<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'scsxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'scsittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFscsxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmscsxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="scsxxth.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="scsxxth.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="scsxxth.id_grlxxmh_customer"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="scsxxth.id_sodxxth"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="scsxxth.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="scsxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblscsxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
								<th>Customer</th>
								<th data-toggle="tooltip" title="From SO / PO Sub Contract">Kode Transaksi</th>
								<th>Warehouse</th>
								<th>TX</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabscsittd"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabscsittd" class="tab-pane active">
					<div id="frmscsittd">
						<div class="panel-body">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.id_iimxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.id_iumxxmh_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.jumlah_unit"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.harga_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.subtotal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.diskon_jenis"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="scsittd.diskon_persen"></editor-field>
									<editor-field name="scsittd.diskon_value"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="scsittd.diskon_final"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="scsittd.dpp"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="scsittd.keterangan"></editor-field>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblscsittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_scsxxth</th>
										<th>SKU</th>
										<th>Item</th>
										<th>UoM</th>
										<th>Quantity</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/scsxxth/fn/scsxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtscsxxth, tblscsxxth, show_deleted_scsxxth = 0, id_scsxxth;
	var edtscsittd, tblscsittd, show_deleted_scsittd = 0, id_scsittd;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_sodxxth_old = 0, id_iwhxxmh_old = 0, id_sodxxth = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, diskon_jenis_select = null, harga_unit_select = null;

	// get tableRelation
	tableRelation('scsxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN scsxxth
		edtscsxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/scsxxth/scsxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_scsxxth = show_deleted_scsxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmscsxxth",
			table: "#tblscsxxth",
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
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "scsxxth.start_at",
					name: "scsxxth.start_at",
					type: "hidden"
				},	
				{
					label: "scsxxth.finish_at",
					name: "scsxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "scsxxth",
					type: "hidden"
				},	
				{
					label: "scsxxth.transaction_state",
					name: "scsxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "scsxxth.tanggal",
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
					label: "Customer <sup class='text-danger'>*<sup>",
					name: "scsxxth.id_grlxxmh_customer",
					fieldInfo: "Customer Konsinyasi",
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
									is_konsinyasi: '1',
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
					label: "Sales Order <sup class='text-danger'>*<sup>",
					name: "scsxxth.id_sodxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/scsxxth/scsxxth_sodxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_customer: id_grlxxmh_customer,
									id_sodxxth_old: id_sodxxth_old,
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
					label: "scsxxth.id_iitxxmh",
					name: "scsxxth.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "scsxxth.id_fpytmmh",
					name: "scsxxth.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "scsxxth.id_fcrxxmh",
					name: "scsxxth.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "scsxxth.is_pajak",
					name: "scsxxth.is_pajak",
					type: "hidden"
				},
				{
					label: "scsxxth.pajak_jenis",
					name: "scsxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "scsxxth.pajak_in_ex",
					name: "scsxxth.pajak_in_ex",
					type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "scsxxth.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iwhxxmh_old: id_iwhxxmh_old,
									ids_iwhctmh: '',
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
					label: "Supir <sup class='text-danger'>*<sup>",
					name: "scsxxth.supir_nama"
				},
				{
					label: "Keterangan",
					name: "scsxxth.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edtscsxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtscsxxth.field('scsxxth.start_at').val(start_at);

			if(action == 'create'){
				tblscsxxth.rows().deselect();
			}
		});

		edtscsxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtscsxxth.dependent( 'scsxxth.id_grlxxmh_customer', function ( val, data, callback ) {
			edtscsxxth.field('scsxxth.id_sodxxth').input().val(null).trigger('change');
			id_grlxxmh_customer = val;
			return {}
		}, {event: 'keyup change'});
		
		edtscsxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal         = edtscsxxth.field('scsxxth.tanggal').val();
				id_iwhxxmh      = edtscsxxth.field('scsxxth.id_iwhxxmh').val();
				id_grlxxmh_customer      = edtscsxxth.field('scsxxth.id_grlxxmh_customer').val();
				id_sodxxth      = edtscsxxth.field('scsxxth.id_sodxxth').val();

				validasiRequired(
					edtscsxxth, 
					"scsxxth", 
					{
						"tanggal": tanggal, 
						"id_iwhxxmh": id_iwhxxmh, 
						"id_grlxxmh_customer": id_grlxxmh_customer,
					}
				);

				validasiRequired(
					edtscsxxth, 
					"scsxxth", 
					{
						"id_sodxxth": id_sodxxth
					}
				);

			}
			
			if ( edtscsxxth.inError() ) {
				return false;
			}
		});

		edtscsxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtscsxxth.field('scsxxth.finish_at').val(finish_at);
		});
		
		edtscsxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblscsxxth.ajax.reload(null, false);
		} );

		edtscsxxth.on( 'close', function () {
			edtscsxxth.enable();
		} );
		
		tblscsxxth = $('#tblscsxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/scsxxth/scsxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_scsxxth = show_deleted_scsxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
			orderFixed: [2, 'asc'],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,6]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "scsxxth.id",visible:false },
				{ data: "scsxxth.tanggal" },
				{ data: "scsxxth.kode" },
				{ data: "grlxxmh.nama" },
				{
					data: "sodxxth.kode"
				},
				{ data: "iwhxxmh.nama" },
				{ 
					data: "scsxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_scsxxth';
					$table       = 'tblscsxxth';
					$edt         = 'edtscsxxth';
					$show_status = '_scsxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrintJurnal',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Jurnal',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('../../views/core/jv_print.php?jenis_transaksi=Sales Consignee&id_transaksi='+id_scsxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.scsxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.scsxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblscsxxth.searchPanes.container().appendTo('#spscsxxth');
		tblscsxxth.searchBuilder.container().appendTo( '#sbscsxxth' );
		
		tblscsxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblscsittd];
			CekInitHeaderHD(tblscsxxth, tbl_details);
		} );
		
		tblscsxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('scsxxth');
			id_grlxxmh_old      = scsxxth_data.id_grlxxmh_customer;
			id_grlxxmh_customer = scsxxth_data.id_grlxxmh_customer;
			id_sodxxth_old      = scsxxth_data.id_sodxxth;
			id_sodxxth          = scsxxth_data.id_sodxxth;
			id_iwhxxmh_old      = scsxxth_data.id_iwhxxmh;
			
			// atur hak akses
			tbl_details = [tblscsittd];
			CekSelectHeaderHD(tblscsxxth, tbl_details);

		} );
		
		tblscsxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('scsxxth');
			id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_sodxxth_old = 0, id_iwhxxmh_old = 0, id_sodxxth = 0;

			// atur hak akses
			tbl_details = [tblscsittd];
			CekDeselectHeaderHD(tblscsxxth, tbl_details);
		} );
		// END scsxxth

		// BEGIN scsittd
		edtscsittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/scsxxth/scsittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_scsittd = show_deleted_scsittd;
					d.id_scsxxth = id_scsxxth;
				}
			},
			template: "#frmscsittd",
			table: "#tblscsittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "scsittd.start_at",
					name: "scsittd.start_at",
					type: "hidden"
				},	
				{
					label: "scsittd.finish_at",
					name: "scsittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "scsittd",
					type: "hidden"
				},	
				{
					label: "scsittd.transaction_state",
					name: "scsittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_scsxxth",
					name: "scsittd.id_scsxxth",
					type: "hidden"
				},	
				{
					label: "scsittd.id_sodittd",
					name: "scsittd.id_sodittd",
					type: "hidden"
				},
				{
					label: "scsittd.id_sodxxth",
					name: "scsittd.id_sodxxth",
					// type: "hidden"
				},
				{
					label: getTranslation('price') + " <sup class='text-danger'>*<sup>",
					name: "scsittd.harga_unit",
				},
				{
					label: getTranslation('subtotal') + " <sup class='text-danger'>*<sup>",
					name: "scsittd.subtotal",
					type: "readonly"
				},
				{
					label: getTranslation('discount') + " <sup class='text-danger'>*<sup>",
					name: "scsittd.diskon_jenis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "-", "value": 0 },
						{ "label": "Percent", "value": 1 },
						{ "label": "Value", "value": 2 }
					]
				},
				{
					label: getTranslation('discountPercentage'),
					name: "scsittd.diskon_persen"
				}, 	
				{
					label: getTranslation('discountValue'),
					name: "scsittd.diskon_value"
				}, 	
				{
					label: getTranslation('discountFinal'),
					name: "scsittd.diskon_final",
					type: "readonly"
				},
				{
					label: getTranslation('total'),
					name: "scsittd.dpp",
					type: "readonly"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "scsittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder: "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: function() {
								return "../../models/scsxxth/scsittd_iimxxmh_fn_opt.php";
							},
							dataType: 'json',
							data: function (params) {
								return {
									id_iimxxmh_old: id_iimxxmh_old,
									id_sodxxth: id_sodxxth,
									search: params.term || '',
									page: params.page || 1
								};
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
					label: "scsittd.jumlah_bom",
					name: "scsittd.jumlah_bom"
				},
				{
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "scsittd.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "scsittd.id_iumxxmh_unit",
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
					label: "Keterangan",
					name: "scsittd.keterangan",
					type: "textarea"
				}
			]
		} );

		//masking
		unmask_scsittd = maskingNumber(
			edtscsittd, 
			"scsittd", 
			[
				"jumlah_unit", 
				"harga_unit", 
				"subtotal", 
				"diskon_persen", 
				"diskon_value", 
				"diskon_final", 
				"dpp", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);
			
		edtscsittd.on( 'preOpen', function( e, mode, action ) {
			edtscsittd.field('scsittd.id_scsxxth').val(id_scsxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtscsittd.field('scsittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblscsittd.rows().deselect();
			}
		});

		edtscsittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtscsittd.dependent( 'scsittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;

			edtscsittd.field('scsittd.jumlah_unit').fieldInfo('');
			edtscsittd.field('scsittd.id_iumxxmh_unit').input().val(null).trigger('change');
			
			scsittd_fn_sodittd(id_sodxxth,id_iimxxmh)
			return {}
		}, {event: 'keyup change'});

		edtscsittd.dependent( 'scsittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtscsittd, 'scsittd');
			hitungDiskon(edtscsittd, 'scsittd');
			hitungDpp(edtscsittd, 'scsittd');
			return {}
		}, {event: 'keyup change'});
		
		edtscsittd.dependent( 'scsittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtscsittd, 'scsittd');
			hitungDpp(edtscsittd, 'scsittd');

			return {}
		}, {event: 'keyup change'});

		edtscsittd.dependent( 'scsittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtscsittd.field('scsittd.diskon_persen').show();
				edtscsittd.field('scsittd.diskon_value').hide();
				
				edtscsittd.field('scsittd.diskon_persen').val();
				edtscsittd.field('scsittd.diskon_value').val('');
			} else if (val == 2) {
				edtscsittd.field('scsittd.diskon_persen').hide();
				edtscsittd.field('scsittd.diskon_value').show();
				
				edtscsittd.field('scsittd.diskon_persen').val('');
				edtscsittd.field('scsittd.diskon_value').val();
			} else {
				edtscsittd.field('scsittd.diskon_persen').hide();
				edtscsittd.field('scsittd.diskon_value').hide();
				edtscsittd.field('scsittd.diskon_persen').val(0);
				edtscsittd.field('scsittd.diskon_value').val(0);
				edtscsittd.field('scsittd.diskon_final').val(0);
			}

			hitungDiskon(edtscsittd, 'scsittd');
			hitungDpp(edtscsittd, 'scsittd');
			return {}
		}, {event: 'keyup change'});
		
		edtscsittd.dependent( 'scsittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtscsittd, 'scsittd');
				hitungDpp(edtscsittd, 'scsittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtscsittd.dependent( 'scsittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtscsittd, 'scsittd');
				hitungDpp(edtscsittd, 'scsittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtscsittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_scsittd;
			}

			if(action != 'remove'){
				id_iimxxmh = edtscsittd.field('scsittd.id_iimxxmh').val();
				id_sodittd = edtscsittd.field('scsittd.id_sodittd').val();
				id_iumxxmh_unit = edtscsittd.field('scsittd.id_iumxxmh_unit').val();

				validasiRequired(
					edtscsittd,
					'scsittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);

				validasiUnique(
					action,
					edtscsittd, 
					"scsittd", 
					"id_iimxxmh", 
					'id_iimxxmh, id_scsxxth',
					id_iimxxmh+","+id_scsxxth,
					id_scsittd
				);

				validasiInventory(id_transaksi, id_iimxxmh, id_iumxxmh_unit, id_iwhxxmh_old, 'sodittd', id_sodittd);
			}
			
			if ( edtscsittd.inError() ) {
				return false;
			}
		});

		edtscsittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtscsittd.field('scsittd.finish_at').val(finish_at);
		});
			
		edtscsittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			hitungSubtotalHeader(id_transaksi_h, 'scsittd', 'scsxxth');
			hitungHeaderDetail('scsxxth', 'scsittd', id_transaksi_h);

			tblscsxxth.ajax.reload(null, false);
			tblscsittd.rows().deselect();
			tblscsittd.ajax.reload(null, false);
		} );

		edtscsittd.on( 'close', function () {
			edtscsittd.enable();
		} );
		
		tblscsittd = $('#tblscsittd').DataTable( {
			ajax: {
				url: "../../models/scsxxth/scsittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_scsittd = show_deleted_scsittd;
					d.id_scsxxth = id_scsxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "scsittd.id",visible:false },
				{ data: "scsittd.id_scsxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "scsittd.jumlah_unit",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_scsittd';
					$table       = 'tblscsittd';
					$edt         = 'edtscsittd';
					$show_status = '_scsittd';
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

		tblscsittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblscsittd, 1 );
			CekDrawDetailHDFinal(tblscsxxth);
		} );

		tblscsittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('scsittd');
			id_iimxxmh_old = scsittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = scsittd_data.id_iumxxmh_unit;
			diskon_jenis_select = scsittd_data.diskon_jenis;
			harga_unit_select = scsittd_data.harga_unit;

			// atur hak akses
			CekSelectDetailHD( tblscsittd );
		} );

		tblscsittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('scsittd');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, diskon_jenis_select = null, harga_unit_select = null;
			
			// atur hak akses
			CekDeselectDetailHD( tblscsittd );
		} );
		// END scsittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblscsxxth.rows().deselect();
				tblscsxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFscsxxth').modal('toggle');
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
