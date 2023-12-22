<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iittpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliittpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iittpmh/fn/iittpmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiittpmh, tbliittpmh, show_deleted_iittpmh = 0, id_iittpmh;
		// ------------- end of default variable

		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiittpmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iittpmh/iittpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iittpmh = show_deleted_iittpmh;
					}
				},
				table: "#tbliittpmh",
				fields: [ 
					{
						label: "iittpmh.start_at",
						name: "iittpmh.start_at",
						type: "hidden"
					},	
					{
						label: "iittpmh.finish_at",
						name: "iittpmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iittpmh",
						type: "hidden"
					},	
					{
						label: "iittpmh.transaction_state",
						name: "iittpmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iittpmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iittpmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiittpmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiittpmh.field('iittpmh.start_at').val(start_at);

				if(action == 'create'){
					tbliittpmh.rows().deselect();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiittpmh.field('iittpmh.kode').enable();
						edtiittpmh.field('iittpmh.nama').enable();
					}else{
						edtiittpmh.field('iittpmh.kode').disable();
						edtiittpmh.field('iittpmh.nama').disable();
					}
				}
			});

			edtiittpmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiittpmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
					// BEGIN of validasi iittpmh.nama
					if ( ! edtiittpmh.field('iittpmh.nama').isMultiValue() ) {
						nama = edtiittpmh.field('iittpmh.nama').val();
						if(!nama || nama == ''){
							edtiittpmh.field('iittpmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iittpmh.nama
						if(action == 'create'){
							id_iittpmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iittpmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_iittpmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiittpmh.field('iittpmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iittpmh.nama
					}
					// END of validasi iittpmh.nama
				}
				
				if ( edtiittpmh.inError() ) {
					return false;
				}
			});
			
			edtiittpmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiittpmh.field('iittpmh.finish_at').val(finish_at);
			});

			edtiittpmh.on( 'close', function () {
				edtiittpmh.enable();
			} );

			//start datatables
			tbliittpmh = $('#tbliittpmh').DataTable( {
				ajax: {
					url: "../../models/iittpmh/iittpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iittpmh = show_deleted_iittpmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iittpmh.id",visible:false },
					{ data: "iittpmh.nama" },
					{ data: "iittpmh.keterangan" },
					{ 
						data: "iittpmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iittpmh';
						$table       = 'tbliittpmh';
						$edt         = 'edtiittpmh';
						$show_status = '_iittpmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
				},
				rowCallback: function( row, data, index ) {
					if ( data.iittpmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iittpmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliittpmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliittpmh);
			} );
			
			tbliittpmh.on( 'select', function( e, dt, type, indexes ) {
				iittpmh_data    	= tbliittpmh.row( { selected: true } ).data().iittpmh;
				id_iittpmh      	= iittpmh_data.id;
				id_transaksi_h 		= id_iittpmh; // dipakai untuk general
				id_transaksi_log	= id_iittpmh; // dipakai untuk general
				transaction_state   = iittpmh_data.transaction_state;
				is_defaultprogram   = iittpmh_data.is_defaultprogram;

				// atur hak akses
				CekSelectHeaderH(tbliittpmh);
			} );

			tbliittpmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iittpmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliittpmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
