<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'httgltd';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'httgltd_d';

	$rowId = 0;
	if (isset($_GET['rowId'])) {
		$rowId = $_GET['rowId'];
	}
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhttgltd" tabindex="-1" role="dialog" aria-hidden="true">
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
				
				<table id="tblhttgltd" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Tanggal</th>
							<th>Kode</th>
							<th>Nama</th>
							<th>Keterangan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhttgltd_d">Exception</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhttgltd_d" class="tab-pane active">
					<div class="panel-body">
						<table id="tblhttgltd_d" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_httgltd</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httgltd/fn/httgltd_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthttgltd, tblhttgltd, show_deleted_httgltd = 0, id_httgltd;
	var edthttgltd_d, tblhttgltd_d, show_deleted_httgltd_d = 0, id_httgltd_d;
	// ------------- end of default variable

	var id_iitxxmh = 0, id_hetxxmh_old = 0, id_hosxxmh_old = 0, id_iigxxmh = 0, id_hevxxmh_old = 0, id_hodxxmh_old = 0, id_iibxxmh_old = 0, id_httgltd_old = 0;
	
	var id_transaksi_old = 0;
	var is_default_old = 0;	var is_iumxxmh_beli = 0, is_iumxxmh_beli_old = 0, is_iumxxmh_jual = 0, is_iumxxmh_jual_old = 0;

	//ini untuk single
	var rowId = <?php echo $rowId; ?>;

	// get tableRelation
	tableRelation('httgltd');
	var kategori_dokumen = "";
	var kategori_dokumen_value = "";

	// Tanggal awal: 1 Januari tahun ini
	var start_date = moment().startOf('year').toDate();
	$('#start_date').datepicker('setDate', start_date);

	// Tanggal akhir: 31 Desember tahun ini
	var end_date = moment().endOf('year').toDate();
	$('#end_date').datepicker('setDate', end_date);


	$(document).ready(function() {
		// BEGIN httgltd
		start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
		end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');

		edthttgltd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/httgltd/httgltd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httgltd = show_deleted_httgltd;
					d.rowId = rowId;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhttgltd",
			fields: [ 
				{
					label: "httgltd.start_at",
					name: "httgltd.start_at",
					type: "hidden"
				},	
				{
					label: "httgltd.finish_at",
					name: "httgltd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "httgltd",
					type: "hidden"
				},	
				{
					label: "httgltd.transaction_state",
					name: "httgltd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Tanggal",
					name: "httgltd.tanggal",
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
					name: "httgltd.nama"
				}, 	
				{
					label: "Keterangan",
					name: "httgltd.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthttgltd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttgltd.field('httgltd.start_at').val(start_at);

			if(action == 'create'){
				tblhttgltd.rows().deselect();
			}
		});

		edthttgltd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});

		edthttgltd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edthttgltd.field('httgltd.tanggal').val();
				tanggal_ymd = moment(tanggal).format("YYYY-MM-DD");
				nama = edthttgltd.field('httgltd.nama').val();

				validasiRequired(
					edthttgltd,
					'httgltd',
					{
						'tanggal': tanggal,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthttgltd,
					'httgltd',
					'tanggal',
					'tanggal',
					'"'+tanggal_ymd+'"',
					id_httgltd
				);

				validasiUnique(
					action,
					edthttgltd,
					'httgltd',
					'nama',
					'nama',
					'"'+nama+'"',
					id_httgltd
				);
			}
			
			if ( edthttgltd.inError() ) {
				return false;
			}
		});
		
		edthttgltd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttgltd.field('httgltd.finish_at').val(finish_at);
		});
		
		edthttgltd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			// id_transaksi_header = json.data[0].httgltd.id;
		} );

		edthttgltd.on( 'close', function () {
			edthttgltd.enable();
		} );
		
		tblhttgltd = $('#tblhttgltd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/httgltd/httgltd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httgltd = show_deleted_httgltd;
					d.rowId = rowId;
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
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "httgltd.id",visible:false },
				{ data: "httgltd.tanggal" },
				{ data: "httgltd.kode" },
				{ data: "httgltd.nama" },
				{ data: "httgltd.keterangan" },
				{ 
					data: "httgltd.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "httgltd.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_httgltd';
					$table       = 'tblhttgltd';
					$edt         = 'edthttgltd';
					$show_status = '_httgltd';
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
				if ( data.httgltd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.httgltd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhttgltd.searchPanes.container().appendTo('#sphttgltd');
		tblhttgltd.searchBuilder.container().appendTo( '#sbhttgltd' );
		
		tblhttgltd.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhttgltd_d];
			CekInitHeaderHD(tblhttgltd, tbl_details);
		} );
		
		tblhttgltd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('httgltd');
			id_iitxxmh_old = httgltd_data.id_iitxxmh;
			id_iicxxmh_old = httgltd_data.id_iicxxmh;
			id_iigxxmh     = httgltd_data.id_iigxxmh;
			id_iigxxmh_old = httgltd_data.id_iigxxmh;
			id_iigx2mh_old = httgltd_data.id_iigx2mh;
			id_httgltd_old = httgltd_data.id;
			
			// atur hak akses
			tbl_details = [tblhttgltd_d];
			CekSelectHeaderHD(tblhttgltd, tbl_details);
		} );
		
		tblhttgltd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('httgltd');
			id_iitxxmh_old = 0, id_iicxxmh_old = 0, id_iigxxmh = 0, id_iigxxmh_old = 0, id_iigx2mh_old = 0, id_httgltd_old = 0;

			// atur hak akses
			tbl_details = [tblhttgltd_d];
			CekDeselectHeaderHD(tblhttgltd, tbl_details);
		} );

		// END httgltd
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhttgltd.rows().deselect();
				tblhttgltd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhttgltd').modal('toggle');
			}, false);
				return false;
			}
		});
		
		// BEGIN httgltd_d

		edthttgltd_d = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/httgltd/httgltd_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httgltd_d = show_deleted_httgltd_d;
					d.id_httgltd = id_httgltd;
				}
			},
			table: "#tblhttgltd_d",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "httgltd_d.start_at",
					name: "httgltd_d.start_at",
					type: "hidden"
				},	
				{
					label: "httgltd_d.finish_at",
					name: "httgltd_d.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "httgltd_d",
					type: "hidden"
				},	
				{
					label: "httgltd_d.transaction_state",
					name: "httgltd_d.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_httgltd",
					name: "httgltd_d.id_httgltd",
					type: "hidden"
				},
				{
					label: "nama_tabel",
					name: "httgltd_d.nama_tabel",
					type: "hidden"
				},
				{
					label: "nama",
					name: "httgltd_d.nama",
					type: "hidden"
				},
				{
					label: "Jenis <sup class='text-danger'>*<sup>",
					name: "httgltd_d.jenis",
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
					name: "httgltd_d.id_transaksi",
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
			
		edthttgltd_d.on( 'preOpen', function( e, mode, action ) {
			edthttgltd_d.field('httgltd_d.id_httgltd').val(id_httgltd);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttgltd_d.field('httgltd_d.start_at').val(start_at);
			edthttgltd_d.field('httgltd_d.id_transaksi').hide();
			
			if(action == 'create'){
				tblhttgltd_d.rows().deselect();
			}
		});

		edthttgltd_d.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		

		edthttgltd_d.dependent( 'httgltd_d.jenis', function ( val, data, callback ) {
			if (val !== '') {
				edthttgltd_d.field('httgltd_d.id_transaksi').show();
				var opt_custom;
				if (val === 'Department') {
					edthttgltd_d.field('httgltd_d.nama_tabel').val('hodxxmh');
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
					edthttgltd_d.field('httgltd_d.nama_tabel').val('hosxxmh');
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
					edthttgltd_d.field('httgltd_d.nama_tabel').val('hetxxmh');
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
					edthttgltd_d.field('httgltd_d.nama_tabel').val('hevxxmh');
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

		edthttgltd_d.dependent( 'httgltd_d.id_transaksi', function ( val, data, callback ) {
			if (val > 0) {
				nama_tabel  = edthttgltd_d.field('httgltd_d.nama_tabel').val();
				autofillField(nama_tabel, val, 'nama')
				nama = autofillData.nama;
				edthttgltd_d.field('httgltd_d.nama').val(nama);
			}
			return {}
		}, {event: 'keyup change'});
		
		edthttgltd_d.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				// set variable
				id_transaksi      = edthttgltd_d.field('httgltd_d.id_transaksi').val();
				jenis = edthttgltd_d.field('httgltd_d.jenis').val();

				validasiRequired(
					edthttgltd_d,
					'httgltd_d',
					{
						'id_transaksi': id_transaksi,
						'jenis': jenis
					}
				);
				
			}
			
			if ( edthttgltd_d.inError() ) {
				return false;
			}
		});

		edthttgltd_d.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttgltd_d.field('httgltd_d.finish_at').val(finish_at);
		});
			
		edthttgltd_d.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhttgltd_d.ajax.reload(null, false);			

		} );

		edthttgltd_d.on( 'close', function () {
			edthttgltd_d.enable();
		} );

		tblhttgltd_d = $('#tblhttgltd_d').DataTable( {
			ajax: {
				url: "../../models/httgltd/httgltd_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httgltd_d = show_deleted_httgltd_d;
					d.id_httgltd = id_httgltd;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "httgltd_d.id",visible:false },
				{ data: "httgltd_d.id_httgltd",visible:false },
				{ data: "httgltd_d.jenis" },
				{ data: "httgltd_d.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_httgltd_d';
					$table       = 'tblhttgltd_d';
					$edt         = 'edthttgltd_d';
					$show_status = '_httgltd_d';
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

		tblhttgltd_d.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhttgltd_d, 0 );
			CekDrawDetailHDFinal(tblhttgltd);

		} );

		tblhttgltd_d.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('httgltd_d');
			id_transaksi_old      = httgltd_d_data.id_transaksi;
			is_default_old      = httgltd_d_data.is_default;
			
			// atur hak akses
			CekSelectDetailHD( tblhttgltd_d );

		} );

		tblhttgltd_d.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('httgltd_d');
			id_httgltd_d = 0;
			id_transaksi_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhttgltd_d );

		} );

		// END httgltd_d

	} );// end of document.ready
	
</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
<!--  -->