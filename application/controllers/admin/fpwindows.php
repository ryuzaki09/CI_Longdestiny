<?php
class Fpwindows extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('adminpage');
        $this->load->library('auth');  
        $this->load->model('fpmodel');
        $this->load->model('adminmodel');
        $this->load->library('upload');  
        
       $login = $this->auth->is_logged_in();
       if(!$login)
            redirect(base_url().'admin/login');
    }
    
   public function index(){
       $this->addnew();
   } 
    
   public function addnew(){
       //error_reporting(E_ALL);
        
           
       if($this->input->post('submit') == "Add"){
           $title = $this->input->post('title', true);
           $subtitle = $this->input->post('subtitle', true);
           $desc1 = $this->input->post('desc1', true);
           $desc2 = $this->input->post('desc2', false);
           
           $img = $_FILES;
           $files = "image1";
           if($title == "" || $subtitle == "" || $desc1 == "" || $desc2 == "" || strlen($img['image1']['name'] == "")){
           
              $data['message'] = "Please check required fields";
           } else {
                               
                   $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/';
                   $config['allowed_types'] = 'gif|jpg|png';
                   $config['max_size']	= '500';
                   $config['max_width']  = '1100';
                   $config['max_height']  = '733';
                           
                   $this->upload->initialize($config);
                       
                   //uploading the images
                   if(!$this->upload->do_upload($files)){
                        $data['imgfiles'] = $this->upload->display_errors();
                   } else {
                        $uploadfile = $this->upload->data();
                        $data['imgfiles'] = $uploadfile['file_name']." has been uploaded to Frontpage folder<br/>";
                              
                        //add window to database
                        $result = $this->fpmodel->insert_to_frontpage($title, $subtitle, $desc1, $desc2, $uploadfile['file_name']);
                        $data['message'] = ($result >= 1)
                                            ? "Window Added"
                                            : "Cannot insert";
                   }//end uploading files
                                            
               
           }//end of adding window to database
       }//end submit
           
       $data['pagetitle'] = "Add new window";
       $this->adminpage->loadpage('admin/fpwindow/addnew', $data);
   }
   
   public function listing(){

        $data['listing'] = $this->fpmodel->all_frontpage_data();
        
        $data['pagetitle'] = "Window List";        
        $this->adminpage->loadpage('admin/fpwindow/list', $data);       
       
       
   }
   
   public function edit($id){ 
       //error_reporting(E_ALL);      
       $id      = $id*1;      
       if ($this->input->post('update') == "Update"){
           
           $data    = array('title' => $this->input->post('title', true),
                            'sub_title' => $this->input->post('subtitle', true),
                            'desc1' => $this->input->post('desc1', true),
                            'desc2' => $this->input->post('desc2', true));
           $current_img = $this->input->post('current_img', true);
           
            //if update is succesful
               
               $img = $_FILES['image1']['name'];
               $files = "image1";
               
               if ($img != ""){ //if there is a file to upload
                   if($current_img != ""){ //check for a previous image
                       if(file_exists($_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/'.$current_img)){
                           //delete previous image
                           unlink($_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/'.$current_img);
                       }
                   }// end of deleting previous image
                   
                   $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/';
                   $config['allowed_types'] = 'gif|jpg|png';
                   $config['max_size']	= '500';
                   $config['max_width']  = '1100';
                   $config['max_height']  = '733';
                   
                   $this->upload->initialize($config);
                   //$upload = $this->__update_file_upload($config, $files, $id);
                   
                   if($this->upload->do_upload($files)){  //upload new image
                        $uploaded = $this->upload->data();
                        $data['image'] = $uploaded['file_name'];
                        //$this->adminmodel->update_fpphotos($id, $uploaded['file_name']);
                        $result = $this->adminmodel->update_window($id, $data);
                        $data['message'] = "Window and files updated";
                   } else {                        
                        $data['message'] = $this->upload->display_errors();
                   }            
                   
               } else {
                   $result = $this->adminmodel->update_window($id, $data);                   
                   $data['message'] = ($result >= 1)
                                        ? "Window updated. You have not selected a file to upload"
                                        : "Cannot update window";
               }          
           
       }// end of update
              
       $data['item'] = $this->adminmodel->retrieve_data($id);
       //$data['imgs'] = $this->adminmodel->retrieve_fpphotos($id);       
       $data['edit'] = true;
       $data['css'][] = $this->adminpage->set("css", "/css/imageselect/imgareaselect-animated.css");
       $data['css'][] = $this->adminpage->set("css", "/css/imageselect/imgareaselect-default.css");
       $data['js'][] = $this->adminpage->set("js", "/js/imageselect/jquery.imgareaselect.js");
       $data['js'][] = $this->adminpage->set("js", "/js/imageselect/jquery.imgareaselect.pack.js");
       $data['pagetitle'] = "Edit | ".$data['item']->title;
       $this->adminpage->loadpage('admin/fpwindow/addnew', $data);       
   }
   
   public function subphotos($id){
        $id = $id*1;
        
        if($this->input->post('upload') == "Upload"){
            $files = $_FILES;
            
            $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/thumbs/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '500';
            $config['max_width']  = '260';
            $config['max_height']  = '173';
            
            $this->upload->initialize($config);
            
            Foreach($files AS $imgfile => $imgname){ //go through each img upload
                if($imgfile['name'] != ""){ //check to see if it's empty
                    if($this->upload->do_upload($imgfile)){  //if not empty then upload
                                    $this->fpmodel->addphotos('thumbs', $imgname['name'], $id);
                                    $data['imgfiles'][] = $imgname['name']." has been uploaded to thumbs folder<br/>";
                    } else {
                        $data['imgfiles'][] = $this->upload->display_errors();
                    }
                } else{
                    $data['imgfiles'][] = "No file selected";
                }
            }//end foreach                
        }
        
        $data['item'] = $this->adminmodel->retrieve_data($id);
        $data['sub_photos'] = $this->adminmodel->retrieve_fpphotos($id, $foldername=true);            
        
        $data['pagetitle'] = $data['item']->title." | Upload Sub Photos";
        
        $this->adminpage->loadpage('admin/fpwindow/subphotos', $data);
        
        
    }
  
   
   public function delete_window(){
       if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
           
           $id      = ($this->input->post('id', true)*1);
           $result = $this->adminmodel->delete_window($id);

           echo ($result)
				? "true"
				: "Something went wrong! Unable to delete.";
       }         
       
   }
   
   public function delete_subphoto(){
       if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
           $photoid     = ($this->input->post('id', true)*1);
           $foldername  = $this->input->post('foldername', true);
           $imgname     = $this->input->post('imgname', true);

           $imgpath = $_SERVER['DOCUMENT_ROOT']."/media/images/frontpage/".$foldername."/".$imgname;
           //check if file exists
           if (file_exists($imgpath)){
               //if exists then delete file
               unlink($imgpath);
               //then remove from database
               $result = $this->fpmodel->db_delete_subphotos($photoid, $foldername);
               echo ($result)
                    ? "true"
                    : "Cannot delete from database";

           } else {
               echo "File does not exist in ".$foldername;
           }
       }
   }
   
   public function __update_file_upload($config, $files, $id){
       $this->upload->initialize($config);
                   
       if($this->upload->do_upload($files)){  //upload new image
            $uploaded = $this->upload->data();
            $this->adminmodel->update_fpphotos($id, $uploaded['file_name']);
            return true;
       } else {                        
            return false;
       }       
	}
   
	public function cropfile(){
       error_reporting(E_ALL);
              
		$x1 = $this->input->post('x1', true);
		$y1 = $this->input->post('y1', true);		
        $w = $this->input->post('w', true);
        $h = $this->input->post('h', true);
        $current_img = $this->input->post('current_img', true);
        
		$this->load->library('fileuploads');
        
        //Scale the image to the 100px by 100px  
        $scale = 100/$w;        
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/media/images/frontpage/";
		$cropped = $this->fileuploads->resizeThumbnailImage($filelocation."thumbs/".$current_img, $filelocation.$current_img, $w, $h, $x1, $y1, $scale);
        echo $x1."<br/>".$y1."<br/>".$w."<br/>".$h."<br/>".$scale."<br/>".$current_img;
        //$size = getimagesize($_SERVER['DOCUMENT_ROOT']."/media/images/frontpage/".$current_img);
        //echo $_SERVER['DOCUMENT_ROOT']."/media/images/frontpage/".$current_img."<br/>Done!";
        //print_r($size);
        
        
	}
   
   
}

