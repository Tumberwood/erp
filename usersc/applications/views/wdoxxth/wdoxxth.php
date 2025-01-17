<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wdoxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wdoittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFwdoxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<table id="tblwdoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nomor</th>
							<th>Tanggal</th>
							<th>Customer</th>
							<th>No Referensi</th>
							<th>Status</th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabwdoittd_1"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwdoittd_1" class="tab-pane active">
					<div class="panel-body">
						<table id="tblwdoittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_wdoxxth</th>
									<th>Item Code</th>
									<th>Item Name</th>
									<th>UoM</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th id="c_item"></th>
									<th></th>
									<th></th>
								</tr>
							</tfoot>
						</table>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdoxxth/fn/wdoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwdoxxth, tblwdoxxth, show_deleted_wdoxxth = 0, id_wdoxxth;
	var edtwdoittd, tblwdoittd, show_deleted_wdoittd = 0, id_wdoittd;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_wttxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, id_iumxxmh_unit  = 0;

	// get tableRelation
	tableRelation('wdoxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wdoxxth
		edtwdoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wdoxxth/wdoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdoxxth = show_deleted_wdoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwdoxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	
				{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	
				{
					label: "wdoxxth.start_at",
					name: "wdoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wdoxxth.finish_at",
					name: "wdoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wdoxxth",
					type: "hidden"
				},	
				{
					label: "wdoxxth.transaction_state",
					name: "wdoxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Customer <sup class='text-danger'>*<sup>",
					name: "wdoxxth.id_grlxxmh_customer",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/scuxxmh/scuxxmh_fn_opt.php",
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
					label: "Transaction Type <sup class='text-danger'>*<sup>",
					name: "wdoxxth.id_wttxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wttxxmh/wttxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wttxxmh_old: id_wttxxmh_old,
									movement_type_group: '2',
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
					name: "wdoxxth.tanggal",
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
					label: "No Referensi <sup class='text-danger'>*<sup>",
					name: "wdoxxth.no_ref",
				},
				{
					label: "Keterangan",
					name: "wdoxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtwdoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdoxxth.field('wdoxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwdoxxth.rows().deselect();
				edtwdoxxth.field('kategori_dokumen').val('');
				edtwdoxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtwdoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			edtFormButtonSaveConfirmHD();
			
		});
		
		edtwdoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_grlxxmh_customer = edtwdoxxth.field('wdoxxth.id_grlxxmh_customer').val();
				id_wttxxmh = edtwdoxxth.field('wdoxxth.id_wttxxmh').val();
				no_ref = edtwdoxxth.field('wdoxxth.no_ref').val();
				tanggal       = edtwdoxxth.field('wdoxxth.tanggal').val();

				validasiRequired(
					edtwdoxxth,
					'wdoxxth',
					{
						'id_grlxxmh_customer': id_grlxxmh_customer,
						'id_wttxxmh': id_wttxxmh,
						'no_ref': no_ref,
						'tanggal'   : tanggal
					}
				);
			
			}
			
			if ( edtwdoxxth.inError() ) {
				return false;
			}
		});

		edtwdoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdoxxth.field('wdoxxth.finish_at').val(finish_at);

		});
		
		edtwdoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			
		} );

		edtwdoxxth.on( 'close', function () {
			edtwdoxxth.enable();
		} );
		
		tblwdoxxth = $('#tblwdoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wdoxxth/wdoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdoxxth = show_deleted_wdoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
			responsive: false,
			scrollX: true,
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "wdoxxth.id",visible:false },
				{ data: "wdoxxth.kode" },
				{ data: "wdoxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "wdoxxth.no_ref" },
				{ 
					data: "wdoxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wdoxxth';
					$table       = 'tblwdoxxth';
					$edt         = 'edtwdoxxth';
					$show_status = '_wdoxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wdoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wdoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwdoxxth.searchPanes.container().appendTo('#spwdoxxth');
		tblwdoxxth.searchBuilder.container().appendTo( '#sbwdoxxth' );
		
		tblwdoxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwdoittd];
			CekInitHeaderHD(tblwdoxxth, tbl_details);
		} );
		
		tblwdoxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('wdoxxth');
			id_grlxxmh_old    = wdoxxth_data.id_grlxxmh_customer;
			id_wttxxmh_old    = wdoxxth_data.id_wttxxmh;

			// atur hak akses
			tbl_details = [tblwdoittd];
			CekSelectHeaderHD(tblwdoxxth, tbl_details);

		} );
		
		tblwdoxxth.on( 'deselect', function () {
			siVarReset('wdoxxth');
			id_grlxxmh_old = 0;
			id_wttxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblwdoittd];
			CekDeselectHeaderHD(tblwdoxxth, tbl_details);
		} );
		// END wdoxxth

		// BEGIN wdoittd
		edtwdoittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wdoxxth/wdoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdoittd = show_deleted_wdoittd;
					d.id_wdoxxth = id_wdoxxth;
				}
			},
			table: "#tblwdoittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "wdoittd.start_at",
					name: "wdoittd.start_at",
					type: "hidden"
				},	
				{
					label: "wdoittd.finish_at",
					name: "wdoittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wdoittd",
					type: "hidden"
				},	
				{
					label: "wdoittd.transaction_state",
					name: "wdoittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wdoxxth",
					name: "wdoittd.id_wdoxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wdoittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iitxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									ids_iitxxmh: 1,
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
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wdoittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "wdoittd.jumlah_unit"
				}, 	
				{
					label: "Keterangan",
					name: "wdoittd.keterangan",
					type: "textarea"
				}
			]
		} );

		//masking
		unmaskedData = maskingNumber(
			edtwdoittd, 
			"wdoittd", 
			[
				"jumlah_unit", 
			],
			2,
		);
			
		edtwdoittd.on( 'preOpen', function( e, mode, action ) {
			edtwdoittd.field('wdoittd.id_wdoxxth').val(id_wdoxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdoittd.field('wdoittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwdoittd.rows().deselect();
			}
		});

		edtwdoittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtwdoittd.dependent( 'wdoittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtwdoittd.field('wdoittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});

		edtwdoittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_iumxxmh_unit = edtwdoittd.field('wdoittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtwdoittd.field('wdoittd.id_iimxxmh').val();
				jumlah_unit = unmaskedData.jumlah_unit;

				validasiRequired(
					edtwdoittd,
					'wdoittd',
					{
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_iimxxmh': id_iimxxmh,
					}
				);
				
				validasiNumber(
					edtwdoittd,
					'wdoittd',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);

			}
			
			if ( edtwdoittd.inError() ) {
				return false;
			}
		});

		edtwdoittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdoittd.field('wdoittd.finish_at').val(finish_at);
		});
			
		edtwdoittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].wdoittd.id;
            	konversiUom('wdoittd', id_transaksi );

				tblwdoittd.rows().deselect();
			}
			
			tblwdoxxth.ajax.reload(null, false);
			tblwdoittd.ajax.reload(null, false);
		} );

		edtwdoittd.on( 'close', function () {
			edtwdoittd.enable();
		} );
		
		tblwdoittd = $('#tblwdoittd').DataTable( {
			ajax: {
				url: "../../models/wdoxxth/wdoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdoittd = show_deleted_wdoittd;
					d.id_wdoxxth = id_wdoxxth;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "wdoittd.id",visible:false },
				{ data: "wdoittd.id_wdoxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "wdoittd.jumlah_unit",
					...renderNumber( 0, "")
				}

			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wdoittd';
					$table       = 'tblwdoittd';
					$edt         = 'edtwdoittd';
					$show_status = '_wdoittd';
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
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
			}
		} );

		tblwdoittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblwdoittd, 1);
			CekDrawDetailHDFinal(tblwdoxxth);
		} );

		tblwdoittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('wdoittd')

			id_iimxxmh          = wdoittd_data.id_iimxxmh;
			id_iimxxmh_old      = wdoittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wdoittd_data.id_iumxxmh_unit;

			// atur hak akses
			CekSelectDetailHD(tblwdoittd );
		} );

		tblwdoittd.on( 'deselect', function() {
			siVarResetD('wdoittd')
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblwdoxxth, tblwdoittd );
		} );

		// END wdoittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwdoxxth.rows().deselect();
				tblwdoxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwdoxxth').modal('toggle');
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
