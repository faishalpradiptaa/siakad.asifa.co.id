<?php
	$curr_mp = false;
	$curr_tugas = false;
	foreach($tugas as $row)
	{
		if($row->kode_mp == $kode_mp || !$kode_mp) $curr_mp = $row;
		if($row->id_tugas == $id_tugas) $curr_tugas = $row;
	}
	if(!$curr_tugas && isset($tugas[0])) 
	{
		$curr_tugas = $tugas[0];
		$id_tugas = $curr_tugas->id_tugas;
	}
?>

<aside class="tray tray-left tray350" data-tray-mobile="#content > .tray-center">

	<div class="fc-title-clone"><?php echo !$kode_mp ? 'Semua Mata Pelajaran' : $curr_mp->nama_mp; ?></div>

	<?php
		foreach($tugas as $curr_kode_mp => $row) if($curr_kode_mp == $curr_mp->kode_mp || !$kode_mp)
		{
			$arr = explode(' ', $row->batas_tgl_kumpul);
			$tgl_kumpul = datetime2History($row->batas_tgl_kumpul);
			$waktu_kumpul = $arr[1];
			
			$class = strtotime($row->batas_tgl_kumpul) < strtotime('now') ? 'fc-event-danger' : 'fc-event-warning';
			$class = $row->id_submit ? 'fc-event-success' : $class;
			$class = $row->id_tugas == $id_tugas ? 'fc-event-primary' : $class;
			
			$icon = strtotime($row->batas_tgl_kumpul) < strtotime('now') ? 'fa-ban' : 'fa-clock-o';
			$icon = $row->id_submit ? 'fa-check' : $icon;
			$icon = $row->id_tugas == $id_tugas ? 'fa-arrow-right' : $icon;
	?>
	<a href="<?php echo site_url(PAGE_ID.'/'.$raw_kode_mp.'/'.$row->id_tugas); ?>">
	<div class="fc-event <?php echo $class; ?> event ui-draggable ui-draggable-handle" data-event="alert">
		<div class="fc-event-icon">
			<span class="fa <?php echo $icon; ?>"></span>
		</div>
		<div class="fc-event-desc">
			<b><?php echo $tgl_kumpul; ?> lagi</b> : <?php echo $row->nama_tugas; ?></div>
	</div>
	</a>
	<?php } ?>

	<div class="row margin-t-20">
		<div class="col-md-6">
			<a href="<?php echo site_url(PAGE_ID)?>" class="btn btn-default fullwidth"> <i class="fa fa-calendar margin-r-5"></i> Kalender</a>			
		</div>
		<div class="col-md-6">
			<a href="<?php echo site_url(PAGE_ID.'/all')?>" class="btn btn-default fullwidth"> <i class="fa fa-flask margin-r-5"></i> Semua Mapel</a>
		</div>
	</div>

</aside>

<div class="tray tray-center">
	<?php if($curr_tugas) { ?>
	<div class="col-md-12 admin-grid">
		
		<?php if (strtotime($curr_tugas->batas_tgl_kumpul) > strtotime('now')) { ?>
		<div class="alert alert-warning text-center">
			Batas Pengumpulan Tugas : <br>
			<h3><?php echo datetime2History($curr_tugas->batas_tgl_kumpul).' lagi'; ?></h3>
			<?php echo date('d/m/Y H:i', strtotime($curr_tugas->batas_tgl_kumpul));?>
		</div>
		<?php } ?>
		
		<?php
			$error = $this->session->flashdata('error');
			$success = $this->session->flashdata('success');
			if($error) echo '<div class="alert alert-danger">'.$error.'</div>';
			if($success) echo '<div class="alert alert-success">'.$success.'</div>';
		?>
		
		<div class="panel" id="p2">
			<div class="panel-heading">
				<span class="panel-title"><?php echo $curr_tugas->nama_tugas; ?></span>
			</div>
			<div class="panel-body">
				<?php echo $curr_tugas->deskripsi; ?>
			</div>
			<div class="panel-footer">
				<ul class="list-inline">
					<li><i class="fa fa-upload"></i> <?php echo date('d/m/Y H:i', strtotime($curr_tugas->tgl_buat));?></li>
					<li><i class="fa fa-bell"></i> <?php echo date('d/m/Y H:i', strtotime($curr_tugas->batas_tgl_kumpul));?></li>
					<li><i class="fa fa-group"></i> <?php echo $curr_tugas->nama_kelas;?></li>
					<li><i class="fa fa-flask"></i> <?php echo $curr_tugas->nama_mp;?></li>
				</ul>
			</div>
		</div>
		
		
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-title">Pengumpulan Tugas</span>
				<?php if($curr_tugas->tgl_submit) echo '<span class="panel-title pull-right">Dikumpulkan pada : '.date('d/m/Y H:i', strtotime($curr_tugas->tgl_submit)).'</span>'; ?>
			</div>
			<div class="panel-body">
				<?php 
					if($curr_tugas->alamat_file)
					{
						$filesize = $curr_tugas->ukuran_file;
						if($filesize > 1000000) $filesize = round($filesize / 1024 / 1024 ).' mb';
						else $filesize = round($filesize / 1024 ).' kb';
						
						echo '<b>Informasi file : </b><br>';
						echo '<ul class="margin-t-10 margin-b-10">';
						echo '<li>Name : '.$curr_tugas->nama_file.'</li>';
						echo '<li>Size : '.$filesize.'</li>';
						echo '<li>Type : '.$curr_tugas->tipe_file.'</li>';
						echo '</ul><br>';			
						echo '<a href="'.site_url(PAGE_ID.'/download/'.my_base64_encode($curr_tugas->id_submit)).'" class="btn btn-primary margin-b-10 full-width"><i class="fa fa-download margin-r-5"></i> Download file yang saya kumpulkan</a>';
					}
						
				?>
				
				<?php if((!$curr_tugas->id_submit || $curr_tugas->is_multiple_submit == 1) && strtotime($curr_tugas->batas_tgl_kumpul) > strtotime('now')) { ?>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="file" name="upload" class="hide" id="upfile">
					<div id="upfile-info">
					</div>
					<div class="row">
						<div class="col-md-6">
							<button type="button" class="btn btn-default fullwidth" onclick="$('#upfile').click();"> <i class="fa fa-file margin-r-5"></i> Pilih File Tugas</button>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary fullwidth hide" id="upfile-submit"> <i class="fa fa-save margin-r-5"></i> Upload Tugas</button>
						</div>
					</div>
				</form>
				<?php } ?>
			</div>
			
			
		</div>
	</div>

	<?php } ?>
</div>

[section name="plugin-css"]
[/section]

[section name="css"]
<style>
	.list-group li{
		list-style: none;
	}
	.list-group li a{
		color: #000;
	}
	.list-group li a:hover,
	.list-group li a:focus{
		background:#ffffff;
	}
	.fc-event-desc{
		margin-top: 2px;
	}
	.alert-warning, .alert-success{
		color: #755c5c;
	}
	.alert h3{
		margin: 10px!important;
	}
	.fullwidth{
		width: 100%
	}

</style>
[/section]

[section name="plugin-js"]

[/section]

[section name="js"]
<script>
	$(document).ready(function() 
	{
		$('body').addClass('calendar-page');
		$('#content').addClass('table-layout');
		
		$('#upfile').change(function(e)
		{
			filesize = e.target.files[0].size;
			if(filesize > 1000000) filesize = Math.round(filesize / 1024 / 1024 ) + ' mb';
			else filesize = Math.round(filesize / 1024 ) + ' kb';
			
			var html = '<b>Informasi file : </b><br>';
			html += '<ul class="margin-t-10 margin-b-10">';
			html += '<li>Name : '+e.target.files[0].name+'</li>';
			html += '<li>Size : '+filesize+'</li>';
			html += '<li>Type : '+e.target.files[0].type+'</li>';
			html += '</ul><br>';			
			$('#upfile-info').html(html);
			$('#upfile-submit').removeClass('hide');
		})
		
	});
</script>
[/section]

