<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" ><?php echo ($id) ? 'Ubah' : 'Tambah'; echo ' '.$this->title; ?> </h4>
</div>
<div class="modal-body">
	<form action="<?php echo site_url(PAGE_ID.'/form/'.$raw_id);?>" class="form-horizontal row-border frm_validation">
	<div class="validation_msg"></div>
	
	<div class="tab-container">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_form_main" data-toggle="tab">Data Predikat</a></li>
		</ul>
		<div class="tab-content">

			<div class="tab-pane active" id="tab_form_main">
				<div class="scroll-content">

					<div class="form-group">
						<label class="col-sm-3 control-label">Nama Predikat</label>
						<div class="col-md-7">
							<input class="form-control" type="text" name="nama_predikat" validate="required" value="<?php if($data) echo $data->nama_predikat; ?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-12"> 
							<table class="table table-striped" id="grade-container">
								<thead>
									<tr>
										<th width="17%" class="text-center">&gt;=</th>
										<th width="17%" class="text-center">&lt;</th>
										<th width="17%" >Grade</th>
										<th>Deskriptif &nbsp;<i class="fa fa-info-circle" data-original-title="Untuk digunakan di deskripsi mata pelajaran" rel="tooltip"></i></th>
										<th width="10%" class="text-center"><button class="btn btn-xs btn-primary" type="button" data-type="add"><i class="fa fa-plus"></i></button></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>              
	</form>

</div><!-- /.modal-body -->

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
	<button type="button" class="btn btn-primary" onclick="simpan_ajax('save')">Simpan</button>
	<?php if(!$id){ ?><button type="button" class="btn btn-success" onclick="simpan_ajax('apply')">Simpan &amp; Lanjut Input</button><?php } ?>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/predikat.js"></script>

<script>
	/*
	$('.scroll-content').slimScroll({
		height: '470px'
	});
	*/
	
	var grade = $("#grade-container").grade();
	
	<?php if ($data && $data->detail) echo 'grade.set('.json_encode($data->detail).')';  ?>
	
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
					else $('[data-dismiss="modal"]').click();
					if (typeof refresh == 'function') refresh(); 
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