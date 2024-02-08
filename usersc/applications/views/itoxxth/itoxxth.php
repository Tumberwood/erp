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
				<div class="table-responsive">
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
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabitoittd_1"> Items</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabitoittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblitoittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_itoxxth</th>
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

	$(document).ready(function() {
		//start datatables editor
		edtitoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/itoxxth/itoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoxxth = show_deleted_itoxxth;
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
		
		//start datatables
		tblitoxxth = $('#tblitoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/itoxxth/itoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoxxth = show_deleted_itoxxth;
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
			itoxxth_data    		= tblitoxxth.row( { selected: true } ).data().itoxxth;
			id_itoxxth      		= itoxxth_data.id;
			id_transaksi_h 		= id_itoxxth; // dipakai untuk general
			id_transaksi_log	= id_itoxxth; // dipakai untuk general
			transaction_state   = itoxxth_data.transaction_state;
			approval_state   	= itoxxth_data.approval_state;
			is_nextprocess 		= itoxxth_data.is_nextprocess;
			is_jurnal      		= itoxxth_data.is_jurnal;
			id_iwhxxmh_asal_old		= itoxxth_data.id_iwhxxmh_asal;
			id_iwhxxmh_tujuan_old		= itoxxth_data.id_iwhxxmh_tujuan;
			
			// atur hak akses
			tbl_details = [tblitoittd];
			CekSelectHeaderHD(tblitoxxth, tbl_details);

		} );
		
		tblitoxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_itoxxth = 0;
			id_iwhxxmh_tujuan_old = 0;
			id_iwhxxmh_asal_old = 0;

			// atur hak akses
			tbl_details = [tblitoittd];
			CekDeselectHeaderHD(tblitoxxth, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
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
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									ids_iittpmh: 1,
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
					name: "itoittd.jumlah_unit"
				}, 	
				// {
				// 	label: "Keterangan",
				// 	name: "itoittd.keterangan",
				// 	type: "textarea"
				// }
			]
		} );
			
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
			if (action != 'remove') {
				id_transaksi = json.data[0].itoittd.id;
				konversiUom('itoittd', id_transaksi);
			}
		} );

		edtitoittd.on( 'close', function () {
			edtitoittd.enable();
		} );
		
		//start datatables
		tblitoittd = $('#tblitoittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/itoxxth/itoittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_itoittd = show_deleted_itoittd;
					d.id_itoxxth = id_itoxxth;
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
				{ data: "itoittd.id",visible:false },
				{ data: "itoittd.id_itoxxth",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh_unit.nama" },
				{ 
					data: "itoittd.jumlah_unit",
					...renderNumber(0)
				}
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
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					$arr_buttons_approve 	= [];
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

		tblitoittd.searchPanes.container().appendTo('#spitoittd');
		tblitoittd.searchBuilder.container().appendTo( '#sbitoittd' );

		tblitoittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblitoxxth, tblitoittd, 'itoittd' );
			CekDrawDetailHDFinal(tblitoxxth);
		} );

		tblitoittd.on( 'select', function( e, dt, type, indexes ) {
			data_itoittd 		= tblitoittd.row( { selected: true } ).data().itoittd;
			id_itoittd   		= data_itoittd.id;
			id_transaksi_d 		= id_itoittd; // dipakai untuk general
			id_transaksi_log 	= id_itoittd; // dipakai untuk log

			transaction_state_d   = data_itoittd.transaction_state;
			id_iimxxmh_old   = data_itoittd.id_iimxxmh;
			id_iumxxmh_unit_old   = data_itoittd.id_iumxxmh_unit;
			
			// atur hak akses
			CekSelectDetailHD(tblitoxxth, tblitoittd );
		} );

		tblitoittd.on( 'deselect', function() {
			id_itoittd = 0;
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblitoxxth, tblitoittd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
