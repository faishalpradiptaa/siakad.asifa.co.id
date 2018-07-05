function initDateRangePicker(){
    $('#daterangepicker2').daterangepicker({
		format: 'DD-MM-YYYY',
		startDate: moment(),
		endDate: moment(),
		minDate: '01/01/2015',
		maxDate: moment(),
		dateLimit: { years: 1 },
		showDropdowns: true,
		showWeekNumbers: true,
		timePicker: false, 
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		   'This Month': [moment().startOf('month'), moment().endOf('month')],
		   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		opens: 'left',
		drops: 'down',
		buttonClasses: ['btn', 'btn-sm'],
		applyClass: 'btn-primary',
		cancelClass: 'btn-default',
		separator: ' to ',
		locale: {
			applyLabel: 'Submit',
			cancelLabel: 'Cancel',
			fromLabel: 'From',
			toLabel: 'To',
			customRangeLabel: 'Custom',
			daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],                
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			firstDay: 1
		}
	}, function(start, end, label) {        
		$('#daterangepicker2 span').html(start.format('DD-MM-YYYY') + ' s/d ' + end.format('DD-MM-YYYY'));
		dateStart = start;
        dateEnd = end;
        getReport(); 
	});
    $('#daterangepicker2 span').html(getdatenow()+' s/d '+getdatenow()); 
}
function getdatenow(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    
    if(dd<10) {
        dd='0'+dd
    } 
    
    if(mm<10) {
        mm='0'+mm
    } 
    
    today = dd+'-'+mm+'-'+yyyy;
    return today;
}

$("#filtr_tipe").change(function(){
    getReport();
})

$('body').on('click', '.portlet > .portlet-title > .actions > .tutup, .portlet .portlet-title > .actions > .buka', function(e) {
    e.preventDefault();
    var el = $(this).closest(".portlet").children(".portlet-body");
    if ($(this).hasClass("tutup")) {
        $(this).removeClass("tutup").addClass("buka");
        $(this).find(".icon-tutup").removeClass("fa-chevron-down").addClass("fa-chevron-up");
        el.slideUp(200);
    } else {
        $(this).removeClass("buka").addClass("tutup");
        $(this).find(".icon-tutup").removeClass("fa-chevron-up").addClass("fa-chevron-down");
        el.slideDown(200);
    }
});

var initMyToolsPortlet = function() {
    $('.portlet > .portlet-title > .actions > .tutup, .portlet > .portlet-title > .tools > .expand').tooltip({
        container: 'body',
        title: 'Collapse/Expand'
    });
    
    $('.portlet > .portlet-title > .actions > .export-excel').tooltip({
        container: 'body',
        title: 'Export to Excel'
    });
}

$(".export-excel").click(function(){
    tableToExcel($(this).attr('target-table'),$(this).attr('target-table'));
})

/* EXPORT EXCELL */
    var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
      return function(table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        window.location.href = uri + base64(format(template, ctx))
      }
    })()

var ChartsAmchartsProv = function() {

    var initChartSampleProv = function(data) {
        var chart = AmCharts.makeChart("chart_prov", {
            "type": "pie",
            "theme": "light",

            "fontFamily": 'Open Sans',
            
            "color":    '#888',
            "minRadius" : 100,
            "dataProvider": data,
            "valueField": "n",
            "titleField": "reg",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "exportConfig": {
                menuItems: [{
                    icon: '/lib/3/images/export.png',
                    format: 'png'
                }]
            }
        });

        
        $('#chart_prov').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }

    return {
        //main function to initiate the module

        init: function(data) {
            initChartSampleProv(data);
        }

    };

}();

var ChartsAmchartsKota = function() {

    var initChartSampleKota = function(data) {
        var chart = AmCharts.makeChart("chart_kota", {
            "type": "pie",
            "theme": "light",

            "fontFamily": 'Open Sans',
            
            "color":    '#888',
            "minRadius" : 100,
            "dataProvider": data,
            "valueField": "n",
            "titleField": "reg",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "exportConfig": {
                menuItems: [{
                    icon: '/lib/3/images/export.png',
                    format: 'png'
                }]
            }
        });

        
        $('#chart_kota').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }

    return {
        //main function to initiate the module

        init: function(data) {
            initChartSampleKota(data);
        }

    };

}();