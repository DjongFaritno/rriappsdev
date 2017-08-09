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
<script src="<?php echo base_url(); ?>assets/js/vdatauser.js"></script>

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
	                      <!-- <button type="button" class="btn btn-sm btn-warning" onclick="modalSearch()">
	                    <i class="glyphicon glyphicon-search"></i>&nbsp;CARI</button> -->
	                <!-- <button type="button" class="btn btn-success btn-sm" onclick="excelData()">
	                    <i class="fa fa-fw fa-file-excel-o"></i>&nbsp;EXCEL</button> -->
	                  <button type="button" class="btn btn-primary btn-sm" onclick="modalAddUser()">
	                  <i class="glyphicon glyphicon-plus fa-fw"></i>&nbsp;USER</button>
	                  </div>
									</div>
				</div><!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				      <th style="text-align:center">USER NAME</th>
				      <th style="text-align:center">FULL NAME</th>
				      <th style="text-align:center">EMAIL</th>
							<th style="text-align:center">PRIVILEGE</th>
							<!-- <th style="text-align:center">password</th> -->
							<th width="30%">Action</th>
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
<div id="modal_add_user" class="modal fade modal-primary" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title"><?php echo $title; ?></h4>
	  </div>
	  <div class="modal-body">
			<form class="form-horizontal" name="myform" id="myform">
				<input type="hidden" name="id_user" value="">
				<div class="box-body">
        <div id="g_username" class="form-group">
						<label for="exampleFIELD1">USER NAME</label>
						 <!-- <div id='myform_partno_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "20" name="username" id="username" onkeydown="OtomatisKapital(this)">
					</div>
					<div id="g_fullname" class="form-group">
						<label for="exampleFIELD2">FULL NAME</label>
						 <!-- <div id='myform_uraianbarang_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "50" name="fullname" id="fullname"  onkeydown="OtomatisKapital(this)">
					</div>
					<div id="g_email" class="form-group">
						<label for="exampleFIELD13">EMAIL</label>
						 <!-- <div id='myform_nohs_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "20" name="email" id="email">
					</div>
				<div id="g_privilege" class="form-group">
					<label>PRIVILEGE</label>
						<!-- <div id="myform_satuan_errorloc" class="error_strings"></div> -->
						<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="privilege" id="privilege">
						<option value="" selected="selected"></option>
						<option value="ADMIN">ADMIN</option>
						<option value="USER">USER</option>
						<option value="USER">OPERATOR</option>
						</select>
						</div>
						<div id="g_password" class="form-group">
							<label for="exampleFIELD14">PASSWORD</label>
							 <!-- <div id='myform_nohs_errorloc' class="error_strings"></div> -->
							<input class="form-control" type="password" maxlength = "10" name="password" id="password">
						</div>
						<div id="g_cpassword" class="form-group">
							<label for="exampleFIELD15">CONFIRM PASSWORD</label>
							 <!-- <div id='myform_nohs_errorloc' class="error_strings"></div> -->
							<input class="form-control" type="password" maxlength = "10" name="cpassword" id="cpassword">
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
    <button type="button" id="btn_simpan" class="btn btn-primary"  onclick="TambahUser()">
      <i class="glyphicon glyphicon-floppy-disk"></i>SIMPAN
    </button>
    <img id="img-load" style="display:none" src="<?php echo base_url(); ?>assets/images/fb-loader.gif" />
    </div>
  </div>
  </div>
</div>
<!-- end of modal-->
