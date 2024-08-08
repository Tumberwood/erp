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
                    id_wroittd = json.data.rs_wroittd.id_wroittd;
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
</script>