<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'itixxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'itiittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblitixxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabitiittd_1"> Items</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabitiittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblitiittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_itixxth</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/itixxth/fn/itixxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtitixxth, tblitixxth, show_deleted_itixxth = 0, id_itixxth;
	var edtitiittd, tblitiittd, show_deleted_itiittd = 0, id_itiittd;
	// ------------- end of default variable

	var is_need_generate_kode = 1;

	var id_iwhxxmh_asal_old = 0, id_iwhxxmh_tujuan_old = 0, id_itoxxth_old = 0;
	var id_iimxxmh, id_iumxxmh_unit_old = 0, jumlah_unit_old = 0; id_iimxxmh_old = 0;

	$(document).ready(function() {
		//start datatables editor
		edtitixxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/itixxth/itixxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itixxth = show_deleted_itixxth;
				}
			},
			table: "#tblitixxth",
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
					label: "itixxth.start_at",
					name: "itixxth.start_at",
					type: "hidden"
				},	
				{
					label: "itixxth.finish_at",
					name: "itixxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "itixxth",
					type: "hidden"
				},	
				{
					label: "itixxth.transaction_state",
					name: "itixxth.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "itixxth.tanggal",
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
					label: "Goods Transfer <sup class='text-danger'>*<sup>",
					name: "itixxth.id_itoxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/itoxxth/itoxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_itoxxth_old: id_itoxxth_old,
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
					label: "Warehouse Asal",
					name: "itixxth.id_iwhxxmh_asal",
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
					label: "Warehouse Tujuan",
					name: "itixxth.id_iwhxxmh_tujuan",
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
					name: "itixxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtitixxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitixxth.field('itixxth.start_at').val(start_at);
			edtitixxth.field('itixxth.id_iwhxxmh_asal').disable();
			edtitixxth.field('itixxth.id_iwhxxmh_tujuan').disable();

			if(action == 'create'){
				tblitixxth.rows().deselect();
				edtitixxth.field('kategori_dokumen').val('');
				edtitixxth.field('kategori_dokumen_value').val('');
				edtitixxth.field('field_tanggal').val('start_at');
			}
		});

		edtitixxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtitixxth.dependent( 'itixxth.id_itoxxth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('itoxxth', val, 'id_iwhxxmh_asal,id_iwhxxmh_tujuan');
				id_iwhxxmh_asal_old = autofillData.id_iwhxxmh_asal;
				id_iwhxxmh_tujuan_old = autofillData.id_iwhxxmh_tujuan;
				edtitixxth.field('itixxth.id_iwhxxmh_asal').val(id_iwhxxmh_asal_old);
				edtitixxth.field('itixxth.id_iwhxxmh_tujuan').val(id_iwhxxmh_tujuan_old);
			}
			return {}
		}, {event: 'keyup change'});
		
		edtitixxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi itixxth.id_itoxxth 
				id_itoxxth = edtitixxth.field('itixxth.id_itoxxth').val();
				if(!id_itoxxth || id_itoxxth == ''){
					edtitixxth.field('itixxth.id_itoxxth').error( 'Wajib diisi!' );
				}

				// BEGIN of validasi itixxth.tanggal 
				tanggal = edtitixxth.field('itixxth.tanggal').val();
				if(!tanggal || tanggal == ''){
					edtitixxth.field('itixxth.tanggal').error( 'Wajib diisi!' );
				}
				// END of validasi itixxth.tanggal
			}
			
			if ( edtitixxth.inError() ) {
				return false;
			}
		});

		edtitixxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitixxth.field('itixxth.finish_at').val(finish_at);
		});
		
		edtitixxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtitixxth.on( 'close', function () {
			edtitixxth.enable();
		} );
		
		//start datatables
		tblitixxth = $('#tblitixxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/itixxth/itixxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itixxth = show_deleted_itixxth;
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
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "itixxth.id",visible:false },
				{ data: "itixxth.tanggal" },
				{ data: "itixxth.kode" },
				{ data: "asal.nama" },
				{ data: "tujuan.nama" },
				{ 
					data: "itixxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "itixxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_itixxth';
					$table       = 'tblitixxth';
					$edt         = 'edtitixxth';
					$show_status = '_itixxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.itixxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.itixxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblitixxth.searchPanes.container().appendTo('#spitixxth');
			tblitixxth.searchBuilder.container().appendTo( '#sbitixxth' );
		
		tblitixxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblitiittd];
			CekInitHeaderHD(tblitixxth, tbl_details);
		} );
		
		tblitixxth.on( 'select', function( e, dt, type, indexes ) {
			itixxth_data    		= tblitixxth.row( { selected: true } ).data().itixxth;
			id_itixxth      		= itixxth_data.id;
			id_transaksi_h 		= id_itixxth; // dipakai untuk general
			id_transaksi_log	= id_itixxth; // dipakai untuk general
			transaction_state   = itixxth_data.transaction_state;
			approval_state   	= itixxth_data.approval_state;
			is_nextprocess 		= itixxth_data.is_nextprocess;
			id_itoxxth_old		= itixxth_data.id_itoxxth;
			ids_itoxxth		= itixxth_data.id_itoxxth;
			
			// atur hak akses
			tbl_details = [tblitiittd];
			CekSelectHeaderHD(tblitixxth, tbl_details);

		} );
		
		tblitixxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_itixxth = 0;
			id_itoxxth_old = 0;
			ids_itoxxth = 0;

			// atur hak akses
			tbl_details = [tblitiittd];
			CekDeselectHeaderHD(tblitixxth, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edtitiittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/itixxth/itiittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itiittd = show_deleted_itiittd;
					d.id_itixxth = id_itixxth;
				}
			},
			table: "#tblitiittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "itiittd.start_at",
					name: "itiittd.start_at",
					type: "hidden"
				},	
				{
					label: "itiittd.finish_at",
					name: "itiittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "itiittd",
					type: "hidden"
				},	
				{
					label: "itiittd.transaction_state",
					name: "itiittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_itixxth",
					name: "itiittd.id_itixxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "itiittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/itoxxth/iimxxmh_itoxxth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									ids_itoxxth: ids_itoxxth,
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
					name: "itiittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_iimummd_fn_opt.php",
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
					name: "itiittd.jumlah_unit"
				}
			]
		} );
			
		edtitiittd.on( 'preOpen', function( e, mode, action ) {
			edtitiittd.field('itiittd.id_itixxth').val(id_itixxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitiittd.field('itiittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblitiittd.rows().deselect();
			}
		});

		edtitiittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtitiittd.dependent( 'itiittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtitiittd.field('itiittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});
		
		edtitiittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_iimxxmh = edtitiittd.field('itiittd.id_iimxxmh').val();
				if(!id_iimxxmh || id_iimxxmh == ''){
					edtitiittd.field('itiittd.id_iimxxmh').error( 'Wajib diisi!' );
				}
				
				id_iumxxmh = edtitiittd.field('itiittd.id_iumxxmh_unit').val();
				if(!id_iumxxmh || id_iumxxmh == ''){
					edtitiittd.field('itiittd.id_iumxxmh_unit').error( 'Wajib diisi!' );
				}
				
				jumlah_unit = edtitiittd.field('itiittd.jumlah_unit').val();
				if(!jumlah_unit || jumlah_unit == ''){
					edtitiittd.field('itiittd.jumlah_unit').error( 'Wajib diisi!' );
				}

				// validasi min atau max angka
				if(jumlah_unit <= 0 ){
					edtitiittd.field('itiittd.jumlah_unit').error( 'Inputan harus > 0' );
				}
				
				// validasi angka
				if(isNaN(jumlah_unit) ){
					edtitiittd.field('itiittd.jumlah_unit').error( 'Inputan harus berupa Angka!' );
				}
				validasiQty(id_iimxxmh, id_iumxxmh, jumlah_unit,jumlah_unit_old);
                // console.log('IN = '+terkecil_in);
                // console.log('OUT = '+terkecil_out);

				if (terkecil_in > terkecil_out) {
					if (id_iumxxmh == id_iumxxmh_out) {
						edtitiittd.field('itiittd.jumlah_unit').error( 'Quantity Tidak Boleh Melebihi '+text );
					} else {
						edtitiittd.field('itiittd.jumlah_unit').error( 'Quantity Tidak Boleh Melebihi '+terkecil_out+' '+satuan);
					}
				}

			}
			
			if ( edtitiittd.inError() ) {
				return false;
			}
		});

		edtitiittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtitiittd.field('itiittd.finish_at').val(finish_at);
		});
			
		edtitiittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			if (action != 'remove') {
				id_last_insert = json.data[0].itiittd.id;
				konversiUom(id_last_insert, 'itiittd');
			}
		} );

		edtitiittd.on( 'close', function () {
			edtitiittd.enable();
		} );
		
		//start datatables
		tblitiittd = $('#tblitiittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/itixxth/itiittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itiittd = show_deleted_itiittd;
					d.id_itixxth = id_itixxth;
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
				{ data: "itiittd.id",visible:false },
				{ data: "itiittd.id_itixxth",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "itiittd.jumlah_unit",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_itiittd';
					$table       = 'tblitiittd';
					$edt         = 'edtitiittd';
					$show_status = '_itiittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					$arr_buttons_approve 	= ['noapprove'];
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

		tblitiittd.searchPanes.container().appendTo('#spitiittd');
		tblitiittd.searchBuilder.container().appendTo( '#sbitiittd' );

		tblitiittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblitixxth, tblitiittd, 'itiittd' );
			CekDrawDetailHDFinal(tblitixxth);
		} );

		tblitiittd.on( 'select', function( e, dt, type, indexes ) {
			data_itiittd 		= tblitiittd.row( { selected: true } ).data().itiittd;
			id_itiittd   		= data_itiittd.id;
			id_transaksi_d 		= id_itiittd; // dipakai untuk general
			id_transaksi_log 	= id_itiittd; // dipakai untuk log

			transaction_state_d   = data_itiittd.transaction_state;
			id_iimxxmh_old   = data_itiittd.id_iimxxmh;
			id_iumxxmh_unit_old   = data_itiittd.id_iumxxmh_unit;
			jumlah_unit_old   = data_itiittd.jumlah_unit;
			
			// atur hak akses
			CekSelectDetailHD(tblitixxth, tblitiittd );
		} );

		tblitiittd.on( 'deselect', function() {
			id_itiittd = 0;
			id_iimxxmh_old = 0;
			jumlah_unit_old = 0;
			id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblitixxth, tblitiittd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
