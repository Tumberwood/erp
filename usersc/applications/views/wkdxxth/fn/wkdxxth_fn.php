<script>
    function cekBelumConfirm() {
        $.ajax( {
            url: "../../models/wkdxxth/wkdxxth_fn_count_pl.php",
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
    
    function cekDonePicking() {
        $.ajax( {
            url: "../../models/wkdxxth/wkdxxth_fn_done_picking.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wkdxxth: id_wkdxxth
            },
            success: function ( json ) {
                c_id = json.data.c_id;
                s_jumlah_unit = json.data.s_jumlah_unit;
                min_jumlah_unit = json.data.min_jumlah_unit;

                if (transaction_state == 9) {
                    tblwkdxxth.button('btnFinalisasi:name').disable();
                } else {
                    if (c_id == 0 && s_jumlah_unit < min_jumlah_unit) {
                        tblwkdxxth.button('btnFinalisasi:name').enable();
                    } else {
                        tblwkdxxth.button('btnFinalisasi:name').disable();
                    }
                }
            }
        } );

    }
    
    function kittingData(id_wlpxxmh) {
        $.ajax( {
            url: "../../models/wkdxxth/wkdxxth_cek_kitting.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wlpxxmh: id_wlpxxmh
            },
            success: function ( json ) {
                id_iimxxmh_kit = json.data.rs_kit.id_iimxxmh;
                iimxxmh_nama_kit = json.data.rs_kit.iimxxmh_nama;
                wlpxxmh_kode_kit = json.data.rs_kit.wlpxxmh_kode;
            }
        } );

    }

    function confirmLeavePage(event) {
        event.preventDefault();
        console.log(c_id);
        toastr["warning"]("Terdapat "+c_id+" Data PL yang sudah di generate namun belum confirm!","WARNING")

    }
    
</script>