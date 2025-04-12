<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css_Report();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);

        $printing="'printing'";
		$excel="'exporttable'";
		$pdf="'exportpdf'";
        ?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-bar">
                    <div class="page-title-breadcrumb">
                        <div class=" pull-left">
                            <div class="page-title">Session Wise Report</div>
                        </div>
                        <ol class="breadcrumb  pull-right">
                            <li><a href="#" id="Rload" onclick="printDiv('printing')" class="btn btn-success btn-sm pull-right" > Print</a></li>
                            <li><a href="#"  id='exporttable' class="btn btn-success btn-sm pull-right" >Excel</a></li>
                            <li><a href="#"  id='exportpdf'  class="btn btn-success btn-sm pull-right" >Pdf</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-topline-aqua">
                        <form method="POST">								
                            <div class="row">	                        
                                <div class="col-md-3 col-sm-3">																	
                                    <div class="card-body " id="bar-parent10">                                      
                                        <div class="form-group row">
                                        <label>Outlet </label>                                            
                                        <?php 
                                        $sql="select Name,id from headings  where companyid='".$_SESSION['MPOSCOMPANYID']."' and isnull(isvisible,0)=1";
                                        $result=$this->db->query($sql);
                                        							
                                        ?><select  class="form-control  select2" name="outlet" id="outlet">
                                          <option value="0" selected>All Outlet</option>
                                <?php		foreach ($result->result_array() as $row)	 
                                         {		?>                                                   
                                                <option <?php if(@$_POST['outlet']==$row['id']){echo "selected";} ?> value="<?php echo $row['id'] ?>"><?php echo $row['Name']; ?></option>
                                <?php } ?>	
                                          </select>                                        
                                        </div> 
                                    </div>								  
                            </div> 
							  <div class="col-md-3 col-sm-3">																	
                                    <div class="card-body " id="bar-parent10">                                      
                                        <div class="form-group row">
                                        <label>Session </label>                                            
                                        <?php 
                                        $sql="select * from SESSION where  companyid='".$_SESSION['MPOSCOMPANYID']."' ";
                                        $result=$this->db->query($sql);
                                        							
                                        ?>
                                            <select  class="form-control  select2" name="Session" id="Session">
                                            <option value="0"  selected>All Session</option>
                                <?php		foreach ($result->result_array() as $row)	 
                                         {		?>                                                   
                                                <option <?php if(@$_POST['Session']==$row['sESSID']){echo "selected";} ?> value="<?php echo $row['sESSID'] ?>"><?php echo $row['sESSION']; ?></option>
                                <?php } ?>	
                                            </select>
                                        
                                        </div> 
                                    </div>								  
                            </div> 
                            <div class="col-md-2 col-sm-2">																	
                                    <div class="card-body " id="bar-parent10">                                      
                                        <div class="form-group row">
                                        <label>From </label>
                                            <input class="form-control"  value="<?php if(@$_POST['fromdate']){ echo $_POST['fromdate']; } else { echo date('Y-m-d');} ?>" type ="date" name="fromdate">						                        
                                        </div> 
                                    </div>								  
                            </div> 
                            <div class="col-md-2 col-sm-2">																	
                                    <div class="card-body " id="bar-parent10">   
                                        <div class="form-group row">
                                        <label>To  </label>
                                                <input class="form-control" value="<?php if(@$_POST['todate']){ echo $_POST['todate']; } else { echo date('Y-m-d');} ?>" type ="date" name="todate">										      
                                        </div> 										
                                    </div>								  
                            </div>
                            <div class="col-md-2 col-sm-2">										
                                <div class="card-body " id="bar-parent10">   
                                <div class="form-group row">										
                                <button type="submit" onclick="submits()" class="btn btn-primary">Show</button>		
                                </div> 	</div> 									
                            </div> 							  
                            </div>
                            </form>
                        </div>
                        <?php 
        if(isset($_POST['outlet']))
        {   ?>
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-topline-aqua">
                            
                            <div class="card-body ">
                                <div class="table-scrollable">
                                    <div id="printing"  class="col-sm-12">
								   <table  id="example"  class="table table-bordered table-hover" style="width:100%">   
                                   <div>
				                        <h3 class="text-center">Session Wise Report  <?php echo date('d-m-Y', strtotime($_POST['fromdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h3>				
		                            </div>                                 
                                     <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Session</th>
                                            <th>No.Bills</th>
                                            <th>Amount</th>
                                            <th>Tax</th>
                                            <th>Total Amount</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php		
								/*	$query="select tbm.billid,tbm.billno,tbm.billdate,tm.tablename,tbm.noofpax,emp.employee,isnull(tbm.Totaltaxamount,0)as Totaltaxamount,un.Username,
										 tbm.discamount,tbm.itemtotal,tbm.totalamount from trans_Reskotbillraise_mas tbm 
										 inner join tablemas tm on tm.tableid=tbm.tableid 
										 left outer join employee emp on emp.employeeid=tbm.stwid 
										 inner join username un on un.userid=tbm.userid 
										 where tbm.billdate  between '".$_POST['fromdate']."' and '".$_POST['todate']."'and isnull(tbm.settled,0)=1  and
										  isnull(tbm.CANCEL,0)=0 and tbm.RESTYPEID=(CASE WHEN '".$_POST['outlet']."'=0 THEN tbm.RESTYPEID ELSE '".$_POST['outlet']."' END ) 
										  and tbm.sessionid=(CASE WHEN '".$_POST['Session']."'=0 THEN tbm.sessionid ELSE '".$_POST['Session']."' END )  Order by tbm.billno";
                                   */ 
                                     $query="select Ord=1, count(mas.Billid) as NoofBil, Sum(mas.totalamount)as Amount, Sum(mas.itemtotal) as itemtotal, sum(mas.totaltaxamount)as Taxamount,se.sESSION as Session from Trans_ResKotBillraise_mas mas
                                    Inner join Session Se on Se.sESSID=mas.Sessionid
                                    Where  mas.billdate between '".$_POST['fromdate']."' and '".$_POST['todate']."' and isnull(mas.settled,0)=1 and isnull(mas.CANCEL,0)=0
                                    and mas.RESTYPEID=(CASE WHEN '".$_POST['outlet']."'=0 THEN mas.RESTYPEID ELSE '".$_POST['outlet']."' END )
                                     and mas.sessionid=(CASE WHEN '".$_POST['Session']."'=0 THEN mas.sessionid ELSE '".$_POST['Session']."' END )
                                    Group By se.sESSION
                                    Union                                    
                                    select  Ord=2, NoofBil=0, Amount=0, itemtotal=0,Taxamount=0,Session='UnSettled' where 0 !=( select  count(mas.Billid)as Counts from Trans_ResKotBillraise_mas mas
                                    Inner join Session Se on Se.sESSID=mas.Sessionid
                                    Where  mas.billdate between '".$_POST['fromdate']."' and '".$_POST['todate']."' and isnull(mas.settled,0)=0 and isnull(mas.CANCEL,0)=0
                                    and mas.RESTYPEID=(CASE WHEN '".$_POST['outlet']."'=0 THEN mas.RESTYPEID ELSE '".$_POST['outlet']."' END )
                                     and mas.sessionid=(CASE WHEN '".$_POST['Session']."'=0 THEN mas.sessionid ELSE '".$_POST['Session']."' END ))
                                    Union                                    
                                     select Ord=3, count(mas.Billid) as NoofBil, Sum(mas.totalamount)as Amount, Sum(mas.itemtotal) as itemtotal, sum(mas.totaltaxamount)as Taxamount,se.sESSION as Session from Trans_ResKotBillraise_mas mas
                                    Inner join Session Se on Se.sESSID=mas.Sessionid
                                    Where  mas.billdate between '".$_POST['fromdate']."' and '".$_POST['todate']."' and isnull(mas.settled,0)=0 and isnull(mas.CANCEL,0)=0
                                    and mas.RESTYPEID=(CASE WHEN '".$_POST['outlet']."'=0 THEN mas.RESTYPEID ELSE '".$_POST['outlet']."' END )
                                     and mas.sessionid=(CASE WHEN '".$_POST['Session']."'=0 THEN mas.sessionid ELSE '".$_POST['Session']."' END )
                                    Group By se.sESSION ";                                   
                                            $result=$this->db->query($query); $i=1;  $Billno='';  
                                            foreach ($result->result_array() as $row)	 
                                            {
                                                if($row['Session']=='UnSettled')
                                                {
                                                 //  echo '<tr style="text-align: center;background-color:#c9c6c6;"><td  class="text-bold" >Un Settled Bills</td></tr>';
                                                 ?>   <tr style="text-align: center;background-color:#c9c6c6;"><td colspan="6">Pending Bills</td></tr> <?php
                                                }
                                                else
                                                {     ?>                                           																										
                                                <tr>
                                                    <td><?php echo $i; $i++; ?></td>
                                                    <td><?php  echo $row['Session'];?></td>                                                                                
                                                    <td style ="text-align: center;"><?php  echo $row['NoofBil'];?></td>
                                                    <td style ="text-align: end;"><?php  echo $row['itemtotal'];?></td>
                                                    <td style ="text-align: end;"><?php echo $row['Taxamount'];?></td>                                            
                                                    <td style ="text-align: end;"><?php  echo $row['Amount'];?></td>                                                                                  
                                                </tr>											
                                            <?php
                                                }
                                            } ?>
                                            <tr style="text-align: center;background-color:#c9c6c6;"><td colspan="6">Collection</td></tr>
                                            <?php
                                     $query1="select Sum(sm.BillAmount)as Amount,Se.sESSION as Session,pm.PayMode  from Trans_reskotsettlement sm
                                    Inner join SESSION se on se.sESSID=sm.sessionid
                                    Inner join Mas_Paymode pm on PayMode_Id=sm.Paymentid
                                    Where SettleDate  between '".$_POST['fromdate']."' and '".$_POST['todate']."' and isnull(sm.cancel,0)=0
                                    and sm.RESTYPEID=(CASE WHEN '".$_POST['outlet']."'=0 THEN sm.RESTYPEID ELSE '".$_POST['outlet']."' END )
                                    and sm.sessionid=(CASE WHEN '".$_POST['Session']."'=0 THEN sm.sessionid ELSE '".$_POST['Session']."' END )
                                    Group By Se.sESSION,pm.PayMode "; 
                                    $result1=$this->db->query($query1); 
                                    foreach ($result1->result_array() as $row1)	 
                                    {     ?>                                           																										
                                        <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td><?php  echo $row1['Session'];?></td>                                                                                
                                            <td><?php  echo $row1['PayMode'];?></td>
                                            <td style ="text-align: end;"><?php  echo $row1['Amount'];?></td>
                                            <td></td>                                            
                                            <td></td>                                                                                  
                                        </tr>											
                                    <?php
                                     }
                                           // echo '<tr style="text-align: center;background-color:#c9c6c6;"><td  class="text-bold" colspan="6">Collection</td></tr>'; 
                                    ?>
                                                                          
                                        
                                    </tbody>
                                </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php	 }
        ?>
                    </div>
                </div>
                
                
                
                
            </div>
        </div>
<?php 
$this->pweb->wfoot($this->Menu,$this->session);	

$this->pcss->wjs();
?>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
<SCRIPT language="javascript">
		function printDiv(a) {
			 var printContents = document.getElementById(a).innerHTML;
			 var originalContents = document.body.innerHTML;
			 document.body.innerHTML = printContents;
			 window.print();
			 document.body.innerHTML = originalContents;
		}
       function fromdatevalidate()
	   {
		 var a= document.getElementsByName("dateFrom")[0].value;
		 alert(a);
	   }
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}

		$(function() {
        $("#exporttable").click(function(e)
		{

          var table = $("#printing");
          if(table && table.length)
		  {
            $(table).table2excel({
              exclude: ".noExl",
              name: "Excel Document Name",
              filename: "Cashier Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true,
              preserveColors: false
            });
          } 
		});
      });


	  $("body").on("click", "#exportpdf", function () {
            html2canvas($('#printing')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("CashierReport.pdf");
                }
            });
        });

	</SCRIPT>