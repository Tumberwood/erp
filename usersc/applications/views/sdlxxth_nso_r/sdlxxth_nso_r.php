<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'sdlxxth_nso';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblsdlxxth_nso" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode PR</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sdlxxth_nso/fn/sdlxxth_nso_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtsdlxxth_nso, tblsdlxxth_nso, show_deleted_sdlxxth_nso = 0, id_sdlxxth_nso;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('sdlxxth_nso');

	$(document).ready(function() {
		// BEGIN sdlxxth_nso
		tblsdlxxth_nso = $('#tblsdlxxth_nso').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/sdlxxth_nso_r/sdlxxth_nso_r.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth_nso = show_deleted_sdlxxth_nso;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "sdlittd_nso.id",visible:false },
				{ data: "sdlxxth_nso.kode" },
				{ data: "sdlxxth_nso.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ data: "iimxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ 
					data: "sdlittd_nso.jumlah_unit",
					...renderNumber()
				},
				{ data: "iumxxmh_unit.kode" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlxxth_nso';
					$table       = 'tblsdlxxth_nso';
					$edt         = 'edtsdlxxth_nso';
					$show_status = '_sdlxxth_nso';
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
				if ( data.sdlxxth_nso.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sdlxxth_nso.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsdlxxth_nso.searchPanes.container().appendTo('#spsdlxxth_nso');
		tblsdlxxth_nso.searchBuilder.container().appendTo( '#sbsdlxxth_nso' );
		
		tblsdlxxth_nso.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblsdlxxth_nso);
		} );
		
		tblsdlxxth_nso.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('sdlxxth_nso');
			// atur hak akses
			CekSelectHeaderH(tblsdlxxth_nso);
		} );

		tblsdlxxth_nso.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('sdlxxth_nso');

			// atur hak akses
			CekDeselectHeaderH(tblsdlxxth_nso);
		} );

		// END sdlxxth_nso
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
