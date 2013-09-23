<?php

class Adminpage {
   
    
    public function __construct(){
        $this->CI =& get_instance();
    }
    
    function loadpage($page, $data=false, $adminmenu=true)
    {          
            $data['title'] = "LongDestiny CMS";
            $this->CI->load->view('admin/adminheader', $data);
            if($adminmenu == true) {
                $this->CI->load->view('admin/adminmenu');
                $this->CI->load->view('admin/adminmenu2', $data);
            }
            $this->CI->load->view($page, $data);
            $this->CI->load->view('admin/adminfooter');
               
    }
    
    function set($type=false, $source=false){
        if ($type == 'css'){                       
            $data = "<link rel='stylesheet' type='text/css' href='".$source."' />\n";        
            
        }
        
        if ($type == 'js'){            
            $data = "<script type='text/javascript' src='".$source."'></script>\n";                    
        }
        
        return $data;
    }
    

}
?>
