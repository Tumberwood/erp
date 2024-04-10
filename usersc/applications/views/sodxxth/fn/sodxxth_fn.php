<script>

    function sodxxthUpdateFooter() {
        $( '#diskon_final_h' ).html( dtNumberFormat(diskon_final_h)).addClass('text-right text-danger');
        $( '#dpp_final_h' ).html( dtNumberFormat(dpp_final_h)).addClass('text-right');
        $( '#pajak_final_h' ).html( dtNumberFormat(pajak_final_h)).addClass('text-right');
        $( '#grand_total_h' ).html( dtNumberFormat(grand_total_h)).addClass('text-right');
    }

</script>