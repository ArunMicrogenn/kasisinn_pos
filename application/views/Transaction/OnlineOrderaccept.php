<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
date_default_timezone_set('Asia/Kolkata'); 
if(@$_SESSION['MPOSUSERNAME']=='')
{
  echo '<script>window.location="index.php";	</script>';
} 

?>
     <!-- start page content -->
     <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Online Order Ref.NO: <?php echo $Refno; ?></div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                <li><a class="parent-item" href="">Extra</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Order Preview</li>
                            </ol>
                        </div>
                    </div>
	                   <div class="row">
	                    <div class="col-md-12">
						<form action="<?php echo scs_index ?>OnlineOrders/OnlineBillSave" Method="POST">
						 <input type="hidden" name="Refno" value="<?php echo $Refno; ?>">
						 <input type="hidden" name="Kotid" value="<?php echo $Kotid; ?>">
						 <input type="hidden" name="restypeid" value="<?php echo $restypeid; ?>">
						 <input type="hidden" name="Customerid" value="<?php echo $Customerid; ?>">
						 <input type="hidden" name="tableid" value="<?php echo $tableid; ?>">
	                        <div class="white-box">
	                            <h3><b>Order Ref.NO</b> <span class="pull-right">#<?php echo $Refno; ?></span></h3>
	                            <hr>
	                            <div class="row">
	                                <div class="col-md-12">
										<div class="pull-left">
											<address>
												<p class="addr-font-h3">From,</p>												
												<?php 
												$sql1="select * from Headings where id='".$restypeid."'";
                                                $result1 = $this->db->query($sql1);	
                                                foreach ($result1->result_array() as $row1)
                                                {		?>
												<p class="font-bold addr-font-h4"><?php echo $row1['Name']; ?></p>
												<p class="text-muted m-l-5">												
													<?php echo $row1['address1']; ?><br>
													<?php echo $row1['address2']; ?>,<br>
													<?php echo $row1['city'].'-'.$row1['zipcode']; ?>
													</p>
												<?php 
												}?>												
											</address>
										</div>
										<div class="pull-right text-right">
											<address>
												<p class="addr-font-h3">To,</p>
												<?php 
												$sql2="select * from CustomerResturant where Customerid='".$Customerid."'";												
                                                $result2 = $this->db->query($sql2);	
                                                foreach ($result2->result_array() as $row2)											    
											    {
												?>
												<p class="font-bold addr-font-h4"><?php echo $row2['Customer'].' '.$row2['Lookup']; ?></p>
												<p class="text-muted m-l-30">
													Cell:<?php echo $row2['Mobile']; ?>, <br>
													<?php echo $row2['Address1']; ?>, <br>
													<?php echo $row2['Address2']; ?>, <br> <?php echo $row2['add3']; ?>
												</p>
												<p class="m-t-30">
													<b>Order Date :</b> <i class="fa fa-calendar"></i> <?php echo substr($Kotdate, 0, 10); ?>
												</p>
												<?php }?>
											</address>
										</div>
									</div>
	                                <div class="col-md-12">
	                                    <div class="table-responsive m-t-40">
	                                        <table class="table table-hover">
	                                            <thead>
	                                                <tr>
	                                                    <th class="text-center">#</th>	                                                 
	                                                    <th class="text-left">Item</th>
														<th class="text-center">Rate</th>
														<th class="text-center">Qty</th>
	                                                    <th class="text-center">Discount</th>	                                                  	                                                    
	                                                    <th class="text-right">Amount</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                               <?php 
												  $sql1="select det.Rate,itm.Itemname,det.qty,isnull(det.discamt,0) as discamt,det.Amount,mas.totalamount from online_Trans_reskot_mas mas
														inner join online_Trans_reskot_det det on det.kotid=mas.kotid
														inner join Itemmas itm on itm.itemdetid=det.itemid
														where mas.Refno='".$Refno."'";
                                                    $result1 = $this->db->query($sql1);	 $i=1;
                                                    foreach ($result1->result_array() as $row1)	
											       {
												   ?>
	                                                <tr>
	                                                    <td class="text-center"><?php echo $i++; ?></td>	                                               
	                                                    <td class="text-left"><?php echo $row1['Itemname']; ?></td>
														<td class="text-center"><?php echo $row1['Rate']; ?></td>
														<td class="text-center"><?php echo number_format($row1['qty']); ?></td>
	                                                    <td class="text-center"><?php echo $row1['discamt']; ?></td>	                                                   	                                                    
	                                                    <td class="text-right"><?php echo $row1['Amount']; ?></td>
	                                                </tr>
													<?php
														$Grandtotal=$row1['totalamount'];
													} ?>
	                                            </tbody>
	                                        </table>
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="pull-right m-t-30 text-right">
	                                        <!--p>Sub - Total amount: $179</p>
	                                        <p>Discount : $10 </p>
	                                        <p>Tax (10%) : $14 </p>
	                                        <hr-->
	                                        <h3><b>Total :</b> Rs.<?php echo $Grandtotal; ?></h3> </div>
	                                    <div class="clearfix"></div>
	                                    <hr>
	                                    <div class="text-right">
	                                        <button class="btn btn-danger" type="submit"  name="orderstatus"  value="billing"> Proceed to Billing </button>
											<button class="btn btn-danger" type="submit" name="orderstatus" value="Cancel"> Cancel Order </button>
	                                        <button onclick="javascript:window.print();" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
							</form>
	                    </div>
	                </div>
                </div>
            </div>
            <!-- end page content -->

<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>