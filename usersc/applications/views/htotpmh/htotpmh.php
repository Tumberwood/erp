<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htotpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtotpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htotpmh/fn/htotpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtotpmh, tblhtotpmh, show_deleted_htotpmh = 0, id_htotpmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('htotpmh');

		$(document).ready(function() {
			// BEGIN htotpmh
			edthtotpmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/htotpmh/htotpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htotpmh = show_deleted_htotpmh;
					}
				},
				table: "#tblhtotpmh",
				fields: [ 
					{
						label: "htotpmh.start_at",
						name: "htotpmh.start_at",
						type: "hidden"
					},	
					{
						label: "htotpmh.finish_at",
						name: "htotpmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "htotpmh",
						type: "hidden"
					},	
					{
						label: "htotpmh.transaction_state",
						name: "htotpmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "htotpmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "htotpmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "htotpmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edthtotpmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtotpmh.field('htotpmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblhtotpmh.rows().deselect();
					edthtotpmh.field('htotpmh.kode').enable();
					edthtotpmh.field('htotpmh.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edthtotpmh.field('htotpmh.kode').enable();
						edthtotpmh.field('htotpmh.nama').enable();
					}else{
						edthtotpmh.field('htotpmh.kode').disable();
						edthtotpmh.field('htotpmh.nama').disable();
					}
				}
			});

			edthtotpmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthtotpmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edthtotpmh.field('htotpmh.kode').val();
					nama = edthtotpmh.field('htotpmh.nama').val();

					validasiRequired(
						edthtotpmh,
						'htotpmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edthtotpmh,
						'htotpmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_htotpmh
					);

					validasiUnique(
						action,
						edthtotpmh,
						'htotpmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_htotpmh
					);
				}
				
				if ( edthtotpmh.inError() ) {
					return false;
				}
			});
			
			edthtotpmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtotpmh.field('htotpmh.finish_at').val(finish_at);
			});

			edthtotpmh.on( 'close', function () {
				edthtotpmh.enable();
			} );

			tblhtotpmh = $('#tblhtotpmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htotpmh/htotpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htotpmh = show_deleted_htotpmh;
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
					{ data: "htotpmh.id",visible:false },
					{ data: "htotpmh.kode" },
					{ data: "htotpmh.nama" },
					{ data: "htotpmh.keterangan" },
					{ 
						data: "htotpmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_htotpmh';
						$table       = 'tblhtotpmh';
						$edt         = 'edthtotpmh';
						$show_status = '_htotpmh';
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
					if ( data.htotpmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.htotpmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhtotpmh.searchPanes.container().appendTo('#sphtotpmh');
			tblhtotpmh.searchBuilder.container().appendTo( '#sbhtotpmh' );
			
			tblhtotpmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhtotpmh);
			} );
			
			tblhtotpmh.on( 'select', function( e, dt, type, indexes ) {
				htotpmh_data    		= tblhtotpmh.row( { selected: true } ).data().htotpmh;
				id_htotpmh      		= htotpmh_data.id;
				id_transaksi_h 		= id_htotpmh; // dipakai untuk general
				id_transaksi_log	= id_htotpmh; // dipakai untuk general
				transaction_state   = htotpmh_data.transaction_state;
				approval_state   	= htotpmh_data.approval_state;
				is_nextprocess 		= htotpmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblhtotpmh);
			} );

			tblhtotpmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htotpmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtotpmh);
			} );

			// END htotpmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
