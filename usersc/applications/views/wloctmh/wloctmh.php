<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wloctmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwloctmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wloctmh/fn/wloctmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtwloctmh, tblwloctmh, show_deleted_wloctmh = 0, id_wloctmh;
		// ------------- end of default variable
		
		$(document).ready(function() {
			//start datatables editor
			edtwloctmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/wloctmh/wloctmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wloctmh = show_deleted_wloctmh;
					}
				},
				table: "#tblwloctmh",
				fields: [ 
					{
						label: "wloctmh.start_at",
						name: "wloctmh.start_at",
						type: "hidden"
					},	
					{
						label: "wloctmh.finish_at",
						name: "wloctmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "wloctmh",
						type: "hidden"
					},	
					{
						label: "wloctmh.transaction_state",
						name: "wloctmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "wloctmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "wloctmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "wloctmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtwloctmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwloctmh.field('wloctmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblwloctmh.rows().deselect();
				}
			});

			edtwloctmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtwloctmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edtwloctmh.field('wloctmh.kode').val();
					nama = edtwloctmh.field('wloctmh.nama').val();

					validasiRequired(
						edtwloctmh,
						'wloctmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtwloctmh,
						'wloctmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_wloctmh
					);

					validasiUnique(
						action,
						edtwloctmh,
						'wloctmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_wloctmh
					);
				}
				
				if ( edtwloctmh.inError() ) {
					return false;
				}
			});
			
			edtwloctmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwloctmh.field('wloctmh.finish_at').val(finish_at);
			});

			edtwloctmh.on( 'close', function () {
				edtwloctmh.enable();
			} );

			//start datatables
			tblwloctmh = $('#tblwloctmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/wloctmh/wloctmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wloctmh = show_deleted_wloctmh;
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
					{ data: "wloctmh.id",visible:false },
					{ data: "wloctmh.kode" },
					{ data: "wloctmh.nama" },
					{ data: "wloctmh.keterangan" },
					{ 
						data: "wloctmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wloctmh';
						$table       = 'tblwloctmh';
						$edt         = 'edtwloctmh';
						$show_status = '_wloctmh';
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
					if ( data.wloctmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.wloctmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblwloctmh.searchPanes.container().appendTo('#spwloctmh');
			tblwloctmh.searchBuilder.container().appendTo( '#sbwloctmh' );
			
			tblwloctmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwloctmh);
			} );
			
			tblwloctmh.on( 'select', function( e, dt, type, indexes ) {
				wloctmh_data    		= tblwloctmh.row( { selected: true } ).data().wloctmh;
				id_wloctmh      		= wloctmh_data.id;
				id_transaksi_h 		= id_wloctmh; // dipakai untuk general
				id_transaksi_log	= id_wloctmh; // dipakai untuk general
				transaction_state   = wloctmh_data.transaction_state;
				approval_state   	= wloctmh_data.approval_state;
				is_nextprocess 		= wloctmh_data.is_nextprocess;
				is_jurnal      		= wloctmh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tblwloctmh);
			} );

			tblwloctmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_wloctmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblwloctmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
