<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
 
    
	public function index($page = 'register')
	{
        if ( !file_exists('application/views/frontend/'.$page.'.php') ) {
            show_404();
        }

		$this->load->view('frontend/layouts/header');
        $this->load->view('frontend/'.$page);
		$this->load->view('frontend/layouts/footer');
        
        
	}
}
