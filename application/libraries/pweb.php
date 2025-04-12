<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pweb {

    public function phead()
    {
        echo '<!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta content="width=device-width, initial-scale=1" name="viewport" />
                <meta name="description" content="Microgenn POS" />
                <meta name="author" content="Raveendran.N" />
                <title>POS | Microgenn Software Solurions</title>
                <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
                <link rel="icon"href="'.scs_url.'assets/img/favicon.ico" type="image/png"/>';
    }
    public function ptop()
    {
        echo '</head> 
        <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
        <div class="page-wrapper">';
    }
    public function ptop1()
    {
        echo '</head> 
        <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white sidemenu-closed dark-sidebar-color logo-dark">
        <div class="page-wrapper">';
    }
    public function wheader($Menu,$Session)
    {  ?>
        <div id="books" style="margin:5px 0;"></div>
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <!-- logo start -->
                <div class="page-logo">
                    <a href="<?php echo scs_index?>dashboard">
                    <img alt="" src="<?php echo scs_url; ?>assets/img/logo.png">
                    <span class="logo-default" >M-POS</span> </a>
                </div>
                <!-- logo end -->
				<ul class="nav navbar-nav navbar-left in">
					<li><a href="#" class="menu-toggler sidebar-toggler"><i class="icon-menu"></i></a></li>
				</ul>               
                
                <!-- start mobile menu -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
               <!-- end mobile menu -->
                <!-- start header menu -->
                <div id="top-menu" class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                       <!-- start notification dropdown -->
						 <li class="dropdown dropdown-quick-sidebar-toggler">
                             <a id="headerSettingButton" style="position:relative;font-size:20px;color:#188ae2 !important;padding-top:5px !important" > Restaurant </a>
                        </li>
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
				<?php 
                        $Menu->TopMenu_($Session);							
                    ?>
                        </li>
                        <!-- end notification dropdown -->
                       
                        <!-- end message dropdown -->
 						<!-- start manage user dropdown -->
 						<li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle " src="<?php echo scs_url; ?>assets/img/dp.jpg" />
                                <span class="username username-hide-on-mobile"> <?php echo $_SESSION['MPOSUSERNAME'] ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default animated jello">
                                <li>
                                    <a href="#">
                                        <i class="icon-user"></i> Profile </a>
                                </li>
                                
                                <li>
                                    <a href="<?php echo scs_index?>logout">
                                        <i class="icon-logout"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
<?php
    }
    public function menu($Menu,$Session,$F_Ctrl,$F_Class)
    {
         $M_Class="sidemenu page-header-fixed p-t-20";
         if($F_Ctrl=='SingleScreenOperation')
         {
            $M_Class="sidemenu page-header-fixed p-t-20 sidemenu-closed";
         }
     echo '<div class="page-container">';
     echo '<div class="sidebar-container">
            <div class="sidemenu-container navbar-collapse collapse fixed-menu">
                <div id="remove-scroll">
                    <ul class="'.$M_Class.'" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="sideba/r-toggler-wrapper hide">
                            <div class="sidebar-toggler">
                            <span></span>
                            </div>
                        </li>	 ';
        $Menu->Menu_($Session,$F_Ctrl,$F_Class);		
        echo         '</ul>
                </div>
            </div>
        </div>';		
    }
    public function menu1($Menu,$Session)
    {
     echo '<div class="page-container">';
     echo '	<div class="sidebar-container">
                <div class="sidemenu-container navbar-collapse collapse fixed-menu">
                    <div id="remove-scroll">
                    <ul class="sidemenu page-header-fixed sidemenu-closed p-t-20" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>';
                     $Menu->Menu_1($Session);		
        echo         '</ul>
                </div>
            </div>
        </div>';		
    }
    public function wfoot($Menu,$Session)
    {
        echo '</div>';
        $Menu->Footer($Session);
        echo '</div>';						

    }
    public function wfoot1($Menu,$Session)
    {
        echo '</div>';       
        echo '</div>';						

    }
}
?>