<link rel='stylesheet' type='text/css' href='<?php echo base_url()?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css' /> 

<script type='text/javascript' src='<?php echo base_url()?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js'></script> 
<script type='text/javascript' src='<?php echo base_url()?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js'></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/autoNumeric-min.js"></script>

<div id="filter-tgl-container" class="hide">
	<button class="btn btn-default" id="daterangepicker" type="button">
		<i class="fa fa-calendar"></i> &nbsp; <span><?php echo date('d M Y').' s/d '.date('d M Y'); ?></span> &nbsp; <b class="caret"></b>
	</button>
	
	<input name="in_taw" id="in_taw" type="hidden" value="<?php echo date('Y-m-d'); ?>">
	<input name="in_tak" id="in_tak" type="hidden" value="<?php echo date('Y-m-d'); ?>">
</div>

<script>
	var TAKE_OVER = true; // take over init my_table
	
	var table_container = $("#datatable-main");

	var my_table = table_container.myTable({
		dom: "<'row'<'col-md-12 text-right'B>> <'row'<'col-md-6 col-sm-12 pull-left'l><'pull-right col-md-4 col-sm-12 tool-filter-container text-right'>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		fnInitComplete: function ( oSettings ) {
			if ($('.tabletool-container').length) $('.tabletool-container').append( this.parents('.dataTables_wrapper').find('.dt-buttons')[0] );
			$('.tool-filter-container').append( $('#filter-tgl-container').removeClass('hide')[0] );
		},
		fnDrawCallback: function( oSettings ) {
      var html = '';
			var response = this.api().ajax.json();
			html += '<td class="text-right" colspan="'+(table_container.find('thead>tr>th').length-1)+'"><b>Total</b></td>';
			html += '<td class="text-right"><b>'+int2rupiah(response['sum_total'])+'</b></td>';
			table_container.find('tbody').append('<tr>'+html+'</tr>');
    },
		ajax: {
			url: "<?php echo site_url(PAGE_ID.'/get_datatable'); ?>",
			data: function ( d ) {
				d['in_taw'] = $('#in_taw').val();
				d['in_tak'] = $('#in_tak').val();
			}
		}
	});	
	
	$('#daterangepicker').daterangepicker(
	{
		ranges: {<?php echo getDatePickerRange(); ?>},
		opens: 'left',
		startDate: moment(),
		endDate: moment()
	},
	function(start, end) 
	{
		$('#daterangepicker span').html(start.format('D MMM YYYY') + ' s/d ' + end.format('D MMM YYYY'));
		$('#in_taw').val(start.format('YYYY-M-D'));
		$('#in_tak').val(end.format('YYYY-M-D'));
		my_table.refresh();	
	})

	$('body').on('change', '#filter-kelas', function(){
		my_table.refresh();		
	})
</script>