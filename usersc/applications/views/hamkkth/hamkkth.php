<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hamkkth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhamkkth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Kontrak</th>
                                <th>Tanggal Kontrak</th>
                                <th>Nama Karyawan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hamkkth/fn/hamkkth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthamkkth, tblhamkkth, show_deleted_hamkkth = 0, id_hamkkth;
	// ------------- end of default variable
	
	var id_hemxxmh_old = 0, id_hamkkth_atasan_old = 0;

	// get tableRelation
	tableRelation('hamkkth');

	$(document).ready(function() {
		// BEGIN hamkkth
		edthamkkth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hamkkth/hamkkth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hamkkth = show_deleted_hamkkth;
				}
			},
			table: "#tblhamkkth",
			fields: [ 
				{
					label: "hamkkth.start_at",
					name: "hamkkth.start_at",
					type: "hidden"
				},	
				{
					label: "hamkkth.finish_at",
					name: "hamkkth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hamkkth",
					type: "hidden"
				},	
				{
					label: "hamkkth.transaction_state",
					name: "hamkkth.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Nama Karyawan <sup class='text-danger'>*<sup>",
					name: "hamkkth.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt_kontrak_kerja.php",
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
					name: "hamkkth.jenis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Probation", "value": "Probation" },
						{ "label": "PKWT", "value": "PKWT" },
						{ "label": "PKWTT", "value": "PKWTT" },
					]
				},
				{
					label: "Tanggal Mulai <sup class='text-danger'>*<sup>",
					name: "hamkkth.tanggal_mulai",
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
					label: "Tanggal Selesai",
					name: "hamkkth.tanggal_selesai",
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
					name: "hamkkth.keterangan",
					type: "textarea"
				}
			]
		} );

		edthamkkth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthamkkth.field('hamkkth.start_at').val(start_at);
			
			if(action == 'create'){
				tblhamkkth.rows().deselect();
			}
		});

		edthamkkth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthamkkth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				jenis              = edthamkkth.field('hamkkth.jenis').val();
				tanggal_mulai              = edthamkkth.field('hamkkth.tanggal_mulai').val();
				id_hemxxmh        = edthamkkth.field('hamkkth.id_hemxxmh').val();

				validasiRequired(
					edthamkkth,
					'hamkkth',
					{
						'jenis': jenis,
						'tanggal_mulai': tanggal_mulai,
						'id_hemxxmh': id_hemxxmh,
					}
				);
			}
			
			if ( edthamkkth.inError() ) {
				return false;
			}
		});
		
		edthamkkth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthamkkth.field('hamkkth.finish_at').val(finish_at);
		});

		edthamkkth.on( 'close', function () {
			edthamkkth.enable();
		} );

		tblhamkkth = $('#tblhamkkth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hamkkth/hamkkth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hamkkth = show_deleted_hamkkth;
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
				{ data: "hamkkth.id",visible:false },
				{ data: "hamkkth.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hamkkth.tanggal_mulai" },
				{ 
					data: "hamkkth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hamkkth';
					$table       = 'tblhamkkth';
					$edt         = 'edthamkkth';
					$show_status = '_hamkkth';
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
				if ( data.hamkkth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hamkkth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhamkkth.searchPanes.container().appendTo('#sphamkkth');
		tblhamkkth.searchBuilder.container().appendTo( '#sbhamkkth' );
		
		tblhamkkth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhamkkth);
		} );
		
		tblhamkkth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hamkkth');
			id_hemxxmh_old        = hamkkth_data.id_hemxxmh;
			id_hamkkth_atasan_old = hamkkth_data.id_hamkkth_atasan;

			// atur hak akses
			CekSelectHeaderH(tblhamkkth);
		} );

		tblhamkkth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hamkkth');
			id_hemxxmh_old = 0, id_hamkkth_atasan_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhamkkth);
		} );

		// END hamkkth
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
