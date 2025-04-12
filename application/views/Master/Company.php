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
                            <div class="page-title">Company</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li><a class="parent-item" href="">Forms</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Company</li>
                        </ol>
                    </div>
                </div>
                
                <!-- This Part Must that only we display hiden 08092021/ Ravi -->
                <div class="row">
                    <div class="col-sm-12" style="display:none">
                            <div class="card-box">
                                <div class="card-head">
                                    <header>Create Company</header>
                                </div>
                                <div class="card-body ">
                                
                                <div id="wizard">
                                    <h1>First Step</h1>
                                    <div>First Content</div>
                                    <h1>Second Step</h1>
                                    <div>Second Content</div>
                                </div>
                                </div>
                            </div>
                        </div>
                </div>					
                <!-- wizard with validation-->
                
                <div class="row">
                    <div class="col-sm-12">
                            <div class="card-box">
                                <div class="card-head">
                                    <header>Company</header>
                                </div>
                                <div class="card-body ">
                                <form  action="<?php echo scs_index; ?>MsSql/Company" id="example-advanced-form" method="POST" action="">
                                <input type="hidden" name="ID" id="ID" value="<?php echo @$ID; ?>">
                                <input type="hidden" id="EXEC" name="EXEC" value="<?php echo $BUT; ?>" >
                                    <h3>Company Profile</h3>
                                        <fieldset>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$company ?>" type="text" id="Company" name="Company" required/>
                                            <label class="mdl-textfield__label">Company Name</label>
                                            <span class="mdl-textfield__error">Enter Company Name!</span>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$address1 ?>" type="text" id="address" name="address" required/>
                                            <label class="mdl-textfield__label" >Address </label>
                                            <span class="mdl-textfield__error">Enter Address!</span>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$address2 ?>" type="text" id="address1" name="address1" />
                                            <label class="mdl-textfield__label" >Landmark </label>												
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input"  value="<?php echo @$City ?>" type="text" id="city" name="city" required/>
                                            <label class="mdl-textfield__label" >City</label>
                                            <span class="mdl-textfield__error">Enter City!</span>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input"  value="<?php echo @$e_mail ?>"  type="email" id="email" name="email" />
                                            <label class="mdl-textfield__label" >Email</label>												
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class = "mdl-textfield__input" value="<?php echo @$mobile ?>" type = "number" id="mobile" name="mobile" pattern = "-?[0-9]*(\.[0-9]+)?" >
                                            <label class="mdl-textfield__label" >Mobile</label>
                                            <span class="mdl-textfield__error">Enter Mobile!</span>
                                        </div>
                                        
                                    </fieldset>
                                    
                                    <h3>Account Information</h3>
                                    <fieldset>
                                        <div class="col-lg-12 p-t-20"> 
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input"  value="<?php echo @$gstno ?>"  type="text" id="gst" name="gst" />
                                            <label class="mdl-textfield__label" >GST Number</label>												
                                        </div>
                                        
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$Username ?>" type="text" pattern="[A-Z,a-z]*" name="userName" id="username" required/>
                                            <label class="mdl-textfield__label" for="username">POS Username</label>
                                            <span class="mdl-textfield__error">Enter POS User Name!</span>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$pass ?>" type="password"  id="password-2" name="password" required/>
                                            <label class="mdl-textfield__label" for="password-2">POS Password</label>
                                            <span class="mdl-textfield__error">Enter Valid Password!</span>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$pass ?>" type="password" id="confirm-2" name="confirm"  required/>
                                            <label class="mdl-textfield__label" >POS Confirm Password</label>
                                            <span class="mdl-textfield__error">Enter Valid Password!</span>
                                        </div>
                                        </div>
                                    </fieldset>
                                    <h3>Finish</h3>
                                    <fieldset>
                                        <div class="col-lg-12 p-t-20"> 
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
                                                <input type="checkbox" id="checkbox-1" name="acceptTerms" class="mdl-checkbox__input" required>
                                                <span class="mdl-checkbox__label">I agree with the Terms and Conditions.</span>
                                            </label>
                                        </div>
                                    </fieldset>
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