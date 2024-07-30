<script>
    function load_dashboard_logistic (){
        $.ajax( {
            url: "../../models/dash_si_gudang/dash_si_gudang.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function ( json ) {
                $('#showing').show();

                c_id_h = json.data.c_id_h;
                $('#ts_in').html(c_id_h)
                c_id_d = json.data.c_id_d;
                $('#item_in').html(c_id_d)

                c_id_h_out = json.data1.c_id_h;
                $('#ts_out').html(c_id_h_out)
                c_id_d_out = json.data1.c_id_d;
                $('#item_out').html(c_id_d_out)
                avg_jumlah = parseFloat(json.data4.avg_jumlah).toFixed(1);
                $('#avg_jumlah').html(avg_jumlah)
            }
        } );
    };
</script>