<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
                                <div class="page-title">Company</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Company</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>All Companys</header>
                                    
                                </div>
                                <div class="card-body ">
                                    <div class="row p-b-20">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
											<?php  if($_SESSION['MPOSUSERNAME']=='superadmin') {?>
                                                <a href="<?php echo scs_index; ?>Company/Add_Company" id="addRow" class="btn btn-info">
                                                    Add New <i class="fa fa-plus"></i>
                                                </a>
											<?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                            
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                    <table class="table table-hover table-checkable order-column full-width" id="example4">
                                        <thead>
                                            <tr>
                                            	<th class="center"> Hotel_Code </th>
												<th class="center"> Name </th>												
                                                <th class="center"> Mobile </th>
                                                <th class="center"> Email </th>
                                                <th class="center"> City </th>
                                                <th class="center"> Gst.No </th>  
												<th class="center">Action </th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if($_SESSION['MPOSUSERNAME']=='superadmin') {
										$sql="select * from company";
										}
										else
										{
										$sql="select * from company where companyid='".$_SESSION['MPOSCOMPANYID']."'";	
										}
                                        $result = $this->db->query($sql);
                                        foreach($result->result_array() as $row)									
										{
										?>
											<tr class="odd gradeX">
												<td class="center"><?php echo $row['Hotelcode'];?></td>
												<td  class="center">
														<?php echo $row['company'];?>
												</td>												
												<td class="center"><?php echo $row['mobile'];?></td>
												<td class="center"><?php echo $row['e_mail'];?></td>
												<td class="center"><?php echo $row['City'];?></td>
												<td class="center"><?php echo $row['gstno'];?></td>	
												<td class="center">
													<a href="<?php echo scs_index; ?>Company/Add_Company/<?php echo $row['companyid'] ?>/UPDATE" class="btn btn-tbl-edit btn-xs">
														<i class="fa fa-pencil"></i>
													</a>
													<!--button class="btn btn-tbl-delete btn-xs">
														<i class="fa fa-trash-o "></i>
													</button---->
												</td>
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

<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>