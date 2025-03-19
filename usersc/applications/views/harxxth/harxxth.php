<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'harxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'harkptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFharxxth" tabindex="-1" role="dialog" aria-hidden="true">
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

				<div id="frmharxxth">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="harxxth.tanggal_efektif"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="harxxth.id_hemxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="hovxxmh_awal_nama"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="harxxth.id_hovxxmh_akhir"></editor-field>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<editor-field name="hodxxmh_awal_nama"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="harxxth.id_hodxxmh_akhir"></editor-field>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<editor-field name="hosxxmh_awal_nama"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="harxxth.id_hosxxmh_akhir"></editor-field>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<editor-field name="hevxxmh_awal_nama"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="harxxth.id_hevxxmh_akhir"></editor-field>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<editor-field name="hetxxmh_awal_nama"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="harxxth.id_hetxxmh_akhir"></editor-field>
								</div>
							</div>

						</div>
					</div>
				<div class="table-responsive">
                    <table id="tblharxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode</th>
								<th>Tanggal Efektif</th>
								<th>Nama Karyawan</th>
								<th>State</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabharkptd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabharkptd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblharkptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_harxxth</th>
										<th>Compensation</th>
										<th>Nominal</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabharkptd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblharkptd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_harxxth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/harxxth/fn/harxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtharxxth, tblharxxth, show_deleted_harxxth = 0, id_harxxth = 0;
	var edtharkptd, tblharkptd, show_deleted_harkptd = 0, id_harkptd;
	var id_hemxxmh_old = 0, id_hetxxmh_ditawarkan_old = 0, id_hetxxmh_dilamar_old = 0, id_hpcxxmh_old = 0;
	var id_hemxxmh_old = 0, id_hovxxmh_awal_old = 0, id_hovxxmh_akhir_old = 0, id_hodxxmh_awal_old = 0, id_hodxxmh_akhir_old = 0, id_hosxxmh_awal_old = 0, id_hosxxmh_akhir_old = 0, id_hevxxmh_awal_old = 0, id_hevxxmh_akhir_old = 0, id_hetxxmh_awal_old = 0, id_hetxxmh_akhir_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('harxxth');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN harxxth
		edtharxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/harxxth/harxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_harxxth = show_deleted_harxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblharxxth",
			template: "#frmharxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "harxxth.start_at",
					name: "harxxth.start_at",
					type: "hidden"
				},	
				{
					label: "harxxth.finish_at",
					name: "harxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "harxxth",
					type: "hidden"
				},	
				{
					label: "harxxth.transaction_state",
					name: "harxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "harxxth.tanggal_efektif",
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
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "harxxth.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
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
					label: "harxxth.id_hovxxmh_awal",
					name: "harxxth.id_hovxxmh_awal",
					// type: "hidden"
				},
				{
					label: "Divisi Awal",
					name: "hovxxmh_awal_nama",
					type: "readonly"
				},
				{
					label: "Divisi Akhir",
					name: "harxxth.id_hovxxmh_akhir",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hovxxmh/hovxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hovxxmh_old: id_hovxxmh_akhir_old,
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
					label: "harxxth.id_hodxxmh_awal",
					name: "harxxth.id_hodxxmh_awal",
					// type: "hidden"
				},
				{
					label: "Department Awal",
					name: "hodxxmh_awal_nama",
					type: "readonly"
				},
				{
					label: "Department Akhir",
					name: "harxxth.id_hodxxmh_akhir",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh_old: id_hodxxmh_akhir_old,
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
					label: "harxxth.id_hosxxmh_awal",
					name: "harxxth.id_hosxxmh_awal",
					// type: "hidden"
				},
				{
					label: "Section Awal",
					name: "hosxxmh_awal_nama",
					type: "readonly"
				},
				{
					label: "Section Akhir",
					name: "harxxth.id_hosxxmh_akhir",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hosxxmh/hosxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hosxxmh_old: id_hosxxmh_akhir_old,
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
					label: "harxxth.id_hevxxmh_awal",
					name: "harxxth.id_hevxxmh_awal",
					// type: "hidden"
				},
				{
					label: "Level Awal",
					name: "hevxxmh_awal_nama",
					type: "readonly"
				},
				{
					label: "Level Akhir",
					name: "harxxth.id_hevxxmh_akhir",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hevxxmh/hevxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hevxxmh_old: id_hevxxmh_akhir_old,
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
					label: "harxxth.id_hetxxmh_awal",
					name: "harxxth.id_hetxxmh_awal",
					// type: "hidden"
				},
				{
					label: "Jabatan Awal",
					name: "hetxxmh_awal_nama",
					type: "readonly"
				},
				{
					label: "Jabatan Akhir",
					name: "harxxth.id_hetxxmh_akhir",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hetxxmh/hetxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hetxxmh_old: id_hetxxmh_akhir_old,
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
					name: "harxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtharxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtharxxth.field('harxxth.start_at').val(start_at);

			if(action == 'create'){
				tblharxxth.rows().deselect();
			}
		});

		edtharxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtharxxth.dependent( 'harxxth.id_hemxxmh', function ( val, data, callback ) {
			if(val > 0){
				harxxth_load_hemxxmh();
			}
			return {}
		}, {event: 'keyup change'});
		
		edtharxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_efektif = edtharxxth.field('harxxth.tanggal_efektif').val();
				id_hemxxmh = edtharxxth.field('harxxth.id_hemxxmh').val();

				validasiRequired(
					edtharxxth,
					'harxxth',
					{
						'tanggal_efektif': tanggal_efektif,
						'id_hemxxmh': id_hemxxmh,
					}
				);

			}
			
			if ( edtharxxth.inError() ) {
				return false;
			}
		});

		edtharxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtharxxth.field('harxxth.finish_at').val(finish_at);
		});
		
		edtharxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtharxxth.on( 'close', function () {
			edtharxxth.enable();
		} );
		
		tblharxxth = $('#tblharxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/harxxth/harxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_harxxth = show_deleted_harxxth;
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
				{ data: "harxxth.id",visible:false },
				{ data: "harxxth.kode" },
				{ data: "harxxth.tanggal_efektif" },
				{ data: "hemxxmh_data" },
				{ 
					data: "harxxth.transaction_state",
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_harxxth';
					$table       = 'tblharxxth';
					$edt         = 'edtharxxth';
					$show_status = '_harxxth';
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
				if ( data.harxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.harxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblharxxth.searchPanes.container().appendTo('#spharxxth');
		tblharxxth.searchBuilder.container().appendTo( '#sbharxxth' );
		
		tblharxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblharkptd];
			CekInitHeaderHD(tblharxxth, tbl_details);
		} );
		
		tblharxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('harxxth');
			id_hemxxmh_old = harxxth_data.id_hemxxmh;
			
			id_hovxxmh_awal_old = harxxth_data.id_hovxxmh_awal;
			id_hovxxmh_akhir_old = harxxth_data.id_hovxxmh_akhir;

			id_hodxxmh_awal_old = harxxth_data.id_hodxxmh_awal;
			id_hodxxmh_akhir_old = harxxth_data.id_hodxxmh_akhir;

			id_hosxxmh_awal_old = harxxth_data.id_hosxxmh_awal;
			id_hosxxmh_akhir_old = harxxth_data.id_hosxxmh_akhir;

			id_hevxxmh_awal_old = harxxth_data.id_hevxxmh_awal;
			id_hevxxmh_akhir_old = harxxth_data.id_hevxxmh_akhir;

			id_hetxxmh_awal_old = harxxth_data.id_hetxxmh_awal;
			id_hetxxmh_akhir_old = harxxth_data.id_hetxxmh_akhir;

			// atur hak akses
			tbl_details = [tblharkptd];
			CekSelectHeaderHD(tblharxxth, tbl_details);

		} );
		
		tblharxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('harxxth');
			id_hemxxmh_old = 0, id_hovxxmh_awal_old = 0, id_hovxxmh_akhir_old = 0, id_hodxxmh_awal_old = 0, id_hodxxmh_akhir_old = 0, id_hosxxmh_awal_old = 0, id_hosxxmh_akhir_old = 0, id_hevxxmh_awal_old = 0, id_hevxxmh_akhir_old = 0, id_hetxxmh_awal_old = 0, id_hetxxmh_akhir_old = 0;

			// atur hak akses
			tbl_details = [tblharkptd];
			CekDeselectHeaderHD(tblharxxth, tbl_details);
		} );
		// END harxxth

		// BEGIN harkptd
		edtharkptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/harxxth/harkptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_harkptd = show_deleted_harkptd;
					d.id_harxxth = id_harxxth;
				}
			},
			table: "#tblharkptd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "harkptd.start_at",
					name: "harkptd.start_at",
					type: "hidden"
				},	
				{
					label: "harkptd.finish_at",
					name: "harkptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "harkptd",
					type: "hidden"
				},	
				{
					label: "harkptd.transaction_state",
					name: "harkptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_harxxth",
					name: "harkptd.id_harxxth",
					type: "hidden"
				},	
				{
					label: "Compensation <sup class='text-danger'>*<sup>", 
					name: "harkptd.id_hpcxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							// url: "../../models/hattpmh/hattpmh_hpcxxmh_fn_opt.php",
							url: "../../models/hpcxxmh/hpcxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hpcxxmh_old: id_hpcxxmh_old,
									// id_hattpmh_old: id_hattpmh_old,
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
					label: "Nominal <sup class='text-danger'>*<sup>", 
					name: "harkptd.nominal",
				},
			]
		} );

		//masking
		unmaskedData = maskingNumber(
			edtharkptd, 
			"harkptd", 
			[
				"nominal", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);

		edtharkptd.on( 'preOpen', function( e, mode, action ) {
			edtharkptd.field('harkptd.id_harxxth').val(id_harxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtharkptd.field('harkptd.start_at').val(start_at);
			
			if(action == 'create'){
				tblharkptd.rows().deselect();
			}
		});

		edtharkptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtharkptd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hpcxxmh = edtharkptd.field('harkptd.id_hpcxxmh').val();

				validasiRequired(
					edtharkptd,
					'harkptd',
					{
						'id_hpcxxmh': id_hpcxxmh,
					}
				);
			}
			
			if ( edtharkptd.inError() ) {
				return false;
			}
		});

		edtharkptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtharkptd.field('harkptd.finish_at').val(finish_at);
		});
			
		edtharkptd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblharxxth.ajax.reload(null, false);
			tblharkptd.rows().deselect();
			tblharkptd.ajax.reload(null, false);
		} );

		edtharkptd.on( 'close', function () {
			edtharkptd.enable();
		} );
		
		tblharkptd = $('#tblharkptd').DataTable( {
			ajax: {
				url: "../../models/harxxth/harkptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_harkptd = show_deleted_harkptd;
					d.id_harxxth = id_harxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "harkptd.id",visible:false },
				{ data: "harkptd.id_harxxth",visible:false },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "harkptd.nominal",
					...renderNumber()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_harkptd';
					$table       = 'tblharkptd';
					$edt         = 'edtharkptd';
					$show_status = '_harkptd';
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

		tblharkptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblharkptd, 1 );
			CekDrawDetailHDFinal(tblharxxth);
		} );

		tblharkptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('harkptd');
			id_hpcxxmh_old = harkptd_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblharkptd );
		} );

		tblharkptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('harkptd');
			id_hpcxxmh_old = 0;
			// atur hak akses
			CekDeselectDetailHD( tblharkptd );
		} );
		// END harkptd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblharxxth.rows().deselect();
				tblharxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFharxxth').modal('toggle');
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
