<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wloxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div id="frmwloxxmh">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.id_iwhxxmh"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.id_wloctmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.id_wlotpmh"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.id_wloznmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.kapasitas"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.id_iumxxmh_kapasitas"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.rack_name"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.bay_name"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.level_name"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.position_name"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wloxxmh.keterangan"></editor-field>
							</div>
							<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<img src="../../../files/uploads/racking.jpg">
							</div> -->
						</div>
					</div>
				</div>
				<div id="frmwloxxmh_generate">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="id_iwhxxmh"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="id_wloctmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="id_wlotpmh"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="id_wloznmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="kapasitas"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="id_iumxxmh_kapasitas"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="rack_name"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="bay_name"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="level_name"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="position_name"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblwloxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Warehouse</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Zone</th>
                                <th>Rack</th>
                                <th>Bay</th>
                                <th>Level</th>
                                <th>Position</th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wloxxmh/fn/wloxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwloxxmh, tblwloxxmh, show_deleted_wloxxmh = 0, id_wloxxmh;
	// ------------- end of default variable

	var id_iwhxxmh_old = 0, id_wloctmh_old = 0, id_wlotpmh_old = 0, id_wloznmh_old = 0, id_iumxxmh_kapasitas_old = 0;

	var id_wlotpmh, wloxxmh_kode, rack_name, bay_name, level_name, position_name;

	// get tableRelation
	tableRelation('wloxxmh');
	
	$(document).ready(function() {
		// BGIN wloxxmh
		edtwloxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wloxxmh/wloxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wloxxmh = show_deleted_wloxxmh;
				}
			},
			template: "#frmwloxxmh",
			table: "#tblwloxxmh",
			fields: [ 
				{
					label: "wloxxmh.start_at",
					name: "wloxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wloxxmh.finish_at",
					name: "wloxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wloxxmh",
					type: "hidden"
				},	
				{
					label: "wloxxmh.transaction_state",
					name: "wloxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Warehouse<sup class='text-danger'>*<sup>",
					name: "wloxxmh.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
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
					}
				},
				{
					label: "Location Category",
					name: "wloxxmh.id_wloctmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloctmh/wloctmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloctmh_old: id_wloctmh_old,
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
					}
				},
				{
					label: "Location Type",
					name: "wloxxmh.id_wlotpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wlotpmh/wlotpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wlotpmh_old: id_wlotpmh_old,
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
					}
				},
				{
					label: "Location Zone",
					name: "wloxxmh.id_wloznmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloznmh/wloznmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloznmh_old: id_wloznmh_old,
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
					}
				},
				{
					label: "Kapasitas <sup class='text-danger'>*<sup>",
					name: "wloxxmh.kapasitas"
				},
				{
					label: "UoM Kapasitas <sup class='text-danger'>*<sup>",
					name: "wloxxmh.id_iumxxmh_kapasitas",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_kapasitas_old,
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
					}
				},
				{
					label: "Rack / Block",
					name: "wloxxmh.rack_name",
					fieldInfo: "Gunakan Huruf atau Angka, misal A atau AA atau 01"
				},
				{
					label: "Bay",
					name: "wloxxmh.bay_name",
					fieldInfo: "Gunakan Huruf atau Angka, misal A atau AA atau 01"
				},
				{
					label: "Level",
					name: "wloxxmh.level_name",
					fieldInfo: "Gunakan Huruf atau Angka, misal A atau AA atau 01"
				},
				{
					label: "Position",
					name: "wloxxmh.position_name",
					fieldInfo: "Gunakan Huruf atau Angka, misal A atau AA atau 01"
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "wloxxmh.nama",
					type: "readonly"
				},
				{
					label: "Keterangan",
					name: "wloxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwloxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwloxxmh.field('wloxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwloxxmh.rows().deselect();

				edtwloxxmh.field('wloxxmh.nama').enable();
				edtwloxxmh.field('wloxxmh.id_iwhxxmh').enable();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwloxxmh.field('wloxxmh.nama').enable();
					edtwloxxmh.field('wloxxmh.id_iwhxxmh').enable();
				}else{
					edtwloxxmh.field('wloxxmh.nama').disable();
					edtwloxxmh.field('wloxxmh.id_iwhxxmh').disable();
				}

				autofillField('iwhxxmh', id_iwhxxmh, 'kode');
				iwhxxmh_kode = autofillData.kode;
				wloxxmh_generate_nama();

			}
		});

		edtwloxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwloxxmh.dependent( 'wloxxmh.id_iwhxxmh', function ( val, data, callback ) {
			id_iwhxxmh = val;
			autofillField('iwhxxmh', id_iwhxxmh, 'kode');
			iwhxxmh_kode = autofillData.kode;
			wloxxmh_generate_nama();
			return {}
		}, {event: 'keyup change'});

		edtwloxxmh.dependent( 'wloxxmh.rack_name', function ( val, data, callback ) {
			rack_name = val;
			wloxxmh_generate_nama();
			return {}
		}, {event: 'keyup change'});

		edtwloxxmh.dependent( 'wloxxmh.bay_name', function ( val, data, callback ) {
			bay_name = val;
			wloxxmh_generate_nama();
			return {}
		}, {event: 'keyup change'});

		edtwloxxmh.dependent( 'wloxxmh.level_name', function ( val, data, callback ) {
			level_name = val;
			wloxxmh_generate_nama();
			return {}
		}, {event: 'keyup change'});

		edtwloxxmh.dependent( 'wloxxmh.position_name', function ( val, data, callback ) {
			position_name = val;
			wloxxmh_generate_nama();
			return {}
		}, {event: 'keyup change'});

		edtwloxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_iwhxxmh           = edtwloxxmh.field('wloxxmh.id_iwhxxmh').val();
				nama                 = edtwloxxmh.field('wloxxmh.nama').val();
				kapasitas            = edtwloxxmh.field('wloxxmh.kapasitas').val();
				id_iumxxmh_kapasitas = edtwloxxmh.field('wloxxmh.id_iumxxmh_kapasitas').val();
				rack_name            = edtwloxxmh.field('wloxxmh.rack_name').val();
				bay_name             = edtwloxxmh.field('wloxxmh.bay_name').val();

				validasiRequired(
					edtwloxxmh,
					'wloxxmh',
					{
						'id_iwhxxmh': id_iwhxxmh,
						'id_iumxxmh_kapasitas': id_iumxxmh_kapasitas,
						'rack_name': rack_name
					}
				);

				/**
				 * ini harusnya ada kondisi OR
				 * perlu bikin custom validation unique, tidak bisa menggunakan validasiUnique
				 * yang tidak boleh kembar adalah kombinasi :
				 * 	kode, nama, warehouse
				 * 	kode dan warehouse, atau nama dan warehouse
				 */
				validasiUnique(
					action,
					edtwloxxmh,
					'wloxxmh',
					'nama',
					'nama,id_iwhxxmh',
					'"'+nama+'",'+id_iwhxxmh,
					id_wloxxmh
				);

				validasiNumber(
					edtwloxxmh,
					'wloxxmh',
					{
						'kapasitas': kapasitas,
					},
					0,
					'>='
				);

			}
			
			if ( edtwloxxmh.inError() ) {
				return false;
			}
		});
		
		edtwloxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwloxxmh.field('wloxxmh.finish_at').val(finish_at);
		});

		edtwloxxmh.on( 'close', function () {
			edtwloxxmh.enable();
		} );

		edtwloxxmh_generate = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wloxxmh/wloxxmh_fn_generate.php",
				type: 'POST',
				data: function (d){
					
				}
			},
			template: "#frmwloxxmh_generate",
			table: "#tblwloxxmh",
			fields: [ 
				{
					label: "start_at",
					name: "start_at",
					type: "hidden"
				},	
				{
					label: "finish_at",
					name: "finish_at",
					type: "hidden"
				},	
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
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
					}
				},
				{
					label: "Location Category <sup class='text-danger'>*<sup>",
					name: "id_wloctmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloctmh/wloctmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloctmh_old: id_wloctmh_old,
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
					}
				},
				{
					label: "Location Type <sup class='text-danger'>*<sup>",
					name: "id_wlotpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wlotpmh/wlotpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wlotpmh_old: id_wlotpmh_old,
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
					}
				},
				{
					label: "Location Zone",
					name: "id_wloznmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloznmh/wloznmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloznmh_old: id_wloznmh_old,
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
					}
				},
				{
					label: "Kapasitas <sup class='text-danger'>*<sup>",
					name: "kapasitas"
				},
				{
					label: "UoM Kapasitas <sup class='text-danger'>*<sup>",
					name: "id_iumxxmh_kapasitas",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_kapasitas_old,
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
					}
				},
				{
					label: "Rack / Block <sup class='text-danger'>*<sup>",
					name: "rack_name",
					fieldInfo: "Gunakan Huruf atau Angka. Jika lebih dari satu, pisahkan dengan koma (,) Misal A atau AA, A , 01"
				},
				{
					label: "Bay <sup class='text-danger'>*<sup>",
					name: "bay_name",
					fieldInfo: "Gunakan Huruf atau Angka. Jika lebih dari satu, pisahkan dengan koma (,) Misal 01-21 atau 01,03,05"
				},
				{
					label: "Level <sup class='text-danger'>*<sup>",
					name: "level_name",
					fieldInfo: "Gunakan Huruf atau Angka. Jika lebih dari satu, pisahkan dengan koma (,) Misal 01-04 atau 01,03"
				},
				{
					label: "Position <sup class='text-danger'>*<sup>",
					name: "position_name",
					fieldInfo: "Gunakan Huruf atau Angka. Jika lebih dari satu, pisahkan dengan koma (,) Misal L,R"
				}
			]
		} );

		edtwloxxmh_generate.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwloxxmh_generate.field('start_at').val(start_at);
		} );

		edtwloxxmh_generate.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		
		});

		edtwloxxmh_generate.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_iwhxxmh           = edtwloxxmh_generate.field('id_iwhxxmh').val();
				id_wloctmh           = edtwloxxmh_generate.field('id_wloctmh').val();
				id_wlotpmh           = edtwloxxmh_generate.field('id_wlotpmh').val();
				kapasitas            = edtwloxxmh_generate.field('kapasitas').val();
				id_iumxxmh_kapasitas = edtwloxxmh_generate.field('id_iumxxmh_kapasitas').val();
				rack_name            = edtwloxxmh_generate.field('rack_name').val();
				bay_name             = edtwloxxmh_generate.field('bay_name').val();
				level_name           = edtwloxxmh_generate.field('level_name').val();
				position_name        = edtwloxxmh_generate.field('position_name').val();

				if(!id_iwhxxmh || id_iwhxxmh == ''){
					edtwloxxmh_generate.field('id_iwhxxmh').error( 'Wajib diisi!' );
				}
				if(!id_wloctmh || id_wloctmh == ''){
					edtwloxxmh_generate.field('id_wloctmh').error( 'Wajib diisi!' );
				}
				if(!id_wlotpmh || id_wlotpmh == ''){
					edtwloxxmh_generate.field('id_wlotpmh').error( 'Wajib diisi!' );
				}
				if(!kapasitas || kapasitas == ''){
					edtwloxxmh_generate.field('kapasitas').error( 'Wajib diisi!' );
				}
				if(!id_iumxxmh_kapasitas || id_iumxxmh_kapasitas == ''){
					edtwloxxmh_generate.field('id_iumxxmh_kapasitas').error( 'Wajib diisi!' );
				}
				if(!rack_name || rack_name == ''){
					edtwloxxmh_generate.field('rack_name').error( 'Wajib diisi!' );
				}
				if(!bay_name || bay_name == ''){
					edtwloxxmh_generate.field('bay_name').error( 'Wajib diisi!' );
				}
				if(!level_name || level_name == ''){
					edtwloxxmh_generate.field('level_name').error( 'Wajib diisi!' );
				}
				if(!position_name || position_name == ''){
					edtwloxxmh_generate.field('position_name').error( 'Wajib diisi!' );
				}

			}
			
			if ( edtwloxxmh_generate.inError() ) {
				return false;
			}
		});

		edtwloxxmh_generate.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwloxxmh_generate.field('finish_at').val(finish_at);
		});

		edtwloxxmh_generate.on('postSubmit', function(e, json, data, action, xhr) {
			tblwloxxmh.ajax.reload(null, false);
		});

		tblwloxxmh = $('#tblwloxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wloxxmh/wloxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wloxxmh = show_deleted_wloxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,5,6,7,8,9]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "wloxxmh.id",visible:false },
				{ data: "wloxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ data: "wloctmh.nama" },
				{ data: "wlotpmh.nama" },
				{ data: "wloznmh.nama" },
				{ data: "wloxxmh.rack_name" },
				{ data: "wloxxmh.bay_name" },
				{ data: "wloxxmh.level_name" },
				{ data: "wloxxmh.position_name" },
				{ 
					data: "wloxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wloxxmh';
					$table       = 'tblwloxxmh';
					$edt         = 'edtwloxxmh';
					$show_status = '_wloxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					extend: 'create',
					name: 'btnGenerateLocation', 
					editor: edtwloxxmh_generate, 
					text: '<i class="fa fa-google"></i>', 
					className: 'btn btn-outline', 
					titleAttr: 'Generate Location',
					formButtons: [
						{
							text: 'Cancel',
							action: function () {
								this.close();
							},
							className: 'btn btn-warning m-r-xs'
						},
						{
							text: 'Save',
							action: function () {
								this.submit();
							},
							className: 'btn btn-primary m-r-xs'
						},
					]
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wloxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wloxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwloxxmh.searchPanes.container().appendTo('#spwloxxmh');
		tblwloxxmh.searchBuilder.container().appendTo( '#sbwloxxmh' );
		
		tblwloxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwloxxmh);
		} );
		
		tblwloxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wloxxmh');
			id_iwhxxmh_old           = wloxxmh_data.id_iwhxxmh;
			id_wloctmh_old           = wloxxmh_data.id_wloctmh;
			id_wlotpmh_old           = wloxxmh_data.id_wlotpmh;
			id_wloznmh_old           = wloxxmh_data.id_wloznmh;
			id_iumxxmh_kapasitas_old = wloxxmh_data.id_iumxxmh_kapasitas;
			id_iwhxxmh               = wloxxmh_data.id_iwhxxmh;
			// atur hak akses
			CekSelectHeaderH(tblwloxxmh);
		} );

		tblwloxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wloxxmh');
			id_iwhxxmh_old = 0, id_wloctmh_old = 0, id_wlotpmh_old = 0, id_wloznmh_old = 0, id_iumxxmh_kapasitas_old = 0, id_iwhxxmh = 0;

			// atur hak akses
			CekDeselectHeaderH(tblwloxxmh);
		} );
		
		// END wloxxmh

	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
