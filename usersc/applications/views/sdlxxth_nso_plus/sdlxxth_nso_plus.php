<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sdlxxth_nso';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sdlittd_nso';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFsdlxxth_nso" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmsdlxxth_nso">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.id_imtxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.id_grlxxmh_customer"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.referensi_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.referensi"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.plat_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.diskon_persen"></editor-field>
								<editor-field name="sdlxxth_nso.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="sdlxxth_nso.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sdlxxth_nso.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="sdlxxth_nso.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblsdlxxth_nso" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
                                <th>Transaction Type</th>
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

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabsdlittd_nso"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsdlittd_nso" class="tab-pane active">
					<div class="panel-body">
						<div id="frmsdlittd_nso">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.id_iimxxmh"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.id_iumxxmh_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.jumlah_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.harga_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.subtotal"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.diskon_jenis"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.diskon_persen"></editor-field>
										<editor-field name="sdlittd_nso.diskon_value"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.diskon_final"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.dpp"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.tanggal_dibutuhkan"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_nso.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="tblsdlittd_nso" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sdlxxth_nso</th>
										<th>SKU</th>
										<th>Item</th>
										<th>UoM</th>
										<th data-i18n="quantity"></th>
										<th data-i18n="unitPrice"></th>
										<th data-i18n="subtotal"></th>
										<th data-i18n="discount"></th>
										<th data-i18n="total"></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th id="c_item"></th>
										<th data-i18n="subtotal"></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="s_subtotal"></th>
									</tr>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th data-i18n="discount"></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="diskon_final_h"></th>
									</tr>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th data-i18n="taxBase"></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="dpp_final_h"></th>
									</tr>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th data-i18n="tax"></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="pajak_final_h"></th>
									</tr>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th data-i18n="total"></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="grand_total_h"></th>
									</tr>
								</tfoot>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sdlxxth_nso_plus/fn/sdlxxth_nso_plus_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtsdlxxth_nso, tblsdlxxth_nso, show_deleted_sdlxxth_nso = 0, id_sdlxxth_nso;
	var edtsdlittd_nso, tblsdlittd_nso, show_deleted_sdlittd_nso = 0, id_sdlittd_nso;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_iwhxxmh_old = 0, id_imtxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, id_iitxxmh = 0;

	// get tableRelation
	tableRelation('sdlxxth_nso');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN sdlxxth_nso
		edtsdlxxth_nso = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sdlxxth_nso/sdlxxth_nso.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth_nso = show_deleted_sdlxxth_nso;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmsdlxxth_nso",
			table: "#tblsdlxxth_nso",
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
					label: "sdlxxth_nso.start_at",
					name: "sdlxxth_nso.start_at",
					type: "hidden"
				},	
				{
					label: "sdlxxth_nso.finish_at",
					name: "sdlxxth_nso.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sdlxxth_nso",
					type: "hidden"
				},	
				{
					label: "sdlxxth_nso.transaction_state",
					name: "sdlxxth_nso.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "sdlxxth_nso.tanggal",
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
					name: "sdlxxth_nso.id_grlxxmh_customer",
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
					name: "sdlxxth_nso.id_imtxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/imtxxmh/imtxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_imtxxmh_old: id_imtxxmh_old,
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
					label: "sdlxxth_nso.id_iitxxmh",
					name: "sdlxxth_nso.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "sdlxxth_nso.id_fpytmmh",
					name: "sdlxxth_nso.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "sdlxxth_nso.id_fcrxxmh",
					name: "sdlxxth_nso.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "sdlxxth_nso.id_iwhxxmh",
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
					label: "Supir <sup class='text-danger'>*<sup>",
					name: "sdlxxth_nso.supir_nama"
				},
				{
					label: "Plat Nomor <sup class='text-danger'>*<sup>",
					name: "sdlxxth_nso.plat_nomor"
				},
				{
					label: "Referensi <sup class='text-danger'>*<sup>",
					name: "sdlxxth_nso.referensi"
				},
				{
					label: "Surat Jalan",
					name: "sdlxxth_nso.referensi_nomor",
					fieldInfo: "nomor surat jalan pengirim"
				},
				{
					label: getTranslation('subtotal'),
					name: "sdlxxth_nso.subtotal",
					type: "readonly"
				},
				{
					label: getTranslation('discount'),
					name: "sdlxxth_nso.diskon_jenis",
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
					name: "sdlxxth_nso.diskon_persen"
				}, 	
				{
					label: getTranslation('discountValue'),
					name: "sdlxxth_nso.diskon_value"
				}, 	
				{
					label: getTranslation('discountFinal'),
					name: "sdlxxth_nso.diskon_final",
					type: "readonly"
				},
				{
					label: getTranslation('total'),
					name: "sdlxxth_nso.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "sdlxxth_nso.dpp_final",
					type: "hidden"
				},
				{
					label: getTranslation('isTaxable'),
					name: "sdlxxth_nso.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": getTranslation('yes'), "value": 1 },
						{ "label": getTranslation('no'), "value": 0 }
					]
				},
				{
					label: getTranslation('includingTax'),
					name: "sdlxxth_nso.pajak_in_ex",
					type: "select",
					def: 2,
					placeholder : "Select",
					options: [
						{ "label": getTranslation('yes'), "value": 1 },
						{ "label": getTranslation('no'), "value": 2 }
					]
				},
				{
					label: "pajak_jenis",
					name: "sdlxxth_nso.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "sdlxxth_nso.pajak_persen",
					type: "hidden"
				},
				{
					label: getTranslation('tax'),
					name: "sdlxxth_nso.pajak_final",
					type: "readonly"
				},
				{
					label: getTranslation('grandTotal'),
					name: "sdlxxth_nso.grand_total",
					type: "readonly"
				},
				{
					label: "Keterangan",
					name: "sdlxxth_nso.keterangan",
					type: "textarea"
				},
			]
		} );
		
		unmaskedHeader = maskingNumber(
			edtsdlxxth_nso, 
			"sdlxxth_nso", 
			[ 
				"subtotal", 
				"diskon_persen", 
				"diskon_value", 
				"diskon_final", 
				"dpp", 
				"pajak_final", 
				"grand_total", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>=' // val >= 0
		);

		edtsdlxxth_nso.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlxxth_nso.field('sdlxxth_nso.start_at').val(start_at);

			if(action == 'create'){
				tblsdlxxth_nso.rows().deselect();
			}
		});

		edtsdlxxth_nso.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtsdlxxth_nso.dependent( 'sdlxxth_nso.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_persen').show();
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_value').hide();
				
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_persen').val();
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_value').val('');
			} else if (val == 2) {
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_persen').hide();
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_value').show();
				
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_persen').val('');
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_value').val();
			} else {
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_persen').hide();
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_value').hide();
				
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_persen').val(0);
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_value').val(0);
				edtsdlxxth_nso.field('sdlxxth_nso.diskon_final').val(0);
			}
			hitungDiskon(edtsdlxxth_nso, 'sdlxxth_nso');
			hitungDpp(edtsdlxxth_nso, 'sdlxxth_nso');
			hitungHeader(edtsdlxxth_nso,'sdlxxth_nso', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsdlxxth_nso.dependent( 'sdlxxth_nso.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtsdlxxth_nso, 'sdlxxth_nso');
			hitungDpp(edtsdlxxth_nso, 'sdlxxth_nso');
			hitungHeader(edtsdlxxth_nso,'sdlxxth_nso', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtsdlxxth_nso.dependent( 'sdlxxth_nso.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtsdlxxth_nso, 'sdlxxth_nso');
			hitungDpp(edtsdlxxth_nso, 'sdlxxth_nso');
			hitungHeader(edtsdlxxth_nso,'sdlxxth_nso', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtsdlxxth_nso.dependent( 'sdlxxth_nso.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master supplier. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtsdlxxth_nso,'sdlxxth_nso', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtsdlxxth_nso.dependent( 'sdlxxth_nso.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtsdlxxth_nso,'sdlxxth_nso', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsdlxxth_nso.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal         = edtsdlxxth_nso.field('sdlxxth_nso.tanggal').val();
				id_iwhxxmh      = edtsdlxxth_nso.field('sdlxxth_nso.id_iwhxxmh').val();
				id_imtxxmh      = edtsdlxxth_nso.field('sdlxxth_nso.id_imtxxmh').val();
				supir_nama      = edtsdlxxth_nso.field('sdlxxth_nso.supir_nama').val();
				id_grlxxmh_customer      = edtsdlxxth_nso.field('sdlxxth_nso.id_grlxxmh_customer').val();
				plat_nomor      = edtsdlxxth_nso.field('sdlxxth_nso.plat_nomor').val();
				referensi      = edtsdlxxth_nso.field('sdlxxth_nso.referensi').val();

				validasiRequired(
					edtsdlxxth_nso, 
					"sdlxxth_nso", 
					{
						"tanggal": tanggal, 
						"id_iwhxxmh": id_iwhxxmh, 
						"id_imtxxmh": id_imtxxmh, 
						"supir_nama": supir_nama, 
						"id_grlxxmh_customer": id_grlxxmh_customer,
						"plat_nomor": plat_nomor,
						"referensi": referensi,
					}
				);

			}
			
			if ( edtsdlxxth_nso.inError() ) {
				return false;
			}
		});

		edtsdlxxth_nso.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlxxth_nso.field('sdlxxth_nso.finish_at').val(finish_at);
			
			diskon_final_h = edtsdlxxth_nso.field('sdlxxth_nso.diskon_final').input().inputmask('unmaskedvalue');
			dpp_final_h    = edtsdlxxth_nso.field('sdlxxth_nso.dpp_final').input().inputmask('unmaskedvalue');
			pajak_final_h  = edtsdlxxth_nso.field('sdlxxth_nso.pajak_final').input().inputmask('unmaskedvalue');
			grand_total_h  = edtsdlxxth_nso.field('sdlxxth_nso.grand_total').input().inputmask('unmaskedvalue');
			
			sdlxxth_nsoUpdateFooter();
		});
		
		edtsdlxxth_nso.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			edtsdlxxth_nso.field('sdlxxth_nso.diskon_final').val(diskon_final_h);
			edtsdlxxth_nso.field('sdlxxth_nso.dpp_final').val(dpp_final_h);
			edtsdlxxth_nso.field('sdlxxth_nso.pajak_final').val(pajak_final_h);
			edtsdlxxth_nso.field('sdlxxth_nso.grand_total').val(grand_total_h);
		} );

		edtsdlxxth_nso.on( 'close', function () {
			edtsdlxxth_nso.enable();
		} );
		
		tblsdlxxth_nso = $('#tblsdlxxth_nso').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/sdlxxth_nso/sdlxxth_nso.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlxxth_nso = show_deleted_sdlxxth_nso;
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
				{ data: "sdlxxth_nso.id",visible:false },
				{ data: "sdlxxth_nso.tanggal" },
				{ data: "sdlxxth_nso.kode" },
				{ data: "imtxxmh.nama" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ 
					data: "sdlxxth_nso.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlxxth_nso';
					$table       = 'tblsdlxxth_nso';
					$edt         = 'edtsdlxxth_nso';
					$show_status = '_sdlxxth_nso';
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Sales Delivery&id_transaksi='+id_sdlxxth_nso, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.sdlxxth_nso.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sdlxxth_nso.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsdlxxth_nso.searchPanes.container().appendTo('#spsdlxxth_nso');
		tblsdlxxth_nso.searchBuilder.container().appendTo( '#sbsdlxxth_nso' );
		
		tblsdlxxth_nso.on( 'init', function () {
			// atur hak akses
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;

			tbl_details = [tblsdlittd_nso];
			CekInitHeaderHD(tblsdlxxth_nso, tbl_details);
		} );
		
		tblsdlxxth_nso.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('sdlxxth_nso');
			id_grlxxmh_old      = sdlxxth_nso_data.id_grlxxmh_customer;
			id_grlxxmh_customer = sdlxxth_nso_data.id_grlxxmh_customer;
			id_iwhxxmh_old      = sdlxxth_nso_data.id_iwhxxmh;
			id_imtxxmh_old      = sdlxxth_nso_data.id_imtxxmh;
			
			// terkait footer
			diskon_final_h = sdlxxth_nso_data.diskon_final;
			dpp_final_h    = sdlxxth_nso_data.dpp_final;
			pajak_final_h  = sdlxxth_nso_data.pajak_final;
			grand_total_h  = sdlxxth_nso_data.grand_total;
			sdlxxth_nsoUpdateFooter();

			// atur hak akses
			tbl_details = [tblsdlittd_nso];
			CekSelectHeaderHD(tblsdlxxth_nso, tbl_details);

		} );
		
		tblsdlxxth_nso.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('sdlxxth_nso');
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_iwhxxmh_old = 0, id_imtxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblsdlittd_nso];
			CekDeselectHeaderHD(tblsdlxxth_nso, tbl_details);
		} );
		// END sdlxxth_nso

		// BEGIN sdlittd_nso
		edtsdlittd_nso = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sdlxxth_nso/sdlittd_nso.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlittd_nso = show_deleted_sdlittd_nso;
					d.id_sdlxxth_nso = id_sdlxxth_nso;
				}
			},
			table: "#tblsdlittd_nso",
			template: "#frmsdlittd_nso",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "sdlittd_nso.start_at",
					name: "sdlittd_nso.start_at",
					type: "hidden"
				},	
				{
					label: "sdlittd_nso.finish_at",
					name: "sdlittd_nso.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sdlittd_nso",
					type: "hidden"
				},	
				{
					label: "sdlittd_nso.transaction_state",
					name: "sdlittd_nso.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sdlxxth_nso",
					name: "sdlittd_nso.id_sdlxxth_nso",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sdlittd_nso.id_iimxxmh",
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
					name: "sdlittd_nso.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "sdlittd_nso.id_iumxxmh_unit",
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
					name: "sdlittd_nso.keterangan",
					type: "textarea"
				},
				{
					label: "Request Info",
					name: "prqittd_info",
					type: "textarea"
				},
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "sdlittd_nso.harga_unit"
				},
				{
					label: "Subtotal",
					name: "sdlittd_nso.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "sdlittd_nso.diskon_jenis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "-", "value": 0 },
						{ "label": "Percent", "value": 1 },
						{ "label": "Value", "value": 2 }
					]
				},
				{
					label: "Diskon (%)",
					name: "sdlittd_nso.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "sdlittd_nso.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "sdlittd_nso.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "sdlittd_nso.dpp",
					type: "readonly"
				},
			]
		} );
			
		unmaskedData = maskingNumber(
			edtsdlittd_nso, 
			"sdlittd_nso", 
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
		
		edtsdlittd_nso.on( 'preOpen', function( e, mode, action ) {
			edtsdlittd_nso.field('sdlittd_nso.id_sdlxxth_nso').val(id_sdlxxth_nso);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlittd_nso.field('sdlittd_nso.start_at').val(start_at);
			
			if(action == 'create'){
				tblsdlittd_nso.rows().deselect();
			}
		});

		edtsdlittd_nso.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtsdlittd_nso.dependent( 'sdlittd_nso.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtsdlittd_nso.field('sdlittd_nso.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtsdlittd_nso.dependent( 'sdlittd_nso.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsdlittd_nso, 'sdlittd_nso');
			hitungDpp(edtsdlittd_nso, 'sdlittd_nso');
			return {}
		}, {event: 'keyup change'});
		
		edtsdlittd_nso.dependent( 'sdlittd_nso.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsdlittd_nso, 'sdlittd_nso');
			hitungDpp(edtsdlittd_nso, 'sdlittd_nso');

			return {}
		}, {event: 'keyup change'});

		edtsdlittd_nso.dependent( 'sdlittd_nso.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsdlittd_nso.field('sdlittd_nso.diskon_persen').show();
				edtsdlittd_nso.field('sdlittd_nso.diskon_value').hide();
				
				edtsdlittd_nso.field('sdlittd_nso.diskon_persen').val();
				edtsdlittd_nso.field('sdlittd_nso.diskon_value').val('');
			} else if (val == 2) {
				edtsdlittd_nso.field('sdlittd_nso.diskon_persen').hide();
				edtsdlittd_nso.field('sdlittd_nso.diskon_value').show();
				
				edtsdlittd_nso.field('sdlittd_nso.diskon_persen').val('');
				edtsdlittd_nso.field('sdlittd_nso.diskon_value').val();
			} else {
				edtsdlittd_nso.field('sdlittd_nso.diskon_persen').hide();
				edtsdlittd_nso.field('sdlittd_nso.diskon_value').hide();
				edtsdlittd_nso.field('sdlittd_nso.diskon_persen').val(0);
				edtsdlittd_nso.field('sdlittd_nso.diskon_value').val(0);
				edtsdlittd_nso.field('sdlittd_nso.diskon_final').val(0);
			}

			hitungDiskon(edtsdlittd_nso, 'sdlittd_nso');
			hitungDpp(edtsdlittd_nso, 'sdlittd_nso');
			return {}
		}, {event: 'keyup change'});
		
		edtsdlittd_nso.dependent( 'sdlittd_nso.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsdlittd_nso, 'sdlittd_nso');
				hitungDpp(edtsdlittd_nso, 'sdlittd_nso');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsdlittd_nso.dependent( 'sdlittd_nso.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsdlittd_nso, 'sdlittd_nso');
				hitungDpp(edtsdlittd_nso, 'sdlittd_nso');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsdlittd_nso.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_sdlittd_nso;
			}

			if(action != 'remove'){
				id_iimxxmh = edtsdlittd_nso.field('sdlittd_nso.id_iimxxmh').val();
				jumlah_unit = edtsdlittd_nso.field('sdlittd_nso.jumlah_unit').val();
				id_iumxxmh_unit = edtsdlittd_nso.field('sdlittd_nso.id_iumxxmh_unit').val();

				validasiRequired(
					edtsdlittd_nso,
					'sdlittd_nso',
					{
						'id_iimxxmh': id_iimxxmh,
						'jumlah_unit': jumlah_unit,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);
				
				validasiNumber(
					edtsdlittd_nso,
					'sdlittd_nso',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

			}
			
			if ( edtsdlittd_nso.inError() ) {
				return false;
			}
		});

		edtsdlittd_nso.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsdlittd_nso.field('sdlittd_nso.finish_at').val(finish_at);
		});
			
		edtsdlittd_nso.on( 'postSubmit', function (e, json, data, action, xhr) {
			hitungSubtotalHeader(id_transaksi_h, 'sdlittd_nso', 'sdlxxth_nso');
			hitungHeaderDetail('sdlxxth_nso', 'sdlittd_nso', id_transaksi_h);

			tblsdlxxth_nso.ajax.reload(null, false);
			tblsdlittd_nso.rows().deselect();
			tblsdlittd_nso.ajax.reload(null, false);
		} );

		edtsdlittd_nso.on( 'close', function () {
			edtsdlittd_nso.enable();
		} );
		
		tblsdlittd_nso = $('#tblsdlittd_nso').DataTable( {
			ajax: {
				url: "../../models/sdlxxth_nso/sdlittd_nso.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sdlittd_nso = show_deleted_sdlittd_nso;
					d.id_sdlxxth_nso = id_sdlxxth_nso;
				}
			},
			responsive: false,
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "sdlittd_nso.id",visible:false },
				{ data: "sdlittd_nso.id_sdlxxth_nso",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "sdlittd_nso.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "sdlittd_nso.harga_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "sdlittd_nso.subtotal",
					...renderNumber( 0, "")
				},
				{ 
					data: "sdlittd_nso.diskon_final",
					...renderNumber( 0, "")
				},
				{ 
					data: "sdlittd_nso.dpp",
					...renderNumber( 0, "")
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlittd_nso';
					$table       = 'tblsdlittd_nso';
					$edt         = 'edtsdlittd_nso';
					$show_status = '_sdlittd_nso';
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
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();
				var s_subtotal 	= api.column(9).data().sum();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
				$( '#s_subtotal' ).html( dtNumberFormat(s_subtotal) );
			}
		} );

		tblsdlittd_nso.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsdlittd_nso, 1 );
			CekDrawDetailHDFinal(tblsdlxxth_nso);
		} );

		tblsdlittd_nso.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('sdlittd_nso');
			id_iimxxmh_old = sdlittd_nso_data.id_iimxxmh;
			id_iumxxmh_unit_old = sdlittd_nso_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblsdlittd_nso );
		} );

		tblsdlittd_nso.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('sdlittd_nso');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsdlittd_nso );
		} );
		// END sdlittd_nso

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsdlxxth_nso.rows().deselect();
				tblsdlxxth_nso.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsdlxxth_nso').modal('toggle');
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
