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


			$('#txt_Qty').maskMoney({precision:0});
			// $('#angka2').maskMoney({prefix:'US$'});
			// $('#angka3').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
			// $('#angka4').maskMoney();

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


function cancelForm(){

	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
		function(result){
			if(result==true){

				window.location = base_url+'pengajuan';
			}
		}
	);
}

function modalAddItem(){

	$('#txt_Qty').val('');
	$('#modal_add_item').modal('show');
}

function pilihItem(){

	$item  	= $('#opt_item').val();
	$item 	= $item.split('#');

	$('#txt_Nama_kategori').val($item[1]);
}

function tambahItem(){

	var item 					= $('#opt_item').val().split('#');
	var nama_kategori 		= $('#txt_Nama_kategori').val()
	var txt_Qty 	= $('#txt_Qty').val()
	var ukuran 		= $('#txt_ukuran').val()
	var keterangan 		= $('#txt_keterangan').val()

	if(item.length==1){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Kode Barang tidak valid.");
	}
	else if(parseInt(txt_Qty)<1 || txt_Qty==''){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;QTY harus lebih dari 0");
	}
	else if(parseInt(txt_Qty)>0){

		var Kode_Kategori 	= item[0];

		if(cekItem(Kode_Kategori)==true){

			var row_count 		= $('#tb_list tr.tb-detail').length;
			var content_data 	= '<tr class="tb-detail" id="row'+Kode_Kategori+'">';
				content_data 	+= "<td>"+(row_count+1)+"</td>";
				content_data 	+= "<td>"+Kode_Kategori+"</td>";
				content_data 	+= "<td>"+nama_kategori+"</td>";
				content_data 	+= "<td>"+txt_Qty+"</td>";
				content_data 	+= "<td>"+ukuran+"</td>";
				content_data 	+= "<td>"+keterangan+"</td>";
				content_data 	+= '<td><button type="button" class="btn btn-danger btn-xs" ';
				content_data 	+= ' onclick="hapusItem(\''+Kode_Kategori+'\')"><i class="fa fa-fw fa-trash"></i>Hapus</button></td>';
				content_data 	+= "</tr>";

			if(row_count<1){

				$('#tb_list tbody').html(content_data);
			}
			else{

				$('#tb_list tbody').append(content_data);
			}

			$("#hid_jumlah_item").val(row_count+1);
			urutkanNomor();

			$('#modal_add_item').modal('hide');
		}
		else{

			bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Kode Barang "+Kode_Kategori+" sudah ada di list.");
		}
	}
}

function hapusItem(row_id){

	bootbox.confirm("Anda yakin akan menghapus item ini ?",
		function(result){
			if(result==true){

				$('#row'+row_id).remove();
				urutkanNomor();

				var row_count = $('#tb_list tr.tb-detail').length					;

				$('#hid_jumlah_item').val(row_count); //simpan jumlah item


				if(row_count<1){

					var content_data = "<tr><td colspan=\"8\" align=\"center\">Belum Ada Data.</td></tr>";
					$('#tb_list tbody').append(content_data);
				}
			}
		}
	);
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


function simpanData(){

	if(validasiForm()==true){

		//detail data
		var item_data = "";

		var oTable 		= document.getElementById('tb_list');
		var rowLength 	= oTable.rows.length;
			rowLength 	= rowLength-1;

		for (i = 1; i < rowLength; i++){

			var irow = oTable.rows.item(i);

			item_data += irow.cells[1].innerHTML+"#"; //kode kategori
			item_data += irow.cells[3].innerHTML+"#"; //quota
			item_data += irow.cells[4].innerHTML+"#"; //ukuran
			item_data += irow.cells[5].innerHTML+"#"; //keterangan

			item_data += ';';
		}

		//header data
		var no_pengajuan 	= $('#txt_no_pengajuan').val();
		var tgl_pengajuan 	= $('#dtp_tgl_pengajuan').val();

		var json_data 	= {

			'no_pengajuan'		: no_pengajuan,
			'tgl_pengajuan' 	: tgl_pengajuan,
			'item'		: item_data
			};

		$.ajax({

			type:"POST",
			url:base_url+"pengajuan/simpan_pengajuan",
			dataType:"JSON",
			data:json_data,
			success:function(data){

				bootbox.alert({
					message: "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp;Simpan Data Berhasil.",
					size: 'small',
					callback: function () {

						window.location = base_url+'/pengajuan';
					}
				});
			}
		});
	}
}

function validasiForm(){
	if($('#txt_no_pengajuan').val()==''){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;NO PENGAJUAN wajib diisi.");
		return false;
	}

	if($('#hid_jumlah_item').val()=='0'){

		bootbox.alert("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;Item pengajuan masih kosong.");
		return false;
	}
		return true;
}
