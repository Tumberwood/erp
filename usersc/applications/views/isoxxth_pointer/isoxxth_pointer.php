<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">

<style>
	canvas {
		cursor: pointer !important; /* Mengubah kursor menjadi pointer */
	}

	#canvas-container {
		width: 100%; /* Ukuran canvas */
		height: 600px;
		overflow: auto; /* Menambahkan scroll jika gambar lebih besar dari canvas */
		border: 1px solid black; /* Garis batas untuk canvas */
		position: relative;
	}

	#c {
		position: absolute;
	}

	.bg-red{
		background-color: red;
	}

	.bg-yellow{
		background-color: yellow;
	}

	.bg-green{
		background-color: green;
	}

	.bg-blue{
		background-color: blue;
	}

	.bg-pink{
		background-color: pink;
	}

</style>

<?php
	$nama_tabel    = 'isoxxth';
	$nama_tabels_d = [];
?>

<div class="row">
	<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
		<div class="ibox">
			<div class="ibox-content float-e-margins">
				<form id="frmUpload" enctype="multipart/form-data">
					<div class="form-group row">
						<div class="input-group">
							<input type="file" placeholder="Select File" id="inputfileUpload" name="inputfileUpload" class="form-control" accept="image/*">
						</div>
						<span class="form-text text-info">Format file harus berupa png, jpg, jpeg, atau foto langsung dari kamera</span>
					</div>
				</form>
				<hr/>
				<h3>Action</h3>
				<p>
					<button class="btn btn-info" id="addCircleBtn">Add</button><br/>
					<button class="btn btn-danger" id="deleteCircleBtn">Delete</button><br/>
					<button class="btn btn-warning" id="moveCircleBtn">Move</button><br/>
				</p>

				<h3>Color</h3>
				<p>
					<button class="btn bg-red btn-circle" id="colorRed" type="button"></button>
					<button class="btn bg-yellow btn-circle" id="colorYellow" type="button"></button>
					<button class="btn bg-green btn-circle" id="colorGreen" type="button"></button>
					<button class="btn bg-blue btn-circle" id="colorBlue" type="button"></button>
					<!-- <button class="btn bg-pink btn-circle" id="colorPink" type="button"></button> -->
					<input id="circleSize"/>
				</p>

				<hr/>
				<button class="btn btn-primary" id="analyzeBtn">Analisa</button>
				
			</div>
		</div>
	</div>	
	<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
		<div class="ibox">
			<div class="ibox-content">
				<div id="canvas-container">
					<canvas id="c" width="800" height="600"></canvas>
				</div>
				<br/>
				<div id="hasil"></div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.2.0/fabric.min.js"></script>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoxxth_pointer/fn/isoxxth_pointer_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	var canvas = new fabric.Canvas('c');
	var canvasContainer = $('#canvas-container');
	var mode = 'add';
	var warna = 'red';
	var circleSize = 1;
	var fungsi = "draw";

	$(document).ready(function() {

		$("#inputfileUpload").change(function(e) {
			e.preventDefault();

			var file = $('#inputfileUpload')[0].files[0];				
			var reader = new FileReader();
			reader.onload = function (event) {
				replaceCanvasImage(event.target.result);
			};
			reader.readAsDataURL(file);

			return false; 
		});

		$("#circleSize").ionRangeSlider({
            skin: "round",
            min: 0,
            max: 10,
			from: 1,
            type: 'single',
            step: 1,
			onChange: function (data) {
				circleSize = data.from;
			},
        });

		$('#addCircleBtn').on( "click", function() {
			mode = 'add';
		} );

		$('#deleteCircleBtn').on( "click", function() {
			mode = 'delete';
		} );

		$('#moveCircleBtn').on( "click", function() {
			mode = 'move';
		} );
		
		$('#colorRed').on( "click", function() {
			warna = 'red';
		} );

		$('#colorYellow').on( "click", function() {
			warna = 'yellow';
		} );

		$('#colorGreen').on( "click", function() {
			warna = 'green';
		} );
		
		$('#colorBlue').on( "click", function() {
			warna = 'blue';
		} );

		$('#colorPink').on( "click", function() {
			warna = 'pink';
		} );

		canvas.on('mouse:down', function(options) {
			if(mode == 'add'){
				var pointer = canvas.getPointer(options.e);
				// console.log('Canvas clicked at: ', pointer.x, pointer.y);
				addCircle(pointer.x, pointer.y);
			}else if(mode == 'delete'){
				canvas.remove(canvas.getActiveObject())
				
			}else if(mode == 'move'){
				canvas.isDrawingMode = false;
				canvas.selection = true;
			}

        });
		
		$('#analyzeBtn').on( "click", function() {
			toastr.info("Processing ...\nJangan tutup halaman sampai notifikasi ini hilang!", "INFO");
			hitungWarna(Date.now());
			
		} );
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
