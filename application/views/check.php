<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pcss->hjs();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,@$F_Ctrl,@$F_Class);
?>
<!-- END HEAD -->
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <div class="page-wrapper">
        <!-- start header -->
		
        <!-- end header -->
        <!-- start page container -->
        <div class="page-content-wrapper">
 			<!-- start sidebar menu -->
 		
			 <!-- end sidebar menu -->
			<!-- start page content -->
			<?php 
			$Noofpax=1;$Employeeid=0;
			$sql1="select * from  tablemas tm
			left outer join Employee Emp on Emp.Employeeid=tm.SID where tm.Tableid='".$Tableid."'";
			$result1 = $this->db->query($sql1);		
			foreach($result1->result_array() as $row1) {
				$tablename=$row1['Tablename'];
				$Noofpax=$row1['Noofpax'];				
				$SID=$row1['Employee']; 
				$Employeeid=$row1['Employeeid']; 
			}
			?>
            <div class="page-content-wrapper">
                <div class="page-content">                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12">                            
								<div class="card card-topline-purple">														
                                <div class="card-body " id="bar-parent5">
								<form method='post' id="myForm" action="<?php echo scs_index?>kotoutlet/billsave" >
								   <input type="hidden" name="outletid" value="<?php echo $outletid; ?>" id="outletid">
                                    <div class="row"> 
                                        <div class="col-lg-1 col-md-1">										
										</div>										
                                        <div class="col-lg-3 col-md-3">
                                           <div class="form-group row">
                                            <label for="tableno" style="text-align: right" class="col-sm-6 control-label">TableNo</label>
                                            <div class="col-sm-6">
											   <input type="text" class="form-control" id="tableno" readonly value="<?php echo $tablename; ?>"; name="tableno" >
											   <input type="hidden" class="form-control" id="tableid" readonly value="<?php echo $Tableid; ?>"; name="tableid" >
											</div>
                                           </div>                                       
                                        </div>
                                        <div class="col-lg-4 col-md-4 ">
                                           <div class="form-group row">
                                            <label for="pax" style="text-align: right" class="col-sm-6 control-label">Pax</label>
                                            <div class="col-sm-6">
                                              	<input type="number" class="form-control" id="pax" readonly value="<?php echo $Noofpax; ?>" name="pax" >
                                            </div>
                                           </div> 
                                        </div> 
										<div class="col-lg-3 col-md-3 ">
                                           <div class="form-group row">
                                            <label for="steward" style="text-align: right" class="col-sm-6 control-label">Steward</label>
                                            <div class="col-sm-6">
											   <input type="text" class="form-control" id="steward" readonly required value="<?php echo @$SID; ?>" name="steward" >                                               	
											   <input type="hidden" value="<?php echo @$Employeeid; ?>" name="stewardid" id="stewardid">
                                            </div>
                                           </div> 
                                        </div>
										<div class="col-lg-1 col-md-1">										
										</div>																				
										<div class="col-lg-4 col-md-4">
											<div class="form-group row">
                                              <label for="guestname" style="text-align: right" class="col-sm-5 control-label">Guest Name</label>
                                              <div class="col-sm-7">
											   <input type="text" class="form-control" placeholder="Guest Name" id="guestname" value="" name="guestname" > 											   
											  </div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4">
											<div class="form-group row">
                                              <label for="Mobile" style="text-align: right" class="col-sm-5 control-label">Guest Mobile</label>
                                              <div class="col-sm-7">
											   <input type="text" class="form-control" placeholder="Guest Mobile.No"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  id="Mobile" value="" name="Mobile" >  
											  </div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4">
											<div class="form-group row">
                                              <label for="email" style="text-align: right" class="col-sm-3 control-label">E-mail</label>
                                              <div class="col-sm-9">
											   <input type="email" class="form-control" placeholder="E-mail"  id="email" value="" name="email" >  
											  </div>
											</div>
										</div> 
										 <div class="col-lg-12 col-md-12">
											<div class="card-body" id="rw1" style="height:400px;overflow-x: hidden;overflow-y: scroll;">													
												<table style="width:100%;" id="customer" class="table table-striped table-bordered table-hover table-checkable order-column " id="example4">
												  <thead>
													 <tr>
														<th>S.No </th>	
														<th>Item Name </th>
														<th style="text-align:right">Qty </th>
														<th style="text-align:right">Price </th>
														<th style="text-align:right">Total </th>																
													 </tr>
												  </thead>
												  <tbody id="tab_logic1">
														<?php
													  $sql2="select sum(det.Amount) as Amount,sum(det.qty) as qty,det.itemid,det.itemname,det.Rate from Trans_reskot_mas mas
															inner join Trans_reskot_det det on mas.Kotid=det.kotid
															 where mas.Tableid='".$Tableid."' and isnull(mas.Raised,0)=0 and mas.restypeid='".$outletid."' and mas.companyid='".$_SESSION['MPOSCOMPANYID']."'
															 and isnull(det.cANCELORNORM,'')<>'C' and isnull(mas.cancelornorm,'')<>'C'
															 group by det.itemid,det.itemname,det.Rate";
													  $result2 = $this->db->query($sql2); $i=1; $total=0;
													  foreach ($result2->result_array() as $row2) {
														?>
														  <tr class="odd gradeX" id='addr11'>
														    <td><?php echo $i; $i++; ?></td>
															<td><?php echo $row2['itemname'];  ?></td>
															<td style="text-align:right"><?php echo $row2['qty'];  ?></td>
															<td style="text-align:right"><?php echo $row2['Rate'];  ?></td>
															<td style="text-align:right"><?php echo $row2['Amount'];  ?></td>
														  </tr>	
													  <?php 
													  $total=$total+$row2['Amount'];
													  }
													  ?>
													</tbody>
												</table>	
											</div>	
										</div>	
								<?php 
								$sql3="select sum(det.Amount) as Amount,sum(det.qty) as qty,det.itemid,det.itemname,det.Rate,itm.taxsetupid from Trans_reskot_mas mas 
									inner join Trans_reskot_det det on mas.Kotid=det.kotid
									inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
									  where mas.Tableid='".$Tableid."' and isnull(mas.Raised,0)=0 and mas.restypeid='".$outletid."' and mas.companyid='".$_SESSION['MPOSCOMPANYID']."'
									  and isnull(det.cANCELORNORM,'')<>'C' and isnull(mas.cancelornorm,'')<>'C' group by det.itemid,det.itemname,det.Rate,itm.taxsetupid";
								$result3 = $this->db->query($sql3); $totaltax=0;
								foreach ($result3->result_array() as $row3) 
								 {  
									 $sql4="select * from taxsetupmas mas
											 inner join taxsetupdet det on det.taxsetupid=mas.Taxsetupid
											 where mas.Taxsetupid='".$row3['taxsetupid']."'";
									 $result4 = $this->db->query($sql4); $tax=0; $stotal=0;
									 foreach ($result4->result_array() as $row4) 
									 {
										$tax=($row3['Amount']*$row4['percentage'])/100;
										$stotal=$stotal+$tax;
									 }
									  $totaltax=$totaltax + $stotal	; 									 
								 }
								
								
								?>
								<table style="width:100%;">
								<tr>
								<td style="text-align: right;">Discount :</td>
								<td><input type="text" placeholder="" value="0" class="form-control cgrt"  style="text-align:center;" name="disc" id="disc" readonly /> </td>
								<td style="text-align: right;">Tax Amt :</td>
								<td><input type="text" placeholder="" value="<?php echo $totaltax; ?>" class="form-control cgrt"  style="text-align:center;" name="taxes" id="taxes" readonly /> </td>
								<td style="text-align: right;">Grand Total :</td>
								<td ><input type="text" placeholder="" value="<?php echo $total+$totaltax; ?>" class="form-control cgrt"  style="text-align:center;" name="totalamount" id="totalamt" readonly /> 	</td>
								</tr>
								</table>											
										<br/>										
                                    </div>	
									       <center>											
											<!----button type="submit"  name="btn-printno" id="printidft"   class="btn btn-primary">F4-(Print)</button--->
											<button type="button"  name="btn-clear" class="btn btn-primary">Auto Split</button>											
											<button type="button" onclick="popupopen(this.value,<?php echo $Tableid; ?>)" Value="Discount" name="btn-clear"  class="btn btn-primary">Discount</button>
											<button type="submit"  name="btn-submit"  id="placedhd"  class="btn btn-primary">F2-(Save)</button>
											<input type="hidden" name="rowcount" id="rowcount" value='0'>											
											<!--button type="button" onclick="saveandsettlement(<?php echo $Tableid; ?>)" Value="" name="btn-clear"  class="btn btn-primary">Save & Settlement</button-->
										    <button type="button" onclick="fnexit()" name="btn-clear"  class="btn btn-primary">Exit</button>
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
		<!-- The Modal -->
			<div id="myModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
				<div class="modal-header">				  
				  <span id="Tableid"></span><span class="close">&times;</span>
				</div>
				<div class="modal-body">
				  <div id="kotdetails">
				</div>			   
				</div>			   
			  </div>
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
function popupopen(obj,obj1)
{   var outletid=<?php echo $outletid; ?>;
    $.ajax({
          type: 'POST',
          url: '<?php echo scs_index?>/kotoutlet/getdiscountdetails',  //GET ITEM Price any url
          data: {label: obj,outletid : outletid,tableid : obj1},
          success: function(message) { 
		// alert(message);
			$('#kotdetails').html(message);		  
		  },
         // dataType: 'json'
       }); 
  
  modal.style.display = "block";
  $('#Tableid').html(obj);  
 // $('#kotidtable').val(obj);
}
// Get the modal
var modal = document.getElementById("myModal");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function editkot(obj,obj1)
{
	var outletid=<?php echo $outletid; ?>;
	window.location.href = '<?php echo scs_index ?>kotoutlet/Editordeletekot/'+obj+'/'+obj1+'/'+outletid; 
}

  function apply() {
     $("#Discountform").on('submit', function (e) {
      e.preventDefault();
      $.ajax({
         type: 'get',
         url: "<?php echo scs_index?>kotoutlet/discountapply",
         data: $('#Discountform').serialize(),
         success: function (result) {
             // alert(result);
			   var data = result.split('-');			   
			   document.getElementById('disc').value = data[0];	
			   document.getElementById('taxes').value = data[1];	
			   var rate= <?php echo $total; ?>;
			   var gtotal= ((rate*1) + (data[1]*1)) - (data[0]*1); 
			   document.getElementById('totalamt').value = gtotal;	
		/*	$.ajax({url:"<?php echo scs_index ?>table/billtotalwithdiscount?Tableid="+Tableid+"&dis=Yes", type: "POST",dataType: "html",success:function(result){
				$("#billtotal").html(result);				
						}
			  });	*/
            }
          });
		 modal.style.display = "none";
        });
      }
  
	function clears()
	{ 
		location.reload(); 
	}
	function fnexit()
	{
		window.location.href = '<?php echo scs_index?>kotoutlet/tablelist/<?php echo $outletid; ?>'; 
	}
	function saveandsettlement(a)
	{
		window.location.href = '<?php echo scs_index ?>kotoutlet/billsaveandsettlement/<?php echo $outletid; ?>/<?php echo $Tableid; ?>/<?php echo $Noofpax; ?>/<?php echo $Employeeid; ?>'; 
	}
	
	</script>
</html>