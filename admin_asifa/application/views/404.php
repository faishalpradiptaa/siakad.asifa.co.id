<?php $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')  ?>

<link href="<?php echo base_url(); ?>assets/admin/pages/css/error.css" rel="stylesheet" type="text/css"/>

<div class="page-content">

	<?php if (!$is_ajax) {?>
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<!-- BEGIN PAGE TITLE -->
		<div class="page-title"><h1><?php echo PAGE_TITLE && PAGE_TITLE != 'Invalid class name' ? PAGE_TITLE : '404'; ?> &nbsp;<small>Halaman tidak ditemukan</small></h1></div>
		<!-- END PAGE TITLE -->
	</div>
	<!-- END PAGE HEAD -->
	<?php } ?>
	
	
	<!-- BEGIN PAGE CONTENT-->
	<div class="row" style="margin-bottom: 30px">
		<div class="col-md-12 page-404">
			<div class="number">
				 404
			</div>
			<div class="details">
				<h3>Halaman tidak ditemukan !</h3>
				<p>
					Halaman yang anda cari mungkin masih dalam tahap pengembangan.<br/>
				</p>
			</div>
		</div>
		
	</div>
</div>	