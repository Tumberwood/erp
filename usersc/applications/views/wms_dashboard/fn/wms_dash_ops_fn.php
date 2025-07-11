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
                average_format = json.data.average_format;

                html = `
                <div class="ibox" data-toggle="tooltip" data-placement="top" title="Rumus: ( stok per awal periode + stok per akhir periode ) / 2">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-center font-bold">Average Inventory</h5>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="font-bold text-center">${average_format}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="font-bold text-center">${average}</h4>
                            </div>
                        </div>
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
                                <h5 class="text-center font-bold">Inventory Turnover</h5>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="font-bold text-center">${invetory_turnover}</h2>
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

                Highcharts.chart('cumulativeDN', {
                    chart: { 
                        zoomType: 'xy'    
                    },
                    title: { text: 'ABC Analysis' },
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

    function location_3d(end_date, id_iwhxxmh){
        const container = document.getElementById('threejs-container');

        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }

        var tooltip_3d = document.getElementById('tooltip_3d');

        var scene = new THREE.Scene();
        scene.background = new THREE.Color(0xf0f0f0);

        var camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 1, 1000);
        camera.position.set(-30, 30, 30);

        var renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        container.appendChild(renderer.domElement);

        // Controls
        var controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.enablePan = true;
        controls.screenSpacePanning = true;
        controls.minDistance = 10;
        controls.maxDistance = 500;
        controls.target.set(10, 0, 30);
        controls.update();

        // Lights
        var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(100, 100, 100);
        scene.add(directionalLight);

        var ambientLight = new THREE.AmbientLight(0x666666);
        scene.add(ambientLight);

        // tooltip_3d & Raycaster
        var raycaster = new THREE.Raycaster();
        var mouse = new THREE.Vector2();
        var interactiveBoxes = [];

        // Floor
        var floorGeometry = new THREE.PlaneGeometry(300, 200);
        var floorMaterial = new THREE.MeshPhongMaterial({ color: 0x6bbb6b });
        var floor = new THREE.Mesh(floorGeometry, floorMaterial);
        floor.rotation.x = -Math.PI / 2;
        scene.add(floor);

        var metalMaterial = new THREE.MeshStandardMaterial({ color: 0x222222, metalness: 0.8, roughness: 0.4 });
        var woodMaterial = new THREE.MeshStandardMaterial({ color: 0xdddddd, metalness: 0.2, roughness: 0.5 });

        var loader = new THREE.FontLoader();
        let font;
        loader.load('https://cdn.jsdelivr.net/npm/three@0.128.0/examples/fonts/helvetiker_regular.typeface.json', loadedFont => {
            font = loadedFont;
            generateRacks();
        });

        function createRackWithSides(x, z, levels, totalBays, depth, rackName, boxDataPerSide) {
            var rackGroup = new THREE.Group();
            var frameThickness = 0.4;
            var frameHeightStep = 3.5;
            var shelfThickness = 0.3;
            var bayWidth = 5;
            var sideWidth = totalBays * bayWidth;
            var rackDepth = depth * 4;
            var rackHeight = (levels) * frameHeightStep;

            var verticalPostGeo = new THREE.BoxGeometry(frameThickness, rackHeight + 0.2, frameThickness);
            for (let b = 0; b <= totalBays; b++) {
                var xOffset = b * bayWidth;
                [0, rackDepth].forEach(d => {
                var postL = new THREE.Mesh(verticalPostGeo, metalMaterial);
                postL.position.set(xOffset, rackHeight / 2, z + d);
                rackGroup.add(postL);

                var postR = new THREE.Mesh(verticalPostGeo, metalMaterial);
                postR.position.set(xOffset, rackHeight / 2, z - d);
                rackGroup.add(postR);
                });
            }

            var barGeo = new THREE.BoxGeometry(bayWidth, frameThickness, frameThickness);
            for (let l = 1; l <= levels; l++) {
                var y = (l - 1) * frameHeightStep;
                for (let b = 0; b < totalBays; b++) {
                var xMid = b * bayWidth + bayWidth / 2;
                [z + rackDepth / 2, z - rackDepth / 2].forEach(posZ => {
                    var bar = new THREE.Mesh(barGeo, metalMaterial);
                    bar.position.set(xMid, y, posZ);
                    rackGroup.add(bar);
                });
                }
            }

            var shelfGeo = new THREE.BoxGeometry(bayWidth - 0.2, shelfThickness, rackDepth - 0.2);
            for (let l = 1; l <= levels; l++) {
                var y = (l - 1) * frameHeightStep + shelfThickness / 2;
                for (let b = 0; b < totalBays; b++) {
                    var xMid = b * bayWidth + bayWidth / 2;

                    // Sisi kiri (L) di z - rackDepth/2
                    var labelL = `${rackName}-${String(l).padStart(2,'0')}-${String(b+1).padStart(2,'0')}-L`;
                    var shelfL = new THREE.Mesh(shelfGeo, woodMaterial);
                    shelfL.position.set(xMid, y, z - rackDepth / 2);
                    shelfL.userData.label = labelL;
                    interactiveBoxes.push(shelfL);
                    rackGroup.add(shelfL);

                    // Sisi kanan (R) di z + rackDepth/2
                    var labelR = `${rackName}-${String(l).padStart(2,'0')}-${String(b+1).padStart(2,'0')}-R`;
                    var shelfR = new THREE.Mesh(shelfGeo, woodMaterial);
                    shelfR.position.set(xMid, y, z + rackDepth / 2);
                    shelfR.userData.label = labelR;
                    interactiveBoxes.push(shelfR);
                    rackGroup.add(shelfR);
                }
            }

            var boxGeo = new THREE.BoxGeometry(4.5, 2.5, 3.5);
            var boxMaterialL = new THREE.MeshStandardMaterial({ color: 0x6b4f2a });
            var boxMaterialR = new THREE.MeshStandardMaterial({ color: 0x7a5c38 });


            var placeBoxes = (side, zOffset, material) => {
                if (!boxDataPerSide[side] || boxDataPerSide[side].length === 0) return;

                boxDataPerSide[side].forEach(boxInfo => {
                    var { nama, is_fill, bay, level } = boxInfo;
                    // console.log('BOX INFO:', nama, 'is_fill:', is_fill);

                    if (is_fill === 0) return;

                    var bayIndex = (bay || 1) - 1;
                    var xPos = bayIndex * bayWidth + bayWidth / 2;
                    var yPos = ((level || 1) - 1) * frameHeightStep + 1.25;

                    var boxMesh = new THREE.Mesh(boxGeo, material);
                    boxMesh.position.set(xPos, yPos, z + zOffset);
                    boxMesh.userData.label = nama || 'Terisi';
                    interactiveBoxes.push(boxMesh);
                    rackGroup.add(boxMesh);
                });
            };

            placeBoxes("L", -rackDepth / 2, boxMaterialL); // kiri
            placeBoxes("R", rackDepth / 2, boxMaterialR);  // kanan

            if (font && rackName) {
                var textGeo = new THREE.TextGeometry(rackName, {
                    font: font,
                    size: 2,
                    height: 0.3
                });
                textGeo.computeBoundingBox();
                var textWidth = textGeo.boundingBox.max.x - textGeo.boundingBox.min.x;
                var textMesh = new THREE.Mesh(textGeo, new THREE.MeshStandardMaterial({ color: 0xFF3333 }));
                textMesh.position.set(sideWidth / 2 - textWidth / 2, rackHeight + 2, z);
                textMesh.rotation.y = -Math.PI / 2;
                rackGroup.add(textMesh);
            }
            
            // Buat rangka besi: beberapa batang memanjang (x) dan melintang (z)
            var barThickness = 0.1;
            var barLengthX = sideWidth;
            var barLengthZ = rackDepth * 2 + 0.2;
            var barSpacing = 1.0; // jarak antar batang

            // Bar memanjang sepanjang X (horizontal)
            for (let i = 0; i <= barLengthZ / barSpacing; i++) {
                var barGeo = new THREE.BoxGeometry(barLengthX, 0.15, barThickness);
                var bar = new THREE.Mesh(barGeo, metalMaterial);
                bar.position.set(sideWidth / 2, rackHeight + 0.15, z - barLengthZ/2 + i * barSpacing);
                rackGroup.add(bar);
            }

            // Bar memanjang sepanjang Z (vertikal)
            for (let i = 0; i <= barLengthX / barSpacing; i++) {
                var barGeo = new THREE.BoxGeometry(barThickness, 0.15, barLengthZ);
                var bar = new THREE.Mesh(barGeo, metalMaterial);
                bar.position.set(i * barSpacing, rackHeight + 0.15, z);
                rackGroup.add(bar);
            }

            rackGroup.position.set(x, 0, 0);
            scene.add(rackGroup);
        }
        
        var rawData = [];
        var rackGrouped = {};

        // Asumsi ada scene, camera, renderer, controls, floor, container, tooltip_3d sudah dibuat sebelumnya

        function groupRackData(data) {
            for (var item of data) {
                var rack = item.rack_name;
                var bay = item.bay;
                var side = item.nama.endsWith('-L') ? 'L' : 'R';
                if (!rackGrouped[rack]) rackGrouped[rack] = {};
                if (!rackGrouped[rack][bay]) rackGrouped[rack][bay] = { L: [], R: [] };
                rackGrouped[rack][bay][side].push(item);
            }
        }

        function generateRacks() {
            let zOffset = 0;
            var spacing = 30; // jarak antar rack vertikal
            let minZ = Infinity;
            let maxZ = -Infinity;
            let maxSideWidth = 0;
            var bayWidth = 5;

            for (var rackName in rackGrouped) {
                var bayData = rackGrouped[rackName];
                var totalBays = Object.keys(bayData).length;
                var boxData = { L: [], R: [] };
                for (var bay in bayData) {
                boxData.L.push(...bayData[bay].L);
                boxData.R.push(...bayData[bay].R);
                }

                var sideWidth = totalBays * bayWidth;
                if (sideWidth > maxSideWidth) maxSideWidth = sideWidth;

                createRackWithSides(0, zOffset, 4, totalBays, 2, `Rack ${rackName}`, boxData, font);

                if (zOffset < minZ) minZ = zOffset;
                if (zOffset > maxZ) maxZ = zOffset;

                zOffset += spacing;
            }

            // Update floor (karpet)
            var carpetLength = maxZ - minZ + spacing;
            var carpetWidth = maxSideWidth + 10;
            floor.geometry.dispose();
            floor.geometry = new THREE.PlaneGeometry(carpetWidth, carpetLength);
            floor.position.set(carpetWidth / 2 - 2.5, 0, (maxZ + minZ) / 2);
        }

        function setupListeners() {
            window.addEventListener('resize', () => {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });

            window.addEventListener('mousemove', (event) => {
                var rect = container.getBoundingClientRect();
                mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
                mouse.y = - ((event.clientY - rect.top) / rect.height) * 2 + 1;

                raycaster.setFromCamera(mouse, camera);
                var intersects = raycaster.intersectObjects(interactiveBoxes);

                if (intersects.length > 0) {
                    var label = intersects[0].object.userData.label;
                    tooltip_3d.style.display = 'block';
                    tooltip_3d.style.left = (event.clientX - rect.left + 10) + 'px';
                    tooltip_3d.style.top = (event.clientY - rect.top + 10) + 'px';
                    tooltip_3d.innerText = label;
                } else {
                    tooltip_3d.style.display = 'none';
                }
            });
        }

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }

        // Panggil ajax dan generate racks
        $.ajax({
            url: "../../models/wms_dashboard/wms_dash_ops_fn_location_3d.php",
            type: "POST",
            dataType: "json",
            data: {
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function(json) {
                const rs_wloxxmh = json.data.rs_wloxxmh;

                // Cek jika data kosong atau bukan array
                if (!Array.isArray(rs_wloxxmh) || rs_wloxxmh.length === 0) {
                    // console.warn('No rack data returned.');
                    return; // stop di sini
                }

                // Bersihkan data lama jika perlu
                interactiveBoxes.length = 0;
                rackGrouped = {};

                // Group data
                groupRackData(rs_wloxxmh);

                // Generate racks
                generateRacks();

                // Setup listener (mouse, resize, dsb)
                setupListeners();

                // Start animation
                animate();
            },
            error: function(xhr, status, err) {
                console.error('AJAX error:', status, err);
            }
        });
    }
</script>