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
                            <div class="page-title">Outlet Sales Analysis</div>
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
                                    <label>From </label>
                                        <input class="form-control"  value="<?php if(@$_POST['fromdate']){ echo $_POST['fromdate']; } else { echo date('Y-m-d');} ?>" type ="date" name="fromdate">						                        
                                    </div> 
                                </div>								  
                            </div>                           
                            <div class="col-md-3 col-sm-3">										
                                <div class="card-body " id="bar-parent10">   
                                <div class="form-group row mt-3">										
                                <button type="submit"  class="btn btn-primary">Show</button>		
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
				                        <h3 class="text-center">Outlet Sales Analysis On <?php echo date('d-m-Y', strtotime($_POST['fromdate'])); ?><h3>				
		                            </div>                                 
                                     <thead> 
                                        <tr style="text-align: center;background-color:#c9c6c6;">
                                            <th rowspan="2">Outlet</th>  
                                            <th colspan="3">To Day</th>    
                                            <th colspan="3">To Month</th> 
                                            <th colspan="3">Year To Date</th>                                                                                                                                                                             
                                        </tr>                                  
                                        <tr style="text-align: center;background-color:#c9c6c6;">                                           
                                            <th>Sales Amount</th>    
                                            <th>Taxes</th>  
                                            <th>Total Amount</th>    
                                            <th>Sales Amount</th>    
                                            <th>Taxes</th>  
                                            <th>Total Amount</th>  
                                            <th>Sales Amount</th>    
                                            <th>Taxes</th>  
                                            <th>Total Amount</th>                                                                                     
                                        </tr>                                        
                                    </thead>
                                    <tbody>     
                                    <?php                                                      
                                    $query1="Exec Rep_OutletSalesAnalysis ".$_POST['outlet'].",'".$_POST['fromdate']."','".date('Y-m-01', strtotime($_POST['fromdate']))."','".$_SESSION['MPOSCOMPANYID']."'";
                                    $result1=$this->db->query($query1); 
                                    $Amount=0;$Sales=0; $Tax=0; $MAmount=0;$Msales=0;$MTax=0;
                                    $YAmount=0;$Ysales=0;$YTax=0;
                                    foreach ($result1->result_array() as $row1)	 
                                    {  
                                   echo ' <tr>                                           
                                            <td>'.$row1["Name"].'</td>                                                
                                            <td style="text-align: right">'.$row1["Sales"].'</td>    
                                            <td style="text-align: right">'.$row1["Tax"].'</td>    
											<td style="text-align: right">'.$row1["Amount"].'</td>                                               
                                            <td style="text-align: right">'.$row1["Msales"].'</td>  
                                            <td style="text-align: right">'.$row1["MTax"].'</td>    
											<td style="text-align: right">'.$row1["MAmount"].'</td>                                              
                                            <td style="text-align: right">'.$row1["Ysales"].'</td>  
                                            <td style="text-align: right">'.$row1["YTax"].'</td>    
											<td style="text-align: right">'.$row1["YAmount"].'</td> 											
                                        </tr>';   
                                        $Amount=$Amount+$row1["Amount"];     
                                        $Sales=$Sales+$row1["Sales"];                         
                                        $Tax=$Tax+$row1["Tax"];
                                        $MAmount=$MAmount+$row1["MAmount"];
                                        $Msales=$Msales+$row1["Msales"];
                                        $MTax=$MTax+$row1["MTax"];
                                        $YAmount=$YAmount+$row1["YAmount"];
                                        $Ysales=$Ysales+$row1["Ysales"];
                                        $YTax=$YTax+$row1["YTax"];
                                    }   
                                    echo ' <tr>                                           
                                        <td>Total</td>                                             
                                        <td style="text-align: right">'.number_format($Sales,2).'</td>    
                                        <td style="text-align: right">'.number_format($Tax,2).'</td>    
										<td style="text-align: right">'.number_format($Amount,2).'</td>                                           
                                        <td style="text-align: right">'.number_format($Msales,2).'</td>  
                                        <td style="text-align: right">'.number_format($MTax,2).'</td>   
										<td style="text-align: right">'.number_format($MAmount,2).'</td>										                                        
                                        <td style="text-align: right">'.number_format($Ysales,2).'</td>  
                                        <td style="text-align: right">'.number_format($YTax,2).'</td>                                                                                   
										<td style="text-align: right">'.number_format($YAmount,2).'</td>  
                                    </tr>';         
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
              filename: "Outlet Sales Analysis" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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