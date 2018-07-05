<?php $enc_kode_point = my_base64_encode($point->kode_point); ?>
<table class="table table-bordered table-prestasi" id="table-prestasi-<?php echo $enc_kode_point; ?>">
	<thead>
		<tr>
			<th>Jenis Prestasi</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if ($prestasi) 
			{
				foreach($prestasi as $i => $row) 
				{ 
		?>
		<tr number="<?php echo $i; ?>">
			<td><?php echo $row->jenis ? $row->jenis : '&nbsp;'; ?></td>
			<td><?php echo $row->keterangan; ?></td>
		</tr>
		<?php 
				} 
			}
			else echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';	
		?>
	</tbody>
</table>