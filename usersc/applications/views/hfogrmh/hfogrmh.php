<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hfogrmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhfogrmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfogrmh/fn/hfogrmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthfogrmh, tblhfogrmh, show_deleted_hfogrmh = 0, id_hfogrmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hfogrmh');

	$(document).ready(function() {
		// BEGIN hfogrmh
		edthfogrmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfogrmh/hfogrmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfogrmh = show_deleted_hfogrmh;
				}
			},
			table: "#tblhfogrmh",
			fields: [ 
				{
					label: "hfogrmh.start_at",
					name: "hfogrmh.start_at",
					type: "hidden"
				},	
				{
					label: "hfogrmh.finish_at",
					name: "hfogrmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfogrmh",
					type: "hidden"
				},	
				{
					label: "hfogrmh.transaction_state",
					name: "hfogrmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hfogrmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hfogrmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthfogrmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfogrmh.field('hfogrmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhfogrmh.rows().deselect();
				edthfogrmh.field('hfogrmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthfogrmh.field('hfogrmh.nama').enable();
				}else{
					edthfogrmh.field('hfogrmh.nama').disable();
				}
			}
		});

		edthfogrmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthfogrmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edthfogrmh.field('hfogrmh.nama').val();

				validasiRequired(
					edthfogrmh,
					'hfogrmh',
					{
						'nama': nama,
					}
				);

				validasiUnique(
					action,
					edthfogrmh,
					'hfogrmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hfogrmh
				);
			}
			
			if ( edthfogrmh.inError() ) {
				return false;
			}
		});
		
		edthfogrmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfogrmh.field('hfogrmh.finish_at').val(finish_at);
		});

		edthfogrmh.on( 'close', function () {
			edthfogrmh.enable();
		} );

		tblhfogrmh = $('#tblhfogrmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-1',
			},
			ajax: {
				url: "../../models/hfogrmh/hfogrmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfogrmh = show_deleted_hfogrmh;
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
				{ data: "hfogrmh.id",visible:false },
				{ data: "hfogrmh.nama" },
				{ 
					data: "hfogrmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfogrmh';
					$table       = 'tblhfogrmh';
					$edt         = 'edthfogrmh';
					$show_status = '_hfogrmh';
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
				if ( data.hfogrmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfogrmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfogrmh.searchPanes.container().appendTo('#sphfogrmh');
		tblhfogrmh.searchBuilder.container().appendTo( '#sbhfogrmh' );
		
		tblhfogrmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhfogrmh);
		} );
		
		tblhfogrmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfogrmh');

			// atur hak akses
			CekSelectHeaderH(tblhfogrmh);
		} );

		tblhfogrmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfogrmh');

			// atur hak akses
			CekDeselectHeaderH(tblhfogrmh);
		} );

		// END hfogrmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
