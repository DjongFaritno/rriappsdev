//load
$(document).ready(function(){
	setTable();
	$(".datepicker").datepicker({autoclose: true,maxDate: '0'});
});

function setTable(){
	var my_table = $('#tb_list').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"datacurr/loaddatatable",
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
// 		url: base_url+'datacurr/search_query',
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
// 	window.location = base_url+'datacurr/excel_Curr';
// }

// code code di add new modal
function modalAddCurr(){
 clearFormInput();
	$('#modal_add_Curr').modal('show');
	$("input[name='kdcurr']").attr('readonly', false);
	$('#btn_simpan').text('SIMPAN');
	$("input[name='action']").val('SIMPAN');
}

function editKeluar(kdcurr){

	$.ajax({

		type:"POST",
		url:base_url+"datacurr/get_data_curr/"+kdcurr,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='kdcurr']").val(data['kd_curr']);
			$("input[name='kdcurr']").attr('readonly', true);
			$("input[name='namacurr']").val(data['nama_curr']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_Curr').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
	function(result){
		if(result==true){
			window.location = base_url+'datacurr';
		}
	}
	);
}

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

function clearFormInput(){
	$("input[name='kdcurr']").val('');
	$("input[name='namacurr']").val('');
}


function TambahCurr(){

	var kdcurr 				= $("input[name='kdcurr']").val();
	var namacurr 			= $("input[name='namacurr']").val();
	var action 						= $("input[name='action']").val();
	//cek textbox yang kosong
	if(kdcurr=="" || namacurr==""){

		var title 				= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
		var str_message 	= "KODE CURRENCY, &amp; NAMA CURRENCY tidak boleh kosong.";

		bootbox.alert({
			size:'small',
			title:title,
			message:str_message,
			buttons:{
				ok:{
					label: 'OK',
					className: 'btn-warning'
				}
			}
		});
		return false;
	}

	// cek data sudah ada atau belum
	if (action == 'SIMPAN')
	{
						$.ajax({

						type:"POST",
						url:base_url+"datacurr/cekduplicate/"+kdcurr,
						dataType:"html",
						success:function(data)
						{
										var data = $.parseJSON(data);

													if (data !== null )
													{//jika curr sudah ada
															var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;DUPLICATE DATA!!";
															var str_message = "KODE CURRENCY SUDAH ADA!!!";
															bootbox.alert
															({
																	size:'small',
																	title:title,
																	message:str_message,
																	buttons:
																	{
																			ok:{
																				label: 'OK',
																				className: 'btn-danger'
																			}
																	}
															});
															return false;
													}
													// else
													// {
													$('#btn_simpan').hide();
													$('#img-load').show();

													var json_data 	=
													{
															'kdcurr' 		: kdcurr,
															'namacurr' 	: namacurr,
															'action' 				: action
													};
													$.ajax({
																type:"POST",
																url:base_url+"datacurr/ProsesInsert",
																dataType:"JSON",
																data:json_data,
																success:function(data){
																	window.location = base_url+'datacurr';
																}
													});
													// }
						}
					});
	}else{
		//brang tidak ada, ok proses simpan
		$('#btn_simpan').hide();
		$('#img-load').show();

		var json_data 	=
		{
				'kdcurr' 		: kdcurr,
				'namacurr' 	: namacurr,
				'action' 				: action
		};
		$.ajax({
					type:"POST",
					url:base_url+"datacurr/ProsesInsert",
					dataType:"JSON",
					data:json_data,
					success:function(data){
						window.location = base_url+'datacurr';
							}
				});
	}
// end
}
