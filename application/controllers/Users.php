<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users extends CI_Controller {

    public function Users()
	{ 
        $data=array('F_Class'=>'Users','F_Ctrl'=>'Users');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);      
    }

    public function Add_Users($BUT='SAVE')
	{ 
        $data=array('F_Class'=>'Users','F_Ctrl'=>'Add_Users','BUT'=>$BUT);          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);      
    }


    public function Edit_Users($ID=-1,$BUT='UPDATE')
    {       
       $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Users','F_Ctrl'=>'Add_Users');
       if($ID!=-1)
		{ 
			$REC=$this->Myclass->Users($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function UserRights()
    {
        $data=array('F_Class'=>'Users','F_Ctrl'=>'UserRights');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function Password()
	{ 
        $data=array('F_Class'=>'Users','F_Ctrl'=>'Password');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);      
    }

    public function Edit_Password($ID=-1,$BUT='UPDATE')
	{ 
        $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Users','F_Ctrl'=>'Edit_Password');
       if($ID!=-1)
		{ 
			$REC=$this->Myclass->Users($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);  
    }
    public function GetSubmenuRights(){
        if($_REQUEST['mainmenu']=='mainmenu')
        {
            $sq = "select * from menupos where UCID='".$_REQUEST['mainmenuid']."'";
            $exe = $this->db->query($sq);
            foreach($exe->result_array() as $rr){
                $menuname = $rr['MENU'];
            }
            $sql = "select isnull(Fview,0) Fview, isnull(Fedit,0) edit,isnull(Fadd,0) Fadd, isnull(Fdelete,0) Fdelete , SubMenu_Id
            from User_groupRightspos where Mainmenu_id='".$_REQUEST['menuid']."' and UserGroup_Id='".$_REQUEST['userid']."'";
            $ex = $this->db->query($sql);
            $no = $ex->num_rows();
            if($no != 0){
                echo '<h4>'.$_REQUEST['MenuName'].'</h4>';
                echo '<ul style="list-style:none;">';
                foreach($ex->result_array() as $row){
                    echo '<li>';?>
                    
                    <input type="checkbox" <?php if($row['Fview'] !=0){echo "checked"; }?> onClick="view(this.value, '<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" name="groupright" value="<?php echo $row['Fview']; ?>"> View
                    <?php
                    echo '</li>';
                    echo '<li>';?>
                    
                    <input type="checkbox" <?php if($row['edit'] !=0){echo "checked"; }?>  onClick="edit(this.value,'<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" name="groupright"  value="<?php echo $row['edit']; ?>"> Edit
                    <?php
                    echo '</li>';
                    echo '<li>';?>
                    
                    <input type="checkbox" <?php if($row['Fadd'] !=0){echo "checked";} ?> onClick="add(this.value,'<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');"name="groupright" value="<?php echo $row['Fadd']; ?>"> Add
                    <?php
                    echo '</li>';
                    echo '<li>';?>
                    
                    <input type="checkbox" <?php if($row['Fdelete'] !=0){echo "checked"; }?> onClick="deletee(this.value,'<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" name="groupright" value="<?php echo $row['Fdelete']; ?>"> Delete
                    <?php
                    echo '</li>';
                }
                echo '</ul>';
            }
            else{
                echo '<h4>'.$_REQUEST['MenuName'].'</h4>';
                echo '<ul style="list-style:none;">';
            
                    echo '<li>';?>
                    
                    <input type="checkbox" name="groupright" onClick="view(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> View
                    <?php
                    echo '</li>';
                    echo '<li>';?>
                    
                    <input type="checkbox" name="groupright"  onClick="edit(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> Edit
                    <?php
                    echo '</li>';
                    echo '<li>';?>
                    
                    <input type="checkbox"  name="groupright" onClick="add(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> Add
                    <?php
                    echo '</li>';
                    echo '<li>';?>
                    
                    <input type="checkbox"  name="groupright" onClick="deletee(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> Delete
                    <?php
                    echo '</li>';
            
                echo '</ul>';
            }
        }  
        else
        {
              
                $sql = "select isnull(Fview,0) Fview, isnull(Fedit,0) edit,isnull(Fadd,0) Fadd, isnull(Fdelete,0) Fdelete , SubMenu_Id
                from User_groupRightspos where subMenu_id='".$_REQUEST['menuid']."' and UserGroup_Id='".$_REQUEST['userid']."'";
                $ex = $this->db->query($sql);
                $no = $ex->num_rows();
                if($no != 0){
                    echo '<h4>'.$_REQUEST['MenuName'].'</h4>';
                    echo '<ul style="list-style:none;">';
                    foreach($ex->result_array() as $row){
                        echo '<li>';?>
                        
                        <input type="checkbox" <?php if($row['Fview'] !=0){echo "checked"; }?> onClick="view(this.value, '<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" name="groupright" value="<?php echo $row['Fview']; ?>"> View
                        <?php
                        echo '</li>';
                        echo '<li>';?>
                        
                        <input type="checkbox" <?php if($row['edit'] !=0){echo "checked"; }?>  onClick="edit(this.value,'<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" name="groupright"  value="<?php echo $row['edit']; ?>"> Edit
                        <?php
                        echo '</li>';
                        echo '<li>';?>
                        
                        <input type="checkbox" <?php if($row['Fadd'] !=0){echo "checked";} ?> onClick="add(this.value,'<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');"name="groupright" value="<?php echo $row['Fadd']; ?>"> Add
                        <?php
                        echo '</li>';
                        echo '<li>';?>
                        
                        <input type="checkbox" <?php if($row['Fdelete'] !=0){echo "checked"; }?> onClick="deletee(this.value,'<?php echo $row['SubMenu_Id']?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" name="groupright" value="<?php echo $row['Fdelete']; ?>"> Delete
                        <?php
                        echo '</li>';
                    }
                    echo '</ul>';
                }else{
                    echo '<h4>'.$_REQUEST['MenuName'].'</h4>';
                    echo '<ul style="list-style:none;">';
                
                        echo '<li>';?>
                        
                        <input type="checkbox" name="groupright" onClick="view(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> View
                        <?php
                        echo '</li>';
                        echo '<li>';?>
                        
                        <input type="checkbox" name="groupright"  onClick="edit(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> Edit
                        <?php
                        echo '</li>';
                        echo '<li>';?>
                        
                        <input type="checkbox"  name="groupright" onClick="add(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> Add
                        <?php
                        echo '</li>';
                        echo '<li>';?>
                        
                        <input type="checkbox"  name="groupright" onClick="deletee(this.value,'<?php echo $_REQUEST['menuid'];?>', '<?php echo $_REQUEST['userid']?>','<?php echo $_REQUEST['mainmenuid']?>');" value="0"> Delete
                        <?php
                        echo '</li>';
                
                    echo '</ul>';
                }
            }          


        
    }


    public function updateView(){

        $sql = "select * from user_grouprightspos where UserGroup_Id = '".$_REQUEST['userid']."' and submenu_id='".$_REQUEST['menuid']."'";
        $ex = $this->db->query($sql);
        $no = $ex->num_rows();
        $up = '';
        $value = 0;
        if($_REQUEST['value'] == 1){
            $value = 0;
        }
        if($_REQUEST['value'] == 0){
            $value = 1;
        }
        if($no !=0){
           $up = $up."update user_grouprightspos set Fview = '".$value."' where UserGroup_Id = '".$_REQUEST['userid']."' and SubMenu_Id='".$_REQUEST['menuid']."'";
            
        }else{
            $up = $up."insert into user_grouprightspos (Fview, Fadd, Fedit, Fdelete,UserGroup_id, mainmenu_id, submenu_id)
            values('1', '0', '0','0','".$_REQUEST['userid']."','".$_REQUEST['mmenuid']."', '".$_REQUEST['menuid']."') ";
        }

        $exx = $this->db->query($up);
        if($exx){
            echo "success";
        }
    }


    public function updateEdit(){

        $sql = "select * from user_grouprightspos where UserGroup_Id = '".$_REQUEST['userid']."' and submenu_id='".$_REQUEST['menuid']."'";
        $ex = $this->db->query($sql);
        $no = $ex->num_rows();
        $up = '';
        $value = 0;
        if($_REQUEST['value'] == 1){
            $value = 0;
        }
        if($_REQUEST['value'] == 0){
            $value = 1;
        }
        if($no !=0){
           $up = $up."update user_grouprightspos set Fedit = '".$value."' where UserGroup_Id = '".$_REQUEST['userid']."' and SubMenu_Id='".$_REQUEST['menuid']."'";
            
        }else{
            $up = $up."insert into user_grouprightspos(Fview, Fadd, Fedit, Fdelete,UserGroup_id, mainmenu_id, submenu_id)
            values('0', '0', '1','0','".$_REQUEST['userid']."','".$_REQUEST['mmenuid']."', '".$_REQUEST['menuid']."') ";
        }

        $exx = $this->db->query($up);
        if($exx){
            echo "success";
        }
    }

    public function updateAdd(){

        $sql = "select * from user_grouprightspos where UserGroup_Id = '".$_REQUEST['userid']."' and submenu_id='".$_REQUEST['menuid']."'";
        $ex = $this->db->query($sql);
        $no = $ex->num_rows();
        $up = '';
        $value = 0;
        if($_REQUEST['value'] == 1){
            $value = 0;
        }
        if($_REQUEST['value'] == 0){
            $value = 1;
        }
        if($no !=0){
           $up = $up."update user_grouprightspos set Fadd = '".$value."' where UserGroup_Id = '".$_REQUEST['userid']."' and SubMenu_Id='".$_REQUEST['menuid']."'";
            
        }else{
            $up = $up."insert into user_grouprightspos(Fview, Fadd, Fedit, Fdelete,UserGroup_id, mainmenu_id, submenu_id)
            values('0', '1', '0','0','".$_REQUEST['userid']."','".$_REQUEST['mmenuid']."', '".$_REQUEST['menuid']."') ";
        }

        $exx = $this->db->query($up);
        if($exx){
            echo "success";
        }
    }


    public function updateDelete(){

        $sql = "select * from user_grouprightspos where UserGroup_Id = '".$_REQUEST['userid']."' and submenu_id='".$_REQUEST['menuid']."'";
        $ex = $this->db->query($sql);
        $no = $ex->num_rows();
        $up = '';
        $value = 0;
        if($_REQUEST['value'] == 1){
            $value = 0;
        }
        if($_REQUEST['value'] == 0){
            $value = 1;
        }
        if($no !=0){
           $up = $up."update user_grouprightspos set Fdelete = '".$value."' where UserGroup_Id = '".$_REQUEST['userid']."' and SubMenu_Id='".$_REQUEST['menuid']."'";
            
        }else{
            $up = $up."insert into user_grouprightspos(Fview, Fadd, Fedit, Fdelete,UserGroup_id, mainmenu_id, submenu_id)
            values('0', '0', '0','1','".$_REQUEST['userid']."','".$_REQUEST['mmenuid']."', '".$_REQUEST['menuid']."') ";
        }

        $exx = $this->db->query($up);
        if($exx){
            echo "success";
        }
    }
    public function UsersGroup()
    {
        $data=array('F_Class'=>'Users','F_Ctrl'=>'UsersGroup');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data); 
    }
    public function Add_UserGroup($BUT='SAVE')
    {
        $data=array('F_Class'=>'Users','F_Ctrl'=>'Add_UserGroup','BUT'=>$BUT);          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data); 
    }
    public function Edit_UserGroup($ID=-1,$BUT='UPDATE')
    {       
       $data=array('BUT'=>$BUT,'ID'=>$ID,'F_Class'=>'Users','F_Ctrl'=>'Add_UserGroup');
       if($ID!=-1)
		{ 
			$REC=$this->Myclass->UserGroup($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
} ?>