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
    $nama_tabels_d[0] = 'psuxxtd';
    $nama_tabels_d[1] = 'psucttd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblpsuxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>Telepon</th>
                                <th>Whatsapp</th>
                                <th>Fax</th>
                                <th>Email</th>
                                <th>PKP</th>
                                <th>Keterangan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabpsuxxtd_1"> Bank</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabpsucttd"> Kontak</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabpsuxxtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpsuxxtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabpsucttd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpsucttd" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/psuxxmh/fn/psuxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpsuxxmh, tblpsuxxmh, show_deleted_psuxxmh = 0, id_psuxxmh;
	var edtpsuxxtd, tblpsuxxtd, show_deleted_psuxxtd = 0, id_psuxxtd;
	var edtpsucttd, tblpsucttd, show_deleted_psucttd = 0, id_psucttd;
	// ------------- end of default variable
	var id_gctxxmh_old = 0;
	var id_gbuxxmh_old = 0;
	var id_gpvxxmh_old = 0;
	var id_hbnxxmh_old = 0;
	var is_need_generate_kode = 1;

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
			fields: [ 
				{
					// untuk generate_kode
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					// untuk generate_kode
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					// untuk generate_kode
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
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "NIK",
					name: "psuxxmh.nik"
				},
				{
					label: "NPWP",
					name: "psuxxmh.npwp"
				},
				{
					label: "Default Pembayaran",
					name: "psuxxmh.default_pembayaran",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "COD", "value": "COD" },
						{ "label": "DP", "value": "DP" },
						{ "label": "N14", "value": "N14" },
						{ "label": "Net21", "value": "Net21" },
						{ "label": "Net30", "value": "Net30" },
						{ "label": "Net45", "value": "Net45" }
					]
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
			}
		});

		edtpsuxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtpsuxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				telepon = edtpsuxxmh.field('psuxxmh.telepon').val();
				if (telepon != '') {
					if(telepon <= 0 ){
						edtpsuxxmh.field('psuxxmh.telepon').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(telepon) ){
						edtpsuxxmh.field('psuxxmh.telepon').error( 'Inputan harus berupa Angka!' );
					}
				}

				whatsapp = edtpsuxxmh.field('psuxxmh.whatsapp').val();
				if (whatsapp != '') {
					if(whatsapp <= 0 ){
						edtpsuxxmh.field('psuxxmh.whatsapp').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(whatsapp) ){
						edtpsuxxmh.field('psuxxmh.whatsapp').error( 'Inputan harus berupa Angka!' );
					}
				}

				fax = edtpsuxxmh.field('psuxxmh.fax').val();
				if (fax != '') {
					if(fax <= 0 ){
						edtpsuxxmh.field('psuxxmh.fax').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(fax) ){
						edtpsuxxmh.field('psuxxmh.fax').error( 'Inputan harus berupa Angka!' );
					}
				}

				npwp = edtpsuxxmh.field('psuxxmh.npwp').val();
				if (npwp != '') {
					if(npwp <= 0 ){
						edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(npwp) ){
						edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus berupa Angka!' );
					}
				}

				nik = edtpsuxxmh.field('psuxxmh.nik').val();
				if (nik != '') {
					if(nik <= 0 ){
						edtpsuxxmh.field('psuxxmh.nik').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(nik) ){
						edtpsuxxmh.field('psuxxmh.nik').error( 'Inputan harus berupa Angka!' );
					}
				}

				npwp = edtpsuxxmh.field('psuxxmh.npwp').val();
				if (npwp != '') {
					if(npwp <= 0 ){
						edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(npwp) ){
						edtpsuxxmh.field('psuxxmh.npwp').error( 'Inputan harus berupa Angka!' );
					}
				}

				id_gpvxxmh = edtpsuxxmh.field('psuxxmh.id_gpvxxmh').val();
				if(!id_gpvxxmh || id_gpvxxmh == ''){
					edtpsuxxmh.field('psuxxmh.id_gpvxxmh').error( 'Wajib diisi!' );
				}

				id_gbuxxmh = edtpsuxxmh.field('psuxxmh.id_gbuxxmh').val();
				if(!id_gbuxxmh || id_gbuxxmh == ''){
					edtpsuxxmh.field('psuxxmh.id_gbuxxmh').error( 'Wajib diisi!' );
				}

				id_gctxxmh = edtpsuxxmh.field('psuxxmh.id_gctxxmh').val();
				if(!id_gctxxmh || id_gctxxmh == ''){
					edtpsuxxmh.field('psuxxmh.id_gctxxmh').error( 'Wajib diisi!' );
				}

				alamat = edtpsuxxmh.field('psuxxmh.alamat').val();
				if(!alamat || alamat == ''){
					edtpsuxxmh.field('psuxxmh.alamat').error( 'Wajib diisi!' );
				}

				nama = edtpsuxxmh.field('psuxxmh.nama').val();
				if(!nama || nama == ''){
					edtpsuxxmh.field('psuxxmh.nama').error( 'Wajib diisi!' );
				}
				
				// BEGIN of cek unik psuxxmh.nama 
				if(action == 'create'){
					id_psuxxmh = 0;
				}
				
				$.ajax( {
					url: '../../../helpers/validate_fn_unique.php',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						table_name: 'psuxxmh',
						nama_field: 'nama',
						nama_field_value: '"'+nama+'"',
						id_transaksi: id_psuxxmh
					},
					success: function ( json ) {
						if(json.data.count == 1){
							edtpsuxxmh.field('psuxxmh.nama').error( 'Data tidak boleh kembar!' );
						}
					}
				} );
				// END of cek unik psuxxmh.nama 
				// END of validasi psuxxmh.nama
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
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblpsuxxmh.ajax.reload(null,false);
		} );

		edtpsuxxmh.on( 'close', function () {
			edtpsuxxmh.enable();
		} );
		
		//start datatables
		tblpsuxxmh = $('#tblpsuxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
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
				{ data: "psuxxmh.alamat" },
				{ data: "gctxxmh.nama" },
				{ data: "gpvxxmh.nama" },
				{ data: "psuxxmh.telepon" },
				{ data: "psuxxmh.whatsapp" },
				{ data: "psuxxmh.fax" },
				{ data: "psuxxmh.email" },
				{ 
					data: "psuxxmh.is_pkp",
					render: function (data){ 	// render model tulisan
						if (data == 1){
							return 'Ya';
						}else if(data == 0){
							return 'Tidak';
						}else{
							return '';
						}
					}
				},
				{ data: "psuxxmh.keterangan" }
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
			tbl_details = [tblpsuxxtd, tblpsucttd];
			CekInitHeaderHD(tblpsuxxmh, tbl_details);
		} );
		
		tblpsuxxmh.on( 'select', function( e, dt, type, indexes ) {
			psuxxmh_data    		= tblpsuxxmh.row( { selected: true } ).data().psuxxmh;
			id_psuxxmh      		= psuxxmh_data.id;
			id_transaksi_h 		= id_psuxxmh; // dipakai untuk general
			id_transaksi_log	= id_psuxxmh; // dipakai untuk general
			transaction_state   = psuxxmh_data.transaction_state;
			approval_state   	= psuxxmh_data.approval_state;
			is_nextprocess 		= psuxxmh_data.is_nextprocess;
			is_jurnal      		= psuxxmh_data.is_jurnal;
			id_gpvxxmh_old      		= psuxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      		= psuxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      		= psuxxmh_data.id_gctxxmh;
			
			// atur hak akses
			tbl_details = [tblpsuxxtd, tblpsucttd];
			CekSelectHeaderHD(tblpsuxxmh, tbl_details);

		} );
		
		tblpsuxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_psuxxmh = 0;
			id_gctxxmh_old = 0;
			id_gbuxxmh_old = 0;
			id_gpvxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblpsuxxtd, tblpsucttd];
			CekDeselectHeaderHD(tblpsuxxmh, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edtpsuxxtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psuxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psuxxtd = show_deleted_psuxxtd;
					d.id_psuxxmh = id_psuxxmh;
				}
			},
			table: "#tblpsuxxtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "psuxxtd.start_at",
					name: "psuxxtd.start_at",
					type: "hidden"
				},	
				{
					label: "psuxxtd.finish_at",
					name: "psuxxtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "psuxxtd",
					type: "hidden"
				},	
				{
					label: "psuxxtd.transaction_state",
					name: "psuxxtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_psuxxmh",
					name: "psuxxtd.id_psuxxmh",
					type: "hidden"
				},	
				{
					label: "Bank <sup class='text-danger'>*<sup>",
					name: "psuxxtd.id_hbnxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hbnxxmh/hbnxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hbnxxmh_old: id_hbnxxmh_old,
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
					name: "psuxxtd.nama"
				}, 	
				{
					label: "Nomor Rekening<sup class='text-danger'>*<sup>",
					name: "psuxxtd.no_rek"
				}, 	
				{
					label: "Default Rekening",
					name: "psuxxtd.is_default",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
					name: "psuxxtd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtpsuxxtd.on( 'preOpen', function( e, mode, action ) {
			edtpsuxxtd.field('psuxxtd.id_psuxxmh').val(id_psuxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsuxxtd.field('psuxxtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblpsuxxtd.rows().deselect();
			}
		});

		edtpsuxxtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtpsuxxtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi psuxxtd.id_hbnxxmh 
				id_hbnxxmh = edtpsuxxtd.field('psuxxtd.id_hbnxxmh').val();
				if(!id_hbnxxmh || id_hbnxxmh == ''){
					edtpsuxxtd.field('psuxxtd.id_hbnxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi psuxxtd.id_hbnxxmh 

				// BEGIN of validasi psuxxtd.nama 
				nama = edtpsuxxtd.field('psuxxtd.nama').val();
				if(!nama || nama == ''){
					edtpsuxxtd.field('psuxxtd.nama').error( 'Wajib diisi!' );
				}
				// END of validasi psuxxtd.nama 
				
				no_rek = edtpsuxxtd.field('psuxxtd.no_rek').val();
				if(!no_rek || no_rek == ''){
					edtpsuxxtd.field('psuxxtd.no_rek').error( 'Wajib diisi!' );
				}
				if (no_rek != '') {
					if(no_rek <= 0 ){
						edtpsuxxtd.field('psuxxtd.no_rek').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(no_rek) ){
						edtpsuxxtd.field('psuxxtd.no_rek').error( 'Inputan harus berupa Angka!' );
					}
				}
			}
			
			if ( edtpsuxxtd.inError() ) {
				return false;
			}
		});

		edtpsuxxtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsuxxtd.field('psuxxtd.finish_at').val(finish_at);
		});
			
		edtpsuxxtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtpsuxxtd.on( 'close', function () {
			edtpsuxxtd.enable();
		} );
		
		//start datatables
		tblpsuxxtd = $('#tblpsuxxtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/psuxxmh/psuxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psuxxtd = show_deleted_psuxxtd;
					d.id_psuxxmh = id_psuxxmh;
				}
			},
			order: [[ 2, "desc" ]],
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
				{ data: "psuxxtd.id",visible:false },
				{ data: "psuxxtd.id_psuxxmh",visible:false },
				{ data: "hbnxxmh.nama" },
				{ data: "psuxxtd.nama" },
				{ data: "psuxxtd.no_rek" },
				{ 
					data: "psuxxtd.is_default",
					render: function (data){ 	// render model tulisan
						if (data == 1){
							return 'Ya';
						}else if(data == 0){
							return 'Tidak';
						}
					}
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_psuxxtd';
					$table       = 'tblpsuxxtd';
					$edt         = 'edtpsuxxtd';
					$show_status = '_psuxxtd';
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

		tblpsuxxtd.searchPanes.container().appendTo('#sppsuxxtd');
		tblpsuxxtd.searchBuilder.container().appendTo( '#sbpsuxxtd' );

		tblpsuxxtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblpsuxxmh, tblpsuxxtd, 'psuxxtd' );
			CekDrawDetailHDFinal(tblpsuxxmh);
		} );

		tblpsuxxtd.on( 'select', function( e, dt, type, indexes ) {
			data_psuxxtd 		= tblpsuxxtd.row( { selected: true } ).data().psuxxtd;
			id_psuxxtd   		= data_psuxxtd.id;
			id_transaksi_d 		= id_psuxxtd; // dipakai untuk general
			id_transaksi_log 	= id_psuxxtd; // dipakai untuk log

			transaction_state_d   = data_psuxxtd.transaction_state;
			id_hbnxxmh_old   = data_psuxxtd.id_hbnxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblpsuxxmh, tblpsuxxtd );
		} );

		tblpsuxxtd.on( 'deselect', function() {
			id_psuxxtd = 0;
			is_active_d = 0;
			id_hbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblpsuxxmh, tblpsuxxtd );
		} );

// --------- end _detail --------------- //		
// --------- start _detail --------------- //

		//start datatables editor
		edtpsucttd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/psuxxmh/psucttd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psucttd = show_deleted_psucttd;
					d.id_psuxxmh = id_psuxxmh;
				}
			},
			table: "#tblpsucttd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "psucttd.start_at",
					name: "psucttd.start_at",
					type: "hidden"
				},	
				{
					label: "psucttd.finish_at",
					name: "psucttd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "psucttd",
					type: "hidden"
				},	
				{
					label: "psucttd.transaction_state",
					name: "psucttd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_psuxxmh",
					name: "psucttd.id_psuxxmh",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "psucttd.nama"
				}, 	
				{
					label: "Posisi <sup class='text-danger'>*<sup>",
					name: "psucttd.posisi"
				},
				{
					label: "Email",
					name: "psucttd.email"
				},
				{
					label: "Handphone",
					name: "psucttd.handphone"
				}
			]
		} );
			
		edtpsucttd.on( 'preOpen', function( e, mode, action ) {
			edtpsucttd.field('psucttd.id_psuxxmh').val(id_psuxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsucttd.field('psucttd.start_at').val(start_at);
			
			if(action == 'create'){
				tblpsucttd.rows().deselect();
			}
		});

		edtpsucttd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtpsucttd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				nama = edtpsucttd.field('psucttd.nama').val();
				if(!nama || nama == ''){
					edtpsucttd.field('psucttd.nama').error( 'Wajib diisi!' );
				}

				posisi = edtpsucttd.field('psucttd.posisi').val();
				if(!posisi || posisi == ''){
					edtpsucttd.field('psucttd.posisi').error( 'Wajib diisi!' );
				}

				var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				email = edtpsucttd.field('psucttd.email').val();
				if(email != ''){
					if (emailRegex.test(email)) {
						
					} else {
						edtpsucttd.field('psucttd.email').error( 'Format Email Salah!' );
					}
				}

				handphone = edtpsucttd.field('psucttd.handphone').val();
				if(handphone != ''){
					// validasi min atau max angka
					if(handphone <= 0 ){
						edtpsucttd.field('psucttd.handphone').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(handphone) ){
						edtpsucttd.field('psucttd.handphone').error( 'Inputan harus berupa Angka!' );
					}
				}
			}
			
			if ( edtpsucttd.inError() ) {
				return false;
			}
		});

		edtpsucttd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpsucttd.field('psucttd.finish_at').val(finish_at);
		});
			
		edtpsucttd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtpsucttd.on( 'close', function () {
			edtpsucttd.enable();
		} );
		
		//start datatables
		tblpsucttd = $('#tblpsucttd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/psuxxmh/psucttd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_psucttd = show_deleted_psucttd;
					d.id_psuxxmh = id_psuxxmh;
				}
			},
			order: [[ 2, "desc" ]],
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
				{ data: "psucttd.id",visible:false },
				{ data: "psucttd.id_psuxxmh",visible:false },
				{ data: "psucttd.nama" },
				{ data: "psucttd.posisi" },
				{ data: "psucttd.email" },
				{ data: "psucttd.handphone" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_psucttd';
					$table       = 'tblpsucttd';
					$edt         = 'edtpsucttd';
					$show_status = '_psucttd';
					$table_name  = $nama_tabels_d[1];

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

		tblpsucttd.searchPanes.container().appendTo('#sppsucttd');
		tblpsucttd.searchBuilder.container().appendTo( '#sbpsucttd' );

		tblpsucttd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblpsuxxmh, tblpsucttd, 'psucttd' );
			CekDrawDetailHDFinal(tblpsuxxmh);
		} );

		tblpsucttd.on( 'select', function( e, dt, type, indexes ) {
			data_psucttd 		= tblpsucttd.row( { selected: true } ).data().psucttd;
			id_psucttd   		= data_psucttd.id;
			id_transaksi_d 		= id_psucttd; // dipakai untuk general
			id_transaksi_log 	= id_psucttd; // dipakai untuk log

			transaction_state_d   = data_psucttd.transaction_state;
			id_hbnxxmh_old   = data_psucttd.id_hbnxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblpsuxxmh, tblpsucttd );
		} );

		tblpsucttd.on( 'deselect', function() {
			id_psucttd = 0;
			is_active_d = 0;
			id_hbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblpsuxxmh, tblpsucttd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
