<?php

class Profile extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('adminpage');
        $this->load->library('auth');
        $this->load->model('adminmodel');
    }
    
    
    public function changepwd(){
        error_reporting(E_ALL);
        
        $login = $this->auth->is_logged_in();        
        if($login){
        
			$data['pagetitle'] = "Change Password";        
			$this->adminpage->loadpage('admin/profile', $data);
        
        } else {
            redirect(base_url().'admin/login');
        }
    }
    
    public function process(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
            $data = array('pwd' => $this->input->post('pwd1', true));

            //retrieve username from session
            $username = $this->session->userdata('uname');
            $result = $this->adminmodel->changepwd($data, $username);

            echo ($result)
				? "true"
				: "false";
        }
    }
    
    
}


