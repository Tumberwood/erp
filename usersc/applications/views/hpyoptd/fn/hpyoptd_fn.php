<script>
    function hitung_tanggal_akhir() {
        tanggal_mulai = edthpyopth.field('hpyopth.tanggal_mulai').val();
        tenor = edthpyopth.field('hpyopth.tenor').val();

        akhir = moment(tanggal_mulai).add(tenor, 'month').format('DD MMM YYYY');
        edthpyopth.field('hpyopth.tanggal_akhir').val(akhir);
    }

    function hitung_cicilan() {
        nominal = edthpyopth.field('hpyopth.nominal').val();
        tenor = edthpyopth.field('hpyopth.tenor').val();

        if (tenor > 0) {
            per_bulan = Math.ceil(nominal / tenor / 1000) * 1000;
            if (tenor == 1) {
                cicilan_akhir = 0;
            } else{
                cicilan_akhir = nominal - (per_bulan * (tenor - 1));
            }
        } else {
            per_bulan = 0;
            cicilan_akhir = 0;
        }


        edthpyopth.field('hpyopth.cicilan_per_bulan').val(per_bulan);
        edthpyopth.field('hpyopth.cicilan_terakhir').val(cicilan_akhir);
    }
    
</script>