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
                            <div class="page-title">Configurations</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Configurations</li>
                        </ol>
                    </div>
                </div>
                    <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header><?php echo $Name; ?></header>
                                <div class="tools">
                                    <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                </div>
                            </div>
                            <div class="card-body " id="bar-parent">
                            <form action="<?php echo scs_index; ?>MsSql/Configuration" method="POST">
					         <input type="hidden" name="ID" id="ID" value="<?php echo @$ID; ?>">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-3">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li class="nav-item">
                                                <a href="#tab_6_1" data-toggle="tab" class="active">General</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab_6_2" data-toggle="tab">Kot</a>
                                            </li>                                                
                                            <li class="nav-item">
                                                <a href="#tab_6_3" data-toggle="tab">Bill</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab_6_4" data-toggle="tab"> More </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-9">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_6_1">
                                            <table class="table">
                                                <tr>
                                                    <td>1.Disable Accounts Date and System date Validation</td>												
                                                    <td><input type = "checkbox" id = "Enablepreviousdaykotbilling" name="Enablepreviousdaykotbilling" value="1"  class = "mdl-checkbox__input" <?php if($Enablepreviousdaykotbilling ==1){echo "checked"; } ?>>
                                                        <span class = "mdl-checkbox__label">yes</span>													    
                                                    </td>			
                                                </tr>
                                            </table> 
                                                
                                            </div>
                                            <div class="tab-pane fade" id="tab_6_2">
                                                <p>No Settings.</p>
                                            </div>
                                            <div class="tab-pane fade" id="tab_6_3">
                                                <table class="table">
                                                <tr>
                                                    <td>1.Enable Bill Printing.</td>												
                                                    <td><input type = "checkbox" id = "tposbillprintnew" name="tposbillprintnew" value="1" class = "mdl-checkbox__input" <?php if($tposbillprintnew ==1){echo "checked"; } ?>>
                                                        <span class = "mdl-checkbox__label">yes</span>													    
                                                    </td>																	
                                                </tr>
                                                <tr>
                                                <td>2.Enable Bill Short Link Through SMS.</td>												
                                                    <td><input type = "checkbox" id = "ShortLinkSMS" name="ShortLinkSMS" value="1" class = "mdl-checkbox__input" <?php if($ShortLinkSMS ==1){echo "checked"; } ?>>
                                                        <span class = "mdl-checkbox__label">yes</span>													    
                                                    </td>
                                                </tr>
                                                <tr>
                                                <td>3.Enable Bill Short Link Through Whatsapp.</td>												
                                                    <td><input type = "checkbox" id = "ShortLinkwhatsapp" name="ShortLinkwhatsapp" value="1" class = "mdl-checkbox__input" <?php if($ShortLinkwhatsapp ==1){echo "checked"; } ?>>
                                                        <span class = "mdl-checkbox__label">yes</span>													    
                                                    </td>
                                                </tr>
                                                </table>  
                                            </div>
                                            <div class="tab-pane fade" id="tab_6_4">
                                                <p>No Settings.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="EXEC" name="EXEC" value="<?php echo $BUT; ?>"  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"><?php echo $BUT; ?></button>                                
                                </form>
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