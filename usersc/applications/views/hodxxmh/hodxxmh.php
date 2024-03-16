<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hodxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhodxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hodxxmh/fn/hodxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthodxxmh, tblhodxxmh, show_deleted_hodxxmh = 0, id_hodxxmh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('hodxxmh');

		$(document).ready(function() {
			// BEGIN hodxxmh
			edthodxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/hodxxmh/hodxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hodxxmh = show_deleted_hodxxmh;
					}
				},
				table: "#tblhodxxmh",
				fields: [ 
					{
						label: "hodxxmh.start_at",
						name: "hodxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "hodxxmh.finish_at",
						name: "hodxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "hodxxmh",
						type: "hidden"
					},	
					{
						label: "hodxxmh.transaction_state",
						name: "hodxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "hodxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "hodxxmh.nama"
					}
				]
			} );

			edthodxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthodxxmh.field('hodxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblhodxxmh.rows().deselect();
				}
			});

			edthodxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthodxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edthodxxmh.field('hodxxmh.kode').val();
					nama = edthodxxmh.field('hodxxmh.nama').val();

					validasiRequired(
						edthodxxmh,
						'hodxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);
					
					validasiUnique(
						action,
						edthodxxmh,
						'hodxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_hodxxmh
					);

					validasiUnique(
						action,
						edthodxxmh,
						'hodxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_hodxxmh
					);
				}
				
				if ( edthodxxmh.inError() ) {
					return false;
				}
			});
			
			edthodxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthodxxmh.field('hodxxmh.finish_at').val(finish_at);
			});

			edthodxxmh.on( 'close', function () {
				edthodxxmh.enable();
			} );

			tblhodxxmh = $('#tblhodxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/hodxxmh/hodxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hodxxmh = show_deleted_hodxxmh;
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
					{ data: "hodxxmh.id",visible:false },
					{ data: "hodxxmh.kode" , type: 'string'},
					{ data: "hodxxmh.nama" },
					{ 
						data: "hodxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_hodxxmh';
						$table       = 'tblhodxxmh';
						$edt         = 'edthodxxmh';
						$show_status = '_hodxxmh';
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
					if ( data.hodxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.hodxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhodxxmh.searchPanes.container().appendTo('#sphodxxmh');
			tblhodxxmh.searchBuilder.container().appendTo( '#sbhodxxmh' );
			
			tblhodxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhodxxmh);
			} );
			
			tblhodxxmh.on( 'select', function( e, dt, type, indexes ) {
				hodxxmh_data    	= tblhodxxmh.row( { selected: true } ).data().hodxxmh;
				id_hodxxmh      	= hodxxmh_data.id;
				id_transaksi_h 		= id_hodxxmh; // dipakai untuk general
				id_transaksi_log	= id_hodxxmh; // dipakai untuk general
				transaction_state   = hodxxmh_data.transaction_state;
				approval_state   	= hodxxmh_data.approval_state;
				is_nextprocess 		= hodxxmh_data.is_nextprocess;
				
				id_hodxxmh_parent_old = hodxxmh_data.id_hodxxmh_parent;

				// atur hak akses
				CekSelectHeaderH(tblhodxxmh);
			} );

			tblhodxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_hodxxmh = 0;
				id_hodxxmh_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhodxxmh);
			} );

			// END hodxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
