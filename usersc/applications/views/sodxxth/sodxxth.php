<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sodxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sodittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFsodxxth" tabindex="-1" role="dialog" aria-hidden="true">
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

				<!-- start Custom Form Datatables Editor -->
				<div id="frmsodxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.tanggal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.id_iitxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.id_grlxxmh_customer"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.id_fcrxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.id_fpytmmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.diskon_persen"></editor-field>
								<editor-field name="sodxxth.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="sodxxth.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sodxxth.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sodxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<table id="tblsodxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th data-i18n="documentNumber"></th>
							<th data-i18n="date"></th>
							<th data-i18n="customer"></th>
							<th data-i18n="type"></th>
							<th data-i18n="state"></th>
							<th data-i18n="approvalState"></th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabsodittd" data-i18n="item"> </a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabsodittd_2" data-i18n="expenses"></a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsodittd" class="tab-pane active">
					<div class="panel-body">
						<!-- start Custom Form Datatables Editor -->
						<div id="frmsodittd">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sodittd.id_sqtittd"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sqtittd_info"></editor-field>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sodittd.id_iimxxmh"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.id_iumxxmh_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sodittd.jumlah_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.harga_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.subtotal"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sodittd.diskon_jenis"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.diskon_persen"></editor-field>
										<editor-field name="sodittd.diskon_value"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.diskon_final"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.dpp"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sodittd.tanggal_dibutuhkan"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sodittd.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<!-- end Custom Form Datatables Editor -->
						
							<table id="tblsodittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sodxxth</th>
										<th data-i18n="itemCode"></th>
										<th data-i18n="itemName"></th>
										<th data-i18n="uom"></th>
										<th data-i18n="quantity"></th>
										<th data-i18n="price"></th>
										<th data-i18n="subtotal"></th>
										<th data-i18n="discount"></th>
										<th data-i18n="total"></th>
										<th data-i18n="salesQuotation"></th>
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
										<th></th>
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
										<th></th>
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
										<th></th>
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
										<th></th>
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
										<th></th>
									</tr>
								</tfoot>
							</table>
						

					</div>
				</div>
				<div role="tabpanel" id="tabsodittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsodittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sodxxth</th>
										<th data-i18n="code"></th>
										<th data-i18n="name"></th>
										<th data-i18n="notes"></th>
									</tr>
								</thead>
							</table>
						</div>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sodxxth/fn/sodxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtsodxxth, tblsodxxth, show_deleted_sodxxth = 0, id_sodxxth;
	var edtsodittd, tblsodittd, show_deleted_sodittd = 0, id_sodittd;
	// ------------- end of default variable

	var id_iitxxmh_old = 0, id_grlxxmh_old = 0, id_fcrxxmh_old = 0, id_fpytmmh_old = 0, is_pajak, id_iitxxmh;
	var id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, id_sqtittd_old = 0, id_iumxxmh_unit  = 0;

	// get tableRelation
	tableRelation('sodxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN sodxxth
		edtsodxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sodxxth/sodxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sodxxth = show_deleted_sodxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmsodxxth",
			table: "#tblsodxxth",
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
					label: "sodxxth.start_at",
					name: "sodxxth.start_at",
					type: "hidden"
				},	
				{
					label: "sodxxth.finish_at",
					name: "sodxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sodxxth",
					type: "hidden"
				},	
				{
					label: "sodxxth.transaction_state",
					name: "sodxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('type') + ' <sup class="text-danger">*</sup>',
					name: "sodxxth.id_iitxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iitxxmh/iitxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iitxxmh_old: id_iitxxmh_old,
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
					label: getTranslation('termOfPayment') + ' <sup class="text-danger">*</sup>',
					name: "sodxxth.id_fpytmmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fpytmmh/fpytmmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_fpytmmh_old: id_fpytmmh_old,
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
					label: getTranslation('customer') + ' <sup class="text-danger">*</sup>',
					name: "sodxxth.id_grlxxmh_customer",
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
					label: getTranslation('currency') + ' <sup class="text-danger">*</sup>',
					name: "sodxxth.id_fcrxxmh",
					id: "select_id_fcrxxmh", // tambahkan id di select2-nya untuk load default
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fcrxxmh/fcrxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {

								var query = {
									id_fcrxxmh_old: id_fcrxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								var options = data.results.map(function (result) {
									return {
										id: result.id,
										text: result.text
									};
								});

								defaultCurrency();

								if (params.page && params.page === 1) {
									$('#select_id_fcrxxmh').empty().select2({ data: options });
								} else {
									$('#select_id_fcrxxmh').append(new Option(nama_def, id_def, false, false)).trigger('change');
								}

								return {
									results: options,
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
					label: getTranslation('date') + ' <sup class="text-danger">*</sup>',
					name: "sodxxth.tanggal",
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
					label: getTranslation('subtotal'),
					name: "sodxxth.subtotal",
					type: "readonly"
				},
				{
					label: getTranslation('discount'),
					name: "sodxxth.diskon_jenis",
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
					name: "sodxxth.diskon_persen"
				}, 	
				{
					label: getTranslation('discountValue'),
					name: "sodxxth.diskon_value"
				}, 	
				{
					label: getTranslation('discountFinal'),
					name: "sodxxth.diskon_final",
					type: "readonly"
				},
				{
					label: getTranslation('total'),
					name: "sodxxth.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "sodxxth.dpp_final",
					type: "hidden"
				},
				{
					label: getTranslation('isTaxable'),
					name: "sodxxth.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: getTranslation('includingTax'),
					name: "sodxxth.pajak_in_ex",
					type: "select",
					def: 2,
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 2 }
					]
				},
				{
					label: "pajak_jenis",
					name: "sodxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "sodxxth.pajak_persen",
					type: "hidden"
				},
				{
					label: "Pajak",
					name: "sodxxth.pajak_final",
					type: "readonly"
				},
				{
					label: "Grand Total",
					name: "sodxxth.grand_total",
					type: "readonly"
				},
				{
					label: getTranslation('notes'),
					name: "sodxxth.keterangan",
					type: "textarea"
				},
			]
		} );

		edtsodxxth.field('sodxxth.subtotal').input().addClass('text-right');
		edtsodxxth.field('sodxxth.diskon_persen').input().addClass('text-right');
		edtsodxxth.field('sodxxth.diskon_value').input().addClass('text-right');
		edtsodxxth.field('sodxxth.diskon_final').input().addClass('text-right');
		edtsodxxth.field('sodxxth.dpp').input().addClass('text-right');
		edtsodxxth.field('sodxxth.pajak_final').input().addClass('text-right');
		edtsodxxth.field('sodxxth.grand_total').input().addClass('text-right');
		
		edtsodxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsodxxth.field('sodxxth.start_at').val(start_at);

			if(action == 'create'){
				tblsodxxth.rows().deselect();
				edtsodxxth.field('kategori_dokumen').val('');
				edtsodxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtsodxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();

			$('#select_id_fcrxxmh').select2('open');
			setTimeout(function() {
				$('#select_id_fcrxxmh').select2('close');
			}, 5);
		});

		edtsodxxth.dependent( 'sodxxth.id_iitxxmh', function ( val, data, callback ) {
			id_iitxxmh = edtsodxxth.field('sodxxth.id_iitxxmh').val();
			hitungHeader(edtsodxxth,'sodxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsodxxth.dependent( 'sodxxth.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsodxxth.field('sodxxth.diskon_persen').show();
				edtsodxxth.field('sodxxth.diskon_value').hide();
				
				edtsodxxth.field('sodxxth.diskon_persen').val();
				edtsodxxth.field('sodxxth.diskon_value').val('');
			} else if (val == 2) {
				edtsodxxth.field('sodxxth.diskon_persen').hide();
				edtsodxxth.field('sodxxth.diskon_value').show();
				
				edtsodxxth.field('sodxxth.diskon_persen').val('');
				edtsodxxth.field('sodxxth.diskon_value').val();
			} else {
				edtsodxxth.field('sodxxth.diskon_persen').hide();
				edtsodxxth.field('sodxxth.diskon_value').hide();
				
				edtsodxxth.field('sodxxth.diskon_persen').val(0);
				edtsodxxth.field('sodxxth.diskon_value').val(0);
				edtsodxxth.field('sodxxth.diskon_final').val(0);
			}
			hitungDiskon(edtsodxxth, 'sodxxth');
			hitungDpp(edtsodxxth, 'sodxxth');
			hitungHeader(edtsodxxth,'sodxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsodxxth.dependent( 'sodxxth.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtsodxxth, 'sodxxth');
			hitungDpp(edtsodxxth, 'sodxxth');
			hitungHeader(edtsodxxth,'sodxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtsodxxth.dependent( 'sodxxth.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtsodxxth, 'sodxxth');
			hitungDpp(edtsodxxth, 'sodxxth');
			hitungHeader(edtsodxxth,'sodxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtsodxxth.dependent( 'sodxxth.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master customer. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtsodxxth,'sodxxth', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtsodxxth.dependent( 'sodxxth.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtsodxxth,'sodxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});

		edtsodxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_grlxxmh_customer = edtsodxxth.field('sodxxth.id_grlxxmh_customer').val();
				id_fpytmmh    = edtsodxxth.field('sodxxth.id_fpytmmh').val();
				id_fcrxxmh    = edtsodxxth.field('sodxxth.id_fcrxxmh').val();
				id_iitxxmh    = edtsodxxth.field('sodxxth.id_iitxxmh').val();
				tanggal       = edtsodxxth.field('sodxxth.tanggal').val();
				diskon_jenis  = edtsodxxth.field('sodxxth.diskon_jenis').val();
				diskon_persen = edtsodxxth.field('sodxxth.diskon_persen').val();
				diskon_value  = edtsodxxth.field('sodxxth.diskon_value').val();

				validasiRequired(
					edtsodxxth,
					'sodxxth',
					{
						'id_grlxxmh_customer': id_grlxxmh_customer,
						'id_fpytmmh': id_fpytmmh,
						'id_fcrxxmh': id_fcrxxmh,
						'id_iitxxmh': id_iitxxmh,
						'tanggal'   : tanggal
					}
				);

				if(diskon_jenis == 1){
					validasiNumber(
						edtsodxxth,
						'sodxxth',
						{
							'diskon_persen': diskon_persen
						},
						0,
						'>'
					);
				}else if(diskon_jenis == 2){
					validasiNumber(
						edtsodxxth,
						'sodxxth',
						{
							'diskon_value': diskon_value
						},
						0,
						'>'
					);
				}
			
			}
			
			if ( edtsodxxth.inError() ) {
				return false;
			}
		});

		edtsodxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsodxxth.field('sodxxth.finish_at').val(finish_at);
			
			diskon_final_h = edtsodxxth.field('sodxxth.diskon_final').val();
			dpp_final_h    = edtsodxxth.field('sodxxth.dpp_final').val();
			pajak_final_h  = edtsodxxth.field('sodxxth.pajak_final').val();
			grand_total_h  = edtsodxxth.field('sodxxth.grand_total').val();
			
			sodxxthUpdateFooter();
		});
		
		edtsodxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			edtsodxxth.field('sodxxth.diskon_final').val(diskon_final_h);
			edtsodxxth.field('sodxxth.dpp_final').val(dpp_final_h);
			edtsodxxth.field('sodxxth.pajak_final').val(pajak_final_h);
			edtsodxxth.field('sodxxth.grand_total').val(grand_total_h);
		} );

		edtsodxxth.on( 'close', function () {
			edtsodxxth.enable();
		} );
		
		tblsodxxth = $('#tblsodxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sodxxth/sodxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sodxxth = show_deleted_sodxxth;
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
				{ data: "sodxxth.id",visible:false },
				{ data: "sodxxth.kode" },
				{ data: "sodxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "iitxxmh.nama" },
				{ 
					data: "sodxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "sodxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sodxxth';
					$table       = 'tblsodxxth';
					$edt         = 'edtsodxxth';
					$show_status = '_sodxxth';
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
				if ( data.sodxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sodxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsodxxth.searchPanes.container().appendTo('#spsodxxth');
		tblsodxxth.searchBuilder.container().appendTo( '#sbsodxxth' );
		
		tblsodxxth.on( 'init', function () {
			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			sodxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsodittd];
			CekInitHeaderHD(tblsodxxth, tbl_details);
		} );
		
		tblsodxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('sodxxth');
			id_iitxxmh_old    = sodxxth_data.id_iitxxmh;
			id_iitxxmh        = sodxxth_data.id_iitxxmh;
			id_fcrxxmh_old    = sodxxth_data.id_fcrxxmh;
			id_fpytmmh_old    = sodxxth_data.id_fpytmmh;
			id_grlxxmh_old    = sodxxth_data.id_grlxxmh_customer;

			// terkait footer
			diskon_final_h = sodxxth_data.diskon_final;
			dpp_final_h    = sodxxth_data.dpp_final;
			pajak_final_h  = sodxxth_data.pajak_final;
			grand_total_h  = sodxxth_data.grand_total;
			sodxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsodittd];
			CekSelectHeaderHD(tblsodxxth, tbl_details);

		} );
		
		tblsodxxth.on( 'deselect', function () {
			siVarReset('sodxxth');
			id_grlxxmh_old = 0;
			id_fpytmmh_old = 0;
			id_fcrxxmh_old = 0;
			id_iitxxmh_old = 0;

			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			sodxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsodittd];
			CekDeselectHeaderHD(tblsodxxth, tbl_details);
		} );
		// END sodxxth

		// BEGIN sodittd
		edtsodittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sodxxth/sodittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sodittd = show_deleted_sodittd;
					d.id_sodxxth = id_sodxxth;
				}
			},
			template: "#frmsodittd",
			table: "#tblsodittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "sodittd.start_at",
					name: "sodittd.start_at",
					type: "hidden"
				},	
				{
					label: "sodittd.finish_at",
					name: "sodittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sodittd",
					type: "hidden"
				},	
				{
					label: "sodittd.transaction_state",
					name: "sodittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sodxxth",
					name: "sodittd.id_sodxxth",
					type: "hidden"
				},	
				{
					label: "Item SQ<sup class='text-danger'>*<sup>",
					name: "sodittd.id_sqtittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/sqtxxth/sqtittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_sqtittd_old: id_sqtittd_old,
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
					label: "Request Info",
					name: "sqtittd_info",
					type: "textarea"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sodittd.id_iimxxmh",
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
									ids_iitxxmh: id_iitxxmh,
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
					name: "sodittd.id_iumxxmh_unit",
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
					name: "sodittd.jumlah_unit"
				}, 	
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "sodittd.harga_unit"
				},
				{
					label: "Subtotal",
					name: "sodittd.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "sodittd.diskon_jenis",
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
					name: "sodittd.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "sodittd.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "sodittd.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "sodittd.dpp",
					type: "readonly"
				},
				{
					label: "Tanggal Dibutuhkan",
					name: "sodittd.tanggal_dibutuhkan",
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
					label: "Keterangan",
					name: "sodittd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtsodittd.field('sodittd.jumlah_unit').input().addClass('text-right');
		edtsodittd.field('sodittd.harga_unit').input().addClass('text-right');
		edtsodittd.field('sodittd.subtotal').input().addClass('text-right');
		edtsodittd.field('sodittd.diskon_persen').input().addClass('text-right');
		edtsodittd.field('sodittd.diskon_value').input().addClass('text-right');
		edtsodittd.field('sodittd.diskon_final').input().addClass('text-right');
		edtsodittd.field('sodittd.dpp').input().addClass('text-right');
			
		edtsodittd.on( 'preOpen', function( e, mode, action ) {
			edtsodittd.field('sodittd.id_sodxxth').val(id_sodxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsodittd.field('sodittd.start_at').val(start_at);
			
			edtsodittd.field('sqtittd_info').disable();
			
			if(action == 'create'){
				tblsodittd.rows().deselect();
			}
		});

		edtsodittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtsodittd.dependent( 'sodittd.id_sqtittd', function ( val, data, callback ) {
			// id_sqtittd = edtsodittd.field('sodittd.id_sqtittd').val();
			// autofillField('sqtittd', id_sqtittd, 'jumlah_unit,tanggal_dibutuhkan,keterangan')

			// // BEGIN generate sqtittd_info
			// if (autofillData.tanggal_dibutuhkan == null){
			// 	sqtittd_info_dibutuhkan = '';
			// }else{
			// 	sqtittd_info_dibutuhkan = '; Dibutuhkan: ' + moment(autofillData.tanggal_dibutuhkan).format("DD MMM YYYY");
			// }
			// if (autofillData.keterangan != ''){
			// 	sqtittd_info_notes = '; Notes: ' + autofillData.keterangan;
			// }else{
			// 	sqtittd_info_notes = '';
			// }
			// // END generate sqtittd_info
			// edtsodittd.field('sqtittd_info').val('Permintaan: ' + autofillData.jumlah_unit + sqtittd_info_dibutuhkan + sqtittd_info_notes);

			return {}
		}, {event: 'keyup change'});
		
		edtsodittd.dependent( 'sodittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtsodittd.field('sodittd.id_iimxxmh').val();
			edtsodittd.field('sodittd.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtsodittd.dependent( 'sodittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsodittd, 'sodittd');
			hitungDpp(edtsodittd, 'sodittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsodittd.dependent( 'sodittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsodittd, 'sodittd');
			hitungDpp(edtsodittd, 'sodittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsodittd.dependent( 'sodittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsodittd.field('sodittd.diskon_persen').show();
				edtsodittd.field('sodittd.diskon_value').hide();
				
				edtsodittd.field('sodittd.diskon_persen').val();
				edtsodittd.field('sodittd.diskon_value').val('');
			} else if (val == 2) {
				edtsodittd.field('sodittd.diskon_persen').hide();
				edtsodittd.field('sodittd.diskon_value').show();
				
				edtsodittd.field('sodittd.diskon_persen').val('');
				edtsodittd.field('sodittd.diskon_value').val();
			} else {
				edtsodittd.field('sodittd.diskon_persen').hide();
				edtsodittd.field('sodittd.diskon_value').hide();
				edtsodittd.field('sodittd.diskon_persen').val(0);
				edtsodittd.field('sodittd.diskon_value').val(0);
				edtsodittd.field('sodittd.diskon_final').val(0);
			}

			hitungDiskon(edtsodittd, 'sodittd');
			hitungDpp(edtsodittd, 'sodittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsodittd.dependent( 'sodittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsodittd, 'sodittd');
				hitungDpp(edtsodittd, 'sodittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsodittd.dependent( 'sodittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsodittd, 'sodittd');
				hitungDpp(edtsodittd, 'sodittd');
			}
			return {}
		}, {event: 'keyup'});

		edtsodittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_sodittd;
			}

			if(action != 'remove'){
				
				id_sqtittd      = edtsodittd.field('sodittd.id_sqtittd').val();
				id_iumxxmh_unit = edtsodittd.field('sodittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtsodittd.field('sodittd.id_iimxxmh').val();
				jumlah_unit     = edtsodittd.field('sodittd.jumlah_unit').val();
				harga_unit      = edtsodittd.field('sodittd.harga_unit').val();
				diskon_jenis    = edtsodittd.field('sodittd.diskon_jenis').val();
				diskon_persen    = edtsodittd.field('sodittd.diskon_persen').val();
				diskon_value    = edtsodittd.field('sodittd.diskon_value').val();

				validasiRequired(
					edtsodittd,
					'sodittd',
					{
						'id_sqtittd': id_sqtittd,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_iimxxmh': id_iimxxmh,
					}
				);
				
				validasiNumber(
					edtsodittd,
					'sodittd',
					{
						'jumlah_unit': jumlah_unit,
						'harga_unit': harga_unit
					},
					0,
					'>'
				);

				if(diskon_jenis == 1){
					validasiNumber(
						edtsodittd,
						'sodittd',
						{
							'diskon_persen': diskon_persen
						},
						0,
						'>'
					);
				}else if(diskon_jenis == 2){
					validasiNumber(
						edtsodittd,
						'sodittd',
						{
							'diskon_value': diskon_value
						},
						0,
						'>'
					);
				}

				
				validasiOutstandingNew(edtsodittd, 'sodittd', id_transaksi, id_sqtittd, 'sqtittd');

			}
			
			if ( edtsodittd.inError() ) {
				return false;
			}
		});

		edtsodittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsodittd.field('sodittd.finish_at').val(finish_at);
		});
			
		edtsodittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				tblsodittd.rows().deselect();
			}
			
			hitungSubtotalHeader(id_transaksi_h, 'sodittd', 'sodxxth');
			hitungHeaderDetail('sodxxth', 'sodittd', id_transaksi_h);
			
			tblsodxxth.ajax.reload(null, false);
			tblsodittd.ajax.reload(null, false);
		} );

		edtsodittd.on( 'close', function () {
			edtsodittd.enable();
		} );
		
		tblsodittd = $('#tblsodittd').DataTable( {
			ajax: {
				url: "../../models/sodxxth/sodittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sodittd = show_deleted_sodittd;
					d.id_sodxxth = id_sodxxth;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "sodittd.id",visible:false },
				{ data: "sodittd.id_sodxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "sodittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "sodittd.harga_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "sodittd.subtotal",
					...renderNumber( 0, "")
				},
				{ 
					data: "sodittd.diskon_final",
					...renderNumber( 0, "")
				},
				{ 
					data: "sodittd.dpp",
					...renderNumber( 0, "")
				},
				{ data: "sqtxxth.kode" }

			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sodittd';
					$table       = 'tblsodittd';
					$edt         = 'edtsodittd';
					$show_status = '_sodittd';
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
				var s_subtotal 	= api.column(9).data().sum();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
				$( '#s_subtotal' ).html( dtNumberFormat(s_subtotal) );
			}
		} );

		tblsodittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsodittd, 1 );
			CekDrawDetailHDFinal(tblsodxxth);
		} );

		tblsodittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('sodittd');
			id_iimxxmh          = sodittd_data.id_iimxxmh;
			id_iimxxmh_old      = sodittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = sodittd_data.id_iumxxmh_unit;
			id_sqtittd_old      = sodittd_data.id_sqtittd;

			// atur hak akses
			CekSelectDetailHD( tblsodittd );
		} );

		tblsodittd.on( 'deselect', function() {
			siVarResetD('sodittd');
			id_iimxxmh_old = 0, id_sqtittd_old = 0, id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsodittd );
		} );

		// END sodittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsodxxth.rows().deselect();
				tblsodxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsodxxth').modal('toggle');
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
