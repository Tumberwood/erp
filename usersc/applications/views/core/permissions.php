<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$name_tabel       = 'permissions';
    $name_tabels_d 	= [];
    $name_tabels_d[0] = 'user_permission_matches';
    $name_tabels_d[1] = 'permission_page_matches';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFpermissions" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblpermissions" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabuser_permission_matches_1"> Users</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabuser_permission_matches_2"> Pages</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabuser_permission_matches_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbluser_permission_matches" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>permission_id</th>
										<th>Username</th>
										<th>Email</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabuser_permission_matches_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpermission_page_matches" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>permission_id</th>
										<th>Pages</th>
										<th>Link</th>
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


<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtpermissions, tblpermissions, show_deleted_permissions = 0, permission_id;
	var edtuser_permission_matches, tbluser_permission_matches, show_deleted_user_permission_matches = 0, id_user_permission_matches;
	var edtpermission_page_matches, tblpermission_page_matches, show_deleted_permission_page_matches = 0, id_permission_page_matches;
	// ------------- end of default variable
	var user_id_old = 0;
	var page_id_old = 0;
	var user_permission_matches_id = 0;
	var permission_page_matches_id = 0;
	// get tableRelation
	tableRelation('permissions');

	$(document).ready(function() {

		// BEGIN permissions
		edtpermissions = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/permissions.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_permissions = show_deleted_permissions;
				}
			},
			table: "#tblpermissions",
			fields: [ 
				{
					label: "permissions.start_at",
					name: "permissions.start_at",
					type: "hidden"
				},	
				{
					label: "permissions.finish_at",
					name: "permissions.finish_at",
					type: "hidden"
				},	
				{
					label: "name_tabel",
					name: "name_tabel",
					def: "permissions",
					type: "hidden"
				},
				{
					label: "Name <sup class='text-danger'>*<sup>",
					name: "permissions.name"
				}, 
			]
		} );
		
		edtpermissions.on( 'preOpen', function( e, mode, action ) {

			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpermissions.field('permissions.start_at').val(start_at);
			
			if(action == 'create'){
				tblpermissions.rows().deselect();
			}
		});

		edtpermissions.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtpermissions.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				name = edtpermissions.field('permissions.name').val();

				validasiRequired(
					edtpermissions,
					'permissions',
					{
						'name': name
					}
				);
				
				validasiUnique(
					action,
					edtpermissions,
					'permissions',
					'name',
					'name',
					'"'+name+'"',
					permission_id
				);
			}
			
			if ( edtpermissions.inError() ) {
				return false;
			}
		});

		edtpermissions.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpermissions.field('permissions.finish_at').val(finish_at);
		});
		
		edtpermissions.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtpermissions.on( 'close', function () {
			edtpermissions.enable();
		} );
		
		tblpermissions = $('#tblpermissions').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/core/permissions.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_permissions = show_deleted_permissions;
				}
			},
			order: [[ 1, "desc" ]],
			columns: [
				{ data: "permissions.id",visible:false },
				{ data: "permissions.name" },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'permission_id';
					$table       = 'tblpermissions';
					$edt         = 'edtpermissions';
					$show_status = '_permissions';
					$table_name  = $name_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
				
			}
		} );
		
		tblpermissions.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbluser_permission_matches
			, tblpermission_page_matches
		];
			CekInitHeaderHD(tblpermissions, tbl_details);
		} );
		
		tblpermissions.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			permissions_data    = tblpermissions.row( { selected: true } ).data().permissions;
			permission_id      = permissions_data.id;
			console.log(permission_id);
			
			// atur hak akses
			tbl_details = [tbluser_permission_matches
			, tblpermission_page_matches
		];
			CekSelectHeaderHD(tblpermissions, tbl_details);

		} );
		
		tblpermissions.on( 'deselect', function () {
			// reset variable standar framework
			permission_id = 0;

			// atur hak akses
			tbl_details = [tbluser_permission_matches
			, tblpermission_page_matches
		];
			CekDeselectHeaderHD(tblpermissions, tbl_details);
		} );
		// END permissions

		// BEGIN user_permission_matches
		edtuser_permission_matches = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/user_permission_matches.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_user_permission_matches = show_deleted_user_permission_matches;
					d.permission_id = permission_id;
				}
			},
			table: "#tbluser_permission_matches",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "user_permission_matches.start_at",
					name: "user_permission_matches.start_at",
					type: "hidden"
				},	
				{
					label: "user_permission_matches.finish_at",
					name: "user_permission_matches.finish_at",
					type: "hidden"
				},	
				{
					label: "name_tabel",
					name: "name_tabel",
					def: "user_permission_matches",
					type: "hidden"
				},
				{
					label: "permission_id",
					name: "user_permission_matches.permission_id",
					type: "hidden"
				},	
				{
					label: "Username",
					name: "user_permission_matches.user_id",
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
									id_users_old: user_id_old,
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
			
		edtuser_permission_matches.on( 'preOpen', function( e, mode, action ) {
			edtuser_permission_matches.field('user_permission_matches.permission_id').val(permission_id);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtuser_permission_matches.field('user_permission_matches.start_at').val(start_at);
			
			if(action == 'create'){
				tbluser_permission_matches.rows().deselect();
			}
		});

		edtuser_permission_matches.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtuser_permission_matches.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				user_id = edtuser_permission_matches.field('user_permission_matches.user_id').val();

				validasiRequired(
					edtuser_permission_matches,
					'user_permission_matches',
					{
						'user_id': user_id
					}
				);

				console.log(user_permission_matches_id);
				console.log(permission_id);
				validasiUnique(
					action,
					edtuser_permission_matches,
					'user_permission_matches',
					'user_id',
					'user_id,permission_id',
					user_id+","+permission_id,
					user_permission_matches_id
				);
			}
			
			if ( edtuser_permission_matches.inError() ) {
				return false;
			}
		});

		edtuser_permission_matches.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtuser_permission_matches.field('user_permission_matches.finish_at').val(finish_at);
		});
			
		edtuser_permission_matches.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtuser_permission_matches.on( 'close', function () {
			edtuser_permission_matches.enable();
		} );
		
		tbluser_permission_matches = $('#tbluser_permission_matches').DataTable( {
			ajax: {
				url: "../../models/core/user_permission_matches.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_user_permission_matches = show_deleted_user_permission_matches;
					d.permission_id = permission_id;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "user_permission_matches.id",visible:false },
				{ data: "user_permission_matches.permission_id",visible:false },
				{ data: "users.username" },
				{ data: "users.email" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_user_permission_matches';
					$table       = 'tbluser_permission_matches';
					$edt         = 'edtuser_permission_matches';
					$show_status = '_user_permission_matches';
					$table_name  = $name_tabels_d[0];

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

		tbluser_permission_matches.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbluser_permission_matches, 1 );
			CekDrawDetailHDFinal(tblpermissions);
		} );

		tbluser_permission_matches.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			user_permission_matches_data    = tbluser_permission_matches.row( { selected: true } ).data().user_permission_matches;
			user_permission_matches_id      = user_permission_matches_data.id;
			user_id_old      = user_permission_matches_data.user_id;
			
			// atur hak akses
			CekSelectDetailHD( tbluser_permission_matches );
		} );

		tbluser_permission_matches.on( 'deselect', function() {
			// reset variable standar framework
			user_id_old = 0;
			user_permission_matches_id = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbluser_permission_matches );
		} );
		// END user_permission_matches

		// BEGIN permission_page_matches
		edtpermission_page_matches = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/permission_page_matches.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_permission_page_matches = show_deleted_permission_page_matches;
					d.permission_id = permission_id;
				}
			},
			table: "#tblpermission_page_matches",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "permission_page_matches.start_at",
					name: "permission_page_matches.start_at",
					type: "hidden"
				},	
				{
					label: "permission_page_matches.finish_at",
					name: "permission_page_matches.finish_at",
					type: "hidden"
				},	
				{
					label: "name_tabel",
					name: "name_tabel",
					def: "permission_page_matches",
					type: "hidden"
				},
				{
					label: "permission_id",
					name: "permission_page_matches.permission_id",
					type: "hidden"
				},	
				{
					label: "Page",
					name: "permission_page_matches.page_id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/pages_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_pages_old: page_id_old,
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
			
		edtpermission_page_matches.on( 'preOpen', function( e, mode, action ) {
			edtpermission_page_matches.field('permission_page_matches.permission_id').val(permission_id);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpermission_page_matches.field('permission_page_matches.start_at').val(start_at);
			
			if(action == 'create'){
				tblpermission_page_matches.rows().deselect();
			}
		});

		edtpermission_page_matches.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtpermission_page_matches.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				page_id = edtpermission_page_matches.field('permission_page_matches.page_id').val();

				validasiRequired(
					edtpermission_page_matches,
					'permission_page_matches',
					{
						'page_id': page_id
					}
				);

				console.log(permission_page_matches_id);
				console.log(permission_id);
				validasiUnique(
					action,
					edtpermission_page_matches,
					'permission_page_matches',
					'page_id',
					'page_id,permission_id',
					page_id+","+permission_id,
					permission_page_matches_id
				);
			}
			
			if ( edtpermission_page_matches.inError() ) {
				return false;
			}
		});

		edtpermission_page_matches.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpermission_page_matches.field('permission_page_matches.finish_at').val(finish_at);
		});
			
		edtpermission_page_matches.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtpermission_page_matches.on( 'close', function () {
			edtpermission_page_matches.enable();
		} );
		
		tblpermission_page_matches = $('#tblpermission_page_matches').DataTable( {
			ajax: {
				url: "../../models/core/permission_page_matches.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_permission_page_matches = show_deleted_permission_page_matches;
					d.permission_id = permission_id;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "permission_page_matches.id",visible:false },
				{ data: "permission_page_matches.permission_id",visible:false },
				{ data: "pages.title" },
				{ data: "pages.page" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_permission_page_matches';
					$table       = 'tblpermission_page_matches';
					$edt         = 'edtpermission_page_matches';
					$show_status = '_permission_page_matches';
					$table_name  = $name_tabels_d[0];

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

		tblpermission_page_matches.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblpermission_page_matches, 1 );
			CekDrawDetailHDFinal(tblpermissions);
		} );

		tblpermission_page_matches.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			permission_page_matches_data    = tblpermission_page_matches.row( { selected: true } ).data().permission_page_matches;
			permission_page_matches_id      = permission_page_matches_data.id;
			user_id_old      = permission_page_matches_data.user_id;
			
			// atur hak akses
			CekSelectDetailHD( tblpermission_page_matches );
		} );

		tblpermission_page_matches.on( 'deselect', function() {
			// reset variable standar framework
			user_id_old = 0;
			permission_page_matches_id = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblpermission_page_matches );
		} );
		// END permission_page_matches


		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblpermissions.rows().deselect();
				tblpermissions.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFpermissions').modal('toggle');
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
