<script>
    function cekDetail(){
        $.ajax( {
            url: "../../models/hrremth/hrremth_fn_detail.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                id_hrremth: id_hrremth
            },
            success: function ( json ) {
                c_id = json.data.rs_hrremth.c_id;
            }
        } );
    };

    function getNamaPengaju(){
        $.ajax( {
            url: "../../models/hrremth/hrremth_fn_hemxxmh_pengaju.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            success: function ( json ) {
                namaPengaju = json.data.rs_hrremth.nama;
            }
        } );
    };
</script>