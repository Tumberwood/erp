<script>
    function itiittd_fn_itoittd(id_itoxxth,id_iimxxmh){
        if(id_itoxxth > 0 && id_iimxxmh > 0){
            $.ajax( {
                url: "../../models/itixxth/itiittd_fn_itoittd.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_itoxxth: id_itoxxth,
                    id_iimxxmh: id_iimxxmh
                },
                success: function ( json ) {
                    id_itoittd = json.data.rs_itoittd.id_itoittd;
                    edtitiittd.field('itiittd.id_itoittd').val(id_itoittd);
                }
            } );
        }
    };

</script>