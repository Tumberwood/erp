<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'nirxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblnirxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Category</th>
                                <th>Building</th>
                                <th>Keterangan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/nirxxmh/fn/nirxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtnirxxmh, tblnirxxmh, show_deleted_nirxxmh = 0, id_nirxxmh;
	// ------------- end of default variable
	
	id_nirctmh_old = 0, id_nibxxmh_old = 0;
	
	// get tableRelation
	tableRelation('nirxxmh');

	$(document).ready(function() {
		// BEGIN nirxxmh
		edtnirxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/nirxxmh/nirxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_nirxxmh = show_deleted_nirxxmh;
				}
			},
			table: "#tblnirxxmh",
			fields: [ 
				{
					label: "nirxxmh.start_at",
					name: "nirxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "nirxxmh.finish_at",
					name: "nirxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "nirxxmh",
					type: "hidden"
				},	
				{
					label: "nirxxmh.transaction_state",
					name: "nirxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "nirxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "nirxxmh.nama"
				}, 	
				{
					label: "Room Category",
					name: "nirxxmh.id_nirctmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/nirctmh/nirctmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_nirctmh_old: id_nirctmh_old,
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
					label: "Building",
					name: "nirxxmh.id_nibxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/nibxxmh/nibxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_nibxxmh_old: id_nibxxmh_old,
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
					name: "nirxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtnirxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtnirxxmh.field('nirxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblnirxxmh.rows().deselect();
				edtnirxxmh.field('nirxxmh.kode').enable();
				edtnirxxmh.field('nirxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtnirxxmh.field('nirxxmh.kode').enable();
					edtnirxxmh.field('nirxxmh.nama').enable();
				}else{
					edtnirxxmh.field('nirxxmh.kode').disable();
					edtnirxxmh.field('nirxxmh.nama').disable();
				}
			}
		});

		edtnirxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirm();
		});

		edtnirxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtnirxxmh.field('nirxxmh.kode').val();
				nama = edtnirxxmh.field('nirxxmh.nama').val();
				id_nibxxmh = edtnirxxmh.field('nirxxmh.id_nibxxmh').val();

				validasiRequired(
					edtnirxxmh,
					'nirxxmh',
					{
						'kode': kode,
						'nama': nama,
						'id_nibxxmh': id_nibxxmh
					}
				);

				validasiUnique(
					action,
					edtnirxxmh,
					'nirxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_nirxxmh
				);

				validasiUnique(
					action,
					edtnirxxmh,
					'nirxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_nirxxmh
				);
			}
			
			if ( edtnirxxmh.inError() ) {
				return false;
			}
		});
		
		edtnirxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtnirxxmh.field('nirxxmh.finish_at').val(finish_at);
		});

		edtnirxxmh.on( 'close', function () {
			edtnirxxmh.enable();
		} );

		tblnirxxmh = $('#tblnirxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/nirxxmh/nirxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_nirxxmh = show_deleted_nirxxmh;
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
				{ data: "nirxxmh.id",visible:false },
				{ data: "nirxxmh.kode" },
				{ data: "nirxxmh.nama" },
				{ data: "nirctmh.nama" },
				{ data: "nibxxmh.nama" },
				{ data: "nirxxmh.keterangan" },
				{ 
					data: "nirxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_nirxxmh';
					$table       = 'tblnirxxmh';
					$edt         = 'edtnirxxmh';
					$show_status = '_nirxxmh';
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
				if ( data.nirxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.nirxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblnirxxmh.searchPanes.container().appendTo('#spnirxxmh');
		tblnirxxmh.searchBuilder.container().appendTo( '#sbnirxxmh' );
		
		tblnirxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblnirxxmh);
		} );
		
		tblnirxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('nirxxmh');

			id_nirctmh_old 		= nirxxmh_data.id_nirctmh;
			id_nibxxmh_old 		= nirxxmh_data.id_nibxxmh;

			// atur hak akses
			CekSelectHeaderH(tblnirxxmh);
		} );

		tblnirxxmh.on( 'deselect', function () {
			siVarReset('nirxxmh');

			id_nirctmh_old = 0;
			id_nibxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblnirxxmh);
		} );

		// END nirxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
