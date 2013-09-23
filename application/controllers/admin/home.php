<?php

class Home extends CI_Controller{
    var $loggedin;
    
    function __construct(){
        parent::__construct();
        $this->load->library('adminpage');
        $this->load->library('auth');        
    }
    
    function index(){        
        $login = $this->auth->is_logged_in();
        
        if($login == true){            
            $this->adminpage->loadpage('admin/adminpage');
        }else{
            redirect(base_url().'admin/login');
        }
    }
    
      
    
}

?>
