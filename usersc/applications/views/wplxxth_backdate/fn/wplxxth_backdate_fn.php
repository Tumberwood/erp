<script>
    function cekBelumConfirm() {
        $.ajax( {
            url: "../../models/wplxxth/wplxxth_fn_count_pl.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                c_id = json.data.c_id;

                if (c_id == 0) {
			        window.removeEventListener('beforeunload', confirmLeavePage)
                } else {
                    window.addEventListener('beforeunload', confirmLeavePage);
                }
            }
        } );

    }

    function confirmLeavePage(event) {
        event.preventDefault();
        console.log(c_id);
        toastr["warning"]("Terdapat "+c_id+" Data PL yang sudah di generate namun belum confirm!","WARNING")

    }

    function wlpxxmh_kode_validasi (){
        wlpxxmh_kode = edtwpllptd.field('wpllptd.wlpxxmh_kode').val();
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        edtwpllptd.field('wpllptd.wlpxxmh_kode').error( json.data.message );
                        edtwpllptd.field('wpllptd.wlpxxmh_kode').val('');
                    }
                }
            } );
            
        }
    };
    
    function konversiJumlah(id_iimxxmh, id_iumxxmh_unit){
        $.ajax( {
            url: "../../models/wktxxth/wktxxth_backdate_konversi_jumlah.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
            },
            success: function ( json ) {
                jumlah_konversi = json.data.jumlah_konversi;
            }
        } );
    };
    
</script>