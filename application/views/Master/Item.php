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
                                <div class="page-title">Item</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Item</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Item</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>Item</header>
									<button id = "panel-button" 
			                           class = "mdl-button mdl-js-button mdl-button--icon pull-right" 
			                           data-upgraded = ",MaterialButton">
			                           <i class = "material-icons">more_vert</i>
			                        </button>
			                        
								</div>
								<form action="<?php echo scs_index; ?>MsSql/Item" method="POST">
                                <input type="hidden" name="ID" id="ID" value="<?php echo @$ID; ?>">
								<div class="card-body row">
						            <div class="col-lg-6 p-t-20"> 
						              <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
					                     <input class = "mdl-textfield__input" type = "text" value="<?php echo @$Itemname; ?>" name="item" id = "item" required/>
					                     <label class = "mdl-textfield__label">Item Name</label>
					                  </div>
						            </div>
						            <div class="col-lg-6 p-t-20"> 
						              <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
					                     <input class = "mdl-textfield__input" type = "text" value="<?php echo @$ItemCode; ?>"  name="itemcode" id = "itemcode" required/>
					                     <label class = "mdl-textfield__label">Item Code</label>
					                  </div>
						            </div>  
									<div class="col-lg-6 p-t-20"> 
						              <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
					                     <input class = "mdl-textfield__input" type = "number" value="<?php echo @$Rate ?>" name="Rate" id = "Rate" pattern = "-?[0-9]*(\.[0-9]+)?" required/>
					                     <label class = "mdl-textfield__label">Rate</label>
					                  </div>
						            </div>
						            <?php 
									if(@$_SESSION['MPOSCOMPANYID']=='')
									{
									$sql="select * from Itemgroup"; 
									}
									else
									{  
									$sql="select * from Itemgroup where companyid='".$_SESSION['MPOSCOMPANYID']."'";
									}
									?>
						             <div class="col-lg-6 p-t-20"> 
						              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
								            <input class="mdl-textfield__input" type="text" id="Itemgroup" value="<?php echo @$Itemgroup ?>" onchange="itemgrouptax(this.value)" value="" name="Itemgroup" readonly tabIndex="-1">
								            <label for="Itemgroup" class="pull-right margin-0">
								                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
								            </label>
								            <label for="Itemgroup" class="mdl-textfield__label">Item Group</label>
								            <ul data-mdl-for="Itemgroup" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
											<?php 											
                                            $result=$this->db->query($sql);
                                            foreach ($result->result_array() as $row)	
											{
											?>
								                <li class="mdl-menu__item" data-val="<?php echo $row['Itemgroup']; ?>"><?php echo $row['Itemgroup']; ?></li>
											<?php 
											}
											?>
								            </ul>
								        </div>
						            </div>
								
									
									
									<div class="col-lg-6 p-t-20"> 
						              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
								            <input class="mdl-textfield__input" type="text" id="taxsetup" value="<?php echo @$taxsetupname ?>" name="taxsetup" readonly tabIndex="-1">
								            <label for="taxsetup" class="pull-right margin-0">
								                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
								            </label>
								            <label for="taxsetup" class="mdl-textfield__label">Tax Stup</label>
								            <ul data-mdl-for="taxsetup" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
											<?php 
											$sql="select * from taxsetupmas where companyid='".$_SESSION['MPOSCOMPANYID']."'";
                                            $result=$this->db->query($sql);
                                            foreach ($result->result_array() as $row)	
											{
											?>
								                <li class="mdl-menu__item" data-val="<?php echo $row['taxsetupname']; ?>"><?php echo $row['taxsetupname']; ?></li>
											<?php 
											}
											?>
								            </ul>
								        </div>
						            </div>
									<div class="col-lg-6 p-t-20"> 
						              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
								            <input class="mdl-textfield__input" type="text" id="Foodtype" value="<?php echo @$Foodtype ?>" name="Foodtype" readonly tabIndex="-1">
								            <label for="Foodtype" class="pull-right margin-0">
								                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
								            </label>
								            <label for="Foodtype" class="mdl-textfield__label">Food Type</label>
								            <ul data-mdl-for="Foodtype" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
											<?php 
											$sql="select * from mas_posFoodtype where companyid='".$_SESSION['MPOSCOMPANYID']."'";
                                            $result=$this->db->query($sql);
                                            foreach ($result->result_array() as $row)	
											{
											?>
								                <li class="mdl-menu__item" data-val="<?php echo $row['Foodtype']; ?>"><?php echo $row['Foodtype']; ?></li>
											<?php 
											}
											?>
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
									{
									?>
									<input type="hidden" value="<?php echo $_SESSION['MPOSCOMPANYID']; ?>" name="hotelcode">	
									<?php 
									}  
									if(@$_SESSION['MPOSCOMPANYID']=='')
									{
									$sql="select * from itemsubgroup2"; 
									}
									else
									{  
									$sql="select * from itemsubgroup2 where companyid='".$_SESSION['MPOSCOMPANYID']."'";
									}
									?>
						             <div class="col-lg-6 p-t-20"> 
						              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
								            <input class="mdl-textfield__input" type="text" id="itemsubgroup2" value="<?php echo @$Subgroupname2 ?>" name="itemsubgroup2" readonly tabIndex="-1">
								            <label for="itemsubgroup2" class="pull-right margin-0">
								                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
								            </label>
								            <label for="itemsubgroup2" class="mdl-textfield__label">Item Sub Group 1</label>
								            <ul data-mdl-for="itemsubgroup2" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
											<?php 
											$result=$this->db->query($sql);
                                            foreach ($result->result_array() as $row)	
											{
											?>
								                <li class="mdl-menu__item" data-val="<?php echo $row['Subgroupname2']; ?>"><?php echo $row['Subgroupname2']; ?></li>
											<?php 
											}
											?>
								            </ul>
								        </div>
						            </div> <?php
									if(@$_SESSION['MPOSCOMPANYID']=='')
									{
									$sql="select * from itemsubgroup3"; 
									}
									else
									{  
									$sql="select * from itemsubgroup3 where companyid='".$_SESSION['MPOSCOMPANYID']."'";
									}
									?>
						             <div class="col-lg-6 p-t-20"> 
						              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
								            <input class="mdl-textfield__input" type="text" id="itemsubgroup3" value="<?php echo @$Subgroupname3 ?>" name="itemsubgroup3" readonly tabIndex="-1">
								            <label for="itemsubgroup3" class="pull-right margin-0">
								                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
								            </label>
								            <label for="itemsubgroup3" class="mdl-textfield__label">Item Sub Group 2</label>
								            <ul data-mdl-for="itemsubgroup3" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
											<?php 
                                            $result=$this->db->query($sql);
                                            foreach ($result->result_array() as $row)	
											{
											?>
								                <li class="mdl-menu__item" data-val="<?php echo $row['Subgroupname3']; ?>"><?php echo $row['Subgroupname3']; ?></li>
											<?php 
											}
											?>
								            </ul>
								        </div>
						            </div>
                                    <?php 
                                        if(@$Inactive=='' || @$Inactive=='0')
                                        {
                                            $Active='Active';
                                        }
                                        else
                                        {
                                            $Active='Inactive';
                                        }
                                    ?>
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