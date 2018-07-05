
<table class="table table-bordered">
	<thead>
		<tr>
			<?php foreach($aspek as $col) echo '<th width="'.$col->width.'" class="text-center">'.$col->nama_aspek.'</th>'; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
				$enc_kode_point = my_base64_encode($point->kode_point);
				foreach($aspek as $col)
				{
					$enc_kode_aspek = my_base64_encode($col->kode_aspek);
					$val = $data[$col->kode_aspek]->nilai;
					echo '<td width="'.$col->width.'">';
					
					if($col->tipe == 'deskripsi')
					{
						echo '<textarea class="form-control" rows="2" name="custom['.$enc_kode_point.']['.$enc_kode_aspek.']">'.$val.'</textarea>';
						
					}
					
					echo '</td>' ;
				}
			?>
		</tr>
	</tbody>
</table>