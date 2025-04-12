<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pcss->hjs();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,@$F_Ctrl,@$F_Class);
?>
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <div class="page-wrapper">
        <div class="page-content-wrapper">

			<?php 
			$Noofpax=1; $runningkot=0;
			$sql1="select * from  tablemas where Tableid='".@$Tableid."'";
			$result1 = $this->db->query($sql1);
			foreach ($result1->result_array() as $row1) {
			$tablename=$row1['Tablename'];
			if($row1['Status']=='K')
			{   $Noofpax=$row1['Noofpax'];
				$sql="select * from Employee where Employeeid='".$row1['SID']."'";
				$result = $this->db->query($sql);
				foreach($result->result_array() as $row) {  $SID=$row['Employee'];  }
				$runningkot=1;
			}
			}
			?>
            <div class="page-content-wrapper">
                <div class="page-content">                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12 mt-2">
                            <div class="card card-box">                               
                                <div class="card-body " id="bar-parent5">
								<form method='post' id="myForm" action="<?php echo scs_index ?>/kotoutlet/kotsave" >
								   <input type="hidden" name="outletid" value="<?php echo $Outletid; ?>" id="outletid">
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
														  <tr class="odd gradeX" id='addr11'></tr>																																													
														</tbody>
													</table>					
											</div>	
								<table style="width:100%;">
								<tr>								
								<td style="width: 200px;text-align: right;">Total : </td>
								<td style="width: 100px;"><input type="text" placeholder="" value="0" class="form-control cgrt"  style="text-align:center;" name="totalamount" id="totalamt" readonly /> 								
								</td>
								</tr>
								</table>											
										<br/>										
                                    </div>	
									       <center>
											<button type="button"  name="btn-submit" onclick="placekot();" id="placedhd" class="btn btn-primary">F2-(Place KOT)</button>
											<!----button type="submit"  name="btn-printno" id="printidft"   class="btn btn-primary">F4-(Print)</button--->
											<button type="button"  name="btn-clear" onclick="clears();"  class="btn btn-primary">Clear</button>											
											<input type="hidden" name="rowcount" id="rowcount" value='0'>
											<?php
                                            if($runningkot==1)
											{ ?>
											  <button type="button" onclick="popupopen(this.value,<?php echo $Tableid; ?>)" Value="Edit" name="btn-clear"  class="btn btn-primary">KOT Edit</button>
											  <button type="button" onclick="popupopen(this.value,<?php echo $Tableid; ?>)" Value="Delete" name="btn-clear"  class="btn btn-primary">KOT Delete</button>
										    <?php }
											?>
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
				  KOT : <span id="Tableid"></span><span class="close">&times;</span>
				</div>
				<div class="modal-body">
				  <div class="table-scrollable">
                     <table class="table table-hover table-checkable order-column full-width" id="example4">
					  <thead id="kotdetails">                        
                      </thead>
					 </table>
				</div>			   
				</div>			   
			  </div>
			</div>
        <!-- end page container -->
        <!-- start footer -->
    </div>
	


<?php
$this->pweb->wfoot1($this->Menu,$this->session);	
$this->pcss->wjs();
?>

<script>
function popupopen(obj,obj1)
{   var outletid=<?php echo $Outletid; ?>;
    $.ajax({
          type: 'POST',
          url: '<?php echo scs_index ?>kotoutlet/getrunningkotdetails',  //GET ITEM Price any url
          data: {label: obj,outletid : outletid,tableid : obj1},
          success: function(message) { 
		// alert(message);
			$('#kotdetails').html(message);		  
		  },
          dataType: 'json'
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
	var outletid=<?php echo $Outletid; ?>;
	window.location.href = '<?php echo scs_index?>kotoutlet/editordeletekot/'+obj+'/'+obj1+'/'+outletid; 
}

$(document).ready(function(){
	
	  for (var i = 1; i < 11; i++) {	 
     $('#addr1'+i).html("<td style='width:10%'> "+i+"</td><td style='width:10%'><input name='itemcode[]' id='itemcode"+i+"' onblur='onitemcode("+i+")' type='text' placeholder='' class='form-control input-md ctrtss"+i+"'></td><td style='width:40%'><input name='itemname[]' id='"+i+"'  type='text' placeholder=''  class='form-control input-md item1 clrt"+i+"'><input type='hidden' name='taxtypeid[]' id='taxtypeid"+i+"'><input type='hidden' name='itemid[]' id='itemid"+i+"'></td><td style='width:10%'><input name='itemqty[]' id='itemqty"+i+"' onblur='itemqty("+i+")'; style='width: 60px;'  type='number' placeholder=''  class='form-control input-md'></td><td style='width:10%'><input name='itemprice[]' id='itemprice"+i+"' style='text-align:right;' type='text' placeholder=''  class='form-control input-md' readonly></td><td style='width:10%'><input name='subprice[]' id='subprice"+i+"' style='text-align:right;' type='text' value='0.00' placeholder=''  class='form-control input-md amtBal' readonly></td><td style='width:10%' class='valigntop'> <button onclick='addField();' type='button' class='addField btn btn-success btn-xs'> <i  class='fa fa-check'></i>   </button></td>");

     $('#tab_logic1').append('<tr class="odd gradeX" id="addr1'+(i+1)+'"></tr>');
	  }
      $(".item1").autocomplete({
      source: "<?php echo scs_index ?>kotoutlet/itemsearch?outletid=<?php echo $Outletid; ?>",
	  select: function (event, ui, i) {
	  //alert(jQuery(this).attr('id'));
	  	 var idj = $(this).attr('id'); ////ROW ID
         var selectedObj = ui.item.label;   /// ITEM NAME
		 setprice(idj,selectedObj);	  ///NEXT FUNCTION MOVE	 
        }
    });
	$( "#steward" ).autocomplete({
      source: "<?php echo scs_index ?>kotoutlet/stwlist/<?php echo $Outletid; ?>",
	  select: function (event, ui, i) {
	    var selectedObj = ui.item.label; 
        $('#itemcode1').focus();		  
        }
    });
	
	$("#placedhd").attr("disabled", true); 
	  
  } );
  
    function setprice(obj,obj2)
	{    var outletid=<?php echo $Outletid; ?>;
		 $.ajax({
          type: 'POST',
          url: '<?php echo scs_index ?>kotoutlet/itemprice',  //GET ITEM Price any url
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
		 $("#placedhd").attr("disabled", false); 		 				
		
		var boxes = document.getElementsByName("itemqty[]");
		$('#rowcount').val(boxes.length);
        totTt=0;		
         $(".amtBal").each(function(){
		totTt +=parseFloat($(this).val());	    });	
		$('#totalamt').val(parseFloat(totTt).toFixed(2));	 		
		
	   }
	}
	function onitemcode(obj)
	{
	  var itemcode = $('#itemcode'+obj).val();	  
	   var outletid=<?php echo $Outletid; ?>;
		 $.ajax({
          type: 'POST',
          url: '<?php echo scs_index ?>kotoutlet/itemcode',  //GET ITEM Price any url
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
	function clears()
	{
		location.reload(); 
	}
	function fnexit()
	{
		window.location.href = '<?php echo scs_index ?>Kotoutlet/Tablelist/<?php echo $Outletid; ?>'; 
	}

	const placekot = () =>{

		$.ajax({
          type: 'POST',
          url: '<?php echo scs_index ?>kotoutlet/kotsave',  //GET ITEM Price any url
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
					   window.location.href = '<?php echo scs_index?>kotoutlet/Tablelist/<?php echo $Outletid; ?>'; 
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
				   window.location.href = '<?php echo scs_index?>kotoutlet/Tablelist/<?php echo $Outletid; ?>'; 
				})
			}
		  }
		});
	}
	
	</script>
</html>