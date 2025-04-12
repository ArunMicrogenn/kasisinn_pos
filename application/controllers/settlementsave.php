<?php
defined('BASEPATH') or exit('No direct script access allowed');

class settlementsave extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
      
        $this->pcss->hjs();
    }


    public function index()
    {
        date_default_timezone_set('Asia/Kolkata'); 
       $qry = "SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_POST['outletid'] . "'";
        $result1 = $this->db->query($qry);
        $lastdate = $result1->num_rows();
        if ($lastdate != 0) {
           $date = date("Y-m-d");
            $time = date("H:i:s");
        } else {
            $qrys = "SELECT * FROM Date_change_bar WHERE companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and restypeid='" . $_POST['outletid'] . "'";
            $results1 = $this->db->query($qrys);
            foreach($results1->result_array() as $rows1) {
                $date = $rows1['Newdate'];
                $time = "11:59:00";
            }
        }

        $billid = $_POST['billid'];
        for ($i = 0; $i <= $_POST['rowcount']; $i++) {
            if (@$_POST['paymode'][$i]) {
                if ($_POST['paymode'][$i] == '4') {
                    $balanceamt = '0';
                } else {
                    $balanceamt = $_POST['Amount'][$i];
                }
                if ($_POST['paymode'][$i] == '7') {

                 $sql1 =" select * from room_status r
                 inner join trans_roomdet_det d on r.roomgrcid=d.roomgrcid
                 where r.roomid='" . $_POST['bank'][$i] . "'";
                 $res1 = $this->db->query($sql1);
                 foreach($res1->result_array() as $row1){
                    $grcid= $row1['grcid'];
                    $roomgrcid = $row1['roomgrcid'];
                    $tarriftype = $row1['tarrifftypeid'];
                    $roomrent = $row1['roomrent'];
                    $ratetypeid = $row1['ratetypeid'];
                    $roomid = $row1['Roomid'];
                 }
                 $sql = "insert into Trans_credit_entry(creditno,Roomid,grcid,creditdate,creditheadid,Amount,
                  roomgrcid,payid,bankid,crtime,tarrifftype,groupno,otherAmount,outletname,resttypeid)values
                  (dbo.Credit_Entry_No(),'" . $_POST['bank'][$i] . "',
                  '".$grcid."', '".$date."',(select Revenue_Id from mas_revenue where RevenueHead='Food')
                  , '".$_POST['Amount'][$i]."','".$roomgrcid."','0','0', '".$time."','".$tarriftype."',
                  '0','".$_POST['Amount'][$i]."',(select Name from headings where id='".$_POST['outletid']."'),'" . $_POST['outletid'] . "' )";
                  $res= $this->db->query($sql);

                  $ins = "insert into Trans_reskotsettlement(sessionid,Billid,SettleDate,SettleTime,BillAmount,CardNo,Paymentid,BankorPartyId,Cancel,validdate,RESTYPEID,balanceamount,companyid)
                    values((select sessionid from Trans_reskotbillraise_mas where Billid='".$billid."'),'" . $billid . "','" . $date . "','" . $time . "','" . $_POST['Amount'][$i] . "','" . @$_POST['cardno'][$i] . "','" . $_POST['paymode'][$i] . "','" . @$_POST['bank'][$i] . "','0','" . @$_POST['exdate'][$i] . "','" . $_POST['outletid'] . "','" . $balanceamt . "','" . $_SESSION['MPOSCOMPANYID'] . "')";
                    $result = $this->db->query($ins);
                     $up = "update tablemas set Status='S' where tableid=".$_POST['tableid']." and restypeid='" . $_POST['outletid'] . "'";
                    $result1 = $this->db->query($up);
                      $Up1="update Trans_reskotbillraise_mas set Settled=1, roomgrcid='".@$roomgrcid."',
                     grcid='".@$grcid."', roomid='".@$roomid."',roomno=(select roomno from mas_room where room_id='".@$roomid."') where Billid='".$billid."'";
                    $result2 = $this->db->query($Up1);

                }else{
                     $ins = "insert into Trans_reskotsettlement(sessionid,Billid,SettleDate,SettleTime,BillAmount,CardNo,Paymentid,BankorPartyId,Cancel,validdate,RESTYPEID,balanceamount,companyid)
                    values((select sessionid from Trans_reskotbillraise_mas where Billid='".$billid."'),'" . $billid . "','" . $date . "','" . $time . "','" . $_POST['Amount'][$i] . "','" . @$_POST['cardno'][$i] . "','" . $_POST['paymode'][$i] . "','" . @$_POST['bank'][$i] . "','0','" . @$_POST['exdate'][$i] . "','" . $_POST['outletid'] . "','" . $balanceamt . "','" . $_SESSION['MPOSCOMPANYID'] . "')";
                    $result = $this->db->query($ins);
                     $up = "update tablemas set Status='S' where tableid=".$_POST['tableid']." and restypeid='" . $_POST['outletid'] . "'";
                    $result1 = $this->db->query($up);
                      $Up1="update Trans_reskotbillraise_mas set Settled=1 where Billid='".$billid."'";
                    $result2 = $this->db->query($Up1);
                }
               
            }
        }
        echo "Redirecting";
        ?>
        <script>
            swal({
                title: 'Settlement Saved Successfully...!',
                text: 'Redirecting...',
                icon: 'success',
                timer: 2000,
                buttons: false,
            })
                .then(() => {
                 window.location.href = '<?php echo scs_index?>kotoutlet/tablelist/<?php echo $_POST['outletid']; ?>';
                })
        </script>
        <?php
        }

    }

