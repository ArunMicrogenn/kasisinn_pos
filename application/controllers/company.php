<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Company extends CI_Controller {

    public function index()
	{
        //$this->load->view('Master/Company_View'); 
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Company_View');        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    function Add_Company($ID=-1,$BUT='SAVE')
    {
        $data=array('F_Class'=>'Master','F_Ctrl'=>'Company','ID'=>$ID,'BUT'=>$BUT);
        if($ID!=-1)
		{ 
			$REC=$this->Myclass->Company($ID);
			$data=array_merge($data,$REC[0]);
		}        
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }

} ?>