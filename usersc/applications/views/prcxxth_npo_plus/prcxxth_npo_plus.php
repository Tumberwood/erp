<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'prcxxth_npo';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'prcittd_npo';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFprcxxth_npo" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmprcxxth_npo">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.id_imtxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.id_grlxxmh_supplier"></editor-field>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.referensi_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.referensi"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.plat_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.diskon_persen"></editor-field>
								<editor-field name="prcxxth_npo.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="prcxxth_npo.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="prcxxth_npo.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_npo.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblprcxxth_npo" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
                                <th>Transaction Type</th>
								<th>Supplier</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabprcittd_npo"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabprcittd_npo" class="tab-pane active">
					<div class="panel-body">
						<div id="frmprcittd_npo">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.id_iimxxmh"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.id_iumxxmh_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.jumlah_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.harga_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.subtotal"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.diskon_jenis"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.diskon_persen"></editor-field>
										<editor-field name="prcittd_npo.diskon_value"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.diskon_final"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.dpp"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.tanggal_dibutuhkan"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_npo.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="tblprcittd_npo" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_prcxxth_npo</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prcxxth_npo_plus/fn/prcxxth_npo_plus_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtprcxxth_npo, tblprcxxth_npo, show_deleted_prcxxth_npo = 0, id_prcxxth_npo;
	var edtprcittd_npo, tblprcittd_npo, show_deleted_prcittd_npo = 0, id_prcittd_npo;
	// ------------- end of default variable

	var id_iitxxmh = 0, id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_iwhxxmh_old = 0, is_pajak;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, id_imtxxmh_old = 0;

	// get tableRelation
	tableRelation('prcxxth_npo');

	// console.log(is_master_table);

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN prcxxth_npo
		edtprcxxth_npo = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth_npo/prcxxth_npo.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth_npo = show_deleted_prcxxth_npo;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmprcxxth_npo",
			table: "#tblprcxxth_npo",
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
					label: "prcxxth_npo.start_at",
					name: "prcxxth_npo.start_at",
					type: "hidden"
				},	
				{
					label: "prcxxth_npo.finish_at",
					name: "prcxxth_npo.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcxxth_npo",
					type: "hidden"
				},	
				{
					label: "prcxxth_npo.transaction_state",
					name: "prcxxth_npo.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "prcxxth_npo.tanggal",
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
					label: "Supplier <sup class='text-danger'>*<sup>",
					name: "prcxxth_npo.id_grlxxmh_supplier",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/psuxxmh/psuxxmh_fn_opt.php",
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
					name: "prcxxth_npo.id_imtxxmh",
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
					label: "prcxxth_npo.id_iitxxmh",
					name: "prcxxth_npo.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "prcxxth_npo.id_fpytmmh",
					name: "prcxxth_npo.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "prcxxth_npo.id_fcrxxmh",
					name: "prcxxth_npo.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "prcxxth_npo.id_iwhxxmh",
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
					label: "Surat Jalan <sup class='text-danger'>*<sup>",
					name: "prcxxth_npo.referensi_nomor",
					fieldInfo: "nomor surat jalan pengirim"
				},
				{
					label: "Supir",
					name: "prcxxth_npo.supir_nama"
				},
				{
					label: "Plat Nomor <sup class='text-danger'>*<sup>",
					name: "prcxxth_npo.plat_nomor"
				},
				{
					label: "Referensi <sup class='text-danger'>*<sup>",
					name: "prcxxth_npo.referensi"
				},
				{
					label: getTranslation('subtotal'),
					name: "prcxxth_npo.subtotal",
					type: "readonly"
				},
				{
					label: getTranslation('discount'),
					name: "prcxxth_npo.diskon_jenis",
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
					name: "prcxxth_npo.diskon_persen"
				}, 	
				{
					label: getTranslation('discountValue'),
					name: "prcxxth_npo.diskon_value"
				}, 	
				{
					label: getTranslation('discountFinal'),
					name: "prcxxth_npo.diskon_final",
					type: "readonly"
				},
				{
					label: getTranslation('total'),
					name: "prcxxth_npo.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "prcxxth_npo.dpp_final",
					type: "hidden"
				},
				{
					label: getTranslation('isTaxable'),
					name: "prcxxth_npo.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": getTranslation('yes'), "value": 1 },
						{ "label": getTranslation('no'), "value": 0 }
					]
				},
				{
					label: getTranslation('includingTax'),
					name: "prcxxth_npo.pajak_in_ex",
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
					name: "prcxxth_npo.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "prcxxth_npo.pajak_persen",
					type: "hidden"
				},
				{
					label: getTranslation('tax'),
					name: "prcxxth_npo.pajak_final",
					type: "readonly"
				},
				{
					label: getTranslation('grandTotal'),
					name: "prcxxth_npo.grand_total",
					type: "readonly"
				},
				{
					label: "Keterangan",
					name: "prcxxth_npo.keterangan",
					type: "textarea"
				}
			]
		} );
		
		unmaskedHeader = maskingNumber(
			edtprcxxth_npo, 
			"prcxxth_npo", 
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

		edtprcxxth_npo.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcxxth_npo.field('prcxxth_npo.start_at').val(start_at);

			if(action == 'create'){
				tblprcxxth_npo.rows().deselect();
			}
		});

		edtprcxxth_npo.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtprcxxth_npo.dependent( 'prcxxth_npo.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtprcxxth_npo.field('prcxxth_npo.diskon_persen').show();
				edtprcxxth_npo.field('prcxxth_npo.diskon_value').hide();
				
				edtprcxxth_npo.field('prcxxth_npo.diskon_persen').val();
				edtprcxxth_npo.field('prcxxth_npo.diskon_value').val('');
			} else if (val == 2) {
				edtprcxxth_npo.field('prcxxth_npo.diskon_persen').hide();
				edtprcxxth_npo.field('prcxxth_npo.diskon_value').show();
				
				edtprcxxth_npo.field('prcxxth_npo.diskon_persen').val('');
				edtprcxxth_npo.field('prcxxth_npo.diskon_value').val();
			} else {
				edtprcxxth_npo.field('prcxxth_npo.diskon_persen').hide();
				edtprcxxth_npo.field('prcxxth_npo.diskon_value').hide();
				
				edtprcxxth_npo.field('prcxxth_npo.diskon_persen').val(0);
				edtprcxxth_npo.field('prcxxth_npo.diskon_value').val(0);
				edtprcxxth_npo.field('prcxxth_npo.diskon_final').val(0);
			}
			hitungDiskon(edtprcxxth_npo, 'prcxxth_npo');
			hitungDpp(edtprcxxth_npo, 'prcxxth_npo');
			hitungHeader(edtprcxxth_npo,'prcxxth_npo', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtprcxxth_npo.dependent( 'prcxxth_npo.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtprcxxth_npo, 'prcxxth_npo');
			hitungDpp(edtprcxxth_npo, 'prcxxth_npo');
			hitungHeader(edtprcxxth_npo,'prcxxth_npo', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtprcxxth_npo.dependent( 'prcxxth_npo.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtprcxxth_npo, 'prcxxth_npo');
			hitungDpp(edtprcxxth_npo, 'prcxxth_npo');
			hitungHeader(edtprcxxth_npo,'prcxxth_npo', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtprcxxth_npo.dependent( 'prcxxth_npo.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master supplier. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtprcxxth_npo,'prcxxth_npo', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtprcxxth_npo.dependent( 'prcxxth_npo.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtprcxxth_npo,'prcxxth_npo', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtprcxxth_npo.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal             = edtprcxxth_npo.field('prcxxth_npo.tanggal').val();
				id_iwhxxmh          = edtprcxxth_npo.field('prcxxth_npo.id_iwhxxmh').val();
				id_imtxxmh          = edtprcxxth_npo.field('prcxxth_npo.id_imtxxmh').val();
				id_grlxxmh_supplier = edtprcxxth_npo.field('prcxxth_npo.id_grlxxmh_supplier').val();
				referensi_nomor     = edtprcxxth_npo.field('prcxxth_npo.referensi_nomor').val();
				plat_nomor     = edtprcxxth_npo.field('prcxxth_npo.plat_nomor').val();
				referensi     = edtprcxxth_npo.field('prcxxth_npo.referensi').val();

				validasiRequired(
					edtprcxxth_npo, 
					"prcxxth_npo", 
					{
						"tanggal": tanggal, 
						"id_grlxxmh_supplier": id_grlxxmh_supplier,
						"id_iwhxxmh": id_iwhxxmh,
						"id_imtxxmh": id_imtxxmh,
						"referensi_nomor": referensi_nomor,
						"plat_nomor": plat_nomor,
						"referensi": referensi,
					}
				);

			}
			
			if ( edtprcxxth_npo.inError() ) {
				return false;
			}
		});

		edtprcxxth_npo.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcxxth_npo.field('prcxxth_npo.finish_at').val(finish_at);
			
			diskon_final_h = edtprcxxth_npo.field('prcxxth_npo.diskon_final').input().inputmask('unmaskedvalue');
			dpp_final_h    = edtprcxxth_npo.field('prcxxth_npo.dpp_final').input().inputmask('unmaskedvalue');
			pajak_final_h  = edtprcxxth_npo.field('prcxxth_npo.pajak_final').input().inputmask('unmaskedvalue');
			grand_total_h  = edtprcxxth_npo.field('prcxxth_npo.grand_total').input().inputmask('unmaskedvalue');
			
			prcxxth_npoUpdateFooter();
		});
		
		edtprcxxth_npo.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			edtprcxxth_npo.field('prcxxth_npo.diskon_final').val(diskon_final_h);
			edtprcxxth_npo.field('prcxxth_npo.dpp_final').val(dpp_final_h);
			edtprcxxth_npo.field('prcxxth_npo.pajak_final').val(pajak_final_h);
			edtprcxxth_npo.field('prcxxth_npo.grand_total').val(grand_total_h);
		} );

		edtprcxxth_npo.on( 'close', function () {
			edtprcxxth_npo.enable();
		} );
		
		tblprcxxth_npo = $('#tblprcxxth_npo').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/prcxxth_npo/prcxxth_npo.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth_npo = show_deleted_prcxxth_npo;
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
				{ data: "prcxxth_npo.id",visible:false },
				{ data: "prcxxth_npo.tanggal" },
				{ data: "prcxxth_npo.kode" },
				{ data: "imtxxmh.nama" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ 
					data: "prcxxth_npo.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcxxth_npo';
					$table       = 'tblprcxxth_npo';
					$edt         = 'edtprcxxth_npo';
					$show_status = '_prcxxth_npo';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.prcxxth_npo.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prcxxth_npo.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprcxxth_npo.searchPanes.container().appendTo('#spprcxxth_npo');
		tblprcxxth_npo.searchBuilder.container().appendTo( '#sbprcxxth_npo' );
		
		tblprcxxth_npo.on( 'init', function () {
			// atur hak akses
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;

			tbl_details = [tblprcittd_npo];
			CekInitHeaderHD(tblprcxxth_npo, tbl_details);
		} );
		
		tblprcxxth_npo.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prcxxth_npo');
			id_grlxxmh_old      = prcxxth_npo_data.id_grlxxmh_supplier;
			id_grlxxmh_supplier = prcxxth_npo_data.id_grlxxmh_supplier;
			id_iwhxxmh_old      = prcxxth_npo_data.id_iwhxxmh;
			id_imtxxmh_old      = prcxxth_npo_data.id_imtxxmh;
			
			// terkait footer
			diskon_final_h = prcxxth_npo_data.diskon_final;
			dpp_final_h    = prcxxth_npo_data.dpp_final;
			pajak_final_h  = prcxxth_npo_data.pajak_final;
			grand_total_h  = prcxxth_npo_data.grand_total;
			prcxxth_npoUpdateFooter();
			
			// atur hak akses
			tbl_details = [tblprcittd_npo];
			CekSelectHeaderHD(tblprcxxth_npo, tbl_details);
		} );
		
		tblprcxxth_npo.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('prcxxth_npo');
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_iwhxxmh_old = 0, id_imtxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblprcittd_npo];
			CekDeselectHeaderHD(tblprcxxth_npo, tbl_details);
		} );
		// END prcxxth_npo

		// BEGIN prcittd_npo
		edtprcittd_npo = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth_npo/prcittd_npo.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd_npo = show_deleted_prcittd_npo;
					d.id_prcxxth_npo = id_prcxxth_npo;
				}
			},
			table: "#tblprcittd_npo",
			template: "#frmprcittd_npo",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "prcittd_npo.start_at",
					name: "prcittd_npo.start_at",
					type: "hidden"
				},	
				{
					label: "prcittd_npo.finish_at",
					name: "prcittd_npo.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcittd_npo",
					type: "hidden"
				},	
				{
					label: "prcittd_npo.transaction_state",
					name: "prcittd_npo.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_prcxxth_npo",
					name: "prcittd_npo.id_prcxxth_npo",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "prcittd_npo.id_iimxxmh",
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
					name: "prcittd_npo.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "prcittd_npo.id_iumxxmh_unit",
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
					name: "prcittd_npo.keterangan",
					type: "textarea"
				},
				{
					label: "Request Info",
					name: "prqittd_info",
					type: "textarea"
				},
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "prcittd_npo.harga_unit"
				},
				{
					label: "Subtotal",
					name: "prcittd_npo.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "prcittd_npo.diskon_jenis",
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
					name: "prcittd_npo.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "prcittd_npo.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "prcittd_npo.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "prcittd_npo.dpp",
					type: "readonly"
				},
				{
					label: "Tanggal Dibutuhkan",
					name: "prcittd_npo.tanggal_dibutuhkan",
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
			]
		} );
			
		unmaskedData = maskingNumber(
			edtprcittd_npo, 
			"prcittd_npo", 
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
		
		edtprcittd_npo.on( 'preOpen', function( e, mode, action ) {
			edtprcittd_npo.field('prcittd_npo.id_prcxxth_npo').val(id_prcxxth_npo);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcittd_npo.field('prcittd_npo.start_at').val(start_at);
			
			if(action == 'create'){
				tblprcittd_npo.rows().deselect();
			}
		});

		edtprcittd_npo.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtprcittd_npo.dependent( 'prcittd_npo.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtprcittd_npo.field('prcittd_npo.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtprcittd_npo.dependent( 'prcittd_npo.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtprcittd_npo, 'prcittd_npo');
			hitungDpp(edtprcittd_npo, 'prcittd_npo');
			return {}
		}, {event: 'keyup change'});
		
		edtprcittd_npo.dependent( 'prcittd_npo.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtprcittd_npo, 'prcittd_npo');
			hitungDpp(edtprcittd_npo, 'prcittd_npo');

			return {}
		}, {event: 'keyup change'});

		edtprcittd_npo.dependent( 'prcittd_npo.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtprcittd_npo.field('prcittd_npo.diskon_persen').show();
				edtprcittd_npo.field('prcittd_npo.diskon_value').hide();
				
				edtprcittd_npo.field('prcittd_npo.diskon_persen').val();
				edtprcittd_npo.field('prcittd_npo.diskon_value').val('');
			} else if (val == 2) {
				edtprcittd_npo.field('prcittd_npo.diskon_persen').hide();
				edtprcittd_npo.field('prcittd_npo.diskon_value').show();
				
				edtprcittd_npo.field('prcittd_npo.diskon_persen').val('');
				edtprcittd_npo.field('prcittd_npo.diskon_value').val();
			} else {
				edtprcittd_npo.field('prcittd_npo.diskon_persen').hide();
				edtprcittd_npo.field('prcittd_npo.diskon_value').hide();
				edtprcittd_npo.field('prcittd_npo.diskon_persen').val(0);
				edtprcittd_npo.field('prcittd_npo.diskon_value').val(0);
				edtprcittd_npo.field('prcittd_npo.diskon_final').val(0);
			}

			hitungDiskon(edtprcittd_npo, 'prcittd_npo');
			hitungDpp(edtprcittd_npo, 'prcittd_npo');
			return {}
		}, {event: 'keyup change'});
		
		edtprcittd_npo.dependent( 'prcittd_npo.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtprcittd_npo, 'prcittd_npo');
				hitungDpp(edtprcittd_npo, 'prcittd_npo');
			}
			return {}
		}, {event: 'keyup'});
		
		edtprcittd_npo.dependent( 'prcittd_npo.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtprcittd_npo, 'prcittd_npo');
				hitungDpp(edtprcittd_npo, 'prcittd_npo');
			}
			return {}
		}, {event: 'keyup'});
		
		edtprcittd_npo.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_prcittd_npo;
			}

			if(action != 'remove'){
				id_iimxxmh = edtprcittd_npo.field('prcittd_npo.id_iimxxmh').val();
				jumlah_unit = edtprcittd_npo.field('prcittd_npo.jumlah_unit').val();
				id_iumxxmh_unit = edtprcittd_npo.field('prcittd_npo.id_iumxxmh_unit').val();

				validasiRequired(
					edtprcittd_npo,
					'prcittd_npo',
					{
						'id_iimxxmh': id_iimxxmh,
						'jumlah_unit': jumlah_unit,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);
				
				validasiNumber(
					edtprcittd_npo,
					'prcittd_npo',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

			}
			
			if ( edtprcittd_npo.inError() ) {
				return false;
			}
		});

		edtprcittd_npo.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcittd_npo.field('prcittd_npo.finish_at').val(finish_at);
		});
			
		edtprcittd_npo.on( 'postSubmit', function (e, json, data, action, xhr) {
			hitungSubtotalHeader(id_transaksi_h, 'prcittd_npo', 'prcxxth_npo');
			hitungHeaderDetail('prcxxth_npo', 'prcittd_npo', id_transaksi_h);

			tblprcxxth_npo.ajax.reload(null, false);
			tblprcittd_npo.rows().deselect();
			tblprcittd_npo.ajax.reload(null, false);
		} );

		edtprcittd_npo.on( 'close', function () {
			edtprcittd_npo.enable();
		} );
		
		tblprcittd_npo = $('#tblprcittd_npo').DataTable( {
			ajax: {
				url: "../../models/prcxxth_npo/prcittd_npo.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd_npo = show_deleted_prcittd_npo;
					d.id_prcxxth_npo = id_prcxxth_npo;
				}
			},
			responsive: false,
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "prcittd_npo.id",visible:false },
				{ data: "prcittd_npo.id_prcxxth_npo",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "prcittd_npo.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "prcittd_npo.harga_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "prcittd_npo.subtotal",
					...renderNumber( 0, "")
				},
				{ 
					data: "prcittd_npo.diskon_final",
					...renderNumber( 0, "")
				},
				{ 
					data: "prcittd_npo.dpp",
					...renderNumber( 0, "")
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcittd_npo';
					$table       = 'tblprcittd_npo';
					$edt         = 'edtprcittd_npo';
					$show_status = '_prcittd_npo';
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

		tblprcittd_npo.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblprcittd_npo, 1 );
			CekDrawDetailHDFinal(tblprcxxth_npo);
		} );

		tblprcittd_npo.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('prcittd_npo');
			id_iimxxmh_old = prcittd_npo_data.id_iimxxmh;
			id_iumxxmh_unit_old = prcittd_npo_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblprcittd_npo );
		} );

		tblprcittd_npo.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('prcittd_npo');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblprcittd_npo );
		} );
		// END prcittd_npo

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblprcxxth_npo.rows().deselect();
				tblprcxxth_npo.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFprcxxth_npo').modal('toggle');
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
