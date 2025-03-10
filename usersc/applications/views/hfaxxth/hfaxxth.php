<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hfaxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hfasktd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhfaxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhfaxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Periode</th>
                                <th data-i18n="employeeCode"></th>
                                <th data-i18n="employeeName"></th>
                                <th data-i18n="division"></th>
                                <th data-i18n="department"></th>
                                <th data-i18n="employeeTitle"></th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="alert alert-info alert-dismissable">
			Pilih baris data pada detail KPI Skor untuk mengisi detail PICA.
		</div>
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li id="tab_kpi"><a class="nav-link active" data-toggle="tab" href="#tabhfskptd_1"> KPI Skor</a></li>
				<li id="pika_d" style="display: none"><a class="nav-link" data-toggle="tab" href="#tabhfasktd_2"> Detail PICA</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhfskptd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<div id="frmhfskptd">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hfskptd.id_hfmxxmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hfskptd.id_iumxxmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hfskptd.id_hfoxxmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hfskptd.id_hfogrmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hfskptd.id_hfoprmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hfskptd.polarisasi"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hfskptd.target_atas"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hfskptd.target_bawah"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hfskptd.bobot_persen"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hfskptd.cara_hitung"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hfskptd.realisasi"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hfskptd.skor"></editor-field>
										</div>
									</div>
								</div>
							</div>
							<table id="tblhfskptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hfsxxth</th>
										<th>id_hfogrmh</th>
										<th>Objective</th>
										<th>Code</th>
										<th>Measurement</th>
										<th>UoM</th>
										<th>Periode</th>
										<th>Polarisasi</th>
										<th>Target Atas</th>
										<th>Target Bawah</th>
										<th>Pencapaian</th>
										<th>Bobot (%)</th>
										<th>Skor</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th>Total</th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="bobot"></th>
										<th id="skor"></th>
									</tr>
								</tfoot>
							</table>
							<span class="badge bg-dark text-white">Not Available</span>
							<span class="badge bg-danger">Off Target</span>
							<span class="badge bg-warning">Between Target Atas & Bawah</span>
							<span class="badge bg-primary">On Target</span>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhfasktd_2" class="tab-pane">
					<div class="panel-body">
						<div id="pica_h3">
						</div>
						<div class="table-responsive">
							<table id="tblhfasktd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hfaxxth</th>
										<th>Problem</th>
										<th>Corrective</th>
										<th>Preventive</th>
										<th>Due Date</th>
										<th>Verificator</th>
										<th>Status</th>
									</tr>
								</thead>
							</table>
						</div>
						<h3>History</h3>
						<div class="table-responsive">
							<table id="tblhfasltd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hfaxxth</th>
										<th>id_hfasktd</th>
										<th>Status</th>
										<th data-i18n="notes"></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfaxxth/fn/hfaxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthfaxxth, tblhfaxxth, show_deleted_hfaxxth = 0, id_hfaxxth;
	var edthfasktd, tblhfasktd, show_deleted_hfasktd = 0, id_hfasktd;
	var edthfskptd, tblhfskptd, show_deleted_hfskptd = 0, id_hfskptd;
	var edthfasltd, tblhfasltd, show_deleted_hfasltd = 0, id_hfasltd;
	// ------------- end of default variable
	var id_hfsxxth_old = 0, id_hemxxmh_verificator_old = 0, id_hemxxmh_pic_old = 0;
	var id_hfkxxth_old = 0, id_hfkobtd_old = 0, skor_select = 0;
	var id_hemxxmh_old = 0, id_hfoxxmh_old = 0, id_hfoprmh_old = 0, id_iumxxmh_old = 0;
	var transaction_state_pica = 0;

	// get tableRelation
	tableRelation('hfaxxth');

	$(document).ready(function() {
		autofillField('ggshrsh', 1, 'batas_skor_revisi');
		var batas_skor_revisi = autofillData.batas_skor_revisi;

		$('#end_date').datepicker('setDate', today_add_m_dmy);

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hfaxxth
		edthfaxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfaxxth/hfaxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfaxxth = show_deleted_hfaxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhfaxxth",
			fields: [ 
				{
					label: "hfaxxth.start_at",
					name: "hfaxxth.start_at",
					type: "hidden"
				},	
				{
					label: "hfaxxth.finish_at",
					name: "hfaxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfaxxth",
					type: "hidden"
				},	
				{
					label: "hfaxxth.transaction_state",
					name: "hfaxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Periode <sup class='text-danger'>*<sup>",
					name: "hfaxxth.id_hfsxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfsxxth/hfsxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfsxxth_old: id_hfsxxth_old,
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
					label: "hfaxxth.id_hemxxmh",
					name: "hfaxxth.id_hemxxmh",
					type: "hidden",
				},
				{
					label: "hfaxxth.periode",
					name: "hfaxxth.periode",
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
			]
		} );
		
		edthfaxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfaxxth.field('hfaxxth.start_at').val(start_at);
			edthfaxxth.field('hfaxxth.periode').hide();

			if(action == 'create'){
				tblhfaxxth.rows().deselect();
			}
		});

		edthfaxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthfaxxth.dependent( 'hfaxxth.id_hfsxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('hfsxxth', val, 'id_hemxxmh,DATE_FORMAT(periode, "%d %b %Y") AS periode');
				id_hemxxmh = autofillData.id_hemxxmh;
				periode = autofillData.periode;
				console.log(periode);
				edthfaxxth.field('hfaxxth.id_hemxxmh').val(id_hemxxmh);
				edthfaxxth.field('hfaxxth.periode').val(periode);
			}
			return {}
		}, {event: 'keyup change'});
		
		edthfaxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hfsxxth = edthfaxxth.field('hfaxxth.id_hfsxxth').val();

				validasiRequired(
					edthfaxxth,
					'hfaxxth',
					{
						'id_hfsxxth': id_hfsxxth,
					}
				);

				validasiUnique(
					action,
					edthfaxxth,
					'hfaxxth',
					'id_hfsxxth',
					'id_hfsxxth',
					'"'+id_hfsxxth+'"',
					id_hfaxxth
				);
			}
			
			if ( edthfaxxth.inError() ) {
				return false;
			}
		});

		edthfaxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfaxxth.field('hfaxxth.finish_at').val(finish_at);
		});
		
		edthfaxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthfaxxth.on( 'close', function () {
			edthfaxxth.enable();
		} );
		
		tblhfaxxth = $('#tblhfaxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hfaxxth/hfaxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfaxxth = show_deleted_hfaxxth;
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
				{ data: "hfaxxth.id",visible:false },
				{ data: "hfaxxth.periode" },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hovxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ 
					data: "hfaxxth.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfaxxth';
					$table       = 'tblhfaxxth';
					$edt         = 'edthfaxxth';
					$show_status = '_hfaxxth';
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
				if ( data.hfaxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfaxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfaxxth.searchPanes.container().appendTo('#sphfaxxth');
		tblhfaxxth.searchBuilder.container().appendTo( '#sbhfaxxth' );
		
		tblhfaxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhfasktd];
			CekInitHeaderHD(tblhfaxxth, tbl_details);
		} );
		
		tblhfaxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfaxxth');
			id_hfsxxth_old = hfaxxth_data.id_hfsxxth;
			
			// atur hak akses
			tbl_details = [tblhfasktd];
			CekSelectHeaderHD(tblhfaxxth, tbl_details);
			tblhfskptd.ajax.reload(null, false);
			tblhfasltd.ajax.reload(null, false);	
		} );
		
		tblhfaxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfaxxth');
			id_hfsxxth_old = 0;
			id_hfasktd = 0;

			// atur hak akses
			tbl_details = [tblhfasktd];
			CekDeselectHeaderHD(tblhfaxxth, tbl_details);
			tblhfskptd.ajax.reload(null, false);
			tblhfasltd.ajax.reload(null, false);	
			$('#pika_d').hide();
			$('#tab_kpi a').tab('show');
		} );
		// END hfaxxth

		///////////////// KPI Skor ///////////////
		// BEGIN hfskptd
		
		edthfskptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfsxxth/hfskptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfskptd = show_deleted_hfskptd;
					d.id_hfsxxth = id_hfsxxth;
				}
			},
			template: "#frmhfskptd",
			table: "#tblhfskptd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hfskptd.start_at",
					name: "hfskptd.start_at",
					type: "hidden"
				},	
				{
					label: "hfskptd.finish_at",
					name: "hfskptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfskptd",
					type: "hidden"
				},	
				{
					label: "hfskptd.transaction_state",
					name: "hfskptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hfsxxth",
					name: "hfskptd.id_hfsxxth",
					type: "hidden"
				},	
				{
					label: "Objective <sup class='text-danger'>*<sup>",  
					name: "hfskptd.id_hfkobtd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfkxxth/hfkobtd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfkobtd_old: id_hfkobtd_old,
									id_hfkxxth: id_hfkxxth_old,
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
					label: "Measurement <sup class='text-danger'>*<sup>",  
					name: "hfskptd.id_hfmxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfmxxmh/hfmxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfmxxmh_old: id_hfmxxmh_old,
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
					label: "Objective",  
					name: "hfskptd.id_hfoxxmh",
					type: "select2",
					opts: {
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfoxxmh/hfoxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfoxxmh_old: id_hfoxxmh_old,
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
					label: "Grup Objective",  
					name: "hfskptd.id_hfogrmh",
					type: "select2",
					opts: {
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfogrmh/hfogrmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfogrmh_old: id_hfogrmh_old,
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
					label: "Periode",  
					name: "hfskptd.id_hfoprmh",
					type: "select2",
					opts: {
						
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfoprmh/hfoprmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfoprmh_old: id_hfoprmh_old,
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
					label: "Polarisasi", 
					name: "hfskptd.polarisasi",
				},
				{
					label: "Target Atas", 
					name: "hfskptd.target_atas",
				},
				{
					label: "Target Bawah", 
					name: "hfskptd.target_bawah",
				},
				{
					label: "UoM",  
					name: "hfskptd.id_iumxxmh",
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
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Bobot (%)", 
					name: "hfskptd.bobot_persen",
				},
				{
					label: "Cara Hitung", 
					name: "hfskptd.cara_hitung",
					type: "quill"
				},
				{
					label: "Realisasi <sup class='text-danger'>*<sup>",  
					name: "hfskptd.realisasi",
				},
				{
					label: "Skor",  
					name: "hfskptd.skor",
					type: "readonly"
				},
			]
		} );
			
		edthfskptd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfskptd.field('hfskptd.start_at').val(start_at);
			
			edthfskptd.field('hfskptd.id_hfmxxmh').disable();
			edthfskptd.field('hfskptd.id_hfoprmh').disable();
			edthfskptd.field('hfskptd.id_hfogrmh').disable();
			edthfskptd.field('hfskptd.id_hfoxxmh').disable();
			edthfskptd.field('hfskptd.id_iumxxmh').disable();
			edthfskptd.field('hfskptd.polarisasi').disable();
			edthfskptd.field('hfskptd.target_atas').disable();
			edthfskptd.field('hfskptd.target_bawah').disable();
			edthfskptd.field('hfskptd.bobot_persen').disable();
			edthfskptd.field('hfskptd.cara_hitung').disable();
			
			if(action == 'create'){
				tblhfskptd.rows().deselect();
			}
		});

		edthfskptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthfskptd.dependent( 'hfskptd.id_hfkobtd', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('hfkobtd', val, '*');
				id_hfoxxmh = autofillData.id_hfoxxmh;
				edthfskptd.field('hfskptd.id_hfoxxmh').val(id_hfoxxmh);
				id_hfoprmh = autofillData.id_hfoprmh;
				edthfskptd.field('hfskptd.id_hfoprmh').val(id_hfoprmh);
				id_iumxxmh_old = autofillData.id_iumxxmh;
				edthfskptd.field('hfskptd.id_iumxxmh').val(id_iumxxmh_old);
				polarisasi = autofillData.polarisasi;
				edthfskptd.field('hfskptd.polarisasi').val(polarisasi);
				target_atas = autofillData.target_atas;
				edthfskptd.field('hfskptd.target_atas').val(target_atas);
				target_bawah = autofillData.target_bawah;
				edthfskptd.field('hfskptd.target_bawah').val(target_bawah);
				bobot_persen = autofillData.bobot_persen;
				edthfskptd.field('hfskptd.bobot_persen').val(bobot_persen);
				cara_hitung = autofillData.cara_hitung;
				edthfskptd.field('hfskptd.cara_hitung').val(cara_hitung);
			}
			return {}
		}, {event: 'keyup change'});

		// edthfskptd.dependent( 'hfskptd.realisasi', function ( val, data, callback ) {
		// 	hitungSkor();
		// 	return {}
		// }, {event: 'keyup change'});

		edthfskptd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hfkobtd = edthfskptd.field('hfskptd.id_hfkobtd').val();
				realisasi = edthfskptd.field('hfskptd.realisasi').val();

				validasiRequired(
					edthfskptd,
					'hfskptd',
					{
						'id_hfkobtd': id_hfkobtd,
						'realisasi': realisasi,
					}
				);

				validasiUnique(
					action,
					edthfskptd,
					'hfskptd',
					'id_hfkobtd',
					'id_hfkobtd,id_hfsxxth',
					id_hfkobtd+','+id_hfsxxth,
					id_hfskptd
				);	

				
				validasiNumber(
					edthfskptd,
					'hfskptd',
					{
						'realisasi': realisasi,
					},
					0,
					'>='
				);
			}
			
			if ( edthfskptd.inError() ) {
				return false;
			}
		});

		edthfskptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfskptd.field('hfskptd.finish_at').val(finish_at);
		});
			
		edthfskptd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhfsxxth.ajax.reload(null, false);			
		} );

		edthfskptd.on( 'close', function () {
			edthfskptd.enable();
		} );
		
		tblhfskptd = $('#tblhfskptd').DataTable( {
			ajax: {
				url: "../../models/hfaxxth/hfskptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfskptd = show_deleted_hfskptd;
					d.id_hfsxxth = id_hfsxxth_old;
					d.batas_skor_revisi = batas_skor_revisi;
				}
			},
			responsive: false,
			order: [[ 2, "asc" ], [ 3, "asc" ]],
			columns: [
				{ data: "hfskptd.id",visible:false },
				{ data: "hfskptd.id_hfsxxth",visible:false },
				{ data: "hfskptd.id_hfogrmh",visible:false },
				{ data: "hfoxxmh.kode",visible:false },
				{ 
					data: "hfogrmh.kode",
					render: function (data, type, row, meta) {
						return '<span class="badge badge-plain" style="color: white; background-color: ' + row.hfogrmh.color + ';">' + data + '</span>';
					}
				},
				{ data: "hfmxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ data: "hfoprmh.nama" },
				{ 
					data: "hfskptd.polarisasi",
					render: function (data, type, row, meta) {
						if (data.toLowerCase() === 'max') {
							return '<span class="badge bg-primary"><i class="fa fa-arrow-up"></i> MAX</span>';
						}
						else {
							return '<span class="badge bg-danger"><i class="fa fa-arrow-down"></i> MIN</span>';
						}
					}
				},
				{ data: "hfskptd.target_atas", ...renderNumber(2) },
				{ data: "hfskptd.target_bawah", ...renderNumber(2) },
				{ data: "hfskptd.realisasi", ...renderNumber(2) },
				{ data: "hfskptd.bobot_persen", ...renderNumber(2) },
				{ data: "hfskptd.skor", ...renderNumber(2) },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfskptd';
					$table       = 'tblhfskptd';
					$edt         = 'edthfskptd';
					$show_status = '_hfskptd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['view', 'log'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			
			rowCallback: function( row, data, index ) {
				if ( parseFloat(data.hfskptd.bobot_persen) == parseFloat(data.hfskptd.skor) ) {
					$('td:eq(7)', row).addClass('bg-primary');
				} else {
					if 
							( 
								parseFloat(data.hfskptd.realisasi) > parseFloat(data.hfskptd.target_atas) && parseFloat(data.hfskptd.realisasi) < parseFloat(data.hfskptd.target_bawah)
								||
								parseFloat(data.hfskptd.realisasi) > parseFloat(data.hfskptd.target_bawah) && parseFloat(data.hfskptd.realisasi) < parseFloat(data.hfskptd.target_atas) 
							) 
					{
						$('td:eq(7)', row).addClass('bg-warning');
					} else if ( data.hfskptd.realisasi == null ) {
						$('td:eq(7)', row).addClass('bg-dark');
					} else {
						$('td:eq(7)', row).addClass('bg-danger');
					}
				}
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var bobot 	= api.column(12).data().sum();
				var skor 	= api.column(13).data().sum();

				$( '#bobot' ).html( dtNumberFormat(bobot) );
				$( '#skor' ).html( dtNumberFormat(skor) );
			}
		} );

		tblhfskptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
		} );

		tblhfskptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hfskptd');

			id_hfkobtd_old = hfskptd_data.id_hfkobtd;
			skor_select = hfskptd_data.skor;
			
			id_hfoxxmh_old = hfskptd_data.id_hfoxxmh;
			id_hfmxxmh_old = hfskptd_data.id_hfmxxmh;
			id_hfoprmh_old = hfskptd_data.id_hfoprmh;
			id_iumxxmh_old = hfskptd_data.id_iumxxmh;
			id_hfogrmh_old = hfskptd_data.id_hfogrmh;

			polarisasi = hfskptd_data.polarisasi;
			target_atas = hfskptd_data.target_atas;
			target_bawah = hfskptd_data.target_bawah;
			realisasi = hfskptd_data.realisasi;
			bobot_persen = hfskptd_data.bobot_persen;
			skor = hfskptd_data.skor;

			$('#pika_d').show();
			tblhfasktd.ajax.reload(null, false);
			tblhfasltd.ajax.reload(null, false);

			autofillField('hfmxxmh', id_hfmxxmh_old, "nama");
			hfmxxmh_nama = autofillData.nama;
			$('#pica_h3').html(`
				<div class="row">
					<div class="col-6">
						<h3>Measurement: ${hfmxxmh_nama}</h3>
						<h3>Target Atas: ${target_atas}</h3>
						<h3>Pencapaian: ${realisasi}</h3>
						<h3>Skor: ${skor}</h3>
					</div>
					<div class="col-6">
						<h3>Polarisasi: ${polarisasi}</h3>
						<h3>Target Bawah: ${target_bawah}</h3>
						<h3>Bobot: ${bobot_persen}</h3>
					</div>
				</div>
			`);
		} );
		
		tblhfskptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hfskptd');
			id_hfkobtd_old = 0;
			skor_select = 0;
			
			id_hfoxxmh_old = 0;
			id_hfmxxmh_old = 0;
			id_hfoprmh_old = 0;
			id_iumxxmh_old = 0;
			id_hfogrmh_old = 0;
			id_hfasktd = 0;

			$('#pika_d').hide();
			tblhfasktd.ajax.reload(null, false);	
			tblhfasltd.ajax.reload(null, false);
			
			// atur hak akses
		} );
		// END hfskptd
		///////////////////////////////////

		// BEGIN hfasktd
		edthfasktd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfaxxth/hfasktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfasktd = show_deleted_hfasktd;
					d.id_hfaxxth = id_hfaxxth;
					d.id_hfskptd = id_hfskptd;
				}
			},
			table: "#tblhfasktd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hfasktd.start_at",
					name: "hfasktd.start_at",
					type: "hidden"
				},	
				{
					label: "hfasktd.finish_at",
					name: "hfasktd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfasktd",
					type: "hidden"
				},	
				{
					label: "hfasktd.transaction_state",
					name: "hfasktd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hfaxxth",
					name: "hfasktd.id_hfaxxth",
					type: "hidden"
				},	
				{
					label: "id_hfskptd",
					name: "hfasktd.id_hfskptd",
					type: "hidden"
				},	
				{
					label: "Problem  <sup class='text-danger'>*<sup>", 
					name: "hfasktd.problem",
					type: "quill"
				},	
				{
					label: "Corrective  <sup class='text-danger'>*<sup>", 
					name: "hfasktd.corrective",
					type: "quill"
				},	
				{
					label: "Preventive <sup class='text-danger'>*<sup>", 
					name: "hfasktd.preventive",
					type: "quill"
				},	
				{
					label: "PIC <sup class='text-danger'>*<sup>",
					name: "hfasktd.id_hemxxmh_pic",
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
									id_hemxxmh_old: id_hemxxmh_pic_old,
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
					label: "Due Date <sup class='text-danger'>*<sup>",
					name: "hfasktd.tanggal",
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
					label: "Verificator <sup class='text-danger'>*<sup>",
					name: "hfasktd.id_hemxxmh_verificator",
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
									id_hemxxmh_old: id_hemxxmh_verificator_old,
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
					label: "Status <sup class='text-danger'>*<sup>",
					name: "hfasktd.status",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Open", "value": "Open" },
						{ "label": "Done", "value": "Done" },
					]
				},
			]
		} );
			
		edthfasktd.on( 'preOpen', function( e, mode, action ) {
			edthfasktd.field('hfasktd.id_hfaxxth').val(id_hfaxxth);
			edthfasktd.field('hfasktd.id_hfskptd').val(id_hfskptd);
			console.log(id_hfskptd);
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfasktd.field('hfasktd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhfasktd.rows().deselect();
			}
		});

		edthfasktd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthfasktd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				corrective = edthfasktd.field('hfasktd.corrective').val();
				problem = edthfasktd.field('hfasktd.problem').val();
				preventive = edthfasktd.field('hfasktd.preventive').val();
				id_hemxxmh_pic = edthfasktd.field('hfasktd.id_hemxxmh_pic').val();
				tanggal = edthfasktd.field('hfasktd.tanggal').val();
				id_hemxxmh_verificator = edthfasktd.field('hfasktd.id_hemxxmh_verificator').val();
				status = edthfasktd.field('hfasktd.status').val();

				validasiRequired(
					edthfasktd,
					'hfasktd',
					{
						'corrective': corrective,
						'problem': problem,
						'preventive': preventive,
						'id_hemxxmh_pic': id_hemxxmh_pic,
						'tanggal': tanggal,
						'id_hemxxmh_verificator': id_hemxxmh_verificator,
						'status': status,
					}
				);
			}
			
			if ( edthfasktd.inError() ) {
				return false;
			}
		});

		edthfasktd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfasktd.field('hfasktd.finish_at').val(finish_at);
		});
			
		edthfasktd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhfaxxth.ajax.reload(null, false);			
		} );

		edthfasktd.on( 'close', function () {
			edthfasktd.enable();
		} );
		
		tblhfasktd = $('#tblhfasktd').DataTable( {
			ajax: {
				url: "../../models/hfaxxth/hfasktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfasktd = show_deleted_hfasktd;
					d.id_hfaxxth = id_hfaxxth;
					d.id_hfskptd = id_hfskptd;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hfasktd.id",visible:false },
				{ data: "hfasktd.id_hfaxxth",visible:false },
				{ data: "hfasktd.problem"},
				{ data: "hfasktd.corrective"},
				{ data: "hfasktd.preventive"},
				{ data: "hfasktd.tanggal"},
				{ data: "verificator.nama"},
				{ data: "hfasktd.status"},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfasktd';
					$table       = 'tblhfasktd';
					$edt         = 'edthfasktd';
					$show_status = '_hfasktd';
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

		tblhfasktd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhfasktd, 1 );
			CekDrawDetailHDFinal(tblhfaxxth);
		} );
		
		tblhfasktd.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhfasltd];
			CekInitHeaderHD(tblhfasktd, tbl_details);
		} );

		tblhfasktd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hfasktd');

			id_hemxxmh_pic_old = hfasktd_data.id_hemxxmh_pic;
			id_hemxxmh_verificator_old = hfasktd_data.id_hemxxmh_verificator;
			id_hfasktd = hfasktd_data.id;
			transaction_state_pica = hfasktd_data.transaction_state;
			
			// atur hak akses
			CekSelectDetailHD( tblhfasktd );
			
			tbl_details = [tblhfasltd];
			CekSelectHeaderHD(tblhfasktd, tbl_details);
			tblhfasltd.ajax.reload(null, false);

			if (transaction_state_pica == 1) {
				tblhfasktd.button( 'btnEdit:name' ).nodes().css( 'display', 'none' );
				tblhfasktd.button( 'btnRemove:name' ).nodes().css( 'display', 'none' );
				
				// tblhfasltd.button( 'btnCreate:name' ).nodes().css( 'display', 'none' );
				// tblhfasltd.button( 'btnNoActionD:name' ).nodes().css( 'display', 'block' );
			} else {
				tblhfasktd.button( 'btnEdit:name' ).nodes().css( 'display', 'block' );
				tblhfasktd.button( 'btnRemove:name' ).nodes().css( 'display', 'block' );

				// tblhfasltd.button( 'btnCreate:name' ).nodes().css( 'display', 'block' );
				// tblhfasltd.button( 'btnNoActionD:name' ).nodes().css( 'display', 'none' );
			}
		} );
		
		tblhfasktd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hfasktd');
			id_hemxxmh_pic_old = 0;
			id_hemxxmh_verificator_old = 0;
			id_hfasktd = 0;
			transaction_state_pica = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhfasktd );
			
			tbl_details = [tblhfasltd];
			CekDeselectHeaderHD(tblhfasktd, tbl_details);
			tblhfasltd.ajax.reload(null, false);
		} );
		// END hfasktd

		// BEGIN hfasltd
		edthfasltd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfaxxth/hfasltd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfasltd = show_deleted_hfasltd;
					d.id_hfaxxth = id_hfaxxth;
					d.id_hfasktd = id_hfasktd;
				}
			},
			table: "#tblhfasltd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hfasltd.start_at",
					name: "hfasltd.start_at",
					type: "hidden"
				},	
				{
					label: "hfasltd.finish_at",
					name: "hfasltd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfasltd",
					type: "hidden"
				},	
				{
					label: "hfasltd.transaction_state",
					name: "hfasltd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hfaxxth",
					name: "hfasltd.id_hfaxxth",
					type: "hidden"
				},	
				{
					label: "id_hfasktd",
					name: "hfasltd.id_hfasktd",
					type: "hidden"
				},	
				{
					label: "Status <sup class='text-danger'>*<sup>",
					name: "hfasltd.status",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "OK", "value": "OK" },
						{ "label": "Not OK", "value": "Not OK" },
					]
				},
				{
					label: getTranslation('notes') + " <sup class='text-danger'>*<sup>",
					name: "hfasltd.keterangan",
					type: "textarea"
				},
			]
		} );
			
		edthfasltd.on( 'preOpen', function( e, mode, action ) {
			edthfasltd.field('hfasltd.id_hfaxxth').val(id_hfaxxth);
			edthfasltd.field('hfasltd.id_hfasktd').val(id_hfasktd);
			console.log(id_hfasktd);
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfasltd.field('hfasltd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhfasltd.rows().deselect();
			}
		});

		edthfasltd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthfasltd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				keterangan = edthfasltd.field('hfasltd.keterangan').val();
				status = edthfasltd.field('hfasltd.status').val();

				validasiRequired(
					edthfasltd,
					'hfasltd',
					{
						'keterangan': keterangan,
						'status': status,
					}
				);
			}
			
			if ( edthfasltd.inError() ) {
				return false;
			}
		});

		edthfasltd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfasltd.field('hfasltd.finish_at').val(finish_at);
		});
			
		edthfasltd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhfaxxth.ajax.reload(null, false);			
			tblhfasktd.ajax.reload(null, false);			
		} );

		edthfasltd.on( 'close', function () {
			edthfasltd.enable();
		} );
		
		tblhfasltd = $('#tblhfasltd').DataTable( {
			ajax: {
				url: "../../models/hfaxxth/hfasltd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfasltd = show_deleted_hfasltd;
					d.id_hfaxxth = id_hfaxxth;
					d.id_hfasktd = id_hfasktd;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hfasltd.id",visible:false },
				{ data: "hfasltd.id_hfaxxth",visible:false },
				{ data: "hfasltd.id_hfasktd",visible:false },
				{ data: "hfasltd.status"},
				{ data: "hfasltd.keterangan"},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfasltd';
					$table       = 'tblhfasltd';
					$edt         = 'edthfasltd';
					$show_status = '_hfasltd';
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

		tblhfasltd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhfasltd, 1 );
			CekDrawDetailHDFinal(tblhfaxxth);
			
			if (transaction_state_pica == 1) {
				tblhfasltd.button( 'btnCreate:name' ).nodes().css( 'display', 'none' );
				tblhfasltd.button( 'btnNoActionD:name' ).nodes().css( 'display', 'block' );
			} else {
				tblhfasltd.button( 'btnCreate:name' ).nodes().css( 'display', 'block' );
				tblhfasltd.button( 'btnNoActionD:name' ).nodes().css( 'display', 'none' );
			}
		} );

		tblhfasltd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hfasltd');
			
			// atur hak akses
			CekSelectDetailHD( tblhfasltd );
			if (transaction_state_pica == 1) {
				tblhfasltd.button( 'btnEdit:name' ).nodes().css( 'display', 'none' );
				tblhfasltd.button( 'btnRemove:name' ).nodes().css( 'display', 'none' );
			} else {
				tblhfasltd.button( 'btnEdit:name' ).nodes().css( 'display', 'block' );
				tblhfasltd.button( 'btnRemove:name' ).nodes().css( 'display', 'block' );
			}
		} );
		
		tblhfasltd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hfasltd');
			
			// atur hak akses
			CekDeselectDetailHD( tblhfasltd );
			if (transaction_state_pica == 1) {
				tblhfasltd.button( 'btnEdit:name' ).nodes().css( 'display', 'none' );
			} else {
				tblhfasltd.button( 'btnEdit:name' ).nodes().css( 'display', 'block' );
			}
		} );
		// END hfasltd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhfaxxth.rows().deselect();
				tblhfaxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhfaxxth').modal('toggle');
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
