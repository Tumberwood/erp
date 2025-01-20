<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wreittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSFwreittd" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode">
												<input type="text" id="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="table-responsive">
                    <table id="tblwreittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>User</th>
                                <th>Warehouse</th>
                                <th>Location</th>
                                <th data-priority="1">LPN</th>
                                <th>Supplier</th>
                                <th>Item Code</th>
                                <th data-priority="2">Item Name</th>
                                <th>UoM</th>
                                <th>Qty</th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wreittd/fn/wreittd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwreittd, tblwreittd, show_deleted_wreittd = 0, id_wreittd;
	// ------------- end of default variable
	
	var id_iwhxxmh_old =0, id_iwhxxmh = 0, id_wloxxmh_old = 0, id_wroxxth = 0, id_wroxxth_old = 0, id_wroittd = 0, id_iimxxmh = 0, id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;

	// get tableRelation
	tableRelation('wreittd');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wreittd
		edtwreittd = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 5,
				}
			},
			ajax: {
				url: "../../models/wreittd/wreittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wreittd = show_deleted_wreittd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwreittd",
			fields: [ 
				{
					label: "wreittd.start_at",
					name: "wreittd.start_at",
					type: "hidden"
				},	
				{
					label: "wreittd.finish_at",
					name: "wreittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wreittd",
					type: "hidden"
				},	
				{
					label: "wreittd.transaction_state",
					name: "wreittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "wreittd.id_wroittd",
					name: "wreittd.id_wroittd",
					type: "hidden"
				},
				{
					label: "Warehouse",
					name: "wreittd.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iwhxxmh_old: id_iwhxxmh_old,
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
				},
				{
					label: "Location",
					name: "wreittd.id_wloxxmh",
					id: "select_wloxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
									ids_wloctmh: 1,
									id_iwhxxmh: id_iwhxxmh,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
                                var options = data.results.map(function (result) {
									return {
										id: result.id,
										text: result.text
									};
								});

								//add by ferry agar auto select 07 sep 23
								if (params.page && params.page === 1) {
									$('#select_wloxxmh').empty().select2({ data: options });
								} else {
									$('#select_wloxxmh').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
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
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "LPN <sup class='text-danger'>*<sup>",
					name: "wreittd.wlpxxmh_kode"
				}, 	
				{
					label: "wreittd.id_wlpxxmh",
					name: "wreittd.id_wlpxxmh",
					type: "hidden"
				}, 	
				{
					label: "Receive Order <sup class='text-danger'>*<sup>",
					name: "wreittd.id_wroxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wroxxth/wroxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wroxxth_old: id_wroxxth_old,
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
				},
				{
					label: "wreittd.id_grlxxmh_supplier",
					name: "wreittd.id_grlxxmh_supplier",
					type: "hidden"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wreittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_wroxxth.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									id_wroxxth: id_wroxxth,
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
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wreittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
				},
				{
					label: "Jumlah <sup class='text-danger'>*<sup>",
					name: "wreittd.jumlah_unit"
				},
				{
					label: "Batch Number",
					name: "wreittd.batch_number"
				},
				{
					label: "Expired Date",
					name: "wreittd.expired_date",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Keterangan",
					name: "wreittd.keterangan",
					type: "textarea"
				}
			]
		} );

		//masking
		unmaskedData = maskingNumber(
			edtwreittd, 
			"wreittd", 
			[
				"jumlah_unit", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);

		edtwreittd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwreittd.field('wreittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwreittd.rows().deselect();
			}
		});

		edtwreittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();

		});
		
		edtwreittd.dependent( 'wreittd.id_iwhxxmh', function ( val, data, callback ) {
			id_iwhxxmh = val;
			edtwreittd.field('wreittd.id_wloxxmh').input().val(null).trigger('change');
			
			$('#select_wloxxmh').select2('open');

            setTimeout(function() {
                $('#select_wloxxmh').select2('close');
            }, 5);
			return {}
		}, {event: 'keyup change'});

		edtwreittd.dependent( 'wreittd.id_wroxxth', function ( val, data, callback ) {
			id_wroxxth = val;
			wreittd_fn_wroiitd(id_wroxxth, id_iimxxmh);
			autofillField('wroxxth', id_wroxxth, 'id_grlxxmh_supplier');
			edtwreittd.field('wreittd.id_grlxxmh_supplier').val(autofillData.id_grlxxmh_supplier);
			edtwreittd.field('wreittd.id_iimxxmh').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtwreittd.dependent( 'wreittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			wreittd_fn_wroiitd(id_wroxxth, id_iimxxmh);
			autofillField('iimxxmh', id_iimxxmh, 'is_batch_number, is_expired_date');
			is_batch_number = autofillData.is_batch_number;
			is_expired_date = autofillData.is_expired_date;

			if (is_batch_number == 1) {
				edtwreittd.field('wreittd.batch_number').label("Batch Number <sup class='text-danger'>*<sup>")
			} else {
				edtwreittd.field('wreittd.batch_number').label("Batch Number")
			}

			if (is_expired_date == 1) {
				edtwreittd.field('wreittd.expired_date').label("Expired Date <sup class='text-danger'>*<sup>")
			} else {
				edtwreittd.field('wreittd.expired_date').label("Expired Date")
			}
			return {}
		}, {event: 'keyup change'});

		edtwreittd.dependent( 'wreittd.wlpxxmh_kode', function ( val, data, callback ) {
			findIdLpn(val);
			return {}
		}, {event: 'keyup change'});
		
		edtwreittd.on( 'preSubmit', function (e, data, action) {

			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_wreittd;
			}

			if(action != 'remove'){
				autofillField('ggswmsh', 1, 'is_replenishment');
				is_replenishment = autofillData.is_replenishment;

				wlpxxmh_kode    = edtwreittd.field('wreittd.wlpxxmh_kode').val();
				id_wroxxth      = edtwreittd.field('wreittd.id_wroxxth').val();
				id_iimxxmh      = edtwreittd.field('wreittd.id_iimxxmh').val();
				id_iumxxmh_unit = edtwreittd.field('wreittd.id_iumxxmh_unit').val();
				jumlah_unit     = unmaskedData.jumlah_unit;
				expired_date     = edtwreittd.field('wreittd.expired_date').val();
				batch_number     = edtwreittd.field('wreittd.batch_number').val();

				validasiRequired(
					edtwreittd,
					'wreittd',
					{
						'wlpxxmh_kode'   : wlpxxmh_kode,
						'id_wroxxth'     : id_wroxxth,
						'id_iimxxmh'     : id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);

				validasiTanggalValid(
					edtwreittd, 
					'wreittd', 
					{
						'expired_date'   : expired_date
					}
				)

				if(action == 'create'){
					id_transaksi = 0;
				}
				
				$.ajax( {
					url: '../../../helpers/validate_fn_unique.php',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						table_name      : 'wreittd',
						nama_field      : 'wlpxxmh_kode',
						nama_field_value: '"'+wlpxxmh_kode+'"',
						id_transaksi    : id_wreittd
					},
					success: function ( json ) {
						if(json.data.count > 0){
							edtwreittd.field('wreittd.wlpxxmh_kode').error( 'LPN sudah pernah dipakai' );
						}
					}
				} );
				
				// validasiUnique(
				//     action,
				//     edtwreittd,
				//     'wreittd',
				//     'wlpxxmh_kode',
				//     'wlpxxmh_kode',
				//     '"'+wlpxxmh_kode+'"',
				//     id_wreittd
				// );

				wlpxxmh_kode_validasi();

				validasiTanggalToday(
					edtwreittd, 'wreittd', 'expired_date', expired_date, '>='
				)

				if (is_replenishment == 1) {
					uomReplenishment(id_iimxxmh, id_iumxxmh_unit);

					
				}
				validasiOutstandingMask(
					edtwreittd, 'wreittd', id_transaksi, id_wroittd, 'wroittd'
				)
				autofillField('iimxxmh', id_iimxxmh, 'is_batch_number, is_expired_date');
				is_batch_number = autofillData.is_batch_number;
				is_expired_date = autofillData.is_expired_date;

				if (is_batch_number == 1) {
					validasiRequired(
						edtwreittd,
						'wreittd',
						{
							'batch_number'   : batch_number,
						}
					);
				}

				if (is_expired_date == 1) {
					validasiRequired(
						edtwreittd,
						'wreittd',
						{
							'expired_date'   : expired_date,
						}
					);
				}
			}
			
			if ( edtwreittd.inError() ) {
				return false;
			}
		});
		
		edtwreittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwreittd.field('wreittd.finish_at').val(finish_at);
		});

		edtwreittd.on('postSubmit', function(e, json, data, action, xhr) {
			
			if (action != 'remove') {
				tblwreittd.rows().deselect();
			}

		});

		edtwreittd.on( 'close', function () {
			edtwreittd.enable();
		} );

		tblwreittd = $('#tblwreittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wreittd/wreittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wreittd = show_deleted_wreittd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [3,5,8]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "wreittd.id",visible:false },
				{ data: "tanggal_confirm" },
				{ data: "wreittd.kode" },
				{ data: "username" },
				{ data: "iwhxxmh.kode" },
				{ data: "wloxxmh.nama" },
				{ data: "wreittd.wlpxxmh_kode" },
				{ data: "grlxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wreittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "wreittd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wreittd';
					$table       = 'tblwreittd';
					$edt         = 'edtwreittd';
					$show_status = '_wreittd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wreittd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wreittd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwreittd.searchPanes.container().appendTo('#spwreittd');
		tblwreittd.searchBuilder.container().appendTo( '#sbwreittd' );
		
		tblwreittd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwreittd);
		} );
		
		tblwreittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wreittd');
			id_iwhxxmh_old = wreittd_data.id_iwhxxmh;
			id_wloxxmh_old = wreittd_data.id_wloxxmh;
			id_wroxxth = wreittd_data.id_wroxxth;
			id_wroxxth_old = wreittd_data.id_wroxxth;
			id_iimxxmh = wreittd_data.id_iimxxmh;
			id_iimxxmh_old = wreittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wreittd_data.id_iumxxmh_unit;
			console.log(is_nextprocess);
			// atur hak akses
			CekSelectHeaderH(tblwreittd);

			if (is_nextprocess == 1) {
				tblwreittd.button('btnRemove:name')
				.nodes()
				.css( 'display', 'none' );
			} else {
				tblwreittd.button('btnRemove:name')
				.nodes()
				.css( 'display', 'block' );
			}
		} );

		tblwreittd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wreittd');
			id_iwhxxmh_old = 0, id_wloxxmh_old = 0, id_wroxxth = 0, id_wroxxth_old = 0, id_iimxxmh = 0, id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblwreittd);
		} );

		// END wreittd

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwreittd.rows().deselect();
				tblwreittd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwreittd').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
