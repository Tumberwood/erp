<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hattpmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hatcpmd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhattpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="state"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhatcpmd"> Kompensasi</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhatcpmd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhatcpmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hattpmh</th>
										<th data-i18n="compensation"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hattpmh/fn/hattpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthattpmh, tblhattpmh, show_deleted_hattpmh = 0, id_hattpmh;
	var edthatcpmd, tblhatcpmd, show_deleted_hatcpmd = 0, id_hatcpmd;
	// ------------- end of default variable

	var id_hpcxxmh_old = 0;

	// get tableRelation
	tableRelation('hattpmh');

	$(document).ready(function() {
		
		// BEGIN hattpmh
		edthattpmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hattpmh/hattpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hattpmh = show_deleted_hattpmh;
				}
			},
			table: "#tblhattpmh",
			fields: [ 
				{
					label: "hattpmh.start_at",
					name: "hattpmh.start_at",
					type: "hidden"
				},	
				{
					label: "hattpmh.finish_at",
					name: "hattpmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hattpmh",
					type: "hidden"
				},	
				{
					label: "hattpmh.transaction_state",
					name: "hattpmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "hattpmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "hattpmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hattpmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthattpmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthattpmh.field('hattpmh.start_at').val(start_at);

			if(action == 'create'){
				tblhattpmh.rows().deselect();
			}
		});

		edthattpmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthattpmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthattpmh.field('hattpmh.kode').val();
				nama = edthattpmh.field('hattpmh.nama').val();

				validasiRequired(
					edthattpmh,
					'hattpmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthattpmh,
					'hattpmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hattpmh
				);

				validasiUnique(
					action,
					edthattpmh,
					'hattpmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hattpmh
				);
			}
			
			if ( edthattpmh.inError() ) {
				return false;
			}
		});

		edthattpmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthattpmh.field('hattpmh.finish_at').val(finish_at);
		});
		
		edthattpmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthattpmh.on( 'close', function () {
			edthattpmh.enable();
		} );
		
		tblhattpmh = $('#tblhattpmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hattpmh/hattpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hattpmh = show_deleted_hattpmh;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "hattpmh.id",visible:false },
				{ data: "hattpmh.kode" },
				{ data: "hattpmh.nama" },
				{ 
					data: "hattpmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hattpmh';
					$table       = 'tblhattpmh';
					$edt         = 'edthattpmh';
					$show_status = '_hattpmh';
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
				if ( data.hattpmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hattpmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhattpmh.searchPanes.container().appendTo('#sphattpmh');
		tblhattpmh.searchBuilder.container().appendTo( '#sbhattpmh' );
		
		tblhattpmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhatcpmd];
			CekInitHeaderHD(tblhattpmh, tbl_details);
		} );
		
		tblhattpmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hattpmh');
			
			// atur hak akses
			tbl_details = [tblhatcpmd];
			CekSelectHeaderHD(tblhattpmh, tbl_details);

		} );
		
		tblhattpmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hattpmh');

			// atur hak akses
			tbl_details = [tblhatcpmd];
			CekDeselectHeaderHD(tblhattpmh, tbl_details);
		} );
		// END hattpmh

		// BEGIN hatcpmd
		edthatcpmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hattpmh/hatcpmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hatcpmd = show_deleted_hatcpmd;
					d.id_hattpmh = id_hattpmh;
				}
			},
			table: "#tblhatcpmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hatcpmd.start_at",
					name: "hatcpmd.start_at",
					type: "hidden"
				},	
				{
					label: "hatcpmd.finish_at",
					name: "hatcpmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hatcpmd",
					type: "hidden"
				},	
				{
					label: "hatcpmd.transaction_state",
					name: "hatcpmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hattpmh",
					name: "hatcpmd.id_hattpmh",
					type: "hidden"
				},	
				{
					label: getTranslation('compensation') + " <sup class='text-danger'>*<sup>",
					name: "hatcpmd.id_hpcxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hpcxxmh/hpcxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hpcxxmh_old: id_hpcxxmh_old,
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
					label: getTranslation('notes'),
					name: "hatcpmd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthatcpmd.on( 'preOpen', function( e, mode, action ) {
			edthatcpmd.field('hatcpmd.id_hattpmh').val(id_hattpmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthatcpmd.field('hatcpmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhatcpmd.rows().deselect();
			}
		});

		edthatcpmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthatcpmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hpcxxmh = edthatcpmd.field('hatcpmd.id_hpcxxmh').val();
				if(!id_hpcxxmh || id_hpcxxmh == ''){
					edthatcpmd.field('hatcpmd.id_hpcxxmh').error( 'Wajib diisi!' );
				}
			}
			
			if ( edthatcpmd.inError() ) {
				return false;
			}
		});

		edthatcpmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthatcpmd.field('hatcpmd.finish_at').val(finish_at);
		});
			
		edthatcpmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthatcpmd.on( 'close', function () {
			edthatcpmd.enable();
		} );
		
		tblhatcpmd = $('#tblhatcpmd').DataTable( {
			ajax: {
				url: "../../models/hattpmh/hatcpmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hatcpmd = show_deleted_hatcpmd;
					d.id_hattpmh = id_hattpmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hatcpmd.id",visible:false },
				{ data: "hatcpmd.id_hattpmh",visible:false },
				{ data: "hpcxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hatcpmd';
					$table       = 'tblhatcpmd';
					$edt         = 'edthatcpmd';
					$show_status = '_hatcpmd';
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

		tblhatcpmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhatcpmd, 1 );
			CekDrawDetailHDFinal(tblhattpmh);
		} );

		tblhatcpmd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hatcpmd');
			id_hpcxxmh_old = hatcpmd_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhatcpmd );
		} );

		tblhatcpmd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hatcpmd');

			id_hpcxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhatcpmd );
		} );
		// END hatcpmd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
