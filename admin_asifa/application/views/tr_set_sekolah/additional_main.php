
<link href="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />

<div id="filter-sekolah-container" class="hide">
	<select class="form-control" id="filter-sekolah">
		<option value="">-- Pilih Sekolah -- </option>
		<option value="null">-- Tidak Punya Sekolah -- </option>
		<?php foreach ($sekolah as $row) echo '<option value="'.$row->kode_sekolah.'">'.$row->nama_sekolah.'</option>'; ?>
		
	</select>
</div>

<script>
	var TAKE_OVER = true; // take over init my_table
	
	$('#crud-add-link').attr('data-target','#main-modal-lg');

	var my_table = $("#datatable-main").myTable({
		extraButtons : [{text: "<i class='fa fa-check-square-o'></i>&nbsp; Set", action: function ( e, dt, node, config ) {$('#crud-add-link').click()} }, ],
		dom: "<'row'<'col-md-12 text-right'B>> <'row'<'col-md-6 col-sm-12 pull-left'l><'pull-right col-md-4 col-sm-12 tool-filter-container text-right'>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		fnInitComplete: function ( oSettings ) {
			if ($('.tabletool-container').length) $('.tabletool-container').append( this.parents('.dataTables_wrapper').find('.dt-buttons')[0] );
			$('.tool-filter-container').append( $('#filter-sekolah-container').removeClass('hide')[0] );
		},
		ajax: {
			url: "<?php echo site_url(PAGE_ID.'/get_datatable'); ?>",
			data: function ( d ) {
				d['sekolah'] = $('#filter-sekolah').val();
			}
		}
	});	
	
	$('body').on('change', '#filter-sekolah', function(){
		my_table.refresh();		
	})
</script>