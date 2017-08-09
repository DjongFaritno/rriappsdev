//load
$(document).ready(function(){
	setTable();
	$(".datepicker").datepicker({autoclose: true,maxDate: '0'});
});

function setTable(){
	var my_table = $('#tb_list').DataTable({
	//   scrollY:'70vh',
	//   scrollCollapse: true,
	//   scrollX: true,
	  processing: true,
	  serverSide: true,
	  ordering: false,
	  ajax: base_url+"datauser/loaddatatable",
	  fixedColumns:{
		  leftColumns: 0
		},
	  bFilter:false,
	  dom: "<'row'<'col-sm-12'tr>>" +
	      "<'row'<'col-sm-5'l><'col-sm-7'pi>>" });
}

function modalSearch(){
	$('#modal_search').modal('show');
}

function searchAct(){
	$("#form_search").ajaxSubmit({
		url: base_url+'datauser/search_query',
		type: 'post',
		success: function(){
			var table = $('#tb_list').DataTable();
			table.ajax.reload( null, false );
			$('#modal_search').modal('toggle');
			// clearForm();
		}
	});
}

// function excelData(){
// 	window.location = base_url+'datauser/excel_user';
// }

// code code di add new modal
function modalAddUser(){
 clearFormInput();
	$('#modal_add_user').modal('show');
	$("input[name='username']").attr('readonly', false);
	$('#btn_simpan').text('SIMPAN');
	$("input[name='action']").val('SIMPAN');
	//filter input
	document.getElementById( 'g_username' ).style.display = ''
	document.getElementById( 'g_fullname' ).style.display = ''
	document.getElementById( 'g_email' ).style.display = ''
	document.getElementById( 'g_privilege' ).style.display = ''
	document.getElementById( 'g_password' ).style.display = ''
	document.getElementById( 'g_cpassword' ).style.display = ''
}

function editKeluar(username){
	clearFormInput();
	$.ajax({

		type:"POST",
		url:base_url+"datauser/get_data_user/"+username,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='username']").val(data['username']);
			$("input[name='username']").attr('readonly', true);
			$("input[name='fullname']").val(data['full_name']);
			$("input[name='email']").val(data['email']);
			$("input[name='password']").val(data['password']);
			$("input[name='cpassword']").val(data['password']);
			$("select[name='privilege']").val(data['privilege']);
			$("input[name='action']").val('PERBAHARUI');
			// sel.options[sel.selectedIndex].value;
			//filter input
			document.getElementById( 'g_username' ).style.display = ''
			document.getElementById( 'g_fullname' ).style.display = ''
			document.getElementById( 'g_email' ).style.display = ''
			document.getElementById( 'g_privilege' ).style.display = ''
			document.getElementById( 'g_password' ).style.display = 'none'
			document.getElementById( 'g_cpassword' ).style.display = 'none'
			$('#btn_simpan').text('PERBAHARUI');
			$('#modal_add_user').modal('show');
		}
	});
}

function ResetPassword(username){
	clearFormInput();
	$.ajax({

		type:"POST",
		url:base_url+"datauser/get_data_user/"+username,
		dataType:"html",
		success:function(data){

			var data = $.parseJSON(data);

			$("input[name='username']").val(data['username']);
			$("input[name='username']").attr('readonly', true);
			$("input[name='fullname']").val(data['full_name']);
			$("input[name='email']").val(data['email']);
			// $("input[name='password']").val(data['password']);
			// $("input[name='cpassword']").val(data['password']);
			$("select[name='privilege']").val(data['privilege']);
			$("input[name='action']").val('RESETPASSWORD');
			// sel.options[sel.selectedIndex].value;
			//filter input
			document.getElementById( 'g_username' ).style.display = 'none'
			document.getElementById( 'g_fullname' ).style.display = 'none'
			document.getElementById( 'g_email' ).style.display = 'none'
			document.getElementById( 'g_privilege' ).style.display = 'none'
			document.getElementById( 'g_password' ).style.display = ''
			document.getElementById( 'g_cpassword' ).style.display = ''
			$('#btn_simpan').text('PERBAHARUI PASSWORD');
			$('#modal_add_user').modal('show');
		}
	});
}

function cancelForm(){
	bootbox.confirm("Anda yakin akan membatalkan form ini ?",
	function(result){
		if(result==true){
			window.location = base_url+'datauser';
		}
	}
	);
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

function clearFormInput(){
	$("input[name='username']").val('');
	$("input[name='fullname']").val('');
	$("input[name='email']").val('');
	$("select[name='privilege']").val('');
	$("input[name='password']").val('');
	$("input[name='cpassword']").val('');
}


function TambahUser(){

	var username 				= $("input[name='username']").val();
	var fullname 				= $("input[name='fullname']").val();
	var email 					= $("input[name='email']").val();
	var privilege 			= $("select[name='privilege']").val();
	var password 				= $("input[name='password']").val();
	var cpassword 			= $("input[name='cpassword']").val();
	var action 					= $("input[name='action']").val();
	//cek textbox yang kosong
	if(username=="" || fullname=="" || email=="" || privilege=="" || password=="" || cpassword==""){

		var title 		= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
		var str_message = "USERNAME, &amp; FULL NAME, &amp; EMAIL, &amp PRIVILEGE, &amp PASSWORD, &amp CONFIRM PASSWORD tidak boleh kosong.";

		bootbox.alert({
			size:'small',
			title:title,
			message:str_message,
			buttons:{
				ok:{
					label: 'OK',
					className: 'btn-warning'
				}
			}
		});
		return false;
	}
	else if(password !== cpassword){

			var title 		= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
			var str_message = "PASSWORD dan CONFIRM PASSWORD tidak sama!!";

			bootbox.alert({
				size:'small',
				title:title,
				message:str_message,
				buttons:{
					ok:{
						label: 'OK',
						className: 'btn-warning'
					}
				}
			});
			return false;
		}
	// add new apa update, jika add new cek data sudah ada atau belum
	if (action == 'SIMPAN')
	{
						$.ajax({

						type:"POST",
						url:base_url+"datauser/cekduplicate/"+username,
						dataType:"html",
						success:function(data)
						{
										var data = $.parseJSON(data);

													if (data !== null )
													{//jika barang sudah ada
															var title 		= "<span class='fa fa-exclamation-triangle text-danger'></span>&nbsp;DUPLICATE DATA!!";
															var str_message = "USERNAME SUDAH ADA!!!";
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
															'username' 		: username,
															'fullname' 		: fullname,
															'email' 			: email,
															'privilege' 	: privilege,
															'password'		:	password,
															'action' 			: action
													};
													$.ajax({
																type:"POST",
																url:base_url+"datauser/ProsesInsert",
																dataType:"JSON",
																data:json_data,
																success:function(data){
																	window.location = base_url+'datauser';
																}
													});
													// }
						}
					});
	}else{
		//brang tidak ada, ok proses simpan
				$('#btn_simpan').hide();
				$('#img-load').show();

				var json_data 	=
				{
					'username' 		: username,
					'fullname' 		: fullname,
					'email' 			: email,
					'privilege' 	: privilege,
					'password'		: password,
					'action' 			: action
				};
				$.ajax({
							type:"POST",
							url:base_url+"datauser/ProsesInsert",
							dataType:"JSON",
							data:json_data,
							success:function(data){
								window.location = base_url+'datauser';
							}
				});
	}

// end

}
