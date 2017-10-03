<?php
// بسم الله الرحمن الرحیم

class MInvoice extends CI_Model 
{

	public function __construct()
	{

        // Call the CI_Model constructor
        parent::__construct();
  }

	function get_list_data($user,$menu)
	{
		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();

		if($data==null)
		{ //data null = pertama kali load page
			$this->db->select('invoice_hd.idinvoicehd, invoice_hd.noinvoice, invoice_hd.tgl_invoice, invoice_hd.noaju, invoice_hd.tgl_aju,
			invoice_hd.kd_supplier,ms_supplier.nama_supplier, invoice_hd.pelabuhan_muat, invoice_hd.negara_asal, invoice_hd.nodaftar_pib, invoice_hd.tgldaftar_pib');
			$this->db->from('invoice_hd');
			$this->db->join('ms_supplier','ms_supplier.kd_supplier = invoice_hd.kd_supplier');
			$this->db->order_by('idinvoicehd','asc');
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

	function ProsesDeleteInvoice($idinvoicehd,$noinvoice)
	{
		$user = $this->session->userdata('logged_in')['uid'];
		// dt
		$this->db->where('noinvoice',$noinvoice);
		$this->db->delete('invoice_dt');
		// hd
		$this->db->where('idinvoicehd',$idinvoicehd);
		$this->db->delete('invoice_hd');
	}

	function get_invoiceeimport($user)
	{
		$data = "SELECT * FROM eimporthd where userid = '$user'";
		return $this->db->query($data)->row();
	}

	function deleteeimportdt($noinvoice)
	{
		$this->db->where('noinvoice',$noinvoice);
		$this->db->delete("eimportdt");
	}

	function deleteeimporthd($user)
	{
		$this->db->where('userid',$user);
		$this->db->delete("eimporthd");
	}

	function get_supplier()
	{
		$data = $this->db->query ("SELECT * FROM ms_supplier ORDER BY kd_supplier,nama_supplier");
		return $data;
	}

	function sveimporthd($datahd)
	{
		$this->db->replace("eimporthd",$datahd);
	}

	function sveimportdt($datadt)
	{
		$this->db->replace("eimportdt",$datadt);
	}

	function GetDataEimportHD($user)
	{
		$data = array();
		$data=$this->db->query("SELECT eimporthd.idinvoicehd, eimporthd.noinvoice, eimporthd.tglinvoice, eimporthd.kd_supplier, ms_supplier.nama_supplier
														from eimporthd join ms_supplier on ms_supplier.kd_supplier = eimporthd.kd_supplier WHERE eimporthd.userid='$user'"
													)->row_array();
													
		return $data;
	}

	function get_invoiceeimportHD($idnoinvoice)
	{
		$data = "SELECT * FROM eimporthd where idinvoicehd = '$idnoinvoice'";
		// echo $data;
		// exit();
		return $this->db->query($data)->row();
	}

	function GetDataEimport($user,$menu,$noinvoice)
	{
		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();

		if($data==null)
		{ //data null = pertama kali load page

			$this->db->select('eimportdt.noinvoice, eimportdt.partno, eimportdt.qty,
			pertek_dt2.nopertek,pertek_dt1.kd_kategori,
			pertek_dt2.id_sub, pertek_dt1.kuota, pertek_dt1.sisa_kuota,  pertek_hd.status');
			$this->db->from('eimportdt');
			$this->db->join('pertek_dt2', 'pertek_dt2.partno = eimportdt.partno', 'left');
			$this->db->join('pertek_dt1', 'pertek_dt1.id_sub = pertek_dt2.id_sub', 'left');
			$this->db->join('pertek_hd', 'pertek_hd.nopertek = pertek_dt2.nopertek', 'left');
			$this->db->order_by('nopertek','Desc');
			$this->db->order_by('kd_kategori','Desc');
			$this->db->where('noinvoice',$noinvoice);
			$this->db->where('status','active');
			$this->db->or_where('status',null);
			// echo $this->db->last_query();
			// 										exit();
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

	function getsum($id_sub, $noinvoice)
	{
			$sql = "SELECT SUM(eimportdt.`qty`) AS qtykirim
			FROM eimportdt
			LEFT JOIN pertek_dt2 ON pertek_dt2.`partno` = eimportdt.`partno`
			WHERE pertek_dt2.id_sub = '$id_sub'
			AND eimportdt.noinvoice ='$noinvoice'";
			// echo $sql;
			// exit();
			return $this->db->query($sql)->row();
	}

	function svInvoiceHD($data)
	{

		$this->db->replace('invoice_HD',$data);
	}

	function svInvoiceDT($noinvoice)
	{
		//insert invoice_DT
		$data = $this->db->query ("INSERT INTO invoice_dt (noinvoice, nopertek,kd_kategori, partno, qty, unit_price, kd_curr)
			SELECT eimportdt.noinvoice, pertek_dt2.nopertek, pertek_dt1.kd_kategori, eimportdt.partno, eimportdt.qty,  eimportdt.unit_price, eimportdt.kd_curr
			FROM eimportdt
			LEFT JOIN pertek_dt2 ON pertek_dt2.partno = eimportdt.partno
			LEFT JOIN pertek_dt1 ON pertek_dt1.id_sub = pertek_dt2.id_sub
			LEFT JOIN pertek_hd ON pertek_hd.nopertek = pertek_dt2.nopertek
			WHERE eimportdt.noinvoice = '$noinvoice' AND pertek_hd.status ='active' OR pertek_hd.status ='null'");
		return $data;
	}

	function udpate_kuotapertek($id_sub,$sisakuota)
	{
		$data = $this->db->query ("UPDATE pertek_dt1 set sisa_kuota ='$sisakuota' WHERE id_sub = '$id_sub'");
		return $data;
	}


	// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::Modul View invoice DT

	function get_invoiceHeader($idinvoicehd)
	{
		$data = array();
		$data=$this->db->query("SELECT invoice_HD.idinvoicehd, invoice_HD.noinvoice, invoice_HD.tgl_invoice, invoice_HD.tgl_aju, invoice_HD.noaju, invoice_HD.kd_supplier, ms_supplier.nama_supplier, invoice_HD.pelabuhan_muat,
		invoice_HD.negara_asal, invoice_HD.nodaftar_pib, invoice_HD.tgldaftar_pib from invoice_HD inner join ms_supplier on ms_supplier.kd_supplier = invoice_HD.kd_supplier WHERE invoice_HD.idinvoicehd='$idinvoicehd'")->row_array();
		return $data;
	}

	function get_invoicehd($idinvoicehd)
	{
		$data = "SELECT * FROM invoice_hd where idinvoicehd = '$idinvoicehd'";
		return $this->db->query($data)->row();
	}

	function get_invoicedt($user,$menu,$noinvoice)
	{

		$this->db->where('user',$user);
		$this->db->where('menu',$menu);
		$data = $this->db->get('query')->row();

		if($data==null)
		{ //data null = pertama kali load page

			$this->db->select('invoice_dt.noinvoice, invoice_dt.partno, invoice_dt.qty,
			invoice_dt.unit_price, invoice_dt.kd_curr');
			$this->db->from('invoice_dt');
			// $this->db->join('eimportdt', 'eimportdt.noinvoice = eimporthd.noinvoice');
			$this->db->order_by('noinvoice','Asc');
			$this->db->where('noinvoice',$noinvoice);
			return $this->db->get()->result();

			// $this->db->select('eimportdt.noinvoice, eimportdt.partno, eimportdt.qty,
			// pertek_dt2.nopertek,pertek_dt1.kd_kategori,
			// pertek_dt2.id_sub, pertek_dt1.kuota,  pertek_hd.status');
			// $this->db->from('eimportdt');
			// $this->db->join('pertek_dt2', 'pertek_dt2.partno = eimportdt.partno', 'left');
			// $this->db->join('pertek_dt1', 'pertek_dt1.id_sub = pertek_dt2.id_sub', 'left');
			// $this->db->join('pertek_hd', 'pertek_hd.nopertek = pertek_dt2.nopertek', 'left');
			// $this->db->order_by('nopertek','Desc');
			// $this->db->order_by('partno','Desc');
			// $this->db->where('noinvoice',$noinvoice);
			// $this->db->where('status','active');
			// $this->db->or_where('status',null);
			// return $this->db->get()->result();

			//query yang akan digunakan untuk export ke excel
			$this->insert_query_report();
		}
		else
		{
			$query = $data->query;
			return $this->db->query($query)->result();
		}
	}

	function get_jumlahpertek($noinvoice,$user)
	{
		$data = array();
		$data=$this->db->query("SELECT DISTINCT pertek_dt2.id_sub, pertek_dt2.nopertek FROM eimportdt
													INNER JOIN eimporthd ON eimporthd.noinvoice = eimportdt.noinvoice
													LEFT JOIN pertek_dt2 ON pertek_dt2.partno = eimportdt.partno
													WHERE eimportdt.noinvoice ='$noinvoice'
													AND eimporthd.`userid` ='$user'")->result_array();
								// echo $this->db->last_query();
								// exit();
		return $data;
	}

	function get_datapertek($id_sub,$noinvoice,$user)
	{
		$data = array();
		$data=$this->db->query("SELECT pertek_dt2.id_sub, pertek_dt2.nopertek ,pertek_dt1.kuota, SUM(eimportdt.qty)  AS total_kirim, pertek_dt1.sisa_kuota- SUM(eimportdt.qty) AS sisa
														FROM eimportdt
														INNER JOIN eimporthd ON eimporthd.noinvoice = eimportdt.noinvoice
														LEFT JOIN pertek_dt2 ON pertek_dt2.partno = eimportdt.partno
														INNER JOIN pertek_dt1 ON pertek_dt1.id_sub = pertek_dt2.id_sub
														WHERE pertek_dt2.id_sub = '$id_sub'
														AND eimportdt.noinvoice ='$noinvoice'
														AND eimporthd.`userid` ='$user'")->row_array();
								// echo $this->db->last_query();
								// exit();
		return $data;
	}


}
