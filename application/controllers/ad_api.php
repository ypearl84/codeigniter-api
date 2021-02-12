<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Ad_api extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Los_Angeles'); 
        $this->load->model('ad_model');
        $this->load->library('form_validation');
    }
    
    function index() {
        echo "index";
    }

    function insert() {
        
        $this->form_validation->set_rules("partner_id", "partner_id", "required");
        $this->form_validation->set_rules("duration", "duration", "required");
        $this->form_validation->set_rules("ad_content", "ad_content", "required");
 
        $array = array();

        $active_data = $rtn = $this->ad_model->find_active_data($this->input->post('partner_id')); 
 
        if((int)$active_data > 0) { 
            $array = array(
                'status' => 400,
                'message' => "Active campaign exists.", 
            );
        } else {
            if($this->form_validation->run()) {
    
                $data = array(
                    'partner_id' => trim($this->input->post('partner_id')),
                    'duration'  => trim($this->input->post('duration')),
                    'ad_content'  => trim($this->input->post('ad_content')),
                    'end_time' => date("Y-m-d H:i:s",strtotime("+".trim($this->input->post('duration'))." seconds"))
                );
    
                $this->ad_model->insert_data($data);
                
                $array = array(
                    'status' => 201
                );
    
            } else {
    
                $array = array(
                    'status' => 400,
                    'partner_id_error' => form_error('partner_id'),
                    'duration_error' => form_error('duration'),
                    'ad_content' => form_error('ad_content')
                );
            }
        } 

        echo json_encode($array, true);
    }

    function find_active_data() { 

        $partner_id = $this->uri->segment(3) ? $this->uri->segment(3) : $partner_id;

        if(!is_null($partner_id)) { 
            $rtn = $this->ad_model->find_active_data($partner_id); 
            
            echo json_encode($rtn); 
        
        } else {
            $array = array(
                'status' => 400
            );
            echo json_encode($array, true); 
        } 
    }

    function delete() {
        echo "delete";
    }
	


}
