<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hlgxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhlgxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hlgxxmh/fn/hlgxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthlgxxmh, tblhlgxxmh, show_deleted_hlgxxmh = 0, id_hlgxxmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('hlgxxmh');

		$(document).ready(function() {
			// BEGIN hlgxxmh
			edthlgxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/hlgxxmh/hlgxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hlgxxmh = show_deleted_hlgxxmh;
					}
				},
				table: "#tblhlgxxmh",
				fields: [ 
					{
						label: "hlgxxmh.start_at",
						name: "hlgxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "hlgxxmh.finish_at",
						name: "hlgxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "hlgxxmh",
						type: "hidden"
					},	
					{
						label: "hlgxxmh.transaction_state",
						name: "hlgxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "hlgxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "hlgxxmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "hlgxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edthlgxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthlgxxmh.field('hlgxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblhlgxxmh.rows().deselect();
					edthlgxxmh.field('hlgxxmh.kode').enable();
					edthlgxxmh.field('hlgxxmh.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edthlgxxmh.field('hlgxxmh.kode').enable();
						edthlgxxmh.field('hlgxxmh.nama').enable();
					}else{
						edthlgxxmh.field('hlgxxmh.kode').disable();
						edthlgxxmh.field('hlgxxmh.nama').disable();
					}
				}
			});

			edthlgxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthlgxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edthlgxxmh.field('hlgxxmh.kode').val();
					nama = edthlgxxmh.field('hlgxxmh.nama').val();

					validasiRequired(
						edthlgxxmh,
						'hlgxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edthlgxxmh,
						'hlgxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_hlgxxmh
					);

					validasiUnique(
						action,
						edthlgxxmh,
						'hlgxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_hlgxxmh
					);
				}
				
				if ( edthlgxxmh.inError() ) {
					return false;
				}
			});
			
			edthlgxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthlgxxmh.field('hlgxxmh.finish_at').val(finish_at);
			});

			edthlgxxmh.on( 'close', function () {
				edthlgxxmh.enable();
			} );

			tblhlgxxmh = $('#tblhlgxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/hlgxxmh/hlgxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hlgxxmh = show_deleted_hlgxxmh;
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
					{ data: "hlgxxmh.id",visible:false },
					{ data: "hlgxxmh.kode" },
					{ data: "hlgxxmh.nama" },
					{ data: "hlgxxmh.keterangan" },
					{ 
						data: "hlgxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_hlgxxmh';
						$table       = 'tblhlgxxmh';
						$edt         = 'edthlgxxmh';
						$show_status = '_hlgxxmh';
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
					if ( data.hlgxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.hlgxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhlgxxmh.searchPanes.container().appendTo('#sphlgxxmh');
			tblhlgxxmh.searchBuilder.container().appendTo( '#sbhlgxxmh' );
			
			tblhlgxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhlgxxmh);
			} );
			
			tblhlgxxmh.on( 'select', function( e, dt, type, indexes ) {
				hlgxxmh_data    		= tblhlgxxmh.row( { selected: true } ).data().hlgxxmh;
				id_hlgxxmh      		= hlgxxmh_data.id;
				id_transaksi_h 		= id_hlgxxmh; // dipakai untuk general
				id_transaksi_log	= id_hlgxxmh; // dipakai untuk general
				transaction_state   = hlgxxmh_data.transaction_state;
				approval_state   	= hlgxxmh_data.approval_state;
				is_nextprocess 		= hlgxxmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblhlgxxmh);
			} );

			tblhlgxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_hlgxxmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhlgxxmh);
			} );

			// END hlgxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
