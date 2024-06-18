<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'grlxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'grllomd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div id="custom_grlxxmh">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.nama"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.alamat"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.id_gctxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.id_gpvxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.id_gbuxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.id_fpytmmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.telepon"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.whatsapp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.npwp"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.nik"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.email"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.fax"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblgrlxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="cityName"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabgrllomd_1"> Lokasi Kirim</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabgrllomd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgrllomd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_grlxxmh</th>
										<th data-i18n="name"></th>
										<th data-i18n="address"></th>
										<th data-i18n="cityName"></th>
										<th data-i18n="provinceName"></th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/scuxxmh/fn/scuxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtgrlxxmh, tblgrlxxmh, show_deleted_grlxxmh = 0, id_grlxxmh;
	var edtgrllomd, tblgrllomd, show_deleted_grllomd = 0, id_grllomd;
	// ------------- end of default variable
	
	var kategori_dokumen = 'is_customer', kategori_dokumen_value = 1;

	var id_gctxxmh = 0, id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_fbnxxmh_old = 0;
	
	// get tableRelation
	tableRelation('grlxxmh');

	$(document).ready(function() {
		// BEGIN grlxxmh
		edtgrlxxmh = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 4,
				}
			},
			ajax: {
				url: "../../models/scuxxmh/scuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlxxmh = show_deleted_grlxxmh;
				}
			},
			table: "#tblgrlxxmh",
			template: '#custom_grlxxmh',
			fields: [ 
				{
					label: "grlxxmh.start_at",
					name: "grlxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "grlxxmh.finish_at",
					name: "grlxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "grlxxmh",
					type: "hidden"
				},	
				{
					label: "grlxxmh.transaction_state",
					name: "grlxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "grlxxmh.nama"
				},
				{
					label: getTranslation('address') + " <sup class='text-danger'>*<sup>",
					name: "grlxxmh.alamat",
					type: "textarea"
				},
				{
					label: getTranslation('cityName') + " <sup class='text-danger'>*<sup>",
					name: "grlxxmh.id_gctxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_old,
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
					label: getTranslation('provinceName') + "<sup class='text-danger'>*<sup>",
					name: "grlxxmh.id_gpvxxmh",
					type: "readonly"
				},
				{
					label: getTranslation('businessEntityName') + "<sup class='text-danger'>*<sup>",
					name: "grlxxmh.id_gbuxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gbuxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gbuxxmh_old: id_gbuxxmh_old,
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
					label: getTranslation('termOfPayment') + "<sup class='text-danger'>*<sup>",
					name: "grlxxmh.id_fpytmmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fpytmmh/fpytmmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_fpytmmh_old: id_fpytmmh_old,
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
					label: getTranslation('phone'),
					name: "grlxxmh.telepon"
				},
				{
					label: "Whatsapp",
					name: "grlxxmh.whatsapp"
				},
				{
					label: "Fax",
					name: "grlxxmh.fax"
				},
				{
					label: getTranslation('email'),
					name: "grlxxmh.email"
				},
				{
					label: "PKP",
					name: "grlxxmh.is_pkp",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "NIK",
					name: "grlxxmh.nik"
				},
				{
					label: "NPWP",
					name: "grlxxmh.npwp"
				},
				{
					label: getTranslation('notes'),
					name: "grlxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtgrlxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlxxmh.field('grlxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblgrlxxmh.rows().deselect();
				edtgrlxxmh.field('grlxxmh.nama').enable();

			}else if(action == 'edit'){

				if(transaction_state == 0){
					edtgrlxxmh.field('grlxxmh.nama').enable();
				}else{
					edtgrlxxmh.field('grlxxmh.nama').disable();
				}
			}
		});

		edtgrlxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});

		edtgrlxxmh.dependent( 'grlxxmh.id_gctxxmh', function ( val, data, callback ) {
			// BEGIN load nama provinsi
			id_gctxxmh = edtgrlxxmh.field('grlxxmh.id_gctxxmh').val();
			autofillField('gctxxmh', id_gctxxmh, 'id_gpvxxmh');
			id_gpvxxmh = autofillData.id_gpvxxmh;
			autofillField('gpvxxmh', id_gpvxxmh, 'nama');
			gpvxxmh_nama = autofillData.nama;
			edtgrlxxmh.field('grlxxmh.id_gpvxxmh').val(gpvxxmh_nama);
			// END load nama provinsi

			return {}
		}, {event: 'keyup change'});
		
		edtgrlxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama       = edtgrlxxmh.field('grlxxmh.nama').val();
				alamat     = edtgrlxxmh.field('grlxxmh.alamat').val();
				id_gctxxmh = edtgrlxxmh.field('grlxxmh.id_gctxxmh').val();
				id_gpvxxmh = edtgrlxxmh.field('grlxxmh.id_gpvxxmh').val();
				id_gbuxxmh = edtgrlxxmh.field('grlxxmh.id_gbuxxmh').val();
				id_fpytmmh = edtgrlxxmh.field('grlxxmh.id_fpytmmh').val();
				email      = edtgrlxxmh.field('grlxxmh.email').val();

				validasiRequired(
					edtgrlxxmh,
					'grlxxmh',
					{
						'nama'      : nama,
						'alamat'    : alamat,
						'id_gctxxmh': id_gctxxmh,
						'id_gpvxxmh': id_gpvxxmh,
						'id_gbuxxmh': id_gbuxxmh,
						'id_fpytmmh': id_fpytmmh
					}
				);

				validasiEmail(
					edtgrlxxmh,
					'grlxxmh',
					{
						'email': email
					}
				);
				
			}
			
			if ( edtgrlxxmh.inError() ) {
				return false;
			}
		});

		edtgrlxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlxxmh.field('grlxxmh.finish_at').val(finish_at);
		});
		
		edtgrlxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgrlxxmh.on( 'close', function () {
			edtgrlxxmh.enable();
		} );
		
		tblgrlxxmh = $('#tblgrlxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/scuxxmh/scuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlxxmh = show_deleted_grlxxmh;
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
					targets: '_all'
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "grlxxmh.id",visible:false },
				{ data: "grlxxmh.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "gctxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_grlxxmh';
					$table       = 'tblgrlxxmh';
					$edt         = 'edtgrlxxmh';
					$show_status = '_grlxxmh';
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
				if ( data.grlxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.grlxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblgrlxxmh.searchPanes.container().appendTo('#spgrlxxmh');
		tblgrlxxmh.searchBuilder.container().appendTo( '#sbgrlxxmh' );
		
		tblgrlxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblgrllomd];
			CekInitHeaderHD(tblgrlxxmh, tbl_details);
		} );
		
		tblgrlxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('grlxxmh');
			id_gpvxxmh_old    = grlxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old    = grlxxmh_data.id_gbuxxmh;
			id_gctxxmh_old    = grlxxmh_data.id_gctxxmh;
			id_fpytmmh_old    = grlxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblgrllomd];
			CekSelectHeaderHD(tblgrlxxmh, tbl_details);

		} );
		
		tblgrlxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('grlxxmh');
			id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0

			// atur hak akses
			tbl_details = [tblgrllomd];
			CekDeselectHeaderHD(tblgrlxxmh, tbl_details);
		} );
		// END grlxxmh

		// BEGIN grllomd
		edtgrllomd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/scuxxmh/sculomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grllomd = show_deleted_grllomd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			table: "#tblgrllomd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "grllomd.start_at",
					name: "grllomd.start_at",
					type: "hidden"
				},	
				{
					label: "grllomd.finish_at",
					name: "grllomd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "grllomd",
					type: "hidden"
				},	
				{
					label: "grllomd.transaction_state",
					name: "grllomd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_grlxxmh",
					name: "grllomd.id_grlxxmh",
					type: "hidden"
				},	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "grllomd.nama"
				}, 
				{
					label: getTranslation('address') + "<sup class='text-danger'>*<sup>",
					name: "grllomd.alamat",
					type: "textarea"
				},
				{
					label: getTranslation('cityName') + "<sup class='text-danger'>*<sup>",
					name: "grllomd.id_gctxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_old,
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
					label: getTranslation('provinceName'),
					name: "grllomd.id_gpvxxmh",
					type: "readonly"
				}
			]
		} );
			
		edtgrllomd.on( 'preOpen', function( e, mode, action ) {
			edtgrllomd.field('grllomd.id_grlxxmh').val(id_grlxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrllomd.field('grllomd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgrllomd.rows().deselect();
			}
		});

		edtgrllomd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtgrllomd.dependent( 'grllomd.id_gctxxmh', function ( val, data, callback ) {
			// BEGIN load nama provinsi
			id_gctxxmh = edtgrllomd.field('grllomd.id_gctxxmh').val();
			autofillField('gctxxmh', id_gctxxmh, 'id_gpvxxmh');
			id_gpvxxmh = autofillData.id_gpvxxmh;
			autofillField('gpvxxmh', id_gpvxxmh, 'nama');
			gpvxxmh_nama = autofillData.nama;
			edtgrllomd.field('grllomd.id_gpvxxmh').val(gpvxxmh_nama);
			// END load nama provinsi

			return {}
		}, {event: 'keyup change'});
		
		edtgrllomd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				nama       = edtgrllomd.field('grllomd.nama').val();
				alamat     = edtgrllomd.field('grllomd.alamat').val();
				id_gctxxmh = edtgrllomd.field('grllomd.id_gctxxmh').val();
				id_gpvxxmh = edtgrllomd.field('grllomd.id_gpvxxmh').val();
				
				validasiRequired(
					edtgrllomd,
					'grllomd',
					{
						'nama'      : nama,
						'alamat'    : alamat,
						'id_gctxxmh': id_gctxxmh,
						'id_gpvxxmh': id_gpvxxmh
					}
				);
			}
			
			if ( edtgrllomd.inError() ) {
				return false;
			}
		});

		edtgrllomd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrllomd.field('grllomd.finish_at').val(finish_at);
		});
			
		edtgrllomd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgrllomd.on( 'close', function () {
			edtgrllomd.enable();
		} );
		
		tblgrllomd = $('#tblgrllomd').DataTable( {
			ajax: {
				url: "../../models/scuxxmh/sculomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grllomd = show_deleted_grllomd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "grllomd.id",visible:false },
				{ data: "grllomd.id_grlxxmh",visible:false },
				{ data: "grllomd.nama" },
				{ data: "grllomd.alamat" },
				{ data: "gctxxmh.nama" },
				{ data: "gpvxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_grllomd';
					$table       = 'tblgrllomd';
					$edt         = 'edtgrllomd';
					$show_status = '_grllomd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				
			},
			rowCallback: function( row, data, index ) {
			}
		} );		

		tblgrllomd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblgrllomd, 1 );
			CekDrawDetailHDFinal(tblgrlxxmh);
		} );

		tblgrllomd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('grllomd');
			id_gctxxmh_old   = grllomd_data.id_gctxxmh;
			id_gpvxxmh_old   = grllomd_data.id_gpvxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblgrllomd );
		} );

		tblgrllomd.on( 'deselect', function() {
			// reset variable standar framework
			siVarReset('grllomd');
			id_gctxxmh_old = 0;
			id_gpvxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblgrllomd );
		} );
		// END grllomd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
