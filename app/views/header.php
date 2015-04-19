<!DOCTYPE html>
<html lang="en">
	<!-- This is Just a Header
	================================================= -->
	<head>
    <meta charset="utf-8">
    <title>Bookstore App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<? echo URL; ?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/style.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/datepicker.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/print.css" rel="stylesheet" media="print">

    <script src="<? echo URL; ?>assets/js/jquery.js"></script>
    <script src="<? echo URL; ?>assets/js/app.js"></script>

    <script src="<? echo URL; ?>assets/js/bootstrap-collapse.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-dropdown.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-modal.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-transition.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-button.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-typeahead.js"></script>
    <script src="<? echo URL; ?>assets/js/jquery.printElement.min.js" ></script>

    <link rel="shortcut icon" href="<? echo URL; ?>assets/img/favicon.ico">
	 <link rel="icon" href="<? echo URL; ?>assets/img/favicon.ico">

	</head>
	<!-- End of Header -->

	<body>

	<!-- TOP Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<a class="brand" href="<? echo URL; ?>"><? echo APPNAME; ?></a>

				<? $isLogin = Session::get('user_loggedIn'); ?>
				<? if($isLogin) : ?>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<? if(Session::get('user_role') == 'admin' || Session::get('user_role') == 'inventory') : ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Produk <b class="caret"></b></a>
				            <ul class="dropdown-menu">
				           		 <li class=""><a href="<? echo URL; ?>classes">Klasifikasi</a></li>
				           		 <li class=""><a href="<? echo URL; ?>supplier">Supplier</a></li>
				           		 <li class=""><a href="<? echo URL; ?>publisher">Penerbit</a></li>
				           		 <li class=""><a href="<? echo URL; ?>product">Produk</a></li>
					             <li class=""><a href="<? echo URL; ?>supply">Supply</a></li>
				            </ul>
				        </li>
				    	<? endif; ?>

						<? if(Session::get('user_role') == 'admin' || Session::get('user_role') == 'inventory' || Session::get('user_role') == 'cashier') : ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Penelusuran <b class="caret"></b></a>
				            <ul class="dropdown-menu">
					             <li class=""><a href="<? echo URL; ?>place">Tempat</a></li>
					             <li class=""><a href="<? echo URL; ?>placement">Penempatan</a></li>
					             <li class=""><a href="<? echo URL; ?>search">Pencarian</a></li>
				            </ul>
				        </li>
				    	<? endif; ?>

				        <? if(Session::get('user_role') == 'admin') : ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kepegawaian <b class="caret"></b></a>
				            <ul class="dropdown-menu">
					             <li class=""><a href="<? echo URL; ?>employee">Pegawai</a></li>
					             <li class=""><a href="<? echo URL; ?>user">Manajemen User</a></li>
					             <!--<li class=""><a href="<? echo URL; ?>attendance">Presensi</a></li>-->
				            </ul>
				        </li>
				    	<? endif; ?>

				    	<? if(Session::get('user_role') == 'admin' || Session::get('user_role') == 'cashier') : ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <b class="caret"></b></a>
				            <ul class="dropdown-menu">
					             <li class=""><a href="<? echo URL; ?>retail">Penjualan Satuan</a></li>
					             <li class=""><a href="<? echo URL; ?>wholesale">Penjualan Grosir</a></li>
					             <li class=""><a href="<? echo URL; ?>loan">Piutang</a></li>
					             <li class=""><a href="<? echo URL; ?>returnment">Pengembalian</a></li>
				            </ul>
				        </li>
				    	<? endif; ?>

				        <? if(Session::get('user_role') == 'admin') : ?>
						<li class=""><a href="<? echo URL; ?>costumer">Pelanggan</a></li>

						<li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b></a>
				            <ul class="dropdown-menu">
					            <li class=""><a href="<? echo URL; ?>report/retail">Penjualan Eceran</a></li>
					            <li class=""><a href="<? echo URL; ?>report/wholesale">Penjualan Grosir</a></li>
					            <li class=""><a href="<? echo URL; ?>report/loan">Piutang</a></li>
					            <li class=""><a href="<? echo URL; ?>report/payment">Penerimaan Piutang</a></li>
					            <li class=""><a href="<? echo URL; ?>report/consign">Penjualan Barang Konsinyasi</a></li>
					            <li class=""><a href="<? echo URL; ?>report/stock">Laporan Stok</a></li>
				            </ul>
				        </li>
				    	<? endif; ?>
					</ul>

			        <ul class="nav pull-right">
			        	<li><a href="#"><? echo Session::get('user_fullName'); ?></a></li>
			        	<li><a href="javascript:void(0)" onclick="logout()">Keluar</a></li>
			        </ul>
			    	<? endif; ?>
				</div>
			</div>
		</div>
    </div>
	<!-- End of TOP Navbar -->

	<!-- Content
	=================================================== -->
	<div id="content" class="container">
