<style>
	.ms-container, .ms-container .ms-selectable, .ms-container .ms-selection{width: 100% !important;}
	.ms-container .ms-loading{display:none}
	.ms-container .ms-list{height: 300px!important;}
	.ms-container .ms-selectable li.ms-elem-selectable{cursor:pointer}
	.ms-container .ms-selectable li.ms-elem-selectable, .ms-container .ms-selection li.ms-elem-selection{padding: 3px 10px; }
	.ms-container .ms-selectable li.ms-elem-selectable:hover{background-color: #eee;}
	.ms-container .ms-selectable li.ms-elem-selectable.active{background: #0665c7; color: white;}
	.ms-container .ms-selectable li.ms-elem-selectable.half-active{background: #525E64; color: white;}
	.ms-container.is-loading .ms-selectable{background-color:#eee;}
	.ms-container.is-loading .ms-list li{display:none}
	.ms-container.is-loading .ms-loading{display:block; position: absolute; top: 100px; width: 100%; left: 0px;}
	.ms-container.is-loading .ms-loading .fa{ font-size: 18px margin-bottom: 10px;}
	.modal-loading{
		background: rgba(255,255,255,0.7);
    position: absolute;
    width: 100%;
    z-index: 99999;
    top: 0;
    bottom: 0;
		padding: 0px;
    margin: 0px;
	}
	.modal-loading .loading-bg{
		margin-top: 180px;
		text-align: center;
		font-size: 18px;
	}
</style>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" >Pembagian Siswa ke Kelas </h4>
</div>
<div class="modal-body">
	<form action="<?php echo site_url(PAGE_ID.'/form');?>" class="row-border frm_validation">
		<div class="validation_msg"></div>
		<div class="row">
		
			<div class="col-md-6">
				<div class="form-group">
					<label>Kelas</label>
					<div class="row">
						<div class="col-md-12">
							<select class="form-control margin-b-10" id="in_ac_kelas" name="in_ac_kelas" validate="required" multiple>
								<option value="">-- Pilih Kelas --</option>
								<?php 
									if(is_array($kelas) ) 
									{	
										foreach ($kelas as $row) if($row->kode_thn_ajaran == THN_AJARAN) echo '<option value="'.$row->kode_kelas.'">'.$row->nama_kelas.'</option>'; 
									}
								?>
							</select>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label>List Siswa <i>(klik untuk memilih)</i> </label>
					<a href="javascript:;" class="pull-right ms-select-all-siswa">Pilih Semua</a>
					<div class="ms-container ms-container-siswa">
						<div class="ms-loading text-center">
							<i class="fa fa-refresh fa-spin"></i><br>
							Memuat Data...
						</div>
						<div class="ms-selectable">
							<ul class="ms-list" tabindex="-1">
							</ul>
						</div>
					</div>
					<label class="ms-counter-siswa"></label>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Cari Mata Pelajaran</label>
					<div class="row">
						<div class="col-md-12">
							<input type="text" id="in_ac_mapel" name="in_siswa">
							<i class="pull-right margin-t-10 ac-helper"></i>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label>List Mata Pelajaran <i>(klik untuk memilih)</i> </label>
					<a href="javascript:;" class="pull-right ms-select-all-mapel">Pilih Semua</a>
					<div class="ms-container ms-container-mapel">
						<div class="ms-loading text-center">
							<i class="fa fa-refresh fa-spin"></i><br>
							Memuat Data...
						</div>
						<div class="ms-selectable">
							<ul class="ms-list" tabindex="-1">
							</ul>
						</div>
					</div>
					<label class="ms-counter-mapel"></label>
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

	var container_siswa = $('.ms-container-siswa');
	var container_mapel = $('.ms-container-mapel');
	var in_ac_kelas = $('#in_ac_kelas');
	
	$("#in_ac_mapel").select2({
		placeholder: "Cari Kode atau Nama Mata Pelajaran",
		minimumInputLength: 3,
		width: '100%',
		allowClear : true,
		ajax: {
			url: "<?php echo site_url('rfp_mapel/autocomplete'); ?>",
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
			addToContainerMapel(m.id, m.text, '', 'new');
			return '<b>'+m.id +'</b> '+m.text; 
		},
	});

	in_ac_kelas.select2();
	
	in_ac_kelas.change(function(){
		getSiswa($(this).val());
	})
	
	var filter_val = $('#filter-kelas').val();
	if(filter_val) 
	{
		$('option[value="'+filter_val+'"]', in_ac_kelas).attr('selected','selected');
		in_ac_kelas.change();
	}
	
	
	
	//================ START SISWA =================
	
	function getSiswa(val)
	{
		if(!val) 
		{
			clearContainer('siswa');
			return false;
		}
		container_siswa.addClass('is-loading');
		$.ajax({
			url : '<?php echo site_url(PAGE_ID.'/get_siswa/'.$id_ambil_kelas); ?>',
			method : 'GET',
			data : {kelas : val},
			dataType : 'JSON',
			success : function(data){
				container_siswa.removeClass('is-loading');
				clearContainer('siswa');
				clearContainer('mapel');
				if(!data.siswa) return false;
				
				$.each(data.siswa, function(key, row){
					addToContainerSiswa(row.id_ambil_kelas, row.kode_kelas, row.no_induk, row.nama);					
				})
				
				if(!data.mapel) return false;
				$.each(data.mapel, function(key, row){
					addToContainerMapel(row.kode_mp, row.nama_mp, row.id_ak, 'hide');
				})
				
				<?php if ($id_ambil_kelas) echo '$("li", container_siswa).first().click();';; ?>
			},
			error : function(){
				container_siswa.removeClass('is-loading');				
			},
		});
	}
	
	function addToContainerSiswa(id_ambil, kelas, no_induk, nama)
	{
		$('ul',container_siswa).append('<li class="ms-elem-selectable" id_ak="'+id_ambil+'" kelas="'+kelas+'"><input type="hidden" name="siswanon" value="'+id_ambil+'"><span><b>'+no_induk+'</b> - '+nama+'</span></li>');		
		$('.ms-counter-siswa').text('Terpilih '+$('li.active', container_siswa).length+' dari '+$('li', container_siswa).length);
	}
	
	container_siswa.on('click', 'li', function(){
		
		if($(this).hasClass('active')) $(this).removeClass('active').find('input').attr('name','siswanon');
		else $(this).addClass('active').find('input').attr('name','siswa[]');
		$('.ms-counter-siswa').text('Terpilih '+$('li.active', container_siswa).length+' dari '+$('li', container_siswa).length);
		generateMapel();
	})
	
	$('.ms-select-all-siswa').click(function(){
		$('li:not(.active)', container_siswa).click();
	})
	
	
	//================ START MAPEL =================
	
	function generateMapel()
	{
		$('li.new', container_mapel).remove();
		$('li[id_ak]:not(.new)', container_mapel).addClass('hide').removeClass('active').removeClass('half-active')
		$('li.active', container_siswa).each(function(){
			var id_ambil_kelas = $(this).attr('id_ak');
			$('li[id_ak~="'+id_ambil_kelas+'"]', container_mapel).removeClass('hide').addClass('active');
			$('li:not([id_ak*="'+id_ambil_kelas+'"]):not(.new)',container_mapel).removeClass('active').addClass('half-active');
		})
		syncMapel();
	}
	
	function addToContainerMapel(kode, nama, id_ambil_kelas, status)
	{
		$('ul',container_mapel).prepend('<li class="ms-elem-selectable '+status+'" id_ak="'+id_ambil_kelas+'" id_mapel="'+kode+'"><input type="hidden" name="mapelnon" value="'+id_ambil_kelas+'"><span><b>'+kode+'</b> - '+nama+'</span></li>');
		syncMapel();
	}
	
	function syncMapel()
	{
		$('li.half-active.active', container_mapel).removeClass('active');
		$('li.active', container_mapel).each(function(){
			var id_ak = $(this).attr('id_ak');
			$(this).find('input').attr('name','mapel[]').val($(this).attr('id_mapel')+'|'+id_ak);			
		})
		$('li.half-active.hide', container_mapel).removeClass('half-active')
		$('li:not(.active) input', container_mapel).attr('name','mapelnon');
		$('li.half-active input', container_mapel).attr('name','mapel[]');
		
		// jika new lihat apakah data ada jika ada maka tdk perlu add baru
		
		$('.ms-counter-mapel').text('Terpilih '+$('li.active', container_mapel).length+' dari '+$('li:not(.hide)', container_mapel).length);
	}
	
	container_mapel.on('click', 'li', function(e)
	{
		var id_mapel = $(this).attr('id_mapel');
		if($(this).hasClass('active')) 
		{
			$(this).removeClass('active').find('input').attr('name','mapelnon');
		}
		else 
		{
			// get id_ambil_kelas
			var id_kelas = '';
			$('li.active', container_siswa).each(function(){
				id_kelas += $(this).attr('id_ak')+' ';
			})
			$(this).addClass('active').removeClass('half-active').attr('id_ak', id_kelas);
		}
		syncMapel();
	})
	
	$('.ms-select-all-mapel').click(function(){
		$('li:not(.active)', container_mapel).click();
	})
	
	
	//================ START GLOBAL =================
	
	function clearContainer(target)
	{
		if(target == 'siswa')
		{
			$('li',container_siswa).remove();		
			$('.ms-counter-siswa').text('Terpilih '+$('li.active', container_siswa).length+' dari '+$('li', container_siswa).length);
		}
		else
		{
			$('li',container_mapel).remove();		
			syncMapel();
			$('.ms-counter-mapel').text('');
		}
	}
	
	function simpan_ajax(mode)
	{
		var form = '.frm_validation';
		$(form).parents('.modal-content').prepend('<div class="modal-loading"><div class="loading-bg"><i class="fa fa-refresh fa-spin margin-r-5"></i> Memproses Data....</div></div>');
		
		$.ajax({
			url : $(form).attr('action'),
			method : 'POST',
			data : $(form).serialize(),
			success: function (data)
			{
				$(form).parents('.modal-content').find('.modal-loading').remove();
				if (data == 'ok')
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data berhasil disimpan !', type: 'success'});
					if (typeof datatable !== 'undefined') datatable.ajax.reload();
					if (typeof my_table !== 'undefined') my_table.refresh();
					if(mode == 'apply')
					{
						clearContainer('mapel');
						clearContainer('siswa');
						$('#in_ac_kelas option').removeAttr('selected').parent().change();
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
				$(form).parents('.modal-content').find('.modal-loading').remove();
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		
		
		return false;
	}

</script>
