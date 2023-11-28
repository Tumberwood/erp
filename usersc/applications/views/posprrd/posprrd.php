<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'podittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblpodittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Purchase Request</th>
                                <th>Purchase Order</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>PR Qty</th>
                                <th>PR UoM</th>
                                <th>PO Qty</th>
                                <th>PO UoM</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/posprrd/fn/posprrd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtpodittd, tblpodittd, show_deleted_podittd = 0, id_podittd;
		// ------------- end of default variable
		
		$(document).ready(function() {
			
			//start datatables
			tblpodittd = $('#tblpodittd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/posprrd/posprrd.php",
					type: 'POST',
					data: function (d){
						
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,3,4]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0]
					}
				],
				responsive: false,
				scrollX: true,
				columns: [
					{ data: "podittd.id",visible:false },
					{ data: "prqxxth.kode" },
					{ data: "podxxth.kode" },
					{ data: "iimxxmh.kode" },
					{ data: "iimxxmh.nama" },
					{ data: "prqittd.jumlah_unit" },
					{ data: "ium_pr.nama" },
					{ data: "podittd.jumlah_unit" },
					{ data: "ium_po.nama" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_podittd';
						$table       = 'tblpodittd';
						$edt         = 'edtpodittd';
						$show_status = '_podittd';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= [];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				}
			} );

			tblpodittd.searchPanes.container().appendTo('#sppodittd');
			tblpodittd.searchBuilder.container().appendTo( '#sbpodittd' );
			
			tblpodittd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblpodittd);
			} );
			
			tblpodittd.on( 'select', function( e, dt, type, indexes ) {
				podittd_data    		= tblpodittd.row( { selected: true } ).data().podittd;
				id_podittd      		= podittd_data.id;
				id_transaksi_h 		= id_podittd; // dipakai untuk general
				id_transaksi_log	= id_podittd; // dipakai untuk general
				transaction_state   = podittd_data.transaction_state;
				approval_state   	= podittd_data.approval_state;
				is_nextprocess 		= podittd_data.is_nextprocess;
				is_jurnal      		= podittd_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tblpodittd);
			} );

			tblpodittd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_podittd = 0;

				// atur hak akses
				CekDeselectHeaderH(tblpodittd);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
