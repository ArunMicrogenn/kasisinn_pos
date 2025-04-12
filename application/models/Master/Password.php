<?php
class Password extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Password_Val()
	{
        
        $qry="exec change_password '".$_POST['newpassword']."','".$_POST['companyid']."','".$_POST['groupid']."', 
        '".$_POST['userid']."','UPDATE'";      
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
                    window.location.href = '<?php echo scs_index; ?>Users/Password'; 
                 })
          </script>
         <?php          
       
    }
}
?>