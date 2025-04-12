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
                                <div class="page-title">User Group</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">User Group</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">User Group</li>
                            </ol>
                        </div>
                    </div>
                     <div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>User Group</header>
									<button id = "panel-button" 
			                           class = "mdl-button mdl-js-button mdl-button--icon pull-right" 
			                           data-upgraded = ",MaterialButton">
			                           <i class = "material-icons">more_vert</i>
			                        </button>
			                        
								</div>
								<form action="<?php echo scs_index; ?>MsSql/UserGroup" method="POST">
								<input type="hidden" name="UserGroup_Id" id="UserGroup_Id" value="<?php echo @$UserGroup_Id; ?>">
								<input type="hidden" name="companyid" id="companyid" value="<?php echo $_SESSION['MPOSCOMPANYID']; ?>">
								<div class="card-body row">
								    <div class="col-lg-6 p-t-20"> 
						              <div class = "mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
					                     <input class = "mdl-textfield__input" type = "text" name="name" value="<?php echo @$UserGroup; ?>" id = "name" required/>
					                     <label class = "mdl-textfield__label">User Group</label>
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