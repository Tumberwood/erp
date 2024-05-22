<script>
    function get_htsxxmh_pengaju (){
        $.ajax( {
            url: "../../models/htscstd/htscstd_fn_jam_shift.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                tanggal: tanggal,
                id_hemxxmh: id_hemxxmh_pengaju
            },
            success: function ( json ) {
                edthtscstd.field('htsxxmh_pengaju_data').val(json.data.rs_htsxxmh.jam_awal + ' - ' + json.data.rs_htsxxmh.jam_akhir);
                edthtscstd.field('htscstd.jam_awal_pengaju').val(json.data.rs_htsxxmh.jam_awal);
                edthtscstd.field('htscstd.jam_akhir_pengaju').val(json.data.rs_htsxxmh.jam_akhir);
                edthtscstd.field('htscstd.jam_awal_istirahat_pengaju').val(json.data.rs_htsxxmh.jam_istirahat_awal);
            }
        } );
    };

    function get_htsxxmh_pengganti (){
        $.ajax( {
            url: "../../models/htscstd/htscstd_fn_jam_shift.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                tanggal: tanggal,
                id_hemxxmh: id_hemxxmh_pengganti
            },
            success: function ( json ) {
                edthtscstd.field('htsxxmh_pengganti_data').val(json.data.rs_htsxxmh.jam_awal + ' - ' + json.data.rs_htsxxmh.jam_akhir);
                edthtscstd.field('htscstd.jam_awal_pengganti').val(json.data.rs_htsxxmh.jam_awal);
                edthtscstd.field('htscstd.jam_akhir_pengganti').val(json.data.rs_htsxxmh.jam_akhir);
                edthtscstd.field('htscstd.jam_awal_istirahat_pengganti').val(json.data.rs_htsxxmh.jam_istirahat_awal);
            }
        } );
    };;
</script>