<?php

class Date_End_Process extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Date_End_Process_Val()
	{ 
        
		$query="select * from trans_Reskot_mas where isnull(raised,0)=0 ";
        $result=$this->db->query($query);												
        $pendingkot= $result->num_rows();  	  
            			
             
        $query1="select * from trans_Reskot_mas where isnull(raised,0)=0 ";												
        $result1=$this->db->query($query1);				
        $pendingbills= $result1->num_rows();  	                 
             
        if ($pendingkot !='0' )
        {
        ?>
        <script>
        swal("Please raise the KOTs !","", "warning")
        .then(()=>{   window.location.href ='<?php echo scs_index; ?>Date_end_process'; });	
        </script>				
        <?php					
        exit;
        }
             
        else if ($pendingbills !='0' )
           {
             ?>
             <script>
             swal("Please settle the Pending Bills !","", "warning")
             .then(()=>{ window.location.href ='<?php echo scs_index; ?>Date_end_process'; });	
             </script>
             <?php
             exit;
            }
        else
            {	
                if(@$_SESSION['MPOSCOMPANYID'])
                {
                    $query="select Newdate from date_Change_bar where companyid=".$_SESSION['MPOSCOMPANYID'];												
                }
                else
                {
                    $query="select Newdate from date_Change_bar ";
                }
                $result=$this->db->query($query);	               
                
                foreach ($result->result_array() as $row) 
                {               
                    $accountdate = $row ['Newdate'];
                    $lastaccountdate = $row ['Newdate'];									
                    $accountdate = substr($accountdate ,0,11);
                    ///$accountdate = date($accountdate,"d-m-Y");
                    $accountdatedate = str_replace('/', '-', $accountdate);
                    $accountdate= date('d-m-Y', strtotime($accountdate));
                }
                date_default_timezone_set('Asia/Kolkata'); 
                 if($accountdate == date('d-m-Y'))
                 {
                 ?>
                 <script>
                 swal("Unable to this Process...!","Unable to Create Future Date Accounts.", "warning")
                 .then(()=>{ window.location.href ='<?php echo scs_index; ?>Date_end_process'; });		
                 </script>
                 <?php
                 exit;	
                 }
                 else
                 {
                 $newdate = $lastaccountdate;
                 date_default_timezone_set('Asia/Kolkata'); 
                 $stop_date = date('Y-m-d H:i:s', strtotime($newdate . ' +1 day'));
                 $update = "update date_Change_bar set newdate='$stop_date' where companyid='".$_SESSION['MPOSCOMPANYID']."' ";
                 $result=$this->db->query($update);	                 
                 ?>
                 <script>
                 swal("Day End Process Completed ... !","Accounts Date Updated.", "success")                
                    .then(()=>{ window.location.href ='<?php echo scs_index; ?>Date_end_process'; });	                     
                 </script>
                 <?php
                 exit;
                 }						
             }					
 
    }
}
?>