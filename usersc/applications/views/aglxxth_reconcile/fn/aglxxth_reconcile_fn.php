<script>
    function reconcile(id_aglaktd, is_reconcile){
        $.ajax( {
            url: "../../models/aglxxth_reconcile/aglxxth_reconcile_fn_update.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_aglaktd: id_aglaktd,
                is_reconcile: is_reconcile
            },
            success: function ( json ) {
                toastr[json.data.type_message](json.data.message,"INFO");
                tblaglxxth.ajax.reload(null, false);
            }
        } );
    };
</script>