<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'havxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhavxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggaran</th>
                                <th>Saran Tindakan</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/havxxmh/fn/havxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthavxxmh, tblhavxxmh, show_deleted_havxxmh = 0, id_havxxmh;
	// ------------- end of default variable
	
	var id_hadxxmh_old = 0;

	// get tableRelation
	tableRelation('havxxmh');

	$(document).ready(function() {
		// BEGIN havxxmh
		edthavxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/havxxmh/havxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_havxxmh = show_deleted_havxxmh;
				}
			},
			table: "#tblhavxxmh",
			fields: [ 
				{
					label: "havxxmh.start_at",
					name: "havxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "havxxmh.finish_at",
					name: "havxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "havxxmh",
					type: "hidden"
				},	
				{
					label: "havxxmh.transaction_state",
					name: "havxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Pelanggaran <sup class='text-danger'>*<sup>",
					name: "havxxmh.nama"
				},
				{
					label: "Saran Tindakan <sup class='text-danger'>*<sup>",
					name: "havxxmh.id_hadxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hadxxmh/hadxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hadxxmh_old: id_hadxxmh_old,
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
					name: "havxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthavxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthavxxmh.field('havxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhavxxmh.rows().deselect();
				edthavxxmh.field('havxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthavxxmh.field('havxxmh.nama').enable();
				}else{
					edthavxxmh.field('havxxmh.nama').disable();
				}
			}
		});

		edthavxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthavxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hadxxmh = edthavxxmh.field('havxxmh.id_hadxxmh').val();
				nama = edthavxxmh.field('havxxmh.nama').val();

				validasiRequired(
					edthavxxmh,
					'havxxmh',
					{
						'id_hadxxmh': id_hadxxmh,
						'nama': nama
					}
				);
			}
			
			if ( edthavxxmh.inError() ) {
				return false;
			}
		});
		
		edthavxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthavxxmh.field('havxxmh.finish_at').val(finish_at);
		});

		edthavxxmh.on( 'close', function () {
			edthavxxmh.enable();
		} );

		tblhavxxmh = $('#tblhavxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/havxxmh/havxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_havxxmh = show_deleted_havxxmh;
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
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "havxxmh.id",visible:false },
				{ data: "havxxmh.nama" },
				{ data: "hadxxmh.nama" },
				{ 
					data: "havxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_havxxmh';
					$table       = 'tblhavxxmh';
					$edt         = 'edthavxxmh';
					$show_status = '_havxxmh';
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
				if ( data.havxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.havxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhavxxmh.searchPanes.container().appendTo('#sphavxxmh');
		tblhavxxmh.searchBuilder.container().appendTo( '#sbhavxxmh' );
		
		tblhavxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhavxxmh);
		} );
		
		tblhavxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('havxxmh');
			id_hadxxmh_old 		= havxxmh_data.id_hadxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhavxxmh);
		} );

		tblhavxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('havxxmh');
			id_hadxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhavxxmh);
		} );

		// END havxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
