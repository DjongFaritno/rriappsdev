<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class DataSupplier extends FNZ_Controller
{

	public function __construct()
		{
		parent::__construct();
		$this->load->model('mdatasupplier');
	  }

	function index()
		{
			$data['title'] = 'Master Data Supplier';
	    $data['content'] = $this->load->view('vDataSupplier',$data,TRUE);
	    $this->load->view('main',$data);
	  }

	function loaddatatable()
		{
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mdatasupplier->get_list_data($user,'datasupplier');
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
						$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->kd_supplier.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
					}
					else
					{
						$act = '<a class="btn btn-danger alert-danger btn-xs" href="'.base_url().'DataSupplier/delete_supplier/'.$data[$i]->kd_supplier.'"
						onclick="return confirm(\'anda yakin akan Hapus '.$data[$i]->kd_supplier.'?\')"><i class="fa fa-fw fa-trash"></i>Hapus</a> ||
						<a class="btn btn-info alert-info btn-xs  " href="#" onclick="editKeluar(\''.$data[$i]->kd_supplier.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
					}
// print $privilege;
					$records["data"][] = array(
					$data[$i]->kd_supplier,
					$data[$i]->nama_supplier,
					$act
					);
 			}

		 $records["draw"]            	= $sEcho;
		 $records["recordsTotal"]    	= $iTotalRecords;
		 $records["recordsFiltered"] 	= $iTotalRecords;
		 echo json_encode($records);
		}

	function get_data_supplier($kdsupplier){
    $data = $this->mdatasupplier->query_data_supplier($kdsupplier);
		echo json_encode($data);
   }

	 function cekduplicate($kdsupplier){
     $data = $this->mdatasupplier->query_data_supplier($kdsupplier);
		 	echo json_encode($data);
	    }

	function ProsesInsert(){
			$kdsupplier   			= $this->input->post('kdsupplier');
			$namasupplier 			= $this->input->post('namasupplier');
			$action 						= $this->input->post('action');
			$data = array(

				'kd_supplier'				=> $kdsupplier,
				'nama_supplier' 		=> $namasupplier,

				);
				if($action=="SIMPAN"){// cek apakah add new atau editdata
					//save new
				$this->mdatasupplier->insert_supplier($data);
			}else{
				//update
			$this->db->where('kd_supplier',$kdsupplier);
			$this->db->update('ms_supplier',$data);
			}
			echo 'true';
		}

		function delete_supplier($kdsupplier){
				$this->mdatasupplier->ProsesDeletesupplier($kdsupplier);
			header('location:'.base_url().'datasupplier');
				}

		function excel_supplier(){
				$user = $this->session->userdata('logged_in')['uid'];
				$data = $this->mdatasupplier->get_list_data($user,'export-supplier');
		        //load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('MASTER SUPPLIER');
				$this->excel->getActiveSheet()->setCellValue('A1', "MASTER SUPPLIER");
				$this->excel->getActiveSheet()->mergeCells('A1:C1');
				$this->excel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//header
				$this->excel->getActiveSheet()->setCellValue('A3', "No");
				$this->excel->getActiveSheet()->setCellValue('B3', "Kode Supplier");
				$this->excel->getActiveSheet()->setCellValue('C3', "Nama Supplier");
				$i  	= 4;
				if($data != null){
					foreach($data as $row){

						// $item  	= $row->kode_supplier.'-'.$row->nama_supplier;
						//
						// $harga = $row->harga;
						// $jumlah = $row->jumlah;
						// $total = $harga*$jumlah;

						$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
						$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->kd_supplier);
						$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->nama_supplier);
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

				$filename='MASTER SUPPLIER.xls'; //save our workbook as this file name
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

			if($this->input->post('cek_s_kdsupplier')){

				$s_kdsupplier = $this->input->post('txt_s_kdsupplier');

				$where .= " kd_supplier like '%$s_kdsupplier%' ";
			}

			if($this->input->post('cek_s_namasupplier')){

				$s_namasupplier= $this->input->post('txt_s_namasupplier');

				$where .= $where==' '?' ':' AND ';
				$where .= " nama_supplier like '%".$s_namasupplier."%' ";
			}
			$this->mdatasupplier->insert_query($where);
		}
}
