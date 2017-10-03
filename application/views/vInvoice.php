<!-- بسم الله الرحمن الرحیم -->

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<style type="text/css">th{ text-align: center; } .datepicker{z-index:1151 !important;}</style>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/script/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vinvoice.js"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
</script>
<!-- Main content -->
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $title; ?></h3>
				  <div class="box-tools">
						<div class="btn-group pull-right">
	                      <button type="button" class="btn btn-sm bg-black-active color-palette" title="UNDUH CONTOH INVOICE" onclick="unduhINVIMPORT()">
	                    <i class="glyphicon glyphicon-download"></i>&nbsp;</button>
	                <!-- <button type="button" class="btn btn-success btn-sm" onclick="excelData()">
	                    <i class="fa fa-fw fa-file-excel-o"></i>&nbsp;EXCEL</button> -->

	                  <button type="button" class="btn btn-primary btn-sm" id="btn_Modal_Upload" title="UNGGAH INVOICE" onclick="ModalUpload()">
	                  <i class="glyphicon glyphicon-cloud-upload"></i>&nbsp;</button>

	                  </div>
										<img id="img-load" style="display:none" src="<?php echo base_url(); ?>assets/images/fb-loader.gif" />
									</div>
				</div><!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				      <th style="text-align:center">NO INVOICE</th>
				      <th style="text-align:center">TANGGAL</th>
							<th style="text-align:center">NO AJU</th>
							<th style="text-align:center">TANGGA AJU</th>
							<th style="text-align:center">SUPPLIER</th>
							<th style="text-align:center">PELABUHAN MUAT</th>
							<th style="text-align:center">NEGARA ASAL</th>
							<th style="text-align:center">NO PIB</th>
							<th style="text-align:center">TANGGAL PIB</th>
							<th >Action</th>
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
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
	</div>
</div>
</section>
<!-- modal Upload -->
<div id="Modal_Upload_Invoice" class="modal fade modal-primary" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
	<div class="modal-content">
		<!-- <form action="<?php echo base_url();?>invoice/upload/" method="post" enctype="multipart/form-data"> -->
		<form action=""  id="form_upload_invoice">
		<div class="modal-header">
		<h4 class="modal-title"><?php echo $modaltitle; ?></h4>
		</div>
		<div class="modal-body">


			<div class="form-group">
					<label for="noinvoice">NO INVOICE</label>
							<input class="form-control" type="text" maxlength = "20" name="noinvoice" id="noinvoice" onkeydown="OtomatisKapital(this)">
			</div>
			<div class="form-group">
					<label for="tglinvoice">TANGGAL INVOICE</label>
					<input type="text" class="form-control datepicker"
							id="tglinvoice" name="tglinvoice" readonly="readonly" value="<?php echo date('Y-m-d');  ?>"  data-date-format="yyyy-mm-dd" />
				</div>
			<div class="form-group">
			<label for="opt_item" class="control-label">ID SUPPLIER</label>
				<?php
					$att_item = 'id="opt_item"  class="form-control
						select2" style="width:100%" onchange="pilihItem()"';
					echo form_dropdown('opt_item', $opt_item, null, $att_item);
				?>
			</div>
		<div class="form-group">
			<label for="txt_Nama_Supplier" class="control-label">NAMA SUPPLIER</label>
				<input type="text" class="form-control" id="txt_Nama_Supplier" readonly="readonly">
		</div>
			<div class="form-group">
				<label class="control-label">FILE EXCEL</label>
					<input class="form-control" type="file" name="file" id="file">
			</div>
			<!-- <input type="submit" value="Upload file"/> -->

		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">BATAL</button>
		<button type="button" onclick="BtnUpInvoice()" id="btn_UpInvoice" class="btn btn-primary">
		<!-- <button type="submit" id="btn_UpInvoice" class="btn btn-primary"> -->
			<i class="glyphicon glyphicon-floppy-disk"></i>UNGGAH
		</button>
		<img id="img-load" style="display:none" src="<?php echo base_url(); ?>assets/images/fb-loader.gif" />
		</div>
	</div>
	</form>
	</div>
</div>
<!-- end of modal-->
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

  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.content -->
