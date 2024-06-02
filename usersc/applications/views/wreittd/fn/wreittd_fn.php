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
</script>