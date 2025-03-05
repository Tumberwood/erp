<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'crfpxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'crfittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFcrfpxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblcrfpxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th data-i18n="date"></th>
                                <th data-i18n="code"></th>
								<th data-i18n="state"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabcrfittd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabcrfittd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabcrfittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblcrfittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_crfpxth</th>
										<th data-i18n="customer"></th>
										<th data-i18n="salesOrder"></th>
										<th data-i18n="item"></th>
										<th data-i18n="quantity"></th>
										<th data-i18n="uom"></th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabcrfittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblcrfittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_crfpxth</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
									</tr>
								</thead>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/crfpxth/fn/crfpxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtcrfpxth, tblcrfpxth, show_deleted_crfpxth = 0, id_crfpxth;
	var edtcrfittd, tblcrfittd, show_deleted_crfittd = 0, id_crfittd;
	var id_grlxxmh_old = 0, id_iimxxmh_old = 0, id_sodxxth_old = 0, id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('crfpxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN crfpxth
		edtcrfpxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/crfpxth/crfpxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_crfpxth = show_deleted_crfpxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblcrfpxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},
				{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},
				{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "crfpxth.start_at",
					name: "crfpxth.start_at",
					type: "hidden"
				},	
				{
					label: "crfpxth.finish_at",
					name: "crfpxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "crfpxth",
					type: "hidden"
				},	
				{
					label: "crfpxth.transaction_state",
					name: "crfpxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('date') + " <sup class='text-danger'>*<sup>",
					name: "crfpxth.tanggal",
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
					label: "By Order",
					name: "crfpxth.is_by_order",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: getTranslation('notes'),
					name: "crfpxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtcrfpxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcrfpxth.field('crfpxth.start_at').val(start_at);

			if(action == 'create'){
				tblcrfpxth.rows().deselect();
			}
		});

		edtcrfpxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtcrfpxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtcrfpxth.field('crfpxth.tanggal').val();
				is_by_order = edtcrfpxth.field('crfpxth.is_by_order').val();

				validasiRequired(
					edtcrfpxth,
					'crfpxth',
					{
						'tanggal': tanggal,
					}
				);
			}
			
			if ( edtcrfpxth.inError() ) {
				return false;
			}
		});

		edtcrfpxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcrfpxth.field('crfpxth.finish_at').val(finish_at);
		});
		
		edtcrfpxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtcrfpxth.on( 'close', function () {
			edtcrfpxth.enable();
		} );
		
		tblcrfpxth = $('#tblcrfpxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/crfpxth/crfpxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_crfpxth = show_deleted_crfpxth;
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
				{ data: "crfpxth.id",visible:false },
				{ data: "crfpxth.tanggal" },
				{ data: "crfpxth.kode" },
				{ 
					data: "crfpxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_crfpxth';
					$table       = 'tblcrfpxth';
					$edt         = 'edtcrfpxth';
					$show_status = '_crfpxth';
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
				if ( data.crfpxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.crfpxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblcrfpxth.searchPanes.container().appendTo('#spcrfpxth');
		tblcrfpxth.searchBuilder.container().appendTo( '#sbcrfpxth' );
		
		tblcrfpxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblcrfittd];
			CekInitHeaderHD(tblcrfpxth, tbl_details);
		} );
		
		tblcrfpxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('crfpxth');
			is_by_order = crfpxth_data.is_by_order;
			
			// atur hak akses
			tbl_details = [tblcrfittd];
			CekSelectHeaderHD(tblcrfpxth, tbl_details);

		} );
		
		tblcrfpxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('crfpxth');
			is_by_order = 0;

			// atur hak akses
			tbl_details = [tblcrfittd];
			CekDeselectHeaderHD(tblcrfpxth, tbl_details);
		} );
		// END crfpxth

		// BEGIN crfittd
		edtcrfittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/crfpxth/crfittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_crfittd = show_deleted_crfittd;
					d.id_crfpxth = id_crfpxth;
				}
			},
			table: "#tblcrfittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "crfittd.start_at",
					name: "crfittd.start_at",
					type: "hidden"
				},	
				{
					label: "crfittd.finish_at",
					name: "crfittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "crfittd",
					type: "hidden"
				},	
				{
					label: "crfittd.transaction_state",
					name: "crfittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_crfpxth",
					name: "crfittd.id_crfpxth",
					type: "hidden"
				},	
				{
					label: getTranslation('customer') + ' <sup class="text-danger">*</sup>',
					name: "crfittd.id_grlxxmh_customer",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/scuxxmh/scuxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_old,
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
					label: getTranslation('salesOrder') + ' <sup class="text-danger">*</sup>',
					name: "crfittd.id_sodxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/crfpxth/crfpxth_sodxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_grlxxmh_customer = edtcrfittd.field('crfittd.id_grlxxmh_customer').val();
								// console.log(id_grlxxmh_customer);
								var query = {
									id_grlxxmh_customer: id_grlxxmh_customer,
									id_sodxxth_old: id_sodxxth_old,
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
					label: "crfittd.id_sodittd",
					name: "crfittd.id_sodittd",
					type: "hidden"
				},
				{
					label: getTranslation('item') + ' <sup class="text-danger">*</sup>',
					name: "crfittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: function() {
								id_sodxxth = edtcrfittd.field('crfittd.id_sodxxth').val();
								
								return id_sodxxth > 0 
								? "../../models/crfpxth/crfittd_sodittd_fn_opt.php" 
								: "../../models/iimxxmh/iimxxmh_fn_opt.php";
							},
							// url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_sodxxth = edtcrfittd.field('crfittd.id_sodxxth').val();
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									id_sodxxth: id_sodxxth,
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "crfittd.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "crfittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								id_iimxxmh = edtcrfittd.field('crfittd.id_iimxxmh').val();
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
					label: "Customer Delivery Request",
					name: "crfittd.tanggal_dibutuhkan_customer",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Internal Delivery Request <sup class='text-danger'>*<sup>",
					name: "crfittd.tanggal_dibutuhkan",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
			]
		} );
			
		edtcrfittd.on( 'preOpen', function( e, mode, action ) {
			edtcrfittd.field('crfittd.id_crfpxth').val(id_crfpxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcrfittd.field('crfittd.start_at').val(start_at);
			edtcrfittd.field('crfittd.tanggal_dibutuhkan_customer').disable();
			
			if(action == 'create'){
				tblcrfittd.rows().deselect();
			}

			if (is_by_order == 1) {
				edtcrfittd.field('crfittd.id_sodxxth').label(getTranslation('salesOrder') + ' <sup class="text-danger">*</sup>');
				edtcrfittd.field('crfittd.id_grlxxmh_customer').label(getTranslation('customer') + ' <sup class="text-danger">*</sup>');
			} else {
				edtcrfittd.field('crfittd.id_sodxxth').label(getTranslation('salesOrder'));
				edtcrfittd.field('crfittd.id_grlxxmh_customer').label(getTranslation('customer'));
			}
		});

		edtcrfittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtcrfittd.dependent( 'crfittd.id_iimxxmh', function ( val, data, callback ) {
			id_sodxxth = edtcrfittd.field('crfittd.id_sodxxth').val();
			crfittd_fn_sodittd(id_sodxxth,val);
			if (id_iimxxmh_old != val) {
				edtcrfittd.field('crfittd.id_iumxxmh_unit').input().val(null).trigger('change');
			}
			return {}
		}, {event: 'keyup change'});

		edtcrfittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iimxxmh = edtcrfittd.field('crfittd.id_iimxxmh').val();
				jumlah_unit = edtcrfittd.field('crfittd.jumlah_unit').val();
				id_iumxxmh_unit = edtcrfittd.field('crfittd.id_iumxxmh_unit').val();
				tanggal_dibutuhkan = edtcrfittd.field('crfittd.tanggal_dibutuhkan').val();
				
				id_sodxxth = edtcrfittd.field('crfittd.id_sodxxth').val();
				id_grlxxmh_customer = edtcrfittd.field('crfittd.id_grlxxmh_customer').val();

				if (is_by_order == 1) {
					validasiRequired(
						edtcrfittd,
						'crfittd',
						{
							'id_sodxxth': id_sodxxth,
							'id_grlxxmh_customer': id_grlxxmh_customer,
						}
					);
				}
				validasiRequired(
					edtcrfittd,
					'crfittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'tanggal_dibutuhkan': tanggal_dibutuhkan,
					}
				);

				
				validasiNumber(
					edtcrfittd,
					'crfittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);
				
				validasiUnique(
					action,
					edtcrfittd,
					'crfittd',
					"id_iimxxmh", 
					'id_iimxxmh,id_crfpxth',
					id_iimxxmh+','+id_crfpxth,
					id_crfittd
				);
			}
			
			if ( edtcrfittd.inError() ) {
				return false;
			}
		});

		edtcrfittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtcrfittd.field('crfittd.finish_at').val(finish_at);
		});
			
		edtcrfittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtcrfittd.on( 'close', function () {
			edtcrfittd.enable();
		} );
		
		tblcrfittd = $('#tblcrfittd').DataTable( {
			ajax: {
				url: "../../models/crfpxth/crfittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_crfittd = show_deleted_crfittd;
					d.id_crfpxth = id_crfpxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "crfittd.id",visible:false },
				{ data: "crfittd.id_crfpxth",visible:false },
				{ data: "grlxxmh.nama" },
				{ data: "sodxxth.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "crfittd.jumlah_unit",
					...renderNumber(2)
				},
				{ data: "iumxxmh.kode" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_crfittd';
					$table       = 'tblcrfittd';
					$edt         = 'edtcrfittd';
					$show_status = '_crfittd';
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
			}
		} );

		tblcrfittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblcrfittd, 1 );
			CekDrawDetailHDFinal(tblcrfpxth);
		} );

		tblcrfittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('crfittd');
			id_iimxxmh_old = crfittd_data.id_iimxxmh;
			id_sodxxth_old = crfittd_data.id_sodxxth;
			id_iumxxmh_unit_old = crfittd_data.id_iumxxmh_unit;
			id_grlxxmh_old = crfittd_data.id_grlxxmh_customer;
			
			// atur hak akses
			CekSelectDetailHD( tblcrfittd );
		} );

		tblcrfittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('crfittd');
			id_iimxxmh_old = 0
			id_sodxxth_old = 0
			id_iumxxmh_unit_old = 0
			id_grlxxmh_old = 0
			
			// atur hak akses
			CekDeselectDetailHD( tblcrfittd );
		} );
		// END crfittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblcrfpxth.rows().deselect();
				tblcrfpxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFcrfpxth').modal('toggle');
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
