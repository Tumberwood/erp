<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hacemtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhacemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="date"></th>
                                <th data-i18n="Med Exam Type"></th>
                                <th data-i18n="employee"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hacemtd/fn/hacemtd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthacemtd, tblhacemtd, show_deleted_hacemtd = 0, id_hacemtd;
	var id_hemxxmh_old = 0, id_hactpmh_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hacemtd');

	$(document).ready(function() {
		// BEGIN hacemtd
		edthacemtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hacemtd/hacemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hacemtd = show_deleted_hacemtd;
				}
			},
			table: "#tblhacemtd",
			fields: [ 
				{
					label: "hacemtd.start_at",
					name: "hacemtd.start_at",
					type: "hidden"
				},	
				{
					label: "hacemtd.finish_at",
					name: "hacemtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hacemtd",
					type: "hidden"
				},	
				{
					label: "hacemtd.transaction_state",
					name: "hacemtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('date') + ` <sup class='text-danger'>*<sup>`,
					name: "hacemtd.tanggal",
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
					label: getTranslation('employee') + ` <sup class='text-danger'>*<sup>`,
					name: "hacemtd.id_hemxxmh",
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: getTranslation('Med Exam Type') + ` <sup class='text-danger'>*<sup>`,
					name: "hacemtd.id_hactpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hactpmh/hactpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hactpmh_old: id_hactpmh_old,
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: getTranslation('notes') + ` <sup class='text-danger'>*<sup>`,
					name: "hacemtd.keterangan",
					type: "textarea"
				}
			]
		} );

		edthacemtd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthacemtd.field('hacemtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhacemtd.rows().deselect();
			}
		});

		edthacemtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthacemtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edthacemtd.field('hacemtd.id_hemxxmh').val();
				tanggal = edthacemtd.field('hacemtd.tanggal').val();
				id_hactpmh = edthacemtd.field('hacemtd.id_hactpmh').val();
				keterangan = edthacemtd.field('hacemtd.keterangan').val();

				validasiRequired(
					edthacemtd,
					'hacemtd',
					{
						'id_hemxxmh': id_hemxxmh,
						'tanggal': tanggal,
						'id_hactpmh': id_hactpmh,
						'keterangan': keterangan,
					}
				);
			}
			
			if ( edthacemtd.inError() ) {
				return false;
			}
		});
		
		edthacemtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthacemtd.field('hacemtd.finish_at').val(finish_at);
		});

		edthacemtd.on( 'close', function () {
			edthacemtd.enable();
		} );

		tblhacemtd = $('#tblhacemtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hacemtd/hacemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hacemtd = show_deleted_hacemtd;
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
				{ data: "hacemtd.id",visible:false },
				{ data: "hacemtd.kode" },
				{ data: "hacemtd.tanggal" },
				{ data: "hactpmh.nama" },
				{ data: "hemxxmh_fullname" },
				{ 
					data: "hacemtd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hacemtd';
					$table       = 'tblhacemtd';
					$edt         = 'edthacemtd';
					$show_status = '_hacemtd';
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
				if ( data.hacemtd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hacemtd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhacemtd.searchPanes.container().appendTo('#sphacemtd');
		tblhacemtd.searchBuilder.container().appendTo( '#sbhacemtd' );
		
		tblhacemtd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhacemtd);
		} );
		
		tblhacemtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hacemtd');
			id_hemxxmh_old = hacemtd_data.id_hemxxmh;
			id_hactpmh_old = hacemtd_data.id_hactpmh;

			// atur hak akses
			CekSelectHeaderH(tblhacemtd);
		} );

		tblhacemtd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hacemtd');
			id_hemxxmh_old = 0, id_hactpmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhacemtd);
		} );

		// END hacemtd
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
