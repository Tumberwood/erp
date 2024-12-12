<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hpcxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhpcxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Periode</th>
                                <th>Komp Tetap</th>
                                <!-- <th>Lain-lain</th> -->
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hpcxxmh/fn/hpcxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthpcxxmh, tblhpcxxmh, show_deleted_hpcxxmh = 0, id_hpcxxmh;
	// ------------- end of default variable
	var id_gtbrlsh_old = 0;

	// get tableRelation
	tableRelation('hpcxxmh');		

	$(document).ready(function() {
		
		// BEGIN hpcxxmh
		edthpcxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hpcxxmh/hpcxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpcxxmh = show_deleted_hpcxxmh;
				}
			},
			table: "#tblhpcxxmh",
			fields: [ 
				{
					label: "hpcxxmh.start_at",
					name: "hpcxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hpcxxmh.finish_at",
					name: "hpcxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hpcxxmh",
					type: "hidden"
				},	
				{
					label: "hpcxxmh.transaction_state",
					name: "hpcxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hpcxxmh.kode"
				}, 	{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hpcxxmh.nama"
				}, 	{
					label: "Jenis <sup class='text-danger'>*<sup>",
					name: "hpcxxmh.jenis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Penambah", "value": 1 },
						{ "label": "Pengurang", "value": 2 }
					]
				}, 	{
					label: "Periode <sup class='text-danger'>*<sup>",
					name: "hpcxxmh.periode",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "One Time", "value": "One Time" },
						{ "label": "Jam", "value": "Jam" },
						{ "label": "Harian", "value": "Harian" },
						{ "label": "Mingguan", "value": "Mingguan" },
						{ "label": "Bulanan", "value": "Bulanan" },
						{ "label": "Tahunan", "value": "Tahunan" }
					]
				}, 	{
					label: "Fix / Variable <sup class='text-danger'>*<sup>",
					name: "hpcxxmh.is_fix",
					type: "select",
					placeholder : "Select",
					fieldInfo: "Variable: Akan dikalikan sesuai syarat tertentu.<br>Fix Proporsional: Nilai tetap, akan diproposional kan berdasarkan syarat tertentu.<br>Fix Tanpa Potongan: Nilai tetap tanpa potongan apapun.",
					def: 1,
					options: [
						{ "label": "Variable", "value": 0 },
						{ "label": "Fix Proporsional", "value": 1 },
						{ "label": "Fix Tanpa Potongan", "value": 2 }
					]
				},
				// {
				// 	label: "Lain-lain",
				// 	name: "hpcxxmh.is_lain",
				// 	type: "select",
				// 	placeholder : "Select",
				// 	options: [
				// 		{ "label": "Ya", "value": 1 },
				// 		{ "label": "Tidak", "value": 0 }
				// 	]
				// },	
				{
					label: "Kena Pajak",
					name: "hpcxxmh.is_kena_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},	
				{
					label: "Nominal",
					name: "hpcxxmh.nominal"
				},
				{
					label: "Menu <sup class='text-danger'>*<sup>",
					name: "hpcxxmh.id_gtbrlsh",
					type: "select2",
					fieldInfo: "Menu sumber data komponen payroll",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/gtbrlsh/gtbrlsh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gtbrlsh_old: id_gtbrlsh_old,
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
					name: "hpcxxmh.keterangan",
					type: "textarea"
				},
			]
		} );

		edthpcxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpcxxmh.field('hpcxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhpcxxmh.rows().deselect();
			}
		});

		edthpcxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthpcxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				kode = edthpcxxmh.field('hpcxxmh.kode').val();
				id_gtbrlsh = edthpcxxmh.field('hpcxxmh.id_gtbrlsh').val();
				nama = edthpcxxmh.field('hpcxxmh.nama').val();
				jenis = edthpcxxmh.field('hpcxxmh.jenis').val();
				periode = edthpcxxmh.field('hpcxxmh.periode').val();
				nominal = edthpcxxmh.field('hpcxxmh.nominal').val();

				validasiRequired(
					edthpcxxmh,
					'hpcxxmh',
					{
						'nama': nama,
						'kode': kode,
						'id_gtbrlsh': id_gtbrlsh,
						'jenis': jenis,
						'periode': periode,
						'periode': periode,
					}
				);

				validasiUnique(
					action,
					edthpcxxmh,
					'hpcxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hpcxxmh
				);
				
				validasiUnique(
					action,
					edthpcxxmh,
					'hpcxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hpcxxmh
				);

				validasiNumber(
					edthpcxxmh,
					'hpcxxmh',
					{
						'nominal': nominal
					}
				);
			}
			
			if ( edthpcxxmh.inError() ) {
				return false;
			}
		});
		
		edthpcxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpcxxmh.field('hpcxxmh.finish_at').val(finish_at);
		});

		edthpcxxmh.on( 'close', function () {
			edthpcxxmh.enable();
		} );

		tblhpcxxmh = $('#tblhpcxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hpcxxmh/hpcxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpcxxmh = show_deleted_hpcxxmh;
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
				{ data: "hpcxxmh.id",visible:false },
				{ data: "hpcxxmh.kode" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "hpcxxmh.jenis" ,
					render: function (data){
						if (data == 1){
							return 'Penambah';
						}else if(data == 2){
							return 'Pengurang';
						}else{
							return '<span class="text-danger">Invalid Data</span>';
						}
					}
				},
				{ data: "hpcxxmh.periode" },
				{ 
					data: "hpcxxmh.is_fix" ,
					render: function (data){
						if (data == 1){
							return 'Fix Proporsional';
						}else if(data == 2){
							return 'Fix Tanpa Potongan';
						}else{
							return 'Variable';
						}
					}
				},
				// { 
				// 	data: "hpcxxmh.is_lain" ,
				// 	...renderYaTidak()
				// },
				{ data: "hpcxxmh.keterangan" },
				{ 
					data: "hpcxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hpcxxmh';
					$table       = 'tblhpcxxmh';
					$edt         = 'edthpcxxmh';
					$show_status = '_hpcxxmh';
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
				if ( data.hpcxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hpcxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhpcxxmh.searchPanes.container().appendTo('#sphpcxxmh');
		tblhpcxxmh.searchBuilder.container().appendTo( '#sbhpcxxmh' );
		
		tblhpcxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhpcxxmh);
		} );
		
		tblhpcxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hpcxxmh');
			id_gtbrlsh_old = hpcxxmh_data.id_gtbrlsh;
			// atur hak akses
			CekSelectHeaderH(tblhpcxxmh);
		} );

		tblhpcxxmh.on( 'deselect', function () {
			siVarReset('hpcxxmh');
			id_gtbrlsh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhpcxxmh);
		} );
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
