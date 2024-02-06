<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iumxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliumxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iumxxmh/fn/iumxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiumxxmh, tbliumxxmh, show_deleted_iumxxmh = 0, id_iumxxmh;
		// ------------- end of default variable

		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiumxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iumxxmh/iumxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iumxxmh = show_deleted_iumxxmh;
					}
				},
				table: "#tbliumxxmh",
				fields: [ 
					{
						label: "iumxxmh.start_at",
						name: "iumxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "iumxxmh.finish_at",
						name: "iumxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iumxxmh",
						type: "hidden"
					},	
					{
						label: "iumxxmh.transaction_state",
						name: "iumxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iumxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iumxxmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iumxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiumxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiumxxmh.field('iumxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbliumxxmh.rows().deselect();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiumxxmh.field('iumxxmh.kode').enable();
						edtiumxxmh.field('iumxxmh.nama').enable();
					}else{
						edtiumxxmh.field('iumxxmh.kode').disable();
						edtiumxxmh.field('iumxxmh.nama').disable();
					}
				}
				
			});

			edtiumxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiumxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					kode = edtiumxxmh.field('iumxxmh.kode').val();
					nama = edtiumxxmh.field('iumxxmh.nama').val();

					validasiRequired(
						edtiumxxmh,
						'iumxxmh',
						{
							'kode': kode,
							'nama': nama

						}
					);

					validasiCekUnik(
						action,
						edtiumxxmh,
						'iumxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_iumxxmh
					);

					validasiCekUnik(
						action,
						edtiumxxmh,
						'iumxxmh',
						'name',
						'name',
						'"'+name+'"',
						id_iumxxmh
					);

				}
				
				if ( edtiumxxmh.inError() ) {
					return false;
				}
			});
			
			edtiumxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiumxxmh.field('iumxxmh.finish_at').val(finish_at);
			});

			edtiumxxmh.on( 'close', function () {
				edtiumxxmh.enable();
			} );

			//start datatables
			tbliumxxmh = $('#tbliumxxmh').DataTable( {
				ajax: {
					url: "../../models/iumxxmh/iumxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iumxxmh = show_deleted_iumxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iumxxmh.id",visible:false },
					{ data: "iumxxmh.kode" },
					{ data: "iumxxmh.nama" },
					{ data: "iumxxmh.keterangan" },
					{ 
						data: "iumxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iumxxmh';
						$table       = 'tbliumxxmh';
						$edt         = 'edtiumxxmh';
						$show_status = '_iumxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
				},
				rowCallback: function( row, data, index ) {
					if ( data.iumxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iumxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );
			
			tbliumxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliumxxmh);
			} );
			
			tbliumxxmh.on( 'select', function( e, dt, type, indexes ) {
				iumxxmh_data    		= tbliumxxmh.row( { selected: true } ).data().iumxxmh;
				id_iumxxmh      		= iumxxmh_data.id;
				id_transaksi_h 		= id_iumxxmh; // dipakai untuk general
				id_transaksi_log	= id_iumxxmh; // dipakai untuk general
				transaction_state   = iumxxmh_data.transaction_state;
				approval_state   	= iumxxmh_data.approval_state;
				is_nextprocess 		= iumxxmh_data.is_nextprocess;
				is_jurnal      		= iumxxmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tbliumxxmh);
			} );

			tbliumxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iumxxmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliumxxmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
