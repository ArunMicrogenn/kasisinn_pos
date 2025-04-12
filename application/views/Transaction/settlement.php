<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
date_default_timezone_set('Asia/Kolkata'); ?>
<!-- END HEAD -->
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <div class="page-wrapper">
        <!-- start header -->
        <!-- end header -->
        <!-- start page container -->
        <div class="page-content-wrapper">

			 <!-- end sidebar menu -->
			<!-- start page content -->
			<?php 
			$sql="select * from Trans_reskotbillraise_mas mas 
				 inner join Tablemas tbl on tbl.tableid=mas.tableid
				 where isnull(mas.tableid,0)='".$Tableid."' and isnull(mas.settled,0)=0 and mas.restypeid='".$Outletid."'";
		    $result = $this->db->query($sql);
			foreach($result->result_array() as $row)
			{ $Amount=$row['totalamount'];
			  $tablename=$row['Tablename'];
			  $Tableid=$row['Tableid'];
			  $Billno=$row['Billno'];
			  $Noofpax=$row['noofpax'];
			  $Billdate=$row['Billdate'];
			  $Billid=$row['Billid'];
			}
			?>
            <div class="page-content-wrapper">
                <div class="page-content">                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">                               
                                <div class="card-body " id="bar-parent5">
								<form method='post' id="myForm" action="<?php echo scs_index?>settlementsave" >
								   <input type="hidden" name="outletid" value="<?php echo $Outletid; ?>" id="outletid">
								   <input type="hidden" name="billid" value="<?php echo $Billid; ?>" id="billid">
                                    <div class="row">     									 
                                        <div class="col-lg-4 col-md-4 ">
                                           <div class="form-group row">
                                            <label for="tableno" class="col-sm-5 control-label">Table No</label>
                                            <div class="col-sm-7">
											   <input type="text" class="form-control" id="tableno" readonly value="<?php echo $tablename; ?>"; name="tableno" >
											   <input type="hidden" class="form-control" id="tableid" readonly value="<?php echo $Tableid; ?>"; name="tableid" >
											</div>
                                           </div>                                       
                                        </div>
                                        <div class="col-lg-4 col-md-4 ">
                                           <div class="form-group row">
                                            <label for="pax" class="col-sm-4 control-label">Billno</label>
                                            <div class="col-sm-8">
                                              	<input type="text" class="form-control" id="pax"  value="<?php echo $Billno; ?>" readOnly name="pax" >
                                            </div>
                                           </div> 
                                        </div> 
										<div class="col-lg-4 col-md-4 ">
                                           <div class="form-group row">
                                            <label for="steward" class="col-sm-4 control-label">Billdate</label>
                                            <div class="col-sm-8">
											   <input type="text" class="form-control" id="steward" readonly value="<?php echo substr($Billdate,0,10);    ?>" name="steward" >                                               	
                                            </div>
                                           </div> 
                                        </div> 
											<div class="card-body" id="rw1" style="height:400px;overflow-x: hidden;overflow-y: scroll;">													
													<table id="customer" class="table table-striped table-bordered table-hover table-checkable order-column full-width" id="example4">
														<thead>
															<tr>
																<th>Paymode</th>
																<th>Amount</th>
																<th>Card/UPI</th>
																<th>Expiry Date</th>																
																<th>Card.No/Transaction.ID</th>																
																<th> Actions </th>
															</tr>
														</thead>
														<tbody id="tab_logic1">
														<?php  $i=1; ?>
														<tr class="odd gradeX" id="addr1<?php echo $i; ?>">
														  <td style="width:30%">
														  <select name="paymode[]" onChange="paymodeselect(<?php echo $i; ?>);" id="paymode<?php echo $i; ?>" class='form-control input-md'>
`														   <option value='0'>Select Paymode</option>
															<?php 
															$sql1="select * from mas_paymode where isnull(posapplicable,0)=1";
														 $result1 = $this->db->query($sql1);
															foreach($result1->result_array() as $row1)
															{ ?>
															  <option value='<?php echo $row1['PayMode_Id']; ?>'> <?php echo $row1['PayMode']; ?> </option>	
															<?php }
															?>
														  </select></td>
														  <td style="width:20%"><input name='Amount[]' id='Amount<?php echo $i; ?>' onclick='applubal("<?php echo $i; ?>")' type='text' placeholder='' value="0.00" class='form-control input-md amtBal ctrtss<?php echo $i; ?>'></td>
														  <td style="width:20%"><select name='bank[]' id="bank<?php echo $i; ?>" style="display:none" class='form-control input-md'><option value='0'>select Card/UPI</option></select></td>
														  <td style="width:10%"><input name='exdate[]' id='exdate<?php echo $i; ?>' style="display:none" value=""  type='date' placeholder=''  class='form-control input-md'></td>
														  <td style="width:10%"><input name='cardno[]' id='cardno<?php echo $i; ?>' style="display:none" value="" type='text' placeholder=''  class='form-control input-md'></td>
														  <td style="width:10%" class='valigntop'> <button type='button' onclick="addField()" class="btn btn-success btn-xs">  <i class="fa fa-check"></i>  </button>
                                                            <!--button type='button'  onclick='deletes(<?php echo $i; ?>)' class="btn btn-danger btn-xs">   <i class="fa fa-trash-o "></i>  </button--->	</td>
														</tr>														
														</tbody>
													</table>					
											</div>	
								<table style="width:100%;">
								<tr>								
								<td style="width: 25%;text-align: right;">Balace : </td>
								<td style="width: 25%;"><input type="text" placeholder="" value="<?php echo $Amount ?>" class="form-control cgrt"  style="text-align:center;" name="balanceamt" id="balanceamt" readonly /> 								
								</td>
								<td style="width: 25%;text-align: right;">Total : </td>
								<td style="width: 25%;"><input type="text" placeholder="" value="<?php echo $Amount ?>" class="form-control cgrt"  style="text-align:center;" name="totalamount" id="totalamount" readonly /> 								
								</td>
								</tr>
								</table>																					
                                    </div><br>
									<center>
									  <button type="button" onclick="settlementsubmit()"  name="btn-submit"  id="placedhd" class="btn btn-primary">Settled</button>
									  <!----button type="submit"  name="btn-printno" id="printidft"   class="btn btn-primary">F4-(Print)</button--->
									  <!--button type="button"  name="btn-clear" onclick="clear()"  class="btn btn-primary">Clear</button-->											
									  <input type="hidden" name="rowcount" id="rowcount" value='0'>				
                                      <button type="button"  onclick ="fnexit()" name="btn-clear"  class="btn btn-primary">Exit</button>
									</center>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page content -->
          
            <!-- end chat sidebar -->
        </div>
		
        <!-- end page container -->
        <!-- start footer -->
 
        <!-- end footer -->
    </div>
	

    <?php
$this->pweb->wfoot1($this->Menu,$this->session);	
$this->pcss->wjs();
?>


<script>
	 function paymodeselect(id)
  { 
     var paymodeid = document.getElementById('paymode'+id).value; 	
	
	  if(paymodeid=='1')
		{
			document.getElementById('bank'+id).style.display = "none"; 
			document.getElementById('cardno'+id).style.display = "none"; 
			document.getElementById('exdate'+id).style.display = "none"; 
			document.getElementById('bank'+id).required = false;
			document.getElementById('cardno'+id).required = false;			
			document.getElementById('exdate'+id).required = false;			
		}
		else if(paymodeid=='2')
		{
			document.getElementById('bank'+id).style.display = "block"; 
			document.getElementById('cardno'+id).style.display = "block"; 
			document.getElementById('exdate'+id).style.display = "block"; 
			document.getElementById('bank'+id).required = true;
			document.getElementById('cardno'+id).required = true;			
			document.getElementById('exdate'+id).required = true;
			$.ajax({url:"<?php echo scs_index ?>kotoutlet/getbankdetails/"+paymodeid, type: "POST",dataType: "html",success:function(result){		
				$("#bank"+id).html(result);
			///	alert (result);
				}
			  });			
		}
		else if(paymodeid=='3' || paymodeid=='5')
		{
			document.getElementById('bank'+id).style.display = "block"; 
			document.getElementById('cardno'+id).style.display = "block"; 
			document.getElementById('exdate'+id).style.display = "none"; 
			document.getElementById('bank'+id).required = true;
			document.getElementById('cardno'+id).required = true;			
			document.getElementById('exdate'+id).required = false;	
			$.ajax({url:"<?php echo scs_index ?>kotoutlet/getbankdetails/"+paymodeid, type: "POST",dataType: "html",success:function(result){		
			$("#bank"+id).html(result);
			///	alert (result);
				}
			  });	
		}
		else if(paymodeid=='4')
		{
			document.getElementById('bank'+id).style.display = "block"; 
			document.getElementById('cardno'+id).style.display = "none"; 
			document.getElementById('exdate'+id).style.display = "none"; 
			document.getElementById('bank'+id).required = true;
			document.getElementById('cardno'+id).required = false;			
			document.getElementById('exdate'+id).required = false;	
			$.ajax({url:"<?php echo scs_index ?>kotoutlet/getbankdetails/"+paymodeid+"/<?php echo $Outletid; ?>", type: "POST",dataType: "html",success:function(result){		
			$("#bank"+id).html(result);
			///	alert (result);
				}
			  });
		}
		
		else if(paymodeid=='6')
		{
			document.getElementById('bank'+id).style.display = "block"; 
			document.getElementById('cardno'+id).style.display = "none"; 
			document.getElementById('exdate'+id).style.display = "none"; 
			document.getElementById('bank'+id).required = true;
			document.getElementById('cardno'+id).required = false;			
			document.getElementById('exdate'+id).required = false;	
			$.ajax({url:"<?php echo scs_index ?>kotoutlet/getbankdetails/"+paymodeid+"/<?php echo $Outletid; ?>", type: "POST",dataType: "html",success:function(result){		
			$("#bank"+id).html(result);
			///	alert (result);
				}
			  });
		}
		else if(paymodeid=='7')
		{
			document.getElementById('bank'+id).style.display = "block"; 
			document.getElementById('cardno'+id).style.display = "block"; 
			document.getElementById('exdate'+id).style.display = "none"; 
			document.getElementById('bank'+id).required = true;
			document.getElementById('cardno'+id).required = false;			
			document.getElementById('exdate'+id).required = false;
			$.ajax({url:"<?php echo scs_index ?>kotoutlet/getbankdetails/"+paymodeid, type: "POST",dataType: "html",success:function(result){		
				$("#bank"+id).html(result);
			///	alert (result);
				}
			  });
		}
  }


  function applubal(obj3)
  {
	bal=$("#balanceamt").val();
	Bval=parseFloat($("#totalamount").val());
	$("#Amount"+obj3).val(bal);
	cashRcd=$("#Amount"+obj3).val();
	totTt=0;
	$(".amtBal").each(function(){
		totTt +=parseFloat($(this).val());
	});
	csBlAmt=parseFloat(Bval-totTt);
	$("#balanceamt").val(csBlAmt.toFixed(2));
	bal=$("#balanceamt").val();
	if(bal=='NaN' || bal <='0.00'){
		$("#balanceamt").val('0.00');
	}
  }
   

  function deletes(obj)
  {
	  //alert(obj);
	  $('#'+obj).val('');
	  $('#itemid'+obj).val('');
	  $('#addr1'+obj).css('display','none');
	   jQuery("#placedhd").attr("disabled", false); 
	//  $("#placedhd").attr("disabled", true);
	//   $("#printidft").attr("disabled", true);
//	reveslqty(obj);  
	var boxes = document.getElementsByName("itemqty[]");
		$('#rowcount').val(boxes.length);	
	  
  }


  function settlementsubmit()
  { 
    bal=$("#balanceamt").val();
	totlamt=$("#totalamount").val();
	totTt=0;
	$(".amtBal").each(function(){
		totTt +=parseFloat($(this).val());
	});
	if(totTt !=totlamt)
	{
	  alert("Settlement Amount Not Tally");
	}
	else if(bal=='0.00')
	{
	   var i = document.getElementById('customer').getElementsByTagName("tr").length;
       var rs = i - 1;
	   var pm = document.getElementById('paymode'+rs).value;
	   $("#rowcount").val(i);	   
	   if(pm=='0')
	   {
		 alert("Please to Select Paymode");  
	   }
	   else if(pm=='2')
	   {
		  var bank = document.getElementById('bank'+rs).value; 
		  var edate = document.getElementById('exdate'+rs).value; 	
		  var cardno = document.getElementById('cardno'+rs).value;		  
		  if(bank=='0' || cardno=='' || cardno=='0')
		  {
			alert("Enter Valied Details");
		  }
		  else
		  {
			 document.getElementById("myForm").submit();  
		  }
	   }
	   else if(pm=='3' || pm=='4' || pm=='6')
	   {
		  var bank = document.getElementById('bank'+rs).value; 
		  if(bank=='0')
		  {
			 alert("Enter Bank Details");
		  }
		  else
		  {
			 document.getElementById("myForm").submit();  
		  }
	   } 
	   else
	   {
		 	document.getElementById("myForm").submit();  
	   }
	 
	}
	else
	{ alert("Settlement Amount Not Tally");}	
  }
</script>
<script>

  function addField()
  { 
   var i = document.getElementById('customer').getElementsByTagName("tr").length;
   var rs = i - 1;
   var pr = document.getElementById('Amount'+rs).value;
   var paymode = document.getElementById('paymode'+rs).value;
    if(pr == '0.00' || pr == '0' || pr == ''  )
	{
	  alert("Please Enter Amount");
	}
	else if(paymode=='0')
	{
	  alert("Please Select Paymode");
	}
    else
	{
		Bval=parseFloat($("#totalamount").val());
		totTt=0;
		$(".amtBal").each(function(){
				totTt +=parseFloat($(this).val());
			  });
		csBlAmt=parseFloat(Bval-totTt);
		$("#balanceamt").val(csBlAmt.toFixed(2));
		bal=$("#balanceamt").val();
		if(bal=='NaN' || bal <='0.00'){
			$("#balanceamt").val('0.00');		}
		bal=$("#balanceamt").val();			
	   if(bal=='0.00')
	   { alert("Balace Amount should be zero"); }
	 
	   else if(paymode=='1')
		{	 		 
			 var markup = "<tr class='odd gradeX' id='addr1"+i+"'><td><select name='paymode[]' onchange='paymodeselect("+i+")' id='paymode"+i+"' class='form-control input-md'>  <option value='0'>Select Paymode</option><?php  $sql1='select * from mas_paymode where isnull(posapplicable,0)=1';	 $result1 =$this->db->query($sql1);	foreach($result1->result_array() as $row1)	{ ?> <option value='<?php echo $row1['PayMode_Id']; ?>'> <?php echo $row1['PayMode']; ?> </option> <?php } ?> </select></td>  <td style='width:20%'><input name='Amount[]' id='Amount"+i+"'  onclick='applubal("+i+")'  type='text' placeholder='' value='0.00' class='form-control input-md amtBal ctrtss"+i+"'></td>  <td style='width:20%'><select name='bank[]' id='bank"+i+"' style='display:none' class='form-control input-md'><option value='0'>select Card/UPI</option></select></td> <td style='width:10%'><input name='exdate[]' id='exdate"+i+"' style='display:none' value=''  type='date' placeholder=''  class='form-control input-md'></td>  <td style='width:10%'><input name='cardno[]' id='cardno"+i+"' style='display:none' value='' type='text' placeholder=''  class='form-control input-md'></td><td class='valigntop'> <button type='button' onclick='addField()' class='btn btn-success btn-xs'>  <i class='fa fa-check'></i></button>  <button  type='button'  onclick='deletes("+i+")' class='btn btn-danger btn-xs'>   <i class='fa fa-trash-o '></i>  </button>	</td></tr>";
			 $("#customer").append(markup);			
		}
		else if(paymode=='2')
		{ 
	      var bank = document.getElementById('bank'+rs).value; 
		  var edate = document.getElementById('exdate'+rs).value; 	
		  var cardno = document.getElementById('cardno'+rs).value;
		  if(bank=='0' || cardno=='' || cardno=='0')
		  {
			alert("Enter Valied Details");
		  }
		  else
		  {
			var markup = "<tr class='odd gradeX' id='addr1"+i+"'><td><select name='paymode[]' onchange='paymodeselect("+i+")' id='paymode"+i+"' class='form-control input-md'>  <option value='0'>Select Paymode</option><?php  $sql1='select * from mas_paymode where isnull(posapplicable,0)=1';	 $result1 = $this->db->query($sql1);	foreach($result1->result_array() as $row1)	{ ?> <option value='<?php echo $row1['PayMode_Id']; ?>'> <?php echo $row1['PayMode']; ?> </option> <?php } ?> </select></td>  <td style='width:20%'><input name='Amount[]' id='Amount"+i+"'  onclick='applubal("+i+")'  type='text' placeholder='' value='0.00' class='form-control input-md amtBal ctrtss"+i+"'></td>  <td style='width:20%'><select name='bank[]' id='bank"+i+"' style='display:none' class='form-control input-md'><option value='0'>select Card/UPI</option></select></td> <td style='width:10%'><input name='exdate[]' id='exdate"+i+"' style='display:none' value=''  type='date' placeholder=''  class='form-control input-md'></td>  <td style='width:10%'><input name='cardno[]' id='cardno"+i+"' style='display:none' value='' type='text' placeholder=''  class='form-control input-md'></td><td class='valigntop'> <button type='button' onclick='addField()' class='btn btn-success btn-xs'>  <i class='fa fa-check'></i></button>  <button  type='button'  onclick='deletes("+i+")' class='btn btn-danger btn-xs'>   <i class='fa fa-trash-o '></i>  </button>	</td></tr>";
	        $("#customer").append(markup); 						
		  }			
		}
	else if(paymode=='3' || paymode=='4' || paymode=='6')
		{
		 var bank = document.getElementById('bank'+rs).value; 
		  if(bank=='0')
		  {
			 alert("Enter Bank Details");
		  }
		  else
		  {
			var markup = "<tr class='odd gradeX' id='addr1"+i+"'><td><select name='paymode[]' onchange='paymodeselect("+i+")' id='paymode"+i+"' class='form-control input-md'>  <option value='0'>Select Paymode</option><?php  $sql1='select * from mas_paymode where isnull(posapplicable,0)=1';	 $result1 = $this->db->query($sql1);	foreach($result1->result_array() as $row1)	{ ?> <option value='<?php echo $row1['PayMode_Id']; ?>'> <?php echo $row1['PayMode']; ?> </option> <?php } ?> </select></td>  <td style='width:20%'><input name='Amount[]' id='Amount"+i+"'  onclick='applubal("+i+")'  type='text' placeholder='' value='0.00' class='form-control input-md amtBal ctrtss"+i+"'></td>  <td style='width:20%'><select name='bank[]' id='bank"+i+"' style='display:none' class='form-control input-md'><option value='0'>select Card/UPI</option></select></td> <td style='width:10%'><input name='exdate[]' id='exdate"+i+"' style='display:none' value=''  type='date' placeholder=''  class='form-control input-md'></td>  <td style='width:10%'><input name='cardno[]' id='cardno"+i+"' style='display:none' value='' type='text' placeholder=''  class='form-control input-md'></td><td class='valigntop'> <button type='button' onclick='addField()' class='btn btn-success btn-xs'>  <i class='fa fa-check'></i></button>  <button  type='button'  onclick='deletes("+i+")' class='btn btn-danger btn-xs'>   <i class='fa fa-trash-o '></i>  </button>	</td></tr>";
	        $("#customer").append(markup);   
		  }		
		}
		else if(paymode=='5')
		{
			var markup = "<tr class='odd gradeX' id='addr1"+i+"'><td><select name='paymode[]' onchange='paymodeselect("+i+")' id='paymode"+i+"' class='form-control input-md'>  <option value='0'>Select Paymode</option><?php  $sql1='select * from mas_paymode where isnull(posapplicable,0)=1';	 $result1 = $this->db->query($sql1);	foreach($result1->result_array() as $row1)	{ ?> <option value='<?php echo $row1['PayMode_Id']; ?>'> <?php echo $row1['PayMode']; ?> </option> <?php } ?> </select></td>  <td style='width:20%'><input name='Amount[]' id='Amount"+i+"'  onclick='applubal("+i+")'  type='text' placeholder='' value='0.00' class='form-control input-md amtBal ctrtss"+i+"'></td>  <td style='width:20%'><select name='bank[]' id='bank"+i+"' style='display:none' class='form-control input-md'><option value='0'>select Card/UPI</option></select></td> <td style='width:10%'><input name='exdate[]' id='exdate"+i+"' style='display:none' value=''  type='date' placeholder=''  class='form-control input-md'></td>  <td style='width:10%'><input name='cardno[]' id='cardno"+i+"' style='display:none' value='' type='text' placeholder=''  class='form-control input-md'></td><td class='valigntop'> <button type='button' onclick='addField()' class='btn btn-success btn-xs'>  <i class='fa fa-check'></i></button>  <button  type='button'  onclick='deletes("+i+")' class='btn btn-danger btn-xs'>   <i class='fa fa-trash-o '></i>  </button>	</td></tr>";
	        $("#customer").append(markup); 
		}		
	}
  }


 

  
  
	
	
$("body").keydown(function(e){
    var keyCode = e.keyCode || e.which;
	if(keyCode == 113)    
	{
	var boxes = document.getElementsByName("itemqty[]"); 
	var ret = false;
    //alert(boxes.length);
	$("#placedhd").click(); 
    $("#placedhd").attr("disabled", true);	 

    }
    });
	
	function fnexit()
	{
		window.location.href = '<?php echo scs_index?>kotoutlet/Tablelist/<?php echo $Outletid; ?>'; 
	}
	
	</script>
