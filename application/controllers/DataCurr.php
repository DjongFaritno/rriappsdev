<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class DataCurr extends FNZ_Controller
{

	public function __construct()
		{
		parent::__construct();
		$this->load->model('mdatacurr');
	  }

	function index()
		{
			$data['title'] = 'Master Data Currency';
	    $data['content'] = $this->load->view('vDatacurr',$data,TRUE);
	    $this->load->view('main',$data);
	  }

	function loaddatatable()
		{
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mdatacurr->get_list_data($user,'datacurr');
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
						$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit" data-toggle="tooltip" title="Chamge Data!" href="#" onclick="editKeluar(\''.$data[$i]->kd_curr.'\')"><i class="fa fa-fw fa-edit"></i></a>';
					}
					else
					{
						$act = '<a class="btn btn-info alert-info btn-xs" data-toggle="tooltip" title="Change Data!" href="#" onclick="editKeluar(\''.$data[$i]->kd_curr.'\')"><i class="fa fa-fw fa-edit"></i></a>
								<a class="btn btn-danger alert-danger btn-xs" data-toggle="tooltip" title="Delete Data!" href="'.base_url().'datacurr/delete_curr/'.$data[$i]->kd_curr.'"
								onclick="return confirm(\'anda yakin akan Hapus '.$data[$i]->kd_curr.'?\')"><i class="fa fa-fw fa-trash"></i></a>';
					}
// print $privilege;
					$records["data"][] = array(
					$data[$i]->kd_curr,
					$data[$i]->nama_curr,
					$act
					);
 			}

		 $records["draw"]            	= $sEcho;
		 $records["recordsTotal"]    	= $iTotalRecords;
		 $records["recordsFiltered"] 	= $iTotalRecords;
		 echo json_encode($records);
		}

	function get_data_curr($kdcurr){
    $data = $this->mdatacurr->query_data_curr($kdcurr);
		echo json_encode($data);
   }

	 function cekduplicate($kdcurr){
     $data = $this->mdatacurr->query_data_curr($kdcurr);
		 	echo json_encode($data);
	    }

	function ProsesInsert(){
			$kdcurr   			= $this->input->post('kdcurr');
			$namacurr 			= $this->input->post('namacurr');
			$action 						= $this->input->post('action');
			$data = array(

				'kd_curr'				=> $kdcurr,
				'nama_curr' 		=> $namacurr,

				);
				if($action=="SIMPAN"){// cek apakah add new atau editdata
					//save new
				$this->mdatacurr->insert_curr($data);
			}else{
				//update
			$this->db->where('kd_curr',$kdcurr);
			$this->db->update('ms_curr',$data);
			}
			echo 'true';
		}

		function delete_curr($kdcurr){
				$this->mdatacurr->ProsesDeletecurr($kdcurr);
			header('location:'.base_url().'datacurr');
				}

		// function excel_curr(){
		// 		$user = $this->session->userdata('logged_in')['uid'];
		// 		$data = $this->mdatacurr->get_list_data($user,'export-curr');
		//         //load our new PHPExcel library
		// 		$this->load->library('excel');
		// 		//activate worksheet number 1
		// 		$this->excel->setActiveSheetIndex(0);
		// 		//name the worksheet
		// 		$this->excel->getActiveSheet()->setTitle('MASTER CURRENCY');
		// 		$this->excel->getActiveSheet()->setCellValue('A1', "MASTER CURRENCY");
		// 		$this->excel->getActiveSheet()->mergeCells('A1:C1');
		// 		$this->excel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// 		//header
		// 		$this->excel->getActiveSheet()->setCellValue('A3', "No");
		// 		$this->excel->getActiveSheet()->setCellValue('B3', "Kode Currency");
		// 		$this->excel->getActiveSheet()->setCellValue('C3', "Nama Currency");
		// 		$i  	= 4;
		// 		if($data != null){
		// 			foreach($data as $row){
		//
		// 				// $item  	= $row->kode_curr.'-'.$row->nama_curr;
		// 				//
		// 				// $harga = $row->harga;
		// 				// $jumlah = $row->jumlah;
		// 				// $total = $harga*$jumlah;
		//
		// 				$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
		// 				$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->kd_curr);
		// 				$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->nama_curr);
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
		// 		$filename='MASTER CURRENCY.xls'; //save our workbook as this file name
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
		// 	if($this->input->post('cek_s_kdcurr')){
		//
		// 		$s_kdcurr = $this->input->post('txt_s_kdcurr');
		//
		// 		$where .= " kd_curr like '%$s_kdcurr%' ";
		// 	}
		//
		// 	if($this->input->post('cek_s_namacurr')){
		//
		// 		$s_namacurr= $this->input->post('txt_s_namacurr');
		//
		// 		$where .= $where==' '?' ':' AND ';
		// 		$where .= " nama_curr like '%".$s_namacurr."%' ";
		// 	}
		// 	$this->mdatacurr->insert_query($where);
		// }
}
