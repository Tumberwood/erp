<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sdlxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sdlittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFsdlxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmsdlxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.is_sub_contract"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.id_grlxxmh_customer"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.id_sodxxth"></editor-field>
								<editor-field name="sdlxxth.id_podxxth"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblsdlxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabsdlittd"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsdlittd" class="tab-pane active">
					<div id="frmsdlittd">
						<div class="panel-body">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.id_iimxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.id_iumxxmh_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.jumlah_unit"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.harga_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.subtotal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.diskon_jenis"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sdlittd.diskon_persen"></editor-field>
									<editor-field name="sdlittd.diskon_value"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="sdlittd.diskon_final"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="sdlittd.dpp"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<!-- <editor-field name="sdlittd.id_scsittd"></editor-field> -->
								</div>
								<div class="col-lg-6">
									<editor-field name="sdlittd.keterangan"></editor-field>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsdlittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sdlxxth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sdlxxth/fn/sdlxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtsdlxxth, tblsdlxxth, show_deleted_sdlxxth = 0, id_sdlxxth;
	var edtsdlittd, tblsdlittd, show_deleted_sdlittd = 0, id_sdlittd;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_sodxxth_old = 0, id_iwhxxmh_old = 0, id_sodxxth = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, diskon_jenis_select = null, harga_unit_select = null;
	var id_podxxth_old = 0, id_scsxxth = 0;

	// get tableRelation
	tableRelation('sdlxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN sdlxxth
		edtsdlxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sdlxxth/sdlxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth = show_deleted_sdlxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmsdlxxth",
			table: "#tblsdlxxth",
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
					label: "sdlxxth.start_at",
					name: "sdlxxth.start_at",
					type: "hidden"
				},	
				{
					label: "sdlxxth.finish_at",
					name: "sdlxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sdlxxth",
					type: "hidden"
				},	
				{
					label: "sdlxxth.transaction_state",
					name: "sdlxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "sdlxxth.tanggal",
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
					name: "sdlxxth.id_grlxxmh_customer",
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
									is_konsinyasi: '0,1',
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
					label: getTranslation('purchaseOrder') + " <sup class='text-danger'>*<sup>",
					name: "sdlxxth.id_podxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/podxxth/podxxth_fn_subcon_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_podxxth_old: id_podxxth_old,
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
					name: "sdlxxth.id_sodxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/sdlxxth/sdlxxth_sodxxth_fn_opt.php",
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
					label: "sdlxxth.id_iitxxmh",
					name: "sdlxxth.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "sdlxxth.id_fpytmmh",
					name: "sdlxxth.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "sdlxxth.id_fcrxxmh",
					name: "sdlxxth.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "sdlxxth.is_pajak",
					name: "sdlxxth.is_pajak",
					type: "hidden"
				},
				{
					label: "sdlxxth.pajak_jenis",
					name: "sdlxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "sdlxxth.pajak_in_ex",
					name: "sdlxxth.pajak_in_ex",
					type: "hidden"
				},
				{
					label: "sdlxxth.id_scsxxth",
					name: "sdlxxth.id_scsxxth",
					type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "sdlxxth.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: function() {
								id_sodxxth          = edtsdlxxth.field('sdlxxth.id_sodxxth').val();
								autofillField('sodxxth', id_sodxxth, 'id_iitxxmh');
								id_iitxxmh = autofillData.id_iitxxmh;
								return id_sodxxth > 0 && id_iitxxmh == 7
									? "../../models/iwhxxmh/iwhxxmh_fn_grlxxmh_opt.php" 
									: "../../models/iwhxxmh/iwhxxmh_fn_opt.php";
							},
							// url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								is_sub_contract          = edtsdlxxth.field('sdlxxth.is_sub_contract').val();	

								//Jika is_sub_contract, maka wh yang tampil cuma wh kategori sub contract
								if (is_sub_contract == 1) {
									ids_iwhctmh = '8';
								} else {
									ids_iwhctmh = '';
								}

								var query = {
									id_iwhxxmh_old: id_iwhxxmh_old,
									ids_iwhctmh: ids_iwhctmh,
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
					name: "sdlxxth.supir_nama"
				},
				{
					label: "Keterangan",
					name: "sdlxxth.keterangan",
					type: "textarea"
				},
				{
					label: "PO Sub Contract?",
					name: "sdlxxth.is_sub_contract",
					type: "select",
					placeholder : "Select",
					def: 0,
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
			]
		} );
		
		edtsdlxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlxxth.field('sdlxxth.start_at').val(start_at);

			if(action == 'create'){
				tblsdlxxth.rows().deselect();
			}
		});

		edtsdlxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtsdlxxth.dependent( 'sdlxxth.is_sub_contract', function ( val, data, callback ) {
			if (val == 1) {
				edtsdlxxth.field('sdlxxth.id_sodxxth').hide();
				edtsdlxxth.field('sdlxxth.id_podxxth').show();
			} else {
				edtsdlxxth.field('sdlxxth.id_sodxxth').show();
				edtsdlxxth.field('sdlxxth.id_podxxth').hide();
			}
			return {}
		}, {event: 'keyup change'});

		edtsdlxxth.dependent( 'sdlxxth.id_grlxxmh_customer', function ( val, data, callback ) {
			edtsdlxxth.field('sdlxxth.id_sodxxth').input().val(null).trigger('change');
			edtsdlxxth.field('sdlxxth.id_iwhxxmh').input().val(null).trigger('change');
			id_grlxxmh_customer = val;
			return {}
		}, {event: 'keyup change'});

		edtsdlxxth.dependent( 'sdlxxth.id_sodxxth', function ( val, data, callback ) {
			id_iwhxxmh      = edtsdlxxth.field('sdlxxth.id_iwhxxmh').val();
			id_sodxxth          = edtsdlxxth.field('sdlxxth.id_sodxxth').val();
			autofillField('sodxxth', id_sodxxth, 'id_iitxxmh');
			id_iitxxmh = autofillData.id_iitxxmh;

			if (id_iitxxmh == 7) {
				if (id_iwhxxmh != id_iwhxxmh_old) {
					edtsdlxxth.field('sdlxxth.id_iwhxxmh').input().val(null).trigger('change');
					dataSalesConsignee(id_sodxxth);
				}
			}
			return {}
		}, {event: 'keyup change'});
		
		edtsdlxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal         = edtsdlxxth.field('sdlxxth.tanggal').val();
				id_iwhxxmh      = edtsdlxxth.field('sdlxxth.id_iwhxxmh').val();
				id_grlxxmh_customer      = edtsdlxxth.field('sdlxxth.id_grlxxmh_customer').val();
				id_sodxxth      = edtsdlxxth.field('sdlxxth.id_sodxxth').val();
				id_podxxth      = edtsdlxxth.field('sdlxxth.id_podxxth').val();
				is_sub_contract      = edtsdlxxth.field('sdlxxth.is_sub_contract').val();

				validasiRequired(
					edtsdlxxth, 
					"sdlxxth", 
					{
						"tanggal": tanggal, 
						"id_iwhxxmh": id_iwhxxmh, 
						"id_grlxxmh_customer": id_grlxxmh_customer,
					}
				);

				if (is_sub_contract == 1) {
					validasiRequired(
						edtsdlxxth, 
						"sdlxxth", 
						{
							"id_podxxth": id_podxxth
						}
					);
				} else {
					validasiRequired(
						edtsdlxxth, 
						"sdlxxth", 
						{
							"id_sodxxth": id_sodxxth
						}
					);
				}

			}
			
			if ( edtsdlxxth.inError() ) {
				return false;
			}
		});

		edtsdlxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlxxth.field('sdlxxth.finish_at').val(finish_at);
		});
		
		edtsdlxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblsdlxxth.ajax.reload(null, false);
		} );

		edtsdlxxth.on( 'close', function () {
			edtsdlxxth.enable();
		} );
		
		tblsdlxxth = $('#tblsdlxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sdlxxth/sdlxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth = show_deleted_sdlxxth;
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
				{ data: "sdlxxth.id",visible:false },
				{ data: "sdlxxth.tanggal" },
				{ data: "sdlxxth.kode" },
				{ data: "grlxxmh.nama" },
				{
					data: "sodxxth.kode",
					render: function(data, type, row) {
						return data ? data : (row.podxxth ? row.podxxth.kode : '');
					}
				},
				{ data: "iwhxxmh.nama" },
				{ 
					data: "sdlxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlxxth';
					$table       = 'tblsdlxxth';
					$edt         = 'edtsdlxxth';
					$show_status = '_sdlxxth';
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Sales Delivery&id_transaksi='+id_sdlxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.sdlxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sdlxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsdlxxth.searchPanes.container().appendTo('#spsdlxxth');
		tblsdlxxth.searchBuilder.container().appendTo( '#sbsdlxxth' );
		
		tblsdlxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblsdlittd];
			CekInitHeaderHD(tblsdlxxth, tbl_details);
		} );
		
		tblsdlxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('sdlxxth');
			id_grlxxmh_old      = sdlxxth_data.id_grlxxmh_customer;
			id_grlxxmh_customer = sdlxxth_data.id_grlxxmh_customer;
			id_sodxxth_old      = sdlxxth_data.id_sodxxth;
			id_podxxth_old      = sdlxxth_data.id_podxxth;
			id_sodxxth          = sdlxxth_data.id_sodxxth;
			id_scsxxth          = sdlxxth_data.id_scsxxth;
			id_iwhxxmh_old      = sdlxxth_data.id_iwhxxmh;
			
			// atur hak akses
			tbl_details = [tblsdlittd];
			CekSelectHeaderHD(tblsdlxxth, tbl_details);

		} );
		
		tblsdlxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('sdlxxth');
			id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_sodxxth_old = 0, id_iwhxxmh_old = 0, id_sodxxth = 0;
			id_podxxth_old = 0, id_scsxxth = 0;

			// atur hak akses
			tbl_details = [tblsdlittd];
			CekDeselectHeaderHD(tblsdlxxth, tbl_details);
		} );
		// END sdlxxth

		// BEGIN sdlittd
		edtsdlittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sdlxxth/sdlittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlittd = show_deleted_sdlittd;
					d.id_sdlxxth = id_sdlxxth;
				}
			},
			template: "#frmsdlittd",
			table: "#tblsdlittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "sdlittd.start_at",
					name: "sdlittd.start_at",
					type: "hidden"
				},	
				{
					label: "sdlittd.finish_at",
					name: "sdlittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sdlittd",
					type: "hidden"
				},	
				{
					label: "sdlittd.transaction_state",
					name: "sdlittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sdlxxth",
					name: "sdlittd.id_sdlxxth",
					type: "hidden"
				},	
				{
					label: "sdlittd.id_sodittd",
					name: "sdlittd.id_sodittd",
					type: "hidden"
				},
				{
					label: "sdlittd.id_sodxxth",
					name: "sdlittd.id_sodxxth",
					// type: "hidden"
				},
				{
					label: "sdlittd.id_podittd",
					name: "sdlittd.id_podittd",
					type: "hidden"
				},
				{
					label: "sdlittd.id_podxxth",
					name: "sdlittd.id_podxxth",
					// type: "hidden"
				},
				{
					label: "sdlittd.id_scsittd",
					name: "sdlittd.id_scsittd",
				},
				{
					label: getTranslation('price') + " <sup class='text-danger'>*<sup>",
					name: "sdlittd.harga_unit",
				},
				{
					label: getTranslation('subtotal') + " <sup class='text-danger'>*<sup>",
					name: "sdlittd.subtotal",
					type: "readonly"
				},
				{
					label: getTranslation('discount') + " <sup class='text-danger'>*<sup>",
					name: "sdlittd.diskon_jenis",
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
					name: "sdlittd.diskon_persen"
				}, 	
				{
					label: getTranslation('discountValue'),
					name: "sdlittd.diskon_value"
				}, 	
				{
					label: getTranslation('discountFinal'),
					name: "sdlittd.diskon_final",
					type: "readonly"
				},
				{
					label: getTranslation('total'),
					name: "sdlittd.dpp",
					type: "readonly"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sdlittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder: "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: function() {
								return id_podxxth_old > 0 
									? "../../models/sdlxxth/podittd_subcon_fn_opt.php" 
									: "../../models/sdlxxth/sdlittd_iimxxmh_fn_opt.php";
							},
							dataType: 'json',
							data: function (params) {
								return {
									id_iimxxmh_old: id_iimxxmh_old,
									id_sodxxth: id_sodxxth,
									id_scsxxth: id_scsxxth,
									id_podxxth: id_podxxth_old,
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
					label: "sdlittd.jumlah_bom",
					name: "sdlittd.jumlah_bom"
				},
				{
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "sdlittd.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "sdlittd.id_iumxxmh_unit",
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
					name: "sdlittd.keterangan",
					type: "textarea"
				}
			]
		} );

		//masking
		unmask_sdlittd = maskingNumber(
			edtsdlittd, 
			"sdlittd", 
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
			
		edtsdlittd.on( 'preOpen', function( e, mode, action ) {
			edtsdlittd.field('sdlittd.id_sdlxxth').val(id_sdlxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlittd.field('sdlittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblsdlittd.rows().deselect();
			}
		});

		edtsdlittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtsdlittd.dependent( 'sdlittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;

			if (id_podxxth_old > 0) {
				var dataOpt = edtsdlittd.field('sdlittd.id_iimxxmh').input().select2('data');
				if (dataOpt.length > 0) {
					var id_podittd = dataOpt[0].id_podittd;
					var id_podxxth = dataOpt[0].id_podxxth;
					var harga_unit = dataOpt[0].harga_unit;
					var jumlah_material = dataOpt[0].jumlah_material;
					var jumlah_unit = dataOpt[0].jumlah_unit;
					var jumlah_bom = dataOpt[0].jumlah_bom;
					id_iumxxmh_unit_old = dataOpt[0].id_iumxxmh_unit;
					
					edtsdlittd.field('sdlittd.id_podittd').val(id_podittd);
					edtsdlittd.field('sdlittd.id_podxxth').val(id_podxxth);
					edtsdlittd.field('sdlittd.harga_unit').val(harga_unit);
					edtsdlittd.field('sdlittd.jumlah_unit').val(jumlah_unit);
					edtsdlittd.field('sdlittd.jumlah_bom').val(jumlah_bom);
					edtsdlittd.field('sdlittd.id_iumxxmh_unit').val(id_iumxxmh_unit_old);

					edtsdlittd.field('sdlittd.jumlah_unit').fieldInfo('Jumlah PO * ' + jumlah_material + ' (Detail BoM)');
				}
			} else {
				edtsdlittd.field('sdlittd.jumlah_unit').fieldInfo('');
				edtsdlittd.field('sdlittd.id_iumxxmh_unit').input().val(null).trigger('change');
			}
			
			if (id_scsxxth > 0) {
				itemConsignee(id_iimxxmh, id_scsxxth);
			} else {
				sdlittd_fn_sodittd(id_sodxxth,id_iimxxmh);
			}
			return {}
		}, {event: 'keyup change'});

		edtsdlittd.dependent( 'sdlittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsdlittd, 'sdlittd');
			hitungDiskon(edtsdlittd, 'sdlittd');
			hitungDpp(edtsdlittd, 'sdlittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsdlittd.dependent( 'sdlittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsdlittd, 'sdlittd');
			hitungDpp(edtsdlittd, 'sdlittd');

			return {}
		}, {event: 'keyup change'});

		edtsdlittd.dependent( 'sdlittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsdlittd.field('sdlittd.diskon_persen').show();
				edtsdlittd.field('sdlittd.diskon_value').hide();
				
				edtsdlittd.field('sdlittd.diskon_persen').val();
				edtsdlittd.field('sdlittd.diskon_value').val('');
			} else if (val == 2) {
				edtsdlittd.field('sdlittd.diskon_persen').hide();
				edtsdlittd.field('sdlittd.diskon_value').show();
				
				edtsdlittd.field('sdlittd.diskon_persen').val('');
				edtsdlittd.field('sdlittd.diskon_value').val();
			} else {
				edtsdlittd.field('sdlittd.diskon_persen').hide();
				edtsdlittd.field('sdlittd.diskon_value').hide();
				edtsdlittd.field('sdlittd.diskon_persen').val(0);
				edtsdlittd.field('sdlittd.diskon_value').val(0);
				edtsdlittd.field('sdlittd.diskon_final').val(0);
			}

			hitungDiskon(edtsdlittd, 'sdlittd');
			hitungDpp(edtsdlittd, 'sdlittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsdlittd.dependent( 'sdlittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsdlittd, 'sdlittd');
				hitungDpp(edtsdlittd, 'sdlittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsdlittd.dependent( 'sdlittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsdlittd, 'sdlittd');
				hitungDpp(edtsdlittd, 'sdlittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsdlittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_sdlittd;
			}

			if(action != 'remove'){
				id_iimxxmh = edtsdlittd.field('sdlittd.id_iimxxmh').val();
				id_sodittd = edtsdlittd.field('sdlittd.id_sodittd').val();
				id_podittd = edtsdlittd.field('sdlittd.id_podittd').val();
				id_scsittd = edtsdlittd.field('sdlittd.id_scsittd').val();
				id_iumxxmh_unit = edtsdlittd.field('sdlittd.id_iumxxmh_unit').val();

				validasiRequired(
					edtsdlittd,
					'sdlittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);

				validasiUnique(
					action,
					edtsdlittd, 
					"sdlittd", 
					"id_iimxxmh", 
					'id_iimxxmh, id_sdlxxth',
					id_iimxxmh+","+id_sdlxxth,
					id_sdlittd
				);

				console.log(id_scsittd);

				//jika ini SO konsinyasi
				if (id_scsittd > 0) {
						validasiInventory(id_transaksi, id_iimxxmh, id_iumxxmh_unit, id_iwhxxmh_old, 'scsittd', id_scsittd);
				} else {
					//Jika SO biasa dan bukan PO subcon
					if (id_sodittd > 0) {
						validasiInventory(id_transaksi, id_iimxxmh, id_iumxxmh_unit, id_iwhxxmh_old, 'sodittd', id_sodittd);
					} else {
						validasiInventory(id_transaksi, id_iimxxmh, id_iumxxmh_unit, id_iwhxxmh_old, 'podittd', id_podittd);
					}
				}

			}
			
			if ( edtsdlittd.inError() ) {
				return false;
			}
		});

		edtsdlittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlittd.field('sdlittd.finish_at').val(finish_at);
		});
			
		edtsdlittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			hitungSubtotalHeader(id_transaksi_h, 'sdlittd', 'sdlxxth');
			hitungHeaderDetail('sdlxxth', 'sdlittd', id_transaksi_h);

			tblsdlxxth.ajax.reload(null, false);
			tblsdlittd.rows().deselect();
			tblsdlittd.ajax.reload(null, false);
		} );

		edtsdlittd.on( 'close', function () {
			edtsdlittd.enable();
		} );
		
		tblsdlittd = $('#tblsdlittd').DataTable( {
			ajax: {
				url: "../../models/sdlxxth/sdlittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlittd = show_deleted_sdlittd;
					d.id_sdlxxth = id_sdlxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "sdlittd.id",visible:false },
				{ data: "sdlittd.id_sdlxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "sdlittd.jumlah_unit",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlittd';
					$table       = 'tblsdlittd';
					$edt         = 'edtsdlittd';
					$show_status = '_sdlittd';
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

		tblsdlittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsdlittd, 1 );
			CekDrawDetailHDFinal(tblsdlxxth);
		} );

		tblsdlittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('sdlittd');
			id_iimxxmh_old = sdlittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = sdlittd_data.id_iumxxmh_unit;
			diskon_jenis_select = sdlittd_data.diskon_jenis;
			harga_unit_select = sdlittd_data.harga_unit;

			// atur hak akses
			CekSelectDetailHD( tblsdlittd );
		} );

		tblsdlittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('sdlittd');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, diskon_jenis_select = null, harga_unit_select = null;
			
			// atur hak akses
			CekDeselectDetailHD( tblsdlittd );
		} );
		// END sdlittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsdlxxth.rows().deselect();
				tblsdlxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsdlxxth').modal('toggle');
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
