<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wms_3d_visual';
	$nama_tabels_d = [];
?>
<style>

    #threejs-container {
      position: relative;
      height: 600px;
      border: 1px solid #ddd;
      background-color: #f0f0f0;
      cursor: grab;
      overflow: hidden;
    }
    #threejs-container:active {
      cursor: grabbing;
    }

    canvas {
      display: block;
      width: 100% !important;
      height: 100% !important;
      /* supaya canvas mengikuti container */
    }

    #tooltip_3d {
      position: absolute;
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      pointer-events: none;
      font-family: sans-serif;
      font-size: 12px;
      display: none;
      z-index: 10;
      user-select: none;
      white-space: nowrap;
    }
  </style>
<!-- begin content here -->

<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmFilter">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Periode</label>
						<div class="input-group input-daterange" id="periode">
							<input type="text" id="start_date" name="start_date" class="form-control">
							<div class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</div>
							<input type="text" id="end_date" name="end_date" class="form-control">
						</div>
					</div>
					<div class="form-group row">												
						<div class="col-sm-6">
							<select class="form-control" id="select_id_iwhxxmh" name="select_id_iwhxxmh"></select>
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

<div class="row">
  <div class="col-12">
    <div class="ibox">
      <div class="ibox-content">
        <!-- Container untuk Three.js -->
        <div id="threejs-container"></div>
		<div id="tooltip_3d"></div>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FontLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/geometries/TextGeometry.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>


<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_highcharts_load.php';
?>



<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wms_3d_visual/fn/wms_3d_visual_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// get tableRelation
	// tableRelation('_blank');
	//Aktivasi Filter Floating
	filterFloating();

	var id_iwhxxmh, id_iwhxxmh_old = 0;

	$("#select_id_iwhxxmh").select2({
		placeholder : "Warehouse",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_iwhxxmh_old: id_iwhxxmh_old,
					search: params.term || '',
					page: params.page || 1
				}
					return query;
			},
			processResults: function (data, params) {
				return {
					results: data.results,
					pagination: {
						more: true
					}
				};
			},
			cache: true,
			minimumInputLength: 1,
			maximum: 10,
			delay: 500,
			maximumSelectionLength: 5,
			minimumResultsForSearch: -1,
		},
	});

	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);

	function reload_dashboard_data(){
		id_iwhxxmh = $('#select_id_iwhxxmh').val();
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date   = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		location_3d(end_date, id_iwhxxmh);
	}

	reload_dashboard_data();
	$(document).ready(function() {
		id_iwhxxmh = $('#select_id_iwhxxmh').val();
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			
		// autoReloadInterval(function () {
		// 	var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
		// 	reload_dashboard_data();
		// });

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true
				},
				end_date: {
					required: true
				},
				select_id_iwhxxmh: {
					required: true
				}
			},
			messages: {
				start_date: {
					required: "Tanggal awal wajib diisi!"
				},
				end_date: {
					required: "Tanggal akhir wajib diisi!"
				},
				select_id_iwhxxmh: {
					required: "Warehouse wajib diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				id_iwhxxmh  = $('#select_id_iwhxxmh').val();

				if (id_iwhxxmh > 0) {
					reload_dashboard_data();
					$('#modalFloatingFilter').modal('toggle');
				}
			}
		});
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
