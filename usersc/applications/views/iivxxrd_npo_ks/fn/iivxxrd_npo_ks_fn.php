<script>
    function detailText(id_iimxxmh) {
        $.ajax( {
            url: "../../models/iivxxrd_npo_ks/iivxxrd_npo_ks_fn_detail.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                id_iimxxmh: id_iimxxmh
            },
            success: function ( json ) {
                iimxxmh_kode = json.data.rs_iimxxmh.iimxxmh_kode;
                iimxxmh_nama = iimxxmh_kode + " - " + json.data.rs_iimxxmh.iimxxmh_nama;
                iumxxmh_kode = json.data.rs_iimxxmh.iumxxmh_kode;
            }
        } );
    }
</script>