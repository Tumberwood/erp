<script>
    
    function crfittd_fn_sodittd(id_sodxxth,id_iimxxmh){
        if(id_sodxxth > 0 && id_iimxxmh > 0){
            $.ajax( {
                url: "../../models/crfpxth/crfittd_fn_sodittd.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    id_sodxxth: id_sodxxth,
                    id_iimxxmh: id_iimxxmh
                },
                success: function ( json ) {
                    id_sodittd = json.data.rs_sodittd.id_sodittd;
                    edtcrfittd.field('crfittd.id_sodittd').val(id_sodittd);

                    tanggal_dibutuhkan = json.data.rs_sodittd.tanggal_dibutuhkan;
                    edtcrfittd.field('crfittd.tanggal_dibutuhkan').val(tanggal_dibutuhkan);
                    edtcrfittd.field('crfittd.tanggal_dibutuhkan_customer').val(tanggal_dibutuhkan);

                    id_iumxxmh_unit_old = json.data.rs_sodittd.id_iumxxmh_unit;
                    edtcrfittd.field('crfittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);
                }
            } );
        }
    };
</script>