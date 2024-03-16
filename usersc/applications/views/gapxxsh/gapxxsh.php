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
                                <th>Kode</th>
                                <th>Type</th>
                                <th>Keterangan</th>
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
										<th>Batas Bawah</th>
										<th>Batas Atas</th>
										<th>Keterangan</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gapxxsh/fn/gapxxsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtgapxxsh, tblgapxxsh, show_deleted_gapxxsh = 0, id_gapxxsh;
	var edtgapdusd, tblgapdusd, show_deleted_gapdusd = 0, id_gapdusd;
	// ------------- end of default variable

	var id_gtbrlsh_old = 0, id_gaptpmh_old = 0;
	var id_users_old = 0;

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
					label: "Nama",
					name: "gapxxsh.id_gtbrlsh",
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
					label: "Keterangan",
					name: "gapxxsh.keterangan",
					type: "textarea"
				},
				{
					label: "Jumlah Level",
					name: "gapxxsh.jumlah_level",
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
		});
		
		edtgapxxsh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_gtbrlsh = edtgapxxsh.field('gapxxsh.id_gtbrlsh').val();
				id_gaptpmh = edtgapxxsh.field('gapxxsh.id_gaptpmh').val();

				validasiRequired(
					edtgapxxsh,
					'gapxxsh',
					{
						'id_gtbrlsh': id_gtbrlsh,
						'id_gaptpmh': id_gaptpmh
					}
				);

				validasiUnique(
					action,
					edtgapxxsh,
					'gapxxsh',
					'id_gtbrlsh',
					'id_gtbrlsh',
					id_gtbrlsh,
					id_gapxxsh
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
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "gapxxsh.id",visible:false },
				{ data: "gtbrlsh.nama" },
				{ data: "gtbrlsh.tblheader" },
				{ data: "gaptpmh.nama" },
				{ data: "gapxxsh.keterangan" }
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
			tbl_details = [tblgapdusd];
			CekInitHeaderHD(tblgapxxsh, tbl_details);
		} );
		
		tblgapxxsh.on( 'select', function( e, dt, type, indexes ) {
			gapxxsh_data      = tblgapxxsh.row( { selected: true } ).data().gapxxsh;
			id_gapxxsh        = gapxxsh_data.id;
			id_transaksi_h    = id_gapxxsh;	// dipakai untuk general
			id_transaksi_log  = id_gapxxsh;	// dipakai untuk general
			transaction_state = gapxxsh_data.transaction_state;
			approval_state    = gapxxsh_data.approval_state;
			is_nextprocess    = gapxxsh_data.is_nextprocess;

			id_gaptpmh_old = gapxxsh_data.id_gaptpmh;
			id_gaptpmh     = gapxxsh_data.id_gaptpmh;
			jumlah_level   = gapxxsh_data.jumlah_level;
			
			// atur hak akses
			tbl_details = [tblgapdusd];
			CekSelectHeaderHD(tblgapxxsh, tbl_details);

		} );
		
		tblgapxxsh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_gapxxsh = 0;
			id_gaptpmh_old = 0;

			// atur hak akses
			tbl_details = [tblgapdusd];
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
					label: "User",
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
		});

		edtgapdusd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtgapdusd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
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
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
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
					targets: [0,4,5,6]
				}
			],
			columns: [
				{ data: "gapdusd.id",visible:false },
				{ data: "gapdusd.id_gapxxsh",visible:false },
				{ data: "users.username" },
				{ data: "gapdusd.level_ke" },
				{ 
					data: "gapdusd.gaptpmh_value_fr" ,
					...renderNumber(0)
				},
				{ 
					data: "gapdusd.gaptpmh_value_to" ,
					...renderNumber(0)
				},
				{ data: "gapdusd.keterangan" }
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
			cek_c_detail= 1;
			CekDrawDetailHD(tblgapxxsh, tblgapdusd, 'gapdusd' );
			CekDrawDetailHDFinal(tblgapxxsh);
		} );

		tblgapdusd.on( 'select', function( e, dt, type, indexes ) {
			data_gapdusd 		= tblgapdusd.row( { selected: true } ).data().gapdusd;
			id_gapdusd   		= data_gapdusd.id;
			id_transaksi_d 		= id_gapdusd; // dipakai untuk general
			id_transaksi_log 	= id_gapdusd; // dipakai untuk log

			transaction_state_d   = data_gapdusd.transaction_state;
			id_users_old   = data_gapdusd.id_users;
			
			// atur hak akses
			CekSelectDetailHD(tblgapxxsh, tblgapdusd );
		} );

		tblgapdusd.on( 'deselect', function() {
			id_gapdusd = 0;
			id_users_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblgapxxsh, tblgapdusd );
		} );

		// END gapdusd

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
