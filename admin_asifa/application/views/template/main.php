<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo PAGE_TITLE; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!--link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"-->
<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="<?php echo base_url(); ?>assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/custom/css/basic.css" rel="stylesheet" type="text/css"/>

<!-- END THEME STYLES -->

<!-- BEGIN PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/global/plugins/pines-notify/jquery.pnotify.default.css' />
[section="plugin-css"]
<!-- END PLUGIN STYLES -->

<!-- BEGIN CUSTOM STYLES -->
[section="css"]
<!-- END CUSTOM STYLES -->

<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/custom/img/favicon.ico">
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-header-fixed page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo site_url('dashboard'); ?>">
				<!--img src="<?php echo base_url(); ?>assets/admin/layout4/img/logo-light.png" alt="logo" class="logo-default"/-->
				<img src="<?php echo base_url(); ?>assets/custom/img/logo.png" alt="logo" height="auto" class="logo-default" style="width: 170px;margin-top:5px;"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		
		<!-- BEGIN PAGE ACTIONS -->
		<div class="page-actions">
			[section="page-actions"]
		</div> 
		<!-- END PAGE ACTIONS -->
		
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="search-peg-form">
				<div style="width:50px" class="pull-left">
					<button type="button" class="btn btn-primary" disabled id="master_no_induk_btn"><i class="fa fa-list-alt"></i></button>
				</div>
				<div style="width:250px" class="pull-right">
					<input type="text" class="form-control input-sm" name="master_no_induk" id="master_no_induk">
				</div>
			</div>
			
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li class="separator hide">
					</li>
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile">
						<?php echo NAMA_LENGKAP ? NAMA_LENGKAP : USERNAME; ?> </span>
						<img alt="" class="img-circle" src="<?php echo $this->session->userdata('photo') ? $this->session->userdata('photo') :  base_url('assets/admin/layout4/img/avatar.png'); ?>"/>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li><a href="<?php echo site_url('dashboard/change_pass'); ?>"> <i class="icon-key"></i> Ganti Password</a></li>
							<li><a href="<?php echo site_url('logout'); ?>"> <i class="fa fa-sign-out"></i> Log Out </a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li>
					<a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i><span class="title"> Dashboard</span></a>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-hdd-o"></i><span class="title"> Master</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li><a href="<?php echo site_url('rf_thn_ajaran'); ?>"><i class="fa fa-archive"></i> Tahun Ajaran</a></li>
						<li><a href="<?php echo site_url('rf_jenjang'); ?>"><i class="fa fa-signal fa-rotate-90"></i> Jenjang</a></li>
						<li><a href="<?php echo site_url('rf_jurusan'); ?>"><i class="fa fa-legal"></i> Jurusan</a></li>
						<li><a href="<?php echo site_url('rf_sekolah'); ?>"><i class="fa fa-university"></i> Sekolah</a></li>
						<li><a href="<?php echo site_url('rf_guru'); ?>"><i class="fa fa-briefcase"></i> Guru</a></li>
						<li><a href="<?php echo site_url('rf_siswa'); ?>"><i class="fa fa-graduation-cap"></i> Siswa</a></li>
						<li><a href="<?php echo site_url('rf_user'); ?>"><i class="fa fa-user"></i> User</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-folder"></i><span class="title"> Data Periodik</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li><a href="<?php echo site_url('rfp_template_rapor'); ?>"><i class="fa fa-cube"></i> Template Rapor</a></li>
						<li><a href="<?php echo site_url('rfp_kelas'); ?>"><i class="fa fa-group"></i> Kelas</a></li>
						<li><a href="<?php echo site_url('rfp_kel_mapel'); ?>"><i class="fa fa-flask"></i> Kelompok MaPel</a></li>
						<li><a href="<?php echo site_url('rfp_mapel'); ?>"><i class="fa fa-flask"></i> Mata Pelajaran</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-exchange"></i><span class="title"> Transaksi</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li><a href="<?php echo site_url('tr_set_kelas'); ?>"><i class="fa fa-group"></i> Set Kelas</a></li>
						<li><a href="<?php echo site_url('tr_set_sekolah'); ?>"><i class="fa fa-university"></i> Set Sekolah &amp; Jurusan</a></li>
						<li><a href="<?php echo site_url('tr_set_mapel'); ?>"><i class="fa fa-flask"></i> Set Mapel</a></li>
						<li><a href="<?php echo site_url('tr_riwayat'); ?>"><i class="fa fa-calendar"></i> Riwayat</a></li>
						<li><a href="<?php echo site_url('tr_tugas'); ?>"><i class="fa fa-pencil-square-o"></i> Tugas</a></li>
						<li>
							<a href="javascript:;">
								<i class="fa fa-flag"></i> <span class="title"> Rapor</span>
								<span class="arrow "></span>
							</a>
							<ul class="sub-menu">
								<?php 
									if(is_array($main_jr)) foreach($main_jr as $val) echo '<li><a href="'.site_url('tr_isi_rapor/index/'.$val->kode_template).'"><i class="fa fa-file"></i> '.$val->nama_template.'</a></li>';
								?>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-money"></i><span class="title"> Keuangan</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li><a href="<?php echo site_url('keu_jenis'); ?>"><i class="fa fa-tags"></i> Jenis Pembayaran</a></li>
						<li><a href="<?php echo site_url('keu_nominal'); ?>"><i class="fa fa-money"></i> Nominal</a></li>
						<li><a href="<?php echo site_url('keu_tagihan'); ?>"><i class="fa fa-credit-card"></i> Tagihan</a></li>
						<li><a href="<?php echo site_url('keu_pembayaran'); ?>"><i class="fa fa-dollar"></i> Pembayaran</a></li>
						<li><a href="<?php echo site_url('lap_keu_tagihan'); ?>"><i class="fa fa-clipboard"></i> Lap Tagihan</a></li>
						<li><a href="<?php echo site_url('lap_keu_pembayaran'); ?>"><i class="fa fa-clipboard"></i> Lap Pembayaran</a></li>
						<li><a href="<?php echo site_url('lap_keu_tanggungan'); ?>"><i class="fa fa-clipboard"></i> Lap Tanggungan</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-bullhorn"></i><span class="title"> Pengumuman</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li><a href="<?php echo site_url('rf_kat_pengumuman'); ?>"><i class="fa fa-tags"></i> Kategori</a></li>
						<li><a href="<?php echo site_url('tr_pengumuman'); ?>"><i class="fa fa-bullhorn"></i> Pengumuman</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-wrench"></i><span class="title"> Setting</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<!--li><a href="<?php echo site_url('st_status'); ?>"><i class="fa fa-tags"></i> Status</a></li-->
						<li><a href="<?php echo site_url('st_agama'); ?>"><i class="fa fa-bell"></i> Agama</a></li>
						<li><a href="<?php echo site_url('st_kota'); ?>"><i class="fa fa-map-marker"></i> Kota</a></li>
						<li><a href="<?php echo site_url('st_provinsi'); ?>"><i class="fa fa-map-marker"></i> Provinsi</a></li>
						<li><a href="<?php echo site_url('st_jenis_rapor'); ?>"><i class="fa fa-cubes"></i> Jenis Rapor</a></li>
						<li><a href="<?php echo site_url('st_predikat'); ?>"><i class="fa fa-sort-alpha-asc"></i> Predikat</a></li>
						<li><a href="<?php echo site_url('st_jenis_riwayat'); ?>"><i class="fa fa-life-ring"></i> Jenis Riwayat</a></li>
						<li><a href="<?php echo site_url('st_ekskul'); ?>"><i class="fa fa-music"></i> Ekstrakurikuler</a></li>						
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-envelope"></i><span class="title"> SMS Gateway</span></a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	
	
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
	<?php echo $content; ?>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 2017 &copy; ASIFA
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->

<!-- BEGIN MODAl -->
<div id="sw-main-modal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">	
			<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>
		</div>
	</div>
</div>

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


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE JS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE JS -->

<!-- BEGIN PLUGIN JS -->
<script type='text/javascript' src='<?php echo base_url(); ?>assets/global/plugins/select2/select2.js'></script> 
<script type="text/javascript" src='<?php echo base_url(); ?>assets/global/plugins/pines-notify/jquery.pnotify.min.js'></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/asas.js"></script>
<!-- END PLUGIN JS -->

<!-- BEGIN PLUGIN JS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
[section="plugin-js"]
<!-- END PLUGIN JS -->

<script>

	$('body').on('hidden.bs.modal', '#main-modal-lg, #main-modal-md', function () {
		$(this).removeData('bs.modal');
		$(this).find('.modal-content').html('<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>')
	});
	
	$("body").on("shown.bs.modal", '#main-modal-lg, #main-modal-md', function(e) 
	{
		$(this).find('.form-control').first().focus();
	});
	
	$("body").on("show.bs.modal", '#sw-main-modal', function(e) 
	{
		$('#sw-main-modal').find(".modal-content").load('<?php echo site_url('rf_siswa/detail/'); ?>/'+$('#master_no_induk').val());
	});
	
	var BASE_URL = '<?php echo base_url(); ?>';
	var SITE_URL = '<?php echo site_url(); ?>';
	var PAGE_URL = '<?php echo site_url(PAGE_ID); ?>';
	
	jQuery(document).ready(function() {    
		
		$("#master_no_induk").select2({
			placeholder: "Cari No Induk atau Nama Siswa",
			minimumInputLength: 3,
			width: 'resolve',
			allowClear : true,
			ajax: {
				url: "<?php echo site_url('rf_siswa/autocomplete')?>",
				dataType: 'json',
				delay: 250,
				data: function (term, page) { 
					return {q: term};
				},
				results: function (data, page) {
					return {results: data.items};
				},
				cache: true
			},
			formatResult: function(m) { return '<b>'+m.id+'</b> '+ m.text; },
			escapeMarkup: function (m) { return m; } ,
			formatSelection: function(m) { 
				$('#master_no_induk').val(m.encoded_id);
				$('#sw-main-modal').modal('show');
				return '<b>'+m.id +'</b> '+m.text; 
			},
		});
		
		$('#master_no_induk').change(function()
		{
			if ($(this).val()) $('#master_no_induk_btn').removeAttr('disabled');
			else $('#master_no_induk_btn').attr('disabled', 'disabled');
		})
		
		$('#master_no_induk_btn').click(function()
		{
			$('#sw-main-modal').modal('show');
		})
	
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
	});
	
	// sidebar & breadcrumb
	$('.page-sidebar-menu a').each(function(){
		var href = $(this).attr('href');
		var bread_container = $('ul.page-breadcrumb');
		if (window.location.href.indexOf(href) > -1)
		{
			var parent = $(this).parent('li').parents('li');
			$(this).parent('li').addClass('active');
			parent.addClass('active open').find('.arrow').addClass('open');
			if(bread_container.length) 
			{
				bread_container.prepend('<li><a href="'+href+'">'+$(this).text()+'</a><i class="fa fa-circle"></i></li>');
				if(parent.length)
				{
					bread_container.prepend('<li><a href="'+parent.find('a').first().attr('href')+'">'+parent.find('a').first().text()+'</a><i class="fa fa-circle"></i></li>');
				}
			}
		}
	});

</script>
<!-- END JAVASCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPT -->
[section="js"]
<!-- END PAGE LEVEL SCRIPT -->

</body>
<!-- END BODY -->
</html>