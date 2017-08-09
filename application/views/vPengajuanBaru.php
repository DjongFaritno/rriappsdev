<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">

<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/maskMoney/jquery.maskMoney.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vpengajuanbaru.js"></script>

<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";

</script>
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $title;?></h3>
				  <div class="btn-group pull-right">
                      <button type="button" class="btn btn-default btn-sm" onclick="cancelForm()">
						  	<i class="glyphicon glyphicon-ban-circle"></i>&nbsp;Cancel</button>
					  <button type="button" class="btn btn-primary btn-sm" onclick="simpanData()">
						  <i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button>
            	</div>
				</div>
				<div class="box-body">
					<div class="row">
	                    <div class="col-md-5">
	                        <div class="form-group tight-bottom">
	                            <label class="control-label col-md-4">No.Pengajuan</label>
	                            <div class="col-md-5">
	                                <input type="text" class="form-control uppercase" placeholder="NO PENGAJUAN"
	                                    id="txt_no_pengajuan" maxlength="15" onkeydown="OtomatisKapital(this)"/>
	                            </div>
	                        </div>
	                    </div>
	                    <!--/span-->
	                    <div class="col-md-4">
												<div class="form-group tight-bottom">
														<label class="control-label col-md-4">Tgl.Pengajuan</label>
														<div class="col-md-5">
																<input type="text" class="form-control datepicker" placeholder="&nbsp;&nbsp;Tgl.Pengajuann"
																		id="dtp_tgl_pengajuan" readonly="readonly" value="<?php echo date('d-m-Y');  ?>"  data-date-format="dd-mm-yyyy" />
														</div>
												</div>
	                    </div>
	                    <!--/span-->
	                </div>


				</div>
			</div>
			<input type="hidden" id="hid_jumlah_item" value="0" />
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $titledt;?></h3>
				  <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalAddItem()">
					  <i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Tambah Item
				  </button>
				</div>
				<table id="tb_list" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode Kategori</th>
							<th>Nama Kategori</th>
							<th>QTY</th>
							<th>Ukuran</th>
							<th>Keterangan</th>
							<th>Hapus</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="8" align="center">
								Belum Ada Data.
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
						</tr>
					</tfoot>
				</table>
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
				</div>
				<!-- /.box-body -->
		  	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="tambahItem()"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Tambah</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
