
<?php
require_once '../../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_css_load.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/header1_must_include.php';

$nama_tabel = 'hrctsth_cfit';
$nama_tabels_d = [];
?>

<style>
/* =========================================================
   CFIT - MINIMAL PROFESSIONAL THEME
========================================================= */

:root {
    /* Warna tombol saja */
    --cfit-button: #7654CF;
    --cfit-button-hover: #6242B5;

    /* Warna netral */
    --cfit-bg: #F7F6F9;
    --cfit-surface: #FFFFFF;
    --cfit-text: #34313A;
    --cfit-muted: #77717F;
    --cfit-border: #E8E4EC;
    --cfit-shadow: 0 2px 10px rgba(40, 30, 55, 0.04);
}

/* =========================================================
   BACKGROUND
========================================================= */

body {
    background: var(--cfit-bg) !important;
    color: var(--cfit-text);
}

/* =========================================================
   MAIN WRAPPER
========================================================= */

.cfit-page {
    padding-top: 24px;
    padding-bottom: 40px;
    color: var(--cfit-text);
}

/* =========================================================
   CARD
========================================================= */

.cfit-page .ibox {
    background: var(--cfit-surface) !important;
    border: 1px solid var(--cfit-border);
    border-radius: 10px;
    box-shadow: var(--cfit-shadow);
    overflow: hidden;
}

.cfit-page .ibox-content {
    background: #FFFFFF !important;
    border: none !important;
    padding: 24px !important;
}

/* =========================================================
   HEADING
========================================================= */

.cfit-page h3 {
    color: var(--cfit-text);
    font-size: 20px;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 20px;
}

.cfit-page h2 {
    color: var(--cfit-text);
    font-size: 19px;
    font-weight: 600;
}

.cfit-page h5 {
    color: var(--cfit-text);
    font-weight: 600;
}

/* =========================================================
   LABEL
========================================================= */

.cfit-page label {
    color: #514B59;
    font-weight: 500;
    font-size: 13px;
}

/* =========================================================
   FORM CONTROL
========================================================= */

.cfit-page .form-control {
    background: #FFFFFF !important;
    border: 1px solid #DED9E5 !important;
    border-radius: 6px !important;
    color: var(--cfit-text) !important;
    min-height: 38px;
    box-shadow: none !important;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.cfit-page .form-control:focus {
    border-color: #BDB6C9 !important;
    box-shadow: 0 0 0 3px rgba(80, 70, 95, 0.07) !important;
    outline: none;
}

.cfit-page .form-control:disabled {
    background: #F5F4F7 !important;
    color: var(--cfit-muted) !important;
    cursor: not-allowed;
}

/* =========================================================
   BUTTONS
========================================================= */

.cfit-page .btn {
    border-radius: 6px !important;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: none !important;
    transition: background-color .2s ease, border-color .2s ease;
}

/* Primary button */
.cfit-page .btn-primary {
    background: var(--cfit-button) !important;
    border: 1px solid var(--cfit-button) !important;
    color: #FFFFFF !important;
}

.cfit-page .btn-primary:hover,
.cfit-page .btn-primary:focus {
    background: var(--cfit-button-hover) !important;
    border-color: var(--cfit-button-hover) !important;
    color: #FFFFFF !important;
}

/* Secondary button */
.cfit-page .btn-secondary {
    background: #F3F1F5 !important;
    border: 1px solid var(--cfit-border) !important;
    color: #514B59 !important;
}

.cfit-page .btn-secondary:hover {
    background: #EAE6EF !important;
    color: var(--cfit-text) !important;
}

/* =========================================================
   MODAL
========================================================= */

.cfit-page .modal-content {
    background: #FFFFFF !important;
    border: 1px solid var(--cfit-border);
    border-radius: 10px;
    box-shadow: 0 10px 35px rgba(30, 20, 45, 0.12);
    overflow: hidden;
}

.cfit-page .modal-header {
    background: #FFFFFF !important;
    border-bottom: 1px solid var(--cfit-border);
    padding: 16px 20px;
}

.cfit-page .modal-title {
    color: var(--cfit-text);
    font-size: 17px;
    font-weight: 600;
}

.cfit-page .modal-body {
    background: #FFFFFF !important;
    color: #514B59;
    padding: 22px;
    line-height: 1.7;
    font-size: 14px;
}

.cfit-page .modal-body h2 {
    color: var(--cfit-text);
    font-size: 19px;
    font-weight: 600;
}

.cfit-page .modal-body .instruction {
    color: #514B59;
}

.cfit-page .modal-body .text-danger {
    color: #A45B65 !important;
}

.cfit-page .modal-footer {
    background: #FFFFFF !important;
    border-top: 1px solid var(--cfit-border);
    padding: 14px 20px;
}

.cfit-page .close {
    color: var(--cfit-muted) !important;
    opacity: .8;
    text-shadow: none;
}

/* =========================================================
   GRID
========================================================= */

.cfit-page .grid-container {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, 48px);
    gap: 0;
}

.cfit-page .grid-item {
    display: flex;
    align-items: center;
    justify-content: center;
}

.cfit-page .grid-box {
    border: 1px solid #D9D4DF;
    background: #FFFFFF;
    color: var(--cfit-text);
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color .15s ease, border-color .15s ease;
}

.cfit-page .grid-box:hover {
    background: #F3F2F5;
    border-color: #BDB8C5;
}

/* Grid selected state - neutral */
.cfit-page .grid-box.selected,
.cfit-page .grid-box.active,
.cfit-page .grid-box.answered {
    background: #EAE8ED !important;
    border-color: #BDB8C5 !important;
    color: var(--cfit-text) !important;
}

/* =========================================================
   QUIZ IMAGES
========================================================= */

.cfit-page .quiz-option {
    display: inline-block;
    text-align: center;
}

.cfit-page .quiz-option img {
    max-width: 100%;
    height: auto;
}

.cfit-page .soal {
    max-width: 100%;
    height: auto;
}

.cfit-page .soal3 {
    max-width: 100%;
    height: auto;
}

.cfit-page .quiz-image-container {
    display: inline-block;
    text-align: center;
}

.cfit-page .quiz-image-container img {
    max-width: 100%;
    height: auto;
}

.cfit-page .cfit4-option {
    display: inline-block;
    text-align: center;
}

.cfit-page .cfit4-option img {
    max-width: 100%;
    height: auto;
}

/* =========================================================
   DATEPICKER
========================================================= */

.datepicker {
    border: 1px solid var(--cfit-border) !important;
    border-radius: 7px !important;
    box-shadow: 0 5px 20px rgba(30, 20, 45, .10) !important;
}

.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td span.active {
    background: #EAE8ED !important;
    background-image: none !important;
    color: var(--cfit-text) !important;
    text-shadow: none !important;
}

.datepicker table tr td.today {
    background: #F3F2F5 !important;
    color: var(--cfit-text) !important;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 767px) {

    .cfit-page {
        padding-top: 12px;
    }

    .cfit-page .ibox-content {
        padding: 16px !important;
    }

    .cfit-page .row > [class*="col-"] {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }

    .cfit-page .grid-container {
        grid-template-columns: repeat(6, 48px);
    }

    .cfit-page .quiz-option {
        display: inline-block;
        width: calc(33.3% - 5px);
        text-align: center;
    }

    .cfit-page .quiz-option img {
        width: 100%;
        height: auto;
    }

    .cfit-page .soal {
        width: 100%;
        height: auto;
        display: block;
        margin: 10px auto;
    }

    .cfit-page .soal3 {
        width: 70%;
        height: auto;
        display: block;
        margin: 10px auto;
        transform: translateY(30px);
    }

    .cfit-page .col-lg-2 {
        order: -1;
    }

    .cfit-page .quiz-image-container {
        display: inline-block;
        width: calc(33.3% - 5px);
        text-align: center;
    }

    .cfit-page .quiz-image-container img {
        width: 100%;
        height: auto;
    }

    .cfit-page .cfit4-option {
        display: inline-block;
        width: calc(33.3% - 5px);
        text-align: center;
    }

    .cfit-page .cfit4-option img {
        width: 100%;
        height: auto;
    }

    .cfit-page .modal-body {
        padding: 16px;
    }
}

@media (max-width: 400px) {
    .cfit-page .grid-container {
        grid-template-columns: repeat(6, 48px);
    }
}
</style>

<div class="cfit-page">

    <div class="container-fluid mt-4">

        <div class="ibox">

            <div class="ibox-content">

                <h3>Tes CFIT</h3>

                <br>

                <form id="cfitForm">

                    <div class="row">

                        <!-- Kolom Kiri -->
                        <div class="col-6">

                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">
                                    Kode CFIT
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

                    <div class="form-group row">

                        <div class="col-6">

                            <button
                                type="button"
                                style="display: none"
                                id="button_modal1"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal1">
                                Petunjuk Sesi 1
                            </button>

                            <button
                                type="button"
                                style="display: none"
                                id="button_modal2"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal2">
                                Petunjuk Sesi 2
                            </button>

                            <button
                                type="button"
                                style="display: none"
                                id="button_modal3"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal3">
                                Petunjuk Sesi 3
                            </button>

                            <button
                                type="button"
                                style="display: none"
                                id="button_modal4"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal4">
                                Petunjuk Sesi 4
                            </button>

                        </div>

                        <div class="col-6 d-flex justify-content-end">

                            <button
                                type="button"
                                style="display: none"
                                id="mulaiCFIT1"
                                class="btn btn-primary"
                                onclick="startQuiz()">
                                Mulai Sesi 1
                            </button>

                            <button
                                type="button"
                                style="display: none"
                                id="mulaiCFIT2"
                                class="btn btn-primary"
                                onclick="startQuiz2()">
                                Mulai Sesi 2
                            </button>

                            <button
                                type="button"
                                style="display: none"
                                id="mulaiCFIT3"
                                class="btn btn-primary"
                                onclick="startQuiz3()">
                                Mulai Sesi 3
                            </button>

                            <button
                                type="button"
                                style="display: none"
                                id="mulaiCFIT4"
                                class="btn btn-primary"
                                onclick="startQuiz4()">
                                Mulai Sesi 4
                            </button>

                        </div>

                    </div>

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

                    <button
                        type="button"
                        id="kirim"
                        class="btn btn-primary"
                        onclick="noKtp()">
                        Kirim
                    </button>

                </form>

            </div>

        </div>

    </div>

    <!-- =================================================
         MODAL SUBTES 1
    ================================================== -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">

        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="myModal1Label">
                        Petunjuk CFIT Sesi 1
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

                    <div class="row">

                        <div class="col-md-6">

                            <div class="instruction">

                                <p class="text-danger">
                                    <b>WAKTU PENGERJAAN (3 Menit)</b>
                                </p>

                                <h2><b>SUBTES 1</b></h2>

                                <p>
                                    Mari kita mulai tes pertama. Perhatikan gambar-gambar contoh pada tes ini.
                                </p>

                                <p>
                                    Pada baris pertama, terdapat sebuah lingkaran di kotak pertama yang semakin ke kanan ukurannya semakin kecil.
                                </p>

                                <p>
                                    Tugas Anda adalah memilih jawaban yang paling sesuai untuk melanjutkan pola tersebut.
                                </p>

                                <p>
                                    Waktu mengerjakan terbatas, dan halaman akan berpindah secara otomatis ketika waktu habis. Oleh karena itu, kerjakan dengan cermat dan teliti.
                                </p>

                                <p><strong>Selamat mengerjakan!</strong></p>

                            </div>

                        </div>

                        <div class="col-md-6 text-center">

                            <img
                                src="part1/hint/1.jpg"
                                class="img-fluid"
                                style="max-width: 100%;">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Tutup
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- =================================================
         MODAL SUBTES 2
    ================================================== -->

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">

        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="myModal2Label">
                        Petunjuk CFIT Sesi 2
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

                    <div class="row">

                        <div class="col-md-6">

                            <div class="instruction">

                                <p class="text-danger">
                                    <b>WAKTU PENGERJAAN (4 Menit)</b>
                                </p>

                                <h2><b>Subtes 2</b></h2>

                                <p>
                                    Perhatikan contoh gambar berikut sebelum memulai tes.
                                </p>

                                <p>
                                    Pada setiap soal, terdapat lima gambar dalam kotak. Tiga gambar memiliki bentuk yang sama, sedangkan dua gambar lainnya memiliki bentuk yang berbeda.
                                </p>

                                <p>
                                    Tugas Anda adalah menemukan dua gambar yang berbeda dari lima gambar yang tersedia.
                                </p>

                                <p>
                                    Untuk menjawab, pilih dua gambar yang menurut Anda tidak sesuai dengan tiga gambar lainnya.
                                </p>

                                <p>
                                    Waktu mengerjakan tes ini terbatas, dan halaman akan berpindah secara otomatis setelah waktu habis. Kerjakan dengan cermat dan teliti.
                                </p>

                                <p><strong>Selamat mengerjakan!</strong></p>

                            </div>

                        </div>

                        <div class="col-md-6 text-center">

                            <img
                                src="part2/hint/1.jpg"
                                class="img-fluid"
                                style="max-width: 100%;">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Tutup
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- =================================================
         MODAL SUBTES 3
    ================================================== -->

    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModal3Label" aria-hidden="true">

        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="myModal3Label">
                        Petunjuk CFIT Sesi 3
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

                    <div class="row">

                        <div class="col-md-6">

                            <div class="instruction">

                                <p class="text-danger">
                                    <b>WAKTU PENGERJAAN (3 Menit)</b>
                                </p>

                                <h2><b>SUBTES 3</b></h2>

                                <p>
                                    Perhatikan contoh gambar berikut sebelum memulai tes.
                                </p>

                                <p>
                                    Pada bagian kiri, terdapat sebuah kotak besar yang berisi beberapa kotak kecil dengan gambar di dalamnya. Namun, salah satu kotak tidak memiliki gambar.
                                </p>

                                <p>
                                    Tugas Anda adalah memilih satu jawaban yang benar dari enam pilihan kotak kecil di sebelah kanan untuk mengisi kotak kosong tersebut.
                                </p>

                                <p>
                                    Waktu mengerjakan tes ini terbatas, dan halaman akan berpindah secara otomatis setelah waktu habis. Kerjakan dengan cermat dan teliti.
                                </p>

                                <p><strong>Selamat mengerjakan!</strong></p>

                            </div>

                        </div>

                        <div class="col-md-6 text-center">

                            <img
                                src="part3/1.jpg"
                                class="img-fluid"
                                style="max-width: 100%;">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Tutup
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- =================================================
         MODAL SUBTES 4
    ================================================== -->

    <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModal4Label" aria-hidden="true">

        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="myModal4Label">
                        Petunjuk CFIT Sesi 4
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

                    <div class="row">

                        <div class="col-md-6">

                            <div class="instruction">

                                <p class="text-danger">
                                    <b>WAKTU PENGERJAAN (2 Menit 30 Detik)</b>
                                </p>

                                <h2><b>SUBTES 4</b></h2>

                                <p>
                                    Ini adalah subtes terakhir. Perhatikan contoh gambar berikut.
                                </p>

                                <p>
                                    Di bagian kiri, terdapat satu gambar sebagai acuan. Sementara di bagian kanan, terdapat lima gambar sebagai pilihan jawaban.
                                </p>

                                <p>
                                    Tugas Anda adalah memilih gambar yang paling sesuai atau paling mendekati dengan gambar yang ada di sebelah kiri.
                                </p>

                                <p>
                                    Waktu untuk mengerjakan tes ini terbatas, dan jawaban yang telah dipilih akan terkunci secara otomatis.
                                </p>

                                <p>
                                    Kerjakan dengan cermat dan teliti.
                                </p>

                                <p><strong>Selamat mengerjakan!</strong></p>

                            </div>

                        </div>

                        <div class="col-md-6 text-center">

                            <img
                                src="part4/1.jpg"
                                class="img-fluid"
                                style="max-width: 100%;">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Tutup
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- =================================================
         QUIZ SESSION 1
    ================================================== -->

    <div class="container-fluid mt-4">

        <div id="quiz1" style="display: none;">

            <div class="ibox">

                <div class="ibox-content">

                    <?php
                        include 'cfit.php';
                    ?>

                </div>

            </div>

        </div>

        <!-- =================================================
             QUIZ SESSION 2
        ================================================== -->

        <div id="quiz2" style="display: none;">

            <div class="ibox">

                <div class="ibox-content">

                    <?php
                        include 'cfit2.php';
                    ?>

                </div>

            </div>

        </div>

        <!-- =================================================
             QUIZ SESSION 3
        ================================================== -->

        <div id="quiz3" style="display: none;">

            <div class="ibox">

                <div class="ibox-content">

                    <?php
                        include 'cfit3.php';
                    ?>

                </div>

            </div>

        </div>

        <!-- =================================================
             QUIZ SESSION 4
        ================================================== -->

        <div id="quiz4" style="display: none;">

            <div class="ibox">

                <div class="ibox-content">

                    <?php
                        include 'cfit4.php';
                    ?>

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

// Function untuk img agar tidak bisa disimpan gambarnya
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".cfit-page img").forEach(img => {
        img.oncontextmenu = () => false;
    });

});

</script>

<?php
require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_cfit/fn/hrctsth_cfit_fn.php';
?>

<!-- do not erase -->

<?php
//require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php';
?>
