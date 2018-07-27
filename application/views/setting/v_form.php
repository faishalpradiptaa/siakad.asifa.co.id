
<?php
	$error = $this->session->flashdata('error');
	$success = $this->session->flashdata('success');
	if($error) echo '<div class="alert alert-danger">'.$error.'</div>';
	if($success) echo '<div class="alert alert-success">'.$success.'</div>';
?>
<div class="panel">
	<form action="" method="POST">
		<ul class="nav nav-tabs nav-justified">
			<li class="active"> <a href="#tab-identitas" data-toggle="tab"> <i class="glyphicons glyphicons-user"></i> Data Pribadi</a></li>
			<li><a href="#tab-orangtua" data-toggle="tab"><i class="glyphicons glyphicons-parents"></i> Orang Tua</a></li>
			<li><a href="#tab-password" data-toggle="tab"><i class="fa fa-key"></i> Ganti Password</a></li>
		</ul>
		<div class="tab-content">
			<div id="tab-identitas"" class="tab-pane active">
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
									<th width="25%">No. Induk</th>
									<td><?php echo $this->detail_siswa->no_induk; ?></td>
								</tr>
								<tr>
									<th>NISN</th>
									<td><?php echo $this->detail_siswa->nisn; ?></td>
								</tr>
								<tr>
									<th>Nama</th>
									<td><?php echo $this->detail_siswa->nama; ?></td>
								</tr>
								<tr>
									<th>Jenis Kelamin</th>
									<td><?php echo $this->detail_siswa->jk == 'l' ? 'Laki-laki' : 'Perempuan'; ?></td>
								</tr>
								<tr>
									<th>Alamat</th>
									<td>
										<div class="row"><div class="col-md-10">
											<input type="text" class="form-control" name="alamat" required value="<?php echo $this->detail_siswa->alamat; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Telp</th>
									<td>
										<div class="row"><div class="col-md-5">
											<input type="text" class="form-control" name="telp" required value="<?php echo $this->detail_siswa->telp; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Email</th>
									<td>
										<div class="row"><div class="col-md-8">
											<input type="email" class="form-control" name="email" required value="<?php echo $this->detail_siswa->email; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><button class="btn btn-primary"><i class="fa fa-save margin-r-5"></i> Simpan</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="tab-orangtua" class="tab-pane">
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
									<th width="25%">Nama Ayah</th>
									<td>
										<div class="row"><div class="col-md-8">
											<input type="text" class="form-control" name="nama_ayah" value="<?php echo $this->detail_siswa->nama_ayah; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Telp Ayah</th>
									<td>
										<div class="row"><div class="col-md-5">
											<input type="text" class="form-control" name="telp_ayah" value="<?php echo $this->detail_siswa->telp_ayah; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Nama Ibu</th>
									<td>
										<div class="row"><div class="col-md-8">
											<input type="text" class="form-control" name="nama_ibu" value="<?php echo $this->detail_siswa->nama_ibu; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Telp Ibu</th>
									<td>
										<div class="row"><div class="col-md-5">
											<input type="text" class="form-control" name="telp_ibu" value="<?php echo $this->detail_siswa->telp_ibu; ?>">
										</div></div>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><button class="btn btn-primary"><i class="fa fa-save margin-r-5"></i> Simpan</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="tab-password" class="tab-pane">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-icon"><i class="fa fa-key"></i>
						</span>
						<span class="panel-title"> Ganti Password</span>
					</div>
					<div class="panel-body">
						<table class="table table-hover">
							<tbody>
								<tr>
									<th width="25%">No. Induk</th>
									<td><?php echo $this->detail_siswa->no_induk; ?></td>
								</tr>
								<tr>
									<th>Nama</th>
									<td><?php echo $this->detail_siswa->nama; ?></td>
								</tr>
								<tr>
									<th>Email</th>
									<td><?php echo $this->detail_siswa->email; ?></td>
								</tr>
								<tr>
									<th>Password Lama</th>
									<td>
										<div class="row"><div class="col-md-6">
											<input type="password" class="form-control" name="pass_lama" value="">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Password Baru</th>
									<td>
										<div class="row"><div class="col-md-6">
											<input type="password" class="form-control" name="pass_baru" value="">
										</div></div>
									</td>
								</tr>
								<tr>
									<th>Ulangi Password Baru</th>
									<td>
										<div class="row"><div class="col-md-6">
											<input type="password" class="form-control" name="pass_confirm" value="">
										</div></div>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><button class="btn btn-primary"><i class="fa fa-save margin-r-5"></i> Simpan</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		

	</form>
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

