<script>
    
    function wlpxxmh_kode_validasi (){
        wlpxxmh_kode = edtwktlptd.field('wktlptd.wlpxxmh_kode').val();
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        edtwktlptd.field('wktlptd.wlpxxmh_kode').error( json.data.message );
                        edtwktlptd.field('wktlptd.wlpxxmh_kode').val('');
                    }
                }
            } );
            
        }
    };
    
    function konversiJumlah(id_iimxxmh, id_iumxxmh_unit){
        $.ajax( {
            url: "../../models/wktxxth/wktxxth_backdate_konversi_jumlah.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
            },
            success: function ( json ) {
                jumlah_konversi = json.data.jumlah_konversi;
            }
        } );
    };

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
    
    function cekDonePicking() {
        $.ajax( {
            url: "../../models/wktxxth/wktxxth_fn_done_picking.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wktxxth: id_wktxxth
            },
            success: function ( json ) {
                c_id = json.data.c_id;
                s_jumlah_unit = json.data.s_jumlah_unit;
                min_jumlah_unit = json.data.min_jumlah_unit;

                if (transaction_state == 9) {
                    tblwktxxth.button('btnFinalisasi:name').disable();
                } else {
                    if (c_id == 0 && s_jumlah_unit < min_jumlah_unit) {
                        tblwktxxth.button('btnFinalisasi:name').enable();
                    } else {
                        tblwktxxth.button('btnFinalisasi:name').disable();
                    }
                }
            }
        } );

    }

    function confirmLeavePage(event) {
        event.preventDefault();
        console.log(c_id);
        toastr["warning"]("Terdapat "+c_id+" Data Kitting yang sudah di generate namun belum confirm!","WARNING")

    }
    
</script>