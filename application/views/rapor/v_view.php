<div class="admin-panels mn pn">
	<div class="col-sm-12 admin-grid">
		<!-- Panel with All Options -->
		<div class="row">
		<div class="col-md-12 admin-grid">
			<div class="panel sort-disable panel-info" data-panel-color="false" data-panel-title="false" data-panel-remove="false" data-panel-collapse="false">
			<div class="panel-heading">
				<span class="panel-icon"><i class="fa fa-check-square"></i>
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
			
								
								<div class="padding-10">
								<?php if ($rapor) { ?>
									<!-- RAPOR HEADER -->
									<table class="table table-responsive table-condensed">
										<tbody>
											<tr>
												<th width="15%">Nama</th>
												<td width="50%"><?php echo $siswa->nama; ?></td>
												<th width="15%">Semester</th>
												<td><?php echo $detail_curr_thn_ajaran->sem_ajaran; ?></td>
											</tr>
											<tr>
												<th>No. Induk</th>
												<td><?php echo $siswa->no_induk; ?></td>
												<th>Tahun Ajaran</th>
												<td><?php echo $detail_curr_thn_ajaran->thn_ajaran; ?></td>
											</tr>
											<tr>
												<th>NISN</th>
												<td><?php echo $siswa->nisn; ?></td>
												<th>Kelas</th>
												<td><?php echo $siswa->nama_kelas; ?></td>
											</tr>
											<tr>
												<th>Sekolah</th>
												<td><?php echo $siswa->nama_sekolah; ?></td>
												<th>Jurusan</th>
												<td><?php echo $siswa->nama_jurusan; ?></td>
											</tr>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												
											</tr>
										</tbody>
									</table>
									
									<!-- RAPOR CONTENT -->
									<?php 
										$replace = array(
											'[CODE:IPS]' => $rapor ? $rapor->ips : '',
										);
										$view = str_replace(array_keys($replace), array_values($replace), $view);
										echo $view; 
									?>
									
									<!-- RAPOR PROPERTY -->
									<div class="row">
										<div class="col-md-4 text-center">
											<br>
											Orang Tua / Wali
											<br><br><br><br>
											(...........................................)
										</div>
										<div class="col-md-4 col-md-offset-4 text-center">
											Malang, <?php echo $rapor ? date('d/m/Y', strtotime($rapor->tgl_publish)) : date('d/m/Y'); ?><br>
											<?php echo $template->ttd_1; ?>
											<br><br><br><br>
											<?php 
												$ttd1 = $rapor->nama_ttd_1 ? $rapor->nama_ttd_1 : $template->nama_ttd_1;
												if($template->nama_ttd_1) echo $ttd1;
												else echo $siswa->nama_wali_kelas; 
											?>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-4 col-md-offset-4 text-center">
											<br>
											<?php echo $template->ttd_2; ?>
											<br><br><br><br>
											<?php 
												$ttd2 = $rapor->nama_ttd_2 ? $rapor->nama_ttd_2 : $template->nama_ttd_2;
												if($template->nama_ttd_2) echo $ttd2;
												else echo $siswa->kepsek.'<br>'.$siswa->nip_kepsek; 
											?>
											<br><br>
										</div>
									</div>

									<?php } else { ?>
									<div class="alert alert-info alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<i class="fa fa-info pr10"></i>
										Rapor anda masih belum tersedia atau masih belum dipublikasikan.
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
</style>
[/section]

[section name="plugin-js"]
	<script type="text/javascript" src="<?php echo base_url();?>assets/custom/plugin/flot/jquery.flot.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/custom/plugin/flot/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/custom/plugin/flot/jquery.flot.categories.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/custom/plugin/flot/jquery.flot.stack.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/custom/plugin/flot/jquery.flot.crosshair.min.js"></script>
[/section]

[section name="js"]
<script>
	$('#select_thn_ajaran').change(function(){
		window.location = '<?php echo site_url(PAGE_ID.'/'.$kode_template); ?>/'+$(this).val();		
	})

	function createGraph(selector, my_data)
	{
		var previousPoint2 = null;
		
		$.plot($(selector),[
			{
				data: my_data,
				lines: { fill: 0.2, lineWidth: 0, },
				color: ['#BAD9F5']
			}, 
			{
				data: my_data,
				points: {show: true, fill: true, radius: 4, fillColor: "#9ACAE6", lineWidth: 2 },
				color: '#9ACAE6',
				shadowSize: 1
			}, 
			{
				data: my_data,
				lines: { show: true, fill: false, lineWidth: 3 },
				color: '#9ACAE6',
				shadowSize: 0
			}
		],
		{
			xaxis: {
				tickLength: 0,
				tickDecimals: 0,
				mode: "categories",
				min: 0,
				font: {
					size: '12',
					lineHeight: 18,
					style: "normal",
					variant: "small-caps",
					color: "#6F7B8A"
				}
			},
			yaxis: {
				ticks: 5,
				tickDecimals: 0,
				tickColor: "#eee",
				font: {
					lineHeight: 14,
					style: "normal",
					variant: "small-caps",
					color: "#6F7B8A"
				}
			},
			grid: {
				hoverable: true,
				clickable: true,
				tickColor: "#eee",
				borderColor: "#eee",
				borderWidth: 1
			}
		});

		$(selector).bind("plothover", function(event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint2 != item.dataIndex) {
					previousPoint2 = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(2);
					showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] );
				}
			}
		});

		$(selector).bind("mouseleave", function() {
			$("#tooltip").remove();
		});
	}
		
	
	if($('.grafik_mapel').length && data_grafik)
	{
		$('.grafik_mapel').each(function(){
			var enc_kode = $(this).attr('enc-kode-mp');
			createGraph('[enc-kode-mp="'+enc_kode+'"]', data_grafik[enc_kode]);
		})
	}
	
	function showChartTooltip(x, y, xValue, yValue)
	{
		$('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
			position: 'absolute',
			display: 'none',
			top: y - 40,
			left: x - 40,
			border: '0px solid #ccc',
			padding: '2px 6px',
			'background-color': '#fff'
		}).appendTo("body").fadeIn(200);
	}
</script>
[/section]

