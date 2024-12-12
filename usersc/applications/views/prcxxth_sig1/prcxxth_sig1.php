<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'prcxxth_sig1';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'prcittd_sig1';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFprcxxth_sig1" tabindex="-1" role="dialog" aria-hidden="true">
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

				<div id="frmprcxxth_sig1">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.id_imtxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.id_grlxxmh_supplier"></editor-field>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.surat_jalan"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.referensi"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.plat_nomor"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.supir_nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="prcxxth_sig1.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblprcxxth_sig1" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
                                <th>Type</th>
								<th>Supplier</th>
								<th>Warehouse</th>
								<th>TX</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabprcittd_sig1"> Items</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabprcittd_sig1" class="tab-pane active">
					<div class="panel-body">
						<div id="frmprcittd_sig1">
							<div class="panel-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd_sig1.id_iimxxmh"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd_sig1.jumlah_unit"></editor-field>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd_sig1.id_iumxxmh_unit"></editor-field>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										<editor-field name="prcittd_sig1.keterangan"></editor-field>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="tblprcittd_sig1" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_prcxxth_sig1</th>
										<th>SKU</th>
										<th>Item</th>
										<th>Quantity</th>
										<th>UoM</th>
									</tr>
								</thead>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prcxxth_sig1/fn/prcxxth_sig1_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtprcxxth_sig1, tblprcxxth_sig1, show_deleted_prcxxth_sig1 = 0, id_prcxxth_sig1;
	var edtprcittd_sig1, tblprcittd_sig1, show_deleted_prcittd_sig1 = 0, id_prcittd_sig1;
	// ------------- end of default variable

	var id_iitxxmh = 0, id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_iwhxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, id_imtxxmh_old = 0;

	// get tableRelation
	tableRelation('prcxxth_sig1');

	// console.log(is_master_table);

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN prcxxth_sig1
		edtprcxxth_sig1 = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth_sig1/prcxxth_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth_sig1 = show_deleted_prcxxth_sig1;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmprcxxth_sig1",
			table: "#tblprcxxth_sig1",
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
					label: "prcxxth_sig1.start_at",
					name: "prcxxth_sig1.start_at",
					type: "hidden"
				},	
				{
					label: "prcxxth_sig1.finish_at",
					name: "prcxxth_sig1.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcxxth_sig1",
					type: "hidden"
				},	
				{
					label: "prcxxth_sig1.transaction_state",
					name: "prcxxth_sig1.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "prcxxth_sig1.tanggal",
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
					name: "prcxxth_sig1.id_grlxxmh_supplier",
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
					label: "Transaction Type <sup class='text-danger'>*<sup>",
					name: "prcxxth_sig1.id_imtxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/imtxxmh/imtxxmh_fn_opt_sig1.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_imtxxmh_old: id_imtxxmh_old,
									movement_type_group: ['GR'],
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
					label: "prcxxth_sig1.id_iitxxmh",
					name: "prcxxth_sig1.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "prcxxth_sig1.id_fpytmmh",
					name: "prcxxth_sig1.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "prcxxth_sig1.id_fcrxxmh",
					name: "prcxxth_sig1.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "prcxxth_sig1.is_pajak",
					name: "prcxxth_sig1.is_pajak",
					type: "hidden"
				},
				{
					label: "prcxxth_sig1.pajak_jenis",
					name: "prcxxth_sig1.pajak_jenis",
					type: "hidden"
				},
				{
					label: "prcxxth_sig1.pajak_in_ex",
					name: "prcxxth_sig1.pajak_in_ex",
					type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "prcxxth_sig1.id_iwhxxmh",
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
					label: "Surat Jalan <sup class='text-danger'>*<sup>",
					name: "prcxxth_sig1.surat_jalan",
					fieldInfo: "Nomor surat jalan pengirim"
				},
				{
					label: "Supir",
					name: "prcxxth_sig1.supir_nama"
				},
				{
					label: "Plat Nomor",
					name: "prcxxth_sig1.plat_nomor"
				},
				{
					label: "Referensi <sup class='text-danger'>*<sup>",
					name: "prcxxth_sig1.referensi",
					fieldInfo: "Nomor referensi, misal Purchase Order"
				},
				{
					label: "Keterangan",
					name: "prcxxth_sig1.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtprcxxth_sig1.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcxxth_sig1.field('prcxxth_sig1.start_at').val(start_at);

			if(action == 'create'){
				tblprcxxth_sig1.rows().deselect();
			}
		});

		edtprcxxth_sig1.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});
		
		edtprcxxth_sig1.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal             = edtprcxxth_sig1.field('prcxxth_sig1.tanggal').val();
				id_iwhxxmh          = edtprcxxth_sig1.field('prcxxth_sig1.id_iwhxxmh').val();
				id_imtxxmh          = edtprcxxth_sig1.field('prcxxth_sig1.id_imtxxmh').val();
				id_grlxxmh_supplier = edtprcxxth_sig1.field('prcxxth_sig1.id_grlxxmh_supplier').val();
				surat_jalan         = edtprcxxth_sig1.field('prcxxth_sig1.surat_jalan').val();
				referensi           = edtprcxxth_sig1.field('prcxxth_sig1.referensi').val();

				validasiRequired(
					edtprcxxth_sig1, 
					"prcxxth_sig1", 
					{
						"tanggal"            : tanggal,
						"id_grlxxmh_supplier": id_grlxxmh_supplier,
						"id_iwhxxmh"         : id_iwhxxmh,
						"id_imtxxmh"         : id_imtxxmh,
						"surat_jalan"        : surat_jalan,
						"referensi"          : referensi,
					}
				);

			}
			
			if ( edtprcxxth_sig1.inError() ) {
				return false;
			}
		});

		edtprcxxth_sig1.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcxxth_sig1.field('prcxxth_sig1.finish_at').val(finish_at);
		});
		
		edtprcxxth_sig1.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtprcxxth_sig1.on( 'close', function () {
			edtprcxxth_sig1.enable();
		} );
		
		tblprcxxth_sig1 = $('#tblprcxxth_sig1').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/prcxxth_sig1/prcxxth_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth_sig1 = show_deleted_prcxxth_sig1;
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
				{ data: "prcxxth_sig1.id",visible:false },
				{ data: "prcxxth_sig1.tanggal" },
				{ data: "prcxxth_sig1.kode" },
				{ data: "imtxxmh.movement_type" },
				{ data: "grlxxmh.nama" },
				{ data: "iwhxxmh.nama" },
				{ 
					data: "prcxxth_sig1.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcxxth_sig1';
					$table       = 'tblprcxxth_sig1';
					$edt         = 'edtprcxxth_sig1';
					$show_status = '_prcxxth_sig1';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.prcxxth_sig1.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prcxxth_sig1.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprcxxth_sig1.searchPanes.container().appendTo('#spprcxxth_sig1');
		tblprcxxth_sig1.searchBuilder.container().appendTo( '#sbprcxxth_sig1' );
		
		tblprcxxth_sig1.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblprcittd_sig1];
			CekInitHeaderHD(tblprcxxth_sig1, tbl_details);
		} );
		
		tblprcxxth_sig1.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prcxxth_sig1');
			id_grlxxmh_old      = prcxxth_sig1_data.id_grlxxmh_supplier;
			id_grlxxmh_supplier = prcxxth_sig1_data.id_grlxxmh_supplier;
			id_iwhxxmh_old      = prcxxth_sig1_data.id_iwhxxmh;
			id_imtxxmh_old      = prcxxth_sig1_data.id_imtxxmh;

			console.log(id_prcxxth_sig1);
			console.log(is_defaultprogram);
			
			// atur hak akses
			tbl_details = [tblprcittd_sig1];
			CekSelectHeaderHD(tblprcxxth_sig1, tbl_details);

		} );
		
		tblprcxxth_sig1.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('prcxxth_sig1');
			id_grlxxmh_old = 0, id_grlxxmh_supplier = 0, id_iwhxxmh_old = 0, id_imtxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblprcittd_sig1];
			CekDeselectHeaderHD(tblprcxxth_sig1, tbl_details);
		} );
		// END prcxxth_sig1

		// BEGIN prcittd_sig1
		edtprcittd_sig1 = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth_sig1/prcittd_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd_sig1 = show_deleted_prcittd_sig1;
					d.id_prcxxth_sig1 = id_prcxxth_sig1;
				}
			},
			table: "#tblprcittd_sig1",
			template: "#frmprcittd_sig1",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "prcittd_sig1.start_at",
					name: "prcittd_sig1.start_at",
					type: "hidden"
				},	
				{
					label: "prcittd_sig1.finish_at",
					name: "prcittd_sig1.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prcittd_sig1",
					type: "hidden"
				},	
				{
					label: "prcittd_sig1.transaction_state",
					name: "prcittd_sig1.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_prcxxth_sig1",
					name: "prcittd_sig1.id_prcxxth_sig1",
					type: "hidden"
				},	
				{
					label: "prcittd_sig1.harga_unit",
					name: "prcittd_sig1.harga_unit",
					type: "hidden"
				},
				{
					label: "prcittd_sig1.diskon_jenis",
					name: "prcittd_sig1.diskon_jenis",
					type: "hidden"
				},
				{
					label: "prcittd_sig1.diskon_persen",
					name: "prcittd_sig1.diskon_persen",
					type: "hidden"
				},
				{
					label: "prcittd_sig1.diskon_value",
					name: "prcittd_sig1.diskon_value",
					type: "hidden"
				},
				{
					label: "prcittd_sig1.diskon_final",
					name: "prcittd_sig1.diskon_final",
					type: "hidden"
				},
				{
					label: "prcittd_sig1.subtotal",
					name: "prcittd_sig1.subtotal",
					type: "hidden"
				},
				{
					label: "prcittd_sig1.dpp",
					name: "prcittd_sig1.dpp",
					type: "hidden"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "prcittd_sig1.id_iimxxmh",
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "prcittd_sig1.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "prcittd_sig1.id_iumxxmh_unit",
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
					label: "Keterangan",
					name: "prcittd_sig1.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtprcittd_sig1.on( 'preOpen', function( e, mode, action ) {
			edtprcittd_sig1.field('prcittd_sig1.id_prcxxth_sig1').val(id_prcxxth_sig1);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcittd_sig1.field('prcittd_sig1.start_at').val(start_at);
			
			if(action == 'create'){
				tblprcittd_sig1.rows().deselect();
			}
		});

		edtprcittd_sig1.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtprcittd_sig1.dependent( 'prcittd_sig1.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtprcittd_sig1.field('prcittd_sig1.id_iumxxmh_unit').input().val(null).trigger('change');
			return {}
		}, {event: 'keyup change'});

		edtprcittd_sig1.dependent( 'prcittd_sig1.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtprcittd_sig1, 'prcittd_sig1');
			return {}
		}, {event: 'keyup change'});
		
		edtprcittd_sig1.dependent( 'prcittd_sig1.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtprcittd_sig1, 'prcittd_sig1');
			return {}
		}, {event: 'keyup change'});
		
		edtprcittd_sig1.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_prcittd_sig1;
			}

			if(action != 'remove'){
				id_iimxxmh = edtprcittd_sig1.field('prcittd_sig1.id_iimxxmh').val();
				jumlah_unit = edtprcittd_sig1.field('prcittd_sig1.jumlah_unit').val();
				id_iumxxmh_unit = edtprcittd_sig1.field('prcittd_sig1.id_iumxxmh_unit').val();

				validasiRequired(
					edtprcittd_sig1,
					'prcittd_sig1',
					{
						'id_iimxxmh': id_iimxxmh,
						'jumlah_unit': jumlah_unit,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);
				
				validasiNumber(
					edtprcittd_sig1,
					'prcittd_sig1',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

			}
			
			if ( edtprcittd_sig1.inError() ) {
				return false;
			}
		});

		edtprcittd_sig1.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprcittd_sig1.field('prcittd_sig1.finish_at').val(finish_at);
		});
			
		edtprcittd_sig1.on( 'postSubmit', function (e, json, data, action, xhr) {

			tblprcxxth_sig1.ajax.reload(null, false);
			tblprcittd_sig1.rows().deselect();
			tblprcittd_sig1.ajax.reload(null, false);
		} );

		edtprcittd_sig1.on( 'close', function () {
			edtprcittd_sig1.enable();
		} );
		
		tblprcittd_sig1 = $('#tblprcittd_sig1').DataTable( {
			ajax: {
				url: "../../models/prcxxth_sig1/prcittd_sig1.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd_sig1 = show_deleted_prcittd_sig1;
					d.id_prcxxth_sig1 = id_prcxxth_sig1;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "prcittd_sig1.id",visible:false },
				{ data: "prcittd_sig1.id_prcxxth_sig1",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "prcittd_sig1.jumlah_unit",
					...renderNumber(0)
				},
				{ data: "iumxxmh_unit.kode" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcittd_sig1';
					$table       = 'tblprcittd_sig1';
					$edt         = 'edtprcittd_sig1';
					$show_status = '_prcittd_sig1';
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
			rowCallback: function( row, data, index ) {
			}
		} );

		tblprcittd_sig1.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblprcittd_sig1, 1 );
			CekDrawDetailHDFinal(tblprcxxth_sig1);
		} );

		tblprcittd_sig1.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('prcittd_sig1');
			id_iimxxmh_old = prcittd_sig1_data.id_iimxxmh;
			id_iumxxmh_unit_old = prcittd_sig1_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblprcittd_sig1 );
		} );

		tblprcittd_sig1.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('prcittd_sig1');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblprcittd_sig1 );
		} );
		// END prcittd_sig1

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblprcxxth_sig1.rows().deselect();
				tblprcxxth_sig1.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFprcxxth_sig1').modal('toggle');
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
