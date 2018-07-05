<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/tinymce/tinymce.min.js"></script>
<script>	
	tinymce.init({ 
		selector:'textarea',
		height : 300,
		theme: 'modern',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace visualblocks visualchars code fullscreen',
			'media nonbreaking table contextmenu directionality',
			'emoticons paste textcolor colorpicker textpattern imagetools toc moxiemanager'
		],
		toolbar1: 'styleselect forecolor backcolor fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink',
		toolbar2: 'undo redo | print preview | blockquote | media image emoticons | code fullscreen',
		image_advtab: true,
		relative_urls: false,
		remove_script_host : false,
		document_base_url: '<?php echo base_url(); ?>'
	});
	
	function beforeSave(){
		code = window.btoa(tinymce.activeEditor.getContent());
		$('[name="pengumuman_encoded"]').val(code)
	} 
</script>
