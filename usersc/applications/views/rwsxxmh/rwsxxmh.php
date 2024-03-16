<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'rwsxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblrwsxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/rwsxxmh/fn/rwsxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtrwsxxmh, tblrwsxxmh, show_deleted_rwsxxmh = 0, id_rwsxxmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('rwsxxmh');

		$(document).ready(function() {
			
			// BEGIN rwsxxmh
			edtrwsxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/rwsxxmh/rwsxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_rwsxxmh = show_deleted_rwsxxmh;
					}
				},
				table: "#tblrwsxxmh",
				fields: [ 
					{
						label: "rwsxxmh.start_at",
						name: "rwsxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "rwsxxmh.finish_at",
						name: "rwsxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "rwsxxmh",
						type: "hidden"
					},	
					{
						label: "rwsxxmh.transaction_state",
						name: "rwsxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "rwsxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "rwsxxmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "rwsxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtrwsxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtrwsxxmh.field('rwsxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblrwsxxmh.rows().deselect();
				}
			});

			edtrwsxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtrwsxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edtrwsxxmh.field('rwsxxmh.kode').val();
					nama = edtrwsxxmh.field('rwsxxmh.nama').val();

					validasiRequired(
						edtrwsxxmh,
						'rwsxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtrwsxxmh,
						'rwsxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_rwsxxmh
					);

					validasiUnique(
						action,
						edtrwsxxmh,
						'rwsxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_rwsxxmh
					);
				}
				
				if ( edtrwsxxmh.inError() ) {
					return false;
				}
			});
			
			edtrwsxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtrwsxxmh.field('rwsxxmh.finish_at').val(finish_at);
			});

			edtrwsxxmh.on( 'close', function () {
				edtrwsxxmh.enable();
			} );

			tblrwsxxmh = $('#tblrwsxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/rwsxxmh/rwsxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_rwsxxmh = show_deleted_rwsxxmh;
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
					{ data: "rwsxxmh.id",visible:false },
					{ data: "rwsxxmh.kode" },
					{ data: "rwsxxmh.nama" },
					{ data: "rwsxxmh.keterangan" },
					{ 
						data: "rwsxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_rwsxxmh';
						$table       = 'tblrwsxxmh';
						$edt         = 'edtrwsxxmh';
						$show_status = '_rwsxxmh';
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
					if ( data.rwsxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.rwsxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblrwsxxmh.searchPanes.container().appendTo('#sprwsxxmh');
			tblrwsxxmh.searchBuilder.container().appendTo( '#sbrwsxxmh' );
			
			tblrwsxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblrwsxxmh);
			} );
			
			tblrwsxxmh.on( 'select', function( e, dt, type, indexes ) {
				rwsxxmh_data    		= tblrwsxxmh.row( { selected: true } ).data().rwsxxmh;
				id_rwsxxmh      		= rwsxxmh_data.id;
				id_transaksi_h 		= id_rwsxxmh; // dipakai untuk general
				id_transaksi_log	= id_rwsxxmh; // dipakai untuk general
				transaction_state   = rwsxxmh_data.transaction_state;
				approval_state   	= rwsxxmh_data.approval_state;
				is_nextprocess 		= rwsxxmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblrwsxxmh);
			} );

			tblrwsxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_rwsxxmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblrwsxxmh);
			} );
			
			// END rwsxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
