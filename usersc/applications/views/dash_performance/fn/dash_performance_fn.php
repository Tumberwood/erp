<script>
    /**
     * Untuk load data-data dashboard
     */

    // BEGIN highchart generate options
    Highcharts.setOptions({
        chart: {
            height: 500
        },
        lang: {
            thousandsSep: ','
        },
        colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
        credits: {
			enabled: false
		},
        legend:{
            align: 'center',
            verticalAlign: 'bottom'
        }
    })
    // END highchart generate options
    
    function chartSkor(start_date, end_date) {
        console.log(end_date);
        
        $.ajax( {
            url: "../../models/dash_performance/dash_performance_fn_skor.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success: function ( json ) {
                var avg_skor = json.data.avg_skor;
              
                // Create the Highcharts gauge chart
                Highcharts.chart('chartSkor', {
                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false,
                        height: '80%'
                    },

                    title: {
                        text: 'Company Skor'
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
                        max: 100,  // Assuming the score is from 0 to 100
                        tickPixelInterval: 72,
                        tickPosition: 'inside',
                        tickColor: Highcharts.defaultOptions.chart.backgroundColor || '#FFFFFF',
                        tickLength: 20,
                        tickWidth: 2,
                        minorTickInterval: null,
                        labels: {
                            distance: 20,
                            style: {
                                fontSize: '14px'
                            }
                        },
                        lineWidth: 0,
                        plotBands: [{
                            from: 0,
                            to: 50,
                            color: 'RGB(26,179,148)', // green
                            thickness: 20,
                        }, {
                            from: 50,
                            to: 75,
                            color: 'RGB(221,223,13)', // yellow
                            thickness: 20
                        }, {
                            from: 75,
                            to: 100,
                            color: 'RGB(223,83,83)', // red
                            thickness: 20,
                        }]
                    },

                    series: [{
                        name: 'Score',
                        data: [avg_skor],  // Use the `avg_skor` data from your query result
                        tooltip: {
                            valueSuffix: ' %'
                        },
                        dataLabels: {
                            format: '{y}%',
                            borderWidth: 0,
                            color: '#333333',
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
        } );

    }

    function radar(start_date, end_date) {
        $.ajax({
            url: "../../models/dash_performance/dash_performance_fn_radar.php",
            type: 'POST',
            data: { 
                start_date: start_date,
                end_date: end_date 
            },
            dataType: 'json',
            success: function(json) {
                let categories = [];
                let points = [];

                json.data.rs_skor.forEach(item => {
                    categories.push(item.kode);
                    points.push({
                        y: parseFloat(item.avg_skor),
                        marker: {
                            fillColor: item.color  // Menggunakan properti color dari query
                        }
                    });
                });

                Highcharts.chart('chartRadar', {
                    chart: {
                        polar: true,
                        type: 'line'
                    },

                    title: {
                        text: 'Pencapaian per Perspektif'
                    },

                    pane: {
                        size: '100%'
                    },

                    xAxis: {
                        categories: categories,
                        tickmarkPlacement: 'on',
                        lineWidth: 0
                    },

                    yAxis: {
                        gridLineInterpolation: 'polygon',
                        lineWidth: 0,
                        min: 0,
                        max: 100,
                        tickInterval: 50, // Tick setiap 50 poin
                        plotLines: [{
                            width: 2,
                            zIndex: 5,
                            label: {
                                text: '50',
                                align: 'right',
                                style: {
                                    color: '#FF0000'
                                }
                            }
                        }]
                    },

                    tooltip: {
                        shared: true,
                        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:.2f}%</b><br/>'
                    },

                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },

                    series: [{
                        name: 'Average Score',
                        data: points,
                        pointPlacement: 'on',
                        color: '#80CEE1'  
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                    layout: 'horizontal'
                                },
                                pane: {
                                    size: '70%'
                                }
                            }
                        }]
                    }
                });
            }
        });
    }

    function displayFamilyTree() {
        const container = document.getElementById('familyTreeContainer');
        container.style.textAlign = "center";
         // Center konten di dalam container

        // Tambahkan kelas "mermaid" pada container, jika belum ada
        container.classList.add('mermaid');

        $.ajax( {
            url: "../../models/dash_performance/dash_performance_fn_tree.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                container.textContent = json.data.chart.trim();
                mermaid.init(undefined, container);
            }
        } );
    }

    function iboxPica(start_date, end_date) {
        $.ajax( {
            url: "../../models/dash_performance/dash_performance_fn_pica_ibox.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success: function ( json ) {
                open = json.data.rs_persen.c_open;
                done = json.data.rs_persen.c_done;
                persen_open = json.data.rs_persen.persen_open;
                persen_done = json.data.rs_persen.persen_done;
                c_id = json.data.rs_sisa.c_id;
                
                $('#sisa_belum_pica').html(c_id);
                $('#done_pica').html('Done: '+ done + ' ('+persen_done+'%)');
                $('#open_pica').html('Open: '+ open + ' ('+persen_open+'%)');
            }
        } );
    }
</script>