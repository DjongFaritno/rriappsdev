<?php
// بسم الله الرحمن الرحیم

class MDataSupplier extends CI_Model {

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

		$this->db->select('kd_supplier, nama_supplier');
		$this->db->from('ms_supplier');
		$this->db->order_by('kd_supplier','desc');
		return $this->db->get()->result();

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report();
		}else{
		$query = $data->query;
		return $this->db->query($query)->result();
			}
	}

	function query_data_supplier($kdsupplier){
		$data = array();
		$data=$this->db->query("SELECT * from ms_supplier where kd_supplier='$kdsupplier'")->row_array();
		return $data;
		}

	function insert_query($param){

				$sql 	= "SELECT * from ms_supplier";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY kd_supplier DESC";
				$ardata = array(

					'user' 	=> $this->session->userdata('logged_in')['uid'],
					'menu' 	=> 'datasupplier',
					'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				// print($print);
								// //query yang akan digunakan untuk export ke excel
				$this->insert_query_report($param);
				}

	function insert_query_report($param='')
				{
				$sql 	= "SELECT * from ms_supplier";

				if(trim($param)!='')$sql .= " WHERE ".$param;

				$sql .= " ORDER BY kd_supplier DESC";

				$ardata = array(
				'user' 	=> $this->session->userdata('logged_in')['uid'],
				'menu' 	=> 'export-Supplier',
				'query'	=> $sql
				);

				$this->db->replace('query',$ardata);
				}

	function insert_supplier($data)
		{
			$this->db->insert('ms_supplier',$data);
		}

	function ProsesDeletesupplier($kdsupplier)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$this->db->where('kd_supplier',$kdsupplier);
		$this->db->delete('ms_supplier');
	}

}
