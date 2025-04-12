<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kotoutlet extends CI_Controller
{
   
    public function index()
    {
        $data=array('F_Class'=>'kotoutlet','F_Ctrl'=>'');
        // $this->load->view('Operations/Bill_Cancellation',$data);
        $this->load->view($data['F_Class'],$data);       
    }
    public function tablelist($ID = -1)
    {
        $data=array('ID' => $ID,'F_Class'=>'tablelist','F_Ctrl'=>'');     
        $this->load->view($data['F_Class'],$data);    
     
    }

    public function cat($tableid = -1, $outletid = -1)
    {
        // echo $ID;

        $data=array('Tableid' => $tableid, 'Outletid' => $outletid,'F_Class'=>'cat');          
        $this->load->view($data['F_Class'],$data);                  
    }

    public function stwlist()
    {
        $datas = $_REQUEST['term'];
        $data = [];
        $select = "SELECT * FROM Employee WHERE Employee like '%" . $datas . "%' and companyid='" . $_SESSION['MPOSCOMPANYID'] . "'";
        $result = $this->db->query($select);
        foreach ($result->result_array() as $row) {
            $data[] = $row['Employee'];
        }
        //return json data
        echo json_encode($data);
    }

    public function itemcode()
    {

        $datas = $_POST['label'];
        $select = "SELECT * FROM itemmas WHERE ItemCode= '" . $datas . "' and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid ='" . $_POST['outletid'] . "'";
        $result = $this->db->query($select);
        $data = [];
        foreach ($result->result_array() as $row) {
            $data[] = $row['Rate'];
            $data[] = $row['taxsetupid'];
            $data[] = $row['itemdetid'];
            $data[] = $row['Itemname'];
        }
        //return json data
        echo json_encode($data);

    }

    public function itemprice()
    {
        $datas = $_POST['label'];
        $select = "SELECT * FROM itemmas WHERE Itemname= '" . $datas . "' and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid ='" . $_POST['outletid'] . "'";
        $result = $this->db->query($select);
        foreach ($result->result_array() as $row) {
            $data[] = $row['Rate'];
            $data[] = $row['ItemCode'];
            $data[] = $row['taxsetupid'];
            $data[] = $row['itemdetid'];
        }
        //return json data
        echo json_encode($data);
    }

    public function getrunningkotdetails()
    {
        $label = $_POST['label'];
        $outletid = $_POST['outletid'];
        $tableid = $_POST['tableid'];
        //return json data 
        $data = '';
        $sql = "select * from Trans_Reskot_mas where Tableid='" . $tableid . "' and isnull(raised,0)=0 and restypeid='" . $outletid . "'";
        $result = $this->db->query($sql);
        foreach ($result->result_array() as $row) {
            //      $data=$data.'<tr>  <th class="center">sdfsdfsd	   </th></tr> ';
            $data = $data . '<tr><th class="center"><button onclick="editkot(this.value,' . $row['Kotid'] . ')" id="kotidtable" value="' . $label . '"   type="button" class="btn btn-round btn-primary">' . $row['Kotno'] . '</button></th></tr>	';
        }

        echo json_encode($data);
    }

    public function itemsearch()
    {
        $datas = $_GET['term'];
       $select = "SELECT * FROM itemmas WHERE Itemname like '%" . $datas . "%' and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid ='" . $_GET['outletid'] . "'";
        $result = $this->db->query($select);
        foreach ($result->result_array() as $row) {
            $data[] = $row['Itemname'];
        }
        //return json data
        echo json_encode($data);
    }

    public function kotsave()
    {
        echo 'test';
        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
            $device = str_replace("Build/", "", $myArray2[0]);
            $device = str_replace(".", "", $device);
        } else {
            $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        }
        //date_default_timezone_set('Asia/Kolkata');	   
        $qry = "SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_POST['outletid'] . "'";
        $result1 = $this->db->query($qry);
        $lastdate = $result1->num_rows();
        if ($lastdate != 0) {
            $date = date("Y-m-d");
            $time = date("H:i:s");
        } else {
            $qrys = "SELECT * FROM Date_change_bar WHERE companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_POST['outletid'] . "'";
            $results1 = $this->db->query($qrys);
            foreach ($results1->result_array() as $rows1) {
                $date = $rows1['Newdate'];
                $time = "11:59:00";
            }
        }
        $Employee = '';
        $sql = "select * from Employee where Employee like '" . $_POST['steward'] . "%'";
        $result = $this->db->query($sql);
        foreach ($result->result_array() as $row) {
            $Employee = $row['Employeeid'];
        }

        $detins = '';
        for ($i = 0; $i < $_POST['rowcount']; $i++) {
            if ($_POST['itemid'][$i]) {
                //	echo $_POST['subprice'][$i];
                if ($i == 0) {
                    $ins = "insert into Trans_reskot_mas (Kotno,Refno,tableid,Stwid,Kotdate,Kottime,totalamount,Raised,cancelornorm,userid,restypeid,noofpax,companyid,fromterminal)
                    
                                values(dbo.KotNo2(" . $_POST['outletid'] . "," . $_SESSION['MPOSCOMPANYID'] . "),'','" . $_POST['tableid'] . "','" . $Employee . "','" . $date . "','" . $time . "','" . $_POST['totalamount'] . "','0','N','" . $_SESSION['MPOSUSERID'] . "','" . $_POST['outletid'] . "','" . $_POST['pax'] . "','" . $_SESSION['MPOSCOMPANYID'] . "','" . $device . "')";
                    //$result = odbc_exec($dbhandle, $ins);
                }
                $detins = $detins . "insert into Trans_reskot_det (kotid,itemid,qty,Rate,Amount,tableid,cANCELORNORM,restypeid,itemname,companyid)
                                values(@Siden,'" . $_POST['itemid'][$i] . "','" . $_POST['itemqty'][$i] . "','" . $_POST['itemprice'][$i] . "','" . $_POST['subprice'][$i] . "','" . $_POST['tableid'] . "','N','" . $_POST['outletid'] . "','" . $_POST['itemname'][$i] . "','" . $_SESSION['MPOSCOMPANYID'] . "')";

                $update = "update Tablemas set Status='K',SID='" . $Employee . "',Noofpax='" . $_POST['pax'] . "' where  Tableid='" . $_POST['tableid'] . "'";
            } else {
                //echo $i; 
            }
        }
        if ($detins <> '') {
            ob_start();
            echo "BEGIN Try ";
            echo "BEGIN Transaction ";
            echo "BEGIN Tran ";
            echo $ins;
            echo "Declare @Siden INT; ";
            echo "set @Siden=@@identity; ";
            echo $detins;
            echo $update;
            echo " If @@error<>0 Rollback Tran else Commit Tran ";
            echo "COMMIT ";
            echo "end try ";
            echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
            echo "END CATCH ";
            $sqc = ob_get_clean();
            $sq = "" . $sqc . "";
            $result = $this->db->query($sq);
            if ($result) {
                echo "success";
            } else {
                echo "failure";
            }
        }
    }

    public function editordeletekot($Lable='',$Kotid=0,$Restypeid=0)
    {
        // $data=array('tableid'=>$tableid, 'outletid'=> $outletid);
        $data=array('F_Class'=>'editordeletekot','F_Ctrl'=>'','Lable'=>$Lable,'Kotid'=>$Kotid,'Restypeid'=>$Restypeid);          
        $this->load->view($data['F_Class'],$data);
        
    }

    public function savekotEdit()
    {

        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
            $device = str_replace("Build/", "", $myArray2[0]);
            $device = str_replace(".", "", $device);
        } else {
            $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        }
        $Employee = '';
        $sql = "select * from Employee where Employee like '" . $_POST['steward'] . "%'";
        $result = $this->db->query($sql);
        foreach ($result->result_array() as $row) {
            $Employee = $row['Employeeid'];
        }

        $detins = '';
        for ($i = 0; $i < $_POST['rowcount']; $i++) {
            if ($_POST['itemid'][$i]) {
                //	echo $_POST['subprice'][$i];
                if ($i == 0) {
                    $ins = "update Trans_reskot_mas set totalamount='" . $_POST['totalamount'] . "' where Kotid='" . $_POST['kotid'] . "'";
                    $ins1 = "update Trans_reskot_det set cANCELORNORM='C',isdelete=1 where Kotid='" . $_POST['kotid'] . "'";
                    //$result = odbc_exec($dbhandle, $ins);
                }
                $detins = $detins . "insert into Trans_reskot_det (kotid,itemid,qty,Rate,Amount,tableid,cANCELORNORM,restypeid,itemname,companyid)
                            values('" . $_POST['kotid'] . "','" . $_POST['itemid'][$i] . "','" . $_POST['itemqty'][$i] . "','" . $_POST['itemprice'][$i] . "','" . $_POST['subprice'][$i] . "','" . $_POST['tableid'] . "','N','" . $_POST['outletid'] . "','" . $_POST['itemname'][$i] . "','" . $_SESSION['MPOSCOMPANYID'] . "')";

                /// $update="update Tablemas set Status='K',SID='".$Employee."',Noofpax='".$_POST['pax']."' where  Tableid='".$_POST['tableid']."'";
            } else {
                //echo $i; 
            }
        }
        if ($detins <> '') {
            ob_start();
            echo "BEGIN Try ";
            echo "BEGIN Transaction ";
            echo "BEGIN Tran ";
            echo $ins1;
            echo $ins;
            echo "Declare @Siden INT; ";
            echo "set @Siden=@@identity; ";
            echo $detins;
            //echo $update;
            echo " If @@error<>0 Rollback Tran else Commit Tran ";
            echo "COMMIT ";
            echo "end try ";
            echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
            echo "END CATCH ";
            $sqc = ob_get_clean();
            $sq = "" . $sqc . "";
            $result = $this->db->query($sq);
            if ($result) {
                echo "success";
            } else {
                echo "failure";
            }

        }
    }

    public function savekotDelete()
    {
        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
            $device = str_replace("Build/", "", $myArray2[0]);
            $device = str_replace(".", "", $device);
        } else {
            $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        }
        $Employee = '';
        $sql = "select * from Employee where Employee like '" . $_POST['steward'] . "%'";
        $result = $this->db->query($sql);
        foreach ($result->result_array() as $row) {
            $Employee = $row['Employeeid'];
        }

        $update = "update Trans_reskot_mas set Raised=1,cancelornorm='C' Where Kotid='" . $_POST['kotid'] . "'";
        $update1 = "update Trans_reskot_det set cANCELORNORM='C',kotdeleteid='" . $_SESSION['MPOSUSERID'] . "' where kotid='" . $_POST['kotid'] . "' and cANCELORNORM='N'";
        $result = $this->db->query($update, $update1);
        if ($result) {
            $sqlq = "select * from Trans_reskot_mas where Tableid=1 and cancelornorm<>'C' and Raised=0";
            $results = $this->db->query($sqlq);
            $no = $results->num_rows();
            if ($no == '0') {
                $up = "update Tablemas set Status='S' where Tableid='" . $_POST['tableid'] . "'";
                $result = $this->db->query($up);
            }
            echo "success";
        } else {
            echo "failure";
        }
    }
    public function getonlinenotification()
    {
         $sql = "select TOP 1 * from online_Trans_reskot_mas where isnull(notificationalertdone,0)=0 and companyid='" . $_POST['label'] . "' order by Kotid ";
        $result = $this->db->query($sql);
        $no = $result->num_rows();
        echo json_encode($no);
        if ($no == 1) {
            $update = "update online_Trans_reskot_mas set notificationalertdone=1 where companyid='" . $_POST['label'] . "'";
            $result = $this->db->query($update);
        }

    }

    public function check($Tableid = -1, $outletid = -1)
    {      
        $data = array('Tableid' => $Tableid, 'outletid' => $outletid,'F_Class'=>'check','F_Ctrl'=>'');
        $this->load->view($data['F_Class'],$data);         
    }

    public function getdiscountdetails()
    {
        $this->load->view('getdiscountdetails');
    }

    public function discountapply()
    {
        $this->load->view('discountapply');
    }
    public function billsaveandsettlement()
    {      
        $qry = "SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_GET['outletid'] . "'";
        $result1 = $this->db->query($qry);
        $lastdate = $result1->num_rows();
        if ($lastdate != 0) {
            $date = date("Y-m-d");
            $time = date("H:i:s");
        } else {
            $qrys = "SELECT * FROM Date_change_bar WHERE companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_GET['outletid'] . "'";
            $results1 = $this->db->query($qrys);
            foreach ($results1->result_array() as $rows1) {
                $date = $rows1['Newdate'];
                $time = "11:59:00";
            }
        }
        

       $sql = "Exec_BillSaveandSettlementpos '".$_GET['tableid']."','".$date."','".$time."','".$_SESSION['MPOSUSERID']."',0" ;
       $result=$this->db->query($sql);
       if($result){?>

       <script>
    
        window.location.href = '<?php echo scs_index?>kotoutlet/tablelist/<?php echo $_GET['outletid']; ?>';
		
       </script>

       <?php
       }else{
        echo "failure";
       }
      

        
    }

    public function billsave()
    {

        $qry = "SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_POST['outletid'] . "'";
        $result1 = $this->db->query($qry);
        $lastdate = $result1->num_rows();
        if ($lastdate != 0) {
            $date = date("Y-m-d");
            $time = date("H:i:s");
        } 
        else 
        {
            $qrys = "SELECT * FROM Date_change_bar WHERE companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_POST['outletid'] . "'";
            $results1 = $this->db->query($qrys);
            foreach ($results1->result_array() as $rows1) {
                $date = $rows1['Newdate'];
                $time = "11:59:00";
            }
        }
        $sessionid = 0;
        $sess = "select sESSID,sESSION,restypeid,convert(varchar,fROMTIME,108) as fromtime,convert(varchar,tOTIME,108) as totime from session where restypeid='".$_POST['outletid']."' and convert(VARCHAR,getdate(),108) between fromtime and totime";
        $sessrs = $this->db->query($sess);
        foreach ($sessrs->result_array() as $row1ss)
        {
        $sessionid = $row1ss['sESSID'];
        }        
        $del = "delete from Temp_resbill where tableid='" . $_POST['tableid'] . "' and  restypeid='" . $_POST['outletid'] . "'";
        $execdel = $this->db->query($del);        
        $cusid = 0;
        if (@$_POST['Mobile']) {
            $sql7 = "select * from CustomerResturant where Mobile='" . $_POST['Mobile'] . "' and companyid='" . $_SESSION['MPOSCOMPANYID'] . "'";
            $sqlexe7 = $this->db->query($sql7);
            $nocus = $sqlexe7->num_rows();
            if ($nocus == 0) {
                $ins2 = "insert into CustomerResturant (Customer,Mobile,email,resttypeid,Companyid)
                values('" . @$_POST['guestname'] . "','" . @$_POST['Mobile'] . "','" . @$_POST['email'] . "','" . $_POST['outletid'] . "','" . $_SESSION['MPOSCOMPANYID'] . "')";
                $sqexe1 = $this->db->query($ins2);
            }
            $sql7 = "select * from CustomerResturant where Mobile='" . $_POST['Mobile'] . "' and companyid='" . $_SESSION['MPOSCOMPANYID'] . "'";
            $sqlexe7 = $this->db->query($sql7);
            foreach ($sqlexe7->result_array() as $row7) {
                $cusid = $row7['Customerid'];
                $Mobile = $row7['Mobile'];
                $Customer = $row7['Customer'];
                $email = $row7['email'];
            }
        }
        $sql ="select mas.kotid,det.itemid,det.qty,det.Rate,det.itemname,det.kotdetid,itm.taxsetupid from Trans_reskot_mas mas
            inner join Trans_reskot_det det on det.kotid=mas.Kotid
            inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
            where mas.Tableid='" . $_POST['tableid'] . "' and ISNULL(mas.cancelornorm,'')<>'C' 
            and isnull(det.cANCELORNORM,'')<>'C'  and isnull(mas.Raised,0)=0 and isnull(mas.restypeid,0)='".$_POST['outletid']."'";
        $result = $this->db->query($sql);
        $itemtotal = 0;
        $Saletax = 0;
        $totldiscamt = 0;
        $insert = '';
        $insert2 = '';
        $Up1='';
        foreach ($result->result_array() as $row) {
            $sql1 = "select * from Temp_discount where tableid='".$_POST['tableid']."' and outletid='".$_POST['outletid']."' and kotdetid='".$row['kotdetid']."'";
            $result1 = $this->db->query($sql1);
            $discamt = 0;
            $discper = 0;
            $disamt = 0;
            foreach ($result1->result_array() as $row1) {
                $discper = $row1['discper'];
                $discamt = $row1['discamt'];
                $disamt = $row1['amt'];
            }

            $amount = ($row['qty'] * $row['Rate']) - $disamt;
            $sql4 = "select * from taxsetupmas mas
                 inner join taxsetupdet det on det.taxsetupid=mas.Taxsetupid
                 where mas.Taxsetupid='" . $row['taxsetupid'] . "'";
            $result4 = $this->db->query($sql4);
            $tax = 0;
            $itemtax = '0';
            foreach ($result4->result_array() as $row4) {
                $tax = ($amount * $row4['percentage']) / 100;
                $itemtax = $itemtax + $tax;
            }
            $damount = $amount + $itemtax;
            $insert = $insert . "insert into Trans_reskotbillraise_det(kotid,billid,itemid,qty,Rate,Amount,restypeid,companyid,taxamount,itemname,discper,discamt)
                     values('" . $row['kotid'] . "',@siden,'" . $row['itemid'] . "','" . $row['qty'] . "','" . $row['Rate'] . "','" . $damount . "','" . $_POST['outletid'] . "','" . $_SESSION['MPOSCOMPANYID'] . "','" . $itemtax . "','" . $row['itemname'] . "','" . $discper . "','" . $disamt . "')";
            $insert2 = $insert2 . "insert into Temp_resbill(tableid,billid,itemid,restypeid,qty,Rate,kotid,amount)
                     values('" . $_POST['tableid'] . "',@siden,'" . $row['itemid'] . "','" . $_POST['outletid'] . "','" . $row['qty'] . "','" . $row['Rate'] . "','" . $row['kotid'] . "','" . $amount . "')";
            $itemtotal = $itemtotal + ($row['qty'] * $row['Rate']);
            $Saletax = $Saletax + $itemtax;
            $totldiscamt = $totldiscamt + $disamt;
            $Up1=$Up1."update Trans_reskot_mas set Raised=1 where kotid='".$row['kotid']."'";
        }
        $grand = $itemtotal + $Saletax - $totldiscamt;
        $grandtotal = round($grand);
        $roundoff = $grandtotal - $grand;
        $roundoff = round($roundoff, 2);
        $insert1 = "insert into Trans_reskotbillraise_mas(Billno,Billdate,Billtime,Refdate,reftime,Refno,tableid,totalamount,itemtotal,totaltaxamount,Salestax,discper,discamount,noofpax,Settled,RoundeOff,CANCEL,CANCELAMT,restypeid,stwid,companyid,userid,customerid,sessionid)
                values(dbo.BillNo(" . $_POST['outletid'] . "," . $_SESSION['MPOSCOMPANYID'] . "),'" . $date . "','" . $time . "',convert(VARCHAR,getdate(),101), convert(VARCHAR,getdate(),108),dbo.BillNo(" . $_POST['outletid'] . "," . $_SESSION['MPOSCOMPANYID'] . "),'" . $_POST['tableid'] . "','" . $grandtotal . "','" . $itemtotal . "','" . $Saletax . "','0','0','" . $totldiscamt . "','" . $_POST['pax'] . "','0','" . $roundoff . "','0','0.00','" . $_POST['outletid'] . "','" . $_POST['stewardid'] . "','" . $_SESSION['MPOSCOMPANYID'] . "','".$_SESSION['MPOSUSERID']."','".$cusid."','".$sessionid."')";
        $up = "update tablemas set Status='B' where restypeid='" . $_POST['outletid'] . "' and Tableid='" . $_POST['tableid'] . "'";
        
        ob_start();
        echo "BEGIN Try ";
        echo "BEGIN Transaction ";
        echo "BEGIN Tran ";
        echo $insert1;
        echo "Declare @Siden INT; ";
        echo "set @Siden=@@identity; ";
        echo $insert;
        echo $insert2;
        echo $up;
        echo $Up1;
        echo " If @@error<>0 Rollback Tran else Commit Tran ";
        echo "COMMIT ";
        echo "end try ";
        echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
        echo "END CATCH ";
        $sqc = ob_get_clean();
        $sq = "" . $sqc . "";
        $sqexe = $this->db->query($sq);
        echo "Redirecting......"; 
        if ($sqexe) {
            ?>
            <script>
                window.location.href = '<?php echo scs_index ?>kotsave_details/BillSave/<?php echo $_POST['outletid']; ?>/<?php echo $_POST['tableid'] ?>/<?php echo $_POST['Mobile'] ?>'; 
            </script>
            <?php
        }


    }


    public function getbankdetails($Paymodeid=0)
    {
        
        if (@$Paymodeid == '2') { ?>
            <option value="0" selected disabled>Select Bank</option>
            <?php
            $sql = "select * from Mas_bank where isnull(isbank,0)<>1 and isnull(isvisible,0)=1 and isnull(isupi,0)<>1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '3' || @$Paymodeid == '5') { ?>
            <option value="0" selected disabled>Select Bank</option>
            <?php
            $sql = "select * from Mas_bank where isnull(isbank,0)=1 and  isnull(isvisible,0)=1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '4') { ?>
            <option value="0" selected disabled>Select Customer</option>
            <?php
            $sql = "select * from CustomerResturant where isnull(resttypeid,0)= '" . $_GET['outletid'] . "' and isnull(Companyid,0)='" . $_SESSION['MPOSCOMPANYID'] . "'";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Customerid'] ?>"><?php echo $row['Customer']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '6') { ?>
            <option value="0" selected disabled>Select UPI</option>
            <?php
            $sql = "select * from Mas_bank where isnull(isupi,0)=1 and isnull(isvisible,0)=1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '7') { ?>
            <option value="0" selected disabled>Select Room</option>
            <?php
            $sql = "select * from room_status r
            inner join mas_room  mr on r.roomid=mr.Room_Id
            where r.Status='Y' and r.billsettle<>1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Roomid'] ?>"><?php echo $row['RoomNo']; ?></option>
                <?php
            }
        }
    }

    public function settlement($Tableid=0,$Outletid=0){
       // $this->load->view('settlement');

       $data=array('Tableid'=>$Tableid,'Outletid'=>$Outletid,'F_Class'=>'Transaction','F_Ctrl'=>'Settlement');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }

  
    public function getbankData($Paymodeid=0)
    {
        
        if (@$Paymodeid == '2') { ?>
            <option value="0" selected disabled>Select Bank</option>
            <?php
            $sql = "select * from Mas_bank where isnull(isbank,0)<>1 and isnull(isvisible,0)=1 and isnull(isupi,0)<>1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '3' || @$Paymodeid == '5') { ?>
            <option value="0" selected disabled>Select Bank</option>
            <?php
            $sql = "select * from Mas_bank where isnull(isbank,0)=1 and  isnull(isvisible,0)=1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '4') { ?>
            <option value="0" selected disabled>Select Customer</option>
            <?php
            $sql = "select * from CustomerResturant where isnull(resttypeid,0)= '" . $_GET['outletid'] . "' and isnull(Companyid,0)='" . $_SESSION['MPOSCOMPANYID'] . "'";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Customerid'] ?>"><?php echo $row['Customer']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '13') { ?>
            <option value="0" selected disabled>Select UPI</option>
            <?php
            $sql = "select * from Mas_bank where isnull(isupi,0)=1 and isnull(isvisible,0)=1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank']; ?></option>
                <?php
            }
        }
        if (@$Paymodeid == '6') { ?>
            <option value="0" selected disabled>Select Room</option>
            <?php
            $sql = "select * from room_status r
            inner join mas_room  mr on r.roomid=mr.Room_Id
            where r.Status='Y' and r.billsettle<>1";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {
                ?>
                <option value="<?php echo $row['Roomid'] ?>"><?php echo $row['RoomNo']; ?></option>
                <?php
            }
        }
    }
   

    }

