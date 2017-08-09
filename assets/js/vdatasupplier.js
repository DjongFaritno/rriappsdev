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
	  ajax: base_url+"datasupplier/loaddatatable",
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

function modalSearch(){
	$('#modal_search').modal('show');
}

function searchAct(){
	$("#form_search").ajaxSubmit({
		url: base_url+'datasupplier/search_query',
		type: 'post',
		success: function(){
			var table = $('#tb_list').DataTable();
			table.ajax.reload( null, false );
			$('#modal_search').modal('toggle');
			// clearForm();
		}
	});
}

function excelData(){
	window.location = base_url+'datasupplier/excel_supplier';
}

// code code di add new modal
function modalAddSupplier(){
 clearFormInput();
	$('#modal_add_supplier').modal('show');
	$("input[name='kdsupplier']").attr('readonly', false);
	$('#btn_simpan').text('SIMPAN');
	$("input[name='action']").val('SIMPAN');
}

function editKeluar(kdsupplier){

	$.ajax({

		type:"POST",
		url:base_url+"datasupplier/get_data_supplier/"+kdsupplier,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='kdsupplier']").val(data['kd_supplier']);
			$("input[name='kdsupplier']").attr('readonly', true);
			$("input[name='namasupplier']").val(data['nama_supplier']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_supplier').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
	function(result){
		if(result==true){
			window.location = base_url+'datasupplier';
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
	$("input[name='kdsupplier']").val('');
	$("input[name='namasupplier']").val('');
}


function TambahSupplier(){

	var kdsupplier 				= $("input[name='kdsupplier']").val();
	var namasupplier 			= $("input[name='namasupplier']").val();
	var action 						= $("input[name='action']").val();
	//cek textbox yang kosong
	if(kdsupplier=="" || namasupplier==""){

		var title 				= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
		var str_message 	= "KODE SUPPLIER, &amp; NAMA SUPPLIER tidak boleh kosong.";

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
						url:base_url+"datasupplier/cekduplicate/"+kdsupplier,
						dataType:"html",
						success:function(data)
						{
										var data = $.parseJSON(data);

													if (data !== null )
													{//jika supplier sudah ada
															var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;DUPLICATE DATA!!";
															var str_message = "KODE SUPLLIER SUDAH ADA!!!";
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
															'kdsupplier' 		: kdsupplier,
															'namasupplier' 	: namasupplier,
															'action' 				: action
													};
													$.ajax({
																type:"POST",
																url:base_url+"datasupplier/ProsesInsert",
																dataType:"JSON",
																data:json_data,
																success:function(data){
																	window.location = base_url+'datasupplier';
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
				'kdsupplier' 		: kdsupplier,
				'namasupplier' 	: namasupplier,
				'action' 				: action
		};
		$.ajax({
					type:"POST",
					url:base_url+"datasupplier/ProsesInsert",
					dataType:"JSON",
					data:json_data,
					success:function(data){
						window.location = base_url+'datasupplier';
							}
				});
	}
// end
}
