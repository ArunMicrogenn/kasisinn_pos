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
                                <div class="page-title">Item Group</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Item Group</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>All Item Group</header>
                                    
                                </div>
                                <div class="card-body ">
                                    <div class="row p-b-20">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="<?php echo scs_index ?>Master/Add_Itemgroup" id="addRow" class="btn btn-info">
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
												<th class="center"> Item Category </th>												
												<th class="center"> Item Group </th>												
												<th class="center"> Tax Setup</th>												
												<th class="center"> NC Cost%</th>												
                                                <th class="center">Action </th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if(@$_SESSION['MPOSCOMPANYID']=='')
										{
										$sql="select * from itemgroup ig 
										    inner join Itemcategory ic on ic.itemcategoryid=ig.itemcategoryid
											inner join company cm on ig.companyid = cm.companyid
											inner join  taxsetupmas tx on tx.Taxsetupid=ig.taxsetupid";
										}
										else{
										$sql="select * from itemgroup ig 
										    inner join Itemcategory ic on ic.itemcategoryid=ig.itemcategoryid
											inner join company cm on ig.companyid = cm.companyid 
											inner join  taxsetupmas tx on tx.Taxsetupid=ig.taxsetupid
											where ig.companyid='".$_SESSION['MPOSCOMPANYID']."'";
										}
                                        $result=$this->db->query($sql);
                                        foreach ($result->result_array() as $row)	                                 
										{
										?>
											<tr class="odd gradeX">
												<td class="center"><?php echo $row['Hotelcode'];?></td>
												<td  class="center"><?php echo $row['itemcategory'];?>	</td>												
												<td  class="center"><?php echo $row['Itemgroup'];?>	</td>
												<td  class="center"><?php echo $row['taxsetupname'];?>	</td>												
												<td  class="center"><?php echo $row['nccostperc'];?>	</td>												
												<td class="center">
													<a href="<?php echo scs_index ?>Master/Add_Itemgroup/<?php echo $row['Itemgroupid'] ?>/UPDATE" class="btn btn-tbl-edit btn-xs">
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