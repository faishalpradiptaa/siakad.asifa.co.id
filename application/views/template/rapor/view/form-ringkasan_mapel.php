
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th class="text-center">Aspek Penilaian.</th>
			<th width="10%" class="text-center">Nilai</th>
			<?php foreach($aspek as $col) if($col->tipe != 'rumus') echo '<th width="'.$col->width.'" class="text-center">'.$col->nama_aspek.'</th>'; ?>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i = 0;
			foreach($mapel as $kel) { 
				$enc_kode_mapel = my_base64_encode($kel->kode);
				$enc_kode_point = my_base64_encode($point->kode_point);
		?>
		<tr>
			<td><?php echo $kel->nama; ?></td>
			<td class="text-center"><?php echo $rata[$kel->kode]->rata2 ? number_format($rata[$kel->kode]->rata2, 2) : '-'; ?></td>
			<?php 
				foreach($aspek as $col) if($col->tipe != 'rumus')
				{
					$val = isset($data[$kel->kode][$col->kode_aspek]) ? $data[$kel->kode][$col->kode_aspek]->nilai : '';
					echo '<td>'.$val.'</td>';
				}
			?>
		</tr>
		<?php 
			} 
		?>
		
	</tbody>
</table>