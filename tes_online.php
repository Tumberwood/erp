<?php
    require_once 'users/init.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php';
    require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); 
?>

<?php
	$nama_tabel    = 'hrctsth_kostik';
	$nama_tabels_d = [];
?>

<style>
    body {
        background-color: rgb(243,243,244);
    }
</style>

<div class="container-fluid mt-4">
    <div class="ibox">
        <div class="ibox-title">
            <h3><i class="fa fa-file-text"></i> Tes Online</h3>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content" style="padding: 15px">
            <h1>Welcome to Tes Online by <b>Solusi Indonesia</b> </h1>
            <p>Silahkan klik tombol di bawah ini untuk mengikuti tes</p>
            <div class="row">
                <div class="col-2">
                    <form action="../../../../hcdxxmh.php" target="_blank">
                        <button type="submit" class="btn btn-info btn btn-primary block full-width m-b"><i class="fa fa-file-text"></i> Form Kandidat</button>
                    </form>
                </div>
                <div class="col-2">
                    <form action="usersc/applications/views/hrctsth_kostik/hrctsth_kostik_public.php" target="_blank">
                        <button type="submit" class="btn btn-primary btn btn-primary block full-width m-b">Tes Papi Kostik</button>
                    </form>
                </div>
                <div class="col-2">
                    <form action="usersc/applications/views/hrctsth_cfit/hrctsth_cfit_public.php" target="_blank">
                        <button type="submit" class="btn btn-primary btn btn-primary block full-width m-b">Tes CFIT</button>
                    </form>
                </div>
                <div class="col-2">
                    <form action="usersc/applications/views/hrctsth_disc/hrctsth_disc_public.php" target="_blank">
                        <button type="submit" class="btn btn-primary btn btn-primary block full-width m-b">Tes DISC</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN JS -->
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; ?>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<script>
</script>

<!-- end content here -->

<!-- do not erase -->
<?php //require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
