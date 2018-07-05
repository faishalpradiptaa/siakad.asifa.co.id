<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
		
		<div class="page-toolbar">
		</div>
		
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
			<?php
				$error = $this->session->flashdata('error');
				$warning = $this->session->flashdata('warning');
				$success = $this->session->flashdata('success');
				if($error) echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$error.'</div>';
				if($warning) echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$warning.'</div>';
				if($success) echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$success.'</div>';
			?>
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-blue-steel"></i>
						<span class="caption-subject font-blue-steel bold uppercase">List <?php echo $this->title.' '.$this->curr_jenjang->nama_jenjang.' - '.$this->curr_thn_ajaran->thn_ajaran.' '.$this->curr_thn_ajaran->sem_ajaran; ?> </span>
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

<?php if ($this->allow_import) { ?>
<div class="hide tool-import">
	<div class="btn-group">
		<a class="pull-right tooltips btn btn-fit-height <?php echo $data_exits ? 'default' : 'yellow-gold'; ?> dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-title="Import dari Tahun Ajaran"> 
			<i class="fa fa-download"></i>&nbsp;
			<span class="thin hidden-xs">Import dari Tahun Ajaran lain</span>&nbsp;
			<i class="fa fa-angle-down"></i>
		</a>
		<ul class="dropdown-menu">
			<?php 
				if(is_array($this->thn_ajaran) && !$data_exits) 
				{	
					foreach ($this->thn_ajaran as $thn) if($thn->kode_thn_ajaran != THN_AJARAN) echo '<li><a href="'.site_url(PAGE_ID.'/import/'.$thn->kode_thn_ajaran).'"><i class="fa fa-file-o"></i> Tahun Ajaran '.$thn->thn_ajaran.' '.$thn->sem_ajaran.'</a></li>'; 
				}
				else if ($data_exits)
					echo '<li><a href="javascript:;"><i class="fa fa-warning"></i> Harap kosongkan data</a></li>'; 
			?>
		</ul>
	</div>
</div>
<?php } ?>


[section name="page-actions"]
<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height green-sharp dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Jenjang"> 
		<i class="fa fa-signal fa-rotate-90"></i>&nbsp;
		<span class="thin hidden-xs"> <?php echo $this->curr_jenjang->nama_jenjang; ?></span>&nbsp;
		<i class="fa fa-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<?php if(is_array($this->jenjang)) foreach ($this->jenjang as $jj) echo '<li><a href="'.site_url(PAGE_ID.'/change_jenjang/'.$jj->kode_jenjang).'"><i class="fa fa-'.($jj->kode_jenjang == JENJANG ? 'check-circle-o' : 'circle-o').'"></i>'.$jj->nama_jenjang.'</a></li>'; ?>
	</ul>
</div>

<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height blue-steel dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Tahun Ajaran"> 
		<i class="fa fa-archive"></i>&nbsp;
		<span class="thin hidden-xs">Tahun Ajaran : <?php echo $this->curr_thn_ajaran->thn_ajaran.' '.$this->curr_thn_ajaran->sem_ajaran; ?></span>&nbsp;
		<i class="fa fa-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<?php if(is_array($this->thn_ajaran)) foreach ($this->thn_ajaran as $thn) echo '<li><a href="'.site_url(PAGE_ID.'/change_thn_ajaran/'.$thn->kode_thn_ajaran).'"><i class="fa fa-'.($thn->kode_thn_ajaran == THN_AJARAN ? 'check-circle-o' : 'circle-o').'"></i> Tahun Ajaran : '.$thn->thn_ajaran.' '.$thn->sem_ajaran.'</a></li>'; ?>
	</ul>
</div>
[/section]

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
[/section]

[section name="css"]
<style>
	.dataTables_filter{display:none!important;}
	@.table-scrollable{overflow-x: inherit; overflow-y: inherit;}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
[/section]

[section name="js"]
<?php if(isset($additional_script)) echo $additional_script; ?>
<script>
	var PAGE_URL = '<?php echo site_url(PAGE_ID);?>';
	
	if (typeof(TAKE_OVER) == 'undefined' || !TAKE_OVER)
	{
		var my_table = $("#datatable-main").myTable(
		{
			dom: "<'row'<'col-md-12 text-right'B>> <'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12 tool-import-container text-right'>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
			extraButtons : [
				<?php if ($this->allow_create) echo '{text: "<i class=\'glyphicon glyphicon-plus\'></i>&nbsp; Tambah", action: function ( e, dt, node, config ) {$(\'#crud-add-link\').click()}}'; ?>
			],
			fnInitComplete: function ( oSettings ) {
				if ($('.tabletool-container').length) $('.tabletool-container').append( this.parents('.dataTables_wrapper').find('.dt-buttons')[0] );
				<?php if ($this->allow_import) echo "$('.tool-import-container').append( $('.tool-import').removeClass('hide')[0] );"; ?>
			},
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

