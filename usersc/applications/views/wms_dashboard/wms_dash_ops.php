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
<style>

    #threejs-container {
      position: relative;
      height: 600px;
      border: 1px solid #ddd;
      background-color: #f0f0f0;
      cursor: grab;
      overflow: hidden;
    }
    #threejs-container:active {
      cursor: grabbing;
    }

    canvas {
      display: block;
      width: 100% !important;
      height: 100% !important;
      /* supaya canvas mengikuti container */
    }

    #tooltip_3d {
      position: absolute;
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      pointer-events: none;
      font-family: sans-serif;
      font-size: 12px;
      display: none;
      z-index: 10;
      user-select: none;
      white-space: nowrap;
    }
  </style>
<!-- begin content here -->

<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmFilter">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Periode</label>
						<div class="input-group input-daterange" id="periode">
							<input type="text" id="start_date" name="start_date" class="form-control">
							<div class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</div>
							<input type="text" id="end_date" name="end_date" class="form-control">
						</div>
					</div>
					<div class="form-group row">												
						<div class="col-sm-6">
							<select class="form-control" id="select_id_iwhxxmh" name="select_id_iwhxxmh"></select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
						<div class="ibox">
							<div class="ibox-content bg-primary p-xs">
								<div class="row vertical-align">
									<div class="col-3">
										<i class="material-icons" style="font-size: 48px;">pallet</i>
									</div>
									<div class="col-9">
										<h2 class="font-bold m-b-md">Receive</h2>
										<hr class="hr-line-dashed m-t-xs m-b-xs">
									</div>
								</div>
								<h4 class="" id="c_lpn_received"></h4>
								<h4 class="" id="avg_receive"></h4>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
						<div class="ibox">
							<div class="ibox-content bg-primary p-xs">
								<div class="row vertical-align">
									<div class="col-3">
										<i class="material-icons" style="font-size: 48px;">forklift</i>
									</div>
									<div class="col-9">
										<h2 class="font-bold m-b-md">Putaway</h5>
										<hr class="hr-line-dashed m-t-xs m-b-xs">
									</div>
								</div>
								<h4 class="" id="c_lpn_putaway"></h4>
								<h4 class="" id="c_lpn_to_putaway"></h4>
								<h4 class="" id="avg_putaway"></h4>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
						<div id="average_inventory"></div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
						<div id="inventory_turnover"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
						<div class="ibox">
							<div class="ibox-content bg-warning p-xs">
								<div class="row vertical-align">
									<div class="col-3">
										<i class="material-icons" style="font-size: 48px;">barcode_reader</i>
									</div>
									<div class="col-9">
										<h2 class="font-bold m-b-md">Picking</h5>
										<hr class="hr-line-dashed m-t-xs m-b-xs">
									</div>
								</div>
								<h4 class="" id="c_lpn_picked"></h4>
								<h4 class="" id="c_lpn_to_pick"></h4>
								<h4 class="" id="avg_picking"></h4>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
						<div class="ibox">
							<div class="ibox-content bg-warning p-xs">
								<div class="row vertical-align">
									<div class="col-3">
										<i class="material-icons" style="font-size: 48px;">local_shipping</i>
									</div>
									<div class="col-9">
										<h2 class="font-bold m-b-md">Dispatch</h5>
										<hr class="hr-line-dashed m-t-xs m-b-xs">
									</div>
								</div>
								<h4 class="" id="c_item_to_dispatch"></h4>
								<h4 class="" id="c_item_dispatched"></h4>
								<h4 class="" id="avg_dispatch"></h4>
								<small></small>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
						<div id="otif"></div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="row">
					<div class="col-12">
						<div id="inbound"></div>
					</div>
				</div>
				<div class="row m-t-n-md">
					<div class="col-12">
						<div id="drop"></div>
					</div>
				</div>
				<div class="row m-t-n-sm">
					<div class="col-12">
						<div id="outbound"></div>
					</div>
				</div>
				<div class="row m-t-n-md">
					<div class="col-12">
						<div id="transit"></div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="ibox">
					<div class="ibox-content p-xs" id="hc_location_capacity">
					</div>
				</div>
				<div class="row">
					<div class="col-4">
						<div class="row m-t-n-md">
							<div class="col-12">
								<div id="overflow"></div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="row m-t-n-md">
							<div class="col-12">
								<div id="rework"></div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="row m-t-n-md">
							<div class="col-12">
								<div id="return"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
		<div class="ibox">
			<div class="ibox-content p-xs" id="hc_man_hours">
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
		<div class="ibox">
			<div class="ibox-content p-xs" id="cumulativeDN">
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
		<div class="ibox">
			<div class="ibox-content p-xs" id="hc_location_heatmap">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="table-responsive">
			<table id="tblwms_log_r" class="table table-striped table-bordered table-hover nowrap" width="100%">
				<thead>
					<tr>
						<th>User</th>
						<th>Receive Entry</th>
						<th>Putaway</th>
						<th>Picking</th>
						<th>Dispatch</th>
						<th>Total</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FontLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/geometries/TextGeometry.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>


<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_highcharts_load.php';
?>



<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wms_dashboard/fn/wms_dash_ops_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// get tableRelation
	// tableRelation('_blank');
	//Aktivasi Filter Floating
	filterFloating();
	var edtwms_log_r, tblwms_log_r, show_deleted_wms_log_r = 0, id_wms_log_r;

	var id_iwhxxmh, id_iwhxxmh_old = 0;

	$("#select_id_iwhxxmh").select2({
		placeholder : "Warehouse",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_iwhxxmh_old: id_iwhxxmh_old,
					search: params.term || '',
					page: params.page || 1
				}
					return query;
			},
			processResults: function (data, params) {
				return {
					results: data.results,
					pagination: {
						more: true
					}
				};
			},
			cache: true,
			minimumInputLength: 1,
			maximum: 10,
			delay: 500,
			maximumSelectionLength: 5,
			minimumResultsForSearch: -1,
		},
	});

	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);

	function reload_dashboard_data(){
		id_iwhxxmh = $('#select_id_iwhxxmh').val();
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date   = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		load_dashboard_wms_ops_box(start_date,end_date,id_iwhxxmh);
		load_dashboard_wms_ops_location_heatmap(end_date);
		load_dashboard_wms_ops_location_capacity(end_date);
		load_dashboard_wms_ops_man_hours(start_date,end_date);
		otif(start_date,end_date);
		averageInventory(start_date,end_date,id_iwhxxmh);
		inventoryTurnover(start_date,end_date,id_iwhxxmh);
		inboundData(end_date, id_iwhxxmh);
		paretoChart(start_date,end_date,id_iwhxxmh);
	}

	reload_dashboard_data();
	$(document).ready(function() {
		id_iwhxxmh = $('#select_id_iwhxxmh').val();
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			
		tblwms_log_r = $('#tblwms_log_r').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-1',
			},
			ajax: {
				url: "../../models/wms_dashboard/wms_dash_ops_log_r.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wms_log_r = show_deleted_wms_log_r;
					d.start_date = start_date;
					d.end_date = end_date;
					d.id_iwhxxmh = id_iwhxxmh;
				}
			},
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: '_all'
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			order: [[ 0, "desc" ]],
			columns: [
				{ data: "username" },
				{ data: "re", ...renderNumber()},
				{ data: "pt", ...renderNumber()},
				{ data: "pc", ...renderNumber()},
				{ data: "dp", ...renderNumber()},
				{ data: "total", ...renderNumber()},
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
					$arr_buttons_tools2 	= [ 'sp', 'sb'];
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

		autoReloadInterval(function () {
			var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
			reload_dashboard_data();
			tblwms_log_r.ajax.reload(null, false);
		});

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true
				},
				end_date: {
					required: true
				},
				select_id_iwhxxmh: {
					required: true
				}
			},
			messages: {
				start_date: {
					required: "Tanggal awal wajib diisi!"
				},
				end_date: {
					required: "Tanggal akhir wajib diisi!"
				},
				select_id_iwhxxmh: {
					required: "Warehouse wajib diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				id_iwhxxmh  = $('#select_id_iwhxxmh').val();

				if (id_iwhxxmh > 0) {
					reload_dashboard_data();
					tblwms_log_r.ajax.reload(null, false);
					$('#modalFloatingFilter').modal('toggle');
				}
			}
		});
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
