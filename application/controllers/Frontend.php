<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {
 
    
	public function index($page = null)
	{
		$page = $this->uri->segment(1) ?? 'index';
		
        if ( !file_exists('application/views/frontend/'.$page.'.php') ) {
            show_404();
        }
		$this->load->view('frontend/layouts/header');
        $this->load->view('frontend/'.$page);
		$this->load->view('frontend/layouts/footer');
         
	}
	
	public function fetch_schools(){
		$search = $this->_post("search");
		$columns =  array("name");
		$schools = null;
		$data["search"] = $search;
		$schools = $this->frontend->fetch_like("schools", $columns, $search);
		// $schools = "hey";
		$html = null;
		if($schools != NULL && count($schools) > 0){
			$html = '<table class="table table-borderless">
						<thead>
							<tr>
								<th>School</th>
								<th>Region</th>
							</tr>
						</thead>
						<tbody>
							';
					
			foreach($schools as $s){
				$html .= '<tr>
							<td>' . $s->name . '</td>
							<td>' . $s->region . '</td>
						</tr>';
			}
			$html .= '</tbody>
					</table>';
		}
        $data['schools'] = $schools;
		$data["html"] = $html;
        echo json_encode($data);
	}

	// custom method for post
	public function _post($value){
        return strip_tags($this->input->post($value,true));
	}
	
}
