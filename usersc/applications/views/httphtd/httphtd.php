<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'httphtd';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'httphtd_d';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<table id="tblhttphtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Tanggal</th>
							<th>Kode</th>
							<th>Nama</th>
							<th>TX</th>
							<th>Approval</th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>

	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabhttphtd_d">Exception</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhttphtd_d" class="tab-pane active">
					<div class="panel-body">
						<table id="tblhttphtd_d" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_httphtd</th>
									<th>Jenis</th>
									<th>Nama</th>
								</tr>
							</thead>
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
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httphtd/fn/httphtd_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthttphtd, tblhttphtd, show_deleted_httphtd = 0, id_httphtd;
	var edthttphtd_d, tblhttphtd_d, show_deleted_httphtd_d = 0, id_httphtd_d;	
	// ------------- end of default variable

	var id_iitxxmh = 0, id_hetxxmh_old = 0, id_hosxxmh_old = 0, id_iigxxmh = 0, id_hevxxmh_old = 0, id_hodxxmh_old = 0, id_iibxxmh_old = 0, id_httphtd_old = 0;
	
	var id_transaksi_old = 0;
	var is_default_old = 0;	var is_iumxxmh_beli = 0, is_iumxxmh_beli_old = 0, is_iumxxmh_jual = 0, is_iumxxmh_jual_old = 0;

	// get tableRelation
	tableRelation('httphtd');
	var kategori_dokumen = "";
	var kategori_dokumen_value = "";

	$(document).ready(function() {
		// BEGIN httphtd
		
		edthttphtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/httphtd/httphtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httphtd = show_deleted_httphtd;
				}
			},
			table: "#tblhttphtd",
			fields: [ 
				{
					label: "httphtd.start_at",
					name: "httphtd.start_at",
					type: "hidden"
				},	
				{
					label: "httphtd.finish_at",
					name: "httphtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "httphtd",
					type: "hidden"
				},	
				{
					label: "httphtd.transaction_state",
					name: "httphtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Tanggal",
					name: "httphtd.tanggal",
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
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "httphtd.nama"
				}, 	
				{
					label: "Keterangan",
					name: "httphtd.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthttphtd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttphtd.field('httphtd.start_at').val(start_at);

			if(action == 'create'){
				tblhttphtd.rows().deselect();
			}
		});

		edthttphtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});

		edthttphtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edthttphtd.field('httphtd.tanggal').val();
				tanggal_ymd = moment(tanggal).format("YYYY-MM-DD");
				nama = edthttphtd.field('httphtd.nama').val();

				validasiRequired(
					edthttphtd,
					'httphtd',
					{
						'tanggal': tanggal,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthttphtd,
					'httphtd',
					'tanggal',
					'tanggal',
					'"'+tanggal_ymd+'"',
					id_httphtd
				);

				validasiUnique(
					action,
					edthttphtd,
					'httphtd',
					'nama',
					'nama',
					'"'+nama+'"',
					id_httphtd
				);
			}
			
			if ( edthttphtd.inError() ) {
				return false;
			}
		});
		
		edthttphtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttphtd.field('httphtd.finish_at').val(finish_at);
		});
		
		edthttphtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			// id_transaksi_header = json.data[0].httphtd.id;
		} );

		edthttphtd.on( 'close', function () {
			edthttphtd.enable();
		} );
		
		tblhttphtd = $('#tblhttphtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/httphtd/httphtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httphtd = show_deleted_httphtd;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "httphtd.id",visible:false },
				{ data: "httphtd.tanggal" },
				{ data: "httphtd.kode" },
				{ data: "httphtd.nama" },
				{ 
					data: "httphtd.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "httphtd.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_httphtd';
					$table       = 'tblhttphtd';
					$edt         = 'edthttphtd';
					$show_status = '_httphtd';
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
				if ( data.httphtd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.httphtd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhttphtd.searchPanes.container().appendTo('#sphttphtd');
		tblhttphtd.searchBuilder.container().appendTo( '#sbhttphtd' );
		
		tblhttphtd.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhttphtd_d];
			CekInitHeaderHD(tblhttphtd, tbl_details);

		} );
		
		tblhttphtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('httphtd');
			id_iitxxmh_old = httphtd_data.id_iitxxmh;
			id_iicxxmh_old = httphtd_data.id_iicxxmh;
			id_iigxxmh     = httphtd_data.id_iigxxmh;
			id_iigxxmh_old = httphtd_data.id_iigxxmh;
			id_iigx2mh_old = httphtd_data.id_iigx2mh;
			id_httphtd_old = httphtd_data.id;
			
			// atur hak akses
			tbl_details = [tblhttphtd_d];
			CekSelectHeaderHD(tblhttphtd, tbl_details);

		} );
		
		tblhttphtd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('httphtd');
			id_iitxxmh_old = 0, id_iicxxmh_old = 0, id_iigxxmh = 0, id_iigxxmh_old = 0, id_iigx2mh_old = 0, id_httphtd_old = 0;

			// atur hak akses
			tbl_details = [tblhttphtd_d];
			CekDeselectHeaderHD(tblhttphtd, tbl_details);

		} );

		// END httphtd

		
		// BEGIN httphtd_d

		edthttphtd_d = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/httphtd/httphtd_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httphtd_d = show_deleted_httphtd_d;
					d.id_httphtd = id_httphtd;
				}
			},
			table: "#tblhttphtd_d",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "httphtd_d.start_at",
					name: "httphtd_d.start_at",
					type: "hidden"
				},	
				{
					label: "httphtd_d.finish_at",
					name: "httphtd_d.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "httphtd_d",
					type: "hidden"
				},	
				{
					label: "httphtd_d.transaction_state",
					name: "httphtd_d.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_httphtd",
					name: "httphtd_d.id_httphtd",
					type: "hidden"
				},
				{
					label: "nama_tabel",
					name: "httphtd_d.nama_tabel",
					type: "hidden"
				},
				{
					label: "nama",
					name: "httphtd_d.nama",
					type: "hidden"
				},
				{
					label: "Jenis <sup class='text-danger'>*<sup>",
					name: "httphtd_d.jenis",
					type: "select",
					placeholder : "Pilih",
					options: [
						{ "label": "Department", "value": "Department" },
						{ "label": "Section", "value": "Section" },
						{ "label": "Employee Title", "value": "Employee Title" },
						{ "label": "Employee Level", "value": "Employee Level" },
					]
				},
				{
					label: "Nama",
					id: "select_nama",
					name: "httphtd_d.id_transaksi",
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
									id_transaksi_old: id_transaksi_old,
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
			]
		} );
			
		edthttphtd_d.on( 'preOpen', function( e, mode, action ) {
			edthttphtd_d.field('httphtd_d.id_httphtd').val(id_httphtd);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttphtd_d.field('httphtd_d.start_at').val(start_at);
			edthttphtd_d.field('httphtd_d.id_transaksi').hide();
			
			if(action == 'create'){
				tblhttphtd_d.rows().deselect();
			}
		});

		edthttphtd_d.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		

		edthttphtd_d.dependent( 'httphtd_d.jenis', function ( val, data, callback ) {
			console.log(val);
			if (val !== '') {
				edthttphtd_d.field('httphtd_d.id_transaksi').show();
				var opt_custom;
				if (val === 'Department') {
					edthttphtd_d.field('httphtd_d.nama_tabel').val('hodxxmh');
					opt_custom = {
						url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
						dataType: 'json',
						data: function(params) {
							var query = {
								id_hodxxmh_old: id_hodxxmh_old,
								search: params.term || '',
								page: params.page || 1
							};
							return query;
						}
					};
				} else if (val === 'Section') {
					edthttphtd_d.field('httphtd_d.nama_tabel').val('hosxxmh');
					opt_custom = {
						url: "../../models/hosxxmh/hosxxmh_fn_opt.php",
						dataType: 'json',
						data: function(params) {
							var query = {
								id_hosxxmh_old: id_hosxxmh_old,
								search: params.term || '',
								page: params.page || 1
							};
							return query;
						}
					};
				} else if (val === 'Employee Title') {
					edthttphtd_d.field('httphtd_d.nama_tabel').val('hetxxmh');
					opt_custom = {
						url: "../../models/hetxxmh/hetxxmh_fn_opt.php",
						dataType: 'json',
						data: function(params) {
							var query = {
								id_hetxxmh_old: id_hetxxmh_old,
								search: params.term || '',
								page: params.page || 1
							};
							return query;
						}
					};
				}else if (val === 'Employee Level') {
					edthttphtd_d.field('httphtd_d.nama_tabel').val('hevxxmh');
					opt_custom = {
						url: "../../models/hevxxmh/hevxxmh_fn_opt.php",
						dataType: 'json',
						data: function(params) {
							var query = {
								id_hevxxmh_old: id_hevxxmh_old,
								search: params.term || '',
								page: params.page || 1
							};
							return query;
						}
					};
				}

				// Update the AJAX URL for select2
				$('#select_nama').select2({
					ajax: {
						url: opt_custom.url,
						dataType: opt_custom.dataType,
						data: opt_custom.data,
						processResults: function(data, params) {
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
				});
			}
			return {}
		}, {event: 'keyup change'});

		edthttphtd_d.dependent( 'httphtd_d.id_transaksi', function ( val, data, callback ) {
			if (val > 0) {
				nama_tabel  = edthttphtd_d.field('httphtd_d.nama_tabel').val();
				autofillField(nama_tabel, val, 'nama')
				console.log(nama_tabel);
				nama = autofillData.nama;
				console.log('nama = ' +nama);
				edthttphtd_d.field('httphtd_d.nama').val(nama);
			}
			return {}
		}, {event: 'keyup change'});
		
		edthttphtd_d.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// set variable
				id_transaksi      = edthttphtd_d.field('httphtd_d.id_transaksi').val();
				jenis = edthttphtd_d.field('httphtd_d.jenis').val();

				validasiRequired(
					edthttphtd_d,
					'httphtd_d',
					{
						'id_transaksi': id_transaksi,
						'jenis': jenis
					}
				);
				
			}
			
			if ( edthttphtd_d.inError() ) {
				return false;
			}
		});

		edthttphtd_d.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttphtd_d.field('httphtd_d.finish_at').val(finish_at);
		});
			
		edthttphtd_d.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhttphtd_d.ajax.reload(null, false);			

		} );

		edthttphtd_d.on( 'close', function () {
			edthttphtd_d.enable();
		} );

		tblhttphtd_d = $('#tblhttphtd_d').DataTable( {
			ajax: {
				url: "../../models/httphtd/httphtd_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httphtd_d = show_deleted_httphtd_d;
					d.id_httphtd = id_httphtd;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "httphtd_d.id",visible:false },
				{ data: "httphtd_d.id_httphtd",visible:false },
				{ data: "httphtd_d.jenis" },
				{ data: "httphtd_d.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_httphtd_d';
					$table       = 'tblhttphtd_d';
					$edt         = 'edthttphtd_d';
					$show_status = '_httphtd_d';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
			],
			initComplete: function() {
				// this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblhttphtd_d.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhttphtd_d, 1 );
			CekDrawDetailHDFinal(tblhttphtd);

		} );

		tblhttphtd_d.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('httphtd_d');
			id_transaksi_old      = httphtd_d_data.id_transaksi;
			is_default_old      = httphtd_d_data.is_default;
			
			// atur hak akses
			CekSelectDetailHD( tblhttphtd_d );

		} );

		tblhttphtd_d.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('httphtd_d');
			id_httphtd_d = 0;
			id_transaksi_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhttphtd_d );

		} );

		// END httphtd_d

	} );// end of document.ready
	
</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
<!--  -->