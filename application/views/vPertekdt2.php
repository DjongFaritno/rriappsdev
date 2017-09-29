<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vPertekdt2.js"></script>

<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";

</script>
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
				<!-- box pertek_hd -->
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">PERTEK <b><?php echo '(status : '.$pertekdt1['status'].')'?></b></h3>
				  <div class="btn-group pull-right">
						<button type="button" class="btn btn-sm btn-default" onclick="BacktopertekDT1()">
					<i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button>
				</div>
				<div class="box-body">
					<div class="row">
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">No Pertek</label>
														<div class="col-md-5"><?php echo $pertekdt1['nopertek'];?>
															<input type="hidden" id="txt_id_Pertek" hidden="true" value="<?php echo $pertekdt1['idpertek']?>">
																		<input type="hidden" id="status" hidden="true" value="<?php echo $pertekdt1['status']?>">
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">No Pengajuan</label>
														<div class="col-md-5"><?php echo $pertekdt1['nopengajuan'];?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Tgl Pertek</label>
														<div class="col-md-5"><?php echo $pertekdt1['tgl_mulai'];?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Tgl Expired</label>
														<div class="col-md-5"><?php echo $pertekdt1['tgl_exp'];?>
														</div>
												</div>
										</div>
									</div>
								</div>
			</div>
			<!-- box Pertek_dt1 -->
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">KATEGORI</h3>
					<input type="hidden" class="form-control uppercase"  readonly
							id="txt_idsub" value="<?php echo $pertekdt1['id_sub'];?>"/>
				</div>
				<div class="box-body">
					<div class="row">
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Kode Kategori</label>
														<div class="col-md-5"><?php echo $pertekdt1['kd_kategori'];?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Kuota/Sisa Kuota</label>
														<div class="col-md-5">
															<?php
															$quota = $pertekdt1['kuota'];
															$squota = $pertekdt1['sisa_kuota'];
															$persen =  ($squota/$quota) * 100;
															?>
															<div class="progress active">
								                <div class="progress-bar progress-bar-red progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $persen?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen?>%">
								                  <font color="#000"> <?php echo number_format($pertekdt1['kuota'], 0, '.', ',').'/'.number_format($pertekdt1['sisa_kuota'], 0, '.', ',');?></font>
								                </div>
								              </div>
													</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Nama Kategori</label>
														<div class="col-md-5"><?php echo $pertekdt1['nama_kategori'];?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Ukuran</label>
														<div class="col-md-5"><?php echo $pertekdt1['ukuran'];?>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">keterangan</label>
														<div class="col-md-5"><?php echo $pertekdt1['keterangan'];?>
														</div>
												</div>
										</div>
	                   </div>
								</div>
			</div>
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $titledt;?></h3>
				</div>
				<table id="tb_listx" class="table table-bordered">
					<thead>
			      <tr>
			      <!-- <th style="text-align:center">ID SUB</th> -->
			      <th style="text-align:center">PART</th>
						<th style="text-align:center">URAIAN BARANG</th>
						<th style="text-align:center">SATUAN</th>
			     <!-- <th style="width: 40px">Label</th> -->
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
			</div>
		</div>
	</div>
</section>
