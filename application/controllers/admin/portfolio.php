<?php
class Portfolio extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonmodel');
        $this->load->library('adminpage');
        $this->load->library('auth');                
        $this->load->model('portfoliomodel');
    }
    
    function addnew(){
        $login = $this->auth->is_logged_in();        
        if($login == true){
            if($this->input->post('add', true) =="Add!"){
                $title = $this->input->post('title', true);
                $link = $this->input->post('link', true);
                $pos = $this->input->post('position', true);

                if($title !="" && $link != ""){
                    $this->load->library('upload');
                    $image = "image";

                    $config['upload_path']   = './media/images/portfolio/'; //if the files does not exist it'll be created
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']   = '8000'; //size in kilobytes                    
                    $config['encrypt_name']  = true;

                    $this->upload->initialize($config);

                    if(!$this->upload->do_upload($image)){
                        $data['message'] = $this->upload->display_errors();
                    } else {
                        $filedata = $this->upload->data();
                        $result = $this->portfoliomodel->add_port($filedata['file_name'], $title, $link, $pos);

                        $data['message'] = "Portfolio Added!";
                    }

                } else {
                    $data['message'] = "Please enter a title and link";
                }
            }

            $data['pagetitle'] = "Portfolio | Add New";

            $this->adminpage->loadpage('admin/portfolio/newportfolio', $data);
        
        } else {
            redirect(base_url().'admin/login');
        }
    }
    
    function listing(){
        $login = $this->auth->is_logged_in();        
        if($login == true){
            $data['result'] = $this->portfoliomodel->alldata();

            $data['pagetitle'] = "Portfolio List";
            $this->adminpage->loadpage('admin/portfolio/list', $data);
        
        } else {
            redirect(base_url().'admin/login');
        }
        
    }
    
    function edit($id){
        error_reporting(E_ALL);
        $login = $this->auth->is_logged_in();        
        if($login == true){
            $id = $id*1;
            
            if($this->input->post('update', true) == "Update"){
                $update = array('port_title' => $this->input->post('title', true),
                                'port_link' => $this->input->post('link', true),
                                'position' => $this->input->post('position', true));
                $old_img = $this->input->post('old_image', true);
                
                $image = "image";
                $this->load->library('upload');
                
                $config['upload_path']   = './media/images/portfolio/'; //if the files does not exist it'll be created
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']   = '8000'; //size in kilobytes
                $config['encrypt_name']  = true;

                $this->upload->initialize($config);
                //echo $_SERVER['DOCUMENT_ROOT'].'/media/images/portfolio/'.$old_img;
                //if there is a file to upload
                if($this->upload->do_upload($image)){
                    if($old_img != ""){ //if there is an old image, check for image and delete
                        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/media/images/portfolio/'.$old_img)){
                            unlink($_SERVER['DOCUMENT_ROOT'].'/media/images/portfolio/'.$old_img);
                        }
                    }
                    
                    $filedata = $this->upload->data();
                    $update['port_img'] = $filedata['file_name'];                    
                }
            
                //perform the update
                $result = $this->portfoliomodel->db_update_portfolio($id, $update);
                $data['message'] = ($result)
                                    ? "Updated!"
                                    : "Cannot update";
            }
            
            $data['result'] = $this->portfoliomodel->db_get_portfolio($id);
            
            $data['pagetitle'] = "Edit | ".$data['result']->port_title;
            $this->adminpage->loadpage('admin/portfolio/edit', $data);
            
        } else {
            redirect(base_url().'admin/login');
        }
    }
    
    function delete_portfolio(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
            $id = ($this->input->post('id', true)*1);
            $old_img = $this->input->post('old_img', true);
            
            if($old_img != ""){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].'/media/images/portfolio/'.$old_img)){
                    unlink($_SERVER['DOCUMENT_ROOT'].'/media/images/portfolio/'.$old_img);
                }
            }
            
            $result = $this->portfoliomodel->db_delete_portfolio($id);
            
            echo ($result)
                    ? "true"
                    : "Cannot delete";

        }
    }
    
}
?>
