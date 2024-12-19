<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ggshrsh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblggshrsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Auto Create User</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ggshrsh/fn/ggshrsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtggshrsh, tblggshrsh, show_deleted_ggshrsh = 0, id_ggshrsh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('ggshrsh');

	$(document).ready(function() {
		// BEGIN ggshrsh
		edtggshrsh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ggshrsh/ggshrsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggshrsh = show_deleted_ggshrsh;
				}
			},
			table: "#tblggshrsh",
			fields: [ 
				{
					label: "ggshrsh.start_at",
					name: "ggshrsh.start_at",
					type: "hidden"
				},	
				{
					label: "ggshrsh.finish_at",
					name: "ggshrsh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ggshrsh",
					type: "hidden"
				},	
				{
					label: "ggshrsh.transaction_state",
					name: "ggshrsh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Auto Create User",
					name: "ggshrsh.is_autocreateusers",
					type: "select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
			]
		} );

		edtggshrsh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggshrsh.field('ggshrsh.start_at').val(start_at);
			
			if(action == 'create'){
				tblggshrsh.rows().deselect();
			}
		});

		edtggshrsh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtggshrsh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
			
			}
			
			if ( edtggshrsh.inError() ) {
				return false;
			}
		});
		
		edtggshrsh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggshrsh.field('ggshrsh.finish_at').val(finish_at);
		});

		edtggshrsh.on( 'close', function () {
			edtggshrsh.enable();
		} );

		tblggshrsh = $('#tblggshrsh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-1',
			},
			ajax: {
				url: "../../models/ggshrsh/ggshrsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggshrsh = show_deleted_ggshrsh;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "ggshrsh.id",visible:false },
				{ data: "ggshrsh.is_autocreateusers", ...renderYaTidak() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ggshrsh';
					$table       = 'tblggshrsh';
					$edt         = 'edtggshrsh';
					$show_status = '_ggshrsh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['edit', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.ggshrsh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ggshrsh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblggshrsh.searchPanes.container().appendTo('#spggshrsh');
		tblggshrsh.searchBuilder.container().appendTo( '#sbggshrsh' );
		
		tblggshrsh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblggshrsh);
		} );
		
		tblggshrsh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ggshrsh');

			// atur hak akses
			CekSelectHeaderH(tblggshrsh);
		} );

		tblggshrsh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ggshrsh');

			// atur hak akses
			CekDeselectHeaderH(tblggshrsh);
		} );

		// END ggshrsh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
