<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wdnxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wdnittd';
    $nama_tabels_d[1] = 'wdnlptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFwdnxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div id="frmwdnxxth">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.id_grlxxmh_customer"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.id_wdoxxth"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.id_grlxxmh_expedition"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.is_all_wh"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.id_iwhxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.supir_nama"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.mobil_nomor"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.no_container"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.no_seal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wdnxxth.keterangan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblwdnxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
								<th>Customer</th>
								<th>Expedition</th>
								<th>Delivery Order</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabwdnittd"> Item</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabwdnlptd"> Dispatch</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwdnittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwdnittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_wdnxxth</th>
										<th>SKU</th>
										<th>Item</th>
										<th>UoM</th>
										<th>Quantity</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabwdnlptd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwdnlptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th rowspan="2">ID</th>
										<th rowspan="2">id_wdnxxth</th>
										<th rowspan="2">Kode Dispatch</th>
										<th rowspan="2">LPN</th>
										<th rowspan="2">Item Code</th>
										<th rowspan="2">Item Name</th>
										<th colspan="2">Terkecil</th>
										<th colspan="2">Default</th>
										<th rowspan="2">Batch Number</th>
										<th rowspan="2">Expired Date</th>
									</tr>
									<tr>
										<th>Jumlah</th>
										<th>UoM</th>
										<th>Jumlah</th>
										<th>UoM</th>
									</tr>
								</thead>
								<tfoot>
									<th></th>
									<th></th>
									<th>Total</th>
									<th></th>
									<th></th>
									<th></th>
									<th id="s_6"></th>
									<th></th>
									<th id="s_8"></th>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdnxxth/fn/wdnxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwdnxxth, tblwdnxxth, show_deleted_wdnxxth = 0, id_wdnxxth;
	var edtwdnittd, tblwdnittd, show_deleted_wdnittd = 0, id_wdnittd;
	var edtwdnlptd, tblwdnlptd, show_deleted_wdnlptd = 0, id_wdnlptd;
	// ------------- end of default variable

	var id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_grlxxmh_expedition = 0, id_wdoxxth_old = 0, id_iwhxxmh_old = 0, id_wdoxxth = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_grlxxmh_expedition_old = 0, id_iumxxmh_unit_old = 0, id_wdplptd_old = 0;

	// get tableRelation
	tableRelation('wdnxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN wdnxxth
		edtwdnxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wdnxxth/wdnxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdnxxth = show_deleted_wdnxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmwdnxxth",
			table: "#tblwdnxxth",
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
					label: "wdnxxth.start_at",
					name: "wdnxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wdnxxth.finish_at",
					name: "wdnxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wdnxxth",
					type: "hidden"
				},	
				{
					label: "wdnxxth.transaction_state",
					name: "wdnxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "wdnxxth.tanggal",
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
					name: "wdnxxth.id_grlxxmh_customer",
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
					label: "Expedition <sup class='text-danger'>*<sup>",
					name: "wdnxxth.id_grlxxmh_expedition",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/grlxxmh/grlxxmh_expedition_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_expedition_old,
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
					label: "Delivery Order",
					name: "wdnxxth.id_wdoxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wdnxxth/wdnxxth_wdoxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_customer: id_grlxxmh_customer,
									id_wdoxxth_old: id_wdoxxth_old,
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
					label: "wdnxxth.id_iitxxmh",
					name: "wdnxxth.id_iitxxmh",
					type: "hidden"
				},

				{
					label: "wdnxxth.id_fpytmmh",
					name: "wdnxxth.id_fpytmmh",
					type: "hidden"
				},
				{
					label: "wdnxxth.id_fcrxxmh",
					name: "wdnxxth.id_fcrxxmh",
					type: "hidden"
				},
				{
					label: "wdnxxth.is_pajak",
					name: "wdnxxth.is_pajak",
					type: "hidden"
				},
				{
					label: "wdnxxth.pajak_jenis",
					name: "wdnxxth.pajak_jenis",
					type: "hidden"
				},
				{
					label: "wdnxxth.pajak_in_ex",
					name: "wdnxxth.pajak_in_ex",
					type: "hidden"
				},
				{
					label: "All WH",
					name: "wdnxxth.is_all_wh",
					type: "select",
					placeholder : "Select",
					def:1,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
					name: "wdnxxth.id_iwhxxmh",
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
					label: "Supir <sup class='text-danger'>*<sup>",
					name: "wdnxxth.supir_nama"
				},
				{
					label: "Nomor Kendaraan <sup class='text-danger'>*<sup>",
					name: "wdnxxth.mobil_nomor"
				},
				{
					label: "No Container",
					name: "wdnxxth.no_container"
				},
				{
					label: "No Seal",
					name: "wdnxxth.no_seal"
				},
				{
					label: "Keterangan",
					name: "wdnxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtwdnxxth.field('wdnxxth.id_iwhxxmh').hide();

		edtwdnxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdnxxth.field('wdnxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwdnxxth.rows().deselect();
			}
		});

		edtwdnxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtwdnxxth.dependent( 'wdnxxth.is_all_wh', function ( val, data, callback ) {
			if (val == 1) {
				edtwdnxxth.field('wdnxxth.id_iwhxxmh').hide();
			} else {
				edtwdnxxth.field('wdnxxth.id_iwhxxmh').show();
			}
			return {}
		}, {event: 'keyup change'});

		edtwdnxxth.dependent( 'wdnxxth.id_grlxxmh_customer', function ( val, data, callback ) {
			edtwdnxxth.field('wdnxxth.id_wdoxxth').input().val(null).trigger('change');
			id_grlxxmh_customer = val;
			return {}
		}, {event: 'keyup change'});
		
		edtwdnxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal         = edtwdnxxth.field('wdnxxth.tanggal').val();
				id_iwhxxmh      = edtwdnxxth.field('wdnxxth.id_iwhxxmh').val();
				id_grlxxmh_customer      = edtwdnxxth.field('wdnxxth.id_grlxxmh_customer').val();
				id_grlxxmh_expedition      = edtwdnxxth.field('wdnxxth.id_grlxxmh_expedition').val();
				id_wdoxxth      = edtwdnxxth.field('wdnxxth.id_wdoxxth').val();
				mobil_nomor      = edtwdnxxth.field('wdnxxth.mobil_nomor').val();
				supir_nama      = edtwdnxxth.field('wdnxxth.supir_nama').val();
				is_all_wh      = edtwdnxxth.field('wdnxxth.is_all_wh').val();

				validasiRequired(
					edtwdnxxth, 
					"wdnxxth", 
					{
						"tanggal": tanggal, 
						// "id_iwhxxmh": id_iwhxxmh, 
						"id_grlxxmh_customer": id_grlxxmh_customer,
						"id_grlxxmh_expedition": id_grlxxmh_expedition,
						"id_wdoxxth": id_wdoxxth,
						"mobil_nomor": mobil_nomor,
						"supir_nama": supir_nama,
					}
				);

				if (is_all_wh == 0) {
					
					validasiRequired(
						edtwdnxxth,
						'wdnxxth',
						{
							'id_iwhxxmh': id_iwhxxmh,
						}
					);
				}

			}
			
			if ( edtwdnxxth.inError() ) {
				return false;
			}
		});

		edtwdnxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdnxxth.field('wdnxxth.finish_at').val(finish_at);
		});
		
		edtwdnxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblwdnxxth.ajax.reload(null, false);
			tblwdnittd.ajax.reload(null, false);
			tblwdnlptd.ajax.reload(null, false);
			// tblwdnxxth.rows().deselect();
		} );

		edtwdnxxth.on( 'close', function () {
			edtwdnxxth.enable();
		} );
		
		tblwdnxxth = $('#tblwdnxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wdnxxth/wdnxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdnxxth = show_deleted_wdnxxth;
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
				{ data: "wdnxxth.id",visible:false },
				{ data: "wdnxxth.tanggal" },
				{ data: "wdnxxth.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "expedisi.nama" },
				{ data: "wdoxxth.kode" },
				{ data: "iwhxxmh.nama" },
				{ 
					data: "wdnxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wdnxxth';
					$table       = 'tblwdnxxth';
					$edt         = 'edtwdnxxth';
					$show_status = '_wdnxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					// $arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{ 
					text: '<i class="fa fa-save"></i>&nbsp;Confirm',
					name: 'btnConfirm',
					className: 'btn btn-sm',
					titleAttr: 'Confirm',
					action: function ( e, dt, node, config ) {
						console.log(id_wdoxxth);
						// jika draft akan dikonfirmasi
						notifConfirm();
						console.log(pesan);
						message_transaction_state = pesan +'\n \nAnda yakin ingin melakukan confirm?';
						
						swal({
							text: message_transaction_state,
							icon: "info",
							buttons: {
								cancel: true,
								confirm: true
							},
						})
						.then((willConfirm) => {
							if (willConfirm) {
								if (pesan_retur != '') {
									swal({
										text: 'List barang yang akan masuk ke lokasi return: \n \n'+pesan_retur,
										icon: "info",
										buttons: {
											cancel: true,
											confirm: true
										},
									})
									.then((willConfirm) => {
										if (willConfirm) {
											fnConfirm('<?php echo $table_name;?>', <?php echo $table;?> );
										}
									});
								} else {
									fnConfirm('<?php echo $table_name;?>', <?php echo $table;?> );
								}
							}
						});

						

					}
				},
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrintDN',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Delivery Note',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('wdnxxth_print.php?id_transaksi='+id_wdnxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wdnxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wdnxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwdnxxth.searchPanes.container().appendTo('#spwdnxxth');
		tblwdnxxth.searchBuilder.container().appendTo( '#sbwdnxxth' );

		
		// tblwdnxxth.buttons().container().on('click', 'button[name="btnCreate"]', function() {
		// 	console.log('123');
		// 	// Add more functionality here if needed
		// });
		
		tblwdnxxth.button('btnPrintDN:name')
				.nodes()
				.css( 'display', 'none' );

		tblwdnxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwdnittd, tblwdnlptd];
			CekInitHeaderHD(tblwdnxxth, tbl_details);
			tblwdnxxth.button('btnPrintDN:name')
				.nodes()
				.css( 'display', 'none' );
		} );
		
		tblwdnxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wdnxxth');
			id_grlxxmh_old      = wdnxxth_data.id_grlxxmh_customer;
			id_grlxxmh_customer = wdnxxth_data.id_grlxxmh_customer;
			id_grlxxmh_expedition_old = wdnxxth_data.id_grlxxmh_expedition;
			id_wdoxxth_old      = wdnxxth_data.id_wdoxxth;
			id_wdoxxth          = wdnxxth_data.id_wdoxxth;
			id_iwhxxmh_old      = wdnxxth_data.id_iwhxxmh;
			console.log(id_wdoxxth);
			
			// atur hak akses
			tbl_details = [tblwdnittd, tblwdnlptd];
			CekSelectHeaderHD(tblwdnxxth, tbl_details);

			if (transaction_state != 0) {
				tblwdnxxth.button('btnPrintDN:name')
					.nodes()
					.css( 'display', 'block' );
			} else {
				tblwdnxxth.button('btnPrintDN:name')
					.nodes()
					.css( 'display', 'none' );					
			}
		} );
		
		tblwdnxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wdnxxth');
			id_grlxxmh_old = 0, id_grlxxmh_customer = 0, id_wdoxxth_old = 0, id_iwhxxmh_old = 0, id_wdoxxth = 0;
			id_grlxxmh_expedition_old = 0;
			// atur hak akses
			tbl_details = [tblwdnittd, tblwdnlptd];
			CekDeselectHeaderHD(tblwdnxxth, tbl_details);
			tblwdnxxth.button('btnPrintDN:name')
				.nodes()
				.css( 'display', 'none' );
		} );
		// END wdnxxth

		// BEGIN wdnittd
		edtwdnittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wdnxxth/wdnittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdnittd = show_deleted_wdnittd;
					d.id_wdnxxth = id_wdnxxth;
				}
			},
			table: "#tblwdnittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "wdnittd.start_at",
					name: "wdnittd.start_at",
					type: "hidden"
				},	
				{
					label: "wdnittd.finish_at",
					name: "wdnittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wdnittd",
					type: "hidden"
				},	
				{
					label: "wdnittd.transaction_state",
					name: "wdnittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wdnxxth",
					name: "wdnittd.id_wdnxxth",
					type: "hidden"
				},	
				{
					label: "wdnittd.id_wdoxxth",
					name: "wdnittd.id_wdoxxth",
					// type: "hidden"
				},
				{
					label: "wdnittd.harga_unit",
					name: "wdnittd.harga_unit",
					// type: "hidden"
				},
				{
					label: "wdnittd.diskon_jenis",
					name: "wdnittd.diskon_jenis",
					// type: "hidden"
				},
				{
					label: "wdnittd.diskon_persen",
					name: "wdnittd.diskon_persen",
					// type: "hidden"
				},
				{
					label: "wdnittd.diskon_value",
					name: "wdnittd.diskon_value",
					// type: "hidden"
				},
				{
					label: "wdnittd.diskon_final",
					name: "wdnittd.diskon_final",
					// type: "hidden"
				},
				{
					label: "wdnittd.subtotal",
					name: "wdnittd.subtotal",
					// type: "hidden"
				},
				{
					label: "wdnittd.dpp",
					name: "wdnittd.dpp",
					// type: "hidden"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wdnittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wdnxxth/wdnittd_iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									id_wdoxxth: id_wdoxxth,
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
					name: "wdnittd.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wdnittd.id_iumxxmh_unit",
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
					name: "wdnittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtwdnittd.on( 'preOpen', function( e, mode, action ) {
			edtwdnittd.field('wdnittd.id_wdnxxth').val(id_wdnxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdnittd.field('wdnittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwdnittd.rows().deselect();
			}
		});

		edtwdnittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtwdnittd.dependent( 'wdnittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = val;
			edtwdnittd.field('wdnittd.id_iumxxmh_unit').input().val(null).trigger('change');
			wdnittd_fn_wdplptd(id_wdoxxth,id_iimxxmh)
			return {}
		}, {event: 'keyup change'});

		edtwdnittd.dependent( 'wdnittd.harga_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtwdnittd, 'wdnittd');
			hitungDpp(edtwdnittd, 'wdnittd');
			return {}
		}, {event: 'keyup change'});
		
		edtwdnittd.dependent( 'wdnittd.jumlah_unit', function ( val, data, callback ) {
			hitungSubtotalDetail(edtwdnittd, 'wdnittd');
			hitungDpp(edtwdnittd, 'wdnittd');

			return {}
		}, {event: 'keyup change'});

		edtwdnittd.dependent( 'wdnittd.diskon_jenis', function ( val, data, callback ) {
			hitungDiskon(edtwdnittd, 'wdnittd');
			hitungDpp(edtwdnittd, 'wdnittd');
			return {}
		}, {event: 'keyup change'});
		
		edtwdnittd.dependent( 'wdnittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtwdnittd, 'wdnittd');
				hitungDpp(edtwdnittd, 'wdnittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtwdnittd.dependent( 'wdnittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtwdnittd, 'wdnittd');
				hitungDpp(edtwdnittd, 'wdnittd');
			}
			return {}
		}, {event: 'keyup'});
		
		edtwdnittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_wdnittd;
			}

			if(action != 'remove'){
				id_iimxxmh = edtwdnittd.field('wdnittd.id_iimxxmh').val();
				jumlah_unit = edtwdnittd.field('wdnittd.jumlah_unit').val();
				id_iumxxmh_unit = edtwdnittd.field('wdnittd.id_iumxxmh_unit').val();

				validasiRequired(
					edtwdnittd,
					'wdnittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'jumlah_unit': jumlah_unit,
						'id_iumxxmh_unit': id_iumxxmh_unit
					}
				);
				
				validasiNumber(
					edtwdnittd,
					'wdnittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);
			}
			
			if ( edtwdnittd.inError() ) {
				return false;
			}
		});

		edtwdnittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdnittd.field('wdnittd.finish_at').val(finish_at);
		});
			
		edtwdnittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			hitungSubtotalHeader(id_transaksi_h, 'wdnittd', 'wdnxxth');
			hitungHeaderDetail('wdnxxth', 'wdnittd', id_transaksi_h);

			tblwdnxxth.ajax.reload(null, false);
			tblwdnittd.rows().deselect();
			tblwdnittd.ajax.reload(null, false);
		} );

		edtwdnittd.on( 'close', function () {
			edtwdnittd.enable();
		} );
		
		tblwdnittd = $('#tblwdnittd').DataTable( {
			ajax: {
				url: "../../models/wdnxxth/wdnittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdnittd = show_deleted_wdnittd;
					d.id_wdnxxth = id_wdnxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "wdnittd.id",visible:false },
				{ data: "wdnittd.id_wdnxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.kode" },
				{ 
					data: "wdnittd.jumlah_unit",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wdnittd';
					$table       = 'tblwdnittd';
					$edt         = 'edtwdnittd';
					$show_status = '_wdnittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblwdnittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwdnittd, 1 );
			CekDrawDetailHDFinal(tblwdnxxth);
		} );

		tblwdnittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wdnittd');
			id_iimxxmh_old = wdnittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wdnittd_data.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD( tblwdnittd );
		} );

		tblwdnittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wdnittd');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwdnittd );
		} );
		// END wdnittd

		edtwdnlptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wdnxxth/wdnlptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdnlptd = show_deleted_wdnlptd;
					d.id_wdnxxth = id_wdnxxth;
				}
			},
			table: "#tblwdnlptd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "wdnlptd.start_at",
					name: "wdnlptd.start_at",
					type: "hidden"
				},	
				{
					label: "wdnlptd.finish_at",
					name: "wdnlptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wdnlptd",
					type: "hidden"
				},	
				{
					label: "wdnlptd.transaction_state",
					name: "wdnlptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wdnxxth",
					name: "wdnlptd.id_wdnxxth",
					type: "hidden"
				},			
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wdnlptd.id_wdplptd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_wdpxxth.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wdplptd_old: id_wdplptd_old,
									id_wdoxxth: id_wdoxxth,
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
					label: "id_iimxxmh",
					name: "wdnlptd.id_iimxxmh",
					type: "hidden"
				},	
				{
					label: "id_wdoittd",
					name: "wdnlptd.id_wdoittd",
					type: "hidden"
				},		
				{
					label: "LPN",
					name: "wdnlptd.wlpxxmh_kode",
					type: "readonly"
				},		
				{
					label: "Expired Date",
					name: "wdnlptd.expired_date",
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
					label: "Batch Number",
					name: "wdnlptd.batch_number",
					type: "readonly"
				},	
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wdnlptd.id_iumxxmh_unit",
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
					name: "wdnlptd.jumlah_unit"
				},
				{
					label: "Keterangan",
					name: "wdnlptd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtwdnlptd.on( 'preOpen', function( e, mode, action ) {
			edtwdnlptd.field('wdnlptd.id_wdnxxth').val(id_wdnxxth);
			edtwdnlptd.field('wdnlptd.expired_date').disable();
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdnlptd.field('wdnlptd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwdnlptd.rows().deselect();
			}
		});

		edtwdnlptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtwdnlptd.dependent( 'wdnlptd.id_wdplptd', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('wdplptd', val, 'id_iimxxmh, id_wdoittd, wlpxxmh_kode, expired_date, batch_number');
				id_iimxxmh = autofillData.id_iimxxmh;
				edtwdnlptd.field('wdnlptd.id_iimxxmh').val(id_iimxxmh);
				edtwdnlptd.field('wdnlptd.id_wdoittd').val(autofillData.id_wdoittd);
				edtwdnlptd.field('wdnlptd.wlpxxmh_kode').val(autofillData.wlpxxmh_kode);
				edtwdnlptd.field('wdnlptd.expired_date').val(moment(autofillData.expired_date).format('DD MMM YYYY'));
				edtwdnlptd.field('wdnlptd.batch_number').val(autofillData.batch_number);
			}
			return {}
		}, {event: 'keyup change'});

		edtwdnlptd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_wdnlptd;
			}
			
			if(action != 'remove'){
				
				id_iumxxmh_unit = edtwdnlptd.field('wdnlptd.id_iumxxmh_unit').val();
				id_wdplptd      = edtwdnlptd.field('wdnlptd.id_wdplptd').val();
				jumlah_unit     = edtwdnlptd.field('wdnlptd.jumlah_unit').val();

				validasiRequired(
					edtwdnlptd,
					'wdnlptd',
					{
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_wdplptd': id_wdplptd,
					}
				);
				
				validasiNumber(
					edtwdnlptd,
					'wdnlptd',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);

				validasiOutstandingNew(
					edtwdnlptd, 'wdnlptd', id_transaksi, id_wdplptd, 'wdplptd'
				);
				
			}
			
			if ( edtwdnlptd.inError() ) {
				return false;
			}
		});

		edtwdnlptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwdnlptd.field('wdnlptd.finish_at').val(finish_at);
		});
			
		edtwdnlptd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				// id_transaksi = json.data[0].wdnlptd.id;
            	// konversiUom('wdnlptd', id_transaksi );

				tblwdnlptd.rows().deselect();
			}
			
			tblwdnxxth.ajax.reload(null, false);
			tblwdnittd.ajax.reload(null, false);
			tblwdnlptd.ajax.reload(null, false);
		} );

		tblwdnlptd = $('#tblwdnlptd').DataTable( {
			ajax: {
				url: "../../models/wdnxxth/wdnlptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wdnlptd = show_deleted_wdnlptd;
					d.id_wdnxxth = id_wdnxxth;
				}
			},
			responsive: false,
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "wdnlptd.id",visible:false },
				{ data: "wdnlptd.id_wdnxxth",visible:false },
				{ data: "wdplptd.kode" },
				{ data: "wdnlptd.wlpxxmh_kode" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "wdnlptd.jumlah_terkecil",
					...renderNumber( 0, "")
				},
				{ data: "uom_terkecil.kode" },
				{ 
					data: "wdnlptd.jumlah_default",
					...renderNumber(2)
				},
				{ data: "uom_default.kode" },
				{ data: "wdnlptd.batch_number" },
				{ data: "wdnlptd.expired_date" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wdnlptd';
					$table       = 'tblwdnlptd';
					$edt         = 'edtwdnlptd';
					$show_status = '_wdnlptd';
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
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api();
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 
				
				for (var i = 6; i <= 8; i+=2) {
					if (i == 8) {
						numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 
					}
					var columnIndex = i;
					var sum_all = api.column(columnIndex).data().sum();
					// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
					var sum = api.column(columnIndex, { page: 'current' }).data().sum();
					$('#s_' + columnIndex).html(numFormat(sum_all));

					// console.log('Number of Pages: ' + api.page.info().pages);
				}
			}
		} );

		tblwdnlptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwdnlptd, 1 );
			CekDrawDetailHDFinal(tblwdnxxth);
		} );

		tblwdnlptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wdnlptd');
			
			// atur hak akses
			CekSelectDetailHD( tblwdnlptd );

			id_iimxxmh          = wdnlptd_data.id_iimxxmh;
			id_iimxxmh_old      = wdnlptd_data.id_iimxxmh;
			id_wdplptd_old      = wdnlptd_data.id_wdplptd;
			id_iumxxmh_unit_old = wdnlptd_data.id_iumxxmh_unit;
			console.log(id_wdplptd_old);
		} );

		tblwdnlptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wdnlptd');
			id_iimxxmh_old = 0;
			id_wdplptd_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwdnlptd );
		} );

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwdnxxth.rows().deselect();
				tblwdnxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwdnxxth').modal('toggle');
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
