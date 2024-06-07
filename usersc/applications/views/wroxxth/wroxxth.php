<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wroxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wroittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFwroxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<table id="tblwroxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nomor</th>
							<th>Tanggal</th>
							<th>Supplier</th>
							<th>Status</th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabwroittd_1"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwroittd_1" class="tab-pane active">
					<div class="panel-body">
						<table id="tblwroittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_wroxxth</th>
									<th>Item Code</th>
									<th>Item Name</th>
									<th>UoM</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th id="c_item"></th>
									<th></th>
									<th></th>
								</tr>
							</tfoot>
						</table>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wroxxth/fn/wroxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwroxxth, tblwroxxth, show_deleted_wroxxth = 0, id_wroxxth;
	var edtwroittd, tblwroittd, show_deleted_wroittd = 0, id_wroittd;
	// ------------- end of default variable

	var id_grlxxmh_old = 0;
	var id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0, id_iumxxmh_unit  = 0;

	// get tableRelation
	tableRelation('wroxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wroxxth
		edtwroxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wroxxth/wroxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wroxxth = show_deleted_wroxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwroxxth",
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
					label: "wroxxth.start_at",
					name: "wroxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wroxxth.finish_at",
					name: "wroxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wroxxth",
					type: "hidden"
				},	
				{
					label: "wroxxth.transaction_state",
					name: "wroxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Supplier <sup class='text-danger'>*<sup>",
					name: "wroxxth.id_grlxxmh_supplier",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/psuxxmh/psuxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_old,
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
					name: "wroxxth.tanggal",
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
					name: "wroxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtwroxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwroxxth.field('wroxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwroxxth.rows().deselect();
				edtwroxxth.field('kategori_dokumen').val('');
				edtwroxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtwroxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			edtFormButtonSaveConfirmHD();
			
		});
		
		edtwroxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_grlxxmh_supplier = edtwroxxth.field('wroxxth.id_grlxxmh_supplier').val();
				tanggal       = edtwroxxth.field('wroxxth.tanggal').val();

				validasiRequired(
					edtwroxxth,
					'wroxxth',
					{
						'id_grlxxmh_supplier': id_grlxxmh_supplier,
						'tanggal'   : tanggal
					}
				);
			
			}
			
			if ( edtwroxxth.inError() ) {
				return false;
			}
		});

		edtwroxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwroxxth.field('wroxxth.finish_at').val(finish_at);

		});
		
		edtwroxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			
		} );

		edtwroxxth.on( 'close', function () {
			edtwroxxth.enable();
		} );
		
		tblwroxxth = $('#tblwroxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wroxxth/wroxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wroxxth = show_deleted_wroxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
			responsive: false,
			scrollX: true,
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "wroxxth.id",visible:false },
				{ data: "wroxxth.kode" },
				{ data: "wroxxth.tanggal" },
				{ data: "grlxxmh.nama" },
				{ 
					data: "wroxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wroxxth';
					$table       = 'tblwroxxth';
					$edt         = 'edtwroxxth';
					$show_status = '_wroxxth';
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
				if ( data.wroxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wroxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwroxxth.searchPanes.container().appendTo('#spwroxxth');
		tblwroxxth.searchBuilder.container().appendTo( '#sbwroxxth' );
		
		tblwroxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwroittd];
			CekInitHeaderHD(tblwroxxth, tbl_details);
		} );
		
		tblwroxxth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('wroxxth');
			id_grlxxmh_old    = wroxxth_data.id_grlxxmh_supplier;

			// atur hak akses
			tbl_details = [tblwroittd];
			CekSelectHeaderHD(tblwroxxth, tbl_details);

		} );
		
		tblwroxxth.on( 'deselect', function () {
			siVarReset('wroxxth');
			id_grlxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblwroittd];
			CekDeselectHeaderHD(tblwroxxth, tbl_details);
		} );
		// END wroxxth

		// BEGIN wroittd
		edtwroittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wroxxth/wroittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wroittd = show_deleted_wroittd;
					d.id_wroxxth = id_wroxxth;
				}
			},
			table: "#tblwroittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "wroittd.start_at",
					name: "wroittd.start_at",
					type: "hidden"
				},	
				{
					label: "wroittd.finish_at",
					name: "wroittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wroittd",
					type: "hidden"
				},	
				{
					label: "wroittd.transaction_state",
					name: "wroittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wroxxth",
					name: "wroittd.id_wroxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wroittd.id_iimxxmh",
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
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wroittd.id_iumxxmh_unit",
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "wroittd.jumlah_unit"
				}, 	
				{
					label: "Keterangan",
					name: "wroittd.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwroittd.field('wroittd.jumlah_unit').input().addClass('text-right');
			
		edtwroittd.on( 'preOpen', function( e, mode, action ) {
			edtwroittd.field('wroittd.id_wroxxth').val(id_wroxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwroittd.field('wroittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwroittd.rows().deselect();
			}
		});

		edtwroittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtwroittd.dependent( 'wroittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtwroittd.field('wroittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});

		edtwroittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_iumxxmh_unit = edtwroittd.field('wroittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtwroittd.field('wroittd.id_iimxxmh').val();
				jumlah_unit     = edtwroittd.field('wroittd.jumlah_unit').val();

				validasiRequired(
					edtwroittd,
					'wroittd',
					{
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_iimxxmh': id_iimxxmh,
					}
				);
				
				validasiNumber(
					edtwroittd,
					'wroittd',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);

			}
			
			if ( edtwroittd.inError() ) {
				return false;
			}
		});

		edtwroittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwroittd.field('wroittd.finish_at').val(finish_at);
		});
			
		edtwroittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].wroittd.id;
            	konversiUom('wroittd', id_transaksi );

				tblwroittd.rows().deselect();
			}
			
			tblwroxxth.ajax.reload(null, false);
			tblwroittd.ajax.reload(null, false);
		} );

		edtwroittd.on( 'close', function () {
			edtwroittd.enable();
		} );
		
		tblwroittd = $('#tblwroittd').DataTable( {
			ajax: {
				url: "../../models/wroxxth/wroittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wroittd = show_deleted_wroittd;
					d.id_wroxxth = id_wroxxth;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "wroittd.id",visible:false },
				{ data: "wroittd.id_wroxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "wroittd.jumlah_unit",
					...renderNumber( 0, "")
				}

			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wroittd';
					$table       = 'tblwroittd';
					$edt         = 'edtwroittd';
					$show_status = '_wroittd';
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
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
			}
		} );

		tblwroittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblwroittd, 1);
			CekDrawDetailHDFinal(tblwroxxth);
		} );

		tblwroittd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('wroittd')

			id_iimxxmh          = wroittd_data.id_iimxxmh;
			id_iimxxmh_old      = wroittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wroittd_data.id_iumxxmh_unit;

			// atur hak akses
			CekSelectDetailHD(tblwroittd );
		} );

		tblwroittd.on( 'deselect', function() {
			siVarResetD('wroittd')
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblwroxxth, tblwroittd );
		} );

		// END wroittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwroxxth.rows().deselect();
				tblwroxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwroxxth').modal('toggle');
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
