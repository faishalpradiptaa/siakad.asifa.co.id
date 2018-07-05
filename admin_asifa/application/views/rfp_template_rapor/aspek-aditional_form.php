<script>
	$('[name="tipe"]').change(function()
	{
		$('[name="rumus"],[name="id_predikat"]').removeAttr('validate').parents('.form-group').hide();
		val = $(this).val();
		if(val == 'rumus') $('[name="rumus"]').attr('validate','required').parents('.form-group').show();
		else if(val == 'nilai_predikat') $('[name="id_predikat"]').attr('validate','required').parents('.form-group').show();
	})
	$('[name="tipe"]').change();
</script>