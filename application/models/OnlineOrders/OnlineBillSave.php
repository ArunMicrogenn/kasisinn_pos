<?php

class OnlineBillSave extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function OnlineOrders_Val()
	{             
        $ID=0;    
        $qry="exec Exec_OnlineBillSave '".$_SESSION['MPOSOUTLET']."','".$_SESSION['MPOSCOMPANYID']."','".$_REQUEST['Kotid']."','".$_SESSION['MPOSUSERID']."'";
        $res=$this->db->query($qry);
        $msg=$this->db->error(); 		
         $output = array();	   
          $output['Qry']=$qry;	
          if($msg['message']!="")
          {	    
            $output['Success']=false;
             $output['ID']=$this->ErrMessage($msg['message']);	          
          }
          else
          {
             $res=$res->row();		 	    
             $output['Success']=true;
             $output['ID']=$res->ID;
          }   
        ?>            
        <script>
            swal({
            title: 'Orders Acceopted',
            text: 'Redirecting...',
            icon: 'success',
            timer: 2000,
            buttons: false,
            })
            .then(() => {             
             window.open('<?php echo scs_index; ?>Receipts/BillPrint/<?php echo  $output['ID']; ?>', '_blank');
             window.location.href ='<?php echo scs_index; ?>dashboard'; 
            })
        </script> 
        <?php         
    }
    public function OnlineOrdersCancel_Val()
    {
        $qry="exec Exec_OnlineOrdersCancel '".$_SESSION['MPOSOUTLET']."','".$_SESSION['MPOSCOMPANYID']."','".$_REQUEST['Kotid']."','".$_SESSION['MPOSUSERID']."'";
        $res=$this->db->query($qry);
        ?>
        <script>
        swal({
        title: 'Orders Cancled',
        text: 'Redirecting...',
        icon: 'success',
        timer: 2000,
        buttons: false,
        })
        .then(() => {                      
         window.location.href ='<?php echo scs_index; ?>dashboard'; 
        })
         </script> 
         <?php
    }

}
?>