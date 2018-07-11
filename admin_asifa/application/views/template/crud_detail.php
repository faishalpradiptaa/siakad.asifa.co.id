
<div class="modal-header"> // Halaman detail
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Detail <?php echo $this->title; ?></h4>
</div>
<div class="modal-body">
	<div class="tab-container">
		<ul class="nav nav-tabs">
			<?php
				// regroup form_data by tab
				foreach ($this->form_data as $key => $val)
				{
					$tab = isset($val['tab']) ? $val['tab'] : 'tab_default';
					if(!isset($this->form_tabs[$tab])) $this->form_tabs[$tab] = array('title' => 'Data '.$this->title);
					$this->form_tabs[$tab]['data'][$key] = $val;
				}

				// atur tab
				$i = 0;
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
					<table class="table table-striped">
						<?php
							foreach ($tab_data['data'] as $key => $val)
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
										<th width="30%">'.$val->title.'</th>
										<td>'.$my_val.'</td>
									</tr>';
								}
							}
						?>

					</table>
				</div>
			</div>
			<?php
					$i++;
				}
			?>

		</div>
	</div>
</div><!-- /.modal-body -->
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

<?php if(isset($additional_script)) echo $additional_script; ?>
