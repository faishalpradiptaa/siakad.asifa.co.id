<?php $enc_kode_point = my_base64_encode($point->kode_point); ?>
<table class="table table-bordered table-prestasi" id="table-prestasi-<?php echo $enc_kode_point; ?>">
	<thead>
		<tr>
			<th>Jenis Prestasi</th>
			<th>Keterangan</th>
			<th width="10%" class="text-center"><a href="javascript:;" class="btn btn-sm btn-primary" data-toggle="add"><i class="fa fa-plus"></i></a></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($prestasi) foreach($prestasi as $i => $row) { ?>
		<tr number="<?php echo $i; ?>">
			<td><input type="text" class="form-control" name="prestasi[<?php echo $i; ?>][jenis]" value="<?php echo $row->jenis; ?>"></td>
			<td><input type="text" class="form-control" name="prestasi[<?php echo $i; ?>][keterangan]" value="<?php echo $row->keterangan; ?>"></td>
			<td class="text-center">
				<a href="javascript:;" tabindex="-1" class="btn btn-sm btn-danger" data-toggle="delete"><i class="fa fa-trash"></i></a></th>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>