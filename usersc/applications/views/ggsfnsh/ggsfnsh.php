<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ggsfnsh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblggsfnsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jatuh Tempo Berdasarkan Tanggal</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ggsfnsh/fn/ggsfnsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtggsfnsh, tblggsfnsh, show_deleted_ggsfnsh = 0, id_ggsfnsh;
	var id_aakxxmh_hutang_sementara_old = 0, id_aakxxmh_persediaan_perjalanan_old = 0, ids_aatxxmh_persediaan_old = '', ids_aatxxmh_biaya_old = '';
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('ggsfnsh');

	$(document).ready(function() {
		// BEGIN ggsfnsh
		edtggsfnsh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ggsfnsh/ggsfnsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggsfnsh = show_deleted_ggsfnsh;
				}
			},
			table: "#tblggsfnsh",
			fields: [ 
				{
					label: "ggsfnsh.start_at",
					name: "ggsfnsh.start_at",
					type: "hidden"
				},	
				{
					label: "ggsfnsh.finish_at",
					name: "ggsfnsh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ggsfnsh",
					type: "hidden"
				},	
				{
					label: "ggsfnsh.transaction_state",
					name: "ggsfnsh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Jatuh Tempo Berdasarkan Tanggal",
					name: "ggsfnsh.jatuh_tempo",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Good Receive", "value": "Good Receive" },
						{ "label": "Invoice", "value": "Invoice" },
					]
				},
			]
		} );

		edtggsfnsh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggsfnsh.field('ggsfnsh.start_at').val(start_at);
			
			if(action == 'create'){
				tblggsfnsh.rows().deselect();
			}
		});

		edtggsfnsh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtggsfnsh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				jatuh_tempo = edtggsfnsh.field('ggsfnsh.jatuh_tempo').val();

				validasiRequired(
					edtggsfnsh,
					'ggsfnsh',
					{
						'jatuh_tempo': jatuh_tempo,
					}
				);
			}
			
			if ( edtggsfnsh.inError() ) {
				return false;
			}
		});
		
		edtggsfnsh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggsfnsh.field('ggsfnsh.finish_at').val(finish_at);
		});

		edtggsfnsh.on( 'close', function () {
			edtggsfnsh.enable();
		} );

		tblggsfnsh = $('#tblggsfnsh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ggsfnsh/ggsfnsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggsfnsh = show_deleted_ggsfnsh;
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
				{ data: "ggsfnsh.id",visible:false },
				{ data: "ggsfnsh.jatuh_tempo" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ggsfnsh';
					$table       = 'tblggsfnsh';
					$edt         = 'edtggsfnsh';
					$show_status = '_ggsfnsh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['edit', 'confirm','view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.ggsfnsh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ggsfnsh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblggsfnsh.searchPanes.container().appendTo('#spggsfnsh');
		tblggsfnsh.searchBuilder.container().appendTo( '#sbggsfnsh' );
		
		tblggsfnsh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblggsfnsh);
		} );
		
		tblggsfnsh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ggsfnsh');
			id_aakxxmh_hutang_sementara_old = ggsfnsh_data.id_aakxxmh_hutang_sementara;
			id_aakxxmh_persediaan_perjalanan_old = ggsfnsh_data.id_aakxxmh_persediaan_perjalanan;

			tblggsfnsh.rows( { selected: true } ).data().each(function (row) {
				if (row.aatxxmh_persediaan) {
					ids_aatxxmh_persediaan_old = "";
					row.aatxxmh_persediaan.forEach(function (aatxxmh_persediaan_data) {
						ids_aatxxmh_persediaan_old = ids_aatxxmh_persediaan_old + "," + aatxxmh_persediaan_data.id;
					});
					ids_aatxxmh_persediaan_old = ids_aatxxmh_persediaan_old.substring(1);
				}
				if (row.aatxxmh_biaya) {
					ids_aatxxmh_biaya_old = "";
					row.aatxxmh_biaya.forEach(function (aatxxmh_biaya_data) {
						ids_aatxxmh_biaya_old = ids_aatxxmh_biaya_old + "," + aatxxmh_biaya_data.id;
					});
					ids_aatxxmh_biaya_old = ids_aatxxmh_biaya_old.substring(1);
				}
			});
			// atur hak akses
			CekSelectHeaderH(tblggsfnsh);
		} );

		tblggsfnsh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ggsfnsh');
			id_aakxxmh_hutang_sementara_old = 0;
			id_aakxxmh_persediaan_perjalanan_old = 0;
			ids_aatxxmh_persediaan_old = '';
			ids_aatxxmh_biaya_old = '';

			// atur hak akses
			CekDeselectHeaderH(tblggsfnsh);
		} );

		// END ggsfnsh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
