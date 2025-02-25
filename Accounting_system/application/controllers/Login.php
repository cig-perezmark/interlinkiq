<?php
  class Login extends CI_Controller{

    public function user_login()
    {
        // $page = "login";

        // if(!file_exists(APPPATH.'views/login/'.$page.'.php'))
        // {
        //     show_404();
        // }

        // $this->load->view('login/'.$page);
        echo "Access denied!";
    }

//     public function login_action()  
//     {  
//         $page = "index";
//         $user = $this->input->post('user');  
//         $pass = $this->input->post('pass');  

//         $data = $this->User_model->login($user, $pass);
 
// 		if($data){
// 			$this->session->set_userdata('user', $data);
//             $session_data = $this->session->all_userdata();

// 			    $this->load->view('templates/header');
//                 $this->load->view('templates/sidebar');
//                 $this->load->view('HR/'.$page, $data);
//                 $this->load->view('templates/footer');
// 		}

// 		else{
// 			header('location:'.base_url().$this->index());
// 			$this->session->set_flashdata('error','Invalid login. User not found');
// 		}

//     } 

    function login_validation()  
    {  
        if($this->uri->segment(3) == 189 OR $this->uri->segment(3) == 108 OR  $this->uri->segment(3) == 387 OR $this->uri->segment(3) == 1105){
            $session_data = array(  
            'username'     =>     "Accounting",
            'id'     =>     "9999",
            'fullname'     =>     "Accounting Department",
            'user_type_id' => "2"
            );  
            $this->session->set_userdata($session_data);  
            $_SESSION['user'] = "Accounting";
            $_SESSION['alert_message3'] = "Successfull";
            redirect('Pages/process_payment/Consultare');
        }
        else if($this->uri->segment(3) == 1 OR $this->uri->segment(3) == 54){
            $session_data = array(  
            'username'     =>     "Employee",
            'id'     =>     "9999",
            'fullname'     =>     "Dahino, Cristina",
            'user_type_id' => "2"
            );  
            $this->session->set_userdata($session_data);  
            $_SESSION['user'] = "Accounting";
            $_SESSION['alert_message3'] = "Successfull";
            redirect('Pages/approve_pay');
        }
        else if( $this->uri->segment(3) == 2 OR $this->uri->segment(3) == 32){
            $session_data = array(  
            'username'     =>     "Employee",
            'id'     =>     "9999",
            'fullname'     =>     "Pena, Christine Joy",
            'user_type_id' => "2"
            );  
            $this->session->set_userdata($session_data);  
            $_SESSION['user'] = "Accounting";
            $_SESSION['alert_message3'] = "Successfull";
            redirect('Pages/get_for_approve_pay');
        }
    } 
    
    
   function logout()  
   {  
        $this->session->unset_userdata('username');  
        redirect('Login/user_login');  
   }  
  
  
}
?>
