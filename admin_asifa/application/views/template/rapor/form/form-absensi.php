
<table class="table table-bordered" style="width:50%">
	<thead>
		<tr>
			<th>Keterangan</th>
			<th width="33%" class="text-center">Hari</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($absensi as $row) { ?>
		<tr>
			<td><?php echo $row->nama_jenis; ?></td>
			<td class="text-center"><?php echo $row->jumlah ? $row->jumlah : 0; ?> Hari</td>
		</tr>
		<?php } ?>
	</tbody>
</table>