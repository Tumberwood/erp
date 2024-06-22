<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'igixxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'igiittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFigixxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tbligixxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Department</th>
                                <th>Account Code</th>
                                <th>Account Name</th>
                                <th>TX</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabigiittd"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabigiittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbligiittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_igixxth</th>
										<th>SKU</th>
										<th>Item</th>
										<th>Quantity</th>
										<th>UoM</th>
									</tr>
								</thead>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/igixxth/fn/igixxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtigixxth, tbligixxth, show_deleted_igixxth = 0, id_igixxth;
	var edtigiittd, tbligiittd, show_deleted_igiittd = 0, id_igiittd;
	// ------------- end of default variable

	var id_hodxxmh_old = 0, id_iwhxxmh_old = 0, id_aakxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iimxxmh = 0, id_iumxxmh_unit_old = 0;

	// get tableRelation
	tableRelation('igixxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN igixxth
		edtigixxth = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 3,
				}
			},
			ajax: {
				url: "../../models/igixxth/igixxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_igixxth = show_deleted_igixxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tbligixxth",
			fields: [ 
				{
					label: "igixxth.start_at",
					name: "igixxth.start_at",
					type: "hidden"
				},	
				{
					label: "igixxth.finish_at",
					name: "igixxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "igixxth",
					type: "hidden"
				},	
				{
					label: "igixxth.transaction_state",
					name: "igixxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "igixxth.tanggal",
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
					label: "Department",
					name: "igixxth.id_hodxxmh",
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
				{
					label: "Select2",
					name: "igixxth.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iwhxxmh_old: id_iwhxxmh_old,
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
					label: "Account",
					name: "igixxth.id_aakxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_biaya.php",
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
					label: "Keterangan <sup class='text-danger'>*<sup>",
					name: "igixxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtigixxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtigixxth.field('igixxth.start_at').val(start_at);

			if(action == 'create'){
				tbligixxth.rows().deselect();
			}
		});

		edtigixxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtigixxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal    = edtigixxth.field('igixxth.tanggal').val();
				id_aakxxmh = edtigixxth.field('igixxth.id_aakxxmh').val();
				keterangan = edtigixxth.field('igixxth.keterangan').val();

				validasiRequired(
					edtigixxth,
					'igixxth',
					{
						'tanggal'   : tanggal,
						'id_aakxxmh': id_aakxxmh,
						'keterangan': keterangan
					}
				);
			}
			
			if ( edtigixxth.inError() ) {
				return false;
			}
		});

		edtigixxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtigixxth.field('igixxth.finish_at').val(finish_at);
		});
		
		edtigixxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtigixxth.on( 'close', function () {
			edtigixxth.enable();
		} );
		
		tbligixxth = $('#tbligixxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/igixxth/igixxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_igixxth = show_deleted_igixxth;
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
				{ data: "igixxth.id",visible:false },
				{ data: "igixxth.tanggal" },
				{ data: "igixxth.kode" },
				{ data: "hodxxmh.nama" },
				{ data: "aakxxmh.kode" },
				{ data: "aakxxmh.nama" },
				{ 
					data: "igixxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_igixxth';
					$table       = 'tbligixxth';
					$edt         = 'edtigixxth';
					$show_status = '_igixxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
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
						window.open('../../views/core/jv_print.php?jenis_transaksi=Goods Issue&id_transaksi='+id_igixxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.igixxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.igixxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbligixxth.searchPanes.container().appendTo('#spigixxth');
		tbligixxth.searchBuilder.container().appendTo( '#sbigixxth' );
		
		tbligixxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbligiittd];
			CekInitHeaderHD(tbligixxth, tbl_details);
		} );
		
		tbligixxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('igixxth');
			id_hodxxmh_old = igixxth_data.id_hodxxmh;
			id_iwhxxmh_old = igixxth_data.id_iwhxxmh;
			id_aakxxmh_old = igixxth_data.id_aakxxmh;
			
			// atur hak akses
			tbl_details = [tbligiittd];
			CekSelectHeaderHD(tbligixxth, tbl_details);

		} );
		
		tbligixxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('igixxth');
			id_hodxxmh_old = 0, id_iwhxxmh_old = 0, id_aakxxmh_old = 0;

			// atur hak akses
			tbl_details = [tbligiittd];
			CekDeselectHeaderHD(tbligixxth, tbl_details);
		} );
		// END igixxth

		// BEGIN igiittd
		edtigiittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/igixxth/igiittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_igiittd = show_deleted_igiittd;
					d.id_igixxth = id_igixxth;
				}
			},
			table: "#tbligiittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "igiittd.start_at",
					name: "igiittd.start_at",
					type: "hidden"
				},	
				{
					label: "igiittd.finish_at",
					name: "igiittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "igiittd",
					type: "hidden"
				},	
				{
					label: "igiittd.transaction_state",
					name: "igiittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_igixxth",
					name: "igiittd.id_igixxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "igiittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iitxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
									ids_iitxxmh: 1,
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "igiittd.jumlah_unit"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "igiittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
					label: "Keterangan",
					name: "igiittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtigiittd.on( 'preOpen', function( e, mode, action ) {
			edtigiittd.field('igiittd.id_igixxth').val(id_igixxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtigiittd.field('igiittd.start_at').val(start_at);
			
			if(action == 'create'){
				tbligiittd.rows().deselect();
			}
		});

		edtigiittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtigiittd.dependent( 'igiittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtigiittd.field('igiittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});
		
		edtigiittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iimxxmh = edtigiittd.field('igiittd.id_iimxxmh').val();
				id_iumxxmh_unit = edtigiittd.field('igiittd.id_iumxxmh_unit').val();
				jumlah_unit = edtigiittd.field('igiittd.jumlah_unit').val();

				validasiRequired(
					edtigiittd,
					'igiittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit': jumlah_unit
					}
				);

				validasiNumber(
					edtigiittd,
					'igiittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);
				
			}
			
			if ( edtigiittd.inError() ) {
				return false;
			}
		});

		edtigiittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtigiittd.field('igiittd.finish_at').val(finish_at);
		});
			
		edtigiittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbligiittd.ajax.reload(null, false);
			tbligixxth.ajax.reload(null, false);
		} );

		edtigiittd.on( 'close', function () {
			edtigiittd.enable();
		} );
		
		tbligiittd = $('#tbligiittd').DataTable( {
			ajax: {
				url: "../../models/igixxth/igiittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_igiittd = show_deleted_igiittd;
					d.id_igixxth = id_igixxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "igiittd.id",visible:false },
				{ data: "igiittd.id_igixxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ 
					data: "igiittd.jumlah_unit" ,
					...renderNumber(2)
				},
				{ data: "iumxxmh.kode" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_igiittd';
					$table       = 'tbligiittd';
					$edt         = 'edtigiittd';
					$show_status = '_igiittd';
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

		tbligiittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbligiittd, 1 );
			CekDrawDetailHDFinal(tbligixxth);
		} );

		tbligiittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('igiittd');
			id_iimxxmh_old      = igiittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = igiittd_data.id_iumxxmh_unit;

			// atur hak akses
			CekSelectDetailHD( tbligiittd );
		} );

		tbligiittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('igiittd');
			id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbligiittd );
		} );
		// END igiittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbligixxth.rows().deselect();
				tbligixxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFigixxth').modal('toggle');
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
