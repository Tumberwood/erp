<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wms_log_r';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwms_log_r" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>id_transaksi</th>
                                <th>Activity</th>
                                <th>Username</th>
                                <th>Start</th>
                                <th>Finish</th>
                                <th>Durasi</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wms_log_r/fn/wms_log_r_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwms_log_r, tblwms_log_r, show_deleted_wms_log_r = 0, id_wms_log_r;
		// ------------- end of default variable

		// get tableRelation
		// tableRelation('wms_log_rheader');
		
		$(document).ready(function() {
			tblwms_log_r = $('#tblwms_log_r').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/wms_log_r/wms_log_r.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wms_log_r = show_deleted_wms_log_r;
					}
				},
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [2,3,4]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				order: [[ 4, "desc" ]],
				columns: [
					{ data: "id",visible:false },
					{ data: "id_transaksi",visible:false },
					{ data: "activity" },
					{ data: "username" },
					{ data: "start_on" },
					{ data: "finish_on" },
					{ data: "durasi" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wms_log_r';
						$table       = 'tblwms_log_r';
						$edt         = 'edtwms_log_r';
						$show_status = '_wms_log_r';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
				}
			} );

			tblwms_log_r.searchPanes.container().appendTo('#spwms_log_r');
			tblwms_log_r.searchBuilder.container().appendTo( '#sbwms_log_r' );
			
			// END wms_log_r
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
