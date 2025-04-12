<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pcss->hjs();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
?>
 
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <div class="page-wrapper">
        <!-- start header -->
			 <!-- end sidebar menu -->
			<!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">                    
                     <div class="row">
						<div class="col-sm-12">
							<div class="card-box">								
								<div class="card-body row">
								<?php 
								$sql="select tochkotscreen,* from headings where companyid='".@$_SESSION['MPOSCOMPANYID']."' and isnull(isvisible,0)=1";
								$res = $this->db->query($sql);
								foreach ($res-> result_array() as $row)
								{
								?>
						           <div class="col-lg-3" style="text-align:center;" id="typeid<?php echo $row['id']; ?>" onclick="viewtypeid(<?php echo $row['id']; ?>,<?php echo $row['tochkotscreen']; ?>);">
									<a>	<img style="width:40%;" src="../assets/img/dine-in.png">
									<h6 class="content-group text-semibold" style="color: #263238;margin-top:20px;"><?php echo $row['Name'] ?></h6>
									</a>
								   </div>	
								<?php
								} ?>
								</div>
							</div>
						</div>
					</div> 
                </div>
            </div>
            <!-- end page content -->
          
            <!-- end chat sidebar -->
        </div>
        <!-- end page container -->
        <!-- start footer -->
        <!-- end footer -->
    </div>
	<!-- start footer -->
<?php
$this->pweb->wfoot($this->Menu, $this->session);
$this->pcss->wjs();
?>
</body>
	<script>
	function viewtypeid(obj)
	{
		window.location.href ='<?php echo scs_index ?>kotoutlet/tablelist/'+obj;	
	}
	
	</script>
