
<?php
require_once '../../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_css_load.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/header1_must_include.php';

$nama_tabel = 'hrctsth_kostik';
$nama_tabels_d = [];
?>

<style>
/* =========================================================
   PAPI KOSTICK - MINIMAL PROFESSIONAL THEME
========================================================= */

:root {
    /* Warna tombol saja */
    --kostik-button: #7654CF;
    --kostik-button-hover: #6242B5;

    /* Warna netral */
    --kostik-bg: #F7F6F9;
    --kostik-surface: #FFFFFF;
    --kostik-text: #34313A;
    --kostik-muted: #77717F;
    --kostik-border: #E8E4EC;
    --kostik-shadow: 0 2px 10px rgba(40, 30, 55, 0.04);
}

/* Background */
body {
    background: var(--kostik-bg) !important;
    color: var(--kostik-text);
}

/* Main wrapper */
.kostik-page {
    padding-top: 24px;
    padding-bottom: 40px;
    color: var(--kostik-text);
}

/* Card */
.kostik-page .ibox {
    background: var(--kostik-surface) !important;
    border: 1px solid var(--kostik-border);
    border-radius: 10px;
    box-shadow: var(--kostik-shadow);
    overflow: hidden;
}

.kostik-page .ibox-content {
    background: #FFFFFF !important;
    border: none !important;
    padding: 24px !important;
}

/* Heading */
.kostik-page h3 {
    color: var(--kostik-text);
    font-size: 20px;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 20px;
}

.kostik-page h5 {
    color: var(--kostik-text);
    font-weight: 600;
}

/* Labels */
.kostik-page label {
    color: #514B59;
    font-weight: 500;
    font-size: 13px;
}

/* Form controls */
.kostik-page .form-control {
    background: #FFFFFF !important;
    border: 1px solid #DED9E5 !important;
    border-radius: 6px !important;
    color: var(--kostik-text) !important;
    min-height: 38px;
    box-shadow: none !important;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.kostik-page .form-control:focus {
    border-color: #A9A3B1 !important;
    box-shadow: 0 0 0 3px rgba(80, 70, 95, 0.07) !important;
    outline: none;
}

.kostik-page .form-control:disabled {
    background: #F5F4F7 !important;
    color: #77717F !important;
    cursor: not-allowed;
}

/* Input group */
.kostik-page .input-group {
    border-radius: 6px;
}

/* Buttons */
.kostik-page .btn {
    border-radius: 6px !important;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: none !important;
    transition: background-color .2s ease, border-color .2s ease;
}

/* Primary button */
.kostik-page .btn-primary {
    background: var(--kostik-button) !important;
    border: 1px solid var(--kostik-button) !important;
    color: #FFFFFF !important;
}

.kostik-page .btn-primary:hover,
.kostik-page .btn-primary:focus {
    background: var(--kostik-button-hover) !important;
    border-color: var(--kostik-button-hover) !important;
    color: #FFFFFF !important;
}

/* Secondary button */
.kostik-page .btn-secondary {
    background: #F3F1F5 !important;
    border: 1px solid var(--kostik-border) !important;
    color: #514B59 !important;
}

.kostik-page .btn-secondary:hover {
    background: #EAE6EF !important;
    color: var(--kostik-text) !important;
}

/* Modal */
.kostik-page .modal-content {
    background: #FFFFFF !important;
    border: 1px solid var(--kostik-border);
    border-radius: 10px;
    box-shadow: 0 10px 35px rgba(30, 20, 45, 0.12);
    overflow: hidden;
}

.kostik-page .modal-header {
    background: #FFFFFF !important;
    border-bottom: 1px solid var(--kostik-border);
    padding: 16px 20px;
}

.kostik-page .modal-title {
    color: var(--kostik-text);
    font-size: 17px;
    font-weight: 600;
}

.kostik-page .modal-body {
    background: #FFFFFF !important;
    color: #514B59;
    padding: 22px;
    line-height: 1.7;
    font-size: 14px;
}

.kostik-page .modal-body h3 {
    color: var(--kostik-text);
    font-size: 18px;
    font-weight: 600;
    margin-top: 12px;
}

.kostik-page .modal-body .text-danger {
    color: #A45B65 !important;
}

.kostik-page .modal-footer {
    background: #FFFFFF !important;
    border-top: 1px solid var(--kostik-border);
    padding: 14px 20px;
}

.kostik-page .close {
    color: #77717F !important;
    opacity: .8;
    text-shadow: none;
}

/* Grid */
.kostik-page .grid-container {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(7, 48px);
    gap: 0;
}

.kostik-page .grid-item {
    display: flex;
    align-items: center;
    justify-content: center;
}

.kostik-page .grid-box {
    border: 1px solid #D9D4DF;
    background: #FFFFFF;
    color: var(--kostik-text);
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color .15s ease, border-color .15s ease;
}

.kostik-page .grid-box:hover {
    background: #F3F2F5;
    border-color: #BDB8C5;
}

/* Grid selection states - neutral */
.kostik-page .grid-box.selected,
.kostik-page .grid-box.active,
.kostik-page .grid-box.answered {
    background: #EAE8ED !important;
    border-color: #BDB8C5 !important;
    color: var(--kostik-text) !important;
}

/* Quiz content */
.kostik-page #quiz1 {
    margin-top: 20px;
}

/* Datepicker */
.datepicker {
    border: 1px solid var(--kostik-border) !important;
    border-radius: 7px !important;
    box-shadow: 0 5px 20px rgba(30, 20, 45, .10) !important;
}

.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td span.active {
    background: #EAE8ED !important;
    background-image: none !important;
    color: var(--kostik-text) !important;
    text-shadow: none !important;
}

.datepicker table tr td.today {
    background: #F3F2F5 !important;
    color: var(--kostik-text) !important;
}

/* Responsive */
@media (max-width: 767px) {
    .kostik-page {
        padding-top: 12px;
    }

    .kostik-page .ibox-content {
        padding: 16px !important;
    }

    .kostik-page .row > [class*="col-"] {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }

    .kostik-page .grid-container {
        grid-template-columns: repeat(10, 30px);
    }

    .kostik-page .grid-box {
        width: 30px;
        height: 30px;
    }

    .kostik-page .qb {
        order: -1;
    }

    .kostik-page .modal-body {
        padding: 16px;
    }
}
</style>

<div class="kostik-page">

    <div class="container-fluid mt-4">

        <div class="ibox">
            <div class="ibox-content">

                <h3>Tes Papi Kostik</h3>

                <form id="kostikForm">

                    <div class="row">

                        <div class="col-6">

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">
                                    Kode Kostik
                                </label>

                                <div class="col-lg-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="kode"
                                        name="kode"
                                        required
                                    >
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
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                            </div>

                        </div>

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
                                        disabled
                                    >
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
                                        disabled
                                    >
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row" style="display:none">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_hcd"></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="id_hcd"
                                    name="id_hcd"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-6">
                            <button
                                style="display:none"
                                type="button"
                                id="button_modal1"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal1"
                            >
                                Instruksi
                            </button>
                        </div>

                        <div class="col-6 d-flex justify-content-end">

                            <button
                                type="button"
                                id="kirim"
                                class="btn btn-primary"
                                onclick="noKtp()"
                            >
                                Kirim
                            </button>

                            <button
                                style="display:none"
                                type="button"
                                id="goToQuiz"
                                class="btn btn-primary"
                                onclick="startQuiz()"
                            >
                                Mulai
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- Modal Instruksi -->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">

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
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <p class="text-danger">
                        <b>WAKTU PENGERJAAN (12 Menit)</b>
                    </p>

                    <h3>INSTRUKSI PAPI KOSTIK</h3>

                    <p>
                        Dihadapan saudara ada persoalan yang didalamnya terdapat
                        90 nomor soal, dimana pada masing-masing nomor terdapat
                        2 pasang pernyataan. Tugas anda adalah memilih salah satu
                        dari setiap pasangan pernyataan tersebut yang anda anggap
                        paling menggambarkan kepribadian atau diri anda.
                    </p>

                    <p>
                        Apabila kedua pernyataan tersebut memiliki kemiripan
                        dengan diri anda saat ini ataupun keduanya tidak satupun
                        menggambarkan diri anda, maka cobalah pertimbangkan kembali
                        secara teliti hingga anda dapat menemukan pernyataan yang
                        paling menggambarkan diri anda.
                    </p>

                    <p><b>Contoh:</b></p>

                    <p>
                        A. Saya adalah pekerja keras
                        <br>
                        B. Saya adalah pemurung
                    </p>

                    <p>
                        Jika anda merasa seseorang yang pekerja keras, maka
                        silahkan memilih pilihan (A). Jika anda merasa seseorang
                        yang pemurung, maka pilihlah jawaban (B).
                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Quiz -->
    <div id="quiz1" style="display:none;">

        <div class="ibox">

            <div class="ibox-content">

                <?php include 'kostik.php'; ?>

            </div>

        </div>

    </div>

</div>

<!-- BEGIN JS -->

<?php
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';

require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php';
?>

<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<script>

var tanggal_hariini_dmy = moment().format('DD MMM YYYY');

$('#periode').datepicker({
    setDate: new Date(),
    autoclose: true,
    todayHighlight: true,
    clearBtn: true,
    format: "dd M yyyy",
    minViewMode: 'month'
});

document.getElementById('id_hcd').style.display = 'none';
document.getElementById('quiz1').style.display = 'none';

</script>

<?php
require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_kostik/fn/hrctsth_kostik_fn.php';
?>

<!-- end content here -->
<!-- do not erase -->

<?php
//require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php';
?>
