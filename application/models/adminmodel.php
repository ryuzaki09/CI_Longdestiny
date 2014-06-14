<?php

class Adminmodel extends Commonmodel {
        
    public function __construct(){
        parent::__construct();
    }
    
    public function adminlogin($username, $password){        
        $this->db->select('id');
        $this->db->where('name', $username);
        $this->db->where('pwd', $password);
        $result = $this->db->get($this->table['adminusers']);
                
        if ($result){
			return ($result->num_rows()>0)
                ? $result->row()
                : false;
        }else {
            return false;
        }        
    }
    
    public function retrieve_data($id){
        
        $this->db->where('id', $id);
                
        $result = $this->db->get($this->table['frontpage']);
        
        return ($result->num_rows() > 0)
				? $result->row()
				: false;
        
    }
    
    public function retrieve_fpphotos($id, $foldername=false){
        $this->db->where('windowID', $id);
        
        if($foldername){
            $this->db->where('foldername', 'thumbs');
            $result = $this->db->get($this->table['fpphotos']);
            return ($result->num_rows() > 0)
                    ? $result->result_array()
                    : false;
            
        } else {
            $this->db->where('foldername', 'frontpage');
            
            $result = $this->db->get($this->table['fpphotos']);
            
            return ($result->num_rows()>0)
                    ? $result->row()
                    : false;
        }          
                
    }
    
    public function update_fpphotos($id, $imgname){
        $this->db->where('windowID', $id);
        $this->db->set('imgname', $imgname);
        
        return $this->db->update($this->table['fpphotos']);
        
    }
    
    public function update_window($id, $data){
        $this->db->where('id', $id);
        return $this->db->update($this->table['frontpage'], $data);
    }
    
    public function delete_window($id){
        $this->db->where('id', $id);
        $result = $this->db->get($this->table['frontpage']);
        
        if ($result){
            $result = $result->row();            
               //delete from thumb folder
               unlink($_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/'.$result->image);            
        }
        
        $this->db->where('id', $id);
        $result2 = $this->db->delete($this->table['frontpage']);       
        
        if($this->db->affected_rows() > 0){
            
            return ($this->__delete_fpphotos($id))
                   ? true
                   : "no_images_to_delete";
            
        } else {
            return false;
        }
        
    }
    
    public function __delete_fpphotos($id){
        $this->db->where('windowID', $id);
        $result = $this->db->get($this->table['fpphotos']);
        
        if ($result){
            $result = $result->result_array();
            foreach($result AS $img){                
               //delete from thumb folder
               unlink($_SERVER['DOCUMENT_ROOT'].'/media/images/frontpage/thumb/'.$img['imgname']);                
            }
            $this->db->where('windowID', $id);
            $this->db->delete($this->table['fpphotos']);
            return ($this->db->affected_rows()>0)
                    ? true
                    : false;                  
            
        } else {
            return false;
        }
    }
    
        
    public function changepwd($data, $where){
        $this->db->where('name', $where);
        return $this->db->update($this->table['adminusers'], $data);
        
    }
    
    public function fetch_albums(){
        $result = $this->db->get($this->table['photoalbum']);
        return ($result)
            ? $result->result_array()
            : false;
    }
    
    public function add_new_album($foldername){
        $this->db->set('folder_name', $foldername);        
        return $this->db->insert($this->table['photoalbum']);
    }
    
    
}
