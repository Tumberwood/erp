<script>
    function hasil(hasil_line1, hasil_line2, hasil_line3, id_hrctstd_disc) {
        
        $.ajax({
            url: '../../models/hrctstd_disc/fn_hasil_akhir.php',
            dataType: 'json',
            type: 'POST',
            data: {
                id_hrctstd_disc: id_hrctstd_disc,
                hasil_line1: hasil_line1,
                hasil_line2: hasil_line2,
                hasil_line3: hasil_line3
            },
            success: function (json) {
                //LINE 1
                var content_line1 = '<h4>' + json.rs_line1.subtitle + '</h4><br>';
            
                for (var i = 1; i <= 12; i++) {
                    if (json.rs_line1['sifat' + i] != 0 && json.rs_line1['sifat' + i] != undefined && json.rs_line1['sifat' + i] != '') {
                        content_line1 += '<p>' + i + '. ' + json.rs_line1['sifat' + i] + '</p>';
                    }
                }

                $('#data-line1').html(content_line1);

                //LINE 2
                var content_line2 = '<h4>' + json.rs_line2.subtitle + '</h4><br>';
            
                for (var i = 1; i <= 12; i++) {
                    if (json.rs_line2['sifat' + i] != 0 && json.rs_line2['sifat' + i] != undefined && json.rs_line2['sifat' + i] != '') {
                        content_line2 += '<p>' + i + '. ' + json.rs_line2['sifat' + i] + '</p>';
                    }
                }

                $('#data-line2').html(content_line2);

                //LINE 3
                var content_line3 = '<h4>' + json.rs_line3.subtitle + '</h4><br>';
            
                for (var i = 1; i <= 12; i++) {
                    if (json.rs_line3['sifat' + i] != 0 && json.rs_line3['sifat' + i] != undefined && json.rs_line3['sifat' + i] != '') {
                        content_line3 += '<p>' + i + '. ' + json.rs_line3['sifat' + i] + '</p>';
                    }
                }

                $('#data-line3').html(content_line3);

                //Keterangan dan Pekejaan
                var job = '<h4>' + json.rs_line3.job + '</h4><br>';
                $('#data-job').html(job);

                var keterangan = '<h4>' + json.rs_line3.keterangan + '</h4><br>';
                $('#data-keterangan').html(keterangan);
            }
        });
    }
</script>