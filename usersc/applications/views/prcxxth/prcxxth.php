<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'prcxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'prcittd';
    $nama_tabels_d[1] = 'prcaktd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFprcxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmprcxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.tanggal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.id_grlxxmh_supplier"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.id_podxxth"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.id_iwhxxmh"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.referensi_nomor"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.mobil_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblprcxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th data-i18n="date"></th>
                                <th data-i18n="code"></th>
								<th data-i18n="supplier"></th>
								<th data-i18n="purchaseOrder"></th>
								<th data-i18n="warehouse"></th>
								<th data-i18n="state"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="alert alert-info alert-dismissable">
			Tab Biaya akan muncul jika Tipe PO yang dipilih = Jasa
		</div>
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabprcittd"> Item</a></li>
				<li id="tab_biaya" style="display: none"><a class="nav-link" data-toggle="tab" href="#tabprcaktd"> Biaya</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabprcittd" class="tab-pane active">
					<div class="panel-body">
						
						<div id="frmprcittd">
							<div class="panel-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd.id_iimxxmh"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd.jumlah_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd.id_iumxxmh_unit"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table id="tblprcittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_prcxxth</th>
										<th data-i18n="itemCode"></th>
										<th data-i18n="itemName"></th>
										<th data-i18n="uom"></th>
										<th data-i18n="quantity"></th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabprcaktd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblprcaktd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_podxxth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prcxxth/fn/prcxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtprcxxth, tblprcxxth, show_deleted_prcxxth = 0, id_prcxxth;
	var edtprcittd, tblprcittd, show_deleted_prcittd = 0, id_prcittd;
	var edtprcaktd, tblprcaktd, show_deleted_prcaktd = 0, id_prcaktd;
	// ------------- end of default variable

	var id_iitxxmh = 0, id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_podxxth_old = 0, id_iwhxxmh_old = 0, id_podxxth = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, id_aakxxmh_old = 0;

	// get tableRelation
	tableRelation('prcxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN prcxxth
		edtprcxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth/prcxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth = show_deleted_prcxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmprcxxth",
			table: "#tblprcxxth",
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
					label: "prcxxth.start_at",
					name: "prcxxth.start_at",
					type: "hidden"
				},	
				{
					label: "prcxxth.finish_at",
					name: "prcxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcxxth",
					type: "hidden"
				},	
				{
					label: "prcxxth.transaction_state",
					name: "prcxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('date') + " <sup class='text-danger'>*<sup>",
					name: "prcxxth.tanggal",
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
					label: getTranslation('supplier') + " <sup class='text-danger'>*<sup>",
					name: "prcxxth.id_grlxxmh_supplier",
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
					label: getTranslation('purchaseOrder') + " <sup class='text-danger'>*<sup>",
					name: "prcxxth.id_podxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/prcxxth/prcxxth_podxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_supplier: id_grlxxmh_supplier,
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
					label: "prcxxth.id_iitxxmh",
					name: "prcxxth.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "prcxxth.id_fpytmmh",
					name: "prcxxth.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "prcxxth.id_fcrxxmh",
					name: "prcxxth.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "prcxxth.is_pajak",
					name: "prcxxth.is_pajak",
					type: "hidden"
				},
				{
					label: "prcxxth.pajak_jenis",
					name: "prcxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "prcxxth.pajak_in_ex",
					name: "prcxxth.pajak_in_ex",
					type: "hidden"
				},
				{
					label: getTranslation('warehouse') + " <sup class='text-danger'>*<sup>",
					name: "prcxxth.id_iwhxxmh",
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
					label: getTranslation('deliverySlip') + " <sup class='text-danger'>*<sup>",
					name: "prcxxth.referensi_nomor"
				},
				{
					label: getTranslation('driver'),
					name: "prcxxth.supir_nama"
				},
				{
					label: getTranslation('licensePlate') + " <sup class='text-danger'>*<sup>",
					name: "prcxxth.mobil_nomor"
				},
				{
					label: getTranslation('notes'),
					name: "prcxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtprcxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcxxth.field('prcxxth.start_at').val(start_at);

			if(action == 'create'){
				tblprcxxth.rows().deselect();
			}
		});

		edtprcxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edtprcxxth.dependent( 'prcxxth.id_grlxxmh_supplier', function ( val, data, callback ) {
			edtprcxxth.field('prcxxth.id_podxxth').input().val(null).trigger('change');
			id_grlxxmh_supplier = val;
			return {}
		}, {event: 'keyup change'});

		edtprcxxth.dependent( 'prcxxth.id_podxxth', function ( val, data, callback ) {
			id_podxxth = val;
			autofillField('podxxth', id_podxxth, 'id_iitxxmh');
			id_iitxxmh = autofillData.id_iitxxmh;
			edtprcxxth.field('prcxxth.id_iitxxmh').val(id_iitxxmh);

			// jika non inventory, tidak perlu isi warehouse
			if(id_iitxxmh == 2 || id_iitxxmh == 3){
				edtprcxxth.field('prcxxth.id_iwhxxmh').hide();
				edtprcxxth.field('prcxxth.referensi_nomor').hide();
				edtprcxxth.field('prcxxth.supir_nama').hide();
				
				if (id_iitxxmh == 3) {
					edtprcxxth.field('prcxxth.mobil_nomor').hide();
				} else {
					edtprcxxth.field('prcxxth.mobil_nomor').show();
				}
			}else{
				edtprcxxth.field('prcxxth.id_iwhxxmh').show();
				edtprcxxth.field('prcxxth.referensi_nomor').show();
				edtprcxxth.field('prcxxth.supir_nama').show();
			}
			
			return {}
		}, {event: 'keyup change'});
		
		edtprcxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal             = edtprcxxth.field('prcxxth.tanggal').val();
				mobil_nomor             = edtprcxxth.field('prcxxth.mobil_nomor').val();
				id_iwhxxmh          = edtprcxxth.field('prcxxth.id_iwhxxmh').val();
				id_grlxxmh_supplier = edtprcxxth.field('prcxxth.id_grlxxmh_supplier').val();
				id_podxxth          = edtprcxxth.field('prcxxth.id_podxxth').val();
				referensi_nomor     = edtprcxxth.field('prcxxth.referensi_nomor').val();

				autofillField('podxxth', id_podxxth, 'id_iitxxmh');
				id_iitxxmh = autofillData.id_iitxxmh;
				if (id_iitxxmh != 3) {
					validasiRequired(
						edtprcxxth, 
						"prcxxth", 
						{
							"mobil_nomor": mobil_nomor, 
						}
					);
				}

				validasiRequired(
					edtprcxxth, 
					"prcxxth", 
					{
						"tanggal": tanggal, 
						"id_grlxxmh_supplier": id_grlxxmh_supplier,
						"id_podxxth": id_podxxth
					}
				);

				if(id_iitxxmh == 1 ){
					validasiRequired(
						edtprcxxth, 
						"prcxxth", 
						{
							"id_iwhxxmh": id_iwhxxmh,
							"referensi_nomor": referensi_nomor
						}
					);
				
				}

			}
			
			if ( edtprcxxth.inError() ) {
				return false;
			}
		});

		edtprcxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcxxth.field('prcxxth.finish_at').val(finish_at);
		});
		
		edtprcxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtprcxxth.on( 'close', function () {
			edtprcxxth.enable();
		} );
		
		tblprcxxth = $('#tblprcxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/prcxxth/prcxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth = show_deleted_prcxxth;
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
				{ data: "prcxxth.id",visible:false },
				{ data: "prcxxth.tanggal" },
				{ data: "prcxxth.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "podxxth.kode" },
				{ data: "iwhxxmh.nama" },
				{ 
					data: "prcxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcxxth';
					$table       = 'tblprcxxth';
					$edt         = 'edtprcxxth';
					$show_status = '_prcxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					extend: 'collection',
					name: 'btnPrintCollection',
					text: '<i class="fa fa-print"></i>',
					className: 'btn btn-sm btn-outline',
					autoClose: true,
					buttons: [
						{
							text: 'Print Jurnal',
							name: 'btnPrintJurnal',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Print Jurnal',
							action: function ( e, dt, node, config ) {
								e.preventDefault(); 
								var url = $(this).attr('href'); 
								window.open('../../views/core/jv_print.php?jenis_transaksi=Goods Receive&id_transaksi='+id_prcxxth, '_blank');
							}
						},
						{
							text: 'Print Slip',
							name: 'btnPrintSlip',
							className: 'btn btn-sm btn-outline',
							titleAttr: 'Print Slip',
							action: function ( e, dt, node, config ) {
								e.preventDefault(); 
								var url = $(this).attr('href'); 
								window.open('prcxxth_print.php?id_transaksi='+id_prcxxth, '_blank');
							}
						}
					]
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.prcxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prcxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprcxxth.searchPanes.container().appendTo('#spprcxxth');
		tblprcxxth.searchBuilder.container().appendTo( '#sbprcxxth' );
		
		tblprcxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblprcittd, tblprcaktd];
			CekInitHeaderHD(tblprcxxth, tbl_details);
			tblprcxxth.button('btnPrintSlip:name').disable();
		} );
		
		tblprcxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prcxxth');
			id_grlxxmh_old      = prcxxth_data.id_grlxxmh_supplier;
			id_grlxxmh_supplier = prcxxth_data.id_grlxxmh_supplier;
			id_podxxth_old      = prcxxth_data.id_podxxth;
			id_podxxth          = prcxxth_data.id_podxxth;
			id_iitxxmh          = prcxxth_data.id_iitxxmh;
			id_iwhxxmh_old      = prcxxth_data.id_iwhxxmh;
			
			// atur hak akses
			tbl_details = [tblprcittd, tblprcaktd];
			CekSelectHeaderHD(tblprcxxth, tbl_details);
			tblprcxxth.button('btnPrintSlip:name').enable();

			if (id_iitxxmh == 3) {
				$('#tab_biaya').show();
			} else {
				$('#tab_biaya').hide();
			}
		} );
		
		tblprcxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('prcxxth');
			id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_podxxth_old = 0, id_iwhxxmh_old = 0, id_podxxth = 0, id_iitxxmh = 0;

			// atur hak akses
			tbl_details = [tblprcittd, tblprcaktd];
			CekDeselectHeaderHD(tblprcxxth, tbl_details);
			tblprcxxth.button('btnPrintSlip:name').disable();
			$('#tab_biaya').hide();
		} );
		// END prcxxth

		// BEGIN prcittd
		edtprcittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth/prcittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd = show_deleted_prcittd;
					d.id_prcxxth = id_prcxxth;
				}
			},
			table: "#tblprcittd",
			template: "#frmprcittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "prcittd.start_at",
					name: "prcittd.start_at",
					type: "hidden"
				},	
				{
					label: "prcittd.finish_at",
					name: "prcittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcittd",
					type: "hidden"
				},	
				{
					label: "prcittd.transaction_state",
					name: "prcittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_prcxxth",
					name: "prcittd.id_prcxxth",
					type: "hidden"
				},	
				{
					label: "prcittd.id_podittd",
					name: "prcittd.id_podittd",
					type: "hidden"
				},
				{
					label: "prcittd.id_podxxth",
					name: "prcittd.id_podxxth",
					type: "hidden"
				},
				{
					label: "prcittd.harga_unit",
					name: "prcittd.harga_unit",
					type: "hidden"
				},
				{
					label: "prcittd.diskon_jenis",
					name: "prcittd.diskon_jenis",
					type: "hidden"
				},
				{
					label: "prcittd.diskon_persen",
					name: "prcittd.diskon_persen",
					type: "hidden"
				},
				{
					label: "prcittd.diskon_value",
					name: "prcittd.diskon_value",
					type: "hidden"
				},
				{
					label: "prcittd.diskon_final",
					name: "prcittd.diskon_final",
					type: "hidden"
				},
				{
					label: "prcittd.subtotal",
					name: "prcittd.subtotal",
					type: "hidden"
				},
				{
					label: "prcittd.dpp",
					name: "prcittd.dpp",
					type: "hidden"
				},
				{
					label: getTranslation('item') + " <sup class='text-danger'>*<sup>",
					name: "prcittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/prcxxth/prcittd_iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									id_podxxth: id_podxxth_old,
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
					label: getTranslation('quantity') + " <sup class='text-danger'>*<sup>",
					name: "prcittd.jumlah_unit"
				},
				{
					label: getTranslation('uom') + " <sup class='text-danger'>*<sup>",
					name: "prcittd.id_iumxxmh_unit",
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
					label: getTranslation('notes'),
					name: "prcittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtprcittd.on( 'preOpen', function( e, mode, action ) {
			edtprcittd.field('prcittd.id_prcxxth').val(id_prcxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcittd.field('prcittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblprcittd.rows().deselect();
			}
		});

		edtprcittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtprcittd.dependent( 'prcittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtprcittd.field('prcittd.id_iumxxmh_unit').input().val(null).trigger('change');
			prcittd_fn_podittd(id_podxxth,id_iimxxmh)
			return {}
		}, {event: 'keyup change'});

		edtprcittd.dependent( 'prcittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtprcittd, 'prcittd');
			hitungDpp(edtprcittd, 'prcittd');
			return {}
		}, {event: 'keyup change'});
		
		edtprcittd.dependent( 'prcittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtprcittd, 'prcittd');
			hitungDpp(edtprcittd, 'prcittd');

			return {}
		}, {event: 'keyup change'});

		edtprcittd.dependent( 'prcittd.diskon_jenis', function ( val, data, callback ) {
			hitungDiskon(edtprcittd, 'prcittd');
			hitungDpp(edtprcittd, 'prcittd');
			return {}
		}, {event: 'keyup change'});
		
		edtprcittd.dependent( 'prcittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtprcittd, 'prcittd');
				hitungDpp(edtprcittd, 'prcittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtprcittd.dependent( 'prcittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtprcittd, 'prcittd');
				hitungDpp(edtprcittd, 'prcittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtprcittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_prcittd;
			}

			if(action != 'remove'){
				id_iimxxmh = edtprcittd.field('prcittd.id_iimxxmh').val();
				jumlah_unit = edtprcittd.field('prcittd.jumlah_unit').val();
				id_iumxxmh_unit = edtprcittd.field('prcittd.id_iumxxmh_unit').val();

				validasiRequired(
					edtprcittd,
					'prcittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'jumlah_unit': jumlah_unit,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);
				
				validasiNumber(
					edtprcittd,
					'prcittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

				validasiOutstanding(
					edtprcittd, 'prcittd', id_transaksi, id_podittd, 'podittd'
				)

			}
			
			if ( edtprcittd.inError() ) {
				return false;
			}
		});

		edtprcittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcittd.field('prcittd.finish_at').val(finish_at);
		});
			
		edtprcittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			hitungSubtotalHeader(id_transaksi_h, 'prcittd', 'prcxxth');
			hitungHeaderDetail('prcxxth', 'prcittd', id_transaksi_h);

			tblprcxxth.ajax.reload(null, false);
			tblprcittd.rows().deselect();
			tblprcittd.ajax.reload(null, false);
		} );

		edtprcittd.on( 'close', function () {
			edtprcittd.enable();
		} );
		
		tblprcittd = $('#tblprcittd').DataTable( {
			ajax: {
				url: "../../models/prcxxth/prcittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd = show_deleted_prcittd;
					d.id_prcxxth = id_prcxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "prcittd.id",visible:false },
				{ data: "prcittd.id_prcxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "prcittd.jumlah_unit",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcittd';
					$table       = 'tblprcittd';
					$edt         = 'edtprcittd';
					$show_status = '_prcittd';
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

		tblprcittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblprcittd, 1 );
			CekDrawDetailHDFinal(tblprcxxth);
		} );

		tblprcittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('prcittd');
			id_iimxxmh_old = prcittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = prcittd_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblprcittd );
		} );

		tblprcittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('prcittd');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblprcittd );
		} );
		// END prcittd
		
		// BEGIN prcaktd
		edtprcaktd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth/prcaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcaktd = show_deleted_prcaktd;
					d.id_prcxxth = id_prcxxth;
				}
			},
			table: "#tblprcaktd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "prcaktd.start_at",
					name: "prcaktd.start_at",
					type: "hidden"
				},	
				{
					label: "prcaktd.finish_at",
					name: "prcaktd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcaktd",
					type: "hidden"
				},	
				{
					label: "prcaktd.transaction_state",
					name: "prcaktd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_prcxxth",
					name: "prcaktd.id_prcxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('account') + " <sup class='text-danger'>*<sup>",
					name: "prcaktd.id_aakxxmh",
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
					name: "prcaktd.nominal"
				}, 	
			]
		} );
			
		//masking
		unmaskedData = maskingNumber(
			edtprcaktd, 
			"prcaktd", 
			[
				"nominal", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);
		
		edtprcaktd.on( 'preOpen', function( e, mode, action ) {
			edtprcaktd.field('prcaktd.id_prcxxth').val(id_prcxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcaktd.field('prcaktd.start_at').val(start_at);
			
			if(action == 'create'){
				tblprcaktd.rows().deselect();
			}
		});

		edtprcaktd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtprcaktd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh = edtprcaktd.field('prcaktd.id_aakxxmh').val();

				validasiRequired(
					edtprcaktd,
					'prcaktd',
					{
						'id_aakxxmh': id_aakxxmh,
					}
				);	

				validasiUnique(
					action,
					edtprcaktd,
					'prcaktd',
					'id_aakxxmh',
					'id_aakxxmh',
					id_aakxxmh,
					id_prcaktd
				);
			}
			
			if ( edtprcaktd.inError() ) {
				return false;
			}
		});

		edtprcaktd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcaktd.field('prcaktd.finish_at').val(finish_at);
		});
			
		edtprcaktd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblprcxxth.ajax.reload(null, false);
		} );

		edtprcaktd.on( 'close', function () {
			edtprcaktd.enable();
		} );
		
		tblprcaktd = $('#tblprcaktd').DataTable( {
			ajax: {
				url: "../../models/prcxxth/prcaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcaktd = show_deleted_prcaktd;
					d.id_prcxxth = id_prcxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "prcaktd.id",visible:false },
				{ data: "prcaktd.id_prcxxth",visible:false },
				{ data: "aakxxmh.kode" },
				{ data: "aakxxmh.nama" },
				{ 
					data: "prcaktd.nominal",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcaktd';
					$table       = 'tblprcaktd';
					$edt         = 'edtprcaktd';
					$show_status = '_prcaktd';
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

		tblprcaktd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblprcaktd, 0 );
			CekDrawDetailHDFinal(tblprcxxth);
		} );

		tblprcaktd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prcaktd');
			id_aakxxmh_old = prcaktd_data.id_aakxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblprcaktd );
		} );

		tblprcaktd.on( 'deselect', function() {
			// reset variable standar framework
			siVarReset('prcaktd');
			id_aakxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblprcaktd );
		} );
		// END prcaktd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblprcxxth.rows().deselect();
				tblprcxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFprcxxth').modal('toggle');
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
