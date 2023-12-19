<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iiggrmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliiggrmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iiggrmh/fn/iiggrmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiiggrmh, tbliiggrmh, show_deleted_iiggrmh = 0, id_iiggrmh;
		// ------------- end of default variable
		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiiggrmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iiggrmh/iiggrmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iiggrmh = show_deleted_iiggrmh;
					}
				},
				table: "#tbliiggrmh",
				fields: [ 
					{
						label: "iiggrmh.start_at",
						name: "iiggrmh.start_at",
						type: "hidden"
					},	
					{
						label: "iiggrmh.finish_at",
						name: "iiggrmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iiggrmh",
						type: "hidden"
					},	
					{
						label: "iiggrmh.transaction_state",
						name: "iiggrmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iiggrmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iiggrmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iiggrmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiiggrmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiiggrmh.field('iiggrmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbliiggrmh.rows().deselect();
				}
			});

			edtiiggrmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiiggrmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi iiggrmh.kode
					if ( ! edtiiggrmh.field('iiggrmh.kode').isMultiValue() ) {
						kode = edtiiggrmh.field('iiggrmh.kode').val();
						if(!kode || kode == ''){
							edtiiggrmh.field('iiggrmh.kode').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iiggrmh.kode
						if(action == 'create'){
							id_iiggrmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iiggrmh',
								nama_field: 'kode',
								nama_field_value: '"'+kode+'"',
								id_transaksi: id_iiggrmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiiggrmh.field('iiggrmh.kode').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iiggrmh.kode
					}
					// END of validasi iiggrmh.kode
					
					// BEGIN of validasi iiggrmh.nama
					if ( ! edtiiggrmh.field('iiggrmh.nama').isMultiValue() ) {
						nama = edtiiggrmh.field('iiggrmh.nama').val();
						if(!nama || nama == ''){
							edtiiggrmh.field('iiggrmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iiggrmh.nama
						if(action == 'create'){
							id_iiggrmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iiggrmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_iiggrmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiiggrmh.field('iiggrmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iiggrmh.nama
					}
					// END of validasi iiggrmh.nama
				}
				
				if ( edtiiggrmh.inError() ) {
					return false;
				}
			});
			
			edtiiggrmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiiggrmh.field('iiggrmh.finish_at').val(finish_at);
			});

			edtiiggrmh.on( 'close', function () {
				edtiiggrmh.enable();
			} );

			//start datatables
			tbliiggrmh = $('#tbliiggrmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/iiggrmh/iiggrmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iiggrmh = show_deleted_iiggrmh;
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
					{ data: "iiggrmh.id",visible:false },
					{ data: "iiggrmh.kode" },
					{ data: "iiggrmh.nama" },
					{ data: "iiggrmh.keterangan" },
					{ 
						data: "iiggrmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iiggrmh';
						$table       = 'tbliiggrmh';
						$edt         = 'edtiiggrmh';
						$show_status = '_iiggrmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.iiggrmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iiggrmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliiggrmh.searchPanes.container().appendTo('#spiiggrmh');
			tbliiggrmh.searchBuilder.container().appendTo( '#sbiiggrmh' );
			
			tbliiggrmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliiggrmh);
			} );
			
			tbliiggrmh.on( 'select', function( e, dt, type, indexes ) {
				iiggrmh_data    		= tbliiggrmh.row( { selected: true } ).data().iiggrmh;
				id_iiggrmh      		= iiggrmh_data.id;
				id_transaksi_h 		= id_iiggrmh; // dipakai untuk general
				id_transaksi_log	= id_iiggrmh; // dipakai untuk general
				transaction_state   = iiggrmh_data.transaction_state;
				approval_state   	= iiggrmh_data.approval_state;
				is_nextprocess 		= iiggrmh_data.is_nextprocess;
				is_jurnal      		= iiggrmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tbliiggrmh);
			} );

			tbliiggrmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iiggrmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tbliiggrmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
