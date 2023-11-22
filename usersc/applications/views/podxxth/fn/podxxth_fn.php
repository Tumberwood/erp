<script>
    function validasiDiskon(edt, tabel) {
        diskon_value = edt.field(tabel+'.diskon_value').val();
        if(diskon_value != ''){
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
        if(diskon_persen != ''){
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
</script>