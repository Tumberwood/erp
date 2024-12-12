<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'si_training_h';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'si_training_d';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFsi_training_h" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblsi_training_h" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul Pelatihan</th>
                                <th>Tanggal</th>
                                <th>Pemateri</th>
                                <th>Angkatan</th>
                                <th>Step</th>
                                <th>Pertemuan</th>
                                <th>Keterangan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabsi_training_d_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabsi_training_d_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsi_training_d_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsi_training_d" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_si_training_h</th>
										<th>Nama</th>
										<th>No Whatsapp</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabsi_training_d_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsi_training_d_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_si_training_h</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/si_training_h/fn/si_training_h_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtsi_training_h, tblsi_training_h, show_deleted_si_training_h = 0, id_si_training_h;
	var edtsi_training_d, tblsi_training_d, show_deleted_si_training_d = 0, id_si_training_d;
	// ------------- end of default variable
	var id_si_training_peserta_m_old = 0;

	// get tableRelation
	tableRelation('si_training_h');

	$(document).ready(function() {
		$('#end_date').datepicker('setDate', today_add_m_dmy);

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN si_training_h
		edtsi_training_h = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/si_training_h/si_training_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_si_training_h = show_deleted_si_training_h;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblsi_training_h",
			fields: [ 
				{
					label: "si_training_h.start_at",
					name: "si_training_h.start_at",
					type: "hidden"
				},	
				{
					label: "si_training_h.finish_at",
					name: "si_training_h.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "si_training_h",
					type: "hidden"
				},	
				{
					label: "si_training_h.transaction_state",
					name: "si_training_h.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Judul Pelatihan <sup class='text-danger'>*<sup>",
					name: "si_training_h.judul"
				}, 	
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "si_training_h.tanggal",
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
					label: "Pemateri <sup class='text-danger'>*<sup>",
					name: "si_training_h.pemateri"
				}, 	
				{
					label: "Angkatan <sup class='text-danger'>*<sup>",
					name: "si_training_h.angkatan"
				}, 	
				{
					label: "Step <sup class='text-danger'>*<sup>",
					name: "si_training_h.step"
				}, 	
				{
					label: "Pertemuan <sup class='text-danger'>*<sup>",
					name: "si_training_h.pertemuan"
				}, 	
				{
					label: "Keterangan",
					name: "si_training_h.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtsi_training_h.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsi_training_h.field('si_training_h.start_at').val(start_at);

			if(action == 'create'){
				tblsi_training_h.rows().deselect();
			}
		});

		edtsi_training_h.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtsi_training_h.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtsi_training_h.field('si_training_h.tanggal').val();
				judul = edtsi_training_h.field('si_training_h.judul').val();
				pemateri = edtsi_training_h.field('si_training_h.pemateri').val();
				angkatan = edtsi_training_h.field('si_training_h.angkatan').val();
				step = edtsi_training_h.field('si_training_h.step').val();
				pertemuan = edtsi_training_h.field('si_training_h.pertemuan').val();

				validasiRequired(
					edtsi_training_h,
					'si_training_h',
					{
						'tanggal': tanggal,
						'judul': judul,
						'pemateri': pemateri,
						'angkatan': angkatan,
						'step': step,
						'pertemuan': pertemuan,
					}
				);

				validasiUnique(
					action,
					edtsi_training_h,
					'si_training_h',
					'judul',
					'judul',
					'"'+judul+'"',
					id_si_training_h
				);
			}
			
			if ( edtsi_training_h.inError() ) {
				return false;
			}
		});

		edtsi_training_h.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsi_training_h.field('si_training_h.finish_at').val(finish_at);
		});
		
		edtsi_training_h.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtsi_training_h.on( 'close', function () {
			edtsi_training_h.enable();
		} );
		
		tblsi_training_h = $('#tblsi_training_h').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/si_training_h/si_training_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_si_training_h = show_deleted_si_training_h;
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
				{ data: "si_training_h.id",visible:false },
				{ data: "si_training_h.judul" },
				{ data: "si_training_h.tanggal" },
				{ data: "si_training_h.pemateri" },
				{ data: "si_training_h.angkatan" },
				{ data: "si_training_h.step" },
				{ data: "si_training_h.pertemuan" },
				{ data: "si_training_h.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_si_training_h';
					$table       = 'tblsi_training_h';
					$edt         = 'edtsi_training_h';
					$show_status = '_si_training_h';
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
				if ( data.si_training_h.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.si_training_h.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsi_training_h.searchPanes.container().appendTo('#spsi_training_h');
		tblsi_training_h.searchBuilder.container().appendTo( '#sbsi_training_h' );
		
		tblsi_training_h.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblsi_training_d];
			CekInitHeaderHD(tblsi_training_h, tbl_details);
		} );
		
		tblsi_training_h.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('si_training_h');
			
			// atur hak akses
			tbl_details = [tblsi_training_d];
			CekSelectHeaderHD(tblsi_training_h, tbl_details);

		} );
		
		tblsi_training_h.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('si_training_h');

			// atur hak akses
			tbl_details = [tblsi_training_d];
			CekDeselectHeaderHD(tblsi_training_h, tbl_details);
		} );
		// END si_training_h

		// BEGIN si_training_d
		edtsi_training_d = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/si_training_h/si_training_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_si_training_d = show_deleted_si_training_d;
					d.id_si_training_h = id_si_training_h;
				}
			},
			table: "#tblsi_training_d",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "si_training_d.start_at",
					name: "si_training_d.start_at",
					type: "hidden"
				},	
				{
					label: "si_training_d.finish_at",
					name: "si_training_d.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "si_training_d",
					type: "hidden"
				},	
				{
					label: "si_training_d.transaction_state",
					name: "si_training_d.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_si_training_h",
					name: "si_training_d.id_si_training_h",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",  
					name: "si_training_d.id_si_training_peserta_m",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/si_training_peserta_m/si_training_peserta_m_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_si_training_peserta_m_old: id_si_training_peserta_m_old,
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
			
		edtsi_training_d.on( 'preOpen', function( e, mode, action ) {
			edtsi_training_d.field('si_training_d.id_si_training_h').val(id_si_training_h);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsi_training_d.field('si_training_d.start_at').val(start_at);
			
			if(action == 'create'){
				tblsi_training_d.rows().deselect();
			}
		});

		edtsi_training_d.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtsi_training_d.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_si_training_peserta_m = edtsi_training_d.field('si_training_d.id_si_training_peserta_m').val();

				validasiRequired(
					edtsi_training_d,
					'si_training_d',
					{
						'id_si_training_peserta_m': id_si_training_peserta_m
					}
				);

				validasiUnique(
					action,
					edtsi_training_d,
					'si_training_d',
					'id_si_training_peserta_m',
					'id_si_training_peserta_m',
					id_si_training_peserta_m,
					id_si_training_d
				);	
			}
			
			if ( edtsi_training_d.inError() ) {
				return false;
			}
		});

		edtsi_training_d.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsi_training_d.field('si_training_d.finish_at').val(finish_at);
		});
			
		edtsi_training_d.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblsi_training_h.ajax.reload(null, false);			
		} );

		edtsi_training_d.on( 'close', function () {
			edtsi_training_d.enable();
		} );
		
		tblsi_training_d = $('#tblsi_training_d').DataTable( {
			ajax: {
				url: "../../models/si_training_h/si_training_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_si_training_d = show_deleted_si_training_d;
					d.id_si_training_h = id_si_training_h;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "si_training_d.id",visible:false },
				{ data: "si_training_d.id_si_training_h",visible:false },
				{ data: "si_training_peserta_m.nama" },
				{ data: "si_training_peserta_m.no_wa" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_si_training_d';
					$table       = 'tblsi_training_d';
					$edt         = 'edtsi_training_d';
					$show_status = '_si_training_d';
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

		tblsi_training_d.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblsi_training_d, 1 );
			CekDrawDetailHDFinal(tblsi_training_h);
		} );

		tblsi_training_d.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('si_training_d');

			id_si_training_peserta_m_old = si_training_d_data.id_si_training_peserta_m;
			
			// atur hak akses
			CekSelectDetailHD( tblsi_training_d );
		} );
		
		tblsi_training_d.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('si_training_d');
			id_si_training_peserta_m_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblsi_training_d );
		} );
		// END si_training_d

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblsi_training_h.rows().deselect();
				tblsi_training_h.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFsi_training_h').modal('toggle');
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
