<script>
    function getUrutan (){
        $.ajax( {
            url: "../../models/gfrxxth/gfrxxth_fn_urutan.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_gfrxxth: id_gfrxxth,
            },
            success: function ( json ) {
                edtgfrfltd.field('gfrfltd.urutan').fieldInfo('Urutan terkahir: '+json.data.rs_gfrxxth.urutan_max);
            }
        } );
    };
</script>