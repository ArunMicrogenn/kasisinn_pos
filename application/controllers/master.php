<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Master extends CI_Controller {

    public function Outlet()
	{
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Outlet_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function Add_Outlet($BUT='SAVE')
	{ 
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Outlet','BUT'=>$BUT);  
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function Edit_Outlet($ID=-1,$BUT='UPDATE')
    {       
       $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Outlet');
       if($ID!=-1)
		{ 
			$REC=$this->Myclass->Outlet($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Itemcategory()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Itemcategory_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
     }
    function Add_Itemcategory($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Itemcategory');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Itemcategory($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function ItemGroup()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'ItemGroup_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_Itemgroup($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Itemgroup');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Itemgroup($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function ItemSubGroup1()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'ItemSubGroup1_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_ItemSubGroup1($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'ItemSubGroup1');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->ItemSubGroup1($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function ItemSubGroup2()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'ItemSubGroup2_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_ItemSubGroup2($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'ItemSubGroup2');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->ItemSubGroup2($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function FoodType()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'FoodType_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_FoodType($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'FoodType');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->FoodType($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Items()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Items_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_Item($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Item');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Items($ID);
			$data=array_merge($data,$REC[0]);
		}
        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function MenuLink()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'MenuLink');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Table()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Table_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
    function Add_Table($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Table');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Tables($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);  
    }
    function Employee()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Employee_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data); 
    }
    function Add_Employee($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Employee');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Employee($ID);
			$data=array_merge($data,$REC[0]);
		}
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data); 
    }
    function CustomerRestaurat()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'CustomerRestaurat_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_Customer($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Customer');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Customers($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Configuration()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Configuration_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
    function Configuration_Edit($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Configuration');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Configuration($ID);
			$data=array_merge($data,$REC[0]);
		}
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    } 
    function SMSTemplates()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'SMSTemplates_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);   
    }  
    function Edit_SMSTemplates($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'SMSTemplates');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->SMSTemplates($ID);
			$data=array_merge($data,$REC[0]);
		}
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);   
    } 
    function Sessions()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Sessions_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);   
    }
    function Add_Session($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Session');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Session($ID);
			$data=array_merge($data,$REC[0]);
		}
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);   
    }
    function Taxtype()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Taxtype_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
    function  Add_Taxtype($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Taxtype');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Taxtype($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
    function TaxSetup()
    {        
        $data=array('F_Class'=>'Master','F_Ctrl'=>'TaxSetup_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);  
    }
	function  Add_TaxSetup($ID=-1,$BUT='SAVE')
    {

       
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'Add_TaxSetup');
        if($ID!=-1)
		{ 
			  $REC=$this->Myclass->TaxSetup($ID);
			  $data=array_merge($data,$REC[0]);
            //   print_r($data);

		}     
        else{
            $REC=$this->Myclass->ClearTaxSetup();
            $data=array_merge($data,$REC[0]);
        }   
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
	public function getTaxtype(){

        $sql = "select * from taxtype where companyid='".$_SESSION['MPOSCOMPANYID']."' AND taxid='".$_REQUEST['id']."' and isnull(inactive,0)<>1 ";
        $res = $this->db->query($sql);
        foreach($res->result_array() as $row){
            $sql1 = "select * from temp__selectedtaxType where taxid='".$_REQUEST['id']."'";
            $res1 = $this->db->query($sql1);
            $no1 = $res1->num_rows();
            if($no1 !=0){
                foreach($res1->result_array() as $row1){
                echo 
                '
                    <div class="form-group row" id="'.$row['taxid'].'">
                    <label class="col-sm-3 col-form-label" for="'.$row['taxtype'].'"> '.$row['taxtype'].' </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control no-border" id="'.$row['taxtype'].'" aria-describedby="tax" onchange="getTempSelected('.$row1['taxid'].',this.value);" ondblclick="getTempSelected('.$row1['taxid'].',this.value);" placeholder="'.$row['taxtype'].'" value="'.$row1['value'].'" data-toggle="tooltip" data-placement="right" title="Double Click" required>
                           
                            </div>
                            <div class="col-sm-1"><span class="btn btn-danger" onclick="deleterow('.$row1['taxid'].')" style="padding:10px; border-radius:5px;">X</span></div>

                    </div>
                ';
                }

            }else{
                echo 
                '
                    <div class="form-group row " id="'.$row['taxid'].'">
                    <label class="col-sm-3 col-form-label" for="'.$row['taxtype'].'"> '.$row['taxtype'].' </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control no-border" id="'.$row['taxtype'].'" aria-describedby="tax" onchange="getTempSelected('.$row['taxid'].',this.value);" ondblclick="getTempSelected('.$row['taxid'].',this.value);" placeholder="'.$row['taxtype'].'" data-toggle="tooltip" data-placement="right" title="Double Click" required>
                        </div>
                        <div class="col-sm-1"><span class="btn btn-danger" onclick="deleterow('.$row['taxid'].')" style="padding:10px; border-radius:5px;">X</span></div>
                    </div>
                ';

                $insert = "insert into temp__selectedtaxtype(taxid,value)values('".$_REQUEST['id']."', '0')";
                $res = $this->db->query($insert);
                }

             
            }
        
    }

    public function getSelectedTaxtype(){
        if($_REQUEST['value'] ==''){
            $value=0;
        }else{
            $value=$_REQUEST['value'];
        }
        $up = "update temp__selectedtaxType set value='".$value."' where taxid='".$_REQUEST['id']."'";
        $res = $this->db->query($up);

        $getId = "select id from temp__selectedtaxType where taxid='".$_REQUEST['id']."'";
        $resq = $this->db->query($getId);
        foreach($resq->result_array() as $ro){
            $tempid= $ro['id'];
        }

        $getdet = "select * from temp__selectedtaxType_det where temptaxid='".$_REQUEST['id']."'";
        $resdet = $this->db->query($getdet);
       $nodet = $resdet->num_rows();
        $nodet;
        if($nodet == 0){
           $sql = "select * from taxtype where companyid='".$_SESSION['MPOSCOMPANYID']."' or companyid=0 and isnull(inactive,0)<>1 ";
            $res = $this->db->query($sql);
            foreach($res->result_array() as $row){
                echo '<div class="form-check">
                    <input class="form-check-input" type="checkbox" onchange="saveFinalTaxtype('.$_REQUEST['id'].','.$row['taxid'].', '.$tempid.', this.checked);" name="finalTaxtype" value="'.$row['taxid'].'" id="'.$row['taxtype'].'">
                    <label class="form-check-label" for="'.$row['taxtype'].'">
                        '.$row['taxtype'].'
                    </label>
                </div>';
            }
        }else{

            $sql1 = "select * from taxtype 
            where companyid='".$_SESSION['MPOSCOMPANYID']."' or companyid=0 and isnull(inactive,0)<>1";
            $res1 = $this->db->query($sql1);
            foreach($res1->result_array() as $ro){
               $sql3 = "select * from temp__selectedtaxtype mas
                inner join  temp__selectedtaxtype_det det on  mas.id=det.tempid 
                where mas.id='".$tempid."' and det.dettaxid='".$ro['taxid']."'";
                $res3 = $this->db->query($sql3);
                 $chk = $res3->num_rows();
                if($chk ==0){
                    echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox"  onchange="saveFinalTaxtype('.$_REQUEST['id'].','.$ro['taxid'].', '.$tempid.', this.checked);" name="finalTaxtype" value="'.$ro['taxid'].'" id="'.$ro['taxtype'].'">
                        <label class="form-check-label" for="'.$ro['taxtype'].'">
                            '.$ro['taxtype'].'
                        </label>
                    </div>';
                }else{
                    echo '<div class="form-check">
                            <input class="form-check-input" type="checkbox"  checked onchange="saveFinalTaxtype('.$_REQUEST['id'].','.$ro['taxid'].', '.$tempid.', this.checked);" name="finalTaxtype" value="'.$ro['taxid'].'" id="'.$ro['taxtype'].'">
                            <label class="form-check-label" for="'.$ro['taxtype'].'">
                                '.$ro['taxtype'].'
                            </label>
                        </div>';
                }
            }

            
        }


        
    }

	 public function saveFinalTaxtype(){

        $check = "select * from temp__selectedtaxtype_det where tempid='".$_REQUEST['tempid']."' and
        dettaxid=  '".$_REQUEST['Lselectedid']."' and temptaxid='".$_REQUEST['Fleveid']."'";
        $res = $this->db->query($check);
        $no = $res->num_rows();
        
        if($no !=0){

            foreach($res->result_array() as $ro){
                $detid = $ro['detid']; 
            }

            if($_REQUEST['checked'] == 0){
                $del = "delete from temp__selectedtaxtype_det where detid='".$detid."' ";
                $this->db->query($del);
            }else{
                $up = "update temp__selectedtaxtype_det set  dettaxid=  '".$_REQUEST['Lselectedid']."' where detid='".$detid."' ";
                $this->db->query($up);
            }
        }else{

            if($_REQUEST['checked'] == 1){
                $ins = "insert into temp__selectedtaxtype_det (tempid,dettaxid,temptaxid)values
                ('".$_REQUEST['tempid']."','".$_REQUEST['Lselectedid']."','".$_REQUEST['Fleveid']."')";
                $this->db->query($ins);
            }
        }
      
    }

    public function deleterow(){
        $sql1 = "delete from temp__selectedtaxType_det where tempid=(select id from temp__selectedtaxType where taxid='".$_REQUEST['id']."')";
        $sql = "delete from temp__selectedtaxType where taxid='".$_REQUEST['id']."'";

        $res= $this->db->query($sql1.$sql);
         echo $_REQUEST['id'];
     
    }
    Public function SplInstructions()
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'SplInstructions_View');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);        
    }
    function Add_SplInstructions($ID=-1,$BUT='SAVE')
    {
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Master','F_Ctrl'=>'SplInstructions');
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->SplInstruction($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);  
    }

} ?>