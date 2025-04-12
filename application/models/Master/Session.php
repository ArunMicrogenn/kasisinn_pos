<?php

class Session extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Session_Val()
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
        $sql="select * from headings where Name='".$_POST['outlet']."'";
        $result=$this->db->query($sql);
        foreach ($result->result_array() as $row)     
        { $outlet=$row['id'];}

        if($_POST['EXEC']=='SAVE')
        {
            $sel="select * from SESSION where restypeid = '".$outlet."' and (fROMTIME  between  '".$_POST['fromtime']."' and '".$_POST['totime']."' or totime between  '".$_POST['fromtime']."' and '".$_POST['totime']."') "; 
            $selresult=$this->db->query($sel);	
            $no= $selresult->num_rows();  
            if($no != '0' )
            {   ?>		  
                <script>                
                    swal("Already Session to have Given time Duration..!", "Please Change the timing!", "warning") 
                    .then(() => {
                        window.location.href = '<?php echo scs_index; ?>Master/Sessions'; 
                    });
                
                </script>           
            <?php     
                exit; 
            } 
        }

        $qry="exec [Exec_Session] '".$_POST['session']."','".$_POST['fromtime']."','".$_POST['totime']."','".$outlet."','".$companyid."','".$_POST['ID']."','".$_POST['EXEC']."'";      
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
             window.location.href ='<?php echo scs_index; ?>Master/Sessions'; 
            })
        </script> 
        <?php 
    }
}