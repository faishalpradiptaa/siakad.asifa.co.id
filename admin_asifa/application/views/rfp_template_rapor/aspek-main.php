<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>
<style>
	.dataTables_filter{display:none!important;}
</style>


<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" >Aspek <b>"<?php echo $detail_point->nama_point; ?>"</b> </h4>
</div>
<div class="modal-body">

	<div class="row">
		<div class="col-md-12">
			<div class="tools tabletool-container"> 
				<a href='<?php echo site_url(PAGE_ID.'/form/0/'.$kode_template.'/'.$kode_point); ?>' data-toggle='modal' data-target='#main-modal-md' class="hide" id="crud-add-link"></a>
			</div>
			<div class="table-container">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="datatable-main">
					<thead>
						<tr class="heading">
							<th width="8%">No.</th>
							<th width="15%">Kode</th>
							<th>Nama Aspek</th>
							<th width="15%" data-class="text-center">Tipe</th>
							<th width="10%" data-class="text-center">Panjang</th>
							<th width="10%" data-class="text-center" data-sortable="false">Opsi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>


<script>
	var my_table = $("#datatable-main").myTable(
	{
		dom : "<'row'<'col-md-4 col-sm-12'l><'col-md-8 col-sm-12 text-right'B>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		extraButtons : [ <?php if ($this->allow_create) echo '{text: "<i class=\'glyphicon glyphicon-plus\'></i>&nbsp; Tambah", action: function ( e, dt, node, config ) {$(\'#crud-add-link\').click()}}'; ?>],
		fnInitComplete : function ( oSettings ) {},
		ajax : {
			url : "<?php echo site_url(PAGE_ID.'/get_datatable'); ?>",
			data : function ( d ) {
				d['kode_template'] = '<?php echo $kode_template; ?>';
				d['kode_point'] = '<?php echo $kode_point; ?>';
			}
		}
	});	
</script>

