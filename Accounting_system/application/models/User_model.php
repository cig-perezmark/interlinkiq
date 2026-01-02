<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        
        $this->load->database();
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

    public function get_user()
    {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_record($param)
    {
        
        if($param == "payee"){
            $this->db->where("active_status", "0");
            $q = $this->db->get($param);  
        }
        else{
        $q = $this->db->get($param);
        }
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
    }
    
    public function get_record_deactivate($param)
    {
        if($param = "payee"){
            $this->db->where("active_status", "1");
            $q = $this->db->get($param);  
        }
      else{
        $q = $this->db->get($param);
        }
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
    }

    public function get_record_where($param2,$user_data_table,$table_name)
    {
        
        // this id is equal to param
        $this->db->where($user_data_table, $param2);

        //table name users
        $result = $this->db->get($table_name);

        if($result->num_rows() > 0)
        {
            return $result->result();
        }
        return array();
    }

    public function update_table($table_name,$user_data_table,$parameter_id,$parameter_value , $set_field)
    {
        $this->db->where($user_data_table, $parameter_id);
        $this->db->update($table_name, array($set_field => $parameter_value));
        return true;
    }

    public function update_table_array_where($table_name,$user_data_table,$parameter_id,$parameter_value)
    {
        $this->db->where($user_data_table, $parameter_id);
        $this->db->update($table_name, $parameter_value);
        return true;
    }

    public function get_record_date($param)
    {
        $this->db->select('*');
        $this->db->from($param);
        $this->db->limit(1);
        $this->db->order_by("id" , 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    function update_where($values, $table_name, $where)
    {
        $query = $this->db->where($where)
                          ->update($table_name, $values);
                 
        return $this->db->affected_rows(); 
    }
    
    
    public function get_user_single($param,$table_name,$user_data_table)
    {
        // this id is equal to param
        $this->db->where($user_data_table, $param);

        //table name users
        $result = $this->db->get($table_name);

        return $result->row_array();
    }

    function can_login($username, $password)  
    {  
        
         $this->db->where('username', $username);  
         $this->db->where('password', $password);  
         $result = $this->db->get('tbl_users');  
        return $result; 
    }

    function get_single_row($param,$table_name,$user_data_table)
    {
       $this->db->select("*");
       //$this->db->distinct();
       $this->db->from('pay');
       $this->db->join('payee','payee.payeeid = pay.payeeid');
       $this->db->join('source','pay.sourceid = source.sourceid');
       $this->db->where('payee.payeeid',$param);
       //$max_date =  $this->db->select_max('pay.paiddate');

   
       $query = $this->db->get();

       if($query->num_rows() != 0)
       {
           return $query->result();
       }
       else
       {
           return false;
       }

    }

    
    function get_deduction_history($param,$table_name,$user_data_table)
    {
        
       $this->db->select("*");
       //$this->db->distinct();
       $this->db->from('user_deductions');
       $this->db->where('user_deductions.payeeid',$param);
       $this->db->join('deductions','deductions.id = user_deductions.deduction_id');
       $this->db->order_by('date_paid', 'DESC');
       //$max_date =  $this->db->select_max('pay.paiddate');

   
       $query = $this->db->get();

       if($query->num_rows() != 0)
       {
           return $query->result();
       }
       else
       {
           return false;
       }

    }

    public function save_records($table_name,$data)
    {
        $this->db->insert($table_name,$data);
        return true;
    }

    function insert($values, $table_name, $getLastId = false) {
        
        $query = $this->db->insert($table_name, $values);
        
        if ($getLastId == true) {
            return $this->db->insert_id();
        }
        
    }
    

    public function update_row($table_name,$payeeid){
		
		$update_rows = array(
			'paid_status' => 'paid',
			'absent_deduction' => '0',
            'night_diff_pay' => '0',
		);
		$this->db->where('payeeid', $payeeid );
		$result = $this->db->update($table_name, $update_rows);	
		return $result;
	}	

    public function update_leave($table_name,$param,$total_leave){
		
		
		$this->db->where('payeeid', $param );
		//$result = $this->db->update($table_name, $update_rows);	
        $result = $this->db->update($table_name, array('total_leave' => $total_leave));
		return $result;
	}	

    public function update_leave_subtract($table_name,$param,$leave_input){
		
		
		$this->db->set('total_leave', 'total_leave-'.$leave_input.'',FALSE);
        $this->db->where('payeeid' , $param);
        $this->db->update($table_name);

		
	}	

    
    public function update_leave_subtract_hr($table_name,$param,$value,$leave_count,$pto_id){
		$table_name1 = "leave_total";
        $leave_input = floatval( $leave_count );
		$this->db->set('total_leave', 'total_leave-'.$leave_input.'',FALSE);
		$this->db->where('payeeid' , $param);
        $this->db->update($table_name1);
        

        $this->db->where('id', $pto_id );
        $this->db->update($table_name, array('approve_status' => $value));
        
		return true;
	}
    
    public function update_leave_add_hr($table_name,$param,$value,$leave_count,$pto_id){
		$table_name1 = "leave_total";
        $leave_input = intval( $leave_count );
		$this->db->set('total_leave', 'total_leave+'.$leave_input.'',FALSE);
		$this->db->where('payeeid' , $param);
        $this->db->update($table_name1);
        

		$this->db->where('id', $pto_id );
        $this->db->update($table_name, array('approve_status' => $value));
        
        
        return true;
		
	}
	
    public function save_employee($table_name,$data,$table_name1,$data1)
    {
        $this->db->insert($table_name,$data);
        $data1['payeeid'] = $this->db->insert_id();
        $data2['payeeid'] = $this->db->insert_id();
        
        $table_name2 = "pay";
        $data2['refno'] = "no input";
        $data2['paidstatus'] = "no existing pay";
        $data2['sourceid'] = "no input";
        $data2['schedule'] = "no input";
        $data2['notes_pay'] = "no input";
        $this->db->insert($table_name1,$data1);
        $this->db->insert($table_name2,$data2);
        return true;
    }

    public function delete_record($table_name,$param,$user_data_table)
    {
        $this->db->where($user_data_table, $param);
        $this->db->delete($table_name);
        return true;
    }

    function get_join()
    {
     
        $this->db->select("*");
        //$this->db->distinct();
        $this->db->from('pay');
        $this->db->join('payee','payee.payeeid = pay.payeeid');
        $this->db->where("active_status", "0");
        $this->db->where('payee.payeeid != 146');
        $this->db->join('employee_details','payee.payeeid = employee_details.payeeid');
        $this->db->where('pay.paiddate = (SELECT MAX(pay.paiddate) from pay as pay_date where pay_date.payeeid = payee.payeeid)');
        $this->db->distinct('payee.fullname');
        $this->db->order_by("fullname" , 'desc');


        $max_date =  $this->db->select_max('pay.paiddate');
    
        $query = $this->db->get();

        if($query->num_rows() != 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function get_user_pay($param)
    {
        
        $this->db->select("*");
        //$this->db->distinct();
        $this->db->from('payee');
        $this->db->where('payee.payeeid = '.$param.'');
        $this->db->join('employee_details','payee.payeeid = employee_details.payeeid');
        $this->db->join('deductions','payee.payeeid = deductions.payeeid');


    
        $query = $this->db->get();

        if($query->num_rows() != 0)
        {
            return $query->result();
        }
       
            return false;       
    }

   public function reset_pay()
    {
        $data = array(
            'paid_status' => 'unpaid',
    );

    $this->db->update('payee', $data);
    }

    public function fetch_single_employee($payeeid)
    {
        $this->db->where('payeeid', $payeeid);
        $query=$this->db->get('deductions');
        return $query->result();
    }

    public function get_month()
    {
        $this->db->select("DISTINCT MONTH(`paiddate`) AS month,SUM(`amount`) as total_amount");
        $this->db->distinct();
        $this->db->from('pay');
        $this->db->distinct('MOTNH(paiddate)');
        $this->db->order_by('paiddate','ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function sum_leave($param)
    {
        $this->db->select("SUM(`leave_count`) as total_amount");
        $this->db->where('payeeid', $param);
        $this->db->from('leave_details');
        $this->db->distinct('payeeid');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employeebudget()
    {
        $this->db->select("fullname,position,SUM(`amount`) as total_amount");
        $this->db->from('payee');
        $this->db->join('pay','pay.payeeid = payee.payeeid');
        $this->db->distinct('fullname');
        $this->db->order_by('fullname','ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_by_month($param,$user_data_table,$table_name)
    {
        $this->db->select("*");
        //$this->db->distinct();
        $this->db->from('pay');
        $this->db->where('month(paiddate) = '.$param.'');
        $this->db->join('payee','payee.payeeid = pay.payeeid');
        $this->db->join('source','source.sourceid = pay.sourceid');
        //table name users
        $result = $this->db->get();

        if($result->num_rows() > 0)
        {
            return $result->result();
        }
        return array();
    }

    public function update_pay($table_name,$param,$param2)
    {
        $this->db->where('payid', $param);
        $this->db->update($table_name, array('paidstatus' => $param2));
        return true;
    }

    public function update_pto($table_name,$pto_id,$param2)
    {
        $this->db->where('id', $pto_id);
        $this->db->update($table_name, array('approve_status' => $param2));
        return true;
    }
    
    public function get_employee_pay_list($table_name, $user_data_table , $param2)
    {
        
            
            // this id is equal to param
            $this->db->where($user_data_table, $param2);
            $this->db->join('source','pay.sourceid=source.sourceid ');
            //table name users
            $result = $this->db->get($table_name);
    
            if($result->num_rows() > 0)
            {
                return $result->result();
            }
            return array();
        
    }

    public function get_employee_PTO_request($param2,$user_data_table,$table_name,$param,$value)
    {

           
           if($param == "108"){
               // this id is equal to param
               $this->db->where($user_data_table, $param2);
               $this->db->or_where($user_data_table, 'ETRR');
               $this->db->join('leave_details','leave_details.payeeid = payee.payeeid ');
               $this->db->where(array('leave_details.payeeid !='=> $param));
                $this->db->where('approve_status', '0');
               //table name users
               $result = $this->db->get($table_name);
       
               if($result->num_rows() > 0)
               {
                   return $result->result();
               }
               return array();
           }
           else{
                // this id is equal to param
               $this->db->where($user_data_table, $param2);
               $this->db->join('leave_details','leave_details.payeeid = payee.payeeid ');
               $this->db->where(array('leave_details.payeeid !='=> $param));
               $this->db->where('approve_status', $value);
           
        
               //table name users
               $result = $this->db->get($table_name);
       
               if($result->num_rows() > 0)
               {
                   return $result->result();
               }
               return array();
           
           }
    }

    
    function get_pto_request_hr()
    {
        
        $this->db->select("*, leave_details.id AS `leave_id`");
        //$this->db->distinct();
        $this->db->from('payee');
        $this->db->join('leave_details','payee.payeeid = leave_details.payeeid');
        $this->db->join('leave_total','leave_total.payeeid = leave_details.payeeid');
        $this->db->where('leave_details.approve_status ', 1);
        $this->db->or_where('leave_details.approve_status ', 3);
        $query = $this->db->get();

        if($query->num_rows() != 0)
        {
            return $query->result();
        }
       
            return false;       
    }

     
    function get_remaining_pto($param2,$user_data_table5,$table_name5)
    {
        
         
        // this id is equal to param
        $this->db->where('payeeid', $param2);
        $this->db->where("approve_status", "2");
        //table name users
        $result = $this->db->get('leave_details');

        if($result->num_rows() > 0)
        {
            return $result->result();
        }
        return array();    
    }

    function get_join_accounting_user_list()
    {
     
        $this->db->select("*");
        //$this->db->distinct();
        $this->db->from('payee');
        $this->db->where("active_status", "0");
        $this->db->join('bankname','bankname.bankno = payee.bankno');
        $this->db->join('employee_details','employee_details.payeeid = payee.payeeid');
        $this->db->distinct('payee.fullname');
        $this->db->order_by("fullname" , 'desc');
        $query = $this->db->get();

        if($query->num_rows() != 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function insert_deduction($table_name2,$data_array)
    {
        $count = $data_array['counter'];

        for($i = 1; $i <= count($count); $i++)
            {
               $data_array1['deduction_id']=$this->input->post('deduction_id'.$i.'');
               $data_array1['user_deduction']=$this->input->post('deduction_amount'.$i.'');
               $data_array1['payeeid']=$data_array['payeeid'];
               $data_array1['reference_no']=$data_array['reference_no'];
               $data_array1['date_paid']=$data_array['date_paid'];
                $this->db->insert($table_name2,$data_array1);
            }
    }


        
    function insert_batch($values, $table_name)
    {
        $this->db->insert_batch($table_name, $values);

        return true;
    }
    
    function get_pay_export($start,$end)
    {
        $this->db->select("*");
        //$this->db->distinct();
        $this->db->from('pay');
        $this->db->where('paiddate >=', $start);
        $this->db->where('paiddate <=', $end);
        $this->db->join('payee','payee.payeeid = pay.payeeid');
        $this->db->join('source','source.sourceid = pay.sourceid');
        $this->db->join('employee_details','payee.payeeid = employee_details.payeeid');
        //table name users
        $result = $this->db->get();

        if($result->num_rows() > 0)
        {
            return $result->result();
        }
        return array();
    }
    
    function get_pay_export_history($start)
    {
        $this->db->select("*");
        //$this->db->distinct();
        $this->db->from('pay');
        $this->db->where('paiddate', $start);
        $this->db->join('payee','payee.payeeid = pay.payeeid');
        $this->db->join('source','source.sourceid = pay.sourceid');
        $this->db->join('employee_details','pay.payeeid = employee_details.payeeid');
        //table name users
        $result = $this->db->get();

        if($result->num_rows() > 0)
        {
            return $result->result();
        }
        return array();
    }
    
    function query($query) {
        
        $_query = $this->db->query($query);
        
        if($_query->num_rows() > 0) {
            return $_query->result_array();
        }
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
    
    function select_insert($paid_date,$start_date){
        $this->db->select('payeeid');
        $this->db->from('payee');
        $this->db->where('active_status', '0');
        $query = $this->db->get();
    
        if ( $query->num_rows() > 0 ) // if result found
        {
            $row = $query->result_array(); // get result in an array format
            $data = array();
            foreach($row as $values){
                $data = array(
                    'payeeid' => $values['payeeid'],
                    'paidstatus' => "unpaid",
                    'paiddate' => $paid_date,
                    'start_date' => $start_date
                );
                $this->db->insert('pay', $data); // insert in order table
            }
            return true;    
        }
        else{
            return false; 
        } 
    }
    
    function insertRecord($record){
 
        if(count($record) > 0){
            $newuser = array(
              "task_id" => trim($record[0]),
              "description" => trim($record[1]),
              "action" => trim($record[2]),
              "comment" => trim($record[3])
            );
    
            $this->db->insert('invoice', $newuser);
        }
    }
    
    public function get_month_invoice()
    {
        $this->db->select("DISTINCT MONTH(`task_date`) AS month ");
        $this->db->distinct();
        $this->db->from('invoice');
        $this->db->distinct('MOTNH(task_date)');
        $this->db->order_by('task_date','ASC');
        $query = $this->db->get();

        return $query->result();
    }
    
}
