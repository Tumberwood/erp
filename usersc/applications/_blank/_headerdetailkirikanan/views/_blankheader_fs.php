<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = '_blankheader';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = '_blankdetail';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSF_blankheader" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tbl_blankheader" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tab_blankdetail_1"> Tab 1</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tab_blankdetail_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tab_blankdetail_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id__blankheader</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tab_blankdetail_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id__blankheader</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/_blankheader/fn/_blankheader_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edt_blankheader, tbl_blankheader, show_deleted__blankheader = 0, id__blankheader;
	var edt_blankdetail, tbl_blankdetail, show_deleted__blankdetail = 0, id__blankdetail;
	// ------------- end of default variable

	id_lacxxmh_old = 0, id_lvtxxmh_old = 0, id_grlxxmh_old = 0;

	// get tableRelation
	tableRelation('_blankheader');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN _blankheader
		edt_blankheader = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blankheader/_blankheader.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankheader = show_deleted__blankheader;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tbl_blankheader",
			fields: [ 
				{
					label: "_blankheader.start_at",
					name: "_blankheader.start_at",
					type: "hidden"
				},	
				{
					label: "_blankheader.finish_at",
					name: "_blankheader.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankheader",
					type: "hidden"
				},	
				{
					label: "_blankheader.transaction_state",
					name: "_blankheader.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "_blankheader.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "_blankheader.nama"
				}, 	
				{
					label: "Keterangan",
					name: "_blankheader.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edt_blankheader.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankheader.field('_blankheader.start_at').val(start_at);

			if(action == 'create'){
				tbl_blankheader.rows().deselect();
			}
		});

		edt_blankheader.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});
		
		edt_blankheader.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blankheader.field('_blankheader.kode').val();
				nama = edt_blankheader.field('_blankheader.nama').val();

				validasiRequired(
					edt_blankheader,
					'_blankheader',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edt_blankheader,
					'_blankheader',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blankheader
				);

				validasiUnique(
					action,
					edt_blankheader,
					'_blankheader',
					'nama',
					'nama',
					'"'+nama+'"',
					id__blankheader
				);
			}
			
			if ( edt_blankheader.inError() ) {
				return false;
			}
		});

		edt_blankheader.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankheader.field('_blankheader.finish_at').val(finish_at);
		});
		
		edt_blankheader.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankheader.on( 'close', function () {
			edt_blankheader.enable();
		} );
		
		tbl_blankheader = $('#tbl_blankheader').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/_blankheader/_blankheader.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankheader = show_deleted__blankheader;
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
				{ data: "_blankheader.id",visible:false },
				{ data: "_blankheader.kode" },
				{ data: "_blankheader.nama" },
				{ data: "_blankheader.keterangan" }
			],
			buttons: [
				// btnSetTools
				{
					extend: 'collection',
					name: 'btnSetTools',
					text: '<i class="fa fa-wrench"></i>',
					titleAttr: 'Tools',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						{
							text: '<i class="fa fa-adjust" id="bf_active_status"></i>&nbsp;Show / Hide Deleted',
							name: 'btnShowHide', 
							className: 'btn btn-sm',
							titleAttr: 'Show / Hide Deleted',
							action: function ( e, dt, node, config, tbl_details ) {
								
								if (show_deleted__blankheader == 0){
									$('#bf_active_status').addClass('text-danger');
									show_deleted__blankheader = 1;
								} else if (show_deleted__blankheader == 1){
									$('#bf_active_status').removeClass('text-danger');
									show_deleted__blankheader = 0;
								}

								tbl_blankheader.rows().deselect();
								tbl_blankheader.ajax.reload(null,false);

							}
						},
						{ 
							extend: "excel",
							name: 'btnExcel', 
							text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
							className: 'btn btn-sm',
							titleAttr: 'Export to Excel',
							exportOptions: {
								columns: ':visible'
							}
						},
						{ 
							extend: "copy", 
							name: 'btnCopy',
							text: '<i class="fa fa-copy"></i>&nbsp;Copy',
							className: 'btn btn-sm',
							titleAttr: 'Copy',
							exportOptions: {
								columns: ':visible'
							}
						},
						{ 
							extend: 'colvis',
							text: '<i class="fa fa-eye-slash"></i>&nbsp;Show / Hide Column',
							name: 'btnColVis',
							className: 'btn btn-sm',
							titleAttr: 'Show / Hide Column',
							columns: colvisCount,
							columnText: function ( dt, idx, title ) {
								return title;
							}
						},

					]  
				},
				// btnSetTools2
				{
					extend: 'collection',
					name: 'btnSetTools2',
					text: '<i class="fa fa-search-plus"></i>',
					titleAttr: 'Advanced Filter',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						{ 
							text: '&nbsp;<i class="fa fa-filter"></i>&nbsp;Filter',
							name: 'btnSF',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Simple Filter',
							action: function (e, dt, button, config) {
								$('#modalSF_blankheader').modal('show');
							}
						},
						{ 
							text: '&nbsp;<i class="fa fa-columns"></i>&nbsp;Search Panes',
							name: 'btnSP',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Filter',
							action: function (e, dt, button, config) {
								$('#modalP_blankheader').modal('show');
							}
						},
						{ 
							text: '&nbsp;<i class="fa fa-search"></i>&nbsp;Search Builder',
							name: 'btnSB',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Search',
							action: function (e, dt, button, config) {
								$('#modalQ_blankheader').modal('show');
							}
						},
					]  
				},
				// btnSetAction
				{
					extend: 'collection',
					name: 'btnSetAction',
					text: '<i class="fa fa-th-list"></i>', 
					titleAttr: 'Actions',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						// Create
						{ 
							extend: 'create',
							name: 'btnCreate', 
							editor: edt_blankheader, 
							text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
							className: 'btn btn-sm', 
							titleAttr: 'Add New',
							formButtons: [
								{
									text: 'Cancel',
									action: function () {
										this.close();
									},
									className: 'btn btn-warning m-r-xs'
								},
								{
									text: 'Save',
									action: function () {
										this.submit();
									},
									className: 'btn btn-primary m-r-xs'
								},
								{
									text: 'Save & Confirm',
									action: function (e, dt, node, config, cb){
										this.submit(
											function (json) {
												new_id = json.data[0]._blankheader.id;
												full_message = '';
												$.ajax( {
													url: '../../../helpers/tr_fn_transaction_state.php',
													dataType: 'json',
													type: 'POST',
													data: {
														table_name       : '_blankheader',
														id_transaksi     : new_id,
														transaction_state: 1
													},
													success: function ( json ) {
														status_code  = json.data.status_code;
														full_message = full_message + json.data.message + '</br>';
														toast_type   = json.data.type_message;

														if(status_code == 200){

															if(is_need_generate_kode == 1){
																$.ajax( {
																	url: '../../../helpers/kode_fn_generate_confirm.php',
																	dataType: 'json',
																	type: 'POST',
																	async: false,
																	data: {
																		state                   : 1,
																		nama_tabel              : _blankheader,
																		kategori_dokumen        : kategori_dokumen,
																		kategori_dokumen_value  : kategori_dokumen_value,
																		id_transaksi            : new_id
																	},
																	success: function ( json ) {
																		toast_type   = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );

															}

															if(is_need_approval == 1){
																// insert gaplgtd
																$.ajax( {
																	url: 'xxx.php',
																	url: '../../../helpers/tr_fn_transaction_state_approval.php',
																	dataType: 'json',
																	type: 'POST',
																	//async: false,
																	data: {
																		state       : 1,
																		id_transaksi: new_id,
																		table_name  : '_blankheader',
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															}

															if(is_need_inventory == 1){
																$.ajax( {
																	url: '../../models/_blankheader/_blankheader_iv.php',
																	dataType: 'json',
																	type: 'POST',
																	//async: false,
																	data: {
																		state           : 1,
																		id_transaksi_h  : new_id,
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															}

															if(is_need_jurnal == 1){
																$.ajax( {
																	url: '../../models/_blankheader/_blankheader_jv.php',
																	dataType: 'json',
																	type: 'POST',
																	async: false,
																	data: {
																		state           : 1,
																		id_transaksi_h  : new_id,
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															}

															// BEGIN jika perlu post_confirm
																$.ajax( {
																	url: '../../models/_blankheader/_blankheader_post_confirm.php',
																	dataType: 'json',
																	type: 'POST',
																	async: false,
																	data: {
																		state           : 1,
																		id_transaksi  : new_id
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	},
																	error: function(xhr, status, error) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															// END jika perlu post_confirm
														}else{
															console.log('no');
														}
														toastr[toast_type](full_message, 'INFO');
														tbl_blankheader.ajax.reload(null, false);
													}
												} );  
											}, 
										);
									},
									className: 'btn btn-primary'
								}
							]
						},
						// Confirm
						{ 
							text: '<i class="fa fa-save"></i>&nbsp;Confirm',
							name: 'btnConfirm',
							className: 'btn btn-sm',
							titleAttr: 'Confirm',
							action: function ( e, dt, node, config ) {
								// jika draft akan dikonfirmasi
								message_transaction_state = "Apakah Anda Yakin Akan Konfimasi Data?";
								is_confirmed = confirm(message_transaction_state);
								if(is_confirmed == true){
									full_message = '';
									$.ajax( {
										url: '../../../helpers/tr_fn_transaction_state.php',
										dataType: 'json',
										type: 'POST',
										data: {
											table_name       : '_blankheader',
											id_transaksi     : id_transaksi_h,
											transaction_state: 1
										},
										success: function ( json ) {
											status_code  = json.data.status_code;
											full_message = full_message + json.data.message + '</br>';
											toast_type   = json.data.type_message;

											if(status_code == 200){

												if(is_need_generate_kode == 1){
													$.ajax( {
														url: '../../../helpers/kode_fn_generate_confirm.php',
														dataType: 'json',
														type: 'POST',
														async: false,
														data: {
															state                   : 1,
															nama_tabel              : _blankheader,
															kategori_dokumen        : kategori_dokumen,
															kategori_dokumen_value  : kategori_dokumen_value,
															id_transaksi            : id_transaksi_h
														},
														success: function ( json ) {
															toast_type   = json.data.type_message;
															full_message = full_message + json.data.message + '</br>';
														}
													} );

												}

												if(is_need_approval == 1){
													// insert gaplgtd
													$.ajax( {
														url: '../../../helpers/tr_fn_transaction_state_approval.php',
														dataType: 'json',
														type: 'POST',
														//async: false,
														data: {
															state       : 1,
															id_transaksi: id_transaksi_h,
															table_name  : '_blankheader',
														},
														success: function ( json ) {
															toast_type = json.data.type_message;
															full_message = full_message + json.data.message + '</br>';
														}
													} );
												}

												if(is_need_inventory == 1){
													$.ajax( {
														url: '../../models/_blankheader/_blankheader_iv.php',
														dataType: 'json',
														type: 'POST',
														//async: false,
														data: {
															state           : 1,
															id_transaksi_h  : id_transaksi_h,
														},
														success: function ( json ) {
															toast_type = json.data.type_message;
															full_message = full_message + json.data.message + '</br>';
														}
													} );
												}

												if(is_need_jurnal == 1){
													$.ajax( {
														url: '../../models/_blankheader/_blankheader_jv.php',
														dataType: 'json',
														type: 'POST',
														async: false,
														data: {
															state           : 1,
															id_transaksi_h  : id_transaksi_h,
														},
														success: function ( json ) {
															toast_type = json.data.type_message;
															full_message = full_message + json.data.message + '</br>';
														}
													} );
												}

												// BEGIN jika perlu post_confirm
													$.ajax( {
														url: '../../models/_blankheader/_blankheader_post_confirm.php',
														dataType: 'json',
														type: 'POST',
														async: false,
														data: {
															state           : 1,
															id_transaksi  : id_transaksi_h
														},
														success: function ( json ) {
															toast_type = json.data.type_message;
															full_message = full_message + json.data.message + '</br>';
														},
														error: function(xhr, status, error) {
															toast_type = json.data.type_message;
															full_message = full_message + json.data.message + '</br>';
														}
													} );
												// END jika perlu post_confirm
											}else{
												console.log('no');
											}
											toastr[toast_type](full_message, 'INFO');
											tbl_blankheader.ajax.reload(null, false);
										}

									} );                                    

								}

							}
						},
						// Edit
						{ 
							extend: 'edit', 
							name: 'btnEdit', 
							editor: edt_blankheader,
							text: '<i class="fa fa-edit"></i>&nbsp;Edit',
							className: 'btn btn-sm',
							titleAttr: 'Edit',
							formButtons: [
								{
									text: 'Cancel',
									action: function () {
										this.close();
									},
									className: 'btn btn-warning m-r-xs'
								},
								{
									text: 'Save',
									action: function () {
										this.submit();
									},
									className: 'btn btn-primary m-r-xs'
								},
								{
									text: 'Save & Confirm',
									action: function (e, dt, node, config, cb){
										this.submit(
											function (json) {
												new_id = json.data[0]._blankheader.id;
												full_message = '';
												$.ajax( {
													url: '../../../helpers/tr_fn_transaction_state.php',
													dataType: 'json',
													type: 'POST',
													data: {
														table_name       : '_blankheader',
														id_transaksi     : new_id,
														transaction_state: 1
													},
													success: function ( json ) {
														status_code  = json.data.status_code;
														full_message = full_message + json.data.message + '</br>';
														toast_type   = json.data.type_message;

														if(status_code == 200){
															if(is_need_generate_kode == 1){
																$.ajax( {
																	url: '../../../helpers/kode_fn_generate_confirm.php',
																	dataType: 'json',
																	type: 'POST',
																	async: false,
																	data: {
																		state                   : 1,
																		nama_tabel              : _blankheader,
																		kategori_dokumen        : kategori_dokumen,
																		kategori_dokumen_value  : kategori_dokumen_value,
																		id_transaksi            : new_id
																	},
																	success: function ( json ) {
																		toast_type   = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );

															}

															if(is_need_approval == 1){
																// insert gaplgtd
																$.ajax( {
																	url: '../../../helpers/tr_fn_transaction_state_approval.php',
																	dataType: 'json',
																	type: 'POST',
																	//async: false,
																	data: {
																		state       : 1,
																		id_transaksi: new_id,
																		table_name  : '_blankheader',
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															}

															if(is_need_inventory == 1){
																$.ajax( {
																	url: '../../models/_blankheader/_blankheader_iv.php',
																	dataType: 'json',
																	type: 'POST',
																	//async: false,
																	data: {
																		state           : 1,
																		id_transaksi_h  : new_id,
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															}

															if(is_need_jurnal == 1){
																$.ajax( {
																	url: '../../models/_blankheader/_blankheader_jv.php',
																	dataType: 'json',
																	type: 'POST',
																	async: false,
																	data: {
																		state           : 1,
																		id_transaksi_h  : new_id,
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															}
															// BEGIN jika perlu post confirm
																$.ajax( {
																	url: '../../models/_blankheader/_blankheader_post_confirm.php',
																	dataType: 'json',
																	type: 'POST',
																	async: false,
																	data: {
																		state           : 1,
																		id_transaksi  : new_id
																	},
																	success: function ( json ) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	},
																	error: function(xhr, status, error) {
																		toast_type = json.data.type_message;
																		full_message = full_message + json.data.message + '</br>';
																	}
																} );
															// END jika perlu post confirm
														}else{
															console.log('no');
														}
														toastr[toast_type](full_message, 'INFO');
														tbl_blankheader.ajax.reload(null, false);
													}

												} );  
											}, 
										);
										
										

									},
									className: 'btn btn-primary'
								}
							]
						},
						// Remove
						{
							extend: 'remove', 
							name: 'btnRemove',
							editor: edt_blankheader, 
							text: '<i class="fa fa-trash"></i>&nbsp;Delete(xH)',
							className: 'btn btn-sm text-danger',
							titleAttr: 'Remove',
							formButtons: [
								{
									text: 'Cancel',
									action: function () {
										this.close();
									}
								},
								'Delete'
							]
						},
						// Close Transcation
						{ 
							text: '<i class="fa fa-window-close"></i>&nbsp;Close',
							name: 'btnClose',
							className: 'btn btn-sm text-warning',
							titleAttr: 'Confirm',
							action: function ( e, dt, node, config ) {

								// jika draft akan dikonfirmasi
								message_transaction_state = "Apakah Anda Yakin Akan Menutup Data?";
								
								is_close = confirm(message_transaction_state);
								if(is_close == true){

									$.ajax( {
										url: '../../../helpers/tr_fn_transaction_state.php',
										dataType: 'json',
										type: 'POST',
										data: {
											table_name	 : '_blank',
											id_transaksi : id_transaksi_h,
											transaction_state : 9
										},
										success: function ( json ) {
											toast_type   = json.data.type_message;
											full_message = json.data.message;
											toastr[toast_type](full_message, 'INFO');
										}
									} );

									tbl_blank.ajax.reload(null, false);

								}

							}
						},
						// View Button
						{
							extend: "selected",
							name: 'btnView',
							text: '<i class="fa fa-window-maximize"></i>&nbsp;View Data',
							className: 'btn btn-sm',
							titleAttr: 'View Data',
							action: function(e, dt, node, config) {
								edt_blankheader.edit(tbl_blank.row({
									selected: true
								}).index(), {
									title: 'View'
								}).buttons(
									{
										text: 'Close',
										action: function () {
											this.close();
										},
										className: 'btn btn-warning'
									}
								);
								edt_blankheader.disable();
								e.preventDefault();
							}
						},
						// Log View Header
						{
							extend: "selected",
							name: 'btnLog',
							text: '<i class="fa fa-history"></i>&nbsp;View Log',
							className: 'btn btn-sm',
							titleAttr: 'View Data Log',
							action: function(e, dt, node, config) {
								e.preventDefault();
								$("#mdlLog").modal("show");

								$.ajax({
									url: '../../../helpers/fn_log_view.php',
									dataType: 'json',
									type: 'POST',
									async: false,
									data: {
										table_name	 : '_blank',
										id_transaksi : id_transaksi_log,
									},
									success: function(json) {
										str_log = '';
										log_data = json.data.rs_activity_log_ml;
										$.each(log_data, function(index, value) {
											
											switch(log_data[index].kode) {
												case 'CREATE':
													badgeClass = 'warning';
													break;
												case 'EDIT':
													badgeClass = 'info';
													break;
												case 'DELETE':
													badgeClass = 'danger';
													break;
												case 'CONFIRM':
													badgeClass = 'primary';
													break;
												case 'CLOSE':
													badgeClass = 'danger';
													break;
												case 'APPROVE':
													badgeClass = 'primary';
													break;
												case 'VOID':
													badgeClass = 'danger';
													break;
												case 'INVALID CODE':
													badgeClass = 'warning';
													break;
												default:
													badgeClass = 'plain';
											}

											str_log =   str_log + 
														'<span class=\"badge badge-' + 
														badgeClass + '\">' + 
														log_data[index].kode + 
														'</span> by ' + 
														log_data[index].username + 
														' at ' + 
														log_data[index].created_on + 
														'</br>';
										});
										$("#contentLog").html(str_log);
									}
								});
							}
						}
					]
				}, 
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data._blankheader.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data._blankheader.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbl_blankheader.searchPanes.container().appendTo('#sp_blankheader');
		tbl_blankheader.searchBuilder.container().appendTo( '#sb_blankheader' );
		
		tbl_blankheader.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekInitHeaderHD(tbl_blankheader, tbl_details);
		} );
		
		tbl_blankheader.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('_blankheader');
			
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekSelectHeaderHD(tbl_blankheader, tbl_details);

		} );
		
		tbl_blankheader.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('_blankheader');

			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekDeselectHeaderHD(tbl_blankheader, tbl_details);
		} );
		// END _blankheader

		// BEGIN _blankdetail
		edt_blankdetail = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blankheader/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id__blankheader = id__blankheader;
				}
			},
			table: "#tbl_blankdetail",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "_blankdetail.start_at",
					name: "_blankdetail.start_at",
					type: "hidden"
				},	
				{
					label: "_blankdetail.finish_at",
					name: "_blankdetail.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankdetail",
					type: "hidden"
				},	
				{
					label: "_blankdetail.transaction_state",
					name: "_blankdetail.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id__blankheader",
					name: "_blankdetail.id__blankheader",
					type: "hidden"
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "_blankdetail.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "_blankdetail.nama"
				}, 	
				{
					label: "Keterangan",
					name: "_blankdetail.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edt_blankdetail.on( 'preOpen', function( e, mode, action ) {
			edt_blankdetail.field('_blankdetail.id__blankheader').val(id__blankheader);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.start_at').val(start_at);
			
			if(action == 'create'){
				tbl_blankdetail.rows().deselect();
			}
		});

		edt_blankdetail.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edt_blankdetail.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blankdetail.field('_blankdetail.kode').val();

				validasiRequired(
					edt_blankdetail,
					'_blankdetail',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edt_blankdetail,
					'_blankdetail',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blankdetail
				);	
			}
			
			if ( edt_blankdetail.inError() ) {
				return false;
			}
		});

		edt_blankdetail.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.finish_at').val(finish_at);
		});
			
		edt_blankdetail.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankdetail.on( 'close', function () {
			edt_blankdetail.enable();
		} );
		
		tbl_blankdetail = $('#tbl_blankdetail').DataTable( {
			ajax: {
				url: "../../models/_blankheader/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id__blankheader = id__blankheader;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "_blankdetail.id",visible:false },
				{ data: "_blankdetail.id__blankheader",visible:false },
				{ data: "_blankdetail.kode" },
				{ data: "_blankdetail.nama" },
				{ data: "_blankdetail.keterangan" }
			],
			buttons: [
				// btnSetTools
				{
					extend: 'collection',
					name: 'btnSetTools',
					text: '<i class="fa fa-wrench"></i>',
					titleAttr: 'Tools',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						{
							text: '<i class="fa fa-adjust" id="bf_active_status"></i>&nbsp;Show / Hide Deleted',
							name: 'btnShowHide', 
							className: 'btn btn-sm',
							titleAttr: 'Show / Hide Deleted',
							action: function ( e, dt, node, config, tbl_details ) {
								
								if (show_deleted__blankdetail == 0){
									$('#bf_active_status').addClass('text-danger');
									show_deleted__blankdetail = 1;
								} else if (show_deleted__blankdetail == 1){
									$('#bf_active_status').removeClass('text-danger');
									show_deleted__blankdetail = 0;
								}

								tbl_blankdetail.rows().deselect();
								tbl_blankdetail.ajax.reload(null,false);

							}
						},
						{ 
							extend: "excel",
							name: 'btnExcel', 
							text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
							className: 'btn btn-sm',
							titleAttr: 'Export to Excel',
							exportOptions: {
								columns: ':visible'
							}
						},
						{ 
							extend: "copy", 
							name: 'btnCopy',
							text: '<i class="fa fa-copy"></i>&nbsp;Copy',
							className: 'btn btn-sm',
							titleAttr: 'Copy',
							exportOptions: {
								columns: ':visible'
							}
						},
						{ 
							extend: 'colvis',
							text: '<i class="fa fa-eye-slash"></i>&nbsp;Show / Hide Column',
							name: 'btnColVis',
							className: 'btn btn-sm',
							titleAttr: 'Show / Hide Column',
							columns: colvisCount,
							columnText: function ( dt, idx, title ) {
								return title;
							}
						},

					]  
				},
				// btnSetAction
				{
					extend: 'collection',
					name: 'btnSetAction',
					text: '<i class="fa fa-th-list"></i>', 
					titleAttr: 'Actions',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						// Create
						{ 
							extend: 'create',
							name: 'btnCreate', 
							editor: edt_blankdetail, 
							text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
							className: 'btn btn-sm', 
							titleAttr: 'Add New',
							formButtons: [
								{
									text: 'Cancel',
									action: function () {
										this.close();
									},
									className: 'btn btn-warning m-r-xs'
								},
								{
									text: 'Save',
									action: function () {
										this.submit();
									},
									className: 'btn btn-primary m-r-xs'
								}
							]
						},
						// Edit
						{ 
							extend: 'edit', 
							name: 'btnEdit', 
							editor: edt_blankdetail,
							text: '<i class="fa fa-edit"></i>&nbsp;Edit',
							className: 'btn btn-sm',
							titleAttr: 'Edit',
							formButtons: [
								{
									text: 'Cancel',
									action: function () {
										this.close();
									},
									className: 'btn btn-warning m-r-xs'
								},
								{
									text: 'Save',
									action: function () {
										this.submit();
									},
									className: 'btn btn-primary m-r-xs'
								}
							]
						},
						// Remove
						{
							extend: 'remove', 
							name: 'btnRemove',
							editor: edt_blankdetail, 
							text: '<i class="fa fa-trash"></i>&nbsp;Delete(xH)',
							className: 'btn btn-sm text-danger',
							titleAttr: 'Remove',
							formButtons: [
								{
									text: 'Cancel',
									action: function () {
										this.close();
									}
								},
								'Delete'
							]
						},
						// View Button
						{
							extend: "selected",
							name: 'btnView',
							text: '<i class="fa fa-window-maximize"></i>&nbsp;View Data',
							className: 'btn btn-sm',
							titleAttr: 'View Data',
							action: function(e, dt, node, config) {
								edt_blankdetail.edit(tbl_blank.row({
									selected: true
								}).index(), {
									title: 'View'
								}).buttons(
									{
										text: 'Close',
										action: function () {
											this.close();
										},
										className: 'btn btn-warning'
									}
								);
								edt_blankdetail.disable();
								e.preventDefault();
							}
						},
						// Log View Detail
						{
							extend: "selected",
							name: 'btnLog',
							text: '<i class="fa fa-history"></i>&nbsp;View Log',
							className: 'btn btn-sm',
							titleAttr: 'View Data Log',
							action: function(e, dt, node, config) {
								e.preventDefault();
								$("#mdlLog").modal("show");

								$.ajax({
									url: '../../../helpers/fn_log_view.php',
									dataType: 'json',
									type: 'POST',
									async: false,
									data: {
										table_name	 : '_blank',
										id_transaksi : id_transaksi_log_d,
									},
									success: function(json) {
										str_log = '';
										log_data = json.data.rs_activity_log_ml;
										$.each(log_data, function(index, value) {
											
											switch(log_data[index].kode) {
												case 'CREATE':
													badgeClass = 'warning';
													break;
												case 'EDIT':
													badgeClass = 'info';
													break;
												case 'DELETE':
													badgeClass = 'danger';
													break;
												case 'CONFIRM':
													badgeClass = 'primary';
													break;
												case 'CLOSE':
													badgeClass = 'danger';
													break;
												case 'APPROVE':
													badgeClass = 'primary';
													break;
												case 'VOID':
													badgeClass = 'danger';
													break;
												case 'INVALID CODE':
													badgeClass = 'warning';
													break;
												default:
													badgeClass = 'plain';
											}

											str_log =   str_log + 
														'<span class=\"badge badge-' + 
														badgeClass + '\">' + 
														log_data[index].kode + 
														'</span> by ' + 
														log_data[index].username + 
														' at ' + 
														log_data[index].created_on + 
														'</br>';
										});
										$("#contentLog").html(str_log);
									}
								});
							}
						},
						//No Action Needed Detail
						{
							text: 'No Action Needed', 
							name: 'btnNoActionD',
							className: 'btn btn-sm text-muted',
							titleAttr: 'No Action Needed',
							action: function () {}
						}
					]
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tbl_blankdetail.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tbl_blankdetail, 1 );
			CekDrawDetailHDFinal(tbl_blankheader);
		} );

		tbl_blankdetail.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('_blankdetail');
			
			// atur hak akses
			CekSelectDetailHD( tbl_blankdetail );
		} );

		tbl_blankdetail.on( 'deselect', function() {
			// reset variable standar framework
			siVarReset('_blankdetail');
			
			// atur hak akses
			CekDeselectDetailHD( tbl_blankdetail );
		} );
		// END _blankdetail

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbl_blankheader.rows().deselect();
				tbl_blankheader.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSF_blankheader').modal('toggle');
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
