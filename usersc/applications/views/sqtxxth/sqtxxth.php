<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'sqtxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'sqtittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblsqtxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>TX</th>
                                <th>Approval</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabsqtittd"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabsqtittd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblsqtittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_sqtxxth</th>
										<th>Item</th>
										<th>Quantity</th>
										<th>UoM</th>
										<th>Tanggal Dibutuhkan</th>
										<th>Keterangan</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/sqtxxth/fn/sqtxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtsqtxxth, tblsqtxxth, show_deleted_sqtxxth = 0, id_sqtxxth;
	var edtsqtittd, tblsqtittd, show_deleted_sqtittd = 0, id_sqtittd;
	// ------------- end of default variable
	var id_grlxxmh_old = 0;
	var id_iimxxmh = 0, id_iimxxmh_old = 0, id_iumxxmh_unit_old = 0;

	// get tableRelation
	tableRelation('sqtxxth');

	$(document).ready(function() {
		
		// BEGIN sqtxxth
		edtsqtxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sqtxxth/sqtxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtxxth = show_deleted_sqtxxth;
				}
			},
			table: "#tblsqtxxth",
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
					label: "sqtxxth.start_at",
					name: "sqtxxth.start_at",
					type: "hidden"
				},	
				{
					label: "sqtxxth.finish_at",
					name: "sqtxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sqtxxth",
					type: "hidden"
				},	
				{
					label: "sqtxxth.transaction_state",
					name: "sqtxxth.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "sqtxxth.tanggal",
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
					label: "Customer <sup class='text-danger'>*<sup>",
					name: "sqtxxth.id_scuxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/scuxxmh/scuxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_old,
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
					label: "Valid Until <sup class='text-danger'>*<sup>",
					name: "sqtxxth.tanggal_validity",
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
					label: "UP <sup class='text-danger'>*<sup>",
					name: "sqtxxth.up1"
				},
				{
					label: "Keterangan",
					name: "sqtxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtsqtxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtxxth.field('sqtxxth.start_at').val(start_at);

			if(action == 'create'){
				tblsqtxxth.rows().deselect();
				edtsqtxxth.field('kategori_dokumen').val('');
				edtsqtxxth.field('kategori_dokumen_value').val('');
			}
		});

		edtsqtxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtsqtxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal          = edtsqtxxth.field('sqtxxth.tanggal').val();
				id_scuxxmh       = edtsqtxxth.field('sqtxxth.id_scuxxmh').val();
				tanggal_validity = edtsqtxxth.field('sqtxxth.tanggal_validity').val();
				up1              = edtsqtxxth.field('sqtxxth.up1').val();

				validasiRequired(
					edtsqtxxth,
					'sqtxxth',
					{
						'tanggal': tanggal,
						'id_scuxxmh': id_scuxxmh,
						'tanggal_validity': tanggal_validity,
						'up1': up1
					}
				);
				
			}
			
			if ( edtsqtxxth.inError() ) {
				return false;
			}
		});

		edtsqtxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtxxth.field('sqtxxth.finish_at').val(finish_at);
		});
		
		edtsqtxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblsqtxxth.rows().deselect();
			tblsqtxxth.ajax.reload(null, false);
		} );

		edtsqtxxth.on( 'close', function () {
			edtsqtxxth.enable();
		} );
		
		tblsqtxxth = $('#tblsqtxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sqtxxth/sqtxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtxxth = show_deleted_sqtxxth;
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
					targets: [0]
				}
			],
			columns: [
				{ data: "sqtxxth.id",visible:false },
				{ data: "sqtxxth.tanggal" },
				{ data: "sqtxxth.kode" },
				{ data: "grlxxmh.nama" },
				{ 
					data: "sqtxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "sqtxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sqtxxth';
					$table       = 'tblsqtxxth';
					$edt         = 'edtsqtxxth';
					$show_status = '_sqtxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.sqtxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.sqtxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsqtxxth.searchPanes.container().appendTo('#spsqtxxth');
		tblsqtxxth.searchBuilder.container().appendTo( '#sbsqtxxth' );
		
		tblsqtxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblsqtittd];
			CekInitHeaderHD(tblsqtxxth, tbl_details);
		} );
		
		tblsqtxxth.on( 'select', function( e, dt, type, indexes ) {
			sqtxxth_data      = tblsqtxxth.row( { selected: true } ).data().sqtxxth;
			id_sqtxxth        = sqtxxth_data.id;
			id_transaksi_h    = id_sqtxxth;                                           // dipakai untuk general
			id_transaksi_log  = id_sqtxxth;                                           // dipakai untuk general
			transaction_state = sqtxxth_data.transaction_state;
			approval_state    = sqtxxth_data.approval_state;
			is_nextprocess    = sqtxxth_data.is_nextprocess;
			
			id_grlxxmh_old = sqtxxth_data.id_scuxxmh;
			
			// atur hak akses
			tbl_details = [tblsqtittd];
			CekSelectHeaderHD(tblsqtxxth, tbl_details);

		} );
		
		tblsqtxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_sqtxxth = 0;
			id_grlxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblsqtittd];
			CekDeselectHeaderHD(tblsqtxxth, tbl_details);
		} );
		
		// END sqtxxth

		// BEGIN sqtittd
		edtsqtittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/sqtxxth/sqtittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtittd = show_deleted_sqtittd;
					d.id_sqtxxth = id_sqtxxth;
				}
			},
			table: "#tblsqtittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "sqtittd.start_at",
					name: "sqtittd.start_at",
					type: "hidden"
				},	
				{
					label: "sqtittd.finish_at",
					name: "sqtittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "sqtittd",
					type: "hidden"
				},	
				{
					label: "sqtittd.transaction_state",
					name: "sqtittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_sqtxxth",
					name: "sqtittd.id_sqtxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "sqtittd.id_iimxxmh",
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "sqtittd.jumlah_unit"
				}, 
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "sqtittd.id_iumxxmh_unit",
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
					label: "Harga <sup class='text-danger'>*<sup>", 
					name: "sqtittd.harga_unit",
				},
				{
					label: "Keterangan",
					name: "sqtittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtsqtittd.on( 'preOpen', function( e, mode, action ) {
			edtsqtittd.field('sqtittd.id_sqtxxth').val(id_sqtxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtittd.field('sqtittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblsqtittd.rows().deselect();
			}
		});

		edtsqtittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtsqtittd.dependent( 'sqtittd.id_iimxxmh', function ( val, data, callback ) {
			id_iimxxmh = edtsqtittd.field('sqtittd.id_iimxxmh').val();
			return {}
		}, {event: 'keyup change'});
		
		edtsqtittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				id_iimxxmh = edtsqtittd.field('sqtittd.id_iimxxmh').val();
				id_iumxxmh_unit = edtsqtittd.field('sqtittd.id_iumxxmh_unit').val();
				jumlah_unit     = edtsqtittd.field('sqtittd.jumlah_unit').val();
				harga_unit      = edtsqtittd.field('sqtittd.harga_unit').val();

				validasiRequired(
					edtsqtittd,
					'sqtittd',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit': jumlah_unit,
						'harga_unit': harga_unit
					}
				);

				validasiNumber(
					edtsqtittd,
					'sqtittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

				validasiNumber(
					edtsqtittd,
					'sqtittd',
					{
						'harga_unit': harga_unit,
					},
					0,
					'>'
				);
				
			}
			
			if ( edtsqtittd.inError() ) {
				return false;
			}
		});

		edtsqtittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsqtittd.field('sqtittd.finish_at').val(finish_at);
		});
			
		edtsqtittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtsqtittd.on( 'close', function () {
			edtsqtittd.enable();
		} );
			
		tblsqtittd = $('#tblsqtittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/sqtxxth/sqtittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_sqtittd = show_deleted_sqtittd;
					d.id_sqtxxth = id_sqtxxth;
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
				{ data: "sqtittd.id",visible:false },
				{ data: "sqtittd.id_sqtxxth",visible:false },
				{ data: "sqtittd.nama" },
				{ 
					data: "sqtittd.jumlah_unit",
					...renderNumber(0)
				},
				{ data: "iumxxmh.nama" },
				{ data: "sqtittd.tanggal_dibutuhkan" },
				{ data: "sqtittd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sqtittd';
					$table       = 'tblsqtittd';
					$edt         = 'edtsqtittd';
					$show_status = '_sqtittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
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

		tblsqtittd.searchPanes.container().appendTo('#spsqtittd');
		tblsqtittd.searchBuilder.container().appendTo( '#sbsqtittd' );

		tblsqtittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblsqtxxth, tblsqtittd, 'sqtittd' );
			CekDrawDetailHDFinal(tblsqtxxth);
		} );

		tblsqtittd.on( 'select', function( e, dt, type, indexes ) {
			data_sqtittd 		= tblsqtittd.row( { selected: true } ).data().sqtittd;
			id_sqtittd   		= data_sqtittd.id;
			id_transaksi_d 		= id_sqtittd; // dipakai untuk general
			id_transaksi_log_d 	= id_sqtittd; // dipakai untuk log

			transaction_state_d   = data_sqtittd.transaction_state;

			id_iumxxmh_old      = data_sqtittd.id_iumxxmh_unit;
			id_iimxxmh          = data_sqtittd.id_iimxxmh;
			id_iimxxmh_unit_old = data_sqtittd.id_iimxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblsqtxxth, tblsqtittd );
		} );

		tblsqtittd.on( 'deselect', function() {
			id_sqtittd = 0;
			id_iumxxmh_old   = 0, id_iimxxmh_unit_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblsqtxxth, tblsqtittd );
		} );

		// END sqtittd
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
