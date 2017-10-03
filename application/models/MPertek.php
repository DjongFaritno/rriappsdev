<?php
// بسم الله الرحمن الرحیم

class MPertek extends CI_Model {

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

		$this->db->select('idpertek, nopertek, nopengajuan, tgl_mulai, tgl_exp, status');
		$this->db->from('pertek_hd');
		$this->db->order_by('nopertek','desc');
		return $this->db->get()->result();

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report();
		}else{
		$query = $data->query;
		return $this->db->query($query)->result();
			}
	}

	function query_data_pertek($nopertek){
		$data = array();
		$data=$this->db->query("SELECT * from pertek_hd where nopertek='$nopertek'")->row_array();
		return $data;
	}

	function insert_query($param)
	{
		$sql 	= "SELECT * from pengajuan_hd";
		if(trim($param)!='')$sql .= " WHERE ".$param;
		$sql .= " ORDER BY nopengajuan DESC";
		$ardata = array
		(
			'user' 	=> $this->session->userdata('logged_in')['uid'],
			'menu' 	=> 'pertek',
			'query'	=> $sql
		);

		$this->db->replace('query',$ardata);
		// print($print);
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
			'menu' 	=> 'export-pertek',
			'query'	=> $sql
		);

		$this->db->replace('query',$ardata);
	}

	function get_perteknHD($idpertek){
		$data = "SELECT * FROM pertek_hd where idpertek = '$idpertek'";
		return $this->db->query($data)->row();
	}

	function ProsesDeletePertek($idpertek,$nopertek,$nopengajuan)
	{
		//del Pertek hd
		$this->db->where('idpertek',$idpertek);
		$this->db->delete('pertek_hd');
		//del pengajuan dt
		$this->db->where('nopertek',$nopertek);
		$this->db->delete('pertek_dt1');
		$this->db->where('nopertek',$nopertek);
		$this->db->delete('pertek_dt2');
		// update status pengajuan
		$this->db->set('status', 'active');
		$this->db->where('nopengajuan',$nopengajuan);
		$this->db->update('pengajuan_hd');

	}

// ----------------------------------form view dt1 pertek new
	function get_nopengajuan($idpengajuan){
		$data = array();
		$data=$this->db->query("SELECT idpengajuan, nopengajuan, tgl_pengajuan FROM pengajuan_hd where idpengajuan ='$idpengajuan'")->row_array();
		return $data;
	}

	function get_pengajuanHD($idpengajuan){
		$data = "SELECT * FROM pengajuan_hd where idpengajuan = '$idpengajuan'";
		return $this->db->query($data)->row();
	}

	function get_list_datadt1($user,$menu,$nopengajuan)
	{

		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();
		if($data==null)
		{ //data null = pertama kali load page

			$this->db->select('id_sub,nopengajuan,kd_kategori,kuota,ukuran,keterangan');
			$this->db->from('pengajuan_dt1');
			$this->db->order_by('kd_kategori','desc');
			$this->db->where('nopengajuan',$nopengajuan);
			return $this->db->get()->result();

			//query yang akan digunakan untuk export ke excel
			$this->insert_query_report();
		}
		else
		{
			$query = $data->query;
			return $this->db->query($query)->result();
		}
	}

	function simpan_pertek_header($data){

		$this->db->replace('pertek_hd',$data);
	}

	function simpan_pertek_detail($no_pertek,$no_pengajuan){
		$data = array();
		$data=$this->db->query("INSERT INTO pertek_dt1 (id_sub,nopertek,kd_kategori,kuota,sisa_kuota,ukuran,keterangan)
		SELECT id_sub,'$no_pertek',kd_kategori,kuota,kuota,ukuran,keterangan
		FROM pengajuan_dt1 where nopengajuan='$no_pengajuan'");
		// return $data;
	}

	function simpan_pertek_part($no_pertek,$no_pengajuan){
		$data = array();
		$data=$this->db->query("INSERT INTO pertek_dt2 (nopertek,id_sub,partno)
		SELECT '$no_pertek',id_sub,partno
		FROM pengajuan_dt2 where nopengajuan='$no_pengajuan'");
		// return $data;
	}

	function update_Pengajuan($no_pengajuan){
		$this->db->set('status', 'nonactive');
		$this->db->where('nopengajuan',$no_pengajuan);
		$this->db->update('pengajuan_hd');
		// return $data;
	}

	function get_nopertek($idpertek){
		$data = "SELECT * FROM pertek_hd where idpertek = '$idpertek' and status = 'active'";
		return $this->db->query($data)->row();
	}

	function cek_invoice($nopertek){
		$data = array();
		$data=$this->db->query("SELECT * from invoice_dt where nopertek='$nopertek'")->row_array();
		return $data;
	}
	
	function mcek_pertek($nopertek){
		$data = array();
		$data=$this->db->query("SELECT * FROM pertek_hd where nopertek = '$nopertek'")->row_array();
		return $data;
	}

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::pertek dt1
	function get_nopertekHD($idpertek){
		$data = array();
		$data=$this->db->query("SELECT idpertek, nopertek, status FROM pertek_hd where idpertek ='$idpertek'")->row_array();
		return $data;
	}

	function get_list_datapertekdt1($user,$menu,$nopertek)
	{
		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();
		if($data==null)
		{ //data null = pertama kali load page

			$this->db->select('pertek_dt1.id_sub, pertek_dt1.nopertek, pertek_dt1.kd_kategori,ms_kategori.nama_kategori, pertek_dt1.kuota, pertek_dt1.sisa_kuota, pertek_dt1.ukuran,pertek_dt1.keterangan');
			$this->db->from('pertek_dt1');
			$this->db->join('ms_kategori','ms_kategori.kd_kategori = pertek_dt1.kd_kategori');
			$this->db->order_by('kd_kategori','asc');
			$this->db->where('nopertek',$nopertek);
			// echo $this->db->last_query();
			// 					exit();
			return $this->db->get()->result();

			//query yang akan digunakan untuk export ke excel
			$this->insert_query_report();
		}
		else
		{
			$query = $data->query;
			return $this->db->query($query)->result();
		}
	}

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::pertekdt2
	function get_nopertekdt1($idsub){
		$data = array();
		$data=$this->db->query("SELECT a.id_sub, b.idpertek, a.nopertek, b.nopengajuan, a.kd_kategori, a.kuota, a.sisa_kuota, a.ukuran, a.keterangan, b.tgl_mulai, b.tgl_exp, b.status, c.nama_kategori
		FROM pertek_dt1 a INNER JOIN pertek_hd b ON b.`nopertek`= a.`nopertek` INNER JOIN ms_kategori c ON c.`kd_kategori`= a.`kd_kategori` WHERE a.`id_sub`=$idsub")->row_array();
		return $data;
	}

	function get_barang(){
		$data = $this->db->query ("SELECT * FROM ms_barang ORDER BY partno");
		return $data;
	}

	function get_list_datadt2($user,$menu,$idsub)
	{

		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();
		if($data==null)
		{ //data null = pertama kali load page

			$this->db->select('pertek_dt2.id_sub, pertek_dt2.partno, ms_barang.uraian_barang,ms_barang.satuan');
			$this->db->from('pertek_dt2');
			$this->db->join('ms_barang', 'ms_barang.partno = pertek_dt2.partno');
			$this->db->order_by('id_sub','desc');
			$this->db->where('id_sub',$idsub);
			return $this->db->get()->result();

			//query yang akan digunakan untuk export ke excel
			$this->insert_query_report();
		}
		else
		{
			$query = $data->query;
			return $this->db->query($query)->result();
		}
	}

}
