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
                                // get lokasi putaway
                                wptittd_details = wptittd_details + json.data.iimxxmh_kode + ' - ';
                                wptittd_details = wptittd_details + json.data.iimxxmh_nama + '\n';
                                wptittd_details = wptittd_details + json.data.s_jumlah_unit + ' ';
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
                                        edtwptittd.field('wptittd_details').val(wptittd_details);
                                    }
                                } );
                            }
                        } );
                    }
                }
            } );
            
        }
    };
</script>