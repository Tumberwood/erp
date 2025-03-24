<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrctsth_cfit';
	$nama_tabels_d = [];
?>
<style>
  .grid-container {
      width: 100%; /* Make the container width responsive to the parent */
      display: grid;
      grid-template-columns: repeat(3, 48px); /* Three columns of fixed size */
      gap: 0; /* No gap between grid items */
  }

  .grid-item {
      display: flex; /* Flexbox to center content */
      align-items: center; /* Center vertically */
      justify-content: center; /* Center horizontally */
  }

  .grid-box {
      border: 1px solid #000; /* Border for grid boxes */
      width: 48px; /* Fixed width for each box */
      height: 48px; /* Fixed height for each box */
      display: flex; /* Flexbox to center text */
      align-items: center; /* Center vertically */
      justify-content: center; /* Center horizontally */
      cursor: pointer; /* Pointer on hover */
      transition: background-color 0.3s; /* Smooth transition */
  }
  
  /* Tampilan Mobile, Ferry 24 Mar 2025 */
  @media (max-width: 400px) {
    .quiz-option {
      display: inline-block;
      width: calc(33.3% - 5px); /* 3 kolom per baris */
      text-align: center;
    }

    .quiz-option img {
      width: 100%;
      height: auto;
    }

    .soal {
      width: 100%;
      height: auto;
      display: block;
      margin: 10px auto;
    }

    .col-lg-2 {  
      order: -1; /* Biar Question Box naik ke atas */  
    }  

    .grid-container {
        grid-template-columns: repeat(6, 48px); /* Three columns of fixed size */
    }
    
    .quiz-image-container {
      display: inline-block;
      width: calc(33.3% - 5px); /* 3 kolom per baris */
      text-align: center;
    }

    .quiz-image-container img {
      width: 100%;
      height: auto;
    }
    
    .cfit4-option {
      display: inline-block;
      width: calc(33.3% - 5px); /* 3 kolom per baris */
      text-align: center;
    }

    .cfit4-option img {
      width: 100%;
      height: auto;
    }
  }
  /* body::before {
      content: "SOLUSI INDONESIA";
      position: fixed;
      top: 40%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 50px;
      color: rgba(255, 0, 0, 0.3);
      font-weight: bold;
      pointer-events: none;
      z-index: 9999;
  } */

</style>

<div class="container">
  <form id="cfitForm">
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-6">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label">Kode CFIT</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="kode" name="kode" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label">Tanggal</label>
                <div class="col-lg-8">
                    <div class="input-group input-daterange" id="periode">
                        <input type="text" id="start_date" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-6">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label">Nama Kandidat</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="nama" name="nama" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label">No KTP</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="ktp" name="ktp" disabled>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group row">
      <div class="col-6">
        <button type="button" style="display: none" id="button_modal1" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Petunjuk Sesi 1</button>
        <button type="button" style="display: none" id="button_modal2" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Petunjuk Sesi 2</button>
        <button type="button" style="display: none" id="button_modal3" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">Petunjuk Sesi 3</button>
        <button type="button" style="display: none" id="button_modal4" class="btn btn-primary" data-toggle="modal" data-target="#myModal4">Petunjuk Sesi 4</button>
      </div>
        <div class="col-6 d-flex justify-content-end">
        <button type="button" style="display: none" id="mulaiCFIT1" class="btn btn-primary" onclick="startQuiz()">Mulai Sesi 1</button>
        <button type="button" style="display: none" id="mulaiCFIT2" class="btn btn-primary" onclick="startQuiz2()">Mulai Sesi 2</button>
        <button type="button" style="display: none" id="mulaiCFIT3" class="btn btn-primary" onclick="startQuiz3()">Mulai Sesi 3</button>
        <button type="button" style="display: none" id="mulaiCFIT4" class="btn btn-primary" onclick="startQuiz4()">Mulai Sesi 4</button>
      </div>
    </div>

    <div class="row" style="display: none">
      <div class="col-md-12">
        <div class="form-group">
          <label for="id_hcd"></label>
          <input type="text" class="form-control" id="id_hcd" name="id_hcd" disabled>
        </div>
      </div>
    </div>
    <button type="button" id="kirim" class="btn btn-primary" onclick="noKtp()" >Kirim</button>
	</form>
</div>	

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal1Label">Petunjuk CFIT Sesi 1</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Kolom Kiri: Instruksi -->
          <div class="col-md-6">
            <div class="instruction">
              <p class="text-danger"> <b>WAKTU PENGERJAAN (3 Menit)</b></p>
              <h2><b>SUBTES 1</b></h2>
              <p>Mari kita mulai tes pertama. Perhatikan gambar-gambar contoh pada tes ini.</p>
              <p>Pada baris pertama, terdapat sebuah lingkaran di kotak pertama yang semakin ke kanan ukurannya semakin kecil.</p>
              <p>Tugas Anda adalah memilih jawaban yang paling sesuai untuk melanjutkan pola tersebut.</p>
              <p>Waktu mengerjakan terbatas, dan halaman akan berpindah secara otomatis ketika waktu habis. Oleh karena itu, kerjakan dengan cermat dan teliti.</p>
              <p><strong>Selamat mengerjakan!</strong></p>
            </div>
          </div>
          
          <!-- Kolom Kanan: Gambar -->
          <div class="col-md-6 text-center">
            <img src="part1/hint/1.jpg" class="img-fluid" style="max-width: 100%;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal SUBTES 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal2Label">Petunjuk CFIT Sesi 2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Kolom Kiri: Instruksi -->
          <div class="col-md-6">
            <div class="instruction">
              <p class="text-danger"> <b>WAKTU PENGERJAAN (4 Menit)</b></p>
              <h2><b>Subtes 2</b></h2>

              <p>Perhatikan contoh gambar berikut sebelum memulai tes.</p>
              <p>Pada setiap soal, terdapat lima gambar dalam kotak. Tiga gambar memiliki bentuk yang sama, sedangkan dua gambar lainnya memiliki bentuk yang berbeda.</p>
              <p>Tugas Anda adalah menemukan dua gambar yang berbeda dari lima gambar yang tersedia.</p>
              <p>Untuk menjawab, pilih dua gambar yang menurut Anda tidak sesuai dengan tiga gambar lainnya.</p>
              <p>Waktu mengerjakan tes ini terbatas, dan halaman akan berpindah secara otomatis setelah waktu habis. Kerjakan dengan cermat dan teliti.</p>
              <p><strong>Selamat mengerjakan!</strong></p>
            </div>
          </div>

          <!-- Kolom Kanan: Gambar -->
          <div class="col-md-6 text-center">
            <img src="part2/hint/1.jpg" class="img-fluid" style="max-width: 100%;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal SUBTES 3 -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModal3Label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal3Label">Petunjuk CFIT Sesi 3</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Kolom Kiri: Instruksi -->
          <div class="col-md-6">
            <div class="instruction">
              <p class="text-danger"> <b>WAKTU PENGERJAAN (3 Menit)</b></p>
              <h2><b>SUBTES 3</b></h2>
              <p>Perhatikan contoh gambar berikut sebelum memulai tes.</p>
              <p>Pada bagian kiri, terdapat sebuah kotak besar yang berisi beberapa kotak kecil dengan gambar di dalamnya. Namun, salah satu kotak tidak memiliki gambar.</p>
              <p>Tugas Anda adalah memilih satu jawaban yang benar dari enam pilihan kotak kecil di sebelah kanan untuk mengisi kotak kosong tersebut.</p>
              <p>Waktu mengerjakan tes ini terbatas, dan halaman akan berpindah secara otomatis setelah waktu habis. Kerjakan dengan cermat dan teliti.</p>
              <p><strong>Selamat mengerjakan!</strong></p>
            </div>
          </div>

          <!-- Kolom Kanan: Gambar -->
          <div class="col-md-6 text-center">
            <img src="part3/1.jpg" class="img-fluid" style="max-width: 100%;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal SUBTES 4 -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModal4Label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal4Label">Petunjuk CFIT Sesi 4</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Kolom Kiri: Instruksi -->
          <div class="col-md-6">
            <div class="instruction">
              <p class="text-danger"> <b>WAKTU PENGERJAAN (2 Menit 30 Detik)</b></p>
              <h2><b>SUBTES 4</b></h2>
              <p>Ini adalah subtes terakhir. Perhatikan contoh gambar berikut.</p>
              <p>Di bagian kiri, terdapat satu gambar sebagai acuan. Sementara di bagian kanan, terdapat lima gambar sebagai pilihan jawaban.</p>
              <p>Tugas Anda adalah memilih gambar yang paling sesuai atau paling mendekati dengan gambar yang ada di sebelah kiri.</p>
              <p>Waktu untuk mengerjakan tes ini terbatas, dan jawaban yang telah dipilih akan terkunci secara otomatis.</p>
              <p>Kerjakan dengan cermat dan teliti.</p>
              <p><strong>Selamat mengerjakan!</strong></p>
            </div>
          </div>

          <!-- Kolom Kanan: Gambar -->
          <div class="col-md-6 text-center">
            <img src="part4/1.jpg" class="img-fluid" style="max-width: 100%;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<div class="ibox">
  <div class="ibox-content">

    <div id="quiz1" style="display: none;">
      <?php
          include 'cfit.php'; // Include the HTML file
      ?>
    </div>
    
    <div id="quiz2" style="display: none;">
      <?php
          include 'cfit2.php'; // Include the HTML file
      ?>
    </div>
    
    <div id="quiz3" style="display: none;">
      <?php
          include 'cfit3.php'; // Include the HTML file
      ?>
    </div>
    
    <div id="quiz4" style="display: none;">
      <?php
          include 'cfit4.php'; // Include the HTML file
      ?>
    </div>
  </div>
</div>

<!-- BEGIN JS -->
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; ?>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_cfit/fn/hrctsth_cfit_fn.php'; ?>

<!-- end content here -->

<script>
  //function untuk img agar tidak bisa disimpan gambarnya
  document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll("img").forEach(img => {
          img.oncontextmenu = () => false;
      });
  });
</script>
<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
