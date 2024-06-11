<script>
    
    function confirmLeavePage(event) {
        event.preventDefault();
    }

    function wlpxxmh_kode_validasi (){
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wptittd/wptittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        edtwptittd.field('wptittd.wlpxxmh_kode').error( json.data.message );
                    }else{
                        edtwptittd.field('wptittd.wlpxxmh_kode').error('');
                        // is_valid_lpn = 1;
                        let wptittd_details = '';
                        // cek apakah stok di receiving ada yang bisa di putaway
                        $.ajax( {
                            url: "../../models/wptittd/wptittd_fn_iivxxrd.php",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                wlpxxmh_kode: wlpxxmh_kode,
                                uniqueToken: uniqueToken,
                            },
                            success: function ( json ) {
                                id_iimxxmh = json.data.id_iimxxmh;
                                edtwptittd.field('wptittd.id_iimxxmh').val(id_iimxxmh);
                                edtwptittd.field('wptittd.jumlah_unit').val(json.data.sisa_default);
                                id_iumxxmh_unit_old = json.data.id_iumxxmh_default;
                                edtwptittd.field('wptittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);

                                // get lokasi putaway
                                wptittd_details = wptittd_details + json.data.iimxxmh_kode + ' - ';
                                wptittd_details = wptittd_details + json.data.iimxxmh_nama + '\n';
                                wptittd_details = wptittd_details + json.data.s_jumlah_unit + ' ';
                                wptittd_details = wptittd_details + json.data.iumxxmh_default_kode + '\n';
                                wptittd_details = wptittd_details + 'Outstanding: ' + (parseFloat(json.data.sisa_default) + parseFloat(jumlah_unit_old)).toFixed(2) + ' ';
                                wptittd_details = wptittd_details + json.data.iumxxmh_default_kode + '\n';
                                $.ajax( {
                                    url: "../../models/wptittd/wptittd_fn_wloxxmh.php",
                                    dataType: 'json',
                                    type: 'POST',
                                    data: {
                                        wlpxxmh_kode: wlpxxmh_kode,
                                        uniqueToken: uniqueToken,
                                    },
                                    success: function ( json ) {                      
                                        wloxxmh_nama_target = json.data.wloxxmh_nama;
                                        wptittd_details = wptittd_details + json.data.wloxxmh_nama;
                                        id_iwhxxmh = json.data.id_iwhxxmh;
                                        id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                                        id_wloxxmh_asal = json.data.id_wloxxmh_asal;
                                        edtwptittd.field('wptittd.id_iwhxxmh').val(id_iwhxxmh);
                                        edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan);
                                        edtwptittd.field('wptittd.id_wloxxmh_asal').val(id_wloxxmh_asal);
                                        // edtwptittd.field('wptittd_details').val(wptittd_details);
                                        edtwptittd.field('wptittd.keterangan').val(wptittd_details);

                                        
                                        if (id_iimxxmh > 0) {
                                            lpnBooking();
                                            // $('div.DTE_Form_Buttons button:eq(1)').click();
                                        } else {
                                            edtwptittd.field('wptittd.wlpxxmh_kode').error( 'LPN ini tidak ditemukan dalam report inventory!' );
                                        }
                                        
                                        // console.log(is_valid_lpn);
                                        if (is_valid_lpn == 1) {
                                            $('div.DTE_Form_Buttons button:eq(1)').hide();
                                            $('div.DTE_Form_Buttons button:eq(2)').show();
                                            
                                            edtwptittd.field('wptittd.wlpxxmh_kode').disable();
                                            edtwptittd.field('wptittd.id_iumxxmh_unit').show();
                                            edtwptittd.field('wptittd.keterangan').show();
                                            edtwptittd.field('wptittd.jumlah_unit').show();
                                            edtwptittd.field('wptittd.jumlah_unit').focus();

                                            // console.log('uniqueToken load' +uniqueToken);
                                            booking(1);
                                        }
                                    }
                                } );
                            }
                        } );
                    }
                }
            } );
            
        }
    };

    function outstandingItem() {
        $.ajax( {
            url: "../../models/wptittd/wptittd_fn_iivxxrd.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                wlpxxmh_kode: wlpxxmh_kode,
                uniqueToken: uniqueToken,
            },
            success: function ( json ) {
                jumlah_unit = json.data.sisa_default;
                hitungKonversi();
            }
        } );
    }
    
    function hitungKonversi() {
        id_iimxxmh = edtwptittd.field('wptittd.id_iimxxmh').val();

        $.ajax( {
            url: "../../models/wptittd/wptittd_fn_konversi_unit.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit_old,
                jumlah_unit: jumlah_unit,
            },
            success: function ( json ) {
                id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();

                id_iumxxmh_terkecil = json.data.id_iumxxmh_terkecil;
                id_iumxxmh_default = json.data.id_iumxxmh_default;
                // console.log(id_iumxxmh_terkecil);

                if (id_iumxxmh_unit == id_iumxxmh_terkecil) {
                    //terkecil tidak mungkin decimal atau 1,99
                    sisa = Math.round(json.data.jumlah_terkecil);
                    // console.log('terkecil');
                    // console.log(sisa);
                } else if (id_iumxxmh_unit == id_iumxxmh_default) {
                    sisa = parseFloat(json.data.jumlah_default).toFixed(2);
                    // console.log('def');
                    // console.log(sisa);
                } else {
                    sisa = json.data.jumlah_konversi;
                    // console.log('konv');
                    // console.log(sisa);
                }
            }
        } );
    }

    function generateUniqueToken() {
        var timestamp = new Date().getTime().toString(36);
        var randomString = Math.random().toString(36).substring(2);
        return timestamp + randomString;
    }

    function booking(state) {
        wlpxxmh_kode = edtwptittd.field('wptittd.wlpxxmh_kode').val();
        id_iimxxmh = edtwptittd.field('wptittd.id_iimxxmh').val();
        id_iwhxxmh = edtwptittd.field('wptittd.id_iwhxxmh').val();
        id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();
        jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();
        id_wloxxmh_asal = edtwptittd.field('wptittd.id_wloxxmh_asal').val();
        id_wloxxmh_tujuan = edtwptittd.field('wptittd.id_wloxxmh_tujuan').val();
        // console.log("state = "+state);

        $.ajax( {
            url: "../../models/wptittd/wptittd_iivxxrd_booking.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                keterangan: uniqueToken,
                id_iumxxmh_unit: id_iumxxmh_unit,
                wlpxxmh_kode: wlpxxmh_kode,
                jumlah_unit: jumlah_unit,
                id_wloxxmh_asal: id_wloxxmh_asal,
                id_wloxxmh_tujuan: id_wloxxmh_tujuan,
                id_iimxxmh: id_iimxxmh,
                id_iwhxxmh: id_iwhxxmh,
                state: state,
            },
            success: function ( json ) {
                // console.log('oke');
            }
        } );
    }

    function lpnBooking() {
        $.ajax( {
            url: "../../models/wptittd/wptittd_lpn_booking.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                wlpxxmh_kode: wlpxxmh_kode
            },
            success: function ( json ) {
                c_id = json.data.c_id;
                // console.log('ajax c_id = '+c_id);
                
                if (c_id > 0) {
                    edtwptittd.field('wptittd.wlpxxmh_kode').error( 'LPN ini sedang dipakai oleh user lain!' );
                } else {
                    outstandingItem();
                    if (sisa == 0) {
                        edtwptittd.field('wptittd.wlpxxmh_kode').error( 'LPN ini sudah habis terpakai!' );
                    } else {
                        edtwptittd.field('wptittd.wlpxxmh_kode').error('');
                        is_valid_lpn = 1;
                    }
                }
            }
        } );
    }

    function validasiLocation() {
        wloxxmh_nama_scan = edtwptittd.field('wloxxmh_nama_scan').val();

        $.ajax( {
            url: "../../models/wptittd/wptittd_fn_location_setting.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                wloxxmh_nama_scan: wloxxmh_nama_scan,
                wlpxxmh_kode: wlpxxmh_kode,
            },
            success: function ( json ) {
                id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                // console.log(id_wloxxmh_tujuan);

                //ini code jika is_ganti_lokasi_putaway == 1
                //cek apakah lokasi yang discan sama dengan yang di detail/keterangan
                if(wloxxmh_nama_scan != wloxxmh_nama_target){
                    //jika tidak sama maka akan ada confirm

                        if(id_wloxxmh_tujuan == 0){
                            edtwptittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
                            edtwptittd.field('wloxxmh_nama_scan').val('');
                            // console.log('xx');
                        }else{
                            const confirm_loc = confirm('Apakah anda ingin mengganti lokasi simpan?');
                            if (confirm_loc) {
                                edtwptittd.field('wloxxmh_nama_scan').error( '' );
                                // console.log('lokasi ok');
                                edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan);     
                            } else {
                                edtwptittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
                                edtwptittd.field('wloxxmh_nama_scan').val('');
                                // console.log('xx');
                            }
                        }
                }else{
                    //meskipun kalo is_ganti_lokasi_putaway == 1 tapi nama scan sesui dengan yang detail maka pakai coding ini untuk OK
                    edtwptittd.field('wloxxmh_nama_scan').error( '' );
                    // console.log('lokasi ok');
                }
            }
        } );
    }

    function updateJson(uniqueToken) {
        var data = {
            keterangan: uniqueToken
        };
        // Convert data to JSON format
        var jsonData = JSON.stringify(data);
        // console.log(jsonData);
        // Send data asynchronously using navigator.sendBeacon
        navigator.sendBeacon('../..//models/wptittd/wptittd_fn_remove_booking.php', jsonData);
    }
</script>