<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'rbmxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'rbmittd';
    $nama_tabels_d[1] = 'rbmwptd';
    
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblrbmxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>R</th>
                                <th>Nama</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabrbmittd"> Items</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabrbmwptd"> Work Process</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabrbmittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblrbmittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_rbmxxth</th>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>UoM</th>
										<th>Q</th>
									</tr>
								</thead>
							</table>
						</div>

					</div>
				</div>
				<div role="tabpanel" id="tabrbmwptd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblrbmwptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_rbmxxth</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Cycle Time</th>
										<th>Keterangan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/rbmxxth/fn/rbmxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtrbmxxth, tblrbmxxth, show_deleted_rbmxxth = 0, id_rbmxxth;
	var edtrbmittd, tblrbmittd, show_deleted_rbmittd = 0, id_rbmittd;
	var edtrbmwptd, tblrbmwptd, show_deleted_rbmwptd = 0, id_rbmwptd;
	// ------------- end of default variable

	is_need_generate_kode = 1;

	id_iimxxmh_old = 0, revisi_ke = 0;
	id_iimxxmh_rm = 0, id_iimxxmh_rm_old = 0, id_iumxxmh_unit_old = 0;
	id_rwpxxmh_old = 0;

	$(document).ready(function() {
		// BEGIN rbmxxth

		edtrbmxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/rbmxxth/rbmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rbmxxth = show_deleted_rbmxxth;
				}
			},
			table: "#tblrbmxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},
				{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},
				{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "rbmxxth.start_at",
					name: "rbmxxth.start_at",
					type: "hidden"
				},	
				{
					label: "rbmxxth.finish_at",
					name: "rbmxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "rbmxxth",
					type: "hidden"
				},	
				{
					label: "rbmxxth.transaction_state",
					name: "rbmxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "is_revisi",
					name: "is_revisi"
				},
				{
					label: "Revision#",
					name: "rbmxxth.revisi_ke"
				},
				{
					label: "BOM Asal",
					name: "rbmxxth.id_rbmxxth_asal"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "rbmxxth.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iicxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									search: params.term || '',
									id_iimxxmh_old: id_iimxxmh_old,
									ids_iccttmh: 3,
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
					name: "rbmxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtrbmxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrbmxxth.field('rbmxxth.start_at').val(start_at);

			if(action == 'create'){
				tblrbmxxth.rows().deselect();

				edtrbmxxth.field('kategori_dokumen').val('');
				edtrbmxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtrbmxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtrbmxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_iimxxmh = edtrbmxxth.field('rbmxxth.id_iimxxmh').val();
				
				validasiRequired(
					edtrbmxxth,
					'rbmxxth',
					{
						'id_iimxxmh': id_iimxxmh
					}
				);
				
				
			}
			
			if ( edtrbmxxth.inError() ) {
				return false;
			}
		});

		edtrbmxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrbmxxth.field('rbmxxth.finish_at').val(finish_at);
		});
		
		edtrbmxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblrbmxxth.ajax.reload(null, false);
		} );

		edtrbmxxth.on( 'close', function () {
			edtrbmxxth.enable();
		} );
		
		tblrbmxxth = $('#tblrbmxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/rbmxxth/rbmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rbmxxth = show_deleted_rbmxxth;
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
				{ data: "rbmxxth.id",visible:false },
				{ data: "rbmxxth.kode" },
				{ data: "rbmxxth.revisi_ke" },
				{ data: "iimxxmh.nama" },
				{ data: "rbmxxth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_rbmxxth';
					$table       = 'tblrbmxxth';
					$edt         = 'edtrbmxxth';
					$show_status = '_rbmxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{ 
					extend: 'selected',
					name: 'btnCreateRevision', 
					text: '<i class="fa fa-google"></i>', 
					className: 'btn btn-outline', 
					titleAttr: 'Create Revision',
					action: function (e, dt, node, config) {
						var revisi_ke_new = parseInt(revisi_ke) + 1;
                        // Start in edit mode, and then change to create
                        edtrbmxxth
                            .edit(tblrbmxxth.rows({ selected: true }).indexes(), {
                                title: 'Create Revision',
                                buttons: 'Create Revision'
                            })
							.disable('rbmxxth.revisi_ke')
							.set( 'rbmxxth.id_rbmxxth_asal', id_rbmxxth )
							.set( 'is_revisi', 1 )
							.set( 'rbmxxth.revisi_ke', revisi_ke_new )
                            .mode('create');
                    }
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.rbmxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.rbmxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblrbmxxth.searchPanes.container().appendTo('#sprbmxxth');
		tblrbmxxth.searchBuilder.container().appendTo( '#sbrbmxxth' );
		
		tblrbmxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblrbmittd, tblrbmwptd];
			CekInitHeaderHD(tblrbmxxth, tbl_details);
		} );
		
		tblrbmxxth.on( 'select', function( e, dt, type, indexes ) {
			rbmxxth_data      = tblrbmxxth.row( { selected: true } ).data().rbmxxth;
			id_rbmxxth        = rbmxxth_data.id;
			id_transaksi_h    = id_rbmxxth;                                           // dipakai untuk general
			id_transaksi_log  = id_rbmxxth;                                           // dipakai untuk general
			transaction_state = rbmxxth_data.transaction_state;
			approval_state    = rbmxxth_data.approval_state;
			is_nextprocess    = rbmxxth_data.is_nextprocess;
			id_iimxxmh_old    = rbmxxth_data.id_iimxxmh;
			revisi_ke    = rbmxxth_data.revisi_ke;
			// atur hak akses
			tbl_details = [tblrbmittd, tblrbmwptd];
			CekSelectHeaderHD(tblrbmxxth, tbl_details);

		} );
		
		tblrbmxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_rbmxxth = 0;
			id_iimxxmh_old = 0;
			// atur hak akses
			tbl_details = [tblrbmittd, tblrbmwptd];
			CekDeselectHeaderHD(tblrbmxxth, tbl_details);
		} );
		
		// END rbmxxth


		// BEGIN rbmittd

		edtrbmittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/rbmxxth/rbmittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rbmittd = show_deleted_rbmittd;
					d.id_rbmxxth = id_rbmxxth;
				}
			},
			table: "#tblrbmittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "rbmittd.start_at",
					name: "rbmittd.start_at",
					type: "hidden"
				},	
				{
					label: "rbmittd.finish_at",
					name: "rbmittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "rbmittd",
					type: "hidden"
				},	
				{
					label: "rbmittd.transaction_state",
					name: "rbmittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_rbmxxth",
					name: "rbmittd.id_rbmxxth",
					type: "hidden"
				},	
				{
					label: "Raw Material",
					name: "rbmittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iicxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_rm_old,
									ids_iicxxmh: 1,
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
					label: "Jumlah",
					name: "rbmittd.jumlah_unit",
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "rbmittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_iimummd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh: id_iimxxmh_rm,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
					name: "rbmittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtrbmittd.on( 'preOpen', function( e, mode, action ) {
			edtrbmittd.field('rbmittd.id_rbmxxth').val(id_rbmxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrbmittd.field('rbmittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblrbmittd.rows().deselect();
			}
		});

		edtrbmittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtrbmittd.dependent( 'rbmittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh_rm = edtrbmittd.field('rbmittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});
		
		edtrbmittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_iimxxmh_rm = edtrbmittd.field('rbmittd.id_iimxxmh').val();
				validasiRequired(
					edtrbmittd,
					'rbmittd',
					{
						'id_iimxxmh': id_iimxxmh_rm
					}
				);
			}
			
			if ( edtrbmittd.inError() ) {
				return false;
			}
		});

		edtrbmittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrbmittd.field('rbmittd.finish_at').val(finish_at);
		});
			
		edtrbmittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_last_insert = json.data[0].rbmittd.id;
				konversiUom('rbmittd', id_last_insert);
				tblrbmittd.rows().deselect();
			}
		} );

		edtrbmittd.on( 'close', function () {
			edtrbmittd.enable();
		} );

		tblrbmittd = $('#tblrbmittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/rbmxxth/rbmittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rbmittd = show_deleted_rbmittd;
					d.id_rbmxxth = id_rbmxxth;
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
					targets: [0,4]
				}
			],
			columns: [
				{ data: "rbmittd.id",visible:false },
				{ data: "rbmittd.id_rbmxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "rbmittd.jumlah_unit" ,
					...renderNumber(2)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_rbmittd';
					$table       = 'tblrbmittd';
					$edt         = 'edtrbmittd';
					$show_status = '_rbmittd';
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

		tblrbmittd.searchPanes.container().appendTo('#sprbmittd');
		tblrbmittd.searchBuilder.container().appendTo( '#sbrbmittd' );

		tblrbmittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblrbmxxth, tblrbmittd, 'rbmittd' );
			CekDrawDetailHDFinal(tblrbmxxth);
		} );

		tblrbmittd.on( 'select', function( e, dt, type, indexes ) {
			data_rbmittd 		= tblrbmittd.row( { selected: true } ).data().rbmittd;
			id_rbmittd   		= data_rbmittd.id;
			id_transaksi_d 		= id_rbmittd; // dipakai untuk general
			id_transaksi_log 	= id_rbmittd; // dipakai untuk log

			transaction_state_d   = data_rbmittd.transaction_state;
			id_iimxxmh_rm_old   = data_rbmittd.id_iimxxmh;
			id_iumxxmh_unit_old   = data_rbmittd.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD(tblrbmxxth, tblrbmittd );
		} );

		tblrbmittd.on( 'deselect', function() {
			id_rbmittd = 0;
			id_iimxxmh_rm_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblrbmxxth, tblrbmittd );
		} );

		// END rbmittd


		// BEGIN rbmwptd

		edtrbmwptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/rbmxxth/rbmwptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rbmwptd = show_deleted_rbmwptd;
					d.id_rbmxxth = id_rbmxxth;
				}
			},
			table: "#tblrbmwptd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "rbmwptd.start_at",
					name: "rbmwptd.start_at",
					type: "hidden"
				},	
				{
					label: "rbmwptd.finish_at",
					name: "rbmwptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "rbmwptd",
					type: "hidden"
				},	
				{
					label: "rbmwptd.transaction_state",
					name: "rbmwptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_rbmxxth",
					name: "rbmwptd.id_rbmxxth",
					type: "hidden"
				},	
				{
					label: "Work Process <sup class='text-danger'>*<sup>",
					name: "rbmwptd.id_rwpxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/rwpxxmh/rwpxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_rwpxxmh_old: id_rwpxxmh_old,
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
					label: "Cycle Time",
					name: "rbmwptd.cycletime"
				},
				{
					label: "Keterangan",
					name: "rbmwptd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtrbmwptd.on( 'preOpen', function( e, mode, action ) {
			edtrbmwptd.field('rbmwptd.id_rbmxxth').val(id_rbmxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrbmwptd.field('rbmwptd.start_at').val(start_at);
			
			if(action == 'create'){
				tblrbmwptd.rows().deselect();
			}
		});

		edtrbmwptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtrbmwptd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_rwpxxmh = edtrbmwptd.field('rbmwptd.id_rwpxxmh').val();
				validasiRequired(
					edtrbmwptd,
					'rbmwptd',
					{
						'id_rwpxxmh': id_rwpxxmh
					}
				);

				cycletime = edtrbmwptd.field('rbmwptd.cycletime').val();
				validasiNumber(
					edtrbmwptd,
					'rbmwptd',
					{
						'cycletime': cycletime,
					},
					0,
					'>'
				);
			}
			
			if ( edtrbmwptd.inError() ) {
				return false;
			}
		});

		edtrbmwptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrbmwptd.field('rbmwptd.finish_at').val(finish_at);
		});
			
		edtrbmwptd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// nothing to do
		} );

		edtrbmwptd.on( 'close', function () {
			edtrbmwptd.enable();
		} );

		tblrbmwptd = $('#tblrbmwptd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/rbmxxth/rbmwptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rbmwptd = show_deleted_rbmwptd;
					d.id_rbmxxth = id_rbmxxth;
				}
			},
			order: [[ 0, "asc" ]],
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
					targets: [0,4]
				}
			],
			columns: [
				{ data: "rbmwptd.id",visible:false },
				{ data: "rbmwptd.id_rbmxxth",visible:false },
				{ data: "rwpxxmh.kode" },
				{ data: "rwpxxmh.nama" },
				{ 
					data: "rbmwptd.cycletime",
					...renderNumber(0)
				},
				{ data: "rbmwptd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_rbmwptd';
					$table       = 'tblrbmwptd';
					$edt         = 'edtrbmwptd';
					$show_status = '_rbmwptd';
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

		tblrbmwptd.searchPanes.container().appendTo('#sprbmwptd');
		tblrbmwptd.searchBuilder.container().appendTo( '#sbrbmwptd' );

		tblrbmwptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblrbmxxth, tblrbmwptd, 'rbmwptd' );
			CekDrawDetailHDFinal(tblrbmxxth);
		} );

		tblrbmwptd.on( 'select', function( e, dt, type, indexes ) {
			data_rbmwptd 		= tblrbmwptd.row( { selected: true } ).data().rbmwptd;
			id_rbmwptd   		= data_rbmwptd.id;
			id_transaksi_d 		= id_rbmwptd; // dipakai untuk general
			id_transaksi_log 	= id_rbmwptd; // dipakai untuk log

			transaction_state_d   = data_rbmwptd.transaction_state;
			id_rwpxxmh_old   = data_rbmwptd.id_rwpxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblrbmxxth, tblrbmwptd );
		} );

		tblrbmwptd.on( 'deselect', function() {
			id_rbmwptd = 0;
			id_rwpxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblrbmxxth, tblrbmwptd );
		} );

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
