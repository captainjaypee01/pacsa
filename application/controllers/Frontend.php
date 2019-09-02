<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {
 
     
    public function __construct(){
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');

	}
	
	public function index($page = null)
	{
		$this->load->view('frontend/layouts/header');
		$this->load->view('frontend/index');
		$this->load->view('frontend/layouts/footer');
		 
         
	}
	public function register($page = null)
	{ 
		$this->load->view('frontend/layouts/header');
		$this->load->view('frontend/register');
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

	// Functions for individual Registration
	public function individualRegister(){
		
		$this->validate("first_name", "First Name", "required|strip_tags|trim|xss_clean");
		$this->validate("last_name", "Last Name", "required|strip_tags|trim|xss_clean");
		$this->validate("email", "Email Address", "required|strip_tags|trim|xss_clean");
		$this->validate("contact", "Contact Number", "required|strip_tags|trim|xss_clean");
		$this->validate("gender", "Gender", "required|strip_tags|trim|xss_clean");
		$this->validate("shirt_size", "Shirt Size", "required|strip_tags|trim|xss_clean");
		$this->validate("delegate_type", "Delegate Type", "required|strip_tags|trim|xss_clean"); 
		$data = array(
			"first_name" => $this->_post("first_name"),
			"last_name" => $this->_post("last_name"),
			"middle_name" => $this->_post("middle_name"),
			"email" => $this->_post("email"),
			"contact" => $this->_post("contact"),
			"gender" => $this->_post("gender"),
			"is_head" => $this->_post("is_head"),
			"shirt_size" => $this->_post("shirt_size"),
			"delegate_type" => $this->_post("delegate_type"),
			"school_id" => $this->_post("school_id"),
		);

		if($this->form_validation->run()){
			if($this->frontend->insert("delegates", $data)){
				$response["message"] = "Successfully Registered";
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

	// Functions for Batch registration
	public function generateBatchForms(){
		$totalDelegates = $this->_post("total_delegates");
		$school_id = $this->_post("school_id");
		$html = '
		<div class="card-body"> <form id="frm-batch-registration">';
			for($i = 0; $i < $totalDelegates; $i++){
				$html .= '<div class="row justify-content-center align-items-center mt-5 mb-5">
							<div class="col-md-6 col-sm-8 align-self-center">
								<div class="card">
									<div class="card-header text-center">
										<strong>
											Delegate ' . ($i + 1) . '
										</strong>
									</div><!--card-header-->
					
									<div class="card-body"> 
										<div class="row">
											<div class="col-md-4 col-sm-12">
												<div class="form-group">
													<input type="text" name="first_name[]" placeholder="First name" class="form-control" required>
												</div>
											</div>
											<div class="col-md-4 col-sm-12">
												<div class="form-group">
													<input type="text" name="middle_name[]" placeholder="Middle name" class="form-control">
												</div>
											</div>
											<div class="col-md-4 col-sm-12">
												<div class="form-group">
													<input type="text" name="last_name[]" placeholder="Last name" class="form-control" required>
												</div>
											</div>
										</div>
				
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<input type="text" name="email[]" placeholder="Email Address" class="form-control" required>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<input type="text" name="contact[]" placeholder="Contact Number" class="form-control" required>
												</div>
											</div>
										</div> 
				
										<div class="row">
				
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<h6 class="pl-2 form-label_w">Shirt Size</h6>
													<select name="shirt_size[]" class="" required>
														<option value=""></option>
														<option value="XS">Extra Small</option>
														<option value="S">Small</option>
														<option value="M">Medium</option>
														<option value="L">Large</option>
														<option value="XL">Extra Large</option>
													</select>
												</div>
											</div>
				
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<h6 class="form-label_w">Gender</h6>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="gender[' . $i .']" value="m">
														<label class="form-check-label" for="gender">Male</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="gender[' . $i .']" value="f">
														<label class="form-check-label" for="gender">Female</label>
													</div> 
												</div>
											</div>
				
										</div>
				
										<div class="row">
				
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<h6 class="pl-2 form-label_w">Delegate Type</h6>
													<select name="delegate_type[]" id="delegate_type" class="" required>
														<option value=""></option>
														<option value="student">Student</option>
														<option value="adviser">Adviser</option> 
													</select>
												</div>
											</div>
				
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<h6 class="form-label_w">Is Head Delegate?</h6>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="is_head[' . $i .']" value="1">
														<label class="form-check-label" for="is_head">Yes</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="is_head[' . $i .']" value="0">
														<label class="form-check-label" for="is_head">No</label>
													</div> 
												</div>
											</div>
				
										</div> 
									</div>
								</div>  
							</div>
						</div>';
			}

			$html .= '
			
				<div class="row justify-content-center align-items-center mt-5 mb-5">
					<div class="col md-6 mx-auto text-center">
						<input type="number" name="school_id" id="school_id2" value="'. $school_id .'" hidden>
						<button type="submit" class="btn btn-success ">Submit</button>
					</div>
				</div>
			</form></div>'; 
			echo json_encode($html);
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
				"is_batch" => 1,
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
