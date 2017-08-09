$(document).ready(function(){
	setTable();
});

function setTable(){
    var idinvoicehd = $('#txt_noinvoice').val();
	var my_table = $('#tb_list').DataTable({
	  // scrollY:'70vh',
	  // scrollCollapse: false,
	  // scrollX: false,
		bPaginate: false,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"invoice/loaddatatable_invoicedt/"+idinvoicehd,
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

function Backtoinvoice(){
    window.location = base_url+'invoice/';
}
