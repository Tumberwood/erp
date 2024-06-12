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
                                edtwtrittd.field('wtrittd.jumlah_unit').val(parseFloat(json.data.sisa_default).toFixed(2));
                                id_iumxxmh_unit_old = json.data.id_iumxxmh_default;
                                edtwtrittd.field('wtrittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);

                                // get lokasi putaway
                                wtrittd_details = wtrittd_details + json.data.iimxxmh_kode + ' - ';
                                wtrittd_details = wtrittd_details + json.data.iimxxmh_nama + '\n';
                                wtrittd_details = wtrittd_details + parseFloat(json.data.s_jumlah_unit).toFixed(2) + ' ';
                                wtrittd_details = wtrittd_details + json.data.iumxxmh_default_kode + '\n';
                                wtrittd_details = wtrittd_details + 'Outstanding: ' + (parseFloat(json.data.sisa_default) + parseFloat(jumlah_unit_old)).toFixed(2) + ' ';
                                wtrittd_details = wtrittd_details + json.data.iumxxmh_default_kode + '\n';
                                $.ajax( {
                                    url: "../../models/wtrittd/wtrittd_fn_wloxxmh.php",
                                    dataType: 'json',
                                    type: 'POST',
                                    data: {
                                        wlpxxmh_kode: wlpxxmh_kode,
                                        uniqueToken: uniqueToken,
                                    },
                                    success: function ( json ) {                      
                                        wloxxmh_nama_target = json.data.wloxxmh_nama;
                                        wtrittd_details = wtrittd_details + json.data.wloxxmh_nama;
                                        id_iwhxxmh = json.data.id_iwhxxmh;
                                        id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;

                                        edtwtrittd.field('wtrittd.id_iwhxxmh').val(id_iwhxxmh);
                                        edtwtrittd.field('wtrittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan);
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
                } else {
                    outstandingItem();
                    if (sisa == 0) {
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
        console.log('is_gabung_lpn = '+is_gabung_lpn);

        $.ajax( {
            url: "../../models/wtrittd/wtrittd_fn_location_setting.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                is_gabung_lpn: is_gabung_lpn,
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
                            edtwtrittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
                            edtwtrittd.field('wloxxmh_nama_scan').val('');
                            // console.log('xx');
                        }else{
                            const confirm_loc = confirm('Apakah anda ingin mengganti lokasi simpan?');
                            if (confirm_loc) {
                                edtwtrittd.field('wloxxmh_nama_scan').error( '' );
                                // console.log('lokasi ok');
                                edtwtrittd.field('wtrittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan);     
                            } else {
                                edtwtrittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
                                edtwtrittd.field('wloxxmh_nama_scan').val('');
                                // console.log('xx');
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
                // console.log('ajax id_loc = '+id_loc);
                
                if (id_loc > 0) {
                    edtwtrittd.field('wtrittd.id_wloxxmh_asal').val(id_loc);
                    edtwtrittd.field('wloxxmh_nama_asal').error( '' );
                } else {
                    edtwtrittd.field('wloxxmh_nama_asal').error( 'Lokasi Tidak Ditemukan!' );
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
                    
                    if (c_id > 0) {
                        batch_number_tujuan = json.data.batch_number;
                        expired_date_tujuan = json.data.expired_date;
                        id_iimxxmh_tujuan = json.data.id_iimxxmh;

                        if (id_iimxxmh_tujuan == id_iimxxmh) {
                            edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error('');
                        } else {
                            edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error('Item LPN Tujuan tidak sama dengan LPN Asal');
                        }
                    }else{
                        edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').error( json.data.message );
                        edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').val( '' );
                    }
                }
            } );
        }
    }
</script>