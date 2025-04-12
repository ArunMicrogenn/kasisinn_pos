<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Settings extends CI_Controller {

    public function DataPurging()
	{        
        $data=array('F_Class'=>'Settings','F_Ctrl'=>'DataPurging');        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);  
    }
    public function Datapurging_Save()
    {
        
        if($_REQUEST['selected']=='1')
        {
        $sql="delete from headings where companyid='". $_REQUEST['Company']."'
        delete from Itemcategory where companyid='". $_REQUEST['Company']."'
        delete from itemgroup where companyid='". $_REQUEST['Company']."'
        delete from Itemsubgroup2 where companyid='". $_REQUEST['Company']."'
        delete from Itemsubgroup3 where companyid='". $_REQUEST['Company']."'
        delete from Mas_posfoodtype where companyid='". $_REQUEST['Company']."'
        delete from Itemmas_main where companyid='". $_REQUEST['Company']."'
        delete from itemmas where companyid='". $_REQUEST['Company']."'
        delete from Tablemas where companyid='". $_REQUEST['Company']."'
        delete from Employee where companyid='". $_REQUEST['Company']."'
        delete from Trans_ResKot_det where companyid='". $_REQUEST['Company']."'
        delete from Trans_ResKot_mas where companyid='". $_REQUEST['Company']."'
        delete from Trans_ReskotBillraise_det where companyid='". $_REQUEST['Company']."'
        delete from Trans_ReskotBillraise_mas where companyid='". $_REQUEST['Company']."'
        delete from Trans_ResKotSettlement where companyid='". $_REQUEST['Company']."'
        delete from Date_change_bar where companyid='". $_REQUEST['Company']."'
        delete from outbox where companyid='". $_REQUEST['Company']."'    
        delete from trans_reskotbilltax_det where companyid='". $_REQUEST['Company']."'   ";
        
        }
        else
        {
        $sql="delete from Trans_ResKot_det where companyid='". $_REQUEST['Company']."'
        delete from Trans_ResKot_mas where companyid='". $_REQUEST['Company']."'
        delete from Trans_ReskotBillraise_det where companyid='". $_REQUEST['Company']."'
        delete from Trans_ReskotBillraise_mas where companyid='". $_REQUEST['Company']."' 
        delete from Trans_ResKotSettlement where companyid='". $_REQUEST['Company']."' 
        update tablemas set Status='S' where companyid='". $_REQUEST['Company']."'        
		delete from outbox where companyid='". $_REQUEST['Company']."' 
        delete from trans_reskotbilltax_det where companyid='". $_REQUEST['Company']."'     ";
		
        }
        $res=$this->db->query($sql);
    }

} ?>