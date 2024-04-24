<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'httgltd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhttgltd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httgltd/fn/httgltd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthttgltd, tblhttgltd, show_deleted_httgltd = 0, id_httgltd;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('httgltd');
		var kategori_dokumen = "";
		var kategori_dokumen_value = "";

		$(document).ready(function() {
			// BEGIN httgltd
			edthttgltd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/httgltd/httgltd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_httgltd = show_deleted_httgltd;
					}
				},
				table: "#tblhttgltd",
				fields: [ 
					{
						label: "httgltd.start_at",
						name: "httgltd.start_at",
						type: "hidden"
					},	
					{
						label: "httgltd.finish_at",
						name: "httgltd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "httgltd",
						type: "hidden"
					},	
					{
						label: "httgltd.transaction_state",
						name: "httgltd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Tanggal",
						name: "httgltd.tanggal",
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
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "httgltd.nama"
					}, 	
					{
						label: "Keterangan",
						name: "httgltd.keterangan",
						type: "textarea"
					}
				]
			} );

			edthttgltd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthttgltd.field('httgltd.start_at').val(start_at);
				
				if(action == 'create'){
					tblhttgltd.rows().deselect();
				}
			});

			edthttgltd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthttgltd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					tanggal = edthttgltd.field('httgltd.tanggal').val();
					tanggal_ymd = moment(tanggal).format("YYYY-MM-DD");
					nama = edthttgltd.field('httgltd.nama').val();

					validasiRequired(
						edthttgltd,
						'httgltd',
						{
							'tanggal': tanggal,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edthttgltd,
						'httgltd',
						'tanggal',
						'tanggal',
						'"'+tanggal_ymd+'"',
						id_httgltd
					);

					validasiUnique(
						action,
						edthttgltd,
						'httgltd',
						'nama',
						'nama',
						'"'+nama+'"',
						id_httgltd
					);
				}
				
				if ( edthttgltd.inError() ) {
					return false;
				}
			});
			
			edthttgltd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthttgltd.field('httgltd.finish_at').val(finish_at);
			});

			edthttgltd.on( 'close', function () {
				edthttgltd.enable();
			} );

			tblhttgltd = $('#tblhttgltd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/httgltd/httgltd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_httgltd = show_deleted_httgltd;
					}
				},
				order: [[ 1, "asc" ]],
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
					{ data: "httgltd.id",visible:false },
					{ data: "httgltd.tanggal" },
					{ data: "httgltd.kode" },
					{ data: "httgltd.nama" },
					{ data: "httgltd.keterangan" },
					{ 
						data: "httgltd.transaction_state" ,
						...renderTransactionStatus()
					},
					{ 
						data: "httgltd.approval_state" ,
						...renderApprovalStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_httgltd';
						$table       = 'tblhttgltd';
						$edt         = 'edthttgltd';
						$show_status = '_httgltd';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
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
									$.ajax( {
										url: '../../models/httgltd/httgltd_post_approve.php',
										dataType: 'json',
										type: 'POST',
										data: {
											state           : 1,
                        					id_transaksi_h  : id_transaksi_h
										},
										success: function ( json ) {
											tblhttgltd.ajax.reload(null, false);
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
										url: '../../models/httgltd/httgltd_post_approve.php',
										dataType: 'json',
										type: 'POST',
										data: {
											state           : -1,
                        					id_transaksi_h  : id_transaksi_h
										},
										success: function ( json ) {
											tblhttgltd.ajax.reload(null, false);
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
										url: '../../models/httgltd/httgltd_post_approve.php',
										dataType: 'json',
										type: 'POST',
										data: {
											state           : -9,
                        					id_transaksi_h  : id_transaksi_h
										},
										success: function ( json ) {
											tblhttgltd.ajax.reload(null, false);
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
					if ( data.httgltd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.httgltd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhttgltd.searchPanes.container().appendTo('#sphttgltd');
			tblhttgltd.searchBuilder.container().appendTo( '#sbhttgltd' );
			
			tblhttgltd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhttgltd);
				tblhttgltd.button( 'btnSetApprove:name' ).disable();
			} );
			
			tblhttgltd.on( 'select', function( e, dt, type, indexes ) {
				httgltd_data    		= tblhttgltd.row( { selected: true } ).data().httgltd;
				id_httgltd      		= httgltd_data.id;
				id_transaksi_h 		= id_httgltd; // dipakai untuk general
				id_transaksi_log	= id_httgltd; // dipakai untuk general
				transaction_state   = httgltd_data.transaction_state;
				approval_state   	= httgltd_data.approval_state;
				is_nextprocess 		= httgltd_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblhttgltd);

				// BEGIN approval button
				tblhttgltd.button( 'btnSetApprove:name' ).enable();
				if(approval_state == 1){
					// approve
					tblhttgltd.button( 'btnApprove1:name' ).disable();
					tblhttgltd.button( 'btnCancelApprove1:name' ).enable();
					tblhttgltd.button( 'btnVoid1:name' ).disable();
				}else if(approval_state == -1){
					// cancel approve
					tblhttgltd.button( 'btnApprove1:name' ).enable();
					tblhttgltd.button( 'btnCancelApprove1:name' ).disable();
					tblhttgltd.button( 'btnVoid1:name' ).disable();
				}else if(approval_state == -9){
					// void
					tblhttgltd.button( 'btnApprove1:name' ).disable();
					tblhttgltd.button( 'btnCancelApprove1:name' ).disable();
					tblhttgltd.button( 'btnVoid1:name' ).disable();
				}else{
					// open
					tblhttgltd.button( 'btnApprove1:name' ).enable();
					tblhttgltd.button( 'btnCancelApprove1:name' ).disable();
					tblhttgltd.button( 'btnVoid1:name' ).enable();
				}
				// END approval button
			} );

			tblhttgltd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_httgltd = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhttgltd);
				tblhttgltd.button( 'btnSetApprove:name' ).disable();
			} );

			// END httgltd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
