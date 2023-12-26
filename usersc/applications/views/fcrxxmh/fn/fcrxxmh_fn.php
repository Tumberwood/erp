<script>
    function cekDefault(table_name,id_tabel){
        $.ajax( {
            url: '../../../helpers/fn_is_default_update.php',
            dataType: 'json',
            type: 'POST',
            data: {
                table_name           : table_name,
                id_transaksi_default : id_transaksi_default
            },
            success: function ( json ) {
				tblfcrxxmh.ajax.reload(null, false);
            }
        } );
    }
</script>