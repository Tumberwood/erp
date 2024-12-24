<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hpyoptd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhpyoptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="name"></th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hpyoptd/fn/hpyoptd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthpyoptd, tblhpyoptd, show_deleted_hpyoptd = 0, id_hpyoptd;
	var id_hemxxmh_old = 0;
	var id_hpcxxmh_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hpyoptd');

	$(document).ready(function() {
		// BEGIN hpyoptd
		edthpyoptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hpyoptd/hpyoptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyoptd = show_deleted_hpyoptd;
				}
			},
			table: "#tblhpyoptd",
			fields: [ 
				{
					label: "hpyoptd.start_at",
					name: "hpyoptd.start_at",
					type: "hidden"
				},	
				{
					label: "hpyoptd.finish_at",
					name: "hpyoptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hpyoptd",
					type: "hidden"
				},	
				{
					label: "hpyoptd.transaction_state",
					name: "hpyoptd.transaction_state",
					type: "hidden",
					def: 0
				}, 	
				{
					label: "Karyawan <sup class='text-danger'>*<sup>",
					name: "hpyoptd.id_hemxxmh",
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
					name: "hpyoptd.id_hpcxxmh",
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
					name: "hpyoptd.nominal"
				},
				{
					label: "Tanggal<sup class='text-danger'>*<sup>",
					name: "hpyoptd.tanggal",
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
					name: "hpyoptd.keterangan",
					type: "textarea"
				}
			]
		} );

		edthpyoptd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpyoptd.field('hpyoptd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhpyoptd.rows().deselect();
			}else if(action == 'edit'){
				if(transaction_state == 0){
				}else{
				}
			}
		});

		edthpyoptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthpyoptd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edthpyoptd.field('hpyoptd.id_hemxxmh').val();
				keterangan = edthpyoptd.field('hpyoptd.keterangan').val();
				tanggal = edthpyoptd.field('hpyoptd.tanggal').val();
				nominal = edthpyoptd.field('hpyoptd.nominal').val();

				validasiRequired(
					edthpyoptd,
					'hpyoptd',
					{
						'id_hemxxmh': id_hemxxmh,
						'tanggal': tanggal,
					}
				);
				
				validasiNumber(
					edthpyoptd,
					'hpyoptd',
					{
						'nominal': nominal,
					},
					0,
					'>'
				);
			}
			
			if ( edthpyoptd.inError() ) {
				return false;
			}
		});
		
		edthpyoptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpyoptd.field('hpyoptd.finish_at').val(finish_at);
		});

		edthpyoptd.on( 'close', function () {
			edthpyoptd.enable();
		} );

		tblhpyoptd = $('#tblhpyoptd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hpyoptd/hpyoptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyoptd = show_deleted_hpyoptd;
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
				{ data: "hpyoptd.id",visible:false },
				{ data: "hemxxmh_data" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "hpyoptd.nominal",
					...renderNumber()
				},
				{ data: "hpyoptd.tanggal" },
				{ data: "hpyoptd.keterangan" },
				{ 
					data: "hpyoptd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hpyoptd';
					$table       = 'tblhpyoptd';
					$edt         = 'edthpyoptd';
					$show_status = '_hpyoptd';
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
				if ( data.hpyoptd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hpyoptd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhpyoptd.searchPanes.container().appendTo('#sphpyoptd');
		tblhpyoptd.searchBuilder.container().appendTo( '#sbhpyoptd' );
		
		tblhpyoptd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhpyoptd);
		} );
		
		tblhpyoptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hpyoptd');
			id_hemxxmh_old      = hpyoptd_data.id_hemxxmh;
			id_hpcxxmh_old      = hpyoptd_data.id_hpcxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhpyoptd);
		} );

		tblhpyoptd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hpyoptd');
			id_hemxxmh_old = 0;
			id_hpcxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhpyoptd);
		} );

		// END hpyoptd
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
