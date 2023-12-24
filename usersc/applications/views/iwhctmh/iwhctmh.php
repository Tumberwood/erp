<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iwhctmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliwhctmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iwhctmh/fn/iwhctmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiwhctmh, tbliwhctmh, show_deleted_iwhctmh = 0, id_iwhctmh;
		// ------------- end of default variable

		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiwhctmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iwhctmh/iwhctmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iwhctmh = show_deleted_iwhctmh;
					}
				},
				table: "#tbliwhctmh",
				fields: [ 
					{
						label: "iwhctmh.start_at",
						name: "iwhctmh.start_at",
						type: "hidden"
					},	
					{
						label: "iwhctmh.finish_at",
						name: "iwhctmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iwhctmh",
						type: "hidden"
					},	
					{
						label: "iwhctmh.transaction_state",
						name: "iwhctmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iwhctmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iwhctmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iwhctmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiwhctmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiwhctmh.field('iwhctmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbliwhctmh.rows().deselect();

					edtiwhctmh.field('iwhctmh.kode').enable();
					edtiwhctmh.field('iwhctmh.nama').enable();

				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiwhctmh.field('iwhctmh.kode').enable();
						edtiwhctmh.field('iwhctmh.nama').enable();
					}else{
						edtiwhctmh.field('iwhctmh.kode').disable();
						edtiwhctmh.field('iwhctmh.nama').disable();
					}
				}
			});

			edtiwhctmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiwhctmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi iwhctmh.kode
					if ( ! edtiwhctmh.field('iwhctmh.kode').isMultiValue() ) {
						kode = edtiwhctmh.field('iwhctmh.kode').val();
						if(!kode || kode == ''){
							edtiwhctmh.field('iwhctmh.kode').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iwhctmh.kode
						if(action == 'create'){
							id_iwhctmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iwhctmh',
								nama_field: 'kode',
								nama_field_value: '"'+kode+'"',
								id_transaksi: id_iwhctmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiwhctmh.field('iwhctmh.kode').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iwhctmh.kode
					}
					// END of validasi iwhctmh.kode
					
					// BEGIN of validasi iwhctmh.nama
					if ( ! edtiwhctmh.field('iwhctmh.nama').isMultiValue() ) {
						nama = edtiwhctmh.field('iwhctmh.nama').val();
						if(!nama || nama == ''){
							edtiwhctmh.field('iwhctmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik iwhctmh.nama
						if(action == 'create'){
							id_iwhctmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'iwhctmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_iwhctmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtiwhctmh.field('iwhctmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik iwhctmh.nama
					}
					// END of validasi iwhctmh.nama
				}
				
				if ( edtiwhctmh.inError() ) {
					return false;
				}
			});
			
			edtiwhctmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiwhctmh.field('iwhctmh.finish_at').val(finish_at);
			});

			edtiwhctmh.on( 'close', function () {
				edtiwhctmh.enable();
			} );

			//start datatables
			tbliwhctmh = $('#tbliwhctmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/iwhctmh/iwhctmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iwhctmh = show_deleted_iwhctmh;
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
					{ data: "iwhctmh.id",visible:false },
					{ data: "iwhctmh.kode" },
					{ data: "iwhctmh.nama" },
					{ data: "iwhctmh.keterangan" },
					{ 
						data: "iwhctmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iwhctmh';
						$table       = 'tbliwhctmh';
						$edt         = 'edtiwhctmh';
						$show_status = '_iwhctmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.iwhctmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iwhctmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliwhctmh.searchPanes.container().appendTo('#spiwhctmh');
			tbliwhctmh.searchBuilder.container().appendTo( '#sbiwhctmh' );
			
			tbliwhctmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliwhctmh);
			} );
			
			tbliwhctmh.on( 'select', function( e, dt, type, indexes ) {
				iwhctmh_data    		= tbliwhctmh.row( { selected: true } ).data().iwhctmh;
				id_iwhctmh      		= iwhctmh_data.id;
				id_transaksi_h 		= id_iwhctmh; // dipakai untuk general
				id_transaksi_log	= id_iwhctmh; // dipakai untuk general
				transaction_state   = iwhctmh_data.transaction_state;
				approval_state   	= iwhctmh_data.approval_state;
				is_nextprocess 		= iwhctmh_data.is_nextprocess;
				is_jurnal      		= iwhctmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tbliwhctmh);
			} );

			tbliwhctmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iwhctmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliwhctmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
