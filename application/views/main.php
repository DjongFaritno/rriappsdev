<!DOCTYPE html>
<!-- بسم الله الرحمن الرحیم -->

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" type="text/css" href="<?php echo base_url() ?>assets/images/ship.jpg" />
  <?php require_once('include/inc_css.php'); ?>
  <?php require_once('include/inc_js.php'); ?>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-green fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <?php require_once('navbar.php'); ?>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->

  <?php $this->load->view('sidemenu');?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php if(isset($content)) echo $content; ?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
  <?php require_once('include/inc_footer.php'); ?>
  </footer>

</div>
<!-- ./wrapper -->
</body>
</html>
