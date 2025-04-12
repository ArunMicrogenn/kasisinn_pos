<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->css();
$this->pweb->ptop();
$this->pcss->hjs();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu,$this->session,@$F_Ctrl,@$F_Class);
?>
<!-- END HEAD -->

<body
	class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
	<div class="page-wrapper">
		<div class="page-content-wrapper">
			<?php
			$sql = "SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid=" . $_SESSION['MPOSCOMPANYID'];
			$result = $this->db->query($sql);
			$no = $result->num_rows();

			$sql2 = "SELECT * FROM session WHERE restypeid='".$ID."'  and companyid=".$_SESSION['MPOSCOMPANYID'];
			$result2 = $this->db->query($sql2);
			$no2 = $result2->num_rows();
			if ($no2 == 0) { ?>
				<script>
					swal("There is No Session in this timeing..!", "Kindly Add the Session on this timeing..", "warning")
						.then(() => {
							window.location.href = 'sessions.php';
						});		
				</script>
			<?php
			}

			$sql1 = "select * from headings where isnull(Enablepreviousdaykotbilling,0)=1 and id='".$ID."'  and companyid=".$_SESSION['MPOSCOMPANYID'];
			$result1 = $this->db->query($sql1);
			$lastaudit = $result1->num_rows();
			if ($lastaudit == '0') {

				if ($no == 0) { ?>
					<script>
						swal("Kindly to Do Day End Process..!", "Accounts Date and System date Mismatch..", "warning")
							.then(() => {
								window.location.href = '<?php echo scs_index ?>Date_end_process';
							});		
					</script>
				<?php }
			}
			?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<marquee style="color: red;">
						<?php if ($no == '0') {
							echo "Sales will be added on Last Account Date...";
						} ?>
					</marquee>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-body " id="bar-parent5">
									<div class="row">
										<div class="col-lg-4 col-md-4 ">
											<div class="form-group row">
												<label for="tableno" class="col-sm-5 control-label">Enter Table
													No</label>
												<div class="col-sm-7">
													<form id="tblst" method="post" action="#">
														<input type="text" class="form-control" id="tableno"
															name="tableno" placeholder="Enter Table No">
													</form>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 ">
											<div class="form-group row">
												<label for="outlet" class="col-sm-3 control-label">Outlet</label>
												<div class="col-sm-9">
													<select class="form-control" id="outlet" name="outlet"
														onchange="sltoutlet(this.value);">
														<?php
														echo $sql = "select * from headings where companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and isnull(isvisible,0)=1";
														$result = $this->db->query($sql);
														foreach ($result->result_array() as $row) {
															?>
															<option value="<?php echo $row['id']; ?>"><?php echo $row['Name']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4">
											<label><i class="fa fa-star" style="color:green"></i>Vacant</label>
											<label><i class="fa fa-star" style="color:red"></i>Occupied</label>
											<label><i class="fa fa-star" style="color:orange"></i>Billed</label>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<?php
											$sql1 = "select * from  tablemas where companyid ='".$_SESSION['MPOSCOMPANYID']."' and restypeid='".$ID."' order by Tablename";
											$result1 = $this->db->query($sql1);
											foreach ($result1->result_array() as $row1) {
												if ($row1['Status'] == 'S') {
													$color = "bg-success1";
													?>

													<a href="<?php echo scs_index ?>KotOutlet/Cat/<?php echo $row1['Tableid']; ?>/<?php echo $ID; ?>">
														<div class="boxsize" style="color: white;background-color:Green">
															<span class="info-box-icon push-bottom">
																<?php echo $row1['Tablename']; ?>
															</span>
															<div> &nbsp; </div>
														</div>
													</a>

												<?php
												}
												if ($row1['Status'] == 'K') {
													$color = "bg-purple";
													$pax = $row1['Noofpax'];
													$amt = "-";
													$Stw = "-";
													$sql2 = "select * from Employee where Employeeid='" . $row1['SID'] . "'";
													$result2 = $this->db->query($sql2);
													foreach ($result2->result_array() as $row2) {
														$Stw = $row2['Employee'];
													}
													 $sql3 = "select sum(totalamount)as totalamount from Trans_reskot_mas where tableid='" . $row1['Tableid'] . "' and cancelornorm='N' and ISNULL(Raised,0)=0";
													$result3 = $this->db->query($sql3);
													foreach ($result3->result_array() as $row3) {
														$amt = $row3['totalamount'];
													}

													?>
													<a href="#"
														onclick="popupopen(<?php echo $row1['Tableid']; ?>,'<?php echo $row1['Tablename']; ?>')">
														<div class="boxsize" style="color: white;background-color:red">
															<span class="info-box-icon push-bottom">
																<?php echo $row1['Tablename']; ?>
															</span>
															<div style="display: grid;">
																<center>
																	<div>&nbsp;</div>
																	<div><i class="fa fa-rupee"></i>&nbsp;
																		<?php echo $amt; ?>
																	</div>
																	<div><i class="fa fa-user"></i>&nbsp;
																		<?php echo $Stw; ?>
																	</div>
																</center>
															</div>
														</div>
													</a>
													<?php
												}
												if ($row1['Status'] == 'B') {
													$color = "bg-orange";
													$amt = "-";
													$Stw = "-";
													$sql2 = "select * from Employee where Employeeid='" . $row1['SID'] . "'";
													$result2 = $this->db->query($sql2);
													foreach ($result2->result_array() as $row2) {
														$Stw = $row2['Employee'];
													}
													$sql3 = "select sum(totalamount)as totalamount from Trans_reskotbillraise_mas where tableid='" . $row1['Tableid'] . "' and isnull(CANCEL,0)='0' and ISNULL(Settled,0)=0";
													$result3 = $this->db->query($sql3);
													foreach ($result3->result_array() as $row3) {
														$amt = $row3['totalamount'];
													}
													?>
													<a
														href="<?php echo scs_index ?>kotoutlet/Settlement/<?php echo $row1['Tableid']; ?>/<?php echo $ID; ?>">
														<div class="boxsize" style="color: white;background-color:orange">
															<span class="info-box-icon push-bottom">
																<?php echo $row1['Tablename']; ?>
															</span>
															<div style="display: grid;">
																<center>
																	<div>&nbsp;</div>
																	<div><i class="fa fa-rupee"></i>&nbsp;
																		<?php echo $amt; ?>
																	</div>
																	<div><i class="fa fa-user"></i>&nbsp;
																		<?php echo $Stw; ?>
																	</div>
																</center>
															</div>
														</div>
													</a>
													<?php
												}

											} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- The Modal -->
			<div id="myModal" class="modal">
				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						Table : <span id="Tableid"></span><span class="close">&times;</span>
					</div>
					<div class="modal-body">
						<div class="">
							<table class="table table-hover table-checkable order-column full-width" id="">
								<thead>
									<tr>
										<th class="center">
											<button
												onclick="Newkot(this.value,'<?php echo $ID; ?>')"
												id="kotidtable" value="fff" type="button"
												class="btn btn-round btn-primary">KOT
											</button>
										</th>
									</tr>
									<tr>
										<th class="center">
											<button
												onclick="check(this.value,'<?php echo $ID; ?>')"
												id="billidtable" type="button" value=""
												class="btn btn-round btn-success">Check
											</button>
										</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>

			<script>
				function popupopen(obj, obj1) {
					modal.style.display = "block";
					$('#Tableid').html(obj1);
					$('#kotidtable').val(obj);
					$('#billidtable').val(obj);
				}
				function Newkot(obj, obj1) {
					window.location.href = '<?php echo scs_index ?>kotoutlet/Cat/' + obj + '/' + obj1;

				}
				function check(obj, obj1) {
					window.location.href = '<?php echo scs_index ?>kotoutlet/Check/' + obj + '/' + obj1;

				}
				// Get the modal
				var modal = document.getElementById("myModal");
				// Get the <span> element that closes the modal
				var span = document.getElementsByClassName("close")[0];
				// When the user clicks on <span> (x), close the modal
				span.onclick = function () {
					modal.style.display = "none";
				}
				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function (event) {
					if (event.target == modal) {
						modal.style.display = "none";
					}
				}
			</script>

			<!-- end page content -->

			<!-- end chat sidebar -->
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php
		$this->pweb->wfoot($this->Menu, $this->session);
		$this->pcss->wjs();
		?>