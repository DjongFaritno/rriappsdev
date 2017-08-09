<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends IO_Controller{

	public function __construct(){

        parent::__construct();
        $this->load->model('penjualan_model');
		$this->load->model('stok_model');
    }

	function index(){

		//clear user query
		$this->penjualan_model->del_query($this->session->userdata('logged_in')['uid']);

		$data['content']    = $this->load->view('vPenjualan',null,TRUE);
      	$data['title']      = 'Data Penjualan';
      	$this->load->view('main',$data);
    }

    function data_baru(){

		$barang = $this->penjualan_model->get_databarang('BJ')->result();

		$vdata['opt_item'][NULL] = '-';
		foreach ($barang as $b) {

			$vdata['opt_item'][$b->kode_barang."#".$b->satuan.'#'.$b->harga]
				=$b->kode_barang." : ".$b->nama_barang." ".$b->tipe." ".$b->model;
		}

		$customer = $this->penjualan_model->get_customer();

		$vdata['opt_cust'][NULL] = '-';
		foreach ($customer as $c) {

			$vdata['opt_cust'][$c->kode_vendor]=$c->kode_vendor.'-'.$c->nama_vendor;
		}

        $data['content']    = $this->load->view('vPenjualanBaru',$vdata,TRUE);
        $data['title']      = 'Tambah Data Penjualan';
        $this->load->view('main',$data);
    }

	function simpan_penjualan(){

		$no_penjualan  	= $this->input->post('kode_jual');
		$tgl 						= $this->input->post('tgl_jual');
		$tgl 						= date_parse_from_format("d/m/Y", $tgl);
		$tgl_penjualan 	= $tgl['year'].'/'.$tgl['month'].'/'.$tgl['day'];
		$kode_cust 			= $this->input->post('kode_cust');
		$nama_cust 			= $this->input->post('nama_cust');
		$no_sj 					= $this->input->post('no_sj');
		$no_kw 					= $this->input->post('no_kw');
		$no_mobil 			= $this->input->post('no_mobil');
		$total 					= $this->input->post('total');
		$item 					= $this->input->post('item');
		$bayar 					= $this->input->post('bayar');
		$user 					= $this->session->userdata('logged_in')['uid'];

		if($no_penjualan==''){

			$no_penjualan	=$this->no_jual_baru();
			$no_sj 			=$this->no_sj_baru();
		}

		$header = array(

			'no_penjualan'		=> $no_penjualan,
			'tgl_penjualan' 	=> $tgl_penjualan,
			'kode_customer' 	=> $kode_cust,
			'nama_customer' 	=> $nama_cust,
			'no_sj'				=> $no_sj,
			'no_kwitansi' 		=> $no_kw,
			'no_kendaraan'		=> $no_mobil,
			'total_harga' 		=> $total,
			'bayar' 			=> $bayar,
			'updater' 			=> $user
		);

		$this->penjualan_model->simpan_header($header);

		$item = explode(';',$item);

		foreach ($item as $i) {

			$idetail = explode('#',$i);

			if(count($idetail)>1){

				$detail = array(

					'no_penjualan' 	=> $no_penjualan,
					'kode_barang'	=> $idetail[0],
					'harga'			=> $idetail[2],
					'jumlah'		=> $idetail[1]
				);

				$this->penjualan_model->simpan_detail($detail);

				//simpan ke table mutasi
				$item_mutasi = array(

					'tgl_mutasi'	=> $tgl_penjualan,
					'kode_barang' 	=> $idetail[0],
					'jumlah'		=> $idetail[1],
					'no_dokumen'	=> $no_penjualan,
					'keterangan'	=> 'Penjualan',
					'tipe'			=> 'o',
					'user'			=> $user
				);

				$this->penjualan_model->simpan_mutasi($item_mutasi)	;
				$this->stok_model->balance_stok($idetail[0],$user);
			}
		}

		//simpan hutang untuk pembelian terhutang
		$ar_hutang = array(

			'no_penjualan' 		=> $no_penjualan,
			'kode_customer' 	=> $kode_cust,
			'nominal'			=> $total
		);

		$this->penjualan_model->save_hutang($ar_hutang);

		echo "true";
	}

	function no_jual_baru(){

		$data_sequence 	= $this->penjualan_model->get_sequence('no_penjualan');
		$tahun_bulan 	= date('ym');

		if($data_sequence==null){

			$no_penjualan = 'J'.$tahun_bulan.'-0001';
		}
		else{

			$no_terakhir 	= $data_sequence->nomor_terakhir;
			$sequence_db 	= substr($no_terakhir,-4);
			$awalan 		= 'J'.$tahun_bulan;


			if(substr($no_terakhir,0,5)==$awalan){

				$akhiran 		= str_pad($sequence_db+1, 4, "0", STR_PAD_LEFT);
				$no_penjualan 	= $awalan.'-'.$akhiran;
			}
			else if(substr($no_terakhir,0,5)!=$awalan){

				$no_penjualan = 'J'.$tahun_bulan.'-0001';
			}
		}

		$this->penjualan_model->update_sequence($no_penjualan,'no_penjualan');

		return $no_penjualan;
	}

	function no_sj_baru(){

		$data_sequence 	= $this->penjualan_model->get_sequence('no_sj');
		$tahun_bulan 	= date('ym');

		if($data_sequence==null){

			$no_sj = 'SJ'.$tahun_bulan.'-0001';
		}
		else{

			$no_terakhir 	= $data_sequence->nomor_terakhir;
			$sequence_db 	= substr($no_terakhir,-4);
			$awalan 		= 'SJ'.$tahun_bulan;


			if(substr($no_terakhir,0,6)==$awalan){

				$akhiran 		= str_pad($sequence_db+1, 4, "0", STR_PAD_LEFT);
				$no_sj 	= $awalan.'-'.$akhiran;
			}
			else if(substr($no_terakhir,0,6)!=$awalan){

				$no_sj = 'SJ'.$tahun_bulan.'-0001';
			}
		}

		$this->penjualan_model->update_sequence($no_sj,'no_sj');

		return $no_sj;
	}

	function load_grid(){

		$user = $this->session->userdata('logged_in')['uid'];

		$data = $this->penjualan_model->get_list_data($user,'penjualan');

		$iTotalRecords  	= count($data);
		$iDisplayLength 	= intval($_REQUEST['length']);
		$iDisplayLength 	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  	= intval($_REQUEST['start']);
		$sEcho				= intval($_REQUEST['draw']);

		$records            = array();
		$records["data"]    = array();

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$fdate 	= 'd-M-Y';
		$priv 	= $this->session->userdata('logged_in')['priv'];

		for($i = $iDisplayStart; $i < $end; $i++) {

			$act = '<a class="btn btn-info btn-xs" href="#" onclick="printSJ(\''.$data[$i]->no_penjualan.'\')">Print SJ</a>&nbsp;';

			if($priv=='A'){

				//$act .= '<a class="btn btn-primary btn-xs" href="#" onclick="editJual(\''.$data[$i]->no_penjualan.'\')">Edit</a>&nbsp;';
				$act .= '<a class="btn btn-danger btn-xs" href="#" onclick="hapusJual(\''.$data[$i]->no_penjualan.'\')">Hapus</a>&nbsp;';
			}

			$bayar = $data[$i]->bayar=='H'?'Terhutang':'Lunas';

		   $records["data"][] = array(

		     	$data[$i]->no_penjualan,
				io_date_format($data[$i]->tgl_penjualan,$fdate),
		     	$data[$i]->nama_customer,
		     	$data[$i]->no_sj,
		     	$data[$i]->no_kwitansi,
		     	$data[$i]->no_kendaraan,
		     	number_format($data[$i]->total_harga,0,",","."),
		     	$bayar,
		      $act
		   );
		}

		$records["draw"]            	= $sEcho;
		$records["recordsTotal"]    	= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;

		echo json_encode($records);
	}

	function delete_jual($no_jual){

		$this->penjualan_model->del_penjualan($no_jual);
		header('location:'.base_url().'penjualan');
	}

	function search_query(){

		$where = ' ';

		if($this->input->post('cek_s_nojual')){

			$s_nojual = $this->input->post('txt_s_nojual');

			$where .= " p.no_penjualan = '$s_nojual' ";
		}

		if($this->input->post('cek_s_tglpenjualan')){

			$tgl1 = date_parse_from_format("d/m/Y",$this->input->post('dtp_s_tgl_penjualan_start'));
			$tgl2	= date_parse_from_format("d/m/Y",$this->input->post('dtp_s_tgl_penjualan_end'));

			$tgl_jual1 = $tgl1['year'].'/'.$tgl1['month'].'/'.$tgl1['day'];
			$tgl_jual2 = $tgl2['year'].'/'.$tgl2['month'].'/'.$tgl2['day'];

			$where .= $where==' '?' ':' AND ';
			$where .= " p.tgl_penjualan BETWEEN '".$tgl_jual1."' AND '$tgl_jual2'";
		}

		if($this->input->post('cek_s_kodecustomer')){

			$skode_cust = $this->input->post('txt_s_kodecustomer');

			$where .= $where==' '?' ':' AND ';
			$where .= " p.kode_customer = '".$skode_cust."'";
		}

		if($this->input->post('cek_s_namacustomer')){

			$snama_cust = $this->input->post('txt_s_namacustomer');

			$where .= $where==' '?' ':' AND ';
			$where .= " p.nama_customer LIKE '%".$snama_cust."%'";
		}

		if($this->input->post('cek_s_nosj')){

			$sno_sj = $this->input->post('txt_s_nosj');

			$where .= $where==' '?' ':' AND ';
			$where .= " p.no_sj = '".$sno_sj."'";
		}

		if($this->input->post('cek_s_nokw')){

			$sno_kw = $this->input->post('txt_s_nokw');

			$where .= $where==' '?' ':' AND ';
			$where .= " p.no_kwitansi = '".$sno_kw."'";
		}

		if($this->input->post('cek_s_statusbayar')){

			$bayar = $this->input->post('radio_bayar');

			$where .= $where==' '?' ':' AND ';
			$where .= " p.bayar = '".$bayar."'";
		}

		$this->penjualan_model->insert_query($where);
	}

	function excel_penjualan(){

		$user = $this->session->userdata('logged_in')['uid'];

		$data = $this->penjualan_model->get_list_data($user,'report-penjualan');

        //load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Report-Penjualan');
		$this->excel->getActiveSheet()->setCellValue('A1', "Report Penjualan");
		$this->excel->getActiveSheet()->mergeCells('A1:L1');

		//header
		$this->excel->getActiveSheet()->setCellValue('A3', "No.");
		$this->excel->getActiveSheet()->setCellValue('B3', "No.Penjualan");
        $this->excel->getActiveSheet()->setCellValue('C3', "Tgl.Penjualan");
		$this->excel->getActiveSheet()->setCellValue('D3', "Customer");
		$this->excel->getActiveSheet()->setCellValue('E3', "No.SJ");
		$this->excel->getActiveSheet()->setCellValue('F3', "No.Kwitansi");
		$this->excel->getActiveSheet()->setCellValue('G3', "No.Kendaraan");
		$this->excel->getActiveSheet()->setCellValue('H3', "Item Barang");
		$this->excel->getActiveSheet()->setCellValue('I3', "Jumlah");
		$this->excel->getActiveSheet()->setCellValue('J3', "Satuan");
		$this->excel->getActiveSheet()->setCellValue('K3', "Harga");
		$this->excel->getActiveSheet()->setCellValue('L3', "Lunas");
        $this->excel->getActiveSheet()->setCellValue('M3', "Terhutang");

        $this->excel->getActiveSheet()->setCellValue('L2', "Total");
        $this->excel->getActiveSheet()->mergeCells('L2:M2');

        $fdate 	= "d-M-Y";
		$i  	= 4;

		if($data != null){

			foreach($data as $row){

				$item  	= $row->kode_barang.'-'.$row->nama_barang;
				$status = $row->bayar=='H'?'Terhutang':'Lunas';

				$this->excel->getActiveSheet()->setCellValue('A'.$i, $i-3);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->no_penjualan);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, io_date_format($row->tgl_penjualan,$fdate));
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $row->nama_customer);
				$this->excel->getActiveSheet()->setCellValue('E'.$i, $row->no_sj);
				$this->excel->getActiveSheet()->setCellValue('F'.$i, $row->no_kwitansi);
				$this->excel->getActiveSheet()->setCellValue('G'.$i, $row->no_kendaraan);
				$this->excel->getActiveSheet()->setCellValue('H'.$i, $item);
				$this->excel->getActiveSheet()->setCellValue('I'.$i, $row->jumlah);
				$this->excel->getActiveSheet()->setCellValue('J'.$i, $row->satuan);
				$this->excel->getActiveSheet()->setCellValue('K'.$i, $row->harga);

				if($status=='Terhutang'){

					$this->excel->getActiveSheet()->setCellValue('M'.$i, $row->subtotal);
				}
				else{

					$this->excel->getActiveSheet()->setCellValue('L'.$i, $row->subtotal);
				}

				$i++;
			}
		}

		$rowsum = $i-1;

		$this->excel->getActiveSheet()->setCellValue('L'.$i,'=SUM(L4:L'.$rowsum.')');
		$this->excel->getActiveSheet()->setCellValue('M'.$i,'=SUM(M4:M'.$rowsum.')');

		$this->excel->getActiveSheet()->setCellValue('A'.$i, 'TOTAL');
		$this->excel->getActiveSheet()->mergeCells('A'.$i.':K'.$i);
    	$this->excel->getActiveSheet()->getStyle('A'.$i)->
    		getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$i++;

		for($col = 'A'; $col !== 'M'; $col++) {

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
		$cell_to = "M".$i;
		$this->excel->getActiveSheet()->getStyle('A3:'.$cell_to)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3:M3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('A3:M3')->getFill()->getStartColor()->setRGB('BC8F8F');

		//field total lunas & hutang
		$this->excel->getActiveSheet()->getStyle('K2:M2')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('K2:M2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('K2:M2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('K2:M2')->getFill()->getStartColor()->setRGB('BC8F8F');
		$this->excel->getActiveSheet()->getStyle('K2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// $filename='report-penjualan.xls'; //save our workbook as this file name
		// header('Content-Type: application/vnd.ms-excel'); //mime type
		// header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		// header('Cache-Control: max-age=0');//no cache
		//
		// //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		// //if you want to save it as .XLSX Excel 2007 format
		// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		// //force user to download the Excel file without writing it to server's HD
		// $objWriter->save('php://output');

		$filename='format-penjualan.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');//no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	function printSJ($str){

		$no_jual = base64_decode($str);

		$this->load->library("pdf");

		$data['data'] = $this->penjualan_model->get_penjualan_detail($no_jual)->result();

		// print_r($data);
		// exit();

		// echo $this->load->view('print_sj',$data,true);
		// exit();

		$this->pdf->load_view('print_sj',$data);
		$this->pdf->set_paper("A5", "landscape");
		$this->pdf->render();
		$this->pdf->stream("name-file.pdf",array("Attachment"=>0));
	}

	function get_encrypt(){

		$str = $this->input->post('str');
		echo base64_encode($str);
	}
}
