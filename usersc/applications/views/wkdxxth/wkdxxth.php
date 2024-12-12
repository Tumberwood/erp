<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wkdxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wkdlptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFwkdxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwkdxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Picking Method</th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabwkdlptd"> LPN</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwkdlptd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwkdlptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th rowspan="2">ID</th>
										<th rowspan="2">id_wkdxxth</th>
										<th rowspan="2">LPN</th>
										<th rowspan="2">Location</th>
										<th rowspan="2">Item Code</th>
										<th rowspan="2">Item Name</th>
										<th colspan="2">Terkecil</th>
										<th colspan="2">Default</th>
										<th rowspan="2">Batch Number</th>
										<th rowspan="2">Expired Date</th>
									</tr>
									<tr>
										<th>Jumlah</th>
										<th>UoM</th>
										<th>Jumlah</th>
										<th>UoM</th>
									</tr>
								</thead>
								<tfoot>
									<th></th>
									<th></th>
									<th>Total</th>
									<th></th>
									<th></th>
									<th></th>
									<th id="s_6"></th>
									<th></th>
									<th id="s_8"></th>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wkdxxth/fn/wkdxxth_fn.php'; ?>


<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwkdxxth, tblwkdxxth, show_deleted_wkdxxth = 0, id_wkdxxth;
	var edtwkdlptd, tblwkdlptd, show_deleted_wkdlptd = 0, id_wkdlptd;
	var edtwkdrstd_create;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('wkdxxth');
	var id_iimxxmh_old_kitting = 0, id_iumxxmh_unit_old = 0, id_iumxxmh_unit_old_kitting = 0, id_iimxxmh = 0, id_iwhxxmh_old =0, id_iwhxxmh = 0, id_wloxxmh_old = 0;
	var id_wpmxxmh_old = 0, id_iimxxmh_old = 0, id_iumxxmh_old = 0, id_wlpxxmh_old_kitting = 0, id_iimxxmh_kit = 0;
	
	uniqueToken = '';
	var c_id = 0, jumlah_konversi = 0;
	var id_wloxxmh_old_lpn = 0, id_iumxxmh_unit_old = 0, id_wplittd_old = 0, id_iwhxxmh_old_lpn = 0, id_iumxxmh_unit_old_lpn = 0, jumlah_terkecil_lpn = 0;

	$(document).ready(function() {

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wkdxxth
		edtwkdxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wkdxxth/wkdxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wkdxxth = show_deleted_wkdxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwkdxxth",
			fields: [ 
				{
					label: "wkdxxth.start_at",
					name: "wkdxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wkdxxth.finish_at",
					name: "wkdxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wkdxxth",
					type: "hidden"
				},	
				{
					label: "wkdxxth.transaction_state",
					name: "wkdxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "wkdxxth.tanggal",
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
					label: "LPN Kitting  <sup class='text-danger'>*<sup>",
					name: "wkdxxth.id_wlpxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wkdxxth/wlpxxmh_fn_opt_kitting.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wlpxxmh_old: id_wlpxxmh_old_kitting,
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
					label: "Item Kitting",
					name: "wkdxxth.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "wlpxxmh_kode_kitting",
					name: "wkdxxth.wlpxxmh_kode_kitting",
					type: "hidden"
				},
				{
					label: "Item Kitting",
					name: "iimxxmh_nama",
					type: "readonly"
				},
				// {
				// 	label: "Item Kitting <sup class='text-danger'>*<sup>",
				// 	name: "wkdxxth.id_iimxxmh",
				// 	id: "wdoxxth",
				// 	type: "select2",
				// 	opts: {
				// 		placeholder : "Select",
				// 		allowClear: true,
				// 		multiple: false,
				// 		ajax: {
				// 			url: "../../models/iimxxmh/iimxxmh_fn_opt_iicxxmh.php",
				// 			dataType: 'json',
				// 			data: function (params) {
				// 				var query = {
				// 					id_iimxxmh_old: id_iimxxmh_old_kitting,
				// 					ids_iicxxmh: 4,
				// 					search: params.term || '',
				// 					page: params.page || 1
				// 				}
				// 					return query;
				// 			},
				// 			processResults: function (data, params) {
				// 				return {
				// 					results: data.results,
				// 					pagination: {
				// 						more: true
				// 					}
				// 				};
				// 			},
				// 			cache: true,
				// 			minimumInputLength: 1,
				// 			maximum: 10,
				// 			delay: 500,
				// 			maximumSelectionLength: 5,
				// 			minimumResultsForSearch: -1,
				// 		},
				// 	}
				// },
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wkdxxth.id_iumxxmh_unit",
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
									id_iimxxmh: id_iimxxmh_kit,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old_kitting,
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "wkdxxth.jumlah_unit"
				}, 		
				{
					label: "Picking Method <sup class='text-danger'>*<sup>",
					name: "wkdxxth.id_wpmxxmh",
					id: "select2_wpm", //tambahkan id di select2nya
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wpmxxmh/wpmxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wpmxxmh_old: id_wpmxxmh_old,
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
									$('#select2_wpm').empty().select2({ data: options });
								} else {
									$('#select2_wpm').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
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
					label: "All WH",
					name: "wkdxxth.is_all_wh",
					type: "select",
					placeholder : "Select",
					def:1,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Warehouse<sup class='text-danger'>*<sup>",
					name: "wkdxxth.id_iwhxxmh",
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
					label: "Location<sup class='text-danger'>*<sup>",
					name: "wkdxxth.id_wloxxmh_out",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
							dataType: 'json',
							data: function (params) {
								id_iwhxxmh = edtwkdxxth.field('wkdxxth.id_iwhxxmh').val();
								console.log(id_iwhxxmh);
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
									ids_wloctmh: 4,
									id_iwhxxmh: id_iwhxxmh,
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
					label: "Keterangan",
					name: "wkdxxth.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edtwkdxxth.field('wkdxxth.id_iwhxxmh').hide();

		edtwkdxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwkdxxth.field('wkdxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwkdxxth.rows().deselect();
			}
		});

		edtwkdxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
			
			$('#select2_wpm').select2('open');

			setTimeout(function() {
				$('#select2_wpm').select2('close');
			}, 5);
		});
		
		edtwkdxxth.dependent( 'wkdxxth.is_all_wh', function ( val, data, callback ) {
			if (val == 1) {
				edtwkdxxth.field('wkdxxth.id_iwhxxmh').hide();
			} else {
				edtwkdxxth.field('wkdxxth.id_iwhxxmh').show();
			}
			return {}
		}, {event: 'keyup change'});
		
		edtwkdxxth.dependent( 'wkdxxth.id_wlpxxmh', function ( val, data, callback ) {
			if (val > 0) {
				kittingData(val);
				console.log(id_iimxxmh_kit);
				console.log(iimxxmh_nama_kit);
				console.log(wlpxxmh_kode_kit);
				edtwkdxxth.field('wkdxxth.id_iimxxmh').val(id_iimxxmh_kit);
				edtwkdxxth.field('iimxxmh_nama').val(iimxxmh_nama_kit);
				edtwkdxxth.field('wkdxxth.wlpxxmh_kode_kitting').val(wlpxxmh_kode_kit);
			}
			return {}
		}, {event: 'keyup change'});
		
		edtwkdxxth.dependent( 'wkdxxth.id_iwhxxmh', function ( val, data, callback ) {
			id_iwhxxmh = val;
			// id_wloxxmh_old = 0;

			if (id_wloxxmh_old == 0) {
				edtwkdxxth.field('wkdxxth.id_wloxxmh_out').val('');
			}
			return {}
		}, {event: 'keyup change'});

		edtwkdxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_wlpxxmh = edtwkdxxth.field('wkdxxth.id_wlpxxmh').val();
				id_iumxxmh_unit = edtwkdxxth.field('wkdxxth.id_iumxxmh_unit').val();
				jumlah_unit = edtwkdxxth.field('wkdxxth.jumlah_unit').val();
				tanggal = edtwkdxxth.field('wkdxxth.tanggal').val();
				id_wpmxxmh = edtwkdxxth.field('wkdxxth.id_wpmxxmh').val();
				id_iwhxxmh = edtwkdxxth.field('wkdxxth.id_iwhxxmh').val();
				is_all_wh = edtwkdxxth.field('wkdxxth.is_all_wh').val();
				id_wloxxmh_out = edtwkdxxth.field('wkdxxth.id_wloxxmh_out').val();
				id_iimxxmh = edtwkdxxth.field('wkdxxth.id_iimxxmh').val();

				validasiRequired(
					edtwkdxxth,
					'wkdxxth',
					{
						'id_wlpxxmh': id_wlpxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit': jumlah_unit,
						'tanggal': tanggal,
						'id_wpmxxmh': id_wpmxxmh,
						// 'id_iwhxxmh': id_iwhxxmh,
						'id_wloxxmh_out': id_wloxxmh_out,
					}
				);
				
				validasiNumber(
					edtwkdxxth,
					'wkdxxth',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);

				if (is_all_wh == 0) {
					
					validasiRequired(
						edtwkdxxth,
						'wkdxxth',
						{
							'id_iwhxxmh': id_iwhxxmh,
						}
					);
				}
				
				kittingData(id_wlpxxmh);
				console.log(jumlah_terkecil_ava);
				konversiJumlah(id_iimxxmh, id_iumxxmh_unit);
				console.log(jumlah_konversi);
				sisa_unit = jumlah_terkecil_ava / jumlah_konversi;
				if (jumlah_unit > sisa_unit) {
					edtwkdxxth.field('wkdxxth.jumlah_unit').error('Jumlah unit tidak boleh lebih dari '+sisa_unit );
				}
			}
			
			if ( edtwkdxxth.inError() ) {
				return false;
			}
		});

		edtwkdxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwkdxxth.field('wkdxxth.finish_at').val(finish_at);
		});
		
		edtwkdxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].wkdxxth.id;
            	konversiUom('wkdxxth', id_transaksi );

				tblwkdxxth.rows().deselect();
			}
			tblwkdxxth.ajax.reload(null, false);
		} );

		edtwkdxxth.on( 'close', function () {
			edtwkdxxth.enable();
		} );

		
		tblwkdxxth = $('#tblwkdxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wkdxxth/wkdxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wkdxxth = show_deleted_wkdxxth;
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
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "wkdxxth.id",visible:false },
				{ data: "wkdxxth.kode" },
				{ data: "wkdxxth.tanggal" },
				{ data: "wpmxxmh.nama" },
				{ 
					data: "wkdxxth.transaction_state",
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wkdxxth';
					$table       = 'tblwkdxxth';
					$edt         = 'edtwkdxxth';
					$show_status = '_wkdxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wkdxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wkdxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwkdxxth.searchPanes.container().appendTo('#spwkdxxth');
		tblwkdxxth.searchBuilder.container().appendTo( '#sbwkdxxth' );
		
		tblwkdxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwkdlptd];
			CekInitHeaderHD(tblwkdxxth, tbl_details);
			tblwkdxxth.button('btnEdit:name').disable();
		} );
		
		tblwkdxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wkdxxth');
			
			id_iimxxmh_old_kitting      = wkdxxth_data.id_iimxxmh;
			id_iumxxmh_unit_old_kitting      = wkdxxth_data.id_iumxxmh_unit;
			is_generate_lpn      = wkdxxth_data.is_generate_lpn;
			id_wpmxxmh_old      = wkdxxth_data.id_wpmxxmh;
			id_iwhxxmh_old = wkdxxth_data.id_iwhxxmh;
			id_wloxxmh_old = wkdxxth_data.id_wloxxmh_out;
			id_wloxxmh_out_old = wkdxxth_data.id_wloxxmh_out;
			id_wlpxxmh_old_kitting = wkdxxth_data.id_wlpxxmh;
			// atur hak akses
			tbl_details = [tblwkdlptd];
			CekSelectHeaderHD(tblwkdxxth, tbl_details);
			uniqueToken = 'wkdxxth_id_'+id_transaksi_h;

			
			// console.log(transaction_state);
			if (transaction_state != 0) {
			} else {
				if (is_generate_lpn == 1) {
					tblwkdxxth.button('btnEdit:name').disable();
				} else {
					tblwkdxxth.button('btnEdit:name').enable();
				}
			}
			cekDonePicking();
		} );
		
		tblwkdxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wkdxxth');
			is_generate_lpn = 0, id_iwhxxmh_old = 0, id_wloxxmh_old = 0;
			id_iwhxxmh = 0;
			id_iimxxmh_old_kitting = 0;
			id_iumxxmh_unit_old_kitting = 0;
			id_wpmxxmh_old = 0;
			id_wloxxmh_out_old = 0;
			id_wlpxxmh_old_kitting = 0;
			uniqueToken = '';

			// atur hak akses
			tbl_details = [tblwkdlptd];
			CekDeselectHeaderHD(tblwkdxxth, tbl_details);

			tblwkdxxth.button('btnEdit:name').disable();
		} );
		// END wkdxxth
		
		// BEGIN wkdlptd
		edtwkdlptd = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 5,
				}
			},
			ajax: {
				url: "../../models/wkdxxth/wkdlptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wkdlptd = show_deleted_wkdlptd;
					d.id_wkdxxth = id_wkdxxth;
				}
			},
			table: "#tblwkdlptd",
			fields: [ 
				{
					label: "wkdlptd.start_at",
					name: "wkdlptd.start_at",
					type: "hidden"
				},	
				{
					label: "wkdlptd.finish_at",
					name: "wkdlptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wkdlptd",
					type: "hidden"
				},	
				{
					label: "wkdlptd.transaction_state",
					name: "wkdlptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wkdxxth",
					name: "wkdlptd.id_wkdxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wkdlptd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									ids_iicxxmh: '',
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
					name: "wkdlptd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								id_iimxxmh = edtwkdlptd.field('wkdlptd.id_iimxxmh').val();
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old_lpn,
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
					name: "wkdlptd.jumlah_unit",
					fieldInfo: "Isikan jumlah total per item"
				},
				{
					label: "Batch Number <sup class='text-danger'>*<sup>",
					name: "wkdlptd.batch_number"
				},
				{
					label: "Expired Date <sup class='text-danger'>*<sup>",
					name: "wkdlptd.expired_date",
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
					name: "wkdlptd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwkdlptd.on( 'preOpen', function( e, mode, action ) {
			edtwkdlptd.field('wkdlptd.id_wkdxxth').val(id_wkdxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwkdlptd.field('wkdlptd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwkdlptd.rows().deselect();
			}
		});

		edtwkdlptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();

		});
		
		edtwkdlptd.on( 'preSubmit', function (e, data, action) {

			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_wkdlptd;
			}

			if(action != 'remove'){
				autofillField('ggswmsh', 1, 'is_replenishment');
				is_replenishment = autofillData.is_replenishment;

				id_iimxxmh      = edtwkdlptd.field('wkdlptd.id_iimxxmh').val();
				id_iumxxmh_unit = edtwkdlptd.field('wkdlptd.id_iumxxmh_unit').val();
				jumlah_unit     = edtwkdlptd.field('wkdlptd.jumlah_unit').val();
				expired_date     = edtwkdlptd.field('wkdlptd.expired_date').val();
				batch_number     = edtwkdlptd.field('wkdlptd.batch_number').val();

				validasiRequired(
					edtwkdlptd,
					'wkdlptd',
					{
						'id_iimxxmh'     : id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);

				validasiNumber(
					edtwkdlptd,
					'wkdlptd',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);

				validasiTanggalValid(
					edtwkdlptd, 
					'wkdlptd', 
					{
						'expired_date'   : expired_date
					}
				)

				if(action == 'create'){
					id_transaksi = 0;
				}

				validasiTanggalToday(
					edtwkdlptd, 'wkdlptd', 'expired_date', expired_date, '>='
				)

				if (is_replenishment == 1) {
					uomReplenishment(id_iimxxmh, id_iumxxmh_unit);

					
				}
				
				autofillField('iimxxmh', id_iimxxmh, 'is_batch_number, is_expired_date');
				is_batch_number = autofillData.is_batch_number;
				is_expired_date = autofillData.is_expired_date;

				if (is_batch_number == 1) {
					validasiRequired(
						edtwkdlptd,
						'wkdlptd',
						{
							'batch_number'   : batch_number,
						}
					);
				}

				if (is_expired_date == 1) {
					validasiRequired(
						edtwkdlptd,
						'wkdlptd',
						{
							'expired_date'   : expired_date,
						}
					);
				}
			}
			
			if ( edtwkdlptd.inError() ) {
				return false;
			}
		});
		
		edtwkdlptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwkdlptd.field('wkdlptd.finish_at').val(finish_at);
		});

		edtwkdlptd.on('postSubmit', function(e, json, data, action, xhr) {
			
			if (action != 'remove') {
				tblwkdlptd.rows().deselect();
			}
			tblwkdlptd.ajax.reload(null, false);
			tblwkdxxth.ajax.reload(null, false);
		});

		edtwkdlptd.on( 'close', function () {
			edtwkdlptd.enable();
		} );
		
		tblwkdlptd = $('#tblwkdlptd').DataTable( {
			ajax: {
				url: "../../models/wkdxxth/wkdlptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wkdlptd = show_deleted_wkdlptd;
					d.id_wkdxxth = id_wkdxxth;
				}
			},
			responsive: false,
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "wkdlptd.id",visible:false },
				{ data: "wkdlptd.id_wkdxxth",visible:false },
				{ data: "wkdlptd.wlpxxmh_kode" },
				{ data: "wloxxmh.nama" },
				{ data: "iimxxmh.kode",visible:false },
				{ data: "iimxxmh.nama",visible:false },
				{ 
					data: "wkdlptd.jumlah_terkecil",
					...renderNumber( 0, "")
				},
				{ data: "uom_terkecil.kode" },
				{ 
					data: "wkdlptd.jumlah_default",
					...renderNumber(2)
				},
				{ data: "uom_default.kode" },
				{ data: "wkdlptd.batch_number" },
				{ data: "wkdlptd.expired_date" },
			],
			rowGroup: {
				dataSrc: function (row) {
					return  row.iimxxmh.kode+' - '+row.iimxxmh.nama
				},
				endRender: function (rows, group) {
					var sum_terkecil = rows
						.data()
						.pluck('wkdlptd.jumlah_terkecil')
						.map(function (terkecil) {
							return parseFloat(terkecil) || 0;
						})
						.reduce(function (a, b) {
							return a + b;
						}, 0);
					
					sum_terkecil = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_terkecil);
					
					var sum_default = rows
						.data()
						.pluck('wkdlptd.jumlah_default')
						.map(function (def) {
							return parseFloat(def) || 0;
						})
						.reduce(function (a, b) {
							return a + b;
						}, 0);
					
					sum_default = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_default);

					return $('<tr/>')
						.append('<td class="font-bold text-success">Total</td>')
						.append('<td></td>')
						// .append('<td></td>')
						// .append('<td></td>')
						.append('<td class="text-right font-bold bg-success">' + sum_terkecil + '</td>')
						.append('<td></td>')
						.append('<td class="text-right font-bold bg-success">' + sum_default + '</td>')
						.append('<td></td>')
						.append('<td></td>')
						.append('<td></td>')
						;
				}
			},
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wkdlptd';
					$table       = 'tblwkdlptd';
					$edt         = 'edtwkdlptd';
					$show_status = '_wkdlptd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit','remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api();
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 
				
				for (var i = 6; i <= 8; i+=2) {
					if (i == 8) {
						numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 
					}
					var columnIndex = i;
					var sum_all = api.column(columnIndex).data().sum();
					// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
					var sum = api.column(columnIndex, { page: 'current' }).data().sum();
					$('#s_' + columnIndex).html(numFormat(sum_all));

					// console.log('Number of Pages: ' + api.page.info().pages);
				}
			}
		} );

		tblwkdlptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwkdlptd, 1 );
			CekDrawDetailHDFinal(tblwkdxxth);
		} );

		tblwkdlptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wkdlptd');
			
			// atur hak akses
			CekSelectDetailHD( tblwkdlptd );

			id_iimxxmh          = wkdlptd_data.id_iimxxmh;
			id_iimxxmh_old      = wkdlptd_data.id_iimxxmh;
			id_iumxxmh_unit_old_lpn = wkdlptd_data.id_iumxxmh_unit;
		} );

		tblwkdlptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wkdlptd');
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old_lpn= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwkdlptd );
		} );

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwkdxxth.rows().deselect();
				tblwkdxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwkdxxth').modal('toggle');
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
