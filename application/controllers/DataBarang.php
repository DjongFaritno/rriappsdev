<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class DataBarang extends FNZ_Controller
{

	public function __construct()
		{
		parent::__construct();
		$this->load->model('mdatabarang');
	  }

	function index()
		{
			$data['title'] = 'Master Data Part';
	    $data['content'] = $this->load->view('vDataBarang',$data,TRUE);
	    $this->load->view('main',$data);
	  }

	function loaddatatable()
		{
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mdatabarang->get_list_data($user,'databarang');
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
						$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->partno.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
					}
					else
					{
						$act = '<a class="btn btn-danger alert-danger btn-xs" href="'.base_url().'DataBarang/delete_barang/'.$data[$i]->partno.'"
						onclick="return confirm(\'anda yakin akan Hapus '.$data[$i]->partno.'?\')"><i class="fa fa-fw fa-trash"></i>Hapus</a> ||
						<a class="btn btn-info alert-info btn-xs  " href="#" onclick="editKeluar(\''.$data[$i]->partno.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
					}

					$records["data"][] = array(
					$data[$i]->partno,
					$data[$i]->uraian_barang,
					$data[$i]->nohs,
					$data[$i]->satuan,
					$act
					);
 			}

		 $records["draw"]            	= $sEcho;
		 $records["recordsTotal"]    	= $iTotalRecords;
		 $records["recordsFiltered"] 	= $iTotalRecords;
		 echo json_encode($records);
		}

	function get_data_barang($partno){

		$partno = urldecode($partno);
    $data 	= $this->mdatabarang->query_data_barang($partno);

		echo json_encode($data);
   }

	 function cekduplicate($partno){
		 $partno = urldecode($partno);
     $data = $this->mdatabarang->query_data_barang($partno);
		 	echo json_encode($data);
	    }

	function ProsesInsert(){
			$partno   			= $this->input->post('partno');
			$uraianbarang 	= $this->input->post('uraianbarang');
			$nohs 					= $this->input->post('nohs');
			$satuan 				= $this->input->post('satuan');
			$action 				= $this->input->post('action');
			$data = array(

				'partno'				=> $partno,
				'uraian_barang' => $uraianbarang,
				'nohs' 					=> $nohs,
				'satuan' 				=> $satuan,

				);
				if($action=="SIMPAN"){// cek apakah add new atau editdata
					//save new
				$this->mdatabarang->insert_barang($data);
			}else{
				//update
			$this->db->where('partno',$partno);
			$this->db->update('ms_barang',$data);
			}
			echo 'true';
		}

		function delete_barang($partno){
				$this->mdatabarang->ProsesDeleteBarang($partno);
			header('location:'.base_url().'databarang');
				}

		function excel_barang(){
				$user = $this->session->userdata('logged_in')['uid'];
				$data = $this->mdatabarang->get_list_data($user,'export-Barang');
		        //load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('MASTER BARANG');
				$this->excel->getActiveSheet()->setCellValue('A1', "MASTER BARANG");
				$this->excel->getActiveSheet()->mergeCells('A1:E1');
				$this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//header
				$this->excel->getActiveSheet()->setCellValue('A3', "No.");
				$this->excel->getActiveSheet()->setCellValue('B3', "partno");
		    $this->excel->getActiveSheet()->setCellValue('C3', "uraianbarang");
				$this->excel->getActiveSheet()->setCellValue('D3', "nohs");
				$this->excel->getActiveSheet()->setCellValue('E3', "satuan");
				$i  	= 4;
				if($data != null){
					foreach($data as $row){

						// $item  	= $row->kode_barang.'-'.$row->nama_barang;
						//
						// $harga = $row->harga;
						// $jumlah = $row->jumlah;
						// $total = $harga*$jumlah;

						$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
						$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->partno);
						$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->uraian_barang);
						$this->excel->getActiveSheet()->setCellValue('D'.$i, $row->nohs);
						$this->excel->getActiveSheet()->setCellValue('E'.$i, $row->satuan);
						$i++;
					}
				}

				for($col = 'A'; $col !== 'E'; $col++) {

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
				$cell_to = "E".$i;
				$this->excel->getActiveSheet()->getStyle('A3:'.$cell_to)->applyFromArray($styleArray);
				$this->excel->getActiveSheet()->getStyle('A1:E3')->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A3:E3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$this->excel->getActiveSheet()->getStyle('A3:E3')->getFill()->getStartColor()->setRGB('BC8F8F');

				$filename='MASTER BARANG.xls'; //save our workbook as this file name
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

			if($this->input->post('cek_s_partno')){

				$s_partno = $this->input->post('txt_s_partno');

				$where .= " partno like '%$s_partno%' ";
			}

			if($this->input->post('cek_s_uraianbarang')){

				$s_uraianbarang= $this->input->post('txt_s_uraianbarang');
				$where .= $where==' '?' ':' AND ';
				$where .= " uraian_barang like '%$s_uraianbarang%' ";
			}

			if($this->input->post('cek_s_nohs')){

				$s_nohs= $this->input->post('txt_s_nohs');
				$where .= $where==' '?' ':' AND ';
				$where .= " nohs like '%$s_nohs%' ";
			}

			if($this->input->post('cek_s_satuan')){

				$s_satuan= $this->input->post('txt_s_satuan');
				$where .= $where==' '?' ':' AND ';
				$where .= " satuan like '%$s_satuan%' ";
			}


			$this->mdatabarang->insert_query($where);
		}

}
