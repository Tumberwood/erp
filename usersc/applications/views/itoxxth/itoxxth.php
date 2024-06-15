<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'itoxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'itoittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

					<div class="modal" id="modalSFitoxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
										<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
										<button class="btn btn-primary" type="submit" id="go">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>

                    <table id="tblitoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>TX</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                    </table>
                
            </div>
        </div>
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabitoittd_1"> Items</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabitoittd_1" class="tab-pane active">
					<div class="panel-body">
						
							<table id="tblitoittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_itoxxth</th>
										<th>SKU</th>
										<th>Item</th>
										<th>Quantity</th>
										<th>UoM</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th id="c_items"></th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
								</tfoot>
							</table>

					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/itoxxth/fn/itoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtitoxxth, tblitoxxth, show_deleted_itoxxth = 0, id_itoxxth;
	var edtitoittd, tblitoittd, show_deleted_itoittd = 0, id_itoittd;
	// ------------- end of default variable

	var is_need_generate_kode = 1, is_need_inventory = 1;
	var id_iwhxxmh_asal_old = 0, id_iwhxxmh_tujuan_old = 0;
	
	var id_iimxxmh = 0, id_iumxxmh_unit_old = 0, id_iimxxmh_old = 0;

	// get tableRelation
	tableRelation('itoxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN itoxxth
		edtitoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/itoxxth/itoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoxxth = show_deleted_itoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblitoxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "itoxxth.start_at",
					name: "itoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "itoxxth.finish_at",
					name: "itoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "itoxxth",
					type: "hidden"
				},	
				{
					label: "itoxxth.transaction_state",
					name: "itoxxth.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "itoxxth.tanggal",
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
					label: "Warehouse Asal <sup class='text-danger'>*<sup>",
					name: "itoxxth.id_iwhxxmh_asal",
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
									id_iwhxxmh_old: id_iwhxxmh_asal_old,
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
					label: "Warehouse Tujuan <sup class='text-danger'>*<sup>",
					name: "itoxxth.id_iwhxxmh_tujuan",
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
									id_iwhxxmh_old: id_iwhxxmh_tujuan_old,
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
					label: "Keterangan",
					name: "itoxxth.keterangan",
					type: "textarea"
				}
			]
		} );		
		
		edtitoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitoxxth.field('itoxxth.start_at').val(start_at);

			if(action == 'create'){
				tblitoxxth.rows().deselect();
				edtitoxxth.field('kategori_dokumen').val('');
				edtitoxxth.field('kategori_dokumen_value').val('');
				edtitoxxth.field('field_tanggal').val('start_at');
			}
		});

		edtitoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtitoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi itoxxth.id_iwhxxmh_asal 
				id_iwhxxmh_asal = edtitoxxth.field('itoxxth.id_iwhxxmh_asal').val();
				id_iwhxxmh_tujuan = edtitoxxth.field('itoxxth.id_iwhxxmh_tujuan').val();

				if(!id_iwhxxmh_asal || id_iwhxxmh_asal == ''){
					edtitoxxth.field('itoxxth.id_iwhxxmh_asal').error( 'Wajib diisi!' );
				} else {
					validasiSameWH();
				}
				// END of validasi itoxxth.id_iwhxxmh_asal 

				// BEGIN of validasi itoxxth.id_iwhxxmh_tujuan 
				if(!id_iwhxxmh_tujuan || id_iwhxxmh_tujuan == ''){
					edtitoxxth.field('itoxxth.id_iwhxxmh_tujuan').error( 'Wajib diisi!' );
				} else {
					validasiSameWH();
				}
				// END of validasi itoxxth.id_iwhxxmh_tujuan 

				// BEGIN of validasi itoxxth.tanggal 
				tanggal = edtitoxxth.field('itoxxth.tanggal').val();
				if(!tanggal || tanggal == ''){
					edtitoxxth.field('itoxxth.tanggal').error( 'Wajib diisi!' );
				}
				// END of validasi itoxxth.tanggal
			}
			
			if ( edtitoxxth.inError() ) {
				return false;
			}
		});

		edtitoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitoxxth.field('itoxxth.finish_at').val(finish_at);
		});
		
		edtitoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtitoxxth.on( 'close', function () {
			edtitoxxth.enable();
		} );
		
		tblitoxxth = $('#tblitoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-6',
			},
			ajax: {
				url: "../../models/itoxxth/itoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoxxth = show_deleted_itoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
			// orderFixed: [1, 'asc'],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4,5,6]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "itoxxth.id",visible:false },
				{ data: "itoxxth.tanggal" },
				{ data: "itoxxth.kode" },
				{ data: "iwhxxmh_asal.nama" },
				{ data: "iwhxxmh_tujuan.nama" },
				{ 
					data: "itoxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "itoxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_itoxxth';
					$table       = 'tblitoxxth';
					$edt         = 'edtitoxxth';
					$show_status = '_itoxxth';
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
				if ( data.itoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.itoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblitoxxth.searchPanes.container().appendTo('#spitoxxth');
		tblitoxxth.searchBuilder.container().appendTo( '#sbitoxxth' );
		
		tblitoxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblitoittd];
			CekInitHeaderHD(tblitoxxth, tbl_details);
		} );
		
		tblitoxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('itoxxth');
			id_iwhxxmh_asal_old   = itoxxth_data.id_iwhxxmh_asal;
			id_iwhxxmh_tujuan_old = itoxxth_data.id_iwhxxmh_tujuan;
			
			// atur hak akses
			tbl_details = [tblitoittd];
			CekSelectHeaderHD(tblitoxxth, tbl_details);

		} );
		
		tblitoxxth.on( 'deselect', function () {
			siVarReset('itoxxth');
			id_iwhxxmh_tujuan_old = 0;
			id_iwhxxmh_asal_old = 0;

			// atur hak akses
			tbl_details = [tblitoittd];
			CekDeselectHeaderHD(tblitoxxth, tbl_details);
		} );

		// END itoxxth
		
		// BEGIN itoittd
		edtitoittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/itoxxth/itoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoittd = show_deleted_itoittd;
					d.id_itoxxth = id_itoxxth;
				}
			},
			table: "#tblitoittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "itoittd.start_at",
					name: "itoittd.start_at",
					type: "hidden"
				},	
				{
					label: "itoittd.finish_at",
					name: "itoittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "itoittd",
					type: "hidden"
				},	
				{
					label: "itoittd.transaction_state",
					name: "itoittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_itoxxth",
					name: "itoittd.id_itoxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "itoittd.id_iimxxmh",
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
									ids_iitxxmh: 1,
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
					name: "itoittd.id_iumxxmh_unit",
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
					name: "itoittd.jumlah_unit"
				}, 	
				{
					label: "Keterangan",
					name: "itoittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtitoittd.field('itoittd.jumlah_unit').input().addClass('text-right');

		edtitoittd.on( 'preOpen', function( e, mode, action ) {
			edtitoittd.field('itoittd.id_itoxxth').val(id_itoxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitoittd.field('itoittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblitoittd.rows().deselect();
			}
		});

		edtitoittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtitoittd.dependent( 'itoittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtitoittd.field('itoittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});
		
		edtitoittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_iimxxmh = edtitoittd.field('itoittd.id_iimxxmh').val();
				if(!id_iimxxmh || id_iimxxmh == ''){
					edtitoittd.field('itoittd.id_iimxxmh').error( 'Wajib diisi!' );
				}
				
				id_iumxxmh = edtitoittd.field('itoittd.id_iumxxmh_unit').val();
				if(!id_iumxxmh || id_iumxxmh == ''){
					edtitoittd.field('itoittd.id_iumxxmh_unit').error( 'Wajib diisi!' );
				}
				
				jumlah_unit = edtitoittd.field('itoittd.jumlah_unit').val();
				if(!jumlah_unit || jumlah_unit == ''){
					edtitoittd.field('itoittd.jumlah_unit').error( 'Wajib diisi!' );
				}

				// validasi min atau max angka
				if(jumlah_unit <= 0 ){
					edtitoittd.field('itoittd.jumlah_unit').error( 'Inputan harus > 0' );
				}
				
				// validasi angka
				if(isNaN(jumlah_unit) ){
					edtitoittd.field('itoittd.jumlah_unit').error( 'Inputan harus berupa Angka!' );
				}
			}
			
			if ( edtitoittd.inError() ) {
				return false;
			}
		});

		edtitoittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitoittd.field('itoittd.finish_at').val(finish_at);
		});
			
		edtitoittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblitoxxth.ajax.reload(null, false);
			tblitoittd.ajax.reload(null, false);
		} );

		edtitoittd.on( 'close', function () {
			edtitoittd.enable();
		} );
		
		tblitoittd = $('#tblitoittd').DataTable( {
			ajax: {
				url: "../../models/itoxxth/itoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoittd = show_deleted_itoittd;
					d.id_itoxxth = id_itoxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "itoittd.id",visible:false },
				{ data: "itoittd.id_itoxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "itoittd.jumlah_unit",
					...renderNumber(0)
				},
				{ data: "iumxxmh_unit.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_itoittd';
					$table       = 'tblitoittd';
					$edt         = 'edtitoittd';
					$show_status = '_itoittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2		= [];
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
				var api       = this.api(), data;
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display;
				var c_items = api.column(0).data().count();
				$( '#c_items' ).html( numFormat("Total Item(s): " + c_items) );
			},
		} );

		tblitoittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblitoittd, 1 );
			CekDrawDetailHDFinal(tblitoxxth);
		} );

		tblitoittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('itoittd');
			id_iimxxmh_old      = itoittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = itoittd_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblitoittd );
		} );

		tblitoittd.on( 'deselect', function() {
			siVarResetD('itoittd');
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblitoittd );
		} );
		// END itoittd

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
				tblitoxxth.rows().deselect();
				tblitoxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFitoxxth').modal('toggle');
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
