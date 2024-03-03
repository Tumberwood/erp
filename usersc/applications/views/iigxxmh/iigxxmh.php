<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iigxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliigxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iigxxmh/fn/iigxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiigxxmh, tbliigxxmh, show_deleted_iigxxmh = 0, id_iigxxmh;
		// ------------- end of default variable
		is_need_generate_kode = 1, is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
			edtiigxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iigxxmh/iigxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iigxxmh = show_deleted_iigxxmh;
					}
				},
				table: "#tbliigxxmh",
				formOptions: {
					main: {
						focus: 6,
					}
				},
				fields: [ 
					{
						label: "kategori_dokumen",
						name: "kategori_dokumen",
						type: "hidden"
					},
					{
						label: "kategori_dokumen_value",
						name: "kategori_dokumen_value",
						type: "hidden"
					},
					{
						label: "iigxxmh.start_at",
						name: "iigxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "iigxxmh.finish_at",
						name: "iigxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iigxxmh",
						type: "hidden"
					},	
					{
						label: "iigxxmh.transaction_state",
						name: "iigxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iigxxmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iigxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiigxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiigxxmh.field('iigxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbliigxxmh.rows().deselect();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiigxxmh.field('iigxxmh.nama').enable();

						edtiigxxmh.field('kategori_dokumen').val('');
						edtiigxxmh.field('kategori_dokumen_value').val('');
					}else{
						edtiigxxmh.field('iigxxmh.nama').disable();
					}
				}
			});

			edtiigxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiigxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama = edtiigxxmh.field('iigxxmh.nama').val();
					validasiRequired(
						edtiigxxmh,
						'iigxxmh',
						{
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtiigxxmh,
						'iigxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_iigxxmh,
					);
				
				}
				
				if ( edtiigxxmh.inError() ) {
					return false;
				}
			});
			
			edtiigxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiigxxmh.field('iigxxmh.finish_at').val(finish_at);
			});

			edtiigxxmh.on( 'close', function () {
				edtiigxxmh.enable();
			} );

			//start datatables
			tbliigxxmh = $('#tbliigxxmh').DataTable( {
				ajax: {
					url: "../../models/iigxxmh/iigxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iigxxmh = show_deleted_iigxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iigxxmh.id",visible:false },
					{ data: "iigxxmh.kode" },
					{ data: "iigxxmh.nama" },
					{ data: "iigxxmh.keterangan" },
					{ 
						data: "iigxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iigxxmh';
						$table       = 'tbliigxxmh';
						$edt         = 'edtiigxxmh';
						$show_status = '_iigxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
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
					if ( data.iigxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iigxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );
			
			tbliigxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliigxxmh);
			} );
			
			tbliigxxmh.on( 'select', function( e, dt, type, indexes ) {
				iigxxmh_data    		= tbliigxxmh.row( { selected: true } ).data().iigxxmh;
				id_iigxxmh      		= iigxxmh_data.id;
				id_transaksi_h 		= id_iigxxmh; // dipakai untuk general
				id_transaksi_log	= id_iigxxmh; // dipakai untuk general
				transaction_state   = iigxxmh_data.transaction_state;
				approval_state   	= iigxxmh_data.approval_state;
				is_nextprocess 		= iigxxmh_data.is_nextprocess;
				is_jurnal      		= iigxxmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tbliigxxmh);
			} );

			tbliigxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iigxxmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tbliigxxmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
