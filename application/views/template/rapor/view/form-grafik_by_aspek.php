<?php foreach($mapel as $kode_mp => $mp) { ?>
<div class="row margin-b-15">
	<div class="col-sm-7">
		<h4><?php echo $mp->nama_mp; ?></h4>
		<div class="grafik_mapel" kode-mp="<?php echo $mp->kode_mp; ?>" enc-kode-mp="<?php echo my_base64_encode($mp->kode_mp); ?>" style="height: 228px;"> </div>
	</div>
</div>
<?php } ?>
<script>
	var data_grafik = <?php echo json_encode($data_graph); ?>;
</script>
