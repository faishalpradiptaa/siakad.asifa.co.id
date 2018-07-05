
<table class="table table-bordered">
	<thead>
		<tr>
			<th width="20%">Kesehatan</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($riwayat as $row) { ?>
		<tr>
			<td><b><?php echo $row->nama_jenis; ?></b></td>
			<td><?php if(isset($row->data[0]) && $row->data[0]->tgl) echo '1. '.$row->data[0]->keterangan.' ( '.date('d-m-Y', strtotime($row->data[0]->tgl)).')'; ?> </td>
		</tr>
		<?php foreach($row->data as $i=>$detail) if ($i>0) { ?>
		<tr>
			<td></td>
			<td><?php echo ($i+1).'. '.$detail->keterangan.' ( '.date('d-m-Y', strtotime($detail->tgl)).')'; ?> </td>
		</tr>
		<?php } ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?php } ?>
	</tbody>
</table>