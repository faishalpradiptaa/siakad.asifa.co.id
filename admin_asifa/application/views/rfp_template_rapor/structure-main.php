<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
		<li><a href="javascript:;">Susunan Rapor "<?php echo $detail->nama_template; ?>"</a></li>
	</ul>
	
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
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Susunan Rapor "<?php echo $detail->nama_template; ?>"</span>
					</div>
					<div class="tools tabletool-container"> 
						<div class="dt-buttons">
							<a class="dt-button" href="<?php echo site_url(PAGE_ID.'/form_point/'.$raw_kode); ?>" data-toggle="modal" data-target="#main-modal-md" class="btn btn-default"><span><i class="glyphicon glyphicon-plus"></i>&nbsp; Tambah</span></a>
							<a class="dt-button" href="<?php echo site_url(PAGE_ID.'/form/'.$raw_kode); ?>" data-toggle="modal" data-target="#main-modal-md" class="btn btn-default"><span><i class="glyphicon glyphicon-cog"></i>&nbsp; Setting</span></a>
							<a class="dt-button" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"><span><i class="glyphicon glyphicon-arrow-left"></i>&nbsp; Kembali</span></a>
						</div>
					</div>
				</div>
				<div class="portlet-body clearfix">
					<div class="dd" id="nestable">
						<?php echo $point; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

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

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>
[/section]

[section name="css"]
<style>
.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }
.dd-item, .dd-empty, .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle h4{ margin: 0px; }
.dd-option{ float: right; position:absolute; top:10px; right: 15px;}
.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: auto; margin: 10px 5px 0 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 17px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder, .dd-empty { margin: 0 0 15px; padding: 0; min-height: 30px; background: #f2fbff; border: 2px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {-webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); }

.dd-handle { 
	padding: 10px;
	border: 1px solid #ccc;
	margin-bottom: 15px;
	width: 100%;
	box-sizing: border-box; -moz-box-sizing: border-box;
	background: #fafafa;
	background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
	background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
	background: linear-gradient(top, #fafafa 0%, #eee 100%);
	-webkit-border-radius: 3px;
	border-radius: 3px;
	cursor: move;
}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/custom/js/jquery.nestable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>
[/section]

[section name="js"]
<script>
	
	$('#nestable').nestable({group: 1}).on('change', function(e)
	{
		var list   = e.length ? e : $(e.target);
		var sorted_point = '';
		 if (window.JSON) {
			sorted_point = window.JSON.stringify(list.nestable('serialize'));//, null, 2));
			$.ajax({
				url : '<?php echo site_url(PAGE_ID.'/sort_point/'.$raw_kode); ?>',
				type : 'POST',
				data : {data_json : sorted_point},
				success : function(data){},
				error : function(e){
					$.pnotify({title: 'Susunan Rapor "<?php echo $detail->nama_template; ?>"', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
				},
			})
		} else {
			sorted_point = 'JSON browser support required for this demo.';
		}
	});
	
	$('#nestable').on('click', '[data-toggle="delete"]', function()
	{
		var href = $(this).attr('href');
		var title = $(this).parents('.portlet').find('.caption-subject').text();
		bootbox.confirm("Apakah anda yakin menghpus data ini ?", function(o) 
		{ 
			if(o) window.location = href;
		})
		return false;
	})
	
	function refresh_structure()
	{
		location.reload();		
	}

</script>
[/section]

