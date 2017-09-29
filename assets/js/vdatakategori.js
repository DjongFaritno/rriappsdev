//load
$(document).ready(function(){
	setTable();
	$(".datepicker").datepicker({autoclose: true,maxDate: '0'});
});

function setTable(){
	var my_table = $('#tb_list').DataTable({
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"datakategori/loaddatatable",
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
		url: base_url+'datakategori/search_query',
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
	window.location = base_url+'datakategori/excel_kategori';
}

// code code di add new modal
function modalAddkategori(){
 	clearFormInput();
	$('#modal_add_kategori').modal('show');
	$("input[name='kdkategori']").attr('readonly', false);
	$('#btn_simpan').text('SIMPAN');
	$("input[name='action']").val('SIMPAN');
	$('#kdkategori').focus();
}

function editKeluar(kdkategori){

	$.ajax({

		type:"POST",
		url:base_url+"datakategori/get_data_kategori/"+kdkategori,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$('#kdkategori').val(data['kd_kategori']);
			$('#kdkategori').attr('readonly', true);
			$('#namakategori').val(data['nama_kategori']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_kategori').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
	function(result){
		if(result==true){
			window.location = base_url+'datakategori';
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
	$("input[name='kdkategori']").val('');
	$("input[name='namakategori']").val('');
}


function TambahKategori(){

	var kdkategori 				= $('#kdkategori').val()
	var namakategori 			= $('#namakategori').val()
	var action 					= $('#action').val()
	//cek textbox yang kosong
	if(kdkategori=="" || namakategori==""){

		var title 				= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
		var str_message 	= "KODE KATEGORI, &amp; NAMA KATEGORI tidak boleh kosong.";

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
						url:base_url+"datakategori/cekduplicate/"+kdkategori,
						dataType:"html",
						success:function(data)
						{
										var data = $.parseJSON(data);

													if (data !== null )
													{//jika kategori sudah ada
															var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;DUPLICATE DATA!!";
															var str_message = "KODE KATEGORI SUDAH ADA!!!";
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
															'kdkategori' 		: kdkategori,
															'namakategori' 	: namakategori,
															'action' 				: action
													};
													$.ajax({
																type:"POST",
																url:base_url+"datakategori/ProsesInsert",
																dataType:"JSON",
																data:json_data,
																success:function(data){
																	window.location = base_url+'datakategori';
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
				'kdkategori' 		: kdkategori,
				'namakategori' 	: namakategori,
				'action' 				: action
		};
		$.ajax({
					type:"POST",
					url:base_url+"datakategori/ProsesInsert",
					dataType:"JSON",
					data:json_data,
					success:function(data){
						window.location = base_url+'datakategori';
							}
				});
	}
// end
}
