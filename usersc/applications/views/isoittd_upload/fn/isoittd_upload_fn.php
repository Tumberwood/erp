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
</script>