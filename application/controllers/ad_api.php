<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Ad_api extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Los_Angeles'); 
        $this->load->model('ad_model');
        $this->load->library('form_validation');
    }
    
    function all() {
        $rtn = $this->ad_model->find_all();
        http_response_code(200);  
        echo json_encode($rtn); 
    }

    function insert() {
         
        $active_data = $rtn = $this->ad_model->find_active_data($this->input->post('partner_id')); 
 
        if(!is_null($active_data)) { 
            $array = array(
                'status' => 401,
                'message' => "Active campaign exists.", 
            );
            http_response_code(401);
        } else {

            $this->form_validation->set_rules("partner_id", "partner_id", "required");
            $this->form_validation->set_rules("duration", "duration", "required|numeric");
            $this->form_validation->set_rules("ad_content", "ad_content", "required"); 
     
            $array = array();

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

                http_response_code(201);
    
            } else {
    
                $array = array(
                    'status' => 400,
                    'message' => 'Required data missing or invalid.'
                );

                http_response_code(400);
            }
        } 

        echo json_encode($array, true);
    }

    function find() { 

        $partner_id = $this->uri->segment(3);

        if(!is_null($partner_id)) { 
            $rtn = $this->ad_model->find_data($partner_id); 
            
            http_response_code(200);
            echo json_encode($rtn, true); 
        
        } else {
            $array = array(
                'status' => 400
            );

            http_response_code(400);

            echo json_encode($array, true); 
        } 
    }

    function delete() {
 
        $array = array();
        $index = $this->uri->segment(3);

        if(!is_null($index)) {
 
            $this->ad_model->delete_active_data($index);
            
            $array = array(
                'status' => 200
            );
            http_response_code(200);

        } else {

            $array = array(
                'status' => 400,  
                'message' => "partner_id required.",  
            );
            http_response_code(400);
        }

        echo json_encode($array, true); 

    }
	


}
