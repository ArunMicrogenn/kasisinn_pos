<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pcss->hjs();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
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
			  $sql="select * from Trans_reskot_mas mas
				inner join Tablemas tb on tb.Tableid=mas.tableid
				left join Employee em on em.Employeeid=mas.Stwid
				 where mas.Kotid='".$Kotid."' ";
		    $result = $this->db->query($sql);
			foreach($result->result_array() as $row)
			{ 
				$Amount=$row['totalamount'];
			 echo $tablename=$row['Tablename'];
			  $Tableid=$row['Tableid'];
			  $Noofpax=$row['noofpax'];
			  $SID=$row['Employee'];			  }
			?>
            <div class="page-content-wrapper">
                <div class="page-content">                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">                               
                                <div class="card-body " id="bar-parent5">
								<form method='post' id="myForm" action="" >
								   <input type="hidden" name="outletid" value="<?php echo $Restypeid; ?>" id="outletid">
								   <input type="hidden" name="kotid" value="<?php echo $Kotid; ?>" id="kotid">
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
                                            <label for="pax" class="col-sm-4 control-label">Pax</label>
                                            <div class="col-sm-8">
                                              	<input type="number" class="form-control" id="pax"  value="<?php echo $Noofpax; ?>" name="pax" >
                                            </div>
                                           </div> 
                                        </div> 
										<div class="col-lg-4 col-md-4 ">
                                           <div class="form-group row">
                                            <label for="steward" class="col-sm-4 control-label">Steward</label>
                                            <div class="col-sm-8">
											   <input type="text" class="form-control" id="steward" required value="<?php echo @$SID; ?>" name="steward" >                                               	
                                            </div>
                                           </div> 
                                        </div> 
											<div class="card-body" id="rw1" style="height:400px;overflow-x: hidden;overflow-y: scroll;">													
													<table id="customer" class="table table-striped table-bordered table-hover table-checkable order-column full-width" id="example4">
														<thead>
															<tr>
																<th> S.No </th>
																<th> Code </th>
																<th> Item Name </th>
																<th> Qty </th>
																<th> Price </th>
																<th> Sub Total </th>
																<th> Actions </th>
															</tr>
														</thead>
														<tbody id="tab_logic1">
														<?php  $i=1;
                                                        
														 $sql="select * from Trans_Reskot_det det
														Inner join itemmas itm on itm.itemdetid=det.itemid
														where det.kotid='".$Kotid."' and isnull(det.cANCELORNORM,'')<>'C' and isnull(det.restypeid,0)='".$Restypeid."' and isnull(itm.restypeid,0)='".$Restypeid."'";
														$result = $this->db->query($sql); $dtotal=0;
														foreach($result->result_array() as $row)
														{   
														?>
														<tr class="odd gradeX" id="addr1<?php echo $i; ?>">
														  <td style="width:10%"><?php echo $i; ?></td>
														  <td style="width:10%"><input name='itemcode[]' id='itemcode<?php echo $i; ?>' onblur='onitemcode("<?php echo $i; ?>")' type='text' placeholder='' value="<?php echo $row['ItemCode']; ?>" class='form-control input-md ctrtss<?php echo $i; ?>'></td>
														  <td style="width:40%"><input name='itemname[]' id='<?php echo $i; ?>'  type='text' placeholder=''  value="<?php echo $row['Itemname']; ?>" class='form-control input-md item1 clrt<?php echo $i; ?>'><input type='hidden' value="<?php echo $row['taxsetupid']; ?>" name='taxtypeid[]' id='taxtypeid<?php echo $i; ?>'><input type='hidden' value="<?php echo $row['itemid']; ?>" name='itemid[]' id='itemid<?php echo $i; ?>'></td>
														  <td style="width:10%"><input name='itemqty[]' id='itemqty<?php echo $i; ?>' onblur='itemqty(<?php echo $i; ?>)'; style='width: 60px;' value="<?php echo $row['qty']; ?>"  type='number' placeholder=''  class='form-control input-md'></td>
														  <td style="width:10%"><input name='itemprice[]' id='itemprice<?php echo $i; ?>' style='text-align:right;' value="<?php echo $row['Rate'] ?>" type='text' placeholder=''  class='form-control input-md' readonly></td>
														  <td style="width:10%"><input name='subprice[]' id='subprice<?php echo $i; ?>' style='text-align:right;' value="<?php echo $row['Amount'] ?>" type='text' placeholder=''  class='form-control input-md amtBal' readonly></td>
														  <td style="width:10%" class='valigntop'> <button type='button' onclick="addField();" class="btn btn-success btn-xs">  <i class="fa fa-check"></i>  </button>
                                                            <button <?php if($Lable=='Delete'){ echo 'disabled';} ?> type='button'  onclick='deletes(<?php echo $i; ?>)' class="btn btn-danger btn-xs">   <i class="fa fa-trash-o "></i>  </button>	</td>
														</tr>
														<?php
															$i++; 	
															$dtotal=$dtotal+ $row['Amount'];
														} ?>
														</tbody>
													</table>					
											</div>	
								<table style="width:100%;">
								<tr>								
								<td style="width: 200px;text-align: right;">Total : </td>
								<td style="width: 100px;"><input type="text" placeholder="" value="<?php echo $dtotal ?>" class="form-control cgrt"  style="text-align:center;" name="totalamount" id="totalamt" readonly /> 								
								</td>
								</tr>
								</table>											
										<br/>										
                                    </div>	<?php if($Lable=='Delete') {$caption="Delete KOT";} else {$caption="Update KOT";} ?>
									       <center>
											<button type="button"  name="btn-submit"  id="placedhd" onclick="placekot();" class="btn btn-primary">F2-(<?php echo $caption; ?>)</button>
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
<?php
$this->pweb->wfoot1($this->Menu,$this->session);	
$this->pcss->wjs();
?>
<script>

  function addField()
  {   
    
//  var l = $('#rowcount').val();

  var i = document.getElementById('customer').getElementsByTagName("tr").length;
  var rs = i - 1;
  var pr = document.getElementById(rs).value;
  if(pr == 0)
	{
		
	}
    else
	{
		var markup = "<tr class='odd gradeX' id='addr1"+i+"'><td>"+i+"</td><td><input name='itemcode[]' id='itemcode"+i+"' onblur='onitemcode("+i+")' type='text' placeholder='' value='' class='form-control input-md ctrtss"+i+"'></td> <td><input name='itemname[]' id='"+i+"'  type='text' placeholder=''  value='' class='form-control input-md item1 clrt"+i+"'><input type='hidden' value='' name='taxtypeid[]' id='taxtypeid"+i+"'><input type='hidden' value='' name='itemid[]' id='itemid"+i+"'></td> <td><input name='itemqty[]' id='itemqty"+i+"' onblur='itemqty("+i+")'; style='width: 60px;' value=''  type='number' placeholder=''  class='form-control input-md'></td> <td><input name='itemprice[]' id='itemprice"+i+"' style='text-align:right;' value='' type='text' placeholder=''  class='form-control input-md' readonly></td><td><input name='subprice[]' id='subprice"+i+"' style='text-align:right;' value='' type='text' placeholder=''  class='form-control input-md amtBal' readonly></td><td class='valigntop'> <button type='button' onclick='addField()' class='btn btn-success btn-xs'>  <i class='fa fa-check'></i></button>  <button  type='button'  onclick='deletes("+i+")' class='btn btn-danger btn-xs'>   <i class='fa fa-trash-o '></i>  </button>	</td></tr>";
	   $("#customer").append(markup);
	   $( ".item1" ).autocomplete({
      source: "<?php echo scs_index?>kotoutlet/itemsearch?outletid=<?php echo $Restypeid; ?>",
	  select: function (event, ui, i) {
	  //alert(jQuery(this).attr('id'));
	  	 var idj = jQuery(this).attr('id'); ////ROW ID
         var selectedObj = ui.item.label;   /// ITEM NAME
		 setprice(idj,selectedObj);	  ///NEXT FUNCTION MOVE	 
        }
    });
	}	
	
  }
jQuery(document).ready(function(){	
      $( ".item1" ).autocomplete({
      source: "<?php echo scs_index?>kotoutlet/itemsearch?outletid=<?php echo $Restypeid; ?>",
	  select: function (event, ui, i) {
	  //alert(jQuery(this).attr('id'));
	  	 var idj = jQuery(this).attr('id'); ////ROW ID
         var selectedObj = ui.item.label;   /// ITEM NAME
		 setprice(idj,selectedObj);	  ///NEXT FUNCTION MOVE	 
        }
    });
	$( "#steward" ).autocomplete({
      source: "<?php echo scs_index?>kotoutlet/stwlist?outletid=<?php echo $Restypeid; ?>",
	  select: function (event, ui, i) {
	    var selectedObj = ui.item.label; 
        $('#itemcode1').focus();		  
        }
    });
	var label='<?php echo $Lable; ?>';
	if(label=='Delete')
	{
		jQuery("#placedhd").attr("disabled", false); 		
	}
	else
	{
		jQuery("#placedhd").attr("disabled", true); 
	}
	var boxes = document.getElementsByName("itemqty[]");
	$('#rowcount').val(boxes.length);	
	  
  } );
  

  function deletes(obj)
  {
	  //alert(obj);
	  $('#'+obj).val('');
	  $('#itemid'+obj).val('');
	  $('#subprice'+obj).val('0.00');
	  $('#addr1'+obj).css('display','none');
	   jQuery("#placedhd").attr("disabled", false); 
	   	var totTt=0
		 $(".amtBal").each(function(){
		totTt +=parseFloat($(this).val());	    });					
		$('#totalamt').val(parseFloat(totTt).toFixed(2));
	//  $("#placedhd").attr("disabled", true);
	//   $("#printidft").attr("disabled", true);
//	reveslqty(obj);  
	var boxes = document.getElementsByName("itemqty[]");
		$('#rowcount').val(boxes.length);	
	  
  }
    function setprice(obj,obj2)
	{    var outletid=<?php echo $Restypeid ?>;
		 $.ajax({
          type: 'POST',
          url: '<?php echo scs_index?>kotoutlet/itemprice',  //GET ITEM Price any url
          data: {label: obj2,outletid : outletid},
          success: function(message) { 
		  //alert(message);
		  $('#itemprice'+obj).val(message[0]);	
	      $('#itemcode'+obj).val(message[1]);
		  $('#taxtypeid'+obj).val(message[2]);				  
		  $('#itemid'+obj).val(message[3]);				  
		  },
          dataType: 'json'
       }); 
	   
	  document.getElementById(obj).readOnly = true;
	  document.getElementById('itemcode'+obj).readOnly = true;

	}	
	function itemqty(obj)
	{
	   var amt = $('#itemprice'+obj).val();
	   var qty = $('#itemqty'+obj).val();
	   if(qty == '')  
	   {  alert("Please Enter Qty"); 
		//  $('#itemcode'+obj).focus();
       }
	   else
	   { var subtotal = parseFloat(amt) * parseFloat(qty); 
		 $('#subprice'+obj).val(parseFloat(subtotal).toFixed(2));		
		 jQuery("#placedhd").attr("disabled", false); 
		
		var totTt=0
		 $(".amtBal").each(function(){
		totTt +=parseFloat($(this).val());	    });					
		$('#totalamt').val(parseFloat(totTt).toFixed(2));
		
		var boxes = document.getElementsByName("itemqty[]");
		$('#rowcount').val(boxes.length);	 		
	   }
	}
	function onitemcode(obj)
	{
	  var itemcode = $('#itemcode'+obj).val();	  
	   var outletid=<?php echo $Restypeid; ?>;
		 $.ajax({
          type: 'POST',
          url: '<?php echo scs_index?>kotoutlet/itemcode',  //GET ITEM Price any url
          data: {label: itemcode,outletid : outletid},
          success: function(message) { 	
		  if(message =='')
		  {
			 $('.clrt'+obj).focus();
			 $("#placedhd").attr("disabled", true);
		  }
	      else
		  {
			  $('#itemprice'+obj).val(message[0]);	
			  $('#taxtypeid'+obj).val(message[1]);				  
			  $('#itemid'+obj).val(message[2]);
			  $('.clrt'+obj).val(message[3]);
			  $('#itemqty'+obj).focus();
			  document.getElementById(obj).readOnly = true;
 		  }		  
		  },
          dataType: 'json'
       }); 
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
		window.location.href = '<?php echo scs_index?>kotoutlet/tablelist?outletid=<?php echo $Restypeid; ?>'; 
	}

    const placekot = () =>{

        $.ajax({
        type: 'POST',
        url: '<?php echo scs_index ?>/kotoutlet/savekot<?php echo $Lable; ?>',  //GET ITEM Price any url
        data: $("#myForm").serialize(),
        success: function(message) { 	
            if(message == 'success'){
                swal({
                        title: 'KOT Added Successfully...!',
                        text: 'Redirecting...',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                        })
                        .then(() => {
                        window.location.href = '<?php echo scs_index?>/kotoutlet/tablelist?outletid=<?php echo $Restypeid; ?>'; 
                        });
            }else{
                swal({
                title: 'KOT Added failed...!',
                text: 'Redirecting...',
                icon: 'success',
                timer: 2000,
                buttons: false,
                })
                .then(() => {
              		 window.location.href = '<?php echo scs_index?>/kotoutlet/tablelist?outletid=<?php echo $Restypeid; ?>'; 
                })
            }
        }
        });
        }
	
	</script>
</html>