var ChartsAmcharts = function() {

    var initChartSample7 = function(data) {
        var chart = AmCharts.makeChart("chart_7", {
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

        
        $('#chart_7').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }

    return {
        //main function to initiate the module

        init: function(data) {
            initChartSample7(data);
        }

    };

}();