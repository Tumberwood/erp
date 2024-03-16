<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'rwpxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblrwpxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/rwpxxmh/fn/rwpxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtrwpxxmh, tblrwpxxmh, show_deleted_rwpxxmh = 0, id_rwpxxmh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('rwpxxmh');
		
		$(document).ready(function() {
			// BEGIN rwpxxmh
			edtrwpxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/rwpxxmh/rwpxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_rwpxxmh = show_deleted_rwpxxmh;
					}
				},
				table: "#tblrwpxxmh",
				fields: [ 
					{
						label: "rwpxxmh.start_at",
						name: "rwpxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "rwpxxmh.finish_at",
						name: "rwpxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "rwpxxmh",
						type: "hidden"
					},	
					{
						label: "rwpxxmh.transaction_state",
						name: "rwpxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "rwpxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "rwpxxmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "rwpxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtrwpxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtrwpxxmh.field('rwpxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblrwpxxmh.rows().deselect();
				}
			});

			edtrwpxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtrwpxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					kode = edtrwpxxmh.field('rwpxxmh.kode').val();
					nama = edtrwpxxmh.field('rwpxxmh.nama').val();

					validasiRequired(
						edtrwpxxmh,
						'rwpxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtrwpxxmh,
						'rwpxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_rwpxxmh
					);

					validasiUnique(
						action,
						edtrwpxxmh,
						'rwpxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_rwpxxmh
					);

				}
				
				if ( edtrwpxxmh.inError() ) {
					return false;
				}
			});
			
			edtrwpxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtrwpxxmh.field('rwpxxmh.finish_at').val(finish_at);
			});

			edtrwpxxmh.on( 'close', function () {
				edtrwpxxmh.enable();
			} );

			tblrwpxxmh = $('#tblrwpxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/rwpxxmh/rwpxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_rwpxxmh = show_deleted_rwpxxmh;
					}
				},
				order: [[ 0, "asc" ]],
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
					{ data: "rwpxxmh.id",visible:false },
					{ data: "rwpxxmh.kode" },
					{ data: "rwpxxmh.nama" },
					{ data: "rwpxxmh.keterangan" },
					{ 
						data: "rwpxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_rwpxxmh';
						$table       = 'tblrwpxxmh';
						$edt         = 'edtrwpxxmh';
						$show_status = '_rwpxxmh';
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
					if ( data.rwpxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.rwpxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblrwpxxmh.searchPanes.container().appendTo('#sprwpxxmh');
			tblrwpxxmh.searchBuilder.container().appendTo( '#sbrwpxxmh' );
			
			tblrwpxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblrwpxxmh);
			} );
			
			tblrwpxxmh.on( 'select', function( e, dt, type, indexes ) {
				rwpxxmh_data    		= tblrwpxxmh.row( { selected: true } ).data().rwpxxmh;
				id_rwpxxmh      		= rwpxxmh_data.id;
				id_transaksi_h 		= id_rwpxxmh; // dipakai untuk general
				id_transaksi_log	= id_rwpxxmh; // dipakai untuk general
				transaction_state   = rwpxxmh_data.transaction_state;
				approval_state   	= rwpxxmh_data.approval_state;
				is_nextprocess 		= rwpxxmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblrwpxxmh);
			} );

			tblrwpxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_rwpxxmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblrwpxxmh);
			} );
			// END rwpxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
