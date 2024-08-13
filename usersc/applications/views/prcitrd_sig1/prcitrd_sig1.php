<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'prcxxth_sig1';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblprcxxth_sig1" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>No Doc</th>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prcxxth_sig1/fn/prcxxth_sig1_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprcxxth_sig1, tblprcxxth_sig1, show_deleted_prcxxth_sig1 = 0, id_prcxxth_sig1;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('prcxxth_sig1');

	$(document).ready(function() {
		// BEGIN prcxxth_sig1
		tblprcxxth_sig1 = $('#tblprcxxth_sig1').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/prcitrd_sig1/prcitrd_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth_sig1 = show_deleted_prcxxth_sig1;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4,5,6]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "prcittd_sig1.id",visible:false },
				{ data: "prcxxth_sig1.tanggal" },
				{ data: "prcxxth_sig1.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "prcittd_sig1.jumlah_unit",
					...renderNumber()
				},
				{ data: "iumxxmh_unit.kode" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcxxth_sig1';
					$table       = 'tblprcxxth_sig1';
					$edt         = 'edtprcxxth_sig1';
					$show_status = '_prcxxth_sig1';
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
				if ( data.prcxxth_sig1.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prcxxth_sig1.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprcxxth_sig1.searchPanes.container().appendTo('#spprcxxth_sig1');
		tblprcxxth_sig1.searchBuilder.container().appendTo( '#sbprcxxth_sig1' );
		
		tblprcxxth_sig1.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblprcxxth_sig1);
		} );
		
		tblprcxxth_sig1.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prcxxth_sig1');
			// atur hak akses
			CekSelectHeaderH(tblprcxxth_sig1);
		} );

		tblprcxxth_sig1.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('prcxxth_sig1');

			// atur hak akses
			CekDeselectHeaderH(tblprcxxth_sig1);
		} );

		// END prcxxth_sig1
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
