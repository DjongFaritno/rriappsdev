<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vinvoicecekkuota.js"></script>

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
						<!-- <button type="button" class="btn btn-sm btn-default" onclick="BacktoInvoice()"> -->
					<!-- <i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button> -->
                      <button type="button" class="btn btn-default btn-sm" onclick="BacktoInvoice()">
						  	<i class="glyphicon glyphicon-ban-circle"></i>&nbsp;Cancel</button>
					  <button type="button" class="btn btn-primary btn-sm" onclick="SimpanEimport('<?php echo $eimporthd['idinvoicehd']?>')">
						  <i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button>
            	<!-- </div> -->
				</div>
				<!-- <br>
				<br>
				<br> -->
				<div class="box-body">
					<div class="row">
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">No Invoice</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_no_invoice" value="<?php echo $eimporthd['noinvoice'];?>"/>
																		<input type="hidden" id="txt_idinvoicehd" hidden="true" value="<?php echo $eimporthd['idinvoicehd']?>">
														</div>
												</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">No Daftar PIB</label>
													<div class="col-md-5">
														<input type="text" class="form-control uppercase" onkeydown="OtomatisKapital(this)"
															id="txt_nodaftar_pib" value="" />
													</div>
											</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Invoice</label>
														<div class="col-md-5">
																<input type="text" class="form-control "
																		id="txt_tgl_invoice" readonly="readonly" value="<?php echo $eimporthd['tglinvoice'];?>" data-date-format="dd-mm-yyyy" />
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Daftar PIB</label>
														<div class="col-md-5">
															<input type="text" class="form-control datepicker"
																	id="dtp_tgl_pib" readonly="readonly" value="<?php echo date('Y-m-d');  ?>"  data-date-format="yyyy-mm-dd" />
														</div>
												</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Supplier</label>
													<div class="col-md-8">
														<input type="text" class="form-control uppercase"
																			id="txt_kdsupplier" readonly="readonly" value="<?php echo $eimporthd['kd_supplier'].' - '.$eimporthd['nama_supplier']?>" />
													</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">No Aju</label>
													<div class="col-md-5">
														<input type="text" class="form-control uppercase" onkeydown="OtomatisKapital(this)"
																			id="txt_noaju" value="" />
													</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Negara Asal</label>
													<div class="col-md-8">
														<input type="text" class="form-control uppercase" onkeydown="OtomatisKapital(this)"
																			id="txt_Negara_Asal"  value="" />
													</div>
											</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-3">Tgl Aju</label>
														<div class="col-md-5">
															<input type="text" class="form-control datepicker"
																	id="dtp_tgl_aju" readonly="readonly" value="<?php echo date('Y-m-d');  ?>"  data-date-format="yyyy-mm-dd" />
														</div>
												</div>
										</div>

										<div class="col-md-5">
											<div class="form-group tight-bottom">
													<label class="control-label col-md-3">Pelabuhan Muat</label>
													<div class="col-md-8">
														<input type="text" class="form-control uppercase" onkeydown="OtomatisKapital(this)"
																			id="txt_pelabuhanmuat"  value="" />
													</div>
											</div>
										</div>




	                    <!--/span-->

	                    <!--/span-->
	                </div>
								</div>
			</div>
			<div class="box">
				<table id="tb_listx" class="table table-bordered">
					<thead>
			      <tr>
			      <!-- <th style="text-align:center">ID SUB</th> -->
			      <th style="text-align:center">PART</th>
						<th style="text-align:center">QTY</th>
						<th style="text-align:center">TOTAL QTY</th>
						<th style="text-align:center">NO PERTEK</th>
						<th style="text-align:center">KATEGORI PERTEK</th>
						<th style="text-align:center">KUOTA AWAL</th>
						<th style="text-align:center">KUOTA SAAT INI</th>
			      		<th style="text-align:center">SISA KUOTA</th>
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
