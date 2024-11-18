<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wrexxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wrexxth_wreittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFwrexxth" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode">
												<input type="text" id="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="table-responsive">
                    <table id="tblwrexxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Receive Order</th>
                                <th>Supplier</th>
                                <th>Plat Nomor</th>
                                <th>Driver</th>
                                <th>No Container</th>
                                <th>No Seal</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabwrexxth_wreittd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwrexxth_wreittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwrexxth_wreittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_wrexxth</th>
										<th>Receive Entry</th>
										<th>LPN</th>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>UoM</th>
										<th>Qty</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wrexxth/fn/wrexxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwrexxth, tblwrexxth, show_deleted_wrexxth = 0, id_wrexxth;
	var edtwrexxth_wreittd, tblwrexxth_wreittd, show_deleted_wrexxth_wreittd = 0, id_wrexxth_wreittd;
	// ------------- end of default variable
	var id_wroxxth_old = 0, tanggal = '', id_wreittd_old = 0;

	// get tableRelation
	tableRelation('wrexxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wrexxth
		edtwrexxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wrexxth/wrexxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wrexxth = show_deleted_wrexxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwrexxth",
			fields: [ 
				{
					label: "wrexxth.start_at",
					name: "wrexxth.start_at",
					type: "hidden"
				},	
				{
					label: "wrexxth.finish_at",
					name: "wrexxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wrexxth",
					type: "hidden"
				},	
				{
					label: "wrexxth.transaction_state",
					name: "wrexxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Receive Order <sup class='text-danger'>*<sup>",
					name: "wrexxth.id_wroxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wroxxth/wroxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wroxxth_old: id_wroxxth_old,
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "wrexxth.tanggal",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wrexxth/tanggal_wreittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_wroxxth = edtwrexxth.field('wrexxth.id_wroxxth').val();
								console.log(id_wroxxth);
								var query = {
									tanggal: tanggal,
									id_wroxxth: id_wroxxth,
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
					label: "Plat Nomor",
					name: "wrexxth.plat_nomor",
				},
				{
					label: "Driver",
					name: "wrexxth.driver",
				},
				{
					label: "No Container",
					name: "wrexxth.no_container",
				},
				{
					label: "No Seal",
					name: "wrexxth.no_seal",
				},
			]
		} );
		
		edtwrexxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwrexxth.field('wrexxth.start_at').val(start_at);

			if(action == 'create'){
				tblwrexxth.rows().deselect();
				edtwrexxth.field('wrexxth.id_wroxxth').enable();
				edtwrexxth.field('wrexxth.tanggal').enable();
			} else if(action == 'edit'){
				edtwrexxth.field('wrexxth.id_wroxxth').disable();
				edtwrexxth.field('wrexxth.tanggal').disable();
			} 
		});

		edtwrexxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtwrexxth.dependent( 'wrexxth.no_container', function ( val, data, callback ) {
			if (val != '') {
				edtwrexxth.field('wrexxth.no_seal').label("No Seal <sup class='text-danger'>*<sup>")
			} else {
				edtwrexxth.field('wrexxth.no_seal').label("No Seal")
			}
			return {}
		}, {event: 'keyup change'});
		
		edtwrexxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_wroxxth = edtwrexxth.field('wrexxth.id_wroxxth').val();
				tanggal = edtwrexxth.field('wrexxth.tanggal').val();
				no_container = edtwrexxth.field('wrexxth.no_container').val();
				no_seal = edtwrexxth.field('wrexxth.no_seal').val();

				validasiRequired(
					edtwrexxth,
					'wrexxth',
					{
						'id_wroxxth': id_wroxxth,
						'tanggal': tanggal
					}
				);

				if (no_container != '') {
					validasiRequired(
						edtwrexxth,
						'wrexxth',
						{
							'no_seal': no_seal,
						}
					);
				}

				// validasiUnique(
				// 	action,
				// 	edtwrexxth,
				// 	'wrexxth',
				// 	'id_wroxxth',
				// 	'id_wroxxth',
				// 	'"'+id_wroxxth+'"',
				// 	id_wrexxth
				// );
			}
			
			if ( edtwrexxth.inError() ) {
				return false;
			}
		});

		edtwrexxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwrexxth.field('wrexxth.finish_at').val(finish_at);
		});
		
		edtwrexxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblwrexxth.ajax.reload(null, false);
			tblwrexxth.rows().deselect();
			tblwrexxth_wreittd.ajax.reload(null, false);
		} );

		edtwrexxth.on( 'close', function () {
			edtwrexxth.enable();
		} );
		
		tblwrexxth = $('#tblwrexxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wrexxth/wrexxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wrexxth = show_deleted_wrexxth;
					d.start_date = start_date;
					d.end_date = end_date;
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
				{ data: "wrexxth.id",visible:false },
				{ data: "wrexxth.kode" },
				{ data: "wrexxth.tanggal" },
				{ data: "wroxxth.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "wrexxth.plat_nomor" },
				{ data: "wrexxth.driver" },
				{ data: "wrexxth.no_container" },
				{ data: "wrexxth.no_seal" },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wrexxth';
					$table       = 'tblwrexxth';
					$edt         = 'edtwrexxth';
					$show_status = '_wrexxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					// $arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrintSlip',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Slip',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('wrexxth_print.php?id_transaksi='+id_wrexxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wrexxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wrexxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwrexxth.searchPanes.container().appendTo('#spwrexxth');
		tblwrexxth.searchBuilder.container().appendTo( '#sbwrexxth' );
		
		tblwrexxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwrexxth_wreittd];
			CekInitHeaderHD(tblwrexxth, tbl_details);
			tblwrexxth.button('btnPrintSlip:name').disable();
		} );
		
		tblwrexxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wrexxth');
			id_wroxxth_old = wrexxth_data.id_wroxxth;
			tanggal = wrexxth_data.tanggal;
			console.log(tanggal);
			
			// atur hak akses
			tbl_details = [tblwrexxth_wreittd];
			CekSelectHeaderHD(tblwrexxth, tbl_details);
			tblwrexxth.button('btnPrintSlip:name').enable();
		} );
		
		tblwrexxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wrexxth');
			id_wroxxth_old = 0;
			tanggal = '';

			// atur hak akses
			tbl_details = [tblwrexxth_wreittd];
			CekDeselectHeaderHD(tblwrexxth, tbl_details);
			tblwrexxth.button('btnPrintSlip:name').disable();
		} );
		// END wrexxth

		// BEGIN wrexxth_wreittd
		edtwrexxth_wreittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wrexxth/wrexxth_wreittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wrexxth_wreittd = show_deleted_wrexxth_wreittd;
					d.id_wrexxth = id_wrexxth;
				}
			},
			table: "#tblwrexxth_wreittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "wrexxth_wreittd.start_at",
					name: "wrexxth_wreittd.start_at",
					type: "hidden"
				},	
				{
					label: "wrexxth_wreittd.finish_at",
					name: "wrexxth_wreittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wrexxth_wreittd",
					type: "hidden"
				},	
				{
					label: "wrexxth_wreittd.transaction_state",
					name: "wrexxth_wreittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wrexxth",
					name: "wrexxth_wreittd.id_wrexxth",
					type: "hidden"
				},	
				{
					label: "Receive Entry <sup class='text-danger'>*<sup>",
					name: "wrexxth_wreittd.id_wreittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wreittd/wreittd_slip_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wreittd_old: id_wreittd_old,
									tanggal: tanggal,
									id_wroxxth_old: id_wroxxth_old,
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
			
		edtwrexxth_wreittd.on( 'preOpen', function( e, mode, action ) {
			edtwrexxth_wreittd.field('wrexxth_wreittd.id_wrexxth').val(id_wrexxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwrexxth_wreittd.field('wrexxth_wreittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwrexxth_wreittd.rows().deselect();
			}
		});

		edtwrexxth_wreittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtwrexxth_wreittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_wreittd = edtwrexxth_wreittd.field('wrexxth_wreittd.id_wreittd').val();

				validasiRequired(
					edtwrexxth_wreittd,
					'wrexxth_wreittd',
					{
						'id_wreittd': id_wreittd
					}
				);

				validasiUnique(
					action,
					edtwrexxth_wreittd,
					'wrexxth_wreittd',
					'id_wreittd',
					'id_wreittd',
					'"'+id_wreittd+'"',
					id_wrexxth_wreittd
				);	
			}
			
			if ( edtwrexxth_wreittd.inError() ) {
				return false;
			}
		});

		edtwrexxth_wreittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwrexxth_wreittd.field('wrexxth_wreittd.finish_at').val(finish_at);
		});
			
		edtwrexxth_wreittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtwrexxth_wreittd.on( 'close', function () {
			edtwrexxth_wreittd.enable();
		} );
		
		tblwrexxth_wreittd = $('#tblwrexxth_wreittd').DataTable( {
			ajax: {
				url: "../../models/wrexxth/wrexxth_wreittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wrexxth_wreittd = show_deleted_wrexxth_wreittd;
					d.id_wrexxth = id_wrexxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "wrexxth_wreittd.id",visible:false },
				{ data: "wrexxth_wreittd.id_wrexxth",visible:false },
				{ data: "wreittd.kode" },
				{ data: "wreittd.wlpxxmh_kode" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wreittd.jumlah_unit" ,
					...renderNumber()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wrexxth_wreittd';
					$table       = 'tblwrexxth_wreittd';
					$edt         = 'edtwrexxth_wreittd';
					$show_status = '_wrexxth_wreittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'remove','view', 'log','noactionD'];
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

		tblwrexxth_wreittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwrexxth_wreittd, 1 );
			CekDrawDetailHDFinal(tblwrexxth);
		} );

		tblwrexxth_wreittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wrexxth_wreittd');
			id_wreittd_old = wrexxth_wreittd_data.id_wreittd;
			
			// atur hak akses
			CekSelectDetailHD( tblwrexxth_wreittd );
		} );

		tblwrexxth_wreittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wrexxth_wreittd');
			id_wreittd_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwrexxth_wreittd );
		} );
		// END wrexxth_wreittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwrexxth.rows().deselect();
				tblwrexxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwrexxth').modal('toggle');
			}, false);
				return false;
			}
		});
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
