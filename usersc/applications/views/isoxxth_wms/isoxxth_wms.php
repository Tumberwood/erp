<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'isoxxth_wms';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'isoittd_wms';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFisoxxth_wms" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblisoxxth_wms" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Warehouse</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabisoittd_wms_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabisoittd_wms_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblisoittd_wms" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_isoxxth_wms</th>
										<th>Items</th>
										<th>LPN</th>
										<th>Batch Number</th>
										<th>Expired Date</th>
										<th>UoM</th>
										<th>Fisik</th>
										<th>Cut OFF</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoxxth_wms/fn/isoxxth_wms_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtisoxxth_wms, tblisoxxth_wms, show_deleted_isoxxth_wms = 0, id_isoxxth_wms;
	var edtisoittd_wms, tblisoittd_wms, show_deleted_isoittd_wms = 0, id_isoittd_wms;
	// ------------- end of default variable
	var id_iwhxxmh_old = 0, tanggal = '', id_iimxxmh_old = 0;
	var id_iimxxmh_old = 0, id_wloxxmh_old = 0, id_iumxxmh_unit_old = 0;

	// get tableRelation
	tableRelation('isoxxth_wms');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN isoxxth_wms
		edtisoxxth_wms = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoxxth_wms/isoxxth_wms.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoxxth_wms = show_deleted_isoxxth_wms;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblisoxxth_wms",
			fields: [ 
				{
					label: "isoxxth_wms.start_at",
					name: "isoxxth_wms.start_at",
					type: "hidden"
				},	
				{
					label: "isoxxth_wms.finish_at",
					name: "isoxxth_wms.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoxxth_wms",
					type: "hidden"
				},	
				{
					label: "isoxxth_wms.transaction_state",
					name: "isoxxth_wms.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "isoxxth_wms.id_iwhxxmh",
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "isoxxth_wms.tanggal",
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
					name: "isoxxth_wms.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edtisoxxth_wms.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoxxth_wms.field('isoxxth_wms.start_at').val(start_at);

			if(action == 'create'){
				tblisoxxth_wms.rows().deselect();
				edtisoxxth_wms.field('isoxxth_wms.id_iwhxxmh').enable();
				edtisoxxth_wms.field('isoxxth_wms.tanggal').enable();
			} else if(action == 'edit'){
				edtisoxxth_wms.field('isoxxth_wms.id_iwhxxmh').disable();
				edtisoxxth_wms.field('isoxxth_wms.tanggal').disable();
			} 
		});

		edtisoxxth_wms.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtisoxxth_wms.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iwhxxmh = edtisoxxth_wms.field('isoxxth_wms.id_iwhxxmh').val();
				tanggal = edtisoxxth_wms.field('isoxxth_wms.tanggal').val();

				validasiRequired(
					edtisoxxth_wms,
					'isoxxth_wms',
					{
						'id_iwhxxmh': id_iwhxxmh,
						'tanggal': tanggal
					}
				);
			}
			
			if ( edtisoxxth_wms.inError() ) {
				return false;
			}
		});

		edtisoxxth_wms.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoxxth_wms.field('isoxxth_wms.finish_at').val(finish_at);
		});
		
		edtisoxxth_wms.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblisoxxth_wms.ajax.reload(null, false);
			tblisoxxth_wms.rows().deselect();
			tblisoittd_wms.ajax.reload(null, false);
		} );

		edtisoxxth_wms.on( 'close', function () {
			edtisoxxth_wms.enable();
		} );
		
		tblisoxxth_wms = $('#tblisoxxth_wms').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/isoxxth_wms/isoxxth_wms.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoxxth_wms = show_deleted_isoxxth_wms;
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
				{ data: "isoxxth_wms.id",visible:false },
				{ data: "isoxxth_wms.kode" },
				{ data: "isoxxth_wms.tanggal" },
				{ data: "iwhxxmh.nama" },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_isoxxth_wms';
					$table       = 'tblisoxxth_wms';
					$edt         = 'edtisoxxth_wms';
					$show_status = '_isoxxth_wms';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnCutOff',
					className: 'btn btn-xs btn-outline',
					titleAttr: 'Cut OFF',
					action: function ( e, dt, node, config ) {
						$.ajax( {
							url: "../../models/isoxxth_wms/isoxxth_wms_cut_off.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h,
								id_iwhxxmh_old: id_iwhxxmh_old,
							},
							success: function ( json ) {
        						toastr[json.data.type_message](json.data.message,"INFO");
								tblisoxxth_wms.ajax.reload(null, false);
								tblisoxxth_wms.rows().deselect();
								tblisoittd_wms.ajax.reload(null, false);
							}
						} );

					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.isoxxth_wms.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.isoxxth_wms.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblisoxxth_wms.searchPanes.container().appendTo('#spisoxxth_wms');
		tblisoxxth_wms.searchBuilder.container().appendTo( '#sbisoxxth_wms' );
		
		tblisoxxth_wms.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblisoittd_wms];
			CekInitHeaderHD(tblisoxxth_wms, tbl_details);
			tblisoxxth_wms.button('btnCutOff:name').disable();
		} );
		
		tblisoxxth_wms.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('isoxxth_wms');
			id_iwhxxmh_old = isoxxth_wms_data.id_iwhxxmh;
			tanggal = isoxxth_wms_data.tanggal;
			// console.log(tanggal);
			
			// atur hak akses
			tbl_details = [tblisoittd_wms];
			CekSelectHeaderHD(tblisoxxth_wms, tbl_details);

			if (transaction_state == 0) {
				tblisoxxth_wms.button('btnCutOff:name').enable();
			} else {
				tblisoxxth_wms.button('btnCutOff:name').disable();
			}
		} );
		
		tblisoxxth_wms.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('isoxxth_wms');
			id_iwhxxmh_old = 0;
			tanggal = '';

			// atur hak akses
			tbl_details = [tblisoittd_wms];
			CekDeselectHeaderHD(tblisoxxth_wms, tbl_details);
			tblisoxxth_wms.button('btnCutOff:name').disable();
		} );
		// END isoxxth_wms

		// BEGIN isoittd_wms
		edtisoittd_wms = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoxxth_wms/isoittd_wms.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_wms = show_deleted_isoittd_wms;
					d.id_isoxxth_wms = id_isoxxth_wms;
				}
			},
			table: "#tblisoittd_wms",
			formOptions: {
				main: {
					focus: 10
				}
			},
			fields: [ 
				{
					label: "isoittd_wms.start_at",
					name: "isoittd_wms.start_at",
					type: "hidden"
				},	
				{
					label: "isoittd_wms.finish_at",
					name: "isoittd_wms.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoittd_wms",
					type: "hidden"
				},	
				{
					label: "isoittd_wms.transaction_state",
					name: "isoittd_wms.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_isoxxth_wms",
					name: "isoittd_wms.id_isoxxth_wms",
					type: "hidden"
				},	
				{
					label: "LPN <sup class='text-danger'>*<sup>",
					name: "isoittd_wms.wlpxxmh_kode",
				},
				{
					label: "Batch Number <sup class='text-danger'>*<sup>",
					name: "isoittd_wms.batch_number",
				},
				{
					label: "Expired Date <sup class='text-danger'>*<sup>",
					name: "isoittd_wms.expired_date",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "isoittd_wms.id_iimxxmh",
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: "Location <sup class='text-danger'>*<sup>",
					name: "isoittd_wms.id_wloxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: "Quantity <sup class='text-danger'>*<sup>",  
					name: "isoittd_wms.jumlah_unit",
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",  
					name: "isoittd_wms.id_iumxxmh_unit",
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
									id_iimxxmh: edtisoittd_wms.field('isoittd_wms.id_iimxxmh').val(),
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
					label: "Foto",
					name: "isoittd_wms.id_files_pointer",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtisoittd_wms.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_wms.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				{
					label: "Keterangan",
					name: "isoittd_wms.keterangan",
					type: "textarea"
				},
			]
		} );
			
		edtisoittd_wms.on( 'preOpen', function( e, mode, action ) {
			edtisoittd_wms.field('isoittd_wms.id_isoxxth_wms').val(id_isoxxth_wms);
			
			edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').disable();
			edtisoittd_wms.field('isoittd_wms.batch_number').disable();
			edtisoittd_wms.field('isoittd_wms.expired_date').disable();
			edtisoittd_wms.field('isoittd_wms.id_wloxxmh').disable();
			edtisoittd_wms.field('isoittd_wms.id_iimxxmh').disable();

			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_wms.field('isoittd_wms.start_at').val(start_at);
			
			if(action == 'create'){
				tblisoittd_wms.rows().deselect();
			}
		});

		edtisoittd_wms.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtisoittd_wms.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				jumlah_unit = edtisoittd_wms.field('isoittd_wms.jumlah_unit').val();
				id_iumxxmh_unit = edtisoittd_wms.field('isoittd_wms.id_iumxxmh_unit').val();
				id_iimxxmh = edtisoittd_wms.field('isoittd_wms.id_iimxxmh').val();
				id_wloxxmh = edtisoittd_wms.field('isoittd_wms.id_wloxxmh').val();
				wlpxxmh_kode = edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').val();
				batch_number = edtisoittd_wms.field('isoittd_wms.batch_number').val();
				expired_date = edtisoittd_wms.field('isoittd_wms.expired_date').val();
				
				validasiRequired(
					edtisoittd_wms, 
					"isoittd_wms", 
					{
						"id_iumxxmh_unit": id_iumxxmh_unit,
						"id_iimxxmh": id_iimxxmh,
						"id_wloxxmh": id_wloxxmh,
						"wlpxxmh_kode": wlpxxmh_kode,
						"batch_number": batch_number,
						"expired_date": expired_date,
					}
				);
				
				validasiNumber(
					edtisoittd_wms,
					'isoittd_wms',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);
			}
			
			if ( edtisoittd_wms.inError() ) {
				return false;
			}
		});

		edtisoittd_wms.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_wms.field('isoittd_wms.finish_at').val(finish_at);
		});
		
		edtisoittd_wms.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].isoittd_wms.id;
				konversiUom('isoittd_wms', id_transaksi );
				tblisoittd_wms.ajax.reload(null, false);
				tblisoxxth_wms.ajax.reload(null, false);
			}
		});

		edtisoittd_wms.on( 'close', function () {
			edtisoittd_wms.enable();
		} );
		
		tblisoittd_wms = $('#tblisoittd_wms').DataTable( {
			ajax: {
				url: "../../models/isoxxth_wms/isoittd_wms.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_wms = show_deleted_isoittd_wms;
					d.id_isoxxth_wms = id_isoxxth_wms;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			rowGroup: {
				dataSrc: function (row) {
					return  row.wloxxmh.nama
				}
			},
			columns: [
				{ data: "isoittd_wms.id",visible:false },
				{ data: "isoittd_wms.id_isoxxth_wms",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "isoittd_wms.wlpxxmh_kode" },
				{ data: "isoittd_wms.batch_number" },
				{ data: "isoittd_wms.expired_date" },
				{ data: "iumxxmh_unit.kode" },
				{ data: "isoittd_wms.jumlah_unit", ...renderNumber(2) },
				{ data: "isoittd_wms.is_cut_off", ...renderYaTidak() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_isoittd_wms';
					$table       = 'tblisoittd_wms';
					$edt         = 'edtisoittd_wms';
					$show_status = '_isoittd_wms';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['edit','remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblisoittd_wms.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblisoittd_wms, 1 );
			CekDrawDetailHDFinal(tblisoxxth_wms);
		} );

		tblisoittd_wms.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('isoittd_wms');
			id_iimxxmh_old = isoittd_wms_data.id_iimxxmh;
			id_wloxxmh_old = isoittd_wms_data.id_wloxxmh;
			id_iumxxmh_unit_old = isoittd_wms_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblisoittd_wms );
		} );

		tblisoittd_wms.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('isoittd_wms');
			id_iimxxmh_old = 0;
			id_wloxxmh_old = 0;
			id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblisoittd_wms );
		} );
		// END isoittd_wms

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblisoxxth_wms.rows().deselect();
				tblisoxxth_wms.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFisoxxth_wms').modal('toggle');
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
