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
								<editor-field name="files[].id"></editor-field>
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
							<th>Kode</th>
							<th>Nama</th>
							<th>Tipe</th>
							<th>Kategori</th>
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
									<th rowspan=2>Konversi</th>
									<th colspan=4>UoM Purpose</th>
								</tr>
								<tr>
									<th>Inventory</th>
									<th>Base</th>
									<th>Buy</th>
									<th>Sell</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iimxxmh/fn/iimxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiimxxmh, tbliimxxmh, show_deleted_iimxxmh = 0, id_iimxxmh;
	var edtiimummd, tbliimummd, show_deleted_iimummd = 0, id_iimummd;
	var edtiimummd_copyfrom;
	// ------------- end of default variable

	var id_iitxxmh = 0, id_iitxxmh_old = 0, id_iicxxmh_old = 0, id_iigxxmh = 0, id_iigxxmh_old = 0, id_iigx2mh_old = 0, id_iibxxmh_old = 0, id_iimxxmh_old = 0;
	
	var id_iumxxmh_old = 0;
	var is_default_old = 0;
	var is_iumxxmh_beli = 0, is_iumxxmh_beli_old = 0, is_iumxxmh_jual = 0, is_iumxxmh_jual_old = 0;
	var is_update_iumxxmh_default = 0, is_update_iumxxmh_beli = 0, is_update_iumxxmh_jual  = 0;

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
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "iimxxmh.kode"
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
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
					label: "Item Group 2 <sup class='text-danger'>*<sup>",
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
					label: "Item Brand",
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
					name: "files[].id",
					type: "uploadMany",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtiimxxmh.file( 'files', fileId ).web_path+'" target="_blank">'+ edtiimxxmh.file( 'files', fileId ).filename + '</a>'; 
						}
					},
				},	
				{
					label: "Keterangan",
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
		});

		edtiimxxmh.dependent( 'iimxxmh.id_iitxxmh', function ( val, data, callback ) {
			if (val == 1) {
				edtiimxxmh.field('iimxxmh.id_iicxxmh').label("Item Category <sup class='text-danger'>*<sup>");
				edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group <sup class='text-danger'>*<sup>");
				edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand <sup class='text-danger'>*<sup>");
			} else {
				edtiimxxmh.field('iimxxmh.id_iicxxmh').label("Item Category");
				edtiimxxmh.field('iimxxmh.id_iigxxmh').label("Item Group");
				edtiimxxmh.field('iimxxmh.id_iibxxmh').label("Item Brand");
			}
			return {}
		}, {event: 'keyup change'});
		
		edtiimxxmh.dependent( 'iimxxmh.id_iigxxmh', function ( val, data, callback ) {
			id_iigxxmh = val;
			// code here
			return {}
		}, {event: 'keyup change'});

		edtiimxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtiimxxmh.field('iimxxmh.kode').val();
				nama = edtiimxxmh.field('iimxxmh.nama').val();
				id_iitxxmh = edtiimxxmh.field('iimxxmh.id_iitxxmh').val();

				validasiRequired(
					edtiimxxmh,
					'iimxxmh',
					{
						'kode': kode,
						'nama': nama,
						'id_iitxxmh': id_iitxxmh
					}
				);

				if (id_iitxxmh == 1) {
					id_iicxxmh = edtiimxxmh.field('iimxxmh.id_iicxxmh').val();
					id_iigxxmh = edtiimxxmh.field('iimxxmh.id_iigxxmh').val();
					id_iibxxmh = edtiimxxmh.field('iimxxmh.id_iibxxmh').val();
					
					validasiRequired(
						edtiimxxmh, 
						"iimxxmh", 
						{
							"id_iicxxmh": id_iicxxmh, 
							"id_iigxxmh": id_iigxxmh, 
							"id_iibxxmh": id_iibxxmh
						}
					);
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
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "iimxxmh.id",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iitxxmh.nama" },
				{ data: "iicxxmh.nama" }
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
			tbl_details = [tbliimummd];
			CekInitHeaderHD(tbliimxxmh, tbl_details);

			tbliimummd.button( 'btnCopyFrom:name' ).disable();
		} );
		
		tbliimxxmh.on( 'select', function( e, dt, type, indexes ) {
			iimxxmh_data    	= tbliimxxmh.row( { selected: true } ).data().iimxxmh;
			id_iimxxmh      	= iimxxmh_data.id;
			id_transaksi_h 		= id_iimxxmh; // dipakai untuk general
			id_transaksi_log	= id_iimxxmh; // dipakai untuk general
			transaction_state   = iimxxmh_data.transaction_state;
			approval_state   	= iimxxmh_data.approval_state;
			is_nextprocess 		= iimxxmh_data.is_nextprocess;

			id_iitxxmh_old = iimxxmh_data.id_iitxxmh;
			id_iicxxmh_old = iimxxmh_data.id_iicxxmh;
			id_iigxxmh     = iimxxmh_data.id_iigxxmh;
			id_iigxxmh_old = iimxxmh_data.id_iigxxmh;
			id_iigx2mh_old = iimxxmh_data.id_iigx2mh;
			id_iimxxmh_old = iimxxmh_data.id;
			
			// atur hak akses
			tbl_details = [tbliimummd];
			CekSelectHeaderHD(tbliimxxmh, tbl_details);

			tbliimummd.button( 'btnCopyFrom:name' ).enable();

		} );
		
		tbliimxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_iimxxmh = 0;

			id_iitxxmh_old = 0, id_iicxxmh_old = 0, id_iigxxmh = 0, id_iigxxmh_old = 0, id_iigx2mh_old = 0, id_iimxxmh_old = 0;

			// atur hak akses
			tbl_details = [tbliimummd];
			CekDeselectHeaderHD(tbliimxxmh, tbl_details);

			tbliimummd.button( 'btnCopyFrom:name' ).disable();
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
					label: "Keterangan",
					name: "iimummd.keterangan",
					type: "textarea"
				},
				{
					label: "Net Weight",
					name: "iimummd.nw"
				},
				{
					label: "Gross Weight",
					name: "iimummd.gw"
				},
				{
					label: "Length",
					name: "iimummd.panjang"
				},
				{
					label: "Width",
					name: "iimummd.lebar"
				},
				{
					label: "Height",
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
				}
				
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

			if(action == 'create'){
				is_default_old = 0;
				is_iumxxmh_beli_old = 0
				is_iumxxmh_jual_old = 0
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
			
			if(action == 'create'){
				tbliimummd.rows().deselect();
			}
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

		edtiimummd_copyfrom.on( 'postSubmit', function (e, json, data, action, xhr) {
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
					...renderYaTidak()
				},
				{ 
					data: "iimummd.is_default" ,
					...renderYaTidak()
				},
				{ 
					data: "iimummd.is_iumxxmh_beli" ,
					...renderYaTidak()
				},
				{ 
					data: "iimummd.is_iumxxmh_jual" ,
					...renderYaTidak()
				}
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
					name: 'btnCopyFrom', 
					editor: edtiimummd_copyfrom, 
					text: '<i class="fa fa-google"></i>', 
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
			cek_c_detail= 1;
			CekDrawDetailHD(tbliimxxmh, tbliimummd, 'iimummd' );
			CekDrawDetailHDFinal(tbliimxxmh);

		} );

		tbliimummd.on( 'select', function( e, dt, type, indexes ) {
			data_iimummd 		= tbliimummd.row( { selected: true } ).data().iimummd;
			id_iimummd   		= data_iimummd.id;
			id_transaksi_d 		= id_iimummd; // dipakai untuk general
			id_transaksi_log 	= id_iimummd; // dipakai untuk log

			transaction_state_d   = data_iimummd.transaction_state;

			id_iumxxmh_old = data_iimummd.id_iumxxmh;
			is_default_old = data_iimummd.is_default;
			is_iumxxmh_beli_old = data_iimummd.is_iumxxmh_beli;
			is_iumxxmh_jual_old = data_iimummd.is_iumxxmh_jual;
			
			// atur hak akses
			CekSelectDetailHD(tbliimxxmh, tbliimummd );

		} );

		tbliimummd.on( 'deselect', function() {
			id_iimummd = 0;
			id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tbliimxxmh, tbliimummd );

		} );

		// END iimummd

	} );// end of document.ready
	
</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
<!--  -->