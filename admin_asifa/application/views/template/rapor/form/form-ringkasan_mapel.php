
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
					$enc_kode_aspek = my_base64_encode($col->kode_aspek);
					$val = isset($data[$kel->kode][$col->kode_aspek]) ? $data[$kel->kode][$col->kode_aspek]->nilai : '';
					echo '<td>';
					switch($col->tipe)
					{
						case 'deskripsi' :
							echo '<textarea class="form-control" rows="2" name="ringkasan_mapel['.$enc_kode_mapel.']['.$enc_kode_point.']['.$enc_kode_aspek.']">'.$val.'</textarea>';
						break;
						case 'nilai_predikat' :
							$min = $col->minimal;
							$max = $col->maksimal;
							echo '<input type="number" class="form-control text-center" name="ringkasan_mapel['.$enc_kode_mapel.']['.$enc_kode_point.']['.$enc_kode_aspek.']" step="0.01" min="'.$min.'" max="'.$max.'" value="'.$val.'">';
						break;
						case 'nilai_nominal' :
							echo '<input type="number" class="form-control text-center" name="ringkasan_mapel['.$enc_kode_mapel.']['.$enc_kode_point.']['.$enc_kode_aspek.']" step="0.01" value="'.$val.'">';
						break;
					}
					echo '</td>' ;
				}
			?>
		</tr>
		<?php 
			} 
		?>
		
	</tbody>
</table>