<script>
    function totalDetail(edt, tabel){
        harga_unit = parseFloat(edt.field(tabel+'.harga_unit').val());
        jumlah_unit = parseFloat(edt.field(tabel+'.jumlah_unit').val());

        var subtotal = (jumlah_unit * harga_unit).toFixed(2);
        edt.field(tabel+'.subtotal').val(subtotal);
        edt.field(tabel+'.dpp').val(subtotal);
    }

    function hitungDiskon(edt, tabel){
        diskon_value = parseFloat(edt.field(tabel+'.diskon_value').val());
        diskon_persen = parseFloat(edt.field(tabel+'.diskon_persen').val());
        is_diskon_persen = parseFloat(edt.field(tabel+'.is_diskon_persen').val());
        subtotal = parseFloat(edt.field(tabel+'.subtotal').val());
        var diskon_final = 0;

        if (is_diskon_persen == 1) {
            // Diskon Persen
            edt.field(tabel+'.diskon_value').val('')
            edt.field(tabel+'.diskon_final').val('')

            if (diskon_persen > 0) {
                diskon_final = (diskon_persen / 100 * subtotal).toFixed(2);
            }
        } else {
            // Diskon Persen
            edt.field(tabel+'.diskon_persen').val('')
            edt.field(tabel+'.diskon_final').val('')
            
            if (diskon_value > 0) {
                diskon_final = (diskon_value).toFixed(2);
            }
        }
        edt.field(tabel+'.diskon_final').val(diskon_final);

        var dpp = (subtotal - diskon_final).toFixed(2);
        edt.field(tabel+'.dpp').val(dpp);
    }

    function totalHeader(id_transaksi_h, detail, header, is_dpp){
        $.ajax( {
            url: "<?php echo $us_url_root; ?>usersc/helpers/fn_subtotal_header.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_transaksi_h: id_transaksi_h,
                header: header,
                is_dpp: is_dpp,
                detail: detail
            },
            success: function ( json ) {
                $.notify({
                    message: json.message
                },{
                    type: json.type_message
                });
            }
        } );
    }    

    function konversiTerkecil(id_tabel, tabel){
        $.ajax( {
            url: "<?php echo $us_url_root; ?>usersc/helpers/fn_konversi_terkecil.php",
            dataType: 'json',
            type: 'POST',
            data: {
                tabel: tabel,
                id_tabel: id_tabel
            },
            success: function ( json ) {
                // $.notify({
                //     message: json.message
                // },{
                //     type: json.type_message
                // });
            }
        } );
    }    
</script>