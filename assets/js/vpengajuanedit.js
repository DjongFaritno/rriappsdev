//load
$(document).ready(function(){
	setTable();
	$('.datepicker').datepicker({
		autoclose: true
	});
	// $(".datepicker").datepicker({autoclose: true,maxDate: '0'});

	$('.numbers-only').keypress(function(event) {

		var charCode = (event.which) ? event.which : event.keyCode;
			if ((charCode >= 48 && charCode <= 57)
				|| charCode == 46
				|| charCode == 44
				|| charCode == 8)
				return true;
		return false;
	});
		$(".select2").select2();
		pilihItem();
		$('#txt_Qty').maskMoney({precision:0});
});


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

function setTable(){
	var nopengajuan =$('#txt_id_pengajuan').val()
	var status =$('#status').val()
	var my_table = $('#tb_list').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"pengajuan/loaddatatableviewedit/"+nopengajuan+"/"+status,
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


function FormPengajuanBAru()
{
	window.location = base_url+'pengajuan/add_pengajuan'
}

function ViewDetailPengajuan(nopengajuan){

	$.ajax({

		type:"POST",
		url:base_url+"pengajuan/get_data_pengajuan/"+nopengajuan,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='nopengajuan']").val(data['nopengajuan']);
			$("input[name='nopengajuan']").attr('readonly', true);
			$("input[name='dtp_tgl_pengajuan']").val(data['tgl_pengajuan']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_Pengajuan').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
	function(result){
		if(result==true){
			window.location = base_url+'pengajuan';
		}
	}
	);
}

function BacktoPengajuan(){

			window.location = base_url+'pengajuan';

}

function ViewDt2(id_sub){
	// bootbox.confirm("ON PROGRESS bray!!",
	// function(result){
	// 	if(result==true){
			window.location = base_url+'pengajuan/view_pengajuandt2/'+id_sub;
	// 	}
	// }
	// );
}

function DeleteKategori(idsub,idpengajuan,kd_kategori){
	var status =$('#status').val()
	if(status=='nonactive')
	{
		bootbox.alert("<div class='callout callout-danger'><span class='glyphicon glyphicon-exclamation-sign'></span>Tidak Bisa Dihapus</div>",
			function(result){
				if(result==true){

				}
			}
		);
	}else{
		bootbox.confirm("Anda yakin akan menghapus "+kd_kategori+" ?",
			function(result){
				if(result==true){

					$.post(
						base_url+"pengajuan/delete_Sub/"+idsub,function(){
							window.location = base_url+'pengajuan/pengajuanEdit/'+idpengajuan;
						}
					);
				}
			}
		);
	}
}

function ONprosses(){

	bootbox.alert("<div class='callout callout-danger'><span class='glyphicon glyphicon-exclamation-sign'></span>SEDANG DALAM PENGERJAAN! </div>",
		function(result){
			if(result==true){

			}
		}
	);
}

function btnTGL(){
	$('#BtnTglUpd').show();

}

function UpdateTanggal(){
	$('#BtnTglUpd').hide();
	var nopengajuan 	= $('#txt_no_pengajuan').val();
	var tgl_pengajuan 	= $('#dtp_tgl_pengajuan').val();
	var json_data 	= {
	'nopengajuan'		: nopengajuan,
	'tgl_pengajuan' 	: tgl_pengajuan,
	};

$.ajax({

	type:"POST",
	url:base_url+"pengajuan/updatePengajuan",
	dataType:"JSON",
	data:json_data,
	success:function(data){

		bootbox.alert({
			message: "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp;tanggal sudah dirubah.",
			size: 'small',
			// callback: function () {
			//
			// 	window.location = base_url+'/pengajuan';
			// }
		});
	}
});


}

function modalAddItem(){

	$('#txt_Qty').val('');
	$('#txt_ukuran').val('');
	$('#txt_keterangan').val('');
	$('#modal_add_item').modal('show');
	$("input[name='action']").val('SIMPAN');
}

function pilihItem(){

	$item  	= $('#opt_item').val();
	$item 	= $item.split('#');

	$('#txt_Nama_kategori').val($item[1]);
}

function tambahItem(){
	var idpengajuan =$('#txt_id_pengajuan').val()
	var item 					= $('#opt_item').val().split('#');
	var nama_kategori = $('#txt_Nama_kategori').val();
	var txt_Qty 	= $('#txt_Qty').val();
	var ukuran 		= $('#txt_ukuran').val();
	var keterangan 		= $('#txt_keterangan').val();
	var kategori 				= item[0];
	var nopengajuan 		= $('#txt_no_pengajuan').val();
	var action 					= $('#action').val();

	if(item.length==1){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Kode Kategori tidak valid.");
	}
	else if(parseInt(txt_Qty)<1 || txt_Qty==''){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;QTY harus lebih dari 0");
	}

	else if (action == 'SIMPAN') // add new apa update, jika add new cek data sudah ada atau belum
	{
						$.ajax({

						type:"POST",
						url:base_url+"pengajuan/cekduplicatekategori/"+nopengajuan+"/"+kategori,
						dataType:"html",
						success:function(data)
						{
										var data = $.parseJSON(data);
										// print(data);

													if (data !== null )
													{//jika barang sudah ada
															var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;DUPLICATE DATA!!";
															var str_message = "KATEGORI SUDAH ADA!!!";
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
															'nopengajuan' : nopengajuan,
															'kategori' 	: kategori,
															'txt_Qty' 	: txt_Qty,
															'keterangan' : keterangan,
															'action' 	: action
													};
													$.ajax({
																type:"POST",
																url:base_url+"pengajuan/ProsesInsertKategori",
																dataType:"JSON",
																data:json_data,
																success:function(data){
																	window.location = base_url+'pengajuan/pengajuanEdit/'+idpengajuan;
																}
													});
													// }
						}
					});
	}else{
		//tidak ada, ok proses simpan
				$('#btn_simpan').hide();
				$('#img-load').show();

				var json_data 	=
				{
						'nopengajuan' : nopengajuan,
						'kategori' 	: kategori,
						'txt_Qty' 	: txt_Qty,
						'keterangan' : keterangan,
						'action' 	: action
				};
				$.ajax({
							type:"POST",
							url:base_url+"pengajuan/ProsesInsertKategori",
							dataType:"JSON",
							data:json_data,
							success:function(data){
								window.location = base_url+'pengajuan/pengajuanEdit/'+nopengajuan;
							}
				});
	}

	// end
}

function cekItem(i_kode_kategori){
		var oTable  	= document.getElementById('tb_list');
		var rowLength = oTable.rows.length;
		var itemcount = $('#hid_jumlah_item').val();
		rowLength = rowLength-1;

		if(itemcount=="0"){ //jika item kosong

			return true;
		}
		else{

			for (i = 1; i < rowLength; i++)
			{
				var kode_kategori = oTable.rows.item(i).cells[1].innerHTML;
				// print(kode_kategori);
				if(kode_kategori==i_kode_kategori){

						return false;
				}
			}
			return true;
		}
		// console.log(oTable);
}
function urutkanNomor(){

	var oTable = document.getElementById('tb_list');

	//hitung table row
	var rowLength = oTable.rows.length;
		rowLength = rowLength-1;

	//urutkan nomor per row
	for (i = 1; i < rowLength; i++){

		oTable.rows.item(i).cells[0].innerHTML = i;
	}
}
