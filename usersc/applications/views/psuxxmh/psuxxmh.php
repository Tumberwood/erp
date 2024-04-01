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
    $nama_tabels_d[0] = 'grlbnmd';
    $nama_tabels_d[1] = 'grlctmd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- start Custom Form Datatables Editor -->
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
								<editor-field name="grlxxmh.fax"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="grlxxmh.email"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="grlxxmh.is_pkp"></editor-field>
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
								<editor-field name="grlxxmh.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<div class="table-responsive">
                    <table id="tblgrlxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabgrlbnmd_1"> Bank</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabgrlctmd"> Kontak</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabgrlbnmd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgrlbnmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_grlxxmh</th>
										<th>Bank</th>
										<th>No Rekening</th>
										<th>Nama Rekening</th>
										<th>Default</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div role="tabpanel" id="tabgrlctmd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgrlctmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_grlxxmh</th>
										<th>Nama</th>
										<th>Posisi</th>
										<th>Email</th>
										<th>Handphone</th>
									</tr>
								</thead>
							</table>
						</div>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/psuxxmh/fn/psuxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtgrlxxmh, tblgrlxxmh, show_deleted_grlxxmh = 0, id_grlxxmh;
	var edtgrlbnmd, tblgrlbnmd, show_deleted_grlbnmd = 0, id_grlbnmd;
	var edtgrlctmd, tblgrlctmd, show_deleted_grlctmd = 0, id_grlctmd;
	// ------------- end of default variable
	
	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_fbnxxmh_old = 0;

	// get tableRelation
	tableRelation('grlxxmh');

	$(document).ready(function() {

		// BEGIN grlxxmh
		edtgrlxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlxxmh = show_deleted_grlxxmh;
				}
			},
			table: "#tblgrlxxmh",
			template: "#custom_grlxxmh",
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
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "grlxxmh.nama"
				}, 	
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "grlxxmh.alamat",
					type: "textarea"
				},
				{
					label: "Kota <sup class='text-danger'>*<sup>",
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
					label: "Badan Usaha <sup class='text-danger'>*<sup>",
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
					label: "Provinsi <sup class='text-danger'>*<sup>",
					name: "grlxxmh.id_gpvxxmh",
					type: "readonly"
				},
				{
					label: "Telepon",
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
					label: "Email",
					name: "grlxxmh.email"
				},
				{
					label: "PKP",
					name: "grlxxmh.is_pkp",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "NIK",
					name: "grlxxmh.nik"
				},
				{
					label: "NPWP",
					name: "grlxxmh.npwp",
					type: "mask",
					mask: "00.000.000.0-000.000"
				},
				{
					label: "Syarat Bayar <sup class='text-danger'>*<sup>",
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
					label: "Keterangan",
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
				edtgrlxxmh.field('kategori_dokumen').val('is_supplier');
				edtgrlxxmh.field('kategori_dokumen_value').val(1);
				edtgrlxxmh.field('field_tanggal').val('start_at');

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
				telepon    = edtgrlxxmh.field('grlxxmh.telepon').val();
				whatsapp   = edtgrlxxmh.field('grlxxmh.whatsapp').val();
				fax        = edtgrlxxmh.field('grlxxmh.fax').val();
				email      = edtgrlxxmh.field('grlxxmh.email').val();
				npwp       = edtgrlxxmh.field('grlxxmh.npwp').val();
				nik        = edtgrlxxmh.field('grlxxmh.nik').val();

				validasiRequired(
					edtgrlxxmh,
					'grlxxmh',
					{
						'nama': nama,
						'alamat': alamat,
						'id_gctxxmh': id_gctxxmh,
						'id_gpvxxmh': id_gpvxxmh,
						'id_gbuxxmh': id_gbuxxmh,
						'id_fpytmmh': id_fpytmmh,
					}
				);

				validasiUnique(
					action,
					edtgrlxxmh,
					'grlxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_grlxxmh
				);

				validasiEmail(
					edtgrlxxmh,
					'grlxxmh',
					{
						'email': email
					}
				);
								
				
				// if (npwp != '') {
				// 	npwp_clean = npwp.replace(/[.-]/g,"");
				// 	if(npwp <= 0 ){
				// 		edtgrlxxmh.field('grlxxmh.npwp').error( 'Inputan harus 15 digit angka!' );
				// 	}
				// 	if(isNaN(npwp_clean) ){
				// 		edtgrlxxmh.field('grlxxmh.npwp').error( 'Inputan harus 15 digit angka!' );
				// 	}
				// 	npwp_length   = npwp_clean.length;
				// 	if(npwp_length != 15){
				// 		edtgrlxxmh.field('grlxxmh.npwp').error( 'Inputan harus 15 digit angka!' );
				// 	}
				// }
				
				
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
			tblgrlxxmh.ajax.reload(null,false);
		} );

		edtgrlxxmh.on( 'close', function () {
			edtgrlxxmh.enable();
		} );
		
		tblgrlxxmh = $('#tblgrlxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/psuxxmh/psuxxmh.php",
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
					targets: [0]
				}
			],
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
			tbl_details = [tblgrlbnmd, tblgrlctmd];
			CekInitHeaderHD(tblgrlxxmh, tbl_details);
		} );
		
		tblgrlxxmh.on( 'select', function( e, dt, type, indexes ) {
			grlxxmh_data    	= tblgrlxxmh.row( { selected: true } ).data().grlxxmh;
			id_grlxxmh      	= grlxxmh_data.id;
			id_transaksi_h 		= id_grlxxmh; // dipakai untuk general
			id_transaksi_log	= id_grlxxmh; // dipakai untuk general
			transaction_state   = grlxxmh_data.transaction_state;
			approval_state   	= grlxxmh_data.approval_state;
			is_nextprocess 		= grlxxmh_data.is_nextprocess;
			
			id_gpvxxmh_old      = grlxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      = grlxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      = grlxxmh_data.id_gctxxmh;
			id_fpytmmh_old      = grlxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblgrlbnmd, tblgrlctmd];
			CekSelectHeaderHD(tblgrlxxmh, tbl_details);

		} );
		
		tblgrlxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_grlxxmh = 0, id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old;

			// atur hak akses
			tbl_details = [tblgrlbnmd, tblgrlctmd];
			CekDeselectHeaderHD(tblgrlxxmh, tbl_details);
		} );
		
		// END grlxxmh

		// BEGIN grlbnmd
		edtgrlbnmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psubnmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlbnmd = show_deleted_grlbnmd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			table: "#tblgrlbnmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "grlbnmd.start_at",
					name: "grlbnmd.start_at",
					type: "hidden"
				},	
				{
					label: "grlbnmd.finish_at",
					name: "grlbnmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "grlbnmd",
					type: "hidden"
				},	
				{
					label: "grlbnmd.transaction_state",
					name: "grlbnmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_grlxxmh",
					name: "grlbnmd.id_grlxxmh",
					type: "hidden"
				},	
				{
					label: "Bank <sup class='text-danger'>*<sup>",
					name: "grlbnmd.id_fbnxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fbnxxmh/fbnxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_fbnxxmh_old: id_fbnxxmh_old,
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
					label: "Nama di Rekening<sup class='text-danger'>*<sup>",
					name: "grlbnmd.nama"
				}, 	
				{
					label: "Nomor Rekening<sup class='text-danger'>*<sup>",
					name: "grlbnmd.no_rek"
				}, 	
				{
					label: "Default Rekening",
					name: "grlbnmd.is_default",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
					name: "grlbnmd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtgrlbnmd.on( 'preOpen', function( e, mode, action ) {
			edtgrlbnmd.field('grlbnmd.id_grlxxmh').val(id_grlxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlbnmd.field('grlbnmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgrlbnmd.rows().deselect();
			}
		});

		edtgrlbnmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtgrlbnmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_fbnxxmh = edtgrlbnmd.field('grlbnmd.id_fbnxxmh').val();
				nama       = edtgrlbnmd.field('grlbnmd.nama').val();
				no_rek     = edtgrlbnmd.field('grlbnmd.no_rek').val();

				validasiRequired(
					edtgrlbnmd,
					'grlbnmd',
					{
						'id_fbnxxmh': id_fbnxxmh,
						'nama'      : nama,
						'no_rek'    : no_rek
					}
				);
				
				if (no_rek != '') {
					validasiNumber(
						edtgrlbnmd,
						'grlbnmd',
						{
							'no_rek': no_rek
						}
					);
				}
			}
			
			if ( edtgrlbnmd.inError() ) {
				return false;
			}
		});

		edtgrlbnmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlbnmd.field('grlbnmd.finish_at').val(finish_at);
		});
			
		edtgrlbnmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblgrlbnmd.rows().deselect();
			tblgrlbnmd.ajax.reload(null, false);
		} );

		edtgrlbnmd.on( 'close', function () {
			edtgrlbnmd.enable();
		} );
		
		tblgrlbnmd = $('#tblgrlbnmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/psuxxmh/psubnmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlbnmd = show_deleted_grlbnmd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1,4,5]
				}
			],
			responsive: false,
			// scrollX: true,
			columns: [
				{ data: "grlbnmd.id",visible:false },
				{ data: "grlbnmd.id_grlxxmh",visible:false },
				{ data: "fbnxxmh.nama" },
				{ data: "grlbnmd.no_rek" },
				{ data: "grlbnmd.nama" },
				{ 
					data: "grlbnmd.is_default",
					...renderYaTidak()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_grlbnmd';
					$table       = 'tblgrlbnmd';
					$edt         = 'edtgrlbnmd';
					$show_status = '_grlbnmd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblgrlbnmd.searchPanes.container().appendTo('#spgrlbnmd');
		tblgrlbnmd.searchBuilder.container().appendTo( '#sbgrlbnmd' );

		tblgrlbnmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblgrlxxmh, tblgrlbnmd, 'grlbnmd' );
			CekDrawDetailHDFinal(tblgrlxxmh);
		} );

		tblgrlbnmd.on( 'select', function( e, dt, type, indexes ) {
			data_grlbnmd 		= tblgrlbnmd.row( { selected: true } ).data().grlbnmd;
			id_grlbnmd   		= data_grlbnmd.id;
			id_transaksi_d 		= id_grlbnmd; // dipakai untuk general
			id_transaksi_log_d  = id_grlbnmd; // dipakai untuk log

			transaction_state_d   = data_grlbnmd.transaction_state;
			id_fbnxxmh_old   = data_grlbnmd.id_fbnxxmh;
			// atur hak akses
			CekSelectDetailHD(tblgrlxxmh, tblgrlbnmd );
		} );

		tblgrlbnmd.on( 'deselect', function() {
			id_grlbnmd = 0;
			id_fbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblgrlxxmh, tblgrlbnmd );
		} );

		// END grlbnmd

		// BEGIN grlctmd
		edtgrlctmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psuctmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlctmd = show_deleted_grlctmd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			table: "#tblgrlctmd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "grlctmd.start_at",
					name: "grlctmd.start_at",
					type: "hidden"
				},	
				{
					label: "grlctmd.finish_at",
					name: "grlctmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "grlctmd",
					type: "hidden"
				},	
				{
					label: "grlctmd.transaction_state",
					name: "grlctmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_grlxxmh",
					name: "grlctmd.id_grlxxmh",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "grlctmd.nama"
				}, 	
				{
					label: "Posisi <sup class='text-danger'>*<sup>",
					name: "grlctmd.posisi"
				},
				{
					label: "Email",
					name: "grlctmd.email"
				},
				{
					label: "Handphone",
					name: "grlctmd.handphone"
				}
			]
		} );
			
		edtgrlctmd.on( 'preOpen', function( e, mode, action ) {
			edtgrlctmd.field('grlctmd.id_grlxxmh').val(id_grlxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlctmd.field('grlctmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgrlctmd.rows().deselect();
			}
		});

		edtgrlctmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtgrlctmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// nama = edtgrlctmd.field('grlctmd.nama').val();
				// posisi = edtgrlctmd.field('grlctmd.posisi').val();
				// email = edtgrlctmd.field('grlctmd.email').val();
				// handphone = edtgrlctmd.field('grlctmd.handphone').val();

				// validasiRequired(
				// 	edtgrlctmd,
				// 	'grlctmd',
				// 	{
				// 		'nama': nama,
				// 		'posisi': posisi
				// 	}
				// );

				// validasiEmail(
				// 	edtgrlctmd,
				// 	'grlctmd',
				// 	{
				// 		'email': email
				// 	}
				// );

			}
			
			if ( edtgrlctmd.inError() ) {
				return false;
			}
		});

		edtgrlctmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlctmd.field('grlctmd.finish_at').val(finish_at);
		});
			
		edtgrlctmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblgrlctmd.rows().deselect();
			tblgrlctmd.ajax.reload(null, false);
		} );

		edtgrlctmd.on( 'close', function () {
			edtgrlctmd.enable();
		} );
		
		tblgrlctmd = $('#tblgrlctmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/psuxxmh/psuctmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlctmd = show_deleted_grlctmd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1,4,5]
				}
			],
			responsive: false,
			// scrollX: true,
			columns: [
				{ data: "grlctmd.id",visible:false },
				{ data: "grlctmd.id_grlxxmh",visible:false },
				{ data: "grlctmd.nama" },
				{ data: "grlctmd.posisi" },
				{ data: "grlctmd.email" },
				{ data: "grlctmd.handphone" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_grlctmd';
					$table       = 'tblgrlctmd';
					$edt         = 'edtgrlctmd';
					$show_status = '_grlctmd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblgrlctmd.searchPanes.container().appendTo('#spgrlctmd');
		tblgrlctmd.searchBuilder.container().appendTo( '#sbgrlctmd' );

		tblgrlctmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblgrlxxmh, tblgrlctmd, 'grlctmd' );
			CekDrawDetailHDFinal(tblgrlxxmh);
		} );

		tblgrlctmd.on( 'select', function( e, dt, type, indexes ) {
			data_grlctmd 		= tblgrlctmd.row( { selected: true } ).data().grlctmd;
			id_grlctmd   		= data_grlctmd.id;
			id_transaksi_d 		= id_grlctmd; // dipakai untuk general
			id_transaksi_log_d 	= id_grlctmd; // dipakai untuk log

			transaction_state_d  = data_grlctmd.transaction_state;
			id_fbnxxmh_old   = data_grlctmd.id_fbnxxmh;
			// atur hak akses
			CekSelectDetailHD(tblgrlxxmh, tblgrlctmd );
		} );

		tblgrlctmd.on( 'deselect', function() {
			id_grlctmd = 0;
			id_fbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblgrlxxmh, tblgrlctmd );
		} );

		// END grlctmd
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
