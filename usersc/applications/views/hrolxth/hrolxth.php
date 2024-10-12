<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hrolxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hropctd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhrolxth" tabindex="-1" role="dialog" aria-hidden="true">
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
					<div id="frmhrolxth">
						<div class="panel-body">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hcdxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.tanggal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hetxxmh_dilamar"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hetxxmh_ditawarkan"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_heyxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hevxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hovxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hodxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_hosxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.id_holxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="hrolxth.keterangan"></editor-field>
								</div>
							</div>
						</div>
					</div>
                    <table id="tblhrolxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode</th>
								<th>Nama Kandidat</th>
								<th>Jabatan Dilamar</th>
								<th>Jabatan ditawarkan</th>
								<th>Tanggal Mulai Kerja</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhropctd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhropctd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhropctd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrolxth</th>
										<th>Kompensasi</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhropctd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhropctd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrolxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrolxth/fn/hrolxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthrolxth, tblhrolxth, show_deleted_hrolxth = 0, id_hrolxth;
	var edthropctd, tblhropctd, show_deleted_hropctd = 0, id_hropctd;
	var id_hcdxxmh_old = 0, id_hetxxmh_ditawarkan_old = 0, id_hetxxmh_dilamar_old = 0, id_hpcxxmh_old = 0;
	var id_hovxxmh_old = 0, id_hodxxmh_old = 0, id_hosxxmh_old = 0, id_hetxxmh_old = 0, id_hevxxmh_old = 0, id_heyxxmh_old = 0, id_hesxxmh_old = 0, id_holxxmh_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hrolxth');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hrolxth
		edthrolxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrolxth/hrolxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrolxth = show_deleted_hrolxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmhrolxth",
			table: "#tblhrolxth",
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
					label: "hrolxth.start_at",
					name: "hrolxth.start_at",
					type: "hidden"
				},	
				{
					label: "hrolxth.finish_at",
					name: "hrolxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrolxth",
					type: "hidden"
				},	
				{
					label: "hrolxth.transaction_state",
					name: "hrolxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kandidat <sup class='text-danger'>*<sup>", 
					name: "hrolxth.id_hcdxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hcdxxmh/hcdxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hcdxxmh_old: id_hcdxxmh_old,
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
					label: "Jabatan Dilamar ",
					name: "hrolxth.id_hetxxmh_dilamar",
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
									id_hetxxmh_old: id_hetxxmh_dilamar = 0,
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
					label: "Jabatan Ditawarkan",
					name: "hrolxth.id_hetxxmh_ditawarkan",
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
									id_hetxxmh_old: id_hetxxmh_ditawarkan = 0,
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
					label: "Employee Type <sup class='text-danger'>*<sup>",
					name: "hrolxth.id_heyxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/heyxxmh/heyxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_heyxxmh_old: id_heyxxmh_old,
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
					label: "Employee Level<sup class='text-danger'>*<sup>",
					name: "hrolxth.id_hevxxmh",
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
									id_hevxxmh_old: id_hevxxmh_old,
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
					label: "Divisi <sup class='text-danger'>*<sup>",
					name: "hrolxth.id_hovxxmh",
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
									id_hovxxmh_old: id_hovxxmh_old,
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
					label: "Department <sup class='text-danger'>*<sup>",
					name: "hrolxth.id_hodxxmh",
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
									id_hodxxmh_old: id_hodxxmh_old,
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
					label: "Section ",
					name: "hrolxth.id_hosxxmh",
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
									id_hosxxmh_old: id_hosxxmh_old,
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
					label: "Lokasi Kerja ",
					name: "hrolxth.id_holxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/holxxmh/holxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_holxxmh_old: id_holxxmh_old,
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
					label: "Tanggal Mulai Kerja<sup class='text-danger'>*<sup>",
					name: "hrolxth.tanggal",
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
					label: "Notes",
					name: "hrolxth.keterangan",
					type: "textarea",
				},
			]
		} );
		
		edthrolxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrolxth.field('hrolxth.start_at').val(start_at);

			if(action == 'create'){
				tblhrolxth.rows().deselect();
			}
		});

		edthrolxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthrolxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_heyxxmh = edthrolxth.field('hrolxth.id_heyxxmh').val();
				id_hevxxmh = edthrolxth.field('hrolxth.id_hevxxmh').val();
				id_hovxxmh = edthrolxth.field('hrolxth.id_hovxxmh').val();
				id_hodxxmh = edthrolxth.field('hrolxth.id_hodxxmh').val();
				id_hcdxxmh = edthrolxth.field('hrolxth.id_hcdxxmh').val();

				validasiRequired(
					edthrolxth,
					'hrolxth',
					{
						'id_heyxxmh': id_heyxxmh,
						'id_hevxxmh': id_hevxxmh,
						'id_hovxxmh': id_hovxxmh,
						'id_hodxxmh': id_hodxxmh,
						'id_hcdxxmh': id_hcdxxmh,
					}
				);

			}
			
			if ( edthrolxth.inError() ) {
				return false;
			}
		});

		edthrolxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrolxth.field('hrolxth.finish_at').val(finish_at);
		});
		
		edthrolxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthrolxth.on( 'close', function () {
			edthrolxth.enable();
		} );
		
		tblhrolxth = $('#tblhrolxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrolxth/hrolxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrolxth = show_deleted_hrolxth;
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
				{ data: "hrolxth.id",visible:false },
				{ data: "hrolxth.kode" },
				{ data: "hcdxxmh.nama" },
				{ data: "dilamar.nama" },
				{ data: "ditawarkan.nama" },
				{ data: "hrolxth.tanggal" },
				{ 
					data: "hrolxth.transaction_state",
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrolxth';
					$table       = 'tblhrolxth';
					$edt         = 'edthrolxth';
					$show_status = '_hrolxth';
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
				if ( data.hrolxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrolxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrolxth.searchPanes.container().appendTo('#sphrolxth');
		tblhrolxth.searchBuilder.container().appendTo( '#sbhrolxth' );
		
		tblhrolxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhropctd];
			CekInitHeaderHD(tblhrolxth, tbl_details);
		} );
		
		tblhrolxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrolxth');
			id_hetxxmh_dilamar_old = hrolxth_data.id_hetxxmh_dilamar;
			id_hetxxmh_ditawarkan_old = hrolxth_data.id_hetxxmh_ditawarkan;
			id_heyxxmh_old = hrolxth_data.id_heyxxmh;
			id_hevxxmh_old = hrolxth_data.id_hevxxmh;
			id_hovxxmh_old = hrolxth_data.id_hovxxmh;
			id_hovxxmh_old = hrolxth_data.id_hovxxmh;
			id_hodxxmh_old = hrolxth_data.id_hodxxmh;
			id_hosxxmh_old = hrolxth_data.id_hosxxmh;
			id_holxxmh_old = hrolxth_data.id_holxxmh;
			id_hcdxxmh_old = hrolxth_data.id_hcdxxmh;
			
			// atur hak akses
			tbl_details = [tblhropctd];
			CekSelectHeaderHD(tblhrolxth, tbl_details);

		} );
		
		tblhrolxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrolxth');
			id_hetxxmh_dilamar_old = 0;
			id_hetxxmh_ditawarkan_old = 0;
			id_heyxxmh_old = 0;
			id_hevxxmh_old = 0;
			id_hovxxmh_old = 0;
			id_hovxxmh_old = 0;
			id_hodxxmh_old = 0;
			id_hosxxmh_old = 0;
			id_holxxmh_old = 0;
			id_hcdxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblhropctd];
			CekDeselectHeaderHD(tblhrolxth, tbl_details);
		} );
		// END hrolxth

		// BEGIN hropctd
		edthropctd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrolxth/hropctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hropctd = show_deleted_hropctd;
					d.id_hrolxth = id_hrolxth;
				}
			},
			table: "#tblhropctd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hropctd.start_at",
					name: "hropctd.start_at",
					type: "hidden"
				},	
				{
					label: "hropctd.finish_at",
					name: "hropctd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hropctd",
					type: "hidden"
				},	
				{
					label: "hropctd.transaction_state",
					name: "hropctd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hrolxth",
					name: "hropctd.id_hrolxth",
					type: "hidden"
				},	
				{
					label: "Kompensasi <sup class='text-danger'>*<sup>", 
					name: "hropctd.id_hpcxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hpcxxmh/hpcxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hpcxxmh_old: id_hpcxxmh_old,
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
					label: "Nilai <sup class='text-danger'>*<sup>", 
					name: "hropctd.nilai",
				},
			]
		} );

		edthropctd.on( 'preOpen', function( e, mode, action ) {
			edthropctd.field('hropctd.id_hrolxth').val(id_hrolxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthropctd.field('hropctd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhropctd.rows().deselect();
			}
		});

		edthropctd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthropctd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hpcxxmh = edthropctd.field('hropctd.id_hpcxxmh').val();
				nilai = edthropctd.field('hropctd.nilai').val();

				validasiRequired(
					edthropctd,
					'hropctd',
					{
						'id_hpcxxmh': id_hpcxxmh,
						'nilai': nilai,
					}
				);
				
				validasiNumber(
					edthropctd,
					'hropctd',
					{
						'nilai': nilai,
					},
					0,
					'>'
				);
			}
			
			if ( edthropctd.inError() ) {
				return false;
			}
		});

		edthropctd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthropctd.field('hropctd.finish_at').val(finish_at);
		});
			
		edthropctd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhrolxth.ajax.reload(null, false);
			tblhropctd.rows().deselect();
			tblhropctd.ajax.reload(null, false);
		} );

		edthropctd.on( 'close', function () {
			edthropctd.enable();
		} );
		
		tblhropctd = $('#tblhropctd').DataTable( {
			ajax: {
				url: "../../models/hrolxth/hropctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hropctd = show_deleted_hropctd;
					d.id_hrolxth = id_hrolxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hropctd.id",visible:false },
				{ data: "hropctd.id_hrolxth",visible:false },
				{ data: "hpcxxmh.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hropctd';
					$table       = 'tblhropctd';
					$edt         = 'edthropctd';
					$show_status = '_hropctd';
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

		tblhropctd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhropctd, 1 );
			CekDrawDetailHDFinal(tblhrolxth);
		} );

		tblhropctd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hropctd');
			id_hpcxxmh_old = hropctd_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhropctd );
		} );

		tblhropctd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hropctd');
			id_hpcxxmh_old = 0;
			// atur hak akses
			CekDeselectDetailHD( tblhropctd );
		} );
		// END hropctd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhrolxth.rows().deselect();
				tblhrolxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhrolxth').modal('toggle');
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
