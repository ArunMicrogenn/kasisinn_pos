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
                        <li><a class="parent-item" href="">Session</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Session</li>
                    </ol>
                </div>
            </div>
                <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="card-head">
                            <header>Session</header>
                            <button id = "panel-button" 
                                class = "mdl-button mdl-js-button mdl-button--icon pull-right" 
                                data-upgraded = ",MaterialButton">
                                <i class = "material-icons">more_vert</i>
                            </button>
                            
                        </div>
                        <form action="<?php echo scs_index; ?>MsSql/Session" method="POST">
				    	<input type="hidden" name="ID" id="ID" value="<?php echo @$ID; ?>">
                        <div class="card-body row">
                            <div class="col-lg-6 p-t-20"> 
                                <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                    <input class = "mdl-textfield__input" type = "text" value="<?php echo @$sESSION; ?>" name="session" id = "session" required/>
                                    <label class = "mdl-textfield__label">Session</label>
                                </div>
                                </div>
                                <div class="col-lg-6 p-t-20"> 
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                    <input class="mdl-textfield__input" type="text" id="outlet" value="<?php echo @$Name; ?>" name="outlet" readonly tabIndex="-1" required>
                                    <label for="outlet" class="pull-right margin-0">
                                        <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                    </label>
                                    <label for="outlet" class="mdl-textfield__label">Outlet</label>
                                    <ul data-mdl-for="outlet" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <?php 
                                    $sql="select * from headings where companyid='".$_SESSION['MPOSCOMPANYID']."'";
                                    $result=$this->db->query($sql);
                                    foreach ($result->result_array() as $row)	 
                                    {
                                    ?>
                                        <li class="mdl-menu__item" data-val="<?php echo $row['id']; ?>"><?php echo $row['Name']; ?></li>
                                    <?php 
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                                <div class="col-lg-6 p-t-20"> 
                                    <label class="col-md-4 control-label">From Time</label>
                                    <div class="input-group date form_time col-md-8" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input class="mdl-textfield__input" name="fromtime" size="16" type="text" value="<?php echo substr(@$fROMTIME,11,8);; ?>">                                         
                                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    </div>
                                    <input type="hidden" id="dtp_input3" value="" />
                                    <br/>
                                </div>  
                                <div class="col-lg-6 p-t-20"> 
                                    <label class="col-md-4 control-label">To Time</label>
                                    <div class="input-group date form_time col-md-8" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input class="mdl-textfield__input" size="16" name="totime" type="text" value="<?php echo substr(@$tOTIME,11,8);; ?>">                                                
                                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    </div>
                                    <input type="hidden" id="dtp_input3" value="" />
                                    <br/>
                                </div>
                            <?php 
                            if(@$_SESSION['MPOSCOMPANYID']=='')
                            {
                            ?>
                                <div class="col-lg-6 p-t-20"> 
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                    <input class="mdl-textfield__input" type="text" id="sample2" value="" name="hotelcode" readonly tabIndex="-1">
                                    <label for="sample2" class="pull-right margin-0">
                                        <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                    </label>
                                    <label for="sample2" class="mdl-textfield__label">Hotel Code</label>
                                    <ul data-mdl-for="sample2" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <?php 
                                    $sql="select * from company";
                                    $result=$this->db->query($sql);
                                    foreach ($result->result_array() as $row)	 
                                    {
                                    ?>
                                        <li class="mdl-menu__item" data-val="<?php echo $row['companyid']; ?>"><?php echo $row['Hotelcode']; ?></li>
                                    <?php 
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <?php 
                            }
                            else
                            {  ?>
                            <input type="hidden" value="<?php echo $_SESSION['MPOSCOMPANYID']; ?>" name="hotelcode">	
                            <?php	
                            }
                            ?>
                                <div class="col-lg-12 p-t-20 text-center"> 
                                <button type="submit" id="EXEC" name="EXEC" value="<?php echo $BUT; ?>"  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"><?php echo $BUT; ?></button>                              
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <!-- end page content -->


<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>