<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = '_blank';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbl_blank" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/_blank/fn/_blank_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edt_blank, tbl_blank, show_deleted__blank = 0, id__blank;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('_blankheader');
		
		$(document).ready(function() {
			
			// BEGIN _blank
			edt_blank = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/_blank/_blank.php",
					type: 'POST',
					data: function (d){
						d.show_deleted__blank = show_deleted__blank;
					}
				},
				table: "#tbl_blank",
				fields: [ 
					{
						label: "_blank.start_at",
						name: "_blank.start_at",
						type: "hidden"
					},	
					{
						label: "_blank.finish_at",
						name: "_blank.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "_blank",
						type: "hidden"
					},	
					{
						label: "_blank.transaction_state",
						name: "_blank.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "_blank.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "_blank.nama"
					}, 	
					{
						label: "Keterangan",
						name: "_blank.keterangan",
						type: "textarea"
					}
				]
			} );

			edt_blank.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edt_blank.field('_blank.start_at').val(start_at);
				
				if(action == 'create'){
					tbl_blank.rows().deselect();
				}
			});

			edt_blank.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edt_blank.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edt_blank.field('_blank.kode').val();
					nama = edt_blank.field('_blank.nama').val();

					validasiRequired(
						edt_blank,
						'_blank',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edt_blank,
						'_blank',
						'kode',
						'kode',
						'"'+kode+'"',
						id__blank
					);

					validasiUnique(
						action,
						edt_blank,
						'_blank',
						'nama',
						'nama',
						'"'+nama+'"',
						id__blank
					);
				}
				
				if ( edt_blank.inError() ) {
					return false;
				}
			});
			
			edt_blank.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edt_blank.field('_blank.finish_at').val(finish_at);
			});

			edt_blank.on( 'close', function () {
				edt_blank.enable();
			} );

			tbl_blank = $('#tbl_blank').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/_blank/_blank.php",
					type: 'POST',
					data: function (d){
						d.show_deleted__blank = show_deleted__blank;
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
						targets: [0]
					}
				],
				columns: [
					{ data: "_blank.id",visible:false },
					{ data: "_blank.kode" },
					{ data: "_blank.nama" },
					{ data: "_blank.keterangan" },
					{ 
						data: "_blank.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id__blank';
						$table       = 'tbl_blank';
						$edt         = 'edt_blank';
						$show_status = '__blank';
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
					if ( data._blank.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data._blank.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbl_blank.searchPanes.container().appendTo('#sp_blank');
			tbl_blank.searchBuilder.container().appendTo( '#sb_blank' );
			
			tbl_blank.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbl_blank);
			} );
			
			tbl_blank.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('_blank');

				// atur hak akses
				CekSelectHeaderH(tbl_blank);
			} );

			tbl_blank.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('_blank');

				// atur hak akses
				CekDeselectHeaderH(tbl_blank);
			} );

			// END _blank
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
