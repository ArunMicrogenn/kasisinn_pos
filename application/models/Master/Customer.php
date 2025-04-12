<?php
class Customer extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Customer_Val()
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
            $sel="select * from CustomerResturant  where Mobile='".$_POST['Mobile']."'  and companyid='".$companyid."' "; 
            $selresult=$this->db->query($sel);
            $no= $selresult->num_rows();  	  
            if($no != '0' )
            {  echo "fdf"; ?>		  
            <script>                
                swal("Duplicate Mobile Number..!", "Please to Change Mobile Number!", "warning") 
                .then(() => {
                    window.location.href = '<?php echo scs_index; ?>Master/CustomerRestaurat'; 
                  });
               
            </script>           
            <?php     
            exit; 
            } 
        }
        $qry="exec Exec_Customerpos '".$_POST['Customer']."','".$_POST['Mobile']."','".$_POST['Email']."','".$companyid."','".$Active."','".$_POST['ID']."','".$_POST['EXEC']."'";      
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
             window.location.href ='<?php echo scs_index; ?>Master/CustomerRestaurat'; 
            })
        </script> 
        <?php 
    }
}
?>