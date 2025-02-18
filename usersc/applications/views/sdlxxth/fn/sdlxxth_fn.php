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

                    //kalau harga select ini sudah ada, maka tidak auto seperti di SO, karena bisa diubah harga.
                    if (harga_unit_select == null) {
                        harga_unit = json.data.rs_sodittd.harga_unit;
                        edtsdlittd.field('sdlittd.harga_unit').val(harga_unit);
                    }
                    
                    //kalau diskon select ini sudah ada, maka tidak auto seperti di SO, karena bisa diubah diskon.
                    if (diskon_jenis_select == null) {
                        diskon_jenis = json.data.rs_sodittd.diskon_jenis;
                        edtsdlittd.field('sdlittd.diskon_jenis').val(diskon_jenis);
    
                        diskon_persen = json.data.rs_sodittd.diskon_persen;
                        edtsdlittd.field('sdlittd.diskon_persen').val(diskon_persen);
    
                        diskon_value = json.data.rs_sodittd.diskon_value;
                        edtsdlittd.field('sdlittd.diskon_value').val(diskon_value);
                    }
                    
                }
            } );
        }
    };

    function validasiInventory(id_iimxxmh, id_iumxxmh_unit, id_iwhxxmh, table_before, id_transaksi_before){
        jumlah_unit = edtsdlittd.field('sdlittd.jumlah_unit').input().inputmask('unmaskedvalue');
        $.ajax( {
            url: "../../models/sdlxxth/sdlxxth_fn_validasi_inventory.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
                id_iwhxxmh: id_iwhxxmh,
                table_before: table_before,
                id_transaksi_before: id_transaksi_before,
                jumlah_unit: jumlah_unit,
            },
            success: function ( json ) {
                if(json.data.status_code == 500){
                    edtsdlittd.field('sdlittd.'+json.data.validasi).error( json.data.full_message );
                }
                
            }
        } );
    };
</script>