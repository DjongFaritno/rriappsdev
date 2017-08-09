<!-- بسم الله الرحمن الرحیم -->

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<style type="text/css">th{ text-align: center; } .datepicker{z-index:1151 !important;}</style>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/gen_validatorv4.js"></script>
<script src="<?php echo base_url(); ?>assets/script/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vinvoicedt.js"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
</script>
<!-- Main content -->
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">LIST INVOICE</b></h3>
				  <div class="box-tools">
						<div class="btn-group pull-left">
								<button type="button" class="btn btn-sm btn-default" onclick="Backtoinvoice()">
							<i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button>
	                      <!-- <button type="button" class="btn btn-sm btn-warning" onclick="modalSearch()">
	                    <i class="glyphicon glyphicon-search"></i>&nbsp;CARI</button>
	                <button type="button" class="btn btn-success btn-sm" onclick="excelData()">
	                    <i class="fa fa-fw fa-file-excel-o"></i>&nbsp;EXCEL</button> -->
	                  <!-- <button type="button" class="btn btn-danger btn-sm" id="btn_del_pengajuan" onclick="DeletePengajuan()">
	                  <i class="glyphicon glyphicon-trash"></i><b>&nbsp;HAPUS PENGAJUAN NO <?php echo $nopengajuan['nopengajuan']; ?></b></button> -->
										</div>
									</div>
				</div>
				<!-- box body header -->
				<div class="box-body">
					<div class="row">
						<input type="text" id="txt_noinvoice" hidden="true" value="<?php echo $invoiceHD['idinvoicehd']?>">
					</div>
         <div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">No Invoice</label>
														<div class="col-md-5">
																: <?php echo $invoiceHD['noinvoice']?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">No Daftar PIB</label>
													<div class="col-md-5">
													: <?php echo $invoiceHD['nodaftar_pib']?>
													</div>
											</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Invoice</label>
														<div class="col-md-5">
																: <?php echo $invoiceHD['tgl_invoice']?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Daftar PIB</label>
														<div class="col-md-5">
														: <?php echo $invoiceHD['tgldaftar_pib']?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Supplier</label>
													<div class="col-md-8">
                          : <?php echo $invoiceHD['kd_supplier'].' - '.$invoiceHD['nama_supplier']?>
														</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">No Aju</label>
													<div class="col-md-5">
													: <?php echo $invoiceHD['noaju']?>
													</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Negara Asal</label>
													<div class="col-md-8">
													: <?php echo $invoiceHD['negara_asal']?>
													</div>
											</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Aju</label>
														<div class="col-md-5">
														: <?php echo $invoiceHD['tgl_aju']?>
														</div>
												</div>
										</div>

										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Pelabuhan Muat</label>
													<div class="col-md-8">
													: <?php echo $invoiceHD['pelabuhan_muat']?>
													</div>
											</div>
										</div>


				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				     <th style="text-align:center">PART</th>
						<th style="text-align:center">QTY</th>
						<th style="text-align:center">UNIT PRICE</th>
						<th style="text-align:center">KODE CURRENCY</th>
						<!--<th style="text-align:center">ACTION</th>-->
				    	</tr>
					</thead>
					<tbody>
						<tr>
              <td colspan="8" align="center">
                Tidak ada data ditemukan.
              </td>
            </tr>
          </tbody>
				  </table>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
	</div>
</div>
</section>
<!-- modal search -->
<div id="modal_search" class="modal fade modal-warning" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">PENCARIAN <?php echo $title; ?></h4>
      </div>
      <div class="modal-body">
      <form action="#" class="form-horizontal" id="form_search">
           <!-- row -->
           <div class="row">
               <div class="col-md-7">
                   <div class="form-group tight-bottom">
                       <label class="col-md-5 control-label cur-hand" style="text-align:left;">
                           <input type="checkbox" name="cek_s_nopengajuan">&nbsp;NO PENGAJUAN
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control uppercase" placeholder="NO PENGAJUAN"
                               name="txt_s_nopengajuan" onkeydown="OtomatisKapital(this)">
                       </div>
                   </div>
               </div>
        </div>
           <!-- row -->
           <div class="row">
               <div class="col-md-7">
                   <div class="form-group tight-bottom">
                       <label class="col-md-5 control-label cur-hand" style="text-align:left;">
                           <input type="checkbox"  name="cek_s_namacurr">&nbsp;NAMA CURRENCY
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control uppercase" placeholder="NAMA CURRENCY"
                               name="txt_s_namacurr"  onkeydown="OtomatisKapital(this)">
                       </div>
                   </div>
               </div>
           </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" onclick="searchAct()"><i class="glyphicon glyphicon-search"></i>&nbsp;Search</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.content -->
