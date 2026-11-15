
<?php
require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_css_load.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/header1_must_include.php';

$nama_tabel = 'hrctsth_kostik';
$nama_tabels_d = [];
?>

<style>
/* =====================================================
   TES ONLINE - MINIMAL PROFESSIONAL THEME
===================================================== */

:root {
    /* Button color */
    --tes-button: #7654CF;
    --tes-button-hover: #6242B5;

    /* Neutral colors */
    --tes-bg: #F7F6F9;
    --tes-surface: #FFFFFF;
    --tes-text: #34313A;
    --tes-muted: #77717F;
    --tes-border: #E8E4EC;

    --tes-shadow: 0 2px 10px rgba(40, 30, 55, 0.04);
}

/* =====================================================
   PAGE BACKGROUND
===================================================== */

html {
    min-height: 100%;
    background: var(--tes-bg) !important;
}

body {
    min-height: 100vh;
    margin: 0 !important;
    background: var(--tes-bg) !important;
    color: var(--tes-text) !important;
}

/* =====================================================
   MAIN CONTAINER
===================================================== */

.tes-online-page {
    position: relative;
    min-height: calc(100vh - 20px);
    padding: 35px 25px 50px;
    background: transparent !important;
}

/* =====================================================
   MAIN CARD
===================================================== */

.tes-online-page .ibox {
    background: var(--tes-surface) !important;
    border: 1px solid var(--tes-border) !important;
    border-radius: 10px !important;
    overflow: hidden;
    box-shadow: var(--tes-shadow);
}

/* =====================================================
   CARD HEADER
===================================================== */

.tes-online-page .ibox-title {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 18px 24px !important;

    background: #FFFFFF !important;
    border-bottom: 1px solid var(--tes-border) !important;
}

.tes-online-page .ibox-title h3 {
    margin: 0;
    color: var(--tes-text) !important;
    font-size: 17px;
    font-weight: 600;
}

.tes-online-page .ibox-title h3 i {
    color: var(--tes-muted) !important;
    margin-right: 7px;
}

.tes-online-page .ibox-tools a {
    color: var(--tes-muted) !important;
}

.tes-online-page .ibox-tools a:hover {
    color: var(--tes-text) !important;
}

/* =====================================================
   CARD CONTENT
===================================================== */

.tes-online-page .ibox-content {
    padding: 32px !important;
    background: #FFFFFF !important;
    border: none !important;
    color: var(--tes-text) !important;
}

/* =====================================================
   TYPOGRAPHY
===================================================== */

.tes-online-page h1 {
    margin: 0 0 12px;
    color: var(--tes-text) !important;
    font-size: 27px;
    font-weight: 650;
    letter-spacing: -0.5px;
    line-height: 1.4;
}

.tes-online-page h1 b {
    color: var(--tes-text) !important;
    font-weight: 700;
}

.tes-online-page p {
    margin-bottom: 28px;
    color: var(--tes-muted) !important;
    font-size: 14px;
    line-height: 1.7;
}

/* =====================================================
   TEST BUTTON GRID
===================================================== */

.tes-online-page .test-button {
    margin-bottom: 12px;
}

.tes-online-page .test-button form {
    width: 100%;
}

/* =====================================================
   BUTTON BASE
===================================================== */

.tes-online-page .btn {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 100%;
    min-height: 46px;
    padding: 10px 14px;

    border-radius: 6px !important;

    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0;

    white-space: normal;
    box-shadow: none !important;

    transition:
        background-color .2s ease,
        border-color .2s ease,
        color .2s ease;
}

/* =====================================================
   PRIMARY BUTTON
===================================================== */

.tes-online-page .btn-primary {
    color: #FFFFFF !important;
    background: var(--tes-button) !important;
    border: 1px solid var(--tes-button) !important;
}

.tes-online-page .btn-primary:hover,
.tes-online-page .btn-primary:focus {
    color: #FFFFFF !important;
    background: var(--tes-button-hover) !important;
    border-color: var(--tes-button-hover) !important;
}

.tes-online-page .btn-primary:active {
    color: #FFFFFF !important;
    background: var(--tes-button-hover) !important;
    border-color: var(--tes-button-hover) !important;
}

/* Button icons */
.tes-online-page .btn i {
    margin-right: 7px;
    font-size: 13px;
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 991px) {
    .tes-online-page {
        padding: 25px 18px 35px;
    }

    .tes-online-page .ibox-content {
        padding: 26px !important;
    }

    .tes-online-page h1 {
        font-size: 24px;
    }
}

@media (max-width: 767px) {
    .tes-online-page {
        padding: 18px 12px 30px;
    }

    .tes-online-page .ibox {
        border-radius: 8px !important;
    }

    .tes-online-page .ibox-title {
        padding: 16px 18px !important;
    }

    .tes-online-page .ibox-content {
        padding: 22px 18px !important;
    }

    .tes-online-page h1 {
        font-size: 22px;
    }

    .tes-online-page p {
        font-size: 13px;
        margin-bottom: 20px;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .tes-online-page .btn {
        transition: none;
    }
}
</style>

<!-- =====================================================
     TES ONLINE CONTENT
===================================================== -->

<div class="tes-online-page">

    <div class="container-fluid">

        <div class="ibox">

            <div class="ibox-title">

                <h3>
                    <i class="fa fa-file-text"></i>
                    Tes Online
                </h3>

                <div class="ibox-tools">

                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>

            </div>

            <div class="ibox-content">

                <h1>
                    Welcome to Tes Online by
                    <b>Ferry Ibnu</b>
                </h1>

                <p>
                    Silakan klik tombol di bawah ini untuk mengikuti tes.
                </p>

                <div class="row">

                    <!-- FORM KANDIDAT -->

                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 test-button">

                        <form action="../../../../hcdxxmh.php" target="_blank">

                            <button
                                type="submit"
                                class="btn btn-primary block full-width">

                                <i class="fa fa-user"></i>
                                &nbsp; Form Kandidat

                            </button>

                        </form>

                    </div>

                    <!-- PAPI KOSTICK -->

                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 test-button">

                        <form action="usersc/applications/views/hrctsth_kostik/hrctsth_kostik_public.php" target="_blank">

                            <button
                                type="submit"
                                class="btn btn-primary block full-width">

                                <i class="fa fa-list-alt"></i>
                                &nbsp; Tes Papi Kostik

                            </button>

                        </form>

                    </div>

                    <!-- CFIT -->

                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 test-button">

                        <form action="usersc/applications/views/hrctsth_cfit/hrctsth_cfit_public.php" target="_blank">

                            <button
                                type="submit"
                                class="btn btn-primary block full-width">

                                <i class="fa fa-puzzle-piece"></i>
                                &nbsp; Tes CFIT

                            </button>

                        </form>

                    </div>

                    <!-- DISC -->

                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 test-button">

                        <form action="usersc/applications/views/hrctsth_disc/hrctsth_disc_public.php" target="_blank">

                            <button
                                type="submit"
                                class="btn btn-primary block full-width">

                                <i class="fa fa-bar-chart"></i>
                                &nbsp; Tes DISC

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<?php
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';

require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php';
?>

<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<script>
</script>

<!-- end content here -->

<!-- do not erase -->
<?php
// require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php';
?>
