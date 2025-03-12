<script>
    
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

    function hasil(hasil_line1, hasil_line2, hasil_line3, id_hrctstd_disc) {
        
        $.ajax({
            url: '../../models/hrctstd_disc/fn_hasil_akhir.php',
            dataType: 'json',
            type: 'POST',
            data: {
                id_hrctstd_disc: id_hrctstd_disc,
                hasil_line1: hasil_line1,
                hasil_line2: hasil_line2,
                hasil_line3: hasil_line3
            },
            success: function (json) {
                //LINE 1
                var content_line1 = '<h4>' + json.rs_line1.subtitle + '</h4><br>';
            
                for (var i = 1; i <= 12; i++) {
                    if (json.rs_line1['sifat' + i] != 0 && json.rs_line1['sifat' + i] != undefined && json.rs_line1['sifat' + i] != '') {
                        content_line1 += '<p>' + i + '. ' + json.rs_line1['sifat' + i] + '</p>';
                    }
                }

                $('#data-line1').html(content_line1);

                //LINE 2
                var content_line2 = '<h4>' + json.rs_line2.subtitle + '</h4><br>';
            
                for (var i = 1; i <= 12; i++) {
                    if (json.rs_line2['sifat' + i] != 0 && json.rs_line2['sifat' + i] != undefined && json.rs_line2['sifat' + i] != '') {
                        content_line2 += '<p>' + i + '. ' + json.rs_line2['sifat' + i] + '</p>';
                    }
                }

                $('#data-line2').html(content_line2);

                //LINE 3
                var content_line3 = '<h4>' + json.rs_line3.subtitle + '</h4><br>';
            
                for (var i = 1; i <= 12; i++) {
                    if (json.rs_line3['sifat' + i] != 0 && json.rs_line3['sifat' + i] != undefined && json.rs_line3['sifat' + i] != '') {
                        content_line3 += '<p>' + i + '. ' + json.rs_line3['sifat' + i] + '</p>';
                    }
                }

                $('#data-line3').html(content_line3);

                //Keterangan dan Pekejaan
                var job = '<h4>' + json.rs_line3.job + '</h4><br>';
                $('#data-job').html(job);

                var keterangan = '<h4>' + json.rs_line3.keterangan + '</h4><br>';
                $('#data-keterangan').html(keterangan);
                
                let dataGraph1 = [
                    { y: Number(json.rs_graph.d_line1) || 0, color: '#0000ff' },
                    { y: Number(json.rs_graph.i_line1) || 0, color: '#8d0073' },
                    { y: Number(json.rs_graph.s_line1) || 0, color: '#ba0046' },
                    { y: Number(json.rs_graph.c_line1) || 0, color: '#d60028' }
                ];

                Highcharts.chart('graph1', {
                    title: { text: 'GRAPH 1 MOST' },
                    subtitle: { text: 'Mask Public Self' },
                    accessibility: {
                        point: { valueDescriptionFormat: '{xDescription}{separator}{value} million(s)' }
                    },
                    xAxis: {
                        categories: ['D', 'I', 'S', 'C']
                    },
                    yAxis: {
                        type: 'linear',
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br />',
                        pointFormat: '{point.y}'
                    },
                    series: [{
                        name: 'DISC',
                        data: dataGraph1
                    }]
                });
                
                let dataGraph2 = [
                    { y: Number(json.rs_graph.d_line2) || 0, color: '#0000ff' },
                    { y: Number(json.rs_graph.i_line2) || 0, color: '#8d0073' },
                    { y: Number(json.rs_graph.s_line2) || 0, color: '#ba0046' },
                    { y: Number(json.rs_graph.c_line2) || 0, color: '#d60028' }
                ];

                Highcharts.chart('graph2', {
                    title: { text: 'GRAPH 2 LEAST' },
                    subtitle: { text: 'Core Private Self' },
                    accessibility: {
                        point: { valueDescriptionFormat: '{xDescription}{separator}{value} million(s)' }
                    },
                    xAxis: {
                        categories: ['D', 'I', 'S', 'C']
                    },
                    yAxis: {
                        type: 'linear',
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br />',
                        pointFormat: '{point.y}'
                    },
                    series: [{
                        name: 'DISC',
                        data: dataGraph2
                    }]
                });
                
                let dataGraph3 = [
                    { y: Number(json.rs_graph.d_line3) || 0, color: '#0000ff' },
                    { y: Number(json.rs_graph.i_line3) || 0, color: '#8d0073' },
                    { y: Number(json.rs_graph.s_line3) || 0, color: '#ba0046' },
                    { y: Number(json.rs_graph.c_line3) || 0, color: '#d60038' }
                ];

                Highcharts.chart('graph3', {
                    title: { text: 'GRAPH 3 CHANGE' },
                    subtitle: { text: 'Mirror Perceived Self' },
                    accessibility: {
                        point: { valueDescriptionFormat: '{xDescription}{separator}{value} million(s)' }
                    },
                    xAxis: {
                        categories: ['D', 'I', 'S', 'C']
                    },
                    yAxis: {
                        type: 'linear',
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br />',
                        pointFormat: '{point.y}'
                    },
                    series: [{
                        name: 'DISC',
                        data: dataGraph3
                    }]
                });
    
                if ($.fn.dataTable.isDataTable('#tbl_disc')) {
                    $('#tbl_disc').DataTable().clear();
                    $('#tbl_disc').DataTable().destroy();
                    $('#tbl_disc tbody').empty();
                    $('#tbl_disc thead').empty();
                }

                $('#tbl_disc').DataTable({
                    paging: false,
                    searching: false,
                    info: false,
                    lengthChange: false,
                    responsive: false,
                    data: json.rs_table_hasil,
                    columns: [
                        { 
                            title: "Line", 
                            data: null, 
                            render: function (data, type, row, meta) { 
                                return `<span style="font-weight: bold;">${meta.row + 1}</span>`;
                            } 
                        },
                        { title: "D", data: "d" },
                        { title: "I", data: "i" },
                        { title: "S", data: "s" },
                        { title: "C", data: "c" },
                        { title: "*", data: "star", defaultContent: "" },
                        { 
                            title: "Total", 
                            data: "total", 
                            render: function (data, type, row) {
                                return `<span class="text-danger" style="font-weight: bold;">${data ?? ''}</span>`;
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            targets: [1,2,3,4,5,6], ...renderNumber()
                        },
                    ],
                    buttons: [
                        {
                            extend: 'collection',
                            name: 'btnSetTools',
                            text: '<i class="fa fa-wrench"></i>',
                            titleAttr: 'Tools',
                            className: 'btn btn-sm btn-outline',
                            autoClose: true,
                            buttons: [
                                    { 
                                        extend: "copy", 
                                        name: 'btnCopy',
                                        text: '<i class="fa fa-copy"></i>&nbsp;Copy',
                                        className: 'btn btn-sm',
                                        titleAttr: 'Copy',
                                        exportOptions: {
                                            columns: ':visible'
                                        }
                                    },
                                    { 
                                    extend: "excel",
                                    name: 'btnExcel', 
                                    text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                                    className: 'btn btn-sm',
                                    titleAttr: 'Export to Excel',
                                    exportOptions: {
                                        columns: ':visible',
                                    }
                                },
                            ]
                        }
                    ],
                    rowCallback: function( row, data, index ) {
                        if ( data.d != null && data.star == null ) {
                            $('td:eq(5)', row).addClass('bg-dark');
                        }

                        if ( data.d != null && data.total == null ) {
                            $('td:eq(6)', row).addClass('bg-dark');
                        }
                    }
                });

            }
        });
    }
</script>