<!DOCTYPE html>
<html>

<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo PAGE_TITLE; ?></title>
<meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Font CSS (Via CDN) -->
<!--link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'-->

<!-- Vendor CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/plugins/magnific/magnific-popup.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/plugins/fullcalendar/fullcalendar.min.css'); ?>" media="screen">

<!-- Theme CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/skin/default_skin/css/theme.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/skin/css_jodie/skins/_all-skins.css'); ?>">
<!-- Admin Forms CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin-tools/admin-forms/css/admin-forms.css'); ?>">

<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/css/basic.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/css/style.css'); ?>">

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- BEGIN PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/glyphicons-pro/glyphicons-pro.css'); ?>">
[section="plugin-css"]
<!-- END PLUGIN STYLES -->

<!-- BEGIN CUSTOM STYLES -->
[section="css"]
<!-- END CUSTOM STYLES -->

</head>

<body class="admin-modals-page">

<!-- Start: Main -->
<div id="main">

	<!-- Start: Header -->
	<header class="navbar navbar-fixed-top">
		<div class="navbar-branding">
			<a class="navbar-brand" href="<?php echo site_url(); ?>">
				<!--b>SIAKAD</b> ASIFA-->
				<img src="<?php echo base_url('assets/custom/img/logo.png');?>" width="140" class="mt5">
			</a>
			<span id="toggle_sidemenu_l" class="ad ad-lines"></span>
		</div>
		<ul class="nav navbar-nav navbar-left">
			<li class="hidden-xs">
				<a class="request-fullscreen toggle-active" href="#">
					<span class="ad ad-screen-full fs18"></span>
				</a>
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
			</li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
					<img src="<?php
					$src=base_url()."/assets/img/avatars/".NO_INDUK.".png";
					if(@getimagesize($src)) {
						echo base_url()."/assets/img/avatars/".NO_INDUK.".png";
					}else{
						echo base_url()."/assets/img/avatars/placeholder.png";
					} ?>" alt="avatar" class="mw30 br64 mr15">
					<?php echo NAMA_LENGKAP ? NAMA_LENGKAP : USERNAME; ?>
					<span class="caret caret-tp hidden-xs"></span>
				</a>
				<ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
					<li class="dropdown-header clearfix">
						<div class="pull-left ml10">
							<div class="btn-group" style="width: 100px;">
								<button type="button" class="multiselect dropdown-toggle btn btn-default btn-sm" title="Online" style="width: 100px;">Online</button>
							</div>
						</div>
						<div class="pull-left ml10">
							<div class="btn-group" style="width: 100px;">
								<button type="button" class="multiselect dropdown-toggle btn btn-default btn-sm" title="Siswa" style="width: 100px;">Siswa</button>
							</div>
						</div>
					</li>
					<li class="list-group-item">
						<a href="<?php echo site_url('setting#tab-password')?>" class="animated animated-short fadeInUp">
							<span class="fa fa-gear"></span> Ganti Password </a>
					</li>
					<li class="list-group-item">
						<a href="<?php echo site_url('logout')?>" class="animated animated-short fadeInUp">
							<span class="fa fa-power-off"></span> Logout </a>
					</li>
				</ul>
			</li>
		</ul>

	</header>
	<!-- End: Header -->

	<!-- Start: Sidebar -->
	<aside id="sidebar_left">

		<!-- Start: Sidebar Left Content -->
		<div class="">

			<!-- Start: Sidebar Header -->
			<header class="sidebar-header">

			</header>
			<!-- End: Sidebar Header -->

			<!-- Start: Sidebar Menu -->
			<ul class="nav sidebar-menu navbar-fixed-left">
				<li class="sidebar-label pt20">Menu</li>
				<li>
					<a href="<?php echo site_url(); ?>">
						<span class="fa fa-home"></span>
						<span class="sidebar-title">Beranda</span>
					</a>
				</li>
				<li>
					<a href="<?php echo site_url('keuangan'); ?>">
						<span class="fa fa-money"></span>
						<span class="sidebar-title">Keuangan</span>
					</a>
				</li>
				<li>
					<a class="accordion-toggle" href="#">
						<span class="glyphicons glyphicons-adress_book"></span>
						<span class="sidebar-title">Rapor</span>
						<?php if($menu_template) echo '<span class="caret"></span>'; ?>
					</a>
					<?php if($menu_template) { ?>
					<ul class="nav sub-nav">
						<?php foreach($menu_template as $mtemp) { ?>
						<li>
							<a href="<?php echo site_url('rapor/'.$mtemp->kode_template); ?>">
								<span class="fa fa-calendar"></span>
								<?php echo $mtemp->nama_template; ?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</li>
				<li>
					<a href="<?php echo site_url('kehadiran'); ?>">
						<span class="glyphicons glyphicons-bell"></span>
						<span class="sidebar-title">Kehadiran</span>
					</a>
				</li>
				<li>
					<a href="<?php echo site_url('tugas'); ?>">
						<span class="glyphicons glyphicons-pushpin"></span>
						<span class="sidebar-title">Tugas</span>
					</a>
				</li>
				<li>
					<a href="<?php echo site_url('profil'); ?>">
						<span class="glyphicons glyphicons-user"></span>
						<span class="sidebar-title">Profil</span>
					</a>
				</li>
				<li>
					<a href="<?php echo site_url('setting'); ?>">
						<span class="glyphicons glyphicons-cogwheels"></span>
						<span class="sidebar-title">Pengaturan</span>
					</a>
				</li>

			</ul>
			<!-- End: Sidebar Menu -->

			<!-- Start: Sidebar Collapse Button -->
			<div class="sidebar-toggle-mini" id="sidebar-toggle-mini">
				<a id="tutup" href="#">
					<span class=""></span>
				</a>
			</div>
			<!-- End: Sidebar Collapse Button -->

		</div>
		<!-- End: Sidebar Left Content -->

	</aside>

	<!-- Start: Content-Wrapper -->
	<section id="content_wrapper">

		<!-- Start: Topbar -->
		<header id="topbar">
			<div class="topbar-left">
				<ol class="breadcrumb">
					<li class="crumb-active">
						<a href="">Dashboard</a>
					</li>
					<li class="crumb-link">
						<a href="<?php echo base_url(); ?>">Home</a>
					</li>
				</ol>
			</div>

		</header>
		<!-- End: Topbar -->

		<!-- Begin: Content -->
		<section id="content" class="animated fadeIn">
			<?php echo $content; ?>
		</section>
		<!-- End: Content -->

	</section>


</div>
<!-- End: Main -->

<!-- BEGIN MODAl -->
<div id="main-modal-lg" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>
		</div>
	</div>
</div>
<div id="main-modal-md" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>
		</div>
	</div>
</div>
<!-- END MODAL -->


<!-- BEGIN: PAGE SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/vendor/jquery/jquery-1.11.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery_ui/jquery-ui.min.js'); ?>"></script>

<!-- Page Plugins -->
<script src="<?php echo base_url('assets/vendor/plugins/magnific/jquery.magnific-popup.js'); ?>"></script>
[section="plugin-js"]

<!-- Theme Javascript -->
<script src="<?php echo base_url('assets/js/utility/utility.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/demo/demo.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		"use strict";
		// Init Theme Core
		Core.init();
		// Init Demo JS
		Demo.init();

		// set active menu
		var sidebar = $('.nav.sidebar-menu');
		var breadcrumb = $('.breadcrumb');

		var find = sidebar.find('[href="'+window.location+'"]').first();

		sidebar.find('a').each(function(){
			if(window.location.href.indexOf($(this).attr('href')) != -1) find = $(this);
		})


		if(find)
		{
			find.parent('li').addClass('active').parents('li').children('a').first().addClass('menu-open');
			var title = find.find('.sidebar-title').text();
			var parent_title = find.parent('li').parents('li').children('a').first().find('.sidebar-title').html()
			if (parent_title)
			{
				breadcrumb.find('.crumb-active a').html(find.text());
				breadcrumb.append('<li class="crumb-trail">'+parent_title+'</li>');
				breadcrumb.append('<li class="crumb-trail">'+find.text()+'</li>');
			}
			else
			{
				breadcrumb.find('.crumb-active a').html(title);
				breadcrumb.append('<li class="crumb-trail">'+title+'</li>');
			}

		}

	});

	$('body').on('hidden.bs.modal', '#main-modal-lg, #main-modal-md', function () {
		$(this).removeData('bs.modal');
		$(this).find('.modal-content').html('<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>')
	});

	$("body").on("shown.bs.modal", '#main-modal-lg, #main-modal-md', function(e)
	{
		$(this).find('.form-control').first().focus();
	});

	$('#toggle_sidemenu_l').click(function(e){
    e.stopPropagation();
     $('#').toggleClass('show-menu');
	});

	$('#sidebar_left').click(function(e){
	    e.stopPropagation();
	});

	$('body,html').click(function(e){
	       $('#tutup span').trigger('click');

	});

</script>

<!-- BEGIN PAGE LEVEL SCRIPT -->
[section="js"]
<!-- END PAGE LEVEL SCRIPT -->
<!-- END: PAGE SCRIPTS -->

</body>

</html>
