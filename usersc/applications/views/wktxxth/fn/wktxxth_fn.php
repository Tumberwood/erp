<script>
    // function outstandingItem() {
    //     id_iimxxmh = edtwktittd.field('wktittd.id_iimxxmh').val();
    //     // autofillField('wdoittd', id_wdoittd, 'jumlah_terkecil_os');
    //     // jumlah_unit = autofillData.jumlah_terkecil_os;
    //     $.ajax( {
    //         url: "../../models/wktxxth/wktxxth_fn_konversi_unit.php",
    //         dataType: 'json',
    //         type: 'POST',
    //         async: false,
    //         data: {
    //             id_iimxxmh: id_iimxxmh,
    //             id_iumxxmh_unit: id_iumxxmh_unit_old,
    //             jumlah_unit: jumlah_unit,
    //         },
    //         success: function ( json ) {
    //             id_iumxxmh_unit = edtwktittd.field('wktittd.id_iumxxmh_unit').val();

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
    
    function cekBelumConfirm() {
        $.ajax( {
            url: "../../models/wktxxth/wktxxth_fn_count_pl.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                c_id = json.data.c_id;

                if (c_id == 0) {
			        window.removeEventListener('beforeunload', confirmLeavePage)
                } else {
                    window.addEventListener('beforeunload', confirmLeavePage);
                }
            }
        } );

    }

    function confirmLeavePage(event) {
        event.preventDefault();
        console.log(c_id);
        toastr["warning"]("Terdapat "+c_id+" Data PL yang sudah di generate namun belum confirm!","WARNING")

    }
    
</script>