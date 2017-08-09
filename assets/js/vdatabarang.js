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
	  ajax: base_url+"databarang/loaddatatable",
	//   fixedColumns:{
	// 	  leftColumns: 0
	// 	},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

function modalSearch(){
	$('#modal_search').modal('show');
}

function searchAct(){
	$("#form_search").ajaxSubmit({
		url: base_url+'databarang/search_query',
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
	window.location = base_url+'databarang/excel_barang';
}

// code code di add new modal
function modalAddBarang(){
 clearFormInput();
	$('#modal_add_barang').modal('show');
	$("input[name='partno']").attr('readonly', false);
	$('#btn_simpan').text('SIMPAN');
	$("input[name='action']").val('SIMPAN');
}

function editKeluar(partno){

	var str_url  	= encodeURI(base_url+"databarang/get_data_barang/"+partno);

	$.ajax({

		type:"POST",
		url:str_url,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='partno']").val(data['partno']);
			$("input[name='partno']").attr('readonly', true);
			$("input[name='uraianbarang']").val(data['uraian_barang']);
			$("input[name='nohs']").val(data['nohs']);
			$("select[name='satuan']").val(data['satuan']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_barang').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
	function(result){
		if(result==true){
			window.location = base_url+'databarang';
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
	// var d 		= new Date();
	// var month 	= d.getMonth()+1;
	// var day 	= d.getDate();
	// var year 	= d.getFullYear();
	// var today 	= day+'-'+month+'-'+year;
	//
	// $("input[name='tgl']").val(today);
	$("input[name='partno']").val('');
	$("input[name='uraianbarang']").val('');
	$("input[name='nohs']").val('');
	$("input[name='satuan']").val('');
}


function TambahBarang(){

	var partno 				= $("input[name='partno']").val();
	var uraianbarang 	= $("input[name='uraianbarang']").val();
	var nohs 					= $("input[name='nohs']").val();
	var satuan 				= $("select[name='satuan']").val();
	var action 				= $("input[name='action']").val();
	//cek textbox yang kosong
	if(partno=="" || uraianbarang=="" || nohs=="" || satuan==""){

		var title 		= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
		var str_message = "PARTNO, &amp; URAIAN BARANG, &amp; NO HS, &amp; SATUAN tidak boleh kosong.";

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
	// add new apa update, jika add new cek data sudah ada atau belum
	if (action == 'SIMPAN')
	{
		
						$.ajax({

						type:"POST",
						url:base_url+"databarang/cekduplicate/"+partno,
						dataType:"html",
						success:function(data)
						{
										var data = $.parseJSON(data);

													if (data !== null )
													{//jika barang sudah ada
															var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;DUPLICATE DATA!!";
															var str_message = "PARTNO SUDAH ADA!!!";
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
															'partno' 				: partno,
															'uraianbarang' 	: uraianbarang,
															'nohs' 					: nohs,
															'satuan' 				: satuan,
															'action' 				: action
													};
													$.ajax({
																type:"POST",
																url:base_url+"databarang/ProsesInsert",
																dataType:"JSON",
																data:json_data,
																success:function(data){
																	window.location = base_url+'databarang';
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
						'partno' 				: partno,
						'uraianbarang' 	: uraianbarang,
						'nohs' 					: nohs,
						'satuan' 				: satuan,
						'action' 				: action
				};
				$.ajax({
							type:"POST",
							url:base_url+"databarang/ProsesInsert",
							dataType:"JSON",
							data:json_data,
							success:function(data){
								window.location = base_url+'databarang';
							}
				});
	}

// end

}
