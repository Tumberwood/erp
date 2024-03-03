<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'scuxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sculomd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- start Custom Form Datatables Editor -->
				<div id="custom_scuxxmh">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.nama"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="scuxxmh.alamat"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.id_gctxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="scuxxmh.id_gpvxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.id_gbuxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="scuxxmh.id_fpytmmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.telepon"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="scuxxmh.whatsapp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.npwp"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="scuxxmh.nik"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.email"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="scuxxmh.fax"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="scuxxmh.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<div class="table-responsive">
                    <table id="tblscuxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kota</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabsculomd_1"> Lokasi Kirim</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsculomd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsculomd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_scuxxmh</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Kota</th>
										<th>Provinsi</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/scuxxmh/fn/scuxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtscuxxmh, tblscuxxmh, show_deleted_scuxxmh = 0, id_scuxxmh;
	var edtsculomd, tblsculomd, show_deleted_sculomd = 0, id_sculomd;
	// ------------- end of default variable
	is_master_table = 1;
	var is_need_generate_kode = 1;

	var id_gctxxmh = 0, id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_fbnxxmh_old = 0;
	
	

	$(document).ready(function() {
		//start datatables editor
		edtscuxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/scuxxmh/scuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_scuxxmh = show_deleted_scuxxmh;
				}
			},
			table: "#tblscuxxmh",
			template: '#custom_scuxxmh',
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},	
				{
					label: "scuxxmh.start_at",
					name: "scuxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "scuxxmh.finish_at",
					name: "scuxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "scuxxmh",
					type: "hidden"
				},	
				{
					label: "scuxxmh.transaction_state",
					name: "scuxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "scuxxmh.nama"
				},
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "scuxxmh.alamat",
					type: "textarea"
				},
				{
					label: "Kota <sup class='text-danger'>*<sup>",
					name: "scuxxmh.id_gctxxmh",
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
					label: "Provinsi <sup class='text-danger'>*<sup>",
					name: "scuxxmh.id_gpvxxmh",
					type: "readonly"
				},
				{
					label: "Badan Usaha <sup class='text-danger'>*<sup>",
					name: "scuxxmh.id_gbuxxmh",
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
					label: "Syarat Bayar <sup class='text-danger'>*<sup>",
					name: "scuxxmh.id_fpytmmh",
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
					label: "Telepon",
					name: "scuxxmh.telepon"
				},
				{
					label: "Whatsapp",
					name: "scuxxmh.whatsapp"
				},
				{
					label: "Fax",
					name: "scuxxmh.fax"
				},
				{
					label: "Email",
					name: "scuxxmh.email"
				},
				{
					label: "PKP",
					name: "scuxxmh.is_pkp",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "NIK",
					name: "scuxxmh.nik"
				},
				{
					label: "NPWP",
					name: "scuxxmh.npwp"
				},
				{
					label: "Keterangan",
					name: "scuxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtscuxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtscuxxmh.field('scuxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblscuxxmh.rows().deselect();
			}
		});

		edtscuxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		edtscuxxmh.dependent( 'scuxxmh.id_gctxxmh', function ( val, data, callback ) {
			// BEGIN load nama provinsi
			id_gctxxmh = edtscuxxmh.field('scuxxmh.id_gctxxmh').val();
			autofillField('gctxxmh', id_gctxxmh, 'id_gpvxxmh');
			id_gpvxxmh = autofillData.id_gpvxxmh;
			autofillField('gpvxxmh', id_gpvxxmh, 'nama');
			gpvxxmh_nama = autofillData.nama;
			edtscuxxmh.field('scuxxmh.id_gpvxxmh').val(gpvxxmh_nama);
			// END load nama provinsi

			return {}
		}, {event: 'keyup change'});
		
		edtscuxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama       = edtscuxxmh.field('scuxxmh.nama').val();
				alamat     = edtscuxxmh.field('scuxxmh.alamat').val();
				id_gctxxmh = edtscuxxmh.field('scuxxmh.id_gctxxmh').val();
				id_gpvxxmh = edtscuxxmh.field('scuxxmh.id_gpvxxmh').val();
				id_gbuxxmh = edtscuxxmh.field('scuxxmh.id_gbuxxmh').val();
				id_fpytmmh = edtscuxxmh.field('scuxxmh.id_fpytmmh').val();
				email      = edtscuxxmh.field('scuxxmh.email').val();

				validasiRequired(
					edtscuxxmh,
					'scuxxmh',
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
					edtscuxxmh,
					'scuxxmh',
					{
						'email': email
					}
				);
				
			}
			
			if ( edtscuxxmh.inError() ) {
				return false;
			}
		});

		edtscuxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtscuxxmh.field('scuxxmh.finish_at').val(finish_at);
		});
		
		edtscuxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtscuxxmh.on( 'close', function () {
			edtscuxxmh.enable();
		} );
		
		//start datatables
		tblscuxxmh = $('#tblscuxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/scuxxmh/scuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_scuxxmh = show_deleted_scuxxmh;
				}
			},
			order: [[ 1, "desc" ]],
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
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "scuxxmh.id",visible:false },
				{ data: "scuxxmh.kode" },
				{ data: "scuxxmh.nama" },
				{ data: "gctxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_scuxxmh';
					$table       = 'tblscuxxmh';
					$edt         = 'edtscuxxmh';
					$show_status = '_scuxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.scuxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.scuxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblscuxxmh.searchPanes.container().appendTo('#spscuxxmh');
			tblscuxxmh.searchBuilder.container().appendTo( '#sbscuxxmh' );
		
		tblscuxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblsculomd];
			CekInitHeaderHD(tblscuxxmh, tbl_details);
		} );
		
		tblscuxxmh.on( 'select', function( e, dt, type, indexes ) {
			scuxxmh_data      = tblscuxxmh.row( { selected: true } ).data().scuxxmh;
			id_scuxxmh        = scuxxmh_data.id;
			id_transaksi_h    = id_scuxxmh;                                           // dipakai untuk general
			id_transaksi_log  = id_scuxxmh;                                           // dipakai untuk general
			transaction_state = scuxxmh_data.transaction_state;
			approval_state    = scuxxmh_data.approval_state;
			is_nextprocess    = scuxxmh_data.is_nextprocess;
			is_jurnal         = scuxxmh_data.is_jurnal;
			id_gpvxxmh_old    = scuxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old    = scuxxmh_data.id_gbuxxmh;
			id_gctxxmh_old    = scuxxmh_data.id_gctxxmh;
			id_fpytmmh_old    = scuxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblsculomd];
			CekSelectHeaderHD(tblscuxxmh, tbl_details);

		} );
		
		tblscuxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_scuxxmh = 0, id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0

			// atur hak akses
			tbl_details = [tblsculomd];
			CekDeselectHeaderHD(tblscuxxmh, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edtsculomd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/scuxxmh/sculomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sculomd = show_deleted_sculomd;
					d.id_scuxxmh = id_scuxxmh;
				}
			},
			table: "#tblsculomd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "sculomd.start_at",
					name: "sculomd.start_at",
					type: "hidden"
				},	
				{
					label: "sculomd.finish_at",
					name: "sculomd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sculomd",
					type: "hidden"
				},	
				{
					label: "sculomd.transaction_state",
					name: "sculomd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_scuxxmh",
					name: "sculomd.id_scuxxmh",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "sculomd.nama"
				}, 
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "sculomd.alamat",
					type: "textarea"
				},
				{
					label: "Kota <sup class='text-danger'>*<sup>",
					name: "sculomd.id_gctxxmh",
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
					label: "Provinsi <sup class='text-danger'>*<sup>",
					name: "sculomd.id_gpvxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gpvxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gpvxxmh_old: id_gpvxxmh_old,
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
			
		edtsculomd.on( 'preOpen', function( e, mode, action ) {
			edtsculomd.field('sculomd.id_scuxxmh').val(id_scuxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsculomd.field('sculomd.start_at').val(start_at);
			
			if(action == 'create'){
				tblsculomd.rows().deselect();
			}
		});

		edtsculomd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtsculomd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				nama       = edtsculomd.field('sculomd.nama').val();
				alamat     = edtsculomd.field('sculomd.alamat').val();
				id_gctxxmh = edtsculomd.field('sculomd.id_gctxxmh').val();
				id_gpvxxmh = edtsculomd.field('sculomd.id_gpvxxmh').val();
				
				validasiRequired(
					edtsculomd,
					'sculomd',
					{
						'nama'      : nama,
						'alamat'    : alamat,
						'id_gctxxmh': id_gctxxmh,
						'id_gpvxxmh': id_gpvxxmh
					}
				);
			}
			
			if ( edtsculomd.inError() ) {
				return false;
			}
		});

		edtsculomd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsculomd.field('sculomd.finish_at').val(finish_at);
		});
			
		edtsculomd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtsculomd.on( 'close', function () {
			edtsculomd.enable();
		} );
		
		//start datatables
		tblsculomd = $('#tblsculomd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/scuxxmh/sculomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sculomd = show_deleted_sculomd;
					d.id_scuxxmh = id_scuxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1]
				}
			],
			columns: [
				{ data: "sculomd.id",visible:false },
				{ data: "sculomd.id_scuxxmh",visible:false },
				{ data: "sculomd.nama" },
				{ data: "sculomd.alamat" },
				{ data: "gctxxmh.nama" },
				{ data: "gpvxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sculomd';
					$table       = 'tblsculomd';
					$edt         = 'edtsculomd';
					$show_status = '_sculomd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					$arr_buttons_approve 	= ['noapprove'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblsculomd.searchPanes.container().appendTo('#spsculomd');
		tblsculomd.searchBuilder.container().appendTo( '#sbsculomd' );

		tblsculomd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblscuxxmh, tblsculomd, 'sculomd' );
			CekDrawDetailHDFinal(tblscuxxmh);
		} );

		tblsculomd.on( 'select', function( e, dt, type, indexes ) {
			data_sculomd 		= tblsculomd.row( { selected: true } ).data().sculomd;
			id_sculomd   		= data_sculomd.id;
			id_transaksi_d 		= id_sculomd; // dipakai untuk general
			id_transaksi_log 	= id_sculomd; // dipakai untuk log

			transaction_state_d   = data_sculomd.transaction_state;
			id_gctxxmh_old   = data_sculomd.id_gctxxmh;
			id_gpvxxmh_old   = data_sculomd.id_gpvxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblscuxxmh, tblsculomd );
		} );

		tblsculomd.on( 'deselect', function() {
			id_sculomd = 0;
			id_gctxxmh_old = 0;
			id_gpvxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblscuxxmh, tblsculomd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
