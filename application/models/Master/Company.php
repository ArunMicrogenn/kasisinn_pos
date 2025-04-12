<?php
class Company extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Company_Val()
	{
        $hotelcode = rand(1000,9999);
  
        $qry="exec Exec_Companypos '".$_POST['Company']."','".$_POST['address']."','".$_POST['address1']."', '".$_POST['city']."','".$_POST['email']."','".$_POST['mobile']."','".$_POST['gst']."','".$hotelcode."','".$_POST['userName']."','".$_POST['password']."', '".$_POST['ID']."','".$_POST['EXEC']."'";      
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
                    window.location.href = '<?php echo scs_index; ?>/Company'; 
                 })
          </script>
         <?php          
       
    }
}
?>