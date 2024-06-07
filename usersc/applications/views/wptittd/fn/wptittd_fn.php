<script>
    function wlpxxmh_kode_validasi (){
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wptittd/wptittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        edtwptittd.field('wptittd.wlpxxmh_kode').error( json.data.message );
                    }else{
                        edtwptittd.field('wptittd.wlpxxmh_kode').error('');
                        let wptittd_details = '';
                        // cek apakah stok di receiving ada yang bisa di putaway
                        $.ajax( {
                            url: "../../models/wptittd/wptittd_fn_iivxxrd.php",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                wlpxxmh_kode: wlpxxmh_kode
                            },
                            success: function ( json ) {
                                id_iimxxmh = json.data.id_iimxxmh;
                                edtwptittd.field('wptittd.id_iimxxmh').val(id_iimxxmh);

                                // get lokasi putaway
                                wptittd_details = wptittd_details + json.data.iimxxmh_kode + ' - ';
                                wptittd_details = wptittd_details + json.data.iimxxmh_nama + '\n';
                                wptittd_details = wptittd_details + json.data.s_jumlah_unit + ' ';
                                wptittd_details = wptittd_details + json.data.iumxxmh_unit_kode + '\n';
                                wptittd_details = wptittd_details + 'Outstanding: ' + (parseFloat(json.data.sisa) + parseFloat(jumlah_unit_old)).toFixed(0) + ' ';
                                wptittd_details = wptittd_details + json.data.iumxxmh_unit_kode + '\n';
                                $.ajax( {
                                    url: "../../models/wptittd/wptittd_fn_wloxxmh.php",
                                    dataType: 'json',
                                    type: 'POST',
                                    data: {
                                        wlpxxmh_kode: wlpxxmh_kode
                                    },
                                    success: function ( json ) {                      
                                        wloxxmh_nama_target = json.data.wloxxmh_nama;
                                        wptittd_details = wptittd_details + json.data.wloxxmh_nama;
                                        id_iwhxxmh = json.data.id_iwhxxmh;
                                        id_wloxxmh = json.data.id_wloxxmh;
                                        edtwptittd.field('wptittd.id_iwhxxmh').val(id_iwhxxmh);
                                        edtwptittd.field('wptittd.id_wloxxmh').val(id_wloxxmh);
                                        // edtwptittd.field('wptittd_details').val(wptittd_details);
                                        edtwptittd.field('wptittd.keterangan').val(wptittd_details);
                                    }
                                } );
                            }
                        } );
                    }
                }
            } );
            
        }
    };

    function outstandingItem() {
        $.ajax( {
            url: "../../models/wptittd/wptittd_fn_iivxxrd.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                wlpxxmh_kode: wlpxxmh_kode
            },
            success: function ( json ) {
                sisa = (parseFloat(json.data.sisa) + parseFloat(jumlah_unit_old)).toFixed(0);
            }
        } );
    }
</script>