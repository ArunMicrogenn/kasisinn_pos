<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->css();
$this->pweb->ptop();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
?>
<style>
button{
  position: relative;
  width: 172px;
  height: 32px;
  font-size: 12px;
  background: #2196f3;
  border: none;
  box-shadow: none;
  outline: none;
  cursor: pointer;
  color: #fff;
  display: block;
  margin-top:20px;
}

.submenu{
  position: absolute;
  margin: 0;
  padding: 0;
  width:50%;
  background: #ccc;
  transform-origin: top;
  transform: perspective(1000px) rotateX(-90deg);
  transition: 0.5s;
  overflow-y: scroll;
  height: 200px;
}
.submenu::-webkit-scrollbar {
    display: none;
}
.submenu{
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.submenu.active{
  transform: perspective(1000px) rotateX(0deg);
  margin-left: 203px;
  position:absolute;
  top:10px;
  background: #fff;
}

.submenu li {
  list-style: none;
}

.submenu li  {
  display:block;
  padding: 5px;
  text-align: center;
  text-decoration: none;
  background:#efecec;
  color: #262626;
  border-bottom: 1px solid rgba(0, 0, 0,.2);
  transition: 0.5s;
  
}

.submenu li:last-child{
    border-bottom: none;
}

.submenu li:hover{
  background: #0d7ad0;
  color:#fff;
  transition: 1s;
  border-radius:5px;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">User Rights</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                            href="<?php echo scs_index ?>dashboard">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">User Rights</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">User Rights</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>User Rights</header>
                        <button id="panel-button" class="mdl-button mdl-js-button mdl-button--icon pull-right"
                            data-upgraded=",MaterialButton">
                            <i class="material-icons">more_vert</i>
                        </button>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body row">
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group row">
                                    <!-- <label>Outlet </label> -->
                                    <select class="form-control  select2" name="outlet" id="outlet">
                                        <option value="0" disabled selected>Select Group</option>
                                        <?php
                                            $sql = "select * from UserGroupPOS where Hotel_Id='".$_SESSION['MPOSCOMPANYID']."'";
                                            $ex = $this->db->query($sql);
                                            foreach($ex->result_array() as $row){           ?>
                                        <option <?php if(@$_POST['outlet'] ==$row['UserGroup_Id'] ){ echo "selected";} ?> value='<?php echo $row['UserGroup_Id']?>'><?php echo $row['UserGroup']?></option>
                                       <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 p-t-20 text-center">
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">GET</button>
                            </div>
                        </div>
                    </form>
                    <?php 
                    if(@$_POST['outlet'] != 0){
                        $userid = @$_POST['outlet'];
                        ?>
                    <div class="card-body row">
                        <div class="col-lg-6 p-t-20">
                            <?php 
                                $sq = "select m.Menustring as string , * from menupos m 
                                order by m.orderby";
                                $exe = $this->db->query($sq);
                                $grpname ='';
                                $i = 1;
                                $j = 1;
                            ?>

                        <div class="dropdown"> 
                            <?php 
                            foreach($exe->result_array() as $ro){ ?>
                            
                            <button id="btn<?php echo $i;?>>" class="buttoncount" <?php if($ro['string']!=''){ ?> onclick="formsubmit1('<?php echo $ro['MENU'];?>', '<?php echo $ro['UCID']?>')" <?php } else {?> onclick="func('<?php echo $i;?>')" <?php } ?>><?php echo $ro['MENU'];?></button>
                            <ul id="ul<?php echo $i;?>" class="submenu">
                               <?php
                                $sql1="select * from submenupos Where MNID=".$ro['UCID'];
                                $exe1 = $this->db->query($sql1);
                                foreach($exe1->result_array() as $row1){  ?> 
                                <a id="submenu" onclick="formsubmit(<?php echo $row1['MSID'];?>, '<?php echo $ro['UCID']?>','<?php echo $row1['SUBMENU']?>')">                                 
                                    <li>
                                        <input type="hidden" name ="userrights" id="menuid<?php echo $row1['MSID'];?>" value="<?php echo $row1['MSID']?>">
                                        <?php echo $row1['SUBMENU']?>
                                    </li>
                                </a>
                            <?php
                                }
                               ?>
                            </ul>                       
                            <?php
                              $i++;
                         /*    if($grpname != $ro['MENU'] ){ 
                                $grpname = $ro['MENU'];?>
                        
                       
                        <?php foreach($exe->result_array() as $row){ 
                            if($menuid == $row['UCID']){?>

                            <a id="submenu" onclick="formsubmit('<?php echo $j;?>', '<?php echo $row['UCID']?>')"><li>
                                <input type="hidden" name ="userrights" id="menuid<?php echo $j;?>" value="<?php echo $row['MSID']?>">
                                <?php echo $row['SUBMENU']?></li></a>

                          <?php } $j++;} ?>
                       } */

                         } ?>
                        </div>
                        </div>
                        <div id="Showoptions" class="col-lg-6 p-t-20">
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formsubmit1(a,b){
  //  let val = document.getElementById("btn"+a).value;
    $.ajax({
        type: 'POST',
        url: '<?php echo scs_index?>Users/GetSubmenuRights',  //GET ITEM Price any url
        data: {mainmenu:'mainmenu','MenuName':a,menuid: b, userid:<?php echo $userid;?>, mainmenuid:b},
        success: function(html) { 
            $("#Showoptions").html(html);
        }
    }); 
    }
   const formsubmit = (a,b,c)=>{

    let val = document.getElementById("menuid"+a).value;
    $.ajax({
        type: 'POST',
        url: '<?php echo scs_index?>Users/GetSubmenuRights',  //GET ITEM Price any url
        data: {mainmenu:'submenu','MenuName':c,menuid: val, userid:<?php echo $userid;?>, mainmenuid:b},
        success: function(html) { 
            $("#Showoptions").html(html);
        }
    }); 
   }

   const view = (value, menuid, userid, mmenuid)=>{

    $.ajax({
        type: 'POST',
        url: '<?php echo scs_index?>Users/updateView',  //GET ITEM Price any url
        data: {value: value, userid:userid, menuid:menuid, mmenuid:mmenuid},
        success: function(message){ 
            console.log(message)
        }
    }); 

   }


   const edit = (value, menuid, userid, mmenuid)=>{
    $.ajax({
        type: 'POST',
        url: '<?php echo scs_index?>Users/updateEdit',  //GET ITEM Price any url
        data: {value: value, userid:userid, menuid:menuid, mmenuid:mmenuid},
        success: function(message){ 
            console.log(message)
        }
    }); 

    }


    const add = (value, menuid, userid, mmenuid)=>{

    $.ajax({
        type: 'POST',
        url: '<?php echo scs_index?>Users/updateAdd',  //GET ITEM Price any url
        data: {value: value, userid:userid, menuid:menuid, mmenuid:mmenuid},
        success: function(message){ 
            console.log(message)
        }
    }); 

    }

    const deletee = (value, menuid, userid, mmenuid)=>{

    $.ajax({
        type: 'POST',
        url: '<?php echo scs_index?>Users/updateDelete',  //GET ITEM Price any url
        data: {value: value, userid:userid, menuid:menuid, mmenuid:mmenuid},
        success: function(message){ 
            console.log(message)
        }
    }); 

   
}

const func = (a) =>{
    let c = document.getElementsByClassName('buttoncount');
    for(i=1 ; i<=c.length; i++){
        let list = document.getElementById('ul'+i);
        let res = list.className.search('active');
        if(i == a){
            if(res >= 0){
                document.getElementById('ul'+i).classList.remove("active");
            }else{
                document.getElementById('ul'+i).classList.add("active");
            }
        }
        else{
             document.getElementById('ul'+i).classList.remove("active");
        }
    }
    
}


</script>
<?php
$this->pweb->wfoot($this->Menu, $this->session);
$this->pcss->wjs();
?>