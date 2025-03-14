<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'prcxxth_npo';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblprcxxth_npo" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No Doc</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Jumlah</th>
                                <th>UoM</th>
								<th data-i18n="unitPrice"></th>
								<th data-i18n="subtotal"></th>
								<th data-i18n="discount"></th>
								<th data-i18n="total"></th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prcxxth_npo_price_r/fn/prcxxth_npo_price_r_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprcxxth_npo, tblprcxxth_npo, show_deleted_prcxxth_npo = 0, id_prcxxth_npo;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('prcxxth_npo');

	$(document).ready(function() {
		// BEGIN prcxxth_npo
		tblprcxxth_npo = $('#tblprcxxth_npo').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/prcxxth_npo_r/prcxxth_npo_r.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth_npo = show_deleted_prcxxth_npo;
				}
			},
			responsive: false,
			order: [[ 2, "desc" ],[ 1, "asc" ],[ 0, "asc" ]],
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
				{ data: "prcittd_npo.id",visible:false },
				{ data: "prcxxth_npo.kode" },
				{ data: "prcxxth_npo.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "prcittd_npo.jumlah_unit",
					...renderNumber(2)
				},
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "prcittd_npo.harga_unit",
					...renderNumber( 2)
				},
				{ 
					data: "prcittd_npo.subtotal",
					...renderNumber( 2)
				},
				{ 
					data: "prcittd_npo.diskon_final",
					...renderNumber( 2)
				},
				{ 
					data: "prcittd_npo.dpp",
					...renderNumber( 2)
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcxxth_npo';
					$table       = 'tblprcxxth_npo';
					$edt         = 'edtprcxxth_npo';
					$show_status = '_prcxxth_npo';
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
				if ( data.prcxxth_npo.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prcxxth_npo.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprcxxth_npo.searchPanes.container().appendTo('#spprcxxth_npo');
		tblprcxxth_npo.searchBuilder.container().appendTo( '#sbprcxxth_npo' );
		
		tblprcxxth_npo.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblprcxxth_npo);
		} );
		
		tblprcxxth_npo.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prcxxth_npo');
			// atur hak akses
			CekSelectHeaderH(tblprcxxth_npo);
		} );

		tblprcxxth_npo.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('prcxxth_npo');

			// atur hak akses
			CekDeselectHeaderH(tblprcxxth_npo);
		} );

		// END prcxxth_npo
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
