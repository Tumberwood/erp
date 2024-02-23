<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'psuxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'psubnmd';
    $nama_tabels_d[1] = 'psuctmd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- start Custom Form Datatables Editor -->
				<div id="custom_psuxxmh">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.nama"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="psuxxmh.alamat"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.id_gctxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="psuxxmh.id_gpvxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.id_gbuxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="psuxxmh.id_fpytmmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.telepon"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="psuxxmh.whatsapp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.fax"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="psuxxmh.email"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.is_pkp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.npwp"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="psuxxmh.nik"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="psuxxmh.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<!-- <div class="table-responsive"> -->
                    <table id="tblpsuxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kota</th>
                            </tr>
                        </thead>
                    </table>
                <!-- </div> -->
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabpsubnmd_1"> Bank</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabpsuctmd"> Kontak</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabpsubnmd_1" class="tab-pane active">
					<div class="panel-body">
						<!-- <div class="table-responsive"> -->
							<table id="tblpsubnmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_psuxxmh</th>
										<th>Bank</th>
										<th>No Rekening</th>
										<th>Nama Rekening</th>
										<th>Default</th>
									</tr>
								</thead>
							</table>
						<!-- </div> -->
					</div>
				</div>
				<div role="tabpanel" id="tabpsuctmd" class="tab-pane">
					<div class="panel-body">
						<!-- <div class="table-responsive"> -->
							<table id="tblpsuctmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_psuxxmh</th>
										<th>Nama</th>
										<th>Posisi</th>
										<th>Email</th>
										<th>Handphone</th>
									</tr>
								</thead>
							</table>
						<!-- </div> -->
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/psuxxmh/fn/psuxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpsuxxmh, tblpsuxxmh, show_deleted_psuxxmh = 0, id_psuxxmh;
	var edtpsubnmd, tblpsubnmd, show_deleted_psubnmd = 0, id_psubnmd;
	var edtpsuctmd, tblpsuctmd, show_deleted_psuctmd = 0, id_psuctmd;
	// ------------- end of default variable

	is_master_table = 1;
	is_need_generate_kode = 1;
	
	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_fbnxxmh_old = 0;

	$(document).ready(function() {

		//start datatables editor
		edtpsuxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psuxxmh = show_deleted_psuxxmh;
				}
			},
			table: "#tblpsuxxmh",
			template: "#custom_psuxxmh",
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
					label: "psuxxmh.start_at",
					name: "psuxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "psuxxmh.finish_at",
					name: "psuxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "psuxxmh",
					type: "hidden"
				},	
				{
					label: "psuxxmh.transaction_state",
					name: "psuxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "psuxxmh.nama"
				}, 	
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "psuxxmh.alamat",
					type: "textarea"
				},
				{
					label: "Kota <sup class='text-danger'>*<sup>",
					name: "psuxxmh.id_gctxxmh",
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
					name: "psuxxmh.id_gbuxxmh",
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
					name: "psuxxmh.id_gpvxxmh",
					type: "readonly"
				},
				{
					label: "Telepon",
					name: "psuxxmh.telepon"
				},
				{
					label: "Whatsapp",
					name: "psuxxmh.whatsapp"
				},
				{
					label: "Fax",
					name: "psuxxmh.fax"
				},
				{
					label: "Email",
					name: "psuxxmh.email"
				},
				{
					label: "PKP",
					name: "psuxxmh.is_pkp",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "NIK",
					name: "psuxxmh.nik"
				},
				{
					label: "NPWP",
					name: "psuxxmh.npwp",
					type: "mask",
					mask: "00.000.000.0-000.000"
				},
				{
					label: "Syarat Bayar <sup class='text-danger'>*<sup>",
					name: "psuxxmh.id_fpytmmh",
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
					name: "psuxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtpsuxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsuxxmh.field('psuxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblpsuxxmh.rows().deselect();
				edtpsuxxmh.field('kategori_dokumen').val('');
				edtpsuxxmh.field('kategori_dokumen_value').val('');
				edtpsuxxmh.field('field_tanggal').val('start_at');

				edtpsuxxmh.field('psuxxmh.nama').enable();

			}else if(action == 'edit'){

				if(transaction_state == 0){
					edtpsuxxmh.field('psuxxmh.nama').enable();
				}else{
					edtpsuxxmh.field('psuxxmh.nama').disable();
				}
			}
		});

		edtpsuxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		edtpsuxxmh.dependent( 'psuxxmh.id_gctxxmh', function ( val, data, callback ) {
			// BEGIN load nama provinsi
			id_gctxxmh = edtpsuxxmh.field('psuxxmh.id_gctxxmh').val();
			autofillField('gctxxmh', id_gctxxmh, 'id_gpvxxmh');
			id_gpvxxmh = autofillData.id_gpvxxmh;
			autofillField('gpvxxmh', id_gpvxxmh, 'nama');
			gpvxxmh_nama = autofillData.nama;
			edtpsuxxmh.field('psuxxmh.id_gpvxxmh').val(gpvxxmh_nama);
			// END load nama provinsi

			return {}
		}, {event: 'keyup change'});
		
		edtpsuxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama       = edtpsuxxmh.field('psuxxmh.nama').val();
				alamat     = edtpsuxxmh.field('psuxxmh.alamat').val();
				id_gctxxmh = edtpsuxxmh.field('psuxxmh.id_gctxxmh').val();
				id_gpvxxmh = edtpsuxxmh.field('psuxxmh.id_gpvxxmh').val();
				id_gbuxxmh = edtpsuxxmh.field('psuxxmh.id_gbuxxmh').val();
				id_fpytmmh = edtpsuxxmh.field('psuxxmh.id_fpytmmh').val();
				telepon    = edtpsuxxmh.field('psuxxmh.telepon').val();
				whatsapp   = edtpsuxxmh.field('psuxxmh.whatsapp').val();
				fax        = edtpsuxxmh.field('psuxxmh.fax').val();
				email      = edtpsuxxmh.field('psuxxmh.email').val();
				npwp       = edtpsuxxmh.field('psuxxmh.npwp').val();
				nik        = edtpsuxxmh.field('psuxxmh.nik').val();

				validasiRequired(
					edtpsuxxmh,
					'psuxxmh',
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
					edtpsuxxmh,
					'psuxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_psuxxmh
				);

				validasiEmail(
					edtpsuxxmh,
					'psuxxmh',
					{
						'email': email
					}
				);
								
				
				// if (npwp != '') {
				// 	npwp_clean = npwp.replace(/[.-]/g,"");
				// 	if(npwp <= 0 ){
				// 		edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus 15 digit angka!' );
				// 	}
				// 	if(isNaN(npwp_clean) ){
				// 		edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus 15 digit angka!' );
				// 	}
				// 	npwp_length   = npwp_clean.length;
				// 	if(npwp_length != 15){
				// 		edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus 15 digit angka!' );
				// 	}
				// }
				
				
			}
			
			if ( edtpsuxxmh.inError() ) {
				return false;
			}
		});

		edtpsuxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsuxxmh.field('psuxxmh.finish_at').val(finish_at);
		});
		
		edtpsuxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblpsuxxmh.ajax.reload(null,false);
		} );

		edtpsuxxmh.on( 'close', function () {
			edtpsuxxmh.enable();
		} );
		
		//start datatables
		tblpsuxxmh = $('#tblpsuxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/psuxxmh/psuxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psuxxmh = show_deleted_psuxxmh;
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
			columns: [
				{ data: "psuxxmh.id",visible:false },
				{ data: "psuxxmh.kode" },
				{ data: "psuxxmh.nama" },
				{ data: "gctxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_psuxxmh';
					$table       = 'tblpsuxxmh';
					$edt         = 'edtpsuxxmh';
					$show_status = '_psuxxmh';
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
				if ( data.psuxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.psuxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpsuxxmh.searchPanes.container().appendTo('#sppsuxxmh');
			tblpsuxxmh.searchBuilder.container().appendTo( '#sbpsuxxmh' );
		
		tblpsuxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblpsubnmd, tblpsuctmd];
			CekInitHeaderHD(tblpsuxxmh, tbl_details);
		} );
		
		tblpsuxxmh.on( 'select', function( e, dt, type, indexes ) {
			psuxxmh_data    	= tblpsuxxmh.row( { selected: true } ).data().psuxxmh;
			id_psuxxmh      	= psuxxmh_data.id;
			id_transaksi_h 		= id_psuxxmh; // dipakai untuk general
			id_transaksi_log	= id_psuxxmh; // dipakai untuk general
			transaction_state   = psuxxmh_data.transaction_state;
			approval_state   	= psuxxmh_data.approval_state;
			is_nextprocess 		= psuxxmh_data.is_nextprocess;
			
			id_gpvxxmh_old      = psuxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      = psuxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      = psuxxmh_data.id_gctxxmh;
			id_fpytmmh_old      = psuxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblpsubnmd, tblpsuctmd];
			CekSelectHeaderHD(tblpsuxxmh, tbl_details);

		} );
		
		tblpsuxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_psuxxmh = 0, id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old;

			// atur hak akses
			tbl_details = [tblpsubnmd, tblpsuctmd];
			CekDeselectHeaderHD(tblpsuxxmh, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edtpsubnmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psubnmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psubnmd = show_deleted_psubnmd;
					d.id_psuxxmh = id_psuxxmh;
				}
			},
			table: "#tblpsubnmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "psubnmd.start_at",
					name: "psubnmd.start_at",
					type: "hidden"
				},	
				{
					label: "psubnmd.finish_at",
					name: "psubnmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "psubnmd",
					type: "hidden"
				},	
				{
					label: "psubnmd.transaction_state",
					name: "psubnmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_psuxxmh",
					name: "psubnmd.id_psuxxmh",
					type: "hidden"
				},	
				{
					label: "Bank <sup class='text-danger'>*<sup>",
					name: "psubnmd.id_fbnxxmh",
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
					name: "psubnmd.nama"
				}, 	
				{
					label: "Nomor Rekening<sup class='text-danger'>*<sup>",
					name: "psubnmd.no_rek"
				}, 	
				{
					label: "Default Rekening",
					name: "psubnmd.is_default",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
					name: "psubnmd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtpsubnmd.on( 'preOpen', function( e, mode, action ) {
			edtpsubnmd.field('psubnmd.id_psuxxmh').val(id_psuxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsubnmd.field('psubnmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblpsubnmd.rows().deselect();
			}
		});

		edtpsubnmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtpsubnmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_fbnxxmh = edtpsubnmd.field('psubnmd.id_fbnxxmh').val();
				nama       = edtpsubnmd.field('psubnmd.nama').val();
				no_rek     = edtpsubnmd.field('psubnmd.no_rek').val();

				validasiRequired(
					edtpsubnmd,
					'psubnmd',
					{
						'id_fbnxxmh': id_fbnxxmh,
						'nama'      : nama,
						'no_rek'    : no_rek
					}
				);
				
				if (no_rek != '') {
					validasiNumber(
						edtpsubnmd,
						'psubnmd',
						{
							'no_rek': no_rek
						}
					);
				}
			}
			
			if ( edtpsubnmd.inError() ) {
				return false;
			}
		});

		edtpsubnmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsubnmd.field('psubnmd.finish_at').val(finish_at);
		});
			
		edtpsubnmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblpsubnmd.rows().deselect();
			tblpsubnmd.ajax.reload(null, false);
		} );

		edtpsubnmd.on( 'close', function () {
			edtpsubnmd.enable();
		} );
		
		//start datatables
		tblpsubnmd = $('#tblpsubnmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/psuxxmh/psubnmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psubnmd = show_deleted_psubnmd;
					d.id_psuxxmh = id_psuxxmh;
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
				{ data: "psubnmd.id",visible:false },
				{ data: "psubnmd.id_psuxxmh",visible:false },
				{ data: "fbnxxmh.nama" },
				{ data: "psubnmd.no_rek" },
				{ data: "psubnmd.nama" },
				{ 
					data: "psubnmd.is_default",
					...renderYaTidak()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_psubnmd';
					$table       = 'tblpsubnmd';
					$edt         = 'edtpsubnmd';
					$show_status = '_psubnmd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					$arr_buttons_approve 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblpsubnmd.searchPanes.container().appendTo('#sppsubnmd');
		tblpsubnmd.searchBuilder.container().appendTo( '#sbpsubnmd' );

		tblpsubnmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblpsuxxmh, tblpsubnmd, 'psubnmd' );
			CekDrawDetailHDFinal(tblpsuxxmh);
		} );

		tblpsubnmd.on( 'select', function( e, dt, type, indexes ) {
			data_psubnmd 		= tblpsubnmd.row( { selected: true } ).data().psubnmd;
			id_psubnmd   		= data_psubnmd.id;
			id_transaksi_d 		= id_psubnmd; // dipakai untuk general
			id_transaksi_log_d  = id_psubnmd; // dipakai untuk log

			transaction_state_d   = data_psubnmd.transaction_state;
			id_fbnxxmh_old   = data_psubnmd.id_fbnxxmh;
			// atur hak akses
			CekSelectDetailHD(tblpsuxxmh, tblpsubnmd );
		} );

		tblpsubnmd.on( 'deselect', function() {
			id_psubnmd = 0;
			is_active_d = 0;
			id_fbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblpsuxxmh, tblpsubnmd );
		} );

// --------- end _detail --------------- //		
// --------- start _detail --------------- //

		//start datatables editor
		edtpsuctmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psuctmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psuctmd = show_deleted_psuctmd;
					d.id_psuxxmh = id_psuxxmh;
				}
			},
			table: "#tblpsuctmd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "psuctmd.start_at",
					name: "psuctmd.start_at",
					type: "hidden"
				},	
				{
					label: "psuctmd.finish_at",
					name: "psuctmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "psuctmd",
					type: "hidden"
				},	
				{
					label: "psuctmd.transaction_state",
					name: "psuctmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_psuxxmh",
					name: "psuctmd.id_psuxxmh",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "psuctmd.nama"
				}, 	
				{
					label: "Posisi <sup class='text-danger'>*<sup>",
					name: "psuctmd.posisi"
				},
				{
					label: "Email",
					name: "psuctmd.email"
				},
				{
					label: "Handphone",
					name: "psuctmd.handphone"
				}
			]
		} );
			
		edtpsuctmd.on( 'preOpen', function( e, mode, action ) {
			edtpsuctmd.field('psuctmd.id_psuxxmh').val(id_psuxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsuctmd.field('psuctmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblpsuctmd.rows().deselect();
			}
		});

		edtpsuctmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtpsuctmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// nama = edtpsuctmd.field('psuctmd.nama').val();
				// posisi = edtpsuctmd.field('psuctmd.posisi').val();
				// email = edtpsuctmd.field('psuctmd.email').val();
				// handphone = edtpsuctmd.field('psuctmd.handphone').val();

				// validasiRequired(
				// 	edtpsuctmd,
				// 	'psuctmd',
				// 	{
				// 		'nama': nama,
				// 		'posisi': posisi
				// 	}
				// );

				// validasiEmail(
				// 	edtpsuctmd,
				// 	'psuctmd',
				// 	{
				// 		'email': email
				// 	}
				// );

			}
			
			if ( edtpsuctmd.inError() ) {
				return false;
			}
		});

		edtpsuctmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsuctmd.field('psuctmd.finish_at').val(finish_at);
		});
			
		edtpsuctmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblpsuctmd.rows().deselect();
			tblpsuctmd.ajax.reload(null, false);
		} );

		edtpsuctmd.on( 'close', function () {
			edtpsuctmd.enable();
		} );
		
		//start datatables
		tblpsuctmd = $('#tblpsuctmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/psuxxmh/psuctmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psuctmd = show_deleted_psuctmd;
					d.id_psuxxmh = id_psuxxmh;
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
				{ data: "psuctmd.id",visible:false },
				{ data: "psuctmd.id_psuxxmh",visible:false },
				{ data: "psuctmd.nama" },
				{ data: "psuctmd.posisi" },
				{ data: "psuctmd.email" },
				{ data: "psuctmd.handphone" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_psuctmd';
					$table       = 'tblpsuctmd';
					$edt         = 'edtpsuctmd';
					$show_status = '_psuctmd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					$arr_buttons_approve 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblpsuctmd.searchPanes.container().appendTo('#sppsuctmd');
		tblpsuctmd.searchBuilder.container().appendTo( '#sbpsuctmd' );

		tblpsuctmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblpsuxxmh, tblpsuctmd, 'psuctmd' );
			CekDrawDetailHDFinal(tblpsuxxmh);
		} );

		tblpsuctmd.on( 'select', function( e, dt, type, indexes ) {
			data_psuctmd 		= tblpsuctmd.row( { selected: true } ).data().psuctmd;
			id_psuctmd   		= data_psuctmd.id;
			id_transaksi_d 		= id_psuctmd; // dipakai untuk general
			id_transaksi_log_d 	= id_psuctmd; // dipakai untuk log

			transaction_state_d  = data_psuctmd.transaction_state;
			id_fbnxxmh_old   = data_psuctmd.id_fbnxxmh;
			// atur hak akses
			CekSelectDetailHD(tblpsuxxmh, tblpsuctmd );
		} );

		tblpsuctmd.on( 'deselect', function() {
			id_psuctmd = 0;
			is_active_d = 0;
			id_fbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblpsuxxmh, tblpsuctmd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
