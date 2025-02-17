<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ggsaksh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblggsaksh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hutang Sementara</th>
                                <th>Persediaan Perjalanan</th>
                                <th>Akun Ekuitas</th>
                                <th>Account Type Persediaan</th>
                                <th>Account Type Biaya</th>
                                <th>Account Type Selisih</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ggsaksh/fn/ggsaksh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtggsaksh, tblggsaksh, show_deleted_ggsaksh = 0, id_ggsaksh;
	var id_aakxxmh_hutang_sementara_old = 0, id_aakxxmh_persediaan_perjalanan_old = 0, ids_aatxxmh_persediaan_old = '', ids_aatxxmh_biaya_old = '', ids_aatxxmh_selisih_old = '';
	var id_aakxxmh_ekuitas_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('ggsaksh');

	$(document).ready(function() {
		// BEGIN ggsaksh
		edtggsaksh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ggsaksh/ggsaksh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggsaksh = show_deleted_ggsaksh;
				}
			},
			table: "#tblggsaksh",
			fields: [ 
				{
					label: "ggsaksh.start_at",
					name: "ggsaksh.start_at",
					type: "hidden"
				},	
				{
					label: "ggsaksh.finish_at",
					name: "ggsaksh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ggsaksh",
					type: "hidden"
				},	
				{
					label: "ggsaksh.transaction_state",
					name: "ggsaksh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Hutang Sementara <sup class='text-danger'>*<sup>",
					name: "ggsaksh.id_aakxxmh_hutang_sementara",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_hutang_sementara_old,
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
					label: "Persediaan Perjalanan <sup class='text-danger'>*<sup>",
					name: "ggsaksh.id_aakxxmh_persediaan_perjalanan",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_persediaan_perjalanan_old,
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
					label: "Ekuitas <sup class='text-danger'>*<sup>",
					name: "ggsaksh.id_aakxxmh_ekuitas",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_child.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_ekuitas_old,
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
					label: 'Account Type Persediaan <sup class="text-danger">*</sup>',
					name: "aatxxmh_persediaan[].id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/aatxxmh/aatxxmh_fn_opt_multiple.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									ids_aatxxmh_old: ids_aatxxmh_persediaan_old,
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
					label: 'Account Type Biaya <sup class="text-danger">*</sup>',
					name: "aatxxmh_biaya[].id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/aatxxmh/aatxxmh_fn_opt_multiple.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									ids_aatxxmh_old: ids_aatxxmh_biaya_old,
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
					label: 'Account Type Selisih <sup class="text-danger">*</sup>',
					name: "aatxxmh_selisih[].id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/aatxxmh/aatxxmh_fn_opt_multiple.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									ids_aatxxmh_old: ids_aatxxmh_selisih_old,
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

		edtggsaksh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggsaksh.field('ggsaksh.start_at').val(start_at);
			
			if(action == 'create'){
				tblggsaksh.rows().deselect();
			}
		});

		edtggsaksh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtggsaksh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh_persediaan_perjalanan = edtggsaksh.field('ggsaksh.id_aakxxmh_persediaan_perjalanan').val();
				id_aakxxmh_ekuitas = edtggsaksh.field('ggsaksh.id_aakxxmh_ekuitas').val();
				id_aakxxmh_hutang_sementara = edtggsaksh.field('ggsaksh.id_aakxxmh_hutang_sementara').val();
				id_aatxxmh_persediaan = edtggsaksh.field('aatxxmh_persediaan[].id').val();
				id_aatxxmh_biaya = edtggsaksh.field('aatxxmh_biaya[].id').val();
				id_aatxxmh_selisih = edtggsaksh.field('aatxxmh_selisih[].id').val();

				validasiRequired(
					edtggsaksh,
					'ggsaksh',
					{
						'id_aakxxmh_persediaan_perjalanan': id_aakxxmh_persediaan_perjalanan,
						'id_aakxxmh_ekuitas': id_aakxxmh_ekuitas,
						'id_aakxxmh_hutang_sementara': id_aakxxmh_hutang_sementara,
					}
				);

				
				if(!id_aatxxmh_persediaan || id_aatxxmh_persediaan == ''){
					edtggsaksh.field('aatxxmh_persediaan[].id').error( 'Wajib diisi!' );
				}
				
				if(!id_aatxxmh_biaya || id_aatxxmh_biaya == ''){
					edtggsaksh.field('aatxxmh_biaya[].id').error( 'Wajib diisi!' );
				}
				
				if(!id_aatxxmh_selisih || id_aatxxmh_selisih == ''){
					edtggsaksh.field('aatxxmh_selisih[].id').error( 'Wajib diisi!' );
				}
			}
			
			if ( edtggsaksh.inError() ) {
				return false;
			}
		});
		
		edtggsaksh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggsaksh.field('ggsaksh.finish_at').val(finish_at);
		});

		edtggsaksh.on( 'close', function () {
			edtggsaksh.enable();
		} );

		tblggsaksh = $('#tblggsaksh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ggsaksh/ggsaksh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggsaksh = show_deleted_ggsaksh;
				}
			},
			order: [[ 1, "asc" ]],
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
				{ data: "ggsaksh.id",visible:false },
				{ data: "hutang_sementara.nama" },
				{ data: "persediaan_perjalanan.nama" },
				{ data: "ekuitas.nama" },
				{ data: "aatxxmh_persediaan[].nama" },
				{ data: "aatxxmh_biaya[].nama" },
				{ data: "aatxxmh_selisih[].nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ggsaksh';
					$table       = 'tblggsaksh';
					$edt         = 'edtggsaksh';
					$show_status = '_ggsaksh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['edit', 'confirm','view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.ggsaksh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ggsaksh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblggsaksh.searchPanes.container().appendTo('#spggsaksh');
		tblggsaksh.searchBuilder.container().appendTo( '#sbggsaksh' );
		
		tblggsaksh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblggsaksh);
		} );
		
		tblggsaksh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ggsaksh');
			id_aakxxmh_hutang_sementara_old = ggsaksh_data.id_aakxxmh_hutang_sementara;
			id_aakxxmh_persediaan_perjalanan_old = ggsaksh_data.id_aakxxmh_persediaan_perjalanan;
			id_aakxxmh_ekuitas_old = ggsaksh_data.id_aakxxmh_ekuitas;

			tblggsaksh.rows( { selected: true } ).data().each(function (row) {
				if (row.aatxxmh_persediaan) {
					ids_aatxxmh_persediaan_old = "";
					row.aatxxmh_persediaan.forEach(function (aatxxmh_persediaan_data) {
						ids_aatxxmh_persediaan_old = ids_aatxxmh_persediaan_old + "," + aatxxmh_persediaan_data.id;
					});
					ids_aatxxmh_persediaan_old = ids_aatxxmh_persediaan_old.substring(1);
				}

				if (row.aatxxmh_biaya) {
					ids_aatxxmh_biaya_old = "";
					row.aatxxmh_biaya.forEach(function (aatxxmh_biaya_data) {
						ids_aatxxmh_biaya_old = ids_aatxxmh_biaya_old + "," + aatxxmh_biaya_data.id;
					});
					ids_aatxxmh_biaya_old = ids_aatxxmh_biaya_old.substring(1);
				}

				if (row.aatxxmh_selisih) {
					ids_aatxxmh_selisih_old = "";
					row.aatxxmh_selisih.forEach(function (aatxxmh_selisih_data) {
						ids_aatxxmh_selisih_old = ids_aatxxmh_selisih_old + "," + aatxxmh_selisih_data.id;
					});
					ids_aatxxmh_selisih_old = ids_aatxxmh_selisih_old.substring(1);
				}
			});
			// atur hak akses
			CekSelectHeaderH(tblggsaksh);
		} );

		tblggsaksh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ggsaksh');
			id_aakxxmh_hutang_sementara_old = 0;
			id_aakxxmh_persediaan_perjalanan_old = 0;
			id_aakxxmh_ekuitas_old = 0;
			ids_aatxxmh_persediaan_old = '';
			ids_aatxxmh_biaya_old = '';
			ids_aatxxmh_selisih_old = '';

			// atur hak akses
			CekDeselectHeaderH(tblggsaksh);
		} );

		// END ggsaksh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
