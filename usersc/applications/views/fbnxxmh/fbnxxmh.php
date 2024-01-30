<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fbnxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblfbnxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fbnxxmh/fn/fbnxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfbnxxmh, tblfbnxxmh, show_deleted_fbnxxmh = 0, id_fbnxxmh;
		// ------------- end of default variable

		is_master_table = 1;

		$(document).ready(function() {
			//start datatables editor
			edtfbnxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/fbnxxmh/fbnxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fbnxxmh = show_deleted_fbnxxmh;
					}
				},
				table: "#tblfbnxxmh",
				fields: [ 
					{
						label: "fbnxxmh.start_at",
						name: "fbnxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "fbnxxmh.finish_at",
						name: "fbnxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "fbnxxmh",
						type: "hidden"
					},	
					{
						label: "fbnxxmh.transaction_state",
						name: "fbnxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "fbnxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "fbnxxmh.nama"
					}
				]
			} );

			edtfbnxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfbnxxmh.field('fbnxxmh.start_at').val(start_at);

				if(action == 'create'){
					tblfbnxxmh.rows().deselect();
					edtfbnxxmh.field('fbnxxmh.kode').enable();
					edtfbnxxmh.field('fbnxxmh.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edtfbnxxmh.field('fbnxxmh.kode').enable();
						edtfbnxxmh.field('fbnxxmh.nama').enable();
					}else{
						edtfbnxxmh.field('fbnxxmh.kode').disable();
						edtfbnxxmh.field('fbnxxmh.nama').disable();
					}
				}
			});

			edtfbnxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtfbnxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi fbnxxmh.kode
					if ( ! edtfbnxxmh.field('fbnxxmh.kode').isMultiValue() ) {
						kode = edtfbnxxmh.field('fbnxxmh.kode').val();
						if(!kode || kode == ''){
							edtfbnxxmh.field('fbnxxmh.kode').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik fbnxxmh.kode
						if(action == 'create'){
							id_fbnxxmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'fbnxxmh',
								nama_field: 'kode',
								nama_field_value: '"'+kode+'"',
								id_transaksi: id_fbnxxmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtfbnxxmh.field('fbnxxmh.kode').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik fbnxxmh.kode
					}
					// END of validasi fbnxxmh.kode
					
					// BEGIN of validasi fbnxxmh.nama
					if ( ! edtfbnxxmh.field('fbnxxmh.nama').isMultiValue() ) {
						nama = edtfbnxxmh.field('fbnxxmh.nama').val();
						if(!nama || nama == ''){
							edtfbnxxmh.field('fbnxxmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik fbnxxmh.nama
						if(action == 'create'){
							id_fbnxxmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'fbnxxmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_fbnxxmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edtfbnxxmh.field('fbnxxmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik fbnxxmh.nama
					}
					// END of validasi fbnxxmh.nama
				}
				
				if ( edtfbnxxmh.inError() ) {
					return false;
				}
			});
			
			edtfbnxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfbnxxmh.field('fbnxxmh.finish_at').val(finish_at);
			});

			edtfbnxxmh.on( 'close', function () {
				edtfbnxxmh.enable();
			} );

			//start datatables
			tblfbnxxmh = $('#tblfbnxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/fbnxxmh/fbnxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fbnxxmh = show_deleted_fbnxxmh;
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
					{ data: "fbnxxmh.id",visible:false },
					{ data: "fbnxxmh.kode" , type: 'string'},
					{ data: "fbnxxmh.nama" },
					{ 
						data: "fbnxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_fbnxxmh';
						$table       = 'tblfbnxxmh';
						$edt         = 'edtfbnxxmh';
						$show_status = '_fbnxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.fbnxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.fbnxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblfbnxxmh.searchPanes.container().appendTo('#spfbnxxmh');
			tblfbnxxmh.searchBuilder.container().appendTo( '#sbfbnxxmh' );
			
			tblfbnxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblfbnxxmh);
			} );
			
			tblfbnxxmh.on( 'select', function( e, dt, type, indexes ) {
				fbnxxmh_data    	= tblfbnxxmh.row( { selected: true } ).data().fbnxxmh;
				id_fbnxxmh      	= fbnxxmh_data.id;
				id_transaksi_h 		= id_fbnxxmh; // dipakai untuk general
				id_transaksi_log	= id_fbnxxmh; // dipakai untuk general
				transaction_state   = fbnxxmh_data.transaction_state;
				approval_state   	= fbnxxmh_data.approval_state;
				is_nextprocess 		= fbnxxmh_data.is_nextprocess;
				is_jurnal      		= fbnxxmh_data.is_jurnal;
				
				id_fbnxxmh_parent_old = fbnxxmh_data.id_fbnxxmh_parent;

				// atur hak akses
				CekSelectHeaderH(tblfbnxxmh);
			} );

			tblfbnxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_fbnxxmh = 0;
				id_fbnxxmh_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblfbnxxmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
