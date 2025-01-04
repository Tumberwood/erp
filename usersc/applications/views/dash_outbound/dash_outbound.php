<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'dash_outbound_h';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'dash_outbound';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
					<div id="frmFilter">
					</div>
                    <table id="tbldash_outbound_h" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode PL</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabdash_outbound_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabdash_outbound_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbldash_outbound" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>id_wdoxxth</th>
										<th>Delivery Order</th>
										<th>Jumlah PL</th>
										<th>Jumlah PC</th>
										<th>Jumlah DP</th>
										<th>% Picking</th>
										<th>% Dispatch</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/dash_outbound/fn/dash_outbound_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtdash_outbound_h, tbldash_outbound_h, show_deleted_dash_outbound_h = 0, id_dash_outbound_h = 0;
	var edtdash_outbound, tbldash_outbound, show_deleted_dash_outbound = 0, id_dash_outbound;
	// ------------- end of default variable

	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_hpcxxmh_old = 0;

	$(document).ready(function() {
		// BEGIN dash_outbound_h

		tbldash_outbound_h = $('#tbldash_outbound_h').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/dash_outbound/dash_outbound_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dash_outbound_h = show_deleted_dash_outbound_h;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "id_wplxxth",visible:false },
				{ data: "tanggal" },
				{ data: "wplxxth_kode" },
				{ data: "customer" },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_dash_outbound_h';
					$table       = 'tbldash_outbound_h';
					$edt         = 'edtdash_outbound_h';
					$show_status = '_dash_outbound_h';
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
		} );

		tbldash_outbound_h.searchPanes.container().appendTo('#spdash_outbound_h');
		tbldash_outbound_h.searchBuilder.container().appendTo( '#sbdash_outbound_h' );
		
		tbldash_outbound_h.on( 'select', function( e, dt, type, indexes ) {
			data_dash_outbound_h = tbldash_outbound_h.row( { selected: true } ).data();
			// console.log(data_dash_outbound_h);
			id_dash_outbound_h = data_dash_outbound_h.id_wdoxxth;
			tbldash_outbound.ajax.reload(null, false);
			
		} );
		
		tbldash_outbound_h.on( 'deselect', function () {
			id_dash_outbound_h= 0;
			tbldash_outbound.ajax.reload(null, false);
		} );
		// END dash_outbound_h
		
		tbldash_outbound = $('#tbldash_outbound').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/dash_outbound/dash_outbound_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dash_outbound = show_deleted_dash_outbound;
					d.id_dash_outbound_h = id_dash_outbound_h;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1]
				}
			],
			columns: [
				{ data: "id_wdoxxth",visible:false },
				{ data: "wdoxxth_kode" },
				{ 
					data: "jumlah_unit_pl" ,visible:false,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "jumlah_unit_pc" ,visible:false,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "jumlah_unit_dp" ,visible:false,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "persen_pc",           
					render: function (data, type, row, meta) {
						// Ensure data is a float and round it to 2 decimal places
						const roundedData = parseFloat(parseFloat(data).toFixed(2));

						return `<div class="progress progress-small">
									<div style="width: ${roundedData}%;" class="progress-bar" title="${roundedData}%">
										${roundedData}%
									</div>
								</div>`;
					},
				},
				{ 
					data: "persen_dp",           
					render: function (data, type, row, meta) {
						// Ensure data is a float and round it to 2 decimal places
						const roundedData = parseFloat(parseFloat(data).toFixed(2));

						return `<div class="progress progress-small">
									<div style="width: ${roundedData}%;" class="progress-bar" title="${roundedData}%">
										${roundedData}%
									</div>
								</div>`;
					},
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_dash_outbound';
					$table       = 'tbldash_outbound';
					$edt         = 'edtdash_outbound';
					$show_status = '_dash_outbound';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
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

		tbldash_outbound.searchPanes.container().appendTo('#spdash_outbound');
		tbldash_outbound.searchBuilder.container().appendTo( '#sbdash_outbound' );

		tbldash_outbound.on( 'draw', function( e, settings ) { 
		} );

		tbldash_outbound.on( 'select', function( e, dt, type, indexes ) {
		} );

		tbldash_outbound.on( 'deselect', function() {
		} );
		
		let lastSelectedId = 0; // Variable to track the last selected ID

		// Function that is called on auto reload interval
		autoReloadInterval(function () {
			// Select the label element by its ID

			var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

			var rowToSelect = tbldash_outbound_h.row(lastSelectedId);
			// console.log(lastSelectedId);
			
			// If the row exists, select it
			if (rowToSelect.length) {
				// console.log('ok');
				tbldash_outbound_h.row(lastSelectedId).select();
				tbldash_outbound_h.row(lastSelectedId - 1).deselect();
			} else {
				// console.log('no');
				// Handle if the ID exceeds the number of rows
				tbldash_outbound_h.row(lastSelectedId - 1).deselect();
				lastSelectedId = 0; // Reset to 0 to start over or adjust as needed
				tbldash_outbound_h.row(0).select(); // Optionally select the first row
			}

			data_dash_outbound_h = tbldash_outbound_h.row( { selected: true } ).data();
			id_dash_outbound_h = data_dash_outbound_h.id_wdoxxth;
			// console.log(data_dash_outbound_h);
			tbldash_outbound.ajax.reload(null, false);

			lastSelectedId++;
		});

		//custom label auto reload
		var label = document.getElementById('label-auto-reload');

		label.classList.remove('col-lg-2');
		label.classList.add('col-lg-4');


// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
