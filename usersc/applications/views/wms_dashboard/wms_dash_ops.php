<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = '_blank';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-8">
				<div class="row p-xs">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<form role="form" class="form-inline">
							<div class="form-group">
								<label>Periode</label>
								<div class="input-group input-daterange" id="periode">
									<input type="text" id="start_date" class="form-control">
									<div class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</div>
									<input type="text" id="end_date" class="form-control">
								</div>
							</div>
						</form>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group row">												
							<div class="col-sm-6">
								<select class="form-control" id="select_id_iwhxxmh" name="select_id_iwhxxmh"></select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
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
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
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
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
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
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
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
				</div>
			</div>
			<div class="col-md-4">
				<div class="ibox">
					<div class="ibox-content p-xs" id="hc_location_capacity">
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

	<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
		<div class="ibox">
			<div class="ibox-content p-xs" id="hc_location_heatmap">
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_highcharts_load.php';
?>



<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wms_dashboard/fn/wms_dash_ops_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// get tableRelation
	// tableRelation('_blank');

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

	function reload_dashboard_data(){
		id_iwhxxmh = $('#select_id_iwhxxmh').val();
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date   = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		load_dashboard_wms_ops_box(start_date,end_date,id_iwhxxmh);
		load_dashboard_wms_ops_location_heatmap(end_date);
		load_dashboard_wms_ops_location_capacity(end_date);
		load_dashboard_wms_ops_man_hours(start_date,end_date);
	}

	$(document).ready(function() {

		reload_dashboard_data();

		$("#select_id_iwhxxmh").change(function(){		
			reload_dashboard_data();
		});

		$("#start_date").change(function(){
			reload_dashboard_data();
		});

		$("#end_date").change(function(){
			reload_dashboard_data();
		});

	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
