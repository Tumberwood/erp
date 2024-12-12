<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'prqittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblprqittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Purchase Request</th>
                                <th>Tanggal PO</th>
                                <th>Purchase Order</th>
                                <th>Item PR</th>
                                <th>Item Code</th>
                                <th>Item PO</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prqosrd/fn/prqosrd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprqittd, tblprqittd, show_deleted_prqittd = 0, id_prqittd;
	// ------------- end of default variable
	
	$(document).ready(function() {
		
		//start datatables
		tblprqittd = $('#tblprqittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/prqosrd/prqosrd.php",
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
					targets: [1,2,3,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "id",visible:false },
				{ data: "kode_pr" },
				{ data: "tanggal_po" },
				{ data: "kode_po" },
				{ data: "item_pr" },
				{ data: "item_code" },
				{ data: "item_po" },
				{ 
					data: "qty_pr",
					...renderNumber(0)
				},
				{ data: "uom_pr" },
				{ 
					data: "qty_po" ,
					...renderNumber(0)
				},
				{ data: "uom_po" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prqittd';
					$table       = 'tblprqittd';
					$edt         = 'edtprqittd';
					$show_status = '_prqittd';
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
			}
		} );

		tblprqittd.searchPanes.container().appendTo('#spprqittd');
		tblprqittd.searchBuilder.container().appendTo( '#sbprqittd' );
		
		tblprqittd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblprqittd);
		} );
		
		tblprqittd.on( 'select', function( e, dt, type, indexes ) {
			prqittd_data    		= tblprqittd.row( { selected: true } ).data();
			id_prqittd      		= prqittd_data.id;
			console.log(id_prqittd);

			// atur hak akses
			CekSelectHeaderH(tblprqittd);
		} );

		tblprqittd.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_prqittd = 0;

			// atur hak akses
			CekDeselectHeaderH(tblprqittd);
		} );
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
