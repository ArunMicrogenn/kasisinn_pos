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
                        <div class="page-title">Item Sub Group2</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Item Sub Group2</li>
                    </ol>
                </div>
            </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Item Sub Group2</header>                                    
                        </div>
                        <div class="card-body ">
                            <div class="row p-b-20">
                                <div class="col-md-6 col-sm-6 col-6">
                                    <div class="btn-group">
                                        <a href="<?php echo scs_index ?>Master/Add_ItemSubGroup2" id="addRow" class="btn btn-info">
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
                                        <th class="center"> Item Sub Group2 </th>	
                                        <th class="center"> Item Sub Group1 </th>																							
                                        <th class="center"> Action </th>                                              
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(@$_SESSION['MPOSCOMPANYID']=='')
                                {
                                $sql="select * from itemsubgroup3 ig3 										
                                Inner join itemsubgroup2 ig2 on ig2.subgrpid2=ig3.subgrpid2
                                inner join company cm on ig3.companyid = cm.companyid";
                                }
                                else
                                {
                                $sql="select * from itemsubgroup3 ig3 										
                                Inner join itemsubgroup2 ig2 on ig2.subgrpid2=ig3.subgrpid2
                                inner join company cm on ig3.companyid = cm.companyid where ig3.companyid='".$_SESSION['MPOSCOMPANYID']."'";
                                }								
                                $result=$this->db->query($sql);
                                foreach ($result->result_array() as $row)
                                {
                                ?>
                                    <tr class="odd gradeX">
                                        <td class="center"><?php echo $row['Hotelcode'];?></td>
                                        <td  class="center"><?php echo $row['Subgroupname3'];?>	</td>	
                                        <td  class="center"><?php echo $row['Subgroupname2'];?>	</td>																							
                                        <td class="center">
                                            <a href="<?php echo scs_index ?>Master/Add_ItemSubGroup2/<?php echo $row['subgrpid3'] ?>/UPDATE" class="btn btn-tbl-edit btn-xs">
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