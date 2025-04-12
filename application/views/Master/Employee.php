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
                    <div class="page-title">Employees</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Employees</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Employees</li>
                </ol>
            </div>
        </div>
            <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Employees</header>
                        <button id = "panel-button" 
                            class = "mdl-button mdl-js-button mdl-button--icon pull-right" 
                            data-upgraded = ",MaterialButton">
                            <i class = "material-icons">more_vert</i>
                        </button>
                        
                    </div>
                    <form action="<?php echo scs_index; ?>MsSql/Employee" method="POST">
					<input type="hidden" name="ID" id="ID" value="<?php echo @$ID; ?>">
                    <div class="card-body row">
                        <div class="col-lg-6 p-t-20"> 
                            <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                <input class = "mdl-textfield__input" value="<?php echo @$Employee; ?>" type = "text" name="Employee" id = "Employee" required/>
                                <label class = "mdl-textfield__label">Employee Name</label>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 p-t-20"> 
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                <input class="mdl-textfield__input" type="text" id="steward" value="<?php echo @$Iscapttion; ?>" name="steward" readonly required tabIndex="-1">
                                <label for="steward" class="pull-right margin-0">
                                    <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                </label>
                                <label for="steward" class="mdl-textfield__label">Employee Type</label>
                                <ul data-mdl-for="steward" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">											
                                    <li class="mdl-menu__item" data-val="steward">Steward</li>
                                    <li class="mdl-menu__item" data-val="captain">Captain</li>											
                                </ul>
                            </div>
                        </div>
                    
                            <?php 
                        if(@$_SESSION['MPOSCOMPANYID']=='')
                        {
                        ?>
                        <div class="col-lg-6 p-t-20"> 
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                <input class="mdl-textfield__input" type="text" id="hotelcode" value="" name="hotelcode" readonly tabIndex="-1">
                                <label for="hotelcode" class="pull-right margin-0">
                                    <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                </label>
                                <label for="hotelcode" class="mdl-textfield__label">Hotelcode</label>
                                <ul data-mdl-for="hotelcode" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                <?php 
                                $sql="select * from company";
                                $result = odbc_exec($dbhandle, $sql); 
                                while ($row = odbc_fetch_array($result))
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
                        {
                        ?>
                        <input type="hidden" value="<?php echo $_SESSION['MPOSCOMPANYID']; ?>" name="hotelcode">	
                        <?php 
                        }
                        if(@$inactive=='' || @$inactive=='0')
                            {
                                $Active='Active';
                            }
                            else
                            {
                                $Active='Inactive';
                            } ?>
                           <div class="col-lg-6 p-t-20"> 
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                <input class="mdl-textfield__input" type="text" id="Inactive" value="<?php echo $Active ?>" name="Inactive" readonly tabIndex="-1">
                                <label for="Inactive" class="pull-right margin-0">
                                    <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                </label>
                                <label for="Inactive" class="mdl-textfield__label">Status</label>
                                <ul data-mdl-for="Inactive" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                        <li class="mdl-menu__item" data-val="Active">Active</li>
                                        <li class="mdl-menu__item" data-val="Inactive">Inactive</li>											
                                </ul>
                            </div>
                        </div>
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
<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>