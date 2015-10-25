<?php

class Home extends CI_Controller{
    public $loggedin;
    
    public function __construct(){
        parent::__construct();
        $this->load->library('adminpage');
        $this->load->library('auth');        
		$this->load->model("commonmodel");
    }
    
    public function index(){        
        $login = $this->auth->is_logged_in();
        
        if($login == true)
            $this->adminpage->loadpage('admin/adminpage');
        else
            redirect(base_url().'admin/login');
    }
    
 	public function menusetup(){
		
		if($this->input->post('add_menu') == "Add Menu"){
			
			$linkname = $this->input->post('linkname', true);
			$parent = $this->input->post('parentmenu', true);
			$parentID = ($this->input->post('parent_id', true)*1);
			$linkurl = $this->input->post('linkurl', true);
	    
			//link name must not be blank
			//also if it is parent then url must be blank or
			// if it is not parent then parent_id and url must not be blank 
			if($linkname != "" && $parent =="Yes" && $linkurl =="")  {
		    
				$result = $this->commonmodel->db_insert_menu($linkname);
								
				$data['message'] = ($result)
								? "<div class='alert alert-success'>Parent Menu Added!</div>"
								: "<div class='alert alert-danger'>Failed to add Parent Menu!</div>";
			//Add submenu - check inputs
			} elseif($linkname != "" && $parent =="No" && $linkurl != "" && $parentID >0){

				$result = $this->commonmodel->db_insert_menu($linkname, $parentID, $linkurl);

				$data['message'] = ($result)
								? "<div class='alert alert-success'>Sub Menu Added!</div>"
								: "<div class='alert alert-danger'>Failed to add Sub Menu!</div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>Cannot Add. Please try again!</div>";
			}

		}

		//get parent menus
		$data['parentmenus'] = $this->commonmodel->db_get_parentmenus();

		$data['pagetitle'] = "Admin Menu Setup";

		$this->adminpage->loadpage('admin/menusetup', $data);

	}

	public function menulist(){
		
		$data['pagetitle'] = "Admin Menu List";
		$this->adminpage->loadpage('admin/menusetup', $data);
	}
 
 
    public function update_menu(){
		if($this->input->post('update_menu') == "Update"){
			
			$parentmenu_id 	= ($this->input->post('parentmenuid', true)*1);
			$submenu_id		= ($this->input->post('menuid', true)*1);
			
			//check if parent id or submenu id is submitted and build array to update
			if($parentmenu_id>0){
				$menu_id = $parentmenu_id;
				$updatedata = array('link_name' => $this->input->post('parentname', true));
			} elseif($submenu_id>0){
				$menu_id = $submenu_id;
				$updatedata = array('link_name' => $this->input->post('subname', true),
									'url' => $this->input->post('suburl', true));
			}
			
			$result = $this->commonmodel->db_update_submenu($updatedata, $menu_id);
			
			if($result)
				$this->session->set_flashdata('message', '<div class="alert alert-success">Changes updated!</div>');
			else
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Cannot Update!</div>');

	    
	    	redirect(base_url().'admin/home/menulist');
		}				    

	}
	
	public function delete_menu(){
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
			$menu_id = $this->input->post('menu_id', true);
			$parentid = $this->input->post('parent_id', true);
			
			if(isset($menu_id) && is_numeric($menu_id) && ($menu_id >0)){
				$result = $this->commonmodel->db_delete_menu(false, $menu_id);
			} elseif(is_numeric($parentid) && ($parentid >0)){ //check id is a number
				$result = $this->commonmodel->db_delete_menu($parentid);
			}
			
			echo ($result)
				? "true"
				: $this->db->last_query();			
		}
    }

  
}

