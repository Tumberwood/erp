<script>

    function validasiInput(arr_inputan, callback, is_number) {
        // var isValid = false;
        
        arr_inputan.forEach(inputField => {
            inputField = $(inputField); // Convert to jQuery object
            
            if (is_number != undefined) {
                if (isNaN(inputField.val()) || inputField.val() == '' || inputField.val() == null) {
                    inputField.addClass('is-invalid').focus();
    
                    if (!inputField.next('.invalid-feedback').length) {
                        // Create the invalid-feedback div
                        var invalidFeedback = $('<div class="invalid-feedback text-danger">Inputan harus berupa Angka!</div>');
                        // Append it after the input field
                        inputField.after(invalidFeedback);
                        inputField.next('.invalid-feedback').show();
                    }
                    isValid = false;
                    return false; // Exit the loop early
                }
            } else {
                // console.log(inputField.val());
                if (inputField.val() === '' || inputField.val() == null) {
                    // console.log('kosong');
                    flag_fill = 0;
                    inputField.addClass('is-invalid').focus();

                    if (!inputField.next('.invalid-feedback').length) {
                        
                        if (!inputField.hasClass('select2')) {
                            // Create the invalid-feedback div
                            var invalidFeedback = $('<div class="invalid-feedback text-danger">Wajib diisi!</div>');
                            // Append it after the input field
                            inputField.after(invalidFeedback);
                            inputField.next('.invalid-feedback').show();
                        }
                    }
                    isValid = false;
                    return false; // Exit the loop early
                }
            }
        });

        // console.log(isValid);
        
        arr_inputan.forEach(inputField => {
            inputField = $(inputField); // Convert to jQuery object
            inputField.on('input', function() {
                if (is_number != undefined) {
                    if (!isNaN(inputField.val())) {
                        inputField.toggleClass('is-invalid', $(this).val() == '' || $(this).val() == null);
                        inputField.next('.invalid-feedback').toggle($(this).val() == '' || $(this).val() == null);
                        isValid = true;
                    }
                } else {
                    if (inputField.val() != '' || inputField.val() != null) {
                        inputField.toggleClass('is-invalid', $(this).val() == '' || $(this).val() == null);
                        inputField.next('.invalid-feedback').toggle($(this).val() == '' || $(this).val() == null);
                        isValid = true;
                    }
                }
            });
        });
        // Call the callback function with isValid as argument
        callback(isValid);
    }


    //ALERT KETIKA RELOAD 
    function confirmLeavePage(event) {
        event.preventDefault();
    }

    window.addEventListener('beforeunload', confirmLeavePage);
    $(window).on('unload', function() {
        updateJson();
    });

    function updateJson() {
        var data = {
            id_hcd: id_hcdxxmh
        };
        // Convert data to JSON format
        var jsonData = JSON.stringify(data);
        console.log(jsonData);
        // Send data asynchronously using navigator.sendBeacon
        navigator.sendBeacon('usersc/applications/models/hcdxxmh/hcdxxmh_remove.php', jsonData);
    }

    document.getElementById('hcddcmh_is_npwp').addEventListener('change', function() {
        var npwpSection = document.getElementById('npwp');
        var npwpValue = this.value;
        
        if (npwpValue === '1') {
            npwpSection.style.display = 'block';
        } else {
            npwpSection.style.display = 'none';
            $('#hcddcmh_npwp_no').val('');
            $('#hcddcmh_npwp_alamat').val('');
            $('#hcddcmh_id_gctxxmh_npwp').val('');
            $('#hcddcmh_id_gtxpkmh').val('');
        }
    });

    function appendAjax() {
        var hcddcmh_ktp_no = $('#hcddcmh_ktp_no').val();
        var hcdxxmh_nama = $('#hcdxxmh_nama').val();
        var hcdxxmh_gender = $('#hcdxxmh_gender').val();
        var hcdxxmh_tanggal_lahir = $('#hcdxxmh_tanggal_lahir').val();
        var tanggal_lahir = moment(hcdxxmh_tanggal_lahir, 'DD MMM YYYY');

        // Format the parsed date into the desired format (YYYY-MM-DD)
        var tanggal_lahir_ymd = tanggal_lahir.format('YYYY-MM-DD');

        var hcddcmh_asal_sekolah = $('#hcddcmh_asal_sekolah').val();
        var files_foto = $('#hcdxxmh_id_files_foto')[0].files[0];
        var files_cv = $('#hcdxxmh_id_files_cv')[0].files[0];
        var files_ktp = $('#hcddcmh_id_files_ktp')[0].files[0];
        var files_sim = $('#hcddcmh_id_files_sim')[0].files[0];
        
        var form = $('#myForm'); // Get the form by ID
        var formData = new FormData(form[0]); // Create a FormData object from the form

        //PERSONAL DATA
        formData.append('hcdxxmh_nama', hcdxxmh_nama);
        formData.append('hcdxxmh_gender', $('#hcdxxmh_gender').val());
        formData.append('hcdxxmh_tanggal_lahir', tanggal_lahir_ymd);
        formData.append('selectid_gctxxmh_lahir', $('#selectid_gctxxmh_lahir').val());
        formData.append('hcdxxmh_agama', $('#hcdxxmh_agama').val());
        formData.append('hcdxxmh_perkawinan', $('#hcdxxmh_perkawinan').val());
        formData.append('hcdxxmh_suku', $('#hcdxxmh_suku').val());
        formData.append('hcdmdmh_gol_darah', $('#hcdmdmh_gol_darah').val());
        // formData.append('hcdxxmh_berat', $('#hcdxxmh_berat').val());
        // formData.append('hcdxxmh_tinggi', $('#hcdxxmh_tinggi').val());
        // formData.append('hcdxxmh_no_sepatu', $('#hcdxxmh_no_sepatu').val());
        // formData.append('hcdxxmh_ukuran_seragam', $('#hcdxxmh_ukuran_seragam').val());

        //SOSMED
        formData.append('hcdcsmh_email_personal', $('#hcdcsmh_email_personal').val());
        formData.append('hcdcsmh_twitter', $('#hcdcsmh_twitter').val());
        formData.append('hcdcsmh_facebook', $('#hcdcsmh_facebook').val());
        formData.append('hcdcsmh_linkedin', $('#hcdcsmh_linkedin').val());
        formData.append('hcdcsmh_instagram', $('#hcdcsmh_instagram').val());
        formData.append('hcdcsmh_tiktok', $('#hcdcsmh_tiktok').val());
        formData.append('hcdcsmh_handphone', $('#hcdcsmh_handphone').val());
        formData.append('hcdcsmh_whatsapp', $('#hcdcsmh_whatsapp').val());
        formData.append('hcdcsmh_alamat_tinggal', $('#hcdcsmh_alamat_tinggal').val());
        formData.append('kota_tinggal', $('#kota_tinggal').val());
        // formData.append('rt', $('#rt').val());
        // formData.append('rw', $('#rw').val());
        // formData.append('kelurahan', $('#kelurahan').val());
        // formData.append('kecamatan', $('#kecamatan').val());

        //DOKUMEN
        formData.append('hcddcmh_ktp_no', hcddcmh_ktp_no);
        formData.append('hcddcmh_ktp_alamat', $('#hcddcmh_ktp_alamat').val());
        formData.append('kota_ktp', $('#kota_ktp').val());
        formData.append('hcddcmh_sim_a', $('#hcddcmh_sim_a').val());
        formData.append('hcddcmh_sim_b', $('#hcddcmh_sim_b').val());
        formData.append('hcddcmh_sim_c', $('#hcddcmh_sim_c').val());
        formData.append('hcddcmh_is_npwp', $('#hcddcmh_is_npwp').val());
        formData.append('hcddcmh_npwp_no', $('#hcddcmh_npwp_no').val());
        formData.append('hcddcmh_npwp_alamat', $('#hcddcmh_npwp_alamat').val());
        formData.append('hcddcmh_id_gctxxmh_npwp', $('#hcddcmh_id_gctxxmh_npwp').val());
        formData.append('hcddcmh_id_gtxpkmh', $('#hcddcmh_id_gtxpkmh').val());
        // formData.append('hobby', $('#hobby').val());

        //LAIN LAIN
        formData.append('hcdjbmh_bpjskes_no', $('#hcdjbmh_bpjskes_no').val());
        formData.append('hcdjbmh_bpjstk_no', $('#hcdjbmh_bpjstk_no').val());
        formData.append('hcdjbmh_tempat_tinggal', $('#hcdjbmh_tempat_tinggal').val());
        formData.append('hcdjbmh_kendaraan', $('#hcdjbmh_kendaraan').val());
        formData.append('hcdjbmh_kendaraan_milik', $('#hcdjbmh_kendaraan_milik').val());

        for (var i = 1; i <= 13; i++) {
            formData.append('hcdjbmh_intrv_self_' + i, $('#hcdjbmh_intrv_self_' + i).val());
        }

        //FOTO KANDIDAT
        formData.append('hcdxxmh_id_files_foto', files_foto);
        //CV KANDIDAT
        formData.append('hcdxxmh_id_files_cv', files_cv);
        //KTP
        formData.append('hcddcmh_id_files_ktp', files_ktp);
        //SIM
        formData.append('hcddcmh_id_files_sim', files_sim);
        
        return formData;
    }

    function confirmData(id_hcd) {
        $('#confirm').click(function() {
            // console.log(nama_tabels_d);
            $.ajax( {
                url: 'usersc/applications/models/hcdxxmh/fn_cek_detail.php',
                dataType: 'json',
                async: false,
                type: 'POST',
                data: {
                    id_hcd: id_hcd,
                    nama_tabels_d: nama_tabels_d,
                },
                success: function ( json ) {
                    c_detail = json.data.c_detail;
                    // console.log(c_detail);
                }
            });
            console.log('c_detail luar = '+c_detail);

            var is_next_confirm = 0;
            //untuk validasi angka
            var arr_angka = [
                $('#hcdcsmh_handphone'),
                $('#hcddcmh_ktp_no'),
            ];

            validasiInput(arr_angka, function(isValid) {
                if (isValid) {
                is_next = 1;
                } else {
                is_next = 0;
                }
            }, 1);

            //untuk validasi required
            var arr_wajib = [
                $('#hcdxxmh_nama'),
                $('#hcdxxmh_gender'),
                $('#hcdxxmh_tanggal_lahir'),
                $('#selectid_gctxxmh_lahir'),
                $('#hcdxxmh_agama'),
                $('#hcdxxmh_perkawinan'),
                $('#hcdmdmh_gol_darah'),
                $('#hcdxxmh_id_files_foto'),
                $('#hcdxxmh_id_files_cv'),
                $('#hcdcsmh_alamat_tinggal'),
                $('#kota_tinggal'),
                $('#hcddcmh_ktp_alamat'),
                $('#kota_ktp'),
                $('#hcdcsmh_email_personal'),
            ];

            validasiInput(arr_wajib, function(isValid) {
                if (isValid) {
                    if (is_next == 1) {
                        is_next = 2;
                        // console.log('wkwkwk');
                    }
                }
            });

            hcddcmh_is_npwp = $('#hcddcmh_is_npwp').val();

            //jika ada npwp
            if (hcddcmh_is_npwp == 1) {
                //untuk validasi angka
                var arr_angka = [
                    $('#hcddcmh_npwp_no'),
                ];

                validasiInput(arr_angka, function(isValid) {
                if (isValid) {
                    is_next = 3;
                } else {
                    is_next = 2;
                }
                }, 1);

                //untuk validasi required
                var arr_wajib = [
                    $('#hcddcmh_npwp_alamat'),
                    $('#hcddcmh_id_gctxxmh_npwp'),
                    $('#hcddcmh_id_gtxpkmh'),
                ];

                validasiInput(arr_wajib, function(isValid) {
                if (isValid) {
                    if (is_next == 3) {
                        is_next = 4;
                    }
                }
                });

                if (is_next == 4) {
                    if (c_detail == 7) {
                        is_next_confirm = 1;
                    } else {
                        toastr.remove();
                        toastr["info"]("Mohon isi Data di tabel Keluarga, Pendidikan, Pekerjaan, Kontak Darurat, Pelatihan, Bahasa dan Referensi","INFO");
                    }
                }
            } else {
                // console.log(is_next);
                //next = 2 karena ada 2 function yang berhasil di return atau 2 validasi
                if (is_next == 2) {
                    if (c_detail == 7) {
                        is_next_confirm = 1;
                    } else {
                        toastr.remove();
                        toastr["info"]("Mohon isi Data di tabel Keluarga, Pendidikan, Pekerjaan, Kontak Darurat, Pelatihan, Bahasa dan Referensi","INFO");
                    }
                }
            }

            if (is_next_confirm == 1) {
                confirmAlert = confirm('Apakah anda yakin untuk melakukan konfirmasi data kandidat?')
                if (confirmAlert) {
                    toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO");
                    
                    formData = appendAjax();
                    formData.append('id_hcd', id_hcd);

                    $.ajax({
                        url: 'usersc/applications/models/hcdxxmh/hcdxxmh_create.php',
                        type: 'POST',
                        async: false,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function ( json ) {
                            var response = JSON.parse(json);
                            // console.log(response);
                            toastr.remove();
                            toastr[response.type_message](response.message,"INFO");
                            // id_hcdxxmh = response.id_hcdxxmh;
                            // window.location.reload();
                            // console.log('id_hcdxxmh ajax create = '+id_hcdxxmh);
                            window.removeEventListener('beforeunload', confirmLeavePage);
                            window.location.reload();
                        }
                    });
                } 
            } else {

            }
            
        });
    }
    

    function select2Kota(select2Element, id_gct) {
        if(id_gct == undefined ){
            id_gct = 0;
        }

        // console.log(id_gct);
        select2Element.select2({
            placeholder: "Select",
            allowClear: true,
            multiple: false,
            ajax: {
                url: "usersc/applications/models/core/gctxxmh_fn_opt.php",
                dataType: 'json',
                data: function (params) {
                    var query = {
                        id_gctxxmh_old: id_gct,
                        search: params.term || '',
                        page: params.page || 1
                    }
                        return query;
                },
                processResults: function(data, params) {
                    return {
                        results: data.results,
                        pagination: {
                            more: true
                        }
                    };
                },
                cache: true,
                minimumInputLength: 1,
                maximum: 10,
                delay: 500,
                maximumSelectionLength: 5,
                minimumResultsForSearch: -1
            }
        });
    }

    function select2Ptkp(select2Element, id_gtx) {
        if(id_gtx == undefined ){
            id_gtx = 0;
        }
        select2Element.select2({
            placeholder: "Select",
            allowClear: true,
            multiple: false,
            ajax: {
                url: "usersc/applications/models/gtxpkmh/gtxpkmh_fn_opt.php",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        id_gtxpkmh_old: id_gtx,
                        gtxpkmh_nama: '',
                        search: params.term || '',
                        page: params.page || 1
                    };

                    return query;
                },
                processResults: function(data, params) {
                    var options = data.results.map(function(result) {
                        return {
                            id: result.id,
                            text: result.text
                        };
                    });

                    if (params.page && params.page === 1) {
                        select2Element.empty().select2({ data: options });
                    } else {
                        select2Element.append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
                    }

                    return {
                        results: options,
                        pagination: {
                            more: true
                        }
                    };
                },
                cache: true,
                minimumInputLength: 1,
                maximum: 10,
                delay: 500,
                maximumSelectionLength: 5,
                minimumResultsForSearch: -1
            }
        });
    }

    function family(id_hcdxxmh) {
        // --------- start _detail --------------- //
			//start datatables editor
			edthcdfmmd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "usersc/applications/models/hcdxxmh/hcdfmmd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hcdfmmd = show_deleted_hcdfmmd;
						d.id_hcdxxmh = id_hcdxxmh;
					}
				},
				table: "#tblhcdfmmd",
				formOptions: {
					main: {
						focus: 3
					}
				},
				fields: [ 
					{
						label: "start_on",
						name: "start_on",
						type: "hidden"
					},	{
						label: "finish_on",
						name: "finish_on",
						type: "hidden"
					},	{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "hcdfmmd",
						type: "hidden"
					},	{
						label: "id_hcdxxmh",
						name: "hcdfmmd.id_hcdxxmh",
						type: "hidden"
					},	{
						label: "Active Status",
						name: "hcdfmmd.transaction_state",
                        type: "hidden",
						def: 1
					}, 	{
						label: "Hubungan <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.hubungan",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Diri Sendiri", "value": "Diri Sendiri" },
							{ "label": "Ayah", "value": "Ayah" },
							{ "label": "Ibu", "value": "Ibu" },
							{ "label": "Kakak", "value": "Kakak" },
							{ "label": "Adik", "value": "Adik" },
							{ "label": "Suami", "value": "Suami" },
							{ "label": "Istri", "value": "Istri" },
							{ "label": "Anak", "value": "Anak" }
						]
					},	{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.nama"
					}, 	{
						label: "Tempat Lahir <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.id_gctxxmh_lahir",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "usersc/applications/models/core/gctxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_gctxxmh_old: id_gctxxmh_lahir_fam_old,
										search: params.term || '',
										page: params.page || 1
									}
										return query;
								},
								processResults: function (data, params) {
									return {
										results: data.results,
										pagination: {
											more: true
										}
									};
								},
								cache: true,
								minimumInputLength: 1,
								maximum: 10,
								delay: 500,
								maximumSelectionLength: 5,
								minimumResultsForSearch: -1,
							},
						}
					},	{
						label: "Tanggal Lahir <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.tanggal_lahir",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY'
					}, 	{
						label: "Jenis Kelamin <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.gender",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Laki-laki", "value": "Laki-laki" },
							{ "label": "Perempuan", "value": "Perempuan" }
						]
					},	{
						label: "Pendidikan Terakhir <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.id_hedlvmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "usersc/applications/models/hedlvmh/hedlvmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_hedlvmh_old: id_hedlvmh_fam_old,
										search: params.term || '',
										page: params.page || 1
									}
										return query;
								},
								processResults: function (data, params) {
									return {
										results: data.results,
										pagination: {
											more: true
										}
									};
								},
								cache: true,
								minimumInputLength: 1,
								maximum: 10,
								delay: 500,
								maximumSelectionLength: 5,
								minimumResultsForSearch: -1,
							},
						}
					},	{
						label: "Pekerjaan <sup class='text-danger'>*<sup>",
						name: "hcdfmmd.pekerjaan"
					}
				]
			} );
			
			edthcdfmmd.on( 'preOpen', function( e, mode, action ) {
				edthcdfmmd.field('hcdfmmd.id_hcdxxmh').val(id_hcdxxmh);
				
				start_on = moment().format('YYYY-MM-DD HH:mm:ss');
				edthcdfmmd.field('start_on').val(start_on);

				if(action == 'create'){
					tblhcdfmmd.rows().deselect();
				}
			});

            edthcdfmmd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
                $('div.DTE_Form_Buttons button:eq(2)').hide();
                $('div.DTE_Form_Buttons button:eq(2)').hide();
			});
			
			edthcdfmmd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
					// BEGIN of validasi hcdfmmd.hubungan 
					hubungan = edthcdfmmd.field('hcdfmmd.hubungan').val();
					if(!hubungan || hubungan == ''){
						edthcdfmmd.field('hcdfmmd.hubungan').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.hubungan 

					// BEGIN of validasi hcdfmmd.nama 
					nama = edthcdfmmd.field('hcdfmmd.nama').val();
					if(!nama || nama == ''){
						edthcdfmmd.field('hcdfmmd.nama').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.nama 

					// BEGIN of validasi hcdfmmd.id_gctxxmh_lahir 
					id_gctxxmh_lahir = edthcdfmmd.field('hcdfmmd.id_gctxxmh_lahir').val();
					if(!id_gctxxmh_lahir || id_gctxxmh_lahir == ''){
						edthcdfmmd.field('hcdfmmd.id_gctxxmh_lahir').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.id_gctxxmh_lahir 

					// BEGIN of validasi hcdfmmd.tanggal_lahir 
					tanggal_lahir = edthcdfmmd.field('hcdfmmd.tanggal_lahir').val();
					if(!tanggal_lahir || tanggal_lahir == ''){
						edthcdfmmd.field('hcdfmmd.tanggal_lahir').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.tanggal_lahir 

					// BEGIN of validasi hcdfmmd.gender 
					gender = edthcdfmmd.field('hcdfmmd.gender').val();
					if(!gender || gender == ''){
						edthcdfmmd.field('hcdfmmd.gender').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.gender 

					// BEGIN of validasi hcdfmmd.id_hedlvmh 
					id_hedlvmh = edthcdfmmd.field('hcdfmmd.id_hedlvmh').val();
					if(!id_hedlvmh || id_hedlvmh == ''){
						edthcdfmmd.field('hcdfmmd.id_hedlvmh').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.id_hedlvmh 

					// BEGIN of validasi hcdfmmd.pekerjaan 
					pekerjaan = edthcdfmmd.field('hcdfmmd.pekerjaan').val();
					if(!pekerjaan || pekerjaan == ''){
						edthcdfmmd.field('hcdfmmd.pekerjaan').error( 'Wajib diisi!' );
					}
					// END of validasi hcdfmmd.pekerjaan 
				}
				
				if ( edthcdfmmd.inError() ) {
					return false;
				}
			});

			edthcdfmmd.on('initSubmit', function(e, action) {
				finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
				edthcdfmmd.field('finish_on').val(finish_on);
			});
			
			edthcdfmmd.on( 'postSubmit', function (e, json, data, action, xhr) {
				// event setelah Create atau Edit, dibedakan dari parameter action
				// action : "create" | "edit"
				// do something
			} );
			
			//start datatables
			tblhcdfmmd = $('#tblhcdfmmd').DataTable( {
				ajax: {
					url: "usersc/applications/models/hcdxxmh/hcdfmmd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hcdfmmd = show_deleted_hcdfmmd;
						d.id_hcdxxmh = id_hcdxxmh;
					}
				},
				order: [[ 2, "desc" ]],
                paging: false,
                searching: false,
            info: false,
				columns: [
					{ data: "hcdfmmd.id",visible:false },
					{ data: "hcdfmmd.id_hcdxxmh",visible:false },
					{ data: "hcdfmmd.hubungan" },
					{ data: "hcdfmmd.nama" },
					{ data: "hcdfmmd.gender" },
					{ data: "gctxxmh.nama" },
					{ data: "hcdfmmd.tanggal_lahir" },
					{ data: "hedlvmh.nama" },
					{ data: "hcdfmmd.pekerjaan" }
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_hcdfmmd';
						$table       = 'tblhcdfmmd';
						$edt         = 'edthcdfmmd';
						$show_status = '_hcdfmmd';
						$table_name  = $nama_tabels_d[0];

						$arr_buttons_tools 		= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove'];
						$arr_buttons_tools2 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				rowCallback: function( row, data, index ) {
					if ( data.hcdfmmd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}
				}
			} );

			tblhcdfmmd.on( 'draw', function( e, settings ) { 
            if (id_hcdxxmh == '') {
                tblhcdfmmd.button('btnCreate:name').disable();
            } else {
                tblhcdfmmd.button('btnCreate:name').enable();
            }
				// atur hak akses
				cek_c_detail= 1;
			} );

			tblhcdfmmd.on( 'select', function( e, dt, type, indexes ) {
				data_hcdfmmd = tblhcdfmmd.row( { selected: true } ).data().hcdfmmd;
				id_hcdfmmd   = data_hcdfmmd.id;
				id_transaksi_d    = id_hcdfmmd; // dipakai untuk general
				transaction_state_d       = data_hcdfmmd.transaction_state;
				id_hedlvmh_fam_old       = data_hcdfmmd.id_hedlvmh;
				id_gctxxmh_lahir_fam_old       = data_hcdfmmd.id_gctxxmh_lahir;
				
			} );

			tblhcdfmmd.on( 'deselect', function() {
				id_hcdfmmd = '';
				transaction_state_d = 0;
				id_hedlvmh_fam_old = 0;
				id_gctxxmh_lahir_fam_old = 0;
			} );

        // --------- end _detail --------------- //	
    }

    function education(id_hcdxxmh) {
        
        // --------- start _detail pendidikan--------------- //

        //start datatables editor
        edthcdedmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdedmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdedmd = show_deleted_hcdedmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdedmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdedmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdedmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdedmd.transaction_state",
                    type: "hidden",
                    def: 0
                }, 	{
                    label: "Jenjang Pendidikan <sup class='text-danger'>*<sup>",
                    name: "hcdedmd.id_hedlvmh",
                    type: "select2",
                    opts: {
                        placeholder : "Select",
                        allowClear: true,
                        multiple: false,
                        ajax: {
                            url: "usersc/applications/models/hedlvmh/hedlvmh_fn_opt.php",
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    id_hedlvmh_old: id_hedlvmh_edu_old,
                                    search: params.term || '',
                                    page: params.page || 1
                                }
                                    return query;
                            },
                            processResults: function (data, params) {
                                return {
                                    results: data.results,
                                    pagination: {
                                        more: true
                                    }
                                };
                            },
                            cache: true,
                            minimumInputLength: 1,
                            maximum: 10,
                            delay: 500,
                            maximumSelectionLength: 5,
                            minimumResultsForSearch: -1,
                        },
                    }
                },	{
                    label: "Nama Institusi <sup class='text-danger'>*<sup>",
                    name: "hcdedmd.nama"
                }, 	{
                    label: "Kota <sup class='text-danger'>*<sup>",
                    name: "hcdedmd.id_gctxxmh",
                    type: "select2",
                    opts: {
                        placeholder : "Select",
                        allowClear: true,
                        multiple: false,
                        ajax: {
                            url: "usersc/applications/models/core/gctxxmh_fn_opt.php",
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    id_gctxxmh_old: id_gctxxmh_edu_old,
                                    search: params.term || '',
                                    page: params.page || 1
                                }
                                    return query;
                            },
                            processResults: function (data, params) {
                                return {
                                    results: data.results,
                                    pagination: {
                                        more: true
                                    }
                                };
                            },
                            cache: true,
                            minimumInputLength: 1,
                            maximum: 10,
                            delay: 500,
                            maximumSelectionLength: 5,
                            minimumResultsForSearch: -1,
                        },
                    }
                },	{
                    label: "Tahun Lulus",
                    name: "hcdedmd.tahun_lulus"
                },	{
                    label: "Jurusan",
                    name: "hcdedmd.jurusan"
                },	{
                    label: "Nilai Akhir",
                    name: "hcdedmd.nilai_akhir"
                }
            ]
        } );

        edthcdedmd.on( 'preOpen', function( e, mode, action ) {
            edthcdedmd.field('hcdedmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdedmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdedmd.rows().deselect();
            }
        });

        edthcdedmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdedmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcdedmd.nama 
                nama = edthcdedmd.field('hcdedmd.nama').val();
                if(!nama || nama == ''){
                    edthcdedmd.field('hcdedmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdedmd.nama 

                // BEGIN of validasi hcdedmd.id_gctxxmh 
                id_gctxxmh = edthcdedmd.field('hcdedmd.id_gctxxmh').val();
                if(!id_gctxxmh || id_gctxxmh == ''){
                    edthcdedmd.field('hcdedmd.id_gctxxmh').error( 'Wajib diisi!' );
                }
                // END of validasi hcdedmd.id_gctxxmh 

                // BEGIN of validasi hcdedmd.id_hedlvmh 
                id_hedlvmh = edthcdedmd.field('hcdedmd.id_hedlvmh').val();
                if(!id_hedlvmh || id_hedlvmh == ''){
                    edthcdedmd.field('hcdedmd.id_hedlvmh').error( 'Wajib diisi!' );
                }
                // END of validasi hcdedmd.id_hedlvmh 


                tahun_lulus = edthcdedmd.field('hcdedmd.tahun_lulus').val();
                // validasi angka
                if(isNaN(tahun_lulus) ){
                    edthcdedmd.field('hcdedmd.tahun_lulus').error( 'Inputan harus berupa Angka!' );
                }

                nilai_akhir = edthcdedmd.field('hcdedmd.nilai_akhir').val();
                // validasi angka
                if(isNaN(nilai_akhir) ){
                    edthcdedmd.field('hcdedmd.nilai_akhir').error( 'Inputan harus berupa Angka!' );
                }
            }
            
            if ( edthcdedmd.inError() ) {
                return false;
            }
        });

        edthcdedmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdedmd.field('finish_on').val(finish_on);
        });

        edthcdedmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdedmd = $('#tblhcdedmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdedmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdedmd = show_deleted_hcdedmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdedmd.id",visible:false },
                { data: "hcdedmd.id_hcdxxmh",visible:false },
                { data: "hedlvmh.nama" },
                { data: "hcdedmd.nama" },
                { data: "gctxxmh.nama" },
                { data: "hcdedmd.tahun_lulus" },
                { data: "hcdedmd.jurusan" },
                { data: "hcdedmd.nilai_akhir" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdedmd';
                    $table       = 'tblhcdedmd';
                    $edt         = 'edthcdedmd';
                    $show_status = '_hcdedmd';
                    $table_name  = $nama_tabels_d[1];

                    $arr_buttons_tools 		= [];
                    $arr_buttons_action 	= ['create', 'edit', 'remove'];
                    $arr_buttons_tools2 	= [];
                    include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
                ?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdedmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdedmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdedmd.button('btnCreate:name').disable();
            } else {
                tblhcdedmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdedmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdedmd = tblhcdedmd.row( { selected: true } ).data().hcdedmd;
            id_hcdedmd   = data_hcdedmd.id;
            id_transaksi_d    = id_hcdedmd; // dipakai untuk general
            transaction_state_d       = data_hcdedmd.transaction_state;
            id_gctxxmh_edu_old       = data_hcdedmd.id_gctxxmh;
            id_hedlvmh_edu_old       = data_hcdedmd.id_hedlvmh;
            
        } );

        tblhcdedmd.on( 'deselect', function() {
            id_hcdedmd = '';
            transaction_state_d = 0;
            id_gctxxmh_edu_old = 0;
            id_hedlvmh_edu_old = 0;
        } );
        // --------- end _detail --------------- //		
    }

    function jobs(id_hcdxxmh) {
        // --------- start _detail hcdjbmd PEKERJAAN --------------- //

        //start datatables editor
        edthcdjbmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdjbmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdjbmd = show_deleted_hcdjbmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdjbmd",
			template: "#custom_job",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdjbmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdjbmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdjbmd.transaction_state",
                    type: "hidden",
                    def: 0
                },	{
                    label: "Nama Perusahaan <sup class='text-danger'>*<sup>",
                    name: "hcdjbmd.nama"
                },	{
                    label: "Alamat",
                    name: "hcdjbmd.alamat",
                    type: "textarea"
                }, 	{
                    label: "Kota <sup class='text-danger'>*<sup>",
                    name: "hcdjbmd.id_gctxxmh",
                    type: "select2",
                    opts: {
                        placeholder : "Select",
                        allowClear: true,
                        multiple: false,
                        ajax: {
                            url: "usersc/applications/models/core/gctxxmh_fn_opt.php",
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    id_gctxxmh_old: id_gctxxmh_job_old,
                                    search: params.term || '',
                                    page: params.page || 1
                                }
                                    return query;
                            },
                            processResults: function (data, params) {
                                return {
                                    results: data.results,
                                    pagination: {
                                        more: true
                                    }
                                };
                            },
                            cache: true,
                            minimumInputLength: 1,
                            maximum: 10,
                            delay: 500,
                            maximumSelectionLength: 5,
                            minimumResultsForSearch: -1,
                        },
                    }
                },	{
                    label: "Jenis Usaha",
                    name: "hcdjbmd.jenis"
                }, {
                    label: "Tanggal Awal",
                    name: "hcdjbmd.tanggal_awal",
                    type: "datetime",
                    def: function () { 
                        return new Date(); 
                    },
                    opts:{
                        minDate: new Date('1900-01-01'),
                        firstDay: 0
                    },
                    format: 'DD MMM YYYY'
                }, {
                    label: "Tanggal Akhir",
                    name: "hcdjbmd.tanggal_akhir",
                    type: "datetime",
                    def: function () { 
                        return new Date(); 
                    },
                    opts:{
                        minDate: new Date('1900-01-01'),
                        firstDay: 0
                    },
                    format: 'DD MMM YYYY'
                },	{
                    label: "jabatan Awal",
                    name: "hcdjbmd.jabatan_awal"
                },	{
                    label: "jabatan Akhir",
                    name: "hcdjbmd.jabatan_akhir"
                },	{
                    label: "Nama Atasan Langsung",
                    name: "hcdjbmd.nama_atasan"
                },	{
                    label: "Gaji Terakhir",
                    name: "hcdjbmd.gaji"
                }
            ]
        } );

        edthcdjbmd.on( 'preOpen', function( e, mode, action ) {
            edthcdjbmd.field('hcdjbmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdjbmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdjbmd.rows().deselect();
            }
        });

        edthcdjbmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdjbmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcdjbmd.nama 
                nama = edthcdjbmd.field('hcdjbmd.nama').val();
                if(!nama || nama == ''){
                    edthcdjbmd.field('hcdjbmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdjbmd.nama 

                // BEGIN of validasi hcdjbmd.id_gctxxmh 
                id_gctxxmh = edthcdjbmd.field('hcdjbmd.id_gctxxmh').val();
                if(!id_gctxxmh || id_gctxxmh == ''){
                    edthcdjbmd.field('hcdjbmd.id_gctxxmh').error( 'Wajib diisi!' );
                }
                // END of validasi hcdjbmd.id_gctxxmh 

                gaji = edthcdjbmd.field('hcdjbmd.gaji').val();
                // validasi angka
                if(isNaN(gaji) ){
                    edthcdjbmd.field('hcdjbmd.gaji').error( 'Inputan harus berupa Angka!' );
                }

            }
            
            if ( edthcdjbmd.inError() ) {
                return false;
            }
        });

        edthcdjbmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdjbmd.field('finish_on').val(finish_on);
        });

        edthcdjbmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdjbmd = $('#tblhcdjbmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdjbmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdjbmd = show_deleted_hcdjbmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdjbmd.id",visible:false },
                { data: "hcdjbmd.id_hcdxxmh",visible:false },
                { data: "hcdjbmd.nama" },
                { data: "hcdjbmd.jenis" },
                { data: "hcdjbmd.alamat" },
                { data: "gctxxmh.nama" },
                { data: "hcdjbmd.tanggal_awal" },
                { data: "hcdjbmd.tanggal_akhir" },
                { data: "hcdjbmd.jabatan_awal" },
                { data: "hcdjbmd.jabatan_akhir" },
                { data: "hcdjbmd.nama_atasan" },
                { data: "hcdjbmd.gaji",
                    render: $.fn.dataTable.render.number( ',', '.', 0,'Rp. ','' ),
                    class: "text-right" 
                }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdjbmd';
                    $table       = 'tblhcdjbmd';
                    $edt         = 'edthcdjbmd';
                    $show_status = '_hcdjbmd';
                    $table_name  = $nama_tabels_d[2];

                    $arr_buttons_tools 		= [];
                    $arr_buttons_action 	= ['create', 'edit', 'remove'];
                    $arr_buttons_tools2 	= [];
                    include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
                ?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdjbmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdjbmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdjbmd.button('btnCreate:name').disable();
            } else {
                tblhcdjbmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdjbmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdjbmd = tblhcdjbmd.row( { selected: true } ).data().hcdjbmd;
            id_hcdjbmd   = data_hcdjbmd.id;
            id_transaksi_d    = id_hcdjbmd; // dipakai untuk general
            transaction_state_d       = data_hcdjbmd.transaction_state;
            id_gctxxmh_job_old       = data_hcdjbmd.id_gctxxmh;
				
        } );

        tblhcdjbmd.on( 'deselect', function() {
            id_hcdjbmd = '';
            transaction_state_d = 0;
            id_gctxxmh_job_old = 0;
        } );

        // --------- end _detail --------------- //	
    }

    function organisasi(id_hcdxxmh) {
        // --------- start _detail hcdogmd ORGANISASI --------------- //

        //start datatables editor
        edthcdogmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdogmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdogmd = show_deleted_hcdogmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdogmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdogmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdogmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdogmd.transaction_state",
                    type: "hidden",
                    def: 0
                },	{
                    label: "Nama Organisasi <sup class='text-danger'>*<sup>",
                    name: "hcdogmd.nama"
                },	{
                    label: "Jenis Organisasi",
                    name: "hcdogmd.jenis"
                },	{
                    label: "Tahun",
                    name: "hcdogmd.tahun"
                },	{
                    label: "Jabatan",
                    name: "hcdogmd.jabatan"
                }
            ]
        } );

        edthcdogmd.on( 'preOpen', function( e, mode, action ) {
            edthcdogmd.field('hcdogmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdogmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdogmd.rows().deselect();
            }
        });

        edthcdogmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdogmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcdogmd.nama 
                nama = edthcdogmd.field('hcdogmd.nama').val();
                if(!nama || nama == ''){
                    edthcdogmd.field('hcdogmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdogmd.nama 

            }
            
            if ( edthcdogmd.inError() ) {
                return false;
            }
        });

        edthcdogmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdogmd.field('finish_on').val(finish_on);
        });

        edthcdogmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdogmd = $('#tblhcdogmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdogmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdogmd = show_deleted_hcdogmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdogmd.id",visible:false },
                { data: "hcdogmd.id_hcdxxmh",visible:false },
                { data: "hcdogmd.nama" },
                { data: "hcdogmd.jenis" },
                { data: "hcdogmd.tahun" },
                { data: "hcdogmd.jabatan" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdogmd';
                    $table       = 'tblhcdogmd';
                    $edt         = 'edthcdogmd';
                    $show_status = '_hcdogmd';
                    $table_name  = $nama_tabels_d[3];

                    $arr_buttons_tools 		= [];
                    $arr_buttons_action 	= ['create', 'edit', 'remove'];
                    $arr_buttons_tools2 	= [];
                    include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
                ?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdogmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdogmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdogmd.button('btnCreate:name').disable();
            } else {
                tblhcdogmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdogmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdogmd = tblhcdogmd.row( { selected: true } ).data().hcdogmd;
            id_hcdogmd   = data_hcdogmd.id;
            id_transaksi_d    = id_hcdogmd; // dipakai untuk general
            transaction_state_d       = data_hcdogmd.transaction_state;
        } );

        tblhcdogmd.on( 'deselect', function() {
            id_hcdogmd = '';
            transaction_state_d = 0;
        } );

        // --------- end _detail --------------- //		
    }

    function penyakit(id_hcdxxmh) {
        // --------- start _detail hcddhmd Penyakit --------------- //

        //start datatables editor
        edthcddhmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcddhmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcddhmd = show_deleted_hcddhmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcddhmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcddhmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcddhmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcddhmd.transaction_state",
                    type: "hidden",
                    def: 0
                },	{
                    label: "Jenis Penyakit <sup class='text-danger'>*<sup>",
                    name: "hcddhmd.nama"
                },	{
                    label: "Tahun",
                    name: "hcddhmd.tahun"
                },	{
                    label: "Berapa Lama",
                    name: "hcddhmd.lama"
                },	{
                    label: "Dirawat Di",
                    name: "hcddhmd.dirawat_di"
                }
            ]
        } );

        edthcddhmd.on( 'preOpen', function( e, mode, action ) {
            edthcddhmd.field('hcddhmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcddhmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcddhmd.rows().deselect();
            }
        });

        edthcddhmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcddhmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcddhmd.nama 
                nama = edthcddhmd.field('hcddhmd.nama').val();
                if(!nama || nama == ''){
                    edthcddhmd.field('hcddhmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcddhmd.nama 

            }
            
            if ( edthcddhmd.inError() ) {
                return false;
            }
        });

        edthcddhmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcddhmd.field('finish_on').val(finish_on);
        });

        edthcddhmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcddhmd = $('#tblhcddhmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcddhmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcddhmd = show_deleted_hcddhmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcddhmd.id",visible:false },
                { data: "hcddhmd.id_hcdxxmh",visible:false },
                { data: "hcddhmd.nama" },
                { data: "hcddhmd.tahun" },
                { data: "hcddhmd.lama" },
                { data: "hcddhmd.dirawat_di" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcddhmd';
                    $table       = 'tblhcddhmd';
                    $edt         = 'edthcddhmd';
                    $show_status = '_hcddhmd';
                    $table_name  = $nama_tabels_d[4];

                    $arr_buttons_tools 		= [];
                    $arr_buttons_action 	= ['create', 'edit', 'remove'];
                    $arr_buttons_tools2 	= [];
                    include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
                ?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcddhmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcddhmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcddhmd.button('btnCreate:name').disable();
            } else {
                tblhcddhmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcddhmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcddhmd = tblhcddhmd.row( { selected: true } ).data().hcddhmd;
            id_hcddhmd   = data_hcddhmd.id;
            id_transaksi_d    = id_hcddhmd; // dipakai untuk general
            transaction_state_d       = data_hcddhmd.transaction_state;
        } );

        tblhcddhmd.on( 'deselect', function() {
            id_hcddhmd = '';
            transaction_state_d = 0;
        } );

        // --------- end _detail --------------- //	
    }

    function kontakDarurat(id_hcdxxmh) {
        // --------- start _detail hcdecmd Kontak Darurat --------------- //

        //start datatables editor
        edthcdecmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdecmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdecmd = show_deleted_hcdecmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdecmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdecmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdecmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdecmd.transaction_state",
                    type: "hidden",
                    def: 0
                },	{
                    label: "Nama Kontak Darurat <sup class='text-danger'>*<sup>",
                    name: "hcdecmd.nama"
                },	{
                    label: "Alamat",
                    name: "hcdecmd.alamat"
                },	{
                    label: "No HP<sup class='text-danger'>*<sup>",
                    name: "hcdecmd.no_hp"
                },	{
                    label: "Hubungan",
                    name: "hcdecmd.hubungan",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Ayah", "value": "Ayah" },
                        { "label": "Ibu", "value": "Ibu" },
                        { "label": "Kakak", "value": "Kakak" },
                        { "label": "Adik", "value": "Adik" },
                        { "label": "Suami", "value": "Suami" },
                        { "label": "Istri", "value": "Istri" },
                        { "label": "Anak", "value": "Anak" }
                    ]
                }
            ]
        } );

        edthcdecmd.on( 'preOpen', function( e, mode, action ) {
            edthcdecmd.field('hcdecmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdecmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdecmd.rows().deselect();
            }
        });

        edthcdecmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdecmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcdecmd.nama 
                nama = edthcdecmd.field('hcdecmd.nama').val();
                if(!nama || nama == ''){
                    edthcdecmd.field('hcdecmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdecmd.nama 

                //  validasi hcdecmd.no_hp
                no_hp = edthcdecmd.field('hcdecmd.no_hp').val();
                if(!no_hp || no_hp == ''){
                    edthcdecmd.field('hcdecmd.no_hp').error( 'Wajib diisi!' );
                }
                
                // validasi min atau max angka
                if(no_hp <= 0 ){
                    edthcdecmd.field('hcdecmd.no_hp').error( 'Inputan harus > 0' );
                }
                
                // validasi angka
                if(isNaN(no_hp) ){
                    edthcdecmd.field('hcdecmd.no_hp').error( 'Inputan harus berupa Angka!' );
                }

            }
            
            if ( edthcdecmd.inError() ) {
                return false;
            }
        });

        edthcdecmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdecmd.field('finish_on').val(finish_on);
        });

        edthcdecmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdecmd = $('#tblhcdecmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdecmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdecmd = show_deleted_hcdecmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdecmd.id",visible:false },
                { data: "hcdecmd.id_hcdxxmh",visible:false },
                { data: "hcdecmd.nama" },
                { data: "hcdecmd.alamat" },
                { data: "hcdecmd.no_hp" },
                { data: "hcdecmd.hubungan" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdecmd';
                    $table       = 'tblhcdecmd';
                    $edt         = 'edthcdecmd';
                    $show_status = '_hcdecmd';
                    $table_name  = $nama_tabels_d[5];

                    $arr_buttons_tools 		= [];
                    $arr_buttons_action 	= ['create', 'edit', 'remove'];
                    $arr_buttons_tools2 	= [];
                    include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
                ?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdecmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdecmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdecmd.button('btnCreate:name').disable();
            } else {
                tblhcdecmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdecmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdecmd = tblhcdecmd.row( { selected: true } ).data().hcdecmd;
            id_hcdecmd   = data_hcdecmd.id;
            id_transaksi_d    = id_hcdecmd; // dipakai untuk general
            transaction_state_d       = data_hcdecmd.transaction_state;
        } );

        tblhcdecmd.on( 'deselect', function() {
            id_hcdecmd = '';
            transaction_state_d = 0;
        } );

        // --------- end _detail --------------- //		
    }

    function pelatihan(id_hcdxxmh) {
        // --------- start _detail hcdtrmd PELATIHAN --------------- //

        //start datatables editor
        edthcdtrmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdtrmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdtrmd = show_deleted_hcdtrmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdtrmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdtrmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdtrmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdtrmd.transaction_state",
                    type: "hidden",
                    def: 0
                },	{
                    label: "Nama Pelatihan <sup class='text-danger'>*<sup>",
                    name: "hcdtrmd.nama",
                    type: "textarea"
                },	{
                    label: "Penyelenggara <sup class='text-danger'>*<sup>",
                    name: "hcdtrmd.lembaga"
                },	{
                    label: "Bersertifikat<sup class='text-danger'>*<sup>",
                    name: "hcdtrmd.bersertifikat",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Ya", "value": "Ya" },
                        { "label": "Tidak", "value": "Tidak" }
                    ]
                }, 	{
                    label: "Sertifikat<sup class='text-danger'>*<sup>",
                    name: "hcdtrmd.id_files",
                    type: "upload",
                    display: function ( fileId, counter ) {
                        if(fileId > 0){
                            return '<a href="'+edthcdtrmd.file( 'files', fileId ).web_path+'" target="_blank">'+ edthcdtrmd.file( 'files', fileId ).filename + '</a>'; 
                        }else{
                            return '';
                        }
                    },
                    noFileText: 'File belum diinput'
                },  {
                    label: "Tanggal Mulai",
                    name: "hcdtrmd.tanggal_mulai",
                    type: "datetime",
                    def: function () { 
                        return new Date(); 
                    },
                    opts:{
                        minDate: new Date('1900-01-01'),
                        firstDay: 0
                    },
                    format: 'DD MMM YYYY'
                }, {
                    label: "Tanggal Selesai",
                    name: "hcdtrmd.tanggal_selesai",
                    type: "datetime",
                    def: function () { 
                        return new Date(); 
                    },
                    opts:{
                        minDate: new Date('1900-01-01'),
                        firstDay: 0
                    },
                    format: 'DD MMM YYYY'
                },	{
                    label: "Dibiayai Oleh",
                    name: "hcdtrmd.biayai",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Sendiri", "value": "Sendiri" },
                        { "label": "Perusahaan", "value": "Perusahaan" },
                        { "label": "Gratis", "value": "Gratis" }
                    ]
                }
            ]
        } );
        edthcdtrmd.field('hcdtrmd.id_files').hide();

        edthcdtrmd.on( 'preOpen', function( e, mode, action ) {
            edthcdtrmd.field('hcdtrmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdtrmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdtrmd.rows().deselect();
            }
        });

        edthcdtrmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdtrmd.dependent( 'hcdtrmd.bersertifikat', function ( val, data, callback ) {
            if(val == "Ya"){
                edthcdtrmd.field('hcdtrmd.id_files').show();
                edthcdtrmd.field('hcdtrmd.id_files').val();
            }else{
                edthcdtrmd.field('hcdtrmd.id_files').hide();
                edthcdtrmd.field('hcdtrmd.id_files').val('');
            }
            return {}
        }, {event: 'keyup change'})

        edthcdtrmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcdtrmd.nama 
                nama = edthcdtrmd.field('hcdtrmd.nama').val();
                if(!nama || nama == ''){
                    edthcdtrmd.field('hcdtrmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdtrmd.nama 

                // BEGIN of validasi hcdtrmd.lembaga 
                lembaga = edthcdtrmd.field('hcdtrmd.lembaga').val();
                if(!lembaga || lembaga == ''){
                    edthcdtrmd.field('hcdtrmd.lembaga').error( 'Wajib diisi!' );
                }
                // END of validasi hcdtrmd.lembaga 

                // BEGIN of validasi hcdtrmd.bersertifikat 
                bersertifikat = edthcdtrmd.field('hcdtrmd.bersertifikat').val();
                if(!bersertifikat || bersertifikat == ''){
                    edthcdtrmd.field('hcdtrmd.bersertifikat').error( 'Wajib diisi!' );
                }
                // END of validasi hcdtrmd.bersertifikat 

                if (bersertifikat == 'Ya') {
                    // BEGIN of validasi hcdtrmd.id_files 
                    id_files = edthcdtrmd.field('hcdtrmd.id_files').val();
                    if(!id_files || id_files == ''){
                        edthcdtrmd.field('hcdtrmd.id_files').error( 'Wajib diisi!' );
                    }
                    // END of validasi hcdtrmd.id_files 
                }

            }
            
            if ( edthcdtrmd.inError() ) {
                return false;
            }
        });

        edthcdtrmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdtrmd.field('finish_on').val(finish_on);
        });

        edthcdtrmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdtrmd = $('#tblhcdtrmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdtrmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdtrmd = show_deleted_hcdtrmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdtrmd.id",visible:false },
                { data: "hcdtrmd.id_hcdxxmh",visible:false },
                { data: "hcdtrmd.nama" },
                { data: "hcdtrmd.lembaga" },
                { data: "hcdtrmd.bersertifikat" },
                { data: "hcdtrmd.tanggal_mulai" },
                { data: "hcdtrmd.tanggal_selesai" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdtrmd';
                    $table       = 'tblhcdtrmd';
                    $edt         = 'edthcdtrmd';
                    $show_status = '_hcdtrmd';
                    $table_name  = $nama_tabels_d[6];

                    $arr_buttons_tools 		= [];
                    $arr_buttons_action 	= ['create', 'edit', 'remove'];
                    $arr_buttons_tools2 	= [];
                    include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
                ?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdtrmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdtrmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdtrmd.button('btnCreate:name').disable();
            } else {
                tblhcdtrmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdtrmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdtrmd = tblhcdtrmd.row( { selected: true } ).data().hcdtrmd;
            id_hcdtrmd   = data_hcdtrmd.id;
            id_transaksi_d    = id_hcdtrmd; // dipakai untuk general
            transaction_state_d       = data_hcdtrmd.transaction_state;
        } );

        tblhcdtrmd.on( 'deselect', function() {
            id_hcdtrmd = '';
            transaction_state_d = 0;
        } );

        // --------- end _detail --------------- //		
    }
    
    function bahasa(id_hcdxxmh) {
        // --------- start _detail hcdlgmd BAHASA --------------- //

        //start datatables editor
        edthcdlgmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdlgmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdlgmd = show_deleted_hcdlgmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdlgmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdlgmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdlgmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdlgmd.transaction_state",
                    type: "hidden",
                    def: 0
                }, 	{
                    label: "Bahasa <sup class='text-danger'>*<sup>",
                    name: "hcdlgmd.nama"
                },	{
                    label: "Kemampuan Mendengar	",
                    name: "hcdlgmd.mendengar",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Sangat Baik", "value": "Sangat Baik" },
                        { "label": "Baik", "value": "Baik" },
                        { "label": "Kurang Baik", "value": "Kurang Baik" }
                    ]
                },	{
                    label: "Kemampuan Membaca	",
                    name: "hcdlgmd.membaca",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Sangat Baik", "value": "Sangat Baik" },
                        { "label": "Baik", "value": "Baik" },
                        { "label": "Kurang Baik", "value": "Kurang Baik" }
                    ]
                },	{
                    label: "Kemampuan Menulis	",
                    name: "hcdlgmd.menulis",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Sangat Baik", "value": "Sangat Baik" },
                        { "label": "Baik", "value": "Baik" },
                        { "label": "Kurang Baik", "value": "Kurang Baik" }
                    ]
                },	{
                    label: "Kemampuan Percakapan	",
                    name: "hcdlgmd.percakapan",
                    type: "select",
                    placeholder : "Select",
                    options: [
                        { "label": "Sangat Baik", "value": "Sangat Baik" },
                        { "label": "Baik", "value": "Baik" },
                        { "label": "Kurang Baik", "value": "Kurang Baik" }
                    ]
                }
            ]
        } );

        edthcdlgmd.on( 'preOpen', function( e, mode, action ) {
            edthcdlgmd.field('hcdlgmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdlgmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdlgmd.rows().deselect();
            }
        });

        edthcdlgmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdlgmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){
                // BEGIN of validasi hcdlgmd.nama 
                nama = edthcdlgmd.field('hcdlgmd.nama').val();
                if(!nama || nama == ''){
                    edthcdlgmd.field('hcdlgmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdlgmd.nama 

            }
            
            if ( edthcdlgmd.inError() ) {
                return false;
            }
        });

        edthcdlgmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdlgmd.field('finish_on').val(finish_on);
        });

        edthcdlgmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdlgmd = $('#tblhcdlgmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdlgmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdlgmd = show_deleted_hcdlgmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdlgmd.id",visible:false },
                { data: "hcdlgmd.id_hcdxxmh",visible:false },
                { data: "hcdlgmd.nama" },
                { data: "hcdlgmd.membaca" },
                { data: "hcdlgmd.mendengar" },
                { data: "hcdlgmd.menulis" },
                { data: "hcdlgmd.percakapan" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdlgmd';
                    $table       = 'tblhcdlgmd';
                    $edt         = 'edthcdlgmd';
                    $show_status = '_hcdlgmd';
                    $table_name  = $nama_tabels_d[7];

						$arr_buttons_tools 		= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove'];
						$arr_buttons_tools2 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdlgmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdlgmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdlgmd.button('btnCreate:name').disable();
            } else {
                tblhcdlgmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdlgmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdlgmd = tblhcdlgmd.row( { selected: true } ).data().hcdlgmd;
            id_hcdlgmd   = data_hcdlgmd.id;
            id_transaksi_d    = id_hcdlgmd; // dipakai untuk general
            transaction_state_d       = data_hcdlgmd.transaction_state;
        } );

        tblhcdlgmd.on( 'deselect', function() {
            id_hcdlgmd = '';
            transaction_state_d = 0;
        } );

        // --------- end _detail --------------- //		
    }
    
    function referensi(id_hcdxxmh) {
        // --------- start _detail hcdrfmd Kontak Darurat --------------- //

        //start datatables editor
        edthcdrfmd = new $.fn.dataTable.Editor( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdrfmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdrfmd = show_deleted_hcdrfmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            table: "#tblhcdrfmd",
            formOptions: {
                main: {
                    focus: 3
                }
            },
            fields: [ 
                {
                    label: "start_on",
                    name: "start_on",
                    type: "hidden"
                },	{
                    label: "finish_on",
                    name: "finish_on",
                    type: "hidden"
                },	{
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "hcdrfmd",
                    type: "hidden"
                },	{
                    label: "id_hcdxxmh",
                    name: "hcdrfmd.id_hcdxxmh",
                    type: "hidden"
                },	{
                    label: "Active Status",
                    name: "hcdrfmd.transaction_state",
                    type: "hidden",
                    def: 0
                },	{
                    label: "Nama Referensi <sup class='text-danger'>*<sup>",
                    name: "hcdrfmd.nama"
                },	{
                    label: "Alamat",
                    name: "hcdrfmd.alamat"
                },	{
                    label: "Pekerjaan",
                    name: "hcdrfmd.pekerjaan"
                },	{
                    label: "No HP",
                    name: "hcdrfmd.no_hp"
                },	{
                    label: "Hubungan",
                    name: "hcdrfmd.hubungan"
                }
            ]
        } );

        edthcdrfmd.on( 'preOpen', function( e, mode, action ) {
            edthcdrfmd.field('hcdrfmd.id_hcdxxmh').val(id_hcdxxmh);
            
            start_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdrfmd.field('start_on').val(start_on);

            if(action == 'create'){
                tblhcdrfmd.rows().deselect();
            }
        });

        edthcdrfmd.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        });

        edthcdrfmd.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){

                // BEGIN of validasi hcdrfmd.nama 
                nama = edthcdrfmd.field('hcdrfmd.nama').val();
                if(!nama || nama == ''){
                    edthcdrfmd.field('hcdrfmd.nama').error( 'Wajib diisi!' );
                }
                // END of validasi hcdrfmd.nama 

            }
            
            if ( edthcdrfmd.inError() ) {
                return false;
            }
        });

        edthcdrfmd.on('initSubmit', function(e, action) {
            finish_on = moment().format('YYYY-MM-DD HH:mm:ss');
            edthcdrfmd.field('finish_on').val(finish_on);
        });

        edthcdrfmd.on( 'postSubmit', function (e, json, data, action, xhr) {
            // event setelah Create atau Edit, dibedakan dari parameter action
            // action : "create" | "edit"
            // do something
        } );

        //start datatables
        tblhcdrfmd = $('#tblhcdrfmd').DataTable( {
            ajax: {
                url: "usersc/applications/models/hcdxxmh/hcdrfmd.php",
                type: 'POST',
                data: function (d){
                    d.show_deleted_hcdrfmd = show_deleted_hcdrfmd;
                    d.id_hcdxxmh = id_hcdxxmh;
                }
            },
            order: [[ 2, "desc" ]],
            paging: false,
            searching: false,
            info: false,
            columns: [
                { data: "hcdrfmd.id",visible:false },
                { data: "hcdrfmd.id_hcdxxmh",visible:false },
                { data: "hcdrfmd.nama" },
                { data: "hcdrfmd.alamat" },
                { data: "hcdrfmd.pekerjaan" },
                { data: "hcdrfmd.no_hp" },
                { data: "hcdrfmd.hubungan" }
            ],
            buttons: [
                // BEGIN breaking generate button
                <?php
                    $id_table    = 'id_hcdrfmd';
                    $table       = 'tblhcdrfmd';
                    $edt         = 'edthcdrfmd';
                    $show_status = '_hcdrfmd';
                    $table_name  = $nama_tabels_d[8];

						$arr_buttons_tools 		= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove'];
						$arr_buttons_tools2 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
                // END breaking generate button
            ],
            rowCallback: function( row, data, index ) {
                if ( data.hcdrfmd.transaction_state == -9 ) {
                    $('td', row).addClass('text-danger');
                }
            }
        } );

        tblhcdrfmd.on( 'draw', function( e, settings ) { 
            // atur hak akses
            if (id_hcdxxmh == '') {
                tblhcdrfmd.button('btnCreate:name').disable();
            } else {
                tblhcdrfmd.button('btnCreate:name').enable();
            }
            cek_c_detail= 1;
        } );

        tblhcdrfmd.on( 'select', function( e, dt, type, indexes ) {
            data_hcdrfmd = tblhcdrfmd.row( { selected: true } ).data().hcdrfmd;
            id_hcdrfmd   = data_hcdrfmd.id;
            id_transaksi_d    = id_hcdrfmd; // dipakai untuk general
            transaction_state_d       = data_hcdrfmd.transaction_state;
        } );

        tblhcdrfmd.on( 'deselect', function() {
            id_hcdrfmd = '';
            transaction_state_d = 0;
        } );

        // --------- end _detail --------------- //		
    }
</script>