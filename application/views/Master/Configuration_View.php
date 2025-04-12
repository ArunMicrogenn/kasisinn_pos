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
                        <div class="page-title">Outlet Configuratons</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Outlet Configuratons</li>
                    </ol>
                </div>
            </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Outlet</header>
                            
                        </div>
                        <div class="card-body ">
                            
                            <div class="table-scrollable">
                            
                                <table class="table table-striped custom-table table-hover">
                                <thead>
                                    <tr>                                            	
                                        <th class="center"> Outlet </th>												
                                        <th class="center"> Mobile </th>                                      
                                        <th class="center"> City </th>
                                        <th class="center"> Gst.No </th>  
                                        <th class="center">Action </th>                                              
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(@$_SESSION['MPOSCOMPANYID']=='')
                                {
                                $sql="select hed.Gstno,hed.Name,hed.mobileno,hed.Email,hed.City,hed.Gstno,hed.id,com.Hotelcode from headings hed
                                    inner join company com on com.companyid=hed.companyid";
                                }
                                else
                                {
                                $sql="select hed.Gstno,hed.Name,hed.mobileno,hed.Email,hed.City,hed.Gstno,hed.id,com.Hotelcode from headings hed
                                    inner join company com on com.companyid=hed.companyid
                                        where hed.companyid='".$_SESSION['MPOSCOMPANYID']."'";
                                }
                                $result=$this->db->query($sql);$i=1;                   
                                foreach ($result->result_array() as $row)
                                {
                                ?>
                                    <tr class="odd gradeX">												
                                        <td  class="center"><?php echo $row['Name'];?></td>												
                                        <td class="center"><?php echo $row['mobileno'];?></td>										
                                        <td class="center"><?php echo $row['City'];?></td>
                                        <td class="center"><?php echo $row['Gstno'];?></td>	
                                        <td class="center">
                                            <a href="<?php echo scs_index; ?>Master/Configuration_Edit/<?php echo $row['id'] ?>/UPDATE" class="btn btn-success btn-xs">
                                                <i class="fa fa-eye"></i>
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