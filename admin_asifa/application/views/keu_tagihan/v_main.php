<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
	</ul>
	
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Buat Tagihan </span>
					</div>
				</div>
				<div class="portlet-body">
					
				
					<form action="<?php echo site_url(PAGE_ID);?>" method="POST" class="form-horizontal row-border main-form">
					<div class="row">
						<div class="col-md-6">
						
							<div class="form-group">
								<label class="col-md-4 control-label">Pilih Siswa</label>
								<div class="col-md-8">
									<select class="form-control" name="in_source" required>
										<option value="">-- Pilih Siswa --</option>
										<option value="semua">Semua siswa</option>
										<option value="kelas">Berdasrkan kelas</option>
										<option value="angkatan">Berdasrkan angkatan</option>
										<option value="siswa">Per siswa</option>
									</select>
								</div>
							</div>
							
							<div class="form-group hide" in-group="kelas">
								<label class="col-md-4 control-label">Pilih Kelas</label>
								<div class="col-md-7">
									<select class="form-control" name="in_kelas">
										<option value="">-- Pilih Kelas --</option>
										<?php 
											if(is_array($kelas) ) 
											{	
												foreach ($kelas as $row) echo '<option value="'.$row->kode_kelas.'" tahun="'.$row->kode_thn_ajaran.'">'.$row->nama_kelas.' ('.$row->kode_jenjang.')</option>'; 
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group hide" in-group="angkatan">
								<label class="col-md-4 control-label">Pilih Angkatan</label>
								<div class="col-md-5">	
									<select class="form-control" name="in_angkatan">
										<option value="">-- Pilih Angkatan --</option>
										<?php 
											if(is_array($angkatan) ) 
											{	
												foreach ($angkatan as $row) echo '<option value="'.$row->angkatan.'">'.$row->angkatan.'</option>'; 
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group hide" in-group="siswa">
								<label class="col-md-4 control-label">Cari Siswa</label>
								<div class="col-md-8">
									<input type="text" id="in_ac_siswa" name="in_siswa">
								</div>
							</div>
					
							<div class="form-group">
								<label class="col-md-4 control-label">Jenis Pembayaran</label>
								<div class="col-md-6">
									<select class="form-control" name="in_jenis_bayar" required> 
										<option value="">-- Pilih Jenis --</option>
										<?php 
											if(is_array($jenis_pembayaran) ) 
											{	
												foreach ($jenis_pembayaran as $row) echo '<option value="'.$row->kode_jenis.'" type="'.$row->tipe_jenis.'">'.$row->nama_jenis.'</option>'; 
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group hide" in-group-jenis="per_bulan">
								<label class="col-md-4 control-label">Pilih Bulan</label>
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input class="form-control monthpicker" name="in_bulan" required value="<?php echo date('m/Y'); ?>">
									</div>
									
								</div>
							</div>
							
							<div class="form-group hide" in-group-jenis="per_semester">
								<label class="col-md-4 control-label">Pilih Semester</label>
								<div class="col-md-6">
									<select class="form-control" name="in_semester">
										<option value="">-- Pilih Semester --</option>
										<?php 
											$curr_thn_ajaran = false;
											if(is_array($this->thn_ajaran)) foreach ($this->thn_ajaran as $thn)
											{
												if($thn->kode_thn_ajaran == THN_AJARAN) $curr_thn_ajaran = $thn->thn_ajaran;
												echo '<option value="'.$thn->kode_thn_ajaran.'" '.($thn->kode_thn_ajaran == THN_AJARAN ? ' selected="selected" ' : '').'>'.$thn->thn_ajaran.' '.$thn->sem_ajaran.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group hide" in-group-jenis="per_thn_ajaran">
								<label class="col-md-4 control-label">Pilih Tahun Ajaran</label>
								<div class="col-md-6">
									<select class="form-control" name="in_thn_ajaran">
										<option value="">-- Pilih Tahun Ajaran --</option>
										<?php 
											$thn_ajaran = array();
											if(is_array($this->thn_ajaran)) foreach ($this->thn_ajaran as $thn) if(!in_array($thn->thn_ajaran, $thn_ajaran))
											{
												$thn_ajaran[] = $thn->thn_ajaran;
												echo '<option value="'.$thn->kode_thn_ajaran.'" '.($thn->thn_ajaran == $curr_thn_ajaran ? ' selected="selected" ' : '').'>'.$thn->thn_ajaran.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<label class="control-label col-md-4">Nominal</label>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">Rp. </span>
											<input type="text" class="form-control text-right currency" placeholder="Otomatis" name="in_nominal">
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="col-md-6">
							<div class="well">
								<div class="form-group">
									<label class="control-label col-md-3">Keterangan</label>
									<div class="col-md-9">
										<textarea class="form-control" name="in_keterangan" rows="8"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3"></label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
												<input type="checkbox" name="in_skip_exists" value="1" checked> Lewati data tagihan yg sama yg sudah ada</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="text-center">
						<button type="submit" class="btn btn-primary">Buat Tagihan</button>
						<a class="btn btn-default" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Kembali</a>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>

[section name="page-actions"]
<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height blue-steel dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Tahun Ajaran"> 
		<i class="fa fa-archive"></i>&nbsp;
		<span class="thin hidden-xs">Tahun Ajaran : <?php echo $this->curr_thn_ajaran->thn_ajaran.' '.$this->curr_thn_ajaran->sem_ajaran; ?></span>&nbsp;
		<i class="fa fa-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<?php if(is_array($this->thn_ajaran)) foreach ($this->thn_ajaran as $thn) echo '<li><a href="'.site_url(PAGE_ID.'/change_thn_ajaran/'.$thn->kode_thn_ajaran).'"><i class="fa fa-'.($thn->kode_thn_ajaran == THN_AJARAN ? 'check-circle-o' : 'circle-o').'"></i> Tahun Ajaran : '.$thn->thn_ajaran.' '.$thn->sem_ajaran.'</a></li>'; ?>
	</ul>
</div>
[/section]

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
[/section]

[section name="css"]
<style>
	.portlet-body{
		position: relative;
	}
	.portlet-loading{
		background: rgba(255,255,255,0.7);
    position: absolute;
    width: 100%;
    z-index: 99999;
    top: 0;
    bottom: 0;
	}
	.portlet-loading .loading-bg{
		margin-top: 80px;
		text-align: center;
		font-size: 18px;
	}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/autoNumeric-min.js"></script>

[/section]

[section name="js"]
<script>
	var PAGE_URL = '<?php echo site_url(PAGE_ID);?>';
	
	$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
	$('.monthpicker').datepicker({
			format: 'mm/yyyy',
			viewMode: 'months',
			minViewMode: 'months',
		});
	
	$('[name="in_source"]').change(function()
	{
		$('[in-group]').addClass('hide');
		$('[in-group="'+$(this).val()+'"]').removeClass('hide');
	})
	
	$('[name="in_jenis_bayar"]').change(function()
	{
		var tipe = $(this).find('option[value="'+$(this).val()+'"]').attr('type');
		$('[in-group-jenis]').addClass('hide');
		$('[in-group-jenis="'+tipe+'"]').removeClass('hide');
	})
	
	$("#in_ac_siswa").select2({
		placeholder: "Cari No Induk atau Nama Siswa",
		minimumInputLength: 3,
		width: '100%',
		allowClear : true,
		ajax: {
			url: "<?php echo site_url('rf_siswa/autocomplete'); ?>",
			dataType: 'json',
			delay: 250,
			data: function (term, page) { return {q: term};	},
			results: function (data, page) { return {results: data.items}; },
			cache: true
		},
		formatResult: function(m) { return '<b>'+m.id+'</b> '+ m.text; },
		escapeMarkup: function (m) { return m; } ,
		formatSelection: function(m) 
		{ 
			return '<b>'+m.id +'</b> '+m.text; 
		},
	});

	$('.main-form').submit(function(){
		$(this).parents('.portlet-body').prepend('<div class="portlet-loading"><div class="loading-bg"><i class="fa fa-refresh fa-spin margin-r-5"></i> Memproses Data....</div></div>');
		$.ajax({
			url : $(this).attr('action'),
			method : 'POST',
			data : $(this).serialize(),
			dataType : 'JSON',
			success: function (data)
			{
				$('.portlet-loading').remove();
				if (data.status == true)
				{
					$.pnotify({title: 'Buat Tagihan', text: data.text, type: 'success'});
				}
				else 
				{
					$.pnotify({title: 'Buat Tagihan', text: data.text, type: 'error'});
				}
			},
			error : function (error){
				$('.portlet-loading').remove();
				$.pnotify({title: 'Buat Tagihan', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		return false;
		
	})
	
	
	// Page Property	
	$('.page-sidebar-menu a').each(function()
	{
		var href = $(this).attr('href');
		if (window.location.href.indexOf(href) > -1) $('.caption i').addClass($(this).find('i').attr('class'));
	});

	$('.caption .fa').addClass($('.page-sidebar-menu li.active a').attr('class'));
	
</script>
[/section]

