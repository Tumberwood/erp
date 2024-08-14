<script>
    
    function confirmLeavePage(event) {
        event.preventDefault();
    }

    function getHeaderPutaway() {
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_get_header.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                // console.log(json.data);
                id_wpttpmh_header = json.data.id_wpttpmh;
                c_id_confirm = json.data.c_id_confirm;
                wpttpmh_nama_header = json.data.nama;
                id_putaway_header = json.data.id;

                // console.log(id_wpttpmh_header);
                
                if (id_wpttpmh_header > 0) {
                    $('#select_wpttpmh').prop('disabled', true);
                    // tblwptittd.button('btnCancelPut:name').enable();
                } else {
                    $('#select_wpttpmh').prop('disabled', false);
                    // tblwptittd.button('btnCancelPut:name').disable();
                }

                if (c_id_confirm > 0) {
                    $('#wlpxxmh_kode').prop('disabled', true);
                } else {
                    $('#wlpxxmh_kode').prop('disabled', false);
                }
            }
        } );
    }

    var inputLPN = $('#wlpxxmh_kode');

    function validValidation(input){
        input.removeClass('is-invalid');
        input.next('.invalid-feedback').remove();
    }

    function invalidValidation(input,message){
        input.addClass('is-invalid');
        input.next('.invalid-feedback').remove();
        input.after('<div class="invalid-feedback">'+message+'</div>');
    }

    function lpnValidate() {
        var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
        var id_wpttpmh = $('#select_wpttpmh').val();
        var wlpxxmh_kode = $('#wlpxxmh_kode').val();

        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_wlpxxmh.php",
            dataType: 'json',
            type: 'POST',
            data: {
                wlpxxmh_kode: wlpxxmh_kode
            },
            success: function ( json ) {
                if (wlpxxmh_kode != '') {
                    if (json.data.status_code == 500) {
                        invalidValidation(inputLPN,json.data.message);
                        inputLPN.val('');
                    } else {
                        validValidation(inputLPN);
    
                        if (wlpxxmh_kode != '') {
                            wlpxxmh_kode_validasi(wlpxxmh_kode, inputLPN, timestamp);
                        }
                    }
                }
            }
        });
    }

    function wlpxxmh_kode_validasi (wlpxxmh_kode, inputLPN, timestamp){
        id_wpttpmh = $('#select_wpttpmh').val();

        // console.log(id_wpttpmh);
        if(wlpxxmh_kode != "" && id_wpttpmh > 0){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wptittd_multi/wptittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        invalidValidation(inputLPN,json.data.message);
                    }else{
                        validValidation(inputLPN);
                        // is_valid_lpn = 1;
                        let wptittd_details = '';
                        // cek apakah stok di receiving ada yang bisa di putaway
                        $.ajax( {
                            url: "../../models/wptittd_multi/wptittd_fn_iivxxrd.php",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                id_wpttpmh: id_wpttpmh,
                                wlpxxmh_kode: wlpxxmh_kode,
                                uniqueToken: uniqueToken,
                            },
                            success: function ( json ) {
                                id_iimxxmh = json.data.id_iimxxmh;
                                iimxxmh_kode = json.data.iimxxmh_kode;
                                iimxxmh_nama = json.data.iimxxmh_nama;
                                s_jumlah_unit = json.data.s_jumlah_unit;
                                // edtwptittd.field('wptittd.id_iimxxmh').val(id_iimxxmh);
                                // edtwptittd.field('wptittd.jumlah_unit').val(json.data.sisa_default);
                                sisa_unit = json.data.sisa_default;
                                id_iumxxmh_unit_old = json.data.id_iumxxmh_default;
                                // edtwptittd.field('wptittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);

                                // get lokasi putaway
                                wptittd_details = wptittd_details + json.data.iimxxmh_kode + ' - ';
                                wptittd_details = wptittd_details + json.data.iimxxmh_nama + '\n';
                                wptittd_details = wptittd_details + json.data.s_jumlah_unit + ' ';
                                wptittd_details = wptittd_details + json.data.iumxxmh_default_kode + '\n';
                                wptittd_details = wptittd_details + 'Outstanding: ' + (parseFloat(json.data.sisa_default) + parseFloat(jumlah_unit_old)) + ' ';
                                wptittd_details = wptittd_details + json.data.iumxxmh_default_kode + '\n';

                                $.ajax( {
                                    url: "../../models/wptittd_multi/wptittd_fn_wloxxmh.php",
                                    dataType: 'json',
                                    type: 'POST',
                                    data: {
                                        id_wpttpmh: id_wpttpmh,
                                        wlpxxmh_kode: wlpxxmh_kode,
                                        uniqueToken: uniqueToken,
                                        id_putaway_header: id_putaway_header,
                                    },
                                    success: function ( json ) {                      
                                        wloxxmh_nama_target = json.data.wloxxmh_nama;
                                        wptittd_details = wptittd_details + json.data.wloxxmh_nama;
                                        
                                        id_iwhxxmh = json.data.id_iwhxxmh;
                                        jenis_put = json.data.jenis_put;
                                        id_wloctmh = json.data.id_wloctmh;
                                        id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                                        id_wloxxmh_asal = json.data.id_wloxxmh_asal;

                                        // edtwptittd.field('wptittd.id_iwhxxmh').val(id_iwhxxmh);
                                        // edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan);
                                        // edtwptittd.field('wptittd.id_wloxxmh_asal').val(id_wloxxmh_asal);
                                        // edtwptittd.field('wptittd_details').val(wptittd_details);
                                        // edtwptittd.field('wptittd.keterangan').val(wptittd_details);
                                        
                                        // console.log(id_wloctmh);
                                        // console.log(jenis_put);
                                        if (id_wloctmh == 6) {
                                            if (id_wpttpmh != 2) {
                                                var newOption = new Option(jenis_put, 2, true, true);
                                                $('#select_wpttpmh').append(newOption).trigger('change');

                                                // Update Select2 to reflect the disabled state
                                                $('#select_wpttpmh').trigger('change.select2');
                                            }
                                        }

                                        if (id_iimxxmh > 0) {
                                            lpnBooking(id_wpttpmh, wlpxxmh_kode);
                                            if (sisa_unit <= 0) {
                                                invalidValidation(inputLPN, 'LPN ini sudah habis terpakai!');
                                                is_valid_lpn = 0;
                                            } else {
                                                validValidation(inputLPN);
                                                is_valid_lpn = 1;
                                            }
                                            // $('div.DTE_Form_Buttons button:eq(1)').click();
                                        } else {
                                            invalidValidation(inputLPN, 'LPN ini tidak ditemukan dalam report inventory!');
                                            is_valid_lpn = 0;
                                        }
                                        
                                        // console.log(is_valid_lpn);
                                        if (is_valid_lpn == 1 && id_wpttpmh > 0) {
                                            inputLPN.val('');
                                            // $('#tableLPN').show();
                                            booking(wptittd_details, id_wpttpmh, id_iumxxmh_unit_old, wlpxxmh_kode, sisa_unit, id_wloxxmh_asal, id_wloxxmh_tujuan, id_iimxxmh, id_iwhxxmh, timestamp);
                                        } else {
                                            ////////////
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

    function outstandingItem(id_wpttpmh, wlpxxmh_kode,idTransaksi) {
        if (idTransaksi == 0) {
            token = '';
        } else {
            token = 'putaway_multi_id_wptittd_'+idTransaksi;
        }
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_iivxxrd.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wpttpmh: id_wpttpmh,
                wlpxxmh_kode: wlpxxmh_kode,
                uniqueToken: token,
            },
            success: function ( json ) {
                jumlah_unit = json.data.sisa_default;
                hitungKonversi(idTransaksi);
            }
        } );
    }
    
    function hitungKonversi(idTransaksi) {
        // console.log('id_iimxxmh = '+id_iimxxmh);
        // console.log('id_iumxxmh_unit_old = '+id_iumxxmh_unit_old);
        // console.log('jumlah_unit = '+jumlah_unit);
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_konversi_unit.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit_old,
                jumlah_unit: jumlah_unit,
            },
            success: function ( json ) {
                if (idTransaksi == 0) {
                    id_iumxxmh_unit = id_iumxxmh_unit_old;
                }

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
                // console.log('sisa = '+sisa);
            }
        } );
    }
    
    function generateUniqueToken() {
        var timestamp = new Date().getTime().toString(36);
        var randomString = Math.random().toString(36).substring(2);
        return timestamp + randomString;
    }

    function booking(wptittd_details, id_wpttpmh, id_iumxxmh_unit_old, wlpxxmh_kode, sisa_unit, id_wloxxmh_asal, id_wloxxmh_tujuan, id_iimxxmh, id_iwhxxmh, timestamp){

        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_iivxxrd_booking.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                keterangan: wptittd_details,
                id_iumxxmh_unit: id_iumxxmh_unit_old,
                wlpxxmh_kode: wlpxxmh_kode,
                jumlah_unit: sisa_unit,
                id_wloxxmh_asal: id_wloxxmh_asal,
                id_wloxxmh_tujuan: id_wloxxmh_tujuan,
                id_iimxxmh: id_iimxxmh,
                id_iwhxxmh: id_iwhxxmh,
                state: 1,
                timestamp: timestamp,
                id_wpttpmh: id_wpttpmh,
            },
            success: function ( json ) {
                // console.log('oke');
                getHeaderPutaway();
                tblwptittd.ajax.reload(null, false);
                // generateKonten();
            }
        } );
    }

    function lpnBooking(id_wpttpmh, wlpxxmh_kode) {
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_lpn_booking.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                wlpxxmh_kode: wlpxxmh_kode,
                id_wpttpmh: id_wpttpmh,
            },
            success: function ( json ) {
                c_id = json.data.c_id;
                // console.log('ajax c_id = '+c_id);
                
                if (c_id > 0) {
                    invalidValidation(inputLPN,'LPN ini sedang dipakai oleh user lain!');
                    is_valid_lpn = 0;
                } else {
                    outstandingItem(id_wpttpmh, wlpxxmh_kode, 0);
                    
                }
            }
        } );
    }

    function validasiLocation(idTransaksi, wloxxmh_nama_target) {
        // inputLokasi = $(`#locAsal${idTransaksi}`);
        // wloxxmh_nama_scan = $(`#locAsal${idTransaksi}`).val();
        // console.log(wloxxmh_nama_scan);
        // var id_iumxxmh_unit = $('#uom_select' + idTransaksi).val();

        // autofillField('wptittd', idTransaksi, 'id_iimxxmh,wlpxxmh_kode');
        // id_iimxxmh = autofillData.id_iimxxmh;
        wlpxxmh_kode = wlpxxmh_kode_sel;
        wloxxmh_nama_scan = edtwptittd.field('wloxxmh_nama_scan').val();
        id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();

        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_location_setting.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                keterangan: 'putaway_multi_id_wptittd_'+idTransaksi,
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
                wloxxmh_nama_scan: wloxxmh_nama_scan,
                wlpxxmh_kode: wlpxxmh_kode,
            },
            success: function ( json ) {
                status_code = json.data.status_code;
                id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                // console.log(id_wloxxmh_tujuan);

                //ini code jika is_ganti_lokasi_putaway == 1
                //cek apakah lokasi yang discan sama dengan yang di detail/keterangan
                // if(wloxxmh_nama_scan != wloxxmh_nama_target){
                //     //jika tidak sama maka akan ada confirm
                        
                //         if (status_code == 500) {
                //             invalidValidation(inputLokasi, json.data.message);
                //             inputLokasi.val('');
                //             $('#finish' + idTransaksi).hide();
                //         } else {
                //             const confirm_loc = confirm('Apakah anda ingin mengganti lokasi simpan?');
                //             if (confirm_loc) {
                //                 id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                //                 validValidation(inputLokasi);
                //                 $('#finish' + idTransaksi).show();
                //                 finishData(idTransaksi);
                //                 // console.log('lokasi ok');
                //                 // edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan); 
                //             } else {
                //                 invalidValidation(inputLokasi,'Gagal Menyimpan!');
                //                 inputLokasi.val('');
                //                 $('#finish' + idTransaksi).hide();
                //             }
                //         }
                // }else{
                //     validValidation(inputLokasi);
                //     $('#finish' + idTransaksi).show();
                //     finishData(idTransaksi);
                // }
                
                if(wloxxmh_nama_scan != wloxxmh_nama_target){
                    //jika tidak sama maka akan ada confirm
                        
                        if (status_code == 500) {
                            edtwptittd.field('wloxxmh_nama_scan').error( json.data.message );
                            edtwptittd.field('wloxxmh_nama_scan').val('');
                        } else {
                            const confirm_loc = confirm('Apakah anda ingin mengganti lokasi simpan?');
                            if (confirm_loc) {
                                id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                                edtwptittd.field('wloxxmh_nama_scan').error( '' );
                                // console.log('lokasi ok');
                                edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan); 
                            } else {
                                edtwptittd.field('wloxxmh_nama_scan').error( 'Gagal Menyimpan!' );
                                edtwptittd.field('wloxxmh_nama_scan').val('');
                            }
                        }
                }else{
                    edtwptittd.field('wloxxmh_nama_scan').error( '' );
                }
            }
        } );
    }

    function validasiLocationEdt() {
        wloxxmh_nama_scan = edtwptittd.field('wloxxmh_nama_scan').val();
        id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();

        $.ajax( {
            url: "../../models/wptittd/wptittd_fn_location_setting.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                keterangan: uniqueToken,
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
                wloxxmh_nama_scan: wloxxmh_nama_scan,
                wlpxxmh_kode: wlpxxmh_kode_sel,
            },
            success: function ( json ) {
                status_code = json.data.status_code;
                id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                // console.log(id_wloxxmh_tujuan);

                //ini code jika is_ganti_lokasi_putaway == 1
                //cek apakah lokasi yang discan sama dengan yang di detail/keterangan
                if(wloxxmh_nama_scan != wloxxmh_nama_target){
                    //jika tidak sama maka akan ada confirm
                        
                        if (status_code == 500) {
                            edtwptittd.field('wloxxmh_nama_scan').error( json.data.message );
                            edtwptittd.field('wloxxmh_nama_scan').val('');
                        } else {
                            const confirm_loc = confirm('Apakah anda ingin mengganti lokasi simpan?');
                            if (confirm_loc) {
                                id_wloxxmh_tujuan = json.data.id_wloxxmh_tujuan;
                                edtwptittd.field('wloxxmh_nama_scan').error( '' );
                                // console.log('lokasi ok');
                                edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan); 
                            } else {
                                edtwptittd.field('wloxxmh_nama_scan').error( 'Gagal Menyimpan!' );
                                edtwptittd.field('wloxxmh_nama_scan').val('');
                            }
                        }
                }else{
                    edtwptittd.field('wloxxmh_nama_scan').error( '' );
                }
            }
        } );
    }

    function generateKonten(idTransaksi) {
        $('#konten').empty();
        // console.log(idTransaksi);
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_multi.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                show_deleted_wptittd: show_deleted_wptittd,
            },
            success: function ( json ) {
                wptittd_data = json.data;
                // console.log(wptittd_data);

                // if (wptittd_data.length == 1) {
                    colClass = 'col-md-12 col-lg-12 col-sm-12';
                // } else if (wptittd_data.length == 2){
                //     colClass = 'col-md-6 col-lg-6 col-sm-6';
                // } else if (wptittd_data.length >= 3){
                //     colClass = 'col-md-4 col-lg-4 col-sm-4';
                // }

                genKonten = '';

                wptittd_data.sort((a, b) => a.wptittd.transaction_state - b.wptittd.transaction_state);
                wptittd_data.forEach(dataKonten => {
                    if (dataKonten.wptittd.id == idTransaksi) {
                        transaction_state = dataKonten.wptittd.transaction_state;

                        if (transaction_state == 0) {
                            displayFinish = '';
                        } else {
                            displayFinish = 'style="display: none"';
                        }

                        if (dataKonten.wptittd.id_wpttpmh == 2) {
                            disableInput = 'disabled';
                            btnUpdate = '';
                        } else {
                            disableInput = '';
                            btnUpdate = `<button class="btn btn-primary submit-button" id="update${dataKonten.wptittd.id}" onClick="updateData(${dataKonten.wptittd.id})" >Start</button>`;
                        }
                        
                        btnFinish = `<button class="btn btn-warning submit-button" id="finish${dataKonten.wptittd.id}" onClick="finishData(${dataKonten.wptittd.id})" style="display: none">Finish</button>`;
                        
                        kontenInput = 
                        `
                            <div id="textItem${dataKonten.wptittd.id}">
                                <p>
                                    <b>${dataKonten.iimxxmh.kode} - ${dataKonten.iimxxmh.nama}</b>
                                </p>
                                <p class="m-t-n-sm">
                                    LPN : ${dataKonten.wptittd.wlpxxmh_kode}
                                    <br>
                                    Lokasi Tujuan : ${dataKonten.wloxxmh.nama}
                                    <br>
                                </p>
                            </div>

                            <div class="form-group m-t-n-sm" id="input${dataKonten.wptittd.id}" ${displayFinish}>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex align-items-center">
                                        <select class="form-select fw-bold" id="uom_select${dataKonten.wptittd.id}" onkeyup="jumlahSatuan(${dataKonten.wptittd.id})" style="font-size: 9px; height: 28px" ${disableInput}>
                                            <option value="${dataKonten.wptittd.id_iumxxmh_terkecil}" data-defVal="${dataKonten.wptittd.jumlah_terkecil.toString().replace(/\.?0+$/, '')}">${dataKonten.iumxxmh_terkecil_kode}</option>
                                            <option value="${dataKonten.wptittd.id_iumxxmh_default}" data-defVal="${dataKonten.wptittd.jumlah_default.toString().replace(/\.?0+$/, '')}" selected>${dataKonten.iumxxmh_default_kode}</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex align-items-center">
                                        <div class="quantity-input">
                                            <input type="text" id="input_jumlah${dataKonten.wptittd.id}" value="${dataKonten.wptittd.jumlah_default.toString().replace(/\.?0+$/, '')}" class="form-control form-control-sm quantity" min="0" onkeyup="validasiJumlah(${dataKonten.wptittd.id})" ${disableInput}>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="quantity-input">
                                            <input type="text" id="locAsal${dataKonten.wptittd.id}" onkeyup="validasiLocation(${dataKonten.wptittd.id}, '${dataKonten.wloxxmh.nama}')" class="form-control form-control-sm quantity" placeholder="Location" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        `;

                        genKonten = genKonten+ `
                            <div class="${colClass}">
                                ${kontenInput}
                            </div>
                        `;	

                        // genKonten = genKonten+ `
                        //     <div class="${colClass}">
                        //         <div class="ibox">
                        //             <div class="ibox-content">
                        //                 ${kontenInput}
                        //             </div>
                        //         </div>
                        //     </div>
                        // `;	
                    }
                });
                $('#konten').html(genKonten);
            }
        } );
    }

    function jumlahSatuan(idTransaksi) {
        var unitSelect = $('#uom_select' + idTransaksi).val();
        var defVal = $('#uom_select' + idTransaksi + ' option:selected').attr('data-defVal');

        $('#input_jumlah'+idTransaksi).val(defVal);
        validasiJumlah(idTransaksi);
    }

    function validasiJumlah(idTransaksi) {
        var inputJumlah = $('#input_jumlah' + idTransaksi);
        var valJumlah = inputJumlah.val();
        var qtyInput = parseFloat(inputJumlah.val(), 10); // Parse qtyInput as integer
        var defVal = parseFloat($('#uom_select' + idTransaksi + ' option:selected').attr('data-defVal'), 10); // Parse defVal as integer

        // console.log('valJumlah:', valJumlah); // Check the value of qtyInput
        // console.log('qtyInput:', qtyInput); // Check the value of qtyInput
        // console.log('defVal:', defVal);     // Check the value of defVal

        if (valJumlah == '') {
                inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                inputJumlah.after('<div class="invalid-feedback">Inputan wajib diisi!</div>');
                $('#update' + idTransaksi).hide();
        } else {
            if (isNaN(valJumlah)) {
                inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                inputJumlah.after('<div class="invalid-feedback">Inputan wajib angka!</div>');
                $('#update' + idTransaksi).hide();
                return; // Exit function early if input is not a number
            } else {
                if (qtyInput <= 0) {
                    $('#update' + idTransaksi).hide();
                    inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                    inputJumlah.after('<div class="invalid-feedback">Inputan angka wajib lebih dari 0</div>');
                } else {
                    if (qtyInput > defVal) {
                        // console.log('lebih');
                        $('#update' + idTransaksi).hide();
                        inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                        inputJumlah.after('<div class="invalid-feedback">Jumlah Max: '+defVal+'</div>');
                    } else {
                        $('#update' + idTransaksi).show();
                        inputJumlah.removeClass('is-invalid').next('.invalid-feedback').remove();
                        updateData(idTransaksi)
                    }
                }
            }
        }
        
    }
    
    function updateData(idTransaksi) {
        var valJumlah = $('#input_jumlah' + idTransaksi).val();
        var unitSelect = $('#uom_select' + idTransaksi).val();
        $('#locAsal' + idTransaksi).show();
        $('#update' + idTransaksi).hide();
        $('#input_jumlah' + idTransaksi).prop('disabled', true);
        $('#uom_select' + idTransaksi).prop('disabled', true);

        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_update.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                idTransaksi: idTransaksi,
                jumlah_unit: valJumlah,
                id_iumxxmh_unit: unitSelect,
            },
            success: function ( json ) {
                toastr[json.data.type_message](json.data.message,"INFO");
            }
        } );
    }
    
    function removeBooking(idTransaksi) {
        var data = {
            keterangan: 'putaway_multi_id_wptittd_'+idTransaksi,
        };
        // Convert data to JSON format
        var jsonData = JSON.stringify(data);
        // console.log(jsonData);
        // Send data asynchronously using navigator.sendBeacon
        navigator.sendBeacon('../../models/wptittd_multi/wptittd_fn_remove_booking.php', jsonData);
    }

    function finishData(idTransaksi) {
        removeBooking(idTransaksi);

        id_transaksi_h = idTransaksi;
        fnConfirm('wptittd', tblwptittd );
        tblwptittd.ajax.reload(null, false);
    }

    function confirmHeader() {
        // console.log(id_putaway_header);
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_confirm_header.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_putaway_header: id_putaway_header
            },
            success: function ( json ) {
                getHeaderPutaway();
            }
        } );
    }

    function cancelPutaway() {
        // console.log(id_putaway_header);
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_cancel_putaway.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_putaway_header: id_putaway_header
            },
            success: function ( json ) {
                getHeaderPutaway();
                tblwptittd.ajax.reload(null, false);
            }
        } );
    }

    function cancelDrop() {
        // console.log(id_putaway_header);
        $.ajax( {
            url: "../../models/wptittd_multi/wptittd_fn_cancelDrop.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_putaway_header: id_putaway_header
            },
            success: function ( json ) {
                getHeaderPutaway();
                tblwptittd.ajax.reload(null, false);
            }
        } );
    }
</script>