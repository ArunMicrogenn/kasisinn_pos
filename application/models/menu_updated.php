<?php

class Menu extends CI_Model
{
    function TopMenu_($Session)
	{
        $count=0;
        if(@$_SESSION['MPOSCOMPANYID'])
        {
        $sql="SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid=".$_SESSION['MPOSCOMPANYID'];
        }
        else
        {
        $sql="SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) ";	 
        }						 
        $result=$this->db->query($sql);
        $no= $result->num_rows();      
        if($no==0)
        { $count=$count+1;  }
        $sql1="select * from online_Trans_reskot_mas mas
               inner join headings head on mas.restypeid=head.id
            where head.companyid='".$_SESSION['MPOSCOMPANYID']."' and isnull(mas.Raised,0)=0";	       
       $result1=$this->db->query($sql1);
       $no1= $result1->num_rows();        
       if($no1 !=0)
       { $count=$count+$no1;  }
       ?>
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="fa fa-bell-o"></i>
            <span class="badge headerBadgeColor1"><?php echo $count; ?></span>
        </a>
        <ul class="dropdown-menu animated swing">
            <li class="external">
                <h3><span class="bold">Notifications</span></h3>
                <span class="notification-label purple-bgcolor">New <?php echo $count; ?></span>
            </li>
            <li>
                <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                    <?php 
                    if($no==0)
                    {
                    ?>
                    <li>
                        <a href="<?php echo scs_index; ?>Date_End_Process">
                            <span class="time">Click Here</span>
                            <span class="details">
                            <span class="notification-icon circle yellow"><i class="fa fa-warning"></i></span>Please to Change Accounts Date.!</span>
                        </a>
                    </li>  
                    <?php 
                        }
                    $sql1="select * from online_Trans_reskot_mas mas
                        inner join headings head on mas.restypeid=head.id
                            where head.companyid='".$_SESSION['MPOSCOMPANYID']."' and isnull(mas.Raised,0)=0";	                  
                    $result1=$this->db->query($sql1);                  
                    foreach ($result1->result_array() as $row1)
                    {
                    ?>
                        <li>
                        <a href="onlineorderaccept.php?Kotid=<?php echo base64_encode($row1['Kotid']); ?>">
                            <span class="time">Click Here</span>
                            <span class="details">
                            <span class="notification-icon circle deepPink-bgcolor"><i class="fa fa-check"></i></span>New Order No:<?php echo $row1['Refno']; ?></span>
                        </a>
                    </li>  
                    <?php 
                    }
                    ?>
                </ul>
                <div class="dropdown-menu-footer">
                    <a href="javascript:void(0)"> All notifications </a>
                </div>
            </li>
        </ul>
    <?php

    }
    function Menu_($Session)
	{
        if($_SESSION['MPOSUSERNAME']=='superadmin') 
		     {   $sql="select mn.Menustring,mn.MENU,mn.UCID from MENU mn order by orderby"; }
	    else {	 $sql="select mn.Menustring,mn.MENU,mn.UCID from MENU mn where isnull(isadmin,0)=0 order by orderby"; }
        $result=$this->db->query($sql);  
        foreach ($result->result_array() as $row)
        {
            $status="";											
            if($row['Menustring'] !='')
            { 													
             if($row['Menustring'] == basename($_SERVER['PHP_SELF']))
             { $status="active";}
                echo '<li class="nav-item start '.$status.'">
	                <a href="'.scs_index.$row['Menustring'].'" class="nav-link nav-toggle">
	                    <i class="material-icons">dashboard</i>
	                    <span class="title">'.$row['MENU'].'</span>                                	
	                </a>	                            
	            </li>';
            }
            else
            
			{	$sql1="select * from submenu where MNID='".$row['UCID']."' and Menustring='".basename($_SERVER['PHP_SELF'])."'";				    
                $result1=$this->db->query($sql1);  
                $no1= $result1->num_rows(); 				
				if($no1 !='0')
				{$status="active";}
                echo '<li class="nav-item '.$status.'">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="material-icons">subtitles</i>
                            <span class="title">'.$row['MENU'].'</span>
                            <span class="arrow"></span>
                        </a>							
                        <ul class="sub-menu">';                
                            if($_SESSION['MPOSUSERNAME']=='superadmin')
                            {$sql1="select * from submenu where MNID='".$row['UCID']."'";	}
                            else
                            { $sql1="select * from submenu sm
                                inner join User_GroupRights ug on sm.MSID= ug.SubMenu_Id and sm.MNID='".$row['UCID']."'
                                inner join usergroup ugr on ugr.UserGroup_Id = ug.UserGroup_Id   
                                where  ug.Fview <>0 or ug.Fedit <> 0 or  ug.Fadd <> 0 or ug.Fdelete <> 0 and ugr.UserGroup_Id='".$_SESSION['MPOSUSERID']."'";	}
                            $result1=$this->db->query($sql1);  
                            foreach ($result1->result_array() as $row1)                  
                            {	
                                if($row1['FAdd']=='1' || $row1['FEdit']=='1' || $row1['Fview']=='1')
                                {
                                 if($row1['Menustring'] == basename($_SERVER['PHP_SELF']))
                                { $status1="active";}
                                else
                                { $status1=""; }                 
                            echo '<li class="nav-item '.$status1.'">
                                    <a href="'.scs_index.$row1['Menustring'].'" class="nav-link ">
                                    <span class="title">'.$row1['SUBMENU'].'</span>
                                    </a>
                                </li>';
                            } 
                        }            
                   echo '</ul>								
                        </li>';
            }
            
        }
    }
    function Menu_1($Session)
	{
        if($_SESSION['MPOSUSERNAME']=='superadmin') 
		     {   $sql="select mn.Menustring,mn.MENU,mn.UCID from MENU mn order by orderby"; }
	    else {	 $sql="select mn.Menustring,mn.MENU,mn.UCID from MENU mn where isnull(isadmin,0)=0 order by orderby"; }
        $result=$this->db->query($sql);  
        foreach ($result->result_array() as $row)
        {
            $status="";		
 		    if($row['Menustring'] !='')
			   { 														
				if($row['Menustring'] == basename($_SERVER['PHP_SELF']))
			    { $status="active";}
                ?>
                    <li class="nav-item start <?php echo $status; ?> ">
                        <a href="<?php echo $row['Menustring']; ?>" class="nav-link nav-toggle">
                            <i class="material-icons">dashboard</i>
                            <span class="title"><?php echo $row['MENU']; ?></span>                                	
                        </a>	                            
                    </li>	
                <?php
               }

        }
    }
    function Footer($Session)
    {  ?>
        <!-- start footer -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>    
            $(document).ready(function () {
                refresh_Div();
            });

            var i = 1;
            function refresh_Div() {
                $('#books').empty();
                $.ajax({
                type: 'POST',
                url: '<?php echo scs_index ?>/kotoutlet/getonlinenotification',  //GET ITEM Price any url
                data: {label: <?php echo $_SESSION['MPOSCOMPANYID']; ?>},
                success: function(message) { 	
                if(message==1)
                {
                   // var url="http://192.169.178.237/alerm.mp3";
                    //const audio = new Audio(url);
                    //audio.play();
                    var audio = new Audio('http://192.169.178.237/alerm.mp3');
                    audio.play();
                    //  alert("fff");
                    $( "#top-menu" ).load(window.location.href + " #top-menu" );
                }
                },
                dataType: 'json'
                }); 
            //  alert("ddd");
            }

            var reloadXML = setInterval(refresh_Div, 20000);
        </script>
		<?php 
        $sql="select Top 1 * from date_change_bar where Companyid='".@$_SESSION['MPOSCOMPANYID']."' order by Newdate";
		$result=$this->db->query($sql);  
        foreach ($result->result_array() as $row)        
		{ $Newdate= $row['Newdate'];    }				?>
		    <div class="page-footer">
		     <div style="color: white;" class="pull-left">System Date: <?php echo date('d/m/Y'); ?> - Audit Date : <?php echo date("d/m/Y", strtotime(@$Newdate) ); ?>
			</div>
			 <div style="color: white;" class="pull-right">Microgenn Software Solutions
			  	</div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- end footer --> <?php
    }
}
?>