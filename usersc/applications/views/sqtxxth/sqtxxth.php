<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sqtxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sqtittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFsqtxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmsqtxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sqtxxth.tanggal"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.id_grlxxmh_customer"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sqtxxth.id_fcrxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.id_fpytmmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sqtxxth.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.diskon_persen"></editor-field>
								<editor-field name="sqtxxth.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="sqtxxth.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sqtxxth.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sqtxxth.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="sqtxxth.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="sqtxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>

				<div class="table-responsive">
                    <table id="tblsqtxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Approval</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabsqtittd"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsqtittd" class="tab-pane active">
					
					<div id="frmsqtittd">
						<div class="panel-body">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.id_iimxxmh"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.id_iumxxmh_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.jumlah_unit"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.harga_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.subtotal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.diskon_jenis"></editor-field>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<editor-field name="sqtittd.diskon_persen"></editor-field>
									<editor-field name="sqtittd.diskon_value"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="sqtittd.diskon_final"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="sqtittd.dpp"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
								</div>
								<div class="col-lg-6">
									<editor-field name="sqtittd.keterangan"></editor-field>
								</div>
							</div>
						</div>
					</div>

					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsqtittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sqtxxth</th>
										<th>Item Code</th>
										<th>Item name</th>
										<th>UoM</th>
										<th>Quantity</th>
										<th>Price @</th>
										<th>Subtotal</th>
										<th>Discount</th>
										<th>Total</th>
										<th>Keterangan</th>
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
										<th></th>
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
										<th></th>
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
										<th></th>
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
										<th></th>
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
										<th></th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sqtxxth/fn/sqtxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtsqtxxth, tblsqtxxth, show_deleted_sqtxxth = 0, id_sqtxxth;
	var edtsqtittd, tblsqtittd, show_deleted_sqtittd = 0, id_sqtittd;
	// ------------- end of default variable
	var id_grlxxmh_old = 0, id_fcrxxmh_old = 0, id_fpytmmh_old = 0;
	var id_iimxxmh = 0, id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;

	var id_iitxxmh = 1;

	// get tableRelation
	tableRelation('sqtxxth');

	// BEGIN datepicker init
	$('#periode').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
	// END datepicker init

	$(document).ready(function() {
		start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
		end_date = moment($('#end_date').val()).format('YYYY-MM-DD');
		
		// BEGIN sqtxxth
		edtsqtxxth = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 3,
				}
			},
			ajax: {
				url: "../../models/sqtxxth/sqtxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtxxth = show_deleted_sqtxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblsqtxxth",
			template: "#frmsqtxxth",
			fields: [ 
				{
					label: "sqtxxth.start_at",
					name: "sqtxxth.start_at",
					type: "hidden"
				},	
				{
					label: "sqtxxth.finish_at",
					name: "sqtxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sqtxxth",
					type: "hidden"
				},	
				{
					label: "sqtxxth.transaction_state",
					name: "sqtxxth.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "sqtxxth.tanggal",
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
					name: "sqtxxth.id_grlxxmh_customer",
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
					label: "Payment Terms <sup class='text-danger'>*<sup>",
					name: "sqtxxth.id_fpytmmh",
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
					label: "Currency <sup class='text-danger'>*<sup>",
					name: "sqtxxth.id_fcrxxmh",
					id: "select_id_fcrxxmh", //tambahkan id di select2nya
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
					label: "Valid Until <sup class='text-danger'>*<sup>",
					name: "sqtxxth.tanggal_validity",
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
					label: "UP <sup class='text-danger'>*<sup>",
					name: "sqtxxth.up1"
				},

				{
					label: "Subtotal",
					name: "sqtxxth.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "sqtxxth.diskon_jenis",
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
					name: "sqtxxth.diskon_persen"
				}, 	
				{
					label: "Diskon (Rp)",
					name: "sqtxxth.diskon_value"
				}, 	
				{
					label: "Diskon Final",
					name: "sqtxxth.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "sqtxxth.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "sqtxxth.dpp_final",
					type: "hidden"
				},
				{
					label: "Menggunakan Pajak",
					name: "sqtxxth.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Termasuk Pajak",
					name: "sqtxxth.pajak_in_ex",
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
					name: "sqtxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "sqtxxth.pajak_persen",
					type: "hidden"
				},
				{
					label: "Pajak",
					name: "sqtxxth.pajak_final",
					type: "readonly"
				},
				{
					label: "Grand Total",
					name: "sqtxxth.grand_total",
					type: "readonly"
				},

				{
					label: "Keterangan",
					name: "sqtxxth.keterangan",
					type: "textarea"
				}
			]
		} );

		edtsqtxxth.field('sqtxxth.subtotal').input().addClass('text-right');
		edtsqtxxth.field('sqtxxth.diskon_persen').input().addClass('text-right');
		edtsqtxxth.field('sqtxxth.diskon_value').input().addClass('text-right');
		edtsqtxxth.field('sqtxxth.diskon_final').input().addClass('text-right');
		edtsqtxxth.field('sqtxxth.dpp').input().addClass('text-right');
		edtsqtxxth.field('sqtxxth.pajak_final').input().addClass('text-right');
		edtsqtxxth.field('sqtxxth.grand_total').input().addClass('text-right');
		
		edtsqtxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtxxth.field('sqtxxth.start_at').val(start_at);

			if(action == 'create'){
				tblsqtxxth.rows().deselect();
			}
		});

		edtsqtxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});
		
		edtsqtxxth.dependent( 'sqtxxth.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsqtxxth.field('sqtxxth.diskon_persen').show();
				edtsqtxxth.field('sqtxxth.diskon_value').hide();
				
				edtsqtxxth.field('sqtxxth.diskon_persen').val();
				edtsqtxxth.field('sqtxxth.diskon_value').val('');
			} else if (val == 2) {
				edtsqtxxth.field('sqtxxth.diskon_persen').hide();
				edtsqtxxth.field('sqtxxth.diskon_value').show();
				
				edtsqtxxth.field('sqtxxth.diskon_persen').val('');
				edtsqtxxth.field('sqtxxth.diskon_value').val();
			} else {
				edtsqtxxth.field('sqtxxth.diskon_persen').hide();
				edtsqtxxth.field('sqtxxth.diskon_value').hide();
				
				edtsqtxxth.field('sqtxxth.diskon_persen').val(0);
				edtsqtxxth.field('sqtxxth.diskon_value').val(0);
				edtsqtxxth.field('sqtxxth.diskon_final').val(0);
			}
			hitungDiskon(edtsqtxxth, 'sqtxxth');
			hitungDpp(edtsqtxxth, 'sqtxxth');
			hitungHeader(edtsqtxxth,'sqtxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsqtxxth.dependent( 'sqtxxth.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtsqtxxth, 'sqtxxth');
			hitungDpp(edtsqtxxth, 'sqtxxth');
			hitungHeader(edtsqtxxth,'sqtxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtsqtxxth.dependent( 'sqtxxth.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtsqtxxth, 'sqtxxth');
			hitungDpp(edtsqtxxth, 'sqtxxth');
			hitungHeader(edtsqtxxth,'sqtxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtsqtxxth.dependent( 'sqtxxth.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master supplier. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtsqtxxth,'sqtxxth', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtsqtxxth.dependent( 'sqtxxth.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtsqtxxth,'sqtxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtsqtxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal             = edtsqtxxth.field('sqtxxth.tanggal').val();
				id_grlxxmh_customer = edtsqtxxth.field('sqtxxth.id_grlxxmh_customer').val();
				tanggal_validity    = edtsqtxxth.field('sqtxxth.tanggal_validity').val();
				up1                 = edtsqtxxth.field('sqtxxth.up1').val();

				validasiRequired(
					edtsqtxxth,
					'sqtxxth',
					{
						'tanggal'            : tanggal,
						'id_grlxxmh_customer': id_grlxxmh_customer,
						'tanggal_validity'   : tanggal_validity,
						'up1'                : up1
					}
				);
				
			}
			
			if ( edtsqtxxth.inError() ) {
				return false;
			}
		});

		edtsqtxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtxxth.field('sqtxxth.finish_at').val(finish_at);

			diskon_final_h = edtsqtxxth.field('sqtxxth.diskon_final').val();
			dpp_final_h    = edtsqtxxth.field('sqtxxth.dpp_final').val();
			pajak_final_h  = edtsqtxxth.field('sqtxxth.pajak_final').val();
			grand_total_h  = edtsqtxxth.field('sqtxxth.grand_total').val();
			
			sqtxxthUpdateFooter();
		});
		
		edtsqtxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblsqtxxth.rows().deselect();
			tblsqtxxth.ajax.reload(null, false);

			edtsqtxxth.field('sqtxxth.diskon_final').val(diskon_final_h);
			edtsqtxxth.field('sqtxxth.dpp_final').val(dpp_final_h);
			edtsqtxxth.field('sqtxxth.pajak_final').val(pajak_final_h);
			edtsqtxxth.field('sqtxxth.grand_total').val(grand_total_h);
		} );

		edtsqtxxth.on( 'close', function () {
			edtsqtxxth.enable();
		} );
		
		tblsqtxxth = $('#tblsqtxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sqtxxth/sqtxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtxxth = show_deleted_sqtxxth;
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
					targets: [0,4,5]
				}
			],
			columns: [
				{ data: "sqtxxth.id",visible:false },
				{ data: "sqtxxth.kode" },
				{ data: "sqtxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ 
					data: "sqtxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "sqtxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sqtxxth';
					$table       = 'tblsqtxxth';
					$edt         = 'edtsqtxxth';
					$show_status = '_sqtxxth';
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
				if ( data.sqtxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sqtxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsqtxxth.searchPanes.container().appendTo('#spsqtxxth');
		tblsqtxxth.searchBuilder.container().appendTo( '#sbsqtxxth' );
		
		tblsqtxxth.on( 'init', function () {
			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			sqtxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsqtittd];
			CekInitHeaderHD(tblsqtxxth, tbl_details);
		} );
		
		tblsqtxxth.on( 'select', function( e, dt, type, indexes ) {
			sqtxxth_data      = tblsqtxxth.row( { selected: true } ).data().sqtxxth;
			id_sqtxxth        = sqtxxth_data.id;
			id_transaksi_h    = id_sqtxxth;                                           // dipakai untuk general
			id_transaksi_log  = id_sqtxxth;                                           // dipakai untuk general
			transaction_state = sqtxxth_data.transaction_state;
			approval_state    = sqtxxth_data.approval_state;
			is_nextprocess    = sqtxxth_data.is_nextprocess;
			
			id_grlxxmh_old = sqtxxth_data.id_grlxxmh_customer;
			id_fpytmmh_old = sqtxxth_data.id_fpytmmh;
			id_fcrxxmh_old = sqtxxth_data.id_fcrxxmh;

			// terkait footer
			diskon_final_h = sqtxxth_data.diskon_final;
			dpp_final_h    = sqtxxth_data.dpp_final;
			pajak_final_h  = sqtxxth_data.pajak_final;
			grand_total_h  = sqtxxth_data.grand_total;
			sqtxxthUpdateFooter();
			
			// atur hak akses
			tbl_details = [tblsqtittd];
			CekSelectHeaderHD(tblsqtxxth, tbl_details);

		} );
		
		tblsqtxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_sqtxxth = 0;
			id_grlxxmh_old = 0, id_fpytmmh_old = 0, id_fcrxxmh_old = 0;

			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			sqtxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblsqtittd];
			CekDeselectHeaderHD(tblsqtxxth, tbl_details);
		} );
		// END sqtxxth

		// BEGIN sqtittd
		edtsqtittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sqtxxth/sqtittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtittd = show_deleted_sqtittd;
					d.id_sqtxxth = id_sqtxxth;
				}
			},
			table: "#tblsqtittd",
			template: "#frmsqtittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "sqtittd.start_at",
					name: "sqtittd.start_at",
					type: "hidden"
				},	
				{
					label: "sqtittd.finish_at",
					name: "sqtittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sqtittd",
					type: "hidden"
				},	
				{
					label: "sqtittd.transaction_state",
					name: "sqtittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sqtxxth",
					name: "sqtittd.id_sqtxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sqtittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
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
					name: "sqtittd.id_iumxxmh_unit",
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
					name: "sqtittd.jumlah_unit"
				}, 
				{
					label: "Price @ <sup class='text-danger'>*<sup>", 
					name: "sqtittd.harga_unit",
				},
				{
					label: "Subtotal",
					name: "sqtittd.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "sqtittd.diskon_jenis",
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
					name: "sqtittd.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "sqtittd.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "sqtittd.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "sqtittd.dpp",
					type: "readonly"
				},
				{
					label: "Keterangan",
					name: "sqtittd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtsqtittd.field('sqtittd.jumlah_unit').input().addClass('text-right');
		edtsqtittd.field('sqtittd.harga_unit').input().addClass('text-right');
		edtsqtittd.field('sqtittd.subtotal').input().addClass('text-right');
		edtsqtittd.field('sqtittd.diskon_persen').input().addClass('text-right');
		edtsqtittd.field('sqtittd.diskon_value').input().addClass('text-right');
		edtsqtittd.field('sqtittd.diskon_final').input().addClass('text-right');
		edtsqtittd.field('sqtittd.dpp').input().addClass('text-right');
			
		edtsqtittd.on( 'preOpen', function( e, mode, action ) {
			edtsqtittd.field('sqtittd.id_sqtxxth').val(id_sqtxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtittd.field('sqtittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblsqtittd.rows().deselect();
			}
		});

		edtsqtittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		edtsqtittd.dependent( 'sqtittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtsqtittd.field('sqtittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});

		edtsqtittd.dependent( 'sqtittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsqtittd, 'sqtittd');
			hitungDpp(edtsqtittd, 'sqtittd');
			return {}
		}, {event: 'keyup change'});

		edtsqtittd.dependent( 'sqtittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtsqtittd, 'sqtittd');
			hitungDpp(edtsqtittd, 'sqtittd');
			return {}
		}, {event: 'keyup change'});

		edtsqtittd.dependent( 'sqtittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtsqtittd.field('sqtittd.diskon_persen').show();
				edtsqtittd.field('sqtittd.diskon_value').hide();
				
				edtsqtittd.field('sqtittd.diskon_persen').val();
				edtsqtittd.field('sqtittd.diskon_value').val('');
			} else if (val == 2) {
				edtsqtittd.field('sqtittd.diskon_persen').hide();
				edtsqtittd.field('sqtittd.diskon_value').show();
				
				edtsqtittd.field('sqtittd.diskon_persen').val('');
				edtsqtittd.field('sqtittd.diskon_value').val();
			} else {
				edtsqtittd.field('sqtittd.diskon_persen').hide();
				edtsqtittd.field('sqtittd.diskon_value').hide();
				edtsqtittd.field('sqtittd.diskon_persen').val(0);
				edtsqtittd.field('sqtittd.diskon_value').val(0);
				edtsqtittd.field('sqtittd.diskon_final').val(0);
			}

			hitungDiskon(edtsqtittd, 'sqtittd');
			hitungDpp(edtsqtittd, 'sqtittd');
			return {}
		}, {event: 'keyup change'});

		edtsqtittd.dependent( 'sqtittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsqtittd, 'sqtittd');
				hitungDpp(edtsqtittd, 'sqtittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtsqtittd.dependent( 'sqtittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtsqtittd, 'sqtittd');
				hitungDpp(edtsqtittd, 'sqtittd');
			}
			return {}
		}, {event: 'keyup'});

		edtsqtittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_iimxxmh = edtsqtittd.field('sqtittd.id_iimxxmh').val();
				id_iumxxmh_unit = edtsqtittd.field('sqtittd.id_iumxxmh_unit').val();
				jumlah_unit     = edtsqtittd.field('sqtittd.jumlah_unit').val();
				harga_unit      = edtsqtittd.field('sqtittd.harga_unit').val();

				validasiRequired(
					edtsqtittd,
					'sqtittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit': jumlah_unit,
						'harga_unit': harga_unit
					}
				);

				validasiNumber(
					edtsqtittd,
					'sqtittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

				validasiNumber(
					edtsqtittd,
					'sqtittd',
					{
						'harga_unit': harga_unit,
					},
					0,
					'>'
				);
				
			}
			
			if ( edtsqtittd.inError() ) {
				return false;
			}
		});

		edtsqtittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtittd.field('sqtittd.finish_at').val(finish_at);
		});
			
		edtsqtittd.on( 'postSubmit', function (e, json, data, action, xhr) {

			hitungSubtotalHeader(id_transaksi_h, 'sqtittd', 'sqtxxth');
			hitungHeaderDetail('sqtxxth', 'sqtittd', id_transaksi_h);
			
			tblsqtxxth.ajax.reload(null, false);
			tblsqtittd.ajax.reload(null, false);

			// tblsqtittd.rows().deselect();
			// tblsqtittd.ajax.reload(null, false);
		} );

		edtsqtittd.on( 'close', function () {
			edtsqtittd.enable();
		} );
			
		tblsqtittd = $('#tblsqtittd').DataTable( {
			ajax: {
				url: "../../models/sqtxxth/sqtittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtittd = show_deleted_sqtittd;
					d.id_sqtxxth = id_sqtxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "sqtittd.id",visible:false },
				{ data: "sqtittd.id_sqtxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "sqtittd.jumlah_unit",
					...renderNumber(0)
				},
				{ 
					data: "sqtittd.harga_unit",
					...renderNumber(2)
				},
				{ 
					data: "sqtittd.subtotal",
					...renderNumber(2)
				},
				{ 
					data: "sqtittd.diskon_final",
					...renderNumber(2)
				},
				{ 
					data: "sqtittd.dpp",
					...renderNumber(2)
				},
				{ data: "sqtittd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sqtittd';
					$table       = 'tblsqtittd';
					$edt         = 'edtsqtittd';
					$show_status = '_sqtittd';
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
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();
				var s_subtotal 	= api.column(9).data().sum();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
				$( '#s_subtotal' ).html( dtNumberFormat(s_subtotal) );
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblsqtittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblsqtxxth, tblsqtittd, 'sqtittd' );
			CekDrawDetailHDFinal(tblsqtxxth);
		} );

		tblsqtittd.on( 'select', function( e, dt, type, indexes ) {
			data_sqtittd 		= tblsqtittd.row( { selected: true } ).data().sqtittd;
			id_sqtittd   		= data_sqtittd.id;
			id_transaksi_d 		= id_sqtittd; // dipakai untuk general
			id_transaksi_log_d 	= id_sqtittd; // dipakai untuk log

			transaction_state_d   = data_sqtittd.transaction_state;

			id_iumxxmh_unit_old = data_sqtittd.id_iumxxmh_unit;
			id_iimxxmh          = data_sqtittd.id_iimxxmh;
			id_iimxxmh_old = data_sqtittd.id_iimxxmh;
			
			
			// atur hak akses
			CekSelectDetailHD(tblsqtxxth, tblsqtittd );
		} );

		tblsqtittd.on( 'deselect', function() {
			id_sqtittd = 0;
			id_iumxxmh_unit_old = 0, id_iimxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblsqtxxth, tblsqtittd );
		} );

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
				end_date = moment($('#end_date').val()).format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsqtxxth.rows().deselect();
				tblsqtxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsqtxxth').modal('toggle');
			}, false);
				return false;
			}
		});

		// END sqtittd
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
