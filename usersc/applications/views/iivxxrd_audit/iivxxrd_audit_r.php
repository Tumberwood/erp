<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iivxxrd_audit';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliivxxrd_audit" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th rowspan="2">ID</th>
								<th rowspan="2">Tanggal</th>
								<th rowspan="2">Kode Doc</th>
								<th rowspan="2">Warehouse</th>
								<th rowspan="2">Location</th>
								<th rowspan="2">Item Kode</th>
								<th rowspan="2">Item Nama</th>
								<th colspan="2">Terkecil</th>
								<th colspan="2">Default</th>
								<th rowspan="2">LPN</th>
								<th rowspan="2">Batch Number</th>
								<th rowspan="2">Expired Date</th>
								<th rowspan="2">Status Audit</th>
							</tr>
							<tr>
								<th>Jumlah</th>
								<th>UoM</th>
								<th>Jumlah</th>
								<th>UoM</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iivxxrd_audit/fn/iivxxrd_audit_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtiivxxrd_audit, tbliivxxrd_audit, show_deleted_iivxxrd_audit = 0, id_iivxxrd_audit;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('iivxxrd_audit');
		
		$(document).ready(function() {
			
			tbliivxxrd_audit = $('#tbliivxxrd_audit').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/iivxxrd_audit/iivxxrd_audit.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iivxxrd_audit = show_deleted_iivxxrd_audit;
					}
				},
				order: [[ 1, "desc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,9]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				columns: [
					{ data: "iivxxrd_audit.id",visible:false },
					{ data: "tanggal_confirm" },
					{ data: "iivxxrd_audit.kode" },
					{ data: "iivxxrd_audit.iwhxxmh_kode" },
					{ data: "iivxxrd_audit.wloxxmh_nama" },
					{ data: "iivxxrd_audit.iimxxmh_kode" },
					{ data: "iivxxrd_audit.iimxxmh_nama" },
					{ 
						data: "iivxxrd_audit.jumlah_terkecil", //4
						...renderNumber(0)
					},
					{ data: "iivxxrd_audit.iumxxmh_terkecil_kode" },//5
					{ 
						data: "iivxxrd_audit.jumlah_default",
						render: function (data){
							return data.toString().replace(/\.?0+$/, '');
						},
						class: "text-right"
					},
					{ data: "iivxxrd_audit.iumxxmh_default_kode" },
					{ data: "iivxxrd_audit.wlpxxmh_kode" },
					{ data: "iivxxrd_audit.batch_number" },
					{ data: "iivxxrd_audit.expired_date" },
					{ 
						data: "iivxxrd_audit.status_audit",
						render: function (data){
							if (data == 0) {
								return '<span class="badge badge-plain">Tidak OK</span>';
							} else if (data == 1) {
								return '<span class="badge badge-primary">OK</span>';
							} else {
								return '<span class="badge badge-warning">INVALID</span>';
							}
						}
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iivxxrd_audit';
						$table       = 'tbliivxxrd_audit';
						$edt         = 'edtiivxxrd_audit';
						$show_status = '_iivxxrd_audit';
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
					if ( data.iivxxrd_audit.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iivxxrd_audit.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliivxxrd_audit.searchPanes.container().appendTo('#spiivxxrd_audit');
			tbliivxxrd_audit.searchBuilder.container().appendTo( '#sbiivxxrd_audit' );
			
			tbliivxxrd_audit.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliivxxrd_audit);
			} );
			
			tbliivxxrd_audit.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('iivxxrd_audit');

				// atur hak akses
				CekSelectHeaderH(tbliivxxrd_audit);
			} );

			tbliivxxrd_audit.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('iivxxrd_audit');

				// atur hak akses
				CekDeselectHeaderH(tbliivxxrd_audit);
			} );

			// END iivxxrd_audit
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
