<?php

class ItemSubGroup1 extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function ItemSubGroup1_Val()
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

        $sql1="select * from itemgroup where itemgroup='".$_POST['itemgroup']."'";        
        $result1=$this->db->query($sql1);         
        foreach ($result1->result_array() as $row1)         
        { $Itemgroupid=$row1['Itemgroupid'];}

        if($_POST['EXEC']=='SAVE')
        {
            $sel="select * from itemsubgroup2  where Subgroupname2='".$_POST['itemsubgroup']."'  and companyid='".$companyid."'";         
            $selresult=$this->db->query($sel);	
            $no= $selresult->num_rows();  
            if($no != '0' )
            {   ?>		  
                <script>                
                    swal("Duplicate itemsubgroup Name..!", "Please to Change itemsubgroup Name!", "warning") 
                    .then(() => {
                        window.location.href = '<?php echo scs_index; ?>Master/ItemSubGroup1'; 
                    });
                
                </script>           
            <?php     
                exit; 
            } 
        }
        
        $qry="exec [Exec_ItemSubGroup2] '".$_POST['itemsubgroup']."','".$Itemgroupid."','".$companyid."','".$Active."','".$_POST['ID']."','".$_POST['EXEC']."'";      
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
             window.location.href ='<?php echo scs_index; ?>Master/ItemSubGroup1'; 
            })
        </script> 
        <?php 
    }

}
?>