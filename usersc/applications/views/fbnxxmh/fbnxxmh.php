<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fbnxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblfbnxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fbnxxmh/fn/fbnxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfbnxxmh, tblfbnxxmh, show_deleted_fbnxxmh = 0, id_fbnxxmh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('fbnxxmh');

		$(document).ready(function() {
			// BEGIN fbnxxmh
			edtfbnxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/fbnxxmh/fbnxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fbnxxmh = show_deleted_fbnxxmh;
					}
				},
				table: "#tblfbnxxmh",
				fields: [ 
					{
						label: "fbnxxmh.start_at",
						name: "fbnxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "fbnxxmh.finish_at",
						name: "fbnxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "fbnxxmh",
						type: "hidden"
					},	
					{
						label: "fbnxxmh.transaction_state",
						name: "fbnxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
						name: "fbnxxmh.kode"
					}, 	
					{
						label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
						name: "fbnxxmh.nama"
					}
				]
			} );

			edtfbnxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfbnxxmh.field('fbnxxmh.start_at').val(start_at);

				if(action == 'create'){
					tblfbnxxmh.rows().deselect();
					edtfbnxxmh.field('fbnxxmh.kode').enable();
					edtfbnxxmh.field('fbnxxmh.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edtfbnxxmh.field('fbnxxmh.kode').enable();
						edtfbnxxmh.field('fbnxxmh.nama').enable();
					}else{
						edtfbnxxmh.field('fbnxxmh.kode').disable();
						edtfbnxxmh.field('fbnxxmh.nama').disable();
					}
				}
			});

			edtfbnxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtfbnxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					kode = edtfbnxxmh.field('fbnxxmh.kode').val();
					nama = edtfbnxxmh.field('fbnxxmh.nama').val();

					validasiRequired(
						edtfbnxxmh,
						'fbnxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtfbnxxmh,
						'fbnxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_fbnxxmh
					);

					validasiUnique(
						action,
						edtfbnxxmh,
						'fbnxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_fbnxxmh
					);
				}
				
				if ( edtfbnxxmh.inError() ) {
					return false;
				}
			});
			
			edtfbnxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfbnxxmh.field('fbnxxmh.finish_at').val(finish_at);
			});

			edtfbnxxmh.on( 'close', function () {
				edtfbnxxmh.enable();
			} );

			tblfbnxxmh = $('#tblfbnxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/fbnxxmh/fbnxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fbnxxmh = show_deleted_fbnxxmh;
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
					{ data: "fbnxxmh.id",visible:false },
					{ data: "fbnxxmh.kode" , type: 'string'},
					{ data: "fbnxxmh.nama" },
					{ 
						data: "fbnxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_fbnxxmh';
						$table       = 'tblfbnxxmh';
						$edt         = 'edtfbnxxmh';
						$show_status = '_fbnxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];						
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.fbnxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.fbnxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblfbnxxmh.searchPanes.container().appendTo('#spfbnxxmh');
			tblfbnxxmh.searchBuilder.container().appendTo( '#sbfbnxxmh' );
			
			tblfbnxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblfbnxxmh);
			} );
			
			tblfbnxxmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('fbnxxmh');
				
				id_fbnxxmh_parent_old = fbnxxmh_data.id_fbnxxmh_parent;

				// atur hak akses
				CekSelectHeaderH(tblfbnxxmh);
			} );

			tblfbnxxmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('fbnxxmh');
				id_fbnxxmh_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblfbnxxmh);
			} );

			// END fbnxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
