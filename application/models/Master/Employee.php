<?php
class Employee extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Employee_Val()
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
        if($_POST['steward']=='Steward')
        { $iscapttion=0;}
        else
        { $iscapttion=1; }
        if($_POST['EXEC']=='SAVE')
        {           
            $sel="select * from Employee  where Employee='".$_POST['Employee']."'  and companyid='".$companyid."' "; 
            $selresult=$this->db->query($sel);
            $no= $selresult->num_rows();  	  
            if($no != '0' )
            {  echo "fdf"; ?>		  
            <script>                
                swal("Duplicate Employee Type Name..!", "Please to Change Employee Name!", "warning") 
                .then(() => {
                    window.location.href = '<?php echo scs_index; ?>Master/Employee'; 
                  });
               
            </script>           
            <?php     
            exit; 
            } 
        }
        $qry="exec Exec_Employee '".$_POST['Employee']."','".$iscapttion."','".$companyid."','".$Active."','".$_POST['ID']."','".$_POST['EXEC']."'";      
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
             window.location.href ='<?php echo scs_index; ?>Master/Employee'; 
            })
        </script> 
        <?php 

    }
}
?>