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
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
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
    </div>

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabiimummd_1"> UoM</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabiimummd_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabiimummd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbliimummd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_iimxxmh</th>
										<th>UoM</th>
										<th>Konversi</th>
										<th>Terkecil</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabiimummd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbliimummd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_iimxxmh</th>
										<th>Kode</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iimxxmh/fn/iimxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiimxxmh, tbliimxxmh, show_deleted_iimxxmh = 0, id_iimxxmh;
	var edtiimummd, tbliimummd, show_deleted_iimummd = 0, id_iimummd;
	// ------------- end of default variable
	is_master_table = 1;

	var id_iittpmh_old = 0, id_iicctmh_old = 0, id_iiggrmh_old = 0;
	var id_iumxxmh_old = 0;

	$(document).ready(function() {
		//start datatables editor
		edtiimxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iimxxmh/iimxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iimxxmh = show_deleted_iimxxmh;
				}
			},
			table: "#tbliimxxmh",
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
					name: "iimxxmh.id_iittpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iittpmh/iittpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iittpmh_old: id_iittpmh_old,
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
					name: "iimxxmh.id_iicctmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iicctmh/iicctmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iicctmh_old: id_iicctmh_old,
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
					name: "iimxxmh.id_iiggrmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iiggrmh/iiggrmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iiggrmh_old: id_iiggrmh_old,
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
				edtiimxxmh.field('iimxxmh.kode').disable();
				edtiimxxmh.field('iimxxmh.nama').disable();
			}
		});

		edtiimxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtiimxxmh.dependent( 'iimxxmh.id_iittpmh', function ( val, data, callback ) {
			if (val == 1) {
				edtiimxxmh.field('iimxxmh.id_iiggrmh').label("Item Group <sup class='text-danger'>*<sup>")
				edtiimxxmh.field('iimxxmh.id_iicctmh').label("Item Category <sup class='text-danger'>*<sup>")
			} else {
				edtiimxxmh.field('iimxxmh.id_iiggrmh').label("Item Group")
				edtiimxxmh.field('iimxxmh.id_iicctmh').label("Item Category")
			}
			return {}
		}, {event: 'keyup change'});
		
		edtiimxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				// BEGIN of validasi iimxxmh.kode 
				kode = edtiimxxmh.field('iimxxmh.kode').val();
				if(!kode || kode == ''){
					edtiimxxmh.field('iimxxmh.kode').error( 'Wajib diisi!' );
				}
				
				// BEGIN of cek unik iimxxmh.kode 
				if(action == 'create'){
					id_iimxxmh = 0;
				}
				
				$.ajax( {
					url: '../../../helpers/validate_fn_unique.php',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						table_name: 'iimxxmh',
						nama_field: 'kode',
						nama_field_value: '"'+kode+'"',
						id_transaksi: id_iimxxmh
					},
					success: function ( json ) {
						if(json.data.count == 1){
							edtiimxxmh.field('iimxxmh.kode').error( 'Data tidak boleh kembar!' );
						}
					}
				} );
				// END of cek unik iimxxmh.kode 
				// END of validasi iimxxmh.kode

				// BEGIN of validasi iimxxmh.nama 
				nama = edtiimxxmh.field('iimxxmh.nama').val();
				if(!nama || nama == ''){
					edtiimxxmh.field('iimxxmh.nama').error( 'Wajib diisi!' );
				}
				
				// BEGIN of cek unik iimxxmh.nama 
				if(action == 'create'){
					id_iimxxmh = 0;
				}
				
				$.ajax( {
					url: '../../../helpers/validate_fn_unique.php',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						table_name: 'iimxxmh',
						nama_field: 'nama',
						nama_field_value: '"'+nama+'"',
						id_transaksi: id_iimxxmh
					},
					success: function ( json ) {
						if(json.data.count == 1){
							edtiimxxmh.field('iimxxmh.nama').error( 'Data tidak boleh kembar!' );
						}
					}
				} );
				// END of cek unik iimxxmh.nama 
				// END of validasi iimxxmh.nama

				// BEGIN of validasi iimxxmh.id_iittpmh 
				id_iittpmh = edtiimxxmh.field('iimxxmh.id_iittpmh').val();
				if(!id_iittpmh || id_iittpmh == ''){
					edtiimxxmh.field('iimxxmh.id_iittpmh').error( 'Wajib diisi!' );
				} 
				// END of validasi iimxxmh.id_iittpmh

				if (id_iittpmh == 1) {
					// BEGIN of validasi iimxxmh.id_iicctmh 
					id_iicctmh = edtiimxxmh.field('iimxxmh.id_iicctmh').val();
					if(!id_iicctmh || id_iicctmh == ''){
						edtiimxxmh.field('iimxxmh.id_iicctmh').error( 'Wajib diisi!' );
					} 
					// END of validasi iimxxmh.id_iicctmh

					// BEGIN of validasi iimxxmh.id_iiggrmh 
					id_iiggrmh = edtiimxxmh.field('iimxxmh.id_iiggrmh').val();
					if(!id_iiggrmh || id_iiggrmh == ''){
						edtiimxxmh.field('iimxxmh.id_iiggrmh').error( 'Wajib diisi!' );
					} 
					// END of validasi iimxxmh.id_iiggrmh
				}
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
		} );

		edtiimxxmh.on( 'close', function () {
			edtiimxxmh.enable();
		} );
		
		//start datatables
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
				{ data: "iittpmh.nama" },
				{ data: "iicctmh.nama" }
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
					$arr_buttons_approve 	= [];
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
		} );
		
		tbliimxxmh.on( 'select', function( e, dt, type, indexes ) {
			iimxxmh_data    	= tbliimxxmh.row( { selected: true } ).data().iimxxmh;
			id_iimxxmh      	= iimxxmh_data.id;
			id_transaksi_h 		= id_iimxxmh; // dipakai untuk general
			id_transaksi_log	= id_iimxxmh; // dipakai untuk general
			transaction_state   = iimxxmh_data.transaction_state;
			approval_state   	= iimxxmh_data.approval_state;
			is_nextprocess 		= iimxxmh_data.is_nextprocess;
			is_jurnal      		= iimxxmh_data.is_jurnal;

			id_iittpmh_old = iimxxmh_data.id_iittpmh;
			id_iicctmh_old = iimxxmh_data.id_iicctmh;
			id_iiggrmh_old = iimxxmh_data.id_iiggrmh;
			
			// atur hak akses
			tbl_details = [tbliimummd];
			CekSelectHeaderHD(tbliimxxmh, tbl_details);

		} );
		
		tbliimxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_iimxxmh = 0;

			id_iittpmh_old = 0, id_iicctmh_old = 0, id_iiggrmh_old = 0;

			// atur hak akses
			tbl_details = [tbliimummd];
			CekDeselectHeaderHD(tbliimxxmh, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
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
			formOptions: {
				main: {
					focus: 3
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
					name: "iimummd.jumlah_konversi"
				},
				{
					label: "Keterangan",
					name: "iimummd.keterangan",
					type: "textarea"
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
		});

		edtiimummd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtiimummd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi iimummd.id_iumxxmh 
				id_iumxxmh = edtiimummd.field('iimummd.id_iumxxmh').val();
				if(!id_iumxxmh || id_iumxxmh == ''){
					edtiimummd.field('iimummd.id_iumxxmh').error( 'Wajib diisi!' );
				}
				
				// BEGIN of cek unik iimummd.id_iumxxmh 
				if(action == 'create'){
					id_iimummd = 0;
				}
				
				$.ajax( {
					url: '../../../helpers/validate_fn_unique.php',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						table_name: 'iimummd',
						nama_field: 'id_iimxxmh,id_iumxxmh',
						nama_field_value: id_iimxxmh+','+id_iumxxmh,
						id_transaksi: id_iimummd
					},
					success: function ( json ) {
						if(json.data.count == 1){
							edtiimummd.field('iimummd.id_iumxxmh').error( 'Data tidak boleh kembar!' );
						}
					}
				} );
				// END of cek unik iimummd.id_iumxxmh 
				// END of validasi iimummd.id_iumxxmh 

				// BEGIN of validasi iimummd.jumlah_konversi 
				jumlah_konversi = edtiimummd.field('iimummd.jumlah_konversi').val();
				if(!jumlah_konversi || jumlah_konversi == ''){
					edtiimummd.field('iimummd.jumlah_konversi').error( 'Wajib diisi!' );
				}
				if(jumlah_konversi <= 0 ){
					edtiimummd.field('iimummd.jumlah_konversi').error( 'Inputan harus > 0' );
				}
				if(isNaN(jumlah_konversi) ){
					edtiimummd.field('iimummd.jumlah_konversi').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi iimummd.jumlah_konversi 
			}
			
			if ( edtiimummd.inError() ) {
				return false;
			}
		});

		edtiimummd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiimummd.field('iimummd.finish_at').val(finish_at);
		});
			
		edtiimummd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtiimummd.on( 'close', function () {
			edtiimummd.enable();
		} );
		
		//start datatables
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
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "iimummd.is_terkecil" ,
					render: $.fn.dataTable.render.yaTidak()
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
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					$arr_buttons_approve 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
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
			
			// atur hak akses
			CekSelectDetailHD(tbliimxxmh, tbliimummd );
		} );

		tbliimummd.on( 'deselect', function() {
			id_iimummd = 0;
			is_active_d = 0;
			id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tbliimxxmh, tbliimummd );
		} );

// --------- end _detail --------------- //		

	} );// end of document.ready
	
</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
