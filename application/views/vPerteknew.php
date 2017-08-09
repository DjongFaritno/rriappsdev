<!-- بسم الله الرحمن الرحیم -->

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.css">
<!-- /*<style type="text/css">th{ text-align: center; } .datepicker{z-index:1151 !important;}</style>*/ -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/plugins/gen_validatorv4.js"></script> -->
<script src="<?php echo base_url(); ?>assets/script/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vperteknew.js"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
</script>
<!-- Main content -->
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">ADD TO PERTEK <b><?php echo $nopengajuan['nopengajuan']; ?></b></h3>
				  <div class="box-tools">
						<div class="btn-group pull-left">
								<button type="button" class="btn btn-sm btn-default" onclick="BacktoPengajuan()">
							<i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button>
							<button type="button" class="btn btn-sm bg-blue color-palette" onclick="SimpanPertek()">
						<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;SAVE</button>
	          </div>
				</div>
				<!-- box body header -->
				<div class="box-body">
					<div class="row">
					<div class="col-md-5">
							<div class="form-group tight-bottom">
									<div class="col-md-5">
										<label class="control-label">NO Pengajuan</label>
										<input type="hidden" id="txt_id_pengajuan" value="<?php echo $nopengajuan['idpengajuan'];?>"/>
											<input type="text" class="form-control uppercase"  readonly
													id="txt_no_pengajuan" value="<?php echo $nopengajuan['nopengajuan'];?>"/>
									</div>
							</div>
					</div>
					<div class="col-md-5">
							<div class="form-group tight-bottom">
									<div class="col-md-7">
										<label class="control-label">NO Pertek</label>
											<input type="text" class="form-control uppercase"
													id="txt_no_pertek" onkeydown="OtomatisKapital(this)"/>
									</div>
							</div>
					</div>
					<div class="col-md-5">
						<div class="form-group tight-bottom">
								<div class="col-md-5">
									<label class="control-label">Tgl.Pertek</label>
										<input type="text" class="form-control firstcal" placeholder="&nbsp;&nbsp;Tgl.Pertek"
												id="dtp_tgl_pertek" readonly="readonly" />
								</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group tight-bottom">
								<div class="col-md-5">
									<label class="control-label">Tgl.Expired Pertek</label>
										<input type="text" class="form-control secondcal"  placeholder="&nbsp;&nbsp;Tgl.Exp Pertek"
												id="dtp_tgl_pertekend" name="dtp_tgl_pertekend" readonly="readonly"/>
								</div>
						</div>
					</div>

					<!-- <div class="col-md-5">
						<div class="form-group tight-bottom">
								<div class="col-md-5">
									<label class="control-label">Tgl.Pengajuan</label>
									<input type="text" class="firstcal">
									<input type="text" class="secondcal">
								</div>
						</div>
					</div> -->



					</div>



				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <table id="tb_list" class="table table-bordered">
				    <thead>
							<tr>
				      <th style="text-align:center">KODE KATEGORI</th>
				      <th style="text-align:center">KUOTA</th>
							<th style="text-align:center">UKURAN</th>
							<th style="text-align:center">KETERANGAN</th>
							<!-- <th >Action</th> -->
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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.content -->
<script type="text/javascript">
$(function() {
  $(".firstcal").datepicker({
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, instance) {
      date = $.datepicker.parseDate(instance.settings.dateFormat, dateText, instance.settings);
      date.setMonth(date.getMonth() + 6);
      $(".secondcal").datepicker("setDate", date);
    }
  });
  $(".secondcal").datepicker({
    dateFormat: "dd-mm-yy"
  });
});
</script>
