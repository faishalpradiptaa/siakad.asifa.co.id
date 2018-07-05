<div id="additional-field-mapel" class="hide">
	<?php if(is_array($deskripsi)) foreach($deskripsi as $i => $desk) { ?>
	<div class="form-group" kode-jenis="<?php echo $desk->kode_jenis; ?>">
		<label class="col-sm-3 control-label">
			Deskripsi <?php echo $desk->nama_aspek ?> <br><br>
			<i><small>Tambahkan [predikat] untuk memunculkan predikat</small></i>
		</label>
		<div class="col-sm-9">
			<input type="hidden" name="aspek_kode[<?php echo $i?>]" value="<?php echo $desk->kode_aspek; ?>"/>
			<textarea rows="6" class="form-control" name="aspek_deskripsi[<?php echo $i?>]"><?php echo $desk->deskripsi; ?></textarea>
		</div>
	</div>
	<?php } ?>
</div>

<script>
	$('.scroll-content').append($('.modal').find('#additional-field-mapel .form-group'));
	
	$('[name="kode_kelompok"]').change(function(){
		var attr = $(this).find('option[value="'+$(this).val()+'"]').attr('additional');
		$('[kode-jenis]').hide();				
		$('[kode-jenis="'+attr+'"]').show();
	})
	
	$('[name="kode_kelompok"]').change();
</script>