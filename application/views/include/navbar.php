<?php
$controller = $this->router->fetch_class();
$level = $this->session->userdata('ap_level');
$sub_menu = strtolower($this->uri->segment(2));
?>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
	<!-- begin #header -->
	<div id="header" class="header navbar navbar-default navbar-fixed-top">
		<!-- begin container-fluid -->
		<div class="container-fluid">
			<!-- begin mobile sidebar expand / collapse button -->
			<div class="navbar-header">
				<a href="" class="navbar-brand"><span class="navbar-logo"><i class="ion-ios-monitor"></i></span> <b>Toko</b> Komputer</a>
				<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- end mobile sidebar expand / collapse button -->

			<!-- begin header navigation right -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown navbar-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<span class="user-image online">
							<img src="assets/img/avatar.png" alt="" />
						</span>
						<span class="hidden-xs"><?php echo $this->session->userdata('ap_nama'); ?></span> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu animated fadeInLeft">
						<li class="arrow"></li>
						<li><a href="<?php echo site_url('user/ubah-password'); ?>" id='GantiPass'>Ubah Password</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('secure/logout'); ?>"><i class='fa fa-sign-out fa-fw'></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end container-fluid -->
	</div>
	<!-- end #header -->

	<!-- begin #sidebar -->
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar scrollbar -->
		<div data-scrollbar="true" data-height="100%">
			<!-- begin sidebar user -->
			<ul class="nav">
				<li class="nav-profile">
					<div class="image">
						<a href="javascript:;"><img src="assets/img/avatar.png" alt="" /></a>
					</div>
					<div class="info">
						<?php echo $this->session->userdata('ap_nama'); ?>
						<small><?php echo $this->session->userdata('ap_level_caption'); ?></small>
					</div>
				</li>
			</ul>
			<!-- end sidebar user -->
			<!-- begin sidebar nav -->
			<ul class="nav">
				<li class="nav-header">Navigation</li>
				<!-- <li class="has-sub active">
					<a href="javascript:;">
							<i class="ion-ios-pulse-strong"></i>
							<span>Dashboard</span>
					</a>
				</li> -->
				<?php if($level == 'admin' OR $level == 'keuangan' OR $level == 'kasir') { ?>
				<li class="has-sub <?php if($controller == 'penjualan') { echo 'active'; } ?>">
					<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-shopping-cart fa-fw bg-blue"></i>
							<span>Penjualan</span>
					</a>
					<ul class="sub-menu">
						<?php if($level !== 'keuangan'){ ?>
						<li class="<?php if($sub_menu == 'transaksi') { echo 'active'; } ?>"><a href="<?php echo site_url('penjualan/transaksi'); ?>">Transaksi</a></li>
						<?php } ?>
						<li class="<?php if($sub_menu == 'history') { echo 'active'; } ?>"><a href="<?php echo site_url('penjualan/history'); ?>">History Penjualan</a></li>
						<li role="separator" class="divider"></li>
						<li class="<?php if($sub_menu == 'pelanggan') { echo 'active'; } ?>"><a href="<?php echo site_url('penjualan/pelanggan'); ?>">Data Pelanggan</a></li>
					</ul>
				</li>
				<?php } ?>

				<li class="has-sub <?php if($controller == 'barang') { echo 'active'; } ?>">
					<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-cube fa-fw bg-orange"></i>
							<span>Barang</span>
					</a>
					<ul class="sub-menu">
						<li class="<?php if($sub_menu == '') { echo 'active'; } ?>"><a href="<?php echo site_url('barang'); ?>">Semua Barang</a></li>
						<li role="separator" class="divider"></li>
						<li class="<?php if($sub_menu == 'list-merek') { echo 'active'; } ?>"><a href="<?php echo site_url('barang/list-merek'); ?>">List Merek</a></li>
						<li class="<?php if($sub_menu == 'list-kategori') { echo 'active'; } ?>"><a href="<?php echo site_url('barang/list-kategori'); ?>">List Kategori</a></li>
					</ul>
				</li>

				<?php if($level == 'admin' OR $level == 'kasir') { ?>
				<li <?php if($controller == 'service') { echo "class='active'"; } ?>>
					<a href="<?php echo site_url('service'); ?>">
						<i class="ion-ios-pulse-strong bg-pink"></i>
							<span>Service</span>
					</a>
				</li>
				<?php } ?>

				<?php if($level == 'admin' OR $level == 'keuangan') { ?>
					<li <?php if($controller == 'laporan') { echo "class='active'"; } ?>>
						<a href="<?php echo site_url('laporan'); ?>">
							<i class="fa fa-file-text-o fa-fw bg-purple"></i>
								<span>Laporan</span>
						</a>
					</li>
				<?php } ?>

				<?php if($level == 'admin') { ?>
				<li <?php if($controller == 'user') { echo "class='active'"; } ?>>
					<a href="<?php echo site_url('user'); ?>">
						<i class="fa fa-users fa-fw"></i>
							<span>List User</span>
					</a>
				</li>
				<?php } ?>
						<!-- begin sidebar minify button -->
				<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Collapse</span></a></li>
						<!-- end sidebar minify button -->
			</ul>
			<!-- end sidebar nav -->
		</div>
		<!-- end sidebar scrollbar -->
	</div>
	<div class="sidebar-bg"></div>
	<!-- end #sidebar -->

<script>
$(document).on('click', '#GantiPass', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Ubah Password');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});
</script>
