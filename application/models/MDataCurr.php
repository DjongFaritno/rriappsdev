<?php
// بسم الله الرحمن الرحیم

class MDataCurr extends CI_Model {

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

		$this->db->select('kd_curr, nama_curr');
		$this->db->from('ms_curr');
		$this->db->order_by('kd_curr','desc');
		return $this->db->get()->result();

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report();
		}else{
		$query = $data->query;
		return $this->db->query($query)->result();
			}
	}

	function query_data_curr($kdcurr){
		$data = array();
		$data=$this->db->query("SELECT * from ms_curr where kd_curr='$kdcurr'")->row_array();
		return $data;
		}

	function insert_query($param){

				$sql 	= "SELECT * from ms_curr";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY kd_curr DESC";
				$ardata = array(

					'user' 	=> $this->session->userdata('logged_in')['uid'],
					'menu' 	=> 'datacurr',
					'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				// print($print);
								// //query yang akan digunakan untuk export ke excel
				$this->insert_query_report($param);
				}

	function insert_query_report($param='')
				{
				$sql 	= "SELECT * from ms_curr";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY kd_curr DESC";

				$ardata = array(
				'user' 	=> $this->session->userdata('logged_in')['uid'],
				'menu' 	=> 'export-curr',
				'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				}

	function insert_curr($data)
		{
			$this->db->insert('ms_curr',$data);
		}

	function ProsesDeleteCurr($kdcurr)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$this->db->where('kd_curr',$kdcurr);
		$this->db->delete('ms_curr');
	}

}
