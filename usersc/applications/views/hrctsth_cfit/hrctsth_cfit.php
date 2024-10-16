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
      grid-template-columns: repeat(3, 60px); /* Three columns of fixed size */
      gap: 0; /* No gap between grid items */
  }

  .grid-item {
      display: flex; /* Flexbox to center content */
      align-items: center; /* Center vertically */
      justify-content: center; /* Center horizontally */
  }

  .grid-box {
      border: 1px solid #000; /* Border for grid boxes */
      width: 60px; /* Fixed width for each box */
      height: 60px; /* Fixed height for each box */
      display: flex; /* Flexbox to center text */
      align-items: center; /* Center vertically */
      justify-content: center; /* Center horizontally */
      cursor: pointer; /* Pointer on hover */
      transition: background-color 0.3s; /* Smooth transition */
  }
</style>
<div class="container">
    <form id="cfitForm">
      
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Kode CFIT</label>
        <div class="col-lg-5">
          <input type="text" class="form-control" id="kode" name="kode" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Nama Kandidat</label>
        <div class="col-lg-5">
          <input type="text" class="form-control" id="nama" name="nama" disabled>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-lg-3">
          <button type="button" id="button_modal1" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Petunjuk Sesi 1</button>
          <button type="button" id="button_modal2" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Petunjuk Sesi 2</button>
          <button type="button" id="button_modal3" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">Petunjuk Sesi 3</button>
          <button type="button" id="button_modal4" class="btn btn-primary" data-toggle="modal" data-target="#myModal4">Petunjuk Sesi 4</button>
        </div>
        <div class="col-lg-3">
        <button type="button" id="mulaiCFIT1" class="btn btn-primary" onclick="startQuiz()">Mulai Sesi 1</button>
          <button type="button" id="mulaiCFIT2" class="btn btn-primary" onclick="startQuiz2()">Mulai Sesi 2</button>
          <button type="button" id="mulaiCFIT3" class="btn btn-primary" onclick="startQuiz3()">Mulai Sesi 3</button>
          <button type="button" id="mulaiCFIT4" class="btn btn-primary" onclick="startQuiz4()">Mulai Sesi 4</button>
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
		</div>
	</form>
  </div>	



<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal1Label">Petunjuk CFIT Sesi 1</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<img src="part1/hint/1.jpg" style="width: 440px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal1Label">Petunjuk CFIT Sesi 2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<img src="part2/hint/1.jpg" style="width: 440px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal1Label">Petunjuk CFIT Sesi 3</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<img src="part3/1.jpg" style="width: 440px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal1Label">Petunjuk CFIT Sesi 4</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<img src="part4/1.jpg" style="width: 440px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
	document.getElementById('id_hcd').style.display = 'none';
	//hide sesi 1
	document.getElementById('mulaiCFIT1').style.display = 'none';
	document.getElementById('button_modal1').style.display = 'none';
	document.getElementById('quiz1').style.display = 'none';
	//hide sesi 2
	document.getElementById('mulaiCFIT2').style.display = 'none';
	document.getElementById('button_modal2').style.display = 'none';
	document.getElementById('quiz2').style.display = 'none';
	//hide sesi 3
	document.getElementById('mulaiCFIT3').style.display = 'none';
	document.getElementById('button_modal3').style.display = 'none';
	document.getElementById('quiz3').style.display = 'none';
	//hide sesi 4
	document.getElementById('mulaiCFIT4').style.display = 'none';
	document.getElementById('button_modal4').style.display = 'none';
	document.getElementById('quiz4').style.display = 'none';

</script>
<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
