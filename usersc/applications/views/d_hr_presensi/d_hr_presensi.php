<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'd_hr_presensi';
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
					<div class="col-lg-6">
						<div class="" id="chartEmpIzin"></div>
					</div>
					<div class="col-lg-6">
						<div class="" id="chartEmpAbsen"></div>
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
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/highcharts-more.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/exporting.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/no-data-to-display.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/d_hr_presensi/fn/d_hr_presensi_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtd_hr_presensi, tbld_hr_presensi, show_deleted_d_hr_presensi = 0, id_d_hr_presensi;
	// ------------- end of default variable
	
	filterFloating();

	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
	
	start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
	end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');
	
	$(document).ready(function() {
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				// Define your validation rules here
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
				end_date = moment($('#end_date').val()).format('YYYY-MM-DD');

				// toastr awal
				toastr.info('Harap tunggu ...', 'Proses Upload', {
					progressBar: false, 
					timeOut: 0, // Infinite timeout
					extendedTimeOut: 0
				});
				chartEmpIzin();
				chartEmpAbsen();
				toastr.clear();
				
				$('#modalFloatingFilter').modal('toggle');
				return false; 
			}
		});
		chartEmpIzin();
		chartEmpAbsen();
					
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
