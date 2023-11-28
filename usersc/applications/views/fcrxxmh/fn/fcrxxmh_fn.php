<script>
    function cekDefault(id_tabel){
        $.ajax( {
            url: "../../models/fcrxxmh/fn_cekDefault.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_tabel: id_tabel
            },
            success: function ( json ) {
				tblfcrxxmh.ajax.reload(null, false);
            }
        } );
    }
</script>