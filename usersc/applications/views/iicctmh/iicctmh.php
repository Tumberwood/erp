<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iicctmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliicctmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iicctmh/fn/iicctmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiicctmh, tbliicctmh, show_deleted_iicctmh = 0, id_iicctmh;
		// ------------- end of default variable
		
		$(document).ready(function() {
			//start datatables editor
			edtiicctmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iicctmh/iicctmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iicctmh = show_deleted_iicctmh;
					}
				},
				table: "#tbliicctmh",
				fields: [ 
					{
						label: "iicctmh.start_at",
						name: "iicctmh.start_at",
						type: "hidden"
					},	
					{
						label: "iicctmh.finish_at",
						name: "iicctmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iicctmh",
						type: "hidden"
					},	
					{
						label: "iicctmh.transaction_state",
						name: "iicctmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iicctmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iicctmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iicctmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiicctmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiicctmh.field('iicctmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbliicctmh.rows().deselect();
				}
			});

			edtiicctmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiicctmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi iicctmh.kode
					if ( ! edtiicctmh.field('iicctmh.kode').isMultiValue() ) {
						kode = edtiicctmh.field('iicctmh.kode').val();
						if(!kode || kode == ''){
							edtiicctmh.field('iicctmh.kode').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iicctmh.kode
						if(action == 'create'){
							id_iicctmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iicctmh',
								nama_field: 'kode',
								nama_field_value: '"'+kode+'"',
								id_transaksi: id_iicctmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiicctmh.field('iicctmh.kode').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iicctmh.kode
					}
					// END of validasi iicctmh.kode
					
					// BEGIN of validasi iicctmh.nama
					if ( ! edtiicctmh.field('iicctmh.nama').isMultiValue() ) {
						nama = edtiicctmh.field('iicctmh.nama').val();
						if(!nama || nama == ''){
							edtiicctmh.field('iicctmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iicctmh.nama
						if(action == 'create'){
							id_iicctmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iicctmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_iicctmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiicctmh.field('iicctmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iicctmh.nama
					}
					// END of validasi iicctmh.nama
				}
				
				if ( edtiicctmh.inError() ) {
					return false;
				}
			});
			
			edtiicctmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiicctmh.field('iicctmh.finish_at').val(finish_at);
			});

			edtiicctmh.on( 'close', function () {
				edtiicctmh.enable();
			} );

			//start datatables
			tbliicctmh = $('#tbliicctmh').DataTable( {
				ajax: {
					url: "../../models/iicctmh/iicctmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iicctmh = show_deleted_iicctmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iicctmh.id",visible:false },
					{ data: "iicctmh.kode" },
					{ data: "iicctmh.nama" },
					{ data: "iicctmh.keterangan" },
					{ 
						data: "iicctmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iicctmh';
						$table       = 'tbliicctmh';
						$edt         = 'edtiicctmh';
						$show_status = '_iicctmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h','view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
				},
				rowCallback: function( row, data, index ) {
					if ( data.iicctmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iicctmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );
			
			tbliicctmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliicctmh);
			} );
			
			tbliicctmh.on( 'select', function( e, dt, type, indexes ) {
				iicctmh_data    		= tbliicctmh.row( { selected: true } ).data().iicctmh;
				id_iicctmh      		= iicctmh_data.id;
				id_transaksi_h 		= id_iicctmh; // dipakai untuk general
				id_transaksi_log	= id_iicctmh; // dipakai untuk general
				transaction_state   = iicctmh_data.transaction_state;
				approval_state   	= iicctmh_data.approval_state;
				is_nextprocess 		= iicctmh_data.is_nextprocess;
				is_jurnal      		= iicctmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tbliicctmh);
			} );

			tbliicctmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iicctmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliicctmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
