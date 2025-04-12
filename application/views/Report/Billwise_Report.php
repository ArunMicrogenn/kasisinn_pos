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
                            <div class="page-title">Billwise Report</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li><a class="parent-item" href="">Report</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Billwise Report</li>
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
                                <?php		foreach ($result->result_array() as $row)	 
                                         {		?>                                                   
                                                <option <?php if(@$_POST['outlet']==$row['id']){echo "selected";} ?> value="<?php echo $row['id'] ?>"><?php echo $row['Name']; ?></option>
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
                                            <th>Bill No</th>
                                            <th>Bill Date</th>
                                            <th>Table/Pax</th>
                                            <th>Steward</th>
                                            <th>Item Total</th>
                                            <th>Discount</th>
                                            <th>Taxes</th>
                                            <th>Total</th>
                                            <th>Mode</th>
                                            <th>UserNM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php										
                                    $query="select tbm.billid,tbm.billno,tbm.billdate,tm.tablename,tbm.noofpax,emp.employee,tbm.Totaltaxamount,un.Username,tbm.discamount,tbm.itemtotal,tbm.totalamount from trans_Reskotbillraise_mas tbm 
                                            inner join tablemas tm on tm.tableid=tbm.tableid 
                                            left outer join employee emp on emp.employeeid=tbm.stwid 
                                            inner join username un on un.userid=tbm.userid where tbm.billdate between '".$_POST['fromdate']."' and '".$_POST['todate']."' and isnull(tbm.settled,0)=1 and isnull(tbm.CANCEL,0)=0
                                            and tbm.RESTYPEID='".$_POST['outlet']."'
                                            Order by tbm.billno";
                                            $result=$this->db->query($query); $i=1;  $Billno='';  
                                            foreach ($result->result_array() as $row)	 
                                            {
                                                            ?>                                           																										
                                        <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td><?php  echo $row['billno'];?></td>
                                            <td><?php  echo substr($row['billdate'],0,10);?></td>
                                            <td style ="text-align: center;"><?php  echo $row['tablename'].'/'.$row['noofpax'];?></td>
                                            <td style ="text-align: center;"><?php  echo $row['employee'];?></td>
                                            <td style ="text-align: end;"><?php  echo $row['itemtotal'];?></td>
                                            <td style ="text-align: end;"><?php echo $row['discamount'];?></td>
                                            <td style ="text-align: end;"><?php  echo $row['Totaltaxamount'];?></td>
                                            <td style ="text-align: end;"><?php  echo $row['totalamount'];?></td>
                                            <?php 
                                                $paymode='';
                                                $query2="select * from trans_Reskotsettlement trs
                                                inner join Mas_Paymode pm on pm.PayMode_Id=trs.paymentid 
                                                where trs.billid='".$row['billid']."' and isnull(trs.Cancel,0)=0";
                                                $result2=$this->db->query($query2);  $j=1;                                         
                                                foreach ($result2->result_array() as $row2)	
                                                {  if($j==1)
                                                    {
                                                    $paymode.=$row2['PayMode'];
                                                    }
                                                    else
                                                    {
                                                    $paymode.='/'.$row2['PayMode'];	
                                                    }
                                                $j++;
                                                }
                                            ?>
                                            
                                            <td style ="text-align: end;"><?php  echo $paymode;?></td>
                                            <td><?php echo $row['Username'];?></td>
                                        </tr>											
                                            <?php
                                            }  ?>
                                            <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td></td>
                                            <td></td>
                                            </tr>
                                        <?php	
                                        $query1="select sum(sett.BillAmount)as Amount,pm.Paymode from trans_Reskotsettlement sett
                                                inner join Mas_Paymode pm on pm.PayMode_Id=sett.Paymentid
                                                where sett.SettleDate between '".$_POST['fromdate']."' and '".$_POST['todate']."' 
                                                and ISNULL(sett.Cancel,0)=0 and isnull(sett.RESTYPEID,0)='".$_POST['outlet']."'
                                                Group By pm.PayMode";                                        
                                        $result1=$this->db->query($query1);  $totalcollection=0;                    
                                        foreach ($result1->result_array() as $row1)	
                                            {												 
                                            ?>											
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row1['Paymode']; ?></td>
                                            <td style ="text-align: end;"><?php echo $row1['Amount']; $totalcollection=$totalcollection+$row1['Amount']; ?></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                            <?php 
                                            }
                                            ?>
                                            <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>Total Collection</td>
                                            <td style ="text-align: end;"><?php echo number_format($totalcollection,2); ?></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td style ="text-align: end;"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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