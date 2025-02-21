<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hfoxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhfoxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="group"></th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfoxxmh/fn/hfoxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthfoxxmh, tblhfoxxmh, show_deleted_hfoxxmh = 0, id_hfoxxmh;
	// ------------- end of default variable
	var id_hfogrmh_old = 0;
	
	// get tableRelation
	tableRelation('hfoxxmh');

	$(document).ready(function() {
		// BEGIN hfoxxmh
		edthfoxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfoxxmh/hfoxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfoxxmh = show_deleted_hfoxxmh;
				}
			},
			table: "#tblhfoxxmh",
			fields: [ 
				{
					label: "hfoxxmh.start_at",
					name: "hfoxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hfoxxmh.finish_at",
					name: "hfoxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfoxxmh",
					type: "hidden"
				},	
				{
					label: "hfoxxmh.transaction_state",
					name: "hfoxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "hfoxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hfoxxmh.nama"
				}, 	
				{
					label: getTranslation('group') + "<sup class='text-danger'>*<sup>",
					name: "hfoxxmh.id_hfogrmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfogrmh/hfogrmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfogrmh_old: id_hfogrmh_old,
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
					name: "hfoxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthfoxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfoxxmh.field('hfoxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhfoxxmh.rows().deselect();
				edthfoxxmh.field('hfoxxmh.nama').enable();
				edthfoxxmh.field('hfoxxmh.kode').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthfoxxmh.field('hfoxxmh.nama').enable();
					edthfoxxmh.field('hfoxxmh.kode').enable();
				}else{
					edthfoxxmh.field('hfoxxmh.nama').disable();
					edthfoxxmh.field('hfoxxmh.kode').disable();
				}
			}
		});

		edthfoxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthfoxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edthfoxxmh.field('hfoxxmh.nama').val();
				kode = edthfoxxmh.field('hfoxxmh.kode').val();
				id_hfogrmh = edthfoxxmh.field('hfoxxmh.id_hfogrmh').val();

				validasiRequired(
					edthfoxxmh,
					'hfoxxmh',
					{
						'nama': nama,
						'kode': kode,
						'id_hfogrmh': id_hfogrmh,
					}
				);

				validasiUnique(
					action,
					edthfoxxmh,
					'hfoxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hfoxxmh
				);

				validasiUnique(
					action,
					edthfoxxmh,
					'hfoxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hfoxxmh
				);
			}
			
			if ( edthfoxxmh.inError() ) {
				return false;
			}
		});
		
		edthfoxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfoxxmh.field('hfoxxmh.finish_at').val(finish_at);
		});

		edthfoxxmh.on( 'close', function () {
			edthfoxxmh.enable();
		} );

		tblhfoxxmh = $('#tblhfoxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-1',
			},
			ajax: {
				url: "../../models/hfoxxmh/hfoxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfoxxmh = show_deleted_hfoxxmh;
				}
			},
			order: [[ 2, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "hfoxxmh.id",visible:false },
				{ data: "hfogrmh.nama" },
				{ data: "hfoxxmh.kode" },
				{ data: "hfoxxmh.nama" },
				{ 
					data: "hfoxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfoxxmh';
					$table       = 'tblhfoxxmh';
					$edt         = 'edthfoxxmh';
					$show_status = '_hfoxxmh';
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
				if ( data.hfoxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfoxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfoxxmh.searchPanes.container().appendTo('#sphfoxxmh');
		tblhfoxxmh.searchBuilder.container().appendTo( '#sbhfoxxmh' );
		
		tblhfoxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhfoxxmh);
		} );
		
		tblhfoxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfoxxmh');
			id_hfogrmh_old = hfoxxmh_data.id_hfogrmh;

			// atur hak akses
			CekSelectHeaderH(tblhfoxxmh);
		} );

		tblhfoxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfoxxmh');
			id_hfogrmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhfoxxmh);
		} );

		// END hfoxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
