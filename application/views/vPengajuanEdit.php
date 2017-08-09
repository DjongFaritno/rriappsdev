<!-- بسم الله الرحمن الرحیم -->

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<style type="text/css">th{ text-align: center; } .datepicker{z-index:1151 !important;}</style>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/script/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/maskMoney/jquery.maskMoney.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vpengajuanedit.js"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
</script>
<!-- Main content -->
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
				<!-- //header 1-->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo $title;?></h3>
						<div class="btn-group pull-right">
												<button type="button" class="btn btn-default btn-sm" onclick="cancelForm()">
									<i class="glyphicon glyphicon-ban-circle"></i>&nbsp;Kembali</button>
							<!-- <button type="button" class="btn btn-primary btn-sm" onclick="simpanData()">
								<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button> -->
								</div>
					</div>
					<div class="box-body">
						<div class="row">
												<div class="col-md-5">
														<div class="form-group tight-bottom">
																<label class="control-label col-md-4">No.Pengajuan</label>
																<div class="col-md-5">
																		<input type="text" class="form-control uppercase" value="<?php echo $nopengajuan['nopengajuan']?>" readonly
																				id="txt_no_pengajuan" maxlength="15"/>
																</div>
														</div>
												</div>
												<!--/span-->
												<div class="col-md-4">
													<div class="form-group tight-bottom">
															<label class="control-label col-md-4">Tgl.Pengajuan</label>
															<div class="col-md-5">
																	<input type="text" class="form-control datepicker" placeholder="&nbsp;&nbsp;Tgl.Pengajuan"
																			id="dtp_tgl_pengajuan" onclick="btnTGL()" readonly="readonly" value="<?php echo $nopengajuan['tgl_pengajuan']?>" data-date-format="yyyy-mm-dd"/>
															</div>
															<button type="button" style="display:none" id="BtnTglUpd" class="btn btn-warning btn-sm" onclick="UpdateTanggal()"><i class="glyphicon "></i>&nbsp;Update Tanggal</button>
													</div>
												</div>
												<!--/span-->
										</div>


					</div>
				</div>
				<!-- header2 -->
				<input type="hidden" id="hid_jumlah_item" value="0" />
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">LIST PENGAJUAN NO <b><?php echo $nopengajuan['nopengajuan']; ?></b></h3>
				  <div class="box-tools">
						<div class="btn-group pull-left">
							<button type="button" class="btn btn-sm bg-blue color-palette" onclick="modalAddItem()">
						<i class="glyphicon glyphicon-share"></i>&nbsp;TAMBAH KATEGORI</button>
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
						<input type="hidden" id="txt_id_pengajuan" hidden="true" value="<?php echo $nopengajuan['idpengajuan']?>">
						<input type="hidden" id="status" hidden="true" value="<?php echo $nopengajuan['status']?>">
										</div>


				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				      <th style="text-align:center">KODE KATEGORI</th>
							<th style="text-align:center">NAMA KATEGORI</th>
				      <th style="text-align:center">KUOTA</th>
							<th style="text-align:center">UKURAN</th>
							<th style="text-align:center">KETERANGAN</th>
							<th >Action</th>
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
<!-- modal add item -->
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
						<label for="in" class="col-md-3 control-label">Kategori</label>
						<div class="col-sm-6">
							<?php

								$att_item = 'id="opt_item"  class="form-control
									select2" style="width:100%" onchange="pilihItem()"';

								echo form_dropdown('opt_item', $opt_item, null, $att_item);
							?>
						</div>
				  	</div>
					<div class="form-group">
						<label for="txt_Nama_kategori" class="col-md-3 control-label">Nama Kategori</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="txt_Nama_kategori" placeholder="Nama Kategori" readonly="readonly">
						</div>
					</div>
				<div class="form-group">
					<label for="txt_Qty" class="col-md-3 control-label">QTY</label>
					<div class="col-sm-3">
						<input type="text" class="form-control numbers-only" id="txt_Qty" placeholder="Qty">
					</div>
				</div>
					<div class="form-group">
						<label for="txt_ukuran" class="col-md-3 control-label">Ukuran</label>
						<div class="col-sm-3">
						  <input type="text" class="form-control" id="txt_ukuran" placeholder="Ukuran" >
						</div>
					</div>
					<div class="form-group">
						<label for="txt_keterangan" class="col-md-3 control-label">Keterangan</label>
						<div class="col-sm-3">
						  <textarea type="text" class="form-control" id="txt_keterangan" placeholder="Keterangan" ></textarea>
						</div>
					</div>
					<input type="hidden" class="form-control" id="action" name="action" readonly="readonly">
					<!-- <input type="text"  class="form-control uppercase"  readonly
							id="txt_id_sub" value="<?php echo $nopengajuan['nopengajuan']; ?>"/> -->
				</div>
				<!-- /.box-body -->
		  	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" id="btn_simpan" class="btn btn-primary" onclick="tambahItem()"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Tambah</button>
				  <img id="img-load" style="display:none" src="<?php echo base_url(); ?>assets/images/fb-loader.gif" />
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
