<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<style>
	div.DTE_Field_Type_textarea textarea {
		width: 100%;
		height: 120px;
	}
</style>

<?php
	$nama_tabel    = 'wptittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSFwptittd" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwptittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>LPN</th>
                                <th>Lokasi Tujuan</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>UoM</th>
                                <th>Qty</th>
                                <th>Drop</th>
                                <th>Cancel Drop</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wptittd_backdate/fn/wptittd_backdate_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwptittd, tblwptittd, show_deleted_wptittd = 0, id_wptittd;
	// ------------- end of default variable

	var id_iimxxmh, id_iumxxmh_unit_old  = 0, wlpxxmh_kode, wloxxmh_nama_target, jumlah_unit_old = 0;
	// get tableRelation
	tableRelation('wptittd');

	var uniqueToken = '';
	var sisa = 0;
	var is_valid_lpn = 0;
	var id_iwhxxmh = 0;
	var id_wpttpmh_old = 0;
	var id_wloxxmh_old = 0;
	var id_wloctmh = 0;
	
	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);

	start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
	end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	


	$(document).ready(function() {
		// BEGIN wptittd
		edtwptittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wptittd/wptittd_backdate.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wptittd = show_deleted_wptittd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwptittd",
			fields: [ 
				{
					label: "wptittd.start_at",
					name: "wptittd.start_at",
					type: "hidden"
				},	
				{
					label: "wptittd.finish_at",
					name: "wptittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wptittd",
					type: "hidden"
				},	
				{
					label: "wptittd.transaction_state",
					name: "wptittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "wptittd.is_backdate",
					name: "wptittd.is_backdate",
					type: "hidden",
					def: 1
				},	
				{
					label: "LPN <sup class='text-danger'>*<sup>",
					name: "wptittd.wlpxxmh_kode"
				},
				{
					label: "Jenis Putaway <sup class='text-danger'>*<sup>",
					name: "wptittd.id_wpttpmh",
                    id: "select_wpttpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wpttpmh/wpttpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wpttpmh_old: id_wpttpmh_old,
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
									$('#select_wpttpmh').empty().select2({ data: options });
								} else {
									$('#select_wpttpmh').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
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
					label: "wptittd.id_iimxxmh",
					name: "wptittd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "wptittd.id_iwhxxmh",
					name: "wptittd.id_iwhxxmh",
					type: "hidden"
				},
				{
					label: "wptittd.id_wloxxmh_asal",
					name: "wptittd.id_wloxxmh_asal",
					type: "hidden"
				},
				{
					label: "wptittd.id_wloxxmh_tujuan",
					name: "wptittd.id_wloxxmh_tujuan",
					type: "hidden"
				},
				{
					label: "wptittd.id_wjtxxmh",
					name: "wptittd.id_wjtxxmh",
					type: "hidden",
					def: 4
				},
				{
					label: "Detail",
					// name: "wptittd_details",
					name: "wptittd.keterangan",
					type: "textarea"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wptittd.id_iumxxmh_unit",
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
					name: "wptittd.jumlah_unit"
				},
				{
					label: "Drop",
					name: "wptittd.is_drop",
					type: "select",
					placeholder : "Select",
					fieldInfo: "jika tidak drop,berarti langsung disimpan ke lokasi",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Lokasi Drop <sup class='text-danger'>*<sup>",
					name: "lokasi_drop",
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
									ids_wloctmh: '6',
									id_iwhxxmh: id_iwhxxmh,
									id_wloxxmh_old: id_wloxxmh_old,
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
					label: "Location <sup class='text-danger'>*<sup>",
					name: "wloxxmh_nama_scan"
				},
			]
		} );

		edtwptittd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwptittd.field('wptittd.start_at').val(start_at);

			edtwptittd.field('wptittd.is_drop').hide();
			edtwptittd.field('wptittd.id_iumxxmh_unit').hide();
			edtwptittd.field('wptittd.keterangan').hide();
			edtwptittd.field('wptittd.jumlah_unit').hide();
			edtwptittd.field('wloxxmh_nama_scan').hide();
			edtwptittd.field('lokasi_drop').hide();
			
			if(action == 'create'){
				tblwptittd.rows().deselect();
			}else if(action == 'edit'){
				
			}
			
			uniqueToken = generateUniqueToken();
    		// console.log(uniqueToken)
			$(window).on('unload', function() {
				updateJson(uniqueToken);
			});
			edtwptittd.field('wptittd.keterangan').disable();

			//cek setting wh
			autofillField('ggswmsh', 1, 'is_ganti_lokasi_putaway');
			is_ganti_lokasi_putaway = autofillData.is_ganti_lokasi_putaway;
		});

		edtwptittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			window.addEventListener('beforeunload', confirmLeavePage);

			//ini tunggu load ajax dulu, agar datanya hidden terisi
			//ini untuk keperluan insert booking is_fisik 0,
			//kalau tidak pakai ini, nanti error insert data null semua karena ajax belum success tapi udah di insert datanya
			$('div.DTE_Form_Buttons button:eq(1)').hide();

			// enable disable tombol Save & Confirm
			// edtFormButtonSaveConfirm();
			
			$('div.DTE_Form_Buttons button:eq(2)').hide();
			$('div.DTE_Form_Buttons button:eq(3)').hide();

			$('#select_wpttpmh').select2('open');

            setTimeout(function() {
                $('#select_wpttpmh').select2('close');
            }, 5);
		});

		edtwptittd.dependent( 'wptittd.id_wpttpmh', function ( val, data, callback ) {
			wlpxxmh_kode = edtwptittd.field('wptittd.wlpxxmh_kode').val();
			if (wlpxxmh_kode != '' && val > 0) {
				edtwptittd.field('wptittd.id_wpttpmh').error('');
				wlpxxmh_kode_validasi();

				if (val == 1) {
					edtwptittd.field('wptittd.id_iumxxmh_unit').enable();
					edtwptittd.field('wptittd.jumlah_unit').enable();
				} else {
					edtwptittd.field('wptittd.id_iumxxmh_unit').disable();
					edtwptittd.field('wptittd.jumlah_unit').disable();
				}
			}
			return {}
		}, {event: 'change'});
		
		edtwptittd.dependent( 'wptittd.wlpxxmh_kode', function ( val, data, callback ) {
			wlpxxmh_kode = val;
			if (val != '') {
				lpnValidate(wlpxxmh_kode);
			}

			id_wpttpmh = edtwptittd.field('wptittd.id_wpttpmh').val();
			if (id_wpttpmh > 0) {
				wlpxxmh_kode_validasi();
				$('div.DTE_Form_Buttons button:eq(1)').hide();
			}
			// $(this).unbind('change');
			return {}
		}, {event: 'keyup change'});

		edtwptittd.dependent( 'wptittd.id_iumxxmh_unit', function ( val, data, callback ) {
			if (val > 0) {
				outstandingItem();
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'wptittd.jumlah_unit', function ( val, data, callback ) {
			if (val > 0) {
				outstandingItem();
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'wptittd.is_drop', function ( val, data, callback ) {
			is_drop = edtwptittd.field('wptittd.is_drop').val();
			jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();
			
			if (jumlah_unit > 0) {
				if (is_drop == 1) {
					$('#select_wloxxmh').select2('open');

					setTimeout(function() {
						$('#select_wloxxmh').select2('close');
					}, 5);

					edtwptittd.field('wloxxmh_nama_scan').hide();
					edtwptittd.field('lokasi_drop').show();
				} else {
					edtwptittd.field('wloxxmh_nama_scan').show();
					edtwptittd.field('wloxxmh_nama_scan').focus();
					edtwptittd.field('lokasi_drop').hide();
				}
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'lokasi_drop', function ( val, data, callback ) {
			if (val > 0) {
				id_wloxxmh_tujuan = val;
				edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan); 
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'wloxxmh_nama_scan', function ( val, data, callback ) {
			if(val != ''){
				// wloxxmh_nama_scan = val;
				// if (is_ganti_lokasi_putaway == 1) {
					validasiLocation();
				// } else {
				// 	if(wloxxmh_nama_scan != wloxxmh_nama_target){
				// 		edtwptittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
				// 		edtwptittd.field('wloxxmh_nama_scan').val('');
				// 		// console.log('xx');
				// 	}else{
				// 		edtwptittd.field('wloxxmh_nama_scan').error( '' );
				// 		// console.log('lokasi ok');
				// 	}
				// }
			}
			return {}
		}, {event: 'keyup'});

		edtwptittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				wlpxxmh_kode = edtwptittd.field('wptittd.wlpxxmh_kode').val();
				id_wpttpmh = edtwptittd.field('wptittd.id_wpttpmh').val();
				id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();
				jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();
				wloxxmh_nama_scan = edtwptittd.field('wloxxmh_nama_scan').val();
				lokasi_drop = edtwptittd.field('lokasi_drop').val();
				is_drop = edtwptittd.field('wptittd.is_drop').val();

				if (is_drop == 0) {
					if(!wloxxmh_nama_scan || wloxxmh_nama_scan == ''){
						edtwptittd.field('wloxxmh_nama_scan').error( 'Wajib diisi!' );
					}
				} else {
					if(!lokasi_drop || lokasi_drop == ''){
						edtwptittd.field('lokasi_drop').error( 'Wajib diisi!' );
					}
				}

				validasiRequired(
					edtwptittd,
					'wptittd',
					{
						'wlpxxmh_kode'   : wlpxxmh_kode,
						'id_wpttpmh'   : id_wpttpmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit'    : jumlah_unit,
					}
				);

				validasiNumber(
					edtwptittd,
					'wptittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

				outstandingItem();
				// console.log('sisa = '+sisa); //10.00
				jumlah_unit = parseFloat(jumlah_unit);
				// console.log(sisa);
				// console.log('jumlah_unit = '+jumlah_unit); //5
				if (jumlah_unit > sisa) {
					// console.log(11);
					edtwptittd.field('wptittd.jumlah_unit').error( 'Jumlah Max: '+sisa );
				} else {
					edtwptittd.field('wptittd.jumlah_unit').error('');
					// console.log(22);
				}

				// tidak bisa pakai ini harus hitung sendiri
				// validasiOutstanding(
				// 	edtwptittd, 'wptittd', id_transaksi, id_wroittd, 'wroittd'
				// )

			}
			
			if ( edtwptittd.inError() ) {
				return false;
			}
		});
		
		edtwptittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwptittd.field('wptittd.finish_at').val(finish_at);
		});
		
		edtwptittd.on('postSubmit', function(e, json, data, action, xhr) {
			// if (action != 'remove') {
			// }
			// console.log(json);
			// id_transaksi = json.data[0].wptittd.id;
			// konversiUom('wptittd', id_transaksi );
			console.log(json.data);
			id_transaksi_h = json.data[0].wptittd.id;
			fnConfirm('wptittd', tblwptittd );
			// tblwptittd.rows().deselect();
			tblwptittd.ajax.reload(null, false);
		});

		edtwptittd.on( 'close', function () {
			edtwptittd.enable();
			//delete iiv fisik 0 atau booking
			window.removeEventListener('beforeunload', confirmLeavePage);
			booking(3);
		} );

		tblwptittd = $('#tblwptittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wptittd/wptittd_backdate.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wptittd = show_deleted_wptittd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [0,1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: "_all"
				}
			],
			columns: [
				{ data: "wptittd.id",visible:false },
				{ data: "wptittd.kode" ,visible:false },
				{ data: "wptittd.wlpxxmh_kode" },
				{ data: "wloxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wptittd.jumlah_unit",
					...renderNumber( 2, "")
				},
				{ 
					data: "wptittd.is_drop" ,
					...renderYaTidak()
				},
				{ 
					data: "wptittd.is_cancel_drop" ,
					...renderYaTidak()
				},
				{ 
					data: "wptittd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wptittd';
					$table       = 'tblwptittd';
					$edt         = 'edtwptittd';
					$show_status = '_wptittd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button

				{ 
					extend: 'create',
					name: 'btnCreate', 
					editor: edtwptittd, 
					text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
					className: 'btn btn-sm', 
					titleAttr: 'Add New',
					formButtons: [
						{
							text: 'Cancel',
							name: 'btnCancel',
							action: function () {
								confirm_cancel = confirm('Apakah anda yakin?');
								if (confirm_cancel) {
									this.close();
								}
								// alert('tes');
							},
							className: 'btn btn-warning m-r-xs'
						},
						{
							text: 'Load',
							name: 'btnLoad',
							action: function () {
								// this.close();
								// alert('Load');
								// wlpxxmh_kode = edtwptittd.field('wptittd.wlpxxmh_kode').val();
								
								// // console.log(wlpxxmh_kode);
								// validasiRequired(
								// 	edtwptittd,
								// 	'wptittd',
								// 	{
								// 		'wlpxxmh_kode'   : wlpxxmh_kode,
								// 	}
								// );
								
								// if ( edtwptittd.inError() ) {
								// 	return false;
								// } else {
									
								// }
							},
							className: 'btn btn-primary m-r-xs'
						},
						{
							text: 'Start',
							name: 'btnStart',
							action: function () {
								// this.close();
								outstandingItem();
								jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();

								// console.log('sisa = '+sisa); //10.00
								jumlah_unit = parseFloat(jumlah_unit);
								// console.log('jumlah_unit = '+jumlah_unit); //5
								if (jumlah_unit > sisa) {
									// console.log(11);
									edtwptittd.field('wptittd.jumlah_unit').error( 'Jumlah Max: '+sisa );
								} else {
									edtwptittd.field('wptittd.jumlah_unit').error('');
									
									$('div.DTE_Form_Buttons button:eq(1)').hide();
									$('div.DTE_Form_Buttons button:eq(2)').hide();
									$('div.DTE_Form_Buttons button:eq(3)').show();
									// console.log('uniqueToken start' +uniqueToken);
									booking(1);

									edtwptittd.field('wptittd.id_iumxxmh_unit').disable();
									edtwptittd.field('wptittd.jumlah_unit').disable();
									id_wpttpmh = edtwptittd.field('wptittd.id_wpttpmh').val();
									if (id_wpttpmh == 2) {
										edtwptittd.field('wptittd.is_drop').show();
										edtwptittd.field('wptittd.is_drop').val(1)
									} else {
										edtwptittd.field('wptittd.is_drop').val(0)
										edtwptittd.field('wptittd.is_drop').hide();
										edtwptittd.field('wloxxmh_nama_scan').show();
										edtwptittd.field('wloxxmh_nama_scan').focus();
									}

									id_wloxxmh_asal = edtwptittd.field('wptittd.id_wloxxmh_asal').val();
									id_wloxxmh_tujuan = edtwptittd.field('wptittd.id_wloxxmh_tujuan').val();
									edtwptittd.field('wptittd.id_wpttpmh').disable();
									console.log(id_wloxxmh_asal);
									console.log(id_wloxxmh_tujuan);
								}

								if ( edtwptittd.inError() ) {
									return false;
								}
							},
							className: 'btn btn-primary m-r-xs'
						},
						{
							text: 'Finish',
							action: function (e, dt, node, config, cb){
								this.submit(
									function (json) {
										// id_transaksi_h = json.data[0].wptittd.id;
										// fnConfirm('wptittd', tblwptittd );
									}, 
								);
								
								

							},
							className: 'btn btn-primary'
						}
					]
				},
				{
					text: 'Cancel Drop',
					name: 'btnCancelDrop',
					action: function () {
						confirm_cancel = confirm('Apakah anda yakin ingin cancel drop?');
						if (confirm_cancel) {
							// toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

							$.ajax( {
								url: "../../models/wptittd/wptittd_fn_cancelDrop.php",
								dataType: 'json',
								type: 'POST',
								async: false,
								data: {
									wlpxxmh_kode: wlpxxmh_kode_sel
								},
								success: function ( json ) {
									full_message = json.data.message + '</br>';
									toast_type   = json.data.type_message;
									toastr[toast_type](full_message, 'INFO');
									
									tblwptittd.rows().deselect();
									tblwptittd.ajax.reload(null,false);
								}
							} );
						}
					},
					className: 'btn btn-warning m-r-xs'
				},
                    // END 
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wptittd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wptittd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwptittd.searchPanes.container().appendTo('#spwptittd');
		tblwptittd.searchBuilder.container().appendTo( '#sbwptittd' );
		tblwptittd.button('btnCancelDrop:name').disable();
		
		tblwptittd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwptittd);
		} );
		
		tblwptittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wptittd');
			id_iumxxmh_unit_old = wptittd_data.id_iumxxmh_unit;
			jumlah_unit_old = wptittd_data.jumlah_unit_default;
			id_wpttpmh_old = wptittd_data.id_wpttpmh;
			id_wloxxmh_tujuan = wptittd_data.id_wloxxmh_tujuan;
			wlpxxmh_kode_sel = wptittd_data.wlpxxmh_kode;

			// atur hak akses
			CekSelectHeaderH(tblwptittd);
			autofillField('wloxxmh', id_wloxxmh_tujuan, 'id_wloctmh');
			id_wloctmh_s = autofillData.id_wloctmh;

			//cek apakah lokasi tujuan adalah lokasi drop
			if (id_wloctmh_s == 6) {
				validasiCancelDrop(wlpxxmh_kode_sel);

				//cek apakah di inventory, LPN yg dipilih ini masih ada di DROP?
				if (id_wloctmh_ajx == 6) {
					//kalau masih ada di DROP, maka button enable
					tblwptittd.button('btnCancelDrop:name').enable();
				} else {
					//kalau tidak di lokasi drop, maka sudah pernah di cancel drop sebelumnya
					tblwptittd.button('btnCancelDrop:name').disable();
				}
			} else {
				tblwptittd.button('btnCancelDrop:name').disable();
			}
		} );

		tblwptittd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wptittd');
			id_iumxxmh_unit_old = 0;
			id_wloxxmh_tujuan = 0;
			wlpxxmh_kode_sel = '';
			id_wpttpmh_old = 0;
			jumlah_unit_old = 0;
			tblwptittd.button('btnCancelDrop:name').disable();

			// atur hak akses
			CekDeselectHeaderH(tblwptittd);
		} );

		// END wptittd
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

				tblwptittd.rows().deselect();
				tblwptittd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwptittd').modal('toggle');
			}, false);
				return false;
			}
		});
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
