<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hatemth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hatemtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhatemth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhatemth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode</th>
								<th>Tanggal Efektif</th>
								<th>Nama Karyawan</th>
								<th>State</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhatemtd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhatemtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhatemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hatemth</th>
										<th>Kompensasi</th>
										<th>Nominal</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhatemtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhatemtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hatemth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hatemth/fn/hatemth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthatemth, tblhatemth, show_deleted_hatemth = 0, id_hatemth;
	var edthatemtd, tblhatemtd, show_deleted_hatemtd = 0, id_hatemtd;
	var id_hemxxmh_old = 0, id_hetxxmh_ditawarkan_old = 0, id_hetxxmh_dilamar_old = 0, id_hpcxxmh_old = 0;
	var id_hovxxmh_old = 0, id_hodxxmh_old = 0, id_hosxxmh_old = 0, id_hetxxmh_old = 0, id_hevxxmh_old = 0, id_hattpmh_old = 0, id_hesxxmh_old = 0, id_holxxmh_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hatemth');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hatemth
		edthatemth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hatemth/hatemth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hatemth = show_deleted_hatemth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhatemth",
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
					label: "hatemth.start_at",
					name: "hatemth.start_at",
					type: "hidden"
				},	
				{
					label: "hatemth.finish_at",
					name: "hatemth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hatemth",
					type: "hidden"
				},	
				{
					label: "hatemth.transaction_state",
					name: "hatemth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama Karyawan <sup class='text-danger'>*<sup>", 
					name: "hatemth.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
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
					label: "Type <sup class='text-danger'>*<sup>",
					name: "hatemth.id_hattpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hattpmh/hattpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hattpmh_old: id_hattpmh_old,
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
					label: "Tanggal Efektif<sup class='text-danger'>*<sup>",
					name: "hatemth.tanggal",
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
					label: "Akasan",
					name: "hatemth.alasan",
					type: "textarea",
				},
			]
		} );
		
		edthatemth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthatemth.field('hatemth.start_at').val(start_at);

			if(action == 'create'){
				tblhatemth.rows().deselect();
			}
		});

		edthatemth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthatemth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hattpmh = edthatemth.field('hatemth.id_hattpmh').val();
				tanggal = edthatemth.field('hatemth.tanggal').val();
				id_hemxxmh = edthatemth.field('hatemth.id_hemxxmh').val();

				validasiRequired(
					edthatemth,
					'hatemth',
					{
						'id_hattpmh': id_hattpmh,
						'tanggal': tanggal,
						'id_hemxxmh': id_hemxxmh,
					}
				);

			}
			
			if ( edthatemth.inError() ) {
				return false;
			}
		});

		edthatemth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthatemth.field('hatemth.finish_at').val(finish_at);
		});
		
		edthatemth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthatemth.on( 'close', function () {
			edthatemth.enable();
		} );
		
		tblhatemth = $('#tblhatemth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hatemth/hatemth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hatemth = show_deleted_hatemth;
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
				{ data: "hatemth.id",visible:false },
				{ data: "hatemth.kode" },
				{ data: "hatemth.tanggal" },
				{ data: "hemxxmh.nama" },
				{ 
					data: "hatemth.transaction_state",
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hatemth';
					$table       = 'tblhatemth';
					$edt         = 'edthatemth';
					$show_status = '_hatemth';
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
				if ( data.hatemth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hatemth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhatemth.searchPanes.container().appendTo('#sphatemth');
		tblhatemth.searchBuilder.container().appendTo( '#sbhatemth' );
		
		tblhatemth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhatemtd];
			CekInitHeaderHD(tblhatemth, tbl_details);
		} );
		
		tblhatemth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hatemth');
			id_hetxxmh_dilamar_old = hatemth_data.id_hetxxmh_dilamar;
			id_hetxxmh_ditawarkan_old = hatemth_data.id_hetxxmh_ditawarkan;
			id_hattpmh_old = hatemth_data.id_hattpmh;
			id_hevxxmh_old = hatemth_data.id_hevxxmh;
			id_hovxxmh_old = hatemth_data.id_hovxxmh;
			id_hovxxmh_old = hatemth_data.id_hovxxmh;
			id_hodxxmh_old = hatemth_data.id_hodxxmh;
			id_hosxxmh_old = hatemth_data.id_hosxxmh;
			id_holxxmh_old = hatemth_data.id_holxxmh;
			id_hemxxmh_old = hatemth_data.id_hemxxmh;
			
			// atur hak akses
			tbl_details = [tblhatemtd];
			CekSelectHeaderHD(tblhatemth, tbl_details);

		} );
		
		tblhatemth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hatemth');
			id_hetxxmh_dilamar_old = 0;
			id_hetxxmh_ditawarkan_old = 0;
			id_hattpmh_old = 0;
			id_hevxxmh_old = 0;
			id_hovxxmh_old = 0;
			id_hovxxmh_old = 0;
			id_hodxxmh_old = 0;
			id_hosxxmh_old = 0;
			id_holxxmh_old = 0;
			id_hemxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblhatemtd];
			CekDeselectHeaderHD(tblhatemth, tbl_details);
		} );
		// END hatemth

		// BEGIN hatemtd
		edthatemtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hatemth/hatemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hatemtd = show_deleted_hatemtd;
					d.id_hatemth = id_hatemth;
				}
			},
			table: "#tblhatemtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hatemtd.start_at",
					name: "hatemtd.start_at",
					type: "hidden"
				},	
				{
					label: "hatemtd.finish_at",
					name: "hatemtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hatemtd",
					type: "hidden"
				},	
				{
					label: "hatemtd.transaction_state",
					name: "hatemtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hatemth",
					name: "hatemtd.id_hatemth",
					type: "hidden"
				},	
				{
					label: "Kompensasi <sup class='text-danger'>*<sup>", 
					name: "hatemtd.id_hpcxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hattpmh/hattpmh_hpcxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hpcxxmh_old: id_hpcxxmh_old,
									id_hattpmh_old: id_hattpmh_old,
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
					label: "Nominal <sup class='text-danger'>*<sup>", 
					name: "hatemtd.nominal",
				},
			]
		} );

		edthatemtd.on( 'preOpen', function( e, mode, action ) {
			edthatemtd.field('hatemtd.id_hatemth').val(id_hatemth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthatemtd.field('hatemtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhatemtd.rows().deselect();
			}
		});

		edthatemtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthatemtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hpcxxmh = edthatemtd.field('hatemtd.id_hpcxxmh').val();
				nominal = edthatemtd.field('hatemtd.nominal').val();

				validasiRequired(
					edthatemtd,
					'hatemtd',
					{
						'id_hpcxxmh': id_hpcxxmh,
						'nominal': nominal,
					}
				);
				
				validasiNumber(
					edthatemtd,
					'hatemtd',
					{
						'nominal': nominal,
					},
					0,
					'>'
				);
			}
			
			if ( edthatemtd.inError() ) {
				return false;
			}
		});

		edthatemtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthatemtd.field('hatemtd.finish_at').val(finish_at);
		});
			
		edthatemtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhatemth.ajax.reload(null, false);
			tblhatemtd.rows().deselect();
			tblhatemtd.ajax.reload(null, false);
		} );

		edthatemtd.on( 'close', function () {
			edthatemtd.enable();
		} );
		
		tblhatemtd = $('#tblhatemtd').DataTable( {
			ajax: {
				url: "../../models/hatemth/hatemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hatemtd = show_deleted_hatemtd;
					d.id_hatemth = id_hatemth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hatemtd.id",visible:false },
				{ data: "hatemtd.id_hatemth",visible:false },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "hatemtd.nominal",
					...renderNumber()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hatemtd';
					$table       = 'tblhatemtd';
					$edt         = 'edthatemtd';
					$show_status = '_hatemtd';
					$table_name  = $nama_tabels_d[0];

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
			}
		} );

		tblhatemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhatemtd, 1 );
			CekDrawDetailHDFinal(tblhatemth);
		} );

		tblhatemtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hatemtd');
			id_hpcxxmh_old = hatemtd_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhatemtd );
		} );

		tblhatemtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hatemtd');
			id_hpcxxmh_old = 0;
			// atur hak akses
			CekDeselectDetailHD( tblhatemtd );
		} );
		// END hatemtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhatemth.rows().deselect();
				tblhatemth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhatemth').modal('toggle');
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
