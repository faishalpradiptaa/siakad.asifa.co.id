<?php if ($is_ajax) { ?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" ><?php echo ($id) ? 'Ubah' : 'Tambah'; echo ' '.$this->title; ?> </h4>
</div>
<div class="modal-body">
<?php } else { ?>

<div class="page-content">

	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
		<li><a href="javascrip:;"><?php echo ($id) ? 'Ubah' : 'Tambah'; echo ' '.$this->title; ?></a></li>
	</ul>

	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase"><?php echo ($id) ? 'Ubah' : 'Tambah'; echo ' '.$this->title; ?> </span>
					</div>
					<a href="<?php echo site_url(PAGE_ID); ?>" class="btn btn-default btn-sm pull-right margin-t-5" >Kembali</a>
					<button type="button" class="btn btn-primary btn-sm pull-right margin-t-5 margin-r-10" onclick="simpan_ajax('save')">Simpan</button>
				</div>
				<div class="portlet-body">

<?php } ?>

	<form action="<?php echo site_url(PAGE_ID.'/form/'.$raw_id);?>" class="form-horizontal row-border frm_validation">
	<div class="validation_msg"></div>

	<div class="tab-container">
		<ul class="nav nav-tabs">
			<?php
				$is_time = false;
				$is_date = false;
				$is_datetime = false;
				$is_switch = false;
				$is_select = false;
				$i = 0;

				// regroup form_data by tab
				foreach ($this->form_data as $key => $val)
				{
					$tab = isset($val['tab']) ? $val['tab'] : 'tab_default';
					if(!isset($this->form_tabs[$tab])) $this->form_tabs[$tab] = array('title' => 'Data '.$this->title);
					$this->form_tabs[$tab]['data'][$key] = $val;
				}

				// atur tab
				foreach($this->form_tabs as $tab_id => $tab_data)
				{
					$active = $i == 0 ? 'active' : '';
					echo '<li class="'.$active.'"><a href="#'.$tab_id.'" data-toggle="tab">'.$tab_data['title'].'</a></li>';
					$i++;
				}

			?>
		</ul>
		<div class="tab-content">
			<?php
				$i = 0;
				foreach($this->form_tabs as $tab_id => $tab_data)
				{
					$active = $i == 0 ? 'active' : '';
			?>
			<div class="tab-pane <?php echo $active;?>" id="<?php echo $tab_id; ?>">
				<div class="scroll-content">
				<?php
					foreach ($tab_data['data'] as $key => $val)
					{
						$my_val = $data ? $data->$key : '';
						$val = (object)$val;
						$col_width = isset($val->col_width) ? $val->col_width : 'col-sm-9';
						$elm_id = isset($val->id) ? ' id="'.$val->id.'"' : '';
						$my_val = $my_val == '' && isset($val->default) ? $val->default : $my_val;

						if ($val->type == 'text')
						{
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<input class="form-control" type="text" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.$my_val.'"/>
								</div>
							</div>';
						}
						elseif ($val->type == 'textarea')
						{
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<textarea class="form-control" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" rows="5">'.$my_val.'</textarea>
								</div>
							</div>';
						}
						elseif ($val->type == 'password')
						{
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<input class="form-control" type="password" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" />
								</div>
							</div>';
						}
						elseif ($val->type == 'switch')
						{
							$is_checked = $val->checked;
							if($id) $is_checked = ($my_val == $val->on_value);
							$is_switch = true;
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<input type="checkbox" name="'.$key.'" validate="'.$val->validate.'" value="'.$val->on_value.'" '.($is_checked ? 'checked' : '').' class="button-switch" data-on-text="'.$val->on.'" data-off-text="'.$val->off.'">
								</div>
							</div>';
						}
						else if ($val->type == 'select' && isset($val->data))
						{
							$is_select = true;
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<select class="form-control select2" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'">
										<option value=""> - Pilih '.$val->title.' - </option>';
										if(is_array($val->data)) foreach($val->data as $fd)
										{
											if(is_array($fd)) $fd = (object)$fd;
											$attr = isset($fd->additional) ? 'additional="'.$fd->additional.'"' : '';
											echo $fd->value == $my_val ? '<option value="'.$fd->value.'" '.$attr.' selected>'.$fd->text.'</option>' : '<option value="'.$fd->value.'" '.$attr.'>'.$fd->text.'</option>';
										}
										echo '
									</select>
								</div>
							</div>';
						}
						else if ($val->type == 'radio' && isset($val->data))
						{
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<div class="radio-list margin-l-20">';
										if(is_array($val->data)) foreach($val->data as $fd)
										{
											if(is_array($fd)) $fd = (object)$fd;
											echo '<label class="radio-inline"><input type="radio" name="'.$key.'" validate="'.$val->validate.'" '.($fd->value == $my_val || (!$my_val && $fd->value == $val->default) ? 'checked' : '').' value="'.$fd->value.'"> '.$fd->text.' </label>' ;
										}
										echo '
									</div>
								</div>
							</div>';
						}
						else if ($val->type == 'time')
						{
							$is_time = true;
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<div class="input-group">
										<input class="form-control timepicker" type="text" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.$my_val.'"/>
										<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
										</span>
									</div>
								</div>
							</div>';
						}
						else if ($val->type == 'date')
						{
							$is_date = true;
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<div class="input-group">
										<input class="form-control datepicker" placeholder="dd/mm/yyyy" type="text" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.($my_val ? dateMySQL2dateInd($my_val) : '').'"/>
										<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
							</div>';
						}
						else if ($val->type == 'datetime')
						{
							$is_datetime = true;
							if($my_val)
							{
								$arr_val = explode(' ',$my_val);
								$my_val = dateMySQL2dateInd($arr_val[0]);
								$arr_val = explode(':',$arr_val[1]);
								$my_val .= ' '.$arr_val[0].':'.$arr_val[1];
							}
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<div class="input-group">
										<input class="form-control datetimepicker" placeholder="dd/mm/yyyy hh:ii" type="text" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.$my_val.'"/>
										<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
							</div>';
						}
						else if ($val->type == 'number')
						{
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<input class="form-control" type="number" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.$my_val.'"/>
								</div>
							</div>';
						}
						else if ($val->type == 'hidden')
						{
							echo '<input type="hidden" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.$my_val.'"/>';
						}
						else
						{
							echo '
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$val->title.'</label>
								<div class="'.$col_width.'">
									<input class="form-control" type="text" name="'.$key.'" '.$elm_id.' validate="'.$val->validate.'" value="'.$my_val.'"/>
								</div>
							</div>';
						}
					}
				?>

				<?php if (!$is_ajax) { ?>
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-md-9">
							<button type="button" class="btn btn-primary margin-r-5" onclick="simpan_ajax('save')">Simpan</button>
							<a href="<?php echo site_url(PAGE_ID); ?>" class="btn btn-default" >Kembali</a>
						</div>
					</div>
				<?php } ?>

				</div>
			</div>
			<?php
					$i++;
				}
			?>
		</div>
	</div>
	</form>

<?php if ($is_ajax) { ?>
</div><!-- /.modal-body -->

<div class="modal-footer">
	<?php if(!$id){ ?><button type="button" class="btn btn-success" onclick="simpan_ajax('apply')">Simpan &amp; Lanjut Input</button><?php } ?>
	<button type="button" class="btn btn-primary" onclick="simpan_ajax('save')">Simpan</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
<?php } else { ?>
				</div>
			</div>
		</div>
	</div>

</div>
<?php } ?>


<?php if (!$is_ajax) { ?>

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
[/section]

[section name="css"]
<style>
	.bootstrap-switch .checker{
		display:none;
	}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
[/section]

	<?php if($this->curr_thn_ajaran) { ?>

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

	<?php } ?>

<?php } ?>

<?php if (!$is_ajax) echo '[section name="js"]'; ?>
<script>
	/*
	$('.scroll-content').slimScroll({
		height: '470px'
	});
	*/

	<?php
		if ($is_time) echo "$('.timepicker').timepicker({ autoclose: true, minuteStep: 5, showSeconds: true, showMeridian: false });";
		if ($is_date) echo "$('.datepicker').datepicker({format: 'dd/mm/yyyy'});";
		if ($is_datetime) echo "$('.datetimepicker').datetimepicker({format: 'dd/mm/yyyy hh:ii'});";
		if ($is_switch) echo "$('.button-switch').bootstrapSwitch();";
		if ($is_select) echo "$('.select2').select2();";
	?>

	function simpan_ajax(mode)
	{
		if (typeof beforeSave == 'function') beforeSave();
		var form = '.frm_validation';
		if (!validate(form)) return false;

		$.ajax({
			url : $(form).attr('action'),
			method : 'POST',
			data : $(form).serialize(),
			success: function (data)
			{
				if (data == 'ok')
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data berhasil disimpan !', type: 'success'});
					if (typeof datatable !== 'undefined') datatable.ajax.reload();
					if (typeof my_table !== 'undefined') my_table.refresh();
					if(mode == 'apply')
					{
						$(form).find('.form-control[type="text"], .form-control[type="number"], .form-control[type="email"], .form-control[type="password"]').val('');
						$(form).find('.form-control').first().focus();
					}
					else $(form).parents('.modal').find('[data-dismiss="modal"]').click();
					if (typeof refresh == 'function') refresh();
				}
				else
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data gagal disimpan !', type: 'error'});
				}
			},
			error : function (error){
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		return false;
	}

</script>
<?php if(isset($additional_script)) echo $additional_script; ?>

<?php if (!$is_ajax) echo '[/section]'; ?>
