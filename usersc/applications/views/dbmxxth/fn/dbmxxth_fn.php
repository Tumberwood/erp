<script>
    function revisionNumber(id_iimxxmh){
        $.ajax( {
            url: "../../models/dbmxxth/dbmxxth_fn_count.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh
            },
            success: function ( json ) {
                c_id = json.data.c_id;
				edtdbmxxth.field('dbmxxth.revisi_ke').val(c_id);
            }
        } );
    }
</script>