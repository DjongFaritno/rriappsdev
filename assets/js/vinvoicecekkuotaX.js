$(document).ready(function(){
	setTable();
});

function setTable(){
	var noinvoice =$('#txt_no_invoice').val()
	var my_table = $('#tb_listx').DataTable({
	  // scrollCollapse:  true,
	  // scrollX:         true,
	  processing:      true,
	  serverSide:      true,
	  ordering:        false,
    paging:          false,
    ordering:        false,
    info:            true,
    searching : true,
	  ajax: base_url+"invoice/LoadTableEimportX/"+noinvoice,
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}
