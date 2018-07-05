<?php //dump($data); ?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Detail Siswa <?php echo $data->no_induk.' - '.$data->nama; ?></h4>
</div>
<div class="modal-body">
	<div class="tab-container">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_identitas" data-toggle="tab">Identitas</a></li>
			<li><a href="#tab_akademik" data-toggle="tab">Akademik</a></li>
			<li><a href="#tab_absensi" data-toggle="tab">Absensi</a></li>
			<li><a href="#tab_tanggungan" data-toggle="tab">Tanggungan</a></li>
			<li><a href="#tab_pembayaran" data-toggle="tab">Pembayaran</a></li>
		</ul>
		<div class="tab-content">
			
			<div class="tab-pane active" id="tab_identitas">
				<table class="table table-striped">
					<tr>
						<th width="15%">No. Induk</th>
						<td width="35%"><?php echo $data->no_induk; ?></td>
						<th width="15%">NISN</th>
						<td width="35%"><?php echo $data->nisn; ?></td>
					</tr>
					<tr>
						<th>Nama</th>
						<td><?php echo $data->nama; ?></td>
						<th>Tempat Lahir</th>
						<td>
							<?php 
								foreach($this->form_data['tempat_lahir']['data'] as $row) if($row->value == $data->tempat_lahir) echo $row->text;
							?>
						</td>
					</tr>
					<tr>
						<th>Jenis Kelamin</th>
						<td><?php echo $data->jk == 'l' ? 'Laki-laki' : 'Perempuan'; ?></td>
						<th>Tgl Lahir</th>
						<td><?php echo date('d/m/Y', strtotime($data->tgl_lahir)); ?></td>
					</tr>
					<tr>
						<th>Alamat</th>
						<td><?php echo $data->alamat; ?></td>
						<th>Telp</th>
						<td><?php echo $data->telp; ?></td>
					</tr>
					<tr>
						<th>Agama</th>
						<td>
							<?php 
								foreach($this->form_data['agama']['data'] as $row) if($row->value == $data->agama) echo $row->text;
							?>
						</td>
						<th>Email</th>
						<td><?php echo $data->email; ?></td>
					</tr>
					<tr>
						<th>Nama Ayah</th>
						<td><?php echo $data->nama_ayah; ?></td>
						<th>Nama Ibu</th>
						<td><?php echo $data->nama_ibu; ?></td>
					</tr>
					<tr>
						<th>Telp Ayah</th>
						<td><?php echo $data->telp_ayah; ?></td>
						<th>Telp Ibu</th>
						<td><?php echo $data->telp_ibu; ?></td>
					</tr>
					<tr>
						<th>Angkatan</th>
						<td><?php echo $data->angkatan; ?></td>
						<th>Status</th>
						<td>
							<?php 
								$status_akademis = '';
								foreach($this->form_data['status_akademis']['data'] as $row) if($row->value == $data->status_akademis) $status_akademis = $row->text;
								echo $status_akademis;
							?>
						</td>
					</tr>

				</table>
			</div>	

			<div class="tab-pane" id="tab_akademik">
				<table class="table table-striped">
					<tr class="active">
						<th width="15%">Tahun Ajaran</th>
						<th width="35%"><?php echo $tahun_ajaran->thn_ajaran.' '.$tahun_ajaran->sem_ajaran;?></th>
						<th width="15%"></th>
						<td width="35%"></td>
					</tr>
					<tr>
						<th>No. Induk</th>
						<td><?php echo $data->no_induk; ?></td>
						<th>NISN</th>
						<td><?php echo $data->nisn; ?></td>
					</tr>
					<tr>
						<th>Nama</th>
						<td><?php echo $data->nama; ?></td>
						<th>Jenjang</th>
						<td><?php echo $akademik->nama_jenjang?>
						</td>
					</tr>
					<tr>
						<th>Sekolah</th>
						<td><?php echo $akademik->nama_sekolah; ?></td>
						<th>Jurusan</th>
						<td><?php echo $akademik->nama_jurusan?>
						</td>
					</tr>
					<tr>
						<th>Kelas</th>
						<td><?php echo $akademik->nama_kelas; ?></td>
						<th>Wali Kelas</th>
						<td><?php echo $akademik->nama_wali_kelas?>
						</td>
					</tr>
					<tr>
						<th>Angkatan</th>
						<td><?php echo $data->angkatan; ?></td>
						<th>Status</th>
						<td><?php echo $status_akademis; ?></td>
					</tr>
					<tr>
						<th>Tgl Masuk</th>
						<td><?php echo $data->tgl_masuk ? date('d/m/Y', strtotime($data->tgl_masuk)) : ''; ?></td>
						<th></th>
						<td></td>
					</tr>
					
				</table>
			
			</div>
			
			<div class="tab-pane" id="tab_absensi">
				<?php
					$data_absensi = array();
					foreach($riwayat->data as $row) $data_absensi[$row->kode_jenis_riwayat][] = $row;
				?>
				<table class="table table-striped">
					<tr class="active">
						<th width="15%">Tahun Ajaran</th>
						<th><?php echo $tahun_ajaran->thn_ajaran.' '.$tahun_ajaran->sem_ajaran;?></th>
					</tr>
					<?php 
						foreach($riwayat->jenis as $j) 
						{
							echo '<tr class="warning">';
							echo '<td colspan="2"><b>'.$j->nama_jenis.'</b></td>';
							echo '<tr>';
							if(isset($data_absensi[$j->kode_jenis]) && is_array($data_absensi[$j->kode_jenis])) 
							{
								foreach($data_absensi[$j->kode_jenis] as $row)
								{
									echo '<tr>';
									echo '<td width="15%" class="text-center">'.date('d/m/y', strtotime($row->tgl)).'</td>';
									echo '<td>'.$row->keterangan.'</td>';
									echo '<tr>';
								}
							}
						}
					?>
				</table>
			
			</div>
			
			<div class="tab-pane" id="tab_tanggungan">
				<table class="table table-bordered table-responsive table-striped table-hover">
					<thead>
						<tr class="dark">
							<th width="18%" class="text-center">Kode</th>
							<th>Jenis</th>
							<th width="13%" class="text-center">Periode</th>
							<th width="13%" class="text-right">Tagihan</th>
							<th width="13%" class="text-right">Bayar</th>
							<th width="13%" class="text-right">Kurang</th>
							<th width="13%" class="text-center">Status</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$i=0; 
						$total_tagih = 0;
						$total_bayar = 0;
						$total_kurang = 0;
						$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
						foreach($tagihan as $row) 
						{ 
							$total_tagih += $row->tagih;
							$total_bayar += $row->bayar;
							$total_kurang += $row->tanggungan;
					?>
					<tr>
						<td class="text-center"><?php echo $row->kode_tagihan; ?></td>
						<td><?php echo $row->nama_jenis; ?></td>
						<td class="text-center"><?php echo $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode; ?></td>
						<td class="text-right">Rp. <?php echo number_format($row->tagih,0,',','.'); ?></td>
						<td class="text-right">Rp. <?php echo number_format($row->bayar,0,',','.'); ?></td>
						<td class="text-right">Rp. <?php echo number_format($row->tanggungan,0,',','.'); ?></td>
						<td class="text-center"><?php echo $row->status_tagihan; ?></td>
					</tr>
					<?php } ?>	
					</tbody>
					<tfoot>
						<tr>
							<th class="text-right" colspan="3"><b>Total</b></th>
							<th class="text-right"><b>Rp. <?php echo number_format($total_tagih,0,',','.'); ?></b></th>
							<th class="text-right"><b>Rp. <?php echo number_format($total_bayar,0,',','.'); ?></b></th>
							<th class="text-right"><b>Rp. <?php echo number_format($total_kurang,0,',','.'); ?></b></th>
							<th class="text-center"><?php echo $total_kurang > 0 ? '<span class="label label-danger">Belum Lunas</span>' : '<span class="label label-success">Lunas</span>' ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			
			<div class="tab-pane" id="tab_pembayaran">
				<table class="table table-responsive table-striped table-hover table-bordered">
					<thead>
						<tr class="dark">
							<th width="18%" class="text-center">Kode</th>
							<th>Jenis</th>
							<th width="15%" class="text-center">Periode</th>
							<th width="13%" class="text-center">Transaksi</th>
							<th width="13%" class="text-center">Tgl bayar</th>
							<th width="10%" class="text-center">Bank</th>
							<th width="15%" class="text-right">Nominal</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$i=0; 
						$total = 0;
						foreach($pembayaran as $row)
						{ 
							$total += $row->bayar;
					?>
					<tr>
						<td class="text-center"><?php echo $row->kode_pembayaran; ?></td>
						<td><?php echo $row->nama_jenis; ?></td>
						<td class="text-center"><?php echo $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode; ?></td>
						<td class="text-center"><?php echo ucwords($row->jenis_transaksi); ?></td>
						<td class="text-center"><?php echo date('d/m/Y', strtotime($row->tgl_bayar)); ?></td>
						<td class="text-center"><?php echo $row->bank; ?></td>
						<td class="text-right">Rp. <?php echo number_format($row->bayar,0,',','.'); ?></td>
					</tr>
					<?php } ?>	
					</tbody>
					<tfoot>
						<tr>
							<th class="text-right" colspan="6"><b>Total</b></th>
							<th class="text-right"><b>Rp. <?php echo number_format($total,0,',','.'); ?></b></th>
						</tr>
					</tfoot>
				</table>
			</div>
			
		</div>
	</div>
</div><!-- /.modal-body -->
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

<?php if(isset($additional_script)) echo $additional_script; ?>