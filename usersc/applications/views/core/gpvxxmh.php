<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gpvxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgpvxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="provinceName"></th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgpvxxmh, tblgpvxxmh, show_deleted_gpvxxmh = 0, id_gpvxxmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('gpvxxmh');

		$(document).ready(function() {
			// BEGIN gpvxxmh
			edtgpvxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/gpvxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gpvxxmh = show_deleted_gpvxxmh;
					}
				},
				table: "#tblgpvxxmh",
				fields: [ 
					{
						label: "gpvxxmh.start_at",
						name: "gpvxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "gpvxxmh.finish_at",
						name: "gpvxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gpvxxmh",
						type: "hidden"
					},	
					{
						label: "gpvxxmh.transaction_state",
						name: "gpvxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: getTranslation('provinceName') + " <sup class='text-danger'>*<sup>",
						name: "gpvxxmh.nama"
					}
				]
			} );

			edtgpvxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgpvxxmh.field('gpvxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgpvxxmh.rows().deselect();

					edtgpvxxmh.field('gpvxxmh.nama').enable();

				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtgpvxxmh.field('gpvxxmh.nama').enable();
					}else{
						edtgpvxxmh.field('gpvxxmh.nama').disable();
					}
				}
			});

			edtgpvxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtgpvxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama = edtgpvxxmh.field('gpvxxmh.nama').val();

					validasiRequired(
						edtgpvxxmh,
						'gpvxxmh',
						{
							'nama': nama
						}
					);

				}
				
				if ( edtgpvxxmh.inError() ) {
					return false;
				}
			});

			edtgpvxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgpvxxmh.field('gpvxxmh.finish_at').val(finish_at);
			});
			
			edtgpvxxmh.on( 'close', function () {
				edtgpvxxmh.enable();
			} );

			tblgpvxxmh = $('#tblgpvxxmh').DataTable( {
				ajax: {
					url: "../../models/core/gpvxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gpvxxmh = show_deleted_gpvxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "gpvxxmh.id",visible:false },
					{ data: "gpvxxmh.nama" }
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gpvxxmh';
						$table       = 'tblgpvxxmh';
						$edt         = 'edtgpvxxmh';
						$show_status = '_gpvxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide', 'copy', 'excel', 'colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'nonaktif_h', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				rowCallback: function( row, data, index ) {
					
				}
			} );
			
			tblgpvxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgpvxxmh);
			} );
			
			tblgpvxxmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('gpvxxmh');

				// atur hak akses
				CekSelectHeaderH(tblgpvxxmh);
			} );

			tblgpvxxmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('gpvxxmh');

				// atur hak akses
				CekDeselectHeaderH(tblgpvxxmh);
			} );
			
			// END gpvxxmh

		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
