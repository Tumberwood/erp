<script>
    function validasiSameWH() {
        id_iwhxxmh_asal = edtitoxxth.field('itoxxth.id_iwhxxmh_asal').val();
        id_iwhxxmh_tujuan = edtitoxxth.field('itoxxth.id_iwhxxmh_tujuan').val();

        if (id_iwhxxmh_asal == id_iwhxxmh_tujuan) {
            edtitoxxth.field('itoxxth.id_iwhxxmh_asal').error( 'Warehouse Asal Tidak Boleh Sama dengan Warehouse Tujuan!' );
            edtitoxxth.field('itoxxth.id_iwhxxmh_tujuan').error( 'Warehouse Tujuan Tidak Boleh Sama dengan Warehouse Asal!' );
        }
    }

</script>