<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ndclgmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = '_blankdetail';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndclgmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tab_blankdetail_1"> Tab 1</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tab_blankdetail_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tab_blankdetail_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ndclgmh</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tab_blankdetail_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ndclgmh</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndclgmh/fn/ndclgmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtndclgmh, tblndclgmh, show_deleted_ndclgmh = 0, id_ndclgmh;
	var edt_blankdetail, tbl_blankdetail, show_deleted__blankdetail = 0, id__blankdetail;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('ndclgmh');

	$(document).ready(function() {
		
		// BEGIN ndclgmh
		edtndclgmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndclgmh/ndclgmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndclgmh = show_deleted_ndclgmh;
				}
			},
			table: "#tblndclgmh",
			fields: [ 
				{
					label: "ndclgmh.start_at",
					name: "ndclgmh.start_at",
					type: "hidden"
				},	
				{
					label: "ndclgmh.finish_at",
					name: "ndclgmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndclgmh",
					type: "hidden"
				},	
				{
					label: "ndclgmh.transaction_state",
					name: "ndclgmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "ndclgmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "ndclgmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "ndclgmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtndclgmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndclgmh.field('ndclgmh.start_at').val(start_at);

			if(action == 'create'){
				tblndclgmh.rows().deselect();
			}
		});

		edtndclgmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtndclgmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtndclgmh.field('ndclgmh.kode').val();
				nama = edtndclgmh.field('ndclgmh.nama').val();

				validasiRequired(
					edtndclgmh,
					'ndclgmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtndclgmh,
					'ndclgmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_ndclgmh
				);

				validasiUnique(
					action,
					edtndclgmh,
					'ndclgmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_ndclgmh
				);
			}
			
			if ( edtndclgmh.inError() ) {
				return false;
			}
		});

		edtndclgmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndclgmh.field('ndclgmh.finish_at').val(finish_at);
		});
		
		edtndclgmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndclgmh.on( 'close', function () {
			edtndclgmh.enable();
		} );
		
		tblndclgmh = $('#tblndclgmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndclgmh/ndclgmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndclgmh = show_deleted_ndclgmh;
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
				{ data: "ndclgmh.id",visible:false },
				{ data: "ndclgmh.kode" },
				{ data: "ndclgmh.nama" },
				{ data: "ndclgmh.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndclgmh';
					$table       = 'tblndclgmh';
					$edt         = 'edtndclgmh';
					$show_status = '_ndclgmh';
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
				if ( data.ndclgmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ndclgmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblndclgmh.searchPanes.container().appendTo('#spndclgmh');
		tblndclgmh.searchBuilder.container().appendTo( '#sbndclgmh' );
		
		tblndclgmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekInitHeaderHD(tblndclgmh, tbl_details);
		} );
		
		tblndclgmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('ndclgmh');
			
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekSelectHeaderHD(tblndclgmh, tbl_details);

		} );
		
		tblndclgmh.on( 'deselect', function () {
			siVarReset('ndclgmh');

			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekDeselectHeaderHD(tblndclgmh, tbl_details);
		} );
		// END ndclgmh

		// BEGIN _blankdetail
		edt_blankdetail = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndclgmh/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id_ndclgmh = id_ndclgmh;
				}
			},
			table: "#tbl_blankdetail",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "_blankdetail.start_at",
					name: "_blankdetail.start_at",
					type: "hidden"
				},	
				{
					label: "_blankdetail.finish_at",
					name: "_blankdetail.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankdetail",
					type: "hidden"
				},	
				{
					label: "_blankdetail.transaction_state",
					name: "_blankdetail.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ndclgmh",
					name: "_blankdetail.id_ndclgmh",
					type: "hidden"
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "_blankdetail.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "_blankdetail.nama"
				}, 	
				{
					label: "Keterangan",
					name: "_blankdetail.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edt_blankdetail.on( 'preOpen', function( e, mode, action ) {
			edt_blankdetail.field('_blankdetail.id_ndclgmh').val(id_ndclgmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.start_at').val(start_at);
			
			if(action == 'create'){
				tbl_blankdetail.rows().deselect();
			}
		});

		edt_blankdetail.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edt_blankdetail.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blankdetail.field('_blankdetail.kode').val();

				validasiRequired(
					edt_blankdetail,
					'_blankdetail',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edt_blankdetail,
					'_blankdetail',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blankdetail
				);

			}
			
			if ( edt_blankdetail.inError() ) {
				return false;
			}
		});

		edt_blankdetail.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.finish_at').val(finish_at);
		});
			
		edt_blankdetail.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankdetail.on( 'close', function () {
			edt_blankdetail.enable();
		} );
		
		tbl_blankdetail = $('#tbl_blankdetail').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndclgmh/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id_ndclgmh = id_ndclgmh;
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
				{ data: "_blankdetail.id",visible:false },
				{ data: "_blankdetail.id_ndclgmh",visible:false },
				{ data: "_blankdetail.kode" },
				{ data: "_blankdetail.nama" },
				{ data: "_blankdetail.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__blankdetail';
					$table       = 'tbl_blankdetail';
					$edt         = 'edt_blankdetail';
					$show_status = '__blankdetail';
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

		tbl_blankdetail.searchPanes.container().appendTo('#sp_blankdetail');
		tbl_blankdetail.searchBuilder.container().appendTo( '#sb_blankdetail' );

		tbl_blankdetail.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbl_blankdetail, 1 );
			CekDrawDetailHDFinal(tblndclgmh);
		} );

		tbl_blankdetail.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('_blankdetail');
			
			// atur hak akses
			CekSelectDetailHD( tbl_blankdetail );
		} );

		tbl_blankdetail.on( 'deselect', function() {
			siVarResetD('_blankdetail');
			
			// atur hak akses
			CekDeselectDetailHD( tbl_blankdetail );
		} );
		// END _blankdetail

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
