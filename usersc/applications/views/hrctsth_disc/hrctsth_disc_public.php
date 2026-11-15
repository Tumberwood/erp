
<?php
require_once '../../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_css_load.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/header1_must_include.php';

$nama_tabel = 'hrctsth_disc';
$nama_tabels_d = [];
?>

<style>
/* =========================================================
   DISC - MINIMAL PROFESSIONAL THEME
========================================================= */

:root {
    /* Warna tombol saja */
    --disc-button: #7654CF;
    --disc-button-hover: #6242B5;

    /* Warna netral */
    --disc-bg: #F7F6F9;
    --disc-surface: #FFFFFF;
    --disc-text: #34313A;
    --disc-muted: #77717F;
    --disc-border: #E8E4EC;
    --disc-shadow: 0 2px 10px rgba(40, 30, 55, 0.04);
}

/* =========================================================
   BACKGROUND
========================================================= */

body {
    background: var(--disc-bg) !important;
    color: var(--disc-text);
}

/* =========================================================
   MAIN WRAPPER
========================================================= */

.disc-page {
    padding-top: 24px;
    padding-bottom: 40px;
    color: var(--disc-text);
}

/* =========================================================
   CARD
========================================================= */

.disc-page .ibox {
    background: var(--disc-surface) !important;
    border: 1px solid var(--disc-border);
    border-radius: 10px;
    box-shadow: var(--disc-shadow);
    overflow: hidden;
}

.disc-page .ibox-content {
    background: #FFFFFF !important;
    border: none !important;
    padding: 24px !important;
}

/* =========================================================
   HEADING
========================================================= */

.disc-page h3 {
    color: var(--disc-text);
    font-size: 20px;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 20px;
}

.disc-page h5 {
    color: var(--disc-text);
    font-weight: 600;
}

/* =========================================================
   LABEL
========================================================= */

.disc-page label {
    color: #514B59;
    font-weight: 500;
    font-size: 13px;
}

/* =========================================================
   FORM CONTROL
========================================================= */

.disc-page .form-control {
    background: #FFFFFF !important;
    border: 1px solid #DED9E5 !important;
    border-radius: 6px !important;
    color: var(--disc-text) !important;
    min-height: 38px;
    box-shadow: none !important;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.disc-page .form-control:focus {
    border-color: #BDB6C9 !important;
    box-shadow: 0 0 0 3px rgba(80, 70, 95, 0.07) !important;
    outline: none;
}

.disc-page .form-control:disabled {
    background: #F5F4F7 !important;
    color: var(--disc-muted) !important;
    cursor: not-allowed;
}

/* =========================================================
   BUTTONS
========================================================= */

.disc-page .btn {
    border-radius: 6px !important;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: none !important;
    transition: background-color .2s ease, border-color .2s ease;
}

/* Primary button */
.disc-page .btn-primary {
    background: var(--disc-button) !important;
    border: 1px solid var(--disc-button) !important;
    color: #FFFFFF !important;
}

.disc-page .btn-primary:hover,
.disc-page .btn-primary:focus {
    background: var(--disc-button-hover) !important;
    border-color: var(--disc-button-hover) !important;
    color: #FFFFFF !important;
}

.disc-page .btn-primary:active {
    background: var(--disc-button-hover) !important;
    border-color: var(--disc-button-hover) !important;
    color: #FFFFFF !important;
}

/* Secondary button */
.disc-page .btn-secondary {
    background: #F3F1F5 !important;
    border: 1px solid var(--disc-border) !important;
    color: #514B59 !important;
}

.disc-page .btn-secondary:hover {
    background: #EAE6EF !important;
    color: var(--disc-text) !important;
}

/* =========================================================
   MODAL
========================================================= */

.disc-page .modal-content {
    background: #FFFFFF !important;
    border: 1px solid var(--disc-border);
    border-radius: 10px;
    box-shadow: 0 10px 35px rgba(30, 20, 45, 0.12);
    overflow: hidden;
}

.disc-page .modal-header {
    background: #FFFFFF !important;
    border-bottom: 1px solid var(--disc-border);
    padding: 16px 20px;
}

.disc-page .modal-title {
    color: var(--disc-text);
    font-size: 17px;
    font-weight: 600;
}

.disc-page .modal-body {
    background: #FFFFFF !important;
    color: #514B59;
    padding: 22px;
    line-height: 1.7;
    font-size: 14px;
}

.disc-page .modal-body ul {
    padding-left: 22px;
}

.disc-page .modal-body li {
    margin-bottom: 8px;
}

.disc-page .modal-body .text-danger {
    color: #A45B65 !important;
}

.disc-page .modal-footer {
    background: #FFFFFF !important;
    border-top: 1px solid var(--disc-border);
    padding: 14px 20px;
}

.disc-page .close {
    color: var(--disc-muted) !important;
    opacity: .8;
    text-shadow: none;
}

/* =========================================================
   QUIZ
========================================================= */

.disc-page #quiz1 {
    margin-top: 20px;
}

/* =========================================================
   DATEPICKER
========================================================= */

.datepicker {
    border: 1px solid var(--disc-border) !important;
    border-radius: 7px !important;
    box-shadow: 0 5px 20px rgba(30, 20, 45, .10) !important;
}

.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td span.active {
    background: #EAE8ED !important;
    background-image: none !important;
    color: var(--disc-text) !important;
    text-shadow: none !important;
}

.datepicker table tr td.today {
    background: #F3F2F5 !important;
    color: var(--disc-text) !important;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 767px) {

    .disc-page {
        padding-top: 12px;
    }

    .disc-page .ibox-content {
        padding: 16px !important;
    }

    .disc-page .row > [class*="col-"] {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }

    .disc-page .modal-body {
        padding: 16px;
    }

    .disc-page .modal-footer {
        padding: 12px 16px;
    }
}
</style>

<div class="disc-page">

    <div class="container-fluid mt-4">

        <div class="ibox">

            <div class="ibox-content">

                <h3>Tes DISC</h3>

                <br>

                <form id="discForm">

                    <div class="row">

                        <!-- Kolom Kiri -->
                        <div class="col-6">

                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">
                                    Kode DISC
                                </label>

                                <div class="col-lg-8">

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="kode"
                                        name="kode"
                                        required>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">
                                    Tanggal
                                </label>

                                <div class="col-lg-8">

                                    <div class="input-group input-daterange" id="periode">

                                        <input
                                            type="text"
                                            id="start_date"
                                            class="form-control">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-6">

                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">
                                    Nama Kandidat
                                </label>

                                <div class="col-lg-8">

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="nama"
                                        name="nama"
                                        disabled>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">
                                    No KTP
                                </label>

                                <div class="col-lg-8">

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="ktp"
                                        name="ktp"
                                        disabled>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Elemen yang disembunyikan -->
                    <div class="row" style="display: none">

                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="id_hcd"></label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="id_hcd"
                                    name="id_hcd"
                                    disabled>

                            </div>

                        </div>

                    </div>

                    <!-- Tombol -->
                    <div class="row mt-3">

                        <div class="col-6">

                            <button
                                style="display:none"
                                type="button"
                                id="button_modal1"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal1">
                                Instruksi
                            </button>

                        </div>

                        <div class="col-6 d-flex justify-content-end">

                            <button
                                type="button"
                                id="kirim"
                                class="btn btn-primary"
                                onclick="noKtp()">
                                Kirim
                            </button>

                            <button
                                style="display:none"
                                type="button"
                                id="goToQuiz"
                                class="btn btn-primary"
                                onclick="startQuiz()">
                                Mulai
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- =================================================
         MODAL INSTRUKSI
    ================================================== -->

    <div
        class="modal fade"
        id="myModal1"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModal1Label"
        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="myModal1Label">
                        Instruksi
                    </h5>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <p class="text-danger">
                        <b>WAKTU PENGERJAAN (10 Menit)</b>
                    </p>

                    Setiap nomor di bawah ini memuat 4 (empat) kalimat.
                    Tugas Anda adalah:

                    <ul>

                        <li>
                            Klik pada kolom di bawah huruf [<b>P</b>] di samping
                            kalimat yang <b>PALING menggambarkan</b> diri Anda.
                        </li>

                        <li>
                            Klik pada kolom di bawah huruf [<b>K</b>] di samping
                            kalimat yang <b>PALING TIDAK menggambarkan</b> diri Anda.
                        </li>

                    </ul>

                    <p class="text-danger">
                        <b>PERHATIKAN:</b> (10 Menit) Setiap nomor hanya ada
                        1 (satu) tanda di bawah masing-masing kolom
                        <b>P</b> dan <b>K</b>.
                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- =================================================
         QUIZ
    ================================================== -->

    <div id="quiz1" style="display: none;">

        <div class="ibox">

            <div class="ibox-content">

                <?php
                    include 'disc.php';
                ?>

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

var tanggal_hariini_dmy = moment().format('DD MMM YYYY');

// BEGIN datepicker init
$('#periode').datepicker({
    setDate: new Date(),
    autoclose: true,
    todayHighlight: true,
    clearBtn: true,
    format: "dd M yyyy",
    minViewMode: 'month'
});
// END datepicker init

document.getElementById('id_hcd').style.display = 'none';
document.getElementById('quiz1').style.display = 'none';

</script>

<?php
require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_disc/fn/hrctsth_disc_fn.php';
?>

<!-- end content here -->

<!-- do not erase -->

<?php
//require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php';
?>
