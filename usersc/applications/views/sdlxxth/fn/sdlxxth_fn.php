<script>
    function sdlittd_fn_sodittd(id_sodxxth,id_iimxxmh){
        if(id_sodxxth > 0 && id_iimxxmh > 0){
            $.ajax( {
                url: "../../models/sdlxxth/sdlittd_fn_sodittd.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_sodxxth: id_sodxxth,
                    id_iimxxmh: id_iimxxmh
                },
                success: function ( json ) {
                    id_sodittd = json.data.rs_sodittd.id_sodittd;
                    edtsdlittd.field('sdlittd.id_sodittd').val(id_sodittd);

                    id_sodxxth = json.data.rs_sodittd.id_sodxxth;
                    edtsdlittd.field('sdlittd.id_sodxxth').val(id_sodxxth);

                    harga_unit = json.data.rs_sodittd.harga_unit;
                    edtsdlittd.field('sdlittd.harga_unit').val(harga_unit);

                    diskon_jenis = json.data.rs_sodittd.diskon_jenis;
                    edtsdlittd.field('sdlittd.diskon_jenis').val(diskon_jenis);

                    diskon_persen = json.data.rs_sodittd.diskon_persen;
                    edtsdlittd.field('sdlittd.diskon_persen').val(diskon_persen);

                    diskon_value = json.data.rs_sodittd.diskon_value;
                    edtsdlittd.field('sdlittd.diskon_value').val(diskon_value);
                    
                }
            } );
        }
    };
</script>