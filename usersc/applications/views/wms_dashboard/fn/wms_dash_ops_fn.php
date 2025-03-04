<script>

    /**
     * load_dashboard_wms_ops_box
     * digunakan untuk load data wms operasional box
     */
    function load_dashboard_wms_ops_box (start_date, end_date, id_iwhxxmh){
        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_box.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
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

                    // DISPATCH
                    c_item_to_dispatch = json.data.rs_item_to_dispatch.c_item_to_dispatch;
                    c_item_dispatched = json.data.rs_item_dispatched.c_item_dispatched;
                    avg_dispatch = parseInt(json.data.rs_avg_activity.avg_wdplptd);

                    $('#c_item_dispatched').html('Done: ' + c_item_dispatched);
                    $('#c_item_to_dispatch').html('Open: '+ c_item_to_dispatch);
                    $('#avg_dispatch').html('Average: ' + avg_dispatch + 's');
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
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
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

                let max_s_occurance = json.data.rs_wloxxmh_occurance_max.max_s_occurance;

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
                        // max: max_s_occurance,
                        minColor: '#ffffff',
                        // minColor: '#1ab394', // green for minimum values
                        maxColor: '#DF5353', // red for maximum values
                        stops: [
                            [0, '#ffffff'], // green
                            [0.01, '#1ab394'], // green
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
                        turboThreshold: 0,
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
                id_iwhxxmh: id_iwhxxmh
            },
            success: function ( json ) {

                if(json.data.status_code == 200){
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
                            height: '45%'
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
                }

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
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
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

    function otif(start_date,end_date){
        $('#otif').empty();

        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_on_time_in_fill.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function ( json ) {
                persen_otif = json.data.rs_otif.persen;

                html = `
                <div class="ibox">
                    <div class="ibox-content p-xs">
                        <div class="row vertical-align">
                            <div class="col-9">
                                <h4 class="font-bold ">OTIF</h4>
                            </div>
                        </div>
                        <div class="row vertical-align">
                            <div class="col-9">
                                <h1 class="">${persen_otif}%</h1>
                            </div>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: ${persen_otif}%;" class="progress-bar"></div>
                        </div>
                        <small class="font-bold">On Time In Fill</small>
                    </div>
                </div>
                `;

                $('#otif').html(html);
            }
        } );
    }

    function inboundData(end_date, id_iwhxxmh){
        $('#inbound').empty();
        $('#outbound').empty();
        $('#overflow').empty();
        $('#rework').empty();
        $('#transit').empty();
        $('#drop').empty();
        $('#return').empty();

        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_count_inbound.php",
            dataType: 'json',
            type: 'POST',
            data: {
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function ( json ) {
                //inbound
                c_inbound = json.data.rs_inbound.c_inbound;

                html_inbound = `
                <div class="ibox">
                    <div class="ibox-content bg-primary p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Inbound</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_inbound}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#inbound').html(html_inbound);

                //outbound
                c_outbound = json.data.rs_outbound.c_outbound;

                html_outbound = `
                <div class="ibox">
                    <div class="ibox-content bg-danger p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Outbound</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_outbound}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#outbound').html(html_outbound);

                //overflow
                c_overflow = json.data.rs_overflow.c_overflow;

                html_overflow = `
                <div class="ibox">
                    <div class="ibox-content bg-warning p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Overflow</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_overflow}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#overflow').html(html_overflow);

                //rework
                c_rework = json.data.rs_rework.c_rework;

                html_rework = `
                <div class="ibox">
                    <div class="ibox-content bg-warning p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Rework</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_rework}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#rework').html(html_rework);

                //transit
                c_transit = json.data.rs_transit.c_transit;

                html_transit = `
                <div class="ibox">
                    <div class="ibox-content bg-danger p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Transit Out</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_transit}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#transit').html(html_transit);

                //drop
                c_drop = json.data.rs_drop.c_drop;

                html_drop = `
                <div class="ibox">
                    <div class="ibox-content bg-primary p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Drop</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_drop}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#drop').html(html_drop);

                //return
                c_return = json.data.rs_return.c_return;

                html_return = `
                <div class="ibox">
                    <div class="ibox-content bg-warning p-xs">
                        <div class="row vertical-align">
                            <div class="col-6">
                                <h3 class="font-bold ">Return</h3>
                            </div>
                            <div class="col-6">
                                <h1 class="text-right font-bold">${c_return}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#return').html(html_return);
            }
        } );
    }
    
    function averageInventory(start_date,end_date,id_iwhxxmh){
        $('#average_inventory').empty();

        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_average_inventory.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function ( json ) {
                average = json.data.average;

                html = `
                <div class="ibox" data-toggle="tooltip" data-placement="top" title="Rumus: ( stok per awal periode + stok per akhir periode ) / 2">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-center font-bold">Average Inventory</h6>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="font-bold text-center">${average}</h4>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                `;

                $('#average_inventory').html(html);
                $('[data-toggle="tooltip"]').tooltip();
            }
        } );
    }
    
    function inventoryTurnover(start_date,end_date,id_iwhxxmh){
        $('#inventory_turnover').empty();

        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_inventory_turnover.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function ( json ) {
                invetory_turnover = json.data.invetory_turnover;

                html = `
                <div class="ibox" data-toggle="tooltip" data-placement="top" title="Rumus: SUM jumlah_terkecil delivery note / Average Inventory">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-center font-bold">Inventory Turnover</h6>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="font-bold text-center">${invetory_turnover}</h4>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                `;

                $('#inventory_turnover').html(html);
                $('[data-toggle="tooltip"]').tooltip();
            }
        } );
    }

    function paretoChart(start_date,end_date,id_iwhxxmh){
        
        $.ajax( {
            url: "../../models/wms_dashboard/wms_dash_ops_fn_pareto.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function ( json ) {
                categories = json.data.categories;
                data_delivery = json.data.data_delivery;
                data_kumulatif = json.data.data_kumulatif;

                Highcharts.chart('container', {
                    chart: { 
                        zoomType: 'xy'    
                    },
                    title: { text: 'Pareto Analysis - ABC Categorization' },
                    xAxis: { categories: categories},
                    yAxis: [
                        { 
                            title: { text: 'Delivery' }
                        }, 
                        { 
                            title: { text: 'Cumulative Percentage' },
                            opposite: true,
                            max: 100
                        }
                    ],
                    tooltip: { shared: true },
                    series: [{
                        type: 'column',
                        name: 'Delivery',
                        data: data_delivery,
                        color: '#007bff'
                    }, {
                        type: 'spline',
                        name: 'Cumulative %',
                        data: data_kumulatif,
                        yAxis: 1,
                        color: 'red',
                        marker: { enabled: true }
                    }],
                    plotOptions: {
                        column: { dataLabels: { enabled: true } }
                    }
                });
            }
        } );
    }
</script>