
<div class="row">
	<div class="col-md-4">
		<h4 class="page-header mtn br-light text-muted hidden">User Info</h4>
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-icon"><i class="fa fa-star"></i>
				</span>
				<span class="panel-title"> Data Akademis</span>
			</div>
			<div class="panel-body pn">
				<table class="table mbn tc-icon-1 tc-med-2 tc-bold-last">
					<thead>
						<tr class="hidden">
							<th class="mw30">#</th>
							<th>First Name</th>
							<th>Revenue</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th width="35%">No. Induk</th>
							<td><?php echo $detail_siswa->no_induk; ?></td>
						</tr>
						<tr>
							<th>NISN</th>
							<td><?php echo $detail_siswa->nisn; ?></td>
						</tr>
						<tr>
							<th>Thn Ajaran</th>
							<td><?php echo $tahun_ajaran->thn_ajaran.' '.$tahun_ajaran->sem_ajaran; ?></td>
						</tr>
						<tr>
							<th>Jenjang</th>
							<td><?php echo $ambil_kelas->nama_jenjang; ?></td>
						</tr>
						<tr>
							<th>Sekolah</th>
							<td><?php echo $ambil_kelas->nama_sekolah; ?></td>
						</tr>
							<?php
								if($ambil_kelas->nama_jenjang=="SMA"){
									echo "<tr><th>Jurusan</th>
									<td>".$ambil_kelas->nama_jurusan."</td></tr>";
								}
							?>
						<tr>
							<th>Kelas</th>
							<td><?php echo $ambil_kelas->nama_kelas; ?></td>
						</tr>
						<tr>
							<th>Angkatan</th>
							<td><?php echo $detail_siswa->angkatan; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-8">

		<div class="panel">

			<ul class="nav nav-tabs nav-justified">
				<li class="active"> <a class="fw600" href="#tab-identitas" data-toggle="tab"> <i class="glyphicons glyphicons-user"></i> Data Pribadi</a></li>
				<li class=""> <a class="fw600" href="#tab-orangtua" data-toggle="tab"><i class="glyphicons glyphicons-parents"></i> Orang Tua</a></li>
			</ul>
			<div class="tab-content">
				<!-- Stats Top Graph Bot -->
				<div id="tab-identitas" class="tab-pane active">
					<div class="panel">
						<div class="panel-heading">
							<span class="panel-icon"><i class="glyphicons glyphicons-user"></i>
							</span>
							<span class="panel-title"> Data Pribadi Siswa</span>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<tbody>
									<tr>
										<th width="35%">Nama</th>
										<td><?php echo $detail_siswa->nama; ?></td>
									</tr>
									<tr>
										<th>Tempat / Tgl Lahir</th>
										<td><?php echo $detail_siswa->kota_lahir.'  '.date('d/m/Y', strtotime($detail_siswa->tgl_lahir)); ?></td>
									</tr>
									<tr>
										<th>Jenis Kelamin</th>
										<td><?php echo $detail_siswa->jk == 'l' ? 'Laki-laki' : 'Perempuan'; ?></td>
									</tr>
									<tr>
										<th>Alamat</th>
										<td><?php echo $detail_siswa->alamat; ?></td>
									</tr>
									<tr>
										<th>Telp</th>
										<td><?php echo $detail_siswa->telp; ?></td>
									</tr>
									<tr>
										<th>Agama</th>
										<td><?php echo $detail_siswa->nama_agama; ?></td>
									</tr>
									<tr>
										<th>Email</th>
										<td><?php echo $detail_siswa->email; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div id="tab-orangtua" class="tab-pane p15">
					<div class="panel">
						<div class="panel-heading">
							<span class="panel-icon"><i class="glyphicons glyphicons-parents"></i>
							</span>
							<span class="panel-title"> Data Orang Tua Siswa</span>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<tbody>
									<tr>
										<th width="35%">Nama Ayah</th>
										<td><?php echo $detail_siswa->nama_ayah; ?></td>
									</tr>
									<tr>
										<th>Telp Ayah</th>
										<td><?php echo $detail_siswa->telp_ayah; ?></td>
									</tr>
									<tr>
										<th>Nama Ibu</th>
										<td><?php echo $detail_siswa->nama_ibu; ?></td>
									</tr>
									<tr>
										<th>Telp Ibu</th>
										<td><?php echo $detail_siswa->telp_ibu; ?></td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>
[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>
[/section]

[section name="css"]
<style>
</style>
[/section]

[section name="plugin-js"]
[/section]

[section name="js"]
<script>
</script>
[/section]
