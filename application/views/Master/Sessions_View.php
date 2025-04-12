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
                        <div class="page-title">Session</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Session</li>
                    </ol>
                </div>
            </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Session</header>
                            
                        </div>
                        <div class="card-body ">
                            <div class="row p-b-20">
                                <div class="col-md-6 col-sm-6 col-6">
                                    <div class="btn-group">
                                        <a href="<?php echo scs_index ?>Master/Add_Session" id="addRow" class="btn btn-info">
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
                                    <tr> <th>#</th>                                           													
                                        <th class="right"> Outletname </th>
                                        <th class="center"> Session Name </th>
                                        <th class="center"> From Time </th>
                                        <th class="center"> To Time </th>
                                        <th class="center">Action </th>                                              
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(@$_SESSION['MPOSCOMPANYID']=='')
                                {
                                $sql="select hed.Name as outlet,* from session tm 
                                    inner join headings hed on hed.id=tm.restypeid
                                    inner join company cm on tm.companyid = cm.companyid";
                                }
                                else{
                                $sql="select hed.Name as outlet,* from session tm 
                                    inner join headings hed on hed.id=tm.restypeid
                                    inner join company cm on tm.companyid = cm.companyid
                                    where tm.companyid='".$_SESSION['MPOSCOMPANYID']."'";
                                }
                                $result=$this->db->query($sql); $i=1;
                                foreach ($result->result_array() as $row)	                             
                                {
                                ?>
                                    <tr class="odd gradeX">	
                                        <td><?php echo $i++; ?></td>	
                                        <td  class="right"><?php echo $row['outlet'];?>	</td>	
                                        <td class="center"><?php echo $row['sESSION'];?></td>
                                        <td class="center"><?php echo substr($row['fROMTIME'],11,8);?></td>
                                        <td class="center"><?php echo substr($row['tOTIME'],11,8);?></td>
                                        <td class="center">
                                            <a href="<?php echo scs_index ?>Master/Add_Session/<?php echo $row['sESSID'] ?>/UPDATE" class="btn btn-tbl-edit btn-xs">
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