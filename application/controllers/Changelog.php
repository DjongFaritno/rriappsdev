<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class Changelog extends CI_Controller {

	function __construct(){

        parent::__construct();
        $this->load->model('global_model');
    }

   	function index(){
			$data['title'] = 'Changelog';
			$this->load->view('vchangelog',$data);
   	}

}
