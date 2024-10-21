<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrctstd_kostik';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- start Custom Form Datatables Editor -->
				<div id="form_hrctstd_kostik">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<editor-field name="hrctstd_kostik.N"></editor-field>
								<editor-field name="hrctstd_kostik.G"></editor-field>
								<editor-field name="hrctstd_kostik.A"></editor-field>
								<editor-field name="hrctstd_kostik.L"></editor-field>
								<editor-field name="hrctstd_kostik.P"></editor-field>
								<editor-field name="hrctstd_kostik.I"></editor-field>
								<editor-field name="hrctstd_kostik.T"></editor-field>
								<editor-field name="hrctstd_kostik.V"></editor-field>
							</div>
							<div class="col-md-6">
								<editor-field name="hrctstd_kostik.X"></editor-field>
								<editor-field name="hrctstd_kostik.S"></editor-field>
								<editor-field name="hrctstd_kostik.B"></editor-field>
								<editor-field name="hrctstd_kostik.O"></editor-field>
								<editor-field name="hrctstd_kostik.R"></editor-field>
								<editor-field name="hrctstd_kostik.D"></editor-field>
								<editor-field name="hrctstd_kostik.C"></editor-field>
								<editor-field name="hrctstd_kostik.Z"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<div class="table-responsive">
                    <table id="tblhrctstd_kostik" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th rowspan="2">ID</th>
								<th rowspan="2">Kode Tes</th>
								<th rowspan="2">Nama</th>
								<th rowspan="2">Tanggal</th>
								<th class="text-center" colspan="7">Hasil</th>
							</tr>
                            <tr>
                                <th>WORK DIRECTION</th>
                                <th>LEADERSHIP</th>
                                <th>ACTIVITY</th>
                                <th>SOCIAL NATURE</th>
                                <th>WORK STYLE</th>
                                <th>TEMPERAMENT</th>
                                <th>FOLLOWERSHIP</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="detail_hasil" style="display: none">
	<div class="ibox ">
		<div class="ibox-content">
			<!-- <div class="row">
				<div class="col-md-6 col-12"> -->
					<div id="chartHasilKostik"></div>
				<!-- </div>
				<div class="col-md-6 col-12"> -->
					<iframe id="tabelKostik" width="100%" height="600px" style="border: none;" scrolling="yes" onload="resizeIframe(this)"></iframe>
				<!-- </div> -->
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

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<!-- load highcharts -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/highcharts.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/drilldown.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/highcharts-more.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/exporting.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/highcharts/no-data-to-display.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctstd_kostik/fn/hrctstd_kostik_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthrctstd_kostik, tblhrctstd_kostik, show_deleted_hrctstd_kostik = 0, id_hrctstd_kostik;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hrctstd_kostik');

	$(document).ready(function() {
		// BEGIN hrctstd_kostik
		edthrctstd_kostik = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrctstd_kostik/hrctstd_kostik.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd_kostik = show_deleted_hrctstd_kostik;
				}
			},
			table: "#tblhrctstd_kostik",
			fields: [ 
				{
					label: "hrctstd_kostik.start_at",
					name: "hrctstd_kostik.start_at",
					type: "hidden"
				},	
				{
					label: "hrctstd_kostik.finish_at",
					name: "hrctstd_kostik.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrctstd_kostik",
					type: "hidden"
				},	
				{
					label: "hrctstd_kostik.transaction_state",
					name: "hrctstd_kostik.transaction_state",
					type: "hidden",
					def: 0
				}, {
					label: "N",
					name: "hrctstd_kostik.N"
				}, {
					label: "G",
					name: "hrctstd_kostik.G"
				}, {
					label: "A",
					name: "hrctstd_kostik.A"
				}, {
					label: "L",
					name: "hrctstd_kostik.L"
				}, {
					label: "P",
					name: "hrctstd_kostik.P"
				}, {
					label: "I",
					name: "hrctstd_kostik.I"
				}, {
					label: "T",
					name: "hrctstd_kostik.T"
				}, {
					label: "V",
					name: "hrctstd_kostik.V"
				}, {
					label: "X",
					name: "hrctstd_kostik.X"
				}, {
					label: "S",
					name: "hrctstd_kostik.S"
				}, {
					label: "B",
					name: "hrctstd_kostik.B"
				}, {
					label: "O",
					name: "hrctstd_kostik.O"
				}, {
					label: "R",
					name: "hrctstd_kostik.R"
				}, {
					label: "D",
					name: "hrctstd_kostik.D"
				}, {
					label: "C",
					name: "hrctstd_kostik.C"
				}, {
					label: "Z",
					name: "hrctstd_kostik.Z"
				}
			]
		} );

		edthrctstd_kostik.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd_kostik.field('hrctstd_kostik.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrctstd_kostik.rows().deselect();
				edthrctstd_kostik.field('hrctstd_kostik.kode').enable();
				edthrctstd_kostik.field('hrctstd_kostik.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthrctstd_kostik.field('hrctstd_kostik.kode').enable();
					edthrctstd_kostik.field('hrctstd_kostik.nama').enable();
				}else{
					edthrctstd_kostik.field('hrctstd_kostik.kode').disable();
					edthrctstd_kostik.field('hrctstd_kostik.nama').disable();
				}
			}
		});

		edthrctstd_kostik.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});
		
		edthrctstd_kostik.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd_kostik.field('hrctstd_kostik.finish_at').val(finish_at);
		});

		edthrctstd_kostik.on( 'close', function () {
			edthrctstd_kostik.enable();
		} );

		tblhrctstd_kostik = $('#tblhrctstd_kostik').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrctstd_kostik/hrctstd_kostik.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd_kostik = show_deleted_hrctstd_kostik;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "hrctstd_kostik.id",visible:false },
				{ data: "hrctsth_kostik.kode" },
				{ data: "hcdxxmh.nama" },
				{ data: "hrctsth_kostik.tanggal"},
				{ 
					data: "hrctstd_kostik.work_direction",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.work_direction) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.work_direction;
						} else if (parseFloat(row.hrctstd_kostik.work_direction) >= 2.5 && parseFloat(row.hrctstd_kostik.work_direction) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.work_direction;
						} else if (parseFloat(row.hrctstd_kostik.work_direction) >= 4 && parseFloat(row.hrctstd_kostik.work_direction) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.work_direction;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.work_direction;
						}
					},
					class: "text-right"
				},

				{ data: "hrctstd_kostik.leadership",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.leadership) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.leadership;
						} else if (parseFloat(row.hrctstd_kostik.leadership) >= 2.5 && parseFloat(row.hrctstd_kostik.leadership) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.leadership;
						} else if (parseFloat(row.hrctstd_kostik.leadership) >= 4 && parseFloat(row.hrctstd_kostik.leadership) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.leadership;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.leadership;
						}
					},
					class: "text-right" 
				},
				{ data: "hrctstd_kostik.activiti",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.activiti) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.activiti;
						} else if (parseFloat(row.hrctstd_kostik.activiti) >= 2.5 && parseFloat(row.hrctstd_kostik.activiti) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.activiti;
						} else if (parseFloat(row.hrctstd_kostik.activiti) >= 4 && parseFloat(row.hrctstd_kostik.activiti) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.activiti;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.activiti;
						}
					},
					class: "text-right" 
				},
				{ data: "hrctstd_kostik.social_nature",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.social_nature) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.social_nature;
						} else if (parseFloat(row.hrctstd_kostik.social_nature) >= 2.5 && parseFloat(row.hrctstd_kostik.social_nature) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.social_nature;
						} else if (parseFloat(row.hrctstd_kostik.social_nature) >= 4 && parseFloat(row.hrctstd_kostik.social_nature) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.social_nature;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.social_nature;
						}
					},
					class: "text-right" 
				},
				{ data: "hrctstd_kostik.work_style",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.work_style) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.work_style;
						} else if (parseFloat(row.hrctstd_kostik.work_style) >= 2.5 && parseFloat(row.hrctstd_kostik.work_style) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.work_style;
						} else if (parseFloat(row.hrctstd_kostik.work_style) >= 4 && parseFloat(row.hrctstd_kostik.work_style) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.work_style;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.work_style;
						}
					},
					class: "text-right" 
				},
				{ data: "hrctstd_kostik.temprament",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.temprament) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.temprament;
						} else if (parseFloat(row.hrctstd_kostik.temprament) >= 2.5 && parseFloat(row.hrctstd_kostik.temprament) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.temprament;
						} else if (parseFloat(row.hrctstd_kostik.temprament) >= 4 && parseFloat(row.hrctstd_kostik.temprament) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.temprament;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.temprament;
						}
					},
					class: "text-right" 
				},
				{ data: "hrctstd_kostik.follower",
					render: function (data, type, row) {
						if (parseFloat(row.hrctstd_kostik.follower) < 2.5) {
							return '<i class="fa fa-arrow-down text-danger"></i> ' + row.hrctstd_kostik.follower;
						} else if (parseFloat(row.hrctstd_kostik.follower) >= 2.5 && parseFloat(row.hrctstd_kostik.follower) < 4) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' + row.hrctstd_kostik.follower;
						} else if (parseFloat(row.hrctstd_kostik.follower) >= 4 && parseFloat(row.hrctstd_kostik.follower) < 5.5) {
							return '<i class="fa fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' + row.hrctstd_kostik.follower;
						} else {
							return '<i class="fa fa-arrow-up text-navy" ></i> ' + row.hrctstd_kostik.follower;
						}
					},
					class: "text-right"  
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrctstd_kostik';
					$table       = 'tblhrctstd_kostik';
					$edt         = 'edthrctstd_kostik';
					$show_status = '_hrctstd_kostik';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['view'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hrctstd_kostik.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrctstd_kostik.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrctstd_kostik.searchPanes.container().appendTo('#sphrctstd_kostik');
		tblhrctstd_kostik.searchBuilder.container().appendTo( '#sbhrctstd_kostik' );
		
		tblhrctstd_kostik.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhrctstd_kostik);
		} );
		
		tblhrctstd_kostik.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrctstd_kostik');
			hasil_line1      = hrctstd_kostik_data.hasil_line1;
			hasil_line2      = hrctstd_kostik_data.hasil_line2;
			hasil_line3      = hrctstd_kostik_data.hasil_line3;

			// atur hak akses
			CekSelectHeaderH(tblhrctstd_kostik);
			$('#detail_hasil').show();
			chartHasilKostik();
		} );

		tblhrctstd_kostik.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrctstd_kostik');
			hasil_line1 = 0;
			hasil_line2 = 0;
			hasil_line3 = 0;
			
			$('#detail_hasil').hide();

			// atur hak akses
			CekDeselectHeaderH(tblhrctstd_kostik);
		} );

		// END hrctstd_kostik
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
