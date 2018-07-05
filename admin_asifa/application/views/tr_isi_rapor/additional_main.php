
<link href="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />

<div id="filter-kelas-container" class="hide">
	<select class="form-control" id="filter-kelas">
		<option value="">-- Pilih Kelas -- </option>
		<?php foreach ($kelas as $row) echo '<option value="'.$row->kode_kelas.'">'.$row->nama_kelas.'</option>'; ?>
		
	</select>
</div>

<script>
	var TAKE_OVER = true; // take over init my_table
	var id_kelas = window.location.hash.replace('#','');
	if(id_kelas) $('#filter-kelas option[value="'+id_kelas+'"]').attr('selected','selected')
	
	$('#crud-add-link').attr('data-target','#main-modal-lg');

	var my_table = $("#datatable-main").myTable({
		dom: "<'row'<'col-md-12 text-right'B>> <'row'<'col-md-6 col-sm-12 pull-left'l><'pull-right col-md-4 col-sm-12 tool-filter-container text-right'>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		fnInitComplete: function ( oSettings ) {
			if ($('.tabletool-container').length) $('.tabletool-container').append( this.parents('.dataTables_wrapper').find('.dt-buttons')[0] );
			$('.tool-filter-container').append( $('#filter-kelas-container').removeClass('hide')[0] );
		},
		ajax: {
			url: "<?php echo site_url(PAGE_ID.'/get_datatable/'.$template_rapor->kode_template); ?>",
			data: function ( d ) {
				d['kelas'] = id_kelas && !$('#filter-kelas').val() ? id_kelas : $('#filter-kelas').val();
			}
		}
	});	
	
	$('body').on('change', '#filter-kelas', function(){
		my_table.refresh();		
	})
</script>