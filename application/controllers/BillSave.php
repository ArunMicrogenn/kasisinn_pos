<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class BillSave extends CI_Controller {

    public function index()
	{
        date_default_timezone_set('Asia/Kolkata'); 
        $qry="SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid='".$_SESSION['MPOSCOMPANYID']."' and restypeid='".$_POST['outletid']."'";        
        $result1=$this->db->query($qry);         
        $lastdate= $result1->num_rows();  
        if($lastdate !=0)
        {
            $date=date("Y-m-d");
            $time= date("H:i:s");	
        }
        else
        {  $qrys="SELECT * FROM Date_change_bar WHERE companyid='".$_SESSION['MPOSCOMPANYID']."' and restypeid='".$_POST['outletid']."'";           
           $results1=$this->db->query($qrys);            
           foreach ($results1->result_array() as $rows1)
           {
            $date=$rows1['Newdate'];
            $time= "11:59:00";	
           }
        }
        $Customerid=0;
        if($_POST['GuestName'] !='' || $_POST['GuestMobile'] !='')
        {
            $sql="select * from customerresturant where Mobile='".$_POST['GuestMobile']."'";
            $exec=$this->db->query($sql); 
            $noofcus= $exec->num_rows();   
            if($noofcus =='0')
            {
                $ins1="insert into customerresturant (Customer,Mobile,Cityid,Companyid,gstno,restypeid)
                        values('".$_POST['GuestName']."','".$_POST['GuestMobile']."','1','".$_SESSION['MPOSCOMPANYID']."','".$_POST['GuestGst']."','".$_POST['outletid']."')";
                $exec=$this->db->query($ins1);               	  
            }
            $result=$this->db->query($sql); 
            foreach ($result->result_array() as $row)
            { $Customerid= $row['Customerid']; }           
        }
        $sql="exec Exec_BillSave '".$_POST['Table_Id']."','".$date."','".$time."','".$_SESSION['MPOSUSERID']."','".$Customerid."','".$_POST['Settlement']."'";
        $results=$this->db->query($sql);          
        foreach ($results->result_array() as $rows)
        {
           echo $rows['ID'];
        }  
      
    }

}
?>