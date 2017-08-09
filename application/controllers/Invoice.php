<?php
// <!-- بسم الله الرحمن الرحیم -->
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice extends FNZ_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('Excel','PHPExcel/IOFactory'));
    $this->load->model('minvoice');
  }

  function index()
  {
    //delete semua eimporthd & dt
    $user = $this->session->userdata('logged_in')['uid'];
    $noinvoice = $this->minvoice->get_invoiceeimport($user);
      if($noinvoice != null)
      {
      $noinvoice = $noinvoice->noinvoice;
      $this->minvoice->deleteeimportdt($noinvoice);
      $this->minvoice->deleteeimporthd($user);
      }

    //get Supplier
    $supplier = $this->minvoice->get_Supplier()->result();

    $vdata['opt_item'][NULL] = '-';
    foreach ($supplier as $b) {

      $vdata['opt_item'][$b->kd_supplier."#".$b->nama_supplier]
        =$b->kd_supplier." | ".$b->nama_supplier;
    }
    $vdata['title'] = 'DATA INVOICE';
    $vdata['modaltitle'] = 'UNGGAH INVOICE';
    $data['content'] = $this->load->view('vInvoice',$vdata,TRUE);
    $this->load->view('main',$data);
  }

  function loaddatatable()
    {
      $user = $this->session->userdata('logged_in')['uid'];
      $data = $this->minvoice->get_list_data($user,'invoice');
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
            $act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="VinvoiceDT(\''.$data[$i]->idinvoicehd.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
          }
          else
          {
            $act = '<a class="btn btn-danger alert-danger btn-xs" href="#" onclick="HapusInvoice(\''.$data[$i]->idinvoicehd.'\',\''.$data[$i]->noinvoice.'\')"><i class="fa fa-fw fa-trash"></i>Hapus</a>';
          }

          $noinvoice = '<i class="fa fa-fw fa-file-text"></i><a href="#" onclick="VinvoiceDT(\''.$data[$i]->idinvoicehd.'\',\''.$data[$i]->noinvoice.'\')">'.$data[$i]->noinvoice.'</a>';
          $supplier = $data[$i]->kd_supplier.'-'.$data[$i]->nama_supplier;
          $records["data"][] = array(
          $noinvoice,
          $data[$i]->tgl_invoice,
          $data[$i]->noaju,
          $data[$i]->tgl_aju,
          $supplier,
          $data[$i]->pelabuhan_muat,
          $data[$i]->negara_asal,
          $data[$i]->nodaftar_pib,
          $data[$i]->tgldaftar_pib,
          $act
          );
      }

     $records["draw"]            	= $sEcho;
     $records["recordsTotal"]    	= $iTotalRecords;
     $records["recordsFiltered"] 	= $iTotalRecords;
     echo json_encode($records);
    }

  function HapusInvoice($idinvoicehd){
    $noinvoice = $this->minvoice->get_invoiceHD($idinvoicehd);

        if($noinvoice != null)
      {
          $noinvoice = $noinvoice->noinvoice;
			    $this->minvoice->ProsesDeleteInvoice($idinvoicehd,$noinvoice);
          //restock harusnya:D
	    }
  }

  function upload(){
    $noinvoice  	= $this->input->post('noinvoice');
    $user = $this->session->userdata('logged_in')['uid'];
    $item 			= $this->input->post('opt_item');
    $idetail = explode('#',$item);
    // $file  	= $this->input->post('file');
    $tgl_pengajuan			= $this->input->post('tglinvoice');
		// $tgl 			= date_parse_from_format("d/m/Y", $tgl);
		// $tgl_pengajuan 	= $tgl['year'].'/'.$tgl['month'].'/'.$tgl['day'];
    $fileName = time().$_FILES['file']['name'];
    // $fileName = $this->input->post('file', TRUE);
    $config['upload_path'] = './assets/invoices/';//nama folder
    $config['file_name'] = $fileName;
    $config['allowed_types'] = 'xls|xlsx|csv';
    $config['max_size'] = 10000;

    //  $this->load->library('upload');
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if(! $this->upload->do_upload('file') )
    $this->upload->display_errors();

    //  $media = $this->upload->data('file');
    $media = $this->upload->data();
    //  $inputFileName = './assets/invoices/'.$fileName;
    $inputFileName = './assets/invoices/'.$media['file_name'];

    try {
      $inputFileType = IOFactory::identify($inputFileName);
      $objReader = IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    for ($row = 4; $row <= $highestRow; $row++){                  //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                       NULL,
                                       TRUE,
                                       FALSE);
        //data header
        $datahd = array(
          "noinvoice" => $noinvoice,
          "tglinvoice"=> $tgl_pengajuan,
          "kd_supplier"=> $idetail[0],
          "userid" => $user
       );
       //data detail
        if($rowData[0][0] !=""){
         $datadt = array(
           "noinvoice" => $noinvoice,
            "partno"=> $rowData[0][0],
            "qty"=> $rowData[0][1],
            "unit_price"=> $rowData[0][2],
           "kd_curr"=> $rowData[0][3]
         );
         //savehd
        $this->minvoice->sveimporthd($datahd);
         //save DT
        $this->minvoice->sveimportdt($datadt);
        } //end if
    }
    //  var_dump($datahd);
    //  var_dump($datadt);
    //  return FALSE;
    $this->session->set_flashdata('msg','Berhasil upload ...!!');
    unlink($inputFileName);
    redirect('invoice/cekkuota/');
  }

  function cekkuota()
  {
    $user = $this->session->userdata('logged_in')['uid'];
    //get data eimport
    $vdata['eimporthd']=$this->minvoice->GetDataEimportHD($user);
    // var_dump($vdata);
    // return false
    $vdata['title'] = 'CEK KUOTA';
    $data['content'] = $this->load->view('vinvoicecekkuota',$vdata,TRUE);
    $this->load->view('main',$data);
  }

  function LoadTableEimport($idnoinvoice)
   {
     // print($nopengajuan);
     $user = $this->session->userdata('logged_in')['uid'];
     $noinvoice = $this->minvoice->get_invoiceeimportHD($idnoinvoice);
         if($noinvoice != null)
       {
           $noinvoice = $noinvoice->noinvoice;

           $data = $this->minvoice->GetDataEimport($user,'cekkuota',$noinvoice);
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
               $id_sub= $data[$i]->id_sub;
               $sum = $this->minvoice->getsum($id_sub, $noinvoice);
               $qtykirim = $sum->qtykirim;
               // var_dump($qtykirim);
               // return false;
              //  $qtyinvoice=$sum->qtykirim;

                 $privilege = $this->session->userdata('logged_in')['priv'];
                 if ($privilege=='OPERATOR')//jika sebagai operator, maka tidak bisa hapus data
               {
                 $act = '- || <a class="btn btn-info alert-info btn-xs fa-edit " href="#" onclick="editKeluar(\''.$data[$i]->id_sub.'\')"><i class="fa fa-fw fa-edit"></i>Ubah</a>';
               }
               else
               {
                 $act = '<a class="btn btn-danger alert-danger btn-xs" href="#" onclick="DeletePart(\''.$data[$i]->noinvoice.'\',\''.$data[$i]->partno.'\')"><i class="fa fa-fw fa-trash"></i>Hapus</a> ||
                 <a class="btn btn-info alert-info btn-xs  " href="#" onclick="UbahPartno(\''.$data[$i]->noinvoice.'\',\''.$data[$i]->partno.'\')"><i class="fa fa-fw fa-file-text"></i>Ubah</a>';
               }
              //  {
              //    $act = '<a class="btn btn-danger alert-danger btn-xs" href="#" onclick="DeletePart(\''.$data[$i]->partno.'\',\''.$data[$i]->partno.'\')"><i class="fa fa-fw fa-trash"></i>Hapus</a>';
              //  }
                if($data[$i]->nopertek !=""){
                  $partno = '<div align="center" style="width: 100%">'.$data[$i]->partno.'</div>';
                  $qty = '<div align="center" style="width: 100%">'.number_format($data[$i]->qty, 0, '.', ',').'</div>';
                  $nopertek = '<div align="center" style="width: 100%">'.$data[$i]->nopertek.'</div>';
                  $kategori = '<div align="center" style="width: 100%">'.$data[$i]->kd_kategori.'</div>';
                  $persen =  ($qtykirim / $data[$i]->kuota) * 100;
                  // $kuota = $data[$i]->kuota;
                  if((int)$data[$i]->kuota === (int)$qtykirim){
                  $kuota = '<div class="progress"><div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="'.$persen.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$persen.'%"><font color="#000">'.number_format($data[$i]->kuota, 0, '.', ',').'</font></div></div>';
                  }else{
                  $kuota = '<div class="progress"><div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="'.$persen.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$persen.'%"><font color="#000">'.number_format($data[$i]->kuota, 0, '.', ',').'</font></div></div>';
                  }
                  $totalkuotakirim = $qtykirim;
                  $totalkuotakirim = '<div align="center" style="width: 100%">'.number_format($totalkuotakirim, 0, '.', ',').'</div>';
                  if((int)$data[$i]->kuota < (int)$qtykirim){
                      $kuota = '<div class="progress"><div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="'.$persen.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$persen.'%"><font color="#000">'.number_format($data[$i]->kuota, 0, '.', ',').'</font></div></div>';
                    $sisakuota = (int)$data[$i]->kuota - (int)$qtykirim;
                    $sisakuota = number_format($sisakuota, 0, '.', ',');
                    $sisakuota = '<div class="progress"><div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="50" style="width:100%">'.$sisakuota.'</div></div>';
                  }else{
                    $sisakuota = (int)$data[$i]->kuota - (int)$qtykirim;
                    $sisakuota = '<div align="center">'.number_format($sisakuota, 0, '.', ',').'</div>';
                  }

               }else{
                 $partno = '<div align="center" style="width: 100%">'.$data[$i]->partno.'</div>';
                 $qty = '<div align="center" style="width: 100%">'.number_format($data[$i]->qty, 0, '.', ',').'</div>';
                 $nopertek ='<div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">PART TIDAK ADA DI PERTEK AKTIF</div></div>';
                 $kategori = '<div align="center" style="width: 100%">-</div>';
                 $kuota = '<div align="center" style="width: 100%">-</div>';
                 $totalkuotakirim = '<div align="center" style="width: 100%">-</div>';
                 $sisakuota = '<div align="center" style="width: 100%">-</div>';
               }

               $records["data"][] = array(
                 $partno,
                 $qty,
                 $totalkuotakirim,
                 $nopertek,
                 $kategori,
                 $kuota,
                 $sisakuota
               );
           }

          $records["draw"]            	= $sEcho;
          $records["recordsTotal"]    	= $iTotalRecords;
          $records["recordsFiltered"] 	= $iTotalRecords;
          echo json_encode($records);
      }
   }

   function SaveEimportToinvoice(){

     $idinvoicehd       = $this->input->post('idinvoicehd');
     $noinvoice         = $this->input->post('noinvoice');
     $kd_supplier       = $this->input->post('kd_supplier');
     $kd_supplier = explode('-',$kd_supplier);
     $tgl_invoice       = $this->input->post('tgl_invoice');
      //  $tgl 			= date_parse_from_format("d/m/Y", $tgl);
      //  $tgl_pengajuan 	= $tgl['year'].'/'.$tgl['month'].'/'.$tgl['day'];
     $nodaftar_pib      = $this->input->post('nodaftar_pib');
     $tgldaftar_pib     = $this->input->post('tgldaftar_pib');
      //  $tgl 			= date_parse_from_format("d/m/Y", $tgl);
      //  $tgl_pengajuan 	= $tgl['year'].'/'.$tgl['month'].'/'.$tgl['day'];
     $noaju             = $this->input->post('noaju');
     $tgl_aju           = $this->input->post('tgl_aju');
     $negara_asal       = $this->input->post('negara_asal');
     $pelabuhan_muat    = $this->input->post('pelabuhan_muat');
     $user 			        = $this->session->userdata('logged_in')['uid'];

     $header = array(

      //  'idinvoicehd'		=> $idinvoicehd,
       'noinvoice'		  => $noinvoice,
       'kd_supplier'		=> $kd_supplier[0],
       'tgl_invoice'		=> $tgl_invoice,
       'nodaftar_pib'		=> $nodaftar_pib,
       'tgldaftar_pib'	=> $tgldaftar_pib,
       'noaju'		      => $noaju,
       'tgl_aju'		    => $tgl_aju,
       'negara_asal'		=> $negara_asal,
       'pelabuhan_muat'	=> $pelabuhan_muat,
       'userid' 						=> $user,
     );
     //save header
     $this->minvoice->svInvoiceHD($header);
     //save DT
     $this->minvoice->svInvoiceDT($noinvoice);
        // header('location:'.base_url().'invoice');
        echo "true";
   }

   							//----------------------------------------------------------form view Invoice Detail
  function invoicedt($idinvoicehd)
			{
				$vdata['invoiceHD']=$this->minvoice->get_invoiceHeader($idinvoicehd);
		    $vdata['title'] = 'INVOICE DETAIL';
				$vdata['titledt'] = 'INVOICE DETAIL';
				$data['content'] = $this->load->view('vInvoiceDT',$vdata,TRUE);

				$this->load->view('main',$data);
			}

  function loaddatatable_invoicedt($idinvoicehd)
    {

      $user = $this->session->userdata('logged_in')['uid'];
     $noinvoice = $this->minvoice->get_invoicehd($idinvoicehd);
         if($noinvoice != null)
       {
           $noinvoice = $noinvoice->noinvoice;
           $data = $this->minvoice->get_invoicedt($user,'invoicedt',$noinvoice);
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
          $data[$i]->partno,
          $data[$i]->qty,
          $data[$i]->unit_price,
          $data[$i]->kd_curr
          // ,
          // $act
          );
      }

     $records["draw"]            	= $sEcho;
     $records["recordsTotal"]    	= $iTotalRecords;
     $records["recordsFiltered"] 	= $iTotalRecords;
     echo json_encode($records);
    }
  }

}
