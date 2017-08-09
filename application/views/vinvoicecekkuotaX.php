<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vinvoicecekkuotaX.js"></script>

<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";

</script>
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
				<!-- box pengajuan_hd -->
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">CEK KUOTA IMPORT INVOICE</h3>
				  <div class="btn-group pull-right">
						<button type="button" class="btn btn-sm btn-default" onclick="BacktoPengajuanDT1()">
					<i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button>
                      <!-- <button type="button" class="btn btn-default btn-sm" onclick="cancelForm()">
						  	<i class="glyphicon glyphicon-ban-circle"></i>&nbsp;Cancel</button>
					  <button type="button" class="btn btn-primary btn-sm" onclick="simpanData()">
						  <i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button>
            	</div> -->
				</div>
				<br>
				<br>
				<br>
				<div class="box-body">
					<div class="row">
										<div class="col-md-4">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">No Invoice</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_no_invoice" value="<?php echo $eimporthd['noinvoice'];?>"/>
																		<!-- <input type="hidden" id="status" hidden="true" value="<?php echo $eimporthd['eimporthd']?>"> -->
														</div>
												</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Supplier</label>
													<div class="col-md-8">
															<!-- <input type="text" class="form-control uppercase"
																	id="txt_kdsupplier" readonly="readonly" value="<?php echo str_replace(array('.',','), array('',''), $nopengajuandt1['kuota']);?>" /> -->
																	<input type="text" class="form-control uppercase"
																			id="txt_kdsupplier" readonly="readonly" value="<?php echo $eimporthd['kd_supplier'].' - '.$eimporthd['nama_supplier']?>" />
													</div>
											</div>
										</div>
										<div class="col-md-4">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Invoice</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_tgl_invoice" value="<?php echo $eimporthd['tglinvoice'];?>"/>
														</div>
												</div>
										</div>
	                    <!--/span-->

	                    <!--/span-->
	                </div>
								</div>
			</div>
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">LIST PART INVOICE</h3>
				  <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalAddItem()">
					  <i class="glyphicon glyphicon-plus-sign"></i>&nbsp;LIST PART INVOICE
				  </button>
				</div>
				<table id="tb_listx" class="table table-bordered">
					<thead>
			      <tr>
			      <!-- <th style="text-align:center">ID SUB</th> -->
			      <th style="text-align:center">PART</th>
						<th style="text-align:center">QTY</th>
						<th style="text-align:center">NO PERTEK</th>
						<th style="text-align:center">KATEGORI PERTEK</th>
						<th style="text-align:center">KUOTA</th>
						<th style="text-align:center">TOTAL QTY KIRIM</th>
						<th style="text-align:center">SISA KUOTA</th>
			      <!-- <th >Action</th> -->
			     <!-- <th style="width: 40px">Label</th> -->
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <td>
			        Tidak ada data ditemukan.
			      </td>
			    </tr>
			  </tbody>
				</table>
			</div>
		</div>
	</div>
</section>
