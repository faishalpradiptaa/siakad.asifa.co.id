
<div class="page-content">

	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>
	
	<ul class="page-breadcrumb breadcrumb">
		
	</ul>
	
	<div class="row margin-top-10">

		<div class="col-md-6">
			<div class="row">
			
				<?php $persentase_siswa_valid = round(($siswa_valid / $siswa_all)*100); ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-blue-sharp" data-counter="counterup" data-value="<?php echo $siswa_valid; ?>">0</h3>
								<small>Valid</small>
							</div>
							<div class="icon"><i class="icon-users"></i></div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $persentase_siswa_valid; ?>%;" class="progress-bar progress-bar-success blue-sharp">
									<span class="sr-only"><?php echo $persentase_siswa_valid; ?>% siswa</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">siswa</div>
								<div class="status-number"><?php echo $persentase_siswa_valid; ?>%</div>
							</div>
						</div>
					</div>
				</div>
				
				<?php $persentase_siswa_menunggak = round(($siswa_menunggak / $siswa_all)*100); ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-red-haze" data-counter="counterup" data-value="<?php echo $siswa_menunggak; ?>">0</h3>
								<small>Menunggak</small>
							</div>
							<div class="icon"><i class="icon-dislike"></i></div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $persentase_siswa_menunggak; ?>%;" class="progress-bar progress-bar-success red-haze">
									<span class="sr-only"><?php echo $persentase_siswa_menunggak; ?>% siswa</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title"> siswa</div>
								<div class="status-number"> <?php echo $persentase_siswa_menunggak; ?>%</div>
							</div>
						</div>
					</div>
				</div>
				
				<?php $persentase_bayar = round(($pemasukan_bln_ini->jml_siswa/ $siswa_all)*100); ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-green-sharp">
									<span data-counter="counterup" data-value="<?php echo round($pemasukan_bln_ini->jml_nominal/1000);?>">0</span>
									<small class="font-green-sharp">k</small>
								</h3>
								<small>Pemasukan Bulan Ini</small>
							</div>
							<div class="icon"><i class="icon-pie-chart"></i></div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $persentase_bayar; ?>%;" class="progress-bar progress-bar-success green-sharp">
									<span class="sr-only"><?php echo $persentase_bayar; ?>% siswa</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">siswa</div>
								<div class="status-number"><?php echo $persentase_bayar; ?>%</div>
							</div>
						</div>
					</div>
				</div>					
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-yellow-crusta ">
									<span data-counter="counterup" data-value="<?php echo round($piutang/1000);?>">0</span>
									<small class="font-yellow-crusta">k</small>
								</h3>
								<small>Piutang</small>
							</div>
							<div class="icon"><i class="icon-note"></i></div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 0%;" class="progress-bar progress-bar-success yellow-crusta ">
									<span class="sr-only">0% mahasiswa</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title"> Rupiah</div>
								<div class="status-number"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-blue-sharp"></i>
						<span class="caption-subject bold uppercase font-blue-sharp"> Jml Siswa per Angkatan</span>
					</div>
				</div>
				<div class="portlet-body clearfix">
					<div id="chart_siswa_angkatan" class="chart" style="height: 190px;">
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-purple-medium"></i>
						<span class="caption-subject bold uppercase font-purple-medium"> Jml Siswa per Jenjang</span>
					</div>
					<div class="pull-right margin-t-10"><b><?php echo $thn_ajaran->thn_ajaran.' '.$thn_ajaran->sem_ajaran; ?></b></div>
				</div>
				<div class="portlet-body clearfix">
					<div id="chart_siswa_jenjang" class="chart" style="height: 240px;">
					</div>
				</div>
			</div>
		</div>
	
		<div class="col-md-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-pie-chart font-green-seagreen"></i>
						<span class="caption-subject bold uppercase font-green-seagreen"> Jml Siswa per Umur</span>
					</div>
				</div>
				<div class="portlet-body clearfix">
					<div id="chart_siswa_umur" class="chart" style="height: 240px;">
					</div>
				</div>
			</div>
		</div>
	
		
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-soft"></i>
						<span class="caption-subject bold uppercase font-green-soft"> Pemasukan per bulan</span>
					</div>
				</div>
				<div class="portlet-body clearfix">
					<div id="chart_income_bulanan" class="chart" style="height: 300px;">
					</div>
				</div>
			</div>
		</div>
		
		
		
	</div>

</div>


[section name="plugin-css"]
[/section]

[section name="plugin-js"]
	<script src="<?php echo base_url(); ?>assets/custom/plugin/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/custom/plugin/counterup/jquery.counterup.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
[/section]

[section name="css"]
<style>
	.amcharts-main-div a{
		display: none!important;
	}
</style>
[/section]

[section name="js"]
<script>
	$('[data-counter="counterup"]').counterUp();
	
	var chart_angkatan = AmCharts.makeChart("chart_siswa_angkatan", {
		"type": "serial",
		"addClassNames": true,
		"theme": "light",
		"balloon": {
			"adjustBorderColor": false,
			"horizontalPadding": 10,
			"verticalPadding": 8,
			"color": "#ffffff"
		},
		"dataProvider": <?php echo json_encode($siswa_per_angkatan); ?>,
		"valueAxes": [{ "axisAlpha": 0, "position": "left" }],
		"startDuration": 1,
		"graphs": [ {
			"id": "graph2",
			"balloonText": "<span style='font-size:12px;'>[[title]] angkatan [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
			"bullet": "round",
			"lineThickness": 3,
			"bulletSize": 7,
			"bulletBorderAlpha": 1,
			"bulletColor": "#FFFFFF",
			"useLineColorForBulletBorder": true,
			"bulletBorderThickness": 3,
			"fillAlphas": 0,
			"lineAlpha": 1,
			"title": "Siswa",
			"valueField": "jml"
		}],
		"categoryField": "angkatan",
		"categoryAxis": {
			"gridPosition": "start",
			"axisAlpha": 0,
			"tickLength": 0
		},

	});

	var chart_umur = AmCharts.makeChart("chart_siswa_umur", {
		"dataProvider":  <?php echo json_encode($siswa_per_umur); ?>,
		"type": "pie",
		"theme": "light",
		"valueField": "jml",
		"titleField": "age",
		"outlineAlpha": 0.4,
		"depth3D": 15,
		"angle": 30,
		"fontFamily": 'Open Sans',
		"balloon":{"fixedPosition":true},
		"export": {"enabled": true}
	});
	
	var chart_jenjang = AmCharts.makeChart("chart_siswa_jenjang", {
		"type": "serial",
		"addClassNames": true,
		"theme": "light",
		"depth3D": 20,
    "angle": 30,
		"balloon": {
			"adjustBorderColor": false,
			"horizontalPadding": 10,
			"verticalPadding": 8,
			"color": "#ffffff"
		},
		"dataProvider": <?php echo json_encode($siswa_per_jenjang); ?>,
		"valueAxes": [{ "axisAlpha": 0, "position": "left" }],
		"startDuration": 1,
		"graphs": [{
			"alphaField": "alpha",
			"balloonText": "<span style='font-size:12px;'>Siswa Jenjang [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
			"fillAlphas": 1,
			"lineAlpha": 0,
			"title": "Jumlah",
			"type": "column",
			"valueField": "jml",
			"dashLengthField": "dashLengthColumn",
			"fillColors": "#BF55EC",
		}],
		"categoryField": "nama_jenjang",
		"categoryAxis": {
			"gridPosition": "start",
			"axisAlpha": 0,
			"tickLength": 0
		},

	});

	var chart_income = AmCharts.makeChart("chart_income_bulanan", {
		"type": "serial",
		"addClassNames": true,
		"theme": "light",
		"path": "<?php echo base_url(); ?>assets/custom/img/",
		"balloon": {
			"adjustBorderColor": false,
			"horizontalPadding": 10,
			"verticalPadding": 8,
			"color": "#ffffff"
		},
		"dataProvider": <?php echo json_encode($pemasukan_12_bln); ?>,
		"valueAxes": [{ 
			"axisAlpha": 0, 
			"position": "left",
			"labelFunction" : function(value, valueString, axis)
			{
				var val_string = '';
				if (value>999999999) {val_string = (value/1000000000) + " M";}
				else if (value>999999) {val_string = (value/1000000) + " Jt";} 
				else if (value>999) {val_string = (value/1000) + "K";} 
				else {val_string = value;}
				return val_string
			}
		}],
		"startDuration": 1,
		"graphs": [ {
			"id": "graph2",
			"balloonText": "<span style='font-size:12px;'>[[title]] [[category]] [[thn]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
			"bullet": "round",
			"lineThickness": 3,
			"bulletSize": 7,
			"bulletBorderAlpha": 1,
			"bulletColor": "#FFFFFF",
			"useLineColorForBulletBorder": true,
			"bulletBorderThickness": 3,
			"fillAlphas": 0,
			"lineAlpha": 1,
			"title": "Pemasukan",
			"valueField": "total",
			"lineColor" : "#4DB3A2"
		}],
		"categoryField": "bln",
		"categoryAxis": {
			"gridPosition": "start",
			"axisAlpha": 0,
			"tickLength": 0
		},
		"chartScrollbar": {},
		"startDuration": 0,
		"chartCursor": {
			"cursorAlpha": 0,
			"zoomable": true
		},
	

	});
	
	chart_income.addListener("rendered", function(){ 
		chart_income.zoomToIndexes(chart_income.dataProvider.length-12, chart_income.dataProvider.length-1);
	});

</script>
[/section]