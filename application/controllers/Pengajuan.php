<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends FNZ_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mpengajuan');
	}

	function index()
	{
		$data['title'] = 'LIST PENGAJUAN';
	    $data['content'] = $this->load->view('vPengajuan',$data,TRUE);
	    $this->load->view('main',$data);
	}

	function loaddatatable()
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mpengajuan->get_list_data($user,'pengajuan');
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
				$act = '- || <a class="btn btn-info alert-success btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->idpengajuan.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
				// $act = '<a class="btn bg-black-active color-palette" href="#" <i class="fa fa-fw fa-edit"></i>Sudah dijadikan Pertek</a>  ||
				// <a class="btn btn-info alert-info btn-xs  " href="#" onclick="ViewDt1(\''.$data[$i]->nopengajuan.'\')"><i class="fa fa-fw fa-file-text"></i>Lihat</a>';
			}
			else
			{
				$act = '<div class="btn-group ">
				<button type="button" class="btn btn-danger btn-flat dropdown-toggle btn-xs" data-toggle="dropdown">
				Action<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu" role="menu">
				<li><a href="#" onclick="ViewDt1(\''.$data[$i]->idpengajuan.'\')"><i class="fa fa-fw fa-file-text"> LIHAT</i></a></li>
				<li><a href="#" onclick="Ubah(\''.$data[$i]->idpengajuan.'\',\''.$data[$i]->nopengajuan.'\',\''.$data[$i]->status.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a></li>
				<li><a href="#" onclick="DeletePengajuan(\''.$data[$i]->idpengajuan.'\',\''.$data[$i]->nopengajuan.'\',\''.$data[$i]->status.'\')"><i class="fa fa-fw fa-trash"></i>Hapus</a></li>
				</ul>';
			}

			$records["data"][] = array(
			$data[$i]->nopengajuan,
			$data[$i]->tgl_pengajuan,
			$data[$i]->status,
			$act
			);
		}

		 $records["draw"]            	= $sEcho;
		 $records["recordsTotal"]    	= $iTotalRecords;
		 $records["recordsFiltered"] 	= $iTotalRecords;
		 echo json_encode($records);
	}

	function get_data_pengajuan($nopengajuan)
	{
    	$data = $this->mpengajuan->query_data_pengajuan($nopengajuan);
		echo json_encode($data);
   	}

	function cekduplicate($nopengajuan)
	{
     	$data = $this->mpengajuan->query_data_pengajuan($nopengajuan);
		echo json_encode($data);
	}



		// function excel_pengajuan(){
			// 		$user = $this->session->userdata('logged_in')['uid'];
			// 		$data = $this->mpengajuan->get_list_data($user,'export-pengajuan');
			//         //load our new PHPExcel library
			// 		$this->load->library('excel');
			// 		//activate worksheet number 1
			// 		$this->excel->setActiveSheetIndex(0);
			// 		//name the worksheet
			// 		$this->excel->getActiveSheet()->setTitle('LIST PENGAJUAN');
			// 		$this->excel->getActiveSheet()->setCellValue('A1', "LIST PENGAJUAN");
			// 		$this->excel->getActiveSheet()->mergeCells('A1:C1');
			// 		$this->excel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// 		//header
			// 		$this->excel->getActiveSheet()->setCellValue('A3', "No");
			// 		$this->excel->getActiveSheet()->setCellValue('B3', "No Pengajuan");
			// 		$this->excel->getActiveSheet()->setCellValue('C3', "Tanggal Pengajuan");
			// 		$i  	= 4;
			// 		if($data != null){
			// 			foreach($data as $row){
			//
			// 				// $item  	= $row->nopengajuann.'-'.$row->tgl_pengajuan;
			// 				//
			// 				// $harga = $row->harga;
			// 				// $jumlah = $row->jumlah;
			// 				// $total = $harga*$jumlah;
			//
			// 				$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
			// 				$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->nopengajuan);
			// 				$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->tgl_pengajuan);
			// 				$i++;
			// 			}
			// 		}
			//
			// 		for($col = 'A'; $col !== 'C'; $col++) {
			//
			// 		    $this->excel->getActiveSheet()
			// 		        ->getColumnDimension($col)
			// 		        ->setAutoSize(true);
			// 		}
			//
			// 		$styleArray = array(
			// 		  'borders' => array(
			// 		    'allborders' => array(
			// 		      'style' => PHPExcel_Style_Border::BORDER_THIN
			// 		    )
			// 		  )
			// 		);
			// 		$i = $i-1;
			// 		$cell_to = "C".$i;
			// 		$this->excel->getActiveSheet()->getStyle('A3:'.$cell_to)->applyFromArray($styleArray);
			// 		$this->excel->getActiveSheet()->getStyle('A1:C3')->getFont()->setBold(true);
			// 		$this->excel->getActiveSheet()->getStyle('A3:C3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			// 		$this->excel->getActiveSheet()->getStyle('A3:C3')->getFill()->getStartColor()->setRGB('BC8F8F');
			//
			// 		$filename='LIST PENGAJUAN.xls'; //save our workbook as this file name
			// 		header('Content-Type: application/vnd.ms-excel'); //mime type
			// 		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			// 		header('Cache-Control: max-age=0');//no cache
			//
			// 		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			// 		//if you want to save it as .XLSX Excel 2007 format
			// 		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			// 		//force user to download the Excel file without writing it to server's HD
			// 		$objWriter->save('php://output');
			// 	}

			// function search_query(){
			//
			// 	$where = ' ';
			//
			// 	if($this->input->post('cek_s_nopengajuan')){
			//
			// 		$s_nopengajuan = $this->input->post('txt_s_nopengajuan');
			//
			// 		$where .= " nopengajuan like '%$s_nopengajuan%' ";
			// 	}
			//
			// 	if($this->input->post('cek_s_tgl_pengajuan')){
			//
			// 		$s_tgl_pengajuan= $this->input->post('txt_s_tgl_pengajuan');
			//
			// 		$where .= $where==' '?' ':' AND ';
			// 		$where .= " tgl_pengajuan like '%".$s_tgl_pengajuan."%' ";
			// 	}
			// 	$this->mpengajuan->insert_query($where);
		// }

	//----------------------------------------------------------form ADD PENGAJUAN
	function add_pengajuan()
	{
		//get data kategori
		$kategori = $this->mpengajuan->get_kategori()->result();

		$vdata['opt_item'][NULL] = '-';
		foreach ($kategori as $b) {

			$vdata['opt_item'][$b->kd_kategori."#".$b->nama_kategori]
				=$b->kd_kategori." | ".$b->nama_kategori;
		}

		$vdata['title'] = 'TAMBAH PENGAJUAN';
		$vdata['titledt'] = 'TAMBAH ITEM PENGAJUAN';
		$data['content'] = $this->load->view('vPengajuanbaru',$vdata,TRUE);

		$this->load->view('main',$data);
	}

	function simpan_pengajuan()
	{
		$no_pengajuan  	= $this->input->post('no_pengajuan');
		$tgl			= $this->input->post('tgl_pengajuan');
		$tgl 			= date_parse_from_format("d/m/Y", $tgl);
		$tgl_pengajuan 	= $tgl['year'].'/'.$tgl['month'].'/'.$tgl['day'];
		$item 			= $this->input->post('item');
		$user 			= $this->session->userdata('logged_in')['uid'];
		$header = array(

			'nopengajuan'		=> $no_pengajuan,
			'tgl_pengajuan' 	=> $tgl_pengajuan,
			'user' 						=> $user,
			'status' 					=> 'active'
		);

		$this->mpengajuan->simpan_header($header);
		$item = explode(';',$item);
		foreach ($item as $i) {
				$idetail = explode('#',$i);
				if(count($idetail)>1){

						$detail = array(

							'nopengajuan' 	=> $no_pengajuan,
							'kd_kategori'		=> $idetail[0],
							// $number  = '1.000.000,00';  funsi untuk menghilangkan format ribuan
							// $replaced_number = str_replace(array('.',','), array('',''), $number);
							// echo number_format($replaced_number,2,'.','');
							'kuota'					=> str_replace(array('.',','), array('',''), $idetail[1]),
							'ukuran'				=> $idetail[2],
							'keterangan'		=> $idetail[3]

						);

						$this->mpengajuan->simpan_detail($detail);

				}
		}

		echo "true";
	}


	function delete_pengajuan($idpengajuan){
		$nopengajuan = $this->mpengajuan->get_pengajuanHD($idpengajuan);
		if($nopengajuan != null)
		{
			$nopengajuan = $nopengajuan->nopengajuan;
			$this->mpengajuan->ProsesDeletePengajuan($idpengajuan,$nopengajuan);

			header('location:'.base_url().'pengajuan');
		}
	}


	//----------------------------------------------------------form EDIT PENGAJUAN
	function pengajuanEdit($idpengajuan)
	{
		//get data kategori
		$kategori = $this->mpengajuan->get_kategori()->result();

		$vdata['opt_item'][NULL] = '-';
		foreach ($kategori as $b) 
		{
			$vdata['opt_item'][$b->kd_kategori."#".$b->nama_kategori]
			=$b->kd_kategori." | ".$b->nama_kategori;
		}
		$nopengajuan = $this->mpengajuan->get_pengajuanHD($idpengajuan);
		if($nopengajuan != null)
		{
			$nopengajuan = $nopengajuan->nopengajuan;
			$vdata['nopengajuan']=$this->mpengajuan->get_nopengajuan($nopengajuan);
		}
		$vdata['title'] = 'PENGAJUAN DT1';
		$vdata['titledt'] = 'LIST PENGAJUAN KATEGORI';
		$data['content'] = $this->load->view('vPengajuanEdit',$vdata,TRUE);

		$this->load->view('main',$data);
	}

	function loaddatatableviewedit($idpengajuan,$status)
	{
		$nopengajuan = $this->mpengajuan->get_pengajuanHD($idpengajuan);
		if($nopengajuan != null)
		{
			$nopengajuan = $nopengajuan->nopengajuan;
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mpengajuan->get_list_datadt1($user,'pengajuandt1',$nopengajuan);
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
					$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
				}
				else
				{
					$act = '<a class="btn btn-danger alert-danger btn-xs" href="#" onclick="
					DeleteKategori(\''.$data[$i]->id_sub.'\',\''.$idpengajuan.'\',\''.$data[$i]->kd_kategori.'\')">
					<i class="fa fa-fw fa-trash"></i>Hapus</a>';
				}
				$records["data"][] = array(
					$data[$i]->kd_kategori,
					$data[$i]->nama_kategori,
					// $example = "1234567";
					// $subtotal =  number_format($example, 2, '.', ',');
					// echo $subtotal;
					number_format($data[$i]->kuota, 0, '.', ','),
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

	function cekduplicatekategori($nopengajuan,$kategori){
		$data = $this->mpengajuan->kategori($nopengajuan,$kategori);
		echo json_encode($data);
	}

	function ProsesInsertKategori()
	{
		$nopengajuan   			= $this->input->post('nopengajuan');
		$kategori  			= $this->input->post('kategori');
		$txt_Qty	= $this->input->post('txt_Qty');
		$keterangan	= $this->input->post('keterangan');
		$action 				= $this->input->post('action');
		$data = array(
			'nopengajuan' 		=> $nopengajuan,
			'kd_kategori' 			=> $kategori,
			'kuota' 				=> $txt_Qty,
			'keterangan' 		=> $keterangan,

			);
		if($action=="SIMPAN") // cek apakah add new atau editdata
		{
				//save new
			$this->mpengajuan->simpan_detail($data);
		}
		else
		{
			//update
		$this->db->where('nopengajuan',$nopengajuan);
		$this->db->where('kd_pengajuan',$kategori);
		$this->db->update('pengajuan_dt1',$data);
		}
		echo 'true';
	}

	function updatePengajuan()
	{
		$nopengajuan   			= $this->input->post('nopengajuan');
		$tgl_pengajuan		= $this->input->post('tgl_pengajuan');
		$data = array(
			'tgl_pengajuan' 		=> $tgl_pengajuan,
			);
			//update
		$this->db->where('nopengajuan',$nopengajuan);
		$this->db->update('pengajuan_hd',$data);
		echo 'true';
	}

	//----------------------------------------------------------form view PENGAJUANdt1

	function view_pengajuan($idpengajuan)
	{
		$nopengajuan = $this->mpengajuan->get_pengajuanHD($idpengajuan);

		if($nopengajuan != null)
		{
			$nopengajuan = $nopengajuan->nopengajuan;
			$vdata['nopengajuan']=$this->mpengajuan->get_nopengajuan($nopengajuan);
		}
	
		$vdata['title'] = 'PENGAJUAN DT1';
		$vdata['titledt'] = 'LIST PENGAJUAN KATEGORI';
		$data['content'] = $this->load->view('vPengajuandt1',$vdata,TRUE);

		$this->load->view('main',$data);
	}

	function loaddatatableview($idpengajuan,$status)
	{
		$nopengajuan = $this->mpengajuan->get_pengajuanHD($idpengajuan);

		if($nopengajuan != null)
		{
			$nopengajuan = $nopengajuan->nopengajuan;
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mpengajuan->get_list_datadt1($user,'pengajuandt1',$nopengajuan);
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
					$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
				}
				else
				{
					$act = '<a class="btn btn-info alert-info btn-xs  " href="#" onclick="ViewDt2(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-file-text"></i>List Part</a>';
				}
				$records["data"][] = array(
					$data[$i]->kd_kategori,
					$data[$i]->nama_kategori,
					// $example = "1234567";
					// $subtotal =  number_format($example, 2, '.', ',');
					// echo $subtotal;
					number_format($data[$i]->kuota, 0, '.', ','),
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

	function delete_Sub($idsub)
	{
		$data = $this->mpengajuan->ProsesDeleteSub($idsub);
		echo json_encode($data);
	}

	//----------------------------------------------------------form view PENGAJUANdt2
	function view_pengajuandt2($idsub)
	{
		$vdata['nopengajuandt1']=$this->mpengajuan->get_nopengajuandt1($idsub);

		//get data kategori
		$kategori = $this->mpengajuan->get_barang()->result();

		$vdata['opt_item'][NULL] = '-';
		foreach ($kategori as $b) {

			$vdata['opt_item'][$b->partno."#".$b->uraian_barang."#".$b->nohs."#".$b->satuan]
			=$b->partno." | ".$b->uraian_barang;
		}

		$vdata['title'] = 'PENGAJUAN DT1';
		$vdata['titledt'] = 'LIST PART BARANG';
		$data['content'] = $this->load->view('vPengajuandt2',$vdata,TRUE);

		$this->load->view('main',$data);

	}

	function cekduplicatepart($idsub,$partno)
	{
		$partno = urldecode($partno);
		$idsub = urldecode($idsub);
		$data = $this->mpengajuan->cekbarang($idsub,$partno);
		echo json_encode($data);
	}

	function ProsesInsertPart(){
		$nopengajuan   			= $this->input->post('nopengajuan');
		$partno   			= $this->input->post('partno');
		$idsub 	= $this->input->post('idsub');
		$action 				= $this->input->post('action');
		$data = array(
				'nopengajuan' => $nopengajuan,
				'partno'		=> $partno,
				'id_sub' 		=> $idsub,
		);
		if($action=="SIMPAN")// cek apakah add new atau editdata
		{			
			//save new
			$this->mpengajuan->insert_barang($data);
		}else{
			//update
			$this->db->where('partno',$partno);
			$this->db->update('pengajuan_dt2',$data);
		}
		echo 'true';
	}

	function delete_part($idsub,$partno)
	{
		$data = $this->mpengajuan->ProsesDeletePart($idsub,$partno);
		echo json_encode($data);
	}

	function loaddatatablepart($idsub)
	{
		// print($nopengajuan);
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mpengajuan->get_list_datadt2($user,'pengajuandt2',$idsub);
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
				$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
			}
			else
			{
				$act = '<a class="btn btn-danger alert-danger btn-xs" href="#" onclick="DeletePart(\''.$data[$i]->id_sub.'\',\''.$data[$i]->partno.'\')"><i class="fa fa-fw fa-trash"></i>Hapus</a>';
			}

			$records["data"][] = array(
				$data[$i]->partno,
				$data[$i]->uraian_barang,
				$data[$i]->satuan,
				$act
			);
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}
}
