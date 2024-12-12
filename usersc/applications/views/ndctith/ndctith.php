<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ndctith';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ndctitd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndctith" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabndctitd"> Document</a></li>				
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabndctitd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblndctitd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ndctith</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndctith/fn/ndctith_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtndctith, tblndctith, show_deleted_ndctith = 0, id_ndctith;
	var edtndctitd, tblndctitd, show_deleted_ndctitd = 0, id_ndctitd;
	// ------------- end of default variable

	var id_ndctoth_old = 0;
	var id_ndcxxmh_old = 0;

	// get tableRelation
	tableRelation('ndctith');

	$(document).ready(function() {
		
		// BEGIN ndctith
		edtndctith = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndctith/ndctith.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctith = show_deleted_ndctith;
				}
			},
			table: "#tblndctith",
			fields: [ 
				{
					label: "ndctith.start_at",
					name: "ndctith.start_at",
					type: "hidden"
				},	
				{
					label: "ndctith.finish_at",
					name: "ndctith.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndctith",
					type: "hidden"
				},	
				{
					label: "ndctith.transaction_state",
					name: "ndctith.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal Jam Terima <sup class='text-danger'>*<sup>",
					name: "ndctith.tanggal_jam_ti",
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
					name: "ndctith.id_ndctoth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/ndctoth/ndctoth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_ndctoth_old: id_ndctoth_old,
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
					name: "ndctith.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtndctith.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctith.field('ndctith.start_at').val(start_at);

			if(action == 'create'){
				tblndctith.rows().deselect();
			}
		});

		edtndctith.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtndctith.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_jam_ti = edtndctith.field('ndctith.tanggal_jam_ti').val();
				id_ndctoth = edtndctith.field('ndctith.id_ndctoth').val();

				validasiRequired(
					edtndctith,
					'ndctith',
					{
						'tanggal_jam_ti': tanggal_jam_ti,
						'id_ndctoth': id_ndctoth
					}
				);

			}
			
			if ( edtndctith.inError() ) {
				return false;
			}
		});

		edtndctith.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctith.field('ndctith.finish_at').val(finish_at);
		});
		
		edtndctith.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndctith.on( 'close', function () {
			edtndctith.enable();
		} );
		
		tblndctith = $('#tblndctith').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndctith/ndctith.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctith = show_deleted_ndctith;
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
				{ data: "ndctith.id",visible:false },
				{ data: "ndctith.kode" },
				{ data: "ndctoth.kode" },
				{ data: "ndctith.tanggal_jam_ti" },
				{ data: "users_pengirim.username" },
				{ data: "users_penerima.username" },
				{ data: "ndctith.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndctith';
					$table       = 'tblndctith';
					$edt         = 'edtndctith';
					$show_status = '_ndctith';
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
				if ( data.ndctith.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ndctith.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblndctith.searchPanes.container().appendTo('#spndctith');
		tblndctith.searchBuilder.container().appendTo( '#sbndctith' );
		
		tblndctith.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblndctitd];
			CekInitHeaderHD(tblndctith, tbl_details);
		} );
		
		tblndctith.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('ndctith');
			id_users_penerima_old    = ndctith_data.id_users_penerima;
			
			// atur hak akses
			tbl_details = [tblndctitd];
			CekSelectHeaderHD(tblndctith, tbl_details);

		} );
		
		tblndctith.on( 'deselect', function () {
			siVarReset('ndctith');
			id_users_penerima_old = 0;

			// atur hak akses
			tbl_details = [tblndctitd];
			CekDeselectHeaderHD(tblndctith, tbl_details);
		} );
		// END ndctith

		// BEGIN ndctitd
		edtndctitd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndctith/ndctitd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctitd = show_deleted_ndctitd;
					d.id_ndctith = id_ndctith;
				}
			},
			table: "#tblndctitd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ndctitd.start_at",
					name: "ndctitd.start_at",
					type: "hidden"
				},	
				{
					label: "ndctitd.finish_at",
					name: "ndctitd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndctitd",
					type: "hidden"
				},	
				{
					label: "ndctitd.transaction_state",
					name: "ndctitd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ndctith",
					name: "ndctitd.id_ndctith",
					type: "hidden"
				},	
				{
					label: "Document No <sup class='text-danger'>*<sup>",
					name: "ndctitd.id_ndcrctd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/ndcxxmh/ndcxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_ndcxxmh_old: id_ndcxxmh_old,
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
					name: "ndctitd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtndctitd.on( 'preOpen', function( e, mode, action ) {
			edtndctitd.field('ndctitd.id_ndctith').val(id_ndctith);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctitd.field('ndctitd.start_at').val(start_at);
			
			if(action == 'create'){
				tblndctitd.rows().deselect();
			}
		});

		edtndctitd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtndctitd.dependent( 'ndctitd.id_ndcrctd', function ( val, data, callback ) {
			id_ndcrctd = edtndctitd.field('ndctitd.id_ndcrctd').val();
			autofillField('ndcrctd', id_ndcrctd, 'kepada');

			edtndctitd.field('kepada').val(autofillData.kepada);
			
			return {}
		}, {event: 'keyup change'});

		edtndctitd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_ndcrctd = edtndctitd.field('ndctitd.id_ndcrctd').val();

				validasiRequired(
					edtndctitd,
					'ndctitd',
					{
						'id_ndcrctd': id_ndcrctd
					}
				);

				validasiUnique(
					action,
					edtndctitd,
					'ndctitd',
					'id_ndcrctd',
					'id_ndcrctd,id_ndctith',
					id_ndcrctd + ',' + id_ndctith,
					id_ndctitd
				);

			}
			
			if ( edtndctitd.inError() ) {
				return false;
			}
		});

		edtndctitd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctitd.field('ndctitd.finish_at').val(finish_at);
		});
			
		edtndctitd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblndctith.rows().deselect();
			tblndctith.ajax.reload(null, false);
		} );

		edtndctitd.on( 'close', function () {
			edtndctitd.enable();
		} );
		
		tblndctitd = $('#tblndctitd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndctith/ndctitd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctitd = show_deleted_ndctitd;
					d.id_ndctith = id_ndctith;
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
				{ data: "ndctitd.id",visible:false },
				{ data: "ndctitd.id_ndctith",visible:false },
				{ data: "ndcxxmh.dokumen_nomor" },
				{ data: "ndcrctd.pengirim" },
				{ data: "ndcrctd.kepada" },
				{ data: "ndcrctd.tanggal_jam_terima" },
				{ data: "ndctitd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndctitd';
					$table       = 'tblndctitd';
					$edt         = 'edtndctitd';
					$show_status = '_ndctitd';
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

		tblndctitd.searchPanes.container().appendTo('#spndctitd');
		tblndctitd.searchBuilder.container().appendTo( '#sbndctitd' );

		tblndctitd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblndctitd, 1 );
			CekDrawDetailHDFinal(tblndctith);
		} );

		tblndctitd.on( 'select', function( e, dt, type, indexes ) {
			siVarResetD('ndctitd');
			id_ndcxxmh_old   = ndctitd_data.id_ndcxxmh;
			console.log(id_ndcxxmh_old);
			// atur hak akses
			CekSelectDetailHD( tblndctitd);
		} );

		tblndctitd.on( 'deselect', function() {
			siVarResetD('ndctitd');
			id_ndcxxmh_old = 0;
			// atur hak akses
			CekDeselectDetailHD( tblndctitd );
		} );
		// END ndctitd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
