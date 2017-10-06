<!-- بسم الله الرحمن الرحیم -->

<?php
	$alert = '';

	if($this->session->flashdata('error')==null){

		$alert = 'hidden';
	}
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title><?php echo $title ?></title>
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?php require_once('include/inc_css.php'); ?>
  	<link rel="shortcut icon" type="text/css" href="<?php echo base_url() ?>assets/images/ship.jpg" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><i class="fa fa-fw fa-ship"></i>
    <a href="#"><b>RRI</b>&nbsp;APP&nbsp;<b><h5><strike>BETA VERSION</strike></h5></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  	<div class="alert alert-warning alert-dismissible <?php echo $alert; ?>">
	    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
	    User ID atau Password salah.
	</div>
    <p class="login-box-msg">Login</p>
    <form action="auth/login_act" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="User ID" name="txt_uid">
        <span class="fa fa-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="txt_pwd">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
<?php require_once('include/inc_footer.php'); ?>
</div>
<!-- /.login-box -->
<?php require_once('include/inc_js.php'); ?>

</body>
</html>
