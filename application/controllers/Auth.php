<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){

        parent::__construct();
        $this->load->model('global_model');
    }

   	function index(){
			$data['title'] = 'RRIapp | Login';
			$this->load->view('vLogin',$data);
   	}

	function login_act(){

		$uid 	= $this->input->post('txt_uid');
		$pwd 	= $this->input->post('txt_pwd');
		$pwd 	= substr(md5($pwd),0,15);
		// print($pwd);
		// return false;

		$data 	= $this->global_model->check_user($uid,$pwd);

	   	if($data!=null){

	     	$sess_array = array(
	     		'uid' 		=> $data->username,
	     		'fullname'	=> $data->full_name,
	     		'priv'		=> $data->privilege,
					'e'		=> $data->email
	     	);

	     	$this->session->set_userdata('logged_in', $sess_array);
	     	redirect(base_url().'index.php/welcome','refresh');
	   	}
	   	else{

	   		$this->session->set_flashdata('error', true);
	     	redirect('auth','refresh');
	   	}
	}

	function logout_act(){

		$this->session->unset_userdata('logged_in');
   		session_destroy();

   		redirect('auth','refresh');
	}
}
