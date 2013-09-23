<?php

class Photos extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('commonmodel');
        $this->load->library('adminpage');
        $this->load->library('auth');
        $this->load->model('adminmodel');        
        $this->load->model('photomodel');
    }
    
    
    function addnew(){
        $login = $this->auth->is_logged_in();        
        if($login == true){
        $this->load->helper('form');
        $data['pagetitle'] = "Upload Photo";
        $data['albums'] = $this->adminmodel->fetch_albums();
                
                //start upload process
		if($this->input->post('upload') == "Upload"){
                    $title = array('img1' => $this->input->post('title1', true),
                                    'img2' => $this->input->post('title2', true));
                    if($title['img1'] != "" || $title['img2'] != ""){
                        $existing_folder = $this->input->post('folder_name1', true);
                        $new_folder = $this->input->post('folder_name2', true);
                        $this->load->library('upload');
                        //if user has entered a new folder name
                        if($existing_folder == "" && $new_folder != ""){			

                            //check if folder exists
                            if(!file_exists($_SERVER['DOCUMENT_ROOT']."/media/images/".$new_folder)){
                                mkdir($_SERVER['DOCUMENT_ROOT']."/media/images/".$new_folder."/", 0777);

                                //add new foldername to database
                                $insert_folder = $this->adminmodel->add_new_album($new_folder);
                                if($insert_folder >= 1){
                                    $folder_to_upload = $new_folder;
                                    //get ID of the folder that was just inserted
                                    $albumID = mysql_insert_id();
                                    $upload = true;
                                } else {
                                    $data['message'] = "Cannot insert folder into database";
                                    $upload = false;
                                }
                            } else {
                                $data['message'] = $new_folder." Folder already exists!";
                                $upload = false;
                            }
                        //if user has selected an existing folder to upload    
                        } elseif($existing_folder != "" && $new_folder == "") {
                            $folder_to_upload = $existing_folder;
                            //get the ID of the folder
                            $where = array('folder_name' => $existing_folder);
                            $album = $this->photomodel->get_photoalbum($where);
                            $albumID = $album->albumID;
                            $upload = true;                        
                        } else {
                            $data['message'] = "Please select a folder or create a new folder to upload to";
                            $upload = false;
                        }
                    } else {
                        $data['message'] = "Please enter title for the image";
                        $upload = false;
                    }
                    
                    //retrieve all files to upload
                    $files = $_FILES;
                    if($upload == true){
			$config['upload_path']   = './media/images/'.$folder_to_upload; //if the files does not exist it'll be created
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']   = '8000'; //size in kilobytes
			$config['encrypt_name']  = true;

			$this->upload->initialize($config);
				
			Foreach($files AS $imgfile => $imgname){ //go through each img upload
				if(!empty($imgfile)){ //check to see if it's empty
                                    if($title[$imgfile] != ""){ //if it's not empty check to see if title is not empty
					if($this->upload->do_upload($imgfile)){  //if not empty then upload
                                            $imgdata = $this->upload->data(); //get encrypted file data and then insert the filename below
                                            
                                            $this->photomodel->db_insert_update_photo($imgdata['file_name'], $title[$imgfile], $albumID);
                                            //display the name of the file before encryption
                                            $data['imgfiles'][] = $imgname['name']." has been uploaded to ".$folder_to_upload."<br/>";
                                            //$data['imgfiles'][] = $imgdata['file_name']." has been uploaded to ".$folder_to_upload."<br/>";
					} else {
                                            $data['imgfiles'][] = $this->upload->display_errors();
                                            
                                        }
                                    } 
				}
			}//end foreach
                                
                    } //if upload = true                 
			
                }//if post = upload

		//print_r($files);
		
        $this->adminpage->loadpage('admin/photo/upload', $data);
        
        } else {
            redirect(base_url().'admin/login');
        }
    }
    
    function albumlist(){
        $login = $this->auth->is_logged_in();        
        if($login == true){
            $data['albums'] = $this->adminmodel->fetch_albums();
            $data['pagetitle'] = "Photo Album List";
            $this->adminpage->loadpage('admin/photo/list', $data);
            
        } else {
            redirect(base_url().'admin/login');
        }
    }
    
    function album($id){
        error_reporting(E_ALL);
        $login = $this->auth->is_logged_in();        
        if($login == true){            
            $id = $id*1;            
            
            $where = array('albumID' => $id);
            //get album name
            $data['album_name'] = $this->photomodel->get_photoalbum($where);
            $images = $this->photomodel->db_get_albumPhotos($where);
            
            $data['album_photos'] = $this->photomodel->db_get_albumPhotos($where);
            
            $data['pagetitle'] = "Edit | ".$data['album_name']->folder_name;
            
            $this->adminpage->loadpage('admin/photo/photos', $data);
            
        } else {
            redirect(base_url().'admin/login');
        }
    }
    
               
    function delete_album(){        
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
            $id = ($this->input->post('id', true)*1);
            $foldername = $this->input->post('foldername', true);
                    
            //get images
            $where = array('albumID' => $id);
            $images = $this->photomodel->db_get_albumPhotos($where);           
            //delete images            
            if(is_array($images) && !empty($images)){
                foreach($images AS $photos){
                    unlink($_SERVER['DOCUMENT_ROOT']."/media/images/".$foldername."/".$photos['imgname']);
                }
                //remove from database
                $result = $this->photomodel->db_delete_albumphotos($id);                
            }            
            
            //delete folder            
            $result2 = $this->photomodel->db_delete_album($id);
            
            if ($result2){
                rmdir($_SERVER['DOCUMENT_ROOT']."/media/images/".$foldername);                
                echo ($result) ? "all deleted" : "noimages";
            } else {
                echo "Cannot delete album";
            }
                
        }
    }
    
    function update_album(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
            $albumID = ($this->input->post('albumID', true)*1);
            $old_name = $this->input->post('old_album_name', true);
            $album_name = $this->input->post('new_album_name', true);
            
            //rename the folder on the server
            rename($_SERVER['DOCUMENT_ROOT']."/media/images/".$old_name, $_SERVER['DOCUMENT_ROOT']."/media/images/".$album_name);
            
            $result = $this->photomodel->db_update_album($albumID, $album_name);
            
            echo ($result)
                ? "true"
                : "Cannot update";
        }
        
    }
    
    function delete_photo(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
            $id = ($this->input->post('id', true)*1);
            $foldername = $this->input->post('foldername', true);
            $imgname = $this->input->post('imgname', true);

            $result = $this->photomodel->db_delete_albumphotos($id, true);

            if ($result){
                unlink($_SERVER['DOCUMENT_ROOT']."/media/images/".$foldername."/".$imgname);
                echo "true";
            } else {
                echo "Cannot delete photo";
            }
        }
    }
    
    function update_photo(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
            $id = ($this->input->post('id', true)*1);
            $title = $this->input->post('title', true);

            $result = $this->photomodel->db_insert_update_photo(false, $title, false, $id);
            
            echo ($result)
                ? "true"
                : "Cannot update";
        }
    }
    
}


?>
