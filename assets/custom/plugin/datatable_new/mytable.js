$.fn.myTable = function(options) 
{
	if (typeof  PAGE_URL == 'undefined') PAGE_URL = '';
	var container = this;
	var datatable = false;
	var settings = $.extend({
		buttons: [
			{text: "<i class='glyphicon glyphicon-refresh'></i>&nbsp; Refresh", action: function ( e, dt, node, config ) {dt.ajax.reload()} }, 
			{extend: "print", text: "<i class='glyphicon glyphicon-print'></i>&nbsp; Print", exportOptions: { columns: ':visible'}}, 
			{extend: "excelHtml5", text: "<i class='glyphicon glyphicon-floppy-save'></i>&nbsp; Excel", exportOptions: { columns: ':visible'}}, 
			{extend: "colvis", text: "<i class='fa glyphicon glyphicon-th'></i>&nbsp; Kolom"},
		],
		language: { processing: "<div class='my-loading'><i class='fa fa-refresh fa-spin margin-r-10'></i>Memuat Data...</div>"}, 
		//responsive: !0,
		order: [[0, "asc"]],
		pageLength: 25,
		ajax: PAGE_URL+"/get_datatable",
		serverSide : true,
		processing : true,
		lengthMenu: [
			[5, 10, 25, 50, 100, -1],
			[5, 10, 25, 50, 100, "All"]
		],
		dom: "<'row'<'col-md-12 text-right'B>> <'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>> r <'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		fnInitComplete: function ( oSettings ) {
			if ($('.tabletool-container').length) $('.tabletool-container').append( this.parents('.dataTables_wrapper').find('.dt-buttons')[0] );
		},
	}, options );
	
	// manipulation param
	if(settings.extraButtons) settings.buttons = settings.extraButtons.concat(settings.buttons);
	if(!settings.columns)
	{
		settings.columns = [];
		this.find('thead').first().find('tr').last().find('th').each(function(){
			settings.columns.push($(this).data());	
		})	
	}
	
	if (!settings.serverSide) delete settings["ajax"];
	this.addClass('myTable');
	
	// set filter index
	$(this).find('tfoot.filter tr:first-child td').each(function(){
		$(this).attr('number', $(this).index());
	})
	
	//set datatable
	datatable = container.dataTable(settings);
	datatable.api().columns().eq( 0 ).each( function ( colIdx ) 
	{
		this.on('keyup change', 'tfoot.filter tr td[number="'+colIdx+'"] input, tfoot.filter tr td[number="'+colIdx+'"] select', function () {
			datatable.api().column( colIdx ).search( this.value ).draw();
		});
	});
	
	
	//set event
	this.on('click', '[data-toggle="delete"]', function()
	{
		var href = $(this).attr('href');
		var title = $(this).parents('.portlet').find('.caption-subject').text();
		bootbox.confirm("Apakah anda yakin menghpus data ini ?", function(o) 
		{ 
			if(o)
			{
				$.ajax({
					url : href,
					method : 'GET',
					error : function(data){$.pnotify({ title: title, text: 'Transaksi gagal diproses: error 500', type: 'error'});},
					success : function(data){
						if(data == 'ok')
						{
							$.pnotify({ title: title, text: 'Data berhasil dihapus', type: 'success'});
							container.refresh();
						}
						else $.pnotify({ title: title, text: 'Data gagal dihapus: error 417', type: 'error'});
					},
				});
			}
			
		})
		return false;
	})
	
	this.on('click', '[data-toggle="ajax"]', function()
	{
		var href = $(this).attr('href');
		var title = $(this).parents('.portlet').find('.caption-subject').text();
		$.ajax({
			url : href,
			method : 'GET',
			error : function(data){$.pnotify({ title: title, text: 'Transaksi gagal diproses: error 500', type: 'error'});},
			success : function(data){
				if(data == 'ok') container.refresh();
				else $.pnotify({ title: title, text: 'Transaksi gagal diproses: error 417', type: 'error'});
			},
		});
		return false;
	})
	
	this.on('click', '[data-toggle="datatable-dropdown"]', function()
	{
		var dropdown = $('.mydropdown', container);
		if(!dropdown.length) container.append('<div class="mydropdown dropdown"></div>');
		dropdown = $('.mydropdown', container);
		$(this).parent().find('ul.dropdown-menu').clone().appendTo( dropdown.empty() );
		
		var ul = dropdown.children()
		var pos = $(this).parent().offset();
		var height = $(this).parent().height()
		
		var pos_left = (pos.left-container.offset().left)+30;
		var width = container.parents('.dataTables_wrapper').width();
		if(pos_left > width) pos_left = pos_left - ((pos_left - width) + 20);
		
		dropdown.css({top: (pos.top-container.offset().top) +(height*2+25), left: pos_left, position:'absolute'}).children('ul').show();
		return false;
	})
	
	// clear dropdown
	$(document).mouseup(function (e)
	{
		var container = $(".mydropdown");
		if (!container.is(e.target) && container.has(e.target).length === 0) container.empty();
	});

	// set property
	this.datatable = datatable;
	this.settings = settings;
	
	// set method
	this.refresh = function(){ 
		return container.datatable.api().ajax.reload(); 
	};
	
	return this;
	
};