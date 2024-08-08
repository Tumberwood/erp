<?php
	/**
     *V2 ini tanpa Python, by Ferry Ibnu 26 April 2024
     */
	
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }

	if (isset($_GET['id_sou'])) {
		$id_isoxxth_upload_filter = $_GET['id_sou'];
	} else {
		$id_isoxxth_upload_filter = 0;	
	}

	if (isset($_GET['id_td'])) {
		$id_isoittd_upload_old = $_GET['id_td'];
	} else {
		$id_isoittd_upload_old = 0;	
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
		overflow: scroll; /* Adds scrollbars for both x and y */
		border: 1px solid #ccc; /* Optional: just to visualize the div */
	}

</style>

<?php
	$nama_tabel    = 'isoxxth';
	$nama_tabels_d = [];
?>


<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmisoittd_upload">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-lg-3 col-md-3">Kode Stock Opname</label>
						<div class="col-lg-8 col-sm-8">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- <div class="row">
    <div class="col">
        <div class="ibox collapsed" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmisoittd_upload">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode Stock Opname</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
						</div>
					</div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <button class="btn btn-primary" type="submit" id="go">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<div class="row" id="konten" style="display: none">
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
					<div class="col-6">
						<button class="btn btn-warning" id="saveBtn">Save</button>
					</div>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoxxth_pointer_v2/fn/isoxxth_pointer_v2_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	
	//Aktivasi Filter Floating
	filterFloating();
	
	var canvas = new fabric.Canvas('c');
	var canvasContainer = $('#canvas-container');
	var mode = '';
	var warna = '#ff0000';
	var circleSize = 1;
	var fungsi = "draw";
	var c_circle = 0;
	var arr_warna = [];
	var id_isoxxth_upload_old = 0;
	var simpanFoto = {};
	var id_isoxxth_upload_filter = <?php echo $id_isoxxth_upload_filter ?>;
	var id_isoittd_upload_old = <?php echo $id_isoittd_upload_old ?>;
	
	var circleHistory = [];
	var redoStack = [];

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

	$("#selectKode").select2({
		placeholder : "Select",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/isoxxth_upload/isoxxth_upload_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_isoxxth_upload_old: id_isoxxth_upload_filter,
					search: params.term || '',
					page: params.page || 1
				}
					return query;
			},
			// processResults: function (data, params) {
			// 	return {
			// 		results: data.results,
			// 		pagination: {
			// 			more: true
			// 		}
			// 	};
			// },
			processResults: function (data, params) {
				if (id_isoxxth_upload_filter > 0) {
					var options = data.results.map(function (result) {
						return {
							id: result.id,
							text: result.text
						};
					});

					//add by ferry agar auto select 07 sep 23
					if (params.page && params.page === 1) {
						$('#selectKode').empty().select2({ data: options });
					} else {
						$('#selectKode').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
					}

					return {
						results: options,
						pagination: {
							more: true
						}
					};
				} else {
					return {
						results: data.results,
						pagination: {
							more: true
						}
					};
				}
			},
			cache: true,
			minimumInputLength: 1,
			maximum: 10,
			delay: 500,
			maximumSelectionLength: 5,
			minimumResultsForSearch: -1,
		}
	});

	$(document).ready(function() {

		$('[data-toggle="tooltip"]').tooltip();
		var selectedOption = $('#selectKode').select2('data')[0];
		if (selectedOption) {
			selectedText = selectedOption.text
		}
		
		$('#selectKode').select2('open');

		setTimeout(function() {
			$('#selectKode').select2('close');
		}, 5);
		console.log(id_isoittd_upload_old);
		if (id_isoittd_upload_old > 0) {
			autofillField('isoittd_upload', id_isoittd_upload_old, 'id_files_pointer');
			id_files_pointer = autofillData.id_files_pointer;
			console.log(id_files_pointer);
			if (id_files_pointer > 0) {
				console.log(111);
				// console.log(id_files_pointer);
				autofillField('files', id_files_pointer, 'web_path');
				web_path = autofillData.web_path;
				// console.log(web_path);
				fetchAndUploadFile(web_path);
				$('#inputfileUpload').prop('disabled', true);
				$('#frmisoittd_upload :input').prop('disabled', true);
			}
		}

		kontenData();
		$('#addCircleBtn').prop('disabled', true);
		$('#moveCircleBtn').prop('disabled', true);
		$('#scrollBtn').prop('disabled', true);
		$('#deleteCircleBtn').prop('disabled', true);
		$('#colorPicker').prop('disabled', true);
		$('#pickColor').prop('disabled', true);
		$('#circleSize').prop('disabled', true);
		$('#analyzeBtn').prop('disabled', true);
		$('#saveBtn').prop('disabled', true);
		$('#zoomInBtn').prop('disabled', true);
		$('#zoomOutBtn').prop('disabled', true);

		$('#colorRed').on( "click", function() {
			warna = '#ff0000';
		} );
		
		//Filter Kode harus dipilih dulu
		$("#frmisoittd_upload").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				
			},
			submitHandler: function(frmisoittd_upload) {
				console.log(id_isoxxth_upload_filter);
				if ($('#selectKode').val() > 0) {
					id_isoxxth_upload_filter  = $('#selectKode').val();
				}
				console.log(id_isoxxth_upload_filter);
				// console.log(id_isoxxth_upload_filter);
				kontenData();
				$('#modalFloatingFilter').modal('toggle');
				//Jika ada filter kode maka akan muncul konten
				
			}
		});
		
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
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
