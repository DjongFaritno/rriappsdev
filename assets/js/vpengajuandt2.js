//load
$(document).ready(function(){
	$('.numbers-only').keypress(function(event) {
		var charCode = (event.which) ? event.which : event.keyCode;
			if ((charCode >= 48 && charCode <= 57)
				|| charCode == 46
				|| charCode == 44
				|| charCode == 8)
				return true;
		return false;
	});

	$('.datepicker').datepicker({
			autoclose: true
		});

	$(".select2").select2();

	pilihItem();
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
	  paging: false,
	  ajax: base_url+"pengajuan/loaddatatablepart/"+idsub,
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
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

function cancelForm(){

	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
		function(result){
			if(result==true){

				window.location = base_url+'pengajuan';
			}
		}
	);
}

function BacktoPengajuanDT1(){
	var nopengajuan = $('#txt_id_pengajuan').val();

			window.location = base_url+'pengajuan/view_pengajuan/'+nopengajuan;

}

function modalAddItem(){
	var status =$('#status').val()
	if(status=='nonactive')
	{
		bootbox.alert({
			title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;PERINGATAN!!</div>",
			message: "Tidak bisa tambah Part,Karena sudah dijadikan PERTEK",
			// buttons: {
				OK: {
					label: '<i class="fa fa-check"></i> Ya',
					className: 'btn-danger'
				}
			// },
		});
	}else{
		$('#txt_Qty').val('');
		$('#modal_add_item').modal('show');
		$('#btn_simpan').text('SIMPAN');
		$("input[name='action']").val('SIMPAN');
	}
}

function pilihItem(){

	$item  	= $('#opt_item').val();
	$item 	= $item.split('#');
	$('#txt_uraian_barang').val($item[1]);
	$('#txt_nohs').val($item[2]);
	$('#txt_satuan').val($item[3]);
}

function TambahBarang(){
	var nopengajuan  			= $('#txt_no_pengajuan').val();
	var item 					= $('#opt_item').val().split('#');
	var partno 					= item[0];
	var idsub 					= $('#txt_id_sub').val();
	var action 					= $('#action').val();

	if(item.length==1){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Kode Barang tidak valid.");
	}
	else if (action == 'SIMPAN') // add new apa update, jika add new cek data sudah ada atau belum
	{
		// var str_url  	= encodeURI(base_url+"pengajuan/cekduplicatepart/"+idsub+"/"+partno);
		var str_url  	= encodeURI(base_url+"pengajuan/cekduplicatepart/"+partno);
			$.ajax({

			type:"POST",
			// url:base_url+"pengajuan/cekduplicatepart/"+idsub+"/"+partno,
			url:str_url,
			dataType:"html",
			success:function(data)
			{
				var data = $.parseJSON(data);
				// print(data);
				
					if (data !== null )
					{//jika barang sudah ada
						var nopengajuan_D = data['nopengajuan'];
						var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;PERINGATAN!!";
						var str_message = "Part tidak bisa disimpan karena sudah ada di Pengajuan "+nopengajuan_D+" dengan status ACTIVE!!!";
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
					else
					{
						$('#btn_simpan').hide();
						$('#img-load').show();

						var json_data 	=
						{
							'nopengajuan' : nopengajuan,
							'partno' 	: partno,
							'idsub' 	: idsub,
							'action' 	: action
						};
						$.ajax({
							type:"POST",
							url:base_url+"pengajuan/ProsesInsertPart",
							dataType:"JSON",
							data:json_data,
							success:function(data){
								window.location = base_url+'pengajuan/view_pengajuandt2/'+idsub;
							}
						});
					}
			}
		});
	}else{
		//tidak ada, ok proses simpan
		$('#btn_simpan').hide();
		$('#img-load').show();

		var json_data 	=
		{
			'nopengajuan' : nopengajuan,
				'partno' 	: partno,
				'idsub' 	: idsub,
				'action' 	: action
		};
		$.ajax({
			type:"POST",
			url:base_url+"pengajuan/ProsesInsertPart",
			dataType:"JSON",
			data:json_data,
			success:function(data){
				window.location = base_url+'pengajuan/view_pengajuandt2/'+idsub;
			}
		});
	}

}


function  DeletePart(idsub,partno){
	var status =$('#status').val()
	if(status=='nonactive')
	{
		bootbox.alert({
			title: "<div class='callout callout-danger'><span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;PERINGATAN!!</div>",
			message: "Tidak bisa Hapus Part <b>"+partno+"</b>,Karena sudah dijadikan PERTEK",
			// buttons: {
				OK: {
					label: '<i class="fa fa-check"></i> Ya',
					className: 'btn-danger'
				}
			// },
		});
	}else{
		bootbox.confirm("Anda yakin akan menghapus "+partno+" ?",
			function(result){
				if(result==true){

					$.post(
						base_url+"pengajuan/delete_part/"+idsub+"/"+partno,function(){
							window.location = base_url+'pengajuan/view_pengajuandt2/'+idsub;
						}
					);
				}
			}
		);
	}
}

function  UbahPartno(idsub,partno){
	bootbox.confirm("ON PROSSES ?",
		function(result){
			if(result==true){

				//
				// $.post(
				// 	base_url+"pengajuan/delete_part/"+idsub+"/"+partno,function(){
				// 		window.location = base_url+'pengajuan/view_pengajuandt2/'+idsub;
				// 	}
				// );
			}
		}
	);
}
