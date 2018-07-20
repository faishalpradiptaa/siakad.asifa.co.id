<aside class="tray tray-left tray350" data-tray-mobile="#content > .tray-center">

	<div class="fc-title-clone"></div>

	<div class="section admin-form theme-primary">
		<div class="inline-mp minimal-mp center-block"></div>
	</div>

	<h4 class="mt30"> Mata Pelajaran </h4>

	<hr class="mv15 br-light">

	<?php
		$mp = array();
		$events = array();
		foreach($tugas as $row)
		{
			if(!isset($mp[$row->kode_mp]))
			{
				$mp[$row->kode_mp] = (object)array(
					'kode_mp' => $row->kode_mp,
					'nama_mp' => $row->nama_mp,
					'jumlah' => 0,
				);
			}
			$mp[$row->kode_mp]->jml += 1;
			$events[] = array(
				'title' => '',
				'start' => $row->batas_tgl_kumpul,
				'end' => $row->batas_tgl_kumpul,
				'url' => site_url(PAGE_ID.'/'.my_base64_encode($row->kode_mp).'/'.$row->id_tugas),
				'className' => 'fc-event-danger',
			);
		}
	?>

	<ul class="list-group">
		<?php
			foreach($mp as $kode_mp=>$row)
			{
				echo '<li><a class="list-group-item" href="'.site_url(PAGE_ID.'/'.my_base64_encode($row->kode_mp)).'"><span class="badge badge-danger">'.$row->jml.'</span>'.$row->nama_mp.'</a></li>';
			}
		?>
	</ul>

	<div class="row margin-t-20">
		<div class="col-md-12">
			<a href="<?php echo site_url(PAGE_ID.'/all')?>" class="btn btn-default fullwidth"> <i class="fa fa-flask margin-r-5"></i> Semua Mapel</a>
		</div>
	</div>

</aside>

<div class="tray tray-center">
	<div id='calendar' class="admin-theme"></div>
</div>

[section name="plugin-css"]
[/section]

[section name="css"]
<style>
	.list-group li{
		list-style: none;
	}
	.list-group li a{
		color: #000;
	}
	.list-group li a:hover,
	.list-group li a:focus{
		background:#ffffff;
	}
	.fullwidth{
		width: 100%
	}
</style>
[/section]

[section name="plugin-js"]
<script src="<?php echo base_url('assets/admin-tools/admin-forms/js/jquery-ui-monthpicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-tools/admin-forms/js/jquery-ui-datepicker.min.js') ?>"></script>
<script src='<?php echo base_url('assets/vendor/plugins/fullcalendar/lib/moment.min.js') ?>'></script>
<script src='<?php echo base_url('assets/vendor/plugins/fullcalendar/fullcalendar.min.js') ?>'></script>
[/section]

[section name="js"]
<script>
	jQuery(document).ready(function() {
		$('body').addClass('calendar-page');
		$('#content').addClass('table-layout');

		var Calendar = $('#calendar');
		var Picker = $('.inline-mp');

		// Init FullCalendar Plugin
		Calendar.fullCalendar({
			header: {
				//left: 'month,agendaWeek,agendaDay',
				//center: 'month,agendaWeek,agendaDay',
				//right: 'title'
			},
			editable: false,
			droppable: false,
			timeFormat: 'H:mm',
			events: <?php echo json_encode($events); ?>,
			viewRender: function(view) {
        if (Picker.hasClass('hasMonthpicker')) {
          var selectedDate = Calendar.fullCalendar('getDate');
          var formatted = moment(selectedDate, 'MM-DD-YYYY').format('MM/YY');
          Picker.monthpicker("setDate", formatted);
        }
        var titleContainer = $('.fc-title-clone');
        if (!titleContainer.length) {
          return;
        }
        titleContainer.html(view.title);
      },

		});

		Picker.monthpicker({
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>',
			showButtonPanel: false,
			onSelect: function(selectedDate) {
				var formatted = moment(selectedDate, 'MM/YYYY').format('MM/DD/YYYY');
				Calendar.fullCalendar('gotoDate', formatted)
			}
		});



	});
</script>
[/section]
