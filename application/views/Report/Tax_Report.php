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
                            <div class="page-title">Tax Report</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li><a class="parent-item" href="">Report</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Tax Report</li>
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
                                            <option value="01" >All</option>
                                <?php		foreach ($result->result_array() as $row)	 
                                         {		?>                                                   
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
                                            <input class="form-control"  value="<?php if(@$_POST['fromdate']){ echo $_POST['fromdate']; } else { echo date('Y-m-d');} ?>" type ="date" name="fromdate">						                        
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
                                            <th>Outlet</th>
                                            <th>Sales Val</th>
                                            <?php 
                                            $sql = "select * from taxtype where companyid='".$_SESSION['MPOSCOMPANYID']."'
                                                        and isnull(inactive,0)<>1 and taxtype<>'Item Total' order by orderby asc";
                                                $res = $this->db->query($sql);
                                                foreach($res->result_array() as $row){
                                                    echo '<th>'.$row['taxtype'].'</th>';
                                                }
                                            ?>
                                            <th>Discount</th>
                                            <th>R.Off</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php										
                                        $query="select * from (select * from ( 
                                        select * from (select isnull(sum(itemtotal),0.00) as salesval,isnull(sum(isnull(RoundeOff,0)),0.00) as roundoff,
                                        isnull(sum(discamount),0.00) as discount from trans_reskotbillraise_mas 
                                        where restypeid='".$_POST['outlet']."' and  billdate between 
                                        '".$_POST['fromdate']."' and '".$_POST['todate']."') as T,
                                        (select Name from headings where companyid='".$_SESSION['MPOSCOMPANYID']."' and id='".$_POST['outlet']."') as outletname
                                        ) as temp
                                        ) as a";
                                           
                                            $result=$this->db->query($query); $i=1;    
                                            foreach ($result->result_array() as $row)	 
                                            {
                                             ?>                                           																										
                                            <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td><?php  echo $row['Name'];?></td>
                                            <td style ="text-align: end;"><?php  echo $row['salesval'];?></td>
                                            <?php 
                                            $sql = "select sum(Amount) as totalamount,t.taxid,t.taxtype,t.orderby from taxtype t
                                            left join trans_reskotbilltax_det det on t.taxid = det.taxid
                                            left join trans_reskotbillraise_mas m on m.Billid = det.billid
                                            where    m.restypeid='".$_POST['outlet']."' and m.billdate between '".$_POST['fromdate']."' and '".$_POST['todate']."'
                                            and t.taxtype<>'Item Total' and t.companyid='".$_SESSION['MPOSCOMPANYID']."'
                                            group by t.taxid,t.taxtype,t.orderby";
                                            $res = $this->db->query($sql);
                                            foreach($res->result_array() as $ro){
                                                echo '<td style ="text-align: end;">'.$ro['totalamount'].'</td>';
                                            }
                                            ?>
                                            <td style ="text-align: center;"></td>
                                            <td style ="text-align: end;"><?php echo $row['discount']?></td>
                                            <td style ="text-align: end;"><?php echo $row['roundoff']?></td>
                                            <td style ="text-align: end;"></td>
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