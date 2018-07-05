<?php 
	$option_ekskul = array();
	$enc_kode_point = my_base64_encode($point->kode_point); 
	foreach ($ekskul as $row) $option_ekskul[$row->kode_ekskul] = $row; 
?>

<table class="table table-bordered table-ekskul" id="table-ekskul-<?php echo $enc_kode_point; ?>">
	<thead>
		<tr>
			<th>Kegiatan Ekstrakurikuler</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if ($data_ekskul) 
			{
				foreach($data_ekskul as $i => $row) 
				{ 
		?>
		<tr number="<?php echo $i; ?>">
			<td><?php echo $option_ekskul[$row->kode_ekskul]->nama_ekskul; ?></td>
			<td><?php echo $row->keterangan; ?></td>
		</tr>
		<?php 
				} 
			} 
			else echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';			
		?>
	</tbody>
</table>