<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iwhxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<table id="tbliwhxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Kode</th>
							<th>Nama</th>
							<th>Kategori</th>
							<th>Cabang</th>
							<th>Keterangan</th>
							<th>TX</th>
						</tr>
					</thead>
				</table>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iwhxxmh/fn/iwhxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiwhxxmh, tbliwhxxmh, show_deleted_iwhxxmh = 0, id_iwhxxmh;
	// ------------- end of default variable

	id_iwhctmh_old = 0, id_gbrxxmh_old = 0;

	// get tableRelation
	tableRelation('iwhxxmh');
	
	$(document).ready(function() {
		// BEGIN iwhxxmh
		edtiwhxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iwhxxmh/iwhxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iwhxxmh = show_deleted_iwhxxmh;
				}
			},
			table: "#tbliwhxxmh",
			fields: [ 
				{
					label: "iwhxxmh.start_at",
					name: "iwhxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iwhxxmh.finish_at",
					name: "iwhxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iwhxxmh",
					type: "hidden"
				},	
				{
					label: "iwhxxmh.transaction_state",
					name: "iwhxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "iwhxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "iwhxxmh.nama"
				},
				{
					label: "Kategori <sup class='text-danger'>*<sup>",
					name: "iwhxxmh.id_iwhctmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iwhctmh/iwhctmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iwhctmh_old: id_iwhctmh_old,
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
					label: "Cabang <sup class='text-danger'>*<sup>",
					name: "iwhxxmh.id_gbrxxmh",
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
					name: "iwhxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtiwhxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiwhxxmh.field('iwhxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbliwhxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtiwhxxmh.field('iwhxxmh.kode').enable();
					edtiwhxxmh.field('iwhxxmh.nama').enable();
				}else{
					edtiwhxxmh.field('iwhxxmh.kode').disable();
					edtiwhxxmh.field('iwhxxmh.nama').disable();
				}
			}
		});

		edtiwhxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtiwhxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtiwhxxmh.field('iwhxxmh.kode').val();
				nama = edtiwhxxmh.field('iwhxxmh.nama').val();
				id_iwhctmh = edtiwhxxmh.field('iwhxxmh.id_iwhctmh').val();
				id_gbrxxmh = edtiwhxxmh.field('iwhxxmh.id_gbrxxmh').val();

				validasiRequired(
					edtiwhxxmh,
					'iwhxxmh',
					{
						'kode': kode,
						'nama': nama,
						'id_iwhctmh': id_iwhctmh,
						'id_gbrxxmh': id_gbrxxmh
					}
				);

				validasiUnique(
					action,
					edtiwhxxmh,
					'iwhxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_iwhxxmh
				);

				validasiUnique(
					action,
					edtiwhxxmh,
					'iwhxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_iwhxxmh
				);

			}
			
			if ( edtiwhxxmh.inError() ) {
				return false;
			}
		});
		
		edtiwhxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiwhxxmh.field('iwhxxmh.finish_at').val(finish_at);
		});
		
		edtiwhxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliwhxxmh.ajax.reload(null, false);
		} );

		edtiwhxxmh.on( 'close', function () {
			edtiwhxxmh.enable();
		} );

		tbliwhxxmh = $('#tbliwhxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iwhxxmh/iwhxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iwhxxmh = show_deleted_iwhxxmh;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "iwhxxmh.id",visible:false },
				{ data: "iwhxxmh.kode" },
				{ data: "iwhxxmh.nama" },
				{ data: "iwhctmh.nama" },
				{ data: "gbrxxmh.nama" },
				{ data: "iwhxxmh.keterangan" },
				{ 
					data: "iwhxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iwhxxmh';
					$table       = 'tbliwhxxmh';
					$edt         = 'edtiwhxxmh';
					$show_status = '_iwhxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.iwhxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iwhxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbliwhxxmh.searchPanes.container().appendTo('#spiwhxxmh');
		tbliwhxxmh.searchBuilder.container().appendTo( '#sbiwhxxmh' );
		
		tbliwhxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbliwhxxmh);
		} );
		
		tbliwhxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iwhxxmh');

			id_iwhctmh_old = iwhxxmh_data.id_iwhctmh;
			id_gbrxxmh_old = iwhxxmh_data.id_gbrxxmh;

			// atur hak akses
			CekSelectHeaderH(tbliwhxxmh);
		} );

		tbliwhxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iwhxxmh');
			id_iwhctmh_old = 0, id_gbrxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tbliwhxxmh);
		} );
		
		// END iwhxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
