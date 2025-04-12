<?php
class TaxsetUp extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function TaxsetUp_Val()
	{
        
      $qry="exec New__TaxsetUp '".$_POST['taxsetupname']."','".$_POST['remarks']."',
      '".$_SESSION['MPOSCOMPANYID']."',
      '".$_REQUEST['EXEC']."', 
      '".@$_REQUEST['ID']."'";      
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
               //  timer: 2000,
                 //buttons: true,
                 })
                 .then(() => {
                    window.location.href = '<?php echo scs_index; ?>Master/TaxSetup'; 
                 })
          </script>
         <?php          
       
    }
}
?>