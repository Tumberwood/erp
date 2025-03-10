<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrctsth_kostik';
	$nama_tabels_d = [];
?>

<div class="container">
	<form id="kostikForm">
		<div class="form-group row">
			<label class="col-lg-2 col-form-label">Kode Kostik</label>
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
		
		<div class="row" style="display: none">
			<div class="col-md-12">
				<div class="form-group">
					<label for="id_hcd"></label>
					<input type="text" class="form-control" id="id_hcd" name="id_hcd" disabled>
				</div>
			</div>
		</div>
    <button type="button" id="button_modal1" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Instruksi</button>
		<button type="button" id="kirim" class="btn btn-primary" onclick="noKtp()" >Kirim</button>
	</form>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php'; ?>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth_kostik/fn/hrctsth_kostik_fn.php'; ?>
<!-- datatables main -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/datatables.min.js"></script>

<!-- datatables 3rd party plugins -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/absolute.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/datatables.mark.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/datetime-moment.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/sum().js"></script>

<!-- datatables editor main -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/dataTables.editor.min.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.bootstrap4.min.js"></script>

<!-- datatables editor plugins -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.select2.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.mask.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.quill.js"></script>

<script>	

// Setup Default for Datatables
// If you want to change the setup, please write individually on each page

var colCount;
var colvisCount;

$.fn.dataTable.moment('DD MMM YYYY');
$.fn.dataTable.moment('DD MMM YYYY HH:mm:ss');
$.fn.dataTable.moment('DD MMM YYYY HH:mm');

$.extend( true, $.fn.dataTable.Editor.defaults, {
	formOptions: {
		main: {
			focus: 4,
			onBackground: 'none'
		}
	}
} );

// dom
// P: SearchPanes 
// Q: SearchBuilder 
var dom0 = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

var domP = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'P>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

var domQ = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'Q>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

var domPQ = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'P>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'Q>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

// absolute sorting
var nullTop = $.fn.dataTable.absoluteOrder( [
    { value: null, position: 'top' }
] );

$.extend( true, $.fn.dataTable.defaults, {
	dom: dom0,
	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	pageLength: 10,
	language: {
		paginate: {
			first: "<<",
			previous: "<",
			next: ">",
			last: ">>"
		}
	},
	mark: true,
	select: true,
	processing: true,
	responsive: true,
	
	/**
	 * searchpanes 
	 * disetting di masing-masing halaman
	 */
	// searchPanes: {},	
	
	/**
	 * scroller
	 * di off kan sementara, karena ada bugs pada tab
	 */
	// scrollCollapse: true,
	// scrollY: 300,
    // scroller: {
    //     displayBuffer: 2,
	// 	loadingIndicator: true
    // },
	// scroller: true,
	// deferRender: true,
	
	// colReorder: true,
	// fixedColumns: true,
	// fixedHeader: {
	// 	header: true
	// },
	
} );

	document.getElementById('id_hcd').style.display = 'none';
	//hide sesi 1
	document.getElementById('quiz1').style.display = 'none';
</script>

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
