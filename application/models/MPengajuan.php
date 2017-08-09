<?php
// بسم الله الرحمن الرحیم

class MPengajuan extends CI_Model {

	public function __construct(){

        // Call the CI_Model constructor
        parent::__construct();
    }

	function get_list_data($user,$menu)
	{
		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();
		if($data==null)//data null = pertama kali load page
		{
			$this->db->select('idpengajuan, nopengajuan, tgl_pengajuan, status');
			$this->db->from('pengajuan_hd');
			$this->db->order_by('nopengajuan','desc');
			return $this->db->get()->result();

			//query yang akan digunakan untuk export ke excel
			$this->insert_query_report();
		}else
		{
			$query = $data->query;
			return $this->db->query($query)->result();
		}
	}

	function query_data_pengajuan($nopengajuan)
	{
		$data = array();
		$data=$this->db->query("SELECT * from pengajuan_hd where nopengajuan='$nopengajuan'")->row_array();
		return $data;
	}

	function insert_query($param)
	{
		$sql 	= "SELECT * from pengajuan_hd";

		if(trim($param)!='')$sql .= " WHERE ".$param;

		$sql .= " ORDER BY nopengajuan DESC";
		$ardata = array(
			'user' 	=> $this->session->userdata('logged_in')['uid'],
			'menu' 	=> 'pengajuan',
			'query'	=> $sql
		);

		$this->db->replace('query',$ardata);
		// //query yang akan digunakan untuk export ke excel
		$this->insert_query_report($param);
	}

	function insert_query_report($param='')
	{
		$sql 	= "SELECT * from pengajuan_hd";
		if(trim($param)!='')$sql .= " WHERE ".$param;
		$sql .= " ORDER BY nopengajuan DESC";
		$ardata = array(
			'user' 	=> $this->session->userdata('logged_in')['uid'],
			'menu' 	=> 'export-pengajuan',
			'query'	=> $sql
		);

		$this->db->replace('query',$ardata);
	}

	// function insert_pengajuan($data)
	// 	{
	// 		$this->db->insert('pengajuan_hd',$data);
	// 	}

	function ProsesDeletePengajuan($idpengajuan,$nopengajuan)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		//del pengajuan hd
		$this->db->where('idpengajuan',$idpengajuan);
		$this->db->delete('pengajuan_hd');
		//del pengajuan dt
		$this->db->where('nopengajuan',$nopengajuan);
		$this->db->delete('pengajuan_dt1');
		//del pengajuan dt
		$this->db->where('nopengajuan',$nopengajuan);
		$this->db->delete('pengajuan_dt2');
	}

	function get_kategori(){
		$data = $this->db->query ("SELECT * FROM ms_kategori ORDER BY kd_kategori,nama_kategori");
		return $data;
	}

	function simpan_header($data){

		$this->db->replace('pengajuan_hd',$data);
	}

	function simpan_detail($data){

		$this->db->replace('pengajuan_dt1',$data);
	}
	function get_sequence_pengajuan()
		{

			$this->db->where('nama_field','no_pengajuanhd');
			return $this->db->get('sequence')->row();
		}

// fungsi nomor otomatis
	function update_sequence($last_no)
		{
			$data = array(
			'nama_field'  		=> 'no_pengajuanhd',
			'nomor_terakhir' 	=> $last_no
			);

			$this->db->replace('sequence',$data);
		}
// end fungsi nomor otomatis

function get_pengajuanHD($idpengajuan){
	$data = "SELECT * FROM pengajuan_hd where idpengajuan = '$idpengajuan'";
		return $this->db->query($data)->row();
}

// ----------------------------------form view dt1 pengajuan
function get_list_datadt1($user,$menu,$nopengajuan)
{

	$this->db->where('user',$user);
	$this->db->where('menu',$menu);
	$data = $this->db->get('query')->row();
	if($data==null){ //data null = pertama kali load page
		//
		// $this->db->select('pengajuan_dt2.id_sub,pengajuan_dt2.partno,ms_barang.uraian_barang,ms_barang.satuan');
		// $this->db->from('pengajuan_dt2');
		// $this->db->join('ms_barang', 'ms_barang.partno = pengajuan_dt2.partno');
		// $this->db->order_by('id_sub','desc');
		// $this->db->where('id_sub',$idsub);

	$this->db->select('pengajuan_dt1.id_sub, pengajuan_dt1.nopengajuan, pengajuan_dt1.kd_kategori,ms_kategori.nama_kategori, pengajuan_dt1.kuota, pengajuan_dt1.ukuran,pengajuan_dt1.keterangan');
	$this->db->from('pengajuan_dt1');
	$this->db->join('ms_kategori','ms_kategori.kd_kategori = pengajuan_dt1.kd_kategori');
	$this->db->order_by('kd_kategori','asc');
	$this->db->where('nopengajuan',$nopengajuan);
	return $this->db->get()->result();

	//query yang akan digunakan untuk export ke excel
	$this->insert_query_report();
	}else{
	$query = $data->query;
	return $this->db->query($query)->result();
		}
}

function get_nopengajuan($nopengajuan){
	$data = array();
	$data=$this->db->query("SELECT idpengajuan, nopengajuan, tgl_pengajuan, status FROM pengajuan_hd where nopengajuan ='$nopengajuan'")->row_array();
	return $data;
}

function ProsesDeleteSub($idsub)
	{
	$user = $this->session->userdata('logged_in')['uid'];
	//del pengajuan hd
	$this->db->where('id_sub',$idsub);
	$this->db->delete('pengajuan_dt1');
	}

// ----------------------------------form view dt2 pengajuan
function get_nopengajuandt1($idsub){
	$data = array();
	$data=$this->db->query("SELECT a.id_sub, b.idpengajuan, a.nopengajuan, a.kd_kategori, a.kuota, a.ukuran, a.keterangan, b.tgl_pengajuan, b.status, c.nama_kategori
FROM pengajuan_dt1 a INNER JOIN pengajuan_hd b ON b.`nopengajuan`= a.`nopengajuan` INNER JOIN ms_kategori c ON c.`kd_kategori`= a.`kd_kategori` WHERE a.`id_sub`=$idsub")->row_array();
	return $data;
}
function get_list_datadt2($user,$menu,$idsub)
{

	$this->db->where('user',$user);
	$this->db->where('menu',$menu);
	$data = $this->db->get('query')->row();
	if($data==null){ //data null = pertama kali load page

	$this->db->select('pengajuan_dt2.id_sub,pengajuan_dt2.partno,ms_barang.uraian_barang,ms_barang.satuan');
	$this->db->from('pengajuan_dt2');
	$this->db->join('ms_barang', 'ms_barang.partno = pengajuan_dt2.partno');
	$this->db->order_by('id_sub','desc');
	$this->db->where('id_sub',$idsub);
	return $this->db->get()->result();

	//query yang akan digunakan untuk export ke excel
	$this->insert_query_report();
	}else{
	$query = $data->query;
	return $this->db->query($query)->result();
		}
}
function get_barang(){
	$data = $this->db->query ("SELECT * FROM ms_barang ORDER BY partno");
	return $data;
}
function cekbarang($idsub,$partno){
	$data = array();
	$data=$this->db->query("SELECT * from pengajuan_dt2 where id_sub='$idsub' and partno='$partno'")->row_array();
	return $data;
	}
function kategori($nopengajuan,$kategori){
	$data = array();
	$data=$this->db->query("SELECT * from pengajuan_dt1 where kd_kategori='$kategori' and nopengajuan='$nopengajuan'")->row_array();
	return $data;
	}
function insert_barang($data)
	{
		$this->db->insert('pengajuan_dt2',$data);
	}

function ProsesDeletePart($idsub,$partno)
	{
	$user = $this->session->userdata('logged_in')['uid'];
	//del pengajuan hd
	$this->db->where('id_sub',$idsub);
	$this->db->where('partno',$partno);
	$this->db->delete('pengajuan_dt2');
	}
}
