<?php
class Ad_model extends CI_Model {

    function insert_data($data) {
        $this->db->insert('ad_campaign', $data);
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }
}