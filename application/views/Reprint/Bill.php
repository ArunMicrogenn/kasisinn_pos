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
                            <div class="page-title">Bill Reprint</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li><a class="parent-item" href="">Reprint</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Bill Reprint</li>
                        </ol>
                    </div>
                </div>
                <form method ="POST" action="" >
                <div class="row">						
                    <div class="col-md-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header>Bill Reprint</header>                                    
                            </div>							         																							 					
                            
                            <div class="card-body ">
                            <div class="table-scrollable">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kot.No</th>
                                            <th>Table.NO</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $query="select * from trans_Reskotbillraise_mas mas
                                            inner join Tablemas t on t.Tableid=mas.tableid
                                            where  CANCEL<>'1' and mas.Billdate='".date('Y-m-d')."' and mas.companyid='".@$_SESSION['MPOSCOMPANYID']."' order by billid desc";												
                                        $result=$this->db->query($query); 	 $i=1;
                                        foreach ($result->result_array() as $row)
                                        {
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['Billno']; ?></td>
                                            <td><?php echo $row['Tablename']; ?></td>
                                            <td><a target="_blank" href="<?php echo scs_index; ?>Receipts/BillPrint/<?php echo $row['Billid'] ?>" class="btn btn-success btn-xs"> <i class="fa fa-eye"></i>  </a></td>
                                        </tr>
                                        <?php
                                        $i++;		
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>                                 
                            </div>								
                        </div>
                    </div>						
                </div>  					
                </form>
            </div>
        </div>


<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>
