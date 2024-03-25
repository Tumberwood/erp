<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'podxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'podittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
					
				<!-- start Custom Form Datatables Editor -->
				<div id="frmpodxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.tanggal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.id_iitxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.id_psuxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.id_fcrxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.id_fpytmmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.subtotal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.diskon_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.diskon_persen"></editor-field>
								<editor-field name="podxxth.diskon_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.diskon_final"></editor-field>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-6">
							<editor-field name="podxxth.dpp_final"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.dpp"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.is_pajak"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.pajak_in_ex"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.pajak_jenis"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.pajak_persen"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.pajak_final"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
							</div>
							<div class="col-lg-6">
								<editor-field name="podxxth.grand_total"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="podxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<table id="tblpodxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Tanggal</th>
							<th>Kode</th>
							<th>Supplier</th>
							<th>Type</th>
							<th>TX</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabpodittd_1"> Item</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabpodittd_2"> Biaya</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabpodittd_1" class="tab-pane active">
					<div class="panel-body">
						<!-- start Custom Form Datatables Editor -->
						<div id="frmpodittd">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="podittd.id_prqittd"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="prqittd_info"></editor-field>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="podittd.id_iimxxmh"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.id_iumxxmh_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="podittd.jumlah_unit"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.harga_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.subtotal"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="podittd.diskon_jenis"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.diskon_persen"></editor-field>
										<editor-field name="podittd.diskon_value"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.diskon_final"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.dpp"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<editor-field name="podittd.tanggal_dibutuhkan"></editor-field>
									</div>
									<div class="col-lg-6">
										<editor-field name="podittd.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<!-- end Custom Form Datatables Editor -->
						
							<table id="tblpodittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_podxxth</th>
										<th>Item</th>
										<th>UoM</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Subtotal</th>
										<th>Discount</th>
										<th>Total</th>
										<th>Purchase Request</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
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
						

					</div>
				</div>
				<div role="tabpanel" id="tabpodittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpodittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_podxxth</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/podxxth/fn/podxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpodxxth, tblpodxxth, show_deleted_podxxth = 0, id_podxxth;
	var edtpodittd, tblpodittd, show_deleted_podittd = 0, id_podittd;
	// ------------- end of default variable

	var id_iitxxmh_old = 0, id_psuxxmh_old = 0, id_fcrxxmh_old = 0, id_fpytmmh_old = 0, is_pajak, id_iitxxmh;
	var id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, id_prqittd_old = 0, id_iumxxmh_unit  = 0;

	// get tableRelation
	tableRelation('podxxth');

	$(document).ready(function() {
		// BEGIN podxxth
		edtpodxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/podxxth/podxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podxxth = show_deleted_podxxth;
				}
			},
			template: "#frmpodxxth",
			table: "#tblpodxxth",
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
					label: "podxxth.start_at",
					name: "podxxth.start_at",
					type: "hidden"
				},	
				{
					label: "podxxth.finish_at",
					name: "podxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "podxxth",
					type: "hidden"
				},	
				{
					label: "podxxth.transaction_state",
					name: "podxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Type <sup class='text-danger'>*<sup>",
					name: "podxxth.id_iitxxmh",
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
					label: "Payment Terms <sup class='text-danger'>*<sup>",
					name: "podxxth.id_fpytmmh",
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
					label: "Supplier <sup class='text-danger'>*<sup>",
					name: "podxxth.id_psuxxmh",
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
									id_psuxxmh_old: id_psuxxmh_old,
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
					name: "podxxth.id_fcrxxmh",
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "podxxth.tanggal",
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
					name: "podxxth.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "podxxth.diskon_jenis",
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
					name: "podxxth.diskon_persen"
				}, 	
				{
					label: "Diskon (Rp)",
					name: "podxxth.diskon_value"
				}, 	
				{
					label: "Diskon Final",
					name: "podxxth.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "podxxth.dpp",
					type: "readonly"
				},
				{
					label: "dpp_final",
					name: "podxxth.dpp_final",
					type: "hidden"
				},
				{
					label: "Menggunakan Pajak",
					name: "podxxth.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Termasuk Pajak",
					name: "podxxth.pajak_in_ex",
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
					name: "podxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "podxxth.pajak_persen",
					type: "hidden"
				},
				{
					label: "Pajak",
					name: "podxxth.pajak_final",
					type: "readonly"
				},
				{
					label: "Grand Total",
					name: "podxxth.grand_total",
					type: "readonly"
				},
				
				{
					label: "Keterangan",
					name: "podxxth.keterangan",
					type: "textarea"
				},
			]
		} );

		edtpodxxth.field('podxxth.subtotal').input().addClass('text-right');
		edtpodxxth.field('podxxth.diskon_persen').input().addClass('text-right');
		edtpodxxth.field('podxxth.diskon_value').input().addClass('text-right');
		edtpodxxth.field('podxxth.diskon_final').input().addClass('text-right');
		edtpodxxth.field('podxxth.dpp').input().addClass('text-right');
		edtpodxxth.field('podxxth.pajak_final').input().addClass('text-right');
		edtpodxxth.field('podxxth.grand_total').input().addClass('text-right');
		
		edtpodxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodxxth.field('podxxth.start_at').val(start_at);

			if(action == 'create'){
				tblpodxxth.rows().deselect();
				edtpodxxth.field('kategori_dokumen').val('');
				edtpodxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtpodxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			
			$('#select_id_fcrxxmh').select2('open');
			setTimeout(function() {
				$('#select_id_fcrxxmh').select2('close');
			}, 5);
		});

		edtpodxxth.dependent( 'podxxth.id_iitxxmh', function ( val, data, callback ) {
			id_iitxxmh = edtpodxxth.field('podxxth.id_iitxxmh').val();
			hitungHeader(edtpodxxth,'podxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtpodxxth.dependent( 'podxxth.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtpodxxth.field('podxxth.diskon_persen').show();
				edtpodxxth.field('podxxth.diskon_value').hide();
				
				edtpodxxth.field('podxxth.diskon_persen').val();
				edtpodxxth.field('podxxth.diskon_value').val('');
			} else if (val == 2) {
				edtpodxxth.field('podxxth.diskon_persen').hide();
				edtpodxxth.field('podxxth.diskon_value').show();
				
				edtpodxxth.field('podxxth.diskon_persen').val('');
				edtpodxxth.field('podxxth.diskon_value').val();
			} else {
				edtpodxxth.field('podxxth.diskon_persen').hide();
				edtpodxxth.field('podxxth.diskon_value').hide();
				
				edtpodxxth.field('podxxth.diskon_persen').val(0);
				edtpodxxth.field('podxxth.diskon_value').val(0);
				edtpodxxth.field('podxxth.diskon_final').val(0);
			}
			hitungDiskon(edtpodxxth, 'podxxth');
			hitungDpp(edtpodxxth, 'podxxth');
			hitungHeader(edtpodxxth,'podxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});
		
		edtpodxxth.dependent( 'podxxth.diskon_persen', function ( val, data, callback ) {
			hitungDiskon(edtpodxxth, 'podxxth');
			hitungDpp(edtpodxxth, 'podxxth');
			hitungHeader(edtpodxxth,'podxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});
		
		edtpodxxth.dependent( 'podxxth.diskon_value', function ( val, data, callback ) {
			hitungDiskon(edtpodxxth, 'podxxth');
			hitungDpp(edtpodxxth, 'podxxth');
			hitungHeader(edtpodxxth,'podxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup'});

		edtpodxxth.dependent( 'podxxth.is_pajak', function ( val, data, callback ) {
			/**
			 * is_pajak: menentukan apakah PO tersebut kena pajak atau tidak
			 * nantinya bisa diambilkan dari master supplier. 
			 * tergantung bisnis prosesnya
			 */
			hitungHeader(edtpodxxth,'podxxth', id_iitxxmh);
			return {}
		}, {event: 'change'});

		edtpodxxth.dependent( 'podxxth.pajak_in_ex', function ( val, data, callback ) {
			hitungHeader(edtpodxxth,'podxxth', id_iitxxmh);
			return {}
		}, {event: 'keyup change'});

		edtpodxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_psuxxmh    = edtpodxxth.field('podxxth.id_psuxxmh').val();
				id_fpytmmh    = edtpodxxth.field('podxxth.id_fpytmmh').val();
				id_fcrxxmh    = edtpodxxth.field('podxxth.id_fcrxxmh').val();
				id_iitxxmh    = edtpodxxth.field('podxxth.id_iitxxmh').val();
				tanggal       = edtpodxxth.field('podxxth.tanggal').val();
				diskon_jenis  = edtpodxxth.field('podxxth.diskon_jenis').val();
				diskon_persen = edtpodxxth.field('podxxth.diskon_persen').val();
				diskon_value  = edtpodxxth.field('podxxth.diskon_value').val();

				validasiRequired(
					edtpodxxth,
					'podxxth',
					{
						'id_psuxxmh': id_psuxxmh,
						'id_fpytmmh': id_fpytmmh,
						'id_fcrxxmh': id_fcrxxmh,
						'id_iitxxmh': id_iitxxmh,
						'tanggal'   : tanggal
					}
				);

				if(diskon_jenis == 1){
					validasiNumber(
						edtpodxxth,
						'podxxth',
						{
							'diskon_persen': diskon_persen
						},
						0,
						'>'
					);
				}else if(diskon_jenis == 2){
					validasiNumber(
						edtpodxxth,
						'podxxth',
						{
							'diskon_value': diskon_value
						},
						0,
						'>'
					);
				}
			
			}
			
			if ( edtpodxxth.inError() ) {
				return false;
			}
		});

		edtpodxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodxxth.field('podxxth.finish_at').val(finish_at);
			
			diskon_final_h = edtpodxxth.field('podxxth.diskon_final').val();
			dpp_final_h    = edtpodxxth.field('podxxth.dpp_final').val();
			pajak_final_h  = edtpodxxth.field('podxxth.pajak_final').val();
			grand_total_h  = edtpodxxth.field('podxxth.grand_total').val();
			
			podxxthUpdateFooter();
		});
		
		edtpodxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			edtpodxxth.field('podxxth.diskon_final').val(diskon_final_h);
			edtpodxxth.field('podxxth.dpp_final').val(dpp_final_h);
			edtpodxxth.field('podxxth.pajak_final').val(pajak_final_h);
			edtpodxxth.field('podxxth.grand_total').val(grand_total_h);
		} );

		edtpodxxth.on( 'close', function () {
			edtpodxxth.enable();
		} );
		
		tblpodxxth = $('#tblpodxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/podxxth/podxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podxxth = show_deleted_podxxth;
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
					targets: [0,5,6]
				}
			],
			columns: [
				{ data: "podxxth.id",visible:false },
				{ data: "podxxth.tanggal" },
				{ data: "podxxth.kode" },
				{ data: "psuxxmh.nama" },
				{ data: "iitxxmh.nama" },
				{ 
					data: "podxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "podxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_podxxth';
					$table       = 'tblpodxxth';
					$edt         = 'edtpodxxth';
					$show_status = '_podxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.podxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.podxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpodxxth.searchPanes.container().appendTo('#sppodxxth');
		tblpodxxth.searchBuilder.container().appendTo( '#sbpodxxth' );
		
		tblpodxxth.on( 'init', function () {
			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			podxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblpodittd];
			CekInitHeaderHD(tblpodxxth, tbl_details);
		} );
		
		tblpodxxth.on( 'select', function( e, dt, type, indexes ) {
			podxxth_data      = tblpodxxth.row( { selected: true } ).data().podxxth;
			id_podxxth        = podxxth_data.id;
			id_transaksi_h    = id_podxxth;                                           // dipakai untuk general
			id_transaksi_log  = id_podxxth;                                           // dipakai untuk general
			transaction_state = podxxth_data.transaction_state;
			approval_state    = podxxth_data.approval_state;
			is_nextprocess    = podxxth_data.is_nextprocess;
			id_iitxxmh_old    = podxxth_data.id_iitxxmh;
			id_iitxxmh        = podxxth_data.id_iitxxmh;
			id_fcrxxmh_old    = podxxth_data.id_fcrxxmh;
			id_fpytmmh_old    = podxxth_data.id_fpytmmh;
			id_psuxxmh_old    = podxxth_data.id_psuxxmh;

			// terkait footer
			diskon_final_h = podxxth_data.diskon_final;
			dpp_final_h    = podxxth_data.dpp_final;
			pajak_final_h  = podxxth_data.pajak_final;
			grand_total_h  = podxxth_data.grand_total;
			podxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblpodittd];
			CekSelectHeaderHD(tblpodxxth, tbl_details);

		} );
		
		tblpodxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_podxxth = 0;
			id_psuxxmh_old = 0;
			id_fpytmmh_old = 0;
			id_fcrxxmh_old = 0;
			id_iitxxmh_old = 0;

			// terkait footer
			diskon_final_h = 0;
			dpp_final_h    = 0;
			pajak_final_h  = 0;
			grand_total_h  = 0;
			podxxthUpdateFooter();

			// atur hak akses
			tbl_details = [tblpodittd];
			CekDeselectHeaderHD(tblpodxxth, tbl_details);
		} );
		
		// END podxxth


		// BEGIN podittd

		edtpodittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/podxxth/podittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podittd = show_deleted_podittd;
					d.id_podxxth = id_podxxth;
				}
			},
			template: "#frmpodittd",
			table: "#tblpodittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "podittd.start_at",
					name: "podittd.start_at",
					type: "hidden"
				},	
				{
					label: "podittd.finish_at",
					name: "podittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "podittd",
					type: "hidden"
				},	
				{
					label: "podittd.transaction_state",
					name: "podittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_podxxth",
					name: "podittd.id_podxxth",
					type: "hidden"
				},	
				{
					label: "Item PR<sup class='text-danger'>*<sup>",
					name: "podittd.id_prqittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/prqxxth/prqittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_prqittd_old: id_prqittd_old,
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
					name: "prqittd_info",
					type: "textarea"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "podittd.id_iimxxmh",
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
					name: "podittd.id_iumxxmh_unit",
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
					name: "podittd.jumlah_unit"
				}, 	
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "podittd.harga_unit"
				},
				{
					label: "Subtotal",
					name: "podittd.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "podittd.diskon_jenis",
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
					name: "podittd.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "podittd.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "podittd.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "podittd.dpp",
					type: "readonly"
				},
				{
					label: "Tanggal Dibutuhkan",
					name: "podittd.tanggal_dibutuhkan",
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
					name: "podittd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtpodittd.field('podittd.jumlah_unit').input().addClass('text-right');
		edtpodittd.field('podittd.harga_unit').input().addClass('text-right');
		edtpodittd.field('podittd.subtotal').input().addClass('text-right');
		edtpodittd.field('podittd.diskon_persen').input().addClass('text-right');
		edtpodittd.field('podittd.diskon_value').input().addClass('text-right');
		edtpodittd.field('podittd.diskon_final').input().addClass('text-right');
		edtpodittd.field('podittd.dpp').input().addClass('text-right');
			
		edtpodittd.on( 'preOpen', function( e, mode, action ) {
			edtpodittd.field('podittd.id_podxxth').val(id_podxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodittd.field('podittd.start_at').val(start_at);
			
			edtpodittd.field('prqittd_info').disable();
			
			if(action == 'create'){
				tblpodittd.rows().deselect();
			}
		});

		edtpodittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		edtpodittd.dependent( 'podittd.id_prqittd', function ( val, data, callback ) {
			id_prqittd = edtpodittd.field('podittd.id_prqittd').val();
			autofillField('prqittd', id_prqittd, 'jumlah_unit,tanggal_dibutuhkan,keterangan')

			// BEGIN generate prqittd_info
			if (autofillData.tanggal_dibutuhkan == null){
				prqittd_info_dibutuhkan = '';
			}else{
				prqittd_info_dibutuhkan = '; Dibutuhkan: ' + moment(autofillData.tanggal_dibutuhkan).format("DD MMM YYYY");
			}
			if (autofillData.keterangan != ''){
				prqittd_info_notes = '; Notes: ' + autofillData.keterangan;
			}else{
				prqittd_info_notes = '';
			}
			// END generate prqittd_info
			edtpodittd.field('prqittd_info').val('Permintaan: ' + autofillData.jumlah_unit + prqittd_info_dibutuhkan + prqittd_info_notes);

			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtpodittd.field('podittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});

		edtpodittd.dependent( 'podittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtpodittd, 'podittd');
			hitungDpp(edtpodittd, 'podittd');
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtpodittd, 'podittd');
			hitungDpp(edtpodittd, 'podittd');
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.diskon_jenis', function ( val, data, callback ) {
			if (val == 1) {
				edtpodittd.field('podittd.diskon_persen').show();
				edtpodittd.field('podittd.diskon_value').hide();
				
				edtpodittd.field('podittd.diskon_persen').val();
				edtpodittd.field('podittd.diskon_value').val('');
			} else if (val == 2) {
				edtpodittd.field('podittd.diskon_persen').hide();
				edtpodittd.field('podittd.diskon_value').show();
				
				edtpodittd.field('podittd.diskon_persen').val('');
				edtpodittd.field('podittd.diskon_value').val();
			} else {
				edtpodittd.field('podittd.diskon_persen').hide();
				edtpodittd.field('podittd.diskon_value').hide();
				edtpodittd.field('podittd.diskon_persen').val(0);
				edtpodittd.field('podittd.diskon_value').val(0);
				edtpodittd.field('podittd.diskon_final').val(0);
			}

			hitungDiskon(edtpodittd, 'podittd');
			hitungDpp(edtpodittd, 'podittd');
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpodittd, 'podittd');
				hitungDpp(edtpodittd, 'podittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtpodittd.dependent( 'podittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpodittd, 'podittd');
				hitungDpp(edtpodittd, 'podittd');
			}
			return {}
		}, {event: 'keyup'});

		edtpodittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_prqittd      = edtpodittd.field('podittd.id_prqittd').val();
				id_iumxxmh_unit = edtpodittd.field('podittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtpodittd.field('podittd.id_iimxxmh').val();
				jumlah_unit     = edtpodittd.field('podittd.jumlah_unit').val();
				harga_unit      = edtpodittd.field('podittd.harga_unit').val();
				diskon_jenis    = edtpodittd.field('podittd.diskon_jenis').val();
				diskon_persen    = edtpodittd.field('podittd.diskon_persen').val();
				diskon_value    = edtpodittd.field('podittd.diskon_value').val();

				validasiRequired(
					edtpodittd,
					'podittd',
					{
						'id_prqittd': id_prqittd,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_iimxxmh': id_iimxxmh,
					}
				);
				
				validasiNumber(
					edtpodittd,
					'podittd',
					{
						'jumlah_unit': jumlah_unit,
						'harga_unit': harga_unit
					},
					0,
					'>'
				);

				if(diskon_jenis == 1){
					validasiNumber(
						edtpodittd,
						'podittd',
						{
							'diskon_persen': diskon_persen
						},
						0,
						'>'
					);
				}else if(diskon_jenis == 2){
					validasiNumber(
						edtpodittd,
						'podittd',
						{
							'diskon_value': diskon_value
						},
						0,
						'>'
					);
				}

			}
			
			if ( edtpodittd.inError() ) {
				return false;
			}
		});

		edtpodittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodittd.field('podittd.finish_at').val(finish_at);
		});
			
		edtpodittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				// id_last_insert = json.data[0].podittd.id;
				// id_transaksi_d = json.data[0].podittd.id;
				// konversiUom('podittd', id_last_insert);
				tblpodittd.rows().deselect();
			}
			
			hitungSubtotalHeader(id_transaksi_h, 'podittd', 'podxxth');
			hitungHeaderDetail('podxxth', 'podittd', id_transaksi_h);
			
			tblpodxxth.ajax.reload(null, false);
			tblpodittd.ajax.reload(null, false);
		} );

		edtpodittd.on( 'close', function () {
			edtpodittd.enable();
		} );
		
		tblpodittd = $('#tblpodittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/podxxth/podittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podittd = show_deleted_podittd;
					d.id_podxxth = id_podxxth;
				}
			},
			order: [[ 2, "desc" ]],
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
					targets: [0,4]
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "podittd.id",visible:false },
				{ data: "podittd.id_podxxth",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "podittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "podittd.harga_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "podittd.subtotal",
					...renderNumber( 0, "")
				},
				{ 
					data: "podittd.diskon_final",
					...renderNumber( 0, "")
				},
				{ 
					data: "podittd.dpp",
					...renderNumber( 0, "")
				},
				{ data: "prqxxth.kode" }

			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_podittd';
					$table       = 'tblpodittd';
					$edt         = 'edtpodittd';
					$show_status = '_podittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();
				var s_subtotal 	= api.column(8).data().sum();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
				$( '#s_subtotal' ).html( dtNumberFormat(s_subtotal) );
			}
		} );

		tblpodittd.searchPanes.container().appendTo('#sppodittd');
		tblpodittd.searchBuilder.container().appendTo( '#sbpodittd' );

		tblpodittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblpodxxth, tblpodittd, 'podittd' );
			CekDrawDetailHDFinal(tblpodxxth);
		} );

		tblpodittd.on( 'select', function( e, dt, type, indexes ) {
			data_podittd 		= tblpodittd.row( { selected: true } ).data().podittd;
			id_podittd   		= data_podittd.id;
			id_transaksi_d 		= id_podittd; // dipakai untuk general
			id_transaksi_log 	= id_podittd; // dipakai untuk log

			transaction_state_d = data_podittd.transaction_state;

			id_iimxxmh          = data_podittd.id_iimxxmh;
			id_iimxxmh_old      = data_podittd.id_iimxxmh;
			id_iumxxmh_unit_old = data_podittd.id_iumxxmh_unit;
			id_prqittd_old      = data_podittd.id_prqittd;

			// atur hak akses
			CekSelectDetailHD(tblpodxxth, tblpodittd );
		} );

		tblpodittd.on( 'deselect', function() {
			id_podittd = 0;
			id_iimxxmh_old = 0;
			id_prqittd_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblpodxxth, tblpodittd );
		} );

		// END podittd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
