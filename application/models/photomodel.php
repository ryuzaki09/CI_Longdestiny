<?php
class Photomodel extends Commonmodel {
    
    
    function __construct(){
        parent::__construct();
        $this->load->model('commonmodel');
    }
    
    
    function get_photoalbum($where){
        $this->db->where($where);
        
        //if($table == "album"){
            $get_table = $this->table['photoalbum'];
        //}
        /*
        if($table == "photos"){
            $get_table = $this->table['albumPhotos'];
        }*/
        
        $result = $this->db->get($get_table);
        
        return ($result->num_rows()>0)
                ? $result->row()
                : false;
            
        
    }
    
    function db_get_allalbums(){
        $result = $this->db->get($this->table['photoalbum']);
        
        return ($result->num_rows()>0)
                ? $result->result_array()
                : false;
    }
    
    function db_delete_album($id){
        $this->db->where('albumID', $id);
        $this->db->delete($this->table['photoalbum']);
        
        return(mysql_affected_rows()>0)
                ? true
                : false;      
                
    }
    
    function db_delete_albumphotos($id, $singlephoto=false){        
        if ($singlephoto){
            $this->db->where('pid', $id);
        } else {
            $this->db->where('albumID', $id);
        }
        
        $this->db->delete($this->table['albumPhotos']);
        
        return (mysql_affected_rows()>0)
            ? true
            : false;
    }
    
    function db_update_album($albumid, $album_name){
        $this->db->set('folder_name', $album_name);
        $this->db->where('albumID', $albumid);
        $result = $this->db->update($this->table['photoalbum']);
        
        return (mysql_affected_rows()>0)
                ? true
                : false;
        
    }
    
    function db_insert_update_photo($imgname=false, $title=false, $albumID=false, $id=false){
        $data = array();
        if($imgname){
            $data['imgname'] = $imgname; 
        }
        if($title){
            $data['photo_title'] = $title;
        }
        if($albumID){
            $data['albumID'] = $albumID;
        }
        
        if($id){
            $this->db->where('pid', $id);
            $result = $this->db->update($this->table['albumPhotos'], $data);
        } else {
            $result = $this->db->insert($this->table['albumPhotos'], $data);
        }
        
        return ($result >=1)
                ? true
                : false;
    }
    
    function db_get_albumPhotos($where){
        $this->db->where($where);
        $result = $this->db->get($this->table['albumPhotos']);
        
        return ($result->num_rows()>0)
                ? $result->result_array()
                : false;
    }
    
}


?>
