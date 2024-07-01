<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wpcxxth';
	$nama_tabels_d = [];
?>

<div class="row">
    <div class="col">
        <div class="ibox" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmFilter">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode Picking</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
						</div>
					</div>
                    <!-- <div class="form-group row">
                        <div class="col-lg-4">
                            <button class="btn btn-primary" type="submit" id="go">Submit</button>
                        </div>
                    </div> -->
                </form>
				
            </div>
        </div>
    </div>
</div>

<div class="row" id="konten">
</div>

<div class="ibox">
	<div class="row">
		<div class="col-8 col-lg-11">
		</div>
		<div class="col-4 col-lg-1">
			<button class="btn btn-warning submit-button" id="confirmBtn" style="display: none" onClick="confirmData()">Confirm</button>
		</div>
	</div>
</div>
<br>

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpcxxth/fn/wpcxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwpcxxth, tblwpcxxth, show_deleted_wpcxxth = 0, id_wpcxxth;
		// ------------- end of default variable
		var id_wpcxxth_old = 0;
		var selectedValues = 0;
		var start_at = "";
		var finish_at = "";
		var confirm_at = "";

		// get tableRelation
		tableRelation('wpcxxth');
		
		$("#selectKode").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/wpcxxth/wpcxxth_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_wpcxxth_old: id_wpcxxth_old,
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
			}
		});

		$(document).ready(function() {
			$('#selectKode').change(function() {
				// Get selected values
				selectedValues = $(this).val();
				
				// Log selected values
				id_wpcxxth_old  = $('#selectKode').val();
				generateKonten();
				$('#iboxfilter').addClass('collapsed');
			});

			// $("#frmFilter").submit(function(e) {
			// 	e.preventDefault();
			// }).validate({
			// 	rules: {
					
			// 	},
			// 	submitHandler: function(frmFilter) {
					
			// 	}
			// });

			// END wpcxxth
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
