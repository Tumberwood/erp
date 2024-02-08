<script>

    function isIumxxmhBeliUpdate(table_name, id_transaksi_h, id_transaksi_default,tblname){
        $.ajax( {
            url: "../../models/iimxxmh/iimummd_fn_is_iumxxmh_beli.php",
            dataType: 'json',
            type: 'POST',
            data: {
                table_name           : table_name,
                id_transaksi_h       : id_transaksi_h,
                id_transaksi_default : id_transaksi_default
            },
            success: function ( json ) {
                tblname.ajax.reload(null, false);
            }
        } );
    }

    function isIumxxmhJualUpdate(table_name, id_transaksi_h, id_transaksi_default,tblname){
        $.ajax( {
            url: "../../models/iimxxmh/iimummd_fn_is_iumxxmh_jual.php",
            dataType: 'json',
            type: 'POST',
            data: {
                table_name           : table_name,
                id_transaksi_h       : id_transaksi_h,
                id_transaksi_default : id_transaksi_default
            },
            success: function ( json ) {
                tblname.ajax.reload(null, false);
            }
        } );
    }
</script>