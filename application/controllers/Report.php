<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Report extends CI_Controller {

    public function Billwise_Report()
	{
        // $this->load->view('Report/Billwise_Report'); 
        $data=array('F_Class'=>'Report','F_Ctrl'=>'Billwise_Report');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function Sessionwisereport()
	{
        // $this->load->view('Report/Billwise_Report'); 
        $data=array('F_Class'=>'Report','F_Ctrl'=>'SessionWiseReport');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function ItemwiseReport()
    {
        // $this->load->view('Report/ItemwiseReport'); 
        $data=array('F_Class'=>'Report','F_Ctrl'=>'ItemwiseReport');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function PendingKOT_Report()
    {
        // $this->load->view('Report/PendingKOT_Report'); 
        $data=array('F_Class'=>'Report','F_Ctrl'=>'PendingKOT_Report');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function PendingBill_Report()
    {
        // $this->load->view('Report/PendingBill_Report'); 
        $data=array('F_Class'=>'Report','F_Ctrl'=>'PendingBill_Report');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function Tax_Report()
    {
        $data=array('F_Class'=>'Report','F_Ctrl'=>'Tax_Report');        
         $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function OutletSalesAnalysis()
    {       
        $data=array('F_Class'=>'Report','F_Ctrl'=>'OutletSalesAnalysis');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
    public function ItemCategorySalesAnalysis()
    {       
        $data=array('F_Class'=>'Report','F_Ctrl'=>'ItemCategorySalesAnalysis');          
        $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
    }
}


?>