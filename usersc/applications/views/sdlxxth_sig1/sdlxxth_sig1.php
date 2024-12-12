<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sdlxxth_sig1';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sdlittd_sig1';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFsdlxxth_sig1" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmsdlxxth_sig1">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.id_imtxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.id_grlxxmh_customer"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.referensi"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.plat_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_sig1.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblsdlxxth_sig1" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
                                <th>Type</th>
								<th>Customer</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabsdlittd_sig1"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsdlittd_sig1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsdlittd_sig1" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sdlxxth_sig1</th>
										<th>SKU</th>
										<th>Item</th>
										<th>Quantity</th>
										<th>UoM</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sdlxxth_sig1/fn/sdlxxth_sig1_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtsdlxxth_sig1, tblsdlxxth_sig1, show_deleted_sdlxxth_sig1 = 0, id_sdlxxth_sig1;
	var edtsdlittd_sig1, tblsdlittd_sig1, show_deleted_sdlittd_sig1 = 0, id_sdlittd_sig1;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_iwhxxmh_old = 0, id_imtxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0;

	// get tableRelation
	tableRelation('sdlxxth_sig1');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN sdlxxth_sig1
		edtsdlxxth_sig1 = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sdlxxth_sig1/sdlxxth_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth_sig1 = show_deleted_sdlxxth_sig1;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmsdlxxth_sig1",
			table: "#tblsdlxxth_sig1",
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
					label: "sdlxxth_sig1.start_at",
					name: "sdlxxth_sig1.start_at",
					type: "hidden"
				},	
				{
					label: "sdlxxth_sig1.finish_at",
					name: "sdlxxth_sig1.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sdlxxth_sig1",
					type: "hidden"
				},	
				{
					label: "sdlxxth_sig1.transaction_state",
					name: "sdlxxth_sig1.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "sdlxxth_sig1.tanggal",
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
					name: "sdlxxth_sig1.id_grlxxmh_customer",
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
					name: "sdlxxth_sig1.id_imtxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/imtxxmh/imtxxmh_fn_opt_sig1.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_imtxxmh_old: id_imtxxmh_old,
									movement_type_group: ['GI'],
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
					label: "sdlxxth_sig1.id_iitxxmh",
					name: "sdlxxth_sig1.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "sdlxxth_sig1.id_fpytmmh",
					name: "sdlxxth_sig1.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "sdlxxth_sig1.id_fcrxxmh",
					name: "sdlxxth_sig1.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "sdlxxth_sig1.is_pajak",
					name: "sdlxxth_sig1.is_pajak",
					type: "hidden"
				},
				{
					label: "sdlxxth_sig1.pajak_jenis",
					name: "sdlxxth_sig1.pajak_jenis",
					type: "hidden"
				},
				{
					label: "sdlxxth_sig1.pajak_in_ex",
					name: "sdlxxth_sig1.pajak_in_ex",
					type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "sdlxxth_sig1.id_iwhxxmh",
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
					label: "Supir",
					name: "sdlxxth_sig1.supir_nama"
				},
				{
					label: "Plat Nomor",
					name: "sdlxxth_sig1.plat_nomor"
				},
				{
					label: "Referensi <sup class='text-danger'>*<sup>",
					name: "sdlxxth_sig1.referensi",
					fieldInfo: "Nomor referensi, misal Sales Order"
				},
				{
					label: "Keterangan",
					name: "sdlxxth_sig1.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtsdlxxth_sig1.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlxxth_sig1.field('sdlxxth_sig1.start_at').val(start_at);

			if(action == 'create'){
				tblsdlxxth_sig1.rows().deselect();
			}
		});

		edtsdlxxth_sig1.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});
		
		edtsdlxxth_sig1.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal             = edtsdlxxth_sig1.field('sdlxxth_sig1.tanggal').val();
				id_iwhxxmh          = edtsdlxxth_sig1.field('sdlxxth_sig1.id_iwhxxmh').val();
				id_imtxxmh          = edtsdlxxth_sig1.field('sdlxxth_sig1.id_imtxxmh').val();
				id_grlxxmh_customer = edtsdlxxth_sig1.field('sdlxxth_sig1.id_grlxxmh_customer').val();
				referensi           = edtsdlxxth_sig1.field('sdlxxth_sig1.referensi').val();

				validasiRequired(
					edtsdlxxth_sig1, 
					"sdlxxth_sig1", 
					{
						"tanggal"            : tanggal,
						"id_iwhxxmh"         : id_iwhxxmh,
						"id_imtxxmh"         : id_imtxxmh,
						"id_grlxxmh_customer": id_grlxxmh_customer,
						"referensi"          : referensi,
					}
				);

			}
			
			if ( edtsdlxxth_sig1.inError() ) {
				return false;
			}
		});

		edtsdlxxth_sig1.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlxxth_sig1.field('sdlxxth_sig1.finish_at').val(finish_at);
		});
		
		edtsdlxxth_sig1.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtsdlxxth_sig1.on( 'close', function () {
			edtsdlxxth_sig1.enable();
		} );
		
		tblsdlxxth_sig1 = $('#tblsdlxxth_sig1').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/sdlxxth_sig1/sdlxxth_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth_sig1 = show_deleted_sdlxxth_sig1;
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
				{ data: "sdlxxth_sig1.id",visible:false },
				{ data: "sdlxxth_sig1.tanggal" },
				{ data: "sdlxxth_sig1.kode" },
				{ data: "imtxxmh.movement_type" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ 
					data: "sdlxxth_sig1.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlxxth_sig1';
					$table       = 'tblsdlxxth_sig1';
					$edt         = 'edtsdlxxth_sig1';
					$show_status = '_sdlxxth_sig1';
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Sales Delivery&id_transaksi='+id_sdlxxth_sig1, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.sdlxxth_sig1.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sdlxxth_sig1.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsdlxxth_sig1.searchPanes.container().appendTo('#spsdlxxth_sig1');
		tblsdlxxth_sig1.searchBuilder.container().appendTo( '#sbsdlxxth_sig1' );
		
		tblsdlxxth_sig1.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblsdlittd_sig1];
			CekInitHeaderHD(tblsdlxxth_sig1, tbl_details);
		} );
		
		tblsdlxxth_sig1.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('sdlxxth_sig1');
			id_grlxxmh_old      = sdlxxth_sig1_data.id_grlxxmh_customer;
			id_grlxxmh_customer = sdlxxth_sig1_data.id_grlxxmh_customer;
			id_iwhxxmh_old      = sdlxxth_sig1_data.id_iwhxxmh;
			id_imtxxmh_old      = sdlxxth_sig1_data.id_imtxxmh;
			
			// atur hak akses
			tbl_details = [tblsdlittd_sig1];
			CekSelectHeaderHD(tblsdlxxth_sig1, tbl_details);

		} );
		
		tblsdlxxth_sig1.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('sdlxxth_sig1');
			id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_iwhxxmh_old = 0, id_imtxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblsdlittd_sig1];
			CekDeselectHeaderHD(tblsdlxxth_sig1, tbl_details);
		} );
		// END sdlxxth_sig1

		// BEGIN sdlittd_sig1
		edtsdlittd_sig1 = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sdlxxth_sig1/sdlittd_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlittd_sig1 = show_deleted_sdlittd_sig1;
					d.id_sdlxxth_sig1 = id_sdlxxth_sig1;
				}
			},
			table: "#tblsdlittd_sig1",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "sdlittd_sig1.start_at",
					name: "sdlittd_sig1.start_at",
					type: "hidden"
				},	
				{
					label: "sdlittd_sig1.finish_at",
					name: "sdlittd_sig1.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sdlittd_sig1",
					type: "hidden"
				},	
				{
					label: "sdlittd_sig1.transaction_state",
					name: "sdlittd_sig1.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sdlxxth_sig1",
					name: "sdlittd_sig1.id_sdlxxth_sig1",
					type: "hidden"
				},	
				{
					label: "sdlittd_sig1.harga_unit",
					name: "sdlittd_sig1.harga_unit",
					type: "hidden"
				},
				{
					label: "sdlittd_sig1.diskon_jenis",
					name: "sdlittd_sig1.diskon_jenis",
					type: "hidden"
				},
				{
					label: "sdlittd_sig1.diskon_persen",
					name: "sdlittd_sig1.diskon_persen",
					type: "hidden"
				},
				{
					label: "sdlittd_sig1.diskon_value",
					name: "sdlittd_sig1.diskon_value",
					type: "hidden"
				},
				{
					label: "sdlittd_sig1.diskon_final",
					name: "sdlittd_sig1.diskon_final",
					type: "hidden"
				},
				{
					label: "sdlittd_sig1.subtotal",
					name: "sdlittd_sig1.subtotal",
					type: "hidden"
				},
				{
					label: "sdlittd_sig1.dpp",
					name: "sdlittd_sig1.dpp",
					type: "hidden"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sdlittd_sig1.id_iimxxmh",
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "sdlittd_sig1.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "sdlittd_sig1.id_iumxxmh_unit",
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
					name: "sdlittd_sig1.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtsdlittd_sig1.on( 'preOpen', function( e, mode, action ) {
			edtsdlittd_sig1.field('sdlittd_sig1.id_sdlxxth_sig1').val(id_sdlxxth_sig1);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlittd_sig1.field('sdlittd_sig1.start_at').val(start_at);
			
			if(action == 'create'){
				tblsdlittd_sig1.rows().deselect();
			}
		});

		edtsdlittd_sig1.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtsdlittd_sig1.dependent( 'sdlittd_sig1.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtsdlittd_sig1.field('sdlittd_sig1.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtsdlittd_sig1.dependent( 'sdlittd_sig1.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsdlittd_sig1, 'sdlittd_sig1');
			return {}
		}, {event: 'keyup change'});
		
		edtsdlittd_sig1.dependent( 'sdlittd_sig1.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsdlittd_sig1, 'sdlittd_sig1');
			return {}
		}, {event: 'keyup change'});
		
		edtsdlittd_sig1.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_sdlittd_sig1;
			}

			if(action != 'remove'){
				id_iimxxmh = edtsdlittd_sig1.field('sdlittd_sig1.id_iimxxmh').val();
				jumlah_unit = edtsdlittd_sig1.field('sdlittd_sig1.jumlah_unit').val();
				id_iumxxmh_unit = edtsdlittd_sig1.field('sdlittd_sig1.id_iumxxmh_unit').val();

				validasiRequired(
					edtsdlittd_sig1,
					'sdlittd_sig1',
					{
						'id_iimxxmh': id_iimxxmh,
						'jumlah_unit': jumlah_unit,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);
				
				validasiNumber(
					edtsdlittd_sig1,
					'sdlittd_sig1',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

			}
			
			if ( edtsdlittd_sig1.inError() ) {
				return false;
			}
		});

		edtsdlittd_sig1.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlittd_sig1.field('sdlittd_sig1.finish_at').val(finish_at);
		});
			
		edtsdlittd_sig1.on( 'postSubmit', function (e, json, data, action, xhr) {

			tblsdlxxth_sig1.ajax.reload(null, false);
			tblsdlittd_sig1.rows().deselect();
			tblsdlittd_sig1.ajax.reload(null, false);
		} );

		edtsdlittd_sig1.on( 'close', function () {
			edtsdlittd_sig1.enable();
		} );
		
		tblsdlittd_sig1 = $('#tblsdlittd_sig1').DataTable( {
			ajax: {
				url: "../../models/sdlxxth_sig1/sdlittd_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlittd_sig1 = show_deleted_sdlittd_sig1;
					d.id_sdlxxth_sig1 = id_sdlxxth_sig1;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "sdlittd_sig1.id",visible:false },
				{ data: "sdlittd_sig1.id_sdlxxth_sig1",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "sdlittd_sig1.jumlah_unit",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlittd_sig1';
					$table       = 'tblsdlittd_sig1';
					$edt         = 'edtsdlittd_sig1';
					$show_status = '_sdlittd_sig1';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblsdlittd_sig1.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsdlittd_sig1, 1 );
			CekDrawDetailHDFinal(tblsdlxxth_sig1);
		} );

		tblsdlittd_sig1.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('sdlittd_sig1');
			id_iimxxmh_old = sdlittd_sig1_data.id_iimxxmh;
			id_iumxxmh_unit_old = sdlittd_sig1_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblsdlittd_sig1 );
		} );

		tblsdlittd_sig1.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('sdlittd_sig1');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsdlittd_sig1 );
		} );
		// END sdlittd_sig1

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsdlxxth_sig1.rows().deselect();
				tblsdlxxth_sig1.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsdlxxth_sig1').modal('toggle');
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
