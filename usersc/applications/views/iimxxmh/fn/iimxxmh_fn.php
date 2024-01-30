<script>
    function defBeliJual (field_name){
        $.ajax( {
            url: '../../../helpers/fn_is_def_beli_jual.php',
            dataType: 'json',
            type: 'POST',
            data: {
                field_name           : field_name,
                id_transaksi_default : id_transaksi_default
            },
            success: function ( json ) {
                edtiimummd.ajax.reload(null, false);
            }
        } );
    };
</script>