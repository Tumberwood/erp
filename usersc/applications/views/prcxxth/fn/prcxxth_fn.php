<script>
    function prcittd_fn_podittd(id_podxxth,id_iimxxmh){
        if(id_podxxth > 0 && id_iimxxmh > 0){
            $.ajax( {
                url: "../../models/prcxxth/prcittd_fn_podittd.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_podxxth: id_podxxth,
                    id_iimxxmh: id_iimxxmh
                },
                success: function ( json ) {
                    id_podittd = json.data.rs_podittd.id_podittd;
                    edtprcittd.field('prcittd.id_podittd').val(id_podittd);

                    id_podxxth = json.data.rs_podittd.id_podxxth;
                    edtprcittd.field('prcittd.id_podxxth').val(id_podxxth);

                    harga_unit = json.data.rs_podittd.harga_unit;
                    edtprcittd.field('prcittd.harga_unit').val(harga_unit);

                    diskon_jenis = json.data.rs_podittd.diskon_jenis;
                    edtprcittd.field('prcittd.diskon_jenis').val(diskon_jenis);

                    diskon_persen = json.data.rs_podittd.diskon_persen;
                    edtprcittd.field('prcittd.diskon_persen').val(diskon_persen);

                    diskon_value = json.data.rs_podittd.diskon_value;
                    edtprcittd.field('prcittd.diskon_value').val(diskon_value);
                    
                }
            } );
        }
    };

    
    function validasiInventory(id_iimxxmh, id_iumxxmh_unit, id_iwhxxmh, table_before, id_transaksi_before){
        jumlah_unit = edtprcittd.field('prcittd.jumlah_unit').input().inputmask('unmaskedvalue');
        jumlah_bom = edtprcittd.field('prcittd.jumlah_bom').val();

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
                jumlah_bom: jumlah_bom,
            },
            success: function ( json ) {
                if(json.data.status_code == 500){
                    edtprcittd.field('prcittd.'+json.data.validasi).error( json.data.full_message );
                }
                
            }
        } );
    };
</script>