<!-- بسم الله الرحمن الرحیم -->

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/gen_validatorv4.js"></script>
<script src="<?php echo base_url(); ?>assets/script/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vdatakategori.js"></script>

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
	                  <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah Kategori" onclick="modalAddkategori()">
	                  <i class="glyphicon glyphicon-plus fa-fw"></i>&nbsp;</button>
	                      <button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cari Kategori" onclick="modalSearch()">
	                    <i class="glyphicon glyphicon-search"></i>&nbsp;</button>
	                <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Excel" onclick="excelData()">
	                    <i class="fa fa-fw fa-file-excel-o"></i>&nbsp;</button>
	                  </div>
									</div>
				</div><!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				      <th style="text-align:center">KODE KATEGORI</th>
				      <th style="text-align:center">NAMA KATEGORI</th>
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
<!-- modal add -->
<div id="modal_add_kategori" class="modal modal-primary" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title"><?php echo $title; ?></h4>
	  </div>
	  <div class="modal-body">
			<form class="form-horizontal" name="myform" id="myform">
				<input type="hidden" name="id_kategori" value="">
				<div class="box-body">
        <div class="form-group">
						<label for="exampleFIELD1">KODE KATEGORI</label>
						 <!-- <div id='myform_partno_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "20" name="kdkategori" id="kdkategori" onkeydown="OtomatisKapital(this)">
					</div>
					<div class="form-group">
						<label for="exampleFIELD2">NAMA KATEGORI</label>
						 <!-- <div id='myform_uraianbarang_errorloc' class="error_strings"></div> -->
						 <!-- <input class="form-control" type="text" maxlength = "100" name="namakategori" id="namakategori"  onkeydown="OtomatisKapital(this)">  -->
            <!-- <textarea class="form-control" rows="3" name="namakategori" id="namakategori" onkeydown="OtomatisKapital(this)"></textarea> -->
              <textarea type="text" class="form-control" name="namakategori" id="namakategori" onkeydown="OtomatisKapital(this)"></textarea> 
					</div>
					<!-- //status -->
						<div class="form-group">
						<input class="form-control" style="display:none" type="text" maxlength = "10" name="action" id="action" >
						</div>
				</div>
				<!-- /.box-body -->
			</form>
	  </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">BATAL</button>
    <button type="button" id="btn_simpan" class="btn btn-primary"  onclick="TambahKategori()">
      <i class="glyphicon glyphicon-floppy-disk"></i>SIMPAN
    </button>
    <img id="img-load" style="display:none" src="<?php echo base_url(); ?>assets/images/fb-loader.gif" />
    </div>
  </div>
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
                           <input type="checkbox" name="cek_s_kdkategori">&nbsp;KODE KATEGORI
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control uppercase" placeholder="KODE KATEGORI"
                               name="txt_s_kdkategori" onkeydown="OtomatisKapital(this)">
                       </div>
                   </div>
               </div>
        </div>
           <!-- row -->
           <div class="row">
               <div class="col-md-7">
                   <div class="form-group tight-bottom">
                       <label class="col-md-5 control-label cur-hand" style="text-align:left;">
                           <input type="checkbox"  name="cek_s_namakategori">&nbsp;NAMA KATEGORI
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control uppercase" placeholder="NAMA KATEGORI"
                               name="txt_s_namakategori"  onkeydown="OtomatisKapital(this)">
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
