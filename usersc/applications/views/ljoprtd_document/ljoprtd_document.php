<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel     = 'ljoxxth';
    $nama_tabels_d 	= [];
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFljoxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblljoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
                                <th>id_ljoprtd</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Activity</th>
                                <th>Expedition</th>
                                <th>Vehicle Type</th>
								<th>Plate</th>
                                <th>Driver</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ljoxxth/fn/ljoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtljoxxth, tblljoxxth, show_deleted_ljoxxth = 0, id_ljoxxth;
	var kategori_dokumen = '', kategori_dokumen_value = '';
	// ------------- end of default variable

	id_lacxxmh_old = 0, id_lvtxxmh_old = 0, id_grlxxmh_old = 0;

	// get tableRelation
	tableRelation('ljoxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN ljoxxth
		edtljoxxth = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 8,
				}
			},
			ajax: {
				url: "../../models/ljoprtd_document/ljoprtd_document.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljoxxth = show_deleted_ljoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblljoxxth",
			fields: [ 
				{
					label: "ljoxxth.start_at",
					name: "ljoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "ljoxxth.finish_at",
					name: "ljoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ljoxxth",
					type: "hidden"
				},	
				{
					label: "ljoxxth.transaction_state",
					name: "ljoxxth.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "ljoxxth.tanggal",
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
					label: "Activity <sup class='text-danger'>*<sup>",
					name: "ljoxxth.id_lacxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lacxxmh/lacxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_lacxxmh_old: id_lacxxmh_old,
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
					label: "Expedition <sup class='text-danger'>*<sup>",
					name: "ljoxxth.id_grlxxmh_expedition",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lexxxmh/lexxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_old,
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
					label: "Vehicle Type <sup class='text-danger'>*<sup>",
					name: "ljoxxth.id_lvtxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lvtxxmh/lvtxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_lvtxxmh_old: id_lvtxxmh_old,
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
					label: "Plat No",
					name: "ljoxxth.plat_no",
				},
				{
					label: "Supir",
					name: "ljoxxth.supir_nama",
				},
				{
					label: "Kernet",
					name: "ljoxxth.kernet_nama",
				},
				{
					label: "Keterangan",
					name: "ljoxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtljoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljoxxth.field('ljoxxth.start_at').val(start_at);

			if(action == 'create'){
				tblljoxxth.rows().deselect();
			}

			edtljoxxth.field('ljoxxth.tanggal').disable();
			edtljoxxth.field('ljoxxth.id_lacxxmh').disable();
			edtljoxxth.field('ljoxxth.id_grlxxmh_expedition').disable();
			edtljoxxth.field('ljoxxth.id_lvtxxmh').disable();
			edtljoxxth.field('ljoxxth.plat_no').disable();
			edtljoxxth.field('ljoxxth.supir_nama').disable();
			edtljoxxth.field('ljoxxth.kernet_nama').disable();
			edtljoxxth.field('ljoxxth.keterangan').disable();
		});

		edtljoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});
		
		edtljoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtljoxxth.field('ljoxxth.tanggal').val();
				id_lacxxmh = edtljoxxth.field('ljoxxth.id_lacxxmh').val();
				id_grlxxmh_expedition = edtljoxxth.field('ljoxxth.id_grlxxmh_expedition').val();
				id_lvtxxmh = edtljoxxth.field('ljoxxth.id_lvtxxmh').val();

				validasiRequired(
					edtljoxxth,
					'ljoxxth',
					{
						'tanggal': tanggal,
						'id_lacxxmh': id_lacxxmh,
						'id_grlxxmh_expedition': id_grlxxmh_expedition,
						'id_lvtxxmh': id_lvtxxmh
					}
				);
			}
			
			if ( edtljoxxth.inError() ) {
				return false;
			}
		});

		edtljoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljoxxth.field('ljoxxth.finish_at').val(finish_at);
		});
		
		edtljoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtljoxxth.on( 'close', function () {
			edtljoxxth.enable();
		} );
		
		tblljoxxth = $('#tblljoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ljoprtd_document/ljoprtd_document.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljoxxth = show_deleted_ljoxxth;
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
					targets: [2,3,4,5,6]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1,7,8,9]
				}
			],
			columns: [
				{ data: "ljoxxth.id",visible:false },
				{ data: "ljoprtd.id",visible:false },
				{ data: "ljoxxth.kode" },
				{ data: "ljoxxth.tanggal" },
				{ data: "lacxxmh.nama" },
				{ data: "grlxxmh.nama" },
				{ data: "lvtxxmh.nama" },
				{ data: "ljoxxth.plat_no" },
				{ data: "ljoxxth.supir_nama" },
				{ data: "ljoprtd.tanggaljam_start" }
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
								
								if (show_deleted_ljoxxth == 0){
									$('#bf_active_status').addClass('text-danger');
									show_deleted_ljoxxth = 1;
								} else if (show_deleted_ljoxxth == 1){
									$('#bf_active_status').removeClass('text-danger');
									show_deleted_ljoxxth = 0;
								}

								tblljoxxth.rows().deselect();
								tblljoxxth.ajax.reload(null,false);

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
								$('#modalSFljoxxth').modal('show');
							}
						},
						{ 
							text: '&nbsp;<i class="fa fa-columns"></i>&nbsp;Search Panes',
							name: 'btnSP',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Filter',
							action: function (e, dt, button, config) {
								$('#modalPljoxxth').modal('show');
							}
						},
						{ 
							text: '&nbsp;<i class="fa fa-search"></i>&nbsp;Search Builder',
							name: 'btnSB',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Search',
							action: function (e, dt, button, config) {
								$('#modalQljoxxth').modal('show');
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
											table_name       : 'ljoxxth',
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
															nama_tabel              : 'ljoxxth',
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

											}else{
												console.log('no');
											}
											toastr[toast_type](full_message, 'INFO');
											tblljoxxth.ajax.reload(null, false);
										}

									} );                                    

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
								edtljoxxth.edit(tblljoxxth.row({
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
								edtljoxxth.disable();
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
										table_name	 : 'ljoxxth',
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
				// custom button
				{
					text: '<i class="fa fa-icon">Start</i>',
					name: 'btndocumentStart',
					className: 'btn btn-outline',
					titleAttr: 'Start Process',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						is_confirmed = confirm("Apakah Anda Yakin Akan Start Process?");
            			if(is_confirmed == true){
							$.ajax( {
								url: "../../models/ljoprtd_document/ljoprtd_document_fn.php",
								dataType: 'json',
								type: 'POST',
								data: {
									jenis     : 1,
									id_ljoxxth: id_ljoxxth,
									tanggaljam: tanggaljam_hariini_ymd
								},
								success: function ( json ) {
									full_message = '';
									status_code  = json.data.status_code;
									full_message = full_message + json.data.message + '</br>';
									toast_type   = json.data.type_message;

									toastr[toast_type](full_message, 'INFO');
									tblljoxxth.ajax.reload(null, false);
								}
							} );
						}
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.ljoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ljoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblljoxxth.searchPanes.container().appendTo('#spljoxxth');
		tblljoxxth.searchBuilder.container().appendTo( '#sbljoxxth' );
		
		tblljoxxth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblljoxxth);

			tblljoxxth.button( 'btndocumentStart:name' ).disable();
		} );
		
		tblljoxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ljoxxth');
			id_grlxxmh_old    = ljoxxth_data.id_grlxxmh_expedition;
			id_lacxxmh_old    = ljoxxth_data.id_lacxxmh;
			id_lvtxxmh_old    = ljoxxth_data.id_lvtxxmh;

			ljoprtd_data = tblljoxxth.row( { selected: true } ).data().ljoprtd;
			id_ljoprtd = ljoprtd_data.id;
			
			// atur hak akses
			is_master_table = 1;
			CekSelectHeaderH(tblljoxxth);

			tanggaljam_start  = ljoprtd_data.tanggaljam_start;
			if(tanggaljam_start == null){
				tblljoxxth.button( 'btndocumentStart:name' ).enable();
			}else{
				tblljoxxth.button( 'btndocumentStart:name' ).disable();
			}

		} );
		
		tblljoxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ljoxxth');
			id_grlxxmh_old = 0, id_lacxxmh_old = 0, id_lvtxxmh_old = 0;
			id_ljoprtd = 0;

			// atur hak akses
			CekDeselectHeaderH(tblljoxxth);

			tblljoxxth.button( 'btndocumentStart:name' ).disable();
		} );
		// END ljoxxth

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblljoxxth.rows().deselect();
				tblljoxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFljoxxth').modal('toggle');
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
