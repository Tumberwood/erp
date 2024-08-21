<script>
    function confirmLeavePage(event) {
        event.preventDefault();
    }

    function generateKonten() {
        $('#konten').empty();
        $('.btnLPN').empty();

        $.ajax( {
            url: "../../models/wdpxxth/wdpxxth_iivxxrd_card.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wpclptd: id_wpclptd,
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
                dataKonten.sort((a, b) => a.status_dispatch - b.status_dispatch);
                dataKonten.forEach(kontenData => {
                    wloxxmh_nama = kontenData.wloxxmh_nama;
                    status_dispatch = kontenData.status_dispatch;
                    id_wjtxxmh = kontenData.id_wjtxxmh;
                    wloxxmh_out_nama = kontenData.wloxxmh_out_nama;
                    id_submit_d = kontenData.id_submit_d;

                    if (status_dispatch == 1) {
                        statusDispatchText = '<span class="badge badge-plain">Open</span>';
                    } else if (status_dispatch == 2) {
                        statusDispatchText = '<span class="badge badge-warning">Parsial</span>';
                    } else if (status_dispatch == 3) {
                        statusDispatchText = '<span class="badge badge-primary">Full</span>';
                    } else {
                        statusDispatchText = '';
                    }

                    if (id_wjtxxmh == 2) {
                        btnSubmit = `
                            <button class="btn btn-warning submit-button" id="submit${kontenData.id}" onClick="validasiJumlah(${kontenData.id})" style="display: none">Submit & Confirm</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        `;
                        $('#confirmBtn').hide();
                    } else {
                        $('#confirmBtn').show();
                        btnSubmit = `
                            <button class="btn btn-primary submit-button" id="submit${kontenData.id}" onClick="validasiJumlah(${kontenData.id})">Submit</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        `;
                    }
                    
                    kontenValid = `
                                <div id="textItem${kontenData.id}">
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
                                        Status Dispatch : ${statusDispatchText}
                                        <br>
                                        
                                        Jumlah Pick : ${kontenData.jumlah_default_os.toString().replace(/\.?0+$/, '')} ${kontenData.uom_pl}
                                        <br>
                                        Jumlah Dispatch : ${kontenData.jumlah_default_now.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_default_kode}
                                        <br>
                                        Jumlah Sisa : ${kontenData.sisa_default.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_default_kode}
                                    </p>
                                </div>`

                    btnAudit = `
                                ${kontenValid}

                                <div class="form-group m-t-n-sm" id="input${kontenData.id}">
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
                                                <input 
                                                    type="text" 
                                                    id="input_jumlah${kontenData.id}" 
                                                    value="${id_submit_d > 0 ? kontenData.jumlah_default_now.toString().replace(/\.?0+$/, '') : 
                                                    kontenData.sisa_default_now.toString().replace(/\.?0+$/, '')}" 
                                                    class="form-control form-control-sm quantity" 
                                                    min="0">
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
                            <h3>${kontenData.wlpxxmh_kode} - ${wloxxmh_nama}</h3>
                            ${btnAudit}
                        </div>
                    `;	
                });
                $('.btnLPN').append(btnSubmit);
                $('#konten').html(genKonten);
                // $(`#locAsal${dataKonten[0].id}`).focus();
            }
        } );
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

        console.log('qtyInput:', qtyInput); // Check the value of qtyInput
        console.log('defVal:', defVal);     // Check the value of defVal
        var is_submit = 0;

        if (isNaN(valJumlah)) {
            inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
            inputJumlah.after('<div class="invalid-feedback">Inputan wajib angka!</div>');
            $('#dispatch' + itemId).hide();
            // $('#submit' + itemId).hide().prop('disabled', true);
            is_submit = 0;
            return; // Exit function early if input is not a number
        } else {
            if (qtyInput <= 0) {
                // $('#submit' + itemId).hide().prop('disabled', true);
                is_submit = 0;
                inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                inputJumlah.after('<div class="invalid-feedback">Inputan angka wajib lebih dari 0</div>');
            } else {
                if (qtyInput > defVal) {
                    console.log('lebih');
                    $('#dispatch' + itemId).hide();
                    // $('#submit' + itemId).hide().prop('disabled', true);
                    is_submit = 0;
                    inputJumlah.addClass('is-invalid').next('.invalid-feedback').remove();
                    inputJumlah.after('<div class="invalid-feedback">Jumlah Max: '+defVal+'</div>');
                } else {
                    inputJumlah.removeClass('is-invalid').next('.invalid-feedback').remove();
                    var job_type = dataKonten[0].id_wjtxxmh;  // Assuming dataKonten is defined elsewhere
                    console.log('job_type:', job_type);

                    if (job_type == 1 || job_type == 3) {
                        console.log('job 1 3');
                        // $('#submit' + itemId).show().prop('disabled', false);
                        is_submit = 1;
                    } else {
                        console.log('else job 2');
                        $('#dispatch' + itemId).show().focus();
                        // $('#submit' + itemId).hide().prop('disabled', true);
                        is_submit = 0;
                    }
                }
            }
        }
        
        if (is_submit == 1) {
            submitData(itemId);
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
        console.log(finish_at);
        console.log(selectedValues);
        $(`#submit${itemId}`).hide();
        console.log(start_at);

        $.ajax( {
            url: "../../models/wdpxxth/wdpxxth_fn_submit.php",
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
				    tblwdpxxth.ajax.reload(null, false);
                    generateKonten();
                    
                    $('#modalLPN').modal('toggle');
                    cekDetailSubmit();
                }
            }
        } );
    }

    function cekDetailSubmit() {
        $.ajax( {
            url: "../../models/wdpxxth/wdpxxth_fn_cek_detail_submit.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wpcxxth_old: id_wpcxxth_old
            },
            success: function ( json ) {
                c_id_d = json.data.c_id_d;

                if (c_id_d > 0) {
                    tblwdpxxth.button('btnConfirmDispatch:name').enable();
                } else {
                    tblwdpxxth.button('btnConfirmDispatch:name').disable();
                }
            }
        } );
    }

    function confirmData() {
        $.ajax( {
            url: "../../models/wdpxxth/wdpxxth_fn_cek_confirm.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_wpcxxth_old: id_wpcxxth_old
            },
            success: function ( json ) {
                c_id_d = json.data.c_id_d;
                var isCanConfirm = 0;
                if (c_id_d > 0) {
                    swal({
                        text: 'Apakah Anda yakin? Terdapat '+c_id_d+' data dengan Status Dispatch belum Full',
                        icon: "info",
                        buttons: {
                            cancel: true,
                            confirm: true
                        },
                    })
                    .then((willConfirm) => {
                        if (willConfirm) {
                            console.log('OK');
                            isCanConfirm = 1;
                            confirmDispatch();
                        } else {
                            console.log('NOT OK');
                            isCanConfirm = 0;
                        }
                    });
                } else {
                    isCanConfirm = 1;
                    confirmDispatch();
                }
            }
        } );
        // console.log(wloxxmh_out_nama);
        // confirmDispatch = prompt('Enter Dispatch Location');

        // if(confirmDispatch == wloxxmh_out_nama) {
        // } else {
        //     toastr["warning"]("Dispatch Location Tidak Sesuai!","WARNING");
        // }
    }

    function confirmDispatch() {
        confirm_at = moment().format('YYYY-MM-DD HH:mm:ss');	
            console.log(confirm_at);
            $.ajax( {
                url: "../../models/wdpxxth/wdpxxth_fn_confirm.php",
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
    function isDispatchUsed(id_wpcxxth_old, is_in_use, uniqueToken) {
        var data = {
            id_wpcxxth_old: id_wpcxxth_old,
            is_in_use: is_in_use,
            uniqueToken: uniqueToken,
        };
        // Convert data to JSON format
        var jsonData = JSON.stringify(data);
        // console.log(jsonData);
        // Send data asynchronously using navigator.sendBeacon
        navigator.sendBeacon('../../models/wdpxxth/wdpxxth_fn_is_used.php', jsonData);
    }
    
    function generateUniqueToken() {
        var timestamp = new Date().getTime().toString(36);
        var randomString = Math.random().toString(36).substring(2);
        return timestamp + randomString;
    }
</script>