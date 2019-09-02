<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
 
    
    public function __construct(){
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');

    }
 
    public function getUsers(){
        $this->load->library("pagination");
        $search = $this->input->get("search");
        $columns = array(
            "first_name" => $search, 
            "last_name" => $search,
            "email" => $search,
        );
        
        $response['test'] = $user = $this->admin->fetch_like("delegates", $columns, $search, "created_at"); 

        $totalUsers = 0;
        if($search != ""){
            
            $user = $this->admin->fetch_like("delegates", $columns, $search, "created_at");
            if($user)
                $totalUsers = count($this->admin->fetch_like("delegates", $columns, $search, "created_at")); 
        }
        else
            $totalUsers = count($this->admin->fetch("delegates"));
         
        $config = array();
        $config["base_url"] = "";
        $config["total_rows"] = $totalUsers;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination justify-content-center">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li class="page-item"><a class="page-link" href="#">';
        $config["first_tag_close"] = '</a></li>';
        $config["last_tag_open"] = '<li class="page-item">';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li class="page-item">';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = '<li class="page-item">';
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='page-item active'><a class='page-link' href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li class='page-item'>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $response["page"] = $page;
        $start = ($page - 1) * $config["per_page"]; 

        // check if there is a searching 
        if($search != ""){ 
            $users = $this->admin->fetchPagination("delegates", $columns, $search, "created_at", $config["per_page"], $start);
        }
        else
            $users = $this->admin->fetchPagination("delegates", NULL, NULL, "created_at", $config["per_page"], $start);

        // initialize to check if there are data 
        $response["success"] = false;
        $response["users"] = $users;
        
        if($users){
            if(count($users) > 0){
                $html = '<table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No.</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                $ctr = 1;
                foreach($users as $u){
                    $html .= '<tr>
                                <td>'. $ctr++ .'</td>
                                <td>'. $u->first_name .' ' . $u->last_name .'</td>
                                <td>'. $u->email . '</td>
                                <td>'. $u->shirt_size . '</td>
                                <td>'. $u->delegate_type .'</td>
                                <td>'. $u->contact .'</td>
                                <td>'. $u->payment_status .'</td>
                                <td> <a class="btn btn-info btn-sm" href="'. base_url() . 'admin/user/' . $u->id . '" data-uuid="'. $u->id .'"><i class="fa fa-eye"></i></a></td>
                            </tr>';
                }

                $response["success"] = TRUE;
                $response["userTable"] = $html;
                $response["pagination_link"] = $this->pagination->create_links();
            }
        }
        else{
            $html = '<div class="alert alert-dark" role="alert">
                        No Available Data
                    </div>';
            $response["empty_message"] = $html;
        }


        echo json_encode($response);
        

    }
    
}
