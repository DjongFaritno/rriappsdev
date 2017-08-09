<?php
// بسم الله الرحمن الرحیم

class Global_model extends CI_Model {

	public function __construct(){

        parent::__construct();
    }

	function check_user($uid,$pwd){

		$this->db->where('username',$uid);
		$this->db->where('password',$pwd);

		return $this->db->get('ms_user')->row();
	}
}
