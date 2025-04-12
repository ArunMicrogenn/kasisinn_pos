<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); 
class Login extends CI_Controller {
   function __construct()
   {
       parent::__construct();
       $this->pcss->css();
       $this->pcss->hjs();
       echo "Redirecting...";
   }
	public function index()
	{ 
        if($_POST['username'] =='SuperAdmin') 
        {
         $sql1="Select * from username where  Username='".$_POST['username']."' and pass='".$_POST['pass']."'";
         $result1=$this->db->query($sql1);
         $no= $result1->num_rows();    
          if($no==0)
          { ?>
            <script>				
               swal("Invalied Password!", "Please to Enter Correct Password!", "warning")
               .then((result) => {(window.location.href="<?php echo scs_index; ?>")});
            </script>				
            <?php
           //	window.location.href = 'index.php'; 
                         
          }
          else
          { 
               $sql2="Select * from company where  Hotelcode='".$_POST['hotelcode']."'";
               $result2=$this->db->query($sql2);
               $no2= $result2->num_rows();    
               if($no2==0)
               {$companyid ='0'; }
               else
               {  foreach ($result2->result_array() as $row2)
                  {
                     $companyid=$row2['companyid'];
                  }
               }
               foreach ($result1->result_array() as $row)
		         {
                  $Userid = $row['Userid'];
                  $Username = $row['Username'];
                  $Groupid= $row['Groupid'];
               }
               @session_start();
               $_SESSION['MPOSUSERID']= $Userid;
               $_SESSION['MPOSUSERNAME']= $Username;
               $_SESSION['MPOSCOMPANYID']= $companyid;     
               $_SESSION['MPOSGROUPID']= $Groupid;  
               
             //  $this->load->view('dashboard');
               ?>
               <script>				
                 swal({
                     title: 'Login Successfully...!',
                     text: 'Redirecting...',
                     icon: 'success',
                     timer: 2000,
                     buttons: false,
                     })
                  .then((result) => {(window.location.href="<?php echo scs_index; ?>dashboard")});
               </script>				
               <?php
             }
        }
        else
        {
         $sql="Select * from username where  Username='".$_POST['username']."' and pass='".$_POST['pass']."' and companyid=( select companyid from company where Hotelcode='".$_POST['hotelcode']."') and isnull(inactive,0)=0";
         $result=$this->db->query($sql);
         $no= $result->num_rows();    
         if($no==0)
         { 
            ?>
            <script>				
               swal("Invalied User Name", "Please to Enter Correct User Name and Password", "warning")
               .then((result) => {(window.location.href="<?php echo scs_index; ?>")});
            </script>				
            <?php
          //  $this->load->view('welcome_message');              
         }
         else
         {
        $sql1="Select com.companyid,us.Userid,us.Username,us.Groupid from username us 
           inner join company com on us.companyid=com.companyid
           where  us.Username='".$_POST['username']."' and us.pass='".$_POST['pass']."' and com.Hotelcode='".$_POST['hotelcode']."'";             
           $result1=$this->db->query($sql1);
           $no1= $result1->num_rows();    
           if($no1==0)
           {	   ?>
            <script>				
               swal("Invalied Hotelcode!", "Please to Enter Correct Hotelcode Details!", "warning")
               .then((result) => {(window.location.href="<?php echo scs_index; ?>")});
            </script>				
            <?php
          // swal("Invalied Hotelcode!", "Please to Enter Correct Hotelcode Details!", "warning");
               //$this->load->view('welcome_message');              
           }
           else
           {               
               foreach ($result1->result_array() as $row1)
               {  $Userid = $row1['Userid'];
                  $Username = $row1['Username'];
                  $companyid = $row1['companyid'];
                  $Groupid= $row1['Groupid'];
               }
               @session_start();
               $_SESSION['MPOSUSERID']= $Userid;
               $_SESSION['MPOSUSERNAME']= $Username;
               $_SESSION['MPOSCOMPANYID']= $companyid;  
               $_SESSION['MPOSGROUPID']= $Groupid;  
               ?>
              <script>				
                 swal({
                  title: 'Login Successfully...!',
                  text: 'Redirecting...',
                  icon: 'success',
                  timer: 2000,
                  buttons: false,
                  })
                .then((result) => {(window.location.href="<?php echo scs_index; ?>dashboard")});
               </script>		
               <?php
            //  $this->load->view('dashboard');      
                         
           }
             
         }
         
        }
     
    }
    

}