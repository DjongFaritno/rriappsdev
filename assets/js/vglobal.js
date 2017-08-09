function UserPassword(){
 clearFormInputNav();

$.ajax({

 type:"POST",
 url:base_url+"datauser/get_data_user/"+username,
 dataType:"html",
 success:function(data){

	 var data = $.parseJSON(data);

	 $("input[name='nusername']").val(data['username']);
	 $("input[name='nusername']").attr('readonly', true);
	 $("input[name='nfullname']").val(data['full_name']);
	 $("input[name='nemail']").val(data['email']);
	 // $("input[name='password']").val(data['password']);
	 // $("input[name='cpassword']").val(data['password']);
	 $("select[name='nprivilege']").val(data['privilege']);
	 $("input[name='naction']").val('RESETPASSWORD');
	 // sel.options[sel.selectedIndex].value;
	 //filter input
	 document.getElementById( 'g_nusername' ).style.display = 'none'
	 document.getElementById( 'g_nfullname' ).style.display = 'none'
	 document.getElementById( 'g_nemail' ).style.display = 'none'
	 document.getElementById( 'g_nprivilege' ).style.display = 'none'
	 document.getElementById( 'g_npassword' ).style.display = ''
	 document.getElementById( 'g_ncpassword' ).style.display = ''
	 $('#btn_simpannav').text('PERBAHARUI PASSWORD');
	 $('#modal_add_UserProfile').modal('show');
 }
});
}

function UserProfile(){
 clearFormInputNav();

$.ajax({

 type:"POST",
 url:base_url+"datauser/get_data_user/"+username,
 dataType:"html",
 success:function(data){

	 var data = $.parseJSON(data);

	 $("input[name='nusername']").val(data['username']);
	 $("input[name='nusername']").attr('readonly', true);
	 $("input[name='nfullname']").val(data['full_name']);
	 $("input[name='nemail']").val(data['email']);
	 $("input[name='npassword']").val(data['password']);
	 $("input[name='ncpassword']").val(data['password']);
	 $("select[name='nprivilege']").val(data['privilege']);
	//  $("input[name='nprivilege']").attr('readonly', true);
	 $("input[name='naction']").val('PERBAHARUI');
	 // sel.options[sel.selectedIndex].value;
	 //filter input
	 document.getElementById( 'g_nusername' ).style.display = ''
	 document.getElementById( 'g_nfullname' ).style.display = ''
	 document.getElementById( 'g_nemail' ).style.display = ''
	 document.getElementById( 'g_nprivilege' ).style.display = ''
	 document.getElementById( 'g_npassword' ).style.display = 'none'
	 document.getElementById( 'g_ncpassword' ).style.display = 'none'
	 $('#btn_simpannav').text('PERBAHARUI PROFILE');
	 $('#modal_add_UserProfile').modal('show');
 }
});
}


function clearFormInputNav(){
	$("input[name='nusername']").val('');
	$("input[name='nfullname']").val('');
	$("input[name='nemail']").val('');
	$("select[name='nprivilege']").val('');
	$("input[name='npassword']").val('');
	$("input[name='ncpassword']").val('');
}


function HurufBesar(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}


function TambahUserNav(){

	var username 				= $("input[name='nusername']").val();
	var fullname 				= $("input[name='nfullname']").val();
	var email 					= $("input[name='nemail']").val();
	var privilege 			= $("select[name='nprivilege']").val();
	var password 				= $("input[name='npassword']").val();
	var cpassword 			= $("input[name='ncpassword']").val();
	var action 					= $("input[name='naction']").val();
	//cek textbox yang kosong
	if(username=="" || fullname=="" || email=="" || privilege==""){

		var title 		= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
		var str_message = "USERNAME, &amp; FULL NAME, &amp; EMAIL, &amp PRIVILEGE tidak boleh kosong.";

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
	else if(password =="" || cpassword ==""){

			var title 		= "<span class='fa fa-exclamation-triangle text-warning'></span>&nbsp;Invalid Data";
			var str_message = "PASSWORD, &amp CONFIRM PASSWORD tidak boleh kosong.";

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
													$('#btn_simpannav').hide();
													$('#img-loadnav').show();

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
																	window.location = base_url+'welcome';
																}
													});
													// }
						}
					});
	}else{
		//tidak ada, ok proses simpan
				$('#btn_simpannav').hide();
				$('#img-loadnav').show();

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
								window.location = base_url+'welcome';
							}
				});
	}

// end

}
