<?php 
include_once 'db.php';
include_once 'header.php';
session_start(); 
 if(@$_SESSION['MPOSUSERNAME']=='')
   {
	 echo '<script>window.location="index.php";	</script>';
   } 
?>
<!-- END HEAD -->
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <div class="page-wrapper">
        <!-- start header -->
		<?php include_once 'head.php';	?>
        <!-- end header -->
        <!-- start page container -->
        <div class="page-container">
 			<!-- start sidebar menu -->
 		<?php 	include_once 'sidebar.php';		?>
			 <!-- end sidebar menu -->
			<!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Tax Setup</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Tax Setup</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Tax Setup</header>
                                    
                                </div>
                                <div class="card-body ">
								<form method="POST" action="" >
                                    <div class="row p-b-20">									 
                                        <div class="col-md-12 col-sm-12 col-12">
										 <div class="col-lg-6 p-t-20"> 
											<div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<input class = "mdl-textfield__input" value='' type = "text" name="taxsetupname" id = "taxsetupname" required/>
											<label class = "mdl-textfield__label">Tax Setup Name</label>
											</div>
										</div>  
										</div>
										<div class="col-md-12 col-sm-12 col-12">
										<table id="customer" class="table table-striped table-bordered table-hover table-checkable order-column full-width" id="example4">
														<thead>
															<tr>
															    <th>#</th>
																<th>Tax Type</th>
																<th>Tax %</th>
																<th>Applicable On</th>																
																<th>Actions</th>
															</tr>
														</thead>
														<tbody id="tab_logic1">														
														<tr class="odd gradeX" id="addr1<?php echo $i=1; ?>">
														  <td style="width:10%"><?php echo $i; ?></td>
														  <td style="width:30%"> 
														      <select id='accounthead<?php echo $i; ?>' name='accounthead[]' value="0" class="form-control select2" required>                                                  
																   <option value="0" selected disabled >Select Tax Type</option>   
																 <?php
																	$sql="select* from Taxtype where companyid='".$_SESSION['MPOSCOMPANYID']."'";
																	$result = odbc_exec($dbhandle, $sql);
																	while ($row = odbc_fetch_array($result))
																	{
																 ?>	
																	<option value="<?php echo $row['taxid']; ?>" ><?php echo $row['taxtype']; ?></option>   
																<?php 
																    }
																	?>
															   </select>
														  </td>
														  <td style="width:20%"><input name='taxamount[]' id='taxamount<?php echo $i; ?>'  type='text' placeholder='' required  value=" " class='form-control input-md item1 clrt<?php echo $i; ?>'></td>
														  <td style="width:20%">
														        <select name='multiple<?php echo $i; ?>[]' id='multiple<?php echo $i; ?>' class="form-control select2-multiple" multiple>                                                  
																	<option value="1" selected >ITEM TOTAL</option> 
																   <?php
																	$sql="select* from Taxtype where companyid='".$_SESSION['MPOSCOMPANYID']."'";
																	$result = odbc_exec($dbhandle, $sql);
																	while ($row = odbc_fetch_array($result))
																	{
																   ?>	
																	<option value="<?php echo $row['taxid']; ?>" ><?php echo $row['taxtype']; ?></option>   
																  <?php 
																    }
																	?>
																</select>
														  </td>														
														  <td style="width:20%" class='valigntop'> 
															<button type='button' onclick="addField()" class="btn btn-success btn-xs">  <i class="fa fa-plus"></i>  </button>
                                                            <button type='button'  onclick='deletes(<?php echo $i; ?>)' class="btn btn-danger btn-xs">   <i class="fa fa-trash-o "></i>  </button>	</td>
														</tr>														
														</tbody>
													</table>  
													<input type="hidden" name="rowcount" id="rowcount" value='1'>	
										   </div>	
											   <div class="col-lg-12 p-t-20 text-center"> 
						                  	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
										
											</div>									
                                    </div>    
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
      <?php   include_once 'footer.php';	  ?>
        <!-- end footer -->
    </div>
	<script>
	 function addField()
	  {    
	  var i = document.getElementById('customer').getElementsByTagName("tr").length;
	  var rs = i - 1;
	  var pr = document.getElementById('taxamount'+rs).value;
	  if(pr == 0)
		{
			alert("fff");
		}
		else
		{
			var markup = "<tr class='odd gradeX' id='addr1"+i+"'><td>"+i+"</td> <td style='width:30%'> <select id='accounthead"+i+"' name='accounthead[]' class='form-control select2' ><option value='' selected disabled >Select Tax Type</option> <?php  $sql='select* from Taxtype where companyid='.$_SESSION['MPOSCOMPANYID']; $result = odbc_exec($dbhandle, $sql);	while ($row = odbc_fetch_array($result)) { ?> <option value='<?php echo $row['taxid']; ?>' ><?php echo $row['taxtype']; ?></option>  <?php }?> </select></td><td style='width:20%'><input name='taxamount[]' id='taxamount"+i+"'  type='text' placeholder=''  value='' required class='form-control input-md item1 clrt"+i+"'></td><td style='width:20%'> <select id='multiple"+i+"' name='multiple"+i+"[]' class='form-control select2-multiple' multiple> <option value='1' selected >ITEM TOTAL</option> <?php $sql='select* from Taxtype where companyid='.$_SESSION['MPOSCOMPANYID'];		$result = odbc_exec($dbhandle, $sql);	while ($row = odbc_fetch_array($result)){?> <option value='<?php echo $row['taxid']; ?>' ><?php echo $row['taxtype']; ?></option>    <?php } ?></select></td> <td style='width:20%' class='valigntop'> <button type='button' onclick='addField()' class='btn btn-success btn-xs'>  <i class='fa fa-plus'></i>  </button>    <button type='button'  onclick='deletes("+i+")' class='btn btn-danger btn-xs'>   <i class='fa fa-trash-o '></i>  </button>	</td>	</tr>";
		   $("#customer").append(markup);	
			$('#multiple'+i).select2();   
			$('#accounthead'+i).select2();   
		}	
		var boxes = document.getElementsByName("accounthead[]");
		$('#rowcount').val(boxes.length);		
	  }
	 function deletes(obj)
	 {
	  //alert(obj);
	  $('#accounthead'+obj).val('');
	  $('#multiple'+obj).val('');
	  $('#taxamount'+obj).val('-');
	  $('#addr1'+obj).css('display','none');	  
	//  $("#placedhd").attr("disabled", true);
	//   $("#printidft").attr("disabled", true);
   //	reveslqty(obj);  
	var boxes = document.getElementsByName("accounthead[]");
		$('#rowcount').val(boxes.length);		  
	}
	</script>
	<?php
	
	if(isset($_POST['taxsetupname']))
	 {  
		$ins="insert into Taxsetupmas (taxsetupname,Companyid)
				values('".$_POST['taxsetupname']."','".$_SESSION['MPOSCOMPANYID']."')";
	 	$result = odbc_exec($dbhandle, $ins);
		 $k=1;
		for($j=0; $j<$_POST['rowcount']; $j++) 
		{		
		 $ins1="insert into Taxsetupdet(taxsetupid,Accid,percentage)
				values( IDENT_CURRENT('taxsetupmas'),'".$_POST['accounthead'][$j]."','".$_POST['taxamount'][$j]."')";		
			$ins3='';
		    foreach ($_POST['multiple'.$k] as $selectedOption)
			{				
			$ins3.="insert into taxsetupACdet(taxsetupdetid,Accid,selected)
					values(@Siden,'".$selectedOption."','1')";
			}
		$k++;
			ob_start();
			echo "BEGIN Try ";
			echo "BEGIN Transaction ";
			echo "BEGIN Tran ";
			echo $ins1;
			echo "Declare @Siden INT; ";
			echo "set @Siden=@@identity; ";			
			echo $ins3;
			echo " If @@error<>0 Rollback Tran else Commit Tran ";
			echo "COMMIT ";
			echo "end try ";
			echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
			echo "END CATCH ";
			$sqc = ob_get_clean();
			echo $sq = "".$sqc."";
			$result = odbc_exec($dbhandle, $sq);		
			
			odbc_close($dbhandle);
		}
	
		 ?>
        <script>
				swal({
				title: 'Tax Setup add Successfully...!',
				text: 'Redirecting...',
				icon: 'success',
				timer: 2000,
				buttons: false,
				})
				.then(() => {
				   window.location.href = 'tax_setup.php'; 
				})
		 </script>	<?php	
	 }

	 ?>
    <!-- start js include path -->
    <script src="assets/plugins/jquery/jquery.min.js" ></script>
    <script src="assets/plugins/popper/popper.min.js" ></script>
    <script src="assets/plugins/jquery-blockui/jquery.blockui.min.js" ></script>
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" ></script>
    <!-- Common js-->
	<script src="assets/js/app.js" ></script>
    <script src="assets/js/layout.js" ></script>
	<script src="assets/js/theme-color.js" ></script>
	<!-- data tables -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js" ></script>
 	<script src="assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js" ></script>
 	<script src="assets/js/pages/table/table_data.js" ></script>
	<!-- Material -->
	<script src="assets/plugins/material/material.min.js"></script>
	<!-- animation -->
	<script src="assets/js/pages/ui/animations.js" ></script>
    <!-- end js include path -->
	    <!--select2-->
    <script src="assets/plugins/select2/js/select2.js" ></script>
    <script src="assets/js/pages/select2/select2-init.js" ></script>
</body>
</html>