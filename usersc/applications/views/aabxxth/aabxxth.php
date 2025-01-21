<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'aabxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'aabaktd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFaabxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblaabxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Year</th>
                                <th>Month</th>
								<th data-i18n="department"></th>
								<th data-i18n="total"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabaabaktd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabaabaktd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblaabaktd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_aabxxth</th>
										<th data-i18n="accountCode"></th>
										<th data-i18n="accountName"></th>
										<th data-i18n="nominal"></th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabaabaktd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblaabaktd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_aabxxth</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/aabxxth/fn/aabxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtaabxxth, tblaabxxth, show_deleted_aabxxth = 0, id_aabxxth;
	var edtaabaktd, tblaabaktd, show_deleted_aabaktd = 0, id_aabaktd;
	// ------------- end of default variable

	id_hodxxmh_old = 0, id_aakxxmh_old = 0, id_grlxxmh_old = 0;

	// get tableRelation
	tableRelation('aabxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN aabxxth
		edtaabxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/aabxxth/aabxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aabxxth = show_deleted_aabxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblaabxxth",
			fields: [ 
				{
					label: "aabxxth.start_at",
					name: "aabxxth.start_at",
					type: "hidden"
				},	
				{
					label: "aabxxth.finish_at",
					name: "aabxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "aabxxth",
					type: "hidden"
				},	
				{
					label: "aabxxth.transaction_state",
					name: "aabxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Periode <sup class='text-danger'>*<sup>",
					name: "aabxxth.tanggal",
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
					label: "Tahun",
					name: "aabxxth.tahun",
					type: "hidden",
				},
				{
					label: "Bulan",
					name: "aabxxth.bulan",
					type: "hidden",
				},
				{
					label: getTranslation('department') + " <sup class='text-danger'>*<sup>",
					name: "aabxxth.id_hodxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh_old: id_hodxxmh_old,
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
		
		edtaabxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaabxxth.field('aabxxth.start_at').val(start_at);

			if(action == 'create'){
				tblaabxxth.rows().deselect();
			}
		});

		edtaabxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});
		
		edtaabxxth.dependent('aabxxth.tanggal', function (val, data, callback) {
			if (val != '') {
				var parts = val.split(' '); 
				
				var bulan = parts[1]; 
				var tahun = parts[2]; 

				edtaabxxth.field('aabxxth.tahun').val(tahun);
				edtaabxxth.field('aabxxth.bulan').val(bulan);
			}
			return {};
		}, { event: 'keyup change' });

		edtaabxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hodxxmh = edtaabxxth.field('aabxxth.id_hodxxmh').val();
				tanggal = edtaabxxth.field('aabxxth.tanggal').val();
				tahun = edtaabxxth.field('aabxxth.tahun').val();
				bulan = edtaabxxth.field('aabxxth.bulan').val();

				validasiRequired(
					edtaabxxth,
					'aabxxth',
					{
						'id_hodxxmh': id_hodxxmh,
						'tanggal': tanggal
					}
				);

				validasiUnique(
					action,
					edtaabxxth,
					'aabxxth',
					'id_hodxxmh',
					'bulan,tahun,id_hodxxmh',
					'"'+bulan+'",'+'"'+tahun+'",'+id_hodxxmh,
					id_aabxxth
				);
			}
			
			if ( edtaabxxth.inError() ) {
				return false;
			}
		});

		edtaabxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaabxxth.field('aabxxth.finish_at').val(finish_at);
		});
		
		edtaabxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtaabxxth.on( 'close', function () {
			edtaabxxth.enable();
		} );
		
		tblaabxxth = $('#tblaabxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aabxxth/aabxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aabxxth = show_deleted_aabxxth;
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
				{ data: "aabxxth.id",visible:false },
				{ data: "aabxxth.tahun" },
				{ data: "aabxxth.bulan" },
				{ data: "hodxxmh.nama" },
				{ data: "aabxxth.subtotal" },
				{ 
					data: "aabxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aabxxth';
					$table       = 'tblaabxxth';
					$edt         = 'edtaabxxth';
					$show_status = '_aabxxth';
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
				if ( data.aabxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.aabxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblaabxxth.searchPanes.container().appendTo('#spaabxxth');
		tblaabxxth.searchBuilder.container().appendTo( '#sbaabxxth' );
		
		tblaabxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblaabaktd];
			CekInitHeaderHD(tblaabxxth, tbl_details);
		} );
		
		tblaabxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('aabxxth');

			id_hodxxmh_old = aabxxth_data.id_hodxxmh;
			
			// atur hak akses
			tbl_details = [tblaabaktd];
			CekSelectHeaderHD(tblaabxxth, tbl_details);

		} );
		
		tblaabxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('aabxxth');
			id_hodxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblaabaktd];
			CekDeselectHeaderHD(tblaabxxth, tbl_details);
		} );
		// END aabxxth

		// BEGIN aabaktd
		edtaabaktd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/aabxxth/aabaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aabaktd = show_deleted_aabaktd;
					d.id_aabxxth = id_aabxxth;
				}
			},
			table: "#tblaabaktd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "aabaktd.start_at",
					name: "aabaktd.start_at",
					type: "hidden"
				},	
				{
					label: "aabaktd.finish_at",
					name: "aabaktd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "aabaktd",
					type: "hidden"
				},	
				{
					label: "aabaktd.transaction_state",
					name: "aabaktd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_aabxxth",
					name: "aabaktd.id_aabxxth",
					type: "hidden"
				},	
				{
					label: getTranslation('account') + " <sup class='text-danger'>*<sup>",
					name: "aabaktd.id_aakxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_old,
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
					label: getTranslation('nominal') + " <sup class='text-danger'>*<sup>",
					name: "aabaktd.nominal"
				}, 	
			]
		} );
			
		//masking
		unmaskedData = maskingNumber(
			edtaabaktd, 
			"aabaktd", 
			[
				"nominal", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);
		
		edtaabaktd.on( 'preOpen', function( e, mode, action ) {
			edtaabaktd.field('aabaktd.id_aabxxth').val(id_aabxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaabaktd.field('aabaktd.start_at').val(start_at);
			
			if(action == 'create'){
				tblaabaktd.rows().deselect();
			}
		});

		edtaabaktd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtaabaktd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh = edtaabaktd.field('aabaktd.id_aakxxmh').val();

				validasiRequired(
					edtaabaktd,
					'aabaktd',
					{
						'id_aakxxmh': id_aakxxmh,
					}
				);	
			}
			
			if ( edtaabaktd.inError() ) {
				return false;
			}
		});

		edtaabaktd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaabaktd.field('aabaktd.finish_at').val(finish_at);
		});
			
		edtaabaktd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtaabaktd.on( 'close', function () {
			edtaabaktd.enable();
		} );
		
		tblaabaktd = $('#tblaabaktd').DataTable( {
			ajax: {
				url: "../../models/aabxxth/aabaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aabaktd = show_deleted_aabaktd;
					d.id_aabxxth = id_aabxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "aabaktd.id",visible:false },
				{ data: "aabaktd.id_aabxxth",visible:false },
				{ data: "aakxxmh.kode" },
				{ data: "aakxxmh.nama" },
				{ 
					data: "aabaktd.nominal",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aabaktd';
					$table       = 'tblaabaktd';
					$edt         = 'edtaabaktd';
					$show_status = '_aabaktd';
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

		tblaabaktd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblaabaktd, 1 );
			CekDrawDetailHDFinal(tblaabxxth);
		} );

		tblaabaktd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('aabaktd');
			id_aakxxmh_old = aabaktd_data.id_aakxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblaabaktd );
		} );

		tblaabaktd.on( 'deselect', function() {
			// reset variable standar framework
			siVarReset('aabaktd');
			id_aakxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblaabaktd );
		} );
		// END aabaktd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblaabxxth.rows().deselect();
				tblaabxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFaabxxth').modal('toggle');
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
