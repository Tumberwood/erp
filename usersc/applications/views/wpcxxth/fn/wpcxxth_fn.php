<script>
    function confirmLeavePage(event) {
        event.preventDefault();
    }

    function cekDataInventory(wlpxxmh_kode, id_wloxxmh){
        // cek apakah UoM Replenishment ada
        $.ajax( {
            url: "../../models/wpcxxth/wpcxxth_cek_inventory.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                wlpxxmh_kode: wlpxxmh_kode,
                id_wloxxmh: id_wloxxmh,
            },
            success: function ( json ) {
                message_rep = json.data.message;
                status_code_rep = json.data.status_code;
                console.log(status_code_rep);
            }
        } );
    };

    function generateKonten() {
        $('#konten').empty();
        $('.btnLPN').empty();

        $.ajax( {
            url: "../../models/wpcxxth/wpcxxth_iivxxrd_card.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wpllptd: id_wpllptd,
                uniqueToken: uniqueToken,
            },
            success: function ( json ) {
                dataKonten = json.data;
                window.addEventListener('beforeunload', confirmLeavePage);

                if (dataKonten.length >= 2 && dataKonten.length < 3) {
                    class_col = "col-lg-6";
                } else if (dataKonten.length > 3) {
                    class_col = "col-lg-4";
                } else {
                    class_col = "col-lg-12";
                }

                genKonten = '';
                autofillField('ggswmsh', 1, 'is_replenishment');
				is_replenishment = autofillData.is_replenishment;
                cekDataInventory(dataKonten[0].wlpxxmh_kode, dataKonten[0].id_wloxxmh);
                if (is_replenishment == 1 && status_code_rep == 500) {
                    $('#konten').html(`<h3>${message_rep}</h3>`);
                } else {

                    dataKonten.sort((a, b) => a.status_picking - b.status_picking);
                    dataKonten.forEach(kontenData => {
                        wloxxmh_nama = kontenData.wloxxmh_nama;
                        status_picking = kontenData.status_picking;
                        id_wjtxxmh = kontenData.id_wjtxxmh;
                        wloxxmh_out_nama = kontenData.wloxxmh_out_nama;
                        sisa_terkecil_now = kontenData.sisa_terkecil_now;
                        id_submit_d = kontenData.id_submit_d;
                        console.log(id_submit_d);
    
                        if (id_submit_d > 0) {
                            displayInputan = 'style="display: none"';
                            displayText = '';
                            h3CardLocation = `<h3>${kontenData.wlpxxmh_kode} - ${wloxxmh_nama}</h3>`;
                            displayInputJumlah = '';
                            if (status_picking == 1) {
                                statusPickingText = '<span class="badge badge-plain">Open</span>';
                            } else if (status_picking == 2) {  
                                statusPickingText = '<span class="badge badge-warning">Parsial</span>';
                            } else if (status_picking == 3) {
                                statusPickingText = '<span class="badge badge-primary">Full</span>';
                            }
                        } else {
                            if (status_picking == 1) {
                                displayInputan = '';
                                statusPickingText = '<span class="badge badge-plain">Open</span>';
                                displayText = 'style="display: none"';
                                h3CardLocation = `<h3>${wloxxmh_nama}</h3>`;
                                displayInputJumlah = 'style="display: none"';
                            } else if (status_picking == 2) {
                                displayInputan = '';
                                displayText = 'style="display: none"';
                                statusPickingText = '<span class="badge badge-warning">Parsial</span>';
                                h3CardLocation = `<h3>${wloxxmh_nama}</h3>`;
                                displayInputJumlah = 'style="display: none"';
                            } else if (status_picking == 3) {
                                if (sisa_terkecil_now > 0) {
                                    displayInputJumlah = '';
                                } else {
                                    displayInputJumlah = 'style="display: none"';
                                }
                                displayInputan = 'style="display: none"';
                                displayText = '';
                                statusPickingText = '<span class="badge badge-primary">Full</span>';
                                h3CardLocation = `<h3>${kontenData.wlpxxmh_kode} - ${wloxxmh_nama}</h3>`;
                                displayInputJumlah = 'style="display: none"';
                            } else {
                                displayInputan = '';
                                statusPickingText = '';
                                displayText = 'style="display: none"';
                                h3CardLocation = `<h3>${wloxxmh_nama}</h3>`;
                                displayInputJumlah = 'style="display: none"';
                            }
                        }
    
    
                        if (id_wjtxxmh == 2) {
                            btnSubmit = `
                                <button class="btn btn-warning submit-button" id="submit${kontenData.id}" onClick="submitData(${kontenData.id})" style="display: none">Submit & Confirm</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>`
                                ;
                            $('#confirmBtn').hide();
                        } else {
                            $('#confirmBtn').show();
                            btnSubmit = `
                                    <button class="btn btn-primary submit-button" id="submit${kontenData.id}" onClick="submitData(${kontenData.id})" style="display: none">Submit</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                `;
                        }
                        
                        kontenValid = `
                                    <div ${displayText} id="textItem${kontenData.id}">
                                        <p>
                                            <b>${kontenData.iimxxmh_kode} - ${kontenData.iimxxmh_nama}</b>
                                        </p>
                                        <p class="m-t-n-sm">
                                            Batch Number : ${kontenData.batch_number}
                                            <br>
                                            Expired Date : ${kontenData.expired_date}
                                            <br>
                                            Dispatch Location : ${kontenData.wloxxmh_out_nama}
                                            <br>
                                            Status Picking : ${statusPickingText}
                                            <br>
                                            
                                            Jumlah PL : ${kontenData.jumlah_default_os.toString().replace(/\.?0+$/, '')} ${kontenData.uom_pl}
                                            <br>
                                            Jumlah Pick : ${kontenData.jumlah_default_now.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_default_kode}
                                            <br>
                                            Jumlah Sisa : ${kontenData.sisa_default.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_default_kode}
                                        </p>
                                    </div>`
    
                        kontenInput = `
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="quantity-input">
                                                <input type="text" id="locAsal${kontenData.id}" onkeyup="validasiLocation(${kontenData.id}, '${wloxxmh_nama}')" class="form-control form-control-sm quantity" placeholder="Location" ${displayInputan}>
                                            </div>
                                        </div>
                                    </div>
    
                                    <h3 style="display: none" id="textLPN${kontenData.id}">${kontenData.wlpxxmh_kode}</h3>
                                    
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="quantity-input">
                                                <input type="text" id="lpn${kontenData.id}" onkeyup="validasiLPN(${kontenData.id}, '${kontenData.wlpxxmh_kode}', ${id_submit_d})" class="form-control form-control-sm quantity" placeholder="LPN" style="display: none">
                                            </div>
                                        </div>
                                    </div>
    
                                    ${kontenValid}
    
                                    <div class="form-group m-t-n-sm" id="input${kontenData.id}"  ${displayInputJumlah}>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <select class="form-select fw-bold" id="uom_select${kontenData.id}" onchange="jumlahSatuan(${kontenData.id})" style="font-size: 9px; height: 28px">
                                                    <option value="${kontenData.id_iumxxmh_terkecil}" data-defVal="${kontenData.sisa_terkecil_now.toString().replace(/\.?0+$/, '')}">${kontenData.iumxxmh_terkecil_kode}</option>
                                                    <option value="${kontenData.id_iumxxmh_default}" data-defVal="${kontenData.sisa_default_now.toString().replace(/\.?0+$/, '')}" selected>${kontenData.iumxxmh_default_kode}</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <div class="quantity-input">
                                                    <input type="text" id="input_jumlah${kontenData.id}" value="${kontenData.sisa_default_now.toString().replace(/\.?0+$/, '')}" class="form-control form-control-sm quantity" min="0" onkeyup="validasiJumlah(${kontenData.id})">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center justify-content-between m-t-n-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="quantity-input">
                                                <input type="text" id="dispatch${kontenData.id}" class="form-control form-control-sm quantity" placeholder="Dispatch Location" style="display: none" onchange="validasiDispatch(${kontenData.id}, '${kontenData.wloxxmh_out_nama}')">
                                            </div>
                                        </div>
                                    </div>
                        `;	
                        ;
                        
                        genKonten = genKonten+ `
                            <div class="${class_col}">
                                ${h3CardLocation}
                                ${kontenInput}
                            </div>
                        `;	
                    });
                    $('.btnLPN').append(btnSubmit);
                    $('#konten').html(genKonten);
                }

                // $(`#locAsal${dataKonten[0].id}`).focus();
            }
        } );
    }
    
    genDispatchConfirm = `
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    <div class="quantity-input">
                        <input type="text" id="locDispatch" onkeyup="confirmDispatch()" class="form-control form-control-sm quantity" placeholder="Dispatch">
                    </div>
                </div>
            </div>
        </div>
    `;	
    $('#kontenDispatch').html(genDispatchConfirm);
    
    function validasiLocation(itemId, iwloxxmh_nama) {
        // Disable all elements starting with 'locAsal' except for $('#locAsal' + itemId)
        $('[id^=locAsal]').each(function() {
            var currentId = $(this).attr('id');
            if (currentId !== 'locAsal' + itemId) {
                $(this).prop('disabled', true);
            }
        });
        
        var inputLocation = $('#locAsal' + itemId);
        var inputValue = inputLocation.val();
        start_at = moment().format('YYYY-MM-DD HH:mm:ss');	
        console.log(start_at);

        if (inputValue == '') {
            inputLocation.removeClass('is-invalid');
            inputLocation.next('.invalid-feedback').remove();
        } else {
            if (inputValue != iwloxxmh_nama) {
                $('#lpn' + itemId).hide();
                $('#locAsal' + itemId).prop('disabled', false);
                inputLocation.addClass('is-invalid');
                inputLocation.next('.invalid-feedback').remove();
                inputLocation.after('<div class="invalid-feedback">Lokasi tidak sesuai.</div>');
                inputLocation.val('');
            } else {
                inputLocation.removeClass('is-invalid');
                inputLocation.next('.invalid-feedback').remove();
                $('#textLPN' + itemId).show();
                $('#lpn' + itemId).show();
                $('#lpn' + itemId).focus();
                $('#locAsal' + itemId).prop('disabled', true);
            }
        }
    }

    function validasiLPN(itemId, wlpxxmh_kode, id_submit_d) {
        var inputLPN = $('#lpn' + itemId);
        var inputValue = inputLPN.val();
        // console.log(inputValue);
        console.log(id_submit_d);
        
        if (inputValue == '') {
            inputLPN.removeClass('is-invalid');
            inputLPN.next('.invalid-feedback').remove();
        } else {
            if (inputValue != wlpxxmh_kode) {
                
                $('#input' + itemId).hide();
                $('#lpn' + itemId).prop('disabled', false);
                inputLPN.addClass('is-invalid');
                inputLPN.next('.invalid-feedback').remove();
                inputLPN.after('<div class="invalid-feedback">LPN tidak sesuai.</div>');
                inputLPN.val('');
            } else {
                inputLPN.removeClass('is-invalid');
                inputLPN.next('.invalid-feedback').remove();
                $('#textItem' + itemId).show();
                $('#input' + itemId).show();
                $('#input_jumlah' + itemId).focus();
                $('#lpn' + itemId).prop('disabled', true);
            }
        }
    }

    function jumlahSatuan(itemId) {
        var unitSelect = $('#uom_select' + itemId).val();
        var defVal = $('#uom_select' + itemId + ' option:selected').attr('data-defVal');

        $('#input_jumlah'+itemId).val(defVal);
        validasiJumlah(itemId);
        // $('#uom_select' + itemId).prop('disabled', false);
        // $('#input_jumlah' + itemId).prop('disabled', false);
    }

    function validasiJumlah(itemId) {
        var inputJumlah = $('#input_jumlah' + itemId);
        var valJumlah = inputJumlah.val();
        var qtyInput = parseFloat(inputJumlah.val(), 10); // Parse qtyInput as integer
        var defVal = parseFloat($('#uom_select' + itemId + ' option:selected').attr('data-defVal'), 10); // Parse defVal as integer

        console.log('valJumlah:', valJumlah); // Check the value of qtyInput
        console.log('qtyInput:', qtyInput); // Check the value of qtyInput
        console.log('defVal:', defVal);     // Check the value of defVal

        if (valJumlah == '') {
                inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                inputJumlah.after('<div class="invalid-feedback">Inputan wajib diisi!</div>');
                $('#dispatch' + itemId).hide();
                $('#submit' + itemId).hide().prop('disabled', true);
        } else {
            if (isNaN(valJumlah)) {
                inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                inputJumlah.after('<div class="invalid-feedback">Inputan wajib angka!</div>');
                $('#dispatch' + itemId).hide();
                $('#submit' + itemId).hide().prop('disabled', true);
                return; // Exit function early if input is not a number
            } else {
                if (qtyInput <= 0) {
                    $('#submit' + itemId).hide().prop('disabled', true);
                    inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                    inputJumlah.after('<div class="invalid-feedback">Inputan angka wajib lebih dari 0</div>');
                } else {
                    if (qtyInput > defVal) {
                        // console.log('lebih');
                        $('#dispatch' + itemId).hide();
                        $('#submit' + itemId).hide().prop('disabled', true);
                        inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                        inputJumlah.after('<div class="invalid-feedback">Jumlah Max: '+defVal+'</div>');
                    } else {
                        inputJumlah.removeClass('is-invalid').next('.invalid-feedback').remove();
                        var job_type = dataKonten[0].id_wjtxxmh;  // Assuming dataKonten is defined elsewhere
                        // console.log('job_type:', job_type);

                        if (job_type == 1 || job_type == 3) {
                            // console.log('job 1 3');
                            $('#submit' + itemId).show().prop('disabled', false);
                        } else {
                            // console.log('else job 2');
                            $('#dispatch' + itemId).show().focus();
                            $('#submit' + itemId).hide().prop('disabled', true);
                        }
                    }
                }
            }
        }
        
    }

    function validasiDispatch(itemId, iwloxxmh_nama) {
        var inputDispatch = $('#dispatch' + itemId);
        var inputValue = inputDispatch.val();

        if (inputValue != iwloxxmh_nama) {
            $('#input_jumlah' + itemId).prop('disabled', false);
            $('#uom_select' + itemId).prop('disabled', false);
            $('#submit' + itemId).hide();
            $('#dispatch' + itemId).prop('disabled', false);
            inputDispatch.addClass('is-invalid');
            inputDispatch.next('.invalid-feedback').remove();
            inputDispatch.after('<div class="invalid-feedback">Lokasi tidak sesuai.</div>');
            inputDispatch.val('');
        } else {
            inputDispatch.removeClass('is-invalid');
            inputDispatch.next('.invalid-feedback').remove();
            $('#uom_select' + itemId).prop('disabled', true);
            $('#input_jumlah' + itemId).prop('disabled', true);
            $('#submit' + itemId).show();
            $('#dispatch' + itemId).prop('disabled', true);
        }
    }

    function submitData(itemId) {
        id_iumxxmh_input = $('#uom_select' + itemId).val();
        jumlah_unit_input = $('#input_jumlah' + itemId).val();
        finish_at = moment().format('YYYY-MM-DD HH:mm:ss');	
        console.log(jumlah_unit_input);
        console.log(id_iumxxmh_input);
        $(`#submit${itemId}`).hide();

        $.ajax( {
            url: "../../models/wpcxxth/wpcxxth_fn_submit.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_lpn: itemId,
                id_picking: selectedValues,
                id_iumxxmh_input: id_iumxxmh_input,
                jumlah_unit_input: jumlah_unit_input,
                start_at: start_at,
                finish_at: finish_at,
                uniqueToken: uniqueToken,
            },
            success: function ( json ) {
                status_code = json.data.status_code;
                if (status_code == 200) {
                    toastr[json.data.type_message](json.data.message,"INFO");
				    tblwpcxxth.ajax.reload(null, false);
                    generateKonten();
                    
                    $('#modalLPN').modal('toggle');
                    cekDetailSubmit();
                }
            }
        } );
    }

    function cekDetailSubmit() {
        $.ajax( {
            url: "../../models/wpcxxth/wpcxxth_fn_cek_detail_submit.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wpcxxth_old: id_wpcxxth_old
            },
            success: function ( json ) {
                c_id_d = json.data.c_id_d;

                if (c_id_d > 0) {
                    tblwpcxxth.button('btnConfirmPicking:name').enable();
                } else {
                    tblwpcxxth.button('btnConfirmPicking:name').disable();
                }
            }
        } );
    }

    // function confirmData() {
    //     // console.log(wloxxmh_out_nama);
        
    //     swal({
    //         text: "Masukkan Lokasi Dispatch",
    //         content: {
    //             element: "input",
    //             attributes: {
    //                 placeholder: "Enter Dispatch Location",
    //                 type: "text",
    //             },
    //         },
    //         buttons: {
    //             cancel: true,
    //             confirm: true,
    //         },
    //     })
    //     .then((value) => {
    //         if (value !== null && value.trim() !== "") {
    //             // Lakukan sesuatu jika nilai dispatch location sesuai dengan wloxxmh_out_nama
    //             if (value == wloxxmh_out_nama) {
    //                 confirm_at = moment().format('YYYY-MM-DD HH:mm:ss');	
    //                 console.log(confirm_at);
    //                 $.ajax( {
    //                     url: "../../models/wpcxxth/wpcxxth_fn_confirm.php",
    //                     dataType: 'json',
    //                     type: 'POST',
    //                     data: {
    //                         id_picking: selectedValues,
    //                         start_at: start_at,
    //                         confirm_at: confirm_at,
    //                         uniqueToken: uniqueToken,
    //                     },
    //                     success: function ( json ) {
    //                         status_code = json.data.status_code;
    //                         if (status_code == 200) {
    //                             toastr[json.data.type_message](json.data.message,"INFO");
    //                             // generateKonten();
    //                             window.removeEventListener('beforeunload', confirmLeavePage);
    //                             location.reload();
    //                         }
    //                     }
    //                 } );
    //             } else {
    //                 // Tindakan jika nilai tidak sesuai
    //                 swal("Error", "Dispatch Location tidak sesuai.", "error");
    //             }
    //         } else {
    //             // Tindakan jika nilai tidak diisi atau dibatalkan
    //             swal("Error", "Anda harus memasukkan Lokasi Dispatch.", "error");
    //         }
    //     });
    // }
    function confirmData() {
        confirm_at = moment().format('YYYY-MM-DD HH:mm:ss');	

        $.ajax( {
            url: "../../models/wpcxxth/wpcxxth_fn_confirm.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_picking: selectedValues,
                start_at: start_at,
                confirm_at: confirm_at,
                uniqueToken: uniqueToken,
            },
            success: function ( json ) {
                status_code = json.data.status_code;
                if (status_code == 200) {
                    toastr[json.data.type_message](json.data.message,"INFO");
                    // generateKonten();
                    window.removeEventListener('beforeunload', confirmLeavePage);
                    location.reload();
                }
            }
        } );
    }

    function confirmDispatch() {
        // console.log(wloxxmh_out_nama);
        var inputDispatchConfirm = $('#locDispatch');
        var inputDispatch = inputDispatchConfirm.val();
        console.log(inputDispatch);
        console.log(wloxxmh_out_nama);

        if (inputDispatch == '') {
            inputDispatchConfirm.removeClass('is-invalid');
            inputDispatchConfirm.next('.invalid-feedback').remove();
            $('#confirmInput').hide();
        } else {
            if (inputDispatch != wloxxmh_out_nama) {
                $('#confirmInput').hide();
                console.log('salah');
                inputDispatchConfirm.addClass('is-invalid');
                inputDispatchConfirm.next('.invalid-feedback').remove();
                inputDispatchConfirm.after('<div class="invalid-feedback">Dispatch tidak sesuai.</div>');
                inputDispatchConfirm.val('');
            } else {
                console.log('benar');
                inputDispatchConfirm.removeClass('is-invalid');
                inputDispatchConfirm.next('.invalid-feedback').remove();
                $('#confirmInput').show();
            }
        }
    }

    function isPickingUsed(id_wpcxxth_old, is_in_use, uniqueToken) {
        var data = {
            id_wpcxxth_old: id_wpcxxth_old,
            is_in_use: is_in_use,
            uniqueToken: uniqueToken,
        };
        // Convert data to JSON format
        var jsonData = JSON.stringify(data);
        // console.log(jsonData);
        // Send data asynchronously using navigator.sendBeacon
        navigator.sendBeacon('../../models/wpcxxth/wpcxxth_fn_is_used.php', jsonData);
    }

    function generateUniqueToken() {
        var timestamp = new Date().getTime().toString(36);
        var randomString = Math.random().toString(36).substring(2);
        return timestamp + randomString;
    }
</script>