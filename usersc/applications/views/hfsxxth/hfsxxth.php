<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hfsxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hfskptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhfsxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhfsxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabhfskptd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabhfskptd_2"> Tab 2</a></li> -->
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
				<div role="tabpanel" id="tabhfskptd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhfskptd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hfsxxth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfsxxth/fn/hfsxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthfsxxth, tblhfsxxth, show_deleted_hfsxxth = 0, id_hfsxxth;
	var edthfskptd, tblhfskptd, show_deleted_hfskptd = 0, id_hfskptd;
	// ------------- end of default variable
	var id_hfkxxth_old = 0, id_hfkobtd_old = 0, skor_select = 0;
	var id_hemxxmh_old = 0, id_hfoxxmh_old = 0, id_hfoprmh_old = 0, id_iumxxmh_old = 0, id_hfogrmh_old = 0, id_hfmxxmh_old = 0;

	// get tableRelation
	tableRelation('hfsxxth');

	$(document).ready(function() {
		$('#end_date').datepicker('setDate', today_add_m_dmy);

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hfsxxth
		edthfsxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfsxxth/hfsxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfsxxth = show_deleted_hfsxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhfsxxth",
			fields: [ 
				{
					label: "hfsxxth.start_at",
					name: "hfsxxth.start_at",
					type: "hidden"
				},	
				{
					label: "hfsxxth.finish_at",
					name: "hfsxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfsxxth",
					type: "hidden"
				},	
				{
					label: "hfsxxth.transaction_state",
					name: "hfsxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Periode <sup class='text-danger'>*<sup>",
					name: "hfsxxth.periode",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},{
					label: "KPI <sup class='text-danger'>*<sup>",
					name: "hfsxxth.id_hfkxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfkxxth/hfkxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfkxxth_old: id_hfkxxth_old,
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
					label: "hfkxxth.id_hemxxmh",
					name: "hfsxxth.id_hemxxmh",
					type: "hidden",
				},
			]
		} );
		
		edthfsxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfsxxth.field('hfsxxth.start_at').val(start_at);

			if(action == 'create'){
				tblhfsxxth.rows().deselect();
			}
		});

		edthfsxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edthfsxxth.dependent( 'hfsxxth.id_hfkxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('hfkxxth', val, 'id_hemxxmh');
				id_hemxxmh = autofillData.id_hemxxmh;
				edthfsxxth.field('hfsxxth.id_hemxxmh').val(id_hemxxmh);
			}
			return {}
		}, {event: 'keyup change'});
		
		edthfsxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				periode = edthfsxxth.field('hfsxxth.periode').val();
				id_hfkxxth = edthfsxxth.field('hfsxxth.id_hfkxxth').val();

				autofillField('hfkxxth', id_hfkxxth, 'tanggal_awal, tanggal_akhir');
				tanggal_awal = autofillData.tanggal_awal;
				tanggal_akhir = autofillData.tanggal_akhir;

				let periodeDate = moment(periode).format('YYYY-MM-DD');
				let tanggalAwalDate = moment(tanggal_awal).format('YYYY-MM-DD');
				let tanggalAkhirDate = moment(tanggal_akhir).format('YYYY-MM-DD');

				if (periodeDate < tanggalAwalDate || periodeDate > tanggalAkhirDate) {
					edthfsxxth.field('hfsxxth.periode').error('Periode harus dalam range Tanggal Awal - Tanggal Akhir KPI terpilih!');
				}

				validasiRequired(
					edthfsxxth,
					'hfsxxth',
					{
						'periode': periode,
						'id_hfkxxth': id_hfkxxth,
					}
				);
				
				validasiUnique(
					action,
					edthfsxxth,
					'hfsxxth',
					'periode',
					'periode, id_hfkxxth',
					'"'+periodeDate+'",'+id_hfkxxth,
					id_hfsxxth
				);
			}
			
			if ( edthfsxxth.inError() ) {
				return false;
			}
		});

		edthfsxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfsxxth.field('hfsxxth.finish_at').val(finish_at);
		});
		
		edthfsxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthfsxxth.on( 'close', function () {
			edthfsxxth.enable();
		} );
		
		tblhfsxxth = $('#tblhfsxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hfsxxth/hfsxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfsxxth = show_deleted_hfsxxth;
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
				{ data: "hfsxxth.id",visible:false },
				{ data: "hfsxxth.periode" },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hovxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ 
					data: "hfsxxth.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfsxxth';
					$table       = 'tblhfsxxth';
					$edt         = 'edthfsxxth';
					$show_status = '_hfsxxth';
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
				if ( data.hfsxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfsxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfsxxth.searchPanes.container().appendTo('#sphfsxxth');
		tblhfsxxth.searchBuilder.container().appendTo( '#sbhfsxxth' );
		
		tblhfsxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhfskptd];
			CekInitHeaderHD(tblhfsxxth, tbl_details);
		} );
		
		tblhfsxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfsxxth');

			id_hfkxxth_old = hfsxxth_data.id_hfkxxth;
			// atur hak akses
			tbl_details = [tblhfskptd];
			CekSelectHeaderHD(tblhfsxxth, tbl_details);

		} );
		
		tblhfsxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfsxxth');
			id_hfkxxth_old = 0;
			skor_select = 0;

			// atur hak akses
			tbl_details = [tblhfskptd];
			CekDeselectHeaderHD(tblhfsxxth, tbl_details);
		} );
		// END hfsxxth

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
					focus: 16
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
			edthfskptd.field('hfskptd.id_hfsxxth').val(id_hfsxxth);
			
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
			$(".modal-dialog").addClass("modal-xl");
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

		edthfskptd.dependent( 'hfskptd.realisasi', function ( val, data, callback ) {
			hitungSkor();
			return {}
		}, {event: 'keyup change'});

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
				url: "../../models/hfsxxth/hfskptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfskptd = show_deleted_hfskptd;
					d.id_hfsxxth = id_hfsxxth;
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
					$arr_buttons_action 	= ['edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				// if ( parseFloat(data.hfskptd.realisasi) == parseFloat(data.hfskptd.target_atas) ) {
				// 	$('td:eq(7)', row).addClass('bg-primary');
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
			CekDrawDetailHD( tblhfskptd, 1 );
			CekDrawDetailHDFinal(tblhfsxxth);
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
			
			// atur hak akses
			CekSelectDetailHD( tblhfskptd );
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
			
			// atur hak akses
			CekDeselectDetailHD( tblhfskptd );
		} );
		// END hfskptd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhfsxxth.rows().deselect();
				tblhfsxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhfsxxth').modal('toggle');
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
