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

function ModalUpload(){
  $("input[name='file']").val('');
  $('#Modal_Upload_Invoice').modal('show');
}

function HapusInvoice(idinvoicehd,noinvoice){
	// onprosses();
	bootbox.confirm({
		title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;KONFIRMASI</div>",
		message: "<b>Yakin Akan Menghapus "+noinvoice+"</b>",
		buttons:
		{
			cancel: {
				label: '<i class="fa fa-times"></i> Tidak',
				className: 'btn-success'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Ya',
				className: 'btn-danger'
			}
		},
		callback: function(result){
			if (result==true){
				var str_url  	= encodeURI(base_url+"invoice/delete_invoice/"+idinvoicehd);
				
				$.ajax({

					type:"POST",
					url:str_url,
					dataType:"html",
					success:function(data)
					{
						bootbox.alert({
							message: "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp;Hapus Data Berhasil.",
							size: 'small',
							callback: function () {

								window.location = base_url+'/invoice';
							}
						});
					}
				})
			}
		}
		
	})


}

function BtnUpInvoice(){

	var noinvoice 		= $('#noinvoice').val();
	var tglinvoice 		= $('#tglinvoice').val();
	var file 			= $('#file').val();
	var item 			= $('#opt_item').val().split('#');
	var kd_supplier 	= item[0];

	// window.location = base_url+'invoice/upload/';
	$('#btn_UpInvoice').hide();
	$('#img-load').show();

	if(validasi_upload()==true)
	{
		bootbox.confirm("Unggah Invoice "+noinvoice+"?",
		function(result)
			{	
				if(result==true)
				{
					
					var iform = $('#form_upload_invoice')[0];
					var data = new FormData(iform);
	

						$.ajax({
							type:"POST",
							url:base_url+"invoice/upload",
							type: 'post',
							enctype: 'multipart/form-data',
							contentType: false,
							processData: false,
							data: data,
							// dataType:"JSON",
							// data:json_data,
							success:function(data){

								bootbox.alert({
									message: "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp;Unggah Data Berhasil.",
									size: 'small',
									callback: function () {
										window.location = base_url+'/invoice/cekkuota';
									}
								});
							}
						});

					// }

				}
				else
				{
					$('#btn_UpInvoice').show();
					$('#img-load').hide();
				}
			}
		);
	}

}

function validasi_upload(){
	if($('#noinvoice').val() == '')
	{	
		bootbox.alert({
			title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;ALERT</div>",
			message: "<b>No Invoice Masih Kosong</b>",
			buttons: 
			{
				ok: {
					label: 'TUTUP',
					className: 'btn-danger'
				}
			}
		})
		return false();

	}

	if($('#opt_item').val() == '')
	{	
		bootbox.alert({
			title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;ALERT</div>",
			message: "<b>Kode Supplier Masih Kosong</b>",
			buttons: 
			{
				ok: {
					label: 'TUTUP',
					className: 'btn-danger'
				}
			}
		})
		return false();

	}

	if($('#file').val() == '')
	{	
		bootbox.alert({
			title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;ALERT</div>",
			message: "<b>Tidak Ada File Yang Dipilih</b>",
			buttons: 
			{
				ok: {
					label: 'TUTUP',
					className: 'btn-danger'
				}
			}
		})
		return false();

	}

	return true;
}

function unduhINVIMPORT()
{
	window.location = base_url+'assets/dwn/imp_inv.xls';
}

function onprosses(){
		bootbox.alert({
		title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;ON PROGRESS 😎</div>",
		message: "<b><font size='30'>WILL BE AVAILABE SOON! 🙏🏻</font></b>",
		buttons: 
		{
			ok: {
				label: 'OKAY 🤦‍',
				className: 'btn-danger'
			}
		}
	})
}
