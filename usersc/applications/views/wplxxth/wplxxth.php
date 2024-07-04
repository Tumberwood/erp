<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wplxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wplittd';
    $nama_tabels_d[1] = 'wpllptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFwplxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwplxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode PL</th>
                                <th>Kode DO</th>
                                <th>Tanggal</th>
                                <th>Picking Method</th>
                                <th>Cross Docking</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabwplittd_1"> Item</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabwpllptd"> LPN</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwplittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwplittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
										<tr>
											<th>ID</th>
											<th>id_wplxxth</th>
											<th>Item Code</th>
											<th>Item Name</th>
											<th>UoM</th>
											<th>Qty DO</th>
											<th>Qty PL</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th id="c_item"></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabwpllptd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwpllptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th rowspan="2">ID</th>
										<th rowspan="2">id_wplxxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wplxxth/fn/wplxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwplxxth, tblwplxxth, show_deleted_wplxxth = 0, id_wplxxth;
	var edtwplittd, tblwplittd, show_deleted_wplittd = 0, id_wplittd;
	var edtwpllptd, tblwpllptd, show_deleted_wpllptd = 0, id_wpllptd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('wplxxth');
	var id_wdoxxth_old = 0, id_wdoxxth = 0, id_iwhxxmh_old =0, id_iwhxxmh = 0, id_wloxxmh_old = 0;
	var id_wpmxxmh_old = 0, id_iimxxmh_old = 0, id_iumxxmh_old = 0;
	
	uniqueToken = '';
	var c_id = 0;

	$(document).ready(function() {
		cekBelumConfirm();

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wplxxth
		edtwplxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wplxxth/wplxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wplxxth = show_deleted_wplxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwplxxth",
			fields: [ 
				{
					label: "wplxxth.start_at",
					name: "wplxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wplxxth.finish_at",
					name: "wplxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wplxxth",
					type: "hidden"
				},	
				{
					label: "wplxxth.transaction_state",
					name: "wplxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Delivery Order <sup class='text-danger'>*<sup>",
					name: "wplxxth.id_wdoxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wdoxxth/wdoxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wdoxxth_old: id_wdoxxth_old,
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "wplxxth.tanggal",
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
					label: "Picking Method <sup class='text-danger'>*<sup>",
					name: "wplxxth.id_wpmxxmh",
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
					label: "Warehouse<sup class='text-danger'>*<sup>",
					name: "wplxxth.id_iwhxxmh",
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
					name: "wplxxth.id_wloxxmh_out",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
							dataType: 'json',
							data: function (params) {
								id_iwhxxmh = edtwplxxth.field('wplxxth.id_iwhxxmh').val();
								console.log(id_iwhxxmh);
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
									ids_wloctmh: 2,
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
					label: "Cross Docking?",
					name: "wplxxth.is_crossdocking",
					type: "select",
					def: 1,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
					name: "wplxxth.keterangan",
					type: "textarea"
				},
				{
					label: "wplxxth.id_grlxxmh_customer",
					name: "wplxxth.id_grlxxmh_customer",
					type: "hidden"
				},
			]
		} );
		
		edtwplxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwplxxth.field('wplxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwplxxth.rows().deselect();
			}
		});

		edtwplxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
			
			$('#select2_wpm').select2('open');

			setTimeout(function() {
				$('#select2_wpm').select2('close');
			}, 5);
		});
		
		edtwplxxth.dependent( 'wplxxth.id_wdoxxth', function ( val, data, callback ) {
			autofillField('wdoxxth', val, 'id_grlxxmh_customer');
			id_grlxxmh_customer = autofillData.id_grlxxmh_customer;
			edtwplxxth.field('wplxxth.id_grlxxmh_customer').val(id_grlxxmh_customer);
			return {}
		}, {event: 'keyup change'});
		
		edtwplxxth.dependent( 'wplxxth.id_iwhxxmh', function ( val, data, callback ) {
			id_iwhxxmh = val;
			id_wloxxmh_old = 0;

			if (id_wloxxmh_old == 0) {
				edtwplxxth.field('wplxxth.id_wloxxmh_out').val('');
			}
			console.log('id_iwhxxmh = '+id_iwhxxmh);
			return {}
		}, {event: 'keyup change'});

		edtwplxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_wdoxxth = edtwplxxth.field('wplxxth.id_wdoxxth').val();
				tanggal = edtwplxxth.field('wplxxth.tanggal').val();
				id_wpmxxmh = edtwplxxth.field('wplxxth.id_wpmxxmh').val();
				id_iwhxxmh = edtwplxxth.field('wplxxth.id_iwhxxmh').val();
				id_wloxxmh_out = edtwplxxth.field('wplxxth.id_wloxxmh_out').val();

				validasiRequired(
					edtwplxxth,
					'wplxxth',
					{
						'id_wdoxxth': id_wdoxxth,
						'tanggal': tanggal,
						'id_wpmxxmh': id_wpmxxmh,
						'id_iwhxxmh': id_iwhxxmh,
						'id_wloxxmh_out': id_wloxxmh_out,
					}
				);

			}
			
			if ( edtwplxxth.inError() ) {
				return false;
			}
		});

		edtwplxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwplxxth.field('wplxxth.finish_at').val(finish_at);
		});
		
		edtwplxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblwplxxth.ajax.reload(null, false);
			tblwplittd.ajax.reload(null, false);
			tblwplittd.rows().deselect();
		} );

		edtwplxxth.on( 'close', function () {
			edtwplxxth.enable();
		} );
		
		tblwplxxth = $('#tblwplxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wplxxth/wplxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wplxxth = show_deleted_wplxxth;
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
				{ data: "wplxxth.id",visible:false },
				{ data: "wplxxth.kode" },
				{ data: "wdoxxth.kode" },
				{ data: "wplxxth.tanggal" },
				{ data: "wpmxxmh.nama" },
				{ 
					data: "wplxxth.is_crossdocking",
					...renderYaTidak()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wplxxth';
					$table       = 'tblwplxxth';
					$edt         = 'edtwplxxth';
					$show_status = '_wplxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnGenerateLPN',
					className: 'btn btn-xs btn-outline',
					titleAttr: 'Generate LPN',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var date = new Date().getTime();
						var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
						console.log(uniqueToken);
						toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

						$.ajax( {
							url: "../../models/wplxxth/wplxxth_fn_gen_lpn.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h,
								uniqueToken: uniqueToken,
								timestamp: timestamp
							},
							success: function ( json ) {
								status_code = json.data.status_code;
								if (status_code == 200) {
									toastr[json.data.type_message](json.data.message,"INFO");
									cekBelumConfirm();
									tblwplxxth.ajax.reload(null, false);
									tblwpllptd.ajax.reload(null, false);
									tblwplxxth.rows().deselect();
								}
							}
						} );
					}
				},
				{
					text: '<i class="fa fa-refresh"></i>',
					name: 'btnReset',
					className: 'btn btn-xs btn-outline',
					titleAttr: 'Reset',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var date = new Date().getTime();
						var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
						console.log(uniqueToken);
						toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
						
						$.ajax( {
							url: "../../models/wplxxth/wplxxth_fn_reset_lpn.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h,
								uniqueToken: uniqueToken,
								timestamp: timestamp
							},
							success: function ( json ) {
								status_code = json.data.status_code;
								if (status_code == 200) {
									toastr[json.data.type_message](json.data.message,"INFO");
									cekBelumConfirm();
									tblwplxxth.ajax.reload(null, false);
									tblwpllptd.ajax.reload(null, false);
									tblwplxxth.rows().deselect();
								}
							}
						} );
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wplxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wplxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwplxxth.searchPanes.container().appendTo('#spwplxxth');
		tblwplxxth.searchBuilder.container().appendTo( '#sbwplxxth' );
		
		tblwplxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwplittd, tblwpllptd];
			CekInitHeaderHD(tblwplxxth, tbl_details);
			tblwplxxth.button('btnGenerateLPN:name').disable();
			tblwplxxth.button('btnReset:name').disable();
			tblwplxxth.button('btnReset:name')
				.nodes()
				.css( 'display', 'none' );
			tblwplxxth.button('btnEdit:name').disable();
		} );
		
		tblwplxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wplxxth');
			
			id_wdoxxth_old      = wplxxth_data.id_wdoxxth;
			id_wdoxxth      = wplxxth_data.id_wdoxxth;
			is_generate_lpn      = wplxxth_data.is_generate_lpn;
			id_wpmxxmh_old      = wplxxth_data.id_wpmxxmh;
			id_iwhxxmh_old = wplxxth_data.id_iwhxxmh;
			id_wloxxmh_old = wplxxth_data.id_wloxxmh_out;
			// atur hak akses
			tbl_details = [tblwplittd, tblwpllptd];
			CekSelectHeaderHD(tblwplxxth, tbl_details);
			uniqueToken = 'wplxxth_id_'+id_transaksi_h;

			
			if (transaction_state == 1 || transaction_state == -9) {
				tblwplxxth.button('btnGenerateLPN:name').disable();
				tblwplxxth.button('btnReset:name').disable();
			} else {
				if (is_generate_lpn == 1) {
					tblwplxxth.button('btnReset:name')
						.nodes()
						.css( 'display', 'block' );
					tblwplxxth.button('btnGenerateLPN:name')
						.nodes()
						.css( 'display', 'none' );
					tblwplxxth.button('btnGenerateLPN:name').disable();
					tblwplxxth.button('btnReset:name').enable();
					tblwplittd.button('btnCreate:name').disable();
					tblwplittd.button('btnRemove:name').disable();
					tblwplxxth.button('btnEdit:name').disable();
				} else {
					tblwplxxth.button('btnReset:name')
						.nodes()
						.css( 'display', 'none' );
					tblwplxxth.button('btnGenerateLPN:name')
						.nodes()
						.css( 'display', 'block' );
					tblwplxxth.button('btnGenerateLPN:name').enable();
					tblwplxxth.button('btnReset:name').disable();
					tblwplittd.button('btnCreate:name').enable();
					tblwplittd.button('btnRemove:name').disable();
					tblwplxxth.button('btnEdit:name').enable();
				}
			}
			cekBelumConfirm();
		} );
		
		tblwplxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wplxxth');
			is_generate_lpn = 0, id_iwhxxmh_old = 0, id_wloxxmh_old = 0;
			id_iwhxxmh = 0;
			id_wdoxxth = 0;
			id_wdoxxth_old = 0;
			id_wpmxxmh_old = 0;
			uniqueToken = '';

			// atur hak akses
			tbl_details = [tblwplittd, tblwpllptd];
			CekDeselectHeaderHD(tblwplxxth, tbl_details);
			tblwplxxth.button('btnGenerateLPN:name').disable();
			tblwplxxth.button('btnReset:name').disable();

			tblwplxxth.button('btnReset:name')
				.nodes()
				.css( 'display', 'none' );
			tblwplxxth.button('btnGenerateLPN:name')
				.nodes()
				.css( 'display', 'block' );
			tblwplxxth.button('btnEdit:name').disable();
		} );
		// END wplxxth

		// BEGIN wplittd
		edtwplittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wplxxth/wplittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wplittd = show_deleted_wplittd;
					d.id_wplxxth = id_wplxxth;
				}
			},
			table: "#tblwplittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "wplittd.start_at",
					name: "wplittd.start_at",
					type: "hidden"
				},	
				{
					label: "wplittd.finish_at",
					name: "wplittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wplittd",
					type: "hidden"
				},	
				{
					label: "wplittd.transaction_state",
					name: "wplittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wplxxth",
					name: "wplittd.id_wplxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wplittd.id_wdoittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_wdoxxth.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									id_wdoxxth: id_wdoxxth,
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
					label: "id_iimxxmh",
					name: "wplittd.id_iimxxmh",
					type: "hidden"
				},	
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wplittd.id_iumxxmh_unit",
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "wplittd.jumlah_unit"
				}, 	
				{
					label: "Keterangan",
					name: "wplittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtwplittd.field('wplittd.jumlah_unit').input().addClass('text-right');
		
		edtwplittd.on( 'preOpen', function( e, mode, action ) {
			edtwplittd.field('wplittd.id_wplxxth').val(id_wplxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwplittd.field('wplittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwplittd.rows().deselect();
			}
		});

		edtwplittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').nodes()
        	.css( 'display', 'none' );
		});
		
		edtwplittd.dependent( 'wplittd.id_wdoittd', function ( val, data, callback ) {
			autofillField('wdoittd', val, 'id_iimxxmh, id_iumxxmh_unit');
			id_iimxxmh = autofillData.id_iimxxmh;
			id_iumxxmh_unit_old = autofillData.id_iumxxmh_unit;
			console.log(id_iumxxmh_unit_old);
			edtwplittd.field('wplittd.id_iimxxmh').val(id_iimxxmh);
			edtwplittd.field('wplittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);
			return {}
		}, {event: 'keyup change'});


		edtwplittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_wplittd;
			}
			
			if(action != 'remove'){
				
				id_iumxxmh_unit = edtwplittd.field('wplittd.id_iumxxmh_unit').val();
				id_wdoittd      = edtwplittd.field('wplittd.id_wdoittd').val();
				jumlah_unit     = edtwplittd.field('wplittd.jumlah_unit').val();

				validasiRequired(
					edtwplittd,
					'wplittd',
					{
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_wdoittd': id_wdoittd,
					}
				);
				
				validasiNumber(
					edtwplittd,
					'wplittd',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);

				validasiOutstanding(
					edtwplittd, 'wplittd', id_transaksi, id_wdoittd, 'wdoittd'
				)
				
			}
			
			if ( edtwplittd.inError() ) {
				return false;
			}
		});

		edtwplittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwplittd.field('wplittd.finish_at').val(finish_at);
		});
			
		edtwplittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].wplittd.id;
            	konversiUom('wplittd', id_transaksi );

				tblwplittd.rows().deselect();
			}
			
			tblwplxxth.ajax.reload(null, false);
			tblwplittd.ajax.reload(null, false);
		} );

		edtwplittd.on( 'close', function () {
			edtwplittd.enable();
		} );
		
		tblwplittd = $('#tblwplittd').DataTable( {
			ajax: {
				url: "../../models/wplxxth/wplittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wplittd = show_deleted_wplittd;
					d.id_wplxxth = id_wplxxth;
				}
			},
			order: [[ 2, "asc" ]],
			columns: [
				{ data: "wplittd.id",visible:false },
				{ data: "wplittd.id_wplxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "wplittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "wplittd.subtotal_jumlah_unit",
					...renderNumber( 0, "")
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wplittd';
					$table       = 'tblwplittd';
					$edt         = 'edtwplittd';
					$show_status = '_wplittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
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
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
			}
		} );

		tblwplittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwplittd, 1 );
			CekDrawDetailHDFinal(tblwplxxth);
		} );

		tblwplittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wplittd');
			
			// atur hak akses
			CekSelectDetailHD( tblwplittd );

			id_iimxxmh          = wplittd_data.id_iimxxmh;
			id_iimxxmh_old      = wplittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wplittd_data.id_iumxxmh_unit;
			
			if (is_generate_lpn == 1) {
				tblwplittd.button('btnEdit:name').disable();
				tblwplittd.button('btnRemove:name').disable();
			} else {
				tblwplittd.button('btnEdit:name').enable();
				tblwplittd.button('btnRemove:name').disable();
			}
		} );

		tblwplittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wplittd');
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwplittd );
		} );
		// END wplittd
		
		tblwpllptd = $('#tblwpllptd').DataTable( {
			ajax: {
				url: "../../models/wplxxth/wpllptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpllptd = show_deleted_wpllptd;
					d.id_wplxxth = id_wplxxth;
				}
			},
			responsive: false,
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "wpllptd.id",visible:false },
				{ data: "wpllptd.id_wplxxth",visible:false },
				{ data: "wpllptd.wlpxxmh_kode" },
				{ data: "wloxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "wpllptd.jumlah_terkecil",
					...renderNumber( 0, "")
				},
				{ data: "uom_terkecil.kode" },
				{ 
					data: "wpllptd.jumlah_default",
					...renderNumber(2)
				},
				{ data: "uom_default.kode" },
				{ data: "wpllptd.batch_number" },
				{ data: "wpllptd.expired_date" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wpllptd';
					$table       = 'tblwpllptd';
					$edt         = 'edtwpllptd';
					$show_status = '_wpllptd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [];
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

		tblwpllptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwpllptd, 1 );
			CekDrawDetailHDFinal(tblwplxxth);
		} );

		tblwpllptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wpllptd');
			
			// atur hak akses
			CekSelectDetailHD( tblwpllptd );

			id_iimxxmh          = wpllptd_data.id_iimxxmh;
			id_iimxxmh_old      = wpllptd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wpllptd_data.id_iumxxmh_unit;
		} );

		tblwpllptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wpllptd');
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwpllptd );
		} );
		// END wplittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwplxxth.rows().deselect();
				tblwplxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwplxxth').modal('toggle');
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
