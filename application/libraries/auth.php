<?php

class Auth {    
    
    public function __construct(){
        
        $this->CI =& get_instance();        
        //$this->login = $this->is_logged_in();
    }
    
    function is_logged_in(){
        
        $userdata = $this->CI->session->userdata('is_logged_in');
        if (isset($userdata) && $userdata == true){
            return true;
        }else{
            return false;
        }
    }
    
}
?>
