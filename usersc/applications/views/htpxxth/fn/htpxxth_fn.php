<script>
    function get_httlpmh (){
        $.ajax( {
            url: "../../models/htpxxth/htpxxth_fn_httlpmh.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_httlpmh: id_httlpmh
            },
            success: function ( json ) {
                jenis_jam = json.data.rs_httlpmh.jenis_jam;
            }
        } );
    };
</script>