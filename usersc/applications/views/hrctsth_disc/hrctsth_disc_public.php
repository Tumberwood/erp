<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php';
    require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); 
?>

<?php
	$nama_tabel    = 'hrctsth_disc';
	$nama_tabels_d = [];
?>

<style>
    body {
        background-color: rgb(243,243,244);
    }
</style>

<div class="container-fluid mt-4">
    <div class="ibox">
        <div class="ibox-content" style="padding: 15px">
            <h3>Tes DISC</h3>
            <br>
            <form id="discForm">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kode DISC</label>
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
                    <div class="col-6">
                        <button style="display:none" type="button" id="button_modal1" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Instruksi</button>
                    </div>
                    <div class="col-6 d-flex justify-content-end">    
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
	  	<p class="text-danger"> <b>WAKTU PENGERJAAN (10 Menit)</b></p>

        Setiap nomor dibawah ini memuat 4 (empat) kalimat. Tugas anda adalah:
        <ul>
          <li>Klik pada kolom dibawah huruf [<b>P</b>] di samping kalimat yang <b>PALING menggambarkan</b> diri anda</li>
          <li>Klik pada kolom dibawah huruf [<b>K</b>] di samping kalimat yang <b>PALING TIDAK menggambarkan</b> diri anda</li>
        </ul>
        <p class="text-danger"> <b>PERHATIKAN</b>: (10 Menit) Setiap nomor hanya ada 1 (satu) tanda dibawah masing-masing kolom <b>P</b> dan <b>K</b>.</p>
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
				include 'disc.php'; // Include the HTML file
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
	document.getElementById('quiz1').style.display = 'none';
</script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_disc/fn/hrctsth_disc_fn.php'; ?>

<!-- end content here -->

<!-- do not erase -->
<?php //require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
