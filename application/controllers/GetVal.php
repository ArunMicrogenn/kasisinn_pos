<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class GetVal extends CI_Controller {

    function Item_Group($ID=0)
    {  ?>       
        <option value="0" selected disabled >Select Item Group</option>
        <?php	
            $sql="select * from Itemgroup where Itemcategoryid='".$ID."' and isnull(inactive,0)=0";
            $result=$this->db->query($sql);
            foreach ($result->result_array() as $row)	            
            {
            ?>
             <option value="<?php echo $row['Itemgroupid'] ?>"><?php echo $row['Itemgroup']; ?></option>
            <?php 
            }
    }
    function Items($ID=0)
    {
        $sql="select * from Itemmas_main where Itemgroupid='".$ID."' and isnull(inactive,0)=0";
        $result=$this->db->query($sql);
        foreach ($result->result_array() as $row)	    
        {
        ?>
        <option value="<?php echo $row['Itemid'] ?>"><?php echo $row['Itemname']; ?></option>
        <?php 
        }
    }
    function ItemsDetails($ID=0)
    { ?>
        <table class="table table-striped custom-table table-hover">
                 <thead>
                     <tr>
                      <th>Outlet</th>
                      <th>Copy</th>
                         <th>delete</th>
                      <th>Rate</th>
                      <th>APP Rate</th>
                      <th>Applicable for APP</th>											  
                      <th>Taxsetup</th>                                                        
                      <th>Action</th>
                      </tr>
                    </thead>
                       <tbody> 
                           <?php 													
                           $sql="select * from headings where companyid='".$_SESSION['MPOSCOMPANYID']."'";                
                           $result=$this->db->query($sql);
                           foreach ($result->result_array() as $row)	   
                           {
                               $sql2="select * from itemmas where itemid='".$ID."' and restypeid='".$row['id']."' ";                               
                               $result2=$this->db->query($sql2);
                               $no2= $result2->num_rows();    
                               if($no2 !='0')
                               {
                                foreach ($result2->result_array() as $row2)                                 
                                   {
                                   $rate=$row2['Rate'];
                                   $specialrate=$row2['specialrate'];
                                   $taxsetupid=$row2['taxsetupid'];
                                   $isfa=$row2['isfa'];
                                   }
                                   $selected1='';
                               }
                               else
                               {   $isfa='0';
                                   $rate='';
                                   $specialrate='';
                                   $taxsetupid='';
                                   $selected1='selected';
                               }
                           ?>
                           <tr>
                               <td><a href="#"> <?php echo $row['Name'];?> </a> </td>														
                               <td><button id="c<?php echo $row['id'];  ?>" onclick ="copyrate(<?php echo $row['id'];  ?>,'<?php echo $ID; ?>')" class="btn btn-success btn-xs"> <i class="fa fa-check"></i> </button></td>
                               <td><button id="d<?php echo $row['id'];  ?>" onclick ="deleterate(<?php echo $row['id']  ?>)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o "></i></button></td>
                               <td ><input type="text" id="R<?php echo $row['id'];  ?>" value="<?php echo $rate; ?>" class="form-control" id="inputSuccess" /></td>
                               <td ><input type="text" id="SR<?php echo $row['id'];  ?>" value="<?php echo $specialrate; ?>" class="form-control" /></td>
                               <td><input type="checkbox"  id="APP<?php echo $row['id'];  ?>"  name="APP<?php echo $row['id'];  ?>" <?php if($isfa =='' || $isfa =='0'){ echo ' '; } else { echo "checked";} ?> ></td>
                               <td><select class="form-control" id="S<?php echo $row['id'] ?>" name="S<?php echo $row['id']; ?>" >
                               <?php
                               $sql1="select * from taxsetupmas";                           	
                               $result1=$this->db->query($sql1);                              													
                               ?>
                               <option value="0" <?php echo $selected1; ?> disabled >Select Taxtype</option>
                               <?php 												
                               foreach ($result1->result_array() as $row1)	
                               {	
                               if($row1['Taxsetupid']==$taxsetupid)
                               { $selected='selected'; }	
                               else
                               { $selected=''; }
                               ?>
                               <option <?php echo $selected; ?> value="<?php echo $row1['Taxsetupid']; ?>"><?php echo $row1['taxsetupname']; ?></option>
                               <?php
                               }
                               ?>
                               </select> </td>                                                        
                               <td><span onclick="updateitems('<?php echo $row['id'];?>','<?php echo $ID; ?>')" class="label label-warning label-mini">Update</span></td>                                                       
                           </tr>  
                           <?php
                           }
                           ?>
                       </tbody>
                   </table>
        <?php	
    }
    function CopyRate($ID=0)
    {
        $sql="select * from itemmas_main where Itemid='".$ID."' and isnull(inactive,0)=0";	
        $result=$this->db->query($sql);      
        foreach ($result->result_array() as $row)	
        {	
            $Rate= $row['Rate'];
            $taxsetupid= $row['taxsetupid'];
        } 
        
        echo json_encode($Rate."-".$taxsetupid);
    }
    function UpdateItems()
    {
        if($_GET['rate'] !='0.00' && $_GET['taxid']!='0')
        {
            $sql="select * from itemmas 
            where itemid='".$_GET['itemnameid']."' and restypeid='".$_GET['headid']."'";            
            $result=$this->db->query($sql);                  
            $no= $result->num_rows();    
            if($no=='0')
            {
            $sql1="select itm.Itemname,itm.Itemcode,itm.Itemgroupid,itm.foodtypeid,ig.nccostperc,itm.Itemid from itemmas_main itm
            inner join itemgroup ig on itm.itemgroupid=ig.itemgroupid
            where Itemid='".$_GET['itemnameid']."'";             
            $result1=$this->db->query($sql1);      
            foreach ($result1->result_array() as $row1)	            
            {
                $ins="insert into itemmas (Itemname,Itemcode,Rate,specialrate,isfa,itemgroupid,restypeid,itemid,foodtypeid,nccostperc,companyid,taxsetupid)
                values('".$row1['Itemname']."','".$row1['Itemcode']."','".$_GET['rate']."','".$_GET['SRrate']."','".$_GET['APP']."','".$row1['Itemgroupid']."','".$_GET['headid']."','".$row1['Itemid']."','".$row1['foodtypeid']."','".$row1['nccostperc']."','".$_SESSION['MPOSCOMPANYID']."','".$_GET['taxid']."')";                 
                $result1=$this->db->query($ins);      
            }
            }
            else
            {  $sql1="select itm.Itemname,itm.Itemcode,itm.Itemgroupid,itm.foodtypeid,ig.nccostperc,itm.Itemid from itemmas_main itm
            inner join itemgroup ig on itm.itemgroupid=ig.itemgroupid
            where Itemid='".$_GET['itemnameid']."'";             
            $result1=$this->db->query($sql1);                  
            foreach ($result1->result_array() as $row1)	            
            {
              echo  $Update="update itemmas set Itemname='".$row1['Itemname']."',isfa='".$_GET['APP']."',specialrate='".$_GET['SRrate']."',Itemcode='".$row1['Itemcode']."',Rate='".$_GET['rate']."',itemgroupid='".$row1['Itemgroupid']."',restypeid='".$_GET['headid']."',itemid='".$row1['Itemid']."',foodtypeid='".$row1['foodtypeid']."',nccostperc='".$row1['nccostperc']."',companyid='".$_SESSION['MPOSCOMPANYID']."',taxsetupid='".$_GET['taxid']."' where itemid='".$row1['Itemid']."' and restypeid='".$_GET['headid']."'";                 
                $result1=$this->db->query($Update);  
            }
            }
        }
        else
        {
            $delete="delete itemmas  where itemid='".$_GET['itemnameid']."' and restypeid='".$_GET['headid']."' ";            	
            $result1=$this->db->query($delete);  
        }
    }
}
?>