<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
 
    
    public function __construct(){
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');

    }

	public function index()
	{
        
		$this->load->view('backend/layouts/header');
        $this->load->view('backend/admin');
		$this->load->view('backend/layouts/footer');
         
	}
	public function users()
	{
        
		$this->load->view('backend/layouts/header');
        $this->load->view('backend/user/index');
		$this->load->view('backend/layouts/footer');
         
	}
    
}
