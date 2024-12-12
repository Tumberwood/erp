<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hateith';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hateitd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhateith" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhateith" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode Termination</th>
								<th>Nama Kandidat</th>
								<th>Tanggal Efektif</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhateitd_1"> Interview</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhateitd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<div id="frmhateitd">
								<div class="panel-body">
								</div>
							</div>
							<table id="tblhateitd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hateith</th>
										<th id="interview"></th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhateitd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhateitd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hateith</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hateith/fn/hateith_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthateith, tblhateith, show_deleted_hateith = 0, id_hateith;
	var edthateitd, tblhateitd, show_deleted_hateitd = 0, id_hateitd;
	var id_hatemth_old = 0;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hateith');
	interviewPertama();
	

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hateith
		edthateith = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hateith/hateith.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hateith = show_deleted_hateith;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhateith",
			fields: [ 
				{
					label: "hateith.start_at",
					name: "hateith.start_at",
					type: "hidden"
				},	
				{
					label: "hateith.finish_at",
					name: "hateith.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hateith",
					type: "hidden"
				},	
				{
					label: "hateith.transaction_state",
					name: "hateith.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama Kandidat <sup class='text-danger'>*<sup>", 
					name: "hateith.id_hatemth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hatemth/hatemth_hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hatemth_old: id_hatemth_old,
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
					name: "hatemth_tanggal",
					type: "readonly",
				},
				{
					label: "Catatan",
					name: "hateith.catatan",
					type: "textarea"
				}
			]
		} );
		
		edthateith.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthateith.field('hateith.start_at').val(start_at);
			
			if(action == 'create'){
				tblhateith.rows().deselect();
			}
		});

		edthateith.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthateith.dependent( 'hateith.id_hatemth', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('hatemth', val, 'DATE_FORMAT(tanggal, "%d %b %Y") AS tanggal');
				hatemth_tanggal = autofillData.tanggal;
				edthateith.field('hatemth_tanggal').val(hatemth_tanggal);
			}
			return {}
		}, {event: 'keyup change'});

		edthateith.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hatemth = edthateith.field('hateith.id_hatemth').val();

				validasiRequired(
					edthateith,
					'hateith',
					{
						'id_hatemth': id_hatemth,
					}
				);

			}
			
			if ( edthateith.inError() ) {
				return false;
			}
		});

		edthateith.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthateith.field('hateith.finish_at').val(finish_at);
		});
		
		edthateith.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthateith.on( 'close', function () {
			edthateith.enable();
		} );
		
		tblhateith = $('#tblhateith').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hateith/hateith.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hateith = show_deleted_hateith;
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
				{ data: "hateith.id",visible:false },
				{ data: "hatemth.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hatemth.tanggal" },
				{ 
					data: "hateith.transaction_state",
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hateith';
					$table       = 'tblhateith';
					$edt         = 'edthateith';
					$show_status = '_hateith';
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
				if ( data.hateith.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hateith.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhateith.searchPanes.container().appendTo('#sphateith');
		tblhateith.searchBuilder.container().appendTo( '#sbhateith' );
		
		tblhateith.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhateitd];
			CekInitHeaderHD(tblhateith, tbl_details);
		} );
		
		tblhateith.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hateith');
			id_hatemth_old = hateith_data.id_hatemth;
			// atur hak akses
			tbl_details = [tblhateitd];
			CekSelectHeaderHD(tblhateith, tbl_details);

		} );
		
		tblhateith.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hateith');
			id_hatemth_old = 0;

			// atur hak akses
			tbl_details = [tblhateitd];
			CekDeselectHeaderHD(tblhateith, tbl_details);
		} );
		// END hateith

		// BEGIN hateitd
		edthateitd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hateith/hateitd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hateitd = show_deleted_hateitd;
					d.id_hateith = id_hateith;
				}
			},
			template: "#frmhateitd",
			table: "#tblhateitd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hateitd.start_at",
					name: "hateitd.start_at",
					type: "hidden"
				},	
				{
					label: "hateitd.finish_at",
					name: "hateitd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hateitd",
					type: "hidden"
				},	
				{
					label: "hateitd.transaction_state",
					name: "hateitd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hateith",
					name: "hateitd.id_hateith",
					type: "hidden"
				},	
			]
		} );
			
		genForm('hateitd', edthateitd);

		edthateitd.on( 'preOpen', function( e, mode, action ) {
			edthateitd.field('hateitd.id_hateith').val(id_hateith);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthateitd.field('hateitd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhateitd.rows().deselect();
			}
		});

		edthateitd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthateitd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

			}
			
			if ( edthateitd.inError() ) {
				return false;
			}
		});

		edthateitd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthateitd.field('hateitd.finish_at').val(finish_at);
		});
			
		edthateitd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhateith.ajax.reload(null, false);
			tblhateitd.rows().deselect();
			tblhateitd.ajax.reload(null, false);
		} );

		edthateitd.on( 'close', function () {
			edthateitd.enable();
		} );
		
		tblhateitd = $('#tblhateitd').DataTable( {
			ajax: {
				url: "../../models/hateith/hateitd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hateitd = show_deleted_hateitd;
					d.id_hateith = id_hateith;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hateitd.id",visible:false },
				{ data: "hateitd.id_hateith",visible:false },
				{ data: "hateitd.field_1" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hateitd';
					$table       = 'tblhateitd';
					$edt         = 'edthateitd';
					$show_status = '_hateitd';
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

		tblhateitd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhateitd, 1 );
			CekDrawDetailHDFinal(tblhateith);
		} );

		tblhateitd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hateitd');
			
			// atur hak akses
			CekSelectDetailHD( tblhateitd );
		} );

		tblhateitd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hateitd');
			
			// atur hak akses
			CekDeselectDetailHD( tblhateitd );
		} );
		// END hateitd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhateith.rows().deselect();
				tblhateith.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhateith').modal('toggle');
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
