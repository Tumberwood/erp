<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hrccdth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hrcemtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhrccdth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhrccdth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhrcemtd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhrcemtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhrcemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrccdth</th>
										<th>Request</th>
										<th>Jabatan</th>
										<th>Nama Kandidat</th>
										<th>Tempat</th>
										<th>Agenda</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrccdth/fn/hrccdth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthrccdth, tblhrccdth, show_deleted_hrccdth = 0, id_hrccdth;
	var edthrcemtd, tblhrcemtd, show_deleted_hrcemtd = 0, id_hrcemtd;
	// ------------- end of default variable
	var replacement_select = 0, id_hgnedmh_old = 0, id_hcdxxmh_old = 0, id_hgnlgmh_old = 0, id_hovxxmh_old = 0, id_hodxxmh_old = 0, id_hosxxmh_old = 0, id_hetxxmh_old = 0, id_hevxxmh_old = 0, id_heyxxmh_old = 0, id_hosxxmh_old = 0;
	var id_hrremth_old = 0;

	// get tableRelation
	tableRelation('hrccdth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hrccdth
		edthrccdth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrccdth/hrccdth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrccdth = show_deleted_hrccdth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhrccdth",
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
					label: "hrccdth.start_at",
					name: "hrccdth.start_at",
					type: "hidden"
				},	
				{
					label: "hrccdth.finish_at",
					name: "hrccdth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrccdth",
					type: "hidden"
				},	
				{
					label: "hrccdth.transaction_state",
					name: "hrccdth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",  
					name: "hrccdth.tanggal",
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
					label: "Notes",
					name: "hrccdth.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edthrccdth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrccdth.field('hrccdth.start_at').val(start_at);

			if(action == 'create'){
				tblhrccdth.rows().deselect();
			}
		});

		edthrccdth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});
		
		edthrccdth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edthrccdth.field('hrccdth.tanggal').val();

				validasiRequired(
					edthrccdth,
					'hrccdth',
					{
						'tanggal': tanggal,
					}
				);
			}
			
			if ( edthrccdth.inError() ) {
				return false;
			}
		});

		edthrccdth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrccdth.field('hrccdth.finish_at').val(finish_at);
		});
		
		edthrccdth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhrccdth.ajax.reload(null, false);
		} );

		edthrccdth.on( 'close', function () {
			edthrccdth.enable();
		} );
		
		tblhrccdth = $('#tblhrccdth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrccdth/hrccdth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrccdth = show_deleted_hrccdth;
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
				{ data: "hrccdth.id",visible:false },
				{ data: "hrccdth.kode" },
				{ data: "hrccdth.tanggal" },
				{ 
					data: "hrccdth.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrccdth';
					$table       = 'tblhrccdth';
					$edt         = 'edthrccdth';
					$show_status = '_hrccdth';
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
				if ( data.hrccdth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrccdth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrccdth.searchPanes.container().appendTo('#sphrccdth');
		tblhrccdth.searchBuilder.container().appendTo( '#sbhrccdth' );
		
		tblhrccdth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhrcemtd];
			CekInitHeaderHD(tblhrccdth, tbl_details);
		} );
		
		tblhrccdth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrccdth');
			tbl_details = [tblhrcemtd];
			CekSelectHeaderHD(tblhrccdth, tbl_details);
		} );
		
		tblhrccdth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrccdth');

			// atur hak akses
			tbl_details = [tblhrcemtd];
			CekDeselectHeaderHD(tblhrccdth, tbl_details);
		} );
		// END hrccdth

		// BEGIN hrcemtd
		edthrcemtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrccdth/hrcemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrcemtd = show_deleted_hrcemtd;
					d.id_hrccdth = id_hrccdth;
				}
			},
			table: "#tblhrcemtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hrcemtd.start_at",
					name: "hrcemtd.start_at",
					type: "hidden"
				},	
				{
					label: "hrcemtd.finish_at",
					name: "hrcemtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrcemtd",
					type: "hidden"
				},	
				{
					label: "hrcemtd.transaction_state",
					name: "hrcemtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hrccdth",
					name: "hrcemtd.id_hrccdth",
					type: "hidden"
				},	
				{
					label: "Request <sup class='text-danger'>*<sup>", 
					name: "hrcemtd.id_hrremth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hrremth/hrremth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hrremth_old: id_hrremth_old,
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
					label: "Jabatan",
					name: "hrcemtd.hetxxmh_nama",
					type: "readonly"
				},	
				{
					label: "Nama Kandidat<sup class='text-danger'>*<sup>", 
					name: "hrcemtd.id_hcdxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hcdxxmh/hcdxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hcdxxmh_old: id_hcdxxmh_old,
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
					label: "Email <sup class='text-danger'>*<sup>",
					name: "hrcemtd.email",
					type: "readonly"
				},	
				{
					label: "Handphone <sup class='text-danger'>*<sup>",
					name: "hrcemtd.handphone",
					type: "readonly"
				},	
				{
					label: "Tempat <sup class='text-danger'>*<sup>",
					name: "hrcemtd.tempat",
				},	
				{
					label: "Agenda <sup class='text-danger'>*<sup>",
					name: "hrcemtd.agenda",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Test", "value": "Test" },
						{ "label": "Interview", "value": "Interview" },
						{ "label": "Test dan Interview", "value": "Test dan Interview" },
					]
				},
				{
					label: "Keterangan",
					name: "hrcemtd.keterangan",
					type: "textarea"
				},	
			]
		} );
			
		edthrcemtd.on( 'preOpen', function( e, mode, action ) {
			edthrcemtd.field('hrcemtd.id_hrccdth').val(id_hrccdth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrcemtd.field('hrcemtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrcemtd.rows().deselect();
			}
		});

		edthrcemtd.dependent( 'hrcemtd.id_hcdxxmh', function ( val, data, callback ) {
			if (val > 0) {
				dataKandidat(val);
			}
			return {}
		}, {event: 'keyup change'});

		edthrcemtd.dependent( 'hrcemtd.id_hrremth', function ( val, data, callback ) {
			if (val > 0) {
				dataRequest(val);
			}
			return {}
		}, {event: 'keyup change'});

		edthrcemtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthrcemtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hcdxxmh = edthrcemtd.field('hrcemtd.id_hcdxxmh').val();
				id_hrremth = edthrcemtd.field('hrcemtd.id_hrremth').val();
				tempat = edthrcemtd.field('hrcemtd.tempat').val();
				agenda = edthrcemtd.field('hrcemtd.agenda').val();
				email = edthrcemtd.field('hrcemtd.email').val();
				handphone = edthrcemtd.field('hrcemtd.handphone').val();

				validasiRequired(
					edthrcemtd,
					'hrcemtd',
					{
						'id_hcdxxmh': id_hcdxxmh,
						'id_hrremth': id_hrremth,
						'tempat': tempat,
						'agenda': agenda,
						'email': email,
						'handphone': handphone,
					}
				);
			}
			
			if ( edthrcemtd.inError() ) {
				return false;
			}
		});

		edthrcemtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrcemtd.field('hrcemtd.finish_at').val(finish_at);
		});
			
		edthrcemtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhrccdth.ajax.reload(null, false);
		} );

		edthrcemtd.on( 'close', function () {
			edthrcemtd.enable();
		} );
		
		tblhrcemtd = $('#tblhrcemtd').DataTable( {
			ajax: {
				url: "../../models/hrccdth/hrcemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrcemtd = show_deleted_hrcemtd;
					d.id_hrccdth = id_hrccdth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hrcemtd.id",visible:false },
				{ data: "hrcemtd.id_hrccdth",visible:false },
				{ data: "hrremth.kode" },
				{ data: "hcdxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ data: "hrcemtd.tempat" },
				{ data: "hrcemtd.agenda" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrcemtd';
					$table       = 'tblhrcemtd';
					$edt         = 'edthrcemtd';
					$show_status = '_hrcemtd';
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

		tblhrcemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhrcemtd, 1 );
			CekDrawDetailHDFinal(tblhrccdth);
		} );

		tblhrcemtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hrcemtd');
			id_hcdxxmh_old   = hrcemtd_data.id_hcdxxmh;
			id_hrremth_old   = hrcemtd_data.id_hrremth;
			
			// atur hak akses
			CekSelectDetailHD( tblhrcemtd );
		} );

		tblhrcemtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hrcemtd');
			id_hcdxxmh_old   = 0;
			id_hrremth_old   = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhrcemtd );
		} );
		// END hrcemtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhrccdth.rows().deselect();
				tblhrccdth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhrccdth').modal('toggle');
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
