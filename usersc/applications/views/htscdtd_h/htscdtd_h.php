<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'htscdtd_h';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htscdtd_peg';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhtscdtd_h" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhtscdtd_h" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Department</th>
								<th>Tanggal Terpilih</th>
								<th>Tanggal Pengganti</th>
                                <th>Keterangan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtscdtd_peg_1"> Employee</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabhtscdtd_peg_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtscdtd_peg_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtscdtd_peg" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_htscdtd_h</th>
										<th>NIK</th>
										<th>Nama</th>
										<th>Department</th>
										<th>Jabatan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhtscdtd_peg_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtscdtd_peg_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_htscdtd_h</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htscdtd_h/fn/htscdtd_h_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthtscdtd_h, tblhtscdtd_h, show_deleted_htscdtd_h = 0, id_htscdtd_h;
	var edthtscdtd_peg, tblhtscdtd_peg, show_deleted_htscdtd_peg = 0, id_htscdtd_peg;
	// ------------- end of default variable

	var ids_hodxxmh_old = '';
	var id_hemxxmh_old = 0;

	// get tableRelation
	tableRelation('htscdtd_h');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN htscdtd_h
		edthtscdtd_h = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htscdtd_h/htscdtd_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htscdtd_h = show_deleted_htscdtd_h;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhtscdtd_h",
			fields: [ 
				{
					label: "htscdtd_h.start_at",
					name: "htscdtd_h.start_at",
					type: "hidden"
				},	
				{
					label: "htscdtd_h.finish_at",
					name: "htscdtd_h.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htscdtd_h",
					type: "hidden"
				},	
				{
					label: "htscdtd_h.transaction_state",
					name: "htscdtd_h.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Department <sup class='text-danger'>*<sup>",
					name: "hodxxmh[].id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt_multiple.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									ids_hodxxmh_old: ids_hodxxmh_old,
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "htscdtd_h.tanggal_terpilih",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01')
					},
					format: 'DD MMM YYYY'
				}, 	{
					label: "Tukar Dengan Tanggal <sup class='text-danger'>*<sup>",
					name: "htscdtd_h.tanggal_pengganti",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01')
					},
					format: 'DD MMM YYYY'
				}, 	{
					label: "Keterangan <sup class='text-danger'>*<sup>",
					name: "htscdtd_h.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthtscdtd_h.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtscdtd_h.field('htscdtd_h.start_at').val(start_at);

			if(action == 'create'){
				tblhtscdtd_h.rows().deselect();
			}
		});

		edthtscdtd_h.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthtscdtd_h.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_terpilih = edthtscdtd_h.field('htscdtd_h.tanggal_terpilih').val();
				tanggal_pengganti = edthtscdtd_h.field('htscdtd_h.tanggal_pengganti').val();

				validasiRequired(
					edthtscdtd_h,
					'htscdtd_h',
					{
						'tanggal_terpilih': tanggal_terpilih,
						'tanggal_pengganti': tanggal_pengganti
					}
				);

				id_hodxxmh = edthtscdtd_h.field('hodxxmh[].id').val();
				if(!id_hodxxmh || id_hodxxmh == ''){
					edthtscdtd_h.field('hodxxmh[].id').error( 'htscdtd_peg!' );
				}
			}
			
			if ( edthtscdtd_h.inError() ) {
				return false;
			}
		});

		edthtscdtd_h.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtscdtd_h.field('htscdtd_h.finish_at').val(finish_at);
		});
		
		edthtscdtd_h.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtscdtd_h.on( 'close', function () {
			edthtscdtd_h.enable();
		} );
		
		tblhtscdtd_h = $('#tblhtscdtd_h').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htscdtd_h/htscdtd_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htscdtd_h = show_deleted_htscdtd_h;
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
				{ data: "htscdtd_h.id",visible:false },
				{ data: "htscdtd_h.kode" },
				{ data: "hodxxmh[].nama" },
				{ data: "htscdtd_h.tanggal_terpilih" },
				{ data: "htscdtd_h.tanggal_pengganti" },
				{ data: "htscdtd_h.keterangan" },
				{ 
						data: "htscdtd_h.approval_state",
						...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htscdtd_h';
					$table       = 'tblhtscdtd_h';
					$edt         = 'edthtscdtd_h';
					$show_status = '_htscdtd_h';
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
				if ( data.htscdtd_h.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htscdtd_h.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtscdtd_h.searchPanes.container().appendTo('#sphtscdtd_h');
		tblhtscdtd_h.searchBuilder.container().appendTo( '#sbhtscdtd_h' );
		
		tblhtscdtd_h.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtscdtd_peg];
			CekInitHeaderHD(tblhtscdtd_h, tbl_details);
		} );
		
		tblhtscdtd_h.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('htscdtd_h');
			tblhtscdtd_h.rows( { selected: true } ).data().each(function (row) {
				if (row.hodxxmh) {
					ids_hodxxmh_old = "";
					row.hodxxmh.forEach(function (hodxxmh_data) {
						ids_hodxxmh_old = ids_hodxxmh_old + "," + hodxxmh_data.id;
					});
					ids_hodxxmh_old = ids_hodxxmh_old.substring(1);
				}
			});
			
			// atur hak akses
			tbl_details = [tblhtscdtd_peg];
			CekSelectHeaderHD(tblhtscdtd_h, tbl_details);

		} );
		
		tblhtscdtd_h.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('htscdtd_h');
			ids_hodxxmh_old = '';

			// atur hak akses
			tbl_details = [tblhtscdtd_peg];
			CekDeselectHeaderHD(tblhtscdtd_h, tbl_details);
		} );
		// END htscdtd_h

		// BEGIN htscdtd_peg
		edthtscdtd_peg = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htscdtd_h/htscdtd_peg.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htscdtd_peg = show_deleted_htscdtd_peg;
					d.id_htscdtd_h = id_htscdtd_h;
				}
			},
			table: "#tblhtscdtd_peg",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htscdtd_peg.start_at",
					name: "htscdtd_peg.start_at",
					type: "hidden"
				},	
				{
					label: "htscdtd_peg.finish_at",
					name: "htscdtd_peg.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htscdtd_peg",
					type: "hidden"
				},	
				{
					label: "htscdtd_peg.transaction_state",
					name: "htscdtd_peg.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_htscdtd_h",
					name: "htscdtd_peg.id_htscdtd_h",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "htscdtd_peg.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/htscdtd_h/hemxxmh_fn_opt_department.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
									id_htscdtd_h: id_htscdtd_h,
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
			
		edthtscdtd_peg.on( 'preOpen', function( e, mode, action ) {
			edthtscdtd_peg.field('htscdtd_peg.id_htscdtd_h').val(id_htscdtd_h);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtscdtd_peg.field('htscdtd_peg.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtscdtd_peg.rows().deselect();
			}
		});

		edthtscdtd_peg.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtscdtd_peg.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edthtscdtd_peg.field('htscdtd_peg.id_hemxxmh').val();

				validasiRequired(
					edthtscdtd_peg,
					'htscdtd_peg',
					{
						'id_hemxxmh': id_hemxxmh
					}
				);

				validasiUnique(
					action,
					edthtscdtd_peg,
					'htscdtd_peg',
					'id_hemxxmh',
					'id_hemxxmh',
					'"'+id_hemxxmh+'"',
					id_htscdtd_peg
				);

			}
			
			if ( edthtscdtd_peg.inError() ) {
				return false;
			}
		});

		edthtscdtd_peg.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtscdtd_peg.field('htscdtd_peg.finish_at').val(finish_at);
		});
			
		edthtscdtd_peg.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtscdtd_peg.on( 'close', function () {
			edthtscdtd_peg.enable();
		} );
		
		tblhtscdtd_peg = $('#tblhtscdtd_peg').DataTable( {
			ajax: {
				url: "../../models/htscdtd_h/htscdtd_peg.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htscdtd_peg = show_deleted_htscdtd_peg;
					d.id_htscdtd_h = id_htscdtd_h;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "htscdtd_peg.id",visible:false },
				{ data: "htscdtd_peg.id_htscdtd_h",visible:false },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htscdtd_peg';
					$table       = 'tblhtscdtd_peg';
					$edt         = 'edthtscdtd_peg';
					$show_status = '_htscdtd_peg';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblhtscdtd_peg.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtscdtd_peg, 1 );
			CekDrawDetailHDFinal(tblhtscdtd_h);
		} );

		tblhtscdtd_peg.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('htscdtd_peg');			
			id_hemxxmh_old 		= htscdtd_peg_data.id_hemxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtscdtd_peg );
		} );

		tblhtscdtd_peg.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('htscdtd_peg');
			id_hemxxmh_old = 0;

			// atur hak akses
			CekDeselectDetailHD( tblhtscdtd_peg );
		} );
		// END htscdtd_peg

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhtscdtd_h.rows().deselect();
				tblhtscdtd_h.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhtscdtd_h').modal('toggle');
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
