<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel   = '';
	$nama_tabels_d = [];
	// tes webhook
?>

<!-- begin content here -->

<div class="row">
	<div class="col=lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="profile-image">
			<div id="foto_profile"></div>
		</div>
		<div class="profile-info">
			<div class="">
				<div>
					<h2 class="no-margins">
						Hello
						<br><strong><span id="hemxxmh_nama"></span></strong>
					</h2>
					<h4 id="">
						<br><span id="hodxxmh_nama"></span>
						<br><span id="hetxxmh_nama"></span>
						<br><span class="fa fa-calendar">&nbsp</span><span id="masakerja"></span>
						<br>
						<br>
						<div id="saldoCuti"></div>
					</h4>
					<i id="icon_anniv" class=""></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col=lg-4 col-md-4 col-sm-12 col-xs-12">
		<h3>Kehadiran</h3>
		<div id="httlpmh"></div>
	</div>
	<div class="col=lg-4 col-md-4 col-sm-12 col-xs-12">
		<h3>Kedisiplinan</h3>
		<div id="hadxxmh"></div>
	</div>
</div>

<!-- BEGIN JS -->
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; ?>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/dash_personal/fn/dash_personal.php'; ?>

<script type="text/javascript">
	$(document).ready(function() {
		loadFoto();
		loadKehadiran();
		loadProfile();
		loadKedisiplinan();
	} );// end of document.ready
</script>

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
