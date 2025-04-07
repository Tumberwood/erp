<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gctxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgctxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="cityName"></th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgctxxmh, tblgctxxmh, show_deleted_gctxxmh = 0, id_gctxxmh;
		// ------------- end of default 
		
		var id_gpvxxmh_old = 0;
		
		// get tableRelation
		tableRelation('gcpxxmh');

		$(document).ready(function() {
			// BEGIN gctxxmh
			edtgctxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/gctxxmh/gctxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gctxxmh = show_deleted_gctxxmh;
					}
				},
				table: "#tblgctxxmh",
				fields: [ 
					{
						label: "gctxxmh.start_at",
						name: "gctxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "gctxxmh.finish_at",
						name: "gctxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gctxxmh",
						type: "hidden"
					},	
					{
						label: "gctxxmh.transaction_state",
						name: "gctxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: getTranslation('cityName') + " <sup class='text-danger'>*<sup>",
						name: "gctxxmh.nama"
					}, 	
					{
						label: getTranslation('provinceName') + " <sup class='text-danger'>*<sup>",
						name: "gctxxmh.id_gpvxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/gpvxxmh/gpvxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_gpvxxmh_old: id_gpvxxmh_old,
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
					}
				]
			} );

			edtgctxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgctxxmh.field('gctxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgctxxmh.rows().deselect();

					edtgctxxmh.field('gctxxmh.nama').enable();
					edtgctxxmh.field('gctxxmh.id_gpvxxmh').enable();

				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtgctxxmh.field('gctxxmh.nama').enable();
						edtgctxxmh.field('gctxxmh.id_gpvxxmh').enable();
					}else{
						edtgctxxmh.field('gctxxmh.nama').disable();
						edtgctxxmh.field('gctxxmh.id_gpvxxmh').disable();
					}
				}
			});

			edtgctxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtgctxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama       = edtgctxxmh.field('gctxxmh.nama').val();
					id_gpvxxmh = edtgctxxmh.field('gctxxmh.id_gpvxxmh').val();

					validasiRequired(
						edtgctxxmh,
						'gctxxmh',
						{
							'nama'      : nama,
							'id_gpvxxmh': id_gpvxxmh
						}
					);

				}
				
				if ( edtgctxxmh.inError() ) {
					return false;
				}
			});

			edtgctxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgctxxmh.field('gctxxmh.finish_at').val(finish_at);
			});

			edtgctxxmh.on( 'close', function () {
				edtgctxxmh.enable();
			} );
			
			tblgctxxmh = $('#tblgctxxmh').DataTable( {
				ajax: {
					url: "../../models/gctxxmh/gctxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gctxxmh = show_deleted_gctxxmh;
					}
				},
				order: [[ 2, "asc" ],[ 1, "asc" ]],
				columns: [
					{ data: "gctxxmh.id",visible:false },
					{ data: "gctxxmh.nama" },
					{ data: "gpvxxmh.nama" }
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gctxxmh';
						$table       = 'tblgctxxmh';
						$edt         = 'edtgctxxmh';
						$show_status = '_gctxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide', 'copy', 'excel', 'colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				rowCallback: function( row, data, index ) {
				
				}
			} );
			
			tblgctxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgctxxmh);
			} );
			
			tblgctxxmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('gctxxmh');

				id_gpvxxmh_old = gctxxmh_data.id_gpvxxmh;

				// atur hak akses
				CekSelectHeaderH(tblgctxxmh);
			} );

			tblgctxxmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('gctxxmh');
				id_gpvxxmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblgctxxmh);
			} );

			// END gctxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
