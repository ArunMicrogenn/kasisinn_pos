<?php

class SMSTemplates extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function SMSTemplates_Val()
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

        if($_POST['ID']==1)
        {
            $up="update mas_smsmessagepos set resbillmsg='".$_POST['area']."' where isnull(companyid,0)='".$_SESSION['MPOSCOMPANYID']."'";
            $result=$this->db->query($up);
            ?>
            <script>
            swal({
            title: 'Check SMS to Guest Updated Successfully...!',
            text: 'Redirecting...',
            icon: 'success',
            timer: 2000,
            buttons: false,
            })
            .then(() => {
                window.location.href = '<?php echo scs_index; ?>Master/SMSTemplates'; 
            })
            </script>
            <?php 
        }
        if($_POST['ID']==2)
        {
            $up="update mas_smsmessagepos set appotpmsg='".$_POST['area']."' where isnull(companyid,0)='".$_SESSION['MPOSCOMPANYID']."'";
            $result=$this->db->query($up);
            ?>
            <script>
            swal({
            title: 'APP REGISTRATION OTP SMS Updated Successfully...!',
            text: 'Redirecting...',
            icon: 'success',
            timer: 2000,
            buttons: false,
            })
            .then(() => {
                window.location.href = '<?php echo scs_index; ?>Master/SMSTemplates'; 
            })
            </script>
            <?php 
        }
    }
}?>