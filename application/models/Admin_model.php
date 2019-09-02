<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->affected_rows();
    }
    function insert_batch($table, $data){
        $this->db->insert_batch($table, $data); 
        return $this->db->affected_rows();
     }
 
    // function sample_fetch($table){
    //     $query = $this->db->get($table);
        
    //     return ($query->num_rows() > 0) ? $query->result() : false;
    // }
    function update($table,$data,$where=NULL){
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->update($table,$data);
    }
            
    function fetch($table,$where=NULL,$order = NULL){  
        if($where !== NULL){
            $this->db->where($where);
        }
        if($order !== NULL){
            $this->db->order_by($order, 'desc');
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function fetch_like($table, $columns = NULL, $like = NULL, $order = NULL){  
        if($like !== NULL && $like != ""){ 
            $this->db->or_like($columns);
        }
        if($order !== NULL){
            $this->db->order_by($order, 'desc');
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function fetchPagination($table, $columns = NULL, $like = NULL, $order = NULL, $limit = NULL, $start = NULL){  
        if($like !== NULL && $like != ""){
            $this->db->or_like($columns);
        }
        if($order !== NULL){
            $this->db->order_by($order, 'asc');
        }
        if($limit !== NULL && $start !== NULL){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    
    function fetchPaginationTourLocation($table, $columns = NULL, $like = NULL, $order = NULL, $limit = NULL, $start = NULL){  
        $this->db->select( $table.".*, locations.name as location_name, locations.region");
        $this->db->join("locations", $table.".location_id = locations.id");
        if($like !== NULL && $like != ""){
            $this->db->or_like($columns);
        }
        if($order !== NULL){
            $this->db->order_by($order, 'asc');
        }
        if($limit !== NULL && $start !== NULL){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function fetchPaginationPackageTour($table, $columns = NULL, $like = NULL, $order = NULL, $limit = NULL, $start = NULL){  
        $this->db->select( $table.".*, locations.name as location_name, locations.region, tours.name as tour_name");
        $this->db->join("tours", $table.".tour_id = tours.id");
        $this->db->join("locations", "tours.location_id = locations.id");
        if($like !== NULL && $like != ""){
            $this->db->or_like($columns);
        }
        if($order !== NULL){
            $this->db->order_by($order, 'asc');
        }
        if($limit !== NULL && $start !== NULL){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    
    function fetchPaginationTransaction($table, $columns = NULL, $like = NULL, $order = NULL, $limit = NULL, $start = NULL){  
        $this->db->select( "packages.name as package_name, tours.name as tour_name, locations.name as location_name, locations.region, tours.name as tour_name, users.*, ". $table.".*, ");
        $this->db->join("tours", $table.".tours_id = tours.id");
        $this->db->join("packages", $table.".packages_id = packages.id");
        $this->db->join("users", $table.".user_id = users.id");
        $this->db->join("locations", "tours.location_id = locations.id");
        if($like !== NULL && $like != ""){
            $this->db->or_like($columns);
        }
        if($order !== NULL){
            $this->db->order_by($table.'.'.$order, 'asc');
        }
        if($limit !== NULL && $start !== NULL){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    


}


