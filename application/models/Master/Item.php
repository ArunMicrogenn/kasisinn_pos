<?php

class Item extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Item_Val()
	{ 
        if(@$_SESSION['MPOSCOMPANYID']=='')
        {
         $sql="select * from Company where Hotelcode='".$_POST['hotelcode']."'";
         $result=$this->db->query($sql);
         foreach ($result->result_array() as $row)	
         { $companyid=$row['companyid'];}
        }
        else
        {
           $companyid=$_SESSION['MPOSCOMPANYID'];
        }
        if($_POST['Inactive']=='Active')
        { $Active='0'; }
        else
        { $Active='1'; }

        if($_POST['EXEC']=='SAVE')
        {
            $sel="select * from Itemmas_main  where Itemname='".$_POST['item']."' and companyid='".$companyid."' "; 
            $selresult=$this->db->query($sel);	
            $no= $selresult->num_rows();  
            if($no != '0' )
            {   ?>		  
                <script>                
                    swal("Duplicate Item Name..!", "Please to Change Item Name!", "warning") 
                    .then(() => {
                        window.location.href = '<?php echo scs_index; ?>Master/Items'; 
                    });
                
                </script>           
            <?php     
                exit; 
            }

            $sel1="select * from Itemmas_main  where ItemCode='".$_POST['itemcode']."' and companyid='".$companyid."' "; 
            $selresult1=$this->db->query($sel1);	
            $no= $selresult1->num_rows();  
            if($no != '0' )
            {   ?>		  
                <script>                
                    swal("Duplicate Item Code Name..!", "Please to Change Item Code Name!", "warning") 
                    .then(() => {
                        window.location.href = '<?php echo scs_index; ?>Master/Items'; 
                    });
                
                </script>           
            <?php     
                exit; 
            } 
        }
        $qry="exec Exec_Itemmas_Main '".$_POST['item']."','".$_POST['itemcode']."','".$_POST['Rate']."','".$_POST['Itemgroup']."','".$_POST['taxsetup']."','".$_POST['Foodtype']."','".$companyid."','".$_POST['itemsubgroup2']."','".$_POST['itemsubgroup3']."','".$Active."','".$_POST['ID']."','".$_POST['EXEC']."'";      
        $res=$this->db->query($qry);
        $msg=$this->db->error(); 		
         $output = array();	   
          $output['Qry']=$qry;	
          if($msg['message']!="")
          {	    
            $output['Success']=false;
             $output['MSG']=$this->ErrMessage($msg['message']);	           
         
          }
          else
          {
              $res=$res->row();		 	    
              $output['Success']=true;
             $output['MSG']=$res->MGS;
          }   
        ?>            
        <script>
            swal({
            title: '<?php echo  $output['MSG']; ?>',
            text: 'Redirecting...',
            icon: 'success',
            timer: 2000,
            buttons: false,
            })
            .then(() => {
             window.location.href ='<?php echo scs_index; ?>Master/Items'; 
            })
        </script> 
        <?php  
    }
}