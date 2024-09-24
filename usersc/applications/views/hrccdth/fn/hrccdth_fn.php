<script>
    function dataRequest(id_hrremth){
        $.ajax( {
            url: "../../models/hrccdth/hrccdth_fn_data_request.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                id_hrremth: id_hrremth
            },
            success: function ( json ) {
                hetxxmh_nama = json.data.rs_hrremth.nama;
                edthrcemtd.field('hrcemtd.hetxxmh_nama').val(hetxxmh_nama);
            }
        } );
    };
    function dataKandidat(id_hcdxxmh){
        $.ajax( {
            url: "../../models/hrccdth/hrccdth_fn_data_kandidat.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                id_hcdxxmh: id_hcdxxmh
            },
            success: function ( json ) {
                email_personal = json.data.rs_hrremth.email_personal;
                handphone = json.data.rs_hrremth.handphone;
                edthrcemtd.field('hrcemtd.email').val(email_personal);
                edthrcemtd.field('hrcemtd.handphone').val(handphone);
            }
        } );
    };
</script>