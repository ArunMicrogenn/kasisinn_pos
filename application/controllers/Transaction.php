<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Transaction extends CI_Controller {

    public function index()
	{
        $data=array('F_Class'=>'Transaction','F_Ctrl'=>'SingleScreenOperation');        
         $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
    public function Stwlist()
    {
         $datas = $_GET['term'];
        $data=[];
        $select = "SELECT * FROM Employee WHERE Employee like '%".$datas."%' and companyid='".$_SESSION['MPOSCOMPANYID']."'";        
        $result=$this->db->query($select);
        foreach ($result->result_array() as $row)
        {
             $data[] = $row['Employee'];
        }
        //return json data
        echo json_encode($data);
    }
    Public function paxDetails($ID=0)
    {
        $sql="select Top 1 em.Employee,em.Employeeid,mas.noofpax from Trans_Reskot_mas mas
            inner join Employee em on em.Employeeid=mas.Stwid
            where tableid='".$ID."' and isnull(cancelornorm,'')<>'C' Order By mas.Kotid desc";
        $result=$this->db->query($sql);
        foreach ($result->result_array() as $row)
        {
             $data['Employee'] = $row['Employee'];
             $data['Employeeid'] = $row['Employeeid'];
             $data['noofpax'] = $row['noofpax'];
        }
        echo json_encode($data);
    }
    Public function BillDetailsforSettlement($ID=0)
    {
        $sql="select Top 1 em.Employee,em.Employeeid,mas.noofpax,mas.Billno,mas.Billid,totalamount,mas.Billid  from Trans_reskotbillraise_mas mas
            inner join Employee em on em.Employeeid=mas.Stwid
              where tableid='".$ID."' and isnull(Settled,0)=0 and isnull(CANCEL,0)=0";
        $result=$this->db->query($sql);
        foreach ($result->result_array() as $row)
        {
             $data['Employee'] = $row['Employee'];
             $data['Employeeid'] = $row['Employeeid'];
             $data['noofpax'] = $row['noofpax'];
             $data['Billno'] = $row['Billno'];
             $data['Billid'] = $row['Billid'];
             $data['Totalamount'] = $row['totalamount'];
             $data['Billid'] = $row['Billid'];
        }
        echo json_encode($data);
    }
    Public function ItemGroupByItem($ID=0)
    {
      /*$sql="select * from itemmas itm where Itemgroupid='".$ID."' and restypeid=".$_SESSION['MPOSOUTLET'];
      $result=$this->db->query($sql); */
      $data=array('ID'=>$ID);     
      $this->load->view('Transaction/ItemGroupByItem',$data); 
    }
    Public function TempKot($ID=0,$TID=0,$ADD='')
    {         
        
        if($ADD=='Add')
        {
            //echo $TID;
            $sql="select *  from Temp_kot where TableId='".$TID."' and Itemid='$ID'";
            $result=$this->db->query($sql); 
            $no= $result->num_rows();   
            if($no ==0)
            { 
                $ins="Insert Into Temp_kot(Itemid,Tqty,TRat,Tamt,TableId,Uid,ResId,makekot)
                values('".$ID."','1',(select Rate from itemmas  where itemdetid=".$ID."),(select Rate from itemmas  where itemdetid=".$ID."),'".$TID."','".$_SESSION['MPOSUSERID']."',(select restypeid from itemmas  where itemdetid=".$ID."),'1')";
                $this->db->query($ins); 
            }
            else
            {
                foreach ($result->result_array() as $row)
                {
                    $Tqty = $row['Tqty']+1;
                    $Rate=$row['TRat'];
                    $Tamt=$row['TRat'] * $Tqty;
                }
                $ins="Update Temp_kot set Tqty='".$Tqty."',TRat='".$Rate."',Tamt='".$Tamt."' where TableId='".$TID."' and Itemid='$ID'";
                $this->db->query($ins); 

            }
        }
        else if($ADD=='Remove')
        {
            $ins="delete Temp_kot where TableId='".$TID."' and Itemid='$ID'";
            $this->db->query($ins); 
        }
        else 
        {   
            $sql="select *  from Temp_kot where TableId='".$TID."' and Itemid='$ID'";
            $result=$this->db->query($sql);  
            foreach ($result->result_array() as $row)
            {   if($row['Tqty'] =='1')
                {
                    $ins="Update Temp_kot set Tqty='1' where TableId='".$TID."' and Itemid='$ID'";
                    $this->db->query($ins); 
                }
                else
                {
                    $Tqty = $row['Tqty']-1;
                    $Rate=$row['TRat'];
                    $Tamt=$row['TRat'] * $Tqty;
                    $ins="Update Temp_kot set Tqty='".$Tqty."',TRat='".$Rate."',Tamt='".$Tamt."' where TableId='".$TID."' and Itemid='$ID'";
                    $this->db->query($ins); 
                }             
            }
         
        }
        $this->TempKotlist($TID);
    }   
    public function TempKotQty($ID=0,$Qty=0,$Tableid=0,$Kotid=0)
    {
        $sql="update Trans_reskot_det set qty='".$Qty."',Amount=(select Sum(Rate*".$Qty." ) as Amount from Trans_reskot_det where kotdetid=".$ID.") where kotdetid=".$ID;
        $result=$this->db->query($sql); 
        $sql1="update Trans_reskot_mas set totalamount=(select sum(Amount)as Amount from Trans_reskot_det where kotid='".$Kotid."' and isnull(cANCELORNORM,'')='N') where kotid='".$Kotid."'";
        $result=$this->db->query($sql1); 
        $this->TempKotlist($Tableid);
    }
    Public function TempKotlist($ID=0)
    { ?>
        <table class="table table-borderless mb-0" width="100%" style="border-bottom: 1px #a0a0a0 solid !important;font-size: 11px;overflow:auto;background-color:#FFFFFF">	
        <tbody>		
    <?php $sql="select TableId,k.Itemid,Itemname,Tqty,TRat,Tamt,k.KITMSG,k.Splinstruction from Temp_kot k
        Inner join itemmas i on i.itemdetid=k.Itemid
        where TableId='".$ID."' ";
        $result=$this->db->query($sql); 
        $nooftempitems= $result->num_rows();   
        foreach ($result->result_array() as $row)
        {
        ?>	<tr>
            <td width="10%" class="p-0"><a href="#" onclick="remove(this.id,<?php echo $row['TableId']; ?>)" id="<?php echo $row['Itemid']; ?>" style="color: #f50000; margin-top: 5px" ><b><i style="font-size: 15px;" class="material-icons">close</i></b></a></td>
            <td width="40%" class="p-0"><a onclick="Instruction(this.id,<?php echo $row['TableId']; ?>,'<?php echo $row['Itemname']; ?>')" id="<?php echo $row['Itemid']; ?>" href="#"><?php echo $row['Itemname']; ?></a><?php if($row['KITMSG'] || $row['Splinstruction']) { ?> <a href="#"><i style="font-size: 15px;" class="material-icons">remove_red_eye</i></a><?php } ?></td>
            <td width="5%" class="p-0" style="text-align: center"><a onclick="less(this.id,<?php echo $row['TableId']; ?>)" id="<?php echo $row['Itemid']; ?>" style="color: #f50000; margin-top: 5px" href="#"><img style="width:15px; height: 15px" src="<?php echo scs_url ?>assets/img/less2.png"></a></td>
            <td width="5%" class="p-0" align="center"><?php echo $row['Tqty']; ?></td>
            <td width="5%" class="p-0" style="text-align: center"><a onclick="ItemInsert(this.id)" id="<?php echo $row['Itemid']; ?>" style="color: #f50000; margin-top: 5px" href="#"><img style="width: 15px; height: 15px" src="<?php echo scs_url ?>assets/img/add2.png"></a></td>
            <td width="12%" class="p-1" align="right"><?php echo $row['TRat']; ?></td>
            <td width="15%" class="p-0"  align="right"><?php echo $row['Tamt']; ?></td>	
            </tr>
        <?php
        } ?>
        </tbody>
        </table>
        <table class="table table-borderless mb-0" width="100%" style="border-bottom: 1px #a0a0a0 solid !important;font-size: 11px;overflow:auto;background-color:#FFFFFF">	
            <tbody>		
            <?php
            $sql1="select mas.Kotid,mas.Kotno,det.itemname,det.qty,det.Rate,det.Amount,det.kotdetid from Trans_reskot_mas mas 
            inner join Trans_reskot_det det on det.kotid=mas.kotid
            where mas.Tableid='".$ID."' and isnull(mas.cancelornorm,'')<>'C' and isnull(det.cancelornorm,'')<>'C' and isnull(mas.Raised,0)=0";           
            $result1=$this->db->query($sql1); 
            $noofkotitems= $result1->num_rows();  
            foreach ($result1->result_array() as $row1)
            { ?>
                <tr>	
                    <td width="10%"  class="p-0"><a href="#" onclick="KotCancel(this.id,<?php echo $row1['Kotid']; ?>)" id="<?php echo $row1['kotdetid']; ?>" style="color: #f50000;" ><b><i style="font-size: 15px;" class="material-icons">close</i></b></a>
                        <a href="#" onclick="KotEdit(this.id,<?php echo $row1['Kotid']; ?>)" id="<?php echo $row1['kotdetid']; ?>" style="color: #f50000;" ><b><i style="font-size: 15px;" class="material-icons">create</i></b></a></td>	
                    <td width="15%" class="p-0"><?php echo $row1['Kotno'] ?></td>
                    <td width="35%" class="p-0" style="text-align: left"><?php echo $row1['itemname'] ?></td>                    
                    <td width="5%"class="p-0" style="text-align: center"><span id="Qty<?php echo $row1['kotdetid']; ?>"><?php echo round($row1['qty']) ?></span><input id="QtyIn<?php echo $row1['kotdetid']; ?>" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" style="display:none;width:30px;text-align: center;" value="<?php echo round($row1['qty']) ?>"></td>
                    <td width="5%" class="p-0" style="text-align: center"><a onclick="RunningKOTEdit(<?php echo $row1['kotdetid']; ?>,<?php echo $row1['Kotid']; ?>)" id="Add<?php echo $row1['kotdetid']; ?>" style="display:none;color: #f50000;" href="#"><i style="font-size: 15px;" class="material-icons">done</i></a></td>
                    <td width="15%"class="p-0" style="text-align: Right"><?php echo $row1['Rate'] ?></td>
                    <td width="15%" class="p-0" style="text-align: Right"><?php echo $row1['Amount'] ?></td>														
                </tr>                                                 
            <?php
            } ?>
            </tbody>
        </table>
        <input type="hidden" value="<?php echo $nooftempitems ?>" name="nooftempitems" id="nooftempitems" />
        <input type="hidden" value="<?php echo $noofkotitems ?>" name="noofkotitems" id="noofkotitems" />
        <?php
    }
    Public function BillKotlist($ID=0)
    { ?>
        <table class="table table-borderless mb-0" width="100%" style="border-bottom: 1px #a0a0a0 solid !important;font-size: 11px;overflow:auto;background-color:#FFFFFF">	
            <tbody>		
            <?php
            $sql1="select mas.Billid,mas.Billno,det.itemname,det.qty,det.Rate,det.Amount,det.billdetid from Trans_reskotbillraise_mas mas 
            inner join Trans_reskotbillraise_det det on det.Billid=mas.Billid
            where mas.Tableid='".$ID."' and isnull(mas.Settled,0)=0 and isnull(mas.CANCEL,0)=0";
            $result1=$this->db->query($sql1); 
            foreach ($result1->result_array() as $row1)
            { ?>
                <tr>                    
                    <td width="20%" class="p-0"><?php echo $row1['Billno'] ?></td>
                    <td width="40%" class="p-0" style="text-align: left"><?php echo $row1['itemname'] ?></td>                    
                    <td width="10%"class="p-0" style="text-align: center"><span id="Qty<?php echo $row1['billdetid']; ?>"><?php echo round($row1['qty']) ?></span><input id="QtyIn<?php echo $row1['billdetid']; ?>" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" style="display:none;width:30px;text-align: center;" value="<?php echo round($row1['qty']) ?>"></td>                    
                    <td width="15%"class="p-0" style="text-align: Right"><?php echo $row1['Rate'] ?></td>
                    <td width="15%" class="p-0" style="text-align: Right"><?php echo $row1['Amount'] ?></td>														
                </tr>                                                 
            <?php
            } ?>
            </tbody>
        </table>
        <?php
    }
    public function KotItemCancel($ID=0,$KOT=0,$Table=0)
    {
        $sql="update Trans_reskot_det set cANCELORNORM='C',isdelete=1 where kotdetid=".$ID;
        $result=$this->db->query($sql); 
        $sql1="update Trans_reskot_mas set totalamount=(select sum(Amount)as Amount from Trans_reskot_det where kotid='".$KOT."' and isnull(cANCELORNORM,'')='N') where kotid='".$KOT."'";
        $result=$this->db->query($sql1); 
        $this->TempKotlist($Table);
    }
    public function KotCancel($ID=0,$KOT=0,$Table=0)
    {
        $sql="update Trans_reskot_det set cANCELORNORM='C',isdelete=1 where kotdetid=".$ID;
        $result=$this->db->query($sql); 
        $sql1="update Trans_reskot_mas set cancelornorm='C'  where kotid='".$KOT."'";
        $result=$this->db->query($sql1); 
        $this->TempKotlist($Table);
    }
      public function CartSumDetails($Table=0)
    { 
        $sql="exec Get_CartSumDetails $Table";
        $result=$this->db->query($sql); 
        foreach ($result->result_array() as $row)
            {
                $SubTotal=$row['Amount'];
            }
        $discount='0.00'    ;
        $sql3="select sum(det.discper)as discper,sum(det.discamt)as discamt,sum(det.Amount) as Amount,sum(det.qty) as qty,det.itemid,det.itemname,det.Rate,itm.taxsetupid from Trans_reskot_mas mas 
        inner join Trans_reskot_det det on mas.Kotid=det.kotid
        inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
            where mas.Tableid='".$Table."' and isnull(mas.Raised,0)=0 
            and isnull(det.cANCELORNORM,'')<>'C' and isnull(mas.cancelornorm,'')<>'C' group by det.itemid,det.itemname,det.Rate,itm.taxsetupid";        
        $result3=$this->db->query($sql3);  $totaltax=0.00;        
        foreach ($result3->result_array() as $row3)
         {  
             $sql4="select * from taxsetupmas mas
                     inner join taxsetupdet det on det.taxsetupid=mas.Taxsetupid
                     where mas.Taxsetupid='".$row3['taxsetupid']."'";             
             $result4=$this->db->query($sql4); $tax=0; $stotal=0;             
             foreach ($result4->result_array() as $row4)
             {
                $tax=(($row3['Amount']-$row3['discamt'])*$row4['percentage'])/100;
                $stotal=$stotal+$tax;
             }
              $totaltax=$totaltax + $stotal	; 	
              $discount	=$row3['discamt']+$discount;						 
         }
         /* Temp KOT Tax Calucations */
         $sql3=" select sum(T.Tdiscamt)as discamt, sum(T.Tamt) as Amount,sum(T.Tqty) as qty,T.itemid,itm.itemname,T.TRat,itm.taxsetupid  from Temp_kot T
         inner join itemmas itm on itm.itemdetid=T.Itemid and T.ResId=itm.restypeid
         where T.TableId='".$Table."'    group by T.itemid,itm.itemname,T.TRat,itm.taxsetupid";        
        $result3=$this->db->query($sql3);
        foreach ($result3->result_array() as $row3)
         {  
             $sql4="select * from taxsetupmas mas
                     inner join taxsetupdet det on det.taxsetupid=mas.Taxsetupid
                     where mas.Taxsetupid='".$row3['taxsetupid']."'";             
             $result4=$this->db->query($sql4); $tax=0; $stotal=0;             
             foreach ($result4->result_array() as $row4)
             {
                $tax=(($row3['Amount']-$row3['discamt'])*$row4['percentage'])/100;
                $stotal=$stotal+$tax;
             }
              $totaltax=$totaltax + $stotal	; 
              $discount	=$row3['discamt']+$discount;										 
         }
        ?>
        <table class="table table-borderless" id="kottotal"style="background-color:#FFFFFF;color:#989898;font-weight:bold">
        <tbody>
            <tr>
                <td  class="p-0"style="font-size: 11px;color:#989898;font-weight:bold">SubTotal</td>
                <td class="p-0"  width="100"  style="font-size: 11px;color:#989898;font-weight:bold"  align="right"><?php echo $SubTotal; ?></td>
            </tr>
            <tr>
                <td  class="p-0"style="font-size: 11px;color:#989898;font-weight:bold"><a onClick="DiscountPopUp('<?php echo $Table ?>')" style="font-weight: bold;" href="#">Discount</a></td>
                <td class="p-0"  width="100"  style="font-size: 11px;color:#989898;font-weight:bold"  align="right"><?php echo number_format($discount,2); ?></td>
            </tr>
            <tr>
                <td class="p-0" style="font-size: 11px;color:#989898;font-weight:bold">Tax</td>
                <td class="p-0" width="100"  style="font-size: 11px;color:#989898;font-weight:bold"   align="right"><?php echo number_format($totaltax,2); ?></td>
            </tr>
            <tr>
                <td class="p-0" style="font-size: 11px;color:#989898;font-weight:bold">Round Off</td>
                <td class="p-0" width="100"  style="font-size: 11px;color:#989898;font-weight:bold"   align="right"><?php echo number_format(round($totaltax+$SubTotal)-($totaltax+$SubTotal),2) ?></td>
            </tr>
            <tr>
                <td class="p-0" style="font-size: 13px;color:#188ae2 ;font-weight:bold">Nett Amount</td>
                <td class="p-0" width="100" style="font-size: 13px;color:#188ae2 ;font-weight:bold"  align="right"><?php echo number_format(round($totaltax+$SubTotal-$discount),2); ?></td>
            </tr>
            <tr>
                <td  class="p-0"style="font-size: 11px;color:#989898;font-weight:bold"><a onClick="guestNamePopUp('<?php echo $Table ?>')" style="font-weight: bold;" href="#">Guest Details</a></td>
                <td class="p-0"  width="100"  style="font-size: 11px;color:#989898;font-weight:bold"  align="right">0.00</td>
            </tr>
        </tbody>
        </table>
         <?php 
    }
   public function BillSumDetails($Table=0)
    { 
        $sql="Select itemtotal as itemtotal,isnull(discamount,0) as discamount,totaltaxamount as totaltaxamount,totalamount as totalamount from Trans_ResKotBillraise_mas where tableid=$Table and isnull(Settled,0)=0 and isnull(CANCEL,0)<>1";
        $result=$this->db->query($sql); 
        foreach ($result->result_array() as $row)
            {
                $SubTotal=$row['itemtotal'];
                $Discount=$row['discamount'];
                $totaltax=$row['totaltaxamount'];
                $Nett=$row['totalamount'];
            }        ?>
        <table class="table table-borderless" id="kottotal"style="background-color:#FFFFFF;color:#989898;font-weight:bold">
        <tbody>
            <tr>
                <td  class="p-0"style="font-size: 11px;color:#989898;font-weight:bold"  >SubTotal</td>
                <td class="p-0"  width="100"  style="font-size: 11px;color:#989898;font-weight:bold"  align="right"><?php echo $SubTotal; ?></td>
            </tr>
            <tr>
                <td  class="p-0"style="font-size: 11px;color:#989898;font-weight:bold"  ><a onClick="DiscountPopUp('<?php echo $Table ?>')" style="font-weight: bold;" href="#">Discount</a></td>
                <td class="p-0"  width="100"  style="font-size: 11px;color:#989898;font-weight:bold"  align="right"><?php  echo number_format($Discount,2); ?></td>
            </tr>
            <tr>
                <td class="p-0" style="font-size: 11px;color:#989898;font-weight:bold"  >Tax</td>
                <td class="p-0" width="100"  style="font-size: 11px;color:#989898;font-weight:bold"   align="right"><?php echo number_format($totaltax,2); ?></td>
            </tr>
            <tr>
                <td class="p-0" style="font-size: 11px;color:#989898;font-weight:bold"  >Round Off</td>
                <td class="p-0" width="100"  style="font-size: 11px;color:#989898;font-weight:bold"   align="right"><?php echo number_format(round($totaltax+$SubTotal-$Discount)-($totaltax+$SubTotal-$Discount),2) ?></td>
            </tr>
            <tr>
                <td class="p-0" style="font-size: 13px;color:#188ae2 ;font-weight:bold"  >Nett Amount</td>
                <td class="p-0" width="100" style="font-size: 13px;color:#188ae2 ;font-weight:bold"  align="right"><?php echo number_format($Nett,2); ?></td>
            </tr>
        </tbody>
        </table>
         <?php 
    }
    function guestNameDetails()
    { ?>
        <form id="guestNameDetailsForm" >
            <div class="col-md-12  mt-3">                
                <div class="group">												  
                    <input Type="text" value="" class="form-control" required name="popupGuestName" id="popupGuestName" >
                    <label>Guest Name</label>
                </div> 
                <div class="group mt-3">												  
                    <input Type="text" value="" class="form-control"  pattern="^[0-9]*$" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="popupGuestMobile" id="popupGuestMobile" >
                    <label>Guest Mobile</label>
                </div> 
                <div class="group mt-3">												  
                    <input Type="text" value="" class="form-control" required name="popupGuestGST" id="popupGuestGST" >
                    <label>GST Number</label>
                </div>  
                <div class="btn-group mt-3  mb-3" onclick="guestDetailsSave()" role="group" aria-label="Third group" style="width:100%;margin-top:5px !important"> 
                    <a id="Pybutton" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-primary">Save</a>                                                
                </div>   
            </div>
        </form>
    <?php
    }
    function BankDetails()
    {  ?>
        <form id="BankDetails" value="dd">
            <div class="col-md-12  mt-3">                
                <div class="group">												  
                    <select type="text" class="form-control" name="popupbank<?php echo $_REQUEST['PaymodeId'] ?>" id="popupbank<?php echo $_REQUEST['PaymodeId'] ?>" required >	
                     <?php 
                      
                       if($_REQUEST['PaymodeId'] =='6')
                       { $ID='2'; }
                       else if($_REQUEST['PaymodeId'] =='5' || $_REQUEST['PaymodeId'] =='3')
                       { $ID='1';}
                       else
                       {  $ID=0; }
                        $REC=$this->Myclass->GetBank($ID);
                        foreach($REC as $tbls)
                        { ?>
                        <option value='<?php echo $tbls['Bankid']; ?>'><?php echo $tbls['bank']; ?></option>
                        <?php } ?>
                    </select>
                    <label>Bank</label>
                </div>   
                <div class="group mt-3">		
                    <input type="text" class="form-control" name="popupcardNo<?php echo $_REQUEST['PaymodeId'] ?>" id="popupcardNo<?php echo $_REQUEST['PaymodeId'] ?>" pattern="^[0-9]*$" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" >
                    <label>Card No</label>
                </div> 
                <div class="group mt-3 ">		
                    <input type="date" class="form-control" name="popupValidate<?php echo $_REQUEST['PaymodeId'] ?>" id="popupValidate<?php echo $_REQUEST['PaymodeId'] ?>" min="<?php echo date('Y-m-d'); ?>"  required >
                    <label>Validate </label>
                </div>  
                <div class="btn-group mt-3  mb-3" onclick="cardBankdetails('<?php echo $_REQUEST['PaymodeId'] ?>')" role="group" aria-label="Third group" style="width:100%;margin-top:5px !important"> 
                    <a id="Pybutton" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-primary">Save</a>                                                
                </div>               
            </div>
        </form>
        <?php
    }
    function GetDiscountDetails()
    {   $discper=0; $discamount=0;
        $sql="select discper,discamount from username where Userid='".$_SESSION['MPOSUSERID']."'";
        $result=$this->db->query($sql);       
        foreach ($result->result_array() as $row)
        { $discper= $row['discper'];
          $discamount=$row['discamount'];
        }
        ?>
        <div class="box-content">		
        <form id="Discountform" value="dd"> 
             <input type="hidden" value="<?php echo $discamount; ?>" name="Userdiscamount" id="Userdiscamount" />
             <input type="hidden" value="<?php echo $discper; ?>" name="Userdiscper" id="Userdiscper" />
			 <input type="hidden" value="<?php echo $_REQUEST['tableid']; ?>" name="Tableid" id="Tableid" >
			 <input type="hidden" value="<?php echo $_REQUEST['label']; ?>" name="outletid" id="outletid" >
             <?php        
                    $itemid[]=0;        
                    $Kotid[]=0; 
                    $sql1="exec KotResBillItem_dis ".$_REQUEST['tableid'].",".$_REQUEST['label'];				                                         
                    $result1=$this->db->query($sql1);       
                    foreach ($result1->result_array() as $row1)
                    {  if($row1['discountnotapplicable'] !='1')
                        {
                        $itemid[]=$row1['itemid'];
                        $Kotid[]=$row1['kotdetid'];
                        }
                    }
                 
                    $itemids = implode(",", $itemid);
                    $Kotids = implode(",", $Kotid);            ?>
                    <table class="table table-borderless" width="100%">
                        <thead>
                        <tr>
                            <th>#No</th>
                            <th>Category</th>				   
                            <th>Amount</th>				   
                            <th>Disc %</th>
                            <th>Disc Amt</th>		
                        </tr>
                        </thead> 
                        <tbody>
                        <?php 
                        $sql2="select ic.Itemcategoryid,ic.itemcategory from itemmas itm 
                        INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid INNER 
                        JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
                        where itm.itemdetid in  (".$itemids.")   
                        group by ic.Itemcategoryid,ic.itemcategory
                        union 
                        select ic.Itemcategoryid,ic.itemcategory from temp_kot tk
                        inner join itemmas itm  on itm.itemdetid=tk.Itemid  and tk.ResId=itm.restypeid
                             INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid
                             INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
                        where Tableid='".$_REQUEST['tableid']."' group by ic.Itemcategoryid,ic.itemcategory";         
                        $result2=$this->db->query($sql2);   $i=1;     $catamt=0; $catamt1=0;                    
                        foreach ($result2->result_array() as $row2){ 
                            $qry3="select sum(det.Amount)as Amount from Trans_reskot_mas mas
                            Inner join Trans_resKot_det det on det.Kotid=mas.Kotid
                            INNER JOIN itemmas stm on stm.itemdetid=det.itemid and det.restypeid=stm.restypeid
                            INNER JOIN itemgroup ig on ig.Itemgroupid=stm.Itemgroupid 
                            INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid  
                            where mas.Tableid='".$_REQUEST['tableid']."' and isnull(mas.Raised,0)=0 
                            and ISNULL(mas.cancelornorm,'')<>'C' and ic.Itemcategoryid='".$row2['Itemcategoryid']."'
                            and det.kotdetid in (".$Kotids.") and mas.restypeid='".$_REQUEST['label']."'
                            group by ic.Itemcategoryid,ic.itemcategory";				                            
                            $restrr3=$this->db->query($qry3);                             
                            foreach ($restrr3->result_array() as $row3)			
                            {
                            $catamt=$row3['Amount'];
                            }
                            $qry4="select sum(tk.Tamt) as Amount from temp_kot tk
                                    inner join itemmas itm  on itm.itemdetid=tk.Itemid and tk.ResId=itm.restypeid
                                    INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid
                                    INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
                                    where Tableid='".$_REQUEST['tableid']."' and ic.Itemcategoryid='".$row2['Itemcategoryid']."'";
                                $restrr4=$this->db->query($qry4);                             
                                foreach ($restrr4->result_array() as $row4)			
                                    {
                                    $catamt1=$row4['Amount'];
                                    }
                                echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                echo '<td>'.$row2['itemcategory'].'</td>';
                                echo '<td>'.$catamt+$catamt1; ?>
                                     <input  type="hidden"  value="<?php echo $catamt+$catamt1; ?>" name="total" id="total<?php echo $row2['Itemcategoryid'] ?>" class="form-control">
                                      </td>
                                      <td><input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='2' value="0" name="per<?php echo $row2['Itemcategoryid'] ?>" id="per<?php echo $row2['Itemcategoryid'] ?>" onchange="Clearamt('per<?php echo $row2['Itemcategoryid'] ?>');" class="form-control" min="0" max="10"> </td>	
                                      <td><input  type="text" onchange="Clearper(this.id)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="0" name="amt<?php echo $row2['Itemcategoryid'] ?>" id="amt<?php echo $row2['Itemcategoryid'] ?>" class="form-control"></td>
                                <?php	
                                echo '</tr>';
                                $i=$i+1;
                            } ?>                            
                            <tr>
                                <td></td>
                                <td colspan="3"><input type="text" required class="form-control" placeholder="Reason" name="disreason"id="disreason"></td>                                                            
                                <td><input onclick="apply()" class="btn btn-primary  btn-block " type="Submit" name="discountsubmit" id="discountsubmit" value="Apply"></td>
                            </tr>
                        </tbody	
                    </table>
                    <input type="hidden" value="0" name="itemwise" id='itemwise'/>           
            <script>			
			function Clearper(a)
              { 
			    var res = a.split("amt");			 
			    document.getElementById("per"+res[1]).value = 0;
			    var amt= +document.getElementById(a).value;              
			    var total= document.getElementById("total"+res[1]).value;
			    var str = document.getElementById("total"+res[1]).value ;
			    str = str && Math.round(str);
			    total = total && Math.round(total);
                var Userdiscper	=+document.getElementById('Userdiscamount').value;              
				  if(Userdiscper  < amt)
				  {				
                      swal("User credit Level exited !", {
                            icon: "warning",
                            timer: 2000,
                             buttons: false,
                            });
					  document.getElementById("amt"+res[1]).value = 0;  
                      return;                  
				  } 
				  if(total  <= amt)
				  {
                    swal("Discount Amount Greater than Bill Amount !", {
                            icon: "warning",
                            timer: 2000,
                             buttons: false,
                            });
					  document.getElementById("amt"+res[1]).value = 0;
				  } 			  
			  
			  }
			  
			  function Clearamt(a)
              {                 
			    var res = a.split('per');		
                var Userdiscper	=+document.getElementById('Userdiscper').value;
			    document.getElementById("amt"+res[1]).value = 0;
			    var amt=+document.getElementById(a).value; 
			    var total= document.getElementById("total"+res[1]).value;                
			    var str1 = document.getElementById("per"+res[1]).value;		
			    str1 = str1 && Math.round(str1);
			    total = total && Math.round(total);
			 // console.log	(str1,amt,total);
				  if(str1 > Userdiscper)
				  {
                      swal("User credit Level exited !", {
                            icon: "warning",
                            timer: 2000,
                             buttons: false,
                            });
					  document.getElementById("per"+res[1]).value = 0;
				  }
			  }
		</script>
         </form>
        </div>
    <?php 
    }
    function discountapply()
    {
        $sql="select Itemcategoryid from Itemcategory where companyid='".$_SESSION['MPOSCOMPANYID']."'";
        $restr=$this->db->query($sql);                             
        foreach ($restr->result_array() as $row)
        { 
            if(@$_REQUEST['per'.$row['Itemcategoryid']] !='' || @$_REQUEST['amt'.$row['Itemcategoryid']] !='')
            {   $KAmount=0; $TAmount=0;
                $sql1="select sum(det.Amount) as Amount from Trans_reskot_mas mas 
                Inner join Trans_resKot_det det on det.Kotid=mas.Kotid
                INNER JOIN itemmas stm on stm.itemdetid=det.itemid and det.restypeid=stm.restypeid
                INNER JOIN itemgroup ig on ig.Itemgroupid=stm.Itemgroupid 
                INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid  
                where mas.Tableid='".$_REQUEST['Tableid']."' and isnull(mas.Raised,0)=0 and ISNULL(det.cancelornorm,'')<>'C'
                and ISNULL(mas.cancelornorm,'')<>'C' and ic.Itemcategoryid='".$row['Itemcategoryid']."'  and mas.restypeid='".$_REQUEST['outletid']."' ";
                $restr1=$this->db->query($sql1);    
                foreach ($restr1->result_array() as $row1)
                {
                   $KAmount=$row1['Amount'];
                }
                $sql2=" select sum(tk.Tamt)as Amount from temp_kot tk
                     inner join itemmas itm  on itm.itemdetid=tk.Itemid  and tk.ResId=itm.restypeid
                     INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid
                     INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
                    where Tableid='".$_REQUEST['Tableid']."' and ic.Itemcategoryid='".$row['Itemcategoryid']."'";
                $restr2=$this->db->query($sql2);    
                foreach ($restr2->result_array() as $row2)
                {
                    $TAmount=$row2['Amount']; 
                }

                $TotalAmount=$KAmount+$TAmount;
                
                $sql3="select det.Amount,det.kotdetid from Trans_reskot_mas mas 
                Inner join Trans_resKot_det det on det.Kotid=mas.Kotid
                INNER JOIN itemmas stm on stm.itemdetid=det.itemid and det.restypeid=stm.restypeid
                INNER JOIN itemgroup ig on ig.Itemgroupid=stm.Itemgroupid 
                INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid  
                where mas.Tableid='".$_REQUEST['Tableid']."' and isnull(mas.Raised,0)=0 and ISNULL(det.cancelornorm,'')<>'C'
                and ISNULL(mas.cancelornorm,'')<>'C' and ic.Itemcategoryid='".$row['Itemcategoryid']."'  and mas.restypeid='".$_REQUEST['outletid']."' ";
                $restr3=$this->db->query($sql3);    
                foreach ($restr3->result_array() as $row3)
                {
                    $discountamt=0;
                    $per=0;
                    $catid=$row['Itemcategoryid'] ;
		            $disper = $_REQUEST['per'.$catid];
                    $disamount = $_REQUEST['amt'.$catid];
                    $Rate=$row3['Amount'];
                    if($disper != 0)
                    {
                        $per=$disper;
                        $discountamt=$Rate * ($disper / 100);                    
                    }                    
                    if($disamount !=0)
                    {
                    $first=($disamount/$TotalAmount)*100;
                    $per=$first;
                    $disamt= ($first * $Rate)/100;
                        $discountamt=$disamt;                   
                    }
                    $ins="update Trans_reskot_det set discper='".$per."',discamt='".$discountamt."' where kotdetid='".$row3['kotdetid']."'";
                    $restr=$this->db->query($ins);    
                }
                $sql4="select (tk.Tamt)as Amount,tk.Kot_Id from temp_kot tk
                     inner join itemmas itm  on itm.itemdetid=tk.Itemid  and tk.ResId=itm.restypeid
                     INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid
                     INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
                    where Tableid='".$_REQUEST['Tableid']."' and ic.Itemcategoryid='".$row['Itemcategoryid']."'";
                $restr4=$this->db->query($sql4);    
                foreach ($restr4->result_array() as $row4)
                {
                    $discountamt=0;
                    $per=0;
                    $catid=$row['Itemcategoryid'] ;
		            $disper = $_REQUEST['per'.$catid];
                     $disamount = $_REQUEST['amt'.$catid];
                    $Rate=$row4['Amount'];
                    if($disper != 0)
                    {
                        $per=$disper;
                        $discountamt=$Rate * ($disper / 100);                    
                    }                    
                    if($disamount !=0)
                    {
                    $first=($disamount/$TotalAmount)*100;
                    $per=$first;
                    $disamt= ($first * $Rate)/100;
                        $discountamt=$disamt;                   
                    }
                    $ins="update Temp_kot set Tdiscper='".$per."',Tdiscamt='".$discountamt."' where Kot_Id='".$row4['Kot_Id']."'";
                    $restr=$this->db->query($ins); 
                }
            }
        }	
    }
    /* function  SettlementSave()
    {
        for ($i = 1; $i < 10; $i++) 
        {
          if(@$_REQUEST['Py'.$i] !=0)
          {
            $ins="Insert Trans_reskotsettlement(sessionid, Billid,SettleDate,SettleTime,BillAmount,CardNo,Paymentid,BankorPartyId,Cancel,validdate,RESTYPEID,customerid,TENDRED,CHANGE,tipsamount,companyid) 
            values((select sessionid from Trans_reskotbillraise_mas where Billid='".$_REQUEST['Billid']."'),'".$_REQUEST['Billid']."',convert(varchar(25),getdate(),101),convert(varchar(25),getdate(),108),'".$_REQUEST['Py'.$i]."','".$_REQUEST['cardNo'.$i]."','".$i."','".$_REQUEST['Bank'.$i]."','0','".$_REQUEST['cardValidate'.$i]."','".$_SESSION['MPOSOUTLET']."',0,0,0,'".$_REQUEST['TipsAmt']."','".$_SESSION['MPOSCOMPANYID']."' )";
            $restr=$this->db->query($ins); 
            }
        }    
         $up="update Trans_reskotbillraise_mas set Settled=1 where billid='".$_REQUEST['Billid']."'";
         $restr=$this->db->query($up); 
         $Up1="update Tablemas set Status='S' where Tableid in( select Tableid from Trans_reskotbillraise_mas where Billid='".$_REQUEST['Billid']."')";
         $restr=$this->db->query($Up1); 
         echo $_REQUEST['Billid'];
    }*/
	 function SettlementSave()
{
    $error = false; // Variable to track if there's any error
    
    for ($i = 1; $i < 10; $i++) 
    {
        if(@$_REQUEST['Py'.$i] !=0)
        {
            $ins = "INSERT INTO Trans_reskotsettlement(sessionid, Billid, SettleDate, SettleTime, BillAmount, CardNo, Paymentid, BankorPartyId, Cancel, validdate, RESTYPEID, customerid, TENDRED, CHANGE, tipsamount, companyid) 
            VALUES((SELECT sessionid FROM Trans_reskotbillraise_mas WHERE Billid='".$_REQUEST['Billid']."'), '".$_REQUEST['Billid']."', CONVERT(VARCHAR(25), GETDATE(), 101), CONVERT(VARCHAR(25), GETDATE(), 108), '".$_REQUEST['Py'.$i]."', '".$_REQUEST['cardNo'.$i]."', '".$i."', '".$_REQUEST['Bank'.$i]."', '0', '".$_REQUEST['cardValidate'.$i]."', '".$_SESSION['MPOSOUTLET']."', 0, 0, 0, '".$_REQUEST['TipsAmt']."', '".$_SESSION['MPOSCOMPANYID']."')";
            
            $restr = $this->db->query($ins);
            
            if (!$restr) {
                $error = true; // Set error to true if insertion fails
                break; // Break the loop to stop further processing
            }
        }
    }    
    
    if ($error) {
        // If there's an error, display SweetAlert message and redirect to settlement page
        echo "<script>
                swal('Error!', 'Failed to save settlement records.', 'error').then(function() {
                    //window.location.href = 'settlement_page.php'; // Replace 'settlement_page.php' with your actual page URL
                    window.location.href = '<?php echo scs_index ?>Transaction/index';
                });
              </script>";
    } else {
        // If no error, update tables and continue
        $up = "UPDATE Trans_reskotbillraise_mas SET Settled = 1 WHERE billid='".$_REQUEST['Billid']."'";
        $restr = $this->db->query($up);
        
        $Up1 = "UPDATE Tablemas SET Status='S' WHERE Tableid IN (SELECT Tableid FROM Trans_reskotbillraise_mas WHERE Billid='".$_REQUEST['Billid']."')";
        $restr = $this->db->query($Up1);
        
        echo $_REQUEST['Billid'];
    }
}
    function OpenItemUI()
    {   ?>
        <div class="box-content">		
            <form id="openItemForm" >
                <input type="hidden" name="outletid" value="<?php echo $_REQUEST['label']; ?>">
                <input type="hidden" name="Table" value="<?php echo $_REQUEST['Table']; ?>">
                <div class="col-md-12  mt-3">                
                    <div class="group">												  
                        <input Type="text" value="" class="form-control" required name="ItemName" id="ItemName" >
                        <label>Item Name</label>
                    </div> 
                    <div class="group mt-3">	
                        <select class="form-control" required id="itemGroup" name="itemGroup">
                            <option disabled selected >Select Item Group</option>
                            <?php 
                            $sql="select * from itemgroup where companyid='".$_SESSION['MPOSCOMPANYID']."'";
                            $restr=$this->db->query($sql); 
                            foreach ($restr->result_array() as $row)
                            {
                            ?>
                            <option value="<?php echo $row['Itemgroupid']; ?>"><?php echo $row['Itemgroup']; ?></option>
                            <?php } ?>
                        </select>											                        
                        <label>Guest Mobile</label>
                    </div> 
                    <div class="group mt-3">												  
                        <input Type="text" value="" onchange="Clearper(this.id)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control" required name="Amount" id="Amount" >
                        <label>Amount</label>
                    </div>                      
                    <div class="btn-group mt-3  mb-3" role="group" aria-label="Third group" style="width:100%;margin-top:5px !important"> 
                          <input onclick="openItemSave()" class="btn btn-primary  btn-block " type="Submit" name="discountsubmit" id="discountsubmit" value="Apply">
                    </div>   
                </div>
            </form>
        </div>
    <?php
    }
    function openItemFormSave()
    {
        $ItemCode='OP'.rand(10,100);
    
        $ins="exec Exec_OpenItem '".$_REQUEST['ItemName']."','".$ItemCode."','".$_REQUEST['Amount']."','".$_REQUEST['itemGroup']."','".$_REQUEST['outletid']."','".$_SESSION['MPOSCOMPANYID']."','".$_REQUEST['Table']."','".$_SESSION['MPOSUSERID']."'";
        $restr=$this->db->query($ins); 
        echo "Success";          
        
    }
    function SplitbillUI()
    {  ?>
        <table style="width:100%;font-size:11px;" class="table table-striped table-bordered bootstrap-datatable datatable">
	      <thead style="background: #97144d; color: #fff">
				   <th style="width:5%;text-align: center;">BILL SPLIT</th>
		  </thead>
		 </table>
	   <!--label style="font-size:12px;color:#97144d;text-align: center;">Bill Spliting</label--->
	  <div class="box-content" >
	    
	    <div class="col-md-6" >
          
          <fieldset  > 
          <div id="splitsecontload"></div>
		  </fieldset>	
         </div>
		  <div class="col-md-6" >
           <fieldset>
		    <div id="splitedbilllist"></div>
            </fieldset>
		 </div>
		 </div>
<?php
    }
    function splitbilllist()
    { ?>
    
       <form id="split" >
           <input type="hidden" name="Tableid" id="Tableid" value="<?php echo $_REQUEST['Tableid'];?>">
		     <table style="width:100%;font-size:11px;" class="table table-striped table-bordered bootstrap-datatable datatable">
				   <thead style="background: #3c8dbc; color: #fff">
				   <th style="width:5%;text-align: center;">Sno</th>
				   <th style="width:15%;text-align: center;">Kot.No</th>				   
				   <th style="width:20%;text-align: center;">Item Name</th>
				   <th style="width:10%;text-align: center;">Qty</th>
				   <th style="width:10%;text-align: center;">Amount</th>
				   <th style="width:20%;text-align: center;">E.Qty</th>
				   <th style="width:20%;text-align: center;">Group</th>
				   </thead> 
				<tbody>
			   <?php 
			   $i=1;
			   $qry1="select * from Temp_splitbill_mas where isnull(spqty,0)<>0 and Tableid=".$_REQUEST['Tableid'];				
			   $restrr1 = $this->db->query($qry1);	
			   foreach ($restrr1->result_array() as $row1)
				{  
							 			
			    echo '<tr>';
				echo '<td style="width:5%">'.$i.'</td>';
				echo '<td style="width:15%">'.$row1['Kotno'].'</td>'; 
				echo '<td style="width:20%">'.$row1['itemname'].'</td>';
				echo '<td style="width:10%">'.$row1['qty'].'</td>';
				echo '<td style="width:10%">'.$row1['Amount'].'</td>';
				?>
                <input type="hidden" value="<?php echo $row1['qty']; ?>" id="tqt<?php echo $row1['itemid'];?>">
				<td style="width:20%;"><input style="text-align: center;" onchange="Clearqty(this.id)" class="form-control" type="text" name="qt<?php echo $row1['itemid'] ?>" id="qt<?php echo $row1['itemid'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (int)$row1['qty'];?>"></td>
				<td style="width:20%;text-align: center;"><input  type="hidden" name="Group<?php echo $row1['itemid']; ?>" id="Group<?php echo $row1['itemid']; ?>" value="0"><input value="1" type="checkbox" name="Group<?php echo $row1['itemid']; ?>" id="Group<?php echo $row1['itemid']; ?>" ></td>
				<?php
				echo '</tr>'; 
				$i=$i+1;			
			   }
			   echo '<tr>';
			   echo '<td></td>';
			   echo '<td></td>';
			   echo '<td></td>';
			   echo '<td></td>';
			   echo '<td></td>'; ?>
			   <td><input onclick="splitapply()" type="submit" name="<?php echo $row2['itemcategory']; ?>" id="<?php echo $row2['Itemcategoryid']; ?>" value="Apply"></td>
			   <?php
			   echo '<td></td>';
			   echo '</tr>'; 
			 ?>
			</tbody>			
			</table>	
           </form>
    <?php
    }
}
?>