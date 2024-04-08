<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ndixxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ndidctd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndixxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Transfer Out</th>
                                <th>Tanggal Jam Penyerahan</th>
                                <th>Dari</th>
                                <th>Kepada</th>
								<!-- <th>Tanggal Penerimaan</th> -->
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabndidctd"> Document</a></li>				
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabndidctd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblndidctd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ndixxth</th>
										<th>Document No</th>
										<th>Pengirim</th>
										<th>Kepada</th>
										<th>Tanggal Jam Terima</th>
										<th>Keterangan</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndixxth/fn/ndixxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtndixxth, tblndixxth, show_deleted_ndixxth = 0, id_ndixxth;
	var edtndidctd, tblndidctd, show_deleted_ndidctd = 0, id_ndidctd;
	// ------------- end of default variable

	var id_ndoxxth_old = 0;
	var id_ndrxxtd_old = 0;

	// get tableRelation
	tableRelation('ndixxth');

	$(document).ready(function() {
		
		// BEGIN ndixxth
		edtndixxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndixxth/ndixxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndixxth = show_deleted_ndixxth;
				}
			},
			table: "#tblndixxth",
			fields: [ 
				{
					label: "ndixxth.start_at",
					name: "ndixxth.start_at",
					type: "hidden"
				},	
				{
					label: "ndixxth.finish_at",
					name: "ndixxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndixxth",
					type: "hidden"
				},	
				{
					label: "ndixxth.transaction_state",
					name: "ndixxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal Jam Terima <sup class='text-danger'>*<sup>",
					name: "ndixxth.tanggal_jam_ti",
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
					label: "Transfer Out",
					name: "ndixxth.id_ndoxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/ndoxxth/ndoxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_ndoxxth_old: id_ndoxxth_old,
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
					name: "ndixxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtndixxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndixxth.field('ndixxth.start_at').val(start_at);

			if(action == 'create'){
				tblndixxth.rows().deselect();
			}
		});

		edtndixxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtndixxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_jam_ti = edtndixxth.field('ndixxth.tanggal_jam_ti').val();
				id_ndoxxth = edtndixxth.field('ndixxth.id_ndoxxth').val();

				validasiRequired(
					edtndixxth,
					'ndixxth',
					{
						'tanggal_jam_ti': tanggal_jam_ti,
						'id_ndoxxth': id_ndoxxth
					}
				);

			}
			
			if ( edtndixxth.inError() ) {
				return false;
			}
		});

		edtndixxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndixxth.field('ndixxth.finish_at').val(finish_at);
		});
		
		edtndixxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndixxth.on( 'close', function () {
			edtndixxth.enable();
		} );
		
		tblndixxth = $('#tblndixxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndixxth/ndixxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndixxth = show_deleted_ndixxth;
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
				{ data: "ndixxth.id",visible:false },
				{ data: "ndixxth.kode" },
				{ data: "ndoxxth.kode" },
				{ data: "ndixxth.tanggal_jam_ti" },
				{ data: "users_pengirim.username" },
				{ data: "users_penerima.username" },
				{ data: "ndixxth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndixxth';
					$table       = 'tblndixxth';
					$edt         = 'edtndixxth';
					$show_status = '_ndixxth';
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
				if ( data.ndixxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ndixxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblndixxth.searchPanes.container().appendTo('#spndixxth');
		tblndixxth.searchBuilder.container().appendTo( '#sbndixxth' );
		
		tblndixxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblndidctd];
			CekInitHeaderHD(tblndixxth, tbl_details);
		} );
		
		tblndixxth.on( 'select', function( e, dt, type, indexes ) {
			ndixxth_data = tblndixxth.row( { selected: true } ).data().ndixxth;
			id_ndixxth   = ndixxth_data.id;
			id_transaksi_h    = id_ndixxth;                                                // dipakai untuk general
			id_transaksi_log  = id_ndixxth;                                                // dipakai untuk general
			transaction_state = ndixxth_data.transaction_state;
			approval_state    = ndixxth_data.approval_state;
			is_nextprocess    = ndixxth_data.is_nextprocess;

			id_users_penerima_old    = ndixxth_data.id_users_penerima;
			
			// atur hak akses
			tbl_details = [tblndidctd];
			CekSelectHeaderHD(tblndixxth, tbl_details);

		} );
		
		tblndixxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_ndixxth = 0;

			id_users_penerima_old = 0;

			// atur hak akses
			tbl_details = [tblndidctd];
			CekDeselectHeaderHD(tblndixxth, tbl_details);
		} );
		// END ndixxth

		// BEGIN ndidctd
		edtndidctd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndixxth/ndidctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndidctd = show_deleted_ndidctd;
					d.id_ndixxth = id_ndixxth;
				}
			},
			table: "#tblndidctd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ndidctd.start_at",
					name: "ndidctd.start_at",
					type: "hidden"
				},	
				{
					label: "ndidctd.finish_at",
					name: "ndidctd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndidctd",
					type: "hidden"
				},	
				{
					label: "ndidctd.transaction_state",
					name: "ndidctd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ndixxth",
					name: "ndidctd.id_ndixxth",
					type: "hidden"
				},	
				{
					label: "Document No <sup class='text-danger'>*<sup>",
					name: "ndidctd.id_ndrxxtd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/ndrxxtd/ndrxxtd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_ndrxxtd_old: id_ndrxxtd_old,
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
					label: "Ditujukan Kepada",
					name: "kepada",
					type: "readonly"
				}, 	
				{
					label: "Keterangan",
					name: "ndidctd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtndidctd.on( 'preOpen', function( e, mode, action ) {
			edtndidctd.field('ndidctd.id_ndixxth').val(id_ndixxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndidctd.field('ndidctd.start_at').val(start_at);
			
			if(action == 'create'){
				tblndidctd.rows().deselect();
			}
		});

		edtndidctd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtndidctd.dependent( 'ndidctd.id_ndrxxtd', function ( val, data, callback ) {
			id_ndrxxtd = edtndidctd.field('ndidctd.id_ndrxxtd').val();
			autofillField('ndrxxtd', id_ndrxxtd, 'kepada');

			edtndidctd.field('kepada').val(autofillData.kepada);
			
			return {}
		}, {event: 'keyup change'});

		edtndidctd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_ndrxxtd = edtndidctd.field('ndidctd.id_ndrxxtd').val();

				validasiRequired(
					edtndidctd,
					'ndidctd',
					{
						'id_ndrxxtd': id_ndrxxtd
					}
				);

				validasiUnique(
					action,
					edtndidctd,
					'ndidctd',
					'id_ndrxxtd',
					'id_ndrxxtd,id_ndixxth',
					id_ndrxxtd + ',' + id_ndixxth,
					id_ndidctd
				);

			}
			
			if ( edtndidctd.inError() ) {
				return false;
			}
		});

		edtndidctd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndidctd.field('ndidctd.finish_at').val(finish_at);
		});
			
		edtndidctd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndidctd.on( 'close', function () {
			edtndidctd.enable();
		} );
		
		tblndidctd = $('#tblndidctd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndixxth/ndidctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndidctd = show_deleted_ndidctd;
					d.id_ndixxth = id_ndixxth;
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
				{ data: "ndidctd.id",visible:false },
				{ data: "ndidctd.id_ndixxth",visible:false },
				{ data: "ndrxxtd.dokumen_nomor" },
				{ data: "ndrxxtd.pengirim" },
				{ data: "ndrxxtd.kepada" },
				{ data: "ndrxxtd.tanggal_jam_terima" },
				{ data: "ndidctd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndidctd';
					$table       = 'tblndidctd';
					$edt         = 'edtndidctd';
					$show_status = '_ndidctd';
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

		tblndidctd.searchPanes.container().appendTo('#spndidctd');
		tblndidctd.searchBuilder.container().appendTo( '#sbndidctd' );

		tblndidctd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblndixxth, tblndidctd, 'ndidctd' );
			CekDrawDetailHDFinal(tblndixxth);
		} );

		tblndidctd.on( 'select', function( e, dt, type, indexes ) {
			data_ndidctd = tblndidctd.row( { selected: true } ).data().ndidctd;
			id_ndidctd   = data_ndidctd.id;
			id_transaksi_d    = id_ndidctd; // dipakai untuk general
			id_transaksi_log  = id_ndidctd; // dipakai untuk log

			transaction_state_d   = data_ndidctd.transaction_state;
			
			id_ndrxxtd_old   = data_ndidctd.id_ndrxxtd;
			
			// atur hak akses
			CekSelectDetailHD(tblndixxth, tblndidctd );
		} );

		tblndidctd.on( 'deselect', function() {
			id_ndidctd = 0;
			id_ndrxxtd_old = 0;
			// atur hak akses
			CekDeselectDetailHD(tblndixxth, tblndidctd );
		} );
		// END ndidctd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
