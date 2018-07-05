
<script>
	var TAKE_OVER = true; // take over init my_table
	var my_table = $("#datatable-main").myTable({
		extraButtons : [{text: "<i class='glyphicon glyphicon-plus'></i>&nbsp; Tambah", action: function ( e, dt, node, config ) {window.location = $('#crud-add-link').attr('href')} }, ],
	});	
</script>