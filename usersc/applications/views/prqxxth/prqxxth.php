<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'prqxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'prqittd';

	// BEGIN single data view
	if (isset($_GET['rowid']) && $_GET['rowid'] > 0) {
		$rowid = $_GET['rowid'];
	} else {
		$rowid = 0;
	}
	// END single data view
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFprqxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblprqxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Department</th>
                                <th>TX</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabprqittd"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabprqittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblprqittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th rowspan="2">ID</th>
										<th rowspan="2">id_prqxxth</th>
										<th colspan="2">Item</th>
										<th rowspan="2">Quantity</th>
										<th rowspan="2">UoM</th>
										<th rowspan="2">Tanggal Dibutuhkan</th>
										<th rowspan="2">Keterangan</th>
									</tr>

									<tr>
										<th>Master</th>
										<th>Non Master</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th id="c_items"></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
								</tfoot>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/prqxxth/fn/prqxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprqxxth, tblprqxxth, show_deleted_prqxxth = 0, id_prqxxth;
	var edtprqittd, tblprqittd, show_deleted_prqittd = 0, id_prqittd;
	var rowid = <?php echo $rowid; ?>;
	// ------------- end of default variable
	var id_hodxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iumxxmh_old = 0;

	// get tableRelation
	tableRelation('prqxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN prqxxth
		edtprqxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prqxxth/prqxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqxxth = show_deleted_prqxxth;
					d.start_date = start_date;
					d.end_date = end_date;
					d.rowid = rowid;
				}
			},
			table: "#tblprqxxth",
			fields: [ 
				{
					label: "prqxxth.start_at",
					name: "prqxxth.start_at",
					type: "hidden"
				},	
				{
					label: "prqxxth.finish_at",
					name: "prqxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prqxxth",
					type: "hidden"
				},	
				{
					label: "prqxxth.transaction_state",
					name: "prqxxth.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "prqxxth.tanggal",
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
					label: "Department <sup class='text-danger'>*<sup>",
					name: "prqxxth.id_hodxxmh",
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
					label: "Keterangan",
					name: "prqxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtprqxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqxxth.field('prqxxth.start_at').val(start_at);

			if(action == 'create'){
				tblprqxxth.rows().deselect();
			}
		});

		edtprqxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtprqxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal = edtprqxxth.field('prqxxth.tanggal').val();
				id_hodxxmh = edtprqxxth.field('prqxxth.id_hodxxmh').val();

				validasiRequired(
					edtprqxxth,
					'prqxxth',
					{
						'tanggal': tanggal,
						'id_hodxxmh': id_hodxxmh
					}
				);
				
			}
			
			if ( edtprqxxth.inError() ) {
				return false;
			}
		});

		edtprqxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqxxth.field('prqxxth.finish_at').val(finish_at);
		});
		
		edtprqxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblprqxxth.rows().deselect();
			tblprqxxth.ajax.reload(null, false);
		} );

		edtprqxxth.on( 'close', function () {
			edtprqxxth.enable();
		} );
		
		tblprqxxth = $('#tblprqxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/prqxxth/prqxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqxxth = show_deleted_prqxxth;
					d.start_date = start_date;
					d.end_date = end_date;
					d.rowid = rowid;
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
				{ data: "prqxxth.id",visible:false },
				{ data: "prqxxth.tanggal" },
				{ data: "prqxxth.kode" },
				{ data: "hodxxmh.nama" },
				{ 
					data: "prqxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "prqxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prqxxth';
					$table       = 'tblprqxxth';
					$edt         = 'edtprqxxth';
					$show_status = '_prqxxth';
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
				if ( data.prqxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.prqxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblprqxxth.searchPanes.container().appendTo('#spprqxxth');
		tblprqxxth.searchBuilder.container().appendTo( '#sbprqxxth' );
		
		tblprqxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblprqittd];
			CekInitHeaderHD(tblprqxxth, tbl_details);
		} );
		
		tblprqxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('prqxxth');
			id_hodxxmh_old = prqxxth_data.id_hodxxmh;
			
			// atur hak akses
			tbl_details = [tblprqittd];
			CekSelectHeaderHD(tblprqxxth, tbl_details);

		} );
		
		tblprqxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('prqxxth');
			id_hodxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblprqittd];
			CekDeselectHeaderHD(tblprqxxth, tbl_details);
		} );
		
		// END prqxxth

		// BEGIN prqittd
		edtprqittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/prqxxth/prqittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqittd = show_deleted_prqittd;
					d.id_prqxxth = id_prqxxth;
				}
			},
			table: "#tblprqittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "prqittd.start_at",
					name: "prqittd.start_at",
					type: "hidden"
				},	
				{
					label: "prqittd.finish_at",
					name: "prqittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "prqittd",
					type: "hidden"
				},	
				{
					label: "prqittd.transaction_state",
					name: "prqittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_prqxxth",
					name: "prqittd.id_prqxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "prqittd.id_iimxxmh",
					fieldInfo: "Isi salah satu antara Item Non Master dengan Item",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
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
					label: "Item Non Master<sup class='text-danger'>*<sup>",
					name: "prqittd.nama",
					fieldInfo: "Isi salah satu antara Item Non Master dengan Item"
				}, 	
				{
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "prqittd.jumlah_unit"
				}, 
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "prqittd.id_iumxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
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
					label: "Tanggal Dibutuhkan",
					name: "prqittd.tanggal_dibutuhkan",
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
					name: "prqittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtprqittd.on( 'preOpen', function( e, mode, action ) {
			edtprqittd.field('prqittd.id_prqxxth').val(id_prqxxth);
			console.log(id_prqxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqittd.field('prqittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblprqittd.rows().deselect();
			}
		});

		edtprqittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtprqittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				nama = edtprqittd.field('prqittd.nama').val();
				id_iimxxmh = edtprqittd.field('prqittd.id_iimxxmh').val();
				id_iumxxmh = edtprqittd.field('prqittd.id_iumxxmh').val();
				jumlah_unit = edtprqittd.field('prqittd.jumlah_unit').val();

				if( (!nama || nama == '' ) && (!id_iimxxmh || id_iimxxmh == '' ) || (nama !='' && id_iimxxmh != '' ) ){
					edtprqittd.field('prqittd.nama').error( 'Wajib diisi salah satu!' );
					edtprqittd.field('prqittd.id_iimxxmh').error( 'Wajib diisi salah satu!' );
				}

				validasiRequired(
					edtprqittd,
					'prqittd',
					{
						'id_iumxxmh': id_iumxxmh
					}
				);

				validasiNumber(
					edtprqittd,
					'prqittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);
				
			}
			
			if ( edtprqittd.inError() ) {
				return false;
			}
		});

		edtprqittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtprqittd.field('prqittd.finish_at').val(finish_at);
		});
			
		edtprqittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// tblprqxxth.rows().deselect();
			tblprqxxth.ajax.reload(null, false);
		} );

		edtprqittd.on( 'close', function () {
			edtprqittd.enable();
		} );
			
		tblprqittd = $('#tblprqittd').DataTable( {
			ajax: {
				url: "../../models/prqxxth/prqittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_prqittd = show_deleted_prqittd;
					d.id_prqxxth = id_prqxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "prqittd.id",visible:false },
				{ data: "prqittd.id_prqxxth",visible:false },
				{ data: "iimxxmh.nama" },
				{ data: "prqittd.nama" },
				{ 
					data: "prqittd.jumlah_unit",
					...renderNumber(0)
				},
				{ data: "iumxxmh.nama" },
				{ data: "prqittd.tanggal_dibutuhkan" },
				{ data: "prqittd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prqittd';
					$table       = 'tblprqittd';
					$edt         = 'edtprqittd';
					$show_status = '_prqittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       = this.api(), data;
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display;
				var c_items = api.column(0).data().count();
				$( '#c_items' ).html( numFormat("Total Item(s): " + c_items) );
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblprqittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblprqittd, 1 );
			CekDrawDetailHDFinal(tblprqxxth);
		} );

		tblprqittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('prqittd');
			id_iimxxmh_old   = prqittd_data.id_iimxxmh;
			id_iumxxmh_old   = prqittd_data.id_iumxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblprqittd );
		} );

		tblprqittd.on( 'deselect', function() {
			siVarResetD('prqittd');
			id_iimxxmh_old = 0, id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblprqittd );
		} );

		// END prqittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblprqxxth.rows().deselect();
				tblprqxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFprqxxth').modal('toggle');
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
