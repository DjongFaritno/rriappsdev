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
<script src="<?php echo base_url(); ?>assets/js/vdatabarang.js"></script>

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
	                      <button type="button" class="btn btn-sm btn-warning" onclick="modalSearch()">
	                    <i class="glyphicon glyphicon-search"></i>&nbsp;CARI</button>
	                <button type="button" class="btn btn-success btn-sm" onclick="excelData()">
	                    <i class="fa fa-fw fa-file-excel-o"></i>&nbsp;EXCEL</button>
	                  <button type="button" class="btn btn-primary btn-sm" onclick="modalAddBarang()">
	                  <i class="glyphicon glyphicon-plus fa-fw"></i>&nbsp;BARANG</button>
	                  </div>
									</div>
				</div><!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				      <th style="text-align:center">PART NO</th>
				      <th style="text-align:center">URAIAN BARANG</th>
				      <th style="text-align:center">NO HS</th>
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
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
	</div>
</div>
</section>
<!-- modal add -->
<div id="modal_add_barang" class="modal fade modal-primary" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title"><?php echo $title; ?></h4>
	  </div>
	  <div class="modal-body">
			<form class="form-horizontal" name="myform" id="myform">
				<input type="hidden" name="id_barang" value="">
				<div class="box-body">
        <div class="form-group">
						<label for="exampleFIELD1">PARTNO</label>
						 <!-- <div id='myform_partno_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "20" name="partno" id="partno" onkeydown="OtomatisKapital(this)">
					</div>
					<div class="form-group">
						<label for="exampleFIELD2">URAIAN BARANG</label>
						 <!-- <div id='myform_uraianbarang_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "50" name="uraianbarang" id="uraianbarang"  onkeydown="OtomatisKapital(this)">
					</div>
					<div class="form-group">
						<label for="exampleFIELD13">NO HS</label>
						 <!-- <div id='myform_nohs_errorloc' class="error_strings"></div> -->
						<input class="form-control" type="text" maxlength = "10" name="nohs" id="nohs" onkeypress="return isNumberKey(event)">
					</div>
				<div class="form-group">
					<label>SATUAN</label>
						<!-- <div id="myform_satuan_errorloc" class="error_strings"></div> -->
						<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="satuan" id="satuan">
						<option value="" selected="selected"></option>
						<option value="PCS">PCS</option>
						<option value="KG">KG</option>
						<option value="SETS">SETS</option>
						<option value="KGM">KGM</option>
						</select>
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
    <button type="button" id="btn_simpan" class="btn btn-primary"  onclick="TambahBarang()">
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
                           <input type="checkbox" name="cek_s_partno">&nbsp;PARTNO
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control uppercase" placeholder="PARTNO"
                               name="txt_s_partno" onkeydown="OtomatisKapital(this)">
                       </div>
                   </div>
               </div>
        </div>
           <!-- row -->
           <div class="row">
               <div class="col-md-7">
                   <div class="form-group tight-bottom">
                       <label class="col-md-5 control-label cur-hand" style="text-align:left;">
                           <input type="checkbox"  name="cek_s_uraianbarang">&nbsp;URAIAN BARANG
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control uppercase" placeholder="URAIAN BARANG"
                               name="txt_s_uraianbarang"  onkeydown="OtomatisKapital(this)">
                       </div>
                   </div>
               </div>
           </div>
        <!-- row -->
           <div class="row">
               <div class="col-md-7">
                   <div class="form-group tight-bottom">
                       <label class="col-md-5 control-label cur-hand" style="text-align:left;">
                           <input type="checkbox" name="cek_s_nohs">&nbsp;NO HS
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control" placeholder="NO HS"
                               name="txt_s_nohs" onkeypress="return isNumberKey(event)">
                       </div>
                   </div>
               </div>
           </div>
        <!-- row -->
           <div class="row">
               <div class="col-md-7">
                   <div class="form-group tight-bottom">
                       <label class="col-md-5 control-label cur-hand" style="text-align:left;">
                           <input type="checkbox" name="cek_s_satuan">&nbsp;SATUAN
                       </label>
                       <div class="col-md-7">
                           <input type="text" class="form-control" placeholder="SATUAN"
                               name="txt_s_satuan" onkeydown="OtomatisKapital(this)">
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
<!-- </form><script language="JavaScript" type="text/javascript"
xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
var frmvalidator  = new Validator("myform");
frmvalidator.addValidation("partno","req","Please enter partno");
// frmvalidator.addValidation("FirstName","maxlen=20",	"Max length for FirstName is 20");
// frmvalidator.addValidation("FirstName","alpha","Alphabetic chars only");

frmvalidator.addValidation("uraianbarang","req","Please enter uraianbarang");
frmvalidator.addValidation("nohs","req","Please enter uraianbarang");
frmvalidator.addValidation("satuan","req","Please enter uraianbarang");
// frmvalidator.addValidation("LastName","maxlen=20","Max length is 20");

// frmvalidator.addValidation("Email","maxlen=50");
// frmvalidator.addValidation("Email","req");
// frmvalidator.addValidation("Email","email");
//
// frmvalidator.addValidation("Phone","maxlen=50");
// frmvalidator.addValidation("Phone","numeric");
//
// frmvalidator.addValidation("Address","maxlen=50");
// frmvalidator.addValidation("Country","dontselect=000");

//]]></script> -->
