<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hbnxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhbnxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hbnxxmh/fn/hbnxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthbnxxmh, tblhbnxxmh, show_deleted_hbnxxmh = 0, id_hbnxxmh;
		// ------------- end of default variable

		$(document).ready(function() {
			//start datatables editor
			edthbnxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/hbnxxmh/hbnxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hbnxxmh = show_deleted_hbnxxmh;
					}
				},
				table: "#tblhbnxxmh",
				fields: [ 
					{
						label: "hbnxxmh.start_at",
						name: "hbnxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "hbnxxmh.finish_at",
						name: "hbnxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "hbnxxmh",
						type: "hidden"
					},	
					{
						label: "hbnxxmh.transaction_state",
						name: "hbnxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "hbnxxmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "hbnxxmh.nama"
					}
				]
			} );

			edthbnxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthbnxxmh.field('hbnxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblhbnxxmh.rows().deselect();
				}
			});

			edthbnxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthbnxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi hbnxxmh.kode
					if ( ! edthbnxxmh.field('hbnxxmh.kode').isMultiValue() ) {
						kode = edthbnxxmh.field('hbnxxmh.kode').val();
						if(!kode || kode == ''){
							edthbnxxmh.field('hbnxxmh.kode').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik hbnxxmh.kode
						if(action == 'create'){
							id_hbnxxmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'hbnxxmh',
								nama_field: 'kode',
								nama_field_value: '"'+kode+'"',
								id_transaksi: id_hbnxxmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edthbnxxmh.field('hbnxxmh.kode').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik hbnxxmh.kode
					}
					// END of validasi hbnxxmh.kode
					
					// BEGIN of validasi hbnxxmh.nama
					if ( ! edthbnxxmh.field('hbnxxmh.nama').isMultiValue() ) {
						nama = edthbnxxmh.field('hbnxxmh.nama').val();
						if(!nama || nama == ''){
							edthbnxxmh.field('hbnxxmh.nama').error( 'Wajib diisi!' );
						}
						
						// BEGIN of cek unik hbnxxmh.nama
						if(action == 'create'){
							id_hbnxxmh = 0;
						}
						
						$.ajax( {
							url: '../../../helpers/validate_fn_unique.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name: 'hbnxxmh',
								nama_field: 'nama',
								nama_field_value: '"'+nama+'"',
								id_transaksi: id_hbnxxmh
							},
							success: function ( json ) {
								if(json.data.count == 1){
									edthbnxxmh.field('hbnxxmh.nama').error( 'Data tidak boleh kembar!' );
								}
							}
						} );
						// END of cek unik hbnxxmh.nama
					}
					// END of validasi hbnxxmh.nama
				}
				
				if ( edthbnxxmh.inError() ) {
					return false;
				}
			});
			
			edthbnxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthbnxxmh.field('hbnxxmh.finish_at').val(finish_at);
			});

			edthbnxxmh.on( 'close', function () {
				edthbnxxmh.enable();
			} );

			//start datatables
			tblhbnxxmh = $('#tblhbnxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/hbnxxmh/hbnxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_hbnxxmh = show_deleted_hbnxxmh;
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
					{ data: "hbnxxmh.id",visible:false },
					{ data: "hbnxxmh.kode" , type: 'string'},
					{ data: "hbnxxmh.nama" },
					{ 
						data: "hbnxxmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_hbnxxmh';
						$table       = 'tblhbnxxmh';
						$edt         = 'edthbnxxmh';
						$show_status = '_hbnxxmh';
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
					if ( data.hbnxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.hbnxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhbnxxmh.searchPanes.container().appendTo('#sphbnxxmh');
			tblhbnxxmh.searchBuilder.container().appendTo( '#sbhbnxxmh' );
			
			tblhbnxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhbnxxmh);
			} );
			
			tblhbnxxmh.on( 'select', function( e, dt, type, indexes ) {
				hbnxxmh_data    	= tblhbnxxmh.row( { selected: true } ).data().hbnxxmh;
				id_hbnxxmh      	= hbnxxmh_data.id;
				id_transaksi_h 		= id_hbnxxmh; // dipakai untuk general
				id_transaksi_log	= id_hbnxxmh; // dipakai untuk general
				transaction_state   = hbnxxmh_data.transaction_state;
				approval_state   	= hbnxxmh_data.approval_state;
				is_nextprocess 		= hbnxxmh_data.is_nextprocess;
				is_jurnal      		= hbnxxmh_data.is_jurnal;
				
				id_hbnxxmh_parent_old = hbnxxmh_data.id_hbnxxmh_parent;

				// atur hak akses
				CekSelectHeaderH(tblhbnxxmh);
			} );

			tblhbnxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_hbnxxmh = 0;
				id_hbnxxmh_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhbnxxmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
