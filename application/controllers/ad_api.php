<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Ad_api extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->model('ad_model');
    }
    
    function index() {
        echo "index";
    }

    function insert() {
        echo "insert";
    }

    function delete() {
        echo "delete";
    }
	


}
