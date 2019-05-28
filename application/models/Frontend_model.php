<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_model extends CI_Model {

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
        return $this->db->update($table,$data);
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
            if($columns != NULL){
                foreach($columns as $c){
                    $this->db->like($c, $like, 'both');
                }
            }
        }
        if($order !== NULL){
            $this->db->order_by($order, 'desc');
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    


}


