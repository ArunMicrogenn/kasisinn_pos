<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pcss->hjs();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
?>

<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Re-Settlement</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Report</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Re-Settlement</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
							<form method="POST">								
                                <div class="row">	
								
								
                                 <div class="col-md-3 col-sm-3">									
                                      <div class="card-body " id="bar-parent10">                                      
                                          <div class="form-group row">
                                            <label>Outlet </label>                                            
											<?php 
											$sql="select Name,id from headings  where companyid='".$_SESSION['MPOSCOMPANYID']."' and isnull(isvisible,0)=1";
                                            $result=$this->db->query($sql);
											?>
                                               <select  class="form-control  select2" name="outlet" id="outlet">
											   <option value="0" disabled selected>Select Outlet</option>
									<?php		foreach ($result->result_array() as $row) { ?>                                                   
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['Name']; ?></option>
									<?php } ?>	
                                                </select>
                                            
                                         </div> 
									 </div>								  
								</div> 
								<div class="col-md-3 col-sm-3">									
                                      <div class="card-body " id="bar-parent10">                                      
									  <?php 
											$sql1="select Newdate from date_change_bar  where companyid='".$_SESSION['MPOSCOMPANYID']."' ";
                                            $result1=$this->db->query($sql1);
											foreach ($result1->result_array() as $row1) {
												$accountdate = $row1['Newdate'];
												$accountdate = substr($accountdate,0,10);
											} ?>                                                   											
											
                                          <div class="form-group row">
                                            <label>Account Date </label>
                                               <input type ="text" class ="form-control" name="fromdate" readonly value= "<?php echo $accountdate; ?>" >										      
					                  
                                         </div> 
									 </div>								  
								</div> 
								<!--div class="col-md-3 col-sm-3">									
                                      <div class="card-body " id="bar-parent10">   
										 <div class="form-group row">
                                            <label>To  </label>
                                                  <input type ="date" name="todate">										      
                                         </div> 
										
									 </div>								  
								</div -->
								<div class="col-md-3 col-sm-3">	
									<div class="card-body " id="bar-parent10">   
									<div class="form-group row">										
									<button type="submit" onclick="submits()" class="btn btn-primary">Display</button>		
									</div> 	</div> 									
								</div> 							  
							  </div>
                              </form>
                            </div>
							<?php 
		if(isset($_POST['outlet']))
		 {   ?>
			 <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
                                
                                <div class="card-body ">
                                  <div class="table-scrollable">
                                    <table id="example1" class="display" class="full-width">
                                        <thead>
                                            <tr>
                                                <th>Bill No</th>
                                                <th>Bill Date</th>
                                                <th>Table/Pax</th>                                                
                                                <th>Value</th>																								
												<th>Mode</th>
												<th>UserNM</th>
												<th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$query="SELECT DISTINCT trm.billno,trm.billdate,tm.Status,tm.tableid,tm.tablename,trm.noofpax,trm.totalamount,us.username,trm.billid,trm.restypeid,trm.Refno from trans_Reskotbillraise_mas trm
												inner join trans_Reskotsettlement trs on trs.billid = trm.billid
												inner join tablemas tm on tm.tableid = trm.tableid
												inner join mas_paymode pm on pm.paymode_id = trs.paymentid
												inner join username us on us.userid = trm.userid
												where isnull(trm.settled,0) =1 and isnull(trm.cancel,0)=0 and trm.billdate = '".$_POST['fromdate']."' and isnull(trs.Cancel,0)=0 and trm.restypeid='".$_POST['outlet']."' and  trm.companyid='".$_SESSION['MPOSCOMPANYID']."' order by trm.billno desc";												
                                            $result=$this->db->query($query);
                                            foreach ($result->result_array() as $row)													
												{
													if($row['Refno']==$row['billno'])
													{
													$pm='';
													 $sql="select * from trans_Reskotsettlement trs
														inner join mas_paymode pm on pm.paymode_id = trs.paymentid 
														where isnull(trs.cancel,0)=0 and trs.Billid='".$row['billid']."' and  trs.companyid='".$_SESSION['MPOSCOMPANYID']."' ";												     
                                                    $results=$this->db->query($sql);													
                                                    foreach ($results->result_array() as $rows)													
													{ 
												    $pm=$pm.$rows['PayMode'].'/';
													}												
												?> 				
												<tr>
													<td><?php  echo $row['billno'];?></td>
													<td><?php  echo substr($row['billdate'],0,10);?></td>
													<td style ="text-align: center;"><?php  echo $row['tablename'].'/'.$row['noofpax'];?></td>												
													<td style ="text-align: end;"><?php  echo $row['totalamount'];?></td>												
													<td style ="text-align: left;"><?php echo $pm; ?></td>
													<td><?php echo $row['username'];?></td>
													<td style="width:10%" class='valigntop'> 
                                                    <a class="btn btn-danger btn-xs"  href="Resettlement_edit/<?php echo $row['billid']; ?>/<?php echo $row['tableid']; ?>"><i class="fa fa-edit "></i></a>
													<!-- <button  type='button' class="btn btn-danger btn-xs"  onclick="Deletebill(<?php echo $row['billid']; ?>,'<?php echo $row['Status']; ?>','<?php echo $row['tableid']; ?>', '<?php echo substr($row['billdate'],0,10);?>')">   <i class="fa fa-edit "></i></button> -->
                                                </td>
													
												</tr>
                                            <?php 
													}
												}
												?>
											
						
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
	<?php	 }
		?>
                        </div>
                    </div>         
                    
                    
                    
                </div>
            </div>

<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>
<!-- <script>
	function Deletebill(a,b,c)
	{		
	var billid = a;
	var Table=c;
		if(b=='S')
		{
			swal("Settlement Cancellation Reason :", {
			  content: "input",
			})
			.then((value) => {	
				if(value)
				{
				$.ajax({
						  type: 'POST',
						  url: 'Billsettelementcancel',  //GET ITEM Price any url
						  data: {label: value,billid : billid,Table:Table},
						  success: function(message) { 
							if(message ==='Room Is already checked out!'){
								swal("Unable to process..","Room already checkedout!..", "error")
						  .then(() => {
							window.location.href = 'Settlement_cancellation'; 
							});
							}else{
						
							swal("Settlement Cancellation Completed..!","Redirecting....", "success")
						  .then(() => {
							window.location.href = 'Settlement_cancellation'; 
							});	
							}
						  
						  }
					   }); 
				}
				else
				{
				  swal(`Kindly Enter Valied Reason`);	
				}								
			});			
		}
		else
		{           
			swal("Table is Not Vecant..","Unable to do further Process", "warning");				
		} 
	}
	
	</script> -->