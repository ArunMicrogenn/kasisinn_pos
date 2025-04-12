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
                                <div class="page-title">Item Sub Group1</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Item Sub Group1</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>All Item Sub Group1</header>
                                    
                                </div>
                                <div class="card-body ">
                                    <div class="row p-b-20">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="<?php echo scs_index ?>Master/Add_ItemSubGroup1" id="addRow" class="btn btn-info">
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
                                            	<th class="center"> Hotel_Code </th>
												<th class="center"> Item Sub Group </th>												
												<th class="center"> Item Group </th>																								
                                                <th class="center"> Action </th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if(@$_SESSION['MPOSCOMPANYID']=='')
										{
										$sql="select * from itemsubgroup2 ig2 
											inner join company cm on ig2.companyid = cm.companyid
											inner join itemgroup ig on ig.Itemgroupid=ig2.itemgrpid";
										}
										else
										{
										$sql="select * from itemsubgroup2 ig2 
											inner join company cm on ig2.companyid = cm.companyid
											inner join itemgroup ig on ig.Itemgroupid=ig2.itemgrpid where ig2.companyid='".$_SESSION['MPOSCOMPANYID']."'";
										}
                                        $result=$this->db->query($sql);
                                        foreach ($result->result_array() as $row)	
										{
										?>
											<tr class="odd gradeX">
												<td class="center"><?php echo $row['Hotelcode'];?></td>																						
												<td  class="center"><?php echo $row['Subgroupname2'];?>	</td>												
												<td  class="center"><?php echo $row['Itemgroup'];?>	</td>		
												<td class="center">
													<a href="<?php echo scs_index ?>Master/Add_ItemSubGroup1/<?php echo $row['subgrpid2'] ?>/UPDATE" class="btn btn-tbl-edit btn-xs">
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