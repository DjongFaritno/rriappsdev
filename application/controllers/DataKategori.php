<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class DataKategori extends FNZ_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mdatakategori');
	}

	function index()
	{
		$data['title'] = 'Master Data Kategori';
	    $data['content'] = $this->load->view('vDatakategori',$data,TRUE);
	    $this->load->view('main',$data);
	}

	function loaddatatable()
	{
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mdatakategori->get_list_data($user,'datakategori');
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
				$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->kd_kategori.'\')"><i class="fa fa-fw fa-edit"></i></a>';
			}
			else
			{
				$act = '<a class="btn btn-info alert-info btn-xs  " href="#" data-toggle="tooltip" title="Edit Data!" onclick="editKeluar(\''.$data[$i]->kd_kategori.'\')"><i class="fa fa-fw fa-edit"></i></a> 
						<a class="btn btn-danger alert-danger btn-xs" data-toggle="tooltip" title="Delete Data!" href="'.base_url().'DataKategori/delete_kategori/'.$data[$i]->kd_kategori.'"
						onclick="return confirm(\'anda yakin akan Hapus '.$data[$i]->kd_kategori.'?\')"><i class="fa fa-fw fa-trash"></i></a>';
			}
// print $privilege;
			$records["data"][] = array(
			$data[$i]->kd_kategori,
			$data[$i]->nama_kategori,
			$act
			);
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}

	function get_data_kategori($kdkategori){
    	$data = $this->mdatakategori->query_data_kategori($kdkategori);
		echo json_encode($data);
   	}

	 function cekduplicate($kdkategori){
     	$data = $this->mdatakategori->query_data_kategori($kdkategori);
		echo json_encode($data);
	}

	function ProsesInsert(){
		$kdkategori   			= $this->input->post('kdkategori');
		$namakategori 			= $this->input->post('namakategori');
		$action 						= $this->input->post('action');
		$data = array(

			'kd_kategori'				=> $kdkategori,
			'nama_kategori' 		=> $namakategori,

		);
		if($action=="SIMPAN"){// cek apakah add new atau editdata
			//save new
			$this->mdatakategori->insert_kategori($data);
		}else{
			//update
			$this->db->where('kd_kategori',$kdkategori);
			$this->db->update('ms_kategori',$data);
		}
		echo 'true';
	}

	function delete_kategori($kdkategori){
		$this->mdatakategori->ProsesDeletekategori($kdkategori);
		header('location:'.base_url().'datakategori');
	}

	function excel_kategori(){
		$user = $this->session->userdata('logged_in')['uid'];
		$data = $this->mdatakategori->get_list_data($user,'export-kategori');
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('MASTER KATEGORI');
		$this->excel->getActiveSheet()->setCellValue('A1', "MASTER KATEGORI");
		$this->excel->getActiveSheet()->mergeCells('A1:C1');
		$this->excel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//header
		$this->excel->getActiveSheet()->setCellValue('A3', "No");
		$this->excel->getActiveSheet()->setCellValue('B3', "Kode kategori");
		$this->excel->getActiveSheet()->setCellValue('C3', "Nama kategori");
		$i  	= 4;
		if($data != null){
			foreach($data as $row){

				// $item  	= $row->kode_kategori.'-'.$row->nama_kategori;
				//
				// $harga = $row->harga;
				// $jumlah = $row->jumlah;
				// $total = $harga*$jumlah;

				$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->kd_kategori);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->nama_kategori);
				$i++;
			}
		}

		for($col = 'A'; $col !== 'C'; $col++) {

			$this->excel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
		}

		$styleArray = array(
			'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
		);
		$i = $i-1;
		$cell_to = "C".$i;
		$this->excel->getActiveSheet()->getStyle('A3:'.$cell_to)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('A1:C3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3:C3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('A3:C3')->getFill()->getStartColor()->setRGB('BC8F8F');

		$filename='MASTER KATEGORI.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');//no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	function search_query(){
		$where = ' ';

		if($this->input->post('cek_s_kdkategori')){

			$s_kdkategori = $this->input->post('txt_s_kdkategori');

			$where .= " kd_kategori like '%$s_kdkategori%' ";
		}

		if($this->input->post('cek_s_namakategori')){

			$s_namakategori= $this->input->post('txt_s_namakategori');

			$where .= $where==' '?' ':' AND ';
			$where .= " nama_kategori like '%".$s_namakategori."%' ";
		}
		$this->mdatakategori->insert_query($where);
	}
}
