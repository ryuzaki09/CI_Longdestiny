<?php

class Home extends CI_Controller{
    public $loggedin;
    
    public function __construct(){
        parent::__construct();
        $this->load->library('adminpage');
        $this->load->library('auth');        
    }
    
    public function index(){        
        $login = $this->auth->is_logged_in();
        
        if($login == true)
            $this->adminpage->loadpage('admin/adminpage');
        else
            redirect(base_url().'admin/login');
    }
    
    
}

