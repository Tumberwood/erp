<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hrctsth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hrctstd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhrctsth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhrctsth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Tanggal</th>
								<th>Kode</th>
								<th>Panggilan Kandidat</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhrctstd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhrctstd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhrctstd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrctsth</th>
										<th>Kode Tes</th>
										<th>Nama Kandidat</th>
										<th>Jenis Tes</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhrctstd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhrctstd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrctsth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsth/fn/hrctsth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthrctsth, tblhrctsth, show_deleted_hrctsth = 0, id_hrctsth;
	var edthrctstd, tblhrctstd, show_deleted_hrctstd = 0, id_hrctstd;
	var id_hcdxxmh_old = 0, id_hetxxmh_ditawarkan_old = 0, id_hetxxmh_dilamar_old = 0, id_hrctsmh_old = 0;
	var id_hovxxmh_old = 0, id_hodxxmh_old = 0, id_hosxxmh_old = 0, id_hetxxmh_old = 0, id_hevxxmh_old = 0, id_heyxxmh_old = 0, id_hesxxmh_old = 0, id_holxxmh_old = 0;
	var id_hrcemtd_old = 0, id_hrccdth_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hrctsth');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hrctsth
		edthrctsth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrctsth/hrctsth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctsth = show_deleted_hrctsth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhrctsth",
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
					label: "hrctsth.start_at",
					name: "hrctsth.start_at",
					type: "hidden"
				},	
				{
					label: "hrctsth.finish_at",
					name: "hrctsth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrctsth",
					type: "hidden"
				},	
				{
					label: "hrctsth.transaction_state",
					name: "hrctsth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal<sup class='text-danger'>*<sup>",
					name: "hrctsth.tanggal",
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
					label: "Panggilan Kandidat <sup class='text-danger'>*<sup>",
					name: "hrctsth.id_hrccdth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hrccdth/hrccdth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hrccdth_old: id_hrccdth_old,
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
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: "Notes",
					name: "hrctsth.keterangan",
					type: "textarea",
				},
			]
		} );
		
		edthrctsth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctsth.field('hrctsth.start_at').val(start_at);

			if(action == 'create'){
				tblhrctsth.rows().deselect();
			}
		});

		edthrctsth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});
		
		edthrctsth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal = edthrctsth.field('hrctsth.tanggal').val();
				id_hrccdth = edthrctsth.field('hrctsth.id_hrccdth').val();
				
				validasiRequired(
					edthrctsth,
					'hrctsth',
					{
						'tanggal': tanggal,
						'id_hrccdth': id_hrccdth,
					}
				);

			}
			
			if ( edthrctsth.inError() ) {
				return false;
			}
		});

		edthrctsth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctsth.field('hrctsth.finish_at').val(finish_at);
		});
		
		edthrctsth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthrctsth.on( 'close', function () {
			edthrctsth.enable();
		} );
		
		tblhrctsth = $('#tblhrctsth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrctsth/hrctsth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctsth = show_deleted_hrctsth;
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
				{ data: "hrctsth.id",visible:false },
				{ data: "hrctsth.tanggal" },
				{ data: "hrctsth.kode" },
				{ data: "hrccdth.kode" },
				{ 
					data: "hrctsth.transaction_state",
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrctsth';
					$table       = 'tblhrctsth';
					$edt         = 'edthrctsth';
					$show_status = '_hrctsth';
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
				if ( data.hrctsth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrctsth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrctsth.searchPanes.container().appendTo('#sphrctsth');
		tblhrctsth.searchBuilder.container().appendTo( '#sbhrctsth' );
		
		tblhrctsth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhrctstd];
			CekInitHeaderHD(tblhrctsth, tbl_details);
		} );
		
		tblhrctsth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrctsth');
			id_hrccdth_old = hrctsth_data.id_hrccdth;
			
			// atur hak akses
			tbl_details = [tblhrctstd];
			CekSelectHeaderHD(tblhrctsth, tbl_details);

		} );
		
		tblhrctsth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrctsth');
			id_hrccdth_old = 0;

			// atur hak akses
			tbl_details = [tblhrctstd];
			CekDeselectHeaderHD(tblhrctsth, tbl_details);
		} );
		// END hrctsth

		// BEGIN hrctstd
		edthrctstd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrctsth/hrctstd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd = show_deleted_hrctstd;
					d.id_hrctsth = id_hrctsth;
				}
			},
			table: "#tblhrctstd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hrctstd.start_at",
					name: "hrctstd.start_at",
					type: "hidden"
				},	
				{
					label: "hrctstd.finish_at",
					name: "hrctstd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrctstd",
					type: "hidden"
				},	
				{
					label: "hrctstd.transaction_state",
					name: "hrctstd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hrctsth",
					name: "hrctstd.id_hrctsth",
					type: "hidden"
				},	
				{
					label: "Nama Kandidat <sup class='text-danger'>*<sup>", 
					name: "hrctstd.id_hcdxxmh",
					type: "hidden"
				},
				{
					label: "Nama Kandidat <sup class='text-danger'>*<sup>", 
					name: "hrctstd.id_hrcemtd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hrccdth/hrccdth_hrcemtd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hrccdth: id_hrccdth_old,
									id_hrcemtd_old: id_hrcemtd_old,
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
					label: "Jenis Psikotes <sup class='text-danger'>*<sup>", 
					name: "hrctstd.id_hrctsmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hrctsmh/hrctsmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hrctsmh_old: id_hrctsmh_old,
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

		edthrctstd.on( 'preOpen', function( e, mode, action ) {
			edthrctstd.field('hrctstd.id_hrctsth').val(id_hrctsth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd.field('hrctstd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrctstd.rows().deselect();
			}
		});

		edthrctstd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edthrctstd.dependent( 'hrctstd.id_hrcemtd', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('hrcemtd', val, 'id_hcdxxmh');
				id_hcdxxmh = autofillData.id_hcdxxmh;
				console.log(id_hcdxxmh);
				
				edthrctstd.field('hrctstd.id_hcdxxmh').val(id_hcdxxmh);
			}
			return {}
		}, {event: 'keyup change'});
		
		edthrctstd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hrctsmh = edthrctstd.field('hrctstd.id_hrctsmh').val();
				id_hcdxxmh = edthrctstd.field('hrctstd.id_hcdxxmh').val();
				id_hrcemtd = edthrctstd.field('hrctstd.id_hrcemtd').val();

				validasiRequired(
					edthrctstd,
					'hrctstd',
					{
						'id_hrctsmh': id_hrctsmh,
						'id_hcdxxmh': id_hcdxxmh,
						'id_hrcemtd': id_hrcemtd,
					}
				);

				validasiUnique(
					action,
					edthrctstd, 
					"hrctstd", 
					"id_hrctsmh,id_hcdxxmh,id_hrctsth", 
					'id_hrctsmh,id_hcdxxmh,id_hrctsth',
					id_hrctsmh+","+id_hcdxxmh+","+id_hrctsth,
					id_hrctstd
				);
			}
			
			if ( edthrctstd.inError() ) {
				return false;
			}
		});

		edthrctstd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd.field('hrctstd.finish_at').val(finish_at);
		});
			
		edthrctstd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhrctsth.ajax.reload(null, false);
			tblhrctstd.rows().deselect();
			tblhrctstd.ajax.reload(null, false);
		} );

		edthrctstd.on( 'close', function () {
			edthrctstd.enable();
		} );
		
		tblhrctstd = $('#tblhrctstd').DataTable( {
			ajax: {
				url: "../../models/hrctsth/hrctstd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd = show_deleted_hrctstd;
					d.id_hrctsth = id_hrctsth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hrctstd.id",visible:false },
				{ data: "hrctstd.id_hrctsth",visible:false },
				{ data: "hrctstd.kode" },
				{ data: "hcdxxmh.nama" },
				{ data: "hrctsmh.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrctstd';
					$table       = 'tblhrctstd';
					$edt         = 'edthrctstd';
					$show_status = '_hrctstd';
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

		tblhrctstd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhrctstd, 1 );
			CekDrawDetailHDFinal(tblhrctsth);
		} );

		tblhrctstd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hrctstd');
			id_hrctsmh_old = hrctstd_data.id_hrctsmh;
			id_hcdxxmh_old = hrctstd_data.id_hcdxxmh;
			id_hrcemtd_old = hrctstd_data.id_hrcemtd;
			
			// atur hak akses
			CekSelectDetailHD( tblhrctstd );
		} );

		tblhrctstd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hrctstd');
			id_hrctsmh_old = 0;
			id_hcdxxmh_old = 0;
			id_hrcemtd_old = 0;
			// atur hak akses
			CekDeselectDetailHD( tblhrctstd );
		} );
		// END hrctstd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhrctsth.rows().deselect();
				tblhrctsth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhrctsth').modal('toggle');
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
