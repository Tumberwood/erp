<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hpyopth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhpyopth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="name"></th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Tenor</th>
                                <th>Cicilan per Bulan</th>
                                <th>Cicilan Terakhir</th>
                                <th>Mulai Tanggal</th>
                                <th>Berakhir Tanggal</th>
                                <th data-i18n="notes"></th>
                                <th data-i18n="state"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hpyopth/fn/hpyopth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthpyopth, tblhpyopth, show_deleted_hpyopth = 0, id_hpyopth;
	var id_hemxxmh_old = 0;
	var id_hpcxxmh_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hpyopth');

	$(document).ready(function() {
		// BEGIN hpyopth
		edthpyopth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hpyopth/hpyopth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyopth = show_deleted_hpyopth;
				}
			},
			table: "#tblhpyopth",
			fields: [ 
				{
					label: "hpyopth.start_at",
					name: "hpyopth.start_at",
					type: "hidden"
				},	
				{
					label: "hpyopth.finish_at",
					name: "hpyopth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hpyopth",
					type: "hidden"
				},	
				{
					label: "hpyopth.transaction_state",
					name: "hpyopth.transaction_state",
					type: "hidden",
					def: 0
				}, 	
				{
					label: "Karyawan <sup class='text-danger'>*<sup>",
					name: "hpyopth.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
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
					label: "Jenis <sup class='text-danger'>*<sup>",
					name: "hpyopth.id_hpcxxmh",
					fieldInfo: "Hanya tampil Payroll Component dengan flag <b>Other Payroll = Ya<b>",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hpcxxmh/hpcxxmh_fn_other_payroll_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hpcxxmh_old: id_hpcxxmh_old,
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
					label: "Nominal<sup class='text-danger'>*<sup>",
					name: "hpyopth.nominal"
				}, 	{
					label: "Tenor<sup class='text-danger'>*<sup>",
					name: "hpyopth.tenor"
				}, 	{
					label: "Cicilan per Bulan",
					name: "hpyopth.cicilan_per_bulan",
					type: "readonly"
				}, 	{
					label: "Cicilan Terakhir",
					name: "hpyopth.cicilan_terakhir",
					type: "readonly"
				}, 	{
					label: "Mulai Tanggal<sup class='text-danger'>*<sup>",
					name: "hpyopth.tanggal_mulai",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},	 	{
					label: "Berakhir Tanggal",
					name: "hpyopth.tanggal_akhir",
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
					label: getTranslation('notes'),
					name: "hpyopth.keterangan",
					type: "textarea"
				}
			]
		} );

		edthpyopth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpyopth.field('hpyopth.start_at').val(start_at);
			edthpyopth.field('hpyopth.tanggal_akhir').disable();
			
			if(action == 'create'){
				tblhpyopth.rows().deselect();
			}else if(action == 'edit'){
				if(transaction_state == 0){
				}else{
				}
			}
		});

		edthpyopth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthpyopth.dependent( 'hpyopth.nominal', function ( val, data, callback ) {
			if (val > 0) {
				hitung_cicilan();
			}
			return {}
		}, {event: 'keyup change'});

		edthpyopth.dependent( 'hpyopth.tenor', function ( val, data, callback ) {
			if (val > 0) {
				hitung_cicilan();
				hitung_tanggal_akhir();
			}
			return {}
		}, {event: 'keyup change'});

		edthpyopth.dependent( 'hpyopth.tanggal_mulai', function ( val, data, callback ) {
			if (val != null) {
				hitung_tanggal_akhir();
			}
			return {}
		}, {event: 'keyup change'});

		edthpyopth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edthpyopth.field('hpyopth.id_hemxxmh').val();
				keterangan = edthpyopth.field('hpyopth.keterangan').val();
				tanggal_mulai = edthpyopth.field('hpyopth.tanggal_mulai').val();
				nominal = edthpyopth.field('hpyopth.nominal').val();
				tenor = edthpyopth.field('hpyopth.tenor').val();

				validasiRequired(
					edthpyopth,
					'hpyopth',
					{
						'id_hemxxmh': id_hemxxmh,
						'tanggal_mulai': tanggal_mulai,
					}
				);
				
				validasiNumber(
					edthpyopth,
					'hpyopth',
					{
						'nominal': nominal,
						'tenor': tenor,
					},
					0,
					'>'
				);
			}
			
			if ( edthpyopth.inError() ) {
				return false;
			}
		});
		
		edthpyopth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpyopth.field('hpyopth.finish_at').val(finish_at);
		});

		edthpyopth.on( 'close', function () {
			edthpyopth.enable();
		} );

		tblhpyopth = $('#tblhpyopth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hpyopth/hpyopth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyopth = show_deleted_hpyopth;
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
				{ data: "hpyopth.id",visible:false },
				{ data: "hemxxmh_data" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "hpyopth.nominal",
					...renderNumber()
				},
				{ 
					data: "hpyopth.tenor",
					...renderNumber()
				},
				{ 
					data: "hpyopth.cicilan_per_bulan",
					...renderNumber()
				},
				{ 
					data: "hpyopth.cicilan_terakhir",
					...renderNumber()
				},
				{ data: "hpyopth.tanggal_mulai" },
				{ data: "hpyopth.tanggal_akhir" },
				{ data: "hpyopth.keterangan" },
				{ 
					data: "hpyopth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hpyopth';
					$table       = 'tblhpyopth';
					$edt         = 'edthpyopth';
					$show_status = '_hpyopth';
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
				if ( data.hpyopth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hpyopth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhpyopth.searchPanes.container().appendTo('#sphpyopth');
		tblhpyopth.searchBuilder.container().appendTo( '#sbhpyopth' );
		
		tblhpyopth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhpyopth);
		} );
		
		tblhpyopth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hpyopth');
			id_hemxxmh_old      = hpyopth_data.id_hemxxmh;
			id_hpcxxmh_old      = hpyopth_data.id_hpcxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhpyopth);
		} );

		tblhpyopth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hpyopth');
			id_hemxxmh_old = 0;
			id_hpcxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhpyopth);
		} );

		// END hpyopth
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
