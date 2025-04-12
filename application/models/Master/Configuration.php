<?php
class Configuration extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function Configuration_Val()
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
        $qry="Update Headings set tposbillprintnew='".@$_POST['tposbillprintnew']."',ShortLinkSMS='".@$_POST['ShortLinkSMS']."',ShortLinkwhatsapp='".@$_POST['ShortLinkwhatsapp']."',Enablepreviousdaykotbilling='".@$_POST['Enablepreviousdaykotbilling']."' where isnull(id,0)='".$_POST['ID']."' and isnull(companyid,0)='".$_SESSION['MPOSCOMPANYID']."'";
        $res=$this->db->query($qry);
         
        ?>            
        <script>
            swal({
            title: 'Configurations Updated Successfully..!',
            text: 'Redirecting...',
            icon: 'success',
            timer: 2000,
            buttons: false,
            })
            .then(() => {
             window.location.href ='<?php echo scs_index; ?>Master/Configuration'; 
            })
        </script> 
        <?php 
    }
}
?>