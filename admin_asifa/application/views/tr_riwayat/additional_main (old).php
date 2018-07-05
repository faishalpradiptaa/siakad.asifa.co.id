<style>
	table[is_edit_all="true"] tbody [data-toggle]{display:none !important}
</style>

<div id="filter-kelas-container" class="hide">
	<select class="form-control" id="filter-kelas">
		<option value="">-- Pilih Kelas -- </option>
		<?php foreach ($kelas as $row) echo '<option value="'.$row->kode_kelas.'">'.$row->nama_kelas.'</option>'; ?>
	</select>
</div>

<script>
	var TAKE_OVER = true; // take over init my_table
	
	$('#crud-add-link').attr('data-target','#main-modal-lg');

	var my_table = $("#datatable-main").myTable({
		pageLength: 50,
		dom: "<'row'<'col-md-12 text-right'B>> <'row'<'col-md-6 col-sm-12 pull-left'l><'pull-right col-md-4 col-sm-12 tool-filter-container text-right'>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		fnInitComplete: function ( oSettings ) {
			if ($('.tabletool-container').length) $('.tabletool-container').append( this.parents('.dataTables_wrapper').find('.dt-buttons')[0] );
			$('.tool-filter-container').append( $('#filter-kelas-container').removeClass('hide')[0] );
		},
		fnDrawCallback : function(){
			if ($('[data-toggle="live-cancel-all"]:not(.hide)').length) $('[data-toggle="live-cancel-all"]:not(.hide)').click();
		},
		ajax: {
			url: "<?php echo site_url(PAGE_ID.'/get_datatable'); ?>",
			data: function ( d ) {
				d['kelas'] = $('#filter-kelas').val();
			}
		}
	});	
	
	$('body').on('change', '#filter-kelas', function(){
		my_table.refresh();		
	})
	
	$('#datatable-main').on('click', '[data-toggle="live-edit"]', function(){
		e = $(this);
		id = e.attr('data-value');
		tr = e.parents('tr');
		td = e.parents('td');
		if(tr.attr('is_edit') == 'true') return false;
		
		tr.attr('data-value', id).find('.live-text').addClass('hide');
		tr.find('input').attr('type', 'number');
		e.hide();
		td.append('<a href="javascript:;" class="btn btn-sm btn-success" data-original-title="Simpan" rel="tooltip" data-toggle="live-save"><i class="fa fa-save"></i></a> ')
		td.append('<a href="javascript:;" class="btn btn-sm btn-danger" data-original-title="Batal" rel="tooltip" data-toggle="live-cancel"><i class="fa fa-ban"></i></a>')
		tr.find('input[type="number"]').first().focus().select();
		tr.attr('is_edit','true');
	})
	
	$('#datatable-main').on('click', '[data-toggle="live-cancel"]', function(){
		e = $(this);
		tr = e.parents('tr');
		td = e.parents('td');
		id = tr.attr('data-value');
		
		tr.find('.live-text').removeClass('hide').each(function(){
			$(this).parent('td').find('input').attr('type', 'hidden').val($(this).text());
		})
		td.find('.tooltip').remove();
		td.find('[data-toggle="live-save"]').remove();
		td.find('[data-toggle="live-edit"]').show();
		e.remove();
		tr.attr('is_edit','false');
	})
	
	$('#datatable-main').on('click', '[data-toggle="live-save"]', function(){
		e = $(this);
		tr = e.parents('tr');
		td = e.parents('td');
		id = tr.attr('data-value');
		data = [];
		i = 0;
		
		tr.find('input[type="number"]').each(function()
		{
			data[i++] = {'kode_jenis' : $(this).attr('name'), 'jml' : $(this).val()}
		})
		data = {'no_induk' : id, 'data' : data};
		$.ajax({
			url : '<?php echo site_url(PAGE_ID.'/save'); ?>',
			method : 'POST',
			data : data,
			success: function (data)
			{
				if (data == 'ok')
				{
					tr.find('input[type="number"]').each(function()
					{
						$(this).parent('td').find('.live-text').text($(this).val());
					})
					td.find('[data-toggle="live-cancel"]').click();
				}
				else
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			},
			error : function (error){
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
	})

	
	$('#datatable-main').on('click', '[data-toggle="live-edit-all"]', function(){
		e = $(this);
		id = e.attr('data-value');
		tb = e.parents('table');
		
		
		if(tb.attr('is_edit_all') == 'true') return false;
		e.hide().siblings().removeClass('hide');
		
		$('tbody tr:not([is_edit="true"])', tb).each(function(){
			tr = $(this);
			id = tr.find('[data-toggle="live-edit"]').attr('data-value')
			tr.find('.live-text').addClass('hide');
			tr.find('input').attr('type', 'number');
			tr.attr('is_edit','true').attr('data-value', id)
		})
		
		tb.attr('is_edit_all', 'true');
	})
	
	$('#datatable-main').on('click', '[data-toggle="live-cancel-all"]', function(){
		e = $(this);
		tb = e.parents('table');
		
		if(tb.attr('is_edit_all') != 'true') return false;
		
		$('tbody tr[is_edit="true"]', tb).each(function(){
			tr = $(this);
			tr.find('.live-text').removeClass('hide');
			tr.find('input[type="number"]').attr('type', 'hidden').each(function(){
				td = $(this).parent('td');
				$(this).val(td.find('.live-text').text());
			});
			tr.find('[data-toggle="live-save"],[data-toggle="live-cancel"]').remove();
			tr.find('[data-toggle="live-edit"]').show();
			tr.removeAttr('is_edit')
		})
		tb.removeAttr('is_edit_all');
		e.addClass('hide').siblings().addClass('hide');
		e.parent().find('[data-toggle="live-edit-all"]').removeClass('hide').show()
	})
	
	$('#datatable-main').on('click', '[data-toggle="live-save-all"]', function(){
		e = $(this);
		tb = e.parents('table');
		data = [];
		i = 0;
		
		if(tb.attr('is_edit_all') != 'true') return false;
		
		$('tbody tr[is_edit="true"]', tb).each(function()
		{
			var tr = $(this);
			var id = tr.attr('data-value')
			var row = [];
			var j = 0;
			
			tr.find('input[type="number"]').each(function()
			{
				row[j++] = {'kode_jenis' : $(this).attr('name'), 'jml' : $(this).val()}
			})
			row = {'no_induk' : id, 'data' : row};
			data[i++] = row;
		})
		
		$.ajax({
			url : '<?php echo site_url(PAGE_ID.'/save_batch'); ?>',
			method : 'POST',
			data : {'data' : data},
			success: function (data)
			{
				if (data == 'ok')
					my_table.refresh();
				else
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			},
			error : function (error){
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		
	})
	
	
	
	$('tfoot.filter tr:first-child td:last-child')
		.append('<a href="javascript:;" class="btn btn-sm btn-primary" data-original-title="Ubah Semua" rel="tooltip" data-toggle="live-edit-all"><i class="fa fa-pencil"></i> Semua</a>')
		.append('<a href="javascript:;" class="btn btn-sm btn-success hide" data-original-title="Simpan Semua" rel="tooltip" data-toggle="live-save-all"><i class="fa fa-save"></i></a> ')
		.append('<a href="javascript:;" class="btn btn-sm btn-danger hide" data-original-title="Batal Semua" rel="tooltip" data-toggle="live-cancel-all"><i class="fa fa-ban"></i></a>')
	
</script>