<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->lcss();
$this->pcss->hjs()
?>	
<body>
    <div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="<?php echo scs_index?>login">
					<span class="login100-form-logo">
						<img src="<?php echo scs_url ?>/assets/img/logo1.png"?>
					</span>
					<span class="login100-form-title p-b-34 p-t-27">
						Welcome to M-POS
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" required name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" required name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter Hotel Code">
						<input class="input100" type="text" name="hotelcode" placeholder="Hotel Code">
						<span class="focus-input100" data-placeholder="&#xf1ad;"></span>
					</div>
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="Login" id="Login">
							Login
						</button>
					</div>
					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Mpos Version 1.0
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
 <!-- end js include path -->
</body>
<?php
$this->pcss->wjs();
?>
</html>
