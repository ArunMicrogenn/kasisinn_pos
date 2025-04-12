<?php
class Users extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Users_Val()
	{
        
        $qry="exec New__Users '".$_POST['name']."','".$_POST['groupid']."','".$_POST['password']."', '".$_POST['companyid']."',
        '".$_POST['userid']."','".$_POST['EXEC']."'";      
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
                    window.location.href = '<?php echo scs_index; ?>Users/Users'; 
                 })
          </script>
         <?php          
       
    }
    public function UserGroup_Val()
	{
        
        $qry="exec Exec_UserGroupPOS '".$_POST['name']."', '".$_POST['companyid']."',
        '".$_POST['UserGroup_Id']."','".$_POST['EXEC']."'";      
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
                    window.location.href = '<?php echo scs_index; ?>Users/UsersGroup'; 
                 })
          </script>
         <?php          
       
    }
}
?>