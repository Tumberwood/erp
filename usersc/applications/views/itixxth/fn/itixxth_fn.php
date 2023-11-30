<script>
    function validasiQty(id_iimxxmh, id_iumxxmh, jumlah_unit) {
        $.ajax( {
            url: "../../models/itixxth/fn_validasi_qty.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                ids_itoxxth: ids_itoxxth,
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh: id_iumxxmh,
                jumlah_unit: jumlah_unit
            },
            success: function ( json ) {
                satuan = json.data.rs_in.satuan;
                terkecil_in = json.data.rs_in.jumlah_terkecil;
                terkecil_out = json.data.rs_out.jumlah_terkecil;
                text = json.data.rs_out.text;
                id_iumxxmh_out = json.data.rs_out.id_iumxxmh;

            }
        } );
    }

    function validasiQty(id_iimxxmh, id_iumxxmh, jumlah_unit) {
        $.ajax( {
            url: "../../models/itixxth/fn_validasi_qty.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                ids_itoxxth: ids_itoxxth,
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh: id_iumxxmh,
                jumlah_unit_old: jumlah_unit_old,
                jumlah_unit: jumlah_unit
            },
            success: function ( json ) {
                satuan = json.data.rs_in.satuan;
                terkecil_in = json.data.rs_in.jumlah_terkecil;
                terkecil_out = json.data.rs_out.jumlah_terkecil_os;
                text = json.data.rs_out.text;
                id_iumxxmh_out = json.data.rs_out.id_iumxxmh;

            }
        } );
    }
</script>