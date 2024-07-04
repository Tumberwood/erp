<script>

    // highchart
	Highcharts.setOptions({
        credits: {
            enabled: false
        },
	});

    /**
     * load_dashboard_wms_ops_box
     * digunakan untuk load data wms operasional box
     */
    function load_dashboard_wms_ops_box (start_date, end_date){
        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_box.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function ( json ) {
                // console.log(json);
                if(json.data.status_code == 200){
                    // RECEIVE
                    c_lpn_received = json.data.rs_lpn_received.c_lpn_received;
                    avg_receive = parseInt(json.data.rs_avg_activity.avg_wreittd);

                    $('#c_lpn_received').html('Done: '+ c_lpn_received);
                    $('#avg_receive').html('Average: ' + avg_receive + 's');

                    // PUTAWAY
                    c_lpn_putaway = json.data.rs_lpn_putaway.c_lpn_putaway;
                    c_lpn_to_putaway = json.data.rs_lpn_to_putaway.c_lpn_to_putaway;
                    avg_putaway = parseInt(json.data.rs_avg_activity.avg_wptittd);

                    $('#c_lpn_putaway').html('Done: '+ c_lpn_putaway);
                    $('#c_lpn_to_putaway').html('Open: ' + c_lpn_to_putaway);
                    $('#avg_putaway').html('Average: ' + avg_putaway + 's');

                    // PICKING
                    c_lpn_picked = json.data.rs_lpn_picked.c_lpn_picked;
                    c_lpn_to_pick = json.data.rs_lpn_to_pick.c_lpn_to_pick;
                    avg_picking = parseInt(json.data.rs_avg_activity.avg_wpclptd);

                    $('#c_lpn_picked').html('Done: '+ c_lpn_picked);
                    $('#c_lpn_to_pick').html('Open: ' + c_lpn_to_pick);
                    $('#avg_picking').html('Average: ' + avg_picking + 's');
                }
            }
        } );
        
    };

    /**
     * load_dashboard_wms_ops_location_heatmap
     * digunakan untuk load data location heatmap 
     */
    function load_dashboard_wms_ops_location_heatmap (end_date){
        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_location_heatmap.php",
            dataType: 'json',
            type: 'POST',
            data: {
                end_date: end_date
            },
            success: function ( json ) {

                let xcategory = json.data.rs_wloxxmh_rack_name.map(function(row_rack_name) {
                    return row_rack_name.rack_name;
                });

                let ycategory = json.data.rs_wloxxmh_bay_name.map(function(row_bay_name) {
                    return row_bay_name.rack_bay_name;
                });

                let heatmap_data = json.data.rs_wloxxmh_occurance.map(function(item, index) {
                    return [item.rack, item.bay, item.occurance];
                });

                // Substring template helper for the responsive labels
                Highcharts.Templating.helpers.substr = (s, from, length) => s.substr(from, length);

                // Create the chart
                Highcharts.chart('hc_location_heatmap', {

                    chart: {
                        type: 'heatmap',
                        marginTop: 40,
                        marginBottom: 80,
                        plotBorderWidth: 1
                    },


                    title: {
                        text: 'Location Heatmap',
                        style: {
                            fontSize: '1em'
                        }
                    },

                    xAxis: {
                        categories: xcategory
                    },

                    yAxis: {
                        categories: ycategory,
                        title: null,
                        reversed: false
                    },
                    colorAxis: {
                        min: 0,
                        stops: [
                            [0, '#1ab394'], // green
                            [0.5, '#DDDF0D'], // yellow
                            [1, '#DF5353'] // red
                        ]
                    },

                    legend: {
                        align: 'right',
                        layout: 'vertical',
                        margin: 0,
                        verticalAlign: 'top',
                        y: 25,
                        symbolHeight: 280
                    },
                    tooltip: {
                        formatter: function () {
                            // Calculate total value
                            let total = 0;
                            this.series.data.forEach(point => {
                                total += point.value;
                            });

                            // Calculate percentage
                            let percentage = (this.point.value / total * 100).toFixed(2);

                            return '<b>' + this.series.xAxis.categories[this.point.x] + '</b><br>' +
                                'Occurance: <b>' + this.point.value + ' (' + percentage + '%)</b>';
                        }
                    },


                    series: [{
                        name: 'Location Heatmap',
                        borderWidth: 0,
                        data: heatmap_data,
                        dataLabels: {
                            enabled: true,
                            color: '#000000'
                        }
                    }]

                });

            }
        } );
           
    }

    function load_dashboard_wms_ops_location_capacity (end_date){
        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_location_capacity.php",
            dataType: 'json',
            type: 'POST',
            data: {
                end_date: end_date,
                id_iwhxxmh: 1
            },
            success: function ( json ) {

                let kapasitas_max = json.data.rs_wloxxmh.s_kapasitas;
                let kapasitas_terisi = json.data.rs_wloxxmh.c_id_wloxxmh;

                var ticks = [];
                for (var i = 0; i <= kapasitas_max; i += 200) {
                    ticks.push(i);
                }
                if (ticks[ticks.length - 1] !== kapasitas_max) {
                    ticks.push(kapasitas_max);
                }

                Highcharts.chart('hc_location_capacity', {

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false,
                        height: '60%'
                    },

                    title: {
                        text: 'Location Capacity'
                    },

                    pane: {
                        startAngle: -90,
                        endAngle: 89.9,
                        background: null,
                        center: ['50%', '75%'],
                        size: '110%'
                    },

                    // the value axis
                    yAxis: {
                        min: 0,
                        max: kapasitas_max,
                        tickPositions: ticks,
                        tickPixelInterval: 100,
                        tickPosition: 'inside',
                        labels: {
                            distance: 20,
                            style: {
                                fontSize: '14px'
                            }
                        },
                        lineWidth: 0,
                        plotBands: [{
                            from: 0,
                            to: 0.4*kapasitas_max,
                            color: '#1ab394', // green
                            thickness: 20
                        }, {
                            from: 0.4*kapasitas_max,
                            to: 0.6*kapasitas_max,
                            color: '#DDDF0D', // yellow
                            thickness: 20
                        }, {
                            from: 0.6*kapasitas_max,
                            to: kapasitas_max,
                            color: '#DF5353', // red
                            thickness: 20
                        }]
                    },

                    series: [{
                        name: 'Terisi',
                        data: [kapasitas_terisi],
                        tooltip: {
                            valueSuffix: ' Pallet'
                        },
                        dataLabels: {
                            format: '{y} Pallet ('+(kapasitas_terisi/kapasitas_max*100).toFixed(2)+'%)',
                            borderWidth: 0,
                            color: (
                                Highcharts.defaultOptions.title &&
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || '#333333',
                            style: {
                                fontSize: '16px'
                            }
                        },
                        dial: {
                            radius: '80%',
                            backgroundColor: 'gray',
                            baseWidth: 12,
                            baseLength: '0%',
                            rearLength: '0%'
                        },
                        pivot: {
                            backgroundColor: 'gray',
                            radius: 6
                        }

                    }]

                });

                // hc_location_capacity
            }
        } );
    }

    function load_dashboard_wms_ops_man_hours (start_date,end_date){
        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_man_hours.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function ( json ) {

                let xcategory = json.data.rs_man_hours.map(function(row_man_hours) {
                    return row_man_hours.username;
                });

                let s_durasi_jam = json.data.rs_man_hours.map(function(row_man_hours) {
                    return row_man_hours.s_durasi_jam;
                });
                
                Highcharts.chart('hc_man_hours', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Man Hours',
                    },
                    xAxis: {
                        categories: xcategory,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Effective Hours'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' Hours'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            color: '#228cbc' 
                        }
                    },
                    series: [
                        {
                            name: 'Efective Hours',
                            data: s_durasi_jam
                        }
                    ]
                });

            }
        } );
    }
</script>