<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'udpxxsh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ucudasd';
	$nama_tabels_d[1] = 'udpbrsd';
	$nama_tabels_d[2] = 'udpodsd';
	$nama_tabels_d[3] = 'udpwhsd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
			<div id="custom_users">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="users.username"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="users.email"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="users.fname"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="users.lname"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="users.password"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="confirm_password"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="udpxxsh.data_permission"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="udpxxsh.is_setting"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="permissions[].id"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="udpxxsh.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tbludpxxsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Akses Data</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabucudasd"> CRUD</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabudpbrsd">Cabang</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabudpodsd">Department</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabudpwhsd">Warehouse</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabucudasd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblucudasd" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_udpxxsh</th>
										<th>Pages</th>
										<th data-toggle="tooltip" data-placement="top" title="" data-original-title="Hak Akses Create dan Confirm">C</th>
										<th data-toggle="tooltip" data-placement="top" title="" data-original-title="Hak Akses Edit / Update">U</th>
										<th data-toggle="tooltip" data-placement="top" title="" data-original-title="Hak Akses Delete">D</th>
										<th data-toggle="tooltip" data-placement="top" title="" data-original-title="Hak Akses Approve, Cancel Approve dan Void">A</th>
										<th data-toggle="tooltip" data-placement="top" title="" data-original-title="Hak Akses Export dan Copy Data">E</th>
										<th data-toggle="tooltip" data-placement="top" title="" data-original-title="Hak Akses Print">P</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

				<div role="tabpanel" id="tabudpbrsd" class="tab-pane">
					<div class="panel-body">
						<table id="tbludpbrsd" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_udpxxsh</th>
									<th>Cabang</th>
									<th>Keterangan</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

				<div role="tabpanel" id="tabudpodsd" class="tab-pane">
					<div class="panel-body">
						<table id="tbludpodsd" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_udpxxsh</th>
									<th>Department</th>
									<th>Keterangan</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

				<div role="tabpanel" id="tabudpwhsd" class="tab-pane">
					<div class="panel-body">
						<table id="tbludpwhsd" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_udpxxsh</th>
									<th>Warehouse</th>
									<th>Keterangan</th>
								</tr>
							</thead>
						</table>
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

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtudpxxsh, tbludpxxsh, show_deleted_udpxxsh = 0, id_udpxxsh;
	var edtucudasd, tblucudasd, show_deleted_ucudasd = 0, id_ucudasd;
	var edtudpbrsd, tbludpbrsd, show_deleted_udpbrsd = 0, id_udpbrsd;
	var edtudpodsd, tbludpodsd, show_deleted_udpodsd = 0, id_udpodsd;
	var edtudpwhsd, tbludpwhsd, show_deleted_udpwhsd = 0, id_udpwhsd;
	// ------------- end of default variable

	var id_users = 0, id_users_old  = 0;
	var id_gbrxxmh_old = 0;
	var id_hodxxmh_old = 0;
	var id_iwhxxmh_old = 0;

	// get tableRelation
	tableRelation('udpxxsh');

	$(document).ready(function() {
		
		// BEGIN udpxxsh
		edtudpxxsh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/users.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpxxsh = show_deleted_udpxxsh;
				}
			},
			template: "#custom_users",
			table: "#tbludpxxsh",
			fields: [ 
				{
					label: "users.start_at",
					name: "users.start_at",
					type: "hidden"
				},	
				{
					label: "users.finish_at",
					name: "users.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "udpxxsh",
					type: "hidden"
				},	
				{
					label: "udpxxsh.transaction_state",
					name: "udpxxsh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Username <sup class='text-danger'>*<sup>",  
					name: "users.username"
				},  
				{
					label: "Email <sup class='text-danger'>*<sup>",
					name: "users.email"
				},  
				{
					label: "Password <sup class='text-danger'>*<sup>",
					name: "users.password"
				},  
				{
					label: "Confirm Password <sup class='text-danger'>*<sup>",
					name: "confirm_password"
				},  
				{
					label: "First Name <sup class='text-danger'>*<sup>",
					name: "users.fname"
				},  
				{
					label: "Last Name <sup class='text-danger'>*<sup>",
					name: "users.lname"
				},  
				{
					label: "Permissions <sup class='text-danger'>*<sup>",
					name: "permissions[].id",
					type: "select2",
					opts: {
						"multiple": true
					}
				},	
				{
					label: "Akses Data",
					name: "udpxxsh.data_permission",
					type: "select",
					def: 1,
					options: [
						{ "label": "Self", "value": 1 },
						{ "label": "All", "value": 0 }
					]
				},  
				{
					label: "Boleh Setting",
					name: "udpxxsh.is_setting",
					type: "select",
					def: 0,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				}, 	
				{
					label: "Keterangan",
					name: "udpxxsh.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edtudpxxsh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpxxsh.field('users.start_at').val(start_at);
			
			if (action == 'create'){
				tbludpxxsh.rows().deselect();
				edtudpxxsh.field('users.password').show();
				edtudpxxsh.field('confirm_password').show();
			} else {
				edtudpxxsh.field('users.username').disable();
				edtudpxxsh.field('users.email').disable();
				edtudpxxsh.field('users.password').hide();
				edtudpxxsh.field('confirm_password').hide();
			}
		});

		edtudpxxsh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});
		
		edtudpxxsh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				permissions_id = edtudpxxsh.field('permissions[].id').val();
				username = edtudpxxsh.field('users.username').val();
				email = edtudpxxsh.field('users.email').val();
				password = edtudpxxsh.field('users.password').val();
				fname = edtudpxxsh.field('users.fname').val();
				lname = edtudpxxsh.field('users.lname').val();
				confirm_password = edtudpxxsh.field('confirm_password').val();

				if(!permissions_id || permissions_id == ''){
					edtudpxxsh.field('permissions[].id').error( 'Wajib diisi!' );
				}

				validasiRequired(
					edtudpxxsh,
					'users',
					{
						'username': username,
						'email': email,
						'password': password,
						'fname': fname,
						'lname': lname,
					}
				);

				var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if (!emailRegex.test(email)) {
					edtudpxxsh.field('users.email').error('Format email tidak valid!');
				}

				validasiUnique(
					action,
					edtudpxxsh,
					'users',
					'email',
					'email',
					'"'+email+'"',
					id_users
				);

				
				validasiUnique(
					action,
					edtudpxxsh,
					'users',
					'username',
					'username',
					'"'+username+'"',
					id_users
				);
				
				if (action == 'create') {
					if(!confirm_password || confirm_password == ''){
						edtudpxxsh.field('confirm_password').error( 'Wajib diisi!' );
					}

					if (confirm_password != password) {
						edtudpxxsh.field('confirm_password').error( 'Confirm Password salah!' );
					}
				}
			}
			
			if ( edtudpxxsh.inError() ) {
				return false;
			}
		});

		edtudpxxsh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpxxsh.field('users.finish_at').val(finish_at);
		});
		
		edtudpxxsh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tbludpxxsh.ajax.reload(null,false);
		} );

		edtudpxxsh.on( 'close', function () {
			edtudpxxsh.enable();
		} );
		
		tbludpxxsh = $('#tbludpxxsh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/core/users.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpxxsh = show_deleted_udpxxsh;
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
				{ data: "udpxxsh.id",visible:false },
				{ data: "users.username" },
				{ data: "users_nama" },
				{ 
					data: "udpxxsh.data_permission",
					render: function (data){
						if (data == 0){
							return 'All';
						}else if (data == 1){
							return 'Self';
						}else{
							return '';
						}
					}
				},
				{ data: "udpxxsh.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_udpxxsh';
					$table       = 'tbludpxxsh';
					$edt         = 'edtudpxxsh';
					$show_status = '_udpxxsh';
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
				if ( data.udpxxsh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.udpxxsh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbludpxxsh.searchPanes.container().appendTo('#spudpxxsh');
		tbludpxxsh.searchBuilder.container().appendTo( '#sbudpxxsh' );
		
		tbludpxxsh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblucudasd, tbludpbrsd, tbludpodsd, tbludpwhsd];
			CekInitHeaderHD(tbludpxxsh, tbl_details);

			tblucudasd.button( 'btnRefreshPages:name' ).disable();
		} );
		
		tbludpxxsh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('udpxxsh');
			id_users     = udpxxsh_data.id_users;
			id_users_old = udpxxsh_data.id_users;
			
			// atur hak akses
			tbl_details = [tblucudasd, tbludpbrsd, tbludpodsd, tbludpwhsd];
			CekSelectHeaderHD(tbludpxxsh, tbl_details);

			tblucudasd.button( 'btnRefreshPages:name' ).enable();
			console.log(id_users);
		} );
		
		tbludpxxsh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('udpxxsh');
			id_users = 0, id_users_old = 0;

			// atur hak akses
			tbl_details = [tblucudasd, tbludpbrsd, tbludpodsd, tbludpwhsd];
			CekDeselectHeaderHD(tbludpxxsh, tbl_details);

			tblucudasd.button( 'btnRefreshPages:name' ).disable();
		} );
		// END udpxxsh

		// BEGIN ucudasd
		edtucudasd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/ucudasd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ucudasd = show_deleted_ucudasd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			table: "#tblucudasd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ucudasd.start_at",
					name: "ucudasd.start_at",
					type: "hidden"
				},	
				{
					label: "ucudasd.finish_at",
					name: "ucudasd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ucudasd",
					type: "hidden"
				},	
				{
					label: "ucudasd.transaction_state",
					name: "ucudasd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "ucudasd.id_udpxxsh",
					name: "ucudasd.id_udpxxsh",
					type: "hidden"
				},

				{
					label: "Create",
					name: "ucudasd.hak_c",
					type: "select",
					fieldInfo: "Pengaturan akses Create dan Confirm",
					placeholder: "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},	
				{
					label: "Update",
					name: "ucudasd.hak_u",
					type: "select",
					fieldInfo: "Pengaturan akses Edit atau Update",
					placeholder: "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},	
				{
					label: "Delete",
					name: "ucudasd.hak_d",
					type: "select",
					fieldInfo: "Pengaturan akses Delete",
					placeholder: "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},	
				{
					label: "Approve",
					name: "ucudasd.hak_a",
					type: "select",
					fieldInfo: "Pengaturan akses Approval, Cancel Approve, dan Void Transaksi",
					placeholder: "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Export",
					name: "ucudasd.hak_e",
					type: "select",
					fieldInfo: "Pengaturan akses Export Data",
					placeholder: "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Print",
					name: "ucudasd.hak_p",
					type: "select",
					fieldInfo: "Pengaturan akses Print Dokumen & Jurnal",
					placeholder: "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				}
			]
		} );
			
		edtucudasd.on( 'preOpen', function( e, mode, action ) {
			edtucudasd.field('ucudasd.id_udpxxsh').val(id_udpxxsh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtucudasd.field('ucudasd.start_at').val(start_at);
			
			if(action == 'create'){
				tblucudasd.rows().deselect();
			}
		});

		edtucudasd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtucudasd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){


			}
			
			if ( edtucudasd.inError() ) {
				return false;
			}
		});

		edtucudasd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtucudasd.field('ucudasd.finish_at').val(finish_at);
		});
			
		edtucudasd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtucudasd.on( 'close', function () {
			edtucudasd.enable();
		} );
		
		tblucudasd = $('#tblucudasd').DataTable( {
			ajax: {
				url: "../../models/core/ucudasd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ucudasd = show_deleted_ucudasd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "ucudasd.id",visible:false },
				{ data: "ucudasd.id_udpxxsh",visible:false },
				{ data: "pages.title"},
				{ 
					data: "ucudasd.hak_c",
					render: function (data){
						if (data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}
					}
				},
				{ 
					data: "ucudasd.hak_u" ,
					render: function (data){
						if (data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}
					}
				},
				{ 
					data: "ucudasd.hak_d" ,
					render: function (data){
						if (data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}
					}
				},
				{ 
					data: "ucudasd.hak_a" ,
					render: function (data){
						if (data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}
					}
				},
				{ 
					data: "ucudasd.hak_e" ,
					render: function (data){
						if (data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}
					}
				},
				{ 
					data: "ucudasd.hak_p" ,
					render: function (data){
						if (data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}
					}
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ucudasd';
					$table       = 'tblucudasd';
					$edt         = 'edtucudasd';
					$show_status = '_ucudasd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [ 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
				{
					name: 'btnRefreshPages',
					text: '<i class="fa fa-refresh"></i>',
					className: 'btn btn-outline',
					titleAttr: 'Recheck',
					action: function ( e, dt, node, config ) {
						$.ajax( {
							url: '../../models/core/ucudasd_fn_generate.php',
							dataType: 'json',
							type: 'POST',
							data: {
								id_udpxxsh: id_udpxxsh,
								id_users: id_users
							},
							success: function ( json ) {
								full_message = '';
								status_code  = json.data.status_code;
								full_message = full_message + json.data.message + '</br>';
								toast_type   = json.data.type_message;
								toastr[toast_type](full_message, 'INFO');
								tblucudasd.rows().deselect();
								tblucudasd.ajax.reload(null,false);

								
							}
						} );
					}
				}
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblucudasd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblucudasd, 1 );
			CekDrawDetailHDFinal(tbludpxxsh);
		} );

		tblucudasd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('ucudasd');
			
			// atur hak akses
			CekSelectDetailHD( tblucudasd );
		} );

		tblucudasd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('ucudasd');
			
			// atur hak akses
			CekDeselectDetailHD( tblucudasd );
		} );
		// END ucudasd

		// BEGIN udpbrsd
		edtudpbrsd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/udpbrsd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpbrsd = show_deleted_udpbrsd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			table: "#tbludpbrsd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "udpbrsd.start_at",
					name: "udpbrsd.start_at",
					type: "hidden"
				},	
				{
					label: "udpbrsd.finish_at",
					name: "udpbrsd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "udpbrsd",
					type: "hidden"
				},	
				{
					label: "udpbrsd.id_udpxxsh",
					name: "udpbrsd.id_udpxxsh",
					type: "hidden"
				},
				{
					label: "udpbrsd.transaction_state",
					name: "udpbrsd.transaction_state",
					type: "hidden",
					def: 0
				},

				{
					label: "Cabang",
					name: "udpbrsd.id_gbrxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gbrxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gbrxxmh_old: id_gbrxxmh_old,
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
					name: "udpbrsd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtudpbrsd.on( 'preOpen', function( e, mode, action ) {
			edtudpbrsd.field('udpbrsd.id_udpxxsh').val(id_udpxxsh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpbrsd.field('udpbrsd.start_at').val(start_at);
			
			if(action == 'create'){
				tbludpbrsd.rows().deselect();
			}
		});

		edtudpbrsd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtudpbrsd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_gbrxxmh = edtudpbrsd.field('udpbrsd.id_gbrxxmh').val();

				validasiRequired(
					edtudpbrsd,
					'udpbrsd',
					{
						'id_gbrxxmh': id_gbrxxmh
					}
				);

				validasiUnique(
					action,
					edtudpbrsd,
					'udpbrsd',
					'id_gbrxxmh',
					'id_gbrxxmh,id_udpxxsh',
					id_gbrxxmh+','+id_udpxxsh,
					id_udpbrsd
				);

			}
			
			if ( edtudpbrsd.inError() ) {
				return false;
			}
		});

		edtudpbrsd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpbrsd.field('udpbrsd.finish_at').val(finish_at);
		});
			
		edtudpbrsd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtudpbrsd.on( 'close', function () {
			edtudpbrsd.enable();
		} );
		
		tbludpbrsd = $('#tbludpbrsd').DataTable( {
			ajax: {
				url: "../../models/core/udpbrsd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpbrsd = show_deleted_udpbrsd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "udpbrsd.id",visible:false },
				{ data: "udpbrsd.id_udpxxsh",visible:false },
				{ data: "gbrxxmh.nama" },
				{ data: "udpbrsd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_udpbrsd';
					$table       = 'tbludpbrsd';
					$edt         = 'edtudpbrsd';
					$show_status = '_udpbrsd';
					$table_name  = $nama_tabels_d[0];

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

		tbludpbrsd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbludpbrsd, 1 );
			CekDrawDetailHDFinal(tbludpxxsh);
		} );

		tbludpbrsd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('udpbrsd');
			id_gbrxxmh_old = udpbrsd_data.id_gbrxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tbludpbrsd );
		} );

		tbludpbrsd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('udpbrsd');
			id_gbrxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbludpbrsd );
		} );
		// END udpbrsd

		// BEGIN udpodsd
		edtudpodsd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/udpodsd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpodsd = show_deleted_udpodsd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			table: "#tbludpodsd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "udpodsd.start_at",
					name: "udpodsd.start_at",
					type: "hidden"
				},	
				{
					label: "udpodsd.finish_at",
					name: "udpodsd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "udpodsd",
					type: "hidden"
				},	
				{
					label: "udpodsd.id_udpxxsh",
					name: "udpodsd.id_udpxxsh",
					type: "hidden"
				},
				{
					label: "udpodsd.transaction_state",
					name: "udpodsd.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Department",
					name: "udpodsd.id_hodxxmh",
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
					label: "Keterangan",
					name: "udpodsd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtudpodsd.on( 'preOpen', function( e, mode, action ) {
			edtudpodsd.field('udpodsd.id_udpxxsh').val(id_udpxxsh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpodsd.field('udpodsd.start_at').val(start_at);
			
			if(action == 'create'){
				tbludpodsd.rows().deselect();
			}
		});

		edtudpodsd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtudpodsd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hodxxmh = edtudpodsd.field('udpodsd.id_hodxxmh').val();

				validasiRequired(
					edtudpodsd,
					'udpodsd',
					{
						'id_hodxxmh': id_hodxxmh
					}
				);

				validasiUnique(
					action,
					edtudpodsd,
					'udpodsd',
					'id_hodxxmh',
					'id_hodxxmh,id_udpxxsh',
					id_hodxxmh+','+id_udpxxsh,
					id_udpodsd
				);

			}
			
			if ( edtudpodsd.inError() ) {
				return false;
			}
		});

		edtudpodsd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpodsd.field('udpodsd.finish_at').val(finish_at);
		});
			
		edtudpodsd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtudpodsd.on( 'close', function () {
			edtudpodsd.enable();
		} );
		
		tbludpodsd = $('#tbludpodsd').DataTable( {
			ajax: {
				url: "../../models/core/udpodsd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpodsd = show_deleted_udpodsd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "udpodsd.id",visible:false },
				{ data: "udpodsd.id_udpxxsh",visible:false },
				{ data: "hodxxmh.nama" },
				{ data: "udpodsd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_udpodsd';
					$table       = 'tbludpodsd';
					$edt         = 'edtudpodsd';
					$show_status = '_udpodsd';
					$table_name  = $nama_tabels_d[0];

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

		tbludpodsd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbludpodsd, 1 );
			CekDrawDetailHDFinal(tbludpxxsh);
		} );

		tbludpodsd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('udpodsd');
			id_hodxxmh_old = udpodsd_data.id_hodxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tbludpodsd );
		} );

		tbludpodsd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('udpodsd');
			id_hodxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbludpodsd );
		} );
		// END udpodsd

		// BEGIN udpwhsd
		edtudpwhsd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/core/udpwhsd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpwhsd = show_deleted_udpwhsd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			table: "#tbludpwhsd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "udpwhsd.start_at",
					name: "udpwhsd.start_at",
					type: "hidden"
				},	
				{
					label: "udpwhsd.finish_at",
					name: "udpwhsd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "udpwhsd",
					type: "hidden"
				},	
				{
					label: "udpwhsd.id_udpxxsh",
					name: "udpwhsd.id_udpxxsh",
					type: "hidden"
				},
				{
					label: "udpwhsd.transaction_state",
					name: "udpwhsd.transaction_state",
					type: "hidden",
					def: 0
				},

				{
					label: "Warehouse",
					name: "udpwhsd.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iwhxxmh_old: id_iwhxxmh_old,
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
					name: "udpwhsd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtudpwhsd.on( 'preOpen', function( e, mode, action ) {
			edtudpwhsd.field('udpwhsd.id_udpxxsh').val(id_udpxxsh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpwhsd.field('udpwhsd.start_at').val(start_at);
			
			if(action == 'create'){
				tbludpwhsd.rows().deselect();
			}
		});

		edtudpwhsd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtudpwhsd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iwhxxmh = edtudpwhsd.field('udpwhsd.id_iwhxxmh').val();

				validasiRequired(
					edtudpwhsd,
					'udpwhsd',
					{
						'id_iwhxxmh': id_iwhxxmh
					}
				);

				validasiUnique(
					action,
					edtudpwhsd,
					'udpwhsd',
					'id_iwhxxmh',
					'id_iwhxxmh,id_udpxxsh',
					id_iwhxxmh+','+id_udpxxsh,
					id_udpwhsd
				);

			}
			
			if ( edtudpwhsd.inError() ) {
				return false;
			}
		});

		edtudpwhsd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtudpwhsd.field('udpwhsd.finish_at').val(finish_at);
		});
			
		edtudpwhsd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtudpwhsd.on( 'close', function () {
			edtudpwhsd.enable();
		} );
		
		tbludpwhsd = $('#tbludpwhsd').DataTable( {
			ajax: {
				url: "../../models/core/udpwhsd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_udpwhsd = show_deleted_udpwhsd;
					d.id_udpxxsh = id_udpxxsh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "udpwhsd.id",visible:false },
				{ data: "udpwhsd.id_udpxxsh",visible:false },
				{ data: "iwhxxmh.nama" },
				{ data: "udpwhsd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_udpwhsd';
					$table       = 'tbludpwhsd';
					$edt         = 'edtudpwhsd';
					$show_status = '_udpwhsd';
					$table_name  = $nama_tabels_d[0];

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

		tbludpwhsd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbludpwhsd, 1 );
			CekDrawDetailHDFinal(tbludpxxsh);
		} );

		tbludpwhsd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('udpwhsd');
			id_iwhxxmh_old = udpwhsd_data.id_iwhxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tbludpwhsd );
		} );

		tbludpwhsd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('udpwhsd');
			id_iwhxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbludpwhsd );
		} );
		// END udpwhsd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
