<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" ><?php echo ($id) ? 'Ubah' : 'Tambah'; ?> Point <?php echo $detail->nama_template; ?></h4>
</div>
<div class="modal-body">
	<form action="<?php echo site_url(PAGE_ID.'/form_point/'.$raw_kode_template.'/'.$raw_id);?>" class="form-horizontal row-border frm_validation">
	<div class="validation_msg"></div>
	
	<div class="tab-container">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_form_main" data-toggle="tab">Data Point</a></li>
		</ul>
		<div class="tab-content">

			<div class="tab-pane active" id="tab_form_main">
				<div class="scroll-content">

					<div class="form-group">
						<label class="col-sm-3 control-label">Kode Point</label>
						<div class="col-md-4">
							<input class="form-control" type="text" name="kode_point" validate="required;code" value="<?php if($data) echo $data->kode_point; ?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama Point</label>
						<div class="col-md-7">
							<input class="form-control" type="text" name="nama_point" validate="required" value="<?php if($data) echo $data->nama_point; ?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">Text</label>
						<div class="col-md-9">
							<input class="form-control" type="text" name="text_point" value="<?php if($data) echo $data->text_point; ?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">Jenis Point</label>
						<div class="col-md-5">
							<select class="form-control" name="tipe_point">
								<option value=""> -- Pilih Jenis Point -- </option>
								<option value="deskripsi">Nilai Deskriptif</option>
								<option value="mapel">Nilai Mata Pelajaran</option>
								<option value="grafik_by_aspek">Grafik Nilai Mapel</option>
								<option value="riwayat">Riwayat</option>
								<option value="prestasi">Nilai Prestasi</option>
								<option value="ekskul">Nilai Ekskul</option>
								<option value="ringkasan_mapel">Ringkasan Mata Pelajaran</option>
								<option value="ringkasan_riwayat">Ringkasan Riwayat</option>
								<option value="custom">Nilai Custom</option>
							</select>
						</div>
					</div>
					
					<div class="form-group hide param-riwayat">
						<label class="col-sm-3 control-label">Riwayat yg Ditampilkan</label>
						<div class="col-md-9">
							<select class="form-control select-multiple" name="param_point[riwayat][]" multiple>
								<?php 
									$arr_riwayat = array();
									$param = json_decode($data->param_point);
									if(isset($param->riwayat)) $arr_riwayat = array_values((array)$param->riwayat);							
									
									if(is_array($jenis_riwayat)) foreach($jenis_riwayat as $jr) echo '<option value="'.$jr->kode_jenis.'" '.(in_array($jr->kode_jenis, $arr_riwayat) ? 'selected="selected"' : '').'>'.$jr->nama_jenis.'</option>'; 
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group hide param-grafik_by_aspek">
						<label class="col-sm-3 control-label">Mapel yg Ditampilkan</label>
						<div class="col-md-9">
							<select class="form-control select-multiple" name="param_point[grafik_by_aspek][]" multiple>
								<?php 
									$arr_grafik = array();
									$param = json_decode($data->param_point);
									if(isset($param->grafik_by_aspek)) $arr_grafik = array_values((array)$param->grafik_by_aspek);							
									
									if(is_array($mapel)) foreach($mapel as $mp) echo '<option value="'.$mp->kode_mp.'" '.(in_array($mp->kode_mp, $arr_grafik) ? 'selected="selected"' : '').'>'.$mp->kode_mp.' - '.$mp->nama_mp.'</option>'; 
								?>
							</select>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>              
	</form>

</div><!-- /.modal-body -->

<div class="modal-footer">
	<?php if(!$id){ ?><button type="button" class="btn btn-success" onclick="simpan_ajax('apply')">Simpan &amp; Lanjut Input</button><?php } ?>
	<button type="button" class="btn btn-primary" onclick="simpan_ajax('save')">Simpan</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/predikat.js"></script>

<script>
	/*
	$('.scroll-content').slimScroll({
		height: '470px'
	});
	*/
	
	$('.select-multiple').select2();
	
	$('[name="tipe_point"] option[value="<?php echo $data ? $data->tipe_point : ''; ?>"]').attr('selected', 'selected')
	
	$('[name="tipe_point"]').change(function()
	{
		if($(this).val() == 'riwayat' || $(this).val() == 'ringkasan_riwayat') $('.param-riwayat').removeClass('hide');
		else $('.param-riwayat').addClass('hide');
		
		if($(this).val() == 'grafik_by_aspek') $('.param-grafik_by_aspek').removeClass('hide');
		else $('.param-grafik_by_aspek').addClass('hide');
		
	}).change();
	
	function simpan_ajax(mode)
	{
		var form = '.frm_validation';
		if (!validate(form)) return false;
		
		$.ajax({
			url : $(form).attr('action'),
			method : 'POST',
			data : $(form).serialize(),
			success: function (data)
			{
				if (data == 'ok')
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data berhasil disimpan !', type: 'success'});
					if (typeof datatable !== 'undefined') datatable.ajax.reload();
					if (typeof my_table !== 'undefined') my_table.refresh();
					if(mode == 'apply')
					{
						$(form).find('.form-control[type="text"], .form-control[type="number"], .form-control[type="email"], .form-control[type="password"]').val('');
						$(form).find('.form-control').first().focus();
					}
					else 
					{
						$(form).parents('.modal').find('[data-dismiss="modal"]').click();
						if (typeof refresh_structure == 'function') refresh_structure(); 
					}
				}
				else 
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data gagal disimpan !', type: 'error'});
				}
			},
			error : function (error){
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		
		
		return false;
		
	}
</script>
<?php if(isset($additional_script)) echo $additional_script; ?>