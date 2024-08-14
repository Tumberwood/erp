<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wpcxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwpcxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>id_wpcxxth</th>
								<th>Tanggal</th>
								<th>Kode</th>
								<th>User</th>
								<th>Warehouse</th>
								<th>Lokasi Asal</th>
								<th>Lokasi Tujuan</th>
								<th>LPN</th>
								<th>Item Code</th>
								<th>Item Name</th>
								<th>UoM</th>
								<th>Jumlah Unit</th>
								<th>Batch Number</th>
								<th>Expired Date</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpcxxrd/fn/wpcxxrd_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwpcxxth, tblwpcxxth, show_deleted_wpcxxth = 0, id_wpcxxth;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('wpcxxth');
		
		$(document).ready(function() {
			
			tblwpcxxth = $('#tblwpcxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/wpcxxrd/wpcxxrd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wpcxxth = show_deleted_wpcxxth;
					}
				},
				order: [[ 2, "desc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [2,5,6]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				columns: [
					{ data: "wpclptd.id",visible:false },
					{ data: "wpclptd.id_wpcxxth",visible:false },
					{ data: "tanggal_confirm" },
					{ data: "wpclptd.kode" },
					{ data: "username" },
					{ data: "iwhxxmh.kode" },
					{ data: "asal.nama" },
					{ data: "tujuan.nama" },
					{ data: "wpclptd.wlpxxmh_kode" },
					{ data: "iimxxmh.kode" },
					{ data: "iimxxmh.nama" },
					{ data: "iumxxmh.kode" },
					{ 
						data: "wpclptd.jumlah_unit", //4
						...renderNumber(2)
					},
					{ data: "wpclptd.batch_number" },
					{ data: "wpclptd.expired_date" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wpcxxth';
						$table       = 'tblwpcxxth';
						$edt         = 'edtwpcxxth';
						$show_status = '_wpcxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
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
					if ( data.wpcxxth.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.wpcxxth.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblwpcxxth.searchPanes.container().appendTo('#spwpcxxth');
			tblwpcxxth.searchBuilder.container().appendTo( '#sbwpcxxth' );
			
			tblwpcxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwpcxxth);
			} );
			
			tblwpcxxth.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('wpcxxth');

				// atur hak akses
				CekSelectHeaderH(tblwpcxxth);
			} );

			tblwpcxxth.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('wpcxxth');

				// atur hak akses
				CekDeselectHeaderH(tblwpcxxth);
			} );

			// END wpcxxth
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
