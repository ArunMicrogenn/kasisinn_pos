<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Logout extends CI_Controller {

    public function index()
	{
        @session_start();
        @session_destroy();
        $this->load->view('welcome_message');
    }
}
?>