<div class="admin-panels mn pn">
	<div class="col-sm-12 admin-grid">
		<!-- Panel with All Options -->
		<div class="row">
		<div class="col-md-12 admin-grid">
			<div class="panel sort-disable panel-info" data-panel-color="false" data-panel-title="false" data-panel-remove="false" data-panel-collapse="false">
			<div class="panel-heading">
				<span class="panel-icon"><i class="glyphicons glyphicons-bell"></i>
				</span>
				<span class="panel-title"><?php echo PAGE_TITLE; ?></span>
			</div>
			<div class="panel-body">
				<div class="panel sort-disable">
					<div class="panel-body panel-info">
					<form action="" class="form-horizontal row-border frm_validation" id="frm_validation1">
						<div class="col-md-4">
							<div class="form-group">
							<label class="col-sm-4 control-label">Periode</label>
							<div class="col-sm-8">
								<select id="select_thn_ajaran" class="form-control">
									<?php
										$detail_curr_thn_ajaran = false;
										if($list_thn_ajaran)
										{
											foreach($list_thn_ajaran as $row)
											{
												if($row->kode_thn_ajaran == $curr_thn_ajaran) $detail_curr_thn_ajaran = $row;
												echo '<option value="'.$row->kode_thn_ajaran.'" '.($row->kode_thn_ajaran == $curr_thn_ajaran ? 'selected="selected"' : '').'>'.$row->thn_ajaran.' '.$row->sem_ajaran.'</option>';
											}
										} else
										echo '<option value=""> Data rapor belum tersedia</option>';
									?>
								</select>
							</div>
							</div>
						</div>

					</form>
					</div>
					<div class="panel-body pn" id="panel_frs">

						<div class="row">
							<div class="col-lg-12">


								<div>
								<?php if ($kehadiran) { ?>
									<!-- KEHADIRAN HEADER -->
									<table class="table table-responsive table-condensed">
										<tbody>
											<tr>
												<th>Nama</th>
												<td  colspan="3"><?php echo $siswa->nama; ?></td>
											</tr>
											<tr>
												<th>Semester</th>
												<td  colspan="3"><?php echo $detail_curr_thn_ajaran->sem_ajaran; ?></td>
											</tr>
											<tr>
												<th>No. Induk</th>
												<td  colspan="3"><?php echo $siswa->no_induk; ?></td>
											</tr>
											<tr>
												<th>NISN</th>
												<td  colspan="3"><?php echo $siswa->nisn; ?></td>
											</tr>
											<tr>
												<th>Tahun Ajaran</th>
												<td  colspan="3"><?php echo $detail_curr_thn_ajaran->thn_ajaran; ?></td>
											</tr>
											<tr>
												<th>Jenjang</th>
												<td  colspan="3"><?php echo $siswa->nama_jenjang; ?></td>
											</tr>
											<tr>
												<th>Sekolah</th>
												<td  colspan="3"><?php echo $siswa->nama_sekolah; ?></td>
											</tr>
											<?php
												if($ambil_kelas->nama_jenjang=="SMA"){
													echo "<tr><th>Jurusan</th>
													<td>".$ambil_kelas->nama_jurusan."</td></tr>";
												}
											?>
											<tr>
												<th>Kelas</th>
												<td  colspan="3"><?php echo $siswa->nama_kelas; ?></td>
											</tr>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
											</tr>
										</tbody>
									</table>

									<!-- KEHADIRAN CONTENT -->
									<?php
										$data = array();
										foreach($kehadiran->data as $row) $data[$row->kode_jenis_riwayat][] = $row;
									?>
									<table class="table table-responsive table-condensed">
										<tbody>
											<?php
												foreach($kehadiran->jenis as $j)
												{
													echo '<tr class="tr-jenis">';
													echo '<td colspan="2"><b>'.$j->nama_jenis.'</b></td>';
													echo '<tr>';
													if(isset($data[$j->kode_jenis]) && is_array($data[$j->kode_jenis]))
													{
														foreach($data[$j->kode_jenis] as $row)
														{
															echo '<tr>';
															echo '<td width="15%" class="text-center" style="font-weight: bold;">'.date('d/m/y', strtotime($row->tgl)).'</td>';
															echo '<td>'.$row->keterangan.'</td>';
															echo '<tr>';
														}
													}
													echo '<tr><td colspan="2">&nbsp;</td><tr>';
												}
											?>
										</tbody>
									</table>


									<?php } else { ?>
									<div class="alert alert-info alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<i class="fa fa-info pr10"></i>
										Data kehadiran anda pada periode ini masih belum tersedia atau masih belum dipublikasikan.
									</div>
									<?php } ?>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>


<div class="tray tray-center hide">

<div class="admin-form center-block theme-primary">
	<div class="panel heading-border panel-primary">
		<div class="panel-heading">
			<span class="panel-title"><?php echo PAGE_TITLE; ?></span>
			<div class="col-md-3 pull-right">
				<select id="select_thn_ajaran" class="form-control">
					<?php
						if($list_thn_ajaran)
						{
							foreach($list_thn_ajaran as $row) echo '<option value="'.$row->kode_thn_ajaran.'" '.($row->kode_thn_ajaran == $curr_thn_ajaran ? 'selected="selected"' : '').'>'.$row->thn_ajaran.' '.$row->sem_ajaran.'</option>';
						} else
							echo '<option value=""> Data rapor belum tersedia</option>';

					?>
				</select>
			</div>
		</div>
		<div class="panel-body bg-light">
			<!-- RAPOR HEADER -->


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
.rapor-header, .rapor-point{
	margin-bottom: 15px;
}
.rapor-point h4{
	font-size: 16px;
	font-weight: bold;
}
.IPS-container{
	font-weight: bold;
	border: 1px solid #ddd;
	width: 25%;
	padding: 10px;
	background: white;
}
.IPS-container span{
	float: right;
	display: block;
}
.table{
	background: white;
}
.admin-form .heading-border .panel-heading {
	padding: 20px 20px 5px;
}
.textarea{
	border: 1px solid #ddd;
	padding: 10px;
	min-height: 100px;
	background: #fff;
}
.tr-jenis td{
	background: #e3e3e3;
}
</style>
[/section]

[section name="plugin-js"]
[/section]

[section name="js"]
<script>
$('#select_thn_ajaran').change(function(){
	window.location = '<?php echo site_url(PAGE_ID.'/'.$kode_template); ?>/'+$(this).val();
})
</script>
[/section]
