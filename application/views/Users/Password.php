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
                                <div class="page-title">Change Password</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Change Password</header>
                                    
                                </div>
                                <div class="card-body ">
                                    <!-- <div class="row p-b-20">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="Add_Users" id="addRow" class="btn btn-info">
                                                    Add New <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                            
                                        </div>
                                    </div> -->
                                    <div class="table-scrollable">
                                    <table class="table table-hover table-checkable order-column full-width" id="example4">
                                        <thead>
                                            <tr>
                                            	<th class="center"> Hotel_Code </th>
												<th class="center"> User Name </th>												
                                                <th class="center"> User Group </th>
                                               
												<th class="center">Action </th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if(@$_SESSION['MPOSCOMPANYID']=='')
										{
										$sql="select u.username,u.userid,ug.UserGroup,c.company,c.Hotelcode from username u
                                        inner join UserGrouppos ug on ug.usergroup_id=Groupid
                                        inner join company c on c.companyid = u.companyid order by c.companyid";
										}
										else
										{
										$sql="select u.username,u.userid,ug.UserGroup,c.company,c.Hotelcode from username u
                                        left join UserGrouppos ug on ug.usergroup_id=Groupid
                                        inner join company c on c.companyid = u.companyid
                                        where u.companyid='".$_SESSION['MPOSCOMPANYID']."'
                                        order by u.Userid";
										}										
                                        $result=$this->db->query($sql);
                                        foreach ($result->result_array() as $row)																	
										{
										?>
											<tr class="odd gradeX">
												<td class="center"><?php echo $row['Hotelcode'];?></td>
												<td  class="center"><?php echo $row['username'];?></td>												
												<td class="center"><?php echo $row['UserGroup'];?></td>
												
												<td class="center">
													<a href="Edit_Password/<?php echo $row['userid'] ?>" class="btn btn-tbl-edit btn-xs">
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
	  ?>      <!-- end footer -->
 	<script>
	function viewtypeid(obj)
	{
		window.location.href ='tablelist.php?outletid='+obj;	
	}
	
	</script>
	<?php 
		$this->pcss->wjs();
	?>   
</body>
</html>