<!-- بسم الله الرحمن الرحیم -->
<?php
$privilege = $this->session->userdata('logged_in')['priv'];
if ($privilege=='ADMIN') {
  $Linknya = '';
}else{
  $Linknya = 'display:none';
}
 ?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
	<ul class="sidebar-menu">
	  <li class="treeview">
		<a <a href="<?php echo base_url(); ?>pengajuan">
		  <i class="fa fa-book"></i> <span>PENGAJUAN</span>
		  <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		  </span>
		</a>
		<!-- <ul class="treeview-menu">
		  <li><a href="<?php echo base_url(); ?>pertek"><i class="fa fa-plus-square"></i>Master Pertek</a></li>
		  <li><a href="<?php echo base_url(); ?>importpertek"><i class="fa fa-plus-square"></i>Transaksi Import</a></li>
    </ul> -->
	  </li>
    <li class="treeview">
		<a <a href="<?php echo base_url(); ?>pertek">
		  <i class="fa  fa-truck"></i> <span>PERTEK</span>
		  <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		  </span>
		</a>
		<!-- <ul class="treeview-menu">
		  <li><a href="<?php echo base_url(); ?>ipbb"><i class="fa fa-plus-square"></i>Master IPBB</a></li>
		  <li><a href="<?php echo base_url(); ?>importipbb"><i class="fa fa-plus-square"></i>Transaksi Import</a></li>
		</ul> -->
	  </li>
    <li class="treeview">
		<a <a href="<?php echo base_url(); ?>Invoice">
		  <i class="fa fa-file-text"></i> <span>INVOICES</span>
		  <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		  </span>
		</a>
		<!-- <ul class="treeview-menu">
		  <li><a href="<?php echo base_url(); ?>ipbb"><i class="fa fa-plus-square"></i>Master IPBB</a></li>
		  <li><a href="<?php echo base_url(); ?>importipbb"><i class="fa fa-plus-square"></i>Transaksi Import</a></li>
		</ul> -->
	  </li>
	   <li class="treeview">
		<a href="#">
		  <i class="fa fa-database"></i> <span>MASTER</span>
		  <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		  </span>
		</a>
		<ul class="treeview-menu">
		  <li><a href="<?php echo base_url(); ?>DataBarang"><i class="fa fa-plus-square"></i>BARANG</a></li>
      <li><a href="<?php echo base_url(); ?>DataSupplier"><i class="fa fa-plus-square" ></i>SUPPLIER</a></li>
      <li><a href="<?php echo base_url(); ?>DataKategori"><i class="fa fa-plus-square"></i>KATEGORI</a></li>
      <li><a href="<?php echo base_url(); ?>DataCurr"><i class="fa fa-plus-square"></i>CURRENCY</a></li>
      <li><a href="<?php echo base_url(); ?>DataUser" style="<?php echo $Linknya; ?>" ><i class="fa fa-plus-square"></i>USER</a></li>

		</ul>
	  </li>
	</ul>
  </section>
  <!-- /.sidebar -->
</aside>
