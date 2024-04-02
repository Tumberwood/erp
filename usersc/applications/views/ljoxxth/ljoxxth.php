<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ljoxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ljoprtd';
    $nama_tabels_d[1] = 'ljodstd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblljoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Expedition</th>
                                <th>Plate No</th>
                                <th>Driver</th>
                                <th>Vehicle Type</th>
                                <th>TX</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabljoprtd"> Activity</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabljodstd"> Destination</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabljoprtd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblljoprtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ljoxxth</th>
										<th>Process</th>
										<th>Start</th>
										<th>Finish</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabljodstd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblljodstd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ljoxxth</th>
										<th>Kode</th>
										<th>Nama</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ljoxxth/fn/ljoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtljoxxth, tblljoxxth, show_deleted_ljoxxth = 0, id_ljoxxth;
	var edtljoprtd, tblljoprtd, show_deleted_ljoprtd = 0, id_ljoprtd;
	var edtljodstd, tblljodstd, show_deleted_ljodstd = 0, id_ljodstd;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_lacxxmh_old = 0, id_lvtxxmh_old = 0;
	var id_lprxxmh_old = 0;

	// get tableRelation
	tableRelation('ljoxxth');

	$(document).ready(function() {
		
		// BEGIN ljoxxth
		edtljoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ljoxxth/ljoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljoxxth = show_deleted_ljoxxth;
				}
			},
			table: "#tblljoxxth",
			fields: [ 
				{
					label: "ljoxxth.start_at",
					name: "ljoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "ljoxxth.finish_at",
					name: "ljoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ljoxxth",
					type: "hidden"
				},	
				{
					label: "ljoxxth.transaction_state",
					name: "ljoxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "ljoxxth.tanggal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Activity <sup class='text-danger'>*<sup>",
					name: "ljoxxth.id_lacxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lacxxmh/lacxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_lacxxmh_old: id_lacxxmh_old,
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
					label: "Expedition",
					name: "ljoxxth.id_grlxxmh_expedition",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lexxxmh/lexxxmh_fn_opt.php",
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
					label: "Vehicle Type <sup class='text-danger'>*<sup>",
					name: "ljoxxth.id_lvtxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lvtxxmh/lvtxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_lvtxxmh_old: id_lvtxxmh_old,
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
					label: "Plat No",
					name: "ljoxxth.plat_no",
				},
				{
					label: "Supir",
					name: "ljoxxth.supir_nama",
				},
				{
					label: "Kernet",
					name: "ljoxxth.kernet_nama",
				},
				{
					label: "Keterangan",
					name: "ljoxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtljoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljoxxth.field('ljoxxth.start_at').val(start_at);

			if(action == 'create'){
				tblljoxxth.rows().deselect();
			}
		});

		edtljoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtljoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal    = edtljoxxth.field('ljoxxth.tanggal').val();
				id_lacxxmh = edtljoxxth.field('ljoxxth.id_lacxxmh').val();
				id_lvtxxmh = edtljoxxth.field('ljoxxth.id_lvtxxmh').val();

				validasiRequired(
					edtljoxxth,
					'ljoxxth',
					{
						'tanggal': tanggal,
						'id_lacxxmh': id_lacxxmh,
						'id_lvtxxmh': id_lvtxxmh
					}
				);

			}
			
			if ( edtljoxxth.inError() ) {
				return false;
			}
		});

		edtljoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljoxxth.field('ljoxxth.finish_at').val(finish_at);
		});
		
		edtljoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtljoxxth.on( 'close', function () {
			edtljoxxth.enable();
		} );
		
		tblljoxxth = $('#tblljoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ljoxxth/ljoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljoxxth = show_deleted_ljoxxth;
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
				{ data: "ljoxxth.id",visible:false },
				{ data: "ljoxxth.kode" },
				{ data: "ljoxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "ljoxxth.plat_no" },
				{ data: "ljoxxth.supir_nama" },
				{ data: "lvtxxmh.nama" },
				{ 
					data: "ljoxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ljoxxth';
					$table       = 'tblljoxxth';
					$edt         = 'edtljoxxth';
					$show_status = '_ljoxxth';
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
				if ( data.ljoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ljoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblljoxxth.searchPanes.container().appendTo('#spljoxxth');
		tblljoxxth.searchBuilder.container().appendTo( '#sbljoxxth' );
		
		tblljoxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblljoprtd,tblljodstd];
			CekInitHeaderHD(tblljoxxth, tbl_details);
		} );
		
		tblljoxxth.on( 'select', function( e, dt, type, indexes ) {
			ljoxxth_data = tblljoxxth.row( { selected: true } ).data().ljoxxth;
			id_ljoxxth   = ljoxxth_data.id;
			id_transaksi_h    = id_ljoxxth;                                                // dipakai untuk general
			id_transaksi_log  = id_ljoxxth;                                                // dipakai untuk general
			transaction_state = ljoxxth_data.transaction_state;
			approval_state    = ljoxxth_data.approval_state;
			is_nextprocess    = ljoxxth_data.is_nextprocess;

			id_grlxxmh_old    = ljoxxth_data.id_grlxxmh_expedition;
			id_lacxxmh_old    = ljoxxth_data.id_lacxxmh;
			id_lvtxxmh_old    = ljoxxth_data.id_lvtxxmh;
			
			// atur hak akses
			tbl_details = [tblljoprtd,tblljodstd];
			CekSelectHeaderHD(tblljoxxth, tbl_details);

		} );
		
		tblljoxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_ljoxxth = 0;
			id_grlxxmh_old = 0, id_lacxxmh_old = 0, id_lvtxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblljoprtd,tblljodstd];
			CekDeselectHeaderHD(tblljoxxth, tbl_details);
		} );
		// END ljoxxth

		// BEGIN ljoprtd
		edtljoprtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ljoxxth/ljoprtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljoprtd = show_deleted_ljoprtd;
					d.id_ljoxxth = id_ljoxxth;
				}
			},
			table: "#tblljoprtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ljoprtd.start_at",
					name: "ljoprtd.start_at",
					type: "hidden"
				},	
				{
					label: "ljoprtd.finish_at",
					name: "ljoprtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ljoprtd",
					type: "hidden"
				},	
				{
					label: "ljoprtd.transaction_state",
					name: "ljoprtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ljoxxth",
					name: "ljoprtd.id_ljoxxth",
					type: "hidden"
				},	
				{
					label: "Process <sup class='text-danger'>*<sup>",
					name: "ljoprtd.id_lprxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lprxxmh/lprxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_lprxxmh_old: id_lprxxmh_old,
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
					label: "Start <sup class='text-danger'>*<sup>",
					name: "ljoprtd.tanggaljam_start",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Finish",
					name: "ljoprtd.tanggaljam_finish",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Keterangan",
					name: "ljoprtd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtljoprtd.on( 'preOpen', function( e, mode, action ) {
			edtljoprtd.field('ljoprtd.id_ljoxxth').val(id_ljoxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljoprtd.field('ljoprtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblljoprtd.rows().deselect();
			}
		});

		edtljoprtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtljoprtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_lprxxmh = edtljoprtd.field('ljoprtd.id_lprxxmh').val();
				tanggaljam_start = edtljoprtd.field('ljoprtd.tanggaljam_start').val();

				validasiRequired(
					edtljoprtd,
					'ljoprtd',
					{
						'id_lprxxmh': id_lprxxmh,
						'tanggaljam_start': tanggaljam_start
					}
				);

			}
			
			if ( edtljoprtd.inError() ) {
				return false;
			}
		});

		edtljoprtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljoprtd.field('ljoprtd.finish_at').val(finish_at);
		});
			
		edtljoprtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtljoprtd.on( 'close', function () {
			edtljoprtd.enable();
		} );
		
		tblljoprtd = $('#tblljoprtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ljoxxth/ljoprtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljoprtd = show_deleted_ljoprtd;
					d.id_ljoxxth = id_ljoxxth;
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
				{ data: "ljoprtd.id",visible:false },
				{ data: "ljoprtd.id_ljoxxth",visible:false },
				{ data: "lprxxmh.nama" },
				{ data: "ljoprtd.tanggaljam_start" },
				{ data: "ljoprtd.tanggaljam_finish" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ljoprtd';
					$table       = 'tblljoprtd';
					$edt         = 'edtljoprtd';
					$show_status = '_ljoprtd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
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

		tblljoprtd.searchPanes.container().appendTo('#spljoprtd');
		tblljoprtd.searchBuilder.container().appendTo( '#sbljoprtd' );

		tblljoprtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblljoxxth, tblljoprtd, 'ljoprtd' );
			CekDrawDetailHDFinal(tblljoxxth);
		} );

		tblljoprtd.on( 'select', function( e, dt, type, indexes ) {
			data_ljoprtd = tblljoprtd.row( { selected: true } ).data().ljoprtd;
			id_ljoprtd   = data_ljoprtd.id;
			id_transaksi_d    = id_ljoprtd;                                                // dipakai untuk general
			id_transaksi_log  = id_ljoprtd;                                                // dipakai untuk log
			transaction_state_d   = data_ljoprtd.transaction_state;

			id_lprxxmh_old    = data_ljoprtd.id_lprxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblljoxxth, tblljoprtd );
		} );

		tblljoprtd.on( 'deselect', function() {
			id_ljoprtd = 0;
			id_lprxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblljoxxth, tblljoprtd );
		} );
		// END ljoprtd

		// BEGIN ljodstd
		edtljodstd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ljoxxth/ljodstd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljodstd = show_deleted_ljodstd;
					d.id_ljoxxth = id_ljoxxth;
				}
			},
			table: "#tblljodstd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ljodstd.start_at",
					name: "ljodstd.start_at",
					type: "hidden"
				},	
				{
					label: "ljodstd.finish_at",
					name: "ljodstd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ljodstd",
					type: "hidden"
				},	
				{
					label: "ljodstd.transaction_state",
					name: "ljodstd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ljoxxth",
					name: "ljodstd.id_ljoxxth",
					type: "hidden"
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "ljodstd.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "ljodstd.nama"
				}, 	
				{
					label: "Keterangan",
					name: "ljodstd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtljodstd.on( 'preOpen', function( e, mode, action ) {
			edtljodstd.field('ljodstd.id_ljoxxth').val(id_ljoxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljodstd.field('ljodstd.start_at').val(start_at);
			
			if(action == 'create'){
				tblljodstd.rows().deselect();
			}
		});

		edtljodstd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtljodstd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtljoxxth.field('ljoxxth.kode').val();

				validasiRequired(
					edtljoxxth,
					'ljoxxth',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edtljoxxth,
					'ljoxxth',
					'kode',
					'kode',
					'"'+kode+'"',
					id_ljoxxth
				);

			}
			
			if ( edtljodstd.inError() ) {
				return false;
			}
		});

		edtljodstd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtljodstd.field('ljodstd.finish_at').val(finish_at);
		});
			
		edtljodstd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtljodstd.on( 'close', function () {
			edtljodstd.enable();
		} );
		
		tblljodstd = $('#tblljodstd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ljoxxth/ljodstd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ljodstd = show_deleted_ljodstd;
					d.id_ljoxxth = id_ljoxxth;
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
				{ data: "ljodstd.id",visible:false },
				{ data: "ljodstd.id_ljoxxth",visible:false },
				{ data: "ljodstd.kode" },
				{ data: "ljodstd.nama" },
				{ data: "ljodstd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ljodstd';
					$table       = 'tblljodstd';
					$edt         = 'edtljodstd';
					$show_status = '_ljodstd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
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

		tblljodstd.searchPanes.container().appendTo('#spljodstd');
		tblljodstd.searchBuilder.container().appendTo( '#sbljodstd' );

		tblljodstd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblljoxxth, tblljodstd, 'ljodstd' );
			CekDrawDetailHDFinal(tblljoxxth);
		} );

		tblljodstd.on( 'select', function( e, dt, type, indexes ) {
			data_ljodstd = tblljodstd.row( { selected: true } ).data().ljodstd;
			id_ljodstd   = data_ljodstd.id;
			id_transaksi_d    = id_ljodstd;                                                // dipakai untuk general
			id_transaksi_log  = id_ljodstd;                                                // dipakai untuk log

			transaction_state_d   = data_ljodstd.transaction_state;
			
			// atur hak akses
			CekSelectDetailHD(tblljoxxth, tblljodstd );
		} );

		tblljodstd.on( 'deselect', function() {
			id_ljodstd = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblljoxxth, tblljodstd );
		} );
		// END ljodstd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
