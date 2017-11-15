$(document).ready(function(){
	setTable();

	$('.datepicker').datepicker({
			autoclose: true
		});

});

function setTable()
{
	var noinvoice =$('#txt_idinvoicehd').val()
	var my_table = $('#tb_listx').DataTable({
	//   scrollCollapse:  true,
	//   scrollX:         true,
	  processing:      true,
	  serverSide:      true,
	  ordering:        false,
    paging:          false,
    ordering:        false,
    info:            true,
    searching : true,
	  ajax: base_url+"invoice/LoadTableEimport/"+noinvoice,
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

function OtomatisKapital(a)
{
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function BacktoInvoice()
{
	window.location = base_url+'invoice';
}

function SimpanEimport()
{
	var idinvoicehd 		= $('#txt_idinvoicehd').val();
	var noinvoice 			= $('#txt_no_invoice').val();
	var kd_supplier 		= $('#txt_kdsupplier').val();
	var tgl_invoice 		= $('#txt_tgl_invoice').val();
	var nodaftar_pib 		= $('#txt_nodaftar_pib').val();
	var tgldaftar_pib 		= $('#dtp_tgl_pib').val();
	var noaju 				= $('#txt_noaju').val();
	var tgl_aju 			= $('#dtp_tgl_aju').val();
	var negara_asal 		= $('#txt_Negara_Asal').val();
	var pelabuhan_muat 		= $('#txt_pelabuhanmuat').val();
	$.ajax({
		
		type:"POST",
		url:base_url+"invoice/cek_over_kuota/"+idinvoicehd,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);
			// if (data !=null)
			// {	
				if(data == 'OVER')
				{
					bootbox.alert({
						title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;ALERT</div>",
						message: "<b>Simpan Gagal, kuota pengiriman melebihi kuota PERTEK</b>",
						buttons: 
						{
							ok: {
								label: 'TUTUP',
								className: 'btn-danger'
							}
						}
					})
					return false;
					
				}
				else
				{
					bootbox.confirm("Simpan Invoice "+noinvoice+"?",
					function(result)
					{
						if(result==true)
						{
							if(ValidasiInvoiceHDForm(idinvoicehd)==true)
							{
								
								
								var json_data = {
									'idinvoicehd' 		: idinvoicehd,
									'noinvoice' 		: noinvoice,
									'kd_supplier' 		: kd_supplier,
									'tgl_invoice' 		: tgl_invoice,
									'nodaftar_pib' 		: nodaftar_pib,
									'tgldaftar_pib' 	: tgldaftar_pib,
									'noaju' 			: noaju,
									'tgl_aju' 			: tgl_aju,
									'negara_asal' 		: negara_asal,
									'pelabuhan_muat' 	: pelabuhan_muat
								};
			
								$.ajax({
									type:"POST",
									url:base_url+"invoice/SaveEimportToinvoice",
									dataType:"JSON",
									data:json_data,
									success:function(data){
			
										bootbox.alert({
											message: "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp;Simpan Data Berhasil.",
											size: 'small',
											callback: function () {
												window.location = base_url+'/invoice';
											}
										});
									}
								});
			
							}
			
						}
					}
				);
				}	
				
			// }
		}

	});

	

}

function ValidasiInvoiceHDForm(idinvoicehd)
{
	if($('#txt_nodaftar_pib').val()=='')
	{
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;NO DAFTAR PIB wajib diisi.");
		return false;
	}

	if($('#txt_noaju').val()=='')
	{
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;NO AJU wajib diisi.");
		return false;
	}

	if($('#txt_Negara_Asal').val()=='')
	{
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;NEGARA ASAL wajib diisi.");
		return false;
	}

	if($('#txt_pelabuhanmuat').val()=='')
	{
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;PELABUHAN MUAT wajib diisi.");
		return false;
	}

	if($('#txt_status').val()=='OVER')
	{
		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Simpan gagal, Over Kuota.");
		return false;
	}
	return true;

	

	// return false;
}
