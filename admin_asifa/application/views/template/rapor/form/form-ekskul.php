<?php 
	$option_ekskul = '';
	$enc_kode_point = my_base64_encode($point->kode_point); 
	foreach ($ekskul as $row) $option_ekskul .= '<option value="'.$row->kode_ekskul.'">'.$row->nama_ekskul.'</option>'; 
?>
<select class="hide" id="select-ekskul">
	<?php echo $option_ekskul; ?>
</select>
<table class="table table-bordered table-ekskul" id="table-ekskul-<?php echo $enc_kode_point; ?>">
	<thead>
		<tr>
			<th>Kegiatan Ekstrakurikuler</th>
			<th>Keterangan</th>
			<th width="10%" class="text-center"><a href="javascript:;" class="btn btn-sm btn-primary" data-toggle="add"><i class="fa fa-plus"></i></a></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($data_ekskul) foreach($data_ekskul as $i => $row) { ?>
		<tr number="<?php echo $i; ?>">
			<td><select class="form-control" name="ekskul[<?php echo $i; ?>][kode_ekskul]" data-value="<?php echo $row->kode_ekskul; ?>"><?php echo $option_ekskul; ?></select></td>
			<td><input type="text" class="form-control" name="ekskul[<?php echo $i; ?>][keterangan]" value="<?php echo $row->keterangan; ?>"></td>
			<td class="text-center">
				<a href="javascript:;" tabindex="-1" class="btn btn-sm btn-danger" data-toggle="delete"><i class="fa fa-trash"></i></a></th>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>