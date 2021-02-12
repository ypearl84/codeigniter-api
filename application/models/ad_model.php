<?php
class Ad_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('America/Los_Angeles'); 
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
        $now = date("Y-m-d H:i:s", strtotime("Now")); 

        $this->db->select("count(*) as count");
        $this->db->where("partner_id", $partner_id);
        $this->db->where("end_time >", $now);
        $query = $this->db->get('ad_campaign');
        $row = $query->row();

        if(isset($row)) {
            return $row->count;
        }
    }
}