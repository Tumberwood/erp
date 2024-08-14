<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wdpxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwdpxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th rowspan=2>Item Code</th>
								<th rowspan=2>Item Name</th>
								<th rowspan=2>LPN</th>
								<th colspan=3>Picking List</th>
								<th colspan=3>Picking</th>
								<th colspan=3>Dispatch</th>
								<th colspan=2>Delivery Note</th>
							</tr>
							<tr>
								<th>Kode</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Kode</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Kode</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Kode</th>
								<th>Qty</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdpxxrd/fn/wdpxxrd_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwdpxxth, tblwdpxxth, show_deleted_wdpxxth = 0, id_wdpxxth;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('wdpxxth');
		
		$(document).ready(function() {
			
			tblwdpxxth = $('#tblwdpxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/outbound_r/outbound_r.php",
					type: 'POST',
					data: function (d){
					}
				},
				order: [[ 2, "asc" ]],
				responsive: false,
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
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "wlpxxmh_kode" },
					{ data: "kode_pl" },
					{ 
						data: "jumlah_pl", //4
						...renderNumber(2)
					},
					{ data: "ket_pl" },
					{ data: "kode_pc" },
					{ 
						data: "jumlah_pc", //4
						...renderNumber(2)
					},
					{ data: "ket_pc" },
					{ data: "kode_dp" },
					{ 
						data: "jumlah_dp", //4
						...renderNumber(2)
					},
					{ data: "ket_dp" },
					{ data: "kode_dn" },
					{ 
						data: "jumlah_dn", //4
						...renderNumber(2)
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wdpxxth';
						$table       = 'tblwdpxxth';
						$edt         = 'edtwdpxxth';
						$show_status = '_wdpxxth';
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
					if ( data.ket_pl != 'Lunas' ) {
						$('td', row).addClass('bg-warning');
					}
					if ( data.ket_pc != 'Lunas' ) {
						$('td', row).addClass('bg-warning');
					}
					if ( data.ket_dp != 'Lunas' ) {
						$('td', row).addClass('bg-warning');
					}
				}
			} );

			tblwdpxxth.searchPanes.container().appendTo('#spwdpxxth');
			tblwdpxxth.searchBuilder.container().appendTo( '#sbwdpxxth' );
			
			tblwdpxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwdpxxth);
			} );
			
			tblwdpxxth.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('wdpxxth');

				// atur hak akses
				CekSelectHeaderH(tblwdpxxth);
			} );

			tblwdpxxth.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('wdpxxth');

				// atur hak akses
				CekDeselectHeaderH(tblwdpxxth);
			} );

			// END wdpxxth
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
