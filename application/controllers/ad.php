<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Ad extends CI_Controller {
 
    public function __construct() {
        parent::__construct(); 
    }

    function index()
    { 
        $api_url = "http://localhost/ci-api/index.php/ad_api/all";
        $client = curl_init($api_url);
 
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($client);

        curl_close($client);
 
        $this->load->view('app', [ 'data' => $response ]);
    } 
 
}
