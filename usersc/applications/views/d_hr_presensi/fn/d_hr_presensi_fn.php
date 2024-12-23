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

    function chartEmpIzin() {
        var optionschartEmpIzin = {
            chart: {
                type: 'column',
                //  marginTop: 10, 
            },
            title: {
                text: 'Karyawan Izin',
                align: 'left'
            },
            // subtitle: {
            //     text:
            //         ''
            //     align: 'left'
            // },
            xAxis: {
                type: 'category',
                crosshair: true,
                accessibility: {
                    description: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            legend: {
                enabled: false 
            },
            tooltip: {
                valueSuffix: ' orang'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                series: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [],
            //ADD BY FERRY 26 AUG 23
            //tambahkan drilldown cukup seperti dibawah ini, TIDAK PERLU menambahkan series didalamnya.
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
            }
        };

        $.ajax( {
            url: "../../models/d_hr_presensi/d_hr_presensi_empIzin.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function ( json ) {
                optionschartEmpIzin.series[0] = json.data.results_emp_izin[1];
              
                // console.log(optionschartEmpIzin.series[0]);

                //isi drilldown dengan variable dari json yang isinya adalah series dan data
                optionschartEmpIzin.drilldown = json.data.results_emp_izin[2];
                // console.log(optionschartEmpIzin.drilldown); 
                // console.log(optionschartEmpIzin); 
                Highcharts.chart('chartEmpIzin', optionschartEmpIzin);
            }
        } );
        
    }
    
    function chartEmpAbsen() {
        var optionschartEmpAbsen = {
            chart: {
                type: 'column',
                //  marginTop: 10, 
            },
            title: {
                text: 'Karyawan Absen',
                align: 'left'
            },
            // subtitle: {
            //     text:
            //         ''
            //     align: 'left'
            // },
            xAxis: {
                type: 'category',
                crosshair: true,
                accessibility: {
                    description: ''
                },
                labels: {
                    style: {
                        whiteSpace: 'nowrap' // fix wrap label biar tidak kebawah add by ferry 25-aug-23
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            legend: {
                enabled: false 
            },
            tooltip: {
                valueSuffix: ' orang'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                series: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [],
            //ADD BY FERRY 26 AUG 23
            //tambahkan drilldown cukup seperti dibawah ini, TIDAK PERLU menambahkan series didalamnya.
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
            }
        };

        $.ajax( {
            url: "../../models/d_hr_presensi/d_hr_presensi_empAbsen.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function ( json ) {
                optionschartEmpAbsen.series[0] = json.data.results_emp_absen[1];
              
                // console.log(optionschartEmpAbsen.series[0]);

                //isi drilldown dengan variable dari json yang isinya adalah series dan data
                optionschartEmpAbsen.drilldown = json.data.results_emp_absen[2];
                // console.log(optionschartEmpAbsen.drilldown); 
                // console.log(optionschartEmpAbsen); 
                Highcharts.chart('chartEmpAbsen', optionschartEmpAbsen);
            }
        } );
        
    }

    

</script>