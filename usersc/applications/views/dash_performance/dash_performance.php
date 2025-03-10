<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'dash_performance';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmFilter">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">Periode</label>
						<div class="col-lg-5">
							<div class="input-group input-daterange" id="periode">
								<input type="text" id="start_date" class="form-control">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
								<input type="text" id="end_date" class="form-control">
							</div>
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
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-3">
						<div class="" id="chartSkor"></div>
					</div>
					<div class="col-lg-3">
						<div class="" id="chartRadar"></div>
					</div>
					<div class="col-lg-3">
						<div class="ibox">
							<div class="ibox-content bg-info p-xs">
								<div class="row vertical-align">
									<div class="col-6">
										<h3 class="font-bold ">Outstanding PICA</h3>
									</div>
									<div class="col-6" style="height: 100px;">
										<h1 class="text-right font-bold" id="sisa_belum_pica"></h1>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="ibox">
							<div class="ibox-content bg-primary p-xs">
								<div class="row vertical-align">
									<div class="col-9">
										<h2 class="font-bold m-b-md">PICA Open</h5>
										<hr class="hr-line-dashed m-t-xs m-b-xs">
									</div>
								</div>
								<h4 class="" id="done_pica"></h4>
								<h4 class="" id="open_pica"></h4>
							</div>
						</div>
					</div>	
				</div>	
			</div>	
		</div>	
		
		<div class="ibox ">
			<div class="ibox-content">
				<div class="row">
					<div class="col">
						<h1 class="text-center">Strategy Map</h1>
						<div class="center" id="familyTreeContainer"></div>
					</div>
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

<!-- load highcharts -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/highcharts.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/drilldown.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/highcharts-more.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/exporting.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/no-data-to-display.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/dash_performance/fn/dash_performance_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	// ------------- end of default variable
	
	//Aktivasi Filter Floating
	filterFloating();
	
	$('#start_date').datepicker('setDate', awal_tahun_dmy);
	start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
	end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
	
	$(document).ready(function() {
		chartSkor(start_date, end_date);
		radar(start_date, end_date);
		displayFamilyTree(start_date, end_date);
		iboxPica(start_date, end_date);
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

				chartSkor(start_date, end_date);
				radar(start_date, end_date);
				iboxPica(start_date, end_date);
				$('#modalFloatingFilter').modal('toggle');
			}
		});
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
