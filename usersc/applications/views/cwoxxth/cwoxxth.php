<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'cwoxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'cwoittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFcwoxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblcwoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plan Date</th>
                                <th>RFP</th>
								<th data-i18n='item'></th>
								<th data-i18n='quantity'></th>
								<th data-i18n='uom'></th>
								<th data-i18n='state'></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabcwoittd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabcwoittd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabcwoittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblcwoittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_cwoxxth</th>
										<th data-i18n='item'></th>
										<th data-i18n='quantity'></th>
										<th data-i18n='Quantity Total'></th>
										<th data-i18n='uom'></th>
										<th data-i18n='machine'></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/cwoxxth/fn/cwoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtcwoxxth, tblcwoxxth, show_deleted_cwoxxth = 0, id_cwoxxth;
	var edtcwoittd, tblcwoittd, show_deleted_cwoittd = 0, id_cwoittd;
	var id_crfpxth_old = 0, id_crfittd_old = 0, id_dbmxxth_old = 0, id_iumxxmh_old = 0, id_iumxxmh_d = 0, id_rmsxxmh_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('cwoxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN cwoxxth
		edtcwoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/cwoxxth/cwoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_cwoxxth = show_deleted_cwoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblcwoxxth",
			fields: [ 
				{
					label: "cwoxxth.start_at",
					name: "cwoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "cwoxxth.finish_at",
					name: "cwoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "cwoxxth",
					type: "hidden"
				},	
				{
					label: "cwoxxth.transaction_state",
					name: "cwoxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Plan Date <sup class='text-danger'>*<sup>",  
					name: "cwoxxth.tanggal",
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
					label: "RFP <sup class='text-danger'>*<sup>",
					name: "cwoxxth.id_crfpxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/crfpxth/crfpxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_crfpxth_old: id_crfpxth_old,
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
					label: "Item <sup class='text-danger'>*<sup>",
					name: "cwoxxth.id_crfittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/crfpxth/crfittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_crfpxth = edtcwoxxth.field('cwoxxth.id_crfpxth').val();
								var query = {
									id_crfittd_old: id_crfittd_old,
									id_crfpxth: id_crfpxth,
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
					label: "Jumlah Unit <sup class='text-danger'>*<sup>",
					name: "cwoxxth.jumlah_unit"
				}, 
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "cwoxxth.id_iumxxmh_unit",
					type: "select2",
					opts: {
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_old,
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
					label: "id_iimxxmh <sup class='text-danger'>*<sup>",
					name: "cwoxxth.id_iimxxmh",
					type: "hidden"
				}, 	
				{
					label: "Bill of Material <sup class='text-danger'>*<sup>",
					name: "cwoxxth.id_dbmxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/dbmxxth/dbmxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_iimxxmh = edtcwoxxth.field('cwoxxth.id_iimxxmh').val() || 0;
								var query = {
									id_dbmxxth_old: id_dbmxxth_old,
									id_iimxxmh: id_iimxxmh,
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
					label: getTranslation('notes'),
					name: "cwoxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtcwoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcwoxxth.field('cwoxxth.start_at').val(start_at);
			edtcwoxxth.field('cwoxxth.id_iumxxmh_unit').disable();
			
			if(action == 'create'){
				tblcwoxxth.rows().deselect();
			}
		});

		edtcwoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtcwoxxth.dependent( 'cwoxxth.id_crfpxth', function ( val, data, callback ) {
			if (id_crfpxth_old != val) {
				edtcwoxxth.field('cwoxxth.id_crfittd').input().val(null).trigger('change');
				edtcwoxxth.field('cwoxxth.id_iumxxmh_unit').input().val(null).trigger('change');
			}
			return {}
		}, {event: 'keyup change'});

		edtcwoxxth.dependent( 'cwoxxth.id_crfittd', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('crfittd', val, 'id_iimxxmh,id_iumxxmh_unit');
				id_iimxxmh = autofillData.id_iimxxmh;
				id_iumxxmh_old = autofillData.id_iumxxmh_unit;
				
				edtcwoxxth.field('cwoxxth.id_iumxxmh_unit').val(id_iumxxmh_old);
				edtcwoxxth.field('cwoxxth.id_iimxxmh').val(id_iimxxmh);
				
				edtcwoxxth.field('cwoxxth.id_dbmxxth').input().val(null).trigger('change');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtcwoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtcwoxxth.field('cwoxxth.tanggal').val();
				id_crfpxth = edtcwoxxth.field('cwoxxth.id_crfpxth').val();
				jumlah_unit = edtcwoxxth.field('cwoxxth.jumlah_unit').val();

				validasiRequired(
					edtcwoxxth,
					'cwoxxth',
					{
						'tanggal': tanggal,
						'id_crfpxth': id_crfpxth,
					}
				);
				
				validasiNumber(
					edtcwoxxth,
					'cwoxxth',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);
			}
			
			if ( edtcwoxxth.inError() ) {
				return false;
			}
		});

		edtcwoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcwoxxth.field('cwoxxth.finish_at').val(finish_at);
		});
		
		edtcwoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblcwoittd.ajax.reload(null, false);
		} );

		edtcwoxxth.on( 'close', function () {
			edtcwoxxth.enable();
		} );
		
		tblcwoxxth = $('#tblcwoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/cwoxxth/cwoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_cwoxxth = show_deleted_cwoxxth;
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
				{ data: "cwoxxth.id",visible:false },
				{ data: "cwoxxth.tanggal" },
				{ data: "crfpxth.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "cwoxxth.jumlah_unit", ...renderNumber(2) },
				{ data: "iumxxmh.kode" },
				{ 
					data: "cwoxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_cwoxxth';
					$table       = 'tblcwoxxth';
					$edt         = 'edtcwoxxth';
					$show_status = '_cwoxxth';
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
				if ( data.cwoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.cwoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblcwoxxth.searchPanes.container().appendTo('#spcwoxxth');
		tblcwoxxth.searchBuilder.container().appendTo( '#sbcwoxxth' );
		
		tblcwoxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblcwoittd];
			CekInitHeaderHD(tblcwoxxth, tbl_details);
		} );
		
		tblcwoxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('cwoxxth');
			id_crfpxth_old = cwoxxth_data.id_crfpxth;
			id_crfittd_old = cwoxxth_data.id_crfittd;
			id_dbmxxth_old = cwoxxth_data.id_dbmxxth;
			id_iumxxmh_old = cwoxxth_data.id_iumxxmh_unit;
			
			// atur hak akses
			tbl_details = [tblcwoittd];
			CekSelectHeaderHD(tblcwoxxth, tbl_details);

		} );
		
		tblcwoxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('cwoxxth');
			id_cwoxxth = 0;
			id_crfpxth_old = 0;
			id_crfittd_old = 0;
			id_dbmxxth_old = 0;
			id_iumxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblcwoittd];
			CekDeselectHeaderHD(tblcwoxxth, tbl_details);
		} );
		// END cwoxxth

		// BEGIN cwoittd
		edtcwoittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/cwoxxth/cwoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_cwoittd = show_deleted_cwoittd;
					d.id_cwoxxth = id_cwoxxth;
				}
			},
			table: "#tblcwoittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "cwoittd.start_at",
					name: "cwoittd.start_at",
					type: "hidden"
				},	
				{
					label: "cwoittd.finish_at",
					name: "cwoittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "cwoittd",
					type: "hidden"
				},	
				{
					label: "cwoittd.transaction_state",
					name: "cwoittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_cwoxxth",
					name: "cwoittd.id_cwoxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('itemCode'),
					name: "cwoittd.kode",
					type: "readonly"
				}, 	
				{
					label: getTranslation('itemName'),
					name: "cwoittd.nama",
					type: "readonly"
				}, 	
				{
					label: "Quantity BoM",
					name: "cwoittd.jumlah_bom",
					type: "readonly"
				}, 	
				{
					label: "Quantity Total",
					name: "cwoittd.jumlah_total",
					type: "readonly"
				}, 	
				{
					label: getTranslation('uom'),
					name: "cwoittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_d,
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
					label: getTranslation('machine') + ` <sup class='text-danger'>*<sup>`,
					name: "cwoittd.id_rmsxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/rmsxxmh/rmsxxmh_work_order_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_rmsxxmh_old: id_rmsxxmh_old,
									id_cwoxxth: id_cwoxxth,
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
			]
		} );
			
		edtcwoittd.on( 'preOpen', function( e, mode, action ) {
			edtcwoittd.field('cwoittd.id_cwoxxth').val(id_cwoxxth);
			edtcwoittd.field('cwoittd.id_iumxxmh_unit').disable();
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcwoittd.field('cwoittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblcwoittd.rows().deselect();
			}
		});

		edtcwoittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtcwoittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_rmsxxmh = edtcwoittd.field('cwoittd.id_rmsxxmh').val();

				validasiRequired(
					edtcwoittd,
					'cwoittd',
					{
						'id_rmsxxmh': id_rmsxxmh
					}
				);

			}
			
			if ( edtcwoittd.inError() ) {
				return false;
			}
		});

		edtcwoittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcwoittd.field('cwoittd.finish_at').val(finish_at);
		});
			
		edtcwoittd.on( 'postSubmit', function (e, json, data, action, xhr) {
		} );

		edtcwoittd.on( 'close', function () {
			edtcwoittd.enable();
		} );
		
		tblcwoittd = $('#tblcwoittd').DataTable( {
			ajax: {
				url: "../../models/cwoxxth/cwoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_cwoittd = show_deleted_cwoittd;
					d.id_cwoxxth = id_cwoxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "cwoittd.id",visible:false },
				{ data: "cwoittd.id_cwoxxth",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "cwoittd.jumlah_bom", ...renderNumber(2) },
				{ data: "cwoittd.jumlah_total", ...renderNumber(2) },
				{ data: "iumxxmh.kode" },
				{ data: "rmsxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_cwoittd';
					$table       = 'tblcwoittd';
					$edt         = 'edtcwoittd';
					$show_status = '_cwoittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['edit', 'remove','view', 'log','noactionD'];
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

		tblcwoittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblcwoittd, 1 );
			CekDrawDetailHDFinal(tblcwoxxth);
		} );

		tblcwoittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('cwoittd');
			id_iimxxmh_d = cwoittd_data.id_iimxxmh;
			id_iumxxmh_d = cwoittd_data.id_iumxxmh_unit;
			id_rmsxxmh_old = cwoittd_data.id_rmsxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblcwoittd );
		} );

		tblcwoittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('cwoittd');
			id_iimxxmh_d = 0;
			id_iumxxmh_d = 0;
			id_rmsxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblcwoittd );
		} );
		// END cwoittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblcwoxxth.rows().deselect();
				tblcwoxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFcwoxxth').modal('toggle');
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
