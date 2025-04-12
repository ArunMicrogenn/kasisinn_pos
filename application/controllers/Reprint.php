<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Reprint extends CI_Controller {

    public function Bill()
	{
         $data=array('F_Class'=>'Reprint','F_Ctrl'=>'Bill'); 
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function Bill_Print($RESID=0,$BILLID=0)
    {
         $data=array('F_Class'=>'Receipts','F_Ctrl'=>'BillPrint'); 
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }

}
?>