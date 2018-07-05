<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" >Ubah Pembayaran <?php echo $id; ?> </h4>
</div>
<div class="modal-body">
	<form action="<?php echo site_url(PAGE_ID.'/form/'.$raw_id);?>" class="form-horizontal row-border frm_validation">
	<div class="validation_msg"></div>
	<?php
		$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	?>
	<table class="table table-striped">
		<tr>
			<th width="20%">Kode Pembayaran</th>
			<td><?php echo $pembayaran->kode_pembayaran;?></td>
			<th width="20%">Kode Tagihan</th>
			<td><?php echo $tagihan->kode_tagihan;?></td>
		</tr>
		<tr>
			<th>No. Induk</th>
			<td><?php echo $pembayaran->no_induk;?></td>
			<th>Jenis</th>
			<td><?php echo $tagihan->nama_jenis;?></td>
		</tr>
		<tr>
			<th>Nama</th>
			<td><?php echo $pembayaran->nama_siswa;?></td>
			<th>Periode</th>
			<td><?php echo $tagihan->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($tagihan->periode))].' '.date('Y', strtotime($tagihan->periode)) : $tagihan->periode;?></td>
		</tr>
		<tr>
			<th rowspan="2">Dibayar</th>
			<td rowspan="2">
				<input type="text" required class="form-control currency" name="nominal_bayar" data-v-min="1000" data-v-max="<?php echo $tagihan->tanggungan+$pembayaran->bayar;?>" value="<?php echo $pembayaran->bayar;?>">
			</td>
			<th>Nominal Tagih</th>
			<td><?php echo 'Rp. '.number_format($tagihan->tagih,0,',','.');?></td>
		</tr>
		<tr>
			<th>Nominal Tanggungan</th>
			<td><?php echo 'Rp. '.number_format($tagihan->tanggungan,0,',','.');?></td>
		</tr>
		<tr>
			<th>Tgl Bayar</th>
			<td>
				<input class="form-control datepicker" name="tgl_bayar" value="<?php echo date('d/m/Y', strtotime($pembayaran->tgl_bayar));?>">
			</td>
			<th>Tgl Tagih</th>
			<td><?php echo date('d/m/Y', strtotime($tagihan->tgl_tagih));?></td>
		</tr>
		<tr>
			<th>Bank</th>
			<td><?php echo $pembayaran->bank;?></td>
			<th>Status</th>
			<td><?php echo strtolower($tagihan->status_tagihan) == 'lunas' ? '<span class="label label-success">Lunas</span>' : '<span class="label label-danger">Belum Lunas</span>'; ?></td>
		</tr>
		
	</table>
	

	</form>

</div><!-- /.modal-body -->

<div class="modal-footer">
	<div class="pull-left text-left">
		<?php 
			if($pembayaran) 
			{
				echo '<div style="color:red">* Nominal pembayaran tidak boleh lebih dari nominal tanggungan + nominal bayar sekarang.</div>'; 
			}
		?>
		
	</div>
	<button type="button" class="btn btn-primary" onclick="simpan_ajax('save')">Simpan</button>
	<button type="button"  class="btn btn-danger" onclick="hapus_ajax()">Hapus</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>



<script>
	/*
	$('.scroll-content').slimScroll({
		height: '470px'
	});
	*/
	$('.datepicker').datepicker({format: 'dd/mm/yyyy'});
	$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
	
	function simpan_ajax(mode)
	{
		if (typeof beforeSave == 'function') beforeSave(); 
		var form = '.frm_validation';
		if (!validate(form)) return false;
		
		$.ajax({
			url : $(form).attr('action'),
			method : 'POST',
			data : $(form).serialize(),
			success: function (data)
			{
				if (data == 'ok')
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data berhasil disimpan !', type: 'success'});
					if (typeof datatable !== 'undefined') datatable.ajax.reload();
					if (typeof my_table !== 'undefined') my_table.refresh();
					if(mode == 'apply')
					{
						$(form).find('.form-control[type="text"], .form-control[type="number"], .form-control[type="email"], .form-control[type="password"]').val('');
						$(form).find('.form-control').first().focus();
					}
					else $(form).parents('.modal').find('[data-dismiss="modal"]').click();
					if (typeof refresh == 'function') refresh(); 
				}
				else 
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data gagal disimpan !', type: 'error'});
				}
			},
			error : function (error){
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		return false;
	}
		
	function hapus_ajax()
	{
		if (!confirm('Apakah anda yakin ingin menghapus tagihan ini ?')) return false;
		$.ajax({
			url : '<?php echo site_url(PAGE_ID.'/delete/'.$raw_id)?>',
			method : 'GET',
			success: function (data)
			{
				if (data == 'ok')
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data berhasil dihapus !', type: 'success'});
					if (typeof datatable !== 'undefined') datatable.ajax.reload();
					if (typeof my_table !== 'undefined') my_table.refresh();
					
					$('.modal').find('[data-dismiss="modal"]').click();
					if (typeof refresh == 'function') refresh(); 
				}
				else 
				{
					$.pnotify({title: '<?php echo $this->title; ?>', text: 'Data gagal dihapus !', type: 'error'});
				}
			},
			error : function (error){
				$.pnotify({title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		return false;
	}
</script>