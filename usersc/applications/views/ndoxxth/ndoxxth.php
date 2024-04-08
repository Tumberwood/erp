<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ndoxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ndodctd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabndodctd"> Document</a></li>				
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabndodctd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblndodctd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ndoxxth</th>
										<th>Document No</th>
										<th>Pengirim</th>
										<th>Kepada</th>
										<th>Tanggal Jam Terima </th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndoxxth/fn/ndoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtndoxxth, tblndoxxth, show_deleted_ndoxxth = 0, id_ndoxxth;
	var edtndodctd, tblndodctd, show_deleted_ndodctd = 0, id_ndodctd;
	// ------------- end of default variable

	var id_users_penerima_old = 0;
	var id_ndrxxtd_old = 0;

	// get tableRelation
	tableRelation('ndoxxth');

	$(document).ready(function() {
		
		// BEGIN ndoxxth
		edtndoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndoxxth/ndoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndoxxth = show_deleted_ndoxxth;
				}
			},
			table: "#tblndoxxth",
			fields: [ 
				{
					label: "ndoxxth.start_at",
					name: "ndoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "ndoxxth.finish_at",
					name: "ndoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndoxxth",
					type: "hidden"
				},	
				{
					label: "ndoxxth.transaction_state",
					name: "ndoxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal Jam Penyerahan <sup class='text-danger'>*<sup>",
					name: "ndoxxth.tanggal_jam_to",
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
					label: "Kepada <sup class='text-danger'>*<sup>",
					name: "ndoxxth.id_users_penerima",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/users_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_users_old: id_users_penerima_old,
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
					name: "ndoxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtndoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndoxxth.field('ndoxxth.start_at').val(start_at);

			if(action == 'create'){
				tblndoxxth.rows().deselect();
			}
		});

		edtndoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtndoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_jam_to = edtndoxxth.field('ndoxxth.tanggal_jam_to').val();
				id_users_penerima = edtndoxxth.field('ndoxxth.id_users_penerima').val();

				validasiRequired(
					edtndoxxth,
					'ndoxxth',
					{
						'tanggal_jam_to': tanggal_jam_to,
						'id_users_penerima': id_users_penerima
					}
				);

			}
			
			if ( edtndoxxth.inError() ) {
				return false;
			}
		});

		edtndoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndoxxth.field('ndoxxth.finish_at').val(finish_at);
		});
		
		edtndoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndoxxth.on( 'close', function () {
			edtndoxxth.enable();
		} );
		
		tblndoxxth = $('#tblndoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndoxxth/ndoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndoxxth = show_deleted_ndoxxth;
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
				{ data: "ndoxxth.id",visible:false },
				{ data: "ndoxxth.kode" },
				{ data: "ndoxxth.tanggal_jam_to" },
				{ data: "users_pengirim.username" },
				{ data: "users_penerima.username" },
				{ data: "ndoxxth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndoxxth';
					$table       = 'tblndoxxth';
					$edt         = 'edtndoxxth';
					$show_status = '_ndoxxth';
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
				if ( data.ndoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ndoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblndoxxth.searchPanes.container().appendTo('#spndoxxth');
		tblndoxxth.searchBuilder.container().appendTo( '#sbndoxxth' );
		
		tblndoxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblndodctd];
			CekInitHeaderHD(tblndoxxth, tbl_details);
		} );
		
		tblndoxxth.on( 'select', function( e, dt, type, indexes ) {
			ndoxxth_data = tblndoxxth.row( { selected: true } ).data().ndoxxth;
			id_ndoxxth   = ndoxxth_data.id;
			id_transaksi_h    = id_ndoxxth;                                                // dipakai untuk general
			id_transaksi_log  = id_ndoxxth;                                                // dipakai untuk general
			transaction_state = ndoxxth_data.transaction_state;
			approval_state    = ndoxxth_data.approval_state;
			is_nextprocess    = ndoxxth_data.is_nextprocess;

			id_users_penerima_old    = ndoxxth_data.id_users_penerima;
			
			// atur hak akses
			tbl_details = [tblndodctd];
			CekSelectHeaderHD(tblndoxxth, tbl_details);

		} );
		
		tblndoxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_ndoxxth = 0;

			id_users_penerima_old = 0;

			// atur hak akses
			tbl_details = [tblndodctd];
			CekDeselectHeaderHD(tblndoxxth, tbl_details);
		} );
		// END ndoxxth

		// BEGIN ndodctd
		edtndodctd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndoxxth/ndodctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndodctd = show_deleted_ndodctd;
					d.id_ndoxxth = id_ndoxxth;
				}
			},
			table: "#tblndodctd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ndodctd.start_at",
					name: "ndodctd.start_at",
					type: "hidden"
				},	
				{
					label: "ndodctd.finish_at",
					name: "ndodctd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndodctd",
					type: "hidden"
				},	
				{
					label: "ndodctd.transaction_state",
					name: "ndodctd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ndoxxth",
					name: "ndodctd.id_ndoxxth",
					type: "hidden"
				},	
				{
					label: "Document No <sup class='text-danger'>*<sup>",
					name: "ndodctd.id_ndrxxtd",
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
					name: "ndodctd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtndodctd.on( 'preOpen', function( e, mode, action ) {
			edtndodctd.field('ndodctd.id_ndoxxth').val(id_ndoxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndodctd.field('ndodctd.start_at').val(start_at);
			
			if(action == 'create'){
				tblndodctd.rows().deselect();
			}
		});

		edtndodctd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtndodctd.dependent( 'ndodctd.id_ndrxxtd', function ( val, data, callback ) {
			id_ndrxxtd = edtndodctd.field('ndodctd.id_ndrxxtd').val();
			autofillField('ndrxxtd', id_ndrxxtd, 'kepada');

			edtndodctd.field('kepada').val(autofillData.kepada);
			
			return {}
		}, {event: 'keyup change'});

		edtndodctd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_ndrxxtd = edtndodctd.field('ndodctd.id_ndrxxtd').val();

				validasiRequired(
					edtndodctd,
					'ndodctd',
					{
						'id_ndrxxtd': id_ndrxxtd
					}
				);

				validasiUnique(
					action,
					edtndodctd,
					'ndodctd',
					'id_ndrxxtd',
					'id_ndrxxtd,id_ndoxxth',
					id_ndrxxtd + ',' + id_ndoxxth,
					id_ndodctd
				);

			}
			
			if ( edtndodctd.inError() ) {
				return false;
			}
		});

		edtndodctd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndodctd.field('ndodctd.finish_at').val(finish_at);
		});
			
		edtndodctd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndodctd.on( 'close', function () {
			edtndodctd.enable();
		} );
		
		tblndodctd = $('#tblndodctd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndoxxth/ndodctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndodctd = show_deleted_ndodctd;
					d.id_ndoxxth = id_ndoxxth;
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
				{ data: "ndodctd.id",visible:false },
				{ data: "ndodctd.id_ndoxxth",visible:false },
				{ data: "ndrxxtd.dokumen_nomor" },
				{ data: "ndrxxtd.pengirim" },
				{ data: "ndrxxtd.kepada" },
				{ data: "ndrxxtd.tanggal_jam_terima" },
				{ data: "ndodctd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndodctd';
					$table       = 'tblndodctd';
					$edt         = 'edtndodctd';
					$show_status = '_ndodctd';
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

		tblndodctd.searchPanes.container().appendTo('#spndodctd');
		tblndodctd.searchBuilder.container().appendTo( '#sbndodctd' );

		tblndodctd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblndoxxth, tblndodctd, 'ndodctd' );
			CekDrawDetailHDFinal(tblndoxxth);
		} );

		tblndodctd.on( 'select', function( e, dt, type, indexes ) {
			data_ndodctd = tblndodctd.row( { selected: true } ).data().ndodctd;
			id_ndodctd   = data_ndodctd.id;
			id_transaksi_d    = id_ndodctd; // dipakai untuk general
			id_transaksi_log  = id_ndodctd; // dipakai untuk log

			transaction_state_d   = data_ndodctd.transaction_state;
			
			id_ndrxxtd_old   = data_ndodctd.id_ndrxxtd;
			
			// atur hak akses
			CekSelectDetailHD(tblndoxxth, tblndodctd );
		} );

		tblndodctd.on( 'deselect', function() {
			id_ndodctd = 0;
			id_ndrxxtd_old = 0;
			// atur hak akses
			CekDeselectDetailHD(tblndoxxth, tblndodctd );
		} );
		// END ndodctd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
