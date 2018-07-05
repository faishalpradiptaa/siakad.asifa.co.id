<style>
	.ms-container, .ms-container .ms-selectable, .ms-container .ms-selection{width: 100% !important;}
	.ms-container .ms-loading{display:none}
	.ms-container .ms-list{height: 400px!important;}
	.ms-container .ms-selectable li.ms-elem-selectable{cursor:pointer}
	.ms-container .ms-selectable li.ms-elem-selectable, .ms-container .ms-selection li.ms-elem-selection{padding: 3px 10px; }
	.ms-container .ms-selectable li.ms-elem-selectable:hover{background-color: #eee;}
	.ms-container .ms-selectable li.ms-elem-selectable.active{background: #0665c7; color: white;}
	.ms-container.is-loading .ms-selectable{background-color:#eee;}
	.ms-container.is-loading .ms-list li{display:none}
	.ms-container.is-loading .ms-loading{display:block; position: absolute; top: 100px; width: 100%; left: 0px;}
	.ms-container.is-loading .ms-loading .fa{ font-size: 18px margin-bottom: 10px;}
</style>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" >Set Nominal per Siswa </h4>
</div>
<div class="modal-body">
	<form action="<?php echo site_url(PAGE_ID.'/form');?>" class="row-border frm_validation">
		<div class="validation_msg"></div>
		<div class="row">
		
			<div class="col-md-6">
				
				<div class="form-group">
					<label>Pilih Siswa</label>
					<select class="form-control" name="in_source">
						<option value="">-- Pilih Siswa --</option>
						<option value="angkatan">Berdasrkan angkatan</option>
						<option value="siswa">Per siswa</option>
					</select>
				</div>
				
				<div class="form-group hide" in-group="angkatan">
					<label>Pilih Angkatan</label>
					<div class="row">
						<div class="col-md-6">	
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
				</div>
				
				<div class="form-group hide" in-group="siswa">
					<label>Cari Siswa</label>
					<div class="row">
						<div class="col-md-12">
							<input type="text" id="in_ac_siswa" name="in_siswa">
							<i class="pull-right margin-t-10 ac-helper"></i>
						</div>
					</div>
				</div>
				
				<div class="alert alert-dismissable alert-info text-center">
					Harap kosongi nominal untuk tidak merubah data
				</div>
				
				<?php 
					foreach($jenis as $row) 
					{ 
						$val = isset($nominal[$row->kode_jenis]) ? $nominal[$row->kode_jenis]->nominal : '';
				?>
				<div class="form-group">
					<div class="row">
						<label class="col-md-5"><?php echo $row->nama_jenis; ?></label>
						<div class="col-md-7">
							<div class="input-group">
								<span class="input-group-addon">Rp. </span>
								<input type="text" class="form-control text-right currency" value="<?php echo $val; ?>" name="nominal[<?php echo $row->kode_jenis; ?>]">
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>List Siswa <i>(klik untuk memilih)</i> </label>
					<a href="javascript:;" class="pull-right ms-select-all">Pilih Semua</a>
					<div class="ms-container">
						<div class="ms-loading text-center">
							<i class="fa fa-refresh fa-spin"></i><br>
							Memuat Data...
						</div>
						<div class="ms-selectable">
							<ul class="ms-list" tabindex="-1">
							</ul>
						</div>
					</div>
					<label class="ms-counter"></label>
				</div>
			
			</div>
		</div>
	</form>
</div><!-- /.modal-body -->

<div class="modal-footer">
	<button type="button" class="btn btn-success" onclick="simpan_ajax('apply')">Simpan &amp; Lanjut Input</button>
	<button type="button" class="btn btn-primary" onclick="simpan_ajax('save')">Simpan</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

<script>
	$('[name="in_source"]').change(function()
	{
		if($(this).val() == 'non-kelas') getSiswa('by_non_kelas');
		$('[in-group]').addClass('hide');
		$('[in-group="'+$(this).val()+'"]').removeClass('hide');
	})
	
	var in_angkatan = $('[name="in_angkatan"]');
	var container = $('.ms-container');
	$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
	
	clearContainer();
	
	in_angkatan.change(function(){
		getSiswa('by_angkatan');		
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
			data: function (term, page) { 
				return {q: term};
			},
			results: function (data, page) {
				return {results: data.items};
			},
			cache: true
		},
		formatResult: function(m) { return '<b>'+m.id+'</b> '+ m.text; },
		escapeMarkup: function (m) { return m; } ,
		formatSelection: function(m) 
		{ 
			$('.ac-helper').text('Tekan enter untuk melanjutkan input');
			addToContainer(m.id, m.text);
			return '<b>'+m.id +'</b> '+m.text; 
		},
	});

	function getSiswa(tipe)
	{
		var my_data = {};
		if (tipe == 'by_angkatan') my_data = {angkatan : in_angkatan.val()};
		else return false;
		
		container.addClass('is-loading');
		$.ajax({
			url : '<?php echo site_url(PAGE_ID.'/get_siswa'); ?>',
			method : 'GET',
			data : my_data,
			dataType : 'JSON',
			success : function(data){
				container.removeClass('is-loading');
				clearContainer();
				$.each(data, function(key, row){
					addToContainer(row.no_induk, row.nama);					
				})
			},
			error : function(){
				container.removeClass('is-loading');				
			},
		});
	}
	
	function clearContainer()
	{
		$('li',container).remove();		
		$('.ms-counter').text('');
	}
	
	function addToContainer(no_induk, nama)
	{
		$('ul',container).append('<li class="ms-elem-selectable"><input type="hidden" name="siswanon" value="'+no_induk+'"><span><b>'+no_induk+'</b> - '+nama+'</span></li>');		
		$('.ms-counter').text('Terpilih '+$('li.active', container).length+' dari '+$('li', container).length);
	}
	
	container.on('click', 'li', function(){
		if($(this).hasClass('active')) $(this).removeClass('active').find('input').attr('name','siswanon');
		else $(this).addClass('active').find('input').attr('name','siswa[]');
		$('.ms-counter').text('Terpilih '+$('li.active', container).length+' dari '+$('li', container).length);
	})
	
	$('.ms-select-all').click(function(){
		$('li:not(.active)', container).click();
	})
	
	
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
						clearContainer();
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
		
		
	<?php if($no_induk) { ?>
		$('[name="in_source"] option[value="siswa"]').attr('selected','selected').parent().change()
		$.ajax({
			type	: 'GET',
			data	: {q : '<?php echo $no_induk; ?>'},
			url		: '<?php echo site_url('rf_siswa/autocomplete')?>',
			dataType : "json",
			cache	: false,
			success	: function(data)
			{
				$("#in_ac_siswa").select2('data',data.items[0]).trigger('change');
				$('.ms-select-all').click();
			}
		});
	<?php } ?>
</script>
