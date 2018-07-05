
<link href="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/custom/js/autoNumeric-min.js" type="text/javascript"></script>

<script>
	var TAKE_OVER = true; // take over init my_table
	
	$('#crud-add-link').attr('data-target','#main-modal-lg');

	var my_table = $("#datatable-main").myTable({
		extraButtons : [{text: "<i class='fa fa-check-square-o'></i>&nbsp; Set", action: function ( e, dt, node, config ) {$('#crud-add-link').click()} }, ],
	});	
	

</script>