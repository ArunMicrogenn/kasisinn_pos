<?php

class Outlet extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Outlet_Val()
	{   
      if(@$_SESSION['MPOSCOMPANYID']=='' || @$_SESSION['MPOSCOMPANYID']=='0')
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
         $sel="select * from headings  where Name='".$_POST['name']."'";                 
         $selresult=$this->db->query($sel);
         $no= $selresult->num_rows();  
         if($no != '0')
         { ?>
             <script>
                swal("Duplicate Outlet Name..!", "Please to Change Outlet Name!", "warning") 
                .then(() => {
                    window.location.href = '<?php echo scs_index; ?>Master/Outlet'; 
                  });		
              </script>
         <?php	  
         } 
      }  
       
         $qry="exec Exec_Outlet '".$_POST['name']."','".$_POST['name1']."','".$_POST['address1']."','".$_POST['address2']."','".$_POST['mobile']."','".$_POST['email']."','".$_POST['city']."','".$_POST['zipcode']."','".$_POST['gst']."','".$_POST['fssai']."','".$companyid."','".$Active."', '".$_POST['ID']."','".$_POST['EXEC']."'";      
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
                    window.location.href = '<?php echo scs_index; ?>Master/Outlet'; 
                  })
           </script>
          <?php         
      
    }
}
?>