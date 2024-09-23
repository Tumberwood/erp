<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = '_blankheader';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = '_blankdetail';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSF_blankheader" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tbl_blankheader" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="state"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tab_blankdetail_1"> Tab 1</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tab_blankdetail_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tab_blankdetail_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id__blankheader</th>
										<th data-i18n="code"></th>
										<th data-i18n="name"></th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tab_blankdetail_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id__blankheader</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/_blankheader/fn/_blankheader_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edt_blankheader, tbl_blankheader, show_deleted__blankheader = 0, id__blankheader;
	var edt_blankdetail, tbl_blankdetail, show_deleted__blankdetail = 0, id__blankdetail;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('_blankheader');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN _blankheader
		edt_blankheader = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blankheader/_blankheader.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankheader = show_deleted__blankheader;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tbl_blankheader",
			fields: [ 
				{
					label: "_blankheader.start_at",
					name: "_blankheader.start_at",
					type: "hidden"
				},	
				{
					label: "_blankheader.finish_at",
					name: "_blankheader.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankheader",
					type: "hidden"
				},	
				{
					label: "_blankheader.transaction_state",
					name: "_blankheader.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "_blankheader.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "_blankheader.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "_blankheader.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edt_blankheader.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankheader.field('_blankheader.start_at').val(start_at);

			if(action == 'create'){
				tbl_blankheader.rows().deselect();
			}
		});

		edt_blankheader.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edt_blankheader.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blankheader.field('_blankheader.kode').val();
				nama = edt_blankheader.field('_blankheader.nama').val();

				validasiRequired(
					edt_blankheader,
					'_blankheader',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edt_blankheader,
					'_blankheader',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blankheader
				);

				validasiUnique(
					action,
					edt_blankheader,
					'_blankheader',
					'nama',
					'nama',
					'"'+nama+'"',
					id__blankheader
				);
			}
			
			if ( edt_blankheader.inError() ) {
				return false;
			}
		});

		edt_blankheader.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankheader.field('_blankheader.finish_at').val(finish_at);
		});
		
		edt_blankheader.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankheader.on( 'close', function () {
			edt_blankheader.enable();
		} );
		
		tbl_blankheader = $('#tbl_blankheader').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/_blankheader/_blankheader.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankheader = show_deleted__blankheader;
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
				{ data: "_blankheader.id",visible:false },
				{ data: "_blankheader.kode" },
				{ data: "_blankheader.nama" },
				{ data: "_blankheader.transaction_state" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__blankheader';
					$table       = 'tbl_blankheader';
					$edt         = 'edt_blankheader';
					$show_status = '__blankheader';
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
				if ( data._blankheader.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data._blankheader.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbl_blankheader.searchPanes.container().appendTo('#sp_blankheader');
		tbl_blankheader.searchBuilder.container().appendTo( '#sb_blankheader' );
		
		tbl_blankheader.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekInitHeaderHD(tbl_blankheader, tbl_details);
		} );
		
		tbl_blankheader.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('_blankheader');
			
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekSelectHeaderHD(tbl_blankheader, tbl_details);

		} );
		
		tbl_blankheader.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('_blankheader');

			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekDeselectHeaderHD(tbl_blankheader, tbl_details);
		} );
		// END _blankheader

		// BEGIN _blankdetail
		edt_blankdetail = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blankheader/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id__blankheader = id__blankheader;
				}
			},
			table: "#tbl_blankdetail",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "_blankdetail.start_at",
					name: "_blankdetail.start_at",
					type: "hidden"
				},	
				{
					label: "_blankdetail.finish_at",
					name: "_blankdetail.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankdetail",
					type: "hidden"
				},	
				{
					label: "_blankdetail.transaction_state",
					name: "_blankdetail.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id__blankheader",
					name: "_blankdetail.id__blankheader",
					type: "hidden"
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "_blankdetail.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "_blankdetail.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "_blankdetail.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edt_blankdetail.on( 'preOpen', function( e, mode, action ) {
			edt_blankdetail.field('_blankdetail.id__blankheader').val(id__blankheader);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.start_at').val(start_at);
			
			if(action == 'create'){
				tbl_blankdetail.rows().deselect();
			}
		});

		edt_blankdetail.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edt_blankdetail.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blankdetail.field('_blankdetail.kode').val();

				validasiRequired(
					edt_blankdetail,
					'_blankdetail',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edt_blankdetail,
					'_blankdetail',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blankdetail
				);

			}
			
			if ( edt_blankdetail.inError() ) {
				return false;
			}
		});

		edt_blankdetail.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.finish_at').val(finish_at);
		});
			
		edt_blankdetail.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankdetail.on( 'close', function () {
			edt_blankdetail.enable();
		} );
		
		tbl_blankdetail = $('#tbl_blankdetail').DataTable( {
			ajax: {
				url: "../../models/_blankheader/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id__blankheader = id__blankheader;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "_blankdetail.id",visible:false },
				{ data: "_blankdetail.id__blankheader",visible:false },
				{ data: "_blankdetail.kode" },
				{ data: "_blankdetail.nama" },
				{ data: "_blankdetail.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__blankdetail';
					$table       = 'tbl_blankdetail';
					$edt         = 'edt_blankdetail';
					$show_status = '__blankdetail';
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

		tbl_blankdetail.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbl_blankdetail, 1 );
			CekDrawDetailHDFinal(tbl_blankheader);
		} );

		tbl_blankdetail.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('_blankdetail');
			
			// atur hak akses
			CekSelectDetailHD( tbl_blankdetail );
		} );

		tbl_blankdetail.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('_blankdetail');
			
			// atur hak akses
			CekDeselectDetailHD( tbl_blankdetail );
		} );
		// END _blankdetail

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbl_blankheader.rows().deselect();
				tbl_blankheader.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSF_blankheader').modal('toggle');
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
