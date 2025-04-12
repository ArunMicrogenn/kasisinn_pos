<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); 
class KotSave extends CI_Controller {

    public function index()
	{
        date_default_timezone_set('Asia/Kolkata'); 
        if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
            $device = str_replace("Build/","",$myArray2[0]); $device = str_replace(".","",$device);
            }
            else
            {
                $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            } 
            //date_default_timezone_set('Asia/Kolkata');	   
            $qry="SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid='".$_SESSION['MPOSCOMPANYID']."' and restypeid='".$_POST['outletid']."'";            
            $result1=$this->db->query($qry);	            
           // foreach ($results1->result_array() as $rows2)
           //  {
                ///$lastdate= $result1->num_rows();  
                ///if($lastdate !=0)
                ///{
                ///    $date=date("Y-m-d");
                    //$date=$rows2['Newdate'];
               //     $time= date("H:i:s");	
               // }
               /// else
               // {  
                    $qrys="SELECT * FROM Date_change_bar WHERE companyid='".$_SESSION['MPOSCOMPANYID']."' and restypeid='".$_POST['outletid']."'";               
                    $results1=$this->db->query($qrys);	               
                    foreach ($results1->result_array() as $rows1)
                    {
                        $date=$rows1['Newdate'];
                        ///$time= "11:59:00";	
                        $time= date("H:i:s");
                    }
                ///}
            //}
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
            $Employee=$_POST['steward'];
         /*   $sql="select * from Employee where Employee like '".$_POST['steward']."%'";                        
            $result=$this->db->query($sql);	                      
            foreach ($result->result_array() as $row)
            { $Employee= $row['Employeeid']; } */
            $detins="";
            $totalamount=0;
            $sql="select * from Temp_kot where TableId='".$_POST['Table_Id']."'";
            $result=$this->db->query($sql);	 
            foreach ($result->result_array() as $row)
            {
                $detins=$detins."insert into Trans_reskot_det (kotid,itemid,qty,Rate,Amount,tableid,cANCELORNORM,restypeid,itemname,companyid)
				values(@Siden,'".$row['Itemid']."','".$row['Tqty']."','".$row['TRat']."','".$row['Tamt']."','".$row['TableId']."','N','".$_POST['outletid']."',(select Itemname from Itemmas where itemdetid='".$row['Itemid']."'),'".$_SESSION['MPOSCOMPANYID']."')";
                $totalamount=$totalamount+$row['Tamt'];
            }
            $ins="insert into Trans_reskot_mas (GUESTNAME,customerid,Kotno,Refno,tableid,Stwid,Kotdate,Kottime,totalamount,Raised,cancelornorm,userid,restypeid,noofpax,companyid,fromterminal)
				values('".$_POST['GuestName']."',".$Customerid.",dbo.KotNo2(".$_POST['outletid'].",".$_SESSION['MPOSCOMPANYID']."),'','".$_POST['Table_Id']."','".$Employee."','".$date."','".$time."','".$totalamount."','0','N','".$_SESSION['MPOSUSERID']."','".$_POST['outletid']."','".$_POST['pax']."','".$_SESSION['MPOSCOMPANYID']."','".$device."')";
            $update="update Tablemas set Status='K',SID='".$Employee."',Noofpax='".$_POST['pax']."' where  Tableid='".$_POST['Table_Id']."'";
            $del="delete Temp_kot where TableId='".$_POST['Table_Id']."'";
            if($detins <> '')
                {
                    ob_start();
                    echo "BEGIN Try ";
                    echo "BEGIN Transaction ";
                    echo "BEGIN Tran ";
                    echo $ins;
                    echo "Declare @Siden INT; ";
                    echo "set @Siden=@@identity; ";
                    echo $detins;
                    echo $update;
                    echo $del;
                    echo " If @@error<>0 Rollback Tran else Commit Tran ";
                    echo "COMMIT ";
                    echo "end try ";
                    echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
                    echo "END CATCH ";
                    $sqc = ob_get_clean();
                    $sq = "".$sqc."";                    
                    $result=$this->db->query($sq);	   	
                    echo "Success";                    
                } 
                else {
                echo "Faild";                    
                }
   
    }

}
?>