<script src="<?php echo base_url(); ?>assets/plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vglobal.js"></script>
<?php
// بسم الله الرحمن الرحیم
	$username = $this->session->userdata('logged_in')['uid'];
	$full_name = $this->session->userdata('logged_in')['fullname'];
	$email = $this->session->userdata('logged_in')['e'];
	$privilege = $this->session->userdata('logged_in')['priv'];
?>
<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
var username = '<?php echo $this->session->userdata('logged_in')['uid'];?>';

</script>
<header class="main-header">
<!-- Logo -->
<a href="<?php echo base_url(); ?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
	<span class="logo-mini"><b>RRI<small>&amp;</small>app</span>
  <!-- logo for regular state and mobile devices -->
	<!-- <i class="fa fa-fw fa-ship"></i> -->
  <span class="logo-lg"><b>RRI</b>appDEV</span><i class="fa fa-fw fa-ship"></i>
</a>
<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
	  <!-- Sidebar toggle button-->
	  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	    <span class="sr-only">Toggle navigation</span>
	  </a>
	  <div class="navbar-custom-menu">
	    <ul class="nav navbar-nav">
	      <!-- User Account: style can be found in dropdown.less -->
	      <li class="dropdown user user-menu">
	        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	          <img src="<?php echo base_url(); ?>assets/images/myAvatar.png" class="user-image" alt="User Image">
	          <span class="hidden-xs"><?php echo $full_name; ?></span>
						<span class="hidden-xs"><?php echo '|| \''.$privilege.'\'  '; ?></span>
	        </a>
	        <ul class="dropdown-menu">
	          <!-- User image -->
	          <li class="user-header">
	            <img src="<?php echo base_url(); ?>assets/images/myAvatar.png" class="img-circle" alt="User Image">
	            <p><?php echo $full_name; ?></p>
							<p><?php echo $email; ?></p>
	          </li>
					</li>
	          <!-- Menu Footer-->
	          <li class="user-footer">
	            <div class="pull-left">
								<a href="#" class="btn btn-warning" onclick="UserProfile()">Profile</a>
								<a href="#" class="btn btn-primary" onclick="UserPassword()">Password</a>
	            </div>
							<!-- <div class="pull-middle">
	              <a href="#" class="btn btn-warning" onclick="UserProfile()">Profile</a>
	            </div> -->
	            <div class="pull-right">
	              <a href="<?php echo base_url(); ?>auth/logout_act" class="btn btn-danger">Sign out</a>
	            </div>
	          </li>
	        </ul>
	      </li>
	    </ul>
	  </div>

	</nav>
</header>
<!-- modal add -->
<div id="modal_add_UserProfile" class="modal fade modal-primary" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title">YOU PROFILE AND PASSWORD</h4>
	  </div>
	  <div class="modal-body">
			<form class="form-horizontal" name="nmyform" id="nmyform">
				<input type="hidden" name="nid_user" value="">
				<div class="box-body">
        <div id="g_nusername" class="form-group">
						<label for="exampleFIELD1">USER NAME</label>
						<input class="form-control" type="text" maxlength = "20" name="nusername" id="nusername" onkeydown="HurufBesar(this)">
					</div>
					<div id="g_nfullname" class="form-group">
						<label for="exampleFIELD2">FULL NAME</label>
						<input class="form-control" type="text" maxlength = "50" name="nfullname" id="nfullname"  onkeydown="HurufBesar(this)">
					</div>
					<div id="g_nemail" class="form-group">
						<label for="exampleFIELD13">EMAIL</label>
						<input class="form-control" type="text" maxlength = "20" name="nemail" id="nemail">
					</div>
				<div id="g_nprivilege" class="form-group">
					<label>PRIVILEGE</label>
						<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="nprivilege" id="nprivilege" disabled="">
						<option value="" selected="selected"></option>
						<option value="ADMIN">ADMIN</option>
						<option value="USER">USER</option>
						<option value="USER">OPERATOR</option>
						</select>
						</div>
						<div id="g_npassword" class="form-group">
							<label for="exampleFIELD14">PASSWORD</label>
							<input class="form-control" type="password" maxlength = "10" name="npassword" id="npassword">
						</div>
						<div id="g_ncpassword" class="form-group">
							<label for="exampleFIELD15">CONFIRM PASSWORD</label>
							<input class="form-control" type="password" maxlength = "10" name="ncpassword" id="ncpassword">
						</div>
						<div class="form-group">
						<input class="form-control" style="display:none" type="text" maxlength = "10" name="naction" id="naction" >
						</div>
				</div>
			</form>
	  </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">BATAL</button>
    <button type="button" id="btn_simpannav" class="btn btn-primary"  onclick="TambahUserNav()">
      <i class="glyphicon glyphicon-floppy-disk"></i>SIMPAN
    </button>
    <img id="img-loadnav" style="display:none" src="<?php echo base_url(); ?>assets/images/fb-loader.gif" />
    </div>
  </div>
  </div>
</div>
<!-- end of modal-->
