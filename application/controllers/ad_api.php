<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Ad_api extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
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
        if($this->form_validation->run()) {

            $data = array(
                'partner_id' => trim($this->input->post('partner_id')),
                'duration'  => trim($this->input->post('duration')),
                'ad_content'  => trim($this->input->post('ad_content'))
            );

            $this->ad_model->insert_data($data);
            
            $array = array(
                'success'  => true
            );

        } else {

            $array = array(
                'error'    => true,
                'partner_id_error' => form_error('partner_id'),
                'duration_error' => form_error('duration'),
                'ad_content' => form_error('ad_content')
            );
        }

        echo json_encode($array, true);
    }

    function delete() {
        echo "delete";
    }
	


}
