<?php
// <!-- بسم الله الرحمن الرحیم -->

defined('BASEPATH') OR exit('No direct script access allowed');

class DataUser extends FNZ_Controller
{

	public function __construct()
		{
		parent::__construct();
		$this->load->model('mdatauser');
	  }

	function index()
		{
			$data['title'] = 'Master Data User';
	    $data['content'] = $this->load->view('vDataUser',$data,TRUE);
	    $this->load->view('main',$data);
	  }

	function loaddatatable()
		{
			$user = $this->session->userdata('logged_in')['uid'];
			$data = $this->mdatauser->get_list_data($user,'datauser');
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
						$act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->username.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
					}
					else
					{
						$act = '<a class="btn btn-info alert-info btn-xs" href="#" data-toggle="tooltip" title="Change Data!" onclick="editKeluar(\''.$data[$i]->username.'\')"><i class="fa fa-fw fa-edit"></i></a> ||
								<a class="btn bg-navy btn-xs" href="#" data-toggle="tooltip" title="Change Password!" onclick="ResetPassword(\''.$data[$i]->username.'\')"><i class="fa fa-fw fa-unlock-alt"></i></a> ||
								<a class="btn btn-danger alert-danger btn-xs" data-toggle="tooltip" title="Delete Data!" href="'.base_url().'datauser/delete_user/'.$data[$i]->username.'"
								onclick="return confirm(\'anda yakin akan Hapus '.$data[$i]->username.'?\')"><i class="fa fa-fw fa-trash"></i></a>' ;
					}

					$records["data"][] = array(
					$data[$i]->username,
					$data[$i]->full_name,
					$data[$i]->email,
					$data[$i]->privilege,
					// $data[$i]->password,
					$act
					);
 			}

		 $records["draw"]            	= $sEcho;
		 $records["recordsTotal"]    	= $iTotalRecords;
		 $records["recordsFiltered"] 	= $iTotalRecords;
		 echo json_encode($records);
		}

	function get_data_user($username){
    $data = $this->mdatauser->query_data_user($username);
		echo json_encode($data);
   }

	 function cekduplicate($username){
     $data = $this->mdatauser->query_data_user($username);
		 	echo json_encode($data);
	    }

	function ProsesInsert(){
			$username   = $this->input->post('username');
			$fullname 	= $this->input->post('fullname');
			$email 			= $this->input->post('email');
			$privilege 	= $this->input->post('privilege');
			$pwd 	= $this->input->post('password');
			$password 	= substr(md5($pwd),0,15);
			$action 		= $this->input->post('action');
			$data = array(

				'username'				=> $username,
				'full_name' 			=> $fullname,
				'privilege' 			=> $privilege,
				'email' 				=> $email,
				'password' 				=> $password,

				);
		// 		print ($action);
		// return false;
				if($action=="SIMPAN"){// cek apakah add new atau editdata
					//save new
				$this->mdatauser->insert_user($data);
			}else	if($action=="RESETPASSWORD"){
				//update password saja
				$data = array(

					'username'				=> $username,
					// 'full_name' 		=> $fullname,
					// 'privilege' 		=> $privilege,
					// 'email' 				=> $email,
					'password' 				=> $password,

					);
			$this->db->where('username',$username);
			$this->db->update('ms_user',$data);
			}else{
				//update
				$data = array(

					'username'			=> $username,
					'full_name' 		=> $fullname,
					'privilege' 		=> $privilege,
					'email' 				=> $email,
					// 'password' 			=> $password,

					);
			$this->db->where('username',$username);
			$this->db->update('ms_user',$data);
			}

			echo 'true';
		}

		function delete_user($username){
				$this->mdatauser->ProsesDeleteUser($username);
			header('location:'.base_url().'datauser');
				}

		// function excel_user(){
		// 		$user = $this->session->userdata('logged_in')['uid'];
		// 		$data = $this->mdatauser->get_list_data($user,'export-User');
		//         //load our new PHPExcel library
		// 		$this->load->library('excel');
		// 		//activate worksheet number 1
		// 		$this->excel->setActiveSheetIndex(0);
		// 		//name the worksheet
		// 		$this->excel->getActiveSheet()->setTitle('MASTER USER');
		// 		$this->excel->getActiveSheet()->setCellValue('A1', "MASTER USER");
		// 		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		// 		$this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// 		//header
		// 		$this->excel->getActiveSheet()->setCellValue('A3', "No.");
		// 		$this->excel->getActiveSheet()->setCellValue('B3', "partno");
		//     $this->excel->getActiveSheet()->setCellValue('C3', "uraianuser");
		// 		$this->excel->getActiveSheet()->setCellValue('D3', "nohs");
		// 		$this->excel->getActiveSheet()->setCellValue('E3', "satuan");
		// 		$i  	= 4;
		// 		if($data != null){
		// 			foreach($data as $row){
		//
		// 				// $item  	= $row->kode_user.'-'.$row->nama_user;
		// 				//
		// 				// $harga = $row->harga;
		// 				// $jumlah = $row->jumlah;
		// 				// $total = $harga*$jumlah;
		//
		// 				$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
		// 				$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->partno);
		// 				$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->uraian_user);
		// 				$this->excel->getActiveSheet()->setCellValue('D'.$i, $row->nohs);
		// 				$this->excel->getActiveSheet()->setCellValue('E'.$i, $row->satuan);
		// 				$i++;
		// 			}
		// 		}
		//
		// 		for($col = 'A'; $col !== 'E'; $col++) {
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
		// 		$cell_to = "E".$i;
		// 		$this->excel->getActiveSheet()->getStyle('A3:'.$cell_to)->applyFromArray($styleArray);
		// 		$this->excel->getActiveSheet()->getStyle('A1:E3')->getFont()->setBold(true);
		// 		$this->excel->getActiveSheet()->getStyle('A3:E3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		// 		$this->excel->getActiveSheet()->getStyle('A3:E3')->getFill()->getStartColor()->setRGB('BC8F8F');
		//
		// 		$filename='MASTER USER.xls'; //save our workbook as this file name
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

		function search_query(){

			$where = ' ';

			if($this->input->post('cek_s_partno')){

				$s_partno = $this->input->post('txt_s_partno');

				$where .= " partno like '%$s_partno%' ";
			}

			if($this->input->post('cek_s_uraianuser')){

				$s_uraianuser= $this->input->post('txt_s_uraianuser');
				$where .= $where==' '?' ':' AND ';
				$where .= " uraian_user like '%$s_uraianuser%' ";
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


			$this->mdatauser->insert_query($where);
		}

}
