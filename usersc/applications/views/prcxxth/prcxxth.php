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
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblprcxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Tanggal</th>
                                <th>Kode</th>
								<th>Supplier</th>
								<th>Warehouse</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabprcittd_1"> Items</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabprcittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblprcittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_prcxxth</th>
										<th>Item</th>
										<th>UoM</th>
										<th>Quantity</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prcxxth/fn/prcxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtprcxxth, tblprcxxth, show_deleted_prcxxth = 0, id_prcxxth;
	var edtprcittd, tblprcittd, show_deleted_prcittd = 0, id_prcittd;
	// ------------- end of default variable

	is_need_generate_kode = 1, is_need_inventory = 1;
	// get tableRelation
	tableRelation('prcxxth');

	var id_grlxxmh_supplier = 0, id_podxxth = 0, id_podxxth_old = 0, id_grlxxmh_supplier_old = 0, id_iwhxxmh_old = 0;
	var id_podittd_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0, id_iimxxmh_old = 0, jumlah_terkecil_old = 0;
	var id_grlxxmh_old = 0;

	$(document).ready(function() {
		//start datatables editor
		edtprcxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prcxxth/prcxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcxxth = show_deleted_prcxxth;
				}
			},
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
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
					label: "Supplier <sup class='text-danger'>*<sup>",
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
					label: "Purchase Order",
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
					// type: "hidden"
				},

				{
					label: "prcxxth.id_fpytmmh",
					name: "prcxxth.id_fpytmmh",
					// type: "hidden"
				},
				{
					label: "prcxxth.id_fcrxxmh",
					name: "prcxxth.id_fcrxxmh",
					// type: "hidden"
				},
				{
					label: "prcxxth.is_pajak",
					name: "prcxxth.is_pajak",
					// type: "hidden"
				},
				{
					label: "prcxxth.pajak_jenis",
					name: "prcxxth.pajak_jenis",
					// type: "hidden"
				},
				{
					label: "prcxxth.pajak_in_ex",
					name: "prcxxth.pajak_in_ex",
					// type: "hidden"
				},
				{
					label: "Warehouse <sup class='text-danger'>*<sup>",
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
					label: "Surat Jalan <sup class='text-danger'>*<sup>",
					name: "prcxxth.referensi_nomor"
				},
				{
					label: "Supir <sup class='text-danger'>*<sup>",
					name: "prcxxth.supir_nama"
				},
				{
					label: "Keterangan",
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

				edtprcxxth.field('kategori_dokumen').val('');
				edtprcxxth.field('kategori_dokumen_value').val('');
				edtprcxxth.field('field_tanggal').val('tanggal');
			}
		});

		edtprcxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtprcxxth.dependent( 'prcxxth.id_grlxxmh_supplier', function ( val, data, callback ) {
			id_grlxxmh_supplier = edtprcxxth.field('prcxxth.id_grlxxmh_supplier').val();
			return {}
		}, {event: 'keyup change'});

		edtprcxxth.dependent( 'prcxxth.id_podxxth', function ( val, data, callback ) {
			id_podxxth = edtprcxxth.field('prcxxth.id_podxxth').val();
			autofillField('podxxth', id_podxxth, 'id_iitxxmh,id_fpytmmh,id_fcrxxmh,is_pajak,pajak_jenis,pajak_in_ex');
			edtprcxxth.field('prcxxth.id_iitxxmh').val(autofillData.id_iitxxmh);
			edtprcxxth.field('prcxxth.id_fpytmmh').val(autofillData.id_fpytmmh);
			edtprcxxth.field('prcxxth.id_fcrxxmh').val(autofillData.id_fcrxxmh);
			edtprcxxth.field('prcxxth.is_pajak').val(autofillData.is_pajak);
			edtprcxxth.field('prcxxth.pajak_jenis').val(autofillData.pajak_jenis);
			edtprcxxth.field('prcxxth.pajak_in_ex').val(autofillData.pajak_in_ex);
			return {}
		}, {event: 'keyup change'});

		edtprcxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal         = edtprcxxth.field('prcxxth.tanggal').val();
				id_iwhxxmh      = edtprcxxth.field('prcxxth.id_iwhxxmh').val();
				id_grlxxmh_supplier      = edtprcxxth.field('prcxxth.id_grlxxmh_supplier').val();
				id_podxxth      = edtprcxxth.field('prcxxth.id_podxxth').val();
				referensi_nomor = edtprcxxth.field('prcxxth.referensi_nomor').val();

				validasiRequired(
					edtprcxxth, 
					"prcxxth", 
					{
						"tanggal": tanggal, 
						"id_iwhxxmh": id_iwhxxmh, 
						"id_grlxxmh_supplier": id_grlxxmh_supplier,
						"id_podxxth": id_podxxth,
						"referensi_nomor": referensi_nomor
					}
				);

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
			
		} );

		edtprcxxth.on( 'close', function () {
			edtprcxxth.enable();
		} );
		
		//start datatables
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
					targets: [0]
				}
			],
			columns: [
				{ data: "prcxxth.id",visible:false },
				{ data: "prcxxth.tanggal" },
				{ data: "prcxxth.kode" },
				{ data: "psuxxmh.nama" },
				{ data: "iwhxxmh.nama" }
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
			tbl_details = [tblprcittd];
			CekInitHeaderHD(tblprcxxth, tbl_details);
		} );
		
		tblprcxxth.on( 'select', function( e, dt, type, indexes ) {
			prcxxth_data    	= tblprcxxth.row( { selected: true } ).data().prcxxth;
			id_prcxxth      	= prcxxth_data.id;
			id_transaksi_h 		= id_prcxxth; // dipakai untuk general
			id_transaksi_log	= id_prcxxth; // dipakai untuk general
			transaction_state   = prcxxth_data.transaction_state;
			approval_state   	= prcxxth_data.approval_state;
			is_nextprocess 		= prcxxth_data.is_nextprocess;

			id_podxxth_old 		= prcxxth_data.id_podxxth;
			id_podxxth 			= prcxxth_data.id_podxxth;
			id_iwhxxmh_old 		= prcxxth_data.id_iwhxxmh;
			id_grlxxmh_supplier_old 		= prcxxth_data.id_grlxxmh_supplier;
			console.log(id_podxxth);
			// atur hak akses
			tbl_details = [tblprcittd];
			CekSelectHeaderHD(tblprcxxth, tbl_details);

		} );
		
		tblprcxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_prcxxth = 0;

			id_podxxth_old = 0, id_podxxth = 0, id_iwhxxmh_old = 0, id_grlxxmh_supplier_old = 0;

			// atur hak akses
			tbl_details = [tblprcittd];
			CekDeselectHeaderHD(tblprcxxth, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
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
					label: "Item <sup class='text-danger'>*<sup>",
					name: "prcittd.id_podittd",
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
									id_podittd_old: id_podittd_old,
									id_podxxth: id_podxxth,
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
					label: "prcittd.id_iimxxmh",
					name: "prcittd.id_iimxxmh",
					// type: "hidden"
				},
				{
					label: "Order Info",
					name: "podittd_info",
					type: "textarea"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "prcittd.jumlah_unit"
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

			edtprcittd.field('podittd_info').disable();
		});

		edtprcittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtprcittd.dependent( 'prcittd.id_podittd', function ( val, data, callback ) {
			id_podittd = edtprcittd.field('prcittd.id_podittd').val();
			autofillField('podittd', id_podittd, 'id_iimxxmh, id_iumxxmh_default, jumlah_terkecil_os');
			id_iimxxmh = autofillData.id_iimxxmh; // untuk di load sebagai variable untuk dipakai di select2 prcittd.id_iumxxmh_unit
			edtprcittd.field('prcittd.id_iimxxmh').val(autofillData.id_iimxxmh);
			id_iumxxmh_default = autofillData.id_iumxxmh_default;
			jumlah_terkecil_os  = autofillData.jumlah_terkecil_os;

			autofillField('iumxxmh', id_iumxxmh_default, 'kode');
			iumxxmh_kode_default = autofillData.kode;

			// BEGIN generate podittd_info
			if (jumlah_terkecil_os != ''){
				podittd_info_notes = 'Outstanding: ' + jumlah_terkecil_os + ' ' + iumxxmh_kode_default;
			}else{
				podittd_info_notes = '';
			}
			// END generate podittd_info
			edtprcittd.field('podittd_info').val(podittd_info_notes);

			return {}
		}, {event: 'keyup change'});

		edtprcittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_prcittd;
			}

			if(action != 'remove'){
				id_iimxxmh = edtprcittd.field('prcittd.id_iimxxmh').val();
				id_iumxxmh_unit = edtprcittd.field('prcittd.id_iumxxmh_unit').val();
				jumlah_unit = edtprcittd.field('prcittd.jumlah_unit').val();

				validasiRequired(
					edtprcittd,
					'prcittd',
					{
						'id_iimxxmh': id_iimxxmh,
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

				// validasiOutstanding(
				// 	edtprcittd, 
				// 	'prcittd', 
				// 	id_transaksi
				// );

				validasi_outstanding(edtprcittd, 'prcittd', id_prcittd, id_podittd, 'podittd');
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
			if (action != 'remove') {
				// id_transaksi = json.data[0].prcittd.id;
				// konversiUom('prcittd', id_transaksi);
			}
			tblprcittd.rows().deselect();
		} );

		edtprcittd.on( 'close', function () {
			edtprcittd.enable();
		} );
		
		//start datatables
		tblprcittd = $('#tblprcittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/prcxxth/prcittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prcittd = show_deleted_prcittd;
					d.id_prcxxth = id_prcxxth;
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
			columns: [
				{ data: "prcittd.id",visible:false },
				{ data: "prcittd.id_prcxxth",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.nama" },
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

		tblprcittd.searchPanes.container().appendTo('#spprcittd');
		tblprcittd.searchBuilder.container().appendTo( '#sbprcittd' );

		tblprcittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblprcxxth, tblprcittd, 'prcittd' );
			CekDrawDetailHDFinal(tblprcxxth);
		} );

		tblprcittd.on( 'select', function( e, dt, type, indexes ) {
			data_prcittd 		= tblprcittd.row( { selected: true } ).data().prcittd;
			id_prcittd   		= data_prcittd.id;
			id_transaksi_d 		= id_prcittd; // dipakai untuk general
			id_transaksi_log 	= id_prcittd; // dipakai untuk log

			transaction_state_d   = data_prcittd.transaction_state;

			id_iimxxmh   = data_prcittd.id_iimxxmh;
			id_iimxxmh_old   = data_prcittd.id_iimxxmh;
			id_podittd_old   = data_prcittd.id_podittd;
			id_iumxxmh_unit_old   = data_prcittd.id_iumxxmh_unit;
			jumlah_terkecil_old   = data_prcittd.jumlah_terkecil;

			
			// atur hak akses
			CekSelectDetailHD(tblprcxxth, tblprcittd );
		} );

		tblprcittd.on( 'deselect', function() {
			id_prcittd = 0;
			id_podittd_old = 0, id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, jumlah_terkecil_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblprcxxth, tblprcittd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
