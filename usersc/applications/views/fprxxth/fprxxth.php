<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'fprxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'fprivtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFfprxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblfprxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
							<th>ID</th>
							<th>Kode</th>
							<th>Tanggal</th>
							<th>Supplier</th>
							<th>COA Selisih Bayar</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabfprivtd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabfprivtd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabfprivtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblfprivtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_fprxxth</th>
										<th data-i18n="purchaseInvoice"></th>
										<th data-i18n='date'></th>
										<th data-i18n='dueDate'></th>
										<th>Ammount</th>
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
				<div role="tabpanel" id="tabfprivtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblfprivtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_fprxxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fprxxth/fn/fprxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtfprxxth, tblfprxxth, show_deleted_fprxxth = 0, id_fprxxth;
	var edtfprivtd, tblfprivtd, show_deleted_fprivtd = 0, id_fprivtd;
	var id_aakxxmh_old = 0, id_grlxxmh_supplier_old = 0, id_pivxxth_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('fprxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN fprxxth
		edtfprxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/fprxxth/fprxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fprxxth = show_deleted_fprxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblfprxxth",
			fields: [ 
				{
					label: "fprxxth.start_at",
					name: "fprxxth.start_at",
					type: "hidden"
				},	
				{
					label: "fprxxth.finish_at",
					name: "fprxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fprxxth",
					type: "hidden"
				},	
				{
					label: "fprxxth.transaction_state",
					name: "fprxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "fprxxth.tanggal",
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
					name: "fprxxth.id_grlxxmh_supplier",
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
					label: "COA Selisih Bayar <sup class='text-danger'>*<sup>",
					name: "fprxxth.id_aakxxmh",
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
					label: "Keterangan",
					name: "fprxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtfprxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfprxxth.field('fprxxth.start_at').val(start_at);

			if(action == 'create'){
				tblfprxxth.rows().deselect();
			}
		});

		edtfprxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtfprxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtfprxxth.field('fprxxth.tanggal').val();
				id_grlxxmh_supplier = edtfprxxth.field('fprxxth.id_grlxxmh_supplier').val();
				id_aakxxmh = edtfprxxth.field('fprxxth.id_aakxxmh').val();

				validasiRequired(
					edtfprxxth,
					'fprxxth',
					{
						'tanggal': tanggal,
						'id_grlxxmh_supplier': id_grlxxmh_supplier,
						'id_aakxxmh': id_aakxxmh,
					}
				);
			}
			
			if ( edtfprxxth.inError() ) {
				return false;
			}
		});

		edtfprxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfprxxth.field('fprxxth.finish_at').val(finish_at);
		});
		
		edtfprxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtfprxxth.on( 'close', function () {
			edtfprxxth.enable();
		} );
		
		tblfprxxth = $('#tblfprxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/fprxxth/fprxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fprxxth = show_deleted_fprxxth;
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
				{ data: "fprxxth.id",visible:false },
				{ data: "fprxxth.kode" },
				{ data: "fprxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ data: "aakxxmh.nama" },
				{ data: "fprxxth.ammount", ...renderNumber() },
				{ data: "fprxxth.rencana_bayar", ...renderNumber() },
				{ data: "fprxxth.sisa", ...renderNumber() },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fprxxth';
					$table       = 'tblfprxxth';
					$edt         = 'edtfprxxth';
					$show_status = '_fprxxth';
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
				if ( data.fprxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.fprxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblfprxxth.searchPanes.container().appendTo('#spfprxxth');
		tblfprxxth.searchBuilder.container().appendTo( '#sbfprxxth' );
		
		tblfprxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblfprivtd];
			CekInitHeaderHD(tblfprxxth, tbl_details);
		} );
		
		tblfprxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('fprxxth');
			id_grlxxmh_supplier_old = fprxxth_data.id_grlxxmh_supplier;
			id_aakxxmh_old = fprxxth_data.id_aakxxmh;
			
			// atur hak akses
			tbl_details = [tblfprivtd];
			CekSelectHeaderHD(tblfprxxth, tbl_details);

		} );
		
		tblfprxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('fprxxth');
			id_grlxxmh_supplier_old = 0;
			id_aakxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblfprivtd];
			CekDeselectHeaderHD(tblfprxxth, tbl_details);
		} );
		// END fprxxth

		// BEGIN fprivtd
		edtfprivtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/fprxxth/fprivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fprivtd = show_deleted_fprivtd;
					d.id_fprxxth = id_fprxxth;
				}
			},
			table: "#tblfprivtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "fprivtd.start_at",
					name: "fprivtd.start_at",
					type: "hidden"
				},	
				{
					label: "fprivtd.finish_at",
					name: "fprivtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fprivtd",
					type: "hidden"
				},	
				{
					label: "fprivtd.transaction_state",
					name: "fprivtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_fprxxth",
					name: "fprivtd.id_fprxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('purchaseInvoice') + ` <sup class='text-danger'>*<sup>`,
					name: "fprivtd.id_pivxxth",
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
					name: "fprivtd.tanggal",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: getTranslation('dueDate'),
					name: "fprivtd.tanggal_jatuh_tempo",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					
					label: "Ammount <sup class='text-danger'>*<sup>",  
					name: "fprivtd.ammount",
					type: "readonly"
				},
				{
					
					label: "Rencana Bayar",
					name: "fprivtd.rencana_bayar",
				},
				{
					
					label: "Sisa",
					name: "fprivtd.sisa",
					type: "readonly"
				},
			]
		} );

		edtfprivtd.field('fprivtd.tanggal').disable()
		edtfprivtd.field('fprivtd.tanggal_jatuh_tempo').disable()

		//masking
		unmask_fprivtd = maskingNumber(
			edtfprivtd,
			"fprivtd",
			[
				"ammount",
				"rencana_bayar",
				"sisa"
			],
			0, // digit belakang koma
			0, // validasiNumber
			'>=' // val >= 0
		);
			
		edtfprivtd.on( 'preOpen', function( e, mode, action ) {
			edtfprivtd.field('fprivtd.id_fprxxth').val(id_fprxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfprivtd.field('fprivtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblfprivtd.rows().deselect();
			}
		});

		edtfprivtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtfprivtd.dependent( 'fprivtd.id_pivxxth', function ( val, data, callback ) {
			if (val > 0 && id_pivxxth_old == 0 || id_pivxxth_old != val) {
				autofillField('pivxxth', val, 'DATE_FORMAT(tanggal, "%d %b %Y") AS tanggal,DATE_FORMAT(tanggal_jatuh_tempo, "%d %b %Y") AS tanggal_jatuh_tempo,selisih_bayar')
				tanggal = autofillData.tanggal;
				tanggal_jatuh_tempo = autofillData.tanggal_jatuh_tempo;
				ammount = autofillData.selisih_bayar;
				edtfprivtd.field('fprivtd.tanggal').val(tanggal);
				edtfprivtd.field('fprivtd.tanggal_jatuh_tempo').val(tanggal_jatuh_tempo);
				edtfprivtd.field('fprivtd.ammount').val(ammount);
			}
			return {}
		}, {event: 'keyup change'});
		
		edtfprivtd.dependent( 'fprivtd.ammount', function ( val, data, callback ) {
			ammount = parseFloat(edtfprivtd.field('fprivtd.ammount').input().inputmask('unmaskedvalue'));
			rencana_bayar = parseFloat(edtfprivtd.field('fprivtd.rencana_bayar').input().inputmask('unmaskedvalue'));
			sisa = ammount - rencana_bayar;
			edtfprivtd.field('fprivtd.sisa').val(sisa);
			
			return {}
		}, {event: 'keyup change'});
		
		edtfprivtd.dependent( 'fprivtd.rencana_bayar', function ( val, data, callback ) {
			ammount = parseFloat(edtfprivtd.field('fprivtd.ammount').input().inputmask('unmaskedvalue'));
			rencana_bayar = parseFloat(edtfprivtd.field('fprivtd.rencana_bayar').input().inputmask('unmaskedvalue'));
			sisa = ammount - rencana_bayar;
			edtfprivtd.field('fprivtd.sisa').val(sisa);
			
			return {}
		}, {event: 'keyup change'});

		edtfprivtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_pivxxth = edtfprivtd.field('fprivtd.id_pivxxth').val();

				validasiRequired(
					edtfprivtd,
					'fprivtd',
					{
						'id_pivxxth': id_pivxxth,
					}
				);

				console.log(id_fprxxth);
				

				validasiUnique(
					action,
					edtfprivtd,
					'fprivtd',
					'id_pivxxth',
					'id_pivxxth,id_fprxxth',
					id_pivxxth+","+id_fprxxth,
					id_fprivtd
				);	
			}
			
			if ( edtfprivtd.inError() ) {
				return false;
			}
		});

		edtfprivtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfprivtd.field('fprivtd.finish_at').val(finish_at);
		});
			
		edtfprivtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblfprxxth.rows().deselect();
			tblfprxxth.ajax.reload(null, false);
		} );

		edtfprivtd.on( 'close', function () {
			edtfprivtd.enable();
		} );
		
		tblfprivtd = $('#tblfprivtd').DataTable( {
			ajax: {
				url: "../../models/fprxxth/fprivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fprivtd = show_deleted_fprivtd;
					d.id_fprxxth = id_fprxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "fprivtd.id",visible:false },
				{ data: "fprivtd.id_fprxxth",visible:false },
				{ data: "pivxxth.kode" },
				{ data: "fprivtd.tanggal" },
				{ data: "fprivtd.tanggal_jatuh_tempo" },
				{ data: "fprivtd.ammount", ...renderNumber() },
				{ data: "fprivtd.rencana_bayar", ...renderNumber() },
				{ data: "fprivtd.sisa", ...renderNumber() },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fprivtd';
					$table       = 'tblfprivtd';
					$edt         = 'edtfprivtd';
					$show_status = '_fprivtd';
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

		tblfprivtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblfprivtd, 1 );
			CekDrawDetailHDFinal(tblfprxxth);
		} );

		tblfprivtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('fprivtd');
			id_pivxxth_old = fprivtd_data.id_pivxxth;
			
			// atur hak akses
			CekSelectDetailHD( tblfprivtd );
		} );

		tblfprivtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('fprivtd');
			id_pivxxth_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblfprivtd );
		} );
		// END fprivtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblfprxxth.rows().deselect();
				tblfprxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFfprxxth').modal('toggle');
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
