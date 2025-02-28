<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'spmxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'spmivtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFspmxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblspmxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
							<th>ID</th>
							<th>Kode</th>
							<th>Tanggal</th>
							<th>Kode DPP</th>
							<th>Customer</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabspmivtd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabspmivtd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabspmivtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblspmivtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_spmxxth</th>
										<th data-i18n="salesInvoice"></th>
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
				<div role="tabpanel" id="tabspmivtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblspmivtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_spmxxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/spmxxth/fn/spmxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtspmxxth, tblspmxxth, show_deleted_spmxxth = 0, id_spmxxth;
	var edtspmivtd, tblspmivtd, show_deleted_spmivtd = 0, id_spmivtd;
	var id_aakxxmh_old = 0, id_grlxxmh_customer_old = 0, id_sivxxth_old = 0, id_sprxxth_old = 0;
	var id_aakxxmh_beban_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('spmxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN spmxxth
		edtspmxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/spmxxth/spmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_spmxxth = show_deleted_spmxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblspmxxth",
			fields: [ 
				{
					label: "spmxxth.start_at",
					name: "spmxxth.start_at",
					type: "hidden"
				},	
				{
					label: "spmxxth.finish_at",
					name: "spmxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "spmxxth",
					type: "hidden"
				},	
				{
					label: "spmxxth.transaction_state",
					name: "spmxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "spmxxth.tanggal",
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
					name: "spmxxth.id_grlxxmh_customer",
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
									id_grlxxmh_old: id_grlxxmh_customer_old,
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
					label: "DPP <sup class='text-danger'>*<sup>",
					name: "spmxxth.id_sprxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/sprxxth/sprxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_grlxxmh_customer = edtspmxxth.field('spmxxth.id_grlxxmh_customer').val();
								var query = {
									id_sprxxth_old: id_sprxxth_old,
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
							minimumResultsForSearch: -1
						}
					}
				},	
				{
					label: "Kas / Bank <sup class='text-danger'>*<sup>",
					name: "spmxxth.id_aakxxmh",
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
					name: "spmxxth.id_aakxxmh_beban",
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
					name: "spmxxth.keterangan",
					type: "textarea"
				},
				{
					label: "amount",
					name: "spmxxth.amount",
					type: "hidden"
				},
				{
					label: "rencana_bayar",
					name: "spmxxth.rencana_bayar",
					type: "hidden"
				},
				{
					label: "sisa",
					name: "spmxxth.sisa",
					type: "hidden"
				},
			]
		} );
		// edtspmxxth.field('spmxxth.id_aakxxmh').disable();
		
		edtspmxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtspmxxth.field('spmxxth.start_at').val(start_at);

			if(action == 'create'){
				tblspmxxth.rows().deselect();
			}
		});

		edtspmxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});

		edtspmxxth.dependent( 'spmxxth.id_sprxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('sprxxth', val, 'id_aakxxmh,id_aakxxmh_beban,amount,rencana_bayar,sisa');
				id_aakxxmh_old = autofillData.id_aakxxmh;
				id_aakxxmh_beban_old = autofillData.id_aakxxmh_beban;
				amount = autofillData.amount;
				rencana_bayar = autofillData.rencana_bayar;
				sisa = autofillData.sisa;

				if (id_sprxxth_old != val ) {
					
					edtspmxxth.field('spmxxth.id_aakxxmh').val(id_aakxxmh_old);
					edtspmxxth.field('spmxxth.id_aakxxmh_beban').val(id_aakxxmh_beban_old);
					edtspmxxth.field('spmxxth.amount').val(amount);
					edtspmxxth.field('spmxxth.rencana_bayar').val(rencana_bayar);
					edtspmxxth.field('spmxxth.sisa').val(sisa);
				}
			} else {
				edtspmxxth.field('spmxxth.id_aakxxmh').val('');
				edtspmxxth.field('spmxxth.id_aakxxmh_beban').val('');
				edtspmxxth.field('spmxxth.amount').val('');
				edtspmxxth.field('spmxxth.rencana_bayar').val('');
				edtspmxxth.field('spmxxth.sisa').val('');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtspmxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtspmxxth.field('spmxxth.tanggal').val();
				id_grlxxmh_customer = edtspmxxth.field('spmxxth.id_grlxxmh_customer').val();
				id_aakxxmh = edtspmxxth.field('spmxxth.id_aakxxmh').val();
				id_sprxxth = edtspmxxth.field('spmxxth.id_sprxxth').val();

				validasiRequired(
					edtspmxxth,
					'spmxxth',
					{
						'tanggal': tanggal,
						'id_grlxxmh_customer': id_grlxxmh_customer,
						'id_aakxxmh': id_aakxxmh,
						'id_sprxxth': id_sprxxth,
					}
				);
			}
			
			if ( edtspmxxth.inError() ) {
				return false;
			}
		});

		edtspmxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtspmxxth.field('spmxxth.finish_at').val(finish_at);
		});
		
		edtspmxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtspmxxth.on( 'close', function () {
			edtspmxxth.enable();
		} );
		
		tblspmxxth = $('#tblspmxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/spmxxth/spmxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_spmxxth = show_deleted_spmxxth;
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
				{ data: "spmxxth.id",visible:false },
				{ data: "spmxxth.kode" },
				{ data: "spmxxth.tanggal" },
				{ data: "sprxxth.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "aakxxmh.nama" },
				{ data: "beban.nama" },
				{ data: "spmxxth.amount", ...renderNumber() },
				{ data: "spmxxth.rencana_bayar", ...renderNumber() },
				{ data: "spmxxth.sisa", ...renderNumber() },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_spmxxth';
					$table       = 'tblspmxxth';
					$edt         = 'edtspmxxth';
					$show_status = '_spmxxth';
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Sales Payment&id_transaksi='+id_spmxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.spmxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.spmxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblspmxxth.searchPanes.container().appendTo('#spspmxxth');
		tblspmxxth.searchBuilder.container().appendTo( '#sbspmxxth' );
		
		tblspmxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblspmivtd];
			CekInitHeaderHD(tblspmxxth, tbl_details);
		} );
		
		tblspmxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('spmxxth');
			id_grlxxmh_customer_old = spmxxth_data.id_grlxxmh_customer;
			id_aakxxmh_old = spmxxth_data.id_aakxxmh;
			id_aakxxmh_beban_old = spmxxth_data.id_aakxxmh_beban;
			id_sprxxth_old = spmxxth_data.id_sprxxth;
			
			// atur hak akses
			tbl_details = [tblspmivtd];
			CekSelectHeaderHD(tblspmxxth, tbl_details);

		} );
		
		tblspmxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('spmxxth');
			id_grlxxmh_customer_old = 0;
			id_aakxxmh_old = 0;
			id_aakxxmh_beban_old = 0;
			id_sprxxth_old = 0;

			// atur hak akses
			tbl_details = [tblspmivtd];
			CekDeselectHeaderHD(tblspmxxth, tbl_details);
		} );
		// END spmxxth

		// BEGIN spmivtd
		edtspmivtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/spmxxth/spmivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_spmivtd = show_deleted_spmivtd;
					d.id_spmxxth = id_spmxxth;
				}
			},
			table: "#tblspmivtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "spmivtd.start_at",
					name: "spmivtd.start_at",
					type: "hidden"
				},	
				{
					label: "spmivtd.finish_at",
					name: "spmivtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "spmivtd",
					type: "hidden"
				},	
				{
					label: "spmivtd.transaction_state",
					name: "spmivtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_spmxxth",
					name: "spmivtd.id_spmxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('salesInvoice') + ` <sup class='text-danger'>*<sup>`,
					name: "spmivtd.id_sivxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/sivxxth/sivxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_sivxxth_old: id_sivxxth_old,
									id_grlxxmh_customer: id_grlxxmh_customer_old,
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
					name: "spmivtd.tanggal",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: getTranslation('dueDate'),
					name: "spmivtd.tanggal_jatuh_tempo",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					
					label: "Amount <sup class='text-danger'>*<sup>",  
					name: "spmivtd.amount",
					type: "readonly"
				},
				{
					
					label: "Rencana Bayar",
					name: "spmivtd.rencana_bayar",
				},
				{
					
					label: "Sisa",
					name: "spmivtd.sisa",
					type: "readonly"
				},
			]
		} );

		//masking
		unmask_spmivtd = maskingNumber(
			edtspmivtd,
			"spmivtd",
			[
				"amount",
				"rencana_bayar",
				"sisa"
			],
			0, // digit belakang koma
			0, // validasiNumber
			'>=' // val >= 0
		);
			
		edtspmivtd.on( 'preOpen', function( e, mode, action ) {
			edtspmivtd.field('spmivtd.id_spmxxth').val(id_spmxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtspmivtd.field('spmivtd.start_at').val(start_at);
			
			edtspmivtd.field('spmivtd.id_sivxxth').disable();
			edtspmivtd.field('spmivtd.tanggal').disable();
			edtspmivtd.field('spmivtd.tanggal_jatuh_tempo').disable();
			
			if(action == 'create'){
				tblspmivtd.rows().deselect();
			}
		});

		edtspmivtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtspmivtd.dependent( 'spmivtd.rencana_bayar', function ( val, data, callback ) {
			amount = parseFloat(edtspmivtd.field('spmivtd.amount').input().inputmask('unmaskedvalue'));
			rencana_bayar = parseFloat(edtspmivtd.field('spmivtd.rencana_bayar').input().inputmask('unmaskedvalue'));
			sisa = amount - rencana_bayar;
			edtspmivtd.field('spmivtd.sisa').val(sisa);
			
			return {}
		}, {event: 'keyup change'});

		edtspmivtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_sivxxth = edtspmivtd.field('spmivtd.id_sivxxth').val();

				validasiRequired(
					edtspmivtd,
					'spmivtd',
					{
						'id_sivxxth': id_sivxxth,
					}
				);

				console.log(id_spmxxth);
				

				validasiUnique(
					action,
					edtspmivtd,
					'spmivtd',
					'id_sivxxth',
					'id_sivxxth,id_spmxxth',
					id_sivxxth+","+id_spmxxth,
					id_spmivtd
				);	
			}
			
			if ( edtspmivtd.inError() ) {
				return false;
			}
		});

		edtspmivtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtspmivtd.field('spmivtd.finish_at').val(finish_at);
		});
			
		edtspmivtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblspmxxth.rows().deselect();
			tblspmxxth.ajax.reload(null, false);
		} );

		edtspmivtd.on( 'close', function () {
			edtspmivtd.enable();
		} );
		
		tblspmivtd = $('#tblspmivtd').DataTable( {
			ajax: {
				url: "../../models/spmxxth/spmivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_spmivtd = show_deleted_spmivtd;
					d.id_spmxxth = id_spmxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "spmivtd.id",visible:false },
				{ data: "spmivtd.id_spmxxth",visible:false },
				{ data: "sivxxth.kode" },
				{ data: "spmivtd.tanggal" },
				{ data: "spmivtd.tanggal_jatuh_tempo" },
				{ data: "spmivtd.amount", ...renderNumber() },
				{ data: "spmivtd.rencana_bayar", ...renderNumber() },
				{ data: "spmivtd.sisa", ...renderNumber() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_spmivtd';
					$table       = 'tblspmivtd';
					$edt         = 'edtspmivtd';
					$show_status = '_spmivtd';
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

		tblspmivtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblspmivtd, 1 );
			CekDrawDetailHDFinal(tblspmxxth);
		} );

		tblspmivtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('spmivtd');
			id_sivxxth_old = spmivtd_data.id_sivxxth;
			
			// atur hak akses
			CekSelectDetailHD( tblspmivtd );
		} );

		tblspmivtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('spmivtd');
			id_sivxxth_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblspmivtd );
		} );
		// END spmivtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblspmxxth.rows().deselect();
				tblspmxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFspmxxth').modal('toggle');
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
