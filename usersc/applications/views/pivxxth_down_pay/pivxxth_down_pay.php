<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'pivxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
					
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
									<editor-field name="pivxxth.id_podxxth"></editor-field>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="pivxxth.subtotal"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="pivxxth.down_payment"></editor-field>
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
									<editor-field name="pivxxth.pajak_final"></editor-field>
								</div>
								<div class="col-lg-6">
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="pivxxth.grand_total"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="pivxxth.id_fpytmmh"></editor-field>
								</div>
							</div>
						</div>
					</div>
					
                    <table id="tblpivxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="date"></th>
                                <th data-i18n="supplier"></th>
                                <th data-i18n="purchaseOrder"></th>
                                <th>Nominal PO</th>
                                <th>Down Payment</th>
                                <th data-i18n="state"></th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pivxxth_down_pay/fn/pivxxth_down_pay_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpivxxth, tblpivxxth, show_deleted_pivxxth = 0, id_pivxxth;
	var id_podxxth_old = 0, id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_fpytmmh_old = 0, id_iitxxmh = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('pivxxth');

	$(document).ready(function() {
		// BEGIN pivxxth
		edtpivxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pivxxth_down_pay/pivxxth_down_pay.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pivxxth = show_deleted_pivxxth;
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
					label: "pivxxth.id_iitxxmh",
					name: "pivxxth.id_iitxxmh",
					type: "hidden",
				},	
				{
					label: getTranslation('supplier') + " <sup class='text-danger'>*<sup>",
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
					label: getTranslation('purchaseOrder') + "<sup class='text-danger'>*<sup>",
					name: "pivxxth.id_podxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/prcxxth/prcxxth_podxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_grlxxmh_supplier = edtpivxxth.field('pivxxth.id_grlxxmh_supplier').val();
								console.log(id_grlxxmh_supplier);
								var query = {
									id_podxxth_old: id_podxxth_old,
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
					label: getTranslation('date') + " <sup class='text-danger'>*<sup>",
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
					label: getTranslation('termOfPayment') + " <sup class='text-danger'>*<sup>",
					name: "pivxxth.id_fpytmmh",
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
					label: "Nominal Purchase Order",
					name: "pivxxth.subtotal",
					type: "readonly"
				},
				
				{
					label: "Down Payment <sup class='text-danger'>*<sup>",
					name: "pivxxth.down_payment",
				},
				{
					label: "Diskon Final",
					name: "pivxxth.diskon_final",
					type: "hidden"
				},
				{
					label: "dpp",
					name: "pivxxth.dpp",
					type: "readonly",
				},
				{
					label: "dpp_final",
					name: "pivxxth.dpp_final",
					type: "hidden",
				},
				{
					label: "diskon_jenis",
					name: "pivxxth.diskon_jenis",
					type: "hidden",
				},
				{
					label: getTranslation('isTaxable'),
					name: "pivxxth.is_pajak",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": getTranslation('yes'), "value": 1 },
						{ "label": getTranslation('no'), "value": 0 }
					]
				},
				{
					label: getTranslation('includingTax'),
					name: "pivxxth.pajak_in_ex",
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
					name: "pivxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "pajak_persen",
					name: "pivxxth.pajak_persen",
					type: "hidden"
				},
				{
					label: getTranslation('tax'),
					name: "pivxxth.pajak_final",
					type: "readonly"
				},
				{
					label: getTranslation('grandTotal'),
					name: "pivxxth.grand_total",
					type: "readonly"
				},
				
				{
					label: getTranslation('notes'),
					name: "pivxxth.keterangan",
					type: "textarea"
				},
			]
		} );

		unmaskedHeader = maskingNumber(
			edtpivxxth, 
			"pivxxth", 
			[ 
				"subtotal", 
				"down_payment", 
				"dpp", 
				"pajak_final", 
				"grand_total", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>=' // val >= 0
		);

		edtpivxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpivxxth.field('pivxxth.start_at').val(start_at);
			
			if(action == 'create'){
				tblpivxxth.rows().deselect();
			}
		});

		edtpivxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtpivxxth.dependent( 'pivxxth.id_podxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('podxxth', val, 'grand_total,id_iitxxmh');
				subtotal = autofillData.grand_total;
				id_iitxxmh = autofillData.id_iitxxmh;
				edtpivxxth.field('pivxxth.subtotal').val(subtotal);
				edtpivxxth.field('pivxxth.id_iitxxmh').val(id_iitxxmh);
			} else {
				edtpivxxth.field('pivxxth.subtotal').val(0);
				edtpivxxth.field('pivxxth.id_iitxxmh').val(0);
			}
			return {}
		}, {event: 'keyup change'});

		edtpivxxth.dependent( 'pivxxth.down_payment', function ( val, data, callback ) {
			down_payment = edtpivxxth.field('pivxxth.down_payment').input().inputmask('unmaskedvalue');
			edtpivxxth.field('pivxxth.dpp').val(down_payment);
			hitungHeader(edtpivxxth,'pivxxth', id_iitxxmh);

			return {}
		}, {event: 'keyup change'});

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
				tanggal = edtpivxxth.field('pivxxth.tanggal').val();
				id_fpytmmh = edtpivxxth.field('pivxxth.id_fpytmmh').val();

				validasiRequired(
					edtpivxxth,
					'pivxxth',
					{
						'id_grlxxmh_supplier': id_grlxxmh_supplier,
						'tanggal': tanggal,
						'id_fpytmmh': id_fpytmmh,
					}
				);
			}
			
			if ( edtpivxxth.inError() ) {
				return false;
			}
		});
		
		edtpivxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpivxxth.field('pivxxth.finish_at').val(finish_at);
		});

		edtpivxxth.on( 'close', function () {
			edtpivxxth.enable();
		} );

		tblpivxxth = $('#tblpivxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/pivxxth_down_pay/pivxxth_down_pay.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pivxxth = show_deleted_pivxxth;
				}
			},
			order: [[ 1, "asc" ]],
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
				{ data: "pivxxth.id",visible:false },
				{ data: "pivxxth.kode" },
				{ data: "pivxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "podxxth.kode" },
				{ 
					data: "podxxth.grand_total",
					...renderNumber()
				},
				{ 
					data: "pivxxth.down_payment",
					...renderNumber()
				},
				{ 
					data: "pivxxth.transaction_state" ,
					...renderTransactionStatus()
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
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
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
			// atur hak akses
			CekInitHeaderH(tblpivxxth);
		} );
		
		tblpivxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('pivxxth');
			id_fpytmmh_old = pivxxth_data.id_fpytmmh;
			id_podxxth_old = pivxxth_data.id_podxxth;
			id_grlxxmh_supplier_old = pivxxth_data.id_grlxxmh_supplier;
			id_iitxxmh = pivxxth_data.id_iitxxmh;

			// atur hak akses
			CekSelectHeaderH(tblpivxxth);
		} );

		tblpivxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('pivxxth');
			id_fpytmmh_old = 0;
			id_podxxth_old = 0;
			id_grlxxmh_supplier_old = 0;
			id_iitxxmh = 0;
			// atur hak akses
			CekDeselectHeaderH(tblpivxxth);
		} );

		// END pivxxth
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
