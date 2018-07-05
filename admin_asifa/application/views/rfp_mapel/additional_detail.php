<div id="additional-field-mapel" class="hide">
	<table>
	<?php if(is_array($deskripsi)) foreach($deskripsi as $i => $desk) { ?>
	<tr>
		<th>Deskripsi<br><?php echo $desk->nama_aspek ?></th>
		<td><?php echo $desk->deskripsi; ?></td>
	</tr>
	<?php } ?>
	</table>
</div>

<script>
	$('.scroll-content table').append($('.modal').find('#additional-field-mapel tr'));
</script>