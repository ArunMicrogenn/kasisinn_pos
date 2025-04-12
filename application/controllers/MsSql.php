<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MsSql extends CI_Controller {

	public function Outlet()
	{
        $this->load->model('Master/Outlet');
        $this->Outlet->Outlet_Val();	   
    }
    public function Users()
	{
        $this->load->model('Master/Users');
        $this->Users->Users_Val();	   
    }
    public function UserGroup()
	{
        $this->load->model('Master/Users');
        $this->Users->UserGroup_Val();	   
    }
    public function Itemcategory()
	{
        $this->load->model('Master/Itemcategory');
        $this->Itemcategory->Itemcategory_Val();	   
    } 
    public function ItemGroup()
	{
        $this->load->model('Master/ItemGroup');
        $this->ItemGroup->ItemGroup_Val();	   
    } 
    public function ItemSubGroup1()
    {
        $this->load->model('Master/ItemSubGroup1');
        $this->ItemSubGroup1->ItemSubGroup1_Val();	 
    }
    public function ItemSubGroup2()
    {
        $this->load->model('Master/ItemSubGroup2');
        $this->ItemSubGroup2->ItemSubGroup2_Val();	 
    }
    Public function FoodType()
    {
        $this->load->model('Master/FoodType');
        $this->FoodType->FoodType_Val();	 
    }
    Public function Item()
    {
        $this->load->model('Master/Item');
        $this->Item->Item_Val();	 
    }  
    Public function Table()
    {
        $this->load->model('Master/Table');
        $this->Table->Table_Val();	 
    }   
    public function Employee()
    {
        $this->load->model('Master/Employee');
        $this->Employee->Employee_Val();	 
    }     
    public function Customer()
    {
        $this->load->model('Master/Customer');
        $this->Customer->Customer_Val();	 
    } 
    public function Company()
    {
        $this->load->model('Master/Company');
        $this->Company->Company_Val();	 
    } 
    public function Configuration()
    {
        $this->load->model('Master/Configuration');
        $this->Configuration->Configuration_Val();	 
    } 
    public function SMSTemplates()
    {
        $this->load->model('Master/SMSTemplates');
        $this->SMSTemplates->SMSTemplates_Val();	    
    }
    public function Session()
    {
        $this->load->model('Master/Session');
        $this->Session->Session_Val();	    
    }
    public function Date_End_Process()
    {
        $this->load->model('Operation/Date_End_Process');
        $this->Date_End_Process->Date_End_Process_Val();	   
    }  
    public function Taxtype()
    {
        $this->load->model('Master/Taxtype');
        $this->Taxtype->Taxtype_Val();	    
    }
    
}