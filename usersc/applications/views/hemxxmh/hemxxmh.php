<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hemxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hemjbmh';
?>

<!-- begin content here -->
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="table-responsive">
                    <table id="tblhemxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>

				<div class="tabs-container">
					<ul class="nav nav-tabs" role="tablist">
						<li><a class="nav-link active" data-toggle="tab" href="#tabhemjbmh"> Job Info</a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhemjbmh_2"> Tab 2</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" id="tabhemjbmh" class="tab-pane active">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemjbmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th>Branch</th>
												<th>Division</th>
												<th>Department</th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhemjbmh_2" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemjbmh_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
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
				
            </div>
        </div>
    </div>
</div>

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

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthemxxmh, tblhemxxmh, show_deleted_hemxxmh = 0, id_hemxxmh;
	var edthemjbmh, tblhemjbmh, show_deleted_hemjbmh = 0, id_hemjbmh;
	// ------------- end of default variable

	var id_gbrxxmh_old = 0, id_hovxxmh_old = 0, id_hodxxmh_old = 0;

	// get tableRelation
	tableRelation('hemxxmh');

	$(document).ready(function() {

		// BEGIN hemxxmh
		edthemxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemxxmh = show_deleted_hemxxmh;
				}
			},
			table: "#tblhemxxmh",
			fields: [ 
				{
					label: "hemxxmh.start_at",
					name: "hemxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hemxxmh.finish_at",
					name: "hemxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemxxmh",
					type: "hidden"
				},	
				{
					label: "hemxxmh.transaction_state",
					name: "hemxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hemxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hemxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "hemxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthemxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemxxmh.field('hemxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblhemxxmh.rows().deselect();
				edthemxxmh.field('hemxxmh.kode').enable();
				edthemxxmh.field('hemxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthemxxmh.field('hemxxmh.kode').enable();
					edthemxxmh.field('hemxxmh.nama').enable();
				}else{
					edthemxxmh.field('hemxxmh.kode').disable();
					edthemxxmh.field('hemxxmh.nama').disable();
				}
			}
		});

		edthemxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edthemxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edthemxxmh.field('hemxxmh.nama').val();

				validasiRequired(
					edthemxxmh,
					'hemxxmh',
					{
						'nama': nama
					}
				);

			}
			
			if ( edthemxxmh.inError() ) {
				return false;
			}
		});

		edthemxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemxxmh.field('hemxxmh.finish_at').val(finish_at);
		});
		
		edthemxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthemxxmh.on( 'close', function () {
			edthemxxmh.enable();
		} );
		
		tblhemxxmh = $('#tblhemxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hemxxmh/hemxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemxxmh = show_deleted_hemxxmh;
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
				{ data: "hemxxmh.id",visible:false },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hemxxmh.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemxxmh';
					$table       = 'tblhemxxmh';
					$edt         = 'edthemxxmh';
					$show_status = '_hemxxmh';
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
				if ( data.hemxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hemxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhemxxmh.searchPanes.container().appendTo('#sphemxxmh');
		tblhemxxmh.searchBuilder.container().appendTo( '#sbhemxxmh' );
		
		tblhemxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhemjbmh];
			CekInitHeaderHD(tblhemxxmh, tbl_details);
		} );
		
		tblhemxxmh.on( 'select', function( e, dt, type, indexes ) {
			hemxxmh_data = tblhemxxmh.row( { selected: true } ).data().hemxxmh;
			id_hemxxmh   = hemxxmh_data.id;
			id_transaksi_h    = id_hemxxmh;                                                // dipakai untuk general
			id_transaksi_log  = id_hemxxmh;                                                // dipakai untuk general
			transaction_state = hemxxmh_data.transaction_state;
			approval_state    = hemxxmh_data.approval_state;
			is_nextprocess    = hemxxmh_data.is_nextprocess;
			
			// atur hak akses
			tbl_details = [tblhemjbmh];
			CekSelectHeaderHD(tblhemxxmh, tbl_details);

		} );
		
		tblhemxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_hemxxmh = '';

			// atur hak akses
			tbl_details = [tblhemjbmh];
			CekDeselectHeaderHD(tblhemxxmh, tbl_details);
		} );
		
		// END hemxxmh

		// BEGIN hemjbmh
		edthemjbmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemjbmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemjbmh = show_deleted_hemjbmh;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhemjbmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hemjbmh.start_at",
					name: "hemjbmh.start_at",
					type: "hidden"
				},	
				{
					label: "hemjbmh.finish_at",
					name: "hemjbmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemjbmh",
					type: "hidden"
				},	
				{
					label: "hemjbmh.transaction_state",
					name: "hemjbmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "hemjbmh.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Branch <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_gbrxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gbrxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gbrxxmh_old: id_gbrxxmh_old,
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
					label: "Division <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_hovxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hovxxmh/hovxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hovxxmh_old: id_hovxxmh_old,
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
					label: "Department <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_hodxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh_old: id_hodxxmh_old,
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
			]
		} );
			
		edthemjbmh.on( 'preOpen', function( e, mode, action ) {
			edthemjbmh.field('hemjbmh.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemjbmh.field('hemjbmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhemjbmh.rows().deselect();
			}
		});

		edthemjbmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edthemjbmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_gbrxxmh = edthemjbmh.field('hemjbmh.id_gbrxxmh').val();
				id_hovxxmh = edthemjbmh.field('hemjbmh.id_hovxxmh').val();
				id_hodxxmh = edthemjbmh.field('hemjbmh.id_hodxxmh').val();

				validasiRequired(
					edthemjbmh,
					'hemjbmh',
					{
						'id_gbrxxmh': id_gbrxxmh,
						'id_hovxxmh': id_hovxxmh,
						'id_hodxxmh': id_hodxxmh
					}
				);

			}
			
			if ( edthemjbmh.inError() ) {
				return false;
			}
		});

		edthemjbmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemjbmh.field('hemjbmh.finish_at').val(finish_at);
		});
			
		edthemjbmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemjbmh.rows().deselect();
			tblhemjbmh.ajax.reload(null, false);
		} );

		edthemjbmh.on( 'close', function () {
			edthemjbmh.enable();
		} );
		
		tblhemjbmh = $('#tblhemjbmh').DataTable( {
			ajax: {
				url: "../../models/hemxxmh/hemjbmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemjbmh = show_deleted_hemjbmh;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hemjbmh.id",visible:false },
				{ data: "hemjbmh.id_hemxxmh",visible:false },
				{ data: "gbrxxmh.nama" },
				{ data: "hovxxmh.nama" },
				{ data: "hodxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemjbmh';
					$table       = 'tblhemjbmh';
					$edt         = 'edthemjbmh';
					$show_status = '_hemjbmh';
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

		tblhemjbmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblhemxxmh, tblhemjbmh, 'hemjbmh' );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemjbmh.on( 'select', function( e, dt, type, indexes ) {
			data_hemjbmh 	= tblhemjbmh.row( { selected: true } ).data().hemjbmh;
			id_hemjbmh   	= data_hemjbmh.id;
			id_transaksi_d 		= id_hemjbmh; // dipakai untuk general
			id_transaksi_log 	= id_hemjbmh; // dipakai untuk log

			transaction_state_d   = data_hemjbmh.transaction_state;

			id_gbrxxmh_old   = data_hemjbmh.id_gbrxxmh;
			id_hovxxmh_old   = data_hemjbmh.id_hovxxmh;
			id_hodxxmh_old   = data_hemjbmh.id_hodxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemjbmh );
		} );

		tblhemjbmh.on( 'deselect', function() {
			id_hemjbmh = 0;

			id_gbrxxmh_old   = 0;
			id_hovxxmh_old   = 0;
			id_hodxxmh_old   = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemjbmh );
		} );
		// END hemjbmh

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
