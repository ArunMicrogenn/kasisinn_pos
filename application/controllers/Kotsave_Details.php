<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kotsave_details extends CI_Controller
{
   
    function __construct()
    {
        parent::__construct();
        $this->pcss->css();
        $this->pcss->hjs();
        echo "Redirecting...";
    }
    public function BillSave($Outletid=0,$Tableid=0)
    {
        date_default_timezone_set('Asia/Kolkata'); 
        $sql6 = "select * from taxtype where taxtype='ITEM TOTAL'";
        $result6 = $this->db->query($sql6);
        foreach ($result6->result_array() as $row6) {
            $head = $row6['taxid'];
        }
        echo $sql3 = "select * from Temp_resbill where tableid='".$Tableid."' and restypeid='".$Outletid."'";
        $result3 = $this->db->query($sql3);
        foreach ($result3->result_array() as $row3) {
            $billid = $row3['billid'];
        }
        $sql5 = "select * from Trans_reskotbillraise_det det 
			 inner join itemmas itm on det.itemid=itm.itemdetid and det.restypeid=itm.restypeid
			 where  det.billid='" . $billid . "'";
        $result5 = $this->db->query($sql5);
        foreach ($result5->result_array() as $row5) {
            $amount = $row5['qty'] * $row5['Rate'] - $row5['discamt'];

            $ins = "insert into trans_reskotbilltax_det (refbilldetid,Amount,Percentage,taxtypeid,billid,taxid)
					values('" . $row5['billdetid'] . "','" . $amount . "','0','" . $row5['taxsetupid'] . "','" . $row5['billid'] . "','" . $head . "')";
            $insexe = $this->db->query($ins);
            $sql4 = "select * from taxsetupmas mas
			 inner join taxsetupdet det on det.taxsetupid=mas.Taxsetupid
			 inner join taxtype ty on ty.taxid=det.Accid
			 where mas.Taxsetupid='" . $row5['taxsetupid'] . "'";
            $result4 = $this->db->query($sql4);
            $tax = 0;
            $itemtax = '0';
            foreach ($result4->result_array() as $row4) {
                $select7 = "select * from taxsetupACdet where taxsetupdetid=" . $row4['taxsetupdetid'] . " and selected=1";
                $result7 = $this->db->query($select7);
                foreach ($result7->result_array() as $row7)
                    $toltaxableamt = 0; {
                    $tax = ($amount * $row4['percentage']) / 100;
                    $itemtax = $itemtax + $tax;
                    $ins1 = "insert into trans_reskotbilltax_det(refbilldetid,Amount,Percentage,taxtypeid,billid,taxid)
				values('" . $row5['billdetid'] . "','" . $tax . "','" . $row4['percentage'] . "','" . $row5['taxsetupid'] . "','" . $row5['billid'] . "','" . $row4['taxid'] . "')";
                    $insexe1 = $this->db->query($ins1);
                }
            }
        }

        $sql8 = "select hed.Name,tposbillprintnew,ShortLinkSMS,ShortLinkwhatsapp,com.company from Headings hed
			inner join Company com on hed.companyid=com.companyid
			 where isnull(hed.id,0)='".$Outletid."' and hed.companyid='" . $_SESSION['MPOSCOMPANYID'] . "'";
        $result8 = $this->db->query($sql8);
        foreach ($result8->result_array() as $row8) {
            $tposbillprintnew = $row8['tposbillprintnew'];
            if ($tposbillprintnew == '') {
                $tposbillprintnew = 0;
            }
            $ShortLinkSMS = $row8['ShortLinkSMS'];
            $ShortLinkwhatsapp = $row8['ShortLinkwhatsapp'];
            $company = $row8['company'];
            $OName = $row8['Name'];
        }
        $msgurl = '';
        if ($ShortLinkSMS == 1 || $ShortLinkwhatsapp == 1) {
            $base_url = 'http://localhost/mpos/'; /// Mail Link
            $actual_link = "http://$_SERVER[HTTP_HOST]/mpos/bill_print.php?outletid=".$Outletid."&id=" . $billid;

            $url = urldecode($actual_link);
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $query = "SELECT * FROM Trans_reskotbillraise_mas WHERE bill_url = '" . $url . "' ";
                $result = $this->db->query($query);
                $num_rows = $result->num_rows();
                if ($num_rows > 0) {
                    foreach ($result->result_array() as $row) {
                        $slug = $row['short_code'];
                    }
                } else {
                    $token = substr(md5(uniqid(rand(), true)), 0, 6);
                    $query1 = "SELECT * FROM Trans_reskotbillraise_mas WHERE short_code = '" . $token . "' ";
                    $result1 = $this->db->query($query1);
                    $num_rows1 = $result1->num_rows();
                    if ($num_rows1 > 0) {
                        $short_code = $token = substr(md5(uniqid(rand(), true)), 0, 6);
                    } else {
                        $short_code = $token;
                    }
                    //$short_code = generateUniqueID();
                    $update = "Update Trans_reskotbillraise_mas set bill_url='" . $url . "',short_code='" . $short_code . "' where Billid ='" . $billid . "'";
                    if ($this->db->query($update)) {
                        $slug = $short_code;
                    } else {
                        die("Unknown Error Occured");
                    }
                }

                $msgurl = $base_url . $slug;
            } else {
                die("$url is not a valid URL");
            }
            // if ($ShortLinkSMS == 1) {
            //     if (@$_GET['Mobile']) {
            //         $sql9 = "select [dbo].[GET_MSG]('1','" . $_SESSION['MPOSCOMPANYID'] . "') as msg ";
            //         $result9 = $this->db->query($sql9);
            //         foreach ($result9->result_array() as $row9) {
            //             $msg = $row9['msg'];
            //         }
            //         //SMS Gendration

            //         $msg = str_replace('*name*', $Customer, $msg);
            //         $msg = str_replace('*bamt*', $grandtotal, $msg);
            //         $msg = str_replace('*bdat*', date('d/m/Y'), $msg);
            //         $msg = str_replace('*btim*', date('H:i'), $msg);
            //         $msg = str_replace('*link*', $msgurl, $msg);
            //         $msg = str_replace('*cnam*', $company, $msg);
            //         $msg = str_replace('*onam*', $OName, $msg);

            //         $ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated,companyid)
            // 		values('" . $_GET['Mobile'] . "','" . $msg . "',convert(VARCHAR,getdate(),20),'" . $_SESSION['MPOSCOMPANYID'] . "')";
            //         $execins = $this->db->query($ins);
            //     }
            // }
        } ?>
        <script>
            var tposbillprintnew = <?php echo $tposbillprintnew; ?>;
            if (tposbillprintnew == 1) {
                swal({
                    title: 'Bill Saved Successfully...!',
                    text: 'Redirecting...',
                    icon: 'success',
                    timer: 2000,
                    buttons: false,
                })
                .then(() => {
                    window.open('<?php echo scs_index; ?>Receipts/BillPrint/<?php echo $billid; ?>', '_blank');
                    window.location.href = '<?php echo scs_index ?>kotoutlet/tablelist/<?php echo $Outletid; ?>';
                });
                 /*   .then(() => {  Ravi Changes 21-06-2023

                        var printWindow = window.open('<?php echo scs_index?>kotsave_details/bill_print/<?php echo $Outletid; ?>/<?php echo $billid; ?>');
                        printWindow.print();
                        window.location.href = '<?php echo scs_index ?>kotoutlet/tablelist/<?php echo $Outletid; ?>';
                        //Close window once print is finished
                        printWindow.onafterprint = function () {
                            printWindow.close();
                            window.location.href = '<?php scs_index ?>kotoutlet/tablelist/<?php echo $Outletid; ?>';
                        };
                    }); */
            }
            else {
                swal({
                    title: 'Bill Saved Successfully...!',
                    text: 'Redirecting...',
                    icon: 'success',
                    timer: 2000,
                    buttons: false,
                })
                    .then(() => {
                        window.location.href = '<?php echo scs_index ?>kotoutlet/tablelist/<?php echo $Outletid; ?>';
                    });
            }

        </script>

        <?php

    }


    public function bill_print(){
        $this->load->view('billprint');
    }


    

}