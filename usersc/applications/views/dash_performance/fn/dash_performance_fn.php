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
    
    function chartSkor(start_date) {
        $.ajax( {
            url: "../../models/dash_performance/dash_performance_fn_skor.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                start_date: start_date,
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

    

</script>