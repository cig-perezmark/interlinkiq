<?php
require FCPATH.'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Pages extends CI_Controller
{
    public function view($param = NULL)
    {
        

        if($param == NULL)
        {
            $page = "index";
            $param = "payee";
            $param1 = "payeestatus";
            $param2 = "bankname";
            if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
            {
                show_404();
            }

            //get function from models / User_Model.php / User_model class/ get_user function

            $data['records'] = $this->User_model->get_record($param);
            $data['status'] = $this->User_model->get_record($param1);
            $data['bank_name'] = $this->User_model->get_record($param2);
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('HR/'.$page, $data);
            $this->load->view('templates/footer');
        }
       

        else
        {


            $page = "single";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }
    
            
            //get function from models / User_Model.php / User_model class/ get_user function
            $data['users'] = $this->User_model->get_user_single($param);

            $data['title'] = $data['users']['f_name'];

            if($data['users'])
            {
                $this->load->view('templates/header');
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/footer');
    
            }
        
            else
            {
                show_404();
            }
        }
        
    }

    public function HR_dashboard()
    {
        $page = "index";
        $param = "payee";
        $param1 = "payeestatus";
        $param2 = "bankname";
        if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
        {
            show_404();
        }

        //get function from models / User_Model.php / User_model class/ get_user function

        $data['records'] = $this->User_model->get_record($param);
        $data['status'] = $this->User_model->get_record($param1);
        $data['bank_name'] = $this->User_model->get_record($param2);
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('HR/'.$page, $data);
        $this->load->view('templates/footer');
        
    }

    public function pto_request()
    {
        $page = "pto_request";
        if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
        {
            show_404();
        }
        
        $data['pto_list'] = $this->User_model->get_pto_request_hr();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('HR/'.$page,$data);
        $this->load->view('templates/footer');
    }


    public function employee_details($param,$param2)
    {
        $page = "employee_details";
        $table_name = "payee";
        $employee_tbl = "employee_details";
        $employee_id = "payeeid";
        $user_data_table = "authentication";
        $param1 = "payeestatus";
        if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
        {
            show_404();
        }


        $data['employee_id'] = $param2;
        $data['employee_auth'] = $param;
        //get function from models / User_Model.php / User_model class/ get_user function
        $data['users'] = $this->User_model->get_user_single($param,$table_name,$user_data_table);
        $data['employee_details'] = $this->User_model->get_user_single($param2,$employee_tbl,$employee_id);
        $data['status'] = $this->User_model->get_record($param1);
        $data['status'] = $this->User_model->get_record($param1);
        $data['sum'] = $this->User_model->sum_leave($param2);
        $data['employee_records_files'] = $this->User_model->get_record_where($param2,"payeeid","user_records_file");

        $user_data_table5 = "payeeid";
        $table_name5 = "leave_details";
        $data['leave'] = $this->User_model->get_remaining_pto($param2,$user_data_table5,$table_name5);
        if(empty($data['leave']))
        {
            $data['leave'] = "0";
        }
        $data['leaves'] = $this->User_model->select_where('*', 'leave_details', array('payeeid' => $param2));
        $table_name6 = "leave_total";
        $data['total_leave'] = $this->User_model->get_record_where($param2,$user_data_table5,$table_name6);
        

        
        $data['fullname'] = $data['users']['fullname'];
        $data['Address'] = $data['users']['address'];
        $data['phone'] = $data['users']['phone'];
        $data['email'] = $data['users']['email'];
        $data['company_email'] = $data['users']['company_email'];
        $data['bank_no'] = $data['users']['bankno'];
        $data['accountname'] = $data['users']['accountname'];
        $data['accountno'] = $data['users']['accountno'];
        $data['active_status'] = $data['users']['active_status'];
        $data['datehired'] = $data['users']['datehired'];
        $data['position'] = $data['users']['position'];
        $data['payeeid'] = $data['users']['payeeid'];
        $data['department'] = $data['users']['department'];
        $data['address'] = $data['users']['address'];
        $data['emergency_contact_number'] = $data['users']['emergency_contact_number'];
        $data['secondary_department'] = $data['users']['secondary_department'];

        $data['pay_rate'] = $data['employee_details']['pay_rate'];
        $data['effectivity_date'] = $data['employee_details']['effectivity_date'];
        //break;
        $data_id = $data['users']['statusid'];
        $bank_id = $data['users']['bankno'];
        $table_name1 = "payeestatus";
        $user_data_table1 = "statusid";
        $data['records'] = $this->User_model->get_user_single($data_id,$table_name1,$user_data_table1);
        $data['status1'] = $data['records']['statusname'];
        $data['statusid'] = $data['records']['statusid'];
        //break
        $bank_id = $data['users']['bankno'];
        $table_name2 = "bankname";
        $user_data_table2 = "bankno";
        $data['bank_recordrecords'] = $this->User_model->get_user_single($bank_id,$table_name2,$user_data_table2);
        $data['bank_name'] = $data['bank_recordrecords']['bankname'];
        $data['bank_list'] = $this->User_model->get_record($table_name2);

        //break
        $table_name = "deductions";
        $user_data_table = "payeeid";
        $data['deductions'] = $this->User_model->get_record_where($param2,$user_data_table,$table_name);
        
        $table_name6 = "tbl_users";
        $user_data_table6 = "id";
        $data['user_accounts'] = $this->User_model->get_user_single($param2,$table_name6,$user_data_table6);


        
        if(empty($data['user_accounts']['user_type_id']))
        {
            $data['username'] = "Please enter username";
        }
        else
        {
            $data['user_type'] = $data['user_accounts']['user_type_id'];
        }
        
  
        if(empty($data['user_accounts']['username']))
        {
            $data['username'] = "Please enter username";
        }
        else
        {
            $data['username'] = $data['user_accounts']['username'];
        }
        

        if(empty($data['user_accounts']['password']))
        {
            $data['password'] = "Please enter password";
            $data['input_type'] = "text";
        }
        else
        {
            $data['password'] = $data['user_accounts']['password'];
            $data['input_type'] = "password";
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('HR/'.$page,$data);
        $this->load->view('templates/footer');
        
    }

    public function employee_payrate()
    {
        
        $page = "payrate";
        $param = "payeestatus";
        if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
        {
            show_404();
        }


        $data['records'] = $this->User_model->get_record($param);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('HR/'.$page,$data);
        $this->load->view('templates/footer');
        
    }
    public function HR_pay_source()
    {
        $page = "pay_source";
        $param = "source";
        if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
        {
            show_404();
        }


        $data['records'] = $this->User_model->get_record($param);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('HR/'.$page,$data);
        $this->load->view('templates/footer');
        
    }



   public function save_source()
   {
        $table_name = "source";
        /*Check submit button */
        if($this->input->post('save'))
        {         
        $data['sourcename']=$this->input->post('sourcename'); 
        $data['notes_source']=$this->input->post('notes_source'); 
        $response=$this->User_model->save_records($table_name,$data);
        if($response==true){
            $_SESSION['alert_message'] = "Successfully Added";
            redirect('Pages/HR_pay_source', 'refresh');
        }
        else{
                echo "Insert error !";
        }
        }
   }
    public function savedata()
      {
         /*load registration view form*/
         $page = "index";
         $param = "payee";
         $param1 = "payeestatus";
         $param2 = "bankname";
         $table_name = "payee";
         $table_name1 = "employee_details";
         /*Check submit button */
         if($this->input->post('save'))
         {
             //Generate a random string.
            $token = openssl_random_pseudo_bytes(16);
            
            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token);

            $data['fullname']=$this->input->post('name');
            $data['address']=$this->input->post('address');
            $data['phone']=$this->input->post('phone');
            $data['email']=$this->input->post('email');
            $data['company_email']=$this->input->post('company_email');
            $data['statusid']=$this->input->post('statusid');
           // $data['bankno']=$this->input->post('bankno');
            //$data['accountname']=$this->input->post('accountname');
           // $data['accountno']=$this->input->post('accountno');
           // $data['notes']=$this->input->post('notes');
            $data['position']=$this->input->post('position');
            $data['datehired']=$this->input->post('datehired');
            $data['department']=$this->input->post('department');
            $data['secondary_department']=$this->input->post('secondary_department');
            $data['employee_lvl']=$this->input->post('employee_lvl');
            $data['active_status']= "Active";
            $data['authentication'] = $token;



            $data1['position_details']=$this->input->post('position');
           // $data1['effectivity_date']=$this->input->post('effectivity_date');
           // $data1['pay_rate']=$this->input->post('pay_rate');
            $response=$this->User_model->save_employee($table_name,$data,$table_name1,$data1);
            
            if($response==true){

                    $_SESSION['alert_message'] = "Successfully Added";
                    redirect('Pages/HR_dashboard', 'refresh');

            }
            else{
                  echo "Insert error !";
            }
         }
         
         elseif($this->input->post("save_night_diff")){     
                $records_details_data = array(
                    'payeeid'=> $this->input->post('payeeid'),
                    'ordinary_day'=> $this->input->post('ordinary_day'),
                    'rest_day'=> $this->input->post('rest_day'),
                    'special_day' => $this->input->post('special_day'),
                    'special_rest_day' => $this->input->post('special_rest_day'),
                    'regular_day' => $this->input->post('regular_day'),
                    'regular_rest_day' => $this->input->post('regular_rest_day'),
                    'double_day' => $this->input->post('double_day'),
                    'double_rest_day' => $this->input->post('double_rest_day')
                );
                $bulk_data[] = $records_details_data;
            
           $insert =  $this->User_model->insert_batch($bulk_data, 'payee_night_diff_list');  
            if($insert){
                $result = $this->User_model->update_where(array('night_diff_pay' => $this->input->post('night_diff_pay')), 'payee', 'payeeid = '.$this->input->post('payeeid').'');        
                if($result){
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
         }
         if($this->input->post("save_absent"))
         {
            $result = $this->User_model->update_where(array('absent_deduction' => $this->input->post('absent_deduction')), 'payee', 'payeeid = '.$this->input->post('payeeid').'');        
            if($result){
                redirect($_SERVER['HTTP_REFERER']);
            }

         }

      }

      public function delete_record($param)
      {

        $table_name = "payee";
        $user_data_table = "payeeid";
        $query=$this->User_model->delete_record($table_name,$param,$user_data_table);

        if($query == true)
        {
            $_SESSION['alert_message1'] = "Successfully deleted";
            redirect('Pages/HR_dashboard', 'refresh');
        }
        
      }
   
 
      //accounting

      public function Accounting_dashboard()
      {
          $page = "index";
          $param = "payee";
          $param1 = "payeestatus";
          $param2 = "bankname";
          $table_name = "pay";
          $user_data_table = "payeeid";
          $source = "source";
          $start_cutoff = "start_cutoff";
          $payeeid = $this->input->post('payeeid',true);
          if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
          {
              show_404();
          }
  
          //get function from models / User_Model.php / User_model class/ get_user function
  
   
          $data['pay_status'] = $this->User_model->get_join();
          $data['pay_source'] = $this->User_model->get_record($source);
          $data['start_cutoff'] = $this->User_model->get_record_date($start_cutoff);
          $data['pays'] = $payeeid;
          $this->load->view('templates/header');
          $this->load->view('templates/accounting_sidebar');
          $this->load->view('Accounting/'.$page, $data);
          $this->load->view('templates/footer');
          
      }

      public function Accounting_employee_list()
      {
        $page = "employee_list";
        $payeeid = $this->input->post('payeeid',true);
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }

        //get function from models / User_Model.php / User_model class/ get_user function

        $data['pay_status'] = $this->User_model->get_join_accounting_user_list();

       // $data['pay_status'] = $this->User_model->get_join();
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page, $data);
        $this->load->view('templates/footer');
      }

      public function Accounting_employee_list_details($param_auth,$parameter_id)
      {
        $page = "employee_details";
        $table_name = "bankname";
        $table_name1 = "payee";
        $user_data_table = "payeeid";
        $user_data_table2 = "id";
        $employee_tbl = "employee_details";
        $payeeid = $this->input->post('payeeid',true);
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        
        $table_name6 = "leave_total";
        $data['total_leave'] = $this->User_model->get_record_where($parameter_id,'payeeid',$table_name6);
        

        $data['sum'] = $this->User_model->sum_leave($parameter_id);

        $data['employee_id'] = $parameter_id;
        $data['employee_auth'] = $param_auth;
        $data['employee_records_files'] = $this->User_model->get_record_where($parameter_id,"payeeid","user_records_file");
        $data['users'] = $this->User_model->get_user_single($parameter_id,$table_name1,$user_data_table);
        $data['employee_details'] = $this->User_model->get_user_single($parameter_id,$employee_tbl,$user_data_table);
        $data['pay'] = $data['employee_details']['pay_rate'];
        $data['fullname'] = $data['users']['fullname'];
        if($data['pay'] == 0)
        {
            $data['pay_rate'] = "Please input Pay rate";
        }
        else
        {
            $data['pay_rate'] = $data['employee_details']['pay_rate'];
        }
        $bank_id = $data['users']['bankno'];
        if($bank_id != "0")
        {
            $table_name2 = "bankname";
            $user_data_table3 = "bankno";
            $data['bank_recordrecords'] = $this->User_model->get_user_single($bank_id,$table_name2,$user_data_table3);
            $data['bank_name'] = $data['bank_recordrecords']['bankname'];
            $data['bankno'] = $data['bank_recordrecords']['bankno'];
        }
        else
        {
            $data['bank_name'] = "Please Select Bank";
            $data['bankno'] = "0";
        }

     
          //break
          $table_name4 = "deductions";
          $data['deductions'] = $this->User_model->get_record_where($parameter_id,$user_data_table,$table_name4);
      


        //get function from models / User_Model.php / User_model class/ get_user function
        //$data['user_details'] = $this->User_model->get_user_single($parameter_id,$table_name,$user_data_table2);
        $data['bank_details'] = $this->User_model->get_record($table_name);
        //$data['pay_status'] = $this->User_model->get_join();
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
      }


      public function Accounting_process()
      {
        $page = "pay";
        $param = "payee";
        $param1 = "payeestatus";
        $param2 = "bankname";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }

        //get function from models / User_Model.php / User_model class/ get_user function

        $data['records'] = $this->User_model->get_record($param);
        $data['status'] = $this->User_model->get_record($param1);
        $data['bank_name'] = $this->User_model->get_record($param2);
    
    

        //get function from models / User_Model.php / User_model class/ get_user function


        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
          
      }

      public function Pay_details($param)
      {
        $page = "pay_details";
        $table_name = "pay";
        $user_data_table = "payeeid";
        $source = "source";
        $table_name1 = "payee";

        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }

        //get function from models / User_Model.php / User_model class/ get_user function

        //get function from models / User_Model.php / User_model class/ get_user function
        $data['records'] = $this->User_model->get_user_single($param,$table_name1,$user_data_table);
        $data['employee_name'] = $data['records']['fullname'];
        $data['night_diff_pay'] = $data['records']['night_diff_pay'];
        $data['absent_deduction'] = $data['records']['absent_deduction'];
        $data['employee_id'] = $param;
        $data['pay_history'] = $this->User_model->get_single_row($param,$table_name,$user_data_table);
        $data['user_pay'] = $this->User_model->get_user_pay($param);

        $table_name4 = "employee_details";
        $data['pay_rate'] = $this->User_model->get_user_single($param,$table_name4,$user_data_table);
        if($data['pay_rate'])
        {
            $data['employee_rate'] = $data['pay_rate']['pay_rate'];
        }
        
        $data['freelance_pay_rate'] = $this->User_model->get_user_single($param,$table_name4,$user_data_table);
        if($data['freelance_pay_rate'])
        {
            $data['freelance_pay_rate'] = $data['freelance_pay_rate']['freelance_pay_rate'];
        }
        
        $data['pay_source'] = $this->User_model->get_record($source);
        $table_name4 = "deductions";
        $data['deductions'] = $this->User_model->get_user_single($param,$table_name4,$user_data_table);
        if($data['deductions'])
        {
            $data['deduction_id'] = $data['deductions']['id'];
        }
        else 
        {
            $data['deduction_id'] = "0";
        }

        $table_name3 = "deductions ";
        //$data['employee_deduction'] = $this->User_model->get_record_where($param,$user_data_table,$table_name3);
        $data['employee_deduction'] = $this->User_model->select_where('*', 'deductions', array('payeeid' => $param,'status' => 0));
        if(empty($data['employee_deduction']))
        {
            $data['employee_deduction'] = "0";
        }
        //else{
          //  $data['employee_deduction'] = "0";
        //}
        $user_deduction_table = "user_deductions";
        $data['deduction_history'] = $this->User_model->get_deduction_history($param,$user_deduction_table,$user_data_table);

        $user_data_table5 = "payeeid";
        $table_name5 = "leave_details";
        $data['leave'] = $this->User_model->get_remaining_pto($param,$user_data_table5,$table_name5);
        if(empty($data['leave']))
        {
            $data['leave'] = "0";
        }
    


        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
          
      }

      public function process_pay($param)
      {
          $table_name = "pay";
           /*Check submit button */
           if($this->input->post('save'))
           {         
               $comments = array(
                    $this->input->post('royaltee_comment'),
                    $this->input->post('comission_comment'),
                    $this->input->post('incentives_comment'),
                    $this->input->post('other_fees_comment'),
                    $this->input->post('adjustment_comment'),
                    $this->input->post('bunos_comment'),
                    $this->input->post('marketing_fee_comment'),
                    $this->input->post('cash_advance_comment'),
                    $this->input->post('hourly_comment'),
                    $this->input->post('deduction_comment'),
                    $this->input->post('payrate_comment')
                );
                
                $concatenated_comments = implode(', ', array_filter($comments, 'strlen'));

            $result = $this->User_model->update_where(array('sourceid' => $this->input->post('sourceid'),
                'refno' => $this->input->post('refno'),
                'paiddate' => $this->input->post('paiddate'),
                'amount' => $this->input->post('amount'),
                'paidstatus' => $this->input->post('paidstatus'),
                'royaltee' => $this->input->post('royaltee'),
                'comission' => $this->input->post('comission'),
                'incentives' => $this->input->post('incentives'),
                'submited_by' => $this->session->userdata('fullname'),
                'absent_deduction' => $this->input->post('absent_deduction'),
                'adjustment' => $this->input->post('adjustment'),
                'pay_notes' => $concatenated_comments,
                'other_fees' => $this->input->post('other_fees'),
                'bunos' => $this->input->post('bunos'),
                'marketing_fee' => $this->input->post('marketing_fee'),
                'cash_advance' => $this->input->post('cash_advance'),
                'royaltee_comment' => $this->input->post('royaltee_comment'),
                'comission_comment' => $this->input->post('comission_comment'),
                'incentives_comment' => $this->input->post('incentives_comment'),
                'other_fees_comment' => $this->input->post('other_fees_comment'),
                'adjustment_comment' => $this->input->post('adjustment_comment'),
                'marketing_fee_comment' => $this->input->post('marketing_fee_comment'),
                'bunos_comment' => $this->input->post('bunos_comment'),
                'cash_advance_comment' => $this->input->post('cash_advance_comment'),
                'hourly_comment' => $this->input->post('hourly_comment'),
                'deduction_comment' => $this->input->post('deduction_comment'),
                'payrate_comment' => $this->input->post('payrate_comment'),
                'pay_rate' => $this->input->post('pay_rate'),
                'total_hours' => $this->input->post('total_hours'),
                'hourly_rate' => $this->input->post('hourly_rate'),
                'paidstatus' => "approved",
                ), 'pay', 'payid = '.$this->input->post('payid').'');       
            //   $response=$this->User_model->save_records($table_name,$data);
              if($result==true){
                  $table_name2 = "user_deductions";
                  
                  $bulk_data = array();
                  if($this->input->post('deduction_amount') != 0){
                    if($this->input->post('deduction_id'))
                    {
                        foreach ($this->input->post('deduction_id') as $key => $value) {
                            $records_details_data = array(
                                'user_deduction' => $this->input->post('deduction_amounts')[$key],
                                'deduction_id' => $this->input->post('deduction_id')[$key],
                                'payeeid' => $this->input->post('payeeid'),
                                'reference_no' => $this->input->post('refno'),
                                'date_paid' => $this->input->post('paiddate')
                            );
                            $bulk_data[] = $records_details_data;
                        }
                        $response1 = $this->User_model->insert_batch($bulk_data, 'user_deductions');   
      
                        if($response1 == true)
                        {
                          $table_name1 = "payee";
                        $payeeid = $this->input->post('payeeid');
                        $update = $this->User_model->update_row($table_name1,$payeeid);
                          if($update == true)
                          {
                          $_SESSION['alert_message'] = "Successfully Paid";
                         // redirect('Pages/Accounting_dashboard', 'refresh');
                         redirect($_SERVER['HTTP_REFERER']);
                          }
                          else{
                              echo "Insert error !";
                              }
                        }
                    }
                  }
                  else
                  {
                    $table_name1 = "payee";
                  $payeeid = $this->input->post('payeeid');
                  $update = $this->User_model->update_row($table_name1,$payeeid);
                    if($update == true)
                    {
                    $_SESSION['alert_message'] = "Successfully Paid";
                   // redirect('Pages/Accounting_dashboard', 'refresh');
                    redirect($_SERVER['HTTP_REFERER']);
                    }
                    else{
                        echo "Insert error !";
                        }
                  }
                
                 
              }
             
           }
      }

      public function insert_deduction($param)
      {
          $table_name = "deductions";
           /*Check submit button */
           if($this->input->post('save'))
           {         
              $data['deduction_type']=$this->input->post('deduction_type'); 
              $data['deduction_amount']=$this->input->post('deduction_amount'); 
              $data['start_date']=$this->input->post('start_date'); 
              $data['end_date']=$this->input->post('end_date'); 
              $data['frequency']=$this->input->post('frequency'); 
              $data['deduction_per_pay']=$this->input->post('deduction_per_pay'); 
              $data['notes']=$this->input->post('notes'); 
              $data['payeeid']=   $param; 
              $response=$this->User_model->save_records($table_name,$data);
              if($response==true){
                   $_SESSION['alert_message'] = "Deduction Successfully Added";
                   redirect($_SERVER['HTTP_REFERER']);
              }
              else{
                    echo "Insert error !";
              }
           }
           
     
      }


      
      public function reset_date()
      {
          $table_name = "start_cutoff";
           /*Check submit button */
           if($this->input->post('save'))
           {         
              $data['start_date']=$this->input->post('start_date'); 
              $data['cutoff_date']=$this->input->post('cutoff_date'); 
              $response=$this->User_model->save_records($table_name,$data);
              if($response==true){
                    $update = $this->reset_pay();
              }
              else{
              }
           }
      }


      public function reset_pay()
      {
        $update = $this->User_model->reset_pay();
        if($update == true)
        {
     
        }
        else{
            $_SESSION['alert_message'] = "Successfully Reset";
            redirect('Pages/Accounting_dashboard', 'refresh');
      }

      }

      public function monthly_budget_summary()
      {
        $page = "budget_summary";
     

        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['monthly_budget'] = $this->User_model->get_month();

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
          
      }

      public function post($param)
      {
        $page = "post";
        $table_name = "pay";
        $user_data_table = "paiddate";
        
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }

        $data['monthly_budget_details'] = $this->User_model->get_by_month($param,$user_data_table,$table_name);

        $data['monthly_budget_info'] = $param;

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
          
      }

      
      public function get_employeebudget()
      {
        $page = "employee_budget";
     

        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['employee_budget'] = $this->User_model->get_employeebudget();

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
          
      }


      public function export($param)
      {
        $page = "post";
        $table_name = "pay";
        $user_data_table = "paiddate";

        $data = $this->User_model->get_by_month($param,$user_data_table,$table_name);
    

        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Payment.xlsx"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Employee ID');
		$sheet->setCellValue('B1', 'Full Name');
		$sheet->setCellValue('C1', 'Amount');
		$sheet->setCellValue('D1', 'Paid Date');
        $sheet->setCellValue('E1', 'Source');
		$sn=2;
		foreach ($data as $row) {
		
			$sheet->setCellValue('A'.$sn,$row->payeeid);
			$sheet->setCellValue('B'.$sn,$row->fullname);
			$sheet->setCellValue('C'.$sn,$row->amount);
			$sheet->setCellValue('D'.$sn,$row->paiddate);
            $sheet->setCellValue('E'.$sn,$row->sourcename);
			$sn++;
		}
		//TOTAL

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
      }
      
      public function exportPays($start,$end)
      {
        $data = $this->User_model->get_pay_export($start,$end);

        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Payroll.csv"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Employee ID');
		$sheet->setCellValue('B1', 'Full Name');
		$sheet->setCellValue('C1', 'Amount');
		$sheet->setCellValue('D1', 'Paid Date');
        $sheet->setCellValue('E1', 'Payment Source');
        $sheet->setCellValue('F1', 'Reference Number');
        $sheet->setCellValue('G1', 'Incentives');
        $sheet->setCellValue('H1', 'Royaltee');
        $sheet->setCellValue('I1', 'comission');
        $sheet->setCellValue('J1', 'Base Pay');
        $sheet->setCellValue('K1', 'Total CA Deduction');
        $sheet->setCellValue('L1', 'Total Absent Deduction');
		$sn=2;
		foreach ($data as $row) {
		
			$sheet->setCellValue('A'.$sn,$row->payeeid);
			$sheet->setCellValue('B'.$sn,$row->fullname);
			$sheet->setCellValue('C'.$sn,$row->amount);
			$sheet->setCellValue('D'.$sn,$row->paiddate);
            $sheet->setCellValue('E'.$sn,$row->sourcename);
            $sheet->setCellValue('F'.$sn,$row->refno);
            $sheet->setCellValue('G'.$sn,$row->incentives);
            $sheet->setCellValue('H'.$sn,$row->royaltee);
            $sheet->setCellValue('I'.$sn,$row->comission);
            $sheet->setCellValue('J'.$sn,$row->pay_rate);
            $sheet->setCellValue('K'.$sn,$row->deduction);
            $sheet->setCellValue('L'.$sn,$row->absent_deduction);
			$sn++;
		}
		//TOTAL

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
      }
      
    public function exportPays_history($start)
      {
        $data = $this->User_model->get_pay_export_history($start);

        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Payroll.csv"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Employee ID');
		$sheet->setCellValue('B1', 'Full Name');
		$sheet->setCellValue('C1', 'Monthly Pay');
		$sheet->setCellValue('D1', 'BI - Monthly');
		$sheet->setCellValue('E1', 'Comission');
		$sheet->setCellValue('F1', 'Royaltee Fee');
		$sheet->setCellValue('G1', 'Incentives');
		$sheet->setCellValue('H1', 'Total CA Deduction');
		$sheet->setCellValue('I1', 'Total Absent Deduction');
		$sheet->setCellValue('J1', 'Adjustment');
		$sheet->setCellValue('K1', 'Total Pay');
		$sheet->setCellValue('L1', 'Transfer Fee Charges');
		$sheet->setCellValue('M1', 'Payment Source');
		$sheet->setCellValue('N1', 'Reference Number');
		$sheet->setCellValue('O1', 'Notes');
		$sheet->setCellValue('P1', 'Paid Date');
		$sn=2;
		foreach ($data as $row) {
		    $payee_id = $row->payeeid;
		    $date_paid = $row->paiddate;
		    $refno = $row->refno;
		    $bi_monthly = $row->pay_rate/2;
			$sheet->setCellValue('A'.$sn,$row->payeeid);
 			$sheet->setCellValue('B'.$sn,$row->fullname);
 			$sheet->setCellValue('C'.$sn,$row->pay_rate);
 			$sheet->setCellValue('D'.$sn,$bi_monthly);
 			$sheet->setCellValue('E'.$sn,$row->comission);
 			$sheet->setCellValue('F'.$sn,$row->royaltee);
 			$sheet->setCellValue('G'.$sn,$row->incentives);
 			$user_deduction= $this->User_model->query("SELECT SUM(user_deduction) as user_deduction FROM user_deductions WHERE payeeid = '$payee_id' AND date_paid = '$date_paid' ");
                if($user_deduction){
                    foreach($user_deduction as $result){
                     $sheet->setCellValue('H'.$sn,$result['user_deduction']);  
                    } 
                }
            $sheet->setCellValue('I'.$sn,$row->absent_deduction);
            $sheet->setCellValue('J'.$sn,$row->adjustment);
			$sheet->setCellValue('K'.$sn,$row->amount);
			$sheet->setCellValue('L'.$sn,$row->transfer_fee);
			$sheet->setCellValue('M'.$sn,$row->sourcename);
			$sheet->setCellValue('N'.$sn,$row->refno);
			$sheet->setCellValue('O'.$sn,$row->pay_notes);
			$sheet->setCellValue('P'.$sn,$row->paiddate);
			$sn++;
		}
		//TOTAL

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
      }
      
      public function generate_logs($account,$from,$to)
      {
        $decodedAccountName = $this->db->escape_like_str(urldecode($account));
        $data = $this->Interlink_model->query("SELECT * FROM tbl_service_logs
        INNER JOIN tbl_user ON tbl_service_logs.user_id = tbl_user.ID
        WHERE tbl_service_logs.account= '$decodedAccountName' AND tbl_service_logs.task_date between '$from' AND '$to'");
        
        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Logs.csv"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Task ID');
		$sheet->setCellValue('B1', 'Full Name');
		$sheet->setCellValue('C1', 'Description');
		$sheet->setCellValue('D1', 'Action');
        $sheet->setCellValue('E1', 'Comment');
        $sheet->setCellValue('F1', 'Account');
        $sheet->setCellValue('G1', 'Task Date');
        $sheet->setCellValue('H1', 'Minutes');
		$sn=2;
		if($data){
		   foreach ($data as $row) {
			$sheet->setCellValue('A'.$sn,$row['task_id']);
			$sheet->setCellValue('B'.$sn,$row['first_name'].$row['last_name']);
			$sheet->setCellValue('C'.$sn,$row['description']);
			$sheet->setCellValue('D'.$sn,$row['action']);
            $sheet->setCellValue('E'.$sn,$row['comment']);
            $sheet->setCellValue('F'.$sn,$row['account']);
            $sheet->setCellValue('G'.$sn,$row['task_date']);
            $sheet->setCellValue('H'.$sn,$row['minute']);
			$sn++;
		    }
		    //TOTAL 
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
      }
      
      public function generate_employee_logs($employee_id,$from,$to)
      {
        $decodedAccountName = $this->db->escape_like_str(urldecode($employee_id));
        $data = $this->Interlink_model->query("SELECT * FROM tbl_service_logs
        INNER JOIN tbl_user ON tbl_service_logs.user_id = tbl_user.ID
        WHERE tbl_service_logs.user_id= '$decodedAccountName' AND tbl_service_logs.task_date between '$from' AND '$to'");
        
        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Logs.csv"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Task ID');
		$sheet->setCellValue('B1', 'Full Name');
		$sheet->setCellValue('C1', 'Description');
		$sheet->setCellValue('D1', 'Action');
        $sheet->setCellValue('E1', 'Comment');
        $sheet->setCellValue('F1', 'Account');
        $sheet->setCellValue('G1', 'Task Date');
        $sheet->setCellValue('H1', 'Minutes');
		$sn=2;
		if($data){
		   foreach ($data as $row) {
			$sheet->setCellValue('A'.$sn,$row['task_id']);
			$sheet->setCellValue('B'.$sn,$row['first_name'].$row['last_name']);
			$sheet->setCellValue('C'.$sn,$row['description']);
			$sheet->setCellValue('D'.$sn,$row['action']);
            $sheet->setCellValue('E'.$sn,$row['comment']);
            $sheet->setCellValue('F'.$sn,$row['account']);
            $sheet->setCellValue('G'.$sn,$row['task_date']);
            $sheet->setCellValue('H'.$sn,$row['minute']);
			$sn++;
		    }
		    //TOTAL 
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
      }
  
  
      
      public function insert_leave($param2,$param)
      {
        $user_data_table = "payeeid";
        $table_name = "leave_total";

        if($this->input->post('save'))
        {  
            $data = $this->User_model->get_record_where($param,$user_data_table,$table_name);
            if($data)
            {
               $data1=$this->input->post('total_leave'); 
               $data2=$this->input->post('current_leave');
               $leave_input = intval( $data1 );
               $remain_input = intval( $data2 );

               $leave_total = $leave_input + $remain_input;

               if($leave_total <= 24)
                {
                    $update = $this->User_model->update_leave($table_name,$param,$leave_total);
                }
                else
                {
                    ?>
                    <script type="text/javascript">
                       alert("Leave must not exceed to 24");
                    </script>
                    <?php
                    redirect($_SERVER['HTTP_REFERER']);
                    
                }

            }
           
            else
            {
                //$update = $this->reset_pay();
                $data['total_leave']=$this->input->post('total_leave'); 
                $data['payeeid'] = $param;
                if($data['total_leave'] <= 24)
                {
                    $response=$this->User_model->save_records($table_name,$data);
                    if($response)
                    {
                       // $_SESSION['alert_message'] = "Deduction Successfully Added";
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }

                else
                {
                    ?>
                    <script type="text/javascript">
                       alert("Leave must not exceed to 24");
                      
                    </script>
                    <?php
                    redirect($_SERVER['HTTP_REFERER']);
                }
                
            }
        }
        elseif($this->input->post('save_employee_user'))
        {
             $table_name = "tbl_users";
             $data['username']=$this->input->post('username'); 
             $data['id']=$param; 
             $data['password']=$this->input->post('password'); 
             $data['user_type_id']=$this->input->post('user_type_id'); 

             $response=$this->User_model->save_records($table_name,$data);
             if($response==true){
                  redirect($_SERVER['HTTP_REFERER']);
             }
             else{
                   echo "Insert error !";
             }
        }

        else
        {
            echo "fail to save ";
        }
      }
      
      public function upadte_add_leave($param2,$param){
        $user_data_table = "payeeid";
        $table_name = "leave_total";
            if($this->input->post('save')){
                $data = $this->User_model->get_record_where($param,$user_data_table,$table_name);
                if($data)
                {
                   $data1=$this->input->post('total_leave'); 
                   $data2=$this->input->post('current_leave');
                   $leave_input = floatval( $data1 );
                   $remain_input = floatval( $data2 );
            
                   $leave_total = $leave_input + $remain_input;
            
                   if($leave_total <= 24)
                    {
                        $update = $this->User_model->update_leave($table_name,$param,$leave_total);
                        if($update){
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                           alert("Leave must not exceed to 24");
                        </script>
                        <?php
                        redirect($_SERVER['HTTP_REFERER']);
                        
                    }
                }
                else
                {
                    //$update = $this->reset_pay();
                    $data['total_leave']=$this->input->post('total_leave'); 
                    $data['payeeid'] = $param;
                    if($data['total_leave'] <= 24)
                    {
                        $response=$this->User_model->save_records($table_name,$data);
                        if($response)
                        {
                           // $_SESSION['alert_message'] = "Deduction Successfully Added";
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                           alert("Leave must not exceed to 24");
                          
                        </script>
                        <?php
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }
            
      }

      public function insert_leave_details($param2,$param)
      {

        if($this->input->post('save'))
           {         
              $table_name = "leave_details"; 
              $table_name2 = "leave_total";
              $data['leave_type']=$this->input->post('leave_type'); 
              $data['leave_count']=$this->input->post('leave_count'); 
              $data['start_date']=$this->input->post('start_date'); 
              $data['end_date']=$this->input->post('end_date'); 
              $data['payeeid']=$param; 

              $response=$this->User_model->save_records($table_name,$data);
              if($response==true){
                     $data1 = $this->input->post('leave_count'); 
                     $leave_input = intval( $data1 );

                     $update = $this->User_model->update_leave_subtract($table_name2,$param,$leave_input);
                     
                        return redirect('/Pages/employee_details/'.$param2.'/'.$param.'', 'refresh');
              }
              else{
              }
           }

           if($this->input->post('save_request'))
           {         
              $table_name = "leave_details"; 
              $table_name2 = "leave_total";
              $data['leave_type']=$this->input->post('leave_type'); 
              $data['leave_count']=$this->input->post('leave_count'); 
              $data['start_date']=$this->input->post('start_date'); 
              $data['end_date']=$this->input->post('end_date'); 
              $data['payeeid']=$param; 

              $response=$this->User_model->save_records($table_name,$data);
              if($response==true){
                    
                    redirect($_SERVER['HTTP_REFERER']);
              }
              else{
              }
           }
           if($this->input->post('save_request_manager')){
              $table_name = "leave_details"; 
              $table_name2 = "leave_total";
              $data['leave_type']=$this->input->post('leave_type'); 
              $data['leave_count']=$this->input->post('leave_count'); 
              $data['start_date']=$this->input->post('start_date'); 
              $data['end_date']=$this->input->post('end_date'); 
              $data['approve_status'] = "1";
              $data['payeeid']=$param; 

              $response=$this->User_model->save_records($table_name,$data);
              if($response==true){
                    $_SESSION['alert_message'] = "Status Succefully Updated";
                    redirect($_SERVER['HTTP_REFERER']);
              }
              else{
              }
           }
           
            if($this->input->post('update_pto'))
           {         
            $result = $this->User_model->update_where(array(
                'leave_type' => $this->input->post('leave_type'),
                'leave_count' => $this->input->post('leave_count'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'notes' => $this->input->post('notes'),
                'approve_status'=> $this->input->post('approve_status')),
                'leave_details', 'id = '.$this->input->post('leave_ids').'');   
            if($result==true){
                    $_SESSION['alert_message'] = "Status Succefully Updated";
                    redirect($_SERVER['HTTP_REFERER']);
              }
            else{
              }
           }


      }
      
      public function Accounting_PTO()
      {
          $page = "leave_details";
          $param2 = $_SESSION['id'];
          $table_name = "leave_details";
          $user_data_table = "payeeid";
          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          //get function from models / User_Model.php / User_model class/ get_user function
          $data['pay_list'] = $this->User_model->get_record_where($param2,$user_data_table,$table_name);
          $table_name2 = "leave_total";
          $data['remaining_leave'] = $this->User_model->get_user_single($param2,$table_name2,$user_data_table);
          $data['leave'] = $data['remaining_leave']['total_leave'];

          $this->load->view('templates/header');
          $this->load->view('templates/accounting_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
          
      }

      public function Update_pay($param,$param2)
      {
            $table_name = "pay";
            $update = $this->User_model->update_pay($table_name,$param,$param2);
            if($update)
            {
                    $_SESSION['alert_message'] = "Status Succefully Updated";
                     redirect($_SERVER['HTTP_REFERER']);
            }
      }


      public function Employee_dashboard()
      {
           if($_SESSION['user_type_id'] == "4" ){
              echo '<script> window.history.go(-1) </script>';
          }
          $page = "index";
          $param2 = $_SESSION['id'];
          $table_name = "pay";
          $table_name2 ="payee";
          $user_data_table = "payeeid";
          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          //get function from models / User_Model.php / User_model class/ get_user function
          $data['pay_list'] = $this->User_model->get_employee_pay_list($table_name, $user_data_table , $param2);
          $data['records'] = $this->User_model->get_user_single($param2,$table_name2,$user_data_table);
          $data['status'] = $data['records']['paid_status'];

          $this->load->view('templates/header');
          $this->load->view('templates/employee_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
          
      }

      public function Employee_PTO()
      {
          $page = "leave_details";
          $param2 = $_SESSION['id'];
          $table_name = "leave_details";
          $user_data_table = "payeeid";
          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          //get function from models / User_Model.php / User_model class/ get_user function
          $data['pay_list'] = $this->User_model->get_record_where($param2,$user_data_table,$table_name);
          $table_name2 = "leave_total";
          $data['remaining_leave'] = $this->User_model->get_user_single($param2,$table_name2,$user_data_table);
          if($data['remaining_leave']){
              $data['leave'] = $data['remaining_leave']['total_leave'];
          }

          $this->load->view('templates/header');
          $this->load->view('templates/employee_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
          
      }

      public function Supervisor_PTO()
      {
          $page = "leave_details_manager";
          $param2 = $_SESSION['id'];
          $table_name = "leave_details";
          $user_data_table = "payeeid";
          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          //get function from models / User_Model.php / User_model class/ get_user function
          $data['pay_list'] = $this->User_model->get_record_where($param2,$user_data_table,$table_name);
          $table_name2 = "leave_total";
          $data['remaining_leave'] = $this->User_model->get_user_single($param2,$table_name2,$user_data_table);
          
          if(!empty($data['remaining_leave']['total_leave'])){
            $data['leave'] = $data['remaining_leave']['total_leave'];
          }
          $this->load->view('templates/header');
          $this->load->view('templates/supervios_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
          
      }

      public function update_pto($pto_id,$param,$value)
      {
        $table_name = "leave_details";
        $update = $this->User_model->update_pto($table_name,$pto_id,$value);
        if($update)
        {
                $_SESSION['alert_message'] = "Status Succefully Updated";
                redirect('Pages/supervisor_request', 'refresh');
        }
      }
      public function update_pto_disapprove($pto_id,$param,$value)
      {
        $table_name = "leave_details";
        $update = $this->User_model->update_pto($table_name,$pto_id,$value);
        if($update)
        {
                $_SESSION['alert_message'] = "Status Succefully Updated";
                redirect('Pages/pto_request', 'refresh');
        }
      }

      public function update_pto_hr($pto_id,$param,$value,$leave_count)
      {
        $table_name = "leave_details";
        if($value == 4){
            $update = $this->User_model->update_leave_add_hr($table_name,$param,$value,$leave_count,$pto_id);
            if($update)
            {
                echo '<script> window.history.go(-1) </script>';
            } 
        }
        else{
            $update = $this->User_model->update_leave_subtract_hr($table_name,$param,$value,$leave_count,$pto_id);
            if($update)
            {
                    echo '<script> window.history.go(-1) </script>';
            } 
        }
        
        
      }




      public function Supervisor_dashboard()
      {
          if($_SESSION['user_type_id'] != "4"){
              echo '<script> window.history.go(-1) </script>';
          }
          $page = "supervisor_dashboard";
          $param2 = $_SESSION['id'];
          $table_name = "pay";
          $table_name2 ="payee";
          $user_data_table = "payeeid";
          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
          $data['pay_list'] = $this->User_model->get_employee_pay_list($table_name, $user_data_table , $param2);
          $data['records'] = $this->User_model->get_user_single($param2,$table_name2,$user_data_table);
          $data['status'] = $data['records']['paid_status'];
          //get function from models / User_Model.php / User_model class/ get_user function

         
          $this->load->view('templates/header');
          $this->load->view('templates/supervios_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
          
      }

      public function supervisor_request()
      {
          $page = "supervisor_request";
          $param2 = $_SESSION['id'];
          $table_name = "payee";
          $user_data_table = "payeeid";
          $user_data_table1 = "department";
          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }

          $data['user_deptartment'] = $this->User_model->get_user_single($param2,$table_name,$user_data_table);
          $data['department'] = $data['user_deptartment']['department'];


          $param = $data['department'];
          $value = "0";
          $data['pto'] = $this->User_model->get_employee_PTO_request($param,$user_data_table1,$table_name,$param2,$value);

          $this->load->view('templates/header');
          $this->load->view('templates/supervios_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
          
      }

      public function update_employee_bank_pay($parameter_auth,$parameter_id)
      {
         $table_name = "employee_details";
         $user_data_table = "payeeid";
         $parameter_value = $this->input->post('pay_rate'); 
         $set_field = "pay_rate";
         $table_name1 = "payee";

             $parameter_value = array(
                "bankno" => $this->input->post('bankno'),
                "accountname" => $this->input->post('accountname'),
                "accountno" => $this->input->post('accountno')
           );
             $update1 = $this->User_model->update_table_array_where($table_name1,$user_data_table,$parameter_id,$parameter_value);
             if($update1)
             {
                if($this->input->post('pay_rate') == $this->input->post('exist_pay')){
                    $parameter_value = array(
                        "pay_rate" => $this->input->post('pay_rate'),
                        "pay_approve_status" => 1
                   );
                    $update = $this->User_model->update_table_array_where($table_name,$user_data_table,$parameter_id,$parameter_value);
                    if($update)
                    {
                        $_SESSION['alert_message'] = "Status Succefully Updated";
                        redirect('Pages/Accounting_employee_list_details/'.$parameter_auth.'/'.$parameter_id.'', 'refresh');
                    }
                }
                else{
                    $records_data = array(
                        'PK_id' => $parameter_id,
                        'old_data' => $this->input->post('exist_pay'),
                        'new_data' => $this->input->post('pay_rate'),
                        'submitted_by' => $this->session->userdata('fullname')
                        );
                        $result = $this->User_model->insert($records_data, 'for_approve',true);  
                        if($result)
                        {
                            $parameter_value = array(
                                "pay_approve_status" => 1
                           );
                            $update = $this->User_model->update_table_array_where($table_name,$user_data_table,$parameter_id,$parameter_value);
                            if($update)
                            {
                                $_SESSION['alert_message'] = "Status Succefully Updated";
                                redirect('Pages/Accounting_employee_list_details/'.$parameter_auth.'/'.$parameter_id.'', 'refresh');
                            }
                        }
                } 
             }
        
         
      }

      public function update_employee_hr($parameter_auth,$parameter_id)
      {
        if($this->input->post('update_employee_information'))
        {      
            $table_name = "payee";   
            $user_data_table = "payeeid";

            $parameter_value = array(
                "fullname" => $this->input->post('fullname'),
                "address" => $this->input->post('address'),
                "email" => $this->input->post('email'),
                "company_email" => $this->input->post('company_email'),
                "statusid" => $this->input->post('statusid'),
                "employee_lvl" => $this->input->post('employee_lvl'),
                "phone" => $this->input->post('phone')
           );

            $update = $this->User_model->update_table_array_where($table_name,$user_data_table,$parameter_id,$parameter_value);

           if($update==true){
                $_SESSION['alert_message'] = "User Successfully Updated";
                return redirect('/Pages/employee_details/'.$parameter_auth.'/'.$parameter_id.'', 'refresh');
           }
           else{
                 echo "Insert error !";
           }
            
        }

        elseif($this->input->post('update_employee_details'))
        {      
            $table_name = "payee";   
            $user_data_table = "payeeid";

            $parameter_value = array(
                "datehired" => $this->input->post('datehired'),
                "position" => $this->input->post('position'),
                "emergency_contact_number" => $this->input->post('emergency_contact_number'),
                "secondary_department" => $this->input->post('secondary_department'),
                "department" => $this->input->post('department')
           );

            $update = $this->User_model->update_table_array_where($table_name,$user_data_table,$parameter_id,$parameter_value);

           if($update==true){
                $table_name1 = "employee_details";
                $parameter_value = array(
                    "effectivity_date" => $this->input->post('effectivity_date')
                );

                $update = $this->User_model->update_table_array_where($table_name1,$user_data_table,$parameter_id,$parameter_value);
                
                $_SESSION['alert_message'] = "User Successfully Updated";
                return redirect('/Pages/employee_details/'.$parameter_auth.'/'.$parameter_id.'', 'refresh');
            }

           else{
                 echo "Insert error !";
           }
        }

        elseif($this->input->post('save_records'))
        {
            $config['allowed_types'] = 'jpg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf';
            $config['upload_path'] = './uploads';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload',$config);
            
            if($this->upload->do_upload('record_file_name'))
            {
                //print_r($this->upload->data('file_name'));
                $data['record_name']=$this->input->post('record_name');
                $data['payeeid']=$parameter_id;
                $data['record_file_name']=$this->upload->data('file_name');
                $query = $this->User_model->insert($data, 'user_records_file', true);
                        
           if($query==true)
            {
                $_SESSION['alert_message'] = "Record successfully added";
                redirect($_SERVER['HTTP_REFERER']);
            }
    
            }
            else
            {
                print_r($this->upload->display_errors());  
            }
        }

        
      }

      public function employee_pay_details($parameter_paysource,$parameter_paid_date,$reference_no = null)
      {
        $page = "pay_slip";
        $param = $parameter_paid_date;
        $user_data_table = "paiddate";
        $table_name = "pay";
        if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
        {
            show_404();
        }
        $data['pay_source'] = $parameter_paysource;
        $data['pay_details'] = $this->User_model->get_user_single($param,$table_name,$user_data_table);
        $data['pays_details'] = $this->User_model->get_user_single($reference_no,$table_name,'refno');
        $data['paiddate'] = $parameter_paid_date;
        $table_name1 = "user_deductions";
        $param1 = $reference_no;
        $user_data_table1 = "reference_no";
        $data['pay_deduction'] = $this->User_model->get_user_single($param1,$table_name1,$user_data_table1);
        
        $this->load->view('templates/header');
        if($this->session->userdata('user_type_id') != 4 ){
            $this->load->view('templates/employee_sidebar');
        }
        else{
            $this->load->view('templates/supervios_sidebar');
        }
        
        $this->load->view('Employee/'.$page,$data);
        $this->load->view('templates/footer');
        
      }
      
      function download($filename = NULL)
       {
        // load download helder
        $this->load->helper('download');
        // read file contents
        $name = $filename;
        $data = file_get_contents('./uploads/'.$filename);
        force_download($name, $data);

        }
        
        function update_table($param_id,$payeeid,$update_type)
        {
            try{
                if($update_type == "cancel_pay")
                {
                    $update = $this->User_model->update_table("pay","payid",$param_id,"cancel" , "paidstatus");
                    if($update)
                    {
                        $_SESSION['alert_message'] = "Record successfully updated";
                        return redirect('/Pages/Pay_details/'.$payeeid.'');
                    }
                }
                elseif($update_type == "updatepay")
                {
                    $payeeid = $this->input->post('payeeid');
                    $select_basic = $this->User_model->query("SELECT * FROM employee_details WHERE payeeid = '$payeeid' ");
                    $basic_pay = $select_basic[0]['pay_rate']/2;
                    
                    $result = $this->User_model->update_where(array(
                        'comission' => $this->input->post('comission'),
                        'incentives' => $this->input->post('incentives'),
                        'royaltee' => $this->input->post('royaltee'),
                        'transfer_fee' => $this->input->post('processing_fee'),
                        'pay_notes' => $this->input->post('notes'),
                        'adjustment' => $this->input->post('adjustment'),
                        'sourceid' => $this->input->post('sourceid'),
                        'refno' => $this->input->post('refno'),
                        'paiddate' => $this->input->post('paiddate'),
                        'pay_rate' => $basic_pay,
                        'amount' => !empty($this->input->post('new_amount')) ?  $this->input->post('new_amount') : $this->input->post('amount'),
                        'paidstatus' => $this->input->post('paidstatus')), 'pay', 'payid = '.$this->input->post('payid').'');                  
                    if($result)
                    {
                        // $_SESSION['alert_message'] = "Record successfully updated";
                        // redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                elseif($update_type == "update_deduct")
                {
                    $result = $this->User_model->update_where(array('deduction_per_pay' => $this->input->post('deduction_per_pay'),'deduction_amount' => $this->input->post('deduction_amount'),'deduction_type' => $this->input->post('deduction_type'),'start_date' => $this->input->post('start_date'),'end_date' => $this->input->post('end_date'),'frequency' => $this->input->post('frequency'),'notes' => $this->input->post('notes')), 'deductions', 'id = '.$this->input->post('id').'');          
                    if($result)
                    {
                        $_SESSION['alert_message'] = "Record successfully updated";
                        return redirect('/Pages/Accounting_employee_list_details/'.$this->input->post('auth_ref').'/'.$payeeid.'');
                    }
                }

            }
            catch(\Exception $e){
                log_message('error', $e->getMessage());
                redirect(site_url('Pages/Pay_details/'.$param_id.''));
            }
        }
        function get_pay()
        {
            $id = $this->input->get('id');
            $get_pay= $this->User_model->select_where('*', 'pay', array('payid' => $id));
            echo json_encode($get_pay); 
            exit();
        }
          function delete_records($table_name,$where,$parameter_id)
        {

            $delete = $this->User_model->delete_record($table_name,$parameter_id,$where);
            if($delete){
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
           function update($table_name,$condition_paramerter,$parameter)
        {
            $result = $this->User_model->update_where(array('active_status' => $condition_paramerter), $table_name, 'payeeid = '.$parameter.'');  
            if($result){
                redirect($_SERVER['HTTP_REFERER']);
            }       
        }

        function employee_deactivated()
        {
            $page = "employee_deactivated";
            $param = "payee";
            $param1 = "payeestatus";
            $param2 = "bankname";
            if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
            {
                show_404();
            }

            //get function from models / User_Model.php / User_model class/ get_user function

            $data['records'] = $this->User_model->get_record_deactivate($param);
            $data['status'] = $this->User_model->get_record($param1);
            $data['bank_name'] = $this->User_model->get_record($param2);
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('HR/'.$page, $data);
            $this->load->view('templates/footer');
        }
        
        
        
        public function payment_history()
        {
          $page = "payment_history";
          $payeeid = $this->input->post('payeeid',true);
          if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
          {
              show_404();
          }
  
          $data['date_cutoff'] = $this->User_model->query("SELECT DISTINCT paiddate FROM pay;");
          $this->load->view('templates/header');
          $this->load->view('templates/accounting_sidebar');
          $this->load->view('Accounting/'.$page,$data);
          $this->load->view('templates/footer');
            
        }
  
    function get_payment_history()
        {
            $start_date = $_GET['start_date'];
            $cutoff_date = $_GET['cutoff_date'];

            $data = $this->User_model->query ("SELECT DISTINCT *, payee.payeeid,fullname,employee_id FROM payee INNER JOIN pay ON payee.payeeid = pay.payeeid INNER JOIN employee_details ON employee_details.payeeid = payee.payeeid WHERE paiddate >= '$start_date' AND paiddate <= '$cutoff_date' AND payee.payeeid != '146'");
            if($data){
                foreach($data as $row){
                    echo '
                    <tr>
                        <td>'.$row['payeeid'].'</td>
                        <td>'.$row['fullname'].'</td>
                        <td>'.$row['position'].'</td>
                        <td>';
                            $pay_rate = $row['pay_rate'];
							$bi_month = $pay_rate/2;
							echo $bi_month;
                        
                    echo'    </td>
                        <td>'.$row['company_email'].'</td>
                        <td>'.$row['employee_lvl'].'</td>
                        <td>'.$row['paiddate'].'</td>
                    ';

                    if($row['paidstatus'] == "paid"){
                        echo "<td><span class='badge badge-success'>Paid</span></td>";
                    }
                    elseif($row['paidstatus'] == "forpay"){
                        echo "<td><span class='badge badge-success'>forpay</span></td>";
                    }
                    elseif($row['paidstatus'] == "onhold"){
                        echo "<td><span class='badge badge-danger'>onhold</span></td>";
                    }
                    elseif($row['paidstatus'] == "process"){
                        echo "<td><span class='badge badge-primary'>process</span></td>";
                    }
                    elseif($row['paidstatus'] == "unpaid")
                    {
                        echo "<td><span class='badge badge-warning'>Unpaid</span></td>";
                    }
                    elseif($row['paidstatus'] == "approved")
                    {
                        echo "<td><span class='badge badge-warning' style='background-color:yellow;'>Reviewed</span></td>";
                    }
                    echo '<td>';
                        echo '
                            <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" target="_blank" href="'.site_url('Pages/Pay_details/').''.$row['payeeid'].'/'.$row['payid'].'/'.$row['paiddate'].'/'.$row['start_date'].'"><i class="dw dw-eye"></i> View/Pay</a>
                                    <button data-toggle="modal" data-target="#bd-example-modal-lg2" class="dropdown-item" id="" value="<?php echo $row->payeeid; ?>" href="#"><i class="dw dw-edit3"></i> Unpaid</button>
                                    <a class="dropdown-item" href="'.site_url('Pages/Update_pay/').''.$row['payid'].'/forpay"><i class="icon-copy ion-android-navigate"  style="color:green"></i>Forpay</a>
                                    <a class="dropdown-item" href="'.site_url('Pages/Update_pay/').''.$row['payid'].'/onhold"><i class="icon-copy ion-ios-locked-outline" style="color:red"></i> Onhold</a>
                                    <a class="dropdown-item" href="'.site_url('Pages/Update_pay/').''.$row['payid'].'/process"><i class="icon-copy ion-load-c" style="color:blue"></i> Process</a>
                                </div>
                            </div>
                        ';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
    function process_new()
    {
        
        $date_array = array(
             'start_date' => $this->input->post('start_date'),
             'cutoff_date' => $this->input->post('paid_date'),
             'pay_period' => $this->input->post('pay_period')
         );
         $insert_date = $this->User_model->insert($date_array, 'start_cutoff', true);
         if($insert_date){
            $query = $this->User_model->query("SELECT payeeid FROM payee");
            foreach($query as $row){
                $no_logs_count = 0;
                $user_id =  $row['payeeid'];
                $paiddate = $this->input->post('paid_date');
                $start_date = $this->input->post('start_date');
                $begin = new DateTime($this->input->post('start_date'));
                $end   = new DateTime($this->input->post('paid_date'));
                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $task_date = $i->format("Y-m-d");
                    $nameOfDay = date('D', strtotime($task_date));
                  
                      if($nameOfDay != "Sun" AND $nameOfDay != "Sat"){
                         $select_logs = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee 
                         INNER JOIN tbl_user ON tbl_user.employee_id = tbl_hr_employee.ID
                         INNER JOIN tbl_service_logs ON tbl_service_logs.user_id = tbl_user.ID
                         WHERE tbl_user.employee_id = '$user_id' AND tbl_service_logs.task_date = '$task_date'
                         ");
                         if(empty($select_logs)){
                             $no_logs_count++;
                         }
                         if($begin == $end){
                             $total_count = $no_logs_count;
                         }
                      }
                }
                 if($total_count == 0){
                     $paidstatus = "unpaid";
                 }
                 else{
                     $paidstatus = "onhold";
                 }
                 $data = array(
                     'payeeid' => $user_id,
                     'paidstatus' => $paidstatus,
                     'paiddate' => $paiddate,
                     'start_date' => $start_date
                 );
                 $insert_query = $this->User_model->insert($data, 'pay', true);
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
        
    public function update_flag_status($start)
    {
        $result = $this->User_model->update_where(array('approved_status' => "1"), 'pay', 'paiddate = "'.$start.'"'); 
        if($result){
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function update_flag_status1($start)
    {
        $result = $this->User_model->update_where(array('approved_status' => "2"), 'pay', 'paiddate = "'.$start.'"'); 
        if($result){
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function update_flag_status2($start)
    {
        $result = $this->User_model->update_where(array('approved_status' => "3"), 'pay', 'paiddate = "'.$start.'"'); 
        if($result){
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function get_for_approve_pay()
    {
          $page = "pay_for_approval";

          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          $data['for_approval'] = $this->User_model->query("SELECT DISTINCT paiddate,approved_status FROM pay WHERE approved_status != '0'");
          $this->load->view('templates/header');
          $this->load->view('templates/supervios_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
    }
    
    public function get_approve_pay_list($paiddate)
    {
        $page = "pay_for_approval_list";

          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
            $data['pay_status'] = $this->User_model->query ("SELECT DISTINCT *, payee.payeeid,fullname,employee_id,comission,incentives,royaltee FROM payee INNER JOIN pay ON payee.payeeid = pay.payeeid INNER JOIN employee_details ON employee_details.payeeid = payee.payeeid WHERE payee.payeeid != '146' AND pay.paiddate = '$paiddate'");
           $data['pay_source'] = $this->User_model->select_no_where("*",$table_name = "source");   
            
             $this->load->view('templates/header');
            $this->load->view('templates/supervios_sidebar');
            $this->load->view('Employee/'.$page,$data);
            $this->load->view('templates/footer');
    }
    
    public function approve_pay()
    {
          $page = "pay_approved";

          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          $data['for_approval'] = $this->User_model->query("SELECT DISTINCT paiddate,approved_status FROM pay WHERE approved_status = '1' OR approved_status = '2' OR approved_status = '3'");
          $this->load->view('templates/header');
          $this->load->view('templates/approved_pay');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
    }
    
    public function approved_pay_list($paiddate)
    {
        $page = "pay_for_done_list";

          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
          $data['pay_status'] = $this->User_model->query ("SELECT DISTINCT *, payee.payeeid,fullname,employee_id FROM payee INNER JOIN pay ON payee.payeeid = pay.payeeid INNER JOIN employee_details ON employee_details.payeeid = payee.payeeid WHERE payee.payeeid != '146'  AND pay.paiddate = '$paiddate' ");
            $data['pay_source'] = $this->User_model->select_no_where("*",$table_name = "source");                  
          $this->load->view('templates/header');
          $this->load->view('templates/approved_pay');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
    }
    
    public function for_approve_request()
    {
          $page = "for_approve_request";

          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
       
  
          $data['for_approval'] = $this->User_model->query("SELECT * FROM for_approve INNER JOIN payee ON for_approve.PK_id = payee.payeeid WHERE for_approve.flag_status = '0'");
          $this->load->view('templates/header');
          $this->load->view('templates/supervios_sidebar');
          $this->load->view('Employee/'.$page,$data);
          $this->load->view('templates/footer');
    }
    public function update_request($pay_rate,$payee_id)
    {
        $update = $this->User_model->update_where(array('pay_rate' => $pay_rate,'pay_approve_status' => 0), 'employee_details', 'payeeid = "'.$payee_id.'"');
        $update1 = $this->User_model->update_where(array('flag_status' => 1), 'for_approve', 'PK_id = "'.$payee_id.'"');
        redirect($_SERVER['HTTP_REFERER']);
        
    }
    public function update_request_delete($pay_rate,$payee_id)
    {
        
        $update1 = $this->User_model->update_where(array('flag_status' => 2), 'for_approve', 'PK_id = "'.$payee_id.'"');
        redirect($_SERVER['HTTP_REFERER']);
        
    }
    public function accounting_invoice()
    {

        $page = "invoice";
     

        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['get_month_invoice'] = $this->User_model->get_month_invoice();

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    
    public function accounting_invoice_month()
    {

        $page = "invoice_month";
     

        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['get_month_invoice'] = $this->User_model->get_month_invoice();

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    
    public function importFile(){
        $page = "invoice";
        // Check form submit or not 
        if($this->input->post('upload') != NULL ){ 
            
            // $data = array(); 
           if(!empty($_FILES['file']['name'])){ 
               
               $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
				fgetcsv($csvFile);
				$bulk_data = array();
				while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
				{
				    if($getData[6] != ''){
				        // Get row data
    					$records_details_data = array(
                            'task_id' => $getData[0],
                            'user_id' => $getData[1],
                            'description' => $getData[2],
                            'action' => $getData[3],
                            'comment' => $getData[4],
                            'account' => $getData[5],
                            'task_date' => $getData[6],
                            'minute' => $getData[7]
                        );
				    }
                    $bulk_data[] = $records_details_data;
				}
				$this->User_model->insert_batch($bulk_data, 'invoice'); 
				// Close opened CSV file
				redirect($_SERVER['HTTP_REFERER']);
				fclose($csvFile); 
            }
        }
    }
    
    public function get_employee(){
        $employee_id = $_GET['employee_id'];
        $data= $this->User_model->query("SELECT * FROM payee 
                INNER JOIN employee_details ON payee.payeeid = employee_details.payeeid 
                INNER JOIN bankname ON payee.bankno = bankname.bankno 
                WHERE payee.payeeid = '$employee_id'");
                $interlink_data_employee = $this->Interlink_model->query("SELECT * FROM others_employee_details WHERE employee_id = '$employee_id' ");
        $interlink_data = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee 
                INNER JOIN others_employee_details ON others_employee_details.employee_id = tbl_hr_employee.ID 
                INNER JOIN tbl_hr_job_description ON tbl_hr_job_description.ID = tbl_hr_employee.job_description_id
                WHERE tbl_hr_employee.ID = '$employee_id' ");
        $interlink_department = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee 
                INNER JOIN tbl_hr_department ON tbl_hr_department.ID = tbl_hr_employee.department_id
                WHERE tbl_hr_employee.ID = '$employee_id' ");
        foreach($data as $row){
            $address = $interlink_data[0]['address'];
            // Split the address by "|"
            $address_parts = explode("|", $address);
            
            // Remove "N/A" and empty elements from the address parts
            $address_parts_filtered = array_filter($address_parts, function($part) {
                return $part !== "N/A" && !empty($part);
            });
            
            // Join the filtered address parts with ","
            $formatted_address = implode(", ", $address_parts_filtered);
            echo '
                <div class="row">
                    <div class="col-md-6">
                        <label>Employee Name</label>
                        <input type="text" value="'.$interlink_data[0]['last_name'].','.$interlink_data[0]['first_name'].'" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Employee Position</label>
                        <input type="text" value="'.$interlink_data[0]['title'].'" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Employee Pay Rate</label>
                        <input type="text" value="'.$row['pay_rate'].'" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Employee Level</label>
                        <input type="text" value="'.$interlink_data[0]['employee_lvl'].'" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Department</label>
                        <input type="text" value="'.$interlink_department[0]['title'].'" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Company Email</label>
                        <input type="text" value="'.$interlink_data[0]['email'].'" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Bank Account Number</label>
                        <input type="text" value="'.$row['accountno'].'" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Bank Name</label>
                        <input type="text" value="'.$row['bankname'].'" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Account Name</label>
                        <input type="text" value="'.$row['accountname'].'" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Employee Address</label>
                        <input type="text" value="'.$formatted_address.'" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Phone Number</label>
                        <input type="text" value="'.$interlink_data_employee[0]['contact_no'].'" class="form-control" readonly>
                    </div>
                </div>
            ';
        }
    }
    
    public function Attendance(){
        $page = "attendance";
        if(!file_exists(APPPATH.'views/HR/'.$page.'.php'))
        {
            show_404();
        }
        $data['employee_list'] = $this->User_model->select_no_where("*","payee");  
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('HR/'.$page,$data);
        $this->load->view('templates/footer');
    }
    
    public function Accounting_employee(){
        $page = "employees";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['employee_list'] = $this->Interlink_model->query("SELECT *
            FROM tbl_hr_employee
            WHERE user_id = 34
              AND status = 1
              AND type_id IN (1, 2,3, 4, 5)
              AND ID NOT IN (347, 348);
        ");  
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    public function Accounting_employee_payslip(){
        $page = "employees_payslip";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['employee_list'] = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE user_id = 34 AND type_id IN (1, 2, 4, 5) AND ID NOT IN (347, 348) AND status = 1");  
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    public function Accounting_employee_annual(){
        $page = "employee_annual";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['employee_list'] = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE user_id = 34 AND type_id IN (1, 2, 4, 5) AND ID NOT IN (347, 348) AND status = 1");  
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    public function Accounting_employee_payslip_inactive(){
        $page = "employee_payslip_inactive";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['employee_list'] = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE user_id = 34 AND type_id IN (1, 2, 4, 5) AND ID NOT IN (347, 348) AND status = 0");  
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    public function employees_details(){
        $page = "employees_details";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['bank_details'] = $this->User_model->get_record("bankname");
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    
    public function update_employee($employee_id){
        $payee_check = $this->User_model->select_where('*', 'payee', array('payeeid' => $employee_id));
        $parameter_value = array(
                "bankno" => $this->input->post('bankno'),
                "accountname" => $this->input->post('accountname'),
                "accountno" => $this->input->post('accountno'),
                "payeeid" => $employee_id,
                "bankno" => $this->input->post('bankno')
           );
        if($payee_check){
            $update1 = $this->User_model->update_table_array_where("payee","payeeid",$employee_id,$parameter_value);
        }
        else{
            $result = $this->User_model->insert($parameter_value, 'payee',true);
        }
        $data_check = $this->User_model->select_where('*', 'employee_details', array('payeeid' => $employee_id));
        if($data_check){
            if($this->input->post('pay_rate') == $this->input->post('exist_pay') OR $this->input->post('exist_freelance_pay')== $this->input->post('hourly_rate') ){
               $result = $this->User_model->update_where(array('pay_rate' => $this->input->post('pay_rate'),'freelance_pay_rate' => $this->input->post('hourly_rate')), 'employee_details', 'payeeid = '.$employee_id.'');  
            }
            else{
                $pay_rate = $this->input->post('pay_rate');
                if($this->input->post('employee_type') == 4){
                    $pay_rate = $this->input->post('freelance_pay_rate');
                }
                $records_data = array(
                'PK_id' => $employee_id,
                'old_data' => $this->input->post('exist_pay'),
                'new_data' => $pay_rate,
                );
                $result = $this->User_model->insert($records_data, 'for_approve',true);  
                if($result)
                {
                    $parameter_value = array(
                        "pay_approve_status" => 1
                   );
                    $update = $this->User_model->update_table_array_where('employee_details','payeeid',$employee_id,$parameter_value);
                }
            }
        }
        else{
            $records_data = array(
            'payeeid' => $employee_id,
            'pay_rate' => $this->input->post('pay_rate'),
            'freelance_pay_rate' => $this->input->post('freelance_pay_rate')
            );
            $result = $this->User_model->insert($records_data, 'employee_details',true);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function process_payment($account){
        $page = "process_pay";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $data['accounts'] = $account;
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page,$data);
        $this->load->view('templates/footer');
    }
    public function process_pays(){
        $page = "pay";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }
    public function update_pay_period($value,$id){
        $result = $this->User_model->update_where(array('flag' => $value), 'start_cutoff', 'id = '.$id.'');  
        if($result){
          redirect($_SERVER['HTTP_REFERER']);  
        }
    }
    public function payroll_summary(){
        $page = "payroll_summary";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }
    public function generate_summary(){
        $page = "generate_summary";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }
    
    public function monthly_summary(){
        $page = "monthly_summary";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }
    public function generate_monthly(){
        $page = "generate_monthly";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }
    public function monthly_invoice(){
        $page = "monthly_summary1";
        if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }
    public function get_active_accounts(){
        $from = $_GET['from'];
        $to = $_GET['to'];
        $rows = $this->Interlink_model->query("SELECT DISTINCT account FROM tbl_service_logs WHERE task_date >= '$from' AND task_date <= '$to' AND account != '' ORDER BY account ASC ");
        if($rows){
            foreach($rows as $row){
                echo '
                    <option value="'.$row['account'].'" >'.$row['account'].'</option> 
                ';
            }  
        }
        
    }
    // public function get_employee_servicelogs(){
    //     $from = $_GET['from'];
    //     $to = $_GET['to'];
    //     $rows = $this->Interlink_model->query("SELECT DISTINCT account FROM tbl_service_logs WHERE task_date >= '$from' AND task_date <= '$to' AND account != '' ORDER BY account ASC ");
    //     if($rows){
    //         foreach($rows as $row){
    //             echo '
    //                 <option value="'.$row['account'].'" >'.$row['account'].'</option> 
    //             ';
    //         }  
    //     }
        
    // }
    public function get_employee_pay(){
        $pay_id = $_GET['payid'];
        $get_pay_sql = $this->User_model->query("SELECT * FROM pay WHERE payid = '$pay_id'");
        $date_paid = $get_pay_sql[0]['paiddate'];
        $payee_id = $get_pay_sql[0]['payeeid'];
        $payee_name = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = '$pay_id' ");
        $get_deduction = $this->User_model->query("SELECT * FROM user_deductions WHERE date_paid = '$date_paid' AND payeeid = '$payee_id'");
        // Retrieve and store the comments in an array
        $comments = array();
        
        if (!empty($get_pay_sql[0]['royaltee_comment'])) {
            $comments[] = $get_pay_sql[0]['royaltee_comment'];
        }
        
        if (!empty($get_pay_sql[0]['comission_comment'])) {
            $comments[] = $get_pay_sql[0]['comission_comment'];
        }
        
        if (!empty($get_pay_sql[0]['incentives_comment'])) {
            $comments[] = $get_pay_sql[0]['incentives_comment'];
        }
        
        if (!empty($get_pay_sql[0]['other_fees_comment'])) {
            $comments[] = $get_pay_sql[0]['other_fees_comment'];
        }
        
        if (!empty($get_pay_sql[0]['adjustment_comment'])) {
            $comments[] = $get_pay_sql[0]['adjustment_comment'];
        }
        
        // Convert the comments array to a string
        $commentsString = implode(', ', $comments);
        // Echo the comments separated by commas
        $deducs = 0;
        if($get_deduction){
          $deducs =  $get_deduction[0]['user_deduction'];
        }
        $pay_source = $this->User_model->select_no_where("*",$table_name = "source");
        echo '
            <div class="container">
				<div class="row">
					<div class="col-md-4">
						<label>Paid date</label>
						<input type="hidden" name="payid" value="'.$pay_id.'" id="pay_id">
						<input type="hidden" name="payeeid" value="'.$payee_id.'" id="payeeid">
						<input type="date" class="form-control" id="paiddate" value="'.$get_pay_sql[0]['paiddate'].'" name="paiddate"  placeholder="Enter Amount">
					</div>
					<div class="col-md-4">
						<label>Amount</label>
						<input type="text" class="form-control" id="amount" value="'.$get_pay_sql[0]['amount'].'" name="amount"  placeholder="Enter Amount">
					</div>
					<div class="col-md-4">
						<label>Paid status <span style="color:red">*</span></label>
						<select clas="form-control"  id="dropdown_data" name="paidstatus" style="width:100%;border-color:#d4d4d4;padding:10px">';
						     if( $this->session->userdata('fullname') == "Pena, Christine Joy" ){
						        echo '<option value="approved">Approved</option>
						        <option value="process">Processed</option>';
						     }
						      elseif( $this->session->userdata('fullname') == "Dahino, Cristina" ){
						         echo '<option value="process">Processed</option>
						        <option value="approved">Approved</option>';
						      }
			echo'				<option value="unpaid">Unpaid</option>	
							<option value="paid">Paid</option>
							<option value="forpay">For Pay</option>	
							<option value="onhold">On Hold</option>
							<option value="cancel">Cancel</option>	
						</select>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<label>Reference Number <span style="color:red">*</span></label>
						<input type="text" class="form-control" id="refno" name="refno" value="'.$get_pay_sql[0]['refno'].'"  placeholder="Enter Amount">
					</div>
					<div class="col-md-4">
						<label for="">Payment Source <span style="color:red">*</span> </label>
						<select clas="form-control" id="source_dropdown" name="sourceid" value="'.$get_pay_sql[0]['sourceid'].'" style="width:100%;border-color:#d4d4d4;padding:10px">
            ';
                        foreach($pay_source as $pay_source_row){
                            $value = $pay_source_row['sourceid'];
                    
                            // check if the current value matches the value in the database
                            if ($value == $get_pay_sql[0]['sourceid']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '
                                <option '.$selected.' value="'.$pay_source_row['sourceid'].'">'.$pay_source_row['sourcename'].'</option>
                            ';
                        }
            echo '
						</select>
					</div>
					<div class="col-md-4">
                        <label>Adjustment</label>
						<input type="text" class="form-control" id="adjustment" name="adjustment" value="'.$get_pay_sql[0]['adjustment'].'"  placeholder="Enter Amount">
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col-md-4 form-group">
						<label>Royaltee</label>
						<input type="text" class="form-control prc" id="royaltee" value="'.$get_pay_sql[0]['royaltee'].'" name="royaltee">
					</div>
					<div class="col-md-4 form-group">
						<label for="">Comission</label>
						<input type="text" class="form-control prc" id="comission" value="'.$get_pay_sql[0]['comission'].'" name="comission">
					</div>
					<div class="col-md-4">
						<label>CA Deduction</label>
						<input type="text" class="form-control" id="ca_deduction" name="ca_deduction" value="'.$deducs.'">
					</div>
					
				</div>
				
				<div class="row mt-3">
					<div class="col-md-4">
						<label>Bonus Fee</label>
						<input type="text" class="form-control" id="ca_deduction" name="bunos" value="'.$get_pay_sql[0]['bunos'].'"  placeholder="Enter Amount">
					</div>
					<div class="col-md-4">
					    <label>Marketing Fee</label>
						<input type="text" class="form-control" id="processing_fee" value="'.$get_pay_sql[0]['marketing_fee'].'" name="marketing_fee">
					</div>
					<div class="col-md-4">
					    <label>Process Fee<span style="color:red">*</span> </label>
						<input type="text" class="form-control" id="processing_fee" value="'.$get_pay_sql[0]['transfer_fee'].'" name="processing_fee"  placeholder="Enter Amount">
					</div>
					
				</div>
				<div class="row mt-3">
					<div class="col-md-4 form-group">
                        <label>Incentives</label>
						<input type="text" class="form-control prc" id="incenteives" value="'.$get_pay_sql[0]['incentives'].'" name="incenteives">
					</div>
					<div class="col-md-4">
                        <label>Other Fee</label>
						<input type="text" class="form-control" id="other_fees" name="other_fees" value="'.$get_pay_sql[0]['other_fees'].'"  placeholder="Enter Amount">
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<label>Notes</label>
						<textarea class="form-control" id="notes"name="notes" style="height:70px">'.$commentsString.'</textarea>
					</div>
				</div>
        </div>
        ';
    }
    
    public function get_approve_pay_list_duplicate($paiddate)
    {
        $page = "pay_for_approval_list_duplicate";

          if(!file_exists(APPPATH.'views/Employee/'.$page.'.php'))
          {
              show_404();
          }
  
            $data['pay_status'] = $this->User_model->query ("SELECT DISTINCT *, payee.payeeid,fullname,employee_id,comission,incentives,royaltee FROM payee INNER JOIN pay ON payee.payeeid = pay.payeeid INNER JOIN employee_details ON employee_details.payeeid = payee.payeeid WHERE payee.payeeid != '146' AND pay.paiddate = '$paiddate'");
           $data['pay_source'] = $this->User_model->select_no_where("*",$table_name = "source");   
            
             $this->load->view('templates/header');
            $this->load->view('templates/supervios_sidebar');
            $this->load->view('Employee/'.$page,$data);
            $this->load->view('templates/footer');
    }
    public function email_template()
    {
        $page = "email";

          if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
          {
              show_404();
          }
            $this->load->view('Accounting/'.$page);
            $this->load->view('templates/footer');
    }
    public function bank_comparison($employee_id){
            if($this->session->userdata('fullname') == 'Accounting Department'){
               $result = $this->Interlink_model->update_where(array('is_read' => 1), 'others_notification', 'employee_id = '.$employee_id.''); 
            }
            if($this->session->userdata('fullname') == 'Dahino, Cristina'){
                $result = $this->Interlink_model->update_where(array('user_1' => 1), 'others_notification', 'employee_id = '.$employee_id.''); 
            }
            if($this->session->userdata('fullname') == 'Pena, Christine Joy'){
               $result = $this->Interlink_model->update_where(array('user_2' => 1), 'others_notification', 'employee_id = '.$employee_id.''); 
            }
            $page = "bank_comparison";
            if(!file_exists(APPPATH.'views/Accounting/'.$page.'.php'))
            {
                show_404();
            }
            $this->load->view('templates/header');
            $this->load->view('templates/accounting_sidebar');
            $this->load->view('Accounting/'.$page);
            $this->load->view('templates/footer');
    }
    public function get_monthly_summary(){
        $from = $_GET['date_from'];
        $to = $_GET['date_to'];
        $year = 2023;
        $amount = 0;
        $total_amount = 0;
        $total_incentives = 0;
        $total_referal = 0;
        $total_adjusment = 0;
        $total_gross = 0;
        $total_net = 0;
        $incentives = 0;
        $total_comission = 0;
        $referal = 0;
        $total_deduction = 0;
        $adjust = 0;
        $other_fee = 0;
        $adjustment_sum = 0;
	    $adjustment_deduct = 0;
	    $new_adjustment_sum = 0;
        $new_adjustment_deduc = 0;
        $results = $this->User_model->query("SELECT start_cutoff.start_date,start_cutoff.cutoff_date, start_cutoff.pay_period, pay.paiddate, pay.payeeid,SUM(transfer_fee) as transfer_fee,SUM(other_fees) as other_fees,SUM(transfer_fee) as transfer_fee, SUM(pay.adjustment) as adjustment, SUM(pay.comission) as comission, SUM(pay.pay_rate) as amount, SUM(pay.incentives) as incentives, SUM(pay.comission) as comission, SUM(pay.royaltee) as royaltee 
                                            FROM pay 
                                            INNER JOIN start_cutoff ON start_cutoff.cutoff_date = pay.paiddate  
                                            WHERE paiddate >= '$from' AND paiddate <= '$to'  AND paidstatus IN ('process', 'paid')
                                            GROUP BY pay.paiddate");
            if($results){
                foreach($results as $row){
                    $new_from = $row['start_date'];
				    $new_to = $row['cutoff_date'];
				    $query_result = $this->User_model->query("SELECT payeeid,SUM(adjustment) as adjustment  FROM pay WHERE  paidstatus IN ('process', 'paid') AND paiddate >= '$new_from' AND paiddate <= '$new_to' GROUP BY payeeid ");
			        if($query_result):
				        foreach($query_result as $query_rows):
				            if($query_rows['adjustment'] < 0 ){
				            $adjustment_deduct = $query_rows['adjustment'];
				            $new_adjustment_deduc += $query_rows['adjustment'];
					        }
					        else{
					            $new_adjustment_sum += $query_rows['adjustment'];
					            $adjustment_sum = $query_rows['adjustment'];
					        }
				        endforeach;
			        endif;
				    $deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE date_paid >= '$new_from' AND date_paid <= '$new_to' GROUP BY date_paid");
                    $employee_count = $this->User_model->query("SELECT COUNT(*) as total_count FROM pay WHERE start_date BETWEEN '$new_from' AND '$new_to' AND paidstatus IN ('process', 'paid')");
                    $dedus = 0;
	                if($deduction){
	                    $total_deduction += $deduction[0]['user_deduction'];
	                    echo "$";echo $deduction[0]['user_deduction'];
	                    $dedus = $deduction[0]['user_deduction'];;
	                }
		                
		            $total_amount +=  $row['amount'];
		            $total_comission += $row['comission'];
		            $total_incentives += $row['incentives'];
		            $total_referal += $row['royaltee'];
		            $total_adjusment += $row['adjustment'];
		            $other_fee += $row['other_fees'];
		            $total_gross += number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'], 2, '.', '');
		            $total_net += $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'] - $dedus;
                    echo '
                    
                        <tr>
                          <td></td>
                          <td>'.  date("F j, Y", strtotime($row['pay_period'])).'</td>
                          <td>'.$employee_count[0]['total_count'].'</td>
                          <td>$'.$row['amount'].'</td>
                          <td>$'.number_format((float) $row['incentives'], 2, '.', '').'</td>
                          <td>$'.number_format((float) $row['comission'], 2, '.', '').'</td>
                          <td>$'.number_format((float) $row['royaltee'], 2, '.', '').'</td>
                          <td>$'.number_format((float) $row['transfer_fee'], 2, '.', '').'</td>
                          <td>$'.number_format((float) $new_adjustment_sum, 2, '.', '').'</td>
                          <td>$'.number_format((float) $row['amount'] + $row['incentives'] + $row['comission']+ $new_adjustment_sum + $row['royaltee'] + $other_fee, 2, '.', '').'</td>
                          <td>';
    			                if ($new_adjustment_deduc < 0) {
                                    $formattedValue1 = '$ (' . number_format(abs($new_adjustment_deduc), 2, '.', '') . ')'; // Remove negative sign, add dollar sign, and enclose in parentheses
                                } else {
                                    $formattedValue1 = '$' . number_format($new_adjustment_deduc, 2, '.', ''); // Add dollar sign for positive value
                                }
                                echo $formattedValue1;
                          echo '</td>
                          <td>';
    
        			                $dedu = 0;
        			                if($deduction){
        			                    $total_deduction += $deduction[0]['user_deduction'];
        			                    echo "$";echo $deduction[0]['user_deduction'];
        			                    $dedu = $deduction[0]['user_deduction'];;
        			                }
        			            
                          echo '</td>
                          <td>$'.$row['transfer_fee'].'</td>
                          <td>$'.number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $new_adjustment_sum + $row['royaltee'] + $other_fee - $deduction[0]['user_deduction'] + $new_adjustment_deduc  , 2, '.', '').'</td>
                        </tr>
                    ';
                }
                echo '
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>$'.number_format((float) $total_amount, 2, '.', '').'</td>
                            <td>$'.number_format((float) $total_incentives, 2, '.', '').'</td>
                            <td>$'.number_format((float) $total_comission, 2, '.', '').'</td>
                            <td>$'.$total_referal.'</td>
                            <td>$'.number_format((float) $total_gross, 2, '.', '').'</td>
                            <td>$'.number_format((float) $total_adjusment, 2, '.', '').'</td>
                            <td>$'.number_format((float) $total_deduction, 2, '.', '').'</td>
                            <td>$'.number_format((float) $total_net, 2, '.', '').'</td>
                        </tr>
                ';
            }
    }
    
    public function send_mail(){

         /* Load PHPMailer library */
        $this->load->library('phpmailer_lib');
       
        /* PHPMailer object */
        $mail = $this->phpmailer_lib->load();
       
        /* SMTP configuration */
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
	    $mail->Host       = 'interlinkiq.com';
	    $mail->SMTPAuth   = true;
	    $mail->Username   = 'admin@interlinkiq.com';
	    $mail->Password   = 'L1873@2019new';
	    $mail->SMTPSecure = 'tls';
	    $mail->Port       = 587;
       
        $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
       
        /* Add a recipient */
        
        $recipients = array(
            'marcjhonel.t.ojt@gmail.com' => 'Emjay'
        );
        
        foreach ($recipients as $email => $name) {
            $mail->addAddress($email, $name);
        }
       
        /* Add cc or bcc */
        $mail->addCC('');
        $mail->addBCC('');
       
        /* Email subject */
        $mail->Subject = 'Payroll Monthly Report';
       
        /* Set email format to HTML */
        $mail->isHTML(true);
        /* Email body content */
        $mailContent = '
           <!DOCTYPE html>
            <html>
            <head>
            	<meta charset="UTF-8">
            	<meta name="viewport" content="width=device-width, initial-scale=1.0">
            	<title>Payroll Summary</title>
            	<style>
            		table {
            			border-collapse: collapse;
            			width: 100%;
            			max-width: 600px;
            			margin: 20px auto;
            			font-family: Arial, sans-serif;
            			font-size: 14px;
            			color: #333;
            			border: 1px solid #999;
            		}
            		th, td {
            			border: 1px solid #999;
            			padding: 10px;
            			text-align: left;
            		}
            		th {
            			background-color: #ccc;
            			font-weight: bold;
            		}
            		tr:nth-child(even) {
            			background-color: #f2f2f2;
            		}
            		.total {
            			font-weight: bold;
            			background-color: #f5f5f5;
            		}
            		.gross-pay {
            			font-size: 20px;
            			font-weight: bold;
            			margin-top: 30px;
            		}
            		.net-pay {
            			font-size: 18px;
            			font-weight: bold;
            			margin-top: 10px;
            		}
            	</style>
            </head>
            <body>
            	<h2>Payroll Summary - April</h2>
            	<table>
            		<thead>
            			<tr>
            				<th>Pay Period</th>
            				<th>Basic Pay</th>
            				<th>Incentives</th>
            				<th>Referral</th>
            				<th>Commission</th>
            				<th>Adjustment</th>
            				<th>Deduction</th>
            				<th>Gross Pay</th>
            				<th>Net Pay</th>
            			</tr>
            		</thead>
            		<tbody>';
            			$months = 04;
                        $year = 2023;
                        $total_amount = 0;
                        $total_incentives = 0;
                        $total_referal = 0;
                        $total_adjusment = 0;
                        $total_gross = 0;
                        $total_net = 0;
                        $amount = 0;
                        $incentives = 0;
                        $total_comission = 0;
                        $referal = 0;
                        $total_deduction = 0;
                        $adjust = 0;
                        $deduction = $this->User_model->query("SELECT payeeid, SUM(user_deduction) as user_deduction FROM user_deductions WHERE MONTH(date_paid) = $months AND YEAR(date_paid) = $year GROUP BY date_paid");
                        $results = $this->User_model->query("SELECT start_cutoff.cutoff_date, start_cutoff.pay_period, pay.paiddate, pay.payeeid, SUM(pay.adjustment) as adjustment, SUM(pay.comission) as comission, SUM(pay.pay_rate) as amount, SUM(pay.incentives) as incentives, SUM(pay.comission) as comission, SUM(pay.royaltee) as royaltee FROM pay INNER JOIN start_cutoff ON start_cutoff.cutoff_date = pay.paiddate WHERE MONTH(pay.paiddate) = $months AND YEAR(pay.paiddate) = 2023 GROUP BY pay.paiddate");
                                foreach($results as $row){
                                    $dedus = 0;
					                if($deduction){
					                    $total_deduction += $deduction[0]['user_deduction'];
					                    echo "$";echo $deduction[0]['user_deduction'];
					                    $dedus = $deduction[0]['user_deduction'];;
					                }
						                
						            $total_amount +=  $row['amount'];
						            $total_comission += $row['comission'];
						            $total_incentives += $row['incentives'];
						            $total_referal += $row['royaltee'];
						            $total_adjusment += $row['adjustment'];
						            $total_gross += number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'], 2, '.', '');
						            $total_net += $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'] - $dedus;
                                    $mailContent .= ' <tr>
                                      <td>'.date("F j, Y", strtotime($row['pay_period'])).'</td>
                                      <td><?= "$" ?>'.$row['amount'].'</td>
                                      <td><?= "$" ?>'.$row['incentives'].'</td>
                                      <td><?= "$" ?>'.$row['comission'].'</td>
                                      <td><?= "$" ?>'.$row['royaltee'].'</td>
                                      <td><?= "$" ?>'.$row['adjustment'].'</td>
                                      <td>';
                			                $dedu = 0;
                                            if($deduction){
                                                $total_deduction += $deduction[0]['user_deduction'];
                                                $mailContent .= "$".$deduction[0]['user_deduction'];
                                                $dedu = $deduction[0]['user_deduction'];
                                            }
                    			            
                                       $mailContent .= '</td>
                                      <td>'.number_format((float) $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'], 2, '.', '')  .' </td>
                                      <td>'. $row['amount'] + $row['incentives'] + $row['comission'] + $row['royaltee'] - $dedu .'</td>
                                    </tr>';
                                }
            		 $mailContent .= ' </tbody>
            		<tfoot>
            			<tr class="total">
                            <td>$'.$total_amount.'</td>
                            <td>$'.$total_incentives.'</td>
                            <td>$'.$total_comission.'</td>
                            <td>$'.$total_referal.'</td>
                            <td>$'.$total_adjusment.'</td>
                            <td>$'.$total_deduction.'</td>
                            <td>$'.$total_gross.'</td>
                            <td>$'.$total_net.'</td>
            			</tr>
            		</tfoot>
            	</table>
            	<div class="gross-pay">
            		Gross Pay: $3,150
            	</div>
            	<div class="net-pay">
            		Net Pay: $2,900
            	</div>
            </body>
            </html>
        ';
        $mail->Body = $mailContent;
       
        /* Send email */
        if(!$mail->send()){
            echo 'Mail could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            
        }
    
    }
    
    function load_notification(){
        $output = '';

        $notification = $this->Interlink_model->query("SELECT n.* FROM others_notification AS n INNER JOIN ( SELECT employee_id, MAX(id) AS max_id FROM others_notification WHERE notification_message != ''  GROUP BY employee_id ) AS max_ids ON n.id = max_ids.max_id ORDER BY n.id DESC LIMIT 10;");

        if ($notification) {
            foreach ($notification as $row) {
                $employee_id = $row['employee_id'];
                if ($this->session->userdata('fullname') == 'Accounting Department') {
                    $is_read = $row['is_read'];
                }
                if ($this->session->userdata('fullname') == 'Dahino, Cristina') {
                    $is_read = $row['user_1'];
                }
                if ($this->session->userdata('fullname') == 'Pena, Christine Joy') {
                    $is_read = $row['user_2'];
                }
                $notification_message = $row['notification_message'];
                $updated_date = $row['updated_date'];
                $data = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = '$employee_id' AND status = 1 ");

                // Customize the HTML structure for each notification
                $output .= '<li>';
                $output .= '<a href="' . site_url('Pages/bank_comparison/' . $employee_id) . '">';
                $output .= '<img src="vendors/images/img.jpg" alt="">';
                if ($is_read == 0) {
                    $output .= '<h3>' . $data[0]['first_name'] . ' ' . $data[0]['last_name'] . '</h3>';
                } else {
                    $output .= '<span>' . $data[0]['first_name'] . ' ' . $data[0]['last_name'] . '</span>';
                }
                $output .= '<p>Hi Accounting, ' . $data[0]['first_name'] . ' ' . $data[0]['last_name'] . ' updated his/her ' . $notification_message . ' <br> <span style="font-size:9px">On ' . $updated_date . '</span></p>';
                $output .= '</a>';
                $output .= '</li>';
            }
        }

        return $output;
    }
    public function notification(){
        $page = "notifications";
        if(!file_exists(APPPATH.'views/Accounting/'))
        {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view('Accounting/'.$page);
        $this->load->view('templates/footer');
    }

}
