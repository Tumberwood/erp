<script>
    /**
     * Digunakan untuk mendapatkan data wroiitd
     */
    function wreittd_fn_wroiitd(id_wroxxth,id_iimxxmh){
        if(id_wroxxth > 0 && id_iimxxmh > 0){
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_wroiitd.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_wroxxth: id_wroxxth,
                    id_iimxxmh: id_iimxxmh
                },
                success: function ( json ) {
                    id_wroittd = json.data.rs_loc.id_wroittd;
                    edtwreittd.field('wreittd.id_wroittd').val(id_wroittd);
                }
            } );
        }
    };
    
    function wlpxxmh_kode_validasi (){
        wlpxxmh_kode = edtwreittd.field('wreittd.wlpxxmh_kode').val();
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
                        edtwreittd.field('wreittd.wlpxxmh_kode').error( json.data.message );
                        edtwreittd.field('wreittd.wlpxxmh_kode').val('');
                    }
                }
            } );
            
        }
    };
    
    function findIdLpn (wlpxxmh_kode){
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_find_id_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    id_wlpxxmh = json.data.id_wlpxxmh;
                    edtwreittd.field('wreittd.id_wlpxxmh').val(id_wlpxxmh);
                    wlpxxmh_kode_validasi ();
                }
            } );
            
        }
    };
    
    function uomReplenishment(id_iimxxmh, id_iumxxmh_unit){
        // cek apakah UoM Replenishment ada
        if (id_iumxxmh_unit > 0 && id_iimxxmh > 0) {
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_uom_replenishment.php",
                dataType: 'json',
                async: false,
                type: 'POST',
                data: {
                    id_iimxxmh: id_iimxxmh,
                    id_iumxxmh_unit: id_iumxxmh_unit,
                },
                success: function ( json ) {
                    id_uom_replenishment = json.data.id_uom_replenishment;
                    kode = json.data.kode;
                    jumlah_unit_replenishment = json.data.jumlah_unit_replenishment;
                    message_replenishment = json.data.message;
                    if(id_uom_replenishment == 0){
						edtwreittd.field('wreittd.id_iimxxmh').error( message_replenishment );
					} else {
                        if(jumlah_unit >  jumlah_unit_replenishment){
                            edtwreittd.field('wreittd.jumlah_unit').error( 'Inputan tidak boleh melebihi jumlah replenishment: '+jumlah_unit_replenishment+' '+kode );
                        }
                    }

                }
            } );
        }
    };

    function validasiOutstanding(edt, tbl_name, id_transaksi, id_transaksi_before, tbl_name_before) {
        jumlah_unit     = edt.field(tbl_name+'.jumlah_unit').val();
        id_iimxxmh      = edt.field(tbl_name+'.id_iimxxmh').val();
        id_iumxxmh_unit = edt.field(tbl_name+'.id_iumxxmh_unit').val();

        $.ajax( {
            url: "../../../helpers/fn_validasi_outstanding.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_transaksi       : id_transaksi,
                id_transaksi_before: id_transaksi_before,
                tbl_name           : tbl_name,
                tbl_name_before    : tbl_name_before,
                jumlah_unit        : jumlah_unit,
                id_iimxxmh         : id_iimxxmh,
                id_iumxxmh_unit    : id_iumxxmh_unit
            },
            success: function (json) {
                jumlah_default_sisa = 'Sisa Maksimal ' + json.data.jumlah_default_sisa + ' ' + json.data.iumxxmh_default_kode;
                if (parseFloat(json.data.jumlah_terkecil_after) > parseFloat(json.data.jumlah_terkecil)) {
                    edt.field(tbl_name+'.jumlah_unit').error( jumlah_default_sisa );
                }
            }

        } );
    }
    
    function autoSelectLoc(id_iwhxxmh){
        if(id_iwhxxmh_select != id_iwhxxmh){
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_location_auto.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_iwhxxmh: id_iwhxxmh,
                },
                success: function ( json ) {
                    id_wloxxmh_old = json.data.rs_loc.id;
                    edtwreittd.field('wreittd.id_wloxxmh').val(id_wloxxmh_old);
                }
            } );
        }
    };
</script>