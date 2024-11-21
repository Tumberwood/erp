<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'qwhxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'qwhittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFqwhxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblqwhxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabqwhittd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabqwhittd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabqwhittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblqwhittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th style="vertical-align: middle" rowspan="3">id</th>
										<th style="vertical-align: middle" rowspan="3">id_qwhxxth</th>
										<th style="vertical-align: middle" rowspan="3">Warehouse</th>
										<th style="vertical-align: middle" rowspan="3">Location</th>
										<th style="vertical-align: middle" rowspan="3">LPN</th>
										<th style="vertical-align: middle" rowspan="3">Kode</th>
										<th style="vertical-align: middle" rowspan="3">Nama</th>
										<th colspan="4" class="text-center bg-success">On Hand</th>
										<th style="vertical-align: middle" rowspan="3">Batch Number</th>
										<th style="vertical-align: middle" rowspan="3">Expired Date</th>
										<th style="vertical-align: middle" rowspan="3">Item Status Lama</th>
										<th style="vertical-align: middle" rowspan="3">Item Status Baru</th>
										<th style="vertical-align: middle" rowspan="3">Alasan Status</th>
									</tr>
									<tr>
										<th colspan="2">Terkecil</th>
										<th colspan="2">Default</th></tr>
									<tr>
										<th>Jumlah</th>
										<th>UoM</th>
										<th>Jumlah</th>
										<th>UoM</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabqwhittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblqwhittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_qwhxxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/qwhxxth/fn/qwhxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtqwhxxth, tblqwhxxth, show_deleted_qwhxxth = 0, id_qwhxxth;
	var edtqwhittd, tblqwhittd, show_deleted_qwhittd = 0, id_qwhittd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('qwhxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN qwhxxth
		edtqwhxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/qwhxxth/qwhxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_qwhxxth = show_deleted_qwhxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblqwhxxth",
			fields: [ 
				{
					label: "qwhxxth.start_at",
					name: "qwhxxth.start_at",
					type: "hidden"
				},	
				{
					label: "qwhxxth.finish_at",
					name: "qwhxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "qwhxxth",
					type: "hidden"
				},	
				{
					label: "qwhxxth.transaction_state",
					name: "qwhxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal  <sup class='text-danger'>*<sup>",
					name: "qwhxxth.tanggal",
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
					name: "qwhxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtqwhxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtqwhxxth.field('qwhxxth.start_at').val(start_at);

			if(action == 'create'){
				tblqwhxxth.rows().deselect();
			}
		});

		edtqwhxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtqwhxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtqwhxxth.field('qwhxxth.tanggal').val();

				validasiRequired(
					edtqwhxxth,
					'qwhxxth',
					{
						'tanggal': tanggal,
					}
				);

			}
			
			if ( edtqwhxxth.inError() ) {
				return false;
			}
		});

		edtqwhxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtqwhxxth.field('qwhxxth.finish_at').val(finish_at);
		});
		
		edtqwhxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtqwhxxth.on( 'close', function () {
			edtqwhxxth.enable();
		} );
		
		tblqwhxxth = $('#tblqwhxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/qwhxxth/qwhxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_qwhxxth = show_deleted_qwhxxth;
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
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "qwhxxth.id",visible:false },
				{ data: "qwhxxth.kode" },
				{ data: "qwhxxth.tanggal" },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_qwhxxth';
					$table       = 'tblqwhxxth';
					$edt         = 'edtqwhxxth';
					$show_status = '_qwhxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.qwhxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.qwhxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblqwhxxth.searchPanes.container().appendTo('#spqwhxxth');
		tblqwhxxth.searchBuilder.container().appendTo( '#sbqwhxxth' );
		
		tblqwhxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblqwhittd];
			CekInitHeaderHD(tblqwhxxth, tbl_details);
		} );
		
		tblqwhxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('qwhxxth');
			
			// atur hak akses
			tbl_details = [tblqwhittd];
			CekSelectHeaderHD(tblqwhxxth, tbl_details);

		} );
		
		tblqwhxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('qwhxxth');

			// atur hak akses
			tbl_details = [tblqwhittd];
			CekDeselectHeaderHD(tblqwhxxth, tbl_details);
		} );
		// END qwhxxth

		// BEGIN qwhittd
		edtqwhittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/qwhxxth/qwhittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_qwhittd = show_deleted_qwhittd;
					d.id_qwhxxth = id_qwhxxth;
				}
			},
			table: "#tblqwhittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "qwhittd.start_at",
					name: "qwhittd.start_at",
					type: "hidden"
				},	
				{
					label: "qwhittd.finish_at",
					name: "qwhittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "qwhittd",
					type: "hidden"
				},	
				{
					label: "qwhittd.transaction_state",
					name: "qwhittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_qwhxxth",
					name: "qwhittd.id_qwhxxth",
					type: "hidden"
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "qwhittd.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "qwhittd.nama"
				}, 	
				{
					label: "Keterangan",
					name: "qwhittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtqwhittd.on( 'preOpen', function( e, mode, action ) {
			edtqwhittd.field('qwhittd.id_qwhxxth').val(id_qwhxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtqwhittd.field('qwhittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblqwhittd.rows().deselect();
			}
		});

		edtqwhittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtqwhittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtqwhittd.field('qwhittd.kode').val();

				validasiRequired(
					edtqwhittd,
					'qwhittd',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edtqwhittd,
					'qwhittd',
					'kode',
					'kode',
					'"'+kode+'"',
					id_qwhittd
				);	
			}
			
			if ( edtqwhittd.inError() ) {
				return false;
			}
		});

		edtqwhittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtqwhittd.field('qwhittd.finish_at').val(finish_at);
		});
			
		edtqwhittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtqwhittd.on( 'close', function () {
			edtqwhittd.enable();
		} );
		
		tblqwhittd = $('#tblqwhittd').DataTable( {
			ajax: {
				url: "../../models/qwhxxth/qwhittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_qwhittd = show_deleted_qwhittd;
					d.id_qwhxxth = id_qwhxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "qwhittd.id",visible:false },
				{ data: "qwhittd.id_qwhxxth",visible:false },
				{ data: "qwhittd.iwhxxmh_nama" },
				{ data: "qwhittd.wloxxmh_nama" },
				{ data: "qwhittd.wlpxxmh_kode" },
				{ data: "qwhittd.iimxxmh_kode" },
				{ data: "qwhittd.iimxxmh_nama" },
				{ 
					data: "qwhittd.jumlah_default",
					...renderNumber()
				},
				{ 
					data: "qwhittd.iumxxmh_default_kode",
				},
				{ 
					data: "qwhittd.jumlah_terkecil",
					...renderNumber()
				},
				{ 
					data: "qwhittd.iumxxmh_terkecil_kode",
				},
				{ data: "qwhittd.batch_number" },
				{ data: "qwhittd.expired_date" },
				{ 
					data: "qwhittd.iimxxmh_status_old",
					render: function (data) {
						if(data == 1){
							return '<span class="badge badge-primary">GOOD</span>';
						}else if(data == 2){
							return '<span class="badge badge-danger">BAD</span>';
						}else if(data == 3){
							return '<span class="badge badge-plain">HOLD</span>';
						}else{
							return '<span class="badge badge-warning">INVALID</span>';
						}
					}
				},
				{ 
					data: "qwhittd.iimxxmh_status",
					render: function (data) {
						if(data == 1){
							return '<span class="badge badge-primary">GOOD</span>';
						}else if(data == 2){
							return '<span class="badge badge-danger">BAD</span>';
						}else if(data == 3){
							return '<span class="badge badge-plain">HOLD</span>';
						}else{
							return '<span class="badge badge-warning">INVALID</span>';
						}
					}
				},
				{ data: "qwhittd.alasan_perubahan_status" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_qwhittd';
					$table       = 'tblqwhittd';
					$edt         = 'edtqwhittd';
					$show_status = '_qwhittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['log','noactionD'];
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

		tblqwhittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblqwhittd, 1 );
			CekDrawDetailHDFinal(tblqwhxxth);
		} );

		tblqwhittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('qwhittd');
			
			// atur hak akses
			CekSelectDetailHD( tblqwhittd );
		} );

		tblqwhittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('qwhittd');
			
			// atur hak akses
			CekDeselectDetailHD( tblqwhittd );
		} );
		// END qwhittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblqwhxxth.rows().deselect();
				tblqwhxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFqwhxxth').modal('toggle');
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
