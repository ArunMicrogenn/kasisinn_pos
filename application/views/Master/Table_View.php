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
                                <div class="page-title">Table</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Table</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Table</header>
                                    
                                </div>
                                <div class="card-body ">
                                    <div class="row p-b-20">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="<?php echo scs_index ?>Master/Add_Table" id="addRow" class="btn btn-info">
                                                    Add New <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                            
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                    <table class="table table-hover table-checkable order-column full-width" id="example4">
                                        <thead>
                                            <tr>
                                            	<th class="center"> Table Name </th>												
												<th class="center"> Outletname </th>
                                                <th class="center">Action </th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if(@$_SESSION['MPOSCOMPANYID']=='')
										{
										$sql="select hed.Name as outlet,* from Tablemas tm 
											inner join headings hed on hed.id=tm.restypeid
											inner join company cm on tm.companyid = cm.companyid";
										}
										else{
										$sql="select hed.Name as outlet,* from Tablemas tm 
											inner join headings hed on hed.id=tm.restypeid
											inner join company cm on tm.companyid = cm.companyid
											where tm.companyid='".$_SESSION['MPOSCOMPANYID']."'";
										}					
                                        $result=$this->db->query($sql);
                                        foreach ($result->result_array() as $row)	 
										{
										?>
											<tr class="odd gradeX">
												<td class="center"><?php echo $row['Tablename'];?></td>
												<td  class="center"><?php echo $row['outlet'];?>	</td>												
												
												<td class="center">
													<a href="<?php echo scs_index ?>Master/Add_Table/<?php echo $row['Tableid'] ?>/UPDATE" class="btn btn-tbl-edit btn-xs">
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