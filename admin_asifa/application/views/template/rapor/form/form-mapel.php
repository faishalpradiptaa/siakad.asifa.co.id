
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="5%" class="text-center">No.</th>
			<th>Mata Pelajaran</th>
			<th width="5%" class="text-center">KKM</th>
			<?php foreach($aspek as $col) if($col->tipe != 'rumus') echo '<th width="'.$col->width.'" class="text-center">'.$col->nama_aspek.'</th>'; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($mapel as $kel) { ?>
		<tr>
			<td colspan="2"><b><?php echo $kel->nama; ?></b></td>
			<td></td>
			<?php foreach($aspek as $col) if($col->tipe != 'rumus') echo '<td></td>'; ?>
		</tr>
		<?php 
			$i = 0;
			if(is_array($kel->mapel)) foreach($kel->mapel as $mp) { 
				$enc_kode_mapel = my_base64_encode($mp->kode_mp);
		?>
		<tr>
			<td class="text-center"><?php echo ++$i; ?></td>
			<td><?php echo $mp->nama_mp; ?></td>
			<td class="text-center"><?php echo $mp->kkm; ?></td>
			<?php 
				$enc_kode_point = my_base64_encode($point->kode_point);
				foreach($aspek as $col) if($col->tipe != 'rumus')
				{
					$enc_kode_aspek = my_base64_encode($col->kode_aspek);
					$val = isset($data[$mp->kode_mp][$col->kode_aspek]) ? $data[$mp->kode_mp][$col->kode_aspek]->nilai : '';
					echo '<td>';
					switch($col->tipe)
					{
						case 'deskripsi' :
							echo '<textarea class="form-control" rows="2" name="mapel['.$enc_kode_mapel.']['.$enc_kode_point.']['.$enc_kode_aspek.']">'.$val.'</textarea>';
						break;
						case 'nilai_predikat' :
							$min = $col->minimal;
							$max = $col->maksimal;
							echo '<input type="number" class="form-control text-center" name="mapel['.$enc_kode_mapel.']['.$enc_kode_point.']['.$enc_kode_aspek.']" step="0.01" min="'.$min.'" max="'.$max.'" value="'.$val.'">';
						break;
						case 'nilai_nominal' :
							echo '<input type="number" class="form-control text-center" name="mapel['.$enc_kode_mapel.']['.$enc_kode_point.']['.$enc_kode_aspek.']" step="0.01" value="'.$val.'">';
						break;
					}
					echo '</td>' ;
				}
			?>
			
		</tr>
		<?php 
			}  
			} 
		?>
		
	</tbody>
</table>