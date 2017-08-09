<?php
// بسم الله الرحمن الرحیم

class MDataBarang extends CI_Model {

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

		$this->db->select('partno, uraian_barang, nohs, satuan');
		$this->db->from('ms_barang');
		$this->db->order_by('partno','desc');
		return $this->db->get()->result();

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report();
		}else{
		$query = $data->query;
		return $this->db->query($query)->result();
			}
	}

	function query_data_barang($partno){
		$data = array();
		$data=$this->db->query("SELECT * from ms_barang where partno='$partno'")->row_array();
		return $data;
		}

	function insert_query($param){

				$sql 	= "SELECT * from ms_barang";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY partno DESC";
// PRINT($param);
// PRINT($sql);
				$ardata = array(

					'user' 	=> $this->session->userdata('logged_in')['uid'],
					'menu' 	=> 'databarang',
					'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				// print($print);
								// //query yang akan digunakan untuk export ke excel
				$this->insert_query_report($param);
				}

	function insert_query_report($param='')
				{
				$sql 	= "SELECT * from ms_barang";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY partno DESC";

				$ardata = array(
				'user' 	=> $this->session->userdata('logged_in')['uid'],
				'menu' 	=> 'export-Barang',
				'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				}

	function insert_barang($data)
		{
			$this->db->insert('ms_barang',$data);
		}

	function ProsesDeleteBarang($partno)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$this->db->where('partno',$partno);
		$this->db->delete('ms_barang');
	}

}
