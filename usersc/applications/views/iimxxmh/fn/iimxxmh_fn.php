<script>
    function cekUoMDefault(id_iimxxmh){
        $.ajax( {
            url: "../../models/iimxxmh/iimxxmh_uom_default.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh
            },
            success: function ( json ) {
                c_id = json.data.c_id;
            }
        } );
    }
    
</script>