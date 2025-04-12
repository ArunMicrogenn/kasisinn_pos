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
                                <div class="page-title">Users</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Users</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Users</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>Users</header>
									<button id = "panel-button" 
			                           class = "mdl-button mdl-js-button mdl-button--icon pull-right" 
			                           data-upgraded = ",MaterialButton">
			                           <i class = "material-icons">more_vert</i>
			                        </button>
			                        
								</div>
								<form action="<?php echo scs_index; ?>MsSql/Users" method="POST">
								<input type="hidden" name="userid" id="userid" value="<?php echo @$Userid; ?>">
								<input type="hidden" name="companyid" id="companyid" value="<?php echo $_SESSION['MPOSCOMPANYID']; ?>">
								<div class="card-body row">
								    <div class="col-lg-6 p-t-20"> 
						              <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
					                     <input class = "mdl-textfield__input" type = "text" name="name" value="<?php echo @$Username; ?>" id = "name" required/>
					                     <label class = "mdl-textfield__label">Username</label>
					                  </div>
						            </div>
									<div class="col-lg-6 p-t-20">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<input class="mdl-textfield__input" value="<?php echo @$pass ?>" type="password" minlength="3" maxlength="8" id="password-2" name="password" required/>
											<label class="mdl-textfield__label" for="password-2">Password</label>
											<span class="mdl-textfield__error">Enter Valid Password!</span>
										</div>
									</div> 
									<div class="col-lg-6 p-t-20">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                            <input class="mdl-textfield__input" value="<?php echo @$pass ?>" type="password" id="confirm-2" minlength="3" maxlength="8" name="confirm"  required/>
                                            <label class="mdl-textfield__label" >Confirm Password</label>
                                            <span class="mdl-textfield__error">Enter Valid Password!</span>
                                        </div>
									</div>
									
									<div class="col-lg-6 p-t-20"> 
						              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
								            <input class="mdl-textfield__input" type="text" id="Inactive" value="<?php echo  @$UserGroup;?>" name="groupid" readonly tabIndex="-1">
								            <label for="Inactive" class="pull-right margin-0">
								                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
								            </label>
								            <label for="Inactive" class="mdl-textfield__label">User Group</label>
								            <ul data-mdl-for="Inactive" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
												<?php 
												$sql="select * from UserGroupPOS where hotel_id='".$_SESSION['MPOSCOMPANYID']."'";
												$result=$this->db->query($sql);
												foreach($result->result_array() as $row){
												?>
											       <li class="mdl-menu__item" data-val="<?php echo $row['UserGroup_Id']?>"><?php echo $row['UserGroup']?></li>
												 <?php } ?>									
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
	  ?>      <!-- end footer -->
 	<script>
	function viewtypeid(obj)
	{
		window.location.href ='tablelist.php?outletid='+obj;	
	}
	
	</script>
	<?php 
		$this->pcss->wjs();
	?>   


</body>
</html>