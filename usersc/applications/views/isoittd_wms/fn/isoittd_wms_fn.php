<script>
    autofillField('ggswmsh', 1, 'is_tampil_stok');
    const is_tampil_stok = autofillData.is_tampil_stok;

    function generateKonten() {
        $('#konten').empty();
        $('#awal').hide();
        $('#add_button').show();
        id_wlpxxmh_filter = 0;
        id_wloxxmh_filter = 0;
        is_valid = 0;	
        is_valid_lpn = 0;	
        is_valid_loc = 0;	

        if (wlpxxmh_filter != '') {
            //cek lpn apakah terdaftar di master LPN
            $.ajax( {
                url: "../../models/isoittd_wms/isoittd_wms_fn_cek_lpn_dan_lokasi.php",
                dataType: 'json',
                type: 'POST',
                async: false,
                data: {
                    state: 1,
                    wlpxxmh_filter: wlpxxmh_filter,
                },
                success: function ( json ) {
                    id_wlpxxmh_filter = json.data;

                    if (id_wlpxxmh_filter > 0) {
                        is_valid = 1;
                        is_valid_lpn = 1;
                    } else {
                        is_valid_lpn = 0;
                        alert('LPN Tidak Terdaftar di master LPN!');
                    }
                }
            } );
        }

        if (wloxxmh_filter != '') {
            //cek lpn apakah terdaftar di master LPN
            $.ajax( {
                url: "../../models/isoittd_wms/isoittd_wms_fn_cek_lpn_dan_lokasi.php",
                dataType: 'json',
                type: 'POST',
                async: false,
                data: {
                    state: 2,
                    wloxxmh_filter: wloxxmh_filter,
                },
                success: function ( json ) {
                    id_wloxxmh_filter = json.data;

                    if (id_wloxxmh_filter > 0) {
                        is_valid = 1;
                        is_valid_loc = 1;
                    } else {
                        is_valid_loc = 0;
                        alert('Location Tidak Terdaftar di master Location!');
                    }
                }
            } );
        }

        if (wloxxmh_filter != '' && wlpxxmh_filter != '') {
            if (is_valid_loc == 1 && is_valid_lpn == 1) {
                is_valid = 1;
            } else {
                is_valid = 0;
            }
        }

        if (is_valid == 1) {
            $.ajax( {
                url: "../../models/isoittd_wms/isoittd_wms_iivxxrd.php",
                dataType: 'json',
                type: 'POST',
                async: false,
                data: {
                    id_wlpxxmh_filter: id_wlpxxmh_filter,
                    id_wloxxmh_filter: id_wloxxmh_filter,
                },
                success: function ( json ) {
                    dataKonten = json.data;
                    if (dataKonten.length >= 2 && dataKonten.length < 3) {
                        class_col = "col-lg-6";
                    } else if (dataKonten.length > 3) {
                        class_col = "col-lg-4";
                    } else {
                        class_col = "col-lg-12";
                    }

                    genKonten = '';
                    var genKonten = ''; // pastikan genKonten sudah dideklarasi di luar loop
                    var numFormat = $.fn.dataTable.render.number('.', ',', 0, '').display;

                    dataKonten.forEach(kontenData => {
                        let wloxxmh_nama = kontenData.wloxxmh_nama || '';
                        let is_iiv_valid = kontenData.is_iiv_valid;
                        let is_audit = kontenData.is_audit;
                        let id_audit = kontenData.id_audit;
                        let is_add_new = kontenData.is_add_new;
                        let is_cut_off = kontenData.is_cut_off;
                        let id_iumxxmh_unit = kontenData.id_iumxxmh_unit;
                        let jumlah_unit = kontenData.jumlah_unit;
                        let id_files_pointer = kontenData.id_files_pointer;
                        let keterangan = kontenData.keterangan;

                        let btnAudit = '';
                        if (id_audit == 0) {
                            // Tombol submit audit
                            btnAudit = `
                                <button 
                                    class="btn btn-primary submit-button" 
                                    data-cekvalid="${is_iiv_valid}" 
                                    data-insert="${kontenData.id_iimxxmh},${kontenData.batch_number},${kontenData.expired_date_ymd},${kontenData.wlpxxmh_kode},${kontenData.id_wloxxmh}, ${kontenData.jumlah_iiv_terkecil}">
                                    Next
                                </button>
                            `;
                        } else {
                            btnAudit = `
                                <button 
                                    class="btn btn-warning edit-button" 
                                    data-cekvalid="${is_iiv_valid}" 
                                    data-id="${id_audit}" 
                                    data-editor-id = row_${id_audit}
                                    data-insert="${kontenData.id_iimxxmh},${kontenData.batch_number},${kontenData.expired_date_ymd},${kontenData.wlpxxmh_kode},${kontenData.id_wloxxmh}, ${kontenData.jumlah_iiv_terkecil},${kontenData.id_iumxxmh_unit},${kontenData.jumlah_unit}, ${kontenData.id_files_pointer},${kontenData.keterangan}
                                    ">
                                    Edit
                                </button>
                            `;
                        }

                        let kontenValid = '';
                        if (is_iiv_valid == 1) {
                            let show_stock = '';
                            if (is_tampil_stok != 0) {
                                show_stock = `
                                    <br>
                                    On Hand Terkecil : ${numFormat(kontenData.jumlah_terkecil)} ${kontenData.iumxxmh_terkecil_kode}
                                    <br>
                                    On Hand Default : ${numFormat(kontenData.jumlah_default)} ${kontenData.iumxxmh_default_kode}
                                    <br>
                                    Reserved Terkecil : ${numFormat(kontenData.jumlah_terkecil_booking)} ${kontenData.iumxxmh_terkecil_kode}
                                    <br>
                                    Reserved Default : ${numFormat(kontenData.jumlah_default_booking)} ${kontenData.iumxxmh_default_kode}
                                    <br>
                                    <b>Available Terkecil : ${numFormat(kontenData.jumlah_terkecil_ava)} ${kontenData.iumxxmh_terkecil_kode}</b>
                                    <br>
                                    <b>Available Default : ${numFormat(kontenData.jumlah_default_ava)} ${kontenData.iumxxmh_default_kode}</b>
                                `;
                            }

                            kontenValid = `
                                <p><b>${kontenData.iimxxmh_kode} - ${kontenData.iimxxmh_nama}</b></p>
                                <p class="m-t-n-sm">
                                    Batch Number : ${kontenData.batch_number}
                                    <br>
                                    Expired Date : ${kontenData.expired_date}
                                    ${show_stock}
                                </p>
                            `;
                        } else {
                            kontenValid = '<p>Data Tidak Ditemukan!</p>';
                        }

                        let conct = (kontenData.wlpxxmh_kode !== '' && wloxxmh_nama !== '') ? '-' : '';
                        
                        let badge_is_add_new = '';

                        if (is_add_new == 1) {
                            badge_is_add_new = `<span class="badge badge-danger m-l-xs">NEW</span>`;
                        }

                        let badge_is_cut_off = '';

                        if (is_cut_off == 1) {
                            badge_is_cut_off = `<span class="badge badge-info m-l-xs">Cut OFF</span>`;
                        }

                        genKonten += `
                            <div class="${class_col}">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h3>${kontenData.wlpxxmh_kode} ${conct} ${wloxxmh_nama} ${badge_is_add_new} ${badge_is_cut_off}</h3> 
                                        ${kontenValid}
                                        ${btnAudit}
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // CREATE
                    $(document).on('click', '.submit-button', function () {
                        const isValid = $(this).data('cekvalid');
                        const insertStr = $(this).data('insert');
                        const [id_iimxxmh, batch, expired, kode, id_wloxxmh, jumlah_iiv_terkecil] = insertStr.split(',');

                        if (isValid != 1) {
                            alert('Data tidak valid untuk audit.');
                            return;
                        }
                        
                        edtisoittd_wms.create({
                            title: 'Audit Ceklok',
                            buttons: [
                                {
                                    text: 'Cancel',
                                    action: function () {
                                        this.close();
                                    },
                                    className: 'btn btn-warning m-r-xs'
                                },
                                {
                                    text: 'Save',
                                    action: function () {
                                        this.submit();
                                    },
                                    className: 'btn btn-primary m-r-xs'
                                },
                            ]
                        });

                        id_iimxxmh_old = id_iimxxmh;
                        id_wloxxmh_old = id_wloxxmh;
                        edtisoittd_wms.set({
                            "isoittd_wms.id_iimxxmh": id_iimxxmh,
                            "isoittd_wms.jumlah_iiv_terkecil": jumlah_iiv_terkecil,
                            "isoittd_wms.batch_number": batch,
                            "isoittd_wms.expired_date": moment(expired, 'YYYY-MM-DD').format('DD MMM YYYY'),
                            "isoittd_wms.wlpxxmh_kode": kode,
                            "isoittd_wms.id_wloxxmh": id_wloxxmh
                        });

                    });

                    // EDIT
                    $(document).on('click', '.edit-button', function () {
                        const isValid = $(this).data('cekvalid');
                        const insertStr = $(this).data('insert');
                        const rowId = $(this).data('id'); // ID baris yang akan diedit (pastikan ada di HTML)
                        const [id_iimxxmh, batch, expired, kode, id_wloxxmh, jumlah_iiv_terkecil, id_iumxxmh_unit, jumlah_unit,id_files_pointer, keterangan] = insertStr.split(',');
                        // console.log('id_iumxxmh_unit: '+id_iumxxmh_unit);
                        // console.log('id_wloxxmh: '+id_wloxxmh);
                        if (isValid != 1) {
                            alert('Data tidak valid untuk audit.');
                            return;
                        }

                        // Trigger editor dalam mode edit
                        edtisoittd_wms.edit(rowId, {
                            title: 'Edit Audit Ceklok',
                            buttons: [
                                {
                                    text: 'Cancel',
                                    action: function () {
                                        this.close();
                                    },
                                    className: 'btn btn-warning m-r-xs'
                                },
                                {
                                    text: 'Save',
                                    action: function () {
                                        this.submit();
                                    },
                                    className: 'btn btn-primary m-r-xs'
                                }
                            ]
                        });

                        id_iimxxmh_old = id_iimxxmh;
                        id_wloxxmh_old = id_wloxxmh;
                        id_iumxxmh_unit_old = id_iumxxmh_unit;
                        edtisoittd_wms.set({
                            "isoittd_wms.id_iimxxmh": id_iimxxmh,
                            "isoittd_wms.jumlah_iiv_terkecil": jumlah_iiv_terkecil,
                            "isoittd_wms.id_iumxxmh_unit": id_iumxxmh_unit,
                            "isoittd_wms.jumlah_unit": parseFloat(jumlah_unit).toFixed(2),
                            "isoittd_wms.batch_number": batch,
                            "isoittd_wms.expired_date": moment(expired, 'YYYY-MM-DD').format('DD MMM YYYY'),
                            "isoittd_wms.wlpxxmh_kode": kode,
                            "isoittd_wms.id_wloxxmh": id_wloxxmh,
                            "isoittd_wms.id_files_pointer": id_files_pointer,
                            "isoittd_wms.keterangan": keterangan,
                        });
                    });

                    // console.log(genKonten);
                    $('#konten').html(genKonten);
                }
            } );
        }

        
        $(document).on('click', '.add-button', function () {

            edtisoittd_wms.create({
                title: 'Audit Ceklok',
                buttons: [
                    {
                        text: 'Cancel',
                        className: 'btn btn-warning m-r-xs',
                        action: function () {
                            this.close();
                        }
                    },
                    {
                        text: 'Save',
                        className: 'btn btn-primary m-r-xs',
                        action: function () {
                            this.submit();
                        }
                    }
                ]
            });

            id_wloxxmh_old = id_wloxxmh_filter;
            edtisoittd_wms.set({
                "isoittd_wms.is_add_new": 1,
                "isoittd_wms.id_wloxxmh": id_wloxxmh_filter,
            });
        });
    }

    function wlpxxmh_kode_validasi (){
        wlpxxmh_kode = edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').val();
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
                        edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').error( json.data.message );
                        edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').val('');
                    }
                }
            } );
            
        }
    };
    
    function findIdLpn (wlpxxmh_kode){
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_find_id_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    id_wlpxxmh = json.data.id_wlpxxmh;
                    wlpxxmh_kode_validasi ();
                }
            } );
            
        }
    };
</script>