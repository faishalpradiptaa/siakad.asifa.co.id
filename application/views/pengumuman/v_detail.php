<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" ><?php echo $data->judul; ?></h4>
</div>
<div class="modal-body">
	<?php echo $data->pengumuman; ?>
</div><!-- /.modal-body -->

<div class="modal-footer">
	<div class="pull-left text-alert" style="padding-top:10px;padding-left:10px;">
		<i class="fa fa-clock-o"></i> <?php echo datetime2History($data->publish_date); ?> yang lalu
	</div>
	<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
</div>
