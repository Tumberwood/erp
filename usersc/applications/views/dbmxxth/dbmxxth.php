<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'dbmxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'dbmittd';
    $nama_tabels_d[1] = 'dbmwptd';
    
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbldbmxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="revNo"></th>
                                <th data-i18n="itemCode"></th>
								<th data-i18n="itemName"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabdbmittd"> Items</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabdbmwptd"> Work Process</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabdbmittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbldbmittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_dbmxxth</th>
										<th data-i18n="itemCode"></th>
										<th data-i18n="itemName"></th>
										<th data-i18n="uom"></th>
										<th data-i18n="quantity"></th>
									</tr>
								</thead>
							</table>
						</div>

					</div>
				</div>
				<div role="tabpanel" id="tabdbmwptd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbldbmwptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_dbmxxth</th>
										<th data-i18n="workProcessCode"></th>
										<th data-i18n="workProcessName"></th>
										<th data-i18n="cycleTime" data-toggle="tooltip" data-placement="top" title="In Seconds"></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/dbmxxth/fn/dbmxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtdbmxxth, tbldbmxxth, show_deleted_dbmxxth = 0, id_dbmxxth;
	var edtdbmittd, tbldbmittd, show_deleted_dbmittd = 0, id_dbmittd;
	var edtdbmwptd, tbldbmwptd, show_deleted_dbmwptd = 0, id_dbmwptd;
	// ------------- end of default variable

	id_iimxxmh_old = 0, revisi_ke = 0;
	id_iimxxmh_rm = 0, id_iimxxmh_rm_old = 0, id_iumxxmh_unit_old = 0;
	id_rwpxxmh_old = 0;

	// get tableRelation
	tableRelation('dbmxxth');

	$(document).ready(function() {
		// BEGIN dbmxxth

		edtdbmxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/dbmxxth/dbmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dbmxxth = show_deleted_dbmxxth;
				}
			},
			table: "#tbldbmxxth",
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
					label: "dbmxxth.start_at",
					name: "dbmxxth.start_at",
					type: "hidden"
				},	
				{
					label: "dbmxxth.finish_at",
					name: "dbmxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "dbmxxth",
					type: "hidden"
				},	
				{
					label: "dbmxxth.transaction_state",
					name: "dbmxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "is_revisi",
					name: "is_revisi",
					type: "hidden",
				},
				{
					label: getTranslation('revisionNumber'),
					name: "dbmxxth.revisi_ke",
					type: "readonly",
				},
				{
					label: getTranslation('originalBom'),
					name: "dbmxxth.id_dbmxxth_asal",
					type: "hidden",
				},
				{
					label: getTranslation('item') + "<sup class='text-danger'>*<sup>",
					name: "dbmxxth.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iicxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									search: params.term || '',
									id_iimxxmh_old: id_iimxxmh_old,
									ids_iccttmh: 3,
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
					label: getTranslation('notes'),
					name: "dbmxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtdbmxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdbmxxth.field('dbmxxth.start_at').val(start_at);

			if(action == 'create'){
				tbldbmxxth.rows().deselect();

				edtdbmxxth.field('kategori_dokumen').val('');
				edtdbmxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtdbmxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtdbmxxth.dependent( 'dbmxxth.id_iimxxmh', function ( val, data, callback ) {
			if (val > 0) {
				revisionNumber(val);
			} else {
				edtdbmxxth.field('dbmxxth.revisi_ke').val('');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtdbmxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_iimxxmh = edtdbmxxth.field('dbmxxth.id_iimxxmh').val();
				
				validasiRequired(
					edtdbmxxth,
					'dbmxxth',
					{
						'id_iimxxmh': id_iimxxmh
					}
				);
				
				
			}
			
			if ( edtdbmxxth.inError() ) {
				return false;
			}
		});

		edtdbmxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdbmxxth.field('dbmxxth.finish_at').val(finish_at);
		});
		
		edtdbmxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbldbmxxth.ajax.reload(null, false);
		} );

		edtdbmxxth.on( 'close', function () {
			edtdbmxxth.enable();
		} );
		
		tbldbmxxth = $('#tbldbmxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/dbmxxth/dbmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dbmxxth = show_deleted_dbmxxth;
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
				{ data: "dbmxxth.id",visible:false },
				{ data: "dbmxxth.kode" },
				{ data: "dbmxxth.revisi_ke" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "dbmxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_dbmxxth';
					$table       = 'tbldbmxxth';
					$edt         = 'edtdbmxxth';
					$show_status = '_dbmxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{ 
					extend: 'selected',
					name: 'btnCreateRevision', 
					text: 'R', 
					className: 'btn btn-outline', 
					titleAttr: 'Create Revision',
					action: function (e, dt, node, config) {
						var revisi_ke_new = parseInt(revisi_ke) + 1;
                        // Start in edit mode, and then change to create
                        edtdbmxxth
                            .edit(tbldbmxxth.rows({ selected: true }).indexes(), {
                                title: 'Create Revision',
                                buttons: 'Create Revision'
                            })
							.disable('dbmxxth.revisi_ke')
							.set( 'dbmxxth.id_dbmxxth_asal', id_dbmxxth )
							.set( 'is_revisi', 1 )
							.set( 'dbmxxth.revisi_ke', revisi_ke_new )
                            .mode('create');
                    }
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.dbmxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.dbmxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbldbmxxth.searchPanes.container().appendTo('#spdbmxxth');
		tbldbmxxth.searchBuilder.container().appendTo( '#sbdbmxxth' );
		
		tbldbmxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbldbmittd, tbldbmwptd];
			CekInitHeaderHD(tbldbmxxth, tbl_details);
		} );
		
		tbldbmxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('dbmxxth');
			id_iimxxmh_old    = dbmxxth_data.id_iimxxmh;
			revisi_ke    = dbmxxth_data.revisi_ke;
			// atur hak akses
			tbl_details = [tbldbmittd, tbldbmwptd];
			CekSelectHeaderHD(tbldbmxxth, tbl_details);

		} );
		
		tbldbmxxth.on( 'deselect', function () {
			siVarReset('dbmxxth');
			id_iimxxmh_old = 0;
			// atur hak akses
			tbl_details = [tbldbmittd, tbldbmwptd];
			CekDeselectHeaderHD(tbldbmxxth, tbl_details);
		} );
		
		// END dbmxxth


		// BEGIN dbmittd

		edtdbmittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/dbmxxth/dbmittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dbmittd = show_deleted_dbmittd;
					d.id_dbmxxth = id_dbmxxth;
				}
			},
			table: "#tbldbmittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "dbmittd.start_at",
					name: "dbmittd.start_at",
					type: "hidden"
				},	
				{
					label: "dbmittd.finish_at",
					name: "dbmittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "dbmittd",
					type: "hidden"
				},	
				{
					label: "dbmittd.transaction_state",
					name: "dbmittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_dbmxxth",
					name: "dbmittd.id_dbmxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('rawMaterial') + "<sup class='text-danger'>*<sup>",
					name: "dbmittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iicxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_rm_old,
									ids_iicxxmh: 1,
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
					label: getTranslation('quantity') + "<sup class='text-danger'>*<sup>",
					name: "dbmittd.jumlah_unit",
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "dbmittd.id_iumxxmh_unit",
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
									id_iimxxmh: id_iimxxmh_rm,
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
					label: "Keterangan",
					name: "dbmittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtdbmittd.on( 'preOpen', function( e, mode, action ) {
			edtdbmittd.field('dbmittd.id_dbmxxth').val(id_dbmxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdbmittd.field('dbmittd.start_at').val(start_at);
			
			if(action == 'create'){
				tbldbmittd.rows().deselect();
			}
		});

		edtdbmittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtdbmittd.dependent( 'dbmittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh_rm = edtdbmittd.field('dbmittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});
		
		edtdbmittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_iimxxmh_rm = edtdbmittd.field('dbmittd.id_iimxxmh').val();
				jumlah_unit = edtdbmittd.field('dbmittd.jumlah_unit').val();
				validasiRequired(
					edtdbmittd,
					'dbmittd',
					{
						'id_iimxxmh': id_iimxxmh_rm,
						'jumlah_unit': jumlah_unit
					}
				);

				validasiNumber(
					edtdbmittd,
					'dbmittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);
			}
			
			if ( edtdbmittd.inError() ) {
				return false;
			}
		});

		edtdbmittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdbmittd.field('dbmittd.finish_at').val(finish_at);
		});
			
		edtdbmittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_last_insert = json.data[0].dbmittd.id;
				konversiUom('dbmittd', id_last_insert);
				tbldbmittd.rows().deselect();
			}
		} );

		edtdbmittd.on( 'close', function () {
			edtdbmittd.enable();
		} );

		tbldbmittd = $('#tbldbmittd').DataTable( {
			ajax: {
				url: "../../models/dbmxxth/dbmittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dbmittd = show_deleted_dbmittd;
					d.id_dbmxxth = id_dbmxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "dbmittd.id",visible:false },
				{ data: "dbmittd.id_dbmxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "dbmittd.jumlah_unit" ,
					...renderNumber(2)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_dbmittd';
					$table       = 'tbldbmittd';
					$edt         = 'edtdbmittd';
					$show_status = '_dbmittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];					
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tbldbmittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tbldbmittd,1 );
			CekDrawDetailHDFinal(tbldbmxxth);
		} );

		tbldbmittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('dbmittd');
			id_iimxxmh_rm_old   = dbmittd_data.id_iimxxmh;
			id_iumxxmh_unit_old   = dbmittd_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD(tbldbmittd );
		} );

		tbldbmittd.on( 'deselect', function() {
			siVarResetD('dbmittd');
			id_iimxxmh_rm_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tbldbmittd );
		} );

		

		// END dbmittd


		// BEGIN dbmwptd

		edtdbmwptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/dbmxxth/dbmwptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dbmwptd = show_deleted_dbmwptd;
					d.id_dbmxxth = id_dbmxxth;
				}
			},
			table: "#tbldbmwptd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "dbmwptd.start_at",
					name: "dbmwptd.start_at",
					type: "hidden"
				},	
				{
					label: "dbmwptd.finish_at",
					name: "dbmwptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "dbmwptd",
					type: "hidden"
				},	
				{
					label: "dbmwptd.transaction_state",
					name: "dbmwptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_dbmxxth",
					name: "dbmwptd.id_dbmxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('workProcess') + "<sup class='text-danger'>*<sup>",
					name: "dbmwptd.id_rwpxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/rwpxxmh/rwpxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_rwpxxmh_old: id_rwpxxmh_old,
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
					label: getTranslation('cycleTime'),
					name: "dbmwptd.cycletime"
				},
				{
					label: getTranslation('notes'),
					name: "dbmwptd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtdbmwptd.on( 'preOpen', function( e, mode, action ) {
			edtdbmwptd.field('dbmwptd.id_dbmxxth').val(id_dbmxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdbmwptd.field('dbmwptd.start_at').val(start_at);
			
			if(action == 'create'){
				tbldbmwptd.rows().deselect();
			}
		});

		edtdbmwptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtdbmwptd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_rwpxxmh = edtdbmwptd.field('dbmwptd.id_rwpxxmh').val();
				validasiRequired(
					edtdbmwptd,
					'dbmwptd',
					{
						'id_rwpxxmh': id_rwpxxmh
					}
				);

				cycletime = edtdbmwptd.field('dbmwptd.cycletime').val();
				validasiNumber(
					edtdbmwptd,
					'dbmwptd',
					{
						'cycletime': cycletime,
					},
					0,
					'>'
				);
			}
			
			if ( edtdbmwptd.inError() ) {
				return false;
			}
		});

		edtdbmwptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdbmwptd.field('dbmwptd.finish_at').val(finish_at);
		});
			
		edtdbmwptd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// nothing to do
		} );

		edtdbmwptd.on( 'close', function () {
			edtdbmwptd.enable();
		} );

		tbldbmwptd = $('#tbldbmwptd').DataTable( {
			ajax: {
				url: "../../models/dbmxxth/dbmwptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dbmwptd = show_deleted_dbmwptd;
					d.id_dbmxxth = id_dbmxxth;
				}
			},
			order: [[ 0, "asc" ]],
			columns: [
				{ data: "dbmwptd.id",visible:false },
				{ data: "dbmwptd.id_dbmxxth",visible:false },
				{ data: "rwpxxmh.kode" },
				{ data: "rwpxxmh.nama" },
				{ 
					data: "dbmwptd.cycletime",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_dbmwptd';
					$table       = 'tbldbmwptd';
					$edt         = 'edtdbmwptd';
					$show_status = '_dbmwptd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tbldbmwptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbldbmwptd, 1 );
			CekDrawDetailHDFinal(tbldbmxxth);
		} );

		tbldbmwptd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('dbmwptd');
			id_rwpxxmh_old   = dbmwptd_data.id_rwpxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tbldbmwptd );
		} );

		tbldbmwptd.on( 'deselect', function() {
			siVarResetD('dbmwptd');
			id_rwpxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbldbmwptd );
		} );

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
