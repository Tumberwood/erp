<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hrcivth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hrcivtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhrcivth" tabindex="-1" role="dialog" aria-hidden="true">
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
					<div id="frmhrcivtd">
						<div class="panel-body">
						</div>
					</div>
                    <table id="tblhrcivth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode Panggilan</th>
								<th>Kode Request</th>
								<th>Nama Kandidat</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhrcivtd_1"> Interview</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhrcivtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhrcivtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrcivth</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhrcivtd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhrcivtd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrcivth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrcivth/fn/hrcivth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthrcivth, tblhrcivth, show_deleted_hrcivth = 0, id_hrcivth;
	var edthrcivtd, tblhrcivtd, show_deleted_hrcivtd = 0, id_hrcivtd;
	var id_hrcemtd_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hrcivth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hrcivth
		edthrcivth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrcivth/hrcivth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrcivth = show_deleted_hrcivth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhrcivth",
			fields: [ 
				{
					label: "hrcivth.start_at",
					name: "hrcivth.start_at",
					type: "hidden"
				},	
				{
					label: "hrcivth.finish_at",
					name: "hrcivth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrcivth",
					type: "hidden"
				},	
				{
					label: "hrcivth.transaction_state",
					name: "hrcivth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Request <sup class='text-danger'>*<sup>", 
					name: "hrcivth.id_hrcemtd",
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "hrcivth.tanggal",
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
					label: "Saran Keputusan <sup class='text-danger'>*<sup>",
					name: "hrcivth.saran",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Diterima", "value": "Diterima" },
						{ "label": "Tidak Diterima", "value": "Tidak Diterima" },
					]
				},
				{
					label: "Catatan",
					name: "hrcivth.catatan",
					type: "textarea"
				}
			]
		} );
		
		edthrcivth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrcivth.field('hrcivth.start_at').val(start_at);

			if(action == 'create'){
				tblhrcivth.rows().deselect();
			}
		});

		edthrcivth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthrcivth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edthrcivth.field('hrcivth.tanggal').val();
				id_hrcemtd = edthrcivth.field('hrcivth.id_hrcemtd').val();
				saran = edthrcivth.field('hrcivth.saran').val();

				validasiRequired(
					edthrcivth,
					'hrcivth',
					{
						'tanggal': tanggal,
						'id_hrcemtd': id_hrcemtd,
						'saran': saran,
					}
				);

			}
			
			if ( edthrcivth.inError() ) {
				return false;
			}
		});

		edthrcivth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrcivth.field('hrcivth.finish_at').val(finish_at);
		});
		
		edthrcivth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthrcivth.on( 'close', function () {
			edthrcivth.enable();
		} );
		
		tblhrcivth = $('#tblhrcivth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrcivth/hrcivth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrcivth = show_deleted_hrcivth;
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
				{ data: "hrcivth.id",visible:false },
				{ data: "hrccdth.kode" },
				{ data: "hrremth.kode" },
				{ data: "hcdxxmh.nama" },
				{ 
					data: "hrcivth.transaction_state",
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrcivth';
					$table       = 'tblhrcivth';
					$edt         = 'edthrcivth';
					$show_status = '_hrcivth';
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
				if ( data.hrcivth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrcivth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrcivth.searchPanes.container().appendTo('#sphrcivth');
		tblhrcivth.searchBuilder.container().appendTo( '#sbhrcivth' );
		
		tblhrcivth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhrcivtd];
			CekInitHeaderHD(tblhrcivth, tbl_details);
		} );
		
		tblhrcivth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrcivth');
			
			// atur hak akses
			tbl_details = [tblhrcivtd];
			CekSelectHeaderHD(tblhrcivth, tbl_details);

		} );
		
		tblhrcivth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrcivth');

			// atur hak akses
			tbl_details = [tblhrcivtd];
			CekDeselectHeaderHD(tblhrcivth, tbl_details);
		} );
		// END hrcivth

		// BEGIN hrcivtd
		edthrcivtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrcivth/hrcivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrcivtd = show_deleted_hrcivtd;
					d.id_hrcivth = id_hrcivth;
				}
			},
			template: "#frmhrcivtd",
			table: "#tblhrcivtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hrcivtd.start_at",
					name: "hrcivtd.start_at",
					type: "hidden"
				},	
				{
					label: "hrcivtd.finish_at",
					name: "hrcivtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrcivtd",
					type: "hidden"
				},	
				{
					label: "hrcivtd.transaction_state",
					name: "hrcivtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hrcivth",
					name: "hrcivtd.id_hrcivth",
					type: "hidden"
				},	
			]
		} );
			
		genForm('hrcivtd', edthrcivtd);

		edthrcivtd.on( 'preOpen', function( e, mode, action ) {
			edthrcivtd.field('hrcivtd.id_hrcivth').val(id_hrcivth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrcivtd.field('hrcivtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrcivtd.rows().deselect();
			}
		});

		edthrcivtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthrcivtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

			}
			
			if ( edthrcivtd.inError() ) {
				return false;
			}
		});

		edthrcivtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrcivtd.field('hrcivtd.finish_at').val(finish_at);
		});
			
		edthrcivtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthrcivtd.on( 'close', function () {
			edthrcivtd.enable();
		} );
		
		tblhrcivtd = $('#tblhrcivtd').DataTable( {
			ajax: {
				url: "../../models/hrcivth/hrcivtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrcivtd = show_deleted_hrcivtd;
					d.id_hrcivth = id_hrcivth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hrcivtd.id",visible:false },
				{ data: "hrcivtd.id_hrcivth",visible:false },
				{ data: "hrcivtd.kode" },
				{ data: "hrcivtd.nama" },
				{ data: "hrcivtd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrcivtd';
					$table       = 'tblhrcivtd';
					$edt         = 'edthrcivtd';
					$show_status = '_hrcivtd';
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

		tblhrcivtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhrcivtd, 1 );
			CekDrawDetailHDFinal(tblhrcivth);
		} );

		tblhrcivtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hrcivtd');
			
			// atur hak akses
			CekSelectDetailHD( tblhrcivtd );
		} );

		tblhrcivtd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hrcivtd');
			
			// atur hak akses
			CekDeselectDetailHD( tblhrcivtd );
		} );
		// END hrcivtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhrcivth.rows().deselect();
				tblhrcivth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhrcivth').modal('toggle');
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
