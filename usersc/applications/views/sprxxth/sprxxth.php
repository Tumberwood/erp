<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sprxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sprivtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFsprxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblsprxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
							<th>ID</th>
							<th>Kode</th>
							<th>Tanggal</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabsprivtd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabsprivtd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsprivtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsprivtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sprxxth</th>
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
				<div role="tabpanel" id="tabsprivtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsprivtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sprxxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sprxxth/fn/sprxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtsprxxth, tblsprxxth, show_deleted_sprxxth = 0, id_sprxxth;
	var edtsprivtd, tblsprivtd, show_deleted_sprivtd = 0, id_sprivtd;
	var id_aakxxmh_old = 0, id_grlxxmh_customer_old = 0, id_sivxxth_old = 0;
	var id_aakxxmh_beban_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('sprxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN sprxxth
		edtsprxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sprxxth/sprxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sprxxth = show_deleted_sprxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblsprxxth",
			fields: [ 
				{
					label: "sprxxth.start_at",
					name: "sprxxth.start_at",
					type: "hidden"
				},	
				{
					label: "sprxxth.finish_at",
					name: "sprxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sprxxth",
					type: "hidden"
				},	
				{
					label: "sprxxth.transaction_state",
					name: "sprxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "sprxxth.tanggal",
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
					name: "sprxxth.id_grlxxmh_customer",
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
					label: "Kas / Bank <sup class='text-danger'>*<sup>",
					name: "sprxxth.id_aakxxmh",
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
					name: "sprxxth.id_aakxxmh_beban",
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
					name: "sprxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtsprxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsprxxth.field('sprxxth.start_at').val(start_at);

			if(action == 'create'){
				tblsprxxth.rows().deselect();
			}
		});

		edtsprxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtsprxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtsprxxth.field('sprxxth.tanggal').val();
				id_grlxxmh_customer = edtsprxxth.field('sprxxth.id_grlxxmh_customer').val();
				id_aakxxmh = edtsprxxth.field('sprxxth.id_aakxxmh').val();

				validasiRequired(
					edtsprxxth,
					'sprxxth',
					{
						'tanggal': tanggal,
						'id_grlxxmh_customer': id_grlxxmh_customer,
						'id_aakxxmh': id_aakxxmh,
					}
				);
			}
			
			if ( edtsprxxth.inError() ) {
				return false;
			}
		});

		edtsprxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsprxxth.field('sprxxth.finish_at').val(finish_at);
		});
		
		edtsprxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtsprxxth.on( 'close', function () {
			edtsprxxth.enable();
		} );
		
		tblsprxxth = $('#tblsprxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sprxxth/sprxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sprxxth = show_deleted_sprxxth;
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
				{ data: "sprxxth.id",visible:false },
				{ data: "sprxxth.kode" },
				{ data: "sprxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "aakxxmh.nama" },
				{ data: "beban.nama" },
				{ data: "sprxxth.amount", ...renderNumber() },
				{ data: "sprxxth.rencana_bayar", ...renderNumber() },
				{ data: "sprxxth.sisa", ...renderNumber() },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sprxxth';
					$table       = 'tblsprxxth';
					$edt         = 'edtsprxxth';
					$show_status = '_sprxxth';
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
				if ( data.sprxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sprxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsprxxth.searchPanes.container().appendTo('#spsprxxth');
		tblsprxxth.searchBuilder.container().appendTo( '#sbsprxxth' );
		
		tblsprxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblsprivtd];
			CekInitHeaderHD(tblsprxxth, tbl_details);
		} );
		
		tblsprxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('sprxxth');
			id_grlxxmh_customer_old = sprxxth_data.id_grlxxmh_customer;
			id_aakxxmh_old = sprxxth_data.id_aakxxmh;
			id_aakxxmh_beban_old = sprxxth_data.id_aakxxmh_beban;
			
			// atur hak akses
			tbl_details = [tblsprivtd];
			CekSelectHeaderHD(tblsprxxth, tbl_details);

		} );
		
		tblsprxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('sprxxth');
			id_grlxxmh_customer_old = 0;
			id_aakxxmh_old = 0;
			id_aakxxmh_beban_old = 0;

			// atur hak akses
			tbl_details = [tblsprivtd];
			CekDeselectHeaderHD(tblsprxxth, tbl_details);
		} );
		// END sprxxth

		// BEGIN sprivtd
		edtsprivtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sprxxth/sprivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sprivtd = show_deleted_sprivtd;
					d.id_sprxxth = id_sprxxth;
				}
			},
			table: "#tblsprivtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "sprivtd.start_at",
					name: "sprivtd.start_at",
					type: "hidden"
				},	
				{
					label: "sprivtd.finish_at",
					name: "sprivtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sprivtd",
					type: "hidden"
				},	
				{
					label: "sprivtd.transaction_state",
					name: "sprivtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sprxxth",
					name: "sprivtd.id_sprxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('salesInvoice') + ` <sup class='text-danger'>*<sup>`,
					name: "sprivtd.id_sivxxth",
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
					name: "sprivtd.tanggal",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: getTranslation('dueDate'),
					name: "sprivtd.tanggal_jatuh_tempo",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					
					label: "Amount <sup class='text-danger'>*<sup>",  
					name: "sprivtd.amount",
					type: "readonly"
				},
				{
					
					label: "Rencana Bayar",
					name: "sprivtd.rencana_bayar",
				},
				{
					
					label: "Sisa",
					name: "sprivtd.sisa",
					type: "readonly"
				},
			]
		} );

		edtsprivtd.field('sprivtd.tanggal').disable()
		edtsprivtd.field('sprivtd.tanggal_jatuh_tempo').disable()

		//masking
		unmask_sprivtd = maskingNumber(
			edtsprivtd,
			"sprivtd",
			[
				"amount",
				"rencana_bayar",
				"sisa"
			],
			0, // digit belakang koma
			0, // validasiNumber
			'>=' // val >= 0
		);
			
		edtsprivtd.on( 'preOpen', function( e, mode, action ) {
			edtsprivtd.field('sprivtd.id_sprxxth').val(id_sprxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsprivtd.field('sprivtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblsprivtd.rows().deselect();
			}
		});

		edtsprivtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtsprivtd.dependent( 'sprivtd.id_sivxxth', function ( val, data, callback ) {
			if (val > 0 && id_sivxxth_old == 0 || id_sivxxth_old != val) {
				autofillField('sivxxth', val, 'DATE_FORMAT(tanggal, "%d %b %Y") AS tanggal,DATE_FORMAT(tanggal_jatuh_tempo, "%d %b %Y") AS tanggal_jatuh_tempo,selisih_bayar')
				tanggal = autofillData.tanggal;
				tanggal_jatuh_tempo = autofillData.tanggal_jatuh_tempo;
				amount = autofillData.selisih_bayar;
				edtsprivtd.field('sprivtd.tanggal').val(tanggal);
				edtsprivtd.field('sprivtd.tanggal_jatuh_tempo').val(tanggal_jatuh_tempo);
				edtsprivtd.field('sprivtd.amount').val(amount);
				edtsprivtd.field('sprivtd.rencana_bayar').val(amount);
			}
			return {}
		}, {event: 'keyup change'});
		
		edtsprivtd.dependent( 'sprivtd.amount', function ( val, data, callback ) {
			amount = parseFloat(edtsprivtd.field('sprivtd.amount').input().inputmask('unmaskedvalue'));
			rencana_bayar = parseFloat(edtsprivtd.field('sprivtd.rencana_bayar').input().inputmask('unmaskedvalue'));
			sisa = amount - rencana_bayar;
			edtsprivtd.field('sprivtd.sisa').val(sisa);
			
			return {}
		}, {event: 'keyup change'});
		
		edtsprivtd.dependent( 'sprivtd.rencana_bayar', function ( val, data, callback ) {
			amount = parseFloat(edtsprivtd.field('sprivtd.amount').input().inputmask('unmaskedvalue'));
			rencana_bayar = parseFloat(edtsprivtd.field('sprivtd.rencana_bayar').input().inputmask('unmaskedvalue'));
			sisa = amount - rencana_bayar;
			edtsprivtd.field('sprivtd.sisa').val(sisa);
			
			return {}
		}, {event: 'keyup change'});

		edtsprivtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_sivxxth = edtsprivtd.field('sprivtd.id_sivxxth').val();

				validasiRequired(
					edtsprivtd,
					'sprivtd',
					{
						'id_sivxxth': id_sivxxth,
					}
				);

				console.log(id_sprxxth);
				

				validasiUnique(
					action,
					edtsprivtd,
					'sprivtd',
					'id_sivxxth',
					'id_sivxxth,id_sprxxth',
					id_sivxxth+","+id_sprxxth,
					id_sprivtd
				);	
			}
			
			if ( edtsprivtd.inError() ) {
				return false;
			}
		});

		edtsprivtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsprivtd.field('sprivtd.finish_at').val(finish_at);
		});
			
		edtsprivtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblsprxxth.rows().deselect();
			tblsprxxth.ajax.reload(null, false);
		} );

		edtsprivtd.on( 'close', function () {
			edtsprivtd.enable();
		} );
		
		tblsprivtd = $('#tblsprivtd').DataTable( {
			ajax: {
				url: "../../models/sprxxth/sprivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sprivtd = show_deleted_sprivtd;
					d.id_sprxxth = id_sprxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "sprivtd.id",visible:false },
				{ data: "sprivtd.id_sprxxth",visible:false },
				{ data: "sivxxth.kode" },
				{ data: "sprivtd.tanggal" },
				{ data: "sprivtd.tanggal_jatuh_tempo" },
				{ data: "sprivtd.amount", ...renderNumber() },
				{ data: "sprivtd.rencana_bayar", ...renderNumber() },
				{ data: "sprivtd.sisa", ...renderNumber() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sprivtd';
					$table       = 'tblsprivtd';
					$edt         = 'edtsprivtd';
					$show_status = '_sprivtd';
					$table_name  = $nama_tabels_d[0];

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

		tblsprivtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsprivtd, 1 );
			CekDrawDetailHDFinal(tblsprxxth);
		} );

		tblsprivtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('sprivtd');
			id_sivxxth_old = sprivtd_data.id_sivxxth;
			
			// atur hak akses
			CekSelectDetailHD( tblsprivtd );
		} );

		tblsprivtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('sprivtd');
			id_sivxxth_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsprivtd );
		} );
		// END sprivtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsprxxth.rows().deselect();
				tblsprxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsprxxth').modal('toggle');
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
