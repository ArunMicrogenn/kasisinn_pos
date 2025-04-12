<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); 
class Date_End_Process extends CI_Controller {

    public function index()
	{        
        $data=array('F_Class'=>'Date_End_Process','F_Ctrl'=>'');        
        $this->load->view($data['F_Class'],$data);  
    }
}
?>