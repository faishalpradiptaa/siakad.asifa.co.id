<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
		<li><a href="javascript:;">Transaksi</a> <i class="fa fa-circle"></i></li>
		<li><a href="javascript:;">Nilai <b><?php echo $siswa->no_induk.' - '.$siswa->nama; ?></b></a></li>
		
	</ul>
	
	<div class="row">
		<div class="col-md-12">
			<?php
				$error = $this->session->flashdata('error');
				$warning = $this->session->flashdata('warning');
				$success = $this->session->flashdata('success');
				if($error) echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$error.'</div>';
				if($warning) echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$warning.'</div>';
				if($success) echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$success.'</div>';
			?>
			
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase"><?php echo $template->nama_template.' "'.$siswa->no_induk.' - '.$siswa->nama.'"'; ?></span>
					</div>
					<div class="tools tabletool-container">
						<div class="dt-buttons">
							<a class="dt-button" href="javascript:;" class="btn btn-default" onclick="window.print();"><span><i class="glyphicon glyphicon-print"></i>&nbsp; Cetak</span></a>
							<a class="dt-button" href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template.'#'.$siswa->kode_kelas); ?>" class="btn btn-default"><span><i class="glyphicon glyphicon-arrow-left"></i>&nbsp; Kembali</span></a>
						</div>
					</div>
				</div>
				<div class="portlet-body clearfix">
					
					<!-- RAPOR HEADER -->
					<div class="row rapor-header">
						<div class="col-md-12">
							<table border="0" width="100%">
								<tr>
									<td width="15%">Nama</td>
									<td width="50%">: &nbsp; <?php echo $siswa->nama; ?></td>
									<td width="15%">Kelas</td>
									<td>: &nbsp; <?php echo $siswa->nama_kelas; ?></td>
								</tr>
								<tr>
									<td>No. Induk</td>
									<td>: &nbsp; <?php echo $siswa->no_induk; ?></td>
									<td>Semester</td>
									<td>: &nbsp; <?php echo $this->curr_thn_ajaran->sem_ajaran; ?></td>
								</tr>
								<tr>
									<td>NISN</td>
									<td>: &nbsp; <?php echo $siswa->nisn; ?></td>
									<td>Tahun Pelajaran</td>
									<td>: &nbsp; <?php echo $this->curr_thn_ajaran->thn_ajaran; ?></td>
								</tr>
							</table>
						</div>
					</div>
				
					<form method="post" action="" class="main-form">
						<?php 
							$replace = array(
								'[CODE:IPS]' => $rapor ? $rapor->ips : '',
							);
							$view = str_replace(array_keys($replace), array_values($replace), $view);
							echo $view; 
						?>
						
						<!-- RAPOR PROPERTY -->
						<table width="100%">
							<tr>
								<td width="50%" class="text-center">
									<br>
									Orang Tua / Wali
									<br><br><br><br>
									(...........................................)
								</td>
								<td width="50%" class="text-center">
									Malang, <?php echo $rapor ? date('d/m/Y', strtotime($rapor->tgl_publish)) : date('d/m/Y'); ?><br>
									<?php echo $template->ttd_1; ?>
									<br><br><br><br>
									<?php 
										$ttd1 = $rapor->nama_ttd_1 ? $rapor->nama_ttd_1 : $template->nama_ttd_1;
										if($template->nama_ttd_1) echo $ttd1;
										else echo $siswa->nama_wali_kelas; 
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="text-center">
									<br>
									<?php echo $template->ttd_2; ?>
									<br><br><br><br>
									<?php 
										$ttd2 = $rapor->nama_ttd_2 ? $rapor->nama_ttd_2 : $template->nama_ttd_2;
										if($template->nama_ttd_2) echo $ttd2;
										else echo $siswa->kepsek.'<br>NIP.'.$siswa->nip_kepsek; 
									?>
									<br><br>
								</td>
							</tr>
						</table>
						
						<div class="row margin-t-15">
							<div class="col-sm-12 text-center">
								<a class="btn btn-default" href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template.'#'.$siswa->kode_kelas); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
							</div>
						</div>
					</form>
				
				</div>
			</div>
		</div>
	</div>
</div>


[section name="page-actions"]
<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height green-sharp dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Jenjang"> 
		<i class="fa fa-signal fa-rotate-90"></i>&nbsp;
		<span class="thin hidden-xs"> <?php echo $this->curr_jenjang->nama_jenjang; ?></span>&nbsp;
	</a>
</div>

<div class="btn-group">
	<a class="pull-right tooltips btn btn-fit-height blue-steel dropdown-toggle" data-toggle="dropdown" href="javascript:;" data-original-titles="Ubah Tahun Ajaran"> 
		<i class="fa fa-archive"></i>&nbsp;
		<span class="thin hidden-xs">Tahun Ajaran : <?php echo $this->curr_thn_ajaran->thn_ajaran.' '.$this->curr_thn_ajaran->sem_ajaran; ?></span>&nbsp;
	</a>
</div>
[/section]

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/css/print-rapor.css"/>
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
	}
	.IPS-container span{
		float: right;
    display: block;		
	}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/flot/jquery.flot.categories.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/flot/jquery.flot.stack.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/flot/jquery.flot.crosshair.min.js"></script>
[/section]

[section name="js"]
<script>

	/**** GLOBAL ****/
	var MAIN_FORM = $('.main-form');
	$('.page-sidebar-menu').find('[href="<?php echo site_url(PAGE_ID.'/index/'.$template->kode_template); ?>"]').parent('li').addClass('active').parents('li').addClass('active open');
	
	
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

