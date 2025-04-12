<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); 
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
?>
 <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Day End Process</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Day End Process</li>
                            </ol>
                        </div>
                    </div>
					<form method ="POST" action="<?php echo scs_index; ?>MsSql/Date_End_Process" >
                    <div class="row">						
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Day End Process</header>
                                    
                                </div>
								<?php
                                date_default_timezone_set('Asia/Kolkata'); 
								if(@$_SESSION['MPOSCOMPANYID'])
								{
									$query="select Newdate from date_Change_bar where companyid=".$_SESSION['MPOSCOMPANYID'];												
								}
								else
								{
									$query="select Newdate from date_Change_bar ";
								}							
                                        $result=$this->db->query($query); 					
                                        foreach ($result->result_array() as $row) 
										 {
											$accountdate = $row ['Newdate'];
											$lastaccountdate = $row ['Newdate'];									
											$accountdate = substr($accountdate ,0,11);
											///$accountdate = date($accountdate,"d-m-Y");
											$accountdatedate = str_replace('/', '-', $accountdate);
											$accountdate= date('d-m-Y', strtotime($accountdate));
										  }
									?>                                   																							 					
								<div class="col-md-3 col-sm-3">									
                                      <div class="card-body " id="bar-parent10">                                      
                                          <div class="form-group row">
                                            <label>Account Date </label> 
											<input type ="text" readonly name="accountdate" value ="<?php echo $accountdate ;?> " class = "form-control">					                 
                                         </div> 
									 </div>								  
								</div> 
                                <div class="card-body ">
                                    <div class="row p-b-20">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <button  type ="Submit" class="btn btn-info">
                                                    Submit 
                                                </button>
                                            </div>
                                        </div>                                       
                                    </div>                                 
                                </div>								
							</div>
                        </div>						
                    </div>  
					 <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card card-topline-green">
                                        <div class="card-head">
                                            <header>Pending KOT</header>
                                            <div class="tools">
                                                <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
			                                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
			                                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                            </div>
                                        </div>
                                        <div class="card-body ">
                                            <div class="table-scrollable">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Kot.No</th>
                                                            <th>Table.NO</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
													<?php
													$query="select * from trans_Reskot_mas mas
															inner join tablemas tbl on mas.tableid=tbl.tableid
															where isnull(mas.Raised,0)=0 and cancelornorm<>'C' and mas.companyid='".@$_SESSION['MPOSCOMPANYID']."'";												
                                                    $result=$this->db->query($query); $i=1;
                                                    foreach ($result->result_array() as $row) 
													 {
													?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $row['Kotno']; ?></td>
                                                            <td><?php echo $row['Tablename']; ?></td>
                                                            <td><a href="<?php echo scs_index ?>kotoutlet/check/<?php echo $row['Tableid']; ?>/<?php echo $row['restypeid']; ?>" class="btn btn-success btn-xs"> <i class="fa fa-eye"></i>  </a></td>
                                                        </tr>
													 <?php
													   $i++;		
													  }
													 ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Pending Bills</header>
                                            <div class="tools">
                                                <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
			                                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
			                                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                            </div>
                                        </div>
                                        <div class="card-body ">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Bill.No</th>
                                                        <th>Table.No</th>
														<th>Amount</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php 
												$query1="select * from Trans_reskotbillraise_mas mas
															inner join tablemas tbl on mas.tableid=tbl.tableid
															where isnull(mas.CANCEL,0)=0 and isnull(mas.Settled,0)=0 and mas.companyid='".$_SESSION['MPOSCOMPANYID']."'";												
                                                $result1=$this->db->query($query1); $i=1;
                                                foreach ($result1->result_array() as $row1)
												{
												?> <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $row1['Billno']; ?></td>
                                                        <td><?php echo $row1['Tablename']; ?></td>
														<td><?php echo $row1['totalamount']; ?></td>
                                                        <td><a href="<?php echo scs_index ?>kotoutlet/settlement/<?php echo $row1['Tableid']?>/<?php echo $row1['restypeid']?>" class="btn btn-success btn-xs"> <i class="fa fa-eye"></i>  </a></td>
                                                    </tr> 
												  <?php
													 }
													?>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					</form>
                </div>
            </div>
<?php
$this->pweb->wfoot($this->Menu, $this->session);
$this->pcss->wjs();
?>

