<script>
    function hitungSkor() {
        // Autofill and assign data
        autofillField('ggshrsh', 1, 'kpi_bobot_target_atas,kpi_bobot_target_bawah');
        let batas_atas = autofillData.kpi_bobot_target_atas;
        let batas_bawah = autofillData.kpi_bobot_target_bawah;
        let batas_selisih = batas_atas - batas_bawah;

        let polarisasi = edthfskptd.field('hfskptd.polarisasi').val();
        let id_hfkobtd = edthfskptd.field('hfskptd.id_hfkobtd').val();
        let realisasi = parseFloat(edthfskptd.field('hfskptd.realisasi').val());
        let bobot_persen = parseFloat(edthfskptd.field('hfskptd.bobot_persen').val()).toFixed(2);
        let target_atas = parseFloat(edthfskptd.field('hfskptd.target_atas').val()).toFixed(2);
        let target_bawah = parseFloat(edthfskptd.field('hfskptd.target_bawah').val()).toFixed(2);

        if (id_hfkobtd > 0 && realisasi >= 0) {
            let pencapaian = 0;

            if (polarisasi == 'Min') {
                if (realisasi <= target_atas) { //5 <= 4 false
                    pencapaian = batas_atas; //100
                } else if (realisasi <= target_bawah) { //5 <= 10 True
                    // ((10-5) / (10 - 4)) * 100 + 0;
                    pencapaian = ((target_bawah - realisasi) / (target_bawah - target_atas)) * batas_selisih + batas_bawah;
                } else {
                    pencapaian = 0;
                }
            } else if (polarisasi == 'Max') {
                if (realisasi >= target_atas) {
                    pencapaian = batas_atas;
                } else if (realisasi >= target_bawah) {
                    pencapaian = ((realisasi - target_bawah) / (target_atas - target_bawah)) * batas_selisih + batas_bawah;
                } else {
                    pencapaian = 0;
                }
            }
            pencapaian = parseFloat(pencapaian).toFixed(2)
            // console.log("pencapaian:",pencapaian);

            let skor = parseFloat((pencapaian * bobot_persen) / 100).toFixed(2); //83.33333333333334 * 50 / 100

            // console.log("Skor Akhir:", skor);
            edthfskptd.field('hfskptd.skor').val(skor);
        } else {
            if (skor_select > 0) {
                edthfskptd.field('hfskptd.skor').val(skor_select);
            } else {
                edthfskptd.field('hfskptd.skor').val('');
            }
        }
    }

</script>