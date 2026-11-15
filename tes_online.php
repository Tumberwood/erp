
<?php
    require_once 'users/init.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php';
    require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php');

    $nama_tabel = 'hrctsth_kostik';
    $nama_tabels_d = [];
?>

<style>

/* =====================================================
   TES ONLINE - FULL PURPLE GLASSMORPHISM
===================================================== */

:root {
    --purple-dark: #4C1D95;
    --purple-deep: #5B21B6;
    --purple-main: #7C3AED;
    --purple-light: #A78BFA;
    --purple-lighter: #C4B5FD;

    --purple-text: #FFFFFF;
    --purple-muted: #DDD6FE;

    --purple-border: rgba(255,255,255,.18);

    --purple-card:
        linear-gradient(
            145deg,
            rgba(76,29,149,.88),
            rgba(91,33,182,.86),
            rgba(109,40,217,.88)
        );
}

/* =====================================================
   PAGE BACKGROUND
===================================================== */

html {
    min-height: 100%;
    background: #6D28D9 !important;
}

body {
    min-height: 100vh;
    margin: 0 !important;

    color: var(--purple-text) !important;

    background:
        linear-gradient(
            135deg,
            #4C1D95 0%,
            #6D28D9 32%,
            #7C3AED 65%,
            #A78BFA 100%
        ) !important;

    background-attachment: fixed !important;
}

/* =====================================================
   MAIN CONTAINER
===================================================== */

.tes-online-page {
    position: relative;

    min-height: calc(100vh - 20px);

    padding: 35px 25px 50px;

    overflow: hidden;

    background: transparent !important;
}

/* Decorative glow */

.tes-online-page::before {
    content: "";

    position: absolute;

    width: 400px;
    height: 400px;

    top: -180px;
    right: -100px;

    border-radius: 50%;

    background: rgba(221,214,254,.16);

    filter: blur(90px);

    pointer-events: none;
}

.tes-online-page::after {
    content: "";

    position: absolute;

    width: 400px;
    height: 400px;

    bottom: -180px;
    left: -100px;

    border-radius: 50%;

    background: rgba(167,139,250,.18);

    filter: blur(100px);

    pointer-events: none;
}

/* =====================================================
   MAIN IB0X
===================================================== */

.tes-online-page .ibox {
    position: relative;
    z-index: 1;

    background: var(--purple-card) !important;

    border: 1px solid var(--purple-border) !important;

    border-radius: 20px !important;

    overflow: hidden;

    box-shadow:
        0 25px 70px rgba(35,10,80,.25),
        0 8px 25px rgba(35,10,80,.12),
        inset 0 1px 0 rgba(255,255,255,.10);

    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

/* =====================================================
   IB0X HEADER
===================================================== */

.tes-online-page .ibox-title {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 20px 25px !important;

    background: rgba(46,16,101,.22) !important;

    border-bottom: 1px solid var(--purple-border) !important;
}

.tes-online-page .ibox-title h3 {
    margin: 0;

    color: #FFFFFF !important;

    font-size: 19px;
    font-weight: 700;
}

.tes-online-page .ibox-tools a {
    color: #DDD6FE !important;
}

.tes-online-page .ibox-tools a:hover {
    color: #FFFFFF !important;
}

/* =====================================================
   IB0X CONTENT
===================================================== */

.tes-online-page .ibox-content {
    padding: 35px !important;

    background: transparent !important;

    border: none !important;

    color: #FFFFFF !important;
}

/* =====================================================
   CONTENT TYPOGRAPHY
===================================================== */

.tes-online-page h1 {
    margin: 0 0 15px;

    color: #FFFFFF !important;

    font-size: 30px;
    font-weight: 750;

    letter-spacing: -.7px;
    line-height: 1.3;
}

.tes-online-page h1 b {
    color: #DDD6FE !important;
    font-weight: 800;
}

.tes-online-page p {
    margin-bottom: 30px;

    color: #DDD6FE !important;

    font-size: 15px;
    line-height: 1.7;
}

/* =====================================================
   TEST BUTTON GRID
===================================================== */

.tes-online-page .test-button {
    margin-bottom: 15px;
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
    min-height: 52px;

    padding: 12px 16px;

    border-radius: 12px !important;

    font-size: 14px;
    font-weight: 700;

    letter-spacing: .1px;

    white-space: normal;

    transition:
        transform .2s ease,
        background .2s ease,
        box-shadow .2s ease,
        border-color .2s ease;
}

/* =====================================================
   PRIMARY BUTTON
===================================================== */

.tes-online-page .btn-primary {
    color: #4C1D95 !important;

    background:
        linear-gradient(
            135deg,
            #DDD6FE 0%,
            #C4B5FD 50%,
            #A78BFA 100%
        ) !important;

    border: 1px solid rgba(255,255,255,.28) !important;

    box-shadow:
        0 8px 18px rgba(35,10,80,.20),
        inset 0 1px 0 rgba(255,255,255,.30);
}

.tes-online-page .btn-primary:hover,
.tes-online-page .btn-primary:focus {
    color: #3B0764 !important;

    background:
        linear-gradient(
            135deg,
            #EDE9FE 0%,
            #DDD6FE 50%,
            #C4B5FD 100%
        ) !important;

    border-color: rgba(255,255,255,.5) !important;

    box-shadow:
        0 12px 25px rgba(35,10,80,.28);

    transform: translateY(-3px);
}

/* Active */

.tes-online-page .btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 4px 10px rgba(35,10,80,.2);
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 991px) {

    .tes-online-page {
        padding: 25px 18px 35px;
    }

    .tes-online-page .ibox-content {
        padding: 28px !important;
    }

    .tes-online-page h1 {
        font-size: 26px;
    }
}

@media (max-width: 767px) {

    .tes-online-page {
        padding: 18px 12px 30px;
    }

    .tes-online-page .ibox {
        border-radius: 16px !important;
    }

    .tes-online-page .ibox-title {
        padding: 17px 18px !important;
    }

    .tes-online-page .ibox-content {
        padding: 23px 18px !important;
    }

    .tes-online-page h1 {
        font-size: 23px;
    }

    .tes-online-page p {
        font-size: 14px;
        margin-bottom: 22px;
    }
}

/* =====================================================
   REDUCED MOTION
===================================================== */

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
