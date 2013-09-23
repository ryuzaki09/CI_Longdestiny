<?php

class Fpmodel extends CI_Model {
    var $table = array('frontpage' => 'longdestiny.frontpage',
                       'fpphotos' => 'longdestiny.fpphotos');
    
    function insert_to_frontpage($title=false, $sub_title=false, $desc1=false, $desc2=false, $image=false){
        $data = array('title' => $title,
                      'sub_title' => $sub_title,
                      'desc1' => $desc1,
                      'desc2' => $desc2,
                      'image' => $image);
               
        return $result = $this->db->insert($this->table['frontpage'], $data);
                
    }
    
    function all_frontpage_data(){        
        $result = $this->db->get($this->table['frontpage']);
        /*$result = $this->db->query("SELECT * FROM longdestiny.frontpage AS frontpage 
                                    LEFT JOIN longdestiny.fpphotos AS fpphotos on
                                    frontpage.id=fpphotos.windowID
                                    ORDER BY fpphotos.foldername AND windowID ASC");*/
        return ($result->num_rows() > 0)
        ? $result->result_array()
        : false;
        
    }
    
    function all_fpphotos_data(){
        
        $this->db->order_by('windowID','desc');       
        $result = $this->db->get($this->table['fpphotos']);
        
        return ($result->num_rows() > 0)
        ? $result->result_array()
        : false;
        
    }
    
    function addphotos($foldername=false, $imgname, $windowID){
        $data = array('imgname' => $imgname,
                      'windowID' => $windowID);
        
        if($foldername){
            $data['foldername'] = $foldername;
        }
        
        return $this->db->insert($this->table['fpphotos'], $data);
        
        
    }
    
    function db_delete_subphotos($photoid, $foldername){
        $this->db->where('photoID', $photoid);
        $this->db->where('foldername', $foldername);
        
        $result = $this->db->delete($this->table['fpphotos']);
        return (mysql_affected_rows()>0)
                ? true
                : false;
    }
    
}

?>
