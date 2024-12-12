<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gaptpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgaptpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gaptpmh/fn/gaptpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgaptpmh, tblgaptpmh, show_deleted_gaptpmh = 0, id_gaptpmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('gaptpmh');

		$(document).ready(function() {
			//start datatables editor
			edtgaptpmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/gaptpmh/gaptpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gaptpmh = show_deleted_gaptpmh;
					}
				},
				table: "#tblgaptpmh",
				fields: [ 
					{
						label: "gaptpmh.start_at",
						name: "gaptpmh.start_at",
						type: "hidden"
					},	
					{
						label: "gaptpmh.finish_at",
						name: "gaptpmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gaptpmh",
						type: "hidden"
					},	
					{
						label: "gaptpmh.transaction_state",
						name: "gaptpmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "gaptpmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "gaptpmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtgaptpmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgaptpmh.field('gaptpmh.start_at').val(start_at);

				if(action == 'create'){
					tblgaptpmh.rows().deselect();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edtgaptpmh.field('gaptpmh.nama').enable();
					}else{
						edtgaptpmh.field('gaptpmh.nama').disable();
					}
				}
			});

			edtgaptpmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtgaptpmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama = edtgaptpmh.field('gaptpmh.nama').val();

					validasiRequired(
						edtgaptpmh,
						'gaptpmh',
						{
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtgaptpmh,
						'gaptpmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_gaptpmh
					);
				}
				
				if ( edtgaptpmh.inError() ) {
					return false;
				}
			});
			
			edtgaptpmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgaptpmh.field('gaptpmh.finish_at').val(finish_at);
			});

			edtgaptpmh.on( 'close', function () {
				edtgaptpmh.enable();
			} );

			tblgaptpmh = $('#tblgaptpmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/gaptpmh/gaptpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gaptpmh = show_deleted_gaptpmh;
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				columns: [
					{ data: "gaptpmh.id",visible:false },
					{ data: "gaptpmh.nama" },
					{ data: "gaptpmh.keterangan" },
					{ 
						data: "gaptpmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gaptpmh';
						$table       = 'tblgaptpmh';
						$edt         = 'edtgaptpmh';
						$show_status = '_gaptpmh';
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
					if ( data.gaptpmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.gaptpmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblgaptpmh.searchPanes.container().appendTo('#spgaptpmh');
			tblgaptpmh.searchBuilder.container().appendTo( '#sbgaptpmh' );
			
			tblgaptpmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgaptpmh);
			} );
			
			tblgaptpmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('gaptpmh');

				// atur hak akses
				CekSelectHeaderH(tblgaptpmh);
			} );

			tblgaptpmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('gaptpmh');

				// atur hak akses
				CekDeselectHeaderH(tblgaptpmh);
			} );
			// END gaptpmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
