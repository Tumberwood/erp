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
    
    
    function chartHasilKostik() {
        var optionschartHasilKostik = {
            chart: {
                polar: true
            },
            title: {
                text: 'Grafik Hasil Tes Papi Kostik'
            },
            xAxis: {
                categories: ['N', 'G', 'A', 'L', 'P', 'I', 'T', 'V', 'X', 'S', 'B', 'O', 'R', 'D', 'C', 'Z', 'E', 'K', 'F', 'W']
            },
            yAxis: {
                min: 0
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{y}',
                        style: {
                            fontWeight: 'bold',
                            color: 'black'
                        }
                    }
                }
            },
            series: [],
        };

        $.ajax({
            url: "../../models/hrctstd_kostik/grafik_hasil_kostik.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_hrctstd_kostik: id_hrctstd_kostik,
            },
            success: function (json) {
                optionschartHasilKostik.series[0] = json.data.results_emp_izin[0];
                Highcharts.chart('chartHasilKostik', optionschartHasilKostik);
                
                // Set src of iframe to load the table
                $('#tabelKostik').attr('src', 'tabel_kostik.php?id_hrctstd_kostik=' + id_hrctstd_kostik);
            }
        });
    }

    function resizeIframe(iframe) {
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
    }

</script>