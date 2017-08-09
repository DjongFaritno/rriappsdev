<?php
// بسم الله الرحمن الرحیم

class MDataKategori extends CI_Model {

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

		$this->db->select('kd_kategori, nama_kategori');
		$this->db->from('ms_kategori');
		$this->db->order_by('kd_kategori','desc');
		return $this->db->get()->result();

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report();
		}else{
		$query = $data->query;
		return $this->db->query($query)->result();
			}
	}

	function query_data_kategori($kdkategori){
		$data = array();
		$data=$this->db->query("SELECT * from ms_kategori where kd_kategori='$kdkategori'")->row_array();
		return $data;
		}

	function insert_query($param){

				$sql 	= "SELECT * from ms_kategori";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY kd_kategori DESC";
				$ardata = array(

					'user' 	=> $this->session->userdata('logged_in')['uid'],
					'menu' 	=> 'datakategori',
					'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				// print($print);
								// //query yang akan digunakan untuk export ke excel
				$this->insert_query_report($param);
				}

	function insert_query_report($param='')
				{
				$sql 	= "SELECT * from ms_kategori";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY kd_kategori DESC";

				$ardata = array(
				'user' 	=> $this->session->userdata('logged_in')['uid'],
				'menu' 	=> 'export-kategori',
				'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				}

	function insert_kategori($data)
		{
			$this->db->insert('ms_kategori',$data);
		}

	function ProsesDeletekategori($kdkategori)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$this->db->where('kd_kategori',$kdkategori);
		$this->db->delete('ms_kategori');
	}

}
