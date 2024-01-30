<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'prqxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'prqittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblprqxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Department</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabprqittd"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabprqittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblprqittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_prqxxth</th>
										<th>Item</th>
										<th>Quantity</th>
										<th>UoM</th>
										<th>Tanggal Dibutuhkan</th>
										<th>Keterangan</th>
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
										<th></th>
									</tr>
								</tfoot>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prqxxth/fn/prqxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprqxxth, tblprqxxth, show_deleted_prqxxth = 0, id_prqxxth;
	var edtprqittd, tblprqittd, show_deleted_prqittd = 0, id_prqittd;
	// ------------- end of default variable
	var id_hodxxmh_old = 0;
	var id_iumxxmh_old = 0;
	var is_need_generate_kode = 1;

	$(document).ready(function() {
		//start datatables editor
		edtprqxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prqxxth/prqxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqxxth = show_deleted_prqxxth;
				}
			},
			table: "#tblprqxxth",
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
					label: "prqxxth.start_at",
					name: "prqxxth.start_at",
					type: "hidden"
				},	
				{
					label: "prqxxth.finish_at",
					name: "prqxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prqxxth",
					type: "hidden"
				},	
				{
					label: "prqxxth.transaction_state",
					name: "prqxxth.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "prqxxth.tanggal",
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
					label: "Department <sup class='text-danger'>*<sup>",
					name: "prqxxth.id_hodxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh_old: id_hodxxmh_old,
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
					name: "prqxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtprqxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqxxth.field('prqxxth.start_at').val(start_at);

			if(action == 'create'){
				tblprqxxth.rows().deselect();
				edtprqxxth.field('kategori_dokumen').val('');
				edtprqxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtprqxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtprqxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi prqxxth.tanggal 
				tanggal = edtprqxxth.field('prqxxth.tanggal').val();
				if(!tanggal || tanggal == ''){
					edtprqxxth.field('prqxxth.tanggal').error( 'Wajib diisi!' );
				}
				// END of validasi prqxxth.tanggal

				// BEGIN of validasi prqxxth.id_hodxxmh 
				id_hodxxmh = edtprqxxth.field('prqxxth.id_hodxxmh').val();
				if(!id_hodxxmh || id_hodxxmh == ''){
					edtprqxxth.field('prqxxth.id_hodxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi prqxxth.id_hodxxmh 

			}
			
			if ( edtprqxxth.inError() ) {
				return false;
			}
		});

		edtprqxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqxxth.field('prqxxth.finish_at').val(finish_at);
		});
		
		edtprqxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtprqxxth.on( 'close', function () {
			edtprqxxth.enable();
		} );
		
		//start datatables
		tblprqxxth = $('#tblprqxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/prqxxth/prqxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqxxth = show_deleted_prqxxth;
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
				{ data: "prqxxth.id",visible:false },
				{ data: "prqxxth.tanggal" },
				{ data: "prqxxth.kode" },
				{ data: "hodxxmh.nama" },
				{ 
					data: "prqxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "prqxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prqxxth';
					$table       = 'tblprqxxth';
					$edt         = 'edtprqxxth';
					$show_status = '_prqxxth';
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
				if ( data.prqxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prqxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprqxxth.searchPanes.container().appendTo('#spprqxxth');
			tblprqxxth.searchBuilder.container().appendTo( '#sbprqxxth' );
		
		tblprqxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblprqittd];
			CekInitHeaderHD(tblprqxxth, tbl_details);
		} );
		
		tblprqxxth.on( 'select', function( e, dt, type, indexes ) {
			prqxxth_data    		= tblprqxxth.row( { selected: true } ).data().prqxxth;
			id_prqxxth      		= prqxxth_data.id;
			id_transaksi_h 		= id_prqxxth; // dipakai untuk general
			id_transaksi_log	= id_prqxxth; // dipakai untuk general
			transaction_state   = prqxxth_data.transaction_state;
			approval_state   	= prqxxth_data.approval_state;
			is_nextprocess 		= prqxxth_data.is_nextprocess;
			is_jurnal      		= prqxxth_data.is_jurnal;
			id_hodxxmh_old		= prqxxth_data.id_hodxxmh;
			
			// atur hak akses
			tbl_details = [tblprqittd];
			CekSelectHeaderHD(tblprqxxth, tbl_details);

		} );
		
		tblprqxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_prqxxth = 0;
			id_hodxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblprqittd];
			CekDeselectHeaderHD(tblprqxxth, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edtprqittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prqxxth/prqittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqittd = show_deleted_prqittd;
					d.id_prqxxth = id_prqxxth;
				}
			},
			table: "#tblprqittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "prqittd.start_at",
					name: "prqittd.start_at",
					type: "hidden"
				},	
				{
					label: "prqittd.finish_at",
					name: "prqittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prqittd",
					type: "hidden"
				},	
				{
					label: "prqittd.transaction_state",
					name: "prqittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_prqxxth",
					name: "prqittd.id_prqxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "prqittd.nama"
				}, 	
				{
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "prqittd.jumlah_unit"
				}, 
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "prqittd.id_iumxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_old,
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
					label: "Tanggal Dibutuhkan",
					name: "prqittd.tanggal_dibutuhkan",
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
					label: "Keterangan",
					name: "prqittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtprqittd.on( 'preOpen', function( e, mode, action ) {
			edtprqittd.field('prqittd.id_prqxxth').val(id_prqxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqittd.field('prqittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblprqittd.rows().deselect();
			}
		});

		edtprqittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtprqittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				nama = edtprqittd.field('prqittd.nama').val();
				if(!nama || nama == ''){
					edtprqittd.field('prqittd.nama').error( 'Wajib diisi!' );
				}
				
				id_iumxxmh = edtprqittd.field('prqittd.id_iumxxmh').val();
				if(!id_iumxxmh || id_iumxxmh == ''){
					edtprqittd.field('prqittd.id_iumxxmh').error( 'Wajib diisi!' );
				}
				
				jumlah_unit = edtprqittd.field('prqittd.jumlah_unit').val();
				if(!jumlah_unit || jumlah_unit == ''){
					edtprqittd.field('prqittd.jumlah_unit').error( 'Wajib diisi!' );
				}

				// validasi min atau max angka
				if(jumlah_unit <= 0 ){
					edtprqittd.field('prqittd.jumlah_unit').error( 'Inputan harus > 0' );
				}
				
				// validasi angka
				if(isNaN(jumlah_unit) ){
					edtprqittd.field('prqittd.jumlah_unit').error( 'Inputan harus berupa Angka!' );
				}
			}
			
			if ( edtprqittd.inError() ) {
				return false;
			}
		});

		edtprqittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqittd.field('prqittd.finish_at').val(finish_at);
		});
			
		edtprqittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtprqittd.on( 'close', function () {
			edtprqittd.enable();
		} );
		
		//start datatables
		tblprqittd = $('#tblprqittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/prqxxth/prqittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqittd = show_deleted_prqittd;
					d.id_prqxxth = id_prqxxth;
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
				{ data: "prqittd.id",visible:false },
				{ data: "prqittd.id_prqxxth",visible:false },
				{ data: "prqittd.nama" },
				{ 
					data: "prqittd.jumlah_unit",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "iumxxmh.nama" },
				{ data: "prqittd.tanggal" },
				{ data: "prqittd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prqittd';
					$table       = 'tblprqittd';
					$edt         = 'edtprqittd';
					$show_status = '_prqittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					$arr_buttons_approve 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       = this.api(), data;
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display;
				var c_items = api.column(0).data().count();
				$( '#c_items' ).html( numFormat("Total Item(s): " + c_items) );
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblprqittd.searchPanes.container().appendTo('#spprqittd');
		tblprqittd.searchBuilder.container().appendTo( '#sbprqittd' );

		tblprqittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblprqxxth, tblprqittd, 'prqittd' );
			CekDrawDetailHDFinal(tblprqxxth);
		} );

		tblprqittd.on( 'select', function( e, dt, type, indexes ) {
			data_prqittd 		= tblprqittd.row( { selected: true } ).data().prqittd;
			id_prqittd   		= data_prqittd.id;
			id_transaksi_d 		= id_prqittd; // dipakai untuk general
			id_transaksi_log_d 	= id_prqittd; // dipakai untuk log

			transaction_state_d   = data_prqittd.transaction_state;
			id_iumxxmh_old   = data_prqittd.id_iumxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblprqxxth, tblprqittd );
		} );

		tblprqittd.on( 'deselect', function() {
			id_prqittd = 0;
			is_active_d = 0;
			id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblprqxxth, tblprqittd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
