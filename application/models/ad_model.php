<?php
class Ad_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database('default', TRUE);
    }

    function insert_data($data) {
        $this->db->insert('ad_campaign', $data);
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }

    function find_active_data($partner_id) {
        $this->db->where("partner_id", $partner_id);
        $query = $this->db->get('ad_campaign');
        return $query->result_array();
    }
}