<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class Pertek extends FNZ_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mpertek');
	}

	function index()
	{
		$data['title'] = 'LIST PENGAJUAN';
	    $data['content'] = $this->load->view('vPertek',$data,TRUE);
	    $this->load->view('main',$data);
	}

	function loaddatatablelist()
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mpertek->get_list_data($user,'pertek');
		$iTotalRecords  	= count($data);
		$iDisplayLength 	= intval($_REQUEST['length']);
		$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  	= intval($_REQUEST['start']);
		$sEcho				= intval($_REQUEST['draw']);
		$records            = array();
		$records["data"]    = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;
		$fdate = 'd-M-Y';
		for($i = $iDisplayStart; $i < $end; $i++)
		{
			$privilege = $this->session->userdata('logged_in')['priv'];
			if ($privilege=='OPERATOR')//jika sebagai operator, maka tidak bisa hapus data
			{
				$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->idpertek.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
			}
			else
			{
				$act = '<a class="btn btn-success"  href="#" data-toggle="tooltip" title="View Data!" onclick="ViewDt1(\''.$data[$i]->idpertek.'\')"><i class="fa fa-fw fa-file-text"></i></a>
				<a class="btn btn-danger"  href="#" data-toggle="tooltip" title="Delete Data!" onclick="DeletePertek(\''.$data[$i]->idpertek.'\',\''.$data[$i]->nopertek.'\')"><i class="fa fa-fw fa-trash"></i></a>';
				
			}
			$records["data"][] = array(
			$data[$i]->nopertek,
			$data[$i]->nopengajuan,
			$data[$i]->tgl_mulai,
			$data[$i]->tgl_exp,
			$act
			);
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}

	function delete_pertek($idpertek){
		$pertekHD = $this->mpertek->get_perteknHD($idpertek);
		if($pertekHD != null)
		{
			$nopertek = $pertekHD->nopertek;
			$nopengajuan = $pertekHD->nopengajuan;
			$this->mpertek->ProsesDeletePertek($idpertek,$nopertek,$nopengajuan);

			header('location:'.base_url().'pertek');
		}
	}
// ::::::::::::::::::::::::::::::::::::::::::::::::::::pertek add new
	function newpertek($idpertek)
	{
		$vdata['nopengajuan']=$this->mpertek->get_nopengajuan($idpertek);
		$vdata['title'] = 'PERTEK';
		$data['content'] = $this->load->view('vPerteknew',$vdata,TRUE);
		$this->load->view('main',$data);
	}

	function loaddatatableview($idpertek)
	{
		$nopengajuan = $this->mpertek->get_pengajuanHD($idpertek);
		if($nopengajuan != null)
		{
			$nopengajuan = $nopengajuan->nopengajuan;
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mpertek->get_list_datadt1($user,'pertek',$nopengajuan);
			$iTotalRecords  	= count($data);
			$iDisplayLength 	= intval($_REQUEST['length']);
			$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
			$iDisplayStart  	= intval($_REQUEST['start']);
			$sEcho				= intval($_REQUEST['draw']);
			$records            = array();
			$records["data"]    = array();
			$end = $iDisplayStart + $iDisplayLength;
			$end = $end > $iTotalRecords ? $iTotalRecords : $end;
			$fdate = 'd-M-Y';
			for($i = $iDisplayStart; $i < $end; $i++)
			{
				$records["data"][] = array(
					$data[$i]->kd_kategori,
					$data[$i]->kuota,
					$data[$i]->ukuran,
					$data[$i]->keterangan,
				// $act
				);
			}

			$records["draw"]            	= $sEcho;
			$records["recordsTotal"]    	= $iTotalRecords;
			$records["recordsFiltered"] 	= $iTotalRecords;
			echo json_encode($records);
		}
	}

	function simpan_pertek(){
		$no_pertek 			= $this->input->post('no_pertek');
		$no_pengajuan 		= $this->input->post('no_pengajuan');
		$tmulai 			= $this->input->post('tgl_mulai');
		$tmulai 			= date_parse_from_format("d/m/Y", $tmulai);
		$tgl_mulai 			= $tmulai['year'].'/'.$tmulai['month'].'/'.$tmulai['day'];
		$texp 				= $this->input->post('tgl_exp');
		$texp 				= date_parse_from_format("d/m/Y", $texp);
		$tgl_exp 			= $texp['year'].'/'.$texp['month'].'/'.$texp['day'];
		$user 				= $this->session->userdata('logged_in')['uid'];

		$header = array(
			'nopertek' 			=> $no_pertek,
			'nopengajuan'		=> $no_pengajuan,
			'tgl_mulai' 		=> $tgl_mulai,
			'tgl_exp'				=> $tgl_exp,
			'user' 					=> $user,
			'status' 				=> 'active',
		);
		$this->mpertek->simpan_pertek_header($header);
		$this->mpertek->simpan_pertek_detail($no_pertek,$no_pengajuan);
		$this->mpertek->simpan_pertek_part($no_pertek,$no_pengajuan);
		$this->mpertek->update_Pengajuan($no_pengajuan);
		echo "true";
	}

	function cek_invoice($idpertek)
	{
		$nopertek = $this->mpertek->get_nopertek($idpertek);
		if($nopertek != null)
		{
			$nopertek = $nopertek->nopertek;
			$data = $this->mpertek->cek_invoice($nopertek);
			echo json_encode($data);
		}
	}
	
	function cek_pertek($nopertek)
	{
		$data = $this->mpertek->mcek_pertek($nopertek);
		echo json_encode($data);
	}

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::pertek dt1
	function view_pertek($idpertek)
	{
		$vdata['nopertekHD']=$this->mpertek->get_nopertekHD($idpertek);
		$vdata['title'] 		= 'PERTEK DT1';
		$vdata['titledt'] 	= 'LIST PERTEK KATEGORI';
		$data['content'] 		= $this->load->view('vPertekdt1',$vdata,TRUE);
		$this->load->view('main',$data);
	}

	function loaddatatableviewdt1($idpertek)
	{
		$pertekHD = $this->mpertek->get_perteknHD($idpertek);
		if($pertekHD != null)
		{
			$nopertek = $pertekHD->nopertek;
			// print($nopengajuan);
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mpertek->get_list_datapertekdt1($user,'pertekdt1',$nopertek);
			// var_dump($data);
			// exit();
			$iTotalRecords  	= count($data);
			$iDisplayLength 	= intval($_REQUEST['length']);
			$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
			$iDisplayStart  	= intval($_REQUEST['start']);
			$sEcho				= intval($_REQUEST['draw']);
			$records            = array();
			$records["data"]    = array();
			$end = $iDisplayStart + $iDisplayLength;
			$end = $end > $iTotalRecords ? $iTotalRecords : $end;
			$fdate = 'd-M-Y';
			for($i = $iDisplayStart; $i < $end; $i++)
				{
				$privilege = $this->session->userdata('logged_in')['priv'];

				if ($privilege=='OPERATOR')//jika sebagai operator, maka tidak bisa hapus data
				{
					$act = '<a class="btn btn-success"  href="#" data-toggle="tooltip" title="View Data!" onclick="ViewDt2(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-file-text"></i></a>
					<a class="btn btn-danger"  href="#" data-toggle="tooltip" title="Delete Data!" onclick="view_pertekinvoice(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-trash"></i></a>';
				}
				else
				{
					// $act = '<a class="btn btn-info alert-info btn-xs  " href="#" onclick="ViewDt2(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-file-text"></i>List Part</a>';
					
					$act = '<a class="btn btn-success"  href="#" data-toggle="tooltip" title="View Data!" onclick="ViewDt2(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-file-text"></i></a>
					<a class="btn btn-info"  href="#" data-toggle="tooltip" title="View Data Invoice!" onclick="view_pertekinvoice(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw  fa-list"></i></a>';
				}

				// print $privilege;
				$records["data"][] = array(
					$data[$i]->kd_kategori,
					$data[$i]->nama_kategori,
					// $example = "1234567";
					// $subtotal =  number_format($example, 2, '.', ',');
					// echo $subtotal;
					number_format($data[$i]->kuota, 0, '.', ','),
					number_format($data[$i]->sisa_kuota, 0, '.', ','),
					// $data[$i]->kuota,
					$data[$i]->ukuran,
					$data[$i]->keterangan,
					$act
				);
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
		}
	}
// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::pertekdt2
	function view_pertekdt2($idsub)
	{
		$vdata['pertekdt1']=$this->mpertek->get_nopertekdt1($idsub);

		//get data kategori
		$kategori = $this->mpertek->get_barang()->result();

		// $vdata['opt_item'][NULL] = '-';
		// foreach ($kategori as $b) {
		// 	$vdata['opt_item'][$b->partno."#".$b->uraian_barang."#".$b->nohs."#".$b->satuan]
		// 	=$b->partno." | ".$b->uraian_barang;
		// }

		$vdata['title'] = 'PERTEK DT1';
		$vdata['titledt'] = 'LIST PART BARANG';
		$data['content'] = $this->load->view('vPertekdt2',$vdata,TRUE);

		$this->load->view('main',$data);

	}

	function loaddatatablepart($idsub)
	{
		// print($nopengajuan);
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mpertek->get_list_datadt2($user,'pengajuandt2',$idsub);
		$iTotalRecords  	= count($data);
		$iDisplayLength 	= intval($_REQUEST['length']);
		$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  	= intval($_REQUEST['start']);
		$sEcho				= intval($_REQUEST['draw']);
		$records            = array();
		$records["data"]    = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;
		$fdate = 'd-M-Y';
		for($i = $iDisplayStart; $i < $end; $i++)
		{
			$records["data"][] = array(
				// $data[$i]->id_sub,
				$data[$i]->partno,
				$data[$i]->uraian_barang,
				$data[$i]->satuan
				// 	$act
			);
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::pertekinvoice
	function view_pertekinvoice($idsub)
	{
		$vdata['pertekdt1']=$this->mpertek->get_nopertekdt1($idsub);

		//get data kategori
		$kategori = $this->mpertek->get_barang()->result();

		// $vdata['opt_item'][NULL] = '-';
		// foreach ($kategori as $b) {
		// 	$vdata['opt_item'][$b->partno."#".$b->uraian_barang."#".$b->nohs."#".$b->satuan]
		// 	=$b->partno." | ".$b->uraian_barang;
		// }

		$vdata['title'] = 'PERTEK INVOICE';
		$vdata['titledt'] = 'LIST PART BARANG';
		$vdata['titleinvoice'] = 'LIST INVOICE';
		$data['content'] = $this->load->view('vPertekinvoice',$vdata,TRUE);

		$this->load->view('main',$data);

	}

	function loaddatatablepartinvoice($idsub)
	{
		// print($nopengajuan);
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mpertek->get_list_datadt2($user,'pengajuandt2',$idsub);
		$iTotalRecords  	= count($data);
		$iDisplayLength 	= intval($_REQUEST['length']);
		$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  	= intval($_REQUEST['start']);
		$sEcho				= intval($_REQUEST['draw']);
		$records            = array();
		$records["data"]    = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;
		$fdate = 'd-M-Y';
		for($i = $iDisplayStart; $i < $end; $i++)
		{
			$records["data"][] = array(
				// $data[$i]->id_sub,
				$data[$i]->partno,
				$data[$i]->uraian_barang,
				$data[$i]->satuan
				// 	$act
			);
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}

	function loaddatatablepertekinvoice($idpertek,$kd_kategori)
	{
		// print($nopengajuan);
		
		$pertekHD =$this->mpertek->get_nopertekHD($idpertek);		
		$nopertek = $pertekHD['nopertek'];
		// var_dump($nopertek);
		// exit();
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mpertek->get_list_invoice($user,'pengajuandt2',$nopertek,$kd_kategori);
		$iTotalRecords  	= count($data);
		$iDisplayLength 	= intval($_REQUEST['length']);
		$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  	= intval($_REQUEST['start']);
		$sEcho				= intval($_REQUEST['draw']);
		$records            = array();
		$records["data"]    = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;
		$fdate = 'd-M-Y';
		$kuota_awal = '0';
		for($i = $iDisplayStart; $i < $end; $i++)
		{
			if($kuota_awal ==0)
			{
				$kuota_awal= $data[$i]->kuota;
			}
			else
			{
				$kuota_awal = $kuota_awal;
			}
			// $kuota_awal = $data[$i]->kuota;
			$kuota_awal = $kuota_awal - $data[$i]->qty;
			
			$records["data"][] = array(
				// $data[$i]->id_sub,
				$data[$i]->noinvoice,
				$data[$i]->tgl_invoice,
				$data[$i]->nama_supplier,
				$data[$i]->partno,
				$data[$i]->uraian_barang,
				// $data[$i]->kuota,
				$data[$i]->qty,
				$kuota_awal
				// 	$act
			);
			$kuota_awal = $kuota_awal;
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}

}
