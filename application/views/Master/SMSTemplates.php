<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);

if($ID==1)
{
    $msg =$resbillmsg;
}
else if($ID==2)
{
    $msg =$appotpmsg;
}
?>
<style type="text/css">
	.context-menu {
		position: absolute;
		text-align: center;
		background: lightgray;
		border: 1px solid black;
	}

	.context-menu ul {
		padding: 0px;
		margin: 0px;
		min-width: 150px;
		list-style: none;
	}

	.context-menu ul li {
		padding-bottom: 7px;
		padding-top: 7px;
		border: 1px solid black;
	}

	.context-menu ul li a {
		text-decoration: none;
		color: black;
	}

	.context-menu ul li:hover {
		background: darkgray;
	}
</style>

	<style type="text/css">
		.context-menu {
			position: absolute;
			text-align: center;
			background: lightgray;
			border: 1px solid black;
		}

		.context-menu ul {
			padding: 0px;
			margin: 0px;
			min-width: 150px;
			list-style: none;
		}

		.context-menu ul li {
			padding-bottom: 7px;
			padding-top: 7px;
			border: 1px solid black;
		}

		.context-menu ul li a {
			text-decoration: none;
			color: black;
		}

		.context-menu ul li:hover {
			background: darkgray;
		}
	</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">SMS Templates</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">SMS Templates </li>
                </ol>
            </div>
        </div>
            <!-- add content here -->
            <div class="row">
            <div class="col-md-12 col-sm-12">
            <form action="<?php echo scs_index; ?>MsSql/SMSTemplates" method="POST">
				<input type="hidden" name="ID" id="ID" value="<?php echo @$ID; ?>">
                <textarea style="height:200px; width:100%"  id="area" name="area" cols="30" rows="10"><?php echo @$msg; ?></textarea>							
                <button type="submit" id="EXEC" name="EXEC" value="<?php echo $BUT; ?>" class="btn btn-primary"><?php echo $BUT; ?></button>                
            </form>	
            </div>
                <div id="contextMenu" class="context-menu"
                    style="display:none">
                    <ul>
                        <a href="#" onclick="paste('*otp*')" id="OTP"><li>OTP</li></a>									
                        <a href="#" onclick="paste('*cnam*')" id="CName"><li>CompanyName</li></a>									
                        <a href="#" onclick="paste('*onam*')" id="OName"><li>OutletName</li></a>									
                    </ul>
                </div>
        </div>
    </div>
</div>


<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
?>
	<script>
		document.onclick = hideMenu;
		document.oncontextmenu = rightClick;

		function hideMenu() {
			document.getElementById("contextMenu").style.display = "none"
		}

		function rightClick(e) {
			e.preventDefault();

			if (document.getElementById("contextMenu").style.display == "block")
				hideMenu();
			else {
				var menu = document.getElementById("contextMenu")
					
				menu.style.display = 'block';
				menu.style.left = e.pageX + "px";
				menu.style.top = e.pageY + "px";
			}
		}
	</script>
	 <script>
     function paste(boj) {
	//            var pasteText = document.querySelector("#text");
			var pasteText =document.getElementById("area");			
			 pasteText.focus();
            document.execCommand("paste");
            pasteText.value = pasteText.value + boj;
        }
   </script>
<?php 
$this->pcss->wjs();
?>