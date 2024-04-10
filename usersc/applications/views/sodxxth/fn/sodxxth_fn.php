<script>

    function defaultCurrency() {
        $.ajax( {
            url: "../../models/fcrxxmh/fcrxxmh_fn_default.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                id_def = json.data.id_def;
                nama_def = json.data.nama_def;
            }
        } );
    }

    function sodxxthUpdateFooter() {
        $( '#diskon_final_h' ).html( dtNumberFormat(diskon_final_h)).addClass('text-right text-danger');
        $( '#dpp_final_h' ).html( dtNumberFormat(dpp_final_h)).addClass('text-right');
        $( '#pajak_final_h' ).html( dtNumberFormat(pajak_final_h)).addClass('text-right');
        $( '#grand_total_h' ).html( dtNumberFormat(grand_total_h)).addClass('text-right');
    }

</script>