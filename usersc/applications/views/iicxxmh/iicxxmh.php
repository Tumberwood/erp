<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iicxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliicxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iicxxmh/fn/iicxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiicxxmh, tbliicxxmh, show_deleted_iicxxmh = 0, id_iicxxmh;
		// ------------- end of default variable

		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiicxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iicxxmh/iicxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iicxxmh = show_deleted_iicxxmh;
					}
				},
				table: "#tbliicxxmh",
				fields: [ 
					{
						label: "iicxxmh.start_at",
						name: "iicxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "iicxxmh.finish_at",
						name: "iicxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iicxxmh",
						type: "hidden"
					},	
					{
						label: "iicxxmh.transaction_state",
						name: "iicxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iicxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iicxxmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iicxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiicxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiicxxmh.field('iicxxmh.start_at').val(start_at);

				if(action == 'create'){
					tbliicxxmh.rows().deselect();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiicxxmh.field('iicxxmh.kode').enable();
						edtiicxxmh.field('iicxxmh.nama').enable();
					}else{
						edtiicxxmh.field('iicxxmh.kode').disable();
						edtiicxxmh.field('iicxxmh.nama').disable();
					}
				}
			});

			edtiicxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiicxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edtiicxxmh.field('iicxxmh.kode').val();
					nama = edtiicxxmh.field('iicxxmh.nama').val();
					validasiRequired(
						edtiicxxmh,
						'iicxxmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtiicxxmh,
						'iicxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_iicxxmh,
					);

					validasiUnique(
						action,
						edtiicxxmh,
						'iicxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_iicxxmh,
					);
				}
				
				if ( edtiicxxmh.inError() ) {
					return false;
				}
			});
			
			edtiicxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiicxxmh.field('iicxxmh.finish_at').val(finish_at);
			});

			edtiicxxmh.on( 'close', function () {
				edtiicxxmh.enable();
			} );

			//start datatables
			tbliicxxmh = $('#tbliicxxmh').DataTable( {
				ajax: {
					url: "../../models/iicxxmh/iicxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iicxxmh = show_deleted_iicxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iicxxmh.id",visible:false },
					{ data: "iicxxmh.kode" },
					{ data: "iicxxmh.nama" },
					{ data: "iicxxmh.keterangan" },
					{ 
						data: "iicxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iicxxmh';
						$table       = 'tbliicxxmh';
						$edt         = 'edtiicxxmh';
						$show_status = '_iicxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h','view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
				},
				rowCallback: function( row, data, index ) {
					if ( data.iicxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iicxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );
			
			tbliicxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliicxxmh);
			} );
			
			tbliicxxmh.on( 'select', function( e, dt, type, indexes ) {
				iicxxmh_data    	= tbliicxxmh.row( { selected: true } ).data().iicxxmh;
				id_iicxxmh      	= iicxxmh_data.id;
				id_transaksi_h 		= id_iicxxmh; // dipakai untuk general
				id_transaksi_log	= id_iicxxmh; // dipakai untuk general
				transaction_state   = iicxxmh_data.transaction_state;

				// atur hak akses
				CekSelectHeaderH(tbliicxxmh);
			} );

			tbliicxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iicxxmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliicxxmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
