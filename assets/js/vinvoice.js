//load
$(document).ready(function(){
	setTable();
	$(".datepicker").datepicker({autoclose: true,maxDate: '0'});
	$(".select2").select2();

	// pilihItem();
});

function OtomatisKapital(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function setTable(){
	var my_table = $('#tb_list').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"invoice/loaddatatable/",
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

function VinvoiceDT(idinvoicehd,noinvoice){
	// bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;" +noinvoice+" Sedang Proses Pengerjaan.");
	window.location = base_url+'invoice/invoicedt/'+idinvoicehd;
}

function pilihItem(){

	$item  	= $('#opt_item').val();
	$item 	= $item.split('#');

	$('#txt_Nama_Supplier').val($item[1]);
}
function ModalUpload()
{
  $("input[name='file']").val('');
  $('#Modal_Upload_Invoice').modal('show');
}

function HapusInvoice(idinvoicehd,noinvoice){
	// bootbox.confirm("Anda yakin akan menghapus "+idinvoicehd+" ?",
	// 	function(result){
	// 		if(result==true){
	//
	// 			$.post(
	// 				base_url+"DataBarang/delete_barang/"+idinvoicehd,function(){
	// 					window.location = base_url+'invoice/';
	// 				}
	// 			);
	// 		}
	// 	}

		bootbox.confirm("Yakin Akan Menghapus "+noinvoice+"?",
		function(result){
			if(result==true){
				$.post(
					base_url+"invoice/HapusInvoice/"+idinvoicehd,function(){
						window.location = base_url+'invoice/';
					}
				);
			}
		}
		);

}

// function BtnUpInvoice()
// {
// 	var noinvoice 		= $('#noinvoice').val();
// 	var tglinvoice 		= $('#tglinvoice').val();
// 	var file 					= $('#file').val();
// 	var item 					= $('#opt_item').val().split('#');
// 	var kd_supplier 	= item[0];
//
// 	// window.location = base_url+'invoice/upload/';
//
//
// 		// var title 		= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
// 		// var str_message = "PILIH INVOICE YANG AKAN DI UPLOAD";
// 		//
// 		// bootbox.alert({
// 		// 	size:'small',
// 		// 	title:title,
// 		// 	message:str_message,
// 		// 	buttons:{
// 		// 		ok:{
// 		// 			label: 'OK',
// 		// 			className: 'btn-warning'
// 		// 		}
// 		// 	}
// 		// });
// 		// return false;
//
// }
//
function unduhINVIMPORT()
{
	window.location = base_url+'assets/dwn/imp_inv.xls';
}
