<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'fpmxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'fpmivtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFfpmxxth" tabindex="-1" role="dialog" aria-hidden="true">
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

				<div class="table-responsive">
                    <table id="tblfpmxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
							<th>ID</th>
							<th>Kode</th>
							<th>Tanggal</th>
							<th>Kode DPH</th>
							<th>Supplier</th>
							<th>Kas / Bank</th>
							<th>Akun Selisih Bayar</th>
							<th>Total Amount</th>
							<th>Total Rencana Bayar</th>
							<th>Total Sisa</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabfpmivtd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabfpmivtd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabfpmivtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblfpmivtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_fpmxxth</th>
										<th data-i18n="purchaseInvoice"></th>
										<th data-i18n='date'></th>
										<th data-i18n='dueDate'></th>
										<th>Amount</th>
										<th>Rencana Bayar</th>
										<th>Sisa</th>
									</tr>
								</thead>
								<tfoot>
									<th></th>
									<th></th>
									<th>Total</th>
									<th></th>
									<th></th>
									<th id="s_5"></th>
									<th id="s_6"></th>
									<th id="s_7"></th>
								</tfoot>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabfpmivtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblfpmivtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_fpmxxth</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fpmxxth/fn/fpmxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtfpmxxth, tblfpmxxth, show_deleted_fpmxxth = 0, id_fpmxxth;
	var edtfpmivtd, tblfpmivtd, show_deleted_fpmivtd = 0, id_fpmivtd;
	var id_aakxxmh_old = 0, id_grlxxmh_supplier_old = 0, id_pivxxth_old = 0, id_fprxxth_old = 0;
	var id_aakxxmh_beban_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('fpmxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN fpmxxth
		edtfpmxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/fpmxxth/fpmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fpmxxth = show_deleted_fpmxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblfpmxxth",
			fields: [ 
				{
					label: "fpmxxth.start_at",
					name: "fpmxxth.start_at",
					type: "hidden"
				},	
				{
					label: "fpmxxth.finish_at",
					name: "fpmxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fpmxxth",
					type: "hidden"
				},	
				{
					label: "fpmxxth.transaction_state",
					name: "fpmxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "fpmxxth.tanggal",
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
					name: "fpmxxth.id_grlxxmh_supplier",
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
									id_grlxxmh_old: id_grlxxmh_supplier_old,
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
					label: "DPH <sup class='text-danger'>*<sup>",
					name: "fpmxxth.id_fprxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fprxxth/fprxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_grlxxmh_supplier = edtfpmxxth.field('fpmxxth.id_grlxxmh_supplier').val();
								var query = {
									id_fprxxth_old: id_fprxxth_old,
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
							minimumResultsForSearch: -1
						}
					}
				},	
				{
					label: "Kas / Bank <sup class='text-danger'>*<sup>",
					name: "fpmxxth.id_aakxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_kasbank.php",
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: "Akun Selisih Bayar",
					name: "fpmxxth.id_aakxxmh_beban",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_type_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_beban_old,
									id_aatxxmh: '13',
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: "Keterangan",
					name: "fpmxxth.keterangan",
					type: "textarea"
				},
				{
					label: "amount",
					name: "fpmxxth.amount",
					type: "hidden"
				},
				{
					label: "rencana_bayar",
					name: "fpmxxth.rencana_bayar",
					type: "hidden"
				},
				{
					label: "sisa",
					name: "fpmxxth.sisa",
					type: "hidden"
				},
			]
		} );
		// edtfpmxxth.field('fpmxxth.id_aakxxmh').disable();
		
		edtfpmxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfpmxxth.field('fpmxxth.start_at').val(start_at);

			if(action == 'create'){
				tblfpmxxth.rows().deselect();
			}
		});

		edtfpmxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtfpmxxth.dependent( 'fpmxxth.id_fprxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('fprxxth', val, 'id_aakxxmh,id_aakxxmh_beban,amount,rencana_bayar,sisa');
				id_aakxxmh_old = autofillData.id_aakxxmh;
				id_aakxxmh_beban_old = autofillData.id_aakxxmh_beban;
				amount = autofillData.amount;
				rencana_bayar = autofillData.rencana_bayar;
				sisa = autofillData.sisa;

				if (id_fprxxth_old != val ) {
					
					edtfpmxxth.field('fpmxxth.id_aakxxmh').val(id_aakxxmh_old);
					edtfpmxxth.field('fpmxxth.id_aakxxmh_beban').val(id_aakxxmh_beban_old);
					edtfpmxxth.field('fpmxxth.amount').val(amount);
					edtfpmxxth.field('fpmxxth.rencana_bayar').val(rencana_bayar);
					edtfpmxxth.field('fpmxxth.sisa').val(sisa);
				}
			} else {
				edtfpmxxth.field('fpmxxth.id_aakxxmh').val('');
				edtfpmxxth.field('fpmxxth.id_aakxxmh_beban').val('');
				edtfpmxxth.field('fpmxxth.amount').val('');
				edtfpmxxth.field('fpmxxth.rencana_bayar').val('');
				edtfpmxxth.field('fpmxxth.sisa').val('');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtfpmxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtfpmxxth.field('fpmxxth.tanggal').val();
				id_grlxxmh_supplier = edtfpmxxth.field('fpmxxth.id_grlxxmh_supplier').val();
				id_aakxxmh = edtfpmxxth.field('fpmxxth.id_aakxxmh').val();
				id_fprxxth = edtfpmxxth.field('fpmxxth.id_fprxxth').val();

				validasiRequired(
					edtfpmxxth,
					'fpmxxth',
					{
						'tanggal': tanggal,
						'id_grlxxmh_supplier': id_grlxxmh_supplier,
						'id_aakxxmh': id_aakxxmh,
						'id_fprxxth': id_fprxxth,
					}
				);
			}
			
			if ( edtfpmxxth.inError() ) {
				return false;
			}
		});

		edtfpmxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfpmxxth.field('fpmxxth.finish_at').val(finish_at);
		});
		
		edtfpmxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtfpmxxth.on( 'close', function () {
			edtfpmxxth.enable();
		} );
		
		tblfpmxxth = $('#tblfpmxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/fpmxxth/fpmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fpmxxth = show_deleted_fpmxxth;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "fpmxxth.id",visible:false },
				{ data: "fpmxxth.kode" },
				{ data: "fpmxxth.tanggal" },
				{ data: "fprxxth.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "aakxxmh.nama" },
				{ data: "beban.nama" },
				{ data: "fpmxxth.amount", ...renderNumber() },
				{ data: "fpmxxth.rencana_bayar", ...renderNumber() },
				{ data: "fpmxxth.sisa", ...renderNumber() },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fpmxxth';
					$table       = 'tblfpmxxth';
					$edt         = 'edtfpmxxth';
					$show_status = '_fpmxxth';
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Purchase Payment&id_transaksi='+id_fpmxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.fpmxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.fpmxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblfpmxxth.searchPanes.container().appendTo('#spfpmxxth');
		tblfpmxxth.searchBuilder.container().appendTo( '#sbfpmxxth' );
		
		tblfpmxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblfpmivtd];
			CekInitHeaderHD(tblfpmxxth, tbl_details);
		} );
		
		tblfpmxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('fpmxxth');
			id_grlxxmh_supplier_old = fpmxxth_data.id_grlxxmh_supplier;
			id_aakxxmh_old = fpmxxth_data.id_aakxxmh;
			id_aakxxmh_beban_old = fpmxxth_data.id_aakxxmh_beban;
			id_fprxxth_old = fpmxxth_data.id_fprxxth;
			
			// atur hak akses
			tbl_details = [tblfpmivtd];
			CekSelectHeaderHD(tblfpmxxth, tbl_details);

		} );
		
		tblfpmxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('fpmxxth');
			id_grlxxmh_supplier_old = 0;
			id_aakxxmh_old = 0;
			id_aakxxmh_beban_old = 0;
			id_fprxxth_old = 0;

			// atur hak akses
			tbl_details = [tblfpmivtd];
			CekDeselectHeaderHD(tblfpmxxth, tbl_details);
		} );
		// END fpmxxth

		// BEGIN fpmivtd
		edtfpmivtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/fpmxxth/fpmivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fpmivtd = show_deleted_fpmivtd;
					d.id_fpmxxth = id_fpmxxth;
				}
			},
			table: "#tblfpmivtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "fpmivtd.start_at",
					name: "fpmivtd.start_at",
					type: "hidden"
				},	
				{
					label: "fpmivtd.finish_at",
					name: "fpmivtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fpmivtd",
					type: "hidden"
				},	
				{
					label: "fpmivtd.transaction_state",
					name: "fpmivtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_fpmxxth",
					name: "fpmivtd.id_fpmxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('purchaseInvoice') + ` <sup class='text-danger'>*<sup>`,
					name: "fpmivtd.id_pivxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/pivxxth/pivxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_pivxxth_old: id_pivxxth_old,
									id_grlxxmh_supplier: id_grlxxmh_supplier_old,
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: getTranslation('date'),
					label: "Tanggal",
					name: "fpmivtd.tanggal",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: getTranslation('dueDate'),
					name: "fpmivtd.tanggal_jatuh_tempo",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					
					label: "Amount <sup class='text-danger'>*<sup>",  
					name: "fpmivtd.amount",
					type: "readonly"
				},
				{
					
					label: "Rencana Bayar",
					name: "fpmivtd.rencana_bayar",
				},
				{
					
					label: "Sisa",
					name: "fpmivtd.sisa",
					type: "readonly"
				},
			]
		} );

		//masking
		unmask_fpmivtd = maskingNumber(
			edtfpmivtd,
			"fpmivtd",
			[
				"amount",
				"rencana_bayar",
				"sisa"
			],
			0, // digit belakang koma
			0, // validasiNumber
			'>=' // val >= 0
		);
			
		edtfpmivtd.on( 'preOpen', function( e, mode, action ) {
			edtfpmivtd.field('fpmivtd.id_fpmxxth').val(id_fpmxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfpmivtd.field('fpmivtd.start_at').val(start_at);
			
			edtfpmivtd.field('fpmivtd.id_pivxxth').disable();
			edtfpmivtd.field('fpmivtd.tanggal').disable();
			edtfpmivtd.field('fpmivtd.tanggal_jatuh_tempo').disable();
			
			if(action == 'create'){
				tblfpmivtd.rows().deselect();
			}
		});

		edtfpmivtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtfpmivtd.dependent( 'fpmivtd.rencana_bayar', function ( val, data, callback ) {
			amount = parseFloat(edtfpmivtd.field('fpmivtd.amount').input().inputmask('unmaskedvalue'));
			rencana_bayar = parseFloat(edtfpmivtd.field('fpmivtd.rencana_bayar').input().inputmask('unmaskedvalue'));
			sisa = amount - rencana_bayar;
			edtfpmivtd.field('fpmivtd.sisa').val(sisa);
			
			return {}
		}, {event: 'keyup change'});

		edtfpmivtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_pivxxth = edtfpmivtd.field('fpmivtd.id_pivxxth').val();

				validasiRequired(
					edtfpmivtd,
					'fpmivtd',
					{
						'id_pivxxth': id_pivxxth,
					}
				);

				console.log(id_fpmxxth);
				

				validasiUnique(
					action,
					edtfpmivtd,
					'fpmivtd',
					'id_pivxxth',
					'id_pivxxth,id_fpmxxth',
					id_pivxxth+","+id_fpmxxth,
					id_fpmivtd
				);	
			}
			
			if ( edtfpmivtd.inError() ) {
				return false;
			}
		});

		edtfpmivtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfpmivtd.field('fpmivtd.finish_at').val(finish_at);
		});
			
		edtfpmivtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblfpmxxth.rows().deselect();
			tblfpmxxth.ajax.reload(null, false);
		} );

		edtfpmivtd.on( 'close', function () {
			edtfpmivtd.enable();
		} );
		
		tblfpmivtd = $('#tblfpmivtd').DataTable( {
			ajax: {
				url: "../../models/fpmxxth/fpmivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fpmivtd = show_deleted_fpmivtd;
					d.id_fpmxxth = id_fpmxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "fpmivtd.id",visible:false },
				{ data: "fpmivtd.id_fpmxxth",visible:false },
				{ data: "pivxxth.kode" },
				{ data: "fpmivtd.tanggal" },
				{ data: "fpmivtd.tanggal_jatuh_tempo" },
				{ data: "fpmivtd.amount", ...renderNumber() },
				{ data: "fpmivtd.rencana_bayar", ...renderNumber() },
				{ data: "fpmivtd.sisa", ...renderNumber() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fpmivtd';
					$table       = 'tblfpmivtd';
					$edt         = 'edtfpmivtd';
					$show_status = '_fpmivtd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['edit', 'remove','view', 'log','noactionD'];
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
				var api = this.api();
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 
				
				for (var i = 5; i <= 7; i++) {
					var columnIndex = i;
					var sum_all = api.column(columnIndex).data().sum();
					// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
					var sum = api.column(columnIndex, { page: 'current' }).data().sum();
					$('#s_' + columnIndex).html(numFormat(sum_all));

					// console.log('Number of Pages: ' + api.page.info().pages);
				}
			}
		} );

		tblfpmivtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblfpmivtd, 1 );
			CekDrawDetailHDFinal(tblfpmxxth);
		} );

		tblfpmivtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('fpmivtd');
			id_pivxxth_old = fpmivtd_data.id_pivxxth;
			
			// atur hak akses
			CekSelectDetailHD( tblfpmivtd );
		} );

		tblfpmivtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('fpmivtd');
			id_pivxxth_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblfpmivtd );
		} );
		// END fpmivtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblfpmxxth.rows().deselect();
				tblfpmxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFfpmxxth').modal('toggle');
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
