<script>
    function podxxthUpdateFooter() {
        $( '#diskon_final_h' ).html( dtNumberFormat(diskon_final_h)).addClass('text-right text-danger');
        $( '#dpp_final_h' ).html( dtNumberFormat(dpp_final_h)).addClass('text-right');
        $( '#pajak_final_h' ).html( dtNumberFormat(pajak_final_h)).addClass('text-right');
        $( '#grand_total_h' ).html( dtNumberFormat(grand_total_h)).addClass('text-right');
    }


    function uomBeliDefault(val){
        $.ajax( {
            url: "../../models/podxxth/podxxth_fn_uom_beli.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                id_iimxxmh: id_iimxxmh,
            },
            success: function ( json ) {
                id_iumxxmh_unit_old = json.data.id_iumxxmh;
			    edtpodittd.field('podittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);
            }
            
        } );
    };
</script>