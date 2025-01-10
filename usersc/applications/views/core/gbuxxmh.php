<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gbuxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgbuxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="businessEntityCode"></th>
                                <th data-i18n="businessEntityName"></th>
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
		var edtgbuxxmh, tblgbuxxmh, show_deleted_gbuxxmh = 0, id_gbuxxmh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('gbuxxmh');
		
		$(document).ready(function() {
			// BEGIN gbuxxmh
			edtgbuxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/gbuxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gbuxxmh = show_deleted_gbuxxmh;
					}
				},
				table: "#tblgbuxxmh",
				fields: [ 
					{
						label: "gbuxxmh.start_at",
						name: "gbuxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "gbuxxmh.finish_at",
						name: "gbuxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gbuxxmh",
						type: "hidden"
					},
					{
						label: "gbuxxmh.transaction_state",
						name: "gbuxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},
					{
						label: getTranslation('businessEntityCode') + " <sup class='text-danger'>*<sup>",
						name: "gbuxxmh.kode"
					},
					{
						label: getTranslation('businessEntityName') + " <sup class='text-danger'>*<sup>",
						name: "gbuxxmh.nama"
					}
				]
			} );

			edtgbuxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgbuxxmh.field('gbuxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgbuxxmh.rows().deselect();

					edtgbuxxmh.field('gbuxxmh.kode').enable();
					edtgbuxxmh.field('gbuxxmh.nama').enable();

				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtgbuxxmh.field('gbuxxmh.kode').enable();
						edtgbuxxmh.field('gbuxxmh.nama').enable();
					}else{
						edtgbuxxmh.field('gbuxxmh.kode').disable();
						edtgbuxxmh.field('gbuxxmh.nama').disable();
					}
				}

			});

			edtgbuxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtgbuxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edtgbuxxmh.field('gbuxxmh.kode').val();
					nama = edtgbuxxmh.field('gbuxxmh.nama').val();

					validasiRequired(
						edtgbuxxmh,
						'gbuxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtgbuxxmh,
						'gbuxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_gbuxxmh
					);

					validasiUnique(
						action,
						edtgbuxxmh,
						'gbuxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_gbuxxmh
					);
					
				}
				
				if ( edtgbuxxmh.inError() ) {
					return false;
				}
			});

			edtgbuxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgbuxxmh.field('gbuxxmh.finish_at').val(finish_at);
			});

			edtgbuxxmh.on( 'close', function () {
				edtgbuxxmh.enable();
			} );
			
			tblgbuxxmh = $('#tblgbuxxmh').DataTable( {
				ajax: {
					url: "../../models/core/gbuxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gbuxxmh = show_deleted_gbuxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "gbuxxmh.id",visible:false },
					{ data: "gbuxxmh.kode" },
					{ data: "gbuxxmh.nama" },
					{ 
						data: "gbuxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gbuxxmh';
						$table       = 'tblgbuxxmh';
						$edt         = 'edtgbuxxmh';
						$show_status = '_gbuxxmh';
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
			
			tblgbuxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgbuxxmh);
			} );
			
			tblgbuxxmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('gbuxxmh');

				// atur hak akses
				CekSelectHeaderH(tblgbuxxmh);
			} );

			tblgbuxxmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('gbuxxmh');

				// atur hak akses
				CekDeselectHeaderH(tblgbuxxmh);
			} );

			// END gbuxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
