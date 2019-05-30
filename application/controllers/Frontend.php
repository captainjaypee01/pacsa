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
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							';
					
			foreach($schools as $s){
				$html .= '<tr>
							<td>' . $s->name . '</td>
							<td>' . $s->region . '</td>
							<td> <button type="button" class="btn btn-warning btn-sm btn-school" data-id="'. $s->id .'"> Select </button> 
						</tr>';
			}
			$html .= '</tbody>
					</table>';
		}
        $data['schools'] = $schools;
		$data["html"] = $html;
        echo json_encode($data);
	}

	public function add_school(){
		$this->validate("school_name", "School Name", "required|strip_tags|trim|xss_clean");
		$this->validate("region", "Region", "required|strip_tags|trim|xss_clean");
		$response["post"] = $_POST;
		if($this->form_validation->run()){
			$data = array(
				"name" => $this->_post("school_name"),
				"region" => $this->_post("region"),
			);
			if($this->frontend->insert("schools", $data)){
				$response["message"] = "Successfully Created";
				$response["success"] = TRUE;
			}
			else{
				$response["message"] = "There was an error, please try again!";
				$response["success"] = FALSE;
			}
			echo json_encode($response);
		}
		else{
			foreach($_POST as $key => $value){
                $response['messages'][$key] = form_error($key);
                $response['success'] = FALSE;
            }
            $response['errors'] = validation_errors();
            echo json_encode($response);
		}
	}

	public function batch_registration(){

		$response["post"] = $_POST;
		$contacts = $this->_post("contact");
		$delegate_types = $this->_post("delegate_type");
		$emails = $this->_post("email");
		$first_names = $this->_post("first_name");
		$genders = $this->_post("gender");
		$is_heads = $this->_post("is_head");
		$last_names = $this->_post("last_name");
		$middle_names = $this->_post("middle_name");
		$shirt_sizes = $this->_post("shirt_size");
		$school_id = $this->_post("school_id");
		for($i = 0; $i < count($emails);$i++){
			$data[] = array(
				"first_name" => $first_names[$i],
				"last_name" => $last_names[$i],
				"middle_name" => $middle_names[$i],
				"email" => $emails[$i],
				"contact" => $contacts[$i],
				"gender" => $genders[$i],
				"is_head" => $is_heads[$i],
				"shirt_size" => $shirt_sizes[$i],
				"delegate_type" => $delegate_types[$i],
				"school_id" => $school_id,
			);
		}
		if($this->frontend->insert_batch("delegates", $data)){
			$response["message"] = "Successfully Registered";
			$response["success"] = TRUE;
		}
		else{
			$response["message"] = "There was an error, please try again!";
			$response["success"] = FALSE;
		}
		echo json_encode($response);
	}

	// custom method for post
	public function _post($value){ 
        return is_array($this->input->post($value,true)) ? $this->input->post($value,true) : strip_tags($this->input->post($value,true));
	}

	// costum method for $this->form_validation->set_rules();
    public function validate($param1,$param2,$param3) {
        return $this->form_validation->set_rules($param1,$param2,$param3);
    } 

	
}
