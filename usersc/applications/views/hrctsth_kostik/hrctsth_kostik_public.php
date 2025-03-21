<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php';
    require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); 
?>

<?php
	$nama_tabel    = 'hrctsth_kostik';
	$nama_tabels_d = [];
?>

<style>
    .grid-container {
        width: 100%; /* Make the container width responsive to the parent */
        display: grid;
        grid-template-columns: repeat(7, 48px); /* Three columns of fixed size */
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
    body {
        background-color: rgb(243,243,244);
    }
</style>

<div class="container-fluid mt-4">
    <div class="ibox">
        <div class="ibox-content" style="padding: 15px">
            <h3>Tes Papi Kostik</h3>
            <br>
            <form id="kostikForm">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kode Kostik</label>
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

                <!-- Elemen yang disembunyikan -->
                <div class="row" style="display: none">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_hcd"></label>
                            <input type="text" class="form-control" id="id_hcd" name="id_hcd" disabled>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="row mt-3">
                    <div class="col-2">
                        <button style="display:none" type="button" id="button_modal1" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Instruksi</button>
                    </div>
                    <div class="col-10">
                        <button type="button" id="kirim" class="btn btn-primary" onclick="noKtp()">Kirim</button>
                        <button style="display:none" type="button" id="goToQuiz" class="btn btn-primary" onclick="startQuiz()">Mulai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal1Label">Instruksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<p class="text-danger"> <b>WAKTU PENGERJAAN (12 Menit)</b></p>

		<h3>INSTRUKSI PAPI KOSTIK</h3>
			<br>
			Dihadapan saudara ada persoalan yang didalamnya terdapat 90 nomor soal, dimana pada masing-masing nomor terdapat 2 pasang pernyataan. Tugas anda adalah memilih salah satu dari setiap pasangan pernyataan tersebut yang anda anggap paling menggambarkan kepribadian atau diri anda. Apabila kedua  pernyataan tersebut memiliki kemiripan dengan diri anda saat ini ataupun keduanya tidak satupun menggambarkan diri anda, maka cobalah pertimbangkan kembali secara teliti hingga anda dapat menemukan pernyataan yang paling menggambarkan diri anda.
			<br>
			<br>
			Contoh: 
			<ul style="list-style-type: upper-alpha;">
				<li>Saya adalah pekerja keras</li>
				<li>Saya adalah pemurung</li>
			</ul>

			<br>
			Jika anda merasa seseorang yg pekerja keras, maka silahkan memilih pilihan (A). 
			<br>
			Jika anda merasa seseorang yg pemuruh, maka pilihlah jawaban (B).
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="quiz1" style="display: none;">

	<div class="ibox">
		<div class="ibox-content">
			<?php
				include 'kostik.php'; // Include the HTML file
			?>
		</div>
	</div>
</div>


<!-- BEGIN JS -->
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; ?>
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

	document.getElementById('id_hcd').style.display = 'none';
	//hide sesi 1
	document.getElementById('quiz1').style.display = 'none';
</script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_kostik/fn/hrctsth_kostik_fn.php'; ?>

<!-- end content here -->

<!-- do not erase -->
<?php //require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
