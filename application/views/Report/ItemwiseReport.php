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
                        <div class="page-title">Itemwise Report</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Report</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Itemwise Report</li>
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
                            <?php			foreach ($result->result_array() as $row)	 { ?>                                                   
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
                                        <input class="form-control" value="<?php if(@$_POST['fromdate']){ echo $_POST['fromdate']; } else { echo date('Y-m-d');} ?>" type ="date" name="fromdate">									      					                  
                                    </div> 
                                </div>								  
                        </div> 
                        <div class="col-md-3 col-sm-3">									
                                <div class="card-body " id="bar-parent10">   
                                    <div class="form-group row">
                                    <label>To  </label>
                                        <input class="form-control" value="<?php if(@$_POST['todate']){ echo $_POST['todate']; } else { echo date('Y-m-d');} ?>" type ="date" name="todate">										      
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
                                        <th>#</th>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Total</th>												
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $query="select sum(trd.qty)as qty ,im.itemname,im.itemcode,trd.Rate  from trans_Reskotbillraise_det trd 	 
                                            inner join trans_Reskotbillraise_mas trm on trd.billid = trm.billid
                                            inner join itemmas im on im.itemdetid = trd.itemid 
                                            where trm.billdate between '".$_POST['fromdate']."' and '".$_POST['todate']."' and trm.restypeid ='".$_POST['outlet'] ."'
                                            and isnull(trm.settled,0)=1  and isnull(trm.cancel,0)<>1
                                            Group by  im.itemname,im.itemcode,trd.Rate";												               
                                        $result=$this->db->query($query); 
                                        $totalamt = 0; $i=1;                                  
                                        foreach ($result->result_array() as $row)	   
                                        { ?>                                                												
                                                            
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php  echo $row['itemcode'];?></td>
                                        <td><?php  echo $row['itemname'];?></td>
                                        <td style ="text-align: center;"><?php  echo $row['qty'];?></td>
                                        <td style ="text-align: end;"><?php  echo $row['Rate'];?></td>
                                        <td style ="text-align: end;"><?php  $total= $row['Rate']* $row['qty']; echo number_format($total,2)?></td>												
                                    </tr>

                                    <?php 
                                    $totalamt = $totalamt + $total;
                                        }
                                        ?>
                                    <tr>
                                        <td>Total</td>
                                        <td></td><td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: end;"><?php  echo number_format($totalamt,2); ?></td>
                
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