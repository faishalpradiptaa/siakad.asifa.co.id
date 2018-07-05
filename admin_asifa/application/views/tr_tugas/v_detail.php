<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
		<li><a href="javascrip:;">Detail <?php echo $this->title; ?></a></li>
	</ul>
	
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Detail <?php echo ' '.$this->title; ?> </span>
					</div>
					<a href="<?php echo site_url(PAGE_ID); ?>" class="btn btn-default btn-sm pull-right margin-t-5" >Kembali</a> 
				</div>
				<div class="portlet-body">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-0" data-toggle="tab">Detail Tugas</a></li>
						<li><a href="#tab-1" data-toggle="tab">Pengumpulan Tugas</a></li>
				</ul>
				<div class="tab-content">
					
					<div class="tab-pane active" id="tab-0">
						<table class="table table-striped">
							<?php
								foreach($this->form_data as $key => $val)
								{
									$my_val = $data ? $data->$key : '';
									
									$val = (object)$val;
									if (in_array($val->type, array('select','radio')) && isset($val->data))
									{
										if(is_array($val->data)) foreach($val->data as $fd)
										{
											$fd = (object)$fd;
											if ($fd->value == $my_val) $my_val = $fd->text;
										}
									}
									elseif ($val->type == 'switch' && $my_val)
									{
										$my_val = $my_val == $val->on_value ? $val->on : $val->off;
									}
									elseif ($val->type == 'date' && $my_val) $my_val = dateMySQL2dateInd($my_val);
								
									if($val->type != 'hidden' && $val->type != 'password' )
									{
										echo '
										<tr>
											<th width="20%">'.$val->title.'</th>
											<td>'.$my_val.'</td>
										</tr>';
									}
								}
							?>
						</table>
					</div>	
					
					<div class="tab-pane" id="tab-1">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="datatable-main">
							<thead>
								<tr class="heading">
									<th width="10%" data-visible="false">ID</th>
									<th width="15%">No. Induk</th>
									<th>Nama</th>
									<th width="15%" data-class="text-center">Tgl Dikumpulkan</th>
									<th width="15%" data-class="text-center">Tugas</th>
								</tr>
							</thead>
							<tfoot class="filter">
								<tr>
									<td></td>
									<td><input type="text" class="form-control"/></td>
									<td><input type="text" class="form-control"/></td>
									<td></td>
									<td></td>
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
[/section]

[section name="css"]
<style>
	.bootstrap-switch .checker{
		display:none;
	}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/1.10.15/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/plugins/1.3.1/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.js"></script>
[/section]


[section name="page-actions"]
<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height green-sharp dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Jenjang"> 
		<i class="fa fa-signal fa-rotate-90"></i>&nbsp;
		<span class="thin hidden-xs"> <?php echo $this->curr_jenjang->nama_jenjang; ?></span>&nbsp;
	</a>
</div>

<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height blue-steel dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Tahun Ajaran"> 
		<i class="fa fa-archive"></i>&nbsp;
		<span class="thin hidden-xs">Tahun Ajaran : <?php echo $this->curr_thn_ajaran->thn_ajaran.' '.$this->curr_thn_ajaran->sem_ajaran; ?></span>&nbsp;
	</a>
</div>
[/section]



[section name="js"]
<script>
	var my_table = $("#datatable-main").myTable({
		ajax : '<?php echo site_url(PAGE_ID.'/detail_submit/'.$id); ?>'
		
	});	
</script>
<?php if(isset($additional_script)) echo $additional_script; ?>

[/section]
