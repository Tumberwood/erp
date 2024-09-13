<script>
    function harxxth_load_hemxxmh (){
        id_hemxxmh = edtharxxth.field('harxxth.id_hemxxmh').val();
        $.ajax( {
            url: "../../models/harxxth/harxxth_fn_load_hemxxmh.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_hemxxmh: id_hemxxmh
            },
            success: function ( json ) {

                id_hovxxmh = json.data.rs_hemxxmh.id_hovxxmh_awal;
                id_hodxxmh = json.data.rs_hemxxmh.id_hodxxmh_awal;
                id_hosxxmh = json.data.rs_hemxxmh.id_hosxxmh_awal;
                id_hevxxmh = json.data.rs_hemxxmh.id_hevxxmh_awal;
                id_hetxxmh = json.data.rs_hemxxmh.id_hetxxmh_awal;

                if(id_hovxxmh_awal_old == 0){
                    edtharxxth.field('harxxth.id_hovxxmh_awal').val(id_hovxxmh);
                    edtharxxth.field('hovxxmh_awal_nama').val(json.data.rs_hemxxmh.hovxxmh_awal_nama);
                }
                if(id_hodxxmh_awal_old == 0){
                    edtharxxth.field('hodxxmh_awal_nama').val(json.data.rs_hemxxmh.hodxxmh_awal_nama);
                    edtharxxth.field('harxxth.id_hodxxmh_awal').val(id_hodxxmh);
                }
                if(id_hosxxmh_awal_old == 0){
                    edtharxxth.field('hosxxmh_awal_nama').val(json.data.rs_hemxxmh.hosxxmh_awal_nama);
                    edtharxxth.field('harxxth.id_hosxxmh_awal').val(id_hosxxmh);
                }
                if(id_hevxxmh_awal_old == 0){
                    edtharxxth.field('hevxxmh_awal_nama').val(json.data.rs_hemxxmh.hevxxmh_awal_nama);
                    edtharxxth.field('harxxth.id_hevxxmh_awal').val(id_hevxxmh);
                }
                if(id_hetxxmh_awal_old == 0){
                    edtharxxth.field('hetxxmh_awal_nama').val(json.data.rs_hemxxmh.hetxxmh_awal_nama);
                    edtharxxth.field('harxxth.id_hetxxmh_awal').val(id_hetxxmh);
                }
            }
        } );
    };
</script>