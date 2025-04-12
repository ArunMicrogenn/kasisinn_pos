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
                        <div class="page-title">Pending KOT</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Report</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Pending KOT</li>
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
                            <?php			   foreach ($result->result_array() as $row)	      { ?>                                                   
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['Name']; ?></option>
                            <?php } ?>	
                                        </select>
                                    
                                    </div> 
                                </div>								  
                        </div> 
                        <div class="col-md-3 col-sm-3">									
                                <div class="card-body " id="bar-parent10">                                      
                                    <div class="form-group row">
                                    <label>From </label>
                                        <input class="form-control"  value="<?php echo @$_POST['fromdate']; ?>" type ="date" name="fromdate">		                  
                                    </div> 
                                </div>								  
                        </div> 
                        <div class="col-md-3 col-sm-3">									
                                <div class="card-body " id="bar-parent10">   
                                    <div class="form-group row">
                                    <label>To  </label>
                                        <input class="form-control" value="<?php echo @$_POST['todate']; ?>" type ="date" name="todate">										      
                                    </div> 
                                
                                </div>								  
                        </div>
                        <div class="col-md-3 col-sm-3">	
                            <div class="card-body " id="bar-parent10">   
                            <div class="form-group row">										
                            <button type="submit" onclick="submits()" class="btn btn-primary">Show</button>		
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
                            <table class="table table-bordered table-hover" id="table_id">
                                <thead>
                                    <tr>
                                        <th>Date / Time</th>
                                        <th>Table </th>
                                        <th>KOT No</th>
                                        <th>Steward</th>
                                        <th>Item NM</th>												
                                        <th>Qty</th>												
                                        <th>Rate</th>												
                                        <th>Total</th>												
                                        <th>User NM</th>												
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $query="select trm.kotno,trm.kotdate,trm.kottime,tm.tablename,emp.employee,im.itemname,trd.qty,trd.rate,un.username from trans_Reskot_det trd 
                                        inner join trans_Reskot_mas trm on trm.kotid =trd.kotid
                                        inner join itemmas im on im.itemdetid = trd.itemid  
                                        inner join tablemas tm on tm.tableid=trm.tableid
                                        inner join employee emp on emp.employeeid=trm.stwid
                                        inner join username un on un.userid=trm.userid                                        
                                        where trm.kotdate between '".$_POST['fromdate']."' and '".$_POST['todate']."' and trm.restypeid='".$_POST['outlet'] ."'
                                        and isnull(trm.raised,0)=0";												
                                        $result=$this->db->query($query); 	 
                                        $totalamt = 0;
                                        foreach ($result->result_array() as $row)
                                        { ?>                                             												
                                                            
                                    <tr>
                                        <td><?php  echo substr ($row ['kotdate'],0,10) .' - '.  substr ($row['kottime'],10,20);?></td>
                                        <td><?php  echo $row['tablename'];?></td>
                                        <td style ="text-align: center;"><?php  echo $row['kotno'];?></td>
                                        <td style ="text-align: center;"><?php  echo $row['employee'];?></td>
                                        <td style ="text-align: center;"><?php  echo $row['itemname'];?></td>
                                        <td style ="text-align: end;"><?php  echo $row['qty'];?></td>
                                        <td style ="text-align: end;"><?php  echo $row['rate'];?></td>
                                        <td style ="text-align: end;"><?php  $total= $row['rate']* $row['qty']; echo number_format($total,2)?></td>												
                                        <td style ="text-align: end;"><?php  echo $row['username'];?></td>
                                    </tr>

                                    <?php 
                                    $totalamt = $totalamt + $total;
                                        }
                                        ?>
                                    <tr>
                                        <td>Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>																							
                                        <td style="text-align: end;"><?php  echo number_format($totalamt,2); ?></td>
                                        <td></td>							
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
?>
 	<script type="text/javascript">
	$(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: true,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
	</script>
    	

	
<?php

$this->pcss->wjs();
?>