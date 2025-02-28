<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sivxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sivittd';
    $nama_tabels_d[1] = 'sivaktd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFsivxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmsivxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sivxxth.tanggal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sivxxth.id_grlxxmh_customer"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.id_sdlxxth"></editor-field>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sivxxth.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.diskon_persen"></editor-field>
								<editor-field name="sivxxth.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="sivxxth.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sivxxth.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sivxxth.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sivxxth.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sivxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<table id="tblsivxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nomor</th>
							<th>Tanggal</th>
							<th>Customer</th>
							<th>Kode SIV</th>
							<th>Kode DN</th>
							<th>Status</th>
							<th>Approval</th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabsivittd_1"> Item</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabsivaktd"> Biaya</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsivittd_1" class="tab-pane active">
					<div class="panel-body">
						<!-- start Custom Form Datatables Editor -->
						<div id="frmsivittd">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sivittd.id_sdlittd"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sdlittd_info"></editor-field>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sivittd.id_iimxxmh"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sivittd.jumlah_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sivittd.id_iumxxmh_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sivittd.harga_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sivittd.subtotal"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sivittd.diskon_jenis"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sivittd.diskon_persen"></editor-field>
										<editor-field name="sivittd.diskon_value"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sivittd.diskon_final"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="sivittd.dpp"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="sivittd.tanggal_dibutuhkan"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="sivittd.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<!-- end Custom Form Datatables Editor -->
						
							<table id="tblsivittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sivxxth</th>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>UoM</th>
										<th>Quantity</th>
										<th>Price @</th>
										<th>Subtotal</th>
										<th>Discount</th>
										<th>Total</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th id="c_item"></th>
										<th>Subtotal</th>
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
										<th>Diskon</th>
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
										<th>DPP</th>
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
										<th>Pajak</th>
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
										<th>Total</th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="grand_total_h"></th>
									</tr>
								</tfoot>
							</table>
						

					</div>
				</div>
				<div role="tabpanel" id="tabsivaktd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsivaktd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sivxxth</th>
										<th data-i18n="accountCode"></th>
										<th data-i18n="accountName"></th>
										<th data-i18n="nominal"></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sivxxth/fn/sivxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtsivxxth, tblsivxxth, show_deleted_sivxxth = 0, id_sivxxth;
	var edtsivittd, tblsivittd, show_deleted_sivittd = 0, id_sivittd;
	var edtsivaktd, tblsivaktd, show_deleted_sivaktd = 0, id_sivaktd;
	// ------------- end of default variable

	var id_sdlxxth_old = 0, id_grlxxmh_old = 0, id_fcrxxmh_old = 0, id_fpytmmh_old = 0, is_pajak, id_sdlxxth;
	var id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, id_sdlittd_old = 0, id_iumxxmh_unit  = 0;
	var jumlah_buy = 0, id_aakxxmh_old = 0;
	var id_iitxxmh = 0, id_iitxxmh_old = 0;
	var id_grlxxmh_customer = 0;

	// get tableRelation
	tableRelation('sivxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN sivxxth
		edtsivxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sivxxth/sivxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sivxxth = show_deleted_sivxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmsivxxth",
			table: "#tblsivxxth",
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
					label: "sivxxth.start_at",
					name: "sivxxth.start_at",
					type: "hidden"
				},	
				{
					label: "sivxxth.finish_at",
					name: "sivxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sivxxth",
					type: "hidden"
				},	
				{
					label: "sivxxth.transaction_state",
					name: "sivxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode PO",
					name: "sivxxth.id_sodxxth",
					type: "hidden",
				},
				{
					label: "sivxxth.id_iitxxmh",
					name: "sivxxth.id_iitxxmh",
					type: "hidden",
				},
				{
					label: "Kode DN <sup class='text-danger'>*<sup>",
					name: "sivxxth.id_sdlxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/sivxxth/sivxxth_sdlxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_sdlxxth_old: id_sdlxxth_old,
									id_grlxxmh_customer: id_grlxxmh_customer,
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
					label: "Customer <sup class='text-danger'>*<sup>",
					name: "sivxxth.id_grlxxmh_customer",
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "sivxxth.tanggal",
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
					label: "Subtotal",
					name: "sivxxth.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "sivxxth.diskon_jenis",
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
					name: "sivxxth.diskon_persen"
				}, 	
				{
					label: "Diskon (Rp)",
					name: "sivxxth.diskon_value"
				}, 	
				{
					label: "Diskon Final",
					name: "sivxxth.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "sivxxth.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "sivxxth.dpp_final",
					type: "hidden"
				},
				{
					label: "id_fpytmmh",
					name: "sivxxth.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "Menggunakan Pajak",
					name: "sivxxth.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Termasuk Pajak",
					name: "sivxxth.pajak_in_ex",
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
					name: "sivxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "sivxxth.pajak_persen",
					type: "hidden"
				},
				{
					label: "selisih_bayar",
					name: "sivxxth.selisih_bayar",
					type: "hidden"
				},
				{
					label: "Pajak",
					name: "sivxxth.pajak_final",
					type: "readonly"
				},
				{
					label: "Grand Total",
					name: "sivxxth.grand_total",
					type: "readonly"
				},
				
				{
					label: "Keterangan",
					name: "sivxxth.keterangan",
					type: "textarea"
				},
			]
		} );

		unmaskedHeader = maskingNumber(
			edtsivxxth, 
			"sivxxth", 
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

		edtsivxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsivxxth.field('sivxxth.start_at').val(start_at);

			if(action == 'create'){
				tblsivxxth.rows().deselect();
				kategori_dokumen = 'is_down_payment';
				kategori_dokumen_value = '0';
				
				edtsivxxth.field('sivxxth.id_sdlxxth').enable();
				edtsivxxth.field('sivxxth.id_grlxxmh_customer').enable();
			} else if (action == 'edit') {
				edtsivxxth.field('sivxxth.id_sdlxxth').disable();
				edtsivxxth.field('sivxxth.id_grlxxmh_customer').disable();
				
			}
		});

		edtsivxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtsivxxth.dependent( 'sivxxth.id_grlxxmh_customer', function ( val, data, callback ) {
			id_grlxxmh_customer = val;
			if (id_grlxxmh_old != val) {
				edtsivxxth.field('sivxxth.id_sdlxxth').input().val(null).trigger('change');
			}
			return {}
		}, {event: 'keyup change'});

		edtsivxxth.dependent( 'sivxxth.id_sdlxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('sdlxxth', val, 'id_sodxxth, id_fpytmmh');
				id_sodxxth = autofillData.id_sodxxth;
				edtsivxxth.field('sivxxth.id_sodxxth').val(id_sodxxth);

				id_fpytmmh = autofillData.id_fpytmmh;
				edtsivxxth.field('sivxxth.id_fpytmmh').val(id_fpytmmh);
			}
			return {}
		}, {event: 'keyup change'});

		edtsivxxth.dependent( 'sivxxth.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsivxxth.field('sivxxth.diskon_persen').show();
				edtsivxxth.field('sivxxth.diskon_value').hide();
				
				edtsivxxth.field('sivxxth.diskon_persen').val();
				edtsivxxth.field('sivxxth.diskon_value').val('');
			} else if (val == 2) {
				edtsivxxth.field('sivxxth.diskon_persen').hide();
				edtsivxxth.field('sivxxth.diskon_value').show();
				
				edtsivxxth.field('sivxxth.diskon_persen').val('');
				edtsivxxth.field('sivxxth.diskon_value').val();
			} else {
				edtsivxxth.field('sivxxth.diskon_persen').hide();
				edtsivxxth.field('sivxxth.diskon_value').hide();
				
				edtsivxxth.field('sivxxth.diskon_persen').val(0);
				edtsivxxth.field('sivxxth.diskon_value').val(0);
				edtsivxxth.field('sivxxth.diskon_final').val(0);
			}
			hitungDiskon(edtsivxxth, 'sivxxth');
			hitungDpp(edtsivxxth, 'sivxxth');
			hitungHeader(edtsivxxth,'sivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsivxxth.dependent( 'sivxxth.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtsivxxth, 'sivxxth');
			hitungDpp(edtsivxxth, 'sivxxth');
			hitungHeader(edtsivxxth,'sivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtsivxxth.dependent( 'sivxxth.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtsivxxth, 'sivxxth');
			hitungDpp(edtsivxxth, 'sivxxth');
			hitungHeader(edtsivxxth,'sivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtsivxxth.dependent( 'sivxxth.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master Customer. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtsivxxth,'sivxxth', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtsivxxth.dependent( 'sivxxth.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtsivxxth,'sivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});

		edtsivxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_grlxxmh_customer = edtsivxxth.field('sivxxth.id_grlxxmh_customer').val();
				id_sdlxxth    = edtsivxxth.field('sivxxth.id_sdlxxth').val();
				tanggal       = edtsivxxth.field('sivxxth.tanggal').val();

				validasiRequired(
					edtsivxxth,
					'sivxxth',
					{
						'id_grlxxmh_customer': id_grlxxmh_customer,
						'id_sdlxxth': id_sdlxxth,
						'tanggal'   : tanggal
					}
				);

				validasiUnique(
					action,
					edtsivxxth, 
					"sivxxth", 
					"id_sdlxxth", 
					'id_sdlxxth',
					id_sdlxxth,
					id_sivxxth
				);
			}
			
			if ( edtsivxxth.inError() ) {
				return false;
			}
		});

		edtsivxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsivxxth.field('sivxxth.finish_at').val(finish_at);
		
		});
		
		edtsivxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblsivxxth.ajax.reload(null, false);
			tblsivittd.ajax.reload(null, false);
		} );

		edtsivxxth.on( 'close', function () {
			edtsivxxth.enable();
		} );
		
		tblsivxxth = $('#tblsivxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sivxxth/sivxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sivxxth = show_deleted_sivxxth;
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
				{ data: "sivxxth.id",visible:false },
				{ data: "sivxxth.kode" },
				{ data: "sivxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "sivxxth.kode" },
				{ data: "sdlxxth.kode" },
				{ 
					data: "sivxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "sivxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sivxxth';
					$table       = 'tblsivxxth';
					$edt         = 'edtsivxxth';
					$show_status = '_sivxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Sales Invoice&id_transaksi='+id_sivxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.sivxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sivxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsivxxth.searchPanes.container().appendTo('#spsivxxth');
		tblsivxxth.searchBuilder.container().appendTo( '#sbsivxxth' );
		
		tblsivxxth.on( 'init', function () {
			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			sivxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsivittd, tblsivaktd];
			CekInitHeaderHD(tblsivxxth, tbl_details);
		} );
		
		tblsivxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('sivxxth');
			id_sdlxxth_old    = sivxxth_data.id_sdlxxth;
			id_sdlxxth        = sivxxth_data.id_sdlxxth;
			id_fcrxxmh_old    = sivxxth_data.id_fcrxxmh;
			id_fpytmmh_old    = sivxxth_data.id_fpytmmh;
			id_grlxxmh_old    = sivxxth_data.id_grlxxmh_customer;

			// terkait footer
			diskon_final_h = sivxxth_data.diskon_final;
			dpp_final_h    = sivxxth_data.dpp_final;
			pajak_final_h  = sivxxth_data.pajak_final;
			grand_total_h  = sivxxth_data.grand_total;
			id_iitxxmh_old    = sivxxth_data.id_iitxxmh;
			id_iitxxmh        = sivxxth_data.id_iitxxmh;
			sivxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsivittd, tblsivaktd];
			CekSelectHeaderHD(tblsivxxth, tbl_details);

		} );
		
		tblsivxxth.on( 'deselect', function () {
			siVarReset('sivxxth');
			id_grlxxmh_old = 0;
			id_fpytmmh_old = 0;
			id_fcrxxmh_old = 0;
			id_sdlxxth_old = 0;

			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			id_iitxxmh_old = 0;
			id_iitxxmh = 0;
			sivxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsivittd, tblsivaktd];
			CekDeselectHeaderHD(tblsivxxth, tbl_details);
		} );
		// END sivxxth

		// BEGIN sivittd
		edtsivittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sivxxth/sivittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sivittd = show_deleted_sivittd;
					d.id_sivxxth = id_sivxxth;
				}
			},
			template: "#frmsivittd",
			table: "#tblsivittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "sivittd.start_at",
					name: "sivittd.start_at",
					type: "hidden"
				},	
				{
					label: "sivittd.finish_at",
					name: "sivittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sivittd",
					type: "hidden"
				},	
				{
					label: "sivittd.transaction_state",
					name: "sivittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sivxxth",
					name: "sivittd.id_sivxxth",
					type: "hidden"
				},	
				{
					label: "Item DN<sup class='text-danger'>*<sup>",
					name: "sivittd.id_sdlittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/sdlxxth/sdlittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_sdlittd_old: id_sdlittd_old,
									ids_sdlxxth: id_sdlxxth,
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
					name: "sdlittd_info",
					type: "textarea"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sivittd.id_iimxxmh",
					type: "hidden",
				}, 	
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "sivittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd_buy.php",
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
					name: "sivittd.jumlah_unit"
				}, 	
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "sivittd.harga_unit"
				},
				{
					label: "Subtotal",
					name: "sivittd.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "sivittd.diskon_jenis",
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
					name: "sivittd.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "sivittd.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "sivittd.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "sivittd.dpp",
					type: "readonly"
				},
				{
					label: "Tanggal Dibutuhkan",
					name: "sivittd.tanggal_dibutuhkan",
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
					name: "sivittd.keterangan",
					type: "textarea"
				}
			]
		} );

		//masking
		unmask_sivittd = maskingNumber(
			edtsivittd, 
			"sivittd", 
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
			
		edtsivittd.on( 'preOpen', function( e, mode, action ) {
			edtsivittd.field('sivittd.id_sivxxth').val(id_sivxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsivittd.field('sivittd.start_at').val(start_at);
			
			edtsivittd.field('sdlittd_info').disable();
			
			if(action == 'create'){
				tblsivittd.rows().deselect();
				edtsivittd.field('sivittd.jumlah_unit').enable();
				edtsivittd.field('sivittd.id_iumxxmh_unit').enable();
				edtsivittd.field('sivittd.id_sdlittd').enable();
			} else if(action == 'edit'){
				edtsivittd.field('sivittd.jumlah_unit').disable();
				edtsivittd.field('sivittd.id_iumxxmh_unit').disable();
				edtsivittd.field('sivittd.id_sdlittd').disable();
			}
		});

		edtsivittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtsivittd.dependent( 'sivittd.id_sdlittd', function ( val, data, callback ) {
			id_sdlittd = edtsivittd.field('sivittd.id_sdlittd').val();
			autofillField('sdlittd', id_sdlittd, 'id_iimxxmh, jumlah_unit,keterangan')
			
			// BEGIN generate sdlittd_info
			sdlittd_info_dibutuhkan = '';
			if (autofillData.keterangan != ''){
				sdlittd_info_notes = '; Notes: ' + autofillData.keterangan;
			}else{
				sdlittd_info_notes = '';
			}
			// END generate sdlittd_info
			edtsivittd.field('sdlittd_info').val('Permintaan: ' + autofillData.jumlah_unit + sdlittd_info_dibutuhkan + sdlittd_info_notes);

			edtsivittd.field('sivittd.id_iimxxmh').val(autofillData.id_iimxxmh);

			return {}
		}, {event: 'keyup change'});
		
		edtsivittd.dependent( 'sivittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtsivittd.field('sivittd.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtsivittd.dependent( 'sivittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsivittd, 'sivittd');
			hitungDpp(edtsivittd, 'sivittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsivittd.dependent( 'sivittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsivittd, 'sivittd');
			hitungDpp(edtsivittd, 'sivittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsivittd.dependent( 'sivittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsivittd.field('sivittd.diskon_persen').show();
				edtsivittd.field('sivittd.diskon_value').hide();
				
				edtsivittd.field('sivittd.diskon_persen').val();
				edtsivittd.field('sivittd.diskon_value').val('');
			} else if (val == 2) {
				edtsivittd.field('sivittd.diskon_persen').hide();
				edtsivittd.field('sivittd.diskon_value').show();
				
				edtsivittd.field('sivittd.diskon_persen').val('');
				edtsivittd.field('sivittd.diskon_value').val();
			} else {
				edtsivittd.field('sivittd.diskon_persen').hide();
				edtsivittd.field('sivittd.diskon_value').hide();
				edtsivittd.field('sivittd.diskon_persen').val(0);
				edtsivittd.field('sivittd.diskon_value').val(0);
				edtsivittd.field('sivittd.diskon_final').val(0);
			}

			hitungDiskon(edtsivittd, 'sivittd');
			hitungDpp(edtsivittd, 'sivittd');
			return {}
		}, {event: 'keyup change'});
		
		edtsivittd.dependent( 'sivittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsivittd, 'sivittd');
				hitungDpp(edtsivittd, 'sivittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsivittd.dependent( 'sivittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsivittd, 'sivittd');
				hitungDpp(edtsivittd, 'sivittd');
			}
			return {}
		}, {event: 'keyup'});

		edtsivittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_sivittd;
				console.log(id_sivittd);
			}

			if(action != 'remove'){
				
				id_sdlittd      = edtsivittd.field('sivittd.id_sdlittd').val();
				id_iumxxmh_unit = edtsivittd.field('sivittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtsivittd.field('sivittd.id_iimxxmh').val();
				jumlah_unit     = edtsivittd.field('sivittd.jumlah_unit').val();
				harga_unit      = edtsivittd.field('sivittd.harga_unit').val();
				diskon_jenis    = edtsivittd.field('sivittd.diskon_jenis').val();
				diskon_persen    = edtsivittd.field('sivittd.diskon_persen').val();
				diskon_value    = edtsivittd.field('sivittd.diskon_value').val();

				validasiRequired(
					edtsivittd,
					'sivittd',
					{
						'id_sdlittd': id_sdlittd,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						// 'id_iimxxmh': id_iimxxmh,
					}
				);
				
				// validasiOutstandingMask(edtsivittd, 'sivittd', id_transaksi, id_sdlittd, 'sdlittd');

			}
			
			if ( edtsivittd.inError() ) {
				return false;
			}
		});

		edtsivittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsivittd.field('sivittd.finish_at').val(finish_at);
		});
			
		edtsivittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				tblsivittd.rows().deselect();
			}
			
			hitungSubtotalHeader(id_transaksi_h, 'sivittd', 'sivxxth');
			hitungHeaderDetail('sivxxth', 'sivittd', id_transaksi_h);
			
			tblsivxxth.ajax.reload(null, false);
			tblsivxxth.rows().deselect();
			tblsivittd.ajax.reload(null, false);
		} );

		edtsivittd.on( 'close', function () {
			edtsivittd.enable();
		} );
		
		tblsivittd = $('#tblsivittd').DataTable( {
			ajax: {
				url: "../../models/sivxxth/sivittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sivittd = show_deleted_sivittd;
					d.id_sivxxth = id_sivxxth;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "sivittd.id",visible:false },
				{ data: "sivittd.id_sivxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "sivittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "sivittd.harga_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "sivittd.subtotal",
					...renderNumber( 0, "")
				},
				{ 
					data: "sivittd.diskon_final",
					...renderNumber( 0, "")
				},
				{ 
					data: "sivittd.dpp",
					...renderNumber( 0, "")
				},

			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sivittd';
					$table       = 'tblsivittd';
					$edt         = 'edtsivittd';
					$show_status = '_sivittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['edit', 'remove','view', 'log','noactionD'];
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

		tblsivittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsivittd, 1 );
			CekDrawDetailHDFinal(tblsivxxth);
		} );

		tblsivittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('sivittd');
			id_iimxxmh          = sivittd_data.id_iimxxmh;
			id_iimxxmh_old      = sivittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = sivittd_data.id_iumxxmh_unit;
			id_sdlittd_old      = sivittd_data.id_sdlittd;

			// atur hak akses
			CekSelectDetailHD( tblsivittd );
		} );

		tblsivittd.on( 'deselect', function() {
			siVarResetD('sivittd');
			id_iimxxmh_old = 0, id_sdlittd_old = 0, id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsivittd );
		} );

		// END sivittd
		
		// BEGIN sivaktd
		edtsivaktd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sivxxth/sivaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sivaktd = show_deleted_sivaktd;
					d.id_sivxxth = id_sivxxth;
				}
			},
			table: "#tblsivaktd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "sivaktd.start_at",
					name: "sivaktd.start_at",
					type: "hidden"
				},	
				{
					label: "sivaktd.finish_at",
					name: "sivaktd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sivaktd",
					type: "hidden"
				},	
				{
					label: "sivaktd.transaction_state",
					name: "sivaktd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sivxxth",
					name: "sivaktd.id_sivxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('account') + " <sup class='text-danger'>*<sup>",
					name: "sivaktd.id_aakxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_old,
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
					label: getTranslation('nominal') + " <sup class='text-danger'>*<sup>",
					name: "sivaktd.nominal"
				}, 	
			]
		} );
			
		//masking
		unmask_sivaktd = maskingNumber(
			edtsivaktd, 
			"sivaktd", 
			[
				"nominal", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);
		
		edtsivaktd.on( 'preOpen', function( e, mode, action ) {
			edtsivaktd.field('sivaktd.id_sivxxth').val(id_sivxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsivaktd.field('sivaktd.start_at').val(start_at);
			
			if(action == 'create'){
				tblsivaktd.rows().deselect();
			}
		});

		edtsivaktd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtsivaktd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh = edtsivaktd.field('sivaktd.id_aakxxmh').val();

				validasiRequired(
					edtsivaktd,
					'sivaktd',
					{
						'id_aakxxmh': id_aakxxmh,
					}
				);	

				validasiUnique(
					action,
					edtsivaktd,
					'sivaktd',
					'id_aakxxmh',
					'id_aakxxmh, id_sivxxth',
					id_aakxxmh +','+ id_sivxxth,
					id_sivaktd
				);
			}
			
			if ( edtsivaktd.inError() ) {
				return false;
			}
		});

		edtsivaktd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsivaktd.field('sivaktd.finish_at').val(finish_at);
		});
			
		edtsivaktd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblsivxxth.ajax.reload(null, false);
		} );

		edtsivaktd.on( 'close', function () {
			edtsivaktd.enable();
		} );
		
		tblsivaktd = $('#tblsivaktd').DataTable( {
			ajax: {
				url: "../../models/sivxxth/sivaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sivaktd = show_deleted_sivaktd;
					d.id_sivxxth = id_sivxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "sivaktd.id",visible:false },
				{ data: "sivaktd.id_sivxxth",visible:false },
				{ data: "aakxxmh.kode" },
				{ data: "aakxxmh.nama" },
				{ 
					data: "sivaktd.nominal",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sivaktd';
					$table       = 'tblsivaktd';
					$edt         = 'edtsivaktd';
					$show_status = '_sivaktd';
					$table_name  = $nama_tabels_d[1];

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

		tblsivaktd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblsivaktd, 0 );
			CekDrawDetailHDFinal(tblsivxxth);
		} );

		tblsivaktd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('sivaktd');
			id_aakxxmh_old = sivaktd_data.id_aakxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblsivaktd );
		} );

		tblsivaktd.on( 'deselect', function() {
			// reset variable standar framework
			siVarReset('sivaktd');
			id_aakxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsivaktd );
		} );
		// END sivaktd

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
				tblsivxxth.rows().deselect();
				tblsivxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsivxxth').modal('toggle');
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
