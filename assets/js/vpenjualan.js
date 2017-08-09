$(document).ready(function(){

	setTable();

	$(".datepicker").datepicker();
});

function setTable(){

	var my_table = $('#tb_list').DataTable({
		// scrollY:'70vh',
		// scrollCollapse: true,
		// scrollX: true,
		processing: true,
		serverSide: true,
		ordering: false,
		ajax: base_url+"penjualan/load_grid",
		fixedColumns:{
			leftColumns: 2
		},
		bFilter:false,
		dom: "<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'l><'col-sm-7'pi>>"
	});
}

function modalSearch(){

	$('#modal_search').modal('show');
}

function searchAct(){

	$("#form_search").ajaxSubmit({
		url: base_url+'penjualan/search_query',
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

	window.location = base_url+'penjualan/excel_penjualan';
}

function printSJ(nojual){

	var data = 'str='+nojual;
	var qs_encrypt = $.ajax({
							type:"POST",
							url:base_url+"penjualan/get_encrypt",
							async: false,
							data:data
		}).responseText;

	window.open(base_url+"penjualan/printSJ/"+qs_encrypt, '_blank');
}

function hapusJual(no_jual){

	bootbox.confirm("Anda yakin akan menghapus data ini ?",
		function(result){
			if(result==true){

				$.post(
					base_url+"penjualan/delete_jual/"+no_jual,function(){

						var table = $('#tb_list').DataTable();
						table.ajax.reload( null, false );
					}
				);
			}
		}
	);
}
