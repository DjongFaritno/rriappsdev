//load
$(document).ready(function(){
	setTable();
	$(".datepicker").datepicker({autoclose: true,maxDate: '0'});

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
	var idpertek =$('#txt_idpertek').val()
	var my_table = $('#tb_list').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"pertek/loaddatatableviewdt1/"+idpertek,
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

// function modalSearch(){
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


function FormPengajuanBAru()
{
	window.location = base_url+'pengajuan/add_pengajuan'
}

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

function BacktoPertek(){

			window.location = base_url+'pertek';

}

function ViewDt2(id_sub){
	// bootbox.confirm("ON PROGRESS bray!!",
	// function(result){
	// 	if(result==true){
			window.location = base_url+'pertek/view_pertekdt2/'+id_sub;
	// 	}
	// }
	// );
}

function DeletePengajuan(idsub,nopengajuan,kd_kategori){
	var status =$('#status').val()
	if(status=='nonactive')
	{
		bootbox.alert("<div class='callout callout-danger'><span class='glyphicon glyphicon-exclamation-sign'></span>Tidak Bisa Dihapus</div>",
			function(result){
				if(result==true){

				}
			}
		);
	}else{
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
}

function ONprosses(){

	bootbox.alert("<div class='callout callout-danger'><span class='glyphicon glyphicon-exclamation-sign'></span>SEDANG DALAM PENGERJAAN! </div>",
		function(result){
			if(result==true){

			}
		}
	);
}
function AddToPertek(idpengajuan,nopengajuan){
	var status_pengajuan =$('#status').val()
	if(status_pengajuan=='nonactive'){
		bootbox.alert("<div class='callout callout-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> NO PENGAJUAN "+nopengajuan+" SUDAH DI JADIKAN PERTEK </div>"
			// function(result){
			// 	if(result==true){
			//
			// 	}
			// }
		);

	}else{
	bootbox.confirm("Anda yakin akan membuat PERTEK dari no pengajuan  "+nopengajuan+" ?",
	function(result){
		if(result==true){
			window.location = base_url+'pertek/newpertek/'+idpengajuan;
		}
	}
	);
}
}
