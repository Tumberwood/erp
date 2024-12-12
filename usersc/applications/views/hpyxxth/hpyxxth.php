<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hpyxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hpyemtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhpyxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhpyxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal Awal</th>
                                <th>Periode</th>
                                <th>Keterangan</th>
                                <th>Generated On</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhpyemtd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabhpyemtd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhpyemtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<div id="tabel_atas"></div>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhpyemtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhpyemtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hpyxxth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hpyxxth/fn/hpyxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthpyxxth, tblhpyxxth, show_deleted_hpyxxth = 0, id_hpyxxth;
	var edthpyemtd, tblhpyemtd, show_deleted_hpyemtd = 0, id_hpyemtd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hpyxxth');
	generateTable(id_hpyxxth);

	$(document).ready(function() {
		
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hpyxxth
		edthpyxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hpyxxth/hpyxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyxxth = show_deleted_hpyxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhpyxxth",
			fields: [ 
				{
					label: "hpyxxth.start_at",
					name: "hpyxxth.start_at",
					type: "hidden"
				},	
				{
					label: "hpyxxth.finish_at",
					name: "hpyxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hpyxxth",
					type: "hidden"
				},	
				{
					label: "hpyxxth.transaction_state",
					name: "hpyxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal Awal <sup class='text-danger'>*<sup>",
					name: "hpyxxth.tanggal_awal",
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
					label: "Tanggal Akhir <sup class='text-danger'>*<sup>",
					name: "hpyxxth.tanggal_akhir",
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
					name: "hpyxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthpyxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpyxxth.field('hpyxxth.start_at').val(start_at);

			if(action == 'create'){
				tblhpyxxth.rows().deselect();
			}
		});

		edthpyxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthpyxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_awal = edthpyxxth.field('hpyxxth.tanggal_awal').val();
				tanggal_akhir = edthpyxxth.field('hpyxxth.tanggal_akhir').val();

				validasiRequired(
					edthpyxxth,
					'hpyxxth',
					{
						'tanggal_awal': tanggal_awal,
						'tanggal_akhir': tanggal_akhir
					}
				);

				validasiUnique(
					action,
					edthpyxxth,
					'hpyxxth',
					'tanggal_awal',
					'tanggal_awal',
					'"'+tanggal_awal+'"',
					id_hpyxxth
				);

				validasiUnique(
					action,
					edthpyxxth,
					'hpyxxth',
					'tanggal_akhir',
					'tanggal_akhir',
					'"'+tanggal_akhir+'"',
					id_hpyxxth
				);
			}
			
			if ( edthpyxxth.inError() ) {
				return false;
			}
		});

		edthpyxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpyxxth.field('hpyxxth.finish_at').val(finish_at);
		});
		
		edthpyxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthpyxxth.on( 'close', function () {
			edthpyxxth.enable();
		} );
		
		tblhpyxxth = $('#tblhpyxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hpyxxth/hpyxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyxxth = show_deleted_hpyxxth;
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
				{ data: "hpyxxth.id",visible:false },
				{ data: "hpyxxth.tanggal_awal",visible:false },
				{ 
					data: null ,
					render: function (data, type, row) {
						return row.hpyxxth.tanggal_awal + " - " + row.hpyxxth.tanggal_akhir;
					}
				},
				{ data: "hpyxxth.keterangan" },
				{ data: "hpyxxth.generated_on" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hpyxxth';
					$table       = 'tblhpyxxth';
					$edt         = 'edthpyxxth';
					$show_status = '_hpyxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [ 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnGenPayroll',
					className: 'btn btn-xs btn-outline',
					titleAttr: '',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');

						toastr.info("Processing ...\nJangan tutup halaman sampai notifikasi ini hilang!", "INFO");

						$.ajax( {
							url: "../../models/hpyxxth/hpyxxth_fn_gen_payroll_dinamis.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_hpyxxth		: id_hpyxxth,
								tanggal_awal	: tanggal_awal_select,
								tanggal_akhir	: tanggal_akhir_select,
								timestamp		: timestamp
							},
							success: function ( json ) {
								// hilangkan toastr awal
								toastr.clear();

								full_message = json.data.message + '</br>';
								toast_type   = json.data.type_message;

								// tampilkan toastr baru
								toastr[toast_type](full_message, 'INFO');

								tblhpyxxth.ajax.reload(function ( json ) {
								}, false);
							}
						} );
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hpyxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hpyxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhpyxxth.searchPanes.container().appendTo('#sphpyxxth');
		tblhpyxxth.searchBuilder.container().appendTo( '#sbhpyxxth' );
		tblhpyxxth.button('btnGenPayroll:name').disable();
		
		tblhpyxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhpyemtd];
			CekInitHeaderHD(tblhpyxxth, tbl_details);
		} );
		
		tblhpyxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hpyxxth');
			tanggal_awal_select        = hpyxxth_data.tanggal_awal;
			tanggal_akhir_select       = hpyxxth_data.tanggal_akhir;
			
			// atur hak akses
			tbl_details = [tblhpyemtd];
			CekSelectHeaderHD(tblhpyxxth, tbl_details);
			tblhpyxxth.button('btnGenPayroll:name').enable();
			generateTable(id_hpyxxth);
		} );
		
		tblhpyxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hpyxxth');
			tanggal_awal_select        = '';
			tanggal_akhir_select       = '';

			// atur hak akses
			tbl_details = [tblhpyemtd];
			CekDeselectHeaderHD(tblhpyxxth, tbl_details);
			tblhpyxxth.button('btnGenPayroll:name').disable();
			tableAwal();
		} );
		// END hpyxxth
		
		tblhpyemtd = $('#tblhpyemtd').DataTable( {
			ajax: {
				url: "../../models/hpyxxth/hpyemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpyemtd = show_deleted_hpyemtd;
					d.id_hpyxxth = id_hpyxxth;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			columns: [
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hpyemtd';
					$table       = 'tblhpyemtd';
					$edt         = 'edthpyemtd';
					$show_status = '_hpyemtd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [];
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
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 

				for (var i = 8; i <= 18; i++) {
					var columnIndex = i;
					var sum_all = api.column(columnIndex).data().sum();
					// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
					var sum = api.column(columnIndex, { page: 'current' }).data().sum();
					$('#hpy_' + columnIndex).html(numFormat(sum_all));

					// console.log('Number of Pages: ' + api.page.info().pages);
				}
			}
		} );

		tblhpyemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhpyemtd, 1 );
			CekDrawDetailHDFinal(tblhpyxxth);
		} );

		tblhpyemtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hpyemtd');
			
			// atur hak akses
			CekSelectDetailHD( tblhpyemtd );
		} );

		tblhpyemtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hpyemtd');
			
			// atur hak akses
			CekDeselectDetailHD( tblhpyemtd );
		} );
		// END hpyemtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhpyxxth.rows().deselect();
				tblhpyxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhpyxxth').modal('toggle');
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
