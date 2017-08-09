<!-- بسم الله الرحمن الرحیم -->

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<style type="text/css">th{ text-align: center; } .datepicker{z-index:1151 !important;}</style>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/gen_validatorv4.js"></script>
<script src="<?php echo base_url(); ?>assets/script/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vpengajuandt1.js"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
</script>
<!-- Main content -->
<section class="content">
	<div class="row">
    	<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">PENGAJUAN NO <b><?php echo $nopengajuan['nopengajuan'].' (Status: '.$nopengajuan['status'].')'; ?></b></h3>
				  <div class="box-tools">
						<div class="btn-group pull-left">
								<button type="button" class="btn btn-sm btn-default" onclick="BacktoPengajuan()">
							<i class="glyphicon glyphicon-backward"></i>&nbsp;BACK</button>
							<button type="button" class="btn btn-sm bg-black color-palette" onclick="AddToPertek('<?php echo $nopengajuan['idpengajuan']; ?>','<?php echo $nopengajuan['nopengajuan']; ?>')">
						<i class="glyphicon glyphicon-share"></i>&nbsp;ADD TO PERTEK</button>
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
						<input type="hidden" id="txt_no_pengajuan" hidden="true" value="<?php echo $nopengajuan['idpengajuan']?>">
						<input type="text" id="status" hidden="true" value="<?php echo $nopengajuan['status']?>">
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
