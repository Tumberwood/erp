<script>
    
    function confirmLeavePage(event) {
        event.preventDefault();
    }

    function wlpxxmh_kode_validasi (){
        id_wloxxmh_asal = edtwtrittd.field('wtrittd.id_wloxxmh_asal').val();
        console.log(id_wloxxmh_asal);
        if(wlpxxmh_kode != "" && id_wloxxmh_asal > 0){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wtrittd/wtrittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').error( json.data.message );
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').val( '' );
                        is_valid_lpn = 0;
                    }else{
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').error('');
                        // is_valid_lpn = 1;
                        let wtrittd_details = '';
                        // cek apakah stok di receiving ada yang bisa di putaway
                        $.ajax( {
                            url: "../../models/wtrittd/wtrittd_fn_iivxxrd.php",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                wlpxxmh_kode: wlpxxmh_kode,
                                id_wloxxmh_asal: id_wloxxmh_asal,
                                uniqueToken: uniqueToken,
                            },
                            success: function ( json ) {
                                id_iimxxmh = json.data.id_iimxxmh;
                                edtwtrittd.field('wtrittd.id_iimxxmh').val(id_iimxxmh);
                                edtwtrittd.field('wtrittd.jumlah_unit').val(parseFloat(json.data.sisa_default));
                                edtwtrittd.field('wtrittd.batch_number').val(json.data.batch_number);
                                edtwtrittd.field('wtrittd.expired_date').val(json.data.expired_date);
                                id_iumxxmh_unit_old = json.data.id_iumxxmh_default;
                                edtwtrittd.field('wtrittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);

                                // get lokasi putaway
                                wtrittd_details = wtrittd_details + json.data.iimxxmh_kode + ' - ';
                                wtrittd_details = wtrittd_details + json.data.iimxxmh_nama + '\n';
                                wtrittd_details = wtrittd_details + parseFloat(json.data.s_jumlah_unit) + ' ';
                                wtrittd_details = wtrittd_details + json.data.iumxxmh_default_kode + '\n';
                                
                                // edtwtrittd.field('wtrittd_details').val(wtrittd_details);
                                edtwtrittd.field('wtrittd.keterangan').val(wtrittd_details);

                                console.log(is_valid_lpn);
                                if (id_iimxxmh > 0) {
                                    lpnBooking();
                                    // $('div.DTE_Form_Buttons button:eq(1)').click();
                                } else {
                                    edtwtrittd.field('wtrittd.wlpxxmh_kode').error( 'LPN ini tidak ditemukan dalam report inventory!' );
                                    is_valid_lpn = 0;
                                }
                                
                                // console.log(is_valid_lpn);
                                if (is_valid_lpn == 1) {
                                    $('div.DTE_Form_Buttons button:eq(1)').hide();
                                    $('div.DTE_Form_Buttons button:eq(2)').show();
                                    
                                    edtwtrittd.field('wloxxmh_nama_asal').disable();
                                    edtwtrittd.field('wtrittd.wlpxxmh_kode').disable();
                                    edtwtrittd.field('wtrittd.id_iumxxmh_unit').show();
                                    edtwtrittd.field('wtrittd.keterangan').show();
                                    edtwtrittd.field('wtrittd.jumlah_unit').show();
                                    edtwtrittd.field('wtrittd.jumlah_unit').focus();

                                    // console.log('uniqueToken load' +uniqueToken);
                                    // setTimeout(function() {
                                    //     booking(1);
                                    // }, 3000);
                                }
                            }
                        } );
                    }
                }
            } );
            
        }
    };

    function outstandingItem() {
        id_wloxxmh_asal = edtwtrittd.field('wtrittd.id_wloxxmh_asal').val();
        $.ajax( {
            url: "../../models/wtrittd/wtrittd_fn_iivxxrd.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wloxxmh_asal: id_wloxxmh_asal,
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
        id_iimxxmh = edtwtrittd.field('wtrittd.id_iimxxmh').val();

        $.ajax( {
            url: "../../models/wtrittd/wtrittd_fn_konversi_unit.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit_old,
                jumlah_unit: jumlah_unit,
            },
            success: function ( json ) {
                id_iumxxmh_unit = edtwtrittd.field('wtrittd.id_iumxxmh_unit').val();

                id_iumxxmh_terkecil = json.data.id_iumxxmh_terkecil;
                id_iumxxmh_default = json.data.id_iumxxmh_default;
                // console.log(id_iumxxmh_terkecil);

                if (id_iumxxmh_unit == id_iumxxmh_terkecil) {
                    //terkecil tidak mungkin decimal atau 1,99
                    sisa = Math.round(json.data.jumlah_terkecil);
                    // console.log('terkecil');
                    // console.log(sisa);
                } else if (id_iumxxmh_unit == id_iumxxmh_default) {
                    sisa = parseFloat(json.data.jumlah_default);
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
        wlpxxmh_kode = edtwtrittd.field('wtrittd.wlpxxmh_kode').val();
        id_iimxxmh = edtwtrittd.field('wtrittd.id_iimxxmh').val();
        id_iwhxxmh = edtwtrittd.field('wtrittd.id_iwhxxmh').val();
        id_iumxxmh_unit = edtwtrittd.field('wtrittd.id_iumxxmh_unit').val();
        jumlah_unit = edtwtrittd.field('wtrittd.jumlah_unit').val();
        id_wloxxmh_asal = edtwtrittd.field('wtrittd.id_wloxxmh_asal').val();
        id_wloxxmh_tujuan = edtwtrittd.field('wtrittd.id_wloxxmh_tujuan').val();
        // console.log("state = "+state);

        $.ajax( {
            url: "../../models/wtrittd/wtrittd_iivxxrd_booking.php",
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
            url: "../../models/wtrittd/wtrittd_lpn_booking.php",
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
                    edtwtrittd.field('wtrittd.wlpxxmh_kode').error( 'LPN ini sedang dipakai oleh user lain!' );
                    is_valid_lpn = 0;
                } else {
                    outstandingItem();
                    if (sisa <= 0) {
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').error( 'LPN ini sudah habis terpakai!' );
                        is_valid_lpn = 0;
                    } else {
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').error('');
                        is_valid_lpn = 1;
                    }
                }
            }
        } );
    }

    function validasiLocation() {
        wloxxmh_nama_scan = edtwtrittd.field('wloxxmh_nama_scan').val();
        is_gabung_lpn = edtwtrittd.field('wtrittd.is_gabung_lpn').val();
        is_lpn_baru = edtwtrittd.field('wtrittd.is_lpn_baru').val();
        id_iimxxmh = edtwtrittd.field('wtrittd.id_iimxxmh').val();
        id_iumxxmh_unit = edtwtrittd.field('wtrittd.id_iumxxmh_unit').val();
        console.log('is_gabung_lpn = '+is_gabung_lpn);

        $.ajax( {
            url: "../../models/wtrittd/wtrittd_fn_location_setting.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                keterangan: uniqueToken,
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
                is_gabung_lpn: is_gabung_lpn,
                wloxxmh_nama_scan: wloxxmh_nama_scan,
                wlpxxmh_kode: wlpxxmh_kode,
            },
            success: function ( json ) {
                status_code = json.data.status_code;
                is_inventory = json.data.is_inventory;
                // console.log(id_wloxxmh_tujuan);

                //ini code jika is_ganti_lokasi_putaway == 1
                //cek apakah lokasi yang discan sama dengan yang di detail/keterangan
                if(wloxxmh_nama_scan != wloxxmh_nama_target){
                    //jika tidak sama maka akan ada confirm

                        if (status_code == 500) {
                            edtwtrittd.field('wloxxmh_nama_scan').error( json.data.message );
                            edtwtrittd.field('wloxxmh_nama_scan').val('');
                            if (is_lpn_baru == 1) {
                                edtwtrittd.field('wtrittd.is_gabung_lpn').hide();
                            } else {
                                edtwtrittd.field('wtrittd.is_gabung_lpn').show();
                            }
                        } else {
                            id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                            edtwtrittd.field('wloxxmh_nama_scan').error( '' );
                            // console.log('lokasi ok');
                            edtwtrittd.field('wtrittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan); 
                            if (is_inventory == 1) {
                                edtwtrittd.field('wtrittd.is_gabung_lpn').show();
                            } else {
                                edtwtrittd.field('wtrittd.is_gabung_lpn').hide();
                                edtwtrittd.field('wtrittd.is_gabung_lpn').val(0);
                            }
                        }
                }else{
                    //meskipun kalo is_ganti_lokasi_putaway == 1 tapi nama scan sesui dengan yang detail maka pakai coding ini untuk OK
                    edtwtrittd.field('wloxxmh_nama_scan').error( '' );
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
        navigator.sendBeacon('../..//models/wtrittd/wtrittd_fn_remove_booking.php', jsonData);
    }

    function cekLokasiAsal() {
        wloxxmh_nama_asal = edtwtrittd.field('wloxxmh_nama_asal').val();

        $.ajax( {
            url: "../../models/wtrittd/wtrittd_fn_lokasi_asal.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                wloxxmh_nama_asal: wloxxmh_nama_asal
            },
            success: function ( json ) {
                id_loc = json.data.id_loc;
                id_iwhxxmh = json.data.id_iwhxxmh;
                id_wloctmh = json.data.id_wloctmh;
                console.log(id_wloctmh);
                // console.log('ajax id_loc = '+id_loc);
                
                if (id_loc > 0) {
                    if (id_wloctmh == 3 || id_wloctmh == 4) {
                        edtwtrittd.field('wtrittd.id_wloxxmh_asal').val(id_loc);
                        edtwtrittd.field('wloxxmh_nama_asal').error( '' );
                        edtwtrittd.field('wtrittd.id_iwhxxmh').val(id_iwhxxmh);
                        edtwtrittd.field('wtrittd.id_wloxxmh_tujuan').val(id_loc);
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').show();
                        edtwtrittd.field('wtrittd.wlpxxmh_kode').focus();
                    } else {
                        edtwtrittd.field('wloxxmh_nama_asal').error( 'Lokasi Scan harus Lokasi Storage! atau Rework' );
                        edtwtrittd.field('wloxxmh_nama_asal').val( '' );
                    }
                } else {
                    edtwtrittd.field('wloxxmh_nama_asal').error( 'Lokasi Tidak Ditemukan di Inventory!' );
                    edtwtrittd.field('wloxxmh_nama_asal').val( '' );
                }
            }
        } );
    }

    function validasiLpnTujuan() {
        wlpxxmh_kode_tujuan = edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').val();
        id_iimxxmh = edtwtrittd.field('wtrittd.id_iimxxmh').val();

        if(id_wloxxmh_tujuan > 0) {
            $.ajax( {
                url: "../../models/wtrittd/wtrittd_fn_lpn_tujuan.php",
                dataType: 'json',
                type: 'POST',
                async: false,
                data: {
                    wlpxxmh_kode_tujuan: wlpxxmh_kode_tujuan,
                    id_wloxxmh_tujuan: id_wloxxmh_tujuan,
                },
                success: function ( json ) {
                    c_id = json.data.c_id;
                    console.log('ajax c_id = '+c_id);
                    
                    batch_number_tujuan = json.data.batch_number;
                    expired_date_tujuan = json.data.expired_date;
                    id_iimxxmh_tujuan = json.data.id_iimxxmh;
                    edtwtrittd.field('wtrittd.expired_date_tujuan').val(expired_date_tujuan);
                    edtwtrittd.field('wtrittd.batch_number_tujuan').val(batch_number_tujuan);
                    if (c_id > 0) {

                        if (id_iimxxmh_tujuan == id_iimxxmh) {
                            edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error('');
                        } else {
                            edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error('Penggabungan hanya dapat dilakukan untuk item yang sama!');
                            edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').val( '' );
                        }
                    }else{
                        edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error( json.data.message );
                        edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').val( '' );
                    }
                }
            } );
        }
    }

    function validasiLPNBaru() {
        wlpxxmh_kode_tujuan = edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').val();
        $.ajax( {
            url: "../../models/wtrittd/wtrittd_fn_cek_lpn_baru.php",
            dataType: 'json',
            type: 'POST',
            data: {
                wlpxxmh_kode: wlpxxmh_kode_tujuan
            },
            success: function ( json ) {
                if(json.data.status_code == 500){
                    edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error( json.data.message );
                    edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').val( '' );
                }else{
                    edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error('');
                }
            }
        } );
    }
</script>