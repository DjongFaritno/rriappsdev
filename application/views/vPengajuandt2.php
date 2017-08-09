<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vPengajuandt2.js"></script>

<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";

</script>
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
				<!-- box pengajuan_hd -->
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">PENGAJUAN <?php echo '(Status : '.$nopengajuandt1['status'].')'?></h3>
				  <div class="btn-group pull-right">
						<button type="button" class="btn btn-sm btn-default" onclick="BacktoPengajuanDT1()">
					<i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button>
                      <!-- <button type="button" class="btn btn-default btn-sm" onclick="cancelForm()">
						  	<i class="glyphicon glyphicon-ban-circle"></i>&nbsp;Cancel</button>
					  <button type="button" class="btn btn-primary btn-sm" onclick="simpanData()">
						  <i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button>
            	</div> -->
				</div>
				<div class="box-body">
					<div class="row">
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">NO Pengajuan</label>
														<div class="col-md-5">
															<input type="hidden" id="txt_id_pengajuan" hidden="true" value="<?php echo $nopengajuandt1['idpengajuan']?>">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_no_pengajuan" value="<?php echo $nopengajuandt1['nopengajuan'];?>"/>
																		<input type="hidden" id="status" hidden="true" value="<?php echo $nopengajuandt1['status']?>">
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Tgl Pengajuan</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_tgl_pengajuan" value="<?php echo $nopengajuandt1['tgl_pengajuan'];?>"/>
														</div>
												</div>
										</div>
	                    <!--/span-->
	                    <!-- <div class="col-md-4">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Kuota</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"
																		id="txt_kuota" readonly="readonly" value="<?php echo str_replace(array('.',','), array('',''), $nopengajuandt1['kuota']);?>" />
														</div>
												</div>
	                    </div> -->
	                    <!--/span-->
	                </div>
								</div>
			</div>
			<!-- box pengajuan_dt1 -->
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">KATEGORI</h3>
					<input type="hidden" class="form-control uppercase"  readonly
							id="txt_idsub" value="<?php echo $nopengajuandt1['id_sub'];?>"/>
				</div>
				<div class="box-body">
					<div class="row">
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Kode Kategori</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_kd_kategori" value="<?php echo $nopengajuandt1['kd_kategori'];?>"/>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Kuota</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																<?php	$kuota = number_format($nopengajuandt1['kuota'], 0, '.', ',');?>
																		id="txt_kuota" value="<?php echo $kuota;?>"/>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Nama Kategori</label>
														<div class="col-md-5">
																<textarea class="form-control uppercase"  readonly
																		id="txt_keterangan"><?php echo $nopengajuandt1['nama_kategori'];?></textarea>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Ukuran</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"  readonly
																		id="txt_ukuran" value="<?php echo $nopengajuandt1['ukuran'];?>"/>
														</div>
												</div>
										</div>
										<div class="col-md-5">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">keterangan</label>
														<div class="col-md-5">
																<textarea class="form-control uppercase"  readonly
																		id="txt_keterangan"><?php echo $nopengajuandt1['keterangan'];?></textarea>
														</div>
												</div>
										</div>
	                    <!--/span-->
	                    <!-- <div class="col-md-4">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Kuota</label>
														<div class="col-md-5">
																<input type="text" class="form-control uppercase"
																		id="txt_kuota" readonly="readonly" value="<?php echo $nopengajuandt1['kuota'];?>" />
														</div>
												</div>
	                    </div> -->
	                    <!--/span-->
	                </div>
								</div>
			</div>
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $titledt;?></h3>
				  <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalAddItem()">
					  <i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Tambah Part
				  </button>
				</div>
				<table id="tb_listx" class="table table-bordered">
					<thead>
			      <tr>
			      <!-- <th style="text-align:center">ID SUB</th> -->
			      <th style="text-align:center">PART</th>
						<th style="text-align:center">URAIAN BARANG</th>
						<th style="text-align:center">SATUAN</th>
			      <th width="20%">Action</th>
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

<div id="modal_add_item" class="modal fade modal-primary" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Item</h4>
      </div>
      <div class="modal-body">
		  	<form class="form-horizontal">
				<div class="box-body">
				  	<div class="form-group">
						<label for="in" class="col-md-3 control-label">Partno</label>
						<div class="col-sm-6">
							<?php

								$att_item = 'id="opt_item"  class="form-control
									select2" style="width:100%" onchange="pilihItem()"';

								echo form_dropdown('opt_item', $opt_item, null, $att_item);
							?>
						</div>
				  	</div>
					<div class="form-group">
						<label for="txt_uraian_barang" class="col-md-3 control-label">Uraian Barang</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="txt_uraian_barang" placeholder="Uraian Barang" readonly="readonly">
						</div>
					</div>
				<div class="form-group">
					<label for="txt_nohs" class="col-md-3 control-label">No HS</label>
					<div class="col-sm-3">
						<input type="text" class="form-control numbers-only" id="txt_nohs" placeholder="NO HS" readonly="readonly">
					</div>
				</div>
					<div class="form-group">
						<label for="txt_satuan" class="col-md-3 control-label">Satuan</label>
						<div class="col-sm-3">
						  <input type="text" class="form-control" id="txt_satuan" placeholder="Satuan" readonly="readonly">
						</div>
					</div>
					<input type="hidden" class="form-control" id="action" name="action" readonly="readonly">
					<input type="hidden"  class="form-control uppercase"  readonly
							id="txt_id_sub" value="<?php echo $nopengajuandt1['id_sub'];?>"/>
				</div>
				<!-- /.box-body -->
		  	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" id="btn_simpan" class="btn btn-primary"  onclick="TambahBarang()">
					<i class="glyphicon glyphicon-plus-sign"></i>Tambah</button>
				</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
