<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'forxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'foraktd';

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
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFforxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblforxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Kas / Bank</th>
                                <th>Amount</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabforaktd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabforaktd_1" class="tab-pane active">
					<div class="panel-body">
						<!-- <div class="table-responsive"> -->
							<table id="tblforaktd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_forxxth</th>
										<th>Akun</th>
										<th>Amount</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th>Total</th>
										<th id="total"></th>
										<th></th>
									</tr>
								</tfoot>
							</table>
						<!-- </div> -->

					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/forxxth/fn/forxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtforxxth, tblforxxth, show_deleted_forxxth = 0, id_forxxth;
	var edtforaktd, tblforaktd, show_deleted_foraktd = 0, id_foraktd;
	var rowid = <?php echo $rowid; ?>;
	// ------------- end of default variable

	var id_aakxxmh_kasbank_old = 0;
	var id_aakxxmh_old = 0;

	// get tableRelation
	tableRelation('forxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN forxxth
		edtforxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/forxxth/forxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_forxxth = show_deleted_forxxth;
					d.start_date = start_date;
					d.end_date = end_date;
					d.rowid = rowid;
				}
			},
			table: "#tblforxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},
				{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},
				{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "forxxth.start_at",
					name: "forxxth.start_at",
					type: "hidden"
				},	
				{
					label: "forxxth.finish_at",
					name: "forxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "forxxth",
					type: "hidden"
				},	
				{
					label: "forxxth.transaction_state",
					name: "forxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "forxxth.tanggal",
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
					label: "Kas / Bank <sup class='text-danger'>*<sup>",
					name: "forxxth.id_aakxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_kasbank.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_kasbank_old,
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
					label: "Total Amount",
					name: "forxxth.amount",
					type: "readonly"
				},
				{
					label: "Keterangan <sup class='text-danger'>*<sup>",
					name: "forxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtforxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtforxxth.field('forxxth.start_at').val(start_at);

			if(action == 'create'){
				edtforxxth.field('kategori_dokumen').val('');
				edtforxxth.field('kategori_dokumen_value').val('');
				edtforxxth.field('field_tanggal').val('tanggal');
				tblforxxth.rows().deselect();
			}
		});

		edtforxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtforxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edtforxxth.field('forxxth.tanggal').val();
				id_aakxxmh = edtforxxth.field('forxxth.id_aakxxmh').val();

				validasiRequired(
					edtforxxth,
					'forxxth',
					{
						'tanggal': tanggal,
						'id_aakxxmh': id_aakxxmh
					}
				);

			}
			
			if ( edtforxxth.inError() ) {
				return false;
			}
		});

		edtforxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtforxxth.field('forxxth.finish_at').val(finish_at);
		});
		
		edtforxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtforxxth.on( 'close', function () {
			edtforxxth.enable();
		} );
		
		tblforxxth = $('#tblforxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/forxxth/forxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_forxxth = show_deleted_forxxth;
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
				{ data: "forxxth.id",visible:false },
				{ data: "forxxth.tanggal" },
				{ data: "forxxth.kode" },
				{ data: "aakxxmh.nama" },
				{ 
					data: "forxxth.amount" ,
					...renderNumber(2)
				},
				{ data: "forxxth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_forxxth';
					$table       = 'tblforxxth';
					$edt         = 'edtforxxth';
					$show_status = '_forxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrintJurnal',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Jurnal',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('../../views/core/jv_print.php?jenis_transaksi=Other Receipt&id_transaksi='+id_forxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.forxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.forxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblforxxth.searchPanes.container().appendTo('#spforxxth');
		tblforxxth.searchBuilder.container().appendTo( '#sbforxxth' );
		
		tblforxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblforaktd];
			CekInitHeaderHD(tblforxxth, tbl_details);
		} );
		
		tblforxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('forxxth');
			id_aakxxmh_kasbank_old = forxxth_data.id_aakxxmh;
			
			// atur hak akses
			tbl_details = [tblforaktd];
			CekSelectHeaderHD(tblforxxth, tbl_details);

		} );
		
		tblforxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('forxxth');
			id_aakxxmh_kasbank_old = 0;

			// atur hak akses
			tbl_details = [tblforaktd];
			CekDeselectHeaderHD(tblforxxth, tbl_details);
		} );
		
		// END forxxth

		// BEGIN foraktd
		edtforaktd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/forxxth/foraktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_foraktd = show_deleted_foraktd;
					d.id_forxxth = id_forxxth;
				}
			},
			table: "#tblforaktd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "foraktd.start_at",
					name: "foraktd.start_at",
					type: "hidden"
				},	
				{
					label: "foraktd.finish_at",
					name: "foraktd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "foraktd",
					type: "hidden"
				},	
				{
					label: "foraktd.transaction_state",
					name: "foraktd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_forxxth",
					name: "foraktd.id_forxxth",
					type: "hidden"
				},	
				{
					label: "Akun <sup class='text-danger'>*<sup>",
					name: "foraktd.id_aakxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_child.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_old,
									id_aatxxmh_x: '1',
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
					label: "Amount <sup class='text-danger'>*<sup>",
					name: "foraktd.amount"
				}, 	
				{
					label: "Keterangan",
					name: "foraktd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtforaktd.on( 'preOpen', function( e, mode, action ) {
			edtforaktd.field('foraktd.id_forxxth').val(id_forxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtforaktd.field('foraktd.start_at').val(start_at);
			
			if(action == 'create'){
				tblforaktd.rows().deselect();
			}
		});

		edtforaktd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtforaktd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh = edtforaktd.field('foraktd.id_aakxxmh').val();
				amount = edtforaktd.field('foraktd.amount').val();

				validasiRequired(
					edtforaktd,
					'foraktd',
					{
						'id_aakxxmh': id_aakxxmh,
						'amount': amount
					}
				);

				validasiNumber(
					edtforaktd,
					'foraktd',
					{
						'amount': amount
					},
					0,
					'>'
				);
			}
			
			if ( edtforaktd.inError() ) {
				return false;
			}
		});

		edtforaktd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtforaktd.field('foraktd.finish_at').val(finish_at);
		});
			
		edtforaktd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// tblforxxth.rows().deselect();
			tblforaktd.ajax.reload(null, false);
			tblforxxth.ajax.reload(null, false);
		} );

		edtforaktd.on( 'close', function () {
			edtforaktd.enable();
		} );
		
		tblforaktd = $('#tblforaktd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/forxxth/foraktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_foraktd = show_deleted_foraktd;
					d.id_forxxth = id_forxxth;
				}
			},
			order: [[ 2, "desc" ]],
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
					targets: [0,4]
				}
			],
			columns: [
				{ data: "foraktd.id",visible:false },
				{ data: "foraktd.id_forxxth",visible:false },
				{ data: "foraktd.aakxxmh" },
				{ 
					data: "foraktd.amount" ,
					...renderNumber(2)
				},
				{ data: "foraktd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_foraktd';
					$table       = 'tblforaktd';
					$edt         = 'edtforaktd';
					$show_status = '_foraktd';
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
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       = this.api(), data;
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 
				// hitung jumlah 
				total = api.column( 3 ).data().sum();
				$( '#total' ).html( numFormat(total) );
			}
		} );

		tblforaktd.searchPanes.container().appendTo('#spforaktd');
		tblforaktd.searchBuilder.container().appendTo( '#sbforaktd' );

		tblforaktd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblforaktd, 1 );
			CekDrawDetailHDFinal(tblforxxth);
		} );

		tblforaktd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('foraktd');
			id_aakxxmh_old   = data_foraktd.id_aakxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblforaktd );
		} );

		tblforaktd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('foraktd');
			id_aakxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblforaktd );
		} );

		// END foraktd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblforxxth.rows().deselect();
				tblforxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFforxxth').modal('toggle');
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
