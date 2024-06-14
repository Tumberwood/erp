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
</script>