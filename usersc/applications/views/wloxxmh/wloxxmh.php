<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wloxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwloxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Warehouse</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Zone</th>
                                <th>TX</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wloxxmh/fn/wloxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtwloxxmh, tblwloxxmh, show_deleted_wloxxmh = 0, id_wloxxmh;
		// ------------- end of default variable

		var id_iwhxxmh_old = 0, id_wloctmh_old = 0, id_wlotpmh_old = 0, id_wloznmh_old = 0;

		// get tableRelation
		tableRelation('wloxxmh');
		
		$(document).ready(function() {
			// BGIN wloxxmh
			edtwloxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/wloxxmh/wloxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wloxxmh = show_deleted_wloxxmh;
					}
				},
				table: "#tblwloxxmh",
				fields: [ 
					{
						label: "wloxxmh.start_at",
						name: "wloxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "wloxxmh.finish_at",
						name: "wloxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "wloxxmh",
						type: "hidden"
					},	
					{
						label: "wloxxmh.transaction_state",
						name: "wloxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "wloxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "wloxxmh.nama"
					},	
					{
						label: "Warehouse<sup class='text-danger'>*<sup>",
						name: "wloxxmh.id_iwhxxmh",
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
						label: "Location Category",
						name: "wloxxmh.id_wloctmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/wloctmh/wloctmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_wloctmh_old: id_wloctmh_old,
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
						label: "Location Type",
						name: "wloxxmh.id_wlotpmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/wlotpmh/wlotpmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_wlotpmh_old: id_wlotpmh_old,
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
						label: "Location Zone",
						name: "wloxxmh.id_wloznmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/wloznmh/wloznmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_wloznmh_old: id_wloznmh_old,
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
						name: "wloxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtwloxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwloxxmh.field('wloxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblwloxxmh.rows().deselect();

					edtwloxxmh.field('wloxxmh.kode').enable();
					edtwloxxmh.field('wloxxmh.nama').enable();
					edtwloxxmh.field('wloxxmh.id_iwhxxmh').enable();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtwloxxmh.field('wloxxmh.kode').enable();
						edtwloxxmh.field('wloxxmh.nama').enable();
						edtwloxxmh.field('wloxxmh.id_iwhxxmh').enable();
					}else{
						edtwloxxmh.field('wloxxmh.kode').disable();
						edtwloxxmh.field('wloxxmh.nama').disable();
						edtwloxxmh.field('wloxxmh.id_iwhxxmh').disable();
					}

					
				}
			});

			edtwloxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtwloxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					id_iwhxxmh = edtwloxxmh.field('wloxxmh.id_iwhxxmh').val();
					kode       = edtwloxxmh.field('wloxxmh.kode').val();
					nama       = edtwloxxmh.field('wloxxmh.nama').val();

					validasiRequired(
						edtwloxxmh,
						'wloxxmh',
						{
							'id_iwhxxmh': id_iwhxxmh,
							'kode': kode,
							'nama': nama
						}
					);

					/**
					 * ini harusnya ada kondisi OR
					 * perlu bikin custom validation unique, tidak bisa menggunakan validasiUnique
					 * yang tidak boleh kembar adalah kombinasi :
					 * 	kode, nama, warehouse
					 * 	kode dan warehouse, atau nama dan warehouse
					 */
					validasiUnique(
						action,
						edtwloxxmh,
						'wloxxmh',
						'kode',
						'kode,nama,id_iwhxxmh',
						'"'+kode+'","'+nama+'",'+id_iwhxxmh,
						id_wloxxmh
					);

				}
				
				if ( edtwloxxmh.inError() ) {
					return false;
				}
			});
			
			edtwloxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwloxxmh.field('wloxxmh.finish_at').val(finish_at);
			});

			edtwloxxmh.on( 'close', function () {
				edtwloxxmh.enable();
			} );

			tblwloxxmh = $('#tblwloxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/wloxxmh/wloxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wloxxmh = show_deleted_wloxxmh;
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
					{ data: "wloxxmh.id",visible:false },
					{ data: "wloxxmh.kode" },
					{ data: "wloxxmh.nama" },
					{ data: "iwhxxmh.nama" },
					{ data: "wloctmh.nama" },
					{ data: "wlotpmh.nama" },
					{ data: "wloznmh.nama" },
					{ 
						data: "wloxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wloxxmh';
						$table       = 'tblwloxxmh';
						$edt         = 'edtwloxxmh';
						$show_status = '_wloxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.wloxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.wloxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblwloxxmh.searchPanes.container().appendTo('#spwloxxmh');
			tblwloxxmh.searchBuilder.container().appendTo( '#sbwloxxmh' );
			
			tblwloxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwloxxmh);
			} );
			
			tblwloxxmh.on( 'select', function( e, dt, type, indexes ) {
				wloxxmh_data      = tblwloxxmh.row( { selected: true } ).data().wloxxmh;
				id_wloxxmh        = wloxxmh_data.id;
				id_transaksi_h    = id_wloxxmh;                                           // dipakai untuk general
				id_transaksi_log  = id_wloxxmh;                                           // dipakai untuk general
				transaction_state = wloxxmh_data.transaction_state;
				approval_state    = wloxxmh_data.approval_state;
				is_nextprocess    = wloxxmh_data.is_nextprocess;
				id_iwhxxmh_old    = wloxxmh_data.id_iwhxxmh;
				id_wloctmh_old    = wloxxmh_data.id_wloctmh;
				id_wlotpmh_old    = wloxxmh_data.id_wlotpmh;
				id_wloznmh_old    = wloxxmh_data.id_wloznmh;

				// atur hak akses
				CekSelectHeaderH(tblwloxxmh);
			} );

			tblwloxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_wloxxmh = 0;
				id_iwhxxmh_old = 0, id_wloctmh_old = 0, id_wlotpmh_old = 0, id_wloznmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblwloxxmh);
			} );
			
			// END wloxxmh

		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
