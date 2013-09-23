<?php

class Photos extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('commonmodel');
        $this->load->model('photomodel');
    }
    
    function index($id=false){        
        
                
        $this->default_fp($id);
        /*foreach($albums AS $folders){
            $where = array('albumID' => $folders['albumID']);
        }*/
    }
    
    function default_fp($id){
        
        $id = ($this->uri->segment(2)*1);
        
        //get all albums
        $data['allalbums'] = $this->photomodel->db_get_allalbums();
        
        //check if there is an album selected
        
        if($id){
            //if there is an album selected then select where clause
            $where = array('albumID' => $id);
        } else {
            //if not then select most recent album
            $where = array('albumID' => 1);
        }       
        
        //get photos according to where clause
        $data['single_album'] = $this->photomodel->get_photoalbum($where);
        $data['photos'] = $this->photomodel->db_get_albumPhotos($where);
        
        $this->load->view('photos', $data);
    }

    
    
}

?>
