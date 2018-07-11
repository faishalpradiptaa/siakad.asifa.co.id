<div class="page-content"> // Halaman utama template

	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
	</ul>

	<?php
		$heading = '';
		$filter = '';
		$datatable = array();

		foreach ($this->column as $key => $col)
		{
			$col = (object)$col;
			$title = isset($col->title) ? $col->title : $key;

			// heading
			$h = '';
			$attr = '';
			if(is_array($col->attribut))foreach($col->attribut as $attr_key => $attr_val) $attr .= " $attr_key=\"$attr_val\"";
			if (isset($col->width)) $h = '<th width="'.$col->width.'" '.$attr.'>'.$title.'</th>';
			else $h = '<th '.$attr.'>'.$title.'</th>';
			$heading .= $h;

			//filter
			$f = '';
			if (isset($col->filter))
			{

				if ($col->filter == 'text')
				{
					$f = '<td><input type="text" class="form-control"/></td>';
				}
				else if ($col->filter == 'select' && isset($col->filter_data))
				{

					$f = '<td><select class="form-control"><option value="">Semua</option>';
					if(is_array($col->filter_data)) foreach($col->filter_data as $fd)
					{
						if(is_array($fd)) $fd = (object)$fd;
						$f .= '<option value="'.$fd->value.'">'.$fd->text.'</option>';
					}
					$f .= '</select></td>';
				}
				else
				{
					$f = '<td><input type="text" class="form-control"/></td>';
				}
			}
			else
			{
				$f = '<td></td>';
			}
			$filter .= $f;

			//datatable
			$d = isset($col->attribut) ? $col->attribut : 'null';
			$datatable[] = $d;
		}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">List <?php echo $this->title; ?> </span>
					</div>
					<div class="tools tabletool-container">
						<a href='<?php echo site_url(PAGE_ID.'/form'); ?>' data-toggle='modal' data-target='#main-modal-md' class="hide" id="crud-add-link"></a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-container">

						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="datatable-main">
							<thead>
								<tr class="heading">
									<?php echo $heading; ?>
								</tr>
							</thead>
							<tfoot class="filter">
								<tr>
									<?php echo $filter; ?>
								</tr>
							</tfoot>
							<tbody>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
[/section]

[section name="css"]
<style>
	.dataTables_filter{display:none!important;}
	@.table-scrollable{overflow-x: inherit; overflow-y: inherit;}
</style>
[/section]

[section name="plugin-js"]
<!--script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.js"></script-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/1.10.15/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/jszip.min.js"></script>
<!--script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/buttons.html5.min.js"></script-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
[/section]

[section name="js"]
<?php if(isset($additional_script)) echo $additional_script; ?>
<script>
	var PAGE_URL = '<?php echo site_url(PAGE_ID);?>';

	if (typeof(TAKE_OVER) == 'undefined' || !TAKE_OVER)
	{
		var my_table = $("#datatable-main").myTable(
		{
			extraButtons : [
				<?php if ($this->allow_create) echo '{text: "<i class=\'glyphicon glyphicon-plus\'></i>&nbsp; Tambah", action: function ( e, dt, node, config ) {$(\'#crud-add-link\').click()}}'; ?>
			]
		});
	}

	$('.page-sidebar-menu a').each(function()
	{
		var href = $(this).attr('href');
		if (window.location.href.indexOf(href) > -1) $('.caption i').addClass($(this).find('i').attr('class'));
	});

	$('.caption .fa').addClass($('.page-sidebar-menu li.active a').attr('class'));

	$('body').on('dblclick', '.dataTable tbody tr', function(){
		$(this).find('a').first().click();
	});


</script>
[/section]
