<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gaplgtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgaplgtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Doc Number</th>
                                <th>Nama</th>
                                <th>Diajukan Oleh</th>
                                <th>Diajukan Pada</th>
                                <th>TX</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gaplgtd/fn/gaplgtd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtgaplgtd, tblgaplgtd, show_deleted_gaplgtd = 0, id_gaplgtd;
	// ------------- end of default variable

	var folder, id_transaksi_tujuan;
	
	// get tableRelation
	tableRelation('gaplgtd');

	$(document).ready(function() {
		
		// BEGIN gaplgtd
		edtgaplgtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gaplgtd/gaplgtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gaplgtd = show_deleted_gaplgtd;
				}
			},
			table: "#tblgaplgtd",
			fields: [ 
				{
					label: "gaplgtd.start_at",
					name: "gaplgtd.start_at",
					type: "hidden"
				},	
				{
					label: "gaplgtd.finish_at",
					name: "gaplgtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gaplgtd",
					type: "hidden"
				},	
				{
					label: "gaplgtd.transaction_state",
					name: "gaplgtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Doc Number <sup class='text-danger'>*<sup>",
					name: "gaplgtd.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "gaplgtd.nama"
				}
			]
		} );

		edtgaplgtd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgaplgtd.field('gaplgtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgaplgtd.rows().deselect();
			}
		});

		edtgaplgtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirm();
		});

		edtgaplgtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				
			}
			
			if ( edtgaplgtd.inError() ) {
				return false;
			}
		});
		
		edtgaplgtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgaplgtd.field('gaplgtd.finish_at').val(finish_at);
		});

		edtgaplgtd.on( 'close', function () {
			edtgaplgtd.enable();
		} );

		tblgaplgtd = $('#tblgaplgtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/gaplgtd/gaplgtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gaplgtd = show_deleted_gaplgtd;
				}
			},
			order: [[ 0, "desc" ]],
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
				{ data: "gaplgtd.id",visible:false },
				{ 
					data: "gaplgtd.kode" ,
					render: function (data, type, row) {
						folder              = row.gaplgtd.tbl_name;
						id_transaksi_tujuan = row.gaplgtd.id_transaksi;
						url = '/erpx/usersc/applications/views/' + folder + '/' + folder + '.php?rowid=' +id_transaksi_tujuan;
						if(data){
							return '<a href="'+url+'" target="_blank">'+ data + '</a>';
						}else{
							return '';
						}
					}
				},
				{ data: "gaplgtd.nama" },
				{ data: "users_pengaju.username" },
				{ data: "gaplgtd.dt_pengajuan" },
				{ 
					data: "gaplgtd.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "gaplgtd.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gaplgtd';
					$table       = 'tblgaplgtd';
					$edt         = 'edtgaplgtd';
					$show_status = '_gaplgtd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button

				// BEGIN buttom Approval Set
				{
					extend: 'collection',
					name: 'btnSetApprove',
					text: '<span class="fa fa-check"></span>',
					titleAttr: 'Approval',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						{ 
							text: '<i class="fa fa-check"></i>&nbsp;Approve',
							name: 'btnApprove1',
							className: 'btn btn-sm text-navy',
							titleAttr: 'Approve',
							action: function (e, dt, node, config) {
								full_message = '';
								$.ajax( {
									url: '../../../helpers/tr_fn_approve.php',
									dataType: 'json',
									type: 'POST',
									data: {
										approval_state: 1,
										table_name    : table_name_approve,
										id_transaksi  : id_transaksi_approve,
										id_gaplgtd    : id_transaksi_h,
									},
									success: function ( json ) {
										full_message = full_message + json.data.message + '</br>';
                						toast_type   = json.data.type_message;
										async function performCheckAndPostApprove(json) {
											if (json.data.status_code === 200) {
												// TODO, sistem approval belum final
												// ini harus dicek apakah approval sudah final
												// script _post_approve hanya dijalankan jika approval sudah final
												let url = "../../models/" + selected_folder + "/" + selected_folder + "_post_approve.php";
												try {
													let isPostApproveExist = await checkFileExists(url);
													if (isPostApproveExist) {
														$.ajax({
															url: url,
															dataType: 'json',
															type: 'POST',
															data: {
																id_transaksi: id_transaksi_approve,
																approval_state: 1
															},
															error: function() {
																console.log('File ' + url + ' tidak ada');
															},
															success: function(json) {
																full_message = full_message + json.data.message + '</br>';
                												toast_type   = json.data.type_message;
															}
														});
													} else {
														console.log('File ' + url + ' tidak ada');
													}
												} catch (error) {
													console.error('Error checking file existence:', error);
												}
											}
										}

										performCheckAndPostApprove(json);

										toastr[toast_type](full_message, 'INFO');
										tblgaplgtd.ajax.reload(null, false);

									}
								} );
							}
						},
						{ 
							text: '<i class="fa fa-undo"></i>&nbsp;Cancel Approve',
							name: 'btnCancelApprove1',
							className: 'btn btn-sm',
							titleAttr: 'Approve',
							action: function ( e, dt, node, config ) {
								$.ajax( {
									url: '../../../helpers/tr_fn_approve.php',
									dataType: 'json',
									type: 'POST',
									data: {
										approval_state: -1,
										table_name    : table_name_approve,
										id_transaksi  : id_transaksi_approve,
										id_gaplgtd    : id_transaksi_h,
									},
									success: function ( json ) {
										if(json.data.status_code = 200){
											// TODO, sistem approval belum final
											// ini harus dicek apakah approval sudah final
											// script _post_approve hanya dijalankan jika approval sudah final
											url = "../../models/"+selected_folder+"/"+selected_folder+"_post_approve.php";
											$.ajax( {
												url: url,
												dataType: 'json',
												type: 'POST',
												data: {
													id_transaksi: id_transaksi_approve,
													approval_state: -1
												},
												error: function (){
													console.log('File ' + url + ' tidak ada');
												},
												success: function ( json ) {
													console.log(json);
												}
											} );
										}

										tblgaplgtd.ajax.reload(null, false);
									}
								} );
							}
						},
						{
							text: '<i class="fa fa-remove"></i>&nbsp;Void',
							name: 'btnVoid1',
							className: 'btn btn-sm text-danger',
							titleAttr: 'Void',
							action: function ( e, dt, node, config ) {
								$.ajax( {
									url: '../../../helpers/tr_fn_approve.php',
									dataType: 'json',
									type: 'POST',
									data: {
										approval_state: -9,
										table_name    : table_name_approve,
										id_transaksi  : id_transaksi_approve,
										id_gaplgtd    : id_transaksi_h,
									},
									success: function ( json ) {
										if(json.data.status_code = 200){
											// TODO, sistem approval belum final
											// ini harus dicek apakah approval sudah final
											// script _post_approve hanya dijalankan jika approval sudah final
											url = "../../models/"+selected_folder+"/"+selected_folder+"_post_approve.php";
											$.ajax( {
												url: url,
												dataType: 'json',
												type: 'POST',
												data: {
													id_transaksi: id_transaksi_approve,
													approval_state: -9
												},
												error: function (){
													console.log('File ' + url + ' tidak ada');
												},
												success: function ( json ) {
													console.log(json);
												}
											} );
										}

										tblgaplgtd.ajax.reload(null, false);
									}
								} );
							}
						}
					]
				}
				// END buttom Approval Set
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.gaplgtd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.gaplgtd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblgaplgtd.searchPanes.container().appendTo('#spgaplgtd');
		tblgaplgtd.searchBuilder.container().appendTo( '#sbgaplgtd' );
		
		tblgaplgtd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblgaplgtd);
			tblgaplgtd.button( 'btnSetApprove:name' ).disable();
		} );
		
		tblgaplgtd.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('gaplgtd');
			selected_folder = gaplgtd_data.tbl_name;
			table_name_approve = gaplgtd_data.tbl_name;
			id_transaksi_approve = gaplgtd_data.id_transaksi;

			// atur hak akses
			CekSelectHeaderH(tblgaplgtd);

			// BEGIN approval button
			tblgaplgtd.button( 'btnSetApprove:name' ).enable();
			if(approval_state == 1){
				// approve
				tblgaplgtd.button( 'btnApprove1:name' ).disable();
				tblgaplgtd.button( 'btnCancelApprove1:name' ).disable();
				tblgaplgtd.button( 'btnVoid:name' ).enable();
			}else if(approval_state == -1){
				// cancel approve
				tblgaplgtd.button( 'btnApprove1:name' ).enable();
				tblgaplgtd.button( 'btnCancelApprove1:name' ).disable();
				tblgaplgtd.button( 'btnVoid:name' ).enable();
			}else if(approval_state == -9){
				// void
				tblgaplgtd.button( 'btnApprove1:name' ).disable();
				tblgaplgtd.button( 'btnCancelApprove1:name' ).disable();
				tblgaplgtd.button( 'btnVoid:name' ).disable();
			}else{
				// open
				tblgaplgtd.button( 'btnApprove1:name' ).enable();
				tblgaplgtd.button( 'btnCancelApprove1:name' ).disable();
				tblgaplgtd.button( 'btnVoid:name' ).enable();
			}
			// END approval button

		} );

		tblgaplgtd.on( 'deselect', function () {
			siVarReset('gaplgtd');

			// atur hak akses
			CekDeselectHeaderH(tblgaplgtd);

			tblgaplgtd.button( 'btnSetApprove:name' ).disable();
		} );
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
