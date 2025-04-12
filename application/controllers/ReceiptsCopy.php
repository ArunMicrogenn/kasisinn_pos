<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Receipts extends CI_Controller {
 
    Public function BillPrint($ID=0)
    {      
        require_once($_SERVER['DOCUMENT_ROOT'].'/TCPDF-main/tcpdf.php');
        /* $User=$_SESSION['user']; */
                
        $your_width="105";
        $your_height="800";
        $custom_layout = array($your_width, $your_height);
        $pdf = new TCPDF('P', PDF_UNIT, $custom_layout, true, 'UTF-8', false); 
        $pdf->SetPrintHeader(false);
        /* $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "A5", true, 'UTF-8', false); */
        /* $pdf = new TCPDF('P', PDF_UNIT, "A6", true, 'UTF-8', false);  */
        /* $pdf->SetCreator(PDF_CREATOR); */
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        /* $pdf->SetDisplayMode('default','continuous'); */
        // set margins
        /*  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); */ 
         $pdf->SetMargins(5, 0, 5);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5); 
        
        // set display mode
        $pdf->SetDisplayMode($zoom='fullpage', $layout='TwoColumnRight', $mode='UseNone');
        
        // set pdf viewer preferences
        $pdf->setViewerPreferences(array('Duplex' => 'DuplexFlipLongEdge'));
        
        
        $pdf->SetDisplayMode('default','OneColumn');
        $pdf->SetDisplayMode('default','continuous');
        // set auto page breaks
         /*  $pdf->SetAutoPageBreak(false, -25);  */
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set font
        $pdf->AddFont('DejaVuSansCondensed','','DejaVuSansCondensed.ttf',true);
        
        // add a page
        $pdf->AddPage();
        $pdf->Write(0,'', '', 0, 'R', true, 0, false, false, 0);
        /* $pdf->SetFont('DejaVuSans','',12); */
        $pdf->SetFont('dejavusans','',12);
                
        $sql = "SELECT * FROM Headings where id	=(select restypeid from Trans_ResKotBillraise_mas where billid='".$ID."')";  
        $result=$this->db->query($sql); 
        foreach ($result->result_array() as $row)        
        {
            $restname = $row['Name'];
            $addr = $row['address1'];
            $addr2 = $row['address2'];
            $city = $row['city'];
            $pincode = $row['zipcode'];
            $gstin = $row['gstno'];
            $tinno = $row['tinno'];
            $phone = $row['mobileno'];
        }		
        
        //$rest = "<strong>".$row['shopname']."</strong>";
        
        $sqls = "SELECT * FROM Trans_reskotbillraise_mas mas
                inner join Tablemas tbl on tbl.tableid=mas.tableid
                left outer join employee em on em.employeeid=mas.stwid
                left outer join CustomerResturant cus on cus.Customerid=mas.customerid
                WHERE mas.billid = '".$ID."'";          
        $results=$this->db->query($sqls); 
        foreach ($results->result_array() as $rows)        
        {
            $billno = $rows['Billno'];	
            $outid = $rows['restypeid'];
            $Billdate = $rows['Billdate'];
            $discnt = $rows['discamount'];	
            $parchr = $rows['parcelchrges'];
            $table = $rows['Tablename'];
            $dateti = substr($rows['Billtime'], 11, 5); 
            $pax = $rows['noofpax'];
            $stw = $rows['Employee'];
            $Customer=$rows['Customer'];
            $Mobile=$rows['Mobile'];
            $gstno=$rows['gstno'];
            $grandtotal=$rows['totalamount'];
            $RoundeOff=$rows['RoundeOff'];
            $accountdate = substr($Billdate ,0,11);
            $accountdate = str_replace('/', '-', $accountdate);
            $accountdate= date('d-m-Y', strtotime($accountdate));	
            if($rows['Billno']==$rows['Refno'])
            {
              $Orderno="";	
            }
            else
            {
                $Orderno=$rows['Refno'];
            }
        }
        $sql3="select kmas.Kotno from Trans_reskotbillraise_mas mas 
         inner join Trans_reskotbillraise_det det on det.billid=mas.billid 
         inner join Trans_reskot_mas kmas on kmas.kotid= det.kotid where mas.billid='".$ID."'
         Group By kmas.Kotno"; $kot='';                 
        $result3=$this->db->query($sql3); 
        foreach ($result3->result_array() as $row3)  
        {
            $kot=$kot.$row3['Kotno'];
        }
        
        $mst="Thank You ! Visit Again !!";
        
        //$cgst = sprintf("%01.2f",$bill['cgst']);
        //$totalval = $bill['total_amount'];
        //$totaltax = sprintf("%01.2f",round($totalval));
        
        
        $mm="";
        $mm ="<br/>";                             
        $tbl=<<<EOD
            <table style="" > 
            <hr/>             
            <tr>
            <td colspan="2" style="text-align:center;font-size:19px;font-weight:bold">$restname</td>   
          </tr> 
         <tr>
          <td colspan="2" style="text-align:center;font-size:15px;">$addr</td>   
        </tr> 
        <tr>
          <td colspan="2" style="text-align:center;font-size:15px;">$addr2</td>   
        </tr> 
        <tr>
        <td colspan="2" style="text-align:center;font-size:15px;">$city - $pincode</td>   
        </tr> 
        <tr>
        <td colspan="2" style="text-align:center;font-size:15px;">Cell:&nbsp;$phone</td>   
        </tr>          
        EOD;   
        
        if($gstin)
        {
        $tbl.=<<<EOD
        <tr>
        <td colspan="2" style="text-align:center;font-size:15px;">GSTIN :$gstin</td>   
        </tr> 
        EOD;   
        }
        if($tinno)
        {
        $tbl.=<<<EOD
        <tr>
        <td colspan="2" style="text-align:center;font-size:15px;">FSSAI :$tinno</td>   
        </tr> 
        EOD;   
        }
        if($Customer)
        {
        $tbl.=<<<EOD
        <hr/>               
        <tr>
          <td colspan="2">Guest : $Customer</td>   
        </tr>  
        EOD;   
        }
        if($Mobile)
        {
        $tbl.=<<<EOD
        <tr>
            <td colspan="2">Mobile : $Mobile</td>       
        </tr>     
        EOD;
        }
        if($gstno)
        {
        $tbl.=<<<EOD
        <tr>
            <td colspan="2">GSTINN : $gstno</td>       
        </tr>     
        EOD;
        }     
        $tbl.=<<<EOD
            <hr/>          
            <tr>   
                <td><span style="">Bill.No:$billno</span></td>  
                <td><span style="">Table:$table</span></td> 	
            </tr>
            <tr>
                <td><span style="">Date:$accountdate </span> </td>   
                <td><span style="">Time :$dateti</span></td>
            </tr>
            <tr>
                <td><span style="">PAX :$pax</span></td>
                <td><span style="">Stw:$stw</span> </td>	  
            </tr>	
           </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        $mm
        EOD;
        $tbl.=<<<EOD
        <table style="width:100%;" style="padding:5px;" >
        <tr >
        <td style="width:140px;font-size:12px;font-weight:bold;">ITEM NAME</td>
        <td style="width:50px;font-size:12px;font-weight:bold;">QTY</td>
        <td style="width:55px;font-size:12px;font-weight:bold;">RATE</td>
        <td style="width:73px;font-size:12px;font-weight:bold;">AMOUNT</td>
        </tr>
        </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $tbl.=<<<EOD
        <table style="width:100%;" cellpadding="" cellspacing="5">
        EOD;
        /* echo "select distinct kot_no from asrmypos.pos_bldetail_ntd where bill_no='".$_GET['billNo']."' AND outlet='".$outlet."' AND item_name!='Null'"; */
            $slss = "		select det.Rate,itm.Itemname,sum(det.qty)as qty from Trans_reskotbillraise_mas mas
            inner join Trans_reskotbillraise_det det on det.billid=mas.Billid
            inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
            where mas.Billid='".$ID."' Group By det.Rate,itm.Itemname";            
            $result1=$this->db->query($slss); $subtotal=0;;            
            foreach ($result1->result_array() as $row1)  
            {
            $item_name=ucfirst($row1['Itemname']);
            $item_qty=number_format($row1['qty']);
            $item_rate=$row1['Rate'];
            $line_tot=sprintf("%01.2f",$item_qty * $item_rate);
        //$total += $item_qty * $item_rate;
        $tbl.=<<<EOD
        <tr nobr="true">
        <td style="width:140px;">$item_name</td>
        <td style="width:30px;text-align:center;">$item_qty</td>
        <td style="width:60px;text-align:right;">$item_rate</td>
        <td style="width:80x;text-align:right;">$line_tot</td>
        </tr>
        EOD;
        $subtotal=$subtotal+$line_tot;
        }        
        $subtot = sprintf("%01.2f",$subtotal);
        
        $tbl.=<<<EOD
        <hr/>
        <tr>
        <td colspan="2" style="">Sub Total</td>      
        <td colspan="2" style="text-align:right;width:145px;">$subtot</td>    
        </tr>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        if($discnt != '0')
        {
        $tbl.=<<<EOD
        <tr>
        <td colspan="2" style="">Discount</td>     
        <td colspan="2" style="text-align:right;width:145px;">-$discnt</td>       
        </tr>
        EOD;
        }
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $sql2="select sum(Amount) as Amount,almas.taxid,almas.taxtype from trans_reskotbilltax_det Tsdet
         inner join Taxtype almas on Tsdet.taxid = almas.taxid  
         where almas.taxtype<>'ITEM TOTAL' and Tsdet.billid= '".$ID."'
         Group by almas.taxid,almas.taxtype  order by almas.taxid";          
         $result2=$this->db->query($sql2);            
         foreach ($result2->result_array() as $row2)  
         { $head=$row2['taxtype'];
           $taxamt=$row2['Amount'];   
        $tbl.=<<<EOD
        <tr>
        <td colspan="2" style="">$head</td>        
        <td colspan="2" style="text-align:right;width:145px;">$taxamt</td>
        </tr>
        EOD;
         } 
        $tbl.=<<<EOD
        <hr/>
              
        <tr>
        <td colspan="2">Roundoff</td>      
        <td colspan="2" style="text-align:right;width:145px;">$RoundeOff</td>
        </tr>     
        <hr/>
        <tr>
            <td colspan="2">Grand Total</td>        
            <td colspan="2" style="text-align:right;width:145px;">$grandtotal</td>        
        </tr>      
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $tbl.=<<<EOD
        <tr>
        <td colspan="4" style="">KOT.No:$kot</td>
        </tr>
        EOD;
        $tbl.=<<<EOD
        </table>
        <table style="" cellpadding="3" cellspacing="">
        <tr nobr="true">
        <td style="text-align:center;">
        <span style="font-weight:bold;">$mst</span>
        </td>
        </tr>
        </table>
        EOD;
        if($Orderno<>'')
        {
        $tbl.=<<<EOD
        <table style="" cellpadding="3" cellspacing="">
        <tr nobr="true">
        <td style="text-align:center;">
        <span style="font-weight:bold;">Ref.Order.NO: $Orderno</span>
        </td>
        </tr>
        </table>
        EOD;
        }
            
        
        $pdf->writeHTML($tbl, true, false, false, false,'');
        /* $pdf->IncludeJS("print();"); */
        $pdf->Output('outletBillDuplicate.pdf', 'I');
        
        
    }
    Public function SettlementPrint($ID=0)
    {      
        require_once($_SERVER['DOCUMENT_ROOT'].'/TCPDF-main/tcpdf.php');
        /* $User=$_SESSION['user']; */
                
        $your_width="105";
        $your_height="800";
        $custom_layout = array($your_width, $your_height);
        $pdf = new TCPDF('P', PDF_UNIT, $custom_layout, true, 'UTF-8', false); 
        
        /* $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "A5", true, 'UTF-8', false); */
        /* $pdf = new TCPDF('P', PDF_UNIT, "A6", true, 'UTF-8', false);  */
        /* $pdf->SetCreator(PDF_CREATOR); */
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetPrintHeader(false);
        /* $pdf->SetDisplayMode('default','continuous'); */
        // set margins
        /*  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); */ 
         $pdf->SetMargins(5, 0, 5);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5); 
        
        // set display mode
        $pdf->SetDisplayMode($zoom='fullpage', $layout='TwoColumnRight', $mode='UseNone');
        
        // set pdf viewer preferences
        $pdf->setViewerPreferences(array('Duplex' => 'DuplexFlipLongEdge'));
        
        
        $pdf->SetDisplayMode('default','OneColumn');
        $pdf->SetDisplayMode('default','continuous');
        // set auto page breaks
         /*  $pdf->SetAutoPageBreak(false, -25);  */
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set font
        $pdf->AddFont('DejaVuSansCondensed','','DejaVuSansCondensed.ttf',true);
        
        // add a page
        $pdf->AddPage();
        $pdf->Write(0,'', '', 0, 'R', true, 0, false, false, 0);
        /* $pdf->SetFont('DejaVuSans','',12); */
        $pdf->SetFont('dejavusans','',12);
                
        $sql = "SELECT * FROM Headings where id	=(select restypeid from Trans_ResKotBillraise_mas where billid='".$ID."')";  
        $result=$this->db->query($sql); 
        foreach ($result->result_array() as $row)        
        {
            $restname = $row['Name'];
            $addr = $row['address1'];
            $addr2 = $row['address2'];
            $city = $row['city'];
            $pincode = $row['zipcode'];
            $gstin = $row['gstno'];
            $tinno = $row['tinno'];
            $phone = $row['mobileno'];
        }		
        
        //$rest = "<strong>".$row['shopname']."</strong>";
        
        $sqls = "SELECT * FROM Trans_reskotbillraise_mas mas
                inner join Tablemas tbl on tbl.tableid=mas.tableid
                left outer join employee em on em.employeeid=mas.stwid
                WHERE mas.billid = '".$ID."'";          
        $results=$this->db->query($sqls); 
        foreach ($results->result_array() as $rows)        
        {
            $billno = $rows['Billno'];	
            $outid = $rows['restypeid'];
            $Billdate = $rows['Billdate'];
            $discnt = $rows['discamount'];	
            $parchr = $rows['parcelchrges'];
            $table = $rows['Tablename'];
            $dateti = substr($rows['Billtime'], 11, 5); 
            $pax = $rows['noofpax'];
            $stw = $rows['Employee'];
            $grandtotal=$rows['totalamount'];
            $RoundeOff=$rows['RoundeOff'];
            $accountdate = substr($Billdate ,0,11);
            $accountdate = str_replace('/', '-', $accountdate);
            $accountdate= date('d-m-Y', strtotime($accountdate));	
            if($rows['Billno']==$rows['Refno'])
            {
              $Orderno="";	
            }
            else
            {
                $Orderno=$rows['Refno'];
            }
        }
        $sql3="select kmas.Kotno from Trans_reskotbillraise_mas mas 
         inner join Trans_reskotbillraise_det det on det.billid=mas.billid 
         inner join Trans_reskot_mas kmas on kmas.kotid= det.kotid where mas.billid='".$ID."'
         Group By kmas.Kotno"; $kot='';                 
        $result3=$this->db->query($sql3); 
        foreach ($result3->result_array() as $row3)  
        {
            $kot=$kot.$row3['Kotno'];
        }
        
        $mst="Thank You ! Visit Again !!";
        
        //$cgst = sprintf("%01.2f",$bill['cgst']);
        //$totalval = $bill['total_amount'];
        //$totaltax = sprintf("%01.2f",round($totalval));
        
        
        $mm="";
        $mm ="<br/>";
        
        $tbl = <<<EOD
        EOD;
        
        $tbl.=<<<EOD
            <table style="width:100%;" cellpadding="" cellspacing="5">
            <tr nobr="true">
                <td style="text-align:center;">
                <span style="font-size:19px;font-weight:bold;">$restname</span>$mm
                <span style="font-size:15px;">$addr</span>$mm
                <span style="font-size:15px;">$city - $pincode</span>$mm
                <span style="font-size:15px;">Cell:&nbsp;$phone</span>$mm
                <span style="font-size:15px;">Settlement Receipt</span>$mm
        EOD;
             if($gstin)
             {
        $tbl.=<<<EOD
                <span style="font-size:15px;">GSTIN :$gstin</span>$mm
        EOD;
             }
             if($tinno)
             {
        $tbl.=<<<EOD
                <span style="font-size:15px;">FSSAI :$tinno</span>$mm
        EOD;
             }
        $tbl.=<<<EOD
                 </td>
            </tr>
            </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $tbl.=<<<EOD
           <table style="width:100%;">
            <tr nobr="true">   
            <td><span style="text-align:left">Bill.No:$billno</span></td>  
            <td><span style="text-align:right">Table:$table</span></td> 	
            </tr>
            <tr nobr="true">
            <td><span style="text-align:left">Date:$accountdate </span> </td>   
            <td><span style="text-align:right">Time :$dateti</span></td>
            </tr>
            <tr nobr="true">
             <td><span style="text-align:left">PAX :$pax</span></td>
              <td><span style="text-align:right">Stw:$stw</span> </td>	  
            </tr>	
           </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        $mm
        EOD;
        $tbl.=<<<EOD
        <table style="width:100%;" style="padding:5px;" >
        <tr >
        <td style="width:140px;font-size:12px;font-weight:bold;">ITEM NAME</td>
        <td style="width:50px;font-size:12px;font-weight:bold;">QTY</td>
        <td style="width:55px;font-size:12px;font-weight:bold;">RATE</td>
        <td style="width:73px;font-size:12px;font-weight:bold;">AMOUNT</td>
        </tr>
        </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $tbl.=<<<EOD
        <table style="width:100%;" cellpadding="" cellspacing="5">
        EOD;
        /* echo "select distinct kot_no from asrmypos.pos_bldetail_ntd where bill_no='".$_GET['billNo']."' AND outlet='".$outlet."' AND item_name!='Null'"; */
            $slss = "		select det.Rate,itm.Itemname,sum(det.qty)as qty from Trans_reskotbillraise_mas mas
            inner join Trans_reskotbillraise_det det on det.billid=mas.Billid
            inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
            where mas.Billid='".$ID."' Group By det.Rate,itm.Itemname";            
            $result1=$this->db->query($slss); $subtotal=0;;            
            foreach ($result1->result_array() as $row1)  
            {
            $item_name=ucfirst($row1['Itemname']);
            $item_qty=number_format($row1['qty']);
            $item_rate=$row1['Rate'];
            $line_tot=sprintf("%01.2f",$item_qty * $item_rate);
        //$total += $item_qty * $item_rate;
        $tbl.=<<<EOD
        <tr nobr="true">
        <td style="width:140px;">$item_name</td>
        <td style="width:30px;text-align:center;">$item_qty</td>
        <td style="width:60px;text-align:right;">$item_rate</td>
        <td style="width:80x;text-align:right;">$line_tot</td>
        </tr>
        EOD;
        $subtotal=$subtotal+$line_tot;
        }
        
        $subtot = sprintf("%01.2f",$subtotal);
        $tbl.=<<<EOD
        <hr/>
        EOD;
        
        $tbl.=<<<EOD
        <tr>
        <td style="">Sub Total</td>
        <td></td>
        <td style="text-align:right;width:130px;">$subtot</td>
        <td style=""></td>
        </tr>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        if($discnt != '0')
        {
        $tbl.=<<<EOD
        <tr>
        <td style="">Discount</td>
        <td></td>
        <td style="text-align:right;width:130px;">-$discnt</td>
        <td style=""></td>
        </tr>
        EOD;
        }
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $sql2="select sum(Amount) as Amount,almas.taxid,almas.taxtype from trans_reskotbilltax_det Tsdet
         inner join Taxtype almas on Tsdet.taxid = almas.taxid  
         where almas.taxtype<>'ITEM TOTAL' and Tsdet.billid= '".$ID."'
         Group by almas.taxid,almas.taxtype  order by almas.taxid";          
         $result2=$this->db->query($sql2);            
         foreach ($result2->result_array() as $row2)  
         { $head=$row2['taxtype'];
           $taxamt=$row2['Amount'];   
        $tbl.=<<<EOD
        <tr>
        <td style="">$head</td>
        <td></td>
        <td style="text-align:right;width:130px;">$taxamt</td>
        <td style=""></td>
        </tr>
        EOD;
         } 
        $tbl.=<<<EOD
        <hr/>
        EOD;
        
        $tbl.=<<<EOD
        <table style="width:100%;padding:5px;">
        <tr>
        <td style="text-align:left;width:100px;">Roundoff</td>
        <td></td>
        <td style="text-align:right;width:155px;">$RoundeOff</td>
        <td></td>
        </tr>
        </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $tbl.=<<<EOD
        <table style="width:100%;padding:5px;">
        <tr>
        <td style="text-align:left;width:100px;">Grand Total</td>
        <td></td>
        <td style="text-align:right;width:155px;">$grandtotal</td>
        <td></td>
        </tr>
        </table>
        EOD;
        $tbl.=<<<EOD
        <hr/>
        EOD;
        $tbl.=<<<EOD
        <tr>
        <td colspan="4" style="">KOT.No:$kot</td>
        </tr>
        EOD;
        $sql4="select * from Trans_reskotsettlement mas
        inner join Paymodepos pm on pm.Payid=mas.Paymentid where Billid='$ID'";
        $result4=$this->db->query($sql4);            
        foreach ($result4->result_array() as $row4)  
        {            
            $PayMode=$row4['Paymode'];
            $BillAmount=sprintf("%01.2f",$row4['BillAmount']);
            $tbl.=<<<EOD
            <tr nobr="true">
            <td colspan="2" >Paymode:$PayMode</td>
            <td colspan="2" style="text-align:left;">Amount :$BillAmount</td>           
            </tr>
            EOD;
            $subtotal=$subtotal+$line_tot;
        }
        $tbl.=<<<EOD
        </table>
        <table style="" cellpadding="3" cellspacing="">
        <tr nobr="true">
        <td style="text-align:center;">
        <span style="font-weight:bold;">$mst</span>
        </td>
        </tr>
        </table>
        EOD;
        if($Orderno<>'')
        {
        $tbl.=<<<EOD
        <table style="" cellpadding="3" cellspacing="">
        <tr nobr="true">
        <td style="text-align:center;">
        <span style="font-weight:bold;">Ref.Order.NO: $Orderno</span>
        </td>
        </tr>
        </table>
        EOD;
        }
            
        
        $pdf->writeHTML($tbl, true, false, false, false,'');
        /* $pdf->IncludeJS("print();"); */
        $pdf->Output('outletBillDuplicate.pdf', 'I');
        
        
    }
}