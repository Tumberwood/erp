<script>
    function validasiDiskon(edt, tabel) {
        diskon_value = edt.field(tabel+'.diskon_value').val();
        if(diskon_value > 0){
            // validasi min atau max angka
            if(diskon_value <= 0 ){
                edt.field(tabel+'.diskon_value').error( 'Inputan harus > 0' );
            }
            
            // validasi angka
            if(isNaN(diskon_value) ){
                edt.field(tabel+'.diskon_value').error( 'Inputan harus berupa Angka!' );
            }
        }

        diskon_persen = edt.field(tabel+'.diskon_persen').val();
        if(diskon_persen > 0){
            // validasi min atau max angka
            if(diskon_persen <= 0 ){
                edt.field(tabel+'.diskon_persen').error( 'Inputan harus > 0' );
            }
            
            // validasi angka
            if(isNaN(diskon_persen) ){
                edt.field(tabel+'.diskon_persen').error( 'Inputan harus berupa Angka!' );
            }
        }           
    }

    function defaultCurrency() {
        $.ajax( {
            url: "../../models/podxxth/fn_defaultCurrency.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                id_def = json.data.id_def;
                nama_def = json.data.nama_def;
            }
        } );
    }
</script>