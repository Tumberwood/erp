<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'rmsxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'rmsxxmh_rwpxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="table-responsive">
                    <table id="tblrmsxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabrmsxxmh_rwpxxmh_1"> Process</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabrmsxxmh_rwpxxmh_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblrmsxxmh_rwpxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_rmsxxmh</th>
										<th>Kode</th>
										<th>Nama</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/rmsxxmh/fn/rmsxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtrmsxxmh, tblrmsxxmh, show_deleted_rmsxxmh = 0, id_rmsxxmh;
	var edtrmsxxmh_rwpxxmh, tblrmsxxmh_rwpxxmh, show_deleted_rmsxxmh_rwpxxmh = 0, id_rmsxxmh_rwpxxmh;
	// ------------- end of default variable

	var id_rwpxxmh_old = 0;

	// get tableRelation
	tableRelation('rmsxxmh');

	$(document).ready(function() {
		
		// BEGIN rmsxxmh
		edtrmsxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/rmsxxmh/rmsxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rmsxxmh = show_deleted_rmsxxmh;
				}
			},
			table: "#tblrmsxxmh",
			fields: [ 
				{
					label: "rmsxxmh.start_at",
					name: "rmsxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "rmsxxmh.finish_at",
					name: "rmsxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "rmsxxmh",
					type: "hidden"
				},	
				{
					label: "rmsxxmh.transaction_state",
					name: "rmsxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "rmsxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "rmsxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "rmsxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtrmsxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrmsxxmh.field('rmsxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblrmsxxmh.rows().deselect();
			}
		});

		edtrmsxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtrmsxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtrmsxxmh.field('rmsxxmh.kode').val();
				nama = edtrmsxxmh.field('rmsxxmh.nama').val();

				validasiRequired(
					edtrmsxxmh,
					'rmsxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtrmsxxmh,
					'rmsxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_rmsxxmh
				);

				validasiUnique(
					action,
					edtrmsxxmh,
					'rmsxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_rmsxxmh
				);
			}
			
			if ( edtrmsxxmh.inError() ) {
				return false;
			}
		});

		edtrmsxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrmsxxmh.field('rmsxxmh.finish_at').val(finish_at);
		});
		
		edtrmsxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtrmsxxmh.on( 'close', function () {
			edtrmsxxmh.enable();
		} );
		
		tblrmsxxmh = $('#tblrmsxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/rmsxxmh/rmsxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rmsxxmh = show_deleted_rmsxxmh;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "rmsxxmh.id",visible:false },
				{ data: "rmsxxmh.kode" },
				{ data: "rmsxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_rmsxxmh';
					$table       = 'tblrmsxxmh';
					$edt         = 'edtrmsxxmh';
					$show_status = '_rmsxxmh';
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
				if ( data.rmsxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.rmsxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblrmsxxmh.searchPanes.container().appendTo('#sprmsxxmh');
		tblrmsxxmh.searchBuilder.container().appendTo( '#sbrmsxxmh' );
		
		tblrmsxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblrmsxxmh_rwpxxmh];
			CekInitHeaderHD(tblrmsxxmh, tbl_details);
		} );
		
		tblrmsxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('rmsxxmh');
			
			// atur hak akses
			tbl_details = [tblrmsxxmh_rwpxxmh];
			CekSelectHeaderHD(tblrmsxxmh, tbl_details);

		} );
		
		tblrmsxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('rmsxxmh');

			// atur hak akses
			tbl_details = [tblrmsxxmh_rwpxxmh];
			CekDeselectHeaderHD(tblrmsxxmh, tbl_details);
		} );
		// END rmsxxmh

		// BEGIN rmsxxmh_rwpxxmh
		edtrmsxxmh_rwpxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/rmsxxmh/rmsxxmh_rwpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rmsxxmh_rwpxxmh = show_deleted_rmsxxmh_rwpxxmh;
					d.id_rmsxxmh = id_rmsxxmh;
				}
			},
			table: "#tblrmsxxmh_rwpxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "rmsxxmh_rwpxxmh.start_at",
					name: "rmsxxmh_rwpxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "rmsxxmh_rwpxxmh.finish_at",
					name: "rmsxxmh_rwpxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "rmsxxmh_rwpxxmh",
					type: "hidden"
				},	
				{
					label: "rmsxxmh_rwpxxmh.transaction_state",
					name: "rmsxxmh_rwpxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_rmsxxmh",
					name: "rmsxxmh_rwpxxmh.id_rmsxxmh",
					type: "hidden"
				},	
				{
					label: "Process",
					name: "rmsxxmh_rwpxxmh.id_rwpxxmh",
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
					label: "Keterangan",
					name: "rmsxxmh_rwpxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtrmsxxmh_rwpxxmh.on( 'preOpen', function( e, mode, action ) {
			edtrmsxxmh_rwpxxmh.field('rmsxxmh_rwpxxmh.id_rmsxxmh').val(id_rmsxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrmsxxmh_rwpxxmh.field('rmsxxmh_rwpxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblrmsxxmh_rwpxxmh.rows().deselect();
			}
		});

		edtrmsxxmh_rwpxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtrmsxxmh_rwpxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_rmsxxmh = edtrmsxxmh_rwpxxmh.field('rmsxxmh_rwpxxmh.id_rmsxxmh').val();
				id_rwpxxmh = edtrmsxxmh_rwpxxmh.field('rmsxxmh_rwpxxmh.id_rwpxxmh').val();

				validasiRequired(
					edtrmsxxmh_rwpxxmh,
					'rmsxxmh_rwpxxmh',
					{
						'id_rwpxxmh': id_rwpxxmh
					}
				);

				validasiUnique(
					action,
					edtrmsxxmh_rwpxxmh,
					'rmsxxmh_rwpxxmh',
					'id_rwpxxmh',
					'id_rmsxxmh,id_rwpxxmh',
					id_rmsxxmh+','+id_rwpxxmh,
					id_rmsxxmh_rwpxxmh
				);

			}
			
			if ( edtrmsxxmh_rwpxxmh.inError() ) {
				return false;
			}
		});

		edtrmsxxmh_rwpxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtrmsxxmh_rwpxxmh.field('rmsxxmh_rwpxxmh.finish_at').val(finish_at);
		});
			
		edtrmsxxmh_rwpxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblrmsxxmh.ajax.reload(null, false);
		} );

		edtrmsxxmh_rwpxxmh.on( 'close', function () {
			edtrmsxxmh_rwpxxmh.enable();
		} );
		
		tblrmsxxmh_rwpxxmh = $('#tblrmsxxmh_rwpxxmh').DataTable( {
			ajax: {
				url: "../../models/rmsxxmh/rmsxxmh_rwpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_rmsxxmh_rwpxxmh = show_deleted_rmsxxmh_rwpxxmh;
					d.id_rmsxxmh = id_rmsxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "rmsxxmh_rwpxxmh.id",visible:false },
				{ data: "rmsxxmh_rwpxxmh.id_rmsxxmh",visible:false },
				{ data: "rwpxxmh.kode" },
				{ data: "rwpxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_rmsxxmh_rwpxxmh';
					$table       = 'tblrmsxxmh_rwpxxmh';
					$edt         = 'edtrmsxxmh_rwpxxmh';
					$show_status = '_rmsxxmh_rwpxxmh';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblrmsxxmh_rwpxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblrmsxxmh_rwpxxmh, 1 );
			CekDrawDetailHDFinal(tblrmsxxmh);
		} );

		tblrmsxxmh_rwpxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('rmsxxmh_rwpxxmh');
			id_rwpxxmh_old = rmsxxmh_rwpxxmh_data.id_rwpxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblrmsxxmh_rwpxxmh );
		} );

		tblrmsxxmh_rwpxxmh.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('rmsxxmh_rwpxxmh');
			id_rwpxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblrmsxxmh_rwpxxmh );
		} );
		// END rmsxxmh_rwpxxmh

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
