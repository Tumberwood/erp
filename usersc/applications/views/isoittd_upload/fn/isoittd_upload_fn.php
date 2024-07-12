<script>
    function subtotalFisik (id_transaksi_h){
        $.ajax( {
            url: "../../models/isoittd_upload/fn_subtotal_fisik_selisih.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_transaksi_h: id_transaksi_h
            },
            success: function ( json ) {
                // do nothing
            }
        } );
    };

    function isUploadTransaksi() {
        $.ajax( {
            url: "../../models/isoittd_upload/fn_is_upload_transaksi.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_isoxxth_upload_filter: id_isoxxth_upload_filter
            },
            success: function ( json ) {
                is_update_transaksi_h = json.data.is_update_transaksi_h;
            }
        } );
    }
</script>