<script>
    // function outstandingItem() {
    //     id_iimxxmh = edtwplittd.field('wplittd.id_iimxxmh').val();
    //     // autofillField('wdoittd', id_wdoittd, 'jumlah_terkecil_os');
    //     // jumlah_unit = autofillData.jumlah_terkecil_os;
    //     $.ajax( {
    //         url: "../../models/wplxxth/wplxxth_fn_konversi_unit.php",
    //         dataType: 'json',
    //         type: 'POST',
    //         async: false,
    //         data: {
    //             id_iimxxmh: id_iimxxmh,
    //             id_iumxxmh_unit: id_iumxxmh_unit_old,
    //             jumlah_unit: jumlah_unit,
    //         },
    //         success: function ( json ) {
    //             id_iumxxmh_unit = edtwplittd.field('wplittd.id_iumxxmh_unit').val();

    //             id_iumxxmh_terkecil = json.data.id_iumxxmh_terkecil;
    //             id_iumxxmh_default = json.data.id_iumxxmh_default;

    //             if (id_iumxxmh_unit == id_iumxxmh_terkecil) {
    //                 //terkecil tidak mungkin decimal atau 1,99
    //                 sisa = Math.round(json.data.jumlah_terkecil);
    //             } else if (id_iumxxmh_unit == id_iumxxmh_default) {
    //                 sisa = parseFloat(json.data.jumlah_default);
    //             } else {
    //                 sisa = json.data.jumlah_konversi;
    //             }
    //             console.log(sisa);
    //         }
    //     } );
    // }
    
    function confirmLeavePage(event) {
        event.preventDefault();
    }
    
</script>