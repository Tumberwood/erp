<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'iimxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'iimummd';
    $nama_tabels_d[1] = 'wimlotd';
    $nama_tabels_d[2] = 'iimrlmd_supplier';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div id="frmiimxxmh">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh.kode"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="iimxxmh.nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh.id_iitxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="iimxxmh.id_iicxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh.id_iigxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="iimxxmh.id_iigx2mh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh.id_iibxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh.movement_method"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="iimxxmh.movement_method2"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh.is_batch_number"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="iimxxmh.is_expired_date"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="iimxxmh_files[].id"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="iimxxmh.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>

				<table id="tbliimxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th data-i18n="code"></th>
							<th data-i18n="name"></th>
							<th data-i18n="type"></th>
							<th data-i18n="category"></th>
							<th data-i18n="group"></th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>

	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabiimummd"> UoM</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabwimlotd"> Loc Pref &nbsp<small class="label label-info">WMS</small></a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabiimrlmd_supplier"> Supplier</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabiimummd" class="tab-pane active">
					<div class="panel-body">
						
						<div id="frmiimummd">
							<div class="panel-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.id_iumxxmh"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.is_terkecil"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.jumlah_konversi"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.is_default"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.is_iumxxmh_jual"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.is_iumxxmh_beli"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.is_replenishment"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.keterangan"></editor-field>
									</div>
								</div>
								<h5 class="text-secondary">UoM Weight & Dimension mengikuti General Setting</h5>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.nw"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="iimummd.gw"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<editor-field name="iimummd.panjang"></editor-field>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<editor-field name="iimummd.lebar"></editor-field>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<editor-field name="iimummd.tinggi"></editor-field>
									</div>
								</div>
							</div>
						</div>

						<table id="tbliimummd" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th rowspan=2>ID</th>
									<th rowspan=2>id_iimxxmh</th>
									<th rowspan=2>UoM</th>
									<th rowspan=2 data-i18n="conversion"></th>
									<th colspan=5>UoM Purpose</th>
								</tr>
								<tr>
									<th data-i18n="inventory"></th>
									<th>Base</th>
									<th data-i18n="buy"></th>
									<th data-i18n="sell"></th>
									<th>Replenishment</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

				<div role="tabpanel" id="tabwimlotd" class="tab-pane">
					<div class="panel-body">

						<table id="tblwimlotd" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_iimxxmh</th>
									<th>Location</th>
									<th>Order</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

				<div role="tabpanel" id="tabiimrlmd_supplier" class="tab-pane">
					<div class="panel-body">

						<table id="tbliimrlmd_supplier" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_iimxxmh</th>
									<th>Supplier</th>
									<th>Leadtime</th>
									<th>MOQ</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iimxxmh/fn/iimxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiimxxmh, tbliimxxmh, show_deleted_iimxxmh = 0, id_iimxxmh;
	var edtiimummd, tbliimummd, show_deleted_iimummd = 0, id_iimummd;
	var edtiimummd_copyfrom;
	var edtwimlotd, tblwimlotd, show_deleted_wimlotd = 0, id_wimlotd;
	var edtwimlotd_copyfrom;
	var edtwimlotd_generate;

	var edtiimrlmd_supplier, tbliimrlmd_supplier, show_deleted_iimrlmd_supplier = 0, id_iimrlmd_supplier;
	var edtiimrlmd_supplier_copyfrom;
	// ------------- end of default variable

	var id_iitxxmh = 0, id_iitxxmh_old = 0, id_iicxxmh_old = 0, id_iigxxmh = 0, id_iigxxmh_old = 0, id_iigx2mh_old = 0, id_iibxxmh_old = 0, id_iimxxmh_old = 0;
	
	var id_iumxxmh_old = 0;
	var is_default_old = 0;
	var is_iumxxmh_beli = 0, is_iumxxmh_beli_old = 0, is_iumxxmh_jual = 0, is_iumxxmh_jual_old = 0, is_replenishment_old = 0;
	var is_update_iumxxmh_default = 0, is_update_iumxxmh_beli = 0, is_update_iumxxmh_jual  = 0;
	var id_wloxxmh_old = 0, id_grlxxmh_old = 0;

	// get tableRelation
	tableRelation('iimxxmh');

	$(document).ready(function() {
		// BEGIN iimxxmh
		
		edtiimxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimxxmh = show_deleted_iimxxmh;
				}
			},
			table: "#tbliimxxmh",
			template: "#frmiimxxmh",
			fields: [ 
				{
					label: "iimxxmh.start_at",
					name: "iimxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iimxxmh.finish_at",
					name: "iimxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iimxxmh",
					type: "hidden"
				},	
				{
					label: "iimxxmh.transaction_state",
					name: "iimxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "iimxxmh.is_sub_contract",
					name: "iimxxmh.is_sub_contract",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "iimxxmh.kode"
				},
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "iimxxmh.nama"
				},
				{
					label: "Item Type <sup class='text-danger'>*<sup>",
					name: "iimxxmh.id_iitxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iitxxmh/iitxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iitxxmh_old: id_iitxxmh_old,
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
					label: "Item Category <sup class='text-danger'>*<sup>",
					name: "iimxxmh.id_iicxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iicxxmh/iicxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iicxxmh_old: id_iicxxmh_old,
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
					label: "Item Group 1 <sup class='text-danger'>*<sup>",
					name: "iimxxmh.id_iigxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iigxxmh/iigxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iigxxmh_old: id_iigxxmh_old,
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
					label: "Item Group 2",
					name: "iimxxmh.id_iigx2mh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iigx2mh/iigx2mh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iigxxmh: id_iigxxmh,
									id_iigx2mh_old: id_iigx2mh_old,
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
					label: "Item Brand <sup class='text-danger'>*<sup>",
					name: "iimxxmh.id_iibxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iibxxmh/iibxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iibxxmh_old: id_iibxxmh_old,
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
					label: "Images",
					name: "iimxxmh_files[].id",
					type: "uploadMany",
					display: function ( id_files, counter ) {
						if (id_files > 0) {
							return '<img src="'+edtiimxxmh.file( 'iimxxmh_files', id_files ).web_path+'"/>';
						} else {
							return 'Belum ada gambar';
						}
					},
				},
				{
					label: "Movement Method <sup class='text-danger'>*<sup>",
					name: "iimxxmh.movement_method",
					type: "select",
					placeholder : "Select",
					def: 1,
					options: [
						{ "label": "FEFO", "value": 1 },
						{ "label": "FIFO", "value": 2 },
						{ "label": "LIFO", "value": 3 },
					]
				},
				{
					label: "Movement Method 2<sup class='text-danger'>*<sup>",
					name: "iimxxmh.movement_method2",
					type: "select",
					placeholder : "Select",
					def: 2,
					options: [
						{ "label": "FEFO", "value": 1 },
						{ "label": "FIFO", "value": 2 },
						{ "label": "LIFO", "value": 3 },
					]
				},
				{
					label: "Wajib Batch Number <sup class='text-danger'>*<sup>",
					name: "iimxxmh.is_batch_number",
					type: "select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Wajib Expired Date <sup class='text-danger'>*<sup>",
					name: "iimxxmh.is_expired_date",
					type: "select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: getTranslation('notes'),
					name: "iimxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtiimxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimxxmh.field('iimxxmh.start_at').val(start_at);

			if(action == 'create'){
				tbliimxxmh.rows().deselect();

				edtiimxxmh.field('iimxxmh.kode').enable();
				edtiimxxmh.field('iimxxmh.nama').enable();
			}else if(action == 'edit'){
					
				if(transaction_state == 0){
					edtiimxxmh.field('iimxxmh.kode').enable();
					edtiimxxmh.field('iimxxmh.nama').enable();
				}else{
					edtiimxxmh.field('iimxxmh.kode').disable();
					edtiimxxmh.field('iimxxmh.nama').disable();
				}
			}
		});

		edtiimxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});

		edtiimxxmh.dependent( 'iimxxmh.id_iitxxmh', function ( val, data, callback ) {
			id_iicxxmh = edtiimxxmh.field('iimxxmh.id_iicxxmh').val();
			
			if (val == 1) {
				if (id_iicxxmh == 4 ) {
					edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group");
					edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand");
				} else {
					edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group <sup class='text-danger'>*<sup>");
					edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand <sup class='text-danger'>*<sup>");
				}

				edtiimxxmh.field('iimxxmh.movement_method').show();
				edtiimxxmh.field('iimxxmh.movement_method2').show();
				edtiimxxmh.field('iimxxmh.is_batch_number').show();
				edtiimxxmh.field('iimxxmh.is_expired_date').show();
				edtiimxxmh.field('iimxxmh.is_sub_contract').val(0);
		
			} else {
				if (val == 8) {
					edtiimxxmh.field('iimxxmh.is_sub_contract').val(1);
				} else {
					edtiimxxmh.field('iimxxmh.is_sub_contract').val(0);
				}
				edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group");
				edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand");

				edtiimxxmh.field('iimxxmh.movement_method').hide();
				edtiimxxmh.field('iimxxmh.movement_method2').hide();
				edtiimxxmh.field('iimxxmh.is_batch_number').hide();
				edtiimxxmh.field('iimxxmh.is_expired_date').hide();
			}
			return {}
		}, {event: 'keyup change'});
		
		edtiimxxmh.dependent( 'iimxxmh.id_iigxxmh', function ( val, data, callback ) {
			id_iigxxmh = val;
			// code here
			return {}
		}, {event: 'keyup change'});
		
		edtiimxxmh.dependent( 'iimxxmh.id_iicxxmh', function ( val, data, callback ) {
			id_iitxxmh = edtiimxxmh.field('iimxxmh.id_iitxxmh').val();

			if (id_iitxxmh == 3) {
				edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group");
				edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand");
			} else {
				if (val == 4) {
					edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group");
					edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand");
				} else {
					edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group <sup class='text-danger'>*<sup>");
					edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand <sup class='text-danger'>*<sup>");
				}
			}
			// code here
			return {}
		}, {event: 'keyup change'});

		edtiimxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode       = edtiimxxmh.field('iimxxmh.kode').val();
				nama       = edtiimxxmh.field('iimxxmh.nama').val();
				id_iitxxmh = edtiimxxmh.field('iimxxmh.id_iitxxmh').val();
				id_iicxxmh = edtiimxxmh.field('iimxxmh.id_iicxxmh').val();

				validasiRequired(
					edtiimxxmh,
					'iimxxmh',
					{
						'kode': kode,
						'nama': nama,
						'id_iitxxmh': id_iitxxmh,
						'id_iicxxmh': id_iicxxmh
					}
				);
				
				if (id_iicxxmh != 4) {
					if (id_iitxxmh == 1) {
						id_iigxxmh      = edtiimxxmh.field('iimxxmh.id_iigxxmh').val();
						id_iibxxmh      = edtiimxxmh.field('iimxxmh.id_iibxxmh').val();
						movement_method = edtiimxxmh.field('iimxxmh.movement_method').val();
						movement_method2 = edtiimxxmh.field('iimxxmh.movement_method2').val();
						is_batch_number = edtiimxxmh.field('iimxxmh.is_batch_number').val();
						is_expired_date = edtiimxxmh.field('iimxxmh.is_expired_date').val();
						
						validasiRequired(
							edtiimxxmh, 
							"iimxxmh", 
							{
								"id_iigxxmh": id_iigxxmh,
								"id_iibxxmh": id_iibxxmh,
								'movement_method': movement_method,
								'movement_method2': movement_method2,
							}
						);
	
						if(movement_method == movement_method2){
							edtiimxxmh.field('iimxxmh.movement_method2').error( 'Movement Method kedua tidak boleh sama dengan Movement Method pertama' );
						}
	
						// if(!is_expired_date){
						// 	edtiimxxmh.field('iimxxmh.is_expired_date').error( 'Wajib Diisi!' );
						// }
					}
				}

				validasiUnique(
					action,
					edtiimxxmh, 
					"iimxxmh", 
					"kode", 
					'kode',
					'"'+kode+'"',
					id_iimxxmh
				);
				
				validasiUnique(
					action,
					edtiimxxmh, 
					"iimxxmh", 
					"nama", 
					'nama',
					'"'+nama+'"',
					id_iimxxmh
				);
				
			}
			
			if ( edtiimxxmh.inError() ) {
				return false;
			}
		});

		edtiimxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimxxmh.field('iimxxmh.finish_at').val(finish_at);

			id_iitxxmh = edtiimxxmh.field('iimxxmh.id_iitxxmh').val();
			if (id_iitxxmh != 1) {
				
				// edtiimxxmh.field('iimxxmh.movement_method').val(0);
				edtiimxxmh.field('iimxxmh.is_batch_number').val(0);
				edtiimxxmh.field('iimxxmh.is_expired_date').val(0);
			}
		});
		
		edtiimxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			// id_transaksi_header = json.data[0].iimxxmh.id;
		} );

		edtiimxxmh.on( 'close', function () {
			edtiimxxmh.enable();
		} );
		
		tbliimxxmh = $('#tbliimxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iimxxmh/iimxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimxxmh = show_deleted_iimxxmh;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: "_all"
				}
			],
			columns: [
				{ data: "iimxxmh.id",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iitxxmh.nama" },
				{ data: "iicxxmh.nama" },
				{ data: "iigxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iimxxmh';
					$table       = 'tbliimxxmh';
					$edt         = 'edtiimxxmh';
					$show_status = '_iimxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.iimxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iimxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbliimxxmh.searchPanes.container().appendTo('#spiimxxmh');
		tbliimxxmh.searchBuilder.container().appendTo( '#sbiimxxmh' );

		tbliimxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbliimummd, tblwimlotd, tbliimrlmd_supplier];
			CekInitHeaderHD(tbliimxxmh, tbl_details);

			tbliimummd.button( 'btnIimummdCopyFrom:name' ).disable();
			tblwimlotd.button( 'btnWimlotdCopyFrom:name' ).disable();
			tblwimlotd.button( 'btnGenerateLocPref:name' ).disable();
			tbliimrlmd_supplier.button( 'btnIimrlmd_supplierCopyFrom:name' ).disable();
		} );
		
		tbliimxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iimxxmh');
			id_iitxxmh_old = iimxxmh_data.id_iitxxmh;
			id_iicxxmh_old = iimxxmh_data.id_iicxxmh;
			id_iigxxmh     = iimxxmh_data.id_iigxxmh;
			id_iigxxmh_old = iimxxmh_data.id_iigxxmh;
			id_iigx2mh_old = iimxxmh_data.id_iigx2mh;
			id_iimxxmh_old = iimxxmh_data.id;
			
			// atur hak akses
			tbl_details = [tbliimummd, tblwimlotd, tbliimrlmd_supplier];
			CekSelectHeaderHD(tbliimxxmh, tbl_details);

			tbliimummd.button( 'btnIimummdCopyFrom:name' ).enable();
			tblwimlotd.button( 'btnWimlotdCopyFrom:name' ).enable();
			tblwimlotd.button( 'btnGenerateLocPref:name' ).enable();
			tbliimrlmd_supplier.button( 'btnIimrlmd_supplierCopyFrom:name' ).enable();

			//cek detail UoM default
			cekUoMDefault(id_iimxxmh);
			// console.log(c_id);
			if (c_id == 1) {
				tbliimxxmh.button('btnConfirm:name').enable();
			} else {
				full_message = 'Item ini tidak memiliki UoM Default!</br> Silahkan edit Detail UoM</br>';
				toast_type   = 'error';
				toastr[toast_type](full_message, 'INFO');
				tbliimxxmh.button('btnConfirm:name').disable();
			}
		} );
		
		tbliimxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iimxxmh');
			id_iitxxmh_old = 0, id_iicxxmh_old = 0, id_iigxxmh = 0, id_iigxxmh_old = 0, id_iigx2mh_old = 0, id_iimxxmh_old = 0;

			// atur hak akses
			tbl_details = [tbliimummd, tblwimlotd, tbliimrlmd_supplier];
			CekDeselectHeaderHD(tbliimxxmh, tbl_details);

			tbliimummd.button( 'btnIimummdCopyFrom:name' ).disable();
			tblwimlotd.button( 'btnWimlotdCopyFrom:name' ).disable();
			tblwimlotd.button( 'btnGenerateLocPref:name' ).disable();
			tbliimrlmd_supplier.button( 'btnIimrlmd_supplierCopyFrom:name' ).disable();
		} );

		// END iimxxmh

		
		// BEGIN iimummd

		edtiimummd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimummd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimummd = show_deleted_iimummd;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tbliimummd",
			template: "#frmiimummd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "iimummd.start_at",
					name: "iimummd.start_at",
					type: "hidden"
				},	
				{
					label: "iimummd.finish_at",
					name: "iimummd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iimummd",
					type: "hidden"
				},	
				{
					label: "iimummd.transaction_state",
					name: "iimummd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_iimxxmh",
					name: "iimummd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "UoM",
					name: "iimummd.id_iumxxmh",
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
									id_iumxxmh_old: id_iumxxmh_old,
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
					label: "Terkecil <sup class='text-danger'>*<sup>",
					name: "iimummd.is_terkecil",
					type: "select",
					placeholder : "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				}, 	
				{
					label: "Konversi <sup class='text-danger'>*<sup>",
					name: "iimummd.jumlah_konversi",
					fieldInfo: "Konversi jumlah harus dihitung terhadap UoM terkecil. Isi 1 jika merupakan UoM terkecil"
				},
				{
					label: "Default UoM <sup class='text-danger'>*<sup>",
					name: "iimummd.is_default",
					type: "select",
					placeholder : "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},  	
				{
					label: "Selling UoM <sup class='text-danger'>*<sup>",
					name: "iimummd.is_iumxxmh_jual",
					type: "select",
					placeholder : "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				}, 		
				{
					label: "Buying UoM <sup class='text-danger'>*<sup>",
					name: "iimummd.is_iumxxmh_beli",
					type: "select",
					placeholder : "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				}, 		
				{
					label: "UoM Replenishment <sup class='text-danger'>*<sup>",
					name: "iimummd.is_replenishment",
					type: "select",
					placeholder : "Pilih",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				}, 		
				{
					label: getTranslation('notes'),
					name: "iimummd.keterangan",
					type: "textarea"
				},
				{
					label: "Net Weight (kg)",
					name: "iimummd.nw"
				},
				{
					label: "Gross Weight (kg)",
					name: "iimummd.gw"
				},
				{
					label: "Length (cm)",
					name: "iimummd.panjang"
				},
				{
					label: "Width (cm)",
					name: "iimummd.lebar"
				},
				{
					label: "Height (cm)",
					name: "iimummd.tinggi"
				},
				{
					label: "is_update_iumxxmh_default",
					name: "is_update_iumxxmh_default",
					type: "hidden"
				},
				{
					label: "is_update_iumxxmh_beli",
					name: "is_update_iumxxmh_beli",
					type: "hidden"
				},
				{
					label: "is_update_iumxxmh_jual",
					name: "is_update_iumxxmh_jual",
					type: "hidden"
				},
				{
					label: "is_replenishment",
					name: "is_replenishment",
					type: "hidden"
				},
				
			]
		} );
			
		edtiimummd.on( 'preOpen', function( e, mode, action ) {
			edtiimummd.field('iimummd.id_iimxxmh').val(id_iimxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimummd.field('iimummd.start_at').val(start_at);
			
			if(action == 'create'){
				tbliimummd.rows().deselect();
			}

			edtiimummd.field('is_update_iumxxmh_default').val(0);
		});

		edtiimummd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtiimummd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// set variable
				id_iumxxmh      = edtiimummd.field('iimummd.id_iumxxmh').val();
				jumlah_konversi = edtiimummd.field('iimummd.jumlah_konversi').val();
				panjang         = edtiimummd.field('iimummd.panjang').val();
				lebar           = edtiimummd.field('iimummd.lebar').val();
				tinggi          = edtiimummd.field('iimummd.tinggi').val();
				nw              = edtiimummd.field('iimummd.nw').val();
				gw              = edtiimummd.field('iimummd.gw').val();

				validasiRequired(
					edtiimummd,
					'iimummd',
					{
						'id_iumxxmh': id_iumxxmh,
						'jumlah_konversi': jumlah_konversi
					}
				);
				
				validasiUnique(
					action,
					edtiimummd,
					'iimummd',
					'id_iumxxmh',
					'id_iumxxmh,id_iimxxmh',
					id_iumxxmh+','+id_iimxxmh,
					id_iimummd,
				);

				validasiNumber(
					edtiimummd,
					'iimummd',
					{
						'jumlah_konversi': jumlah_konversi
					},
					0,
					'>'
				);

				if (id_iitxxmh == 1) {
					validasiNumber(
						edtiimummd, 
						'iimummd', 
						{
							'panjang': panjang, 
							'lebar': lebar, 
							'tinggi': tinggi, 
							'nw': nw, 
							'gw': gw
						},
						0,
						'>='
					);
				}
			}
			
			if ( edtiimummd.inError() ) {
				return false;
			}
		});

		edtiimummd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimummd.field('iimummd.finish_at').val(finish_at);

			// BEGIN is_default
			// ambil is_default dari form input
			is_default 		= edtiimummd.field('iimummd.is_default').val();
			is_iumxxmh_beli	= edtiimummd.field('iimummd.is_iumxxmh_beli').val();
			is_iumxxmh_jual = edtiimummd.field('iimummd.is_iumxxmh_jual').val();
			is_replenishment = edtiimummd.field('iimummd.is_replenishment').val();

			if(action == 'create'){
				is_default_old = 0;
				is_iumxxmh_beli_old = 0
				is_iumxxmh_jual_old = 0
				is_replenishment_old = 0
			} // else nya sudah didapatkan saat select

			if(is_default == 1 && is_default != is_default_old){
				// jika inputan Default = Ya dan sebelumnya bukan Ya
				// konfirmasi perubahan
				if(confirm('Apakah Anda Ingin Mengubah Default UoM?')){
					edtiimummd.field('is_update_iumxxmh_default').val(1);
				}else{
					edtiimummd.field('is_update_iumxxmh_default').val(0);
					return false;
				}
			}else{
				// tidak ada perubahan

			}
			// END is_default

			// BEGIN konfirmasi Default UoM Beli
			if(is_iumxxmh_beli == 1 && is_iumxxmh_beli != is_iumxxmh_beli_old){
				if(confirm('Apakah Anda Ingin Mengubah Default Buying UoM?')){
					edtiimummd.field('is_update_iumxxmh_beli').val(1);
				}else{
					edtiimummd.field('is_update_iumxxmh_beli').val(0);
					return false;
				}
			}
			// END konfirmasi Default UoM Beli
			
			// BEGIN konfirmasi Default UoM Jual
			if(is_iumxxmh_jual == 1 && is_iumxxmh_jual != is_iumxxmh_jual_old){
				if(confirm('Apakah Anda Ingin Mengubah Default Selling UoM?')){
					edtiimummd.field('is_update_iumxxmh_jual').val(1);
				}else{
					edtiimummd.field('is_update_iumxxmh_jual').val(0);
					return false;
				}
			}
			// END konfirmasi Default UoM Jual
			
			// BEGIN konfirmasi Default UoM Jual
			if(is_replenishment == 1 && is_replenishment != is_replenishment_old){
				if(confirm('Apakah Anda Ingin Mengubah Default UoM Replenishment?')){
					edtiimummd.field('is_replenishment').val(1);
				}else{
					edtiimummd.field('is_replenishment').val(0);
					return false;
				}
			}
			// END konfirmasi Default UoM Jual

		});
			
		edtiimummd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliimummd.ajax.reload(null, false);			

		} );

		edtiimummd.on( 'close', function () {
			edtiimummd.enable();
		} );

		edtiimummd_copyfrom = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimummd_fn_copyfrom.php",
				type: 'POST',
				data: function (d){
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tbliimummd",
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
					label: "id_iimxxmh",
					name: "iimummd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Copy From Item",
					name: "id_iimxxmh_source",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: 0,
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
				}
			]
		} );
			
		edtiimummd_copyfrom.on( 'preOpen', function( e, mode, action ) {
			edtiimummd_copyfrom.field('iimummd.id_iimxxmh').val(id_iimxxmh);
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimummd_copyfrom.field('start_at').val(start_at);
			
			if(action == 'create'){
				tbliimummd.rows().deselect();
			}
		});

		edtiimummd_copyfrom.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});


		edtiimummd_copyfrom.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iimxxmh_source = edtiimummd_copyfrom.field('id_iimxxmh_source').val();
				if(id_iimxxmh_source == null || id_iimxxmh_source == ''){
					edtiimummd_copyfrom.field('id_iimxxmh_source').error( 'Wajib diisi!' );
				}
				
			}
			
			if ( edtiimummd_copyfrom.inError() ) {
				return false;
			}
		});

		edtiimummd_copyfrom.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimummd_copyfrom.field('finish_at').val(finish_at);
		});

		edtiimummd_copyfrom.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliimxxmh.ajax.reload(null, false);
			tbliimummd.ajax.reload(null, false);
		} );

		tbliimummd = $('#tbliimummd').DataTable( {
			ajax: {
				url: "../../models/iimxxmh/iimummd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimummd = show_deleted_iimummd;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "iimummd.id",visible:false },
				{ data: "iimummd.id_iimxxmh",visible:false },
				{ data: "iumxxmh.kode" },
				{ 
					data: "iimummd.jumlah_konversi" ,
					...renderNumber(2)
				},
				{ 
					data: "iimummd.is_terkecil" ,
					...renderYesNo()
				},
				{ 
					data: "iimummd.is_default" ,
					...renderYesNo()
				},
				{ 
					data: "iimummd.is_iumxxmh_beli" ,
					...renderYesNo()
				},
				{ 
					data: "iimummd.is_iumxxmh_jual" ,
					...renderYesNo()
				},
				{ 
					data: "iimummd.is_replenishment" ,
					...renderYesNo()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iimummd';
					$table       = 'tbliimummd';
					$edt         = 'edtiimummd';
					$show_status = '_iimummd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
				{ 
					extend: 'create',
					name: 'btnIimummdCopyFrom', 
					editor: edtiimummd_copyfrom, 
					text: '<i class="fa fa-copy"></i>', 
					className: 'btn btn-outline', 
					titleAttr: 'Copy From'
				}
			],
			initComplete: function() {
				// this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tbliimummd.on( 'draw', function( e, settings ) { 
			// atur hak akses			
			CekDrawDetailHD( tbliimummd, 1 );
			CekDrawDetailHDFinal(tbliimxxmh);

		} );

		tbliimummd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('iimummd');
			id_iumxxmh_old      = iimummd_data.id_iumxxmh;
			is_default_old      = iimummd_data.is_default;
			is_iumxxmh_beli_old = iimummd_data.is_iumxxmh_beli;
			is_iumxxmh_jual_old = iimummd_data.is_iumxxmh_jual;
			is_replenishment_old = iimummd_data.is_replenishment;
			
			// atur hak akses
			CekSelectDetailHD(tbliimummd );

		} );

		tbliimummd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('iimummd');
			id_iimummd = 0;
			id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbliimummd );

		} );

		// END iimummd

		// BEGIN wimlotd

		edtwimlotd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/wimlotd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wimlotd = show_deleted_wimlotd;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tblwimlotd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "wimlotd.start_at",
					name: "wimlotd.start_at",
					type: "hidden"
				},	
				{
					label: "wimlotd.finish_at",
					name: "wimlotd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wimlotd",
					type: "hidden"
				},	
				{
					label: "wimlotd.transaction_state",
					name: "wimlotd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_iimxxmh",
					name: "wimlotd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Location",
					name: "wimlotd.id_wloxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
									ids_wloctmh: 3,
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
					name: "wimlotd.urutan"
				}
				
			]
		} );
			
		edtwimlotd.on( 'preOpen', function( e, mode, action ) {
			edtwimlotd.field('wimlotd.id_iimxxmh').val(id_iimxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwimlotd.field('wimlotd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwimlotd.rows().deselect();
			}

			autofillField('ggswmsh', 1, 'is_koordinat');
			is_koordinat = autofillData.is_koordinat;
			
			if (is_koordinat == 0) {
				edtwimlotd.field('wimlotd.urutan').label("Urutan <sup class='text-danger'>*<sup>");
			} else {
				edtwimlotd.field('wimlotd.urutan').label("Urutan");
			}
		});

		edtwimlotd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtwimlotd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// set variable
				id_wloxxmh = edtwimlotd.field('wimlotd.id_wloxxmh').val();
				urutan     = edtwimlotd.field('wimlotd.urutan').val();

				validasiRequired(
					edtwimlotd,
					'wimlotd',
					{
						'id_wloxxmh': id_wloxxmh,
					}
				);

				validasiUnique(
					action,
					edtwimlotd,
					'wimlotd',
					'id_wloxxmh',
					'id_iimxxmh, id_wloxxmh',
					id_iimxxmh + ',' + id_wloxxmh,
					id_wimlotd
				);

				autofillField('ggswmsh', 1, 'is_koordinat');
				is_koordinat = autofillData.is_koordinat;
				
				if (is_koordinat == 0) {
					
					validasiNumber(
						edtwimlotd,
						'wimlotd',
						{
							'urutan': urutan
						},
						0,
						'>'
					);

					validasiUnique(
						action,
						edtwimlotd,
						'wimlotd',
						'urutan',
						'id_iimxxmh, urutan',
						id_iimxxmh + ',' + urutan,
						id_wimlotd
					);
				}
			}
			
			if ( edtwimlotd.inError() ) {
				return false;
			}
		});

		edtwimlotd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwimlotd.field('wimlotd.finish_at').val(finish_at);
		});
			
		edtwimlotd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblwimlotd.ajax.reload(null, false);
			tbliimxxmh.ajax.reload(null, false);
		} );

		edtwimlotd.on( 'close', function () {
			edtwimlotd.enable();
		} );


		edtwimlotd_copyfrom = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/wimlotd_fn_copyfrom.php",
				type: 'POST',
				data: function (d){
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tblwimlotd",
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
					label: "id_iimxxmh",
					name: "wimlotd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Copy From Item",
					name: "id_iimxxmh_source",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: 0,
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
				}
			]
		} );
			
		edtwimlotd_copyfrom.on( 'preOpen', function( e, mode, action ) {
			edtwimlotd_copyfrom.field('wimlotd.id_iimxxmh').val(id_iimxxmh);
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwimlotd_copyfrom.field('start_at').val(start_at);

			if(action == 'create'){
				tblwimlotd.rows().deselect();
			}
		});

		edtwimlotd_copyfrom.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});


		edtwimlotd_copyfrom.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iimxxmh_source = edtwimlotd_copyfrom.field('id_iimxxmh_source').val();
				if(id_iimxxmh_source == null || id_iimxxmh_source == ''){
					edtwimlotd_copyfrom.field('id_iimxxmh_source').error( 'Wajib diisi!' );
				}
				
			}
			
			if ( edtwimlotd_copyfrom.inError() ) {
				return false;
			}
		});

		edtwimlotd_copyfrom.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwimlotd_copyfrom.field('finish_at').val(finish_at);
		});

		edtwimlotd_copyfrom.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliimxxmh.ajax.reload(null, false);
			tblwimlotd.ajax.reload(null, false);
		} );

		
		edtwimlotd_generate = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/wimlotd_fn_generate.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wimlotd = show_deleted_wimlotd;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tblwimlotd",
			fields: [ 
				{
					label: "id_iimxxmh",
					name: "id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Rack",
					name: "rack_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Rack.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_rack.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_rack_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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
					label: "Bay",
					name: "bay_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Bay.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_bay.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_bay_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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
					label: "Level",
					name: "level_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Level.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_level.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_level_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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
					label: "Position",
					name: "position_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Position.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_position.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_position_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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

			]
		} );
			
		edtwimlotd_generate.on( 'preOpen', function( e, mode, action ) {
			edtwimlotd_generate.field('id_iimxxmh').val(id_iimxxmh);
		});

		edtwimlotd_generate.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtwimlotd_generate.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				
				
			}
			
			if ( edtwimlotd_generate.inError() ) {
				return false;
			}
		});

		edtwimlotd_generate.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblwimlotd.ajax.reload(null, false);
			tbliimxxmh.ajax.reload(null, false);
		} );


		tblwimlotd = $('#tblwimlotd').DataTable( {
			ajax: {
				url: "../../models/iimxxmh/wimlotd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wimlotd = show_deleted_wimlotd;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			order: [[ 2, "asc" ]],
			columns: [
				{ data: "wimlotd.id",visible:false },
				{ data: "wimlotd.id_iimxxmh",visible:false },
				{ data: "wloxxmh.nama" },
				{ 
					data: "wimlotd.urutan" ,
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wimlotd';
					$table       = 'tblwimlotd';
					$edt         = 'edtwimlotd';
					$show_status = '_wimlotd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				{ 
					extend: 'create',
					name: 'btnWimlotdCopyFrom', 
					editor: edtwimlotd_copyfrom, 
					text: '<i class="fa fa-copy"></i>', 
					className: 'btn btn-outline', 
					titleAttr: 'Copy From'
				},
				{
					extend: 'create',
					name: 'btnGenerateLocPref', 
					editor: edtwimlotd_generate, 
					text: '<i class="fa fa-google"></i>', 
					className: 'btn btn-outline', 
					titleAttr: 'Generate Location Preference'
				},
				// END breaking generate button
			],
			initComplete: function() {

			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblwimlotd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwimlotd, 1 );
			CekDrawDetailHDFinal(tbliimxxmh);

		} );

		tblwimlotd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wimlotd');
			id_wloxxmh_old      = wimlotd_data.id_wloxxmh;
			// atur hak akses
			CekSelectDetailHD( tblwimlotd );

		} );

		tblwimlotd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wimlotd');
			id_wimlotd = 0;
			id_wloxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwimlotd );

		} );

		// END wimlotd


		// BEGIN iimrlmd_supplier

		edtiimrlmd_supplier = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimrlmd_supplier.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimrlmd_supplier = show_deleted_iimrlmd_supplier;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tbliimrlmd_supplier",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "iimrlmd_supplier.start_at",
					name: "iimrlmd_supplier.start_at",
					type: "hidden"
				},	
				{
					label: "iimrlmd_supplier.finish_at",
					name: "iimrlmd_supplier.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iimrlmd_supplier",
					type: "hidden"
				},	
				{
					label: "iimrlmd_supplier.transaction_state",
					name: "iimrlmd_supplier.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_iimxxmh",
					name: "iimrlmd_supplier.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Supplier <sup class='text-danger'>*<sup>",  
					name: "iimrlmd_supplier.id_grlxxmh_supplier",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/psuxxmh/psuxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_old,
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
					label: "Leadtime (Hari) <sup class='text-danger'>*<sup>",
					name: "iimrlmd_supplier.leadtime_hari"
				},
				{
					label: "MOQ <sup class='text-danger'>*<sup>",
					name: "iimrlmd_supplier.moq"
				},
			]
		} );
			
		edtiimrlmd_supplier.on( 'preOpen', function( e, mode, action ) {
			edtiimrlmd_supplier.field('iimrlmd_supplier.id_iimxxmh').val(id_iimxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimrlmd_supplier.field('iimrlmd_supplier.start_at').val(start_at);
			
			if(action == 'create'){
				tbliimrlmd_supplier.rows().deselect();
			}
		});

		edtiimrlmd_supplier.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtiimrlmd_supplier.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// set variable
				id_grlxxmh_supplier = edtiimrlmd_supplier.field('iimrlmd_supplier.id_grlxxmh_supplier').val();
				leadtime_hari     = edtiimrlmd_supplier.field('iimrlmd_supplier.leadtime_hari').val();
				moq     = edtiimrlmd_supplier.field('iimrlmd_supplier.moq').val();

				validasiRequired(
					edtiimrlmd_supplier,
					'iimrlmd_supplier',
					{
						'id_grlxxmh_supplier': id_grlxxmh_supplier,
						'leadtime_hari': leadtime_hari,
						'moq': moq,
					}
				);

				
				validasiNumber(
					edtiimrlmd_supplier,
					'iimrlmd_supplier',
					{
						'leadtime_hari': leadtime_hari,
						'moq': moq,
					},
					0,
					'>'
				);

				validasiUnique(
					action,
					edtiimrlmd_supplier,
					'iimrlmd_supplier',
					'id_grlxxmh_supplier',
					'id_iimxxmh, id_grlxxmh_supplier',
					id_iimxxmh + ',' + id_grlxxmh_supplier,
					id_iimrlmd_supplier
				);

			}
			
			if ( edtiimrlmd_supplier.inError() ) {
				return false;
			}
		});

		edtiimrlmd_supplier.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimrlmd_supplier.field('iimrlmd_supplier.finish_at').val(finish_at);
		});
			
		edtiimrlmd_supplier.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliimrlmd_supplier.ajax.reload(null, false);
			tbliimxxmh.ajax.reload(null, false);
		} );

		edtiimrlmd_supplier.on( 'close', function () {
			edtiimrlmd_supplier.enable();
		} );


		edtiimrlmd_supplier_copyfrom = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimrlmd_supplier_fn_copyfrom.php",
				type: 'POST',
				data: function (d){
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tbliimrlmd_supplier",
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
					label: "id_iimxxmh",
					name: "iimrlmd_supplier.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Copy From Item",
					name: "id_iimxxmh_source",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: 0,
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
				}
			]
		} );
			
		edtiimrlmd_supplier_copyfrom.on( 'preOpen', function( e, mode, action ) {
			edtiimrlmd_supplier_copyfrom.field('iimrlmd_supplier.id_iimxxmh').val(id_iimxxmh);
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimrlmd_supplier_copyfrom.field('start_at').val(start_at);

			if(action == 'create'){
				tbliimrlmd_supplier.rows().deselect();
			}
		});

		edtiimrlmd_supplier_copyfrom.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});


		edtiimrlmd_supplier_copyfrom.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iimxxmh_source = edtiimrlmd_supplier_copyfrom.field('id_iimxxmh_source').val();
				if(id_iimxxmh_source == null || id_iimxxmh_source == ''){
					edtiimrlmd_supplier_copyfrom.field('id_iimxxmh_source').error( 'Wajib diisi!' );
				}
				
			}
			
			if ( edtiimrlmd_supplier_copyfrom.inError() ) {
				return false;
			}
		});

		edtiimrlmd_supplier_copyfrom.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimrlmd_supplier_copyfrom.field('finish_at').val(finish_at);
		});

		edtiimrlmd_supplier_copyfrom.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliimxxmh.ajax.reload(null, false);
			tbliimrlmd_supplier.ajax.reload(null, false);
		} );

		
		edtiimrlmd_supplier_generate = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimrlmd_supplier_fn_generate.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimrlmd_supplier = show_deleted_iimrlmd_supplier;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			table: "#tbliimrlmd_supplier",
			fields: [ 
				{
					label: "id_iimxxmh",
					name: "id_iimxxmh",
					type: "hidden"
				},
				{
					label: "Rack",
					name: "rack_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Rack.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/grlxxmh_supplier/grlxxmh_supplier_fn_opt_rack.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_supplier_rack_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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
					label: "Bay",
					name: "bay_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Bay.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/grlxxmh_supplier/grlxxmh_supplier_fn_opt_bay.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_supplier_bay_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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
					label: "Level",
					name: "level_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Level.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/grlxxmh_supplier/grlxxmh_supplier_fn_opt_level.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_supplier_level_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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
					label: "Position",
					name: "position_name",
					type: "select2",
					fieldInfo: "Dapat pilih lebih dari satu, atau kosongkan jika ingin generate untuk semua Position.",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/grlxxmh_supplier/grlxxmh_supplier_fn_opt_position.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_supplier_position_old: 0,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								results = data.results;
								transformedResults = results.map(item => ({
									id: item.text,
									text: item.text
								}));								
								return {
									results: transformedResults,
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

			]
		} );
			
		edtiimrlmd_supplier_generate.on( 'preOpen', function( e, mode, action ) {
			edtiimrlmd_supplier_generate.field('id_iimxxmh').val(id_iimxxmh);
		});

		edtiimrlmd_supplier_generate.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtiimrlmd_supplier_generate.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				
				
			}
			
			if ( edtiimrlmd_supplier_generate.inError() ) {
				return false;
			}
		});

		edtiimrlmd_supplier_generate.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliimrlmd_supplier.ajax.reload(null, false);
			tbliimxxmh.ajax.reload(null, false);
		} );


		tbliimrlmd_supplier = $('#tbliimrlmd_supplier').DataTable( {
			ajax: {
				url: "../../models/iimxxmh/iimrlmd_supplier.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimrlmd_supplier = show_deleted_iimrlmd_supplier;
					d.id_iimxxmh = id_iimxxmh;
				}
			},
			order: [[ 2, "asc" ]],
			columns: [
				{ data: "iimrlmd_supplier.id",visible:false },
				{ data: "iimrlmd_supplier.id_iimxxmh",visible:false },
				{ data: "grlxxmh.nama" },
				{ 
					data: "iimrlmd_supplier.leadtime_hari" ,
					...renderNumber(0)
				},
				{ 
					data: "iimrlmd_supplier.moq" ,
					...renderNumber(0)
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iimrlmd_supplier';
					$table       = 'tbliimrlmd_supplier';
					$edt         = 'edtiimrlmd_supplier';
					$show_status = '_iimrlmd_supplier';
					$table_name  = $nama_tabels_d[2];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				{ 
					extend: 'create',
					name: 'btnIimrlmd_supplierCopyFrom', 
					editor: edtiimrlmd_supplier_copyfrom, 
					text: '<i class="fa fa-copy"></i>', 
					className: 'btn btn-outline', 
					titleAttr: 'Copy From'
				},
				// END breaking generate button
			],
			initComplete: function() {

			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tbliimrlmd_supplier.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbliimrlmd_supplier, 1 );
			CekDrawDetailHDFinal(tbliimxxmh);

		} );

		tbliimrlmd_supplier.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('iimrlmd_supplier');
			id_grlxxmh_old      = iimrlmd_supplier_data.id_grlxxmh_supplier;
			// atur hak akses
			CekSelectDetailHD( tbliimrlmd_supplier );

		} );

		tbliimrlmd_supplier.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('iimrlmd_supplier');
			id_iimrlmd_supplier = 0;
			id_grlxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbliimrlmd_supplier );

		} );

		// END iimrlmd_supplier

	} );// end of document.ready
	
</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
<!--  -->