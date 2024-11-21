<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ggswmsh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblggswmsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Ganti Lokasi Putaway</th>
								<th>Hapus Draft Ketika Reload</th>
								<th>Replenishment</th>
								<th>One Way DO</th>
								<th>Pick and Pack</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ggswmsh/fn/ggswmsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtggswmsh, tblggswmsh, show_deleted_ggswmsh = 0, id_ggswmsh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('ggswmsh');

	$(document).ready(function() {
		// BEGIN ggswmsh
		edtggswmsh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ggswmsh/ggswmsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggswmsh = show_deleted_ggswmsh;
				}
			},
			table: "#tblggswmsh",
			fields: [ 
				{
					label: "ggswmsh.start_at",
					name: "ggswmsh.start_at",
					type: "hidden"
				},	
				{
					label: "ggswmsh.finish_at",
					name: "ggswmsh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ggswmsh",
					type: "hidden"
				},	
				{
					label: "ggswmsh.transaction_state",
					name: "ggswmsh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Ganti Lokasi Putaway",
					name: "ggswmsh.is_ganti_lokasi_putaway",
					fieldInfo: "Bisa Ganti Lokasi di Putaway, terlepas dari lokasi yang dipilih sistem",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "Hapus Data Ketika Reload",
					name: "ggswmsh.is_delete_reload",
					type: "select",
					placeholder : "Select",
					fieldInfo: "Data yang terhapus adalah data yang belum confirm atau draft yang belum disubmit",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "Replenishment",
					name: "ggswmsh.is_replenishment",
					type: "select",
					placeholder : "Select",
					fieldInfo: "Pilih Yes untuk mengaktifkan Replenishment ",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "One Way DO",
					name: "ggswmsh.is_one_way_do",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "Pick and Pack",
					name: "ggswmsh.pick_and_pack",
					type: "select",
					placeholder : "Select",
					fieldInfo: "Yes: Melakukan Picking dan Packing secara bersamaan.",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
			]
		} );

		edtggswmsh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggswmsh.field('ggswmsh.start_at').val(start_at);
			
			if(action == 'create'){
				tblggswmsh.rows().deselect();
			}
		});

		edtggswmsh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtggswmsh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

			}
			
			if ( edtggswmsh.inError() ) {
				return false;
			}
		});
		
		edtggswmsh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtggswmsh.field('ggswmsh.finish_at').val(finish_at);
		});

		edtggswmsh.on( 'close', function () {
			edtggswmsh.enable();
		} );

		tblggswmsh = $('#tblggswmsh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ggswmsh/ggswmsh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ggswmsh = show_deleted_ggswmsh;
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
				{ data: "ggswmsh.id",visible:false },
				{ data: "ggswmsh.is_ganti_lokasi_putaway", ...renderYaTidak() },
				{ data: "ggswmsh.is_delete_reload", ...renderYaTidak() },
				{ data: "ggswmsh.is_replenishment", ...renderYaTidak() },
				{ data: "ggswmsh.is_one_way_do", ...renderYaTidak() },
				{ data: "ggswmsh.pick_and_pack", ...renderYaTidak() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ggswmsh';
					$table       = 'tblggswmsh';
					$edt         = 'edtggswmsh';
					$show_status = '_ggswmsh';
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
				if ( data.ggswmsh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ggswmsh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblggswmsh.searchPanes.container().appendTo('#spggswmsh');
		tblggswmsh.searchBuilder.container().appendTo( '#sbggswmsh' );
		
		tblggswmsh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblggswmsh);
		} );
		
		tblggswmsh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ggswmsh');

			// atur hak akses
			CekSelectHeaderH(tblggswmsh);
		} );

		tblggswmsh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ggswmsh');

			// atur hak akses
			CekDeselectHeaderH(tblggswmsh);
		} );

		// END ggswmsh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
