<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
		<li><a href="javascript:;">Transaksi</a> <i class="fa fa-circle"></i></li>
		<li><a href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template)?>"><?php echo $template->nama_template; ?></a> <i class="fa fa-circle"></i></li>
		<li><a href="javascript:;">Isi Nilai <b><?php echo $siswa->no_induk.' - '.$siswa->nama; ?></b></a></li>
		
	</ul>
	
	<div class="row">
		<div class="col-md-12">
			<?php
				$error = $this->session->flashdata('error');
				$warning = $this->session->flashdata('warning');
				$success = $this->session->flashdata('success');
				if($error) echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$error.'</div>';
				if($warning) echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$warning.'</div>';
				if($success) echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$success.'</div>';
			?>
			
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Pengisian <?php echo $template->nama_template.' "'.$siswa->no_induk.' - '.$siswa->nama.'"'; ?></span>
					</div>
					<div class="tools tabletool-container">
						<div class="dt-buttons">
							<a class="dt-button" href="<?php echo site_url(PAGE_ID.'/view/'.$template->kode_template.'/'.my_base64_encode($siswa->id_ambil_kelas)); ?>" class="btn btn-default"><span><i class="glyphicon glyphicon-file"></i>&nbsp; Rapor</span></a>
							<a class="dt-button" href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template.'#'.$siswa->kode_kelas); ?>" class="btn btn-default"><span><i class="glyphicon glyphicon-arrow-left"></i>&nbsp; Kembali</span></a>
						</div>
					</div>
				</div>
				<div class="portlet-body clearfix">
					
					<!-- RAPOR HEADER -->
					<div class="row rapor-header">
						<div class="col-md-12">
							<table border="0" width="100%">
								<tr>
									<td width="12%">Nama</td>
									<td width="50%">: <?php echo $siswa->nama; ?></td>
									<td width="12%">Kelas</td>
									<td>: <?php echo $siswa->nama_kelas; ?></td>
								</tr>
								<tr>
									<td>No. Induk</td>
									<td>: <?php echo $siswa->no_induk; ?></td>
									<td>Semester</td>
									<td>: <?php echo $this->curr_thn_ajaran->sem_ajaran; ?></td>
								</tr>
								<tr>
									<td>NISN</td>
									<td>: <?php echo $siswa->nisn; ?></td>
									<td>Tahun Pelajaran</td>
									<td>: <?php echo $this->curr_thn_ajaran->thn_ajaran; ?></td>
								</tr>
							</table>
						</div>
					</div>
				
					<form method="post" action="" class="main-form">
						<?php echo $form; ?>
						
						<!-- RAPOR PROPERTY -->
						<div class="row">
							<div class="col-md-4 text-center">
								<br>
								Orang Tua / Wali
								<br><br><br><br>
								(...........................................)
							</div>
							<div class="col-md-4 col-md-offset-4 text-center">
								<div class="input-group margin-b-15">
									<span class="input-group-btn">
										<button class="btn default" type="button">Malang, </button>
									</span>
									<input class="form-control datepicker" type="text" name="data[tgl_publish]" validate="" value="<?php echo $rapor ? date('d/m/Y', strtotime($rapor->tgl_publish)) : date('d/m/Y'); ?>">
									<span class="input-group-btn">
										<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
								<?php echo $template->ttd_1; ?>
								<br><br><br><br>
								<?php 
									$ttd1 = $rapor->nama_ttd_1 ? $rapor->nama_ttd_1 : $template->nama_ttd_1;
									if($template->nama_ttd_1) echo '<input type="text" class="form-control text-center" name="data[nama_ttd_1]" value="'.$ttd1.'">';
									else echo $siswa->nama_wali_kelas; 
								?>
							</div>
						</div>
						<br>
						<?php if ($template->ttd_2) { ?>
						<div class="row">
							<div class="col-md-4 col-md-offset-4 text-center">
								<br>
								<?php echo $template->ttd_2; ?>
								<br><br><br><br>
								<?php 
									$ttd2 = $rapor->nama_ttd_2 ? $rapor->nama_ttd_2 : $template->nama_ttd_2;
									if($template->nama_ttd_2) echo '<input type="text" class="form-control text-center" name="data[nama_ttd_2]" value="'.$ttd2.'">';
									else echo $siswa->kepsek.'<br>'.$siswa->nip_kepsek; 
								?>
								<br><br>
							</div>
						</div>
						<?php } ?>
						
						<div class="row margin-b-20">
							<div class="col-md-5 col-md-offset-3">
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn default" type="button"><input type="checkbox" name="data[status]" <?php if ($rapor && $rapor->status == 'valid') echo 'checked="checked"' ?> value="valid"></button>
									</span>
									<span class="input-group-btn">
										<button class="btn default" type="button">Data sudah divalidasi dan dinyatakan lengkap dan benar.</button>
									</span>
								</div>
							</div>
						</div>
						
						<div class="row margin-t-15">
							<div class="col-md-12 text-center">
								<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Simpan</button>
								<a class="btn btn-default" href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template.'#'.$siswa->kode_kelas); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


[section name="page-actions"]
<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height green-sharp dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Jenjang"> 
		<i class="fa fa-signal fa-rotate-90"></i>&nbsp;
		<span class="thin hidden-xs"> <?php echo $this->curr_jenjang->nama_jenjang; ?></span>&nbsp;
	</a>
</div>

<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height blue-steel dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Tahun Ajaran"> 
		<i class="fa fa-archive"></i>&nbsp;
		<span class="thin hidden-xs">Tahun Ajaran : <?php echo $this->curr_thn_ajaran->thn_ajaran.' '.$this->curr_thn_ajaran->sem_ajaran; ?></span>&nbsp;
	</a>
</div>
[/section]

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>
[/section]

[section name="css"]
<style>
	.rapor-header, .rapor-point{
		margin-bottom: 15px;		
	}
	
	.rapor-point h4{
		font-size: 16px;
    font-weight: bold;
	}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
[/section]

[section name="js"]
<script>

	/**** GLOBAL ****/
	var MAIN_FORM = $('.main-form');
	$('table', MAIN_FORM).on('focus', 'input,textarea,select', function(){
		$(this).parents('tr').addClass('active');		
	})
	$('table', MAIN_FORM).on('blur', 'input,textarea,select', function(){
		$(this).parents('tr').removeClass('active');		
	})
	$('.page-sidebar-menu').find('[href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template); ?>"]').parent('li').addClass('active').parents('li').addClass('active open');
	$('.datepicker').datepicker({format: 'dd/mm/yyyy'});
	
	/**** TABLE EKSKUL ****/
	$('.table-ekskul', MAIN_FORM).on('click','[data-toggle]',function(){
		e = $(this);
		table = e.parents('table');
		tbody = table.find('tbody');
		tr = e.parents('tr');
		attr = e.attr('data-toggle');
		i = tbody.find('tr').last();
		i = i ? parseInt(i.attr('number')) : 0;
		option = $('#select-ekskul').html();
		
		if(attr == 'add')
		{
			i++;
			html = '<tr number="'+i+'">'+
				'<td><select class="form-control" name="ekskul['+i+'][kode_ekskul]">'+option+'</select></td>'+
				'<td><input type="text" class="form-control" name="ekskul['+i+'][keterangan]" value="<?php echo $row->keterangan; ?>"></td>'+
				'<td class="text-center">'+
					'<a href="javascript:;" tabindex="-1" class="btn btn-sm btn-danger" data-toggle="delete"><i class="fa fa-trash"></i></a></th>'+
				'</td>'+
			'</tr>';
			tbody.append(html);
		}
		else if(attr == 'delete')
		{
			tr.remove();
		}
	})
	if(!$('.table-prestasi tbody tr', MAIN_FORM).length) $('.table-prestasi [data-toggle="add"]').click();
	$('.table-ekskul [data-value]', MAIN_FORM).each(function(){
		e = $(this);
		val = e.attr('data-value');
		e.find('option[value="'+val+'"]').attr('selected', 'selected');		
	})

	
	/**** TABLE PRESTASI ****/
	$('.table-prestasi', MAIN_FORM).on('click','[data-toggle]',function(){
		e = $(this);
		table = e.parents('table');
		tbody = table.find('tbody');
		tr = e.parents('tr');
		attr = e.attr('data-toggle');
		i = tbody.find('tr').last();
		i = i ? parseInt(i.attr('number')) : 0;
		
		if(attr == 'add')
		{
			i++;
			html = '<tr number="'+i+'">'+
				'<td><input type="text" class="form-control" name="prestasi['+i+'][jenis]" value="<?php echo $row->jenis; ?>"></td>'+
				'<td><input type="text" class="form-control" name="prestasi['+i+'][keterangan]" value="<?php echo $row->keterangan; ?>"></td>'+
				'<td class="text-center">'+
					'<a href="javascript:;" tabindex="-1" class="btn btn-sm btn-danger" data-toggle="delete"><i class="fa fa-trash"></i></a></th>'+
				'</td>'+
			'</tr>';
			tbody.append(html);
		}
		else if(attr == 'delete')
		{
			tr.remove();
		}
	})
	if(!$('.table-prestasi tbody tr', MAIN_FORM).length) $('.table-prestasi [data-toggle="add"]').click();
</script>
[/section]

