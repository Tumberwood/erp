<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hosxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhosxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="section"></th>
                                <th data-i18n="department"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hosxxmh/fn/hosxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthosxxmh, tblhosxxmh, show_deleted_hosxxmh = 0, id_hosxxmh;
	// ------------- end of default variable

	var id_hodxxmh_old = 0;
	
	// get tableRelation
	tableRelation('hosxxmh');

	$(document).ready(function() {
		// BEGIN hosxxmh
		edthosxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hosxxmh/hosxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hosxxmh = show_deleted_hosxxmh;
				}
			},
			table: "#tblhosxxmh",
			fields: [ 
				{
					label: "hosxxmh.start_at",
					name: "hosxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hosxxmh.finish_at",
					name: "hosxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hosxxmh",
					type: "hidden"
				},	
				{
					label: "hosxxmh.transaction_state",
					name: "hosxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') +" <sup class='text-danger'>*<sup>",
					name: "hosxxmh.kode"
				}, 	
				{
					label: getTranslation('section') + " <sup class='text-danger'>*<sup>",
					name: "hosxxmh.nama"
				}, 	
				{
					label: getTranslation('department') + " <sup class='text-danger'>*<sup>",
					name: "hosxxmh.id_hodxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh_old: id_hodxxmh_old,
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
					label: getTranslation('notes'),
					name: "hosxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthosxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthosxxmh.field('hosxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhosxxmh.rows().deselect();
				edthosxxmh.field('hosxxmh.kode').enable();
				edthosxxmh.field('hosxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthosxxmh.field('hosxxmh.kode').enable();
					edthosxxmh.field('hosxxmh.nama').enable();
				}else{
					edthosxxmh.field('hosxxmh.kode').disable();
					edthosxxmh.field('hosxxmh.nama').disable();
				}
			}
		});

		edthosxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthosxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthosxxmh.field('hosxxmh.kode').val();
				nama = edthosxxmh.field('hosxxmh.nama').val();
				id_hodxxmh = edthosxxmh.field('hosxxmh.id_hodxxmh').val();

				validasiRequired(
					edthosxxmh,
					'hosxxmh',
					{
						'kode': kode,
						'nama': nama,
						'id_hodxxmh': id_hodxxmh
					}
				);

				validasiUnique(
					action,
					edthosxxmh,
					'hosxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hosxxmh
				);

				validasiUnique(
					action,
					edthosxxmh,
					'hosxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hosxxmh
				);
			}
			
			if ( edthosxxmh.inError() ) {
				return false;
			}
		});
		
		edthosxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthosxxmh.field('hosxxmh.finish_at').val(finish_at);
		});

		edthosxxmh.on( 'close', function () {
			edthosxxmh.enable();
		} );

		tblhosxxmh = $('#tblhosxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hosxxmh/hosxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hosxxmh = show_deleted_hosxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "hosxxmh.id",visible:false },
				{ data: "hosxxmh.kode" },
				{ data: "hosxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ 
					data: "hosxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hosxxmh';
					$table       = 'tblhosxxmh';
					$edt         = 'edthosxxmh';
					$show_status = '_hosxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis','upload'];
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
				if ( data.hosxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hosxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhosxxmh.searchPanes.container().appendTo('#sphosxxmh');
		tblhosxxmh.searchBuilder.container().appendTo( '#sbhosxxmh' );
		
		tblhosxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhosxxmh);
		} );
		
		tblhosxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hosxxmh');
			id_hodxxmh_old 		= hosxxmh_data.id_hodxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhosxxmh);
		} );

		tblhosxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hosxxmh');
			id_hodxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhosxxmh);
		} );

		// END hosxxmh
		
		uploadMaster('hosxxmh', tblhosxxmh, 'files/template_file_upload/Master Section.xlsx');
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
