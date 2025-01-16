<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hfkxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hfkobtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhfkxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhfkxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhfkobtd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhfkobtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhfkobtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hfkxxth</th>
										<th>Objective</th>
										<th>Periode</th>
										<th>Polarisasi</th>
										<th>Target Atas</th>
										<th>Target Bawah</th>
										<th>UoM</th>
										<th>Bobot (%)</th>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script> -->

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfkxxth/fn/hfkxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthfkxxth, tblhfkxxth, show_deleted_hfkxxth = 0, id_hfkxxth;
	var edthfkobtd, tblhfkobtd, show_deleted_hfkobtd = 0, id_hfkobtd;
	// ------------- end of default variable
	var id_hemxxmh_old = 0, id_hfoxxmh_old = 0, id_hfoprmh_old = 0, id_iumxxmh_old = 0;

	// get tableRelation
	tableRelation('hfkxxth');

	$(document).ready(function() {
		$('#end_date').datepicker('setDate', today_add_m_dmy);

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hfkxxth
		edthfkxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfkxxth/hfkxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfkxxth = show_deleted_hfkxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhfkxxth",
			fields: [ 
				{
					label: "hfkxxth.start_at",
					name: "hfkxxth.start_at",
					type: "hidden"
				},	
				{
					label: "hfkxxth.finish_at",
					name: "hfkxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfkxxth",
					type: "hidden"
				},	
				{
					label: "hfkxxth.transaction_state",
					name: "hfkxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('employeeName') + "<sup class='text-danger'>*<sup>",
					name: "hfkxxth.id_hemxxmh",
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
					label: getTranslation('startDate') + "<sup class='text-danger'>*<sup>",
					name: "hfkxxth.tanggal_awal",
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
					label: getTranslation('endDate') + "<sup class='text-danger'>*<sup>",
					name: "hfkxxth.tanggal_akhir",
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
					label: getTranslation('notes'),
					name: "hfkxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthfkxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfkxxth.field('hfkxxth.start_at').val(start_at);

			if(action == 'create'){
				tblhfkxxth.rows().deselect();
			}
		});

		edthfkxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthfkxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_awal = edthfkxxth.field('hfkxxth.tanggal_awal').val();
				tanggal_akhir = edthfkxxth.field('hfkxxth.tanggal_akhir').val();
				id_hemxxmh = edthfkxxth.field('hfkxxth.id_hemxxmh').val();

				validasiRequired(
					edthfkxxth,
					'hfkxxth',
					{
						'tanggal_awal': tanggal_awal,
						'tanggal_akhir': tanggal_akhir,
						'id_hemxxmh': id_hemxxmh,
					}
				);
			}
			
			if ( edthfkxxth.inError() ) {
				return false;
			}
		});

		edthfkxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfkxxth.field('hfkxxth.finish_at').val(finish_at);
		});
		
		edthfkxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthfkxxth.on( 'close', function () {
			edthfkxxth.enable();
		} );
		
		tblhfkxxth = $('#tblhfkxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hfkxxth/hfkxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfkxxth = show_deleted_hfkxxth;
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
				{ data: "hfkxxth.id",visible:false },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hovxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ 
					data: "hfkxxth.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfkxxth';
					$table       = 'tblhfkxxth';
					$edt         = 'edthfkxxth';
					$show_status = '_hfkxxth';
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
				if ( data.hfkxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfkxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfkxxth.searchPanes.container().appendTo('#sphfkxxth');
		tblhfkxxth.searchBuilder.container().appendTo( '#sbhfkxxth' );
		
		tblhfkxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhfkobtd];
			CekInitHeaderHD(tblhfkxxth, tbl_details);
		} );
		
		tblhfkxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfkxxth');

			id_hemxxmh_old = hfkxxth_data.id_hemxxmh;
			
			// atur hak akses
			tbl_details = [tblhfkobtd];
			CekSelectHeaderHD(tblhfkxxth, tbl_details);

		} );
		
		tblhfkxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfkxxth');
			id_hemxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblhfkobtd];
			CekDeselectHeaderHD(tblhfkxxth, tbl_details);
		} );
		// END hfkxxth

		// BEGIN hfkobtd
		edthfkobtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfkxxth/hfkobtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfkobtd = show_deleted_hfkobtd;
					d.id_hfkxxth = id_hfkxxth;
				}
			},
			table: "#tblhfkobtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hfkobtd.start_at",
					name: "hfkobtd.start_at",
					type: "hidden"
				},	
				{
					label: "hfkobtd.finish_at",
					name: "hfkobtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfkobtd",
					type: "hidden"
				},	
				{
					label: "hfkobtd.transaction_state",
					name: "hfkobtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hfkxxth",
					name: "hfkobtd.id_hfkxxth",
					type: "hidden"
				},	
				{
					label: "Objective <sup class='text-danger'>*<sup>",  
					name: "hfkobtd.id_hfoxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
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
					label: "Periode <sup class='text-danger'>*<sup>",  
					name: "hfkobtd.id_hfoprmh",
					type: "select2",
					opts: {
						placeholder : "Select",
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
					label: "Polarisasi <sup class='text-danger'>*<sup>", 
					name: "hfkobtd.polarisasi",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Min", "value": "Min" },
						{ "label": "Max", "value": "Max" }
					]
				},
				{
					label: "Target Atas <sup class='text-danger'>*<sup>", 
					name: "hfkobtd.target_atas",
				},
				{
					label: "Target Bawah <sup class='text-danger'>*<sup>", 
					name: "hfkobtd.target_bawah",
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",  
					name: "hfkobtd.id_iumxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
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
					label: "Bobot (%) <sup class='text-danger'>*<sup>", 
					name: "hfkobtd.bobot_persen",
				},
				{
					label: "Cara Hitung <sup class='text-danger'>*<sup>", 
					name: "hfkobtd.cara_hitung",
					type: "quill"
				},
			]
		} );

		//masking
		unmaskedData = maskingNumber(
			edthfkobtd, 
			"hfkobtd", 
			[
				"target_atas", 
				"target_bawah", 
			],
			2,
		);

		edthfkobtd.on( 'preOpen', function( e, mode, action ) {
			edthfkobtd.field('hfkobtd.id_hfkxxth').val(id_hfkxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfkobtd.field('hfkobtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhfkobtd.rows().deselect();
			}
		});

		edthfkobtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthfkobtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hfoxxmh = edthfkobtd.field('hfkobtd.id_hfoxxmh').val();
				id_hfoprmh = edthfkobtd.field('hfkobtd.id_hfoprmh').val();
				id_hfoxxmh = edthfkobtd.field('hfkobtd.id_hfoxxmh').val();
				id_iumxxmh = edthfkobtd.field('hfkobtd.id_iumxxmh').val();
				polarisasi = edthfkobtd.field('hfkobtd.polarisasi').val();
				bobot_persen = edthfkobtd.field('hfkobtd.bobot_persen').val();
				cara_hitung = edthfkobtd.field('hfkobtd.cara_hitung').val();

				target_atas = unmaskedData.target_atas;
				target_bawah = unmaskedData.target_bawah;
				
				validasiRequired(
					edthfkobtd,
					'hfkobtd',
					{
						'id_hfoxxmh': id_hfoxxmh,
						'id_hfoprmh': id_hfoprmh,
						'id_hfoxxmh': id_hfoxxmh,
						'id_iumxxmh': id_iumxxmh,
						'polarisasi': polarisasi,
						'target_atas': target_atas,
						'target_bawah': target_bawah,
						'bobot_persen': bobot_persen,
						'cara_hitung': cara_hitung,
					}
				);
				
				validasiNumber(
					edthfkobtd,
					'hfkobtd',
					{
						'target_atas': target_atas,
						'target_bawah': target_bawah,
					},
					0,
					'>='
				);
				
				validasiNumber(
					edthfkobtd,
					'hfkobtd',
					{
						'bobot_persen': bobot_persen,
					},
					0,
					'>'
				);

				target_atas = Number(target_atas);
				target_bawah = Number(target_bawah);
				
				if (polarisasi == 'Max') {
					if (target_atas >= target_bawah) {
					} else {
						edthfkobtd.field('hfkobtd.target_atas').error( 'Target Atas harus >= Target Bawah!' );
					}
				} else {
					if (target_atas < target_bawah) {
					} else {
						edthfkobtd.field('hfkobtd.target_atas').error( 'Target Atas harus < Target Bawah!' );
					}
				}

				validasiUnique(
					action,
					edthfkobtd,
					'hfkobtd',
					'id_hfoxxmh',
					'id_hfoxxmh, id_hfkxxth',
					''+id_hfoxxmh+','+id_hfkxxth,
					id_hfkobtd
				);
			}
			
			if ( edthfkobtd.inError() ) {
				return false;
			}
		});

		edthfkobtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfkobtd.field('hfkobtd.finish_at').val(finish_at);
		});
			
		edthfkobtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhfkxxth.ajax.reload(null, false);			
		} );

		edthfkobtd.on( 'close', function () {
			edthfkobtd.enable();
		} );
		
		tblhfkobtd = $('#tblhfkobtd').DataTable( {
			ajax: {
				url: "../../models/hfkxxth/hfkobtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfkobtd = show_deleted_hfkobtd;
					d.id_hfkxxth = id_hfkxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hfkobtd.id",visible:false },
				{ data: "hfkobtd.id_hfkxxth",visible:false },
				{ data: "hfoxxmh.nama" },
				{ data: "hfoprmh.nama" },
				{ data: "hfkobtd.polarisasi" },
				{ data: "hfkobtd.target_atas", ...renderNumber(2) },
				{ data: "hfkobtd.target_bawah", ...renderNumber(2) },
				{ data: "iumxxmh.kode" },
				{ data: "hfkobtd.bobot_persen", ...renderNumber(2) },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfkobtd';
					$table       = 'tblhfkobtd';
					$edt         = 'edthfkobtd';
					$show_status = '_hfkobtd';
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

		tblhfkobtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhfkobtd, 1 );
			CekDrawDetailHDFinal(tblhfkxxth);
		} );

		tblhfkobtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hfkobtd');

			id_hfoxxmh_old = hfkobtd_data.id_hfoxxmh;
			id_hfoprmh_old = hfkobtd_data.id_hfoprmh;
			id_iumxxmh_old = hfkobtd_data.id_iumxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhfkobtd );
		} );
		
		tblhfkobtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hfkobtd');
			id_hfoxxmh_old = 0;
			id_hfoprmh_old = 0;
			id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhfkobtd );
		} );
		// END hfkobtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhfkxxth.rows().deselect();
				tblhfkxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhfkxxth').modal('toggle');
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
