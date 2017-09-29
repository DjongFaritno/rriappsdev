//load
$(document).ready(function(){
	setTable();
	// $(".datepicker").datepicker({autoclose: true,maxDate: '0'});

	$('.numbers-only').keypress(function(event) {

		var charCode = (event.which) ? event.which : event.keyCode;
			if ((charCode >= 48 && charCode <= 57)
				|| charCode == 46
				|| charCode == 44
				|| charCode == 8)
				return true;
		return false;
	});

});


function isNumberKey(evt){ //untuk validasi hanya input angka
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}

function OtomatisKapital(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function setTable(){
	var idpengajuan =$('#txt_id_pengajuan').val()
	var my_table = $('#tb_list').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"pertek/loaddatatableview/"+idpengajuan,
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

// function modalSearch(){
// 	});
	// 	$('#modal_search').modal('show');
	// }
	//
	// function searchAct(){
	// 	$("#form_search").ajaxSubmit({
	// 		url: base_url+'pengajuan/search_query',
	// 		type: 'post',
	// 		success: function(){
	// 			var table = $('#tb_list').DataTable();
	// 			table.ajax.reload( null, false );
	// 			$('#modal_search').modal('toggle');
	// 			// clearForm();
	// 		}
	// 	});
// }

// function excelData(){
	// 	window.location = base_url+'pengajuan/excel_pengajuan';
// }

function ViewDetailPengajuan(nopengajuan){
	$.ajax({

		type:"POST",
		url:base_url+"pengajuan/get_data_pengajuan/"+nopengajuan,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='nopengajuan']").val(data['nopengajuan']);
			$("input[name='nopengajuan']").attr('readonly', true);
			$("input[name='dtp_tgl_pengajuan']").val(data['tgl_pengajuan']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_Pengajuan').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
		function(result){
			if(result==true){
				window.location = base_url+'pengajuan';
			}
		}	
	);
}

function BacktoPengajuan(){
	window.location = base_url+'pengajuan';
}

function ViewDt2(id_sub){
	window.location = base_url+'pengajuan/view_pengajuandt2/'+id_sub;
}

function DeletePengajuan(idsub,nopengajuan,kd_kategori){
	bootbox.confirm("Anda yakin akan menghapus "+kd_kategori+" ?",
		function(result){
			if(result==true){
				$.post(
					base_url+"pengajuan/delete_Sub/"+idsub,function(){
						window.location = base_url+'pengajuan/view_pengajuan/'+nopengajuan;
					}
				);
			}
		}
	);
}

function ONprosses(){
	bootbox.alert("<div class='callout callout-danger'><span class='glyphicon glyphicon-exclamation-sign'></span>SEDANG DALAM PENGERJAAN! </div>",
		function(result){
			if(result==true){

			}
		}
	);
}

function SimpanPertek(){
	if(ValidasiForm()==true)
	{
		//action
		//dataHEADER
		var no_pengajuan 	= $('#txt_no_pengajuan').val();
		var no_pertek 		= $('#txt_no_pertek').val();
		var tgl_mulai 		= $('#dtp_tgl_pertek').val();
		var tgl_exp 		= $('#dtp_tgl_pertekend').val();
		var str_url  		= encodeURI(base_url+"pertek/cek_pertek/"+no_pertek);
		$.ajax({
			type:"POST",
			url:str_url,
			dataType:"html",
			success:function(data){
				var data = $.parseJSON(data);
				if(data != null)
				{
					bootbox.alert({
						title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;PERINGATAN!!</div>",
						message: "Simpan Gagal, NO PERTEK <b>"+no_pertek+"</b>,Sudah ada!!",
						// buttons: {
							OK: {
								label: '<i class="fa fa-check"></i> Ya',
								className: 'btn-danger'
							}
						// },
					});
				}
				else
				{
					var json_data = 
					{
						'no_pertek' 		: no_pertek,
						'no_pengajuan' 		: no_pengajuan,
						'tgl_mulai' 		:	tgl_mulai,
						'tgl_exp' 			: tgl_exp

					};

					$.ajax({
						type:"POST",
						url:base_url+"pertek/simpan_pertek",
						dataType:"JSON",
						data:json_data,
						success:function(data){

							bootbox.alert({
								message: "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp;Simpan Data Berhasil.",
								size: 'small',
								callback: function () {

									window.location = base_url+'/pengajuan';
								}
							});
						}
					});
				}

				
			}
		});

		

	}

}

function ValidasiForm(){
	if ($('#txt_no_pertek').val()==''){
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;NO Pertek masih kosong.");
		return false;
	}
	if ($('#dtp_tgl_pertek').val()==''){
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Silahkan Pilih Tanggal Pertek.");
		return false;
	}
	if ($('#dtp_tgl_pertekend').val()==''){
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Tanggal Pertek Kosong.");
		return false;
	}
		return true;
}
