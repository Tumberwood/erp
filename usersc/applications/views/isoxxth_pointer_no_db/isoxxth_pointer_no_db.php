<?php
	/**
     *V2 ini tanpa Python, by Ferry Ibnu 26 April 2024
     */
	
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
		border: 1px solid #000000; /* Garis batas untuk canvas */
		position: relative;
	}

	#c {
		position: absolute;
	}

	#hasil {
		overflow: scroll; 
		border: 1px solid #ccc; 
	}
</style>

<?php
	$nama_tabel    = 'isoxxth';
	$nama_tabels_d = [];
?>

<!-- <div class="row" id="konten" style="display: none"> -->
<div class="row" id="konten">
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
					<button class="btn btn-info" id="addCircleBtn" title="Add Circle" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
					<button class="btn btn-warning" id="moveCircleBtn" title="Move Circle" data-toggle="tooltip"><i class="fa fa-arrows"></i></button>
					<button class="btn btn-danger" id="deleteCircleBtn" title="Delete Circle" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
					<button class="btn btn-outline" id="scrollBtn" title="Scroll" data-toggle="tooltip"><i class="fa fa-mouse-pointer"></i></button>
					<button class="btn btn-outline" id="zoomInBtn" title="Zoom In" data-toggle="tooltip"><i class="fa fa-search-plus"></i></button>
					<button class="btn btn-outline" id="zoomOutBtn" title="Zoom Out" data-toggle="tooltip"><i class="fa fa-search-minus"></i></button>
				</p>

				<h3>Color</h3>
				<p>
					<input type="color" id="colorPicker" value="#ff0000">
					<button class="btn btn-sm btn-primary" id="pickColor"><i class="fa fa-check"></i></button>
					<div id="btnWarna"></div>
				</p>

				<br>
				<input id="circleSize"/>

				<hr/>

				<div class="row">
					<div class="col-6">
						<button class="btn btn-primary" id="analyzeBtn">Analisa</button>
					</div>
					<!-- <div class="col-6">
						<button class="btn btn-warning" id="saveBtn">Save</button>
					</div> -->
				</div>
				
			</div>
		</div>
	</div>	
	<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
		<div class="ibox">
			<div class="ibox-content">
				<div id="hitung"></div>
				<div id="canvas-container">
					<canvas id="c" width="800" height="600"></canvas>
				</div>
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
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/fabric/fabric.min.js"></script>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoxxth_pointer_no_db/fn/isoxxth_pointer_no_db_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	var canvas = new fabric.Canvas('c');
	var canvasContainer = $('#canvas-container');
	var mode = '';
	var warna = '#ff0000';
	var circleSize = 1;
	var fungsi = "draw";
	var c_circle = 0;
	var arr_warna = [];
	var id_isoxxth_upload_old = 0;
	var id_isoittd_upload_old = 0;
	var simpanFoto = {};
	var id_isoxxth_upload_filter = 0;

	const colorPicker = document.getElementById('colorPicker');
	const pickColorButton = document.getElementById('pickColor');
	const btnWarna = document.getElementById('btnWarna'); // Menyimpan referensi ke elemen dengan id 'btnWarna'
	
	var btnMerah = document.createElement('button'); // Membuat elemen tombol
	btnWarna.innerHTML = '<button class="btn btn-circle" id="colorRed" type="button" style="background-color: red;"></button>';

	pickColorButton.addEventListener('click', () => {
		var selectedColor = colorPicker.value;
		
		warna = selectedColor;

		// cek apakah sudah ada warna merah, jika sudah maka tidak perlu push, ini untuk def value
		if (!arr_warna.includes('#ff0000')) {
			arr_warna.push('#ff0000');
		}
		 // Cek apakah warna yang dipilih sudah ada di dalam array arr_warna
		 if (!arr_warna.includes(selectedColor)) {
			// Jika warna tidak ada di dalam array, tambahkan ke dalam array
			arr_warna.push(selectedColor);
		}

		// Kosongkan konten sebelum menambahkan tombol warna baru
		btnWarna.innerHTML = '';
		
		// Gunakan forEach untuk menambahkan tombol warna untuk setiap warna dalam array arr_warna
		arr_warna.forEach(s_warna => {
			// Buat elemen tombol warna baru
			const btn = document.createElement('button');
			btn.classList.add('btn', 'btn-circle', 'mr-1');
			btn.style.backgroundColor = s_warna;
			btn.type = 'button';

			// Tambahkan event listener untuk setiap tombol warna
			btn.addEventListener('click', () => {
				// Ketika tombol warna diklik, ubah variabel warna menjadi warna yang sesuai
				warna = s_warna;
				colorPicker.value = warna;
			});

			// Tambahkan tombol warna ke dalam elemen dengan id 'btnWarna'
			btnWarna.appendChild(btn);

		});

	});

	$(document).ready(function() {
		$("#circleSize").ionRangeSlider({
			skin: "round",
			min: 0,
			max: 10,
			from: 1,
			type: 'single',
			step: 0.1,
			onChange: function (data) {
				circleSize = data.from;
			},
		});

		$('#colorRed').on( "click", function() {
			warna = '#ff0000';
		} );
		
		//ketika sudah dipilih filenya
		$("#inputfileUpload").change(function(e) {
			e.preventDefault();
			console.log(1);

			$('#hitung').empty();
			$('#hasil').empty(); // Clear any previous images
			canvas.clear();
			
			var fileInput = $('#inputfileUpload')[0];
			if (fileInput.files.length > 0) {
				var file =  fileInput.files[fileInput.files.length - 1];
				
				var maxWidth, maxHeight;
				
				if (window.innerWidth <= 800) { // Check if the screen width is 800 pixels or less
					maxWidth = 1200;  // Maximum width for mobile
					maxHeight = 1000; // Maximum height for mobile
				} else {
					maxWidth = 1800; // Maximum width for desktop
					maxHeight = 1600; // Maximum height for desktop
				}
				var quality = 0.8; // Kualitas gambar (0-1)

				resizeImage(file, maxWidth, maxHeight, quality)
				.then(function(resizedImageBlob) {
					var reader = new FileReader();
					reader.onload = function (event) {
						// console.log(file.name);
						target_bg = event.target.result
						// console.log(event);
						// console.log(event.target);
						replaceCanvasImage(target_bg);
						canvas.setZoom(1); // Atur zoom ke nilai default (misalnya 1)
						canvas.absolutePan({ x: 0, y: 0 });

						// Aktifkan elemen-elemen setelah file terpilih
						// $('#addCircleBtn').prop('disabled', false);
						// $('#moveCircleBtn').prop('disabled', false);
						// $('#deleteCircleBtn').prop('disabled', false);
						// $('#colorPicker').prop('disabled', false);
						// $('#pickColor').prop('disabled', false);
						// $('#circleSize').prop('disabled', false);
						// $('#analyzeBtn').prop('disabled', false);
						
						$('#addCircleBtn').on( "click", function() {
							mode = 'add';
						} );

						$('#deleteCircleBtn').on( "click", function() {
							mode = 'delete';
						} );

						$('#moveCircleBtn').on( "click", function() {
							mode = 'move';
						} );

						$('#scrollBtn').on( "click", function() {
							mode = '';
						} );

						$('#zoomInBtn').on( "click", function() {
							mode = 'zoomIn';
						} );

						$('#zoomOutBtn').on( "click", function() {
							mode = 'zoomOut';
						} );

						canvas.on('mouse:wheel', function(event) {
							zoomCanvas(event.e);
						});

						var isDragging = false;
						var lastPosX, lastPosY;
						
						canvas.on('mouse:down', function(options) {
							if (mode == 'add') {
								var pointer = canvas.getPointer(options.e);
								addCircle(pointer.x, pointer.y);
							} else if (mode == 'delete') {
								var target = canvas.findTarget(options.e);
								if (target && target.type === 'circle') {
									removeCircle(target);
								}
							} else if (mode == 'move') {
								canvas.isDrawingMode = false;
								canvas.selection = true;
							} else if (mode == 'zoomIn') {
								var pointer = canvas.getPointer(options.e);
								zoomMobile(-50, pointer.x, pointer.y); // Zoom in
							} else if (mode == 'zoomOut') {
								var pointer = canvas.getPointer(options.e);
								zoomMobile(50, pointer.x, pointer.y); // Zoom out
							} else {
								// Handle panning
								isDragging = true;
								var pointer = canvas.getPointer(options.e);
								lastPosX = pointer.x;
								lastPosY = pointer.y;
							}
						});

						// Mouse move event
						canvas.on('mouse:move', function(event) {
							if (isDragging) {
								var pointer = canvas.getPointer(event.e);
								var deltaX = pointer.x - lastPosX;
								var deltaY = pointer.y - lastPosY;
								canvas.relativePan({ x: deltaX, y: deltaY });
							}
						});

						// Mouse up event
						canvas.on('mouse:up', function() {
							isDragging = false;
						});

						$('#analyzeBtn').on("click", function() {
							toastr.info("Processing ...\nJangan tutup halaman sampai notifikasi ini hilang!", "INFO");

							// Ensure hitungWarna is called only once
							if (!hitungWarna.isRunning) {
								hitungWarna.isRunning = true; // Set flag to indicate that hitungWarna is running

								hitungWarna(target_bg, function(result) {
									// Assign result to simpanFoto
									simpanFoto = result;

									canvas.absolutePan({ x: 0, y: 0 });
									canvas.setZoom(1);
									// console.log(simpanFoto);

									hitungWarna.isRunning = false; // Reset the flag when hitungWarna is done
								});
							}
						});

					};

					reader.readAsDataURL(resizedImageBlob);
				})
				.catch(function(error) {
					console.error('Error resizing image:', error);
				});
				// reader.readAsDataURL(file);
			}
			return false; 
		});
		return false; 
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
