var Index = function() {

    var dashboardMainChart = null;

    return {

        //main function
        init: function(data) {
            Metronic.addResizeHandler(function() {
                jQuery('.vmaps').each(function() {
                    var map = jQuery(this);
                    map.width(map.parent().width());
                });
            });

            Index.initJQVMAP(data);
        },
                
        initJQVMAP: function(gdpData) {
            var max = 10,
                min = 0,
                cc,
                startColor = [100, 100, 100],
                endColor = [255, 0, 0],
                colors = {},
                hex;
                 
            //find maximum and minimum values
            for (cc in gdpData)
            {
                if (parseFloat(gdpData[cc]) > max)
                {
                    max = parseFloat(gdpData[cc]);
                }
                if (parseFloat(gdpData[cc]) < min)
                {
                    min = parseFloat(gdpData[cc]);
                }
            }
             
            //set colors according to values of GDP
            for (cc in gdpData)
            {
                if (gdpData[cc] > 0)
                {
                    colors[cc] = '#';
                    for (var i = 0; i<3; i++)
                    {
                        hex = Math.round(startColor[i] 
                            + (endColor[i] 
                            - startColor[i])
                            * (gdpData[cc] / (max - min))).toString(16);
                         
                        if (hex.length == 1)
                        {
                            hex = '0'+hex;
                        }
                         
                        colors[cc] += (hex.length == 1 ? '0' : '') + hex;
                    }
                }
            }
            
            if (!jQuery().vectorMap) {
                return;
            }

            var showMap = function(name) {
                jQuery('.vmaps').hide();
                jQuery('#vmap_' + name).show();
                jQuery('#vmap_' + name).vectorMap('set', 'colors', colors);
            }

            var setMap = function(name) {
                var data = {
                    map: 'world_en',
                    backgroundColor: null,
                    borderColor: '#333333',
                    borderOpacity: 0.5,
                    borderWidth: 1,
                    colors: colors,
                    //color:'#006491',
                    enableZoom: true,
                    hoverColor: '#c9dfaf',
                    hoverOpacity: null,
                    values: sample_data,
                    normalizeFunction: 'linear',
                    scaleColors: ['#aaaaaa'],
                    selectedColor: '#c9dfaf',
                    selectedRegion: null,
                    showTooltip: true,
                    onLabelShow: function(event, label, code) {

                    },
                    onRegionOver: function(event, code) {
                        
                    },
                    onRegionClick: function(element, code, region) {
                        
                    }
                };

                data.map = name + '_en';
                var map = jQuery('#vmap_' + name);
                if (!map) {
                    return;
                }
                map.width(map.parent().parent().width());
                map.show();
                map.vectorMap(data);
                map.hide();
            }

            setMap("world");
            setMap("asia");
            showMap("world");
                        
            jQuery('#regional_stat_world').click(function() {
                showMap("world");
            });
            jQuery('#regional_stat_asia').click(function() {
                showMap("asia");
            });
            
            
            
            $('#region_statistics_loading').hide();
            $('#region_statistics_content').show();
        },
    };
}();