<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ndctoth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ndctotd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndctoth" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabndctotd"> Document</a></li>				
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabndctotd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblndctotd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ndctoth</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndctoth/fn/ndctoth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtndctoth, tblndctoth, show_deleted_ndctoth = 0, id_ndctoth;
	var edtndctotd, tblndctotd, show_deleted_ndctotd = 0, id_ndctotd;
	// ------------- end of default variable

	var id_users_penerima_old = 0;
	var id_ndcxxmh_old = 0;

	// get tableRelation
	tableRelation('ndctoth');

	$(document).ready(function() {
		
		// BEGIN ndctoth
		edtndctoth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndctoth/ndctoth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctoth = show_deleted_ndctoth;
				}
			},
			table: "#tblndctoth",
			fields: [ 
				{
					label: "ndctoth.start_at",
					name: "ndctoth.start_at",
					type: "hidden"
				},	
				{
					label: "ndctoth.finish_at",
					name: "ndctoth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndctoth",
					type: "hidden"
				},	
				{
					label: "ndctoth.transaction_state",
					name: "ndctoth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal Jam Penyerahan <sup class='text-danger'>*<sup>",
					name: "ndctoth.tanggal_jam_to",
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
					name: "ndctoth.id_users_penerima",
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
					name: "ndctoth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtndctoth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctoth.field('ndctoth.start_at').val(start_at);

			if(action == 'create'){
				tblndctoth.rows().deselect();
			}
		});

		edtndctoth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtndctoth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_jam_to = edtndctoth.field('ndctoth.tanggal_jam_to').val();
				id_users_penerima = edtndctoth.field('ndctoth.id_users_penerima').val();

				validasiRequired(
					edtndctoth,
					'ndctoth',
					{
						'tanggal_jam_to': tanggal_jam_to,
						'id_users_penerima': id_users_penerima
					}
				);

			}
			
			if ( edtndctoth.inError() ) {
				return false;
			}
		});

		edtndctoth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctoth.field('ndctoth.finish_at').val(finish_at);
		});
		
		edtndctoth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtndctoth.on( 'close', function () {
			edtndctoth.enable();
		} );
		
		tblndctoth = $('#tblndctoth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndctoth/ndctoth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctoth = show_deleted_ndctoth;
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
				{ data: "ndctoth.id",visible:false },
				{ data: "ndctoth.kode" },
				{ data: "ndctoth.tanggal_jam_to" },
				{ data: "users_pengirim.username" },
				{ data: "users_penerima.username" },
				{ data: "ndctoth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndctoth';
					$table       = 'tblndctoth';
					$edt         = 'edtndctoth';
					$show_status = '_ndctoth';
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
				if ( data.ndctoth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ndctoth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblndctoth.searchPanes.container().appendTo('#spndctoth');
		tblndctoth.searchBuilder.container().appendTo( '#sbndctoth' );
		
		tblndctoth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblndctotd];
			CekInitHeaderHD(tblndctoth, tbl_details);
		} );
		
		tblndctoth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('ndctoth');
			id_users_penerima_old    = ndctoth_data.id_users_penerima;
			
			// atur hak akses
			tbl_details = [tblndctotd];
			CekSelectHeaderHD(tblndctoth, tbl_details);

		} );
		
		tblndctoth.on( 'deselect', function () {
			siVarReset('ndctoth');

			id_users_penerima_old = 0;

			// atur hak akses
			tbl_details = [tblndctotd];
			CekDeselectHeaderHD(tblndctoth, tbl_details);
		} );
		// END ndctoth

		// BEGIN ndctotd
		edtndctotd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndctoth/ndctotd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctotd = show_deleted_ndctotd;
					d.id_ndctoth = id_ndctoth;
				}
			},
			table: "#tblndctotd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ndctotd.start_at",
					name: "ndctotd.start_at",
					type: "hidden"
				},	
				{
					label: "ndctotd.finish_at",
					name: "ndctotd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndctotd",
					type: "hidden"
				},	
				{
					label: "ndctotd.transaction_state",
					name: "ndctotd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ndctoth",
					name: "ndctotd.id_ndctoth",
					type: "hidden"
				},	
				{
					label: "Document No <sup class='text-danger'>*<sup>",
					name: "ndctotd.id_ndcxxmh",
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
									document_state: 'in',
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
					name: "ndcrctd.kepada",
					type: "readonly"
				}, 	
				{
					label: "Keterangan",
					name: "ndctotd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtndctotd.on( 'preOpen', function( e, mode, action ) {
			edtndctotd.field('ndctotd.id_ndctoth').val(id_ndctoth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctotd.field('ndctotd.start_at').val(start_at);
			
			if(action == 'create'){
				tblndctotd.rows().deselect();
			}
		});

		edtndctotd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtndctotd.dependent( 'ndctotd.id_ndcxxmh', function ( val, data, callback ) {
			id_ndcxxmh = edtndctotd.field('ndctotd.id_ndcxxmh').val();
			autofillField('ndcrctd', id_ndcxxmh, 'kepada');
			edtndctotd.field('ndcrctd.kepada').val(autofillData.kepada);
			return {}
		}, {event: 'keyup change'});

		edtndctotd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_ndcxxmh = edtndctotd.field('ndctotd.id_ndcxxmh').val();

				validasiRequired(
					edtndctotd,
					'ndctotd',
					{
						'id_ndcxxmh': id_ndcxxmh
					}
				);

				validasiUnique(
					action,
					edtndctotd,
					'ndctotd',
					'id_ndcxxmh',
					'id_ndcxxmh,id_ndctoth',
					id_ndcxxmh + ',' + id_ndctoth,
					id_ndctotd
				);

			}
			
			if ( edtndctotd.inError() ) {
				return false;
			}
		});

		edtndctotd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndctotd.field('ndctotd.finish_at').val(finish_at);
		});
			
		edtndctotd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblndctoth.rows().deselect();
			tblndctoth.ajax.reload(null, false);
			tblndctotd.rows().deselect();
			tblndctotd.ajax.reload(null, false);
		} );

		edtndctotd.on( 'close', function () {
			edtndctotd.enable();
		} );
		
		tblndctotd = $('#tblndctotd').DataTable( {
			ajax: {
				url: "../../models/ndctoth/ndctotd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndctotd = show_deleted_ndctotd;
					d.id_ndctoth = id_ndctoth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "ndctotd.id",visible:false },
				{ data: "ndctotd.id_ndctoth",visible:false },
				{ data: "ndcxxmh.dokumen_nomor" },
				{ data: "ndcrctd.pengirim" },
				{ data: "ndcrctd.kepada" },
				{ data: "ndcrctd.tanggal_jam_terima" },
				{ data: "ndctotd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndctotd';
					$table       = 'tblndctotd';
					$edt         = 'edtndctotd';
					$show_status = '_ndctotd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
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

		tblndctotd.on( 'draw', function( e, settings ) { 
			CekDrawDetailHD( tblndctotd, 1 );
			CekDrawDetailHDFinal(tblndctoth);
		} );

		tblndctotd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('ndctotd');
			id_ndcxxmh_old   = data_ndctotd.id_ndcxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblndctoth, tblndctotd );
		} );

		tblndctotd.on( 'deselect', function() {
			siVarResetD('ndctotd');
			id_ndcxxmh_old = 0;
			// atur hak akses
			CekDeselectDetailHD(tblndctoth, tblndctotd );
		} );
		// END ndctotd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
