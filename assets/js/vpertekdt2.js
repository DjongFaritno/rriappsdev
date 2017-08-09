//load
$(document).ready(function(){

	$('.datepicker').datepicker({
			autoclose: true
		});

	setTable();
});

function setTable(){
	var idsub =$('#txt_idsub').val()
	var my_table = $('#tb_listx').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"pertek/loaddatatablepart/"+idsub,
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


function BacktopertekDT1(){
	var nopertek = $('#txt_id_Pertek').val();

			window.location = base_url+'pertek/view_pertek/'+nopertek;

}
