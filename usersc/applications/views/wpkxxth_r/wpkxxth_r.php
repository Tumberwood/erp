<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wpkxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wpkittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFwpkxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwpkxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabwpkittd_1"> Detail</a></li>
				<!-- <li><a class="nav-link" data-toggle="tab" href="#tabwpkittd_2"> Tab 2</a></li> -->
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwpkittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwpkittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>id</th>
										<th>id_wpkxxth</th>
										<th>Warehouse</th>
										<th>Lokasi Asal</th>
										<th>Lokasi Tujuan</th>
										<th>LPN</th>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>UoM</th>
										<th>Jumlah Unit</th>
										<th>Batch Number</th>
										<th>Expired Date</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabwpkittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwpkittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_wpkxxth</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpkxxth_r/fn/wpkxxth_r_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwpkxxth, tblwpkxxth, show_deleted_wpkxxth = 0, id_wpkxxth;
	var edtwpkittd, tblwpkittd, show_deleted_wpkittd = 0, id_wpkittd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('wpkxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wpkxxth
		edtwpkxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wpkxxth_r/wpkxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpkxxth = show_deleted_wpkxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwpkxxth",
			fields: [ 
				{
					label: "wpkxxth.start_at",
					name: "wpkxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wpkxxth.finish_at",
					name: "wpkxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wpkxxth",
					type: "hidden"
				},	
				{
					label: "wpkxxth.transaction_state",
					name: "wpkxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal  <sup class='text-danger'>*<sup>",
					name: "wpkxxth.tanggal",
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
					name: "wpkxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtwpkxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpkxxth.field('wpkxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwpkxxth.rows().deselect();
			}
		});

		edtwpkxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtwpkxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtwpkxxth.field('wpkxxth.tanggal').val();

				validasiRequired(
					edtwpkxxth,
					'wpkxxth',
					{
						'tanggal': tanggal,
					}
				);

			}
			
			if ( edtwpkxxth.inError() ) {
				return false;
			}
		});

		edtwpkxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpkxxth.field('wpkxxth.finish_at').val(finish_at);
		});
		
		edtwpkxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtwpkxxth.on( 'close', function () {
			edtwpkxxth.enable();
		} );
		
		tblwpkxxth = $('#tblwpkxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wpkxxth_r/wpkxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpkxxth = show_deleted_wpkxxth;
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
				{ data: "wpkxxth.id",visible:false },
				{ data: "wpkxxth.kode" },
				{ data: "wpkxxth.tanggal" },
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wpkxxth';
					$table       = 'tblwpkxxth';
					$edt         = 'edtwpkxxth';
					$show_status = '_wpkxxth';
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
				if ( data.wpkxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wpkxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwpkxxth.searchPanes.container().appendTo('#spwpkxxth');
		tblwpkxxth.searchBuilder.container().appendTo( '#sbwpkxxth' );
		
		tblwpkxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwpkittd];
			CekInitHeaderHD(tblwpkxxth, tbl_details);
		} );
		
		tblwpkxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wpkxxth');
			
			// atur hak akses
			tbl_details = [tblwpkittd];
			CekSelectHeaderHD(tblwpkxxth, tbl_details);

		} );
		
		tblwpkxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wpkxxth');

			// atur hak akses
			tbl_details = [tblwpkittd];
			CekDeselectHeaderHD(tblwpkxxth, tbl_details);
		} );
		// END wpkxxth

		// BEGIN wpkittd
		edtwpkittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wpkxxth_r/wpkittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpkittd = show_deleted_wpkittd;
					d.id_wpkxxth = id_wpkxxth;
				}
			},
			table: "#tblwpkittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "wpkittd.start_at",
					name: "wpkittd.start_at",
					type: "hidden"
				},	
				{
					label: "wpkittd.finish_at",
					name: "wpkittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wpkittd",
					type: "hidden"
				},	
				{
					label: "wpkittd.transaction_state",
					name: "wpkittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wpkxxth",
					name: "wpkittd.id_wpkxxth",
					type: "hidden"
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "wpkittd.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "wpkittd.nama"
				}, 	
				{
					label: "Keterangan",
					name: "wpkittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtwpkittd.on( 'preOpen', function( e, mode, action ) {
			edtwpkittd.field('wpkittd.id_wpkxxth').val(id_wpkxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpkittd.field('wpkittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwpkittd.rows().deselect();
			}
		});

		edtwpkittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtwpkittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwpkittd.field('wpkittd.kode').val();

				validasiRequired(
					edtwpkittd,
					'wpkittd',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edtwpkittd,
					'wpkittd',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wpkittd
				);	
			}
			
			if ( edtwpkittd.inError() ) {
				return false;
			}
		});

		edtwpkittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpkittd.field('wpkittd.finish_at').val(finish_at);
		});
			
		edtwpkittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtwpkittd.on( 'close', function () {
			edtwpkittd.enable();
		} );
		
		tblwpkittd = $('#tblwpkittd').DataTable( {
			ajax: {
				url: "../../models/wpkxxth_r/wpkittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpkittd = show_deleted_wpkittd;
					d.id_wpkxxth = id_wpkxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "wpkittd.id",visible:false },
				{ data: "wpkittd.id_wpkxxth",visible:false },
				{ data: "iwhxxmh.kode" },
				{ data: "asal.nama" },
				{ data: "tujuan.nama" },
				{ data: "wpkittd.wlpxxmh_kode" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wpkittd.jumlah_unit", //4
					...renderNumber(2)
				},
				{ data: "wpkittd.batch_number" },
				{ data: "wpkittd.expired_date" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wpkittd';
					$table       = 'tblwpkittd';
					$edt         = 'edtwpkittd';
					$show_status = '_wpkittd';
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

		tblwpkittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwpkittd, 1 );
			CekDrawDetailHDFinal(tblwpkxxth);
		} );

		tblwpkittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wpkittd');
			
			// atur hak akses
			CekSelectDetailHD( tblwpkittd );
		} );

		tblwpkittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wpkittd');
			
			// atur hak akses
			CekDeselectDetailHD( tblwpkittd );
		} );
		// END wpkittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwpkxxth.rows().deselect();
				tblwpkxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwpkxxth').modal('toggle');
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
