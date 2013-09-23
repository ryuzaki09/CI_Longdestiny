<?php
class Portfoliomodel extends Commonmodel {
 
    function add_port($filename, $title, $link, $pos){
        $data = array('port_img' => $filename, 'port_title' => $title, 'port_link' => $link, 'position' => $pos);
        
        $result = $this->db->insert($this->table['portfolio'], $data);
        
        return(mysql_affected_rows()>0)
                ? true
                : false;
    }
    
    function alldata(){
        $this->db->order_by('position', 'desc');
        $result = $this->db->get($this->table['portfolio']);
        
        return ($result->num_rows()>0)
                ? $result->result_array()
                : false;
    }
    
    function db_get_portfolio($id){
        $this->db->where('port_id', $id);
        
        $result = $this->db->get($this->table['portfolio']);
        
        return ($result->num_rows()>0)
                ? $result->row()
                : false;
        
    }
    
    function db_update_portfolio($id, $data){
        $this->db->where('port_id', $id);
        $result = $this->db->update($this->table['portfolio'], $data);
        
        return (mysql_affected_rows()>0)
                ? true
                : false;
        
    }
    
    function db_delete_portfolio($id){
        $this->db->where('port_id', $id);
        $this->db->delete($this->table['portfolio']);
        
        return (mysql_affected_rows()>0)
                ? true
                : false;
        
    }
    
}
?>
