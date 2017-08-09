<?php
// بسم الله الرحمن الرحیم

class MDataUser extends CI_Model {

	public function __construct(){

        // Call the CI_Model constructor
        parent::__construct();
    }
	function get_list_data($user,$menu)
	{
		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();
		if($data==null){ //data null = pertama kali load page

		$this->db->select('username, full_name, email, privilege');
		$this->db->from('ms_user');
		$this->db->order_by('username','desc');
		return $this->db->get()->result();

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report();
		}else{
		$query = $data->query;
		return $this->db->query($query)->result();
			}
	}

	function query_data_user($username){
		$data = array();
		$data=$this->db->query("SELECT * from ms_user where username='$username'")->row_array();
		return $data;
		}

	function insert_query($param){

				$sql 	= "SELECT * from ms_user";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY username DESC";
// PRINT($param);
// PRINT($sql);
				$ardata = array(

					'user' 	=> $this->session->userdata('logged_in')['uid'],
					'menu' 	=> 'datauser',
					'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				// print($print);
								// //query yang akan digunakan untuk export ke excel
				$this->insert_query_report($param);
				}

	function insert_query_report($param='')
				{
				$sql 	= "SELECT * from ms_user";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY username DESC";

				$ardata = array(
				'user' 	=> $this->session->userdata('logged_in')['uid'],
				'menu' 	=> 'export-User',
				'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				}

	function insert_user($data)
		{
			$this->db->insert('ms_user',$data);
		}

	function ProsesDeleteUser($username)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$this->db->where('username',$username);
		$this->db->delete('ms_user');
	}

}
