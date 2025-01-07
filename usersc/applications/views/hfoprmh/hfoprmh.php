<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hfoprmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhfoprmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfoprmh/fn/hfoprmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthfoprmh, tblhfoprmh, show_deleted_hfoprmh = 0, id_hfoprmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hfoprmh');

	$(document).ready(function() {
		// BEGIN hfoprmh
		edthfoprmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfoprmh/hfoprmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfoprmh = show_deleted_hfoprmh;
				}
			},
			table: "#tblhfoprmh",
			fields: [ 
				{
					label: "hfoprmh.start_at",
					name: "hfoprmh.start_at",
					type: "hidden"
				},	
				{
					label: "hfoprmh.finish_at",
					name: "hfoprmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfoprmh",
					type: "hidden"
				},	
				{
					label: "hfoprmh.transaction_state",
					name: "hfoprmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hfoprmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hfoprmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthfoprmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfoprmh.field('hfoprmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhfoprmh.rows().deselect();
				edthfoprmh.field('hfoprmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthfoprmh.field('hfoprmh.nama').enable();
				}else{
					edthfoprmh.field('hfoprmh.nama').disable();
				}
			}
		});

		edthfoprmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthfoprmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edthfoprmh.field('hfoprmh.nama').val();

				validasiRequired(
					edthfoprmh,
					'hfoprmh',
					{
						'nama': nama,
					}
				);

				validasiUnique(
					action,
					edthfoprmh,
					'hfoprmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hfoprmh
				);
			}
			
			if ( edthfoprmh.inError() ) {
				return false;
			}
		});
		
		edthfoprmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfoprmh.field('hfoprmh.finish_at').val(finish_at);
		});

		edthfoprmh.on( 'close', function () {
			edthfoprmh.enable();
		} );

		tblhfoprmh = $('#tblhfoprmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-1',
			},
			ajax: {
				url: "../../models/hfoprmh/hfoprmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfoprmh = show_deleted_hfoprmh;
				}
			},
			order: [[ 1, "asc" ]],
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
				{ data: "hfoprmh.id",visible:false },
				{ data: "hfoprmh.nama" },
				{ 
					data: "hfoprmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfoprmh';
					$table       = 'tblhfoprmh';
					$edt         = 'edthfoprmh';
					$show_status = '_hfoprmh';
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
				if ( data.hfoprmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfoprmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfoprmh.searchPanes.container().appendTo('#sphfoprmh');
		tblhfoprmh.searchBuilder.container().appendTo( '#sbhfoprmh' );
		
		tblhfoprmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhfoprmh);
		} );
		
		tblhfoprmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfoprmh');

			// atur hak akses
			CekSelectHeaderH(tblhfoprmh);
		} );

		tblhfoprmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfoprmh');

			// atur hak akses
			CekDeselectHeaderH(tblhfoprmh);
		} );

		// END hfoprmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
