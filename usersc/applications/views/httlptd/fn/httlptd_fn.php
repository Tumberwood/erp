<script>
    function hariKerja(id_hemxxmh, tanggal_awal, tanggal_akhir) {
        var c_jadwal = 0;
        
        $.ajax({
            url: "../../models/httlptd/httlptd_hari_kerja.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_hemxxmh: id_hemxxmh,
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir,
            },
            success: function(json) {
                c_jadwal = json.data.c_jadwal;  
                console.log(c_jadwal);  
            }
        });
        
        return c_jadwal; 
    }

</script>