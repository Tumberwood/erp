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
                    }
                }
            } );
            
        }
    };
</script>