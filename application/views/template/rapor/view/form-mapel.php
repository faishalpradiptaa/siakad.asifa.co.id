<?php
	$total = array();

	// cek jika ada yg punya deskripsi
	$is_deskriptif = false;
	$colspan_predikat = 2;
	if(is_array($data)) foreach($data as $row_mp) foreach($row_mp as $row_aspek) if($row_aspek->deskripsi)
	{
		$colspan_predikat = 3;
		$is_deskriptif = true;
		break;
	}
?>
<div class="panel-body pn" style="overflow: auto; height: auto; width: auto;">
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th rowspan="2" width="5%" class="text-center">No.</th>
			<th rowspan="2">Mata Pelajaran</th>
			<?php
				foreach($aspek as $col)
				{
					switch($col->tipe)
					{
						case 'nilai_predikat' :
							echo '<th width="'.$col->width.'" colspan="'.$colspan_predikat.'" class="text-center">'.$col->nama_aspek.'</th>';
						break;
						default :
							echo '<th width="'.$col->width.'" rowspan="2" class="text-center">'.$col->nama_aspek.'</th>';
					}
				}
			?>
		</tr>
		<tr>
			<?php
				foreach($aspek as $col)
				{
					switch($col->tipe)
					{
						case 'nilai_predikat' :
							echo '<th class="text-center">Angka (N)</th><th class="text-center">Predikat</th>';
							if($is_deskriptif) echo '<th class="text-center">Deskripsi</th>';
						break;
						default :
							echo '';
						break;
					}
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($mapel as $kel) { ?>
		<tr>
			<td colspan="2"><b><?php echo $kel->nama; ?></b></td>
			<?php
				foreach($aspek as $col)
				{
					switch($col->tipe)
					{
						case 'nilai_predikat' :
							echo '<td></td><td></td>';
							if($is_deskriptif) echo '<td></td>';
						break;
						default :
							echo '<td></td>';
						break;
					}
				}
			?>
		</tr>
		<?php
			$i = 0;
			if(is_array($kel->mapel)) foreach($kel->mapel as $mp) {
				$enc_kode_mapel = my_base64_encode($mp->kode_mp);
		?>
		<tr>
			<td class="text-center"><?php echo ++$i; ?></td>
			<td><?php echo $mp->nama_mp; ?></td>
			<?php
				$enc_kode_point = my_base64_encode($point->kode_point);

				// restruktur nilai
				$nilai = array();
				$nilai['SKS'] = $mp->sks;
				$nilai['KKM'] = $mp->kkm;
				$total['SKS'] = !isset($total['SKS']) ? $mp->sks : $mp->sks + $total['SKS'];
				$total['KKM'] = !isset($total['KKM']) ? $mp->kkm : $mp->kkm + $total['KKM'];
				foreach($aspek as $col)
				{
					$val = isset($data[$mp->kode_mp][$col->kode_aspek]) ? $data[$mp->kode_mp][$col->kode_aspek] : '';
					$nilai[$col->kode_aspek] = $val->nilai ? $val->nilai : 0;
				}

				foreach($aspek as $col)
				{
					$val = isset($data[$mp->kode_mp][$col->kode_aspek]) ? $data[$mp->kode_mp][$col->kode_aspek] : '';
					switch($col->tipe)
					{
						case 'nilai_nominal' :
							$hasil = $val->nilai != '' ? $val->nilai : '-';
							echo '<td class="text-center">'.$hasil.'</td>';
						break;
						case 'nilai_predikat' :
							$hasil = $val->nilai;
							echo '<td class="text-center">'.$hasil.'</td><td class="text-center">'.$val->grade.'</td>';
							if($is_deskriptif)
							{
								$deskripsi = str_replace('[predikat]', $val->deskriptif, $val->deskripsi);
								echo '<td>'.$deskripsi.'</td>';
							}
						break;
						case 'rumus' :
							$rumus = str_replace(array_keys($nilai), array_values($nilai), $col->rumus);
							$rumus = '$hasil = '.$rumus.';';
							eval($rumus);
							$nilai[$col->kode_aspek] = $hasil;
							echo '<td class="text-center">'.$hasil.'</td>';
						break;
						default :
							echo '<td class="text-center"></td>';
					}
					$total[$col->kode_aspek] = !isset($total[$col->kode_aspek]) ? $hasil : $hasil + $total[$col->kode_aspek];
					echo '</td>' ;
				}
			?>
		</tr>
		<?php
			}
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2" class="text-center">Jumlah</th>
			<?php
				foreach($aspek as $col)
				{
					switch($col->tipe)
					{
						case 'nilai_predikat' :
							echo '<th class="text-center">'.$total[$col->kode_aspek].'</th><th></th>';
							if($is_deskriptif) echo '<th></th>';
						break;
						default :
							echo '<th class="text-center">'.$total[$col->kode_aspek].'</th>';
					}
				}
			?>
		</tr>
		<?php
				/*
				function SUM($kode, $total)
				{
					return isset($total[$kode]) ? $total[$kode] : 0;
				}
				$hasil = 0;
				$rumus = $point->rumus_ip;
				if($rumus)
				{
					$replace = array();
					foreach($nilai as $key => $val) $replace[$key] = '\''.$key.'\', $total';
					$rumus = str_replace(array_keys($replace), array_values($replace), $rumus);
					$rumus = '$hasil = '.$rumus.';';
					eval($rumus);
				}
				*/
				if($point->rumus_ip) echo '<tr><th colspan="2" class="text-center">IP Semester</th><th colspan="8" class="text-center">[CODE:IPS]</th><tr>';
			?>
	</tfoot>
</table>


</div>
