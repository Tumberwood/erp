<script>
    function prcittd_fn_podittd(id_podxxth,id_iimxxmh){
        if(id_podxxth > 0 && id_iimxxmh > 0){
            $.ajax( {
                url: "../../models/prcxxth/prcittd_fn_podittd.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_podxxth: id_podxxth,
                    id_iimxxmh: id_iimxxmh
                },
                success: function ( json ) {
                    id_podittd = json.data.rs_podittd.id_podittd;
                    edtprcittd.field('prcittd.id_podittd').val(id_podittd);
                }
            } );
        }
    };
</script>