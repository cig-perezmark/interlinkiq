<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interlink_model extends CI_Model {
    
     public function __construct() 
     {
            parent::__construct();
            $this->db = $this->load->database("interlink",true);
                    
     }
     
     function select_no_where($fields, $table_name, $single = false) {
        
        $query = $this->db->select($fields)
                          ->from($table_name)
                          ->get();
                          
        if ($query->num_rows() > 0 ):
            return ($single == true) ? $query->row()->$fields : $query->result_array();
        endif;
        
        return false;
    }
    
    function select_where ($fields, $table_name, $where, $boolean = false, $single = false) {
        
        $query = $this->db->select($fields)
                          ->from($table_name)
                          ->where($where)
                          ->get();
                      
        if ($query->num_rows() > 0 ):
            if ($boolean == true) :
                return true;
            else:
                if ($single == true) :
                    return $query->row()->$fields;
                else:
                    return $query->result_array();
                endif;
            endif;
        endif;
        
        return false;
    }
    
    function select_where_orderby ($fields, $table_name, $where, $order_by, $order_type = 'asc', $boolean = false, $single = false) {
        
        $query = $this->db->select($fields)
                          ->from($table_name)
                          ->where($where)
                          ->order_by($order_by, $order_type)
                          ->get();
                      
        if ($query->num_rows() > 0 ):
            if ($boolean == true) :
                return true;
            else:
                if ($single == true) :
                    return $query->row()->$fields;
                else:
                    return $query->result_array();
                endif;
            endif;
        endif;
        
        return false;
    }
    
    function select_order_by($fields, $table_name, $order_field, $order_by = 'asc', $limit = 1, $offset = 0)
    {
        $query = $this->db->select($fields)
                          ->from($table_name)
                          ->order_by($order_field, $order_by)
                          ->limit($limit, $offset)
                          ->get();
        if ($query->num_rows() > 0):
            return ($limit == 1) ? $query->row()->$fields : $query->result_array();
        endif;
        
        return false;
    }
    
    function insert($values, $table_name, $getLastId = false) {
        
        $query = $this->db->insert($table_name, $values);
        
        if ($getLastId == true) {
            return $this->db->insert_id();
        }
        
    }
    
    function insert_batch($values, $table_name)
    {
        $this->db->insert_batch($table_name, $values);
    }
    
    
    function query($query) {
        
        $_query = $this->db->query($query);
        
        if($_query->num_rows() > 0) {
            return $_query->result_array();
        }
    }
    
    function update_where($values, $table_name, $where)
    {
        $query = $this->db->where($where)
                          ->update($table_name, $values);
                 
        return $this->db->affected_rows(); 
    }
    
    function update_batch($values, $table_name, $where)
    {
        $this->db->update_batch($table_name, $values, $where);
    }
    
    function delete($table_name, $where) {
        $this->db->where($where)
                 ->delete($table_name);   
    }
    /** ken queries start here **/
    
    function select_where_like ($fields, $table_name, $like_field, $like_key, $boolean = false, $single = false) {
        
        $query = $this->db->select($fields)
                          ->from($table_name)
                          ->like($like_field, $like_key, "both")
                          ->get();
                      
        if ($query->num_rows() > 0 ):
            if ($boolean == true) :
                return true;
            else:
                if ($single == true) :
                    return $query->row()->$fields;
                else:
                    return $query->result_array();
                endif;
            endif;
        endif;
        
        return false;
    }
    
    function check_table($form, $initials){
        
        $this->load->dbforge();
        $code = strtolower($this->session->userdata("client_code"));
        $table = $code."_".$form;
        
        if(!$this->db->table_exists($table)){
            
            $fields = Array("PK_{$code}{$initials}_id" => Array(
                                                            "type"              => "INT",
                                                            "constraint"        => 11,
                                                            "unsigned"          => TRUE,
                                                            "auto_increment"    => TRUE
                            ),
                            "{$code}{$initials}_lastupdated_by_id" => Array(
                                                            "type"          => "INT",
                                                            "constraint"    => 11,
                                                            "unsigned"      => TRUE
                            ),
                            "{$code}{$initials}_lastupdated_by_name" => Array(
                                                            "type"          => "TEXT",
                                                            "unsigned"      => TRUE
                            ),
                            "{$code}{$initials}_datetime_lastupdated datetime default current_timestamp on update current_timestamp"
                            );
                            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key("PK_{$code}{$initials}_id", TRUE);
            $this->dbforge->create_table($table, true);
            
            return true;
        }
        return false;
    }
    
    function add_column($table, $structure){
        
        $this->dbforge->add_column($table, $structure);
    }
    
    function alter_table($old_name, $new_name){
        
        $this->dbforge->rename_table($old_name, $new_name);
    }
    
    function alter_column($table, $structure){
        
        $this->dbforge->modify_column($table, $structure);
    }
    
    function drop_table($table){
        
        $this->dbforge->drop_table($table,TRUE);
    }
    
    function drop_column($table, $column){
        
        $this->dbforge->drop_column($table, $column);
    }
    
    
}
