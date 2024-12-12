<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'gapxxsh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'gapdusd';
    $nama_tabels_d[1] = 'gaptbtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgapxxsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Type</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabgapdusd"> Users</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabgaptbtd"> Menu</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabgapdusd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgapdusd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_gapxxsh</th>
										<th>User</th>
										<th>Level</th>
										<th>Group</th>
										<th>Nama Group</th>
										<th>Batas Bawah</th>
										<th>Batas Atas (<=)</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabgaptbtd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgaptbtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_gapxxsh</th>
										<th>Nama</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gapxxsh/fn/gapxxsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtgapxxsh, tblgapxxsh, show_deleted_gapxxsh = 0, id_gapxxsh;
	var edtgapdusd, tblgapdusd, show_deleted_gapdusd = 0, id_gapdusd;
	var edtgaptbtd, tblgaptbtd, show_deleted_gaptbtd = 0, id_gaptbtd;
	// ------------- end of default variable

	var id_gtbrlsh = 0, id_gaptpmh_old = 0, jumlah_level_max = 0;
	var id_users_old = 0, tblheader;
	var id_gtbrlsh_old = 0, tbl_group_nama_old = '';

	// get tableRelation
	tableRelation('gapxxsh');

	$(document).ready(function() {
		// BEGIN gapxxsh
		edtgapxxsh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gapxxsh/gapxxsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gapxxsh = show_deleted_gapxxsh;
				}
			},
			table: "#tblgapxxsh",
			fields: [ 
				{
					label: "gapxxsh.start_at",
					name: "gapxxsh.start_at",
					type: "hidden"
				},	
				{
					label: "gapxxsh.finish_at",
					name: "gapxxsh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gapxxsh",
					type: "hidden"
				},	
				{
					label: "gapxxsh.transaction_state",
					name: "gapxxsh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "gapxxsh.nama"
				},
				{
					label: "Type <sup class='text-danger'>*<sup>",
					name: "gapxxsh.id_gaptpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/gaptpmh/gaptpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gaptpmh_old: id_gaptpmh_old,
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
					label: "Jumlah Level",
					name: "gapxxsh.jumlah_level",
				},
				{
					label: "Keterangan",
					name: "gapxxsh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtgapxxsh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgapxxsh.field('gapxxsh.start_at').val(start_at);

			if(action == 'create'){
				tblgapxxsh.rows().deselect();
			}
		});

		edtgapxxsh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtgapxxsh.dependent( 'gapxxsh.id_gaptpmh', function ( val, data, callback ) {
			if(val == 1){
				edtgapxxsh.field('gapxxsh.jumlah_level').show();
			}else if(val == 2){
				edtgapxxsh.field('gapxxsh.jumlah_level').val(null);
				edtgapxxsh.field('gapxxsh.jumlah_level').hide();
			}else{
				edtgapxxsh.field('gapxxsh.jumlah_level').val(null);
				edtgapxxsh.field('gapxxsh.jumlah_level').hide();
			}
			return {}
		}, {event: 'keyup change'});
		
		edtgapxxsh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_gaptpmh = edtgapxxsh.field('gapxxsh.id_gaptpmh').val();
				nama = edtgapxxsh.field('gapxxsh.nama').val();

				validasiRequired(
					edtgapxxsh,
					'gapxxsh',
					{
						'id_gaptpmh': id_gaptpmh,
						'nama': nama
					}
				);
			}
			
			if ( edtgapxxsh.inError() ) {
				return false;
			}
		});

		edtgapxxsh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgapxxsh.field('gapxxsh.finish_at').val(finish_at);
		});
		
		edtgapxxsh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgapxxsh.on( 'close', function () {
			edtgapxxsh.enable();
		} );
		
		tblgapxxsh = $('#tblgapxxsh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/gapxxsh/gapxxsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gapxxsh = show_deleted_gapxxsh;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "gapxxsh.id",visible:false },
				{ data: "gapxxsh.nama" },
				{ data: "gaptpmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gapxxsh';
					$table       = 'tblgapxxsh';
					$edt         = 'edtgapxxsh';
					$show_status = '_gapxxsh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.gapxxsh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.gapxxsh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblgapxxsh.searchPanes.container().appendTo('#spgapxxsh');
		tblgapxxsh.searchBuilder.container().appendTo( '#sbgapxxsh' );
		
		tblgapxxsh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblgapdusd,tblgaptbtd];
			CekInitHeaderHD(tblgapxxsh, tbl_details);
		} );
		
		tblgapxxsh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('gapxxsh');
			id_gaptpmh_old   = gapxxsh_data.id_gaptpmh;
			id_gaptpmh       = gapxxsh_data.id_gaptpmh;
			id_gtbrlsh       = gapxxsh_data.id_gtbrlsh;
			jumlah_level_max = gapxxsh_data.jumlah_level;
			
			// atur hak akses
			tbl_details = [tblgapdusd,tblgaptbtd];
			CekSelectHeaderHD(tblgapxxsh, tbl_details);

		} );
		
		tblgapxxsh.on( 'deselect', function () {
			siVarReset('gapxxsh');
			id_gaptpmh_old = 0, jumlah_level_max = 0;

			// atur hak akses
			tbl_details = [tblgapdusd,tblgaptbtd];
			CekDeselectHeaderHD(tblgapxxsh, tbl_details);
		} );
		
		// END gapxxsh

		// BEGIN gapdusd
		edtgapdusd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gapxxsh/gapdusd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gapdusd = show_deleted_gapdusd;
					d.id_gapxxsh = id_gapxxsh;
				}
			},
			table: "#tblgapdusd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "gapdusd.start_at",
					name: "gapdusd.start_at",
					type: "hidden"
				},	
				{
					label: "gapdusd.finish_at",
					name: "gapdusd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gapdusd",
					type: "hidden"
				},	
				{
					label: "gapdusd.transaction_state",
					name: "gapdusd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_gapxxsh",
					name: "gapdusd.id_gapxxsh",
					type: "hidden"
				},	
				{
					label: "User <sup class='text-danger'>*<sup>", 
					name: "gapdusd.id_users",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/users_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_users_old: id_users_old,
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
					label: "Group",
					name: "gapdusd.tblheader",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false
					},
					options: [
						{ label: "Division", value: "hovxxmh" },
						{ label: "Department", value: "hodxxmh" }
					]
				},
				{
					label: "Group Data",
					name: "gapdusd.tbl_group_nama",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/gapxxsh/gapdusd_fn_opt_tblheader.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									tblheader: tblheader,
									tbl_group_nama_old: tbl_group_nama_old,
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
					label: "Level",
					name: "gapdusd.level_ke"
				},
				{
					label: "Batas Bawah",
					name: "gapdusd.gaptpmh_value_fr"
				},
				{
					label: "Batas Atas",
					name: "gapdusd.gaptpmh_value_to"
				},
				{
					label: "Keterangan",
					name: "gapdusd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtgapdusd.on( 'preOpen', function( e, mode, action ) {
			edtgapdusd.field('gapdusd.id_gapxxsh').val(id_gapxxsh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgapdusd.field('gapdusd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgapdusd.rows().deselect();
			}

			if(id_gaptpmh == 1){
				edtgapdusd.field('gapdusd.level_ke').show();
				edtgapdusd.field('gapdusd.gaptpmh_value_fr').hide();
				edtgapdusd.field('gapdusd.gaptpmh_value_to').hide();
			}else if(id_gaptpmh == 2){
				edtgapdusd.field('gapdusd.level_ke').hide();
				edtgapdusd.field('gapdusd.gaptpmh_value_fr').show();
				edtgapdusd.field('gapdusd.gaptpmh_value_to').show();
			}else{
				edtgapdusd.field('gapdusd.level_ke').hide();
				edtgapdusd.field('gapdusd.gaptpmh_value_fr').hide();
				edtgapdusd.field('gapdusd.gaptpmh_value_to').hide();
			}
		});

		edtgapdusd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtgapdusd.dependent( 'gapdusd.tblheader', function ( val, data, callback ) {
			tblheader = val;
			console.log(tblheader);
			return {}
		}, {event: 'keyup change'});
		
		edtgapdusd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_users = edtgapdusd.field('gapdusd.id_users').val();

				validasiRequired(
					edtgapdusd,
					'gapdusd',
					{
						'id_users': id_users
					}
				);

				if(id_gaptpmh == 1){
					level_ke = edtgapdusd.field('gapdusd.level_ke').val();
					if(level_ke <= 0 ){
						edtgapdusd.field('gapdusd.level_ke').error( 'Inputan harus > 0' );
					}
					if(isNaN(level_ke) ){
						edtgapdusd.field('gapdusd.level_ke').error( 'Inputan harus berupa Angka!' );
					}
					if(level_ke > jumlah_level_max){
						edtgapdusd.field('gapdusd.level_ke').error( 'Level Maksimal ' + jumlah_level_max );
					}
				}else if(id_gaptpmh == 2){
					gaptpmh_value_fr = edtgapdusd.field('gapdusd.gaptpmh_value_fr').val();
					gaptpmh_value_to = edtgapdusd.field('gapdusd.gaptpmh_value_to').val();
					validasiNumber(
						edtgapdusd,
						'gapdusd',
						{
							'gaptpmh_value_fr': gaptpmh_value_fr,
							'gaptpmh_value_to': gaptpmh_value_to
						},
						0,
						'>='
					);
				}else{

				}
				
				

			}
			
			if ( edtgapdusd.inError() ) {
				return false;
			}
		});

		edtgapdusd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgapdusd.field('gapdusd.finish_at').val(finish_at);
		});
			
		edtgapdusd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblgapdusd.rows().deselect();
			tblgapdusd.ajax.reload(null, false);
		} );

		edtgapdusd.on( 'close', function () {
			edtgapdusd.enable();
		} );
		
		tblgapdusd = $('#tblgapdusd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/gapxxsh/gapdusd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gapdusd = show_deleted_gapdusd;
					d.id_gapxxsh = id_gapxxsh;
				}
			},
			order: [[ 3, "asc" ]],
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
				{ data: "gapdusd.id",visible:false },
				{ data: "gapdusd.id_gapxxsh",visible:false },
				{ data: "users.username" },
				{ data: "gapdusd.level_ke" },
				{ data: "gtbrlsh.nama" },
				{ data: "gapdusd.tbl_group_nama" },
				{ 
					data: "gapdusd.gaptpmh_value_fr" ,
					...renderNumber(0)
				},
				{ 
					data: "gapdusd.gaptpmh_value_to" ,
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gapdusd';
					$table       = 'tblgapdusd';
					$edt         = 'edtgapdusd';
					$show_status = '_gapdusd';
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

		tblgapdusd.searchPanes.container().appendTo('#spgapdusd');
		tblgapdusd.searchBuilder.container().appendTo( '#sbgapdusd' );

		tblgapdusd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblgapdusd, 1 );
			CekDrawDetailHDFinal(tblgapxxsh);
		} );

		tblgapdusd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('gapdusd');
			id_users_old        = gapdusd_data.id_users;
			tbl_group_nama_old  = gapdusd_data.tbl_group_nama;
			
			// atur hak akses
			CekSelectDetailHD( tblgapdusd );
		} );

		tblgapdusd.on( 'deselect', function() {
			siVarResetD('apdusd');
			id_users_old = 0, tbl_group_nama_old = '';
			
			// atur hak akses
			CekDeselectDetailHD( tblgapdusd );
		} );

		// END gapdusd

		// BEGIN gaptbtd
		edtgaptbtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gapxxsh/gaptbtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gaptbtd = show_deleted_gaptbtd;
					d.id_gapxxsh = id_gapxxsh;
				}
			},
			table: "#tblgaptbtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "gaptbtd.start_at",
					name: "gaptbtd.start_at",
					type: "hidden"
				},	
				{
					label: "gaptbtd.finish_at",
					name: "gaptbtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gaptbtd",
					type: "hidden"
				},	
				{
					label: "gaptbtd.transaction_state",
					name: "gaptbtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_gapxxsh",
					name: "gaptbtd.id_gapxxsh",
					type: "hidden"
				},	
				{
					label: "Menu",
					name: "gaptbtd.id_gtbrlsh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/gtbrlsh/gtbrlsh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gtbrlsh_old: id_gtbrlsh_old,
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
			]
		} );
			
		edtgaptbtd.on( 'preOpen', function( e, mode, action ) {
			edtgaptbtd.field('gaptbtd.id_gapxxsh').val(id_gapxxsh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgaptbtd.field('gaptbtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgaptbtd.rows().deselect();
			}
		});

		edtgaptbtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtgaptbtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_gtbrlsh = edtgaptbtd.field('gaptbtd.id_gtbrlsh').val();

				validasiRequired(
					edtgaptbtd,
					'gaptbtd',
					{
						'id_gtbrlsh': id_gtbrlsh
					}
				);

				validasiUnique(
					action,
					edtgaptbtd,
					'gaptbtd',
					'id_gtbrlsh',
					'id_gtbrlsh',
					id_gtbrlsh,
					id_gaptbtd
				);

			}
			
			if ( edtgaptbtd.inError() ) {
				return false;
			}
		});

		edtgaptbtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgaptbtd.field('gaptbtd.finish_at').val(finish_at);
		});
			
		edtgaptbtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgaptbtd.on( 'close', function () {
			edtgaptbtd.enable();
		} );
		
		tblgaptbtd = $('#tblgaptbtd').DataTable( {
			ajax: {
				url: "../../models/gapxxsh/gaptbtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gaptbtd = show_deleted_gaptbtd;
					d.id_gapxxsh = id_gapxxsh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "gaptbtd.id",visible:false },
				{ data: "gaptbtd.id_gapxxsh",visible:false },
				{ data: "gtbrlsh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gaptbtd';
					$table       = 'tblgaptbtd';
					$edt         = 'edtgaptbtd';
					$show_status = '_gaptbtd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
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

		tblgaptbtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblgaptbtd, 1 );
			CekDrawDetailHDFinal(tblgapxxsh);
		} );

		tblgaptbtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('gaptbtd');
			id_gtbrlsh_old       = gaptbtd_data.id_gtbrlsh;
			
			// atur hak akses
			CekSelectDetailHD( tblgaptbtd );
		} );

		tblgaptbtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('gaptbtd');
			id_gtbrlsh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblgaptbtd );
		} );
		// END gaptbtd

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
