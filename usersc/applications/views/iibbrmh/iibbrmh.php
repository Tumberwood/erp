<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iibbrmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliibbrmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iibbrmh/fn/iibbrmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiibbrmh, tbliibbrmh, show_deleted_iibbrmh = 0, id_iibbrmh;
		// ------------- end of default variable

		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiibbrmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iibbrmh/iibbrmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iibbrmh = show_deleted_iibbrmh;
					}
				},
				table: "#tbliibbrmh",
				fields: [ 
					{
						label: "iibbrmh.start_at",
						name: "iibbrmh.start_at",
						type: "hidden"
					},	
					{
						label: "iibbrmh.finish_at",
						name: "iibbrmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iibbrmh",
						type: "hidden"
					},	
					{
						label: "iibbrmh.transaction_state",
						name: "iibbrmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iibbrmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iibbrmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iibbrmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiibbrmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiibbrmh.field('iibbrmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbliibbrmh.rows().deselect();

					edtiibbrmh.field('iibbrmh.kode').enable();
					edtiibbrmh.field('iibbrmh.nama').enable();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiibbrmh.field('iibbrmh.kode').enable();
						edtiibbrmh.field('iibbrmh.nama').enable();
					}else{
						edtiibbrmh.field('iibbrmh.kode').disable();
						edtiibbrmh.field('iibbrmh.nama').disable();
					}
				}
			});

			edtiibbrmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiibbrmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi iibbrmh.kode
					if ( ! edtiibbrmh.field('iibbrmh.kode').isMultiValue() ) {
						kode = edtiibbrmh.field('iibbrmh.kode').val();
						if(!kode || kode == ''){
							edtiibbrmh.field('iibbrmh.kode').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iibbrmh.kode
						if(action == 'create'){
							id_iibbrmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iibbrmh',
								nama_field: 'kode',
								nama_field_value: '"'+kode+'"',
								id_transaksi: id_iibbrmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiibbrmh.field('iibbrmh.kode').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iibbrmh.kode
					}
					// END of validasi iibbrmh.kode
					
					// BEGIN of validasi iibbrmh.nama
					if ( ! edtiibbrmh.field('iibbrmh.nama').isMultiValue() ) {
						nama = edtiibbrmh.field('iibbrmh.nama').val();
						if(!nama || nama == ''){
							edtiibbrmh.field('iibbrmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iibbrmh.nama
						if(action == 'create'){
							id_iibbrmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iibbrmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_iibbrmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiibbrmh.field('iibbrmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iibbrmh.nama
					}
					// END of validasi iibbrmh.nama
				}
				
				if ( edtiibbrmh.inError() ) {
					return false;
				}
			});
			
			edtiibbrmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiibbrmh.field('iibbrmh.finish_at').val(finish_at);
			});

			edtiibbrmh.on( 'close', function () {
				edtiibbrmh.enable();
			} );

			//start datatables
			tbliibbrmh = $('#tbliibbrmh').DataTable( {
				ajax: {
					url: "../../models/iibbrmh/iibbrmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iibbrmh = show_deleted_iibbrmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iibbrmh.id",visible:false },
					{ data: "iibbrmh.kode" },
					{ data: "iibbrmh.nama" },
					{ data: "iibbrmh.keterangan" },
					{ 
						data: "iibbrmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iibbrmh';
						$table       = 'tbliibbrmh';
						$edt         = 'edtiibbrmh';
						$show_status = '_iibbrmh';
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
					if ( data.iibbrmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iibbrmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );
			
			tbliibbrmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliibbrmh);
			} );
			
			tbliibbrmh.on( 'select', function( e, dt, type, indexes ) {
				iibbrmh_data    		= tbliibbrmh.row( { selected: true } ).data().iibbrmh;
				id_iibbrmh      		= iibbrmh_data.id;
				id_transaksi_h 		= id_iibbrmh; // dipakai untuk general
				id_transaksi_log	= id_iibbrmh; // dipakai untuk general
				transaction_state   = iibbrmh_data.transaction_state;
				approval_state   	= iibbrmh_data.approval_state;
				is_nextprocess 		= iibbrmh_data.is_nextprocess;
				is_jurnal      		= iibbrmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tbliibbrmh);
			} );

			tbliibbrmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iibbrmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliibbrmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
