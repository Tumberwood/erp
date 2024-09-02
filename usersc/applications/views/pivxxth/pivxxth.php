<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'pivxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'pivittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFpivxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmpivxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="pivxxth.tanggal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="pivxxth.id_grlxxmh_supplier"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.id_prcxxth"></editor-field>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="pivxxth.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.diskon_persen"></editor-field>
								<editor-field name="pivxxth.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="pivxxth.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="pivxxth.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="pivxxth.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="pivxxth.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="pivxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<table id="tblpivxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nomor</th>
							<th>Tanggal</th>
							<th>Supplier</th>
							<th>Kode PO</th>
							<th>Kode GR</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabpivittd_1"> Item</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabpivittd_2"> Biaya</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabpivittd_1" class="tab-pane active">
					<div class="panel-body">
						<!-- start Custom Form Datatables Editor -->
						<div id="frmpivittd">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="pivittd.id_prcittd"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="prcittd_info"></editor-field>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="pivittd.id_iimxxmh"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="pivittd.jumlah_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="pivittd.id_iumxxmh_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="pivittd.harga_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="pivittd.subtotal"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="pivittd.diskon_jenis"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="pivittd.diskon_persen"></editor-field>
										<editor-field name="pivittd.diskon_value"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="pivittd.diskon_final"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="pivittd.dpp"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="pivittd.tanggal_dibutuhkan"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="pivittd.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<!-- end Custom Form Datatables Editor -->
						
							<table id="tblpivittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_pivxxth</th>
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
				<div role="tabpanel" id="tabpivittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpivittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_pivxxth</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pivxxth/fn/pivxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpivxxth, tblpivxxth, show_deleted_pivxxth = 0, id_pivxxth;
	var edtpivittd, tblpivittd, show_deleted_pivittd = 0, id_pivittd;
	// ------------- end of default variable

	var id_prcxxth_old = 0, id_grlxxmh_old = 0, id_fcrxxmh_old = 0, id_fpytmmh_old = 0, is_pajak, id_prcxxth;
	var id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, id_prcittd_old = 0, id_iumxxmh_unit  = 0;
	var jumlah_buy = 0;
	var id_iitxxmh = 0, id_iitxxmh_old = 0;
	var id_grlxxmh_supplier = 0;

	// get tableRelation
	tableRelation('pivxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN pivxxth
		edtpivxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pivxxth/pivxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pivxxth = show_deleted_pivxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmpivxxth",
			table: "#tblpivxxth",
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
					label: "pivxxth.start_at",
					name: "pivxxth.start_at",
					type: "hidden"
				},	
				{
					label: "pivxxth.finish_at",
					name: "pivxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pivxxth",
					type: "hidden"
				},	
				{
					label: "pivxxth.transaction_state",
					name: "pivxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode PO",
					name: "pivxxth.id_podxxth",
					type: "hidden",
				},
				{
					label: "pivxxth.id_iitxxmh",
					name: "pivxxth.id_iitxxmh",
					type: "hidden",
				},
				{
					label: "Kode GR <sup class='text-danger'>*<sup>",
					name: "pivxxth.id_prcxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/pivxxth/pivxxth_prcxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_prcxxth_old: id_prcxxth_old,
									id_grlxxmh_supplier: id_grlxxmh_supplier,
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
					label: "Supplier <sup class='text-danger'>*<sup>",
					name: "pivxxth.id_grlxxmh_supplier",
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "pivxxth.tanggal",
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
					name: "pivxxth.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "pivxxth.diskon_jenis",
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
					name: "pivxxth.diskon_persen"
				}, 	
				{
					label: "Diskon (Rp)",
					name: "pivxxth.diskon_value"
				}, 	
				{
					label: "Diskon Final",
					name: "pivxxth.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "pivxxth.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "pivxxth.dpp_final",
					type: "hidden"
				},
				{
					label: "Menggunakan Pajak",
					name: "pivxxth.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Termasuk Pajak",
					name: "pivxxth.pajak_in_ex",
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
					name: "pivxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "pivxxth.pajak_persen",
					type: "hidden"
				},
				{
					label: "Pajak",
					name: "pivxxth.pajak_final",
					type: "readonly"
				},
				{
					label: "Grand Total",
					name: "pivxxth.grand_total",
					type: "readonly"
				},
				
				{
					label: "Keterangan",
					name: "pivxxth.keterangan",
					type: "textarea"
				},
			]
		} );

		edtpivxxth.field('pivxxth.subtotal').input().addClass('text-right');
		edtpivxxth.field('pivxxth.diskon_persen').input().addClass('text-right');
		edtpivxxth.field('pivxxth.diskon_value').input().addClass('text-right');
		edtpivxxth.field('pivxxth.diskon_final').input().addClass('text-right');
		edtpivxxth.field('pivxxth.dpp').input().addClass('text-right');
		edtpivxxth.field('pivxxth.pajak_final').input().addClass('text-right');
		edtpivxxth.field('pivxxth.grand_total').input().addClass('text-right');

		edtpivxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpivxxth.field('pivxxth.start_at').val(start_at);

			if(action == 'create'){
				tblpivxxth.rows().deselect();
				edtpivxxth.field('kategori_dokumen').val('');
				edtpivxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtpivxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtpivxxth.dependent( 'pivxxth.id_grlxxmh_supplier', function ( val, data, callback ) {
			// if (id_grlxxmh_old == 0 || val != id_grlxxmh_old) {
				// edtpivxxth.field('pivxxth.id_prcxxth').input().val(null).trigger('change');
				id_grlxxmh_supplier = val;
			// }
			return {}
		}, {event: 'keyup change'});

		edtpivxxth.dependent( 'pivxxth.id_prcxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('prcxxth', val, 'id_podxxth');
				id_podxxth = autofillData.id_podxxth;
				edtpivxxth.field('pivxxth.id_podxxth').val(id_podxxth);
			}
			return {}
		}, {event: 'keyup change'});

		edtpivxxth.dependent( 'pivxxth.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtpivxxth.field('pivxxth.diskon_persen').show();
				edtpivxxth.field('pivxxth.diskon_value').hide();
				
				edtpivxxth.field('pivxxth.diskon_persen').val();
				edtpivxxth.field('pivxxth.diskon_value').val('');
			} else if (val == 2) {
				edtpivxxth.field('pivxxth.diskon_persen').hide();
				edtpivxxth.field('pivxxth.diskon_value').show();
				
				edtpivxxth.field('pivxxth.diskon_persen').val('');
				edtpivxxth.field('pivxxth.diskon_value').val();
			} else {
				edtpivxxth.field('pivxxth.diskon_persen').hide();
				edtpivxxth.field('pivxxth.diskon_value').hide();
				
				edtpivxxth.field('pivxxth.diskon_persen').val(0);
				edtpivxxth.field('pivxxth.diskon_value').val(0);
				edtpivxxth.field('pivxxth.diskon_final').val(0);
			}
			hitungDiskon(edtpivxxth, 'pivxxth');
			hitungDpp(edtpivxxth, 'pivxxth');
			hitungHeader(edtpivxxth,'pivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtpivxxth.dependent( 'pivxxth.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtpivxxth, 'pivxxth');
			hitungDpp(edtpivxxth, 'pivxxth');
			hitungHeader(edtpivxxth,'pivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtpivxxth.dependent( 'pivxxth.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtpivxxth, 'pivxxth');
			hitungDpp(edtpivxxth, 'pivxxth');
			hitungHeader(edtpivxxth,'pivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtpivxxth.dependent( 'pivxxth.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master supplier. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtpivxxth,'pivxxth', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtpivxxth.dependent( 'pivxxth.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtpivxxth,'pivxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});

		edtpivxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_grlxxmh_supplier = edtpivxxth.field('pivxxth.id_grlxxmh_supplier').val();
				id_prcxxth    = edtpivxxth.field('pivxxth.id_prcxxth').val();
				tanggal       = edtpivxxth.field('pivxxth.tanggal').val();
				diskon_jenis  = edtpivxxth.field('pivxxth.diskon_jenis').val();
				diskon_persen = edtpivxxth.field('pivxxth.diskon_persen').val();
				diskon_value  = edtpivxxth.field('pivxxth.diskon_value').val();

				validasiRequired(
					edtpivxxth,
					'pivxxth',
					{
						'id_grlxxmh_supplier': id_grlxxmh_supplier,
						'id_prcxxth': id_prcxxth,
						'tanggal'   : tanggal
					}
				);

				validasiUnique(
					action,
					edtpivxxth, 
					"pivxxth", 
					"id_prcxxth", 
					'id_prcxxth',
					id_prcxxth,
					id_pivxxth
				);

				if(diskon_jenis == 1){
					validasiNumber(
						edtpivxxth,
						'pivxxth',
						{
							'diskon_persen': diskon_persen
						},
						0,
						'>'
					);
				}else if(diskon_jenis == 2){
					validasiNumber(
						edtpivxxth,
						'pivxxth',
						{
							'diskon_value': diskon_value
						},
						0,
						'>'
					);
				}
			
			}
			
			if ( edtpivxxth.inError() ) {
				return false;
			}
		});

		edtpivxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpivxxth.field('pivxxth.finish_at').val(finish_at);
		
		});
		
		edtpivxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblpivxxth.ajax.reload(null, false);
			tblpivittd.ajax.reload(null, false);
		} );

		edtpivxxth.on( 'close', function () {
			edtpivxxth.enable();
		} );
		
		tblpivxxth = $('#tblpivxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/pivxxth/pivxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pivxxth = show_deleted_pivxxth;
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
				{ data: "pivxxth.id",visible:false },
				{ data: "pivxxth.kode" },
				{ data: "pivxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "pivxxth.kode" },
				{ data: "prcxxth.kode" },
				{ 
					data: "pivxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "pivxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pivxxth';
					$table       = 'tblpivxxth';
					$edt         = 'edtpivxxth';
					$show_status = '_pivxxth';
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Purchase Invoice&id_transaksi='+id_pivxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.pivxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.pivxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpivxxth.searchPanes.container().appendTo('#sppivxxth');
		tblpivxxth.searchBuilder.container().appendTo( '#sbpivxxth' );
		
		tblpivxxth.on( 'init', function () {
			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			pivxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblpivittd];
			CekInitHeaderHD(tblpivxxth, tbl_details);
		} );
		
		tblpivxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('pivxxth');
			id_prcxxth_old    = pivxxth_data.id_prcxxth;
			id_prcxxth        = pivxxth_data.id_prcxxth;
			id_fcrxxmh_old    = pivxxth_data.id_fcrxxmh;
			id_fpytmmh_old    = pivxxth_data.id_fpytmmh;
			id_grlxxmh_old    = pivxxth_data.id_grlxxmh_supplier;

			// terkait footer
			diskon_final_h = pivxxth_data.diskon_final;
			dpp_final_h    = pivxxth_data.dpp_final;
			pajak_final_h  = pivxxth_data.pajak_final;
			grand_total_h  = pivxxth_data.grand_total;
			id_iitxxmh_old    = pivxxth_data.id_iitxxmh;
			id_iitxxmh        = pivxxth_data.id_iitxxmh;
			pivxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblpivittd];
			CekSelectHeaderHD(tblpivxxth, tbl_details);

		} );
		
		tblpivxxth.on( 'deselect', function () {
			siVarReset('pivxxth');
			id_grlxxmh_old = 0;
			id_fpytmmh_old = 0;
			id_fcrxxmh_old = 0;
			id_prcxxth_old = 0;

			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			id_iitxxmh_old = 0;
			id_iitxxmh = 0;
			pivxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblpivittd];
			CekDeselectHeaderHD(tblpivxxth, tbl_details);
		} );
		// END pivxxth

		// BEGIN pivittd
		edtpivittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pivxxth/pivittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pivittd = show_deleted_pivittd;
					d.id_pivxxth = id_pivxxth;
				}
			},
			template: "#frmpivittd",
			table: "#tblpivittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "pivittd.start_at",
					name: "pivittd.start_at",
					type: "hidden"
				},	
				{
					label: "pivittd.finish_at",
					name: "pivittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pivittd",
					type: "hidden"
				},	
				{
					label: "pivittd.transaction_state",
					name: "pivittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_pivxxth",
					name: "pivittd.id_pivxxth",
					type: "hidden"
				},	
				{
					label: "Item GR<sup class='text-danger'>*<sup>",
					name: "pivittd.id_prcittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/prcxxth/prcittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_prcittd_old: id_prcittd_old,
									ids_prcxxth: id_prcxxth,
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
					name: "prcittd_info",
					type: "textarea"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "pivittd.id_iimxxmh",
					type: "hidden",
				}, 	
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "pivittd.id_iumxxmh_unit",
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
					name: "pivittd.jumlah_unit"
				}, 	
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "pivittd.harga_unit"
				},
				{
					label: "Subtotal",
					name: "pivittd.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "pivittd.diskon_jenis",
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
					name: "pivittd.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "pivittd.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "pivittd.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "pivittd.dpp",
					type: "readonly"
				},
				{
					label: "Tanggal Dibutuhkan",
					name: "pivittd.tanggal_dibutuhkan",
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
					name: "pivittd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtpivittd.field('pivittd.jumlah_unit').input().addClass('text-right');
		edtpivittd.field('pivittd.harga_unit').input().addClass('text-right');
		edtpivittd.field('pivittd.subtotal').input().addClass('text-right');
		edtpivittd.field('pivittd.diskon_persen').input().addClass('text-right');
		edtpivittd.field('pivittd.diskon_value').input().addClass('text-right');
		edtpivittd.field('pivittd.diskon_final').input().addClass('text-right');
		edtpivittd.field('pivittd.dpp').input().addClass('text-right');
			
		edtpivittd.on( 'preOpen', function( e, mode, action ) {
			edtpivittd.field('pivittd.id_pivxxth').val(id_pivxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpivittd.field('pivittd.start_at').val(start_at);
			
			edtpivittd.field('prcittd_info').disable();
			
			if(action == 'create'){
				tblpivittd.rows().deselect();
				edtpivittd.field('pivittd.jumlah_unit').enable();
				edtpivittd.field('pivittd.id_iumxxmh_unit').enable();
				edtpivittd.field('pivittd.id_prcittd').enable();
			} else if(action == 'edit'){
				edtpivittd.field('pivittd.jumlah_unit').disable();
				edtpivittd.field('pivittd.id_iumxxmh_unit').disable();
				edtpivittd.field('pivittd.id_prcittd').disable();
			}
		});

		edtpivittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtpivittd.dependent( 'pivittd.id_prcittd', function ( val, data, callback ) {
			id_prcittd = edtpivittd.field('pivittd.id_prcittd').val();
			autofillField('prcittd', id_prcittd, 'id_iimxxmh, jumlah_unit,tanggal_dibutuhkan,keterangan')
			
			// BEGIN generate prcittd_info
			if (autofillData.tanggal_dibutuhkan == null){
				prcittd_info_dibutuhkan = '';
			}else{
				prcittd_info_dibutuhkan = '; Dibutuhkan: ' + moment(autofillData.tanggal_dibutuhkan).format("DD MMM YYYY");
			}
			if (autofillData.keterangan != ''){
				prcittd_info_notes = '; Notes: ' + autofillData.keterangan;
			}else{
				prcittd_info_notes = '';
			}
			// END generate prcittd_info
			edtpivittd.field('prcittd_info').val('Permintaan: ' + autofillData.jumlah_unit + prcittd_info_dibutuhkan + prcittd_info_notes);

			edtpivittd.field('pivittd.id_iimxxmh').val(autofillData.id_iimxxmh);

			return {}
		}, {event: 'keyup change'});
		
		edtpivittd.dependent( 'pivittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtpivittd.field('pivittd.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtpivittd.dependent( 'pivittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtpivittd, 'pivittd');
			hitungDpp(edtpivittd, 'pivittd');
			return {}
		}, {event: 'keyup change'});
		
		edtpivittd.dependent( 'pivittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtpivittd, 'pivittd');
			hitungDpp(edtpivittd, 'pivittd');
			return {}
		}, {event: 'keyup change'});
		
		edtpivittd.dependent( 'pivittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtpivittd.field('pivittd.diskon_persen').show();
				edtpivittd.field('pivittd.diskon_value').hide();
				
				edtpivittd.field('pivittd.diskon_persen').val();
				edtpivittd.field('pivittd.diskon_value').val('');
			} else if (val == 2) {
				edtpivittd.field('pivittd.diskon_persen').hide();
				edtpivittd.field('pivittd.diskon_value').show();
				
				edtpivittd.field('pivittd.diskon_persen').val('');
				edtpivittd.field('pivittd.diskon_value').val();
			} else {
				edtpivittd.field('pivittd.diskon_persen').hide();
				edtpivittd.field('pivittd.diskon_value').hide();
				edtpivittd.field('pivittd.diskon_persen').val(0);
				edtpivittd.field('pivittd.diskon_value').val(0);
				edtpivittd.field('pivittd.diskon_final').val(0);
			}

			hitungDiskon(edtpivittd, 'pivittd');
			hitungDpp(edtpivittd, 'pivittd');
			return {}
		}, {event: 'keyup change'});
		
		edtpivittd.dependent( 'pivittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpivittd, 'pivittd');
				hitungDpp(edtpivittd, 'pivittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtpivittd.dependent( 'pivittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpivittd, 'pivittd');
				hitungDpp(edtpivittd, 'pivittd');
			}
			return {}
		}, {event: 'keyup'});

		edtpivittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_pivittd;
				console.log(id_pivittd);
			}

			if(action != 'remove'){
				
				id_prcittd      = edtpivittd.field('pivittd.id_prcittd').val();
				id_iumxxmh_unit = edtpivittd.field('pivittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtpivittd.field('pivittd.id_iimxxmh').val();
				jumlah_unit     = edtpivittd.field('pivittd.jumlah_unit').val();
				harga_unit      = edtpivittd.field('pivittd.harga_unit').val();
				diskon_jenis    = edtpivittd.field('pivittd.diskon_jenis').val();
				diskon_persen    = edtpivittd.field('pivittd.diskon_persen').val();
				diskon_value    = edtpivittd.field('pivittd.diskon_value').val();

				validasiRequired(
					edtpivittd,
					'pivittd',
					{
						'id_prcittd': id_prcittd,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						// 'id_iimxxmh': id_iimxxmh,
					}
				);
				
				validasiNumber(
					edtpivittd,
					'pivittd',
					{
						'jumlah_unit': jumlah_unit,
						'harga_unit': harga_unit
					},
					0,
					'>'
				);

				if(diskon_jenis == 1){
					validasiNumber(
						edtpivittd,
						'pivittd',
						{
							'diskon_persen': diskon_persen
						},
						0,
						'>'
					);
				}else if(diskon_jenis == 2){
					validasiNumber(
						edtpivittd,
						'pivittd',
						{
							'diskon_value': diskon_value
						},
						0,
						'>'
					);
				}

				
				validasiOutstanding(edtpivittd, 'pivittd', id_transaksi, id_prcittd, 'prcittd');

			}
			
			if ( edtpivittd.inError() ) {
				return false;
			}
		});

		edtpivittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpivittd.field('pivittd.finish_at').val(finish_at);
		});
			
		edtpivittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				tblpivittd.rows().deselect();
			}
			
			hitungSubtotalHeader(id_transaksi_h, 'pivittd', 'pivxxth');
			hitungHeaderDetail('pivxxth', 'pivittd', id_transaksi_h);
			
			tblpivxxth.ajax.reload(null, false);
			tblpivxxth.rows().deselect();
			tblpivittd.ajax.reload(null, false);
		} );

		edtpivittd.on( 'close', function () {
			edtpivittd.enable();
		} );
		
		tblpivittd = $('#tblpivittd').DataTable( {
			ajax: {
				url: "../../models/pivxxth/pivittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pivittd = show_deleted_pivittd;
					d.id_pivxxth = id_pivxxth;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "pivittd.id",visible:false },
				{ data: "pivittd.id_pivxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "pivittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "pivittd.harga_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "pivittd.subtotal",
					...renderNumber( 0, "")
				},
				{ 
					data: "pivittd.diskon_final",
					...renderNumber( 0, "")
				},
				{ 
					data: "pivittd.dpp",
					...renderNumber( 0, "")
				},

			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pivittd';
					$table       = 'tblpivittd';
					$edt         = 'edtpivittd';
					$show_status = '_pivittd';
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

		tblpivittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblpivittd, 1 );
			CekDrawDetailHDFinal(tblpivxxth);
		} );

		tblpivittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('pivittd');
			id_iimxxmh          = pivittd_data.id_iimxxmh;
			id_iimxxmh_old      = pivittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = pivittd_data.id_iumxxmh_unit;
			id_prcittd_old      = pivittd_data.id_prcittd;

			// atur hak akses
			CekSelectDetailHD( tblpivittd );
		} );

		tblpivittd.on( 'deselect', function() {
			siVarResetD('pivittd');
			id_iimxxmh_old = 0, id_prcittd_old = 0, id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblpivittd );
		} );

		// END pivittd

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
				tblpivxxth.rows().deselect();
				tblpivxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFpivxxth').modal('toggle');
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
