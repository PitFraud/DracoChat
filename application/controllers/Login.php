<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('General_model');

    }
    public function index(){
        $this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
              $this->load->view('Login/login');
        } 
        else 
        {
                $data = array('login_email' => $this->input->post('email'),
                              'login_password' => $this->input->post('password')
                              );
                $result = $this->Login_model->checkUserLogin($data);
                if($result)
                {
                    redirect('/Dashboard/');     
                }
                else{
                    $error['message'] = "The user name or password is invalid";
					$this->load->view('Login/login',$error);
                }
        }
    }
    public function logout(){
        $this->session->sess_destroy();
        redirect('/Login/');
    }

    public function Register()
    {
        $result = '';
        $this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
        if($this->form_validation->run() == FALSE)
        {
           $this->load->view('Login/register');
        }
        else
        {
            $uniqid = 'DC-'.uniqid();
            $data = array(
                'login_name' => $this->input->post('username'),
                'login_email' => $this->input->post('email'),
                'login_password' => $this->input->post('password'),
                'login_user_id' => $uniqid,
                'login_created_at' => date("Y-m-d"),
                'login_updated_at' => date("Y-m-d"),
                'login_status' => 1,
            );

            $result = $this->General_model->add('tbl_login',$data);

            if($result)
        {
            $this->session->set_flashdata('response', 'Account Created Successfully');
        }
        else
        {
            $this->session->set_flashdata('response', 'Something Went Wrong');
        }
        redirect('/Login/');
        }
        
    }
}
?>
