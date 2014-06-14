<?php

class Fpmodel extends CI_Model {
    public $table = array('frontpage' => 'longdestiny.frontpage',
                       'fpphotos' => 'longdestiny.fpphotos');
    
    public function insert_to_frontpage($title=false, $sub_title=false, $desc1=false, $desc2=false, $image=false){
        $data = array('title' => $title,
                      'sub_title' => $sub_title,
                      'desc1' => $desc1,
                      'desc2' => $desc2,
                      'image' => $image);
               
        return $result = $this->db->insert($this->table['frontpage'], $data);
                
    }
    
    public function all_frontpage_data(){        
        $result = $this->db->get($this->table['frontpage']);
        return ($result->num_rows() > 0)
				? $result->result_array()
				: false;
        
    }
    
    public function all_fpphotos_data(){
        
        $this->db->order_by('windowID','desc');       
        $result = $this->db->get($this->table['fpphotos']);
        
        return ($result->num_rows() > 0)
				? $result->result_array()
				: false;
        
    }
    
    public function addphotos($foldername=false, $imgname, $windowID){
        $data = array('imgname' => $imgname,
                      'windowID' => $windowID);
        
        if($foldername){
            $data['foldername'] = $foldername;
        }
        
        return $this->db->insert($this->table['fpphotos'], $data);
        
        
    }
    
    public function db_delete_subphotos($photoid, $foldername){
        $this->db->where('photoID', $photoid);
        $this->db->where('foldername', $foldername);
        
        $this->db->delete($this->table['fpphotos']);
        return ($this->db->affected_rows()>0)
                ? true
                : false;
    }
    
}

