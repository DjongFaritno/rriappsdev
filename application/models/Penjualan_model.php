<?php

class Penjualan_model extends CI_Model {

	public function __construct(){

        // Call the CI_Model constructor
        parent::__construct();
    }

	function get_list_data($user,$menu){

		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();

		if($data==null){ //data null = pertama kali load page

			$this->db->select('p.no_penjualan,p.tgl_penjualan,p.nama_customer,p.no_sj,p.no_kwitansi,p.no_kendaraan,p.total_harga,p.bayar');
			$this->db->from('penjualan p');
			$this->db->join('vendor v','p.kode_customer=v.kode_vendor','LEFT');
			$this->db->order_by('tgl_penjualan','desc');
			$this->db->order_by('no_penjualan','desc');
			return $this->db->get()->result();

			//query yang akan digunakan untuk export ke excel
			$this->insert_query_report();
		}
		else{

			$query = $data->query;
			return $this->db->query($query)->result();
		}
	}

	function insert_query($param){

		$sql 	= "SELECT p.no_penjualan,p.tgl_penjualan,p.nama_customer,p.no_sj,p.no_kwitansi,p.no_kendaraan,p.total_harga,p.bayar FROM
					penjualan p LEFT OUTER JOIN vendor v ON p.kode_customer=v.kode_vendor ";

		if(trim($param)!='')$sql .= " WHERE ".$param;

		$sql .= " ORDER BY tgl_penjualan DESC, no_penjualan DESC";

		$ardata = array(

			'user' 	=> $this->session->userdata('logged_in')['uid'],
			'menu' 	=> 'penjualan',
			'query'	=> $sql
		);

		$this->db->replace('query',$ardata);

		//query yang akan digunakan untuk export ke excel
		$this->insert_query_report($param);
	}

	function insert_query_report($param=''){

		$sql 	= "SELECT p.no_penjualan,p.tgl_penjualan,p.nama_customer,p.no_sj,p.no_kwitansi,p.no_kendaraan,p.total_harga,p.bayar,
						d.kode_barang, b.nama_barang, d.jumlah, d.harga, b.satuan, (d.jumlah*d.harga) as subtotal
					FROM penjualan p LEFT OUTER JOIN vendor v ON p.kode_customer=v.kode_vendor
					 	INNER JOIN penjualan_detail d ON p.no_penjualan=d.no_penjualan
						INNER JOIN master_barang b ON d.kode_barang=b.kode_barang ";

		if(trim($param)!='')$sql .= " WHERE ".$param;

		$sql .= " ORDER BY tgl_penjualan DESC, no_penjualan DESC, d.kode_barang ";

		$ardata = array(

			'user' 	=> $this->session->userdata('logged_in')['uid'],
			'menu' 	=> 'report-penjualan',
			'query'	=> $sql
		);

		$this->db->replace('query',$ardata);
	}

	function del_query($user){

		$this->db->where('user',$user);
		$this->db->where('menu','penjualan');
		$this->db->delete('query');
	}

	function get_databarang($type){

		$data = $this->db->query ("SELECT * FROM master_barang WHERE kategori='$type' ORDER BY nama_barang,kode_barang");
		return $data;
	}

	function get_customer(){

		$this->db->where('tipe','C');
		$this->db->order_by('kode_vendor');

		return $this->db->get('vendor')->result();
	}

	function get_sequence($field){

		$this->db->where('nama_field',$field);
		return $this->db->get('sequence')->row();
	}

	function update_sequence($last_no,$field){

		$data = array(

			'nama_field'  		=> $field,
			'nomor_terakhir' 	=> $last_no
		);

		$this->db->replace('sequence',$data);
	}

	function simpan_header($data){

		$this->db->replace('penjualan',$data);
	}

	function simpan_detail($data){

		$this->db->replace('penjualan_detail',$data);
	}

	function simpan_mutasi($data){

		$this->db->replace('mutasi_barang',$data);
	}

	function save_hutang($data){

		$this->db->replace('hutang',$data);
	}

	function del_penjualan($no_jual){

		//delete mutasi
		$this->db->where('no_dokumen',$no_jual);
		$this->db->delete('mutasi_barang');

		//balance stok
		$this->db->where('no_penjualan',$no_jual);
		$detail = $this->db->get('penjualan_detail')->result();
		$user 	= $this->session->userdata('logged_in')['uid'];

		foreach ($detail as $d){

			$this->balance_stok($d->kode_barang,$user);
		}

		//delete header
		$this->db->where('no_penjualan',$no_jual);
		$this->db->delete('penjualan');

		//delete detail
		$this->db->where('no_penjualan',$no_jual);
		$this->db->delete('penjualan_detail');

		// $this->db->delete('hutang');
		// $this->db->delete('hutang_detail');
	}

	function balance_stok($kode_barang,$user){

		$sqlin  	= "SELECT IFNULL(SUM(jumlah),0) AS jml FROM mutasi_barang WHERE kode_barang='".$kode_barang."' AND tipe='i'";
		$sqlout 	= "SELECT IFNULL(SUM(jumlah),0) AS jml FROM mutasi_barang WHERE kode_barang='".$kode_barang."' AND tipe='o'";

		$sum_in 	= $this->db->query($sqlin)->row()->jml;
		$sum_out 	= $this->db->query($sqlout)->row()->jml;

		$ar_stok = array(

			'kode_barang' 	=> $kode_barang,
			'stok_in' 		=> $sum_in,
			'stok_out'		=> $sum_out,
			'aktual_stok'	=> $sum_in-$sum_out,
			'updater'		=> $user
		);

		$this->db->replace('stok',$ar_stok);
	}

	function get_penjualan_detail($nojual){

		$sql = "SELECT h.no_penjualan,h.tgl_penjualan,h.kode_customer,v.nama_vendor,h.total_harga,h.nama_customer,h.no_sj,h.no_kwitansi,
					h.bayar,d.jumlah,b.satuan,d.harga,b.nama_barang,d.kode_barang,IFNULL(hd.nominal,0) AS bayar,h.no_kendaraan,
					b.tipe,b.model,v.alamat
				FROM penjualan h
					INNER JOIN penjualan_detail d
						ON h.no_penjualan=d.no_penjualan
					INNER JOIN vendor v ON h.kode_customer=v.kode_vendor
					INNER JOIN master_barang b ON d.kode_barang=b.kode_barang
					LEFT OUTER JOIN
						(SELECT IFNULL(SUM(nominal),0) AS nominal, no_penjualan FROM hutang_detail
							GROUP BY no_penjualan) hd
						ON h.no_penjualan=hd.no_penjualan
				WHERE h.no_penjualan='".$nojual."'";

		return $this->db->query($sql);
	}
	
}
