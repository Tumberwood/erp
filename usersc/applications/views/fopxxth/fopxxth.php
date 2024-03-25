<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'fopxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'fopaktd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- <div class="table-responsive"> -->
                    <table id="tblfopxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
                <!-- </div> -->
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabfopaktd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabfopaktd_1" class="tab-pane active">
					<div class="panel-body">
						<!-- <div class="table-responsive"> -->
							<table id="tblfopaktd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_fopxxth</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fopxxth/fn/fopxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtfopxxth, tblfopxxth, show_deleted_fopxxth = 0, id_fopxxth;
	var edtfopaktd, tblfopaktd, show_deleted_fopaktd = 0, id_fopaktd;
	// ------------- end of default variable

	var id_aakxxmh_kasbank_old = 0;
	var id_aakxxmh_old = 0;

	// get tableRelation
	tableRelation('fopxxth');

	$(document).ready(function() {
		
		// BEGIN fopxxth
		edtfopxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/fopxxth/fopxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fopxxth = show_deleted_fopxxth;
				}
			},
			table: "#tblfopxxth",
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
					label: "fopxxth.start_at",
					name: "fopxxth.start_at",
					type: "hidden"
				},	
				{
					label: "fopxxth.finish_at",
					name: "fopxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fopxxth",
					type: "hidden"
				},	
				{
					label: "fopxxth.transaction_state",
					name: "fopxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "fopxxth.tanggal",
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
					name: "fopxxth.id_aakxxmh",
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
					name: "fopxxth.amount",
					type: "readonly"
				},
				{
					label: "Keterangan <sup class='text-danger'>*<sup>",
					name: "fopxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtfopxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfopxxth.field('fopxxth.start_at').val(start_at);

			if(action == 'create'){
				edtfopxxth.field('kategori_dokumen').val('');
				edtfopxxth.field('kategori_dokumen_value').val('');
				edtfopxxth.field('field_tanggal').val('tanggal');
				tblfopxxth.rows().deselect();
			}
		});

		edtfopxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtfopxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				tanggal = edtfopxxth.field('fopxxth.tanggal').val();
				id_aakxxmh = edtfopxxth.field('fopxxth.id_aakxxmh').val();

				validasiRequired(
					edtfopxxth,
					'fopxxth',
					{
						'tanggal': tanggal,
						'id_aakxxmh': id_aakxxmh
					}
				);

			}
			
			if ( edtfopxxth.inError() ) {
				return false;
			}
		});

		edtfopxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfopxxth.field('fopxxth.finish_at').val(finish_at);
		});
		
		edtfopxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtfopxxth.on( 'close', function () {
			edtfopxxth.enable();
		} );
		
		tblfopxxth = $('#tblfopxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/fopxxth/fopxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fopxxth = show_deleted_fopxxth;
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
					targets: [0,4,5]
				}
			],
			columns: [
				{ data: "fopxxth.id",visible:false },
				{ data: "fopxxth.tanggal" },
				{ data: "fopxxth.kode" },
				{ data: "aakxxmh.nama" },
				{ 
					data: "fopxxth.amount" ,
					...renderNumber(2)
				},
				{ data: "fopxxth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fopxxth';
					$table       = 'tblfopxxth';
					$edt         = 'edtfopxxth';
					$show_status = '_fopxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrint',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Voucher',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('fopxxth_jv_print.php?id_fopxxth='+id_fopxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.fopxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.fopxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblfopxxth.searchPanes.container().appendTo('#spfopxxth');
		tblfopxxth.searchBuilder.container().appendTo( '#sbfopxxth' );
		
		tblfopxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblfopaktd];
			CekInitHeaderHD(tblfopxxth, tbl_details);
		} );
		
		tblfopxxth.on( 'select', function( e, dt, type, indexes ) {
			fopxxth_data    		= tblfopxxth.row( { selected: true } ).data().fopxxth;
			id_fopxxth      		= fopxxth_data.id;
			id_transaksi_h 		= id_fopxxth; // dipakai untuk general
			id_transaksi_log	= id_fopxxth; // dipakai untuk general
			transaction_state   = fopxxth_data.transaction_state;
			approval_state   	= fopxxth_data.approval_state;
			is_nextprocess 		= fopxxth_data.is_nextprocess;

			id_aakxxmh_kasbank_old = fopxxth_data.id_aakxxmh;
			
			// atur hak akses
			tbl_details = [tblfopaktd];
			CekSelectHeaderHD(tblfopxxth, tbl_details);

		} );
		
		tblfopxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_fopxxth = 0;
			id_aakxxmh_kasbank_old = 0;

			// atur hak akses
			tbl_details = [tblfopaktd];
			CekDeselectHeaderHD(tblfopxxth, tbl_details);
		} );
		
		// END fopxxth

		// BEGIN fopaktd

		edtfopaktd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/fopxxth/fopaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fopaktd = show_deleted_fopaktd;
					d.id_fopxxth = id_fopxxth;
				}
			},
			table: "#tblfopaktd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "fopaktd.start_at",
					name: "fopaktd.start_at",
					type: "hidden"
				},	
				{
					label: "fopaktd.finish_at",
					name: "fopaktd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fopaktd",
					type: "hidden"
				},	
				{
					label: "fopaktd.transaction_state",
					name: "fopaktd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_fopxxth",
					name: "fopaktd.id_fopxxth",
					type: "hidden"
				},	
				{
					label: "Akun <sup class='text-danger'>*<sup>",
					name: "fopaktd.id_aakxxmh",
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
					name: "fopaktd.amount"
				}, 	
				{
					label: "Keterangan",
					name: "fopaktd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtfopaktd.on( 'preOpen', function( e, mode, action ) {
			edtfopaktd.field('fopaktd.id_fopxxth').val(id_fopxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfopaktd.field('fopaktd.start_at').val(start_at);
			
			if(action == 'create'){
				tblfopaktd.rows().deselect();
			}
		});

		edtfopaktd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtfopaktd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh = edtfopaktd.field('fopaktd.id_aakxxmh').val();
				amount = edtfopaktd.field('fopaktd.amount').val();

				validasiRequired(
					edtfopaktd,
					'fopaktd',
					{
						'id_aakxxmh': id_aakxxmh
					}
				);

				validasiNumber(
					edtfopaktd,
					'fopaktd',
					{
						'amount': amount
					},
					0,
					'>'
				);
			
			}
			
			if ( edtfopaktd.inError() ) {
				return false;
			}
		});

		edtfopaktd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfopaktd.field('fopaktd.finish_at').val(finish_at);
		});
			
		edtfopaktd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// tblfopxxth.rows().deselect();
			tblfopaktd.ajax.reload(null, false);
			tblfopxxth.ajax.reload(null, false);
		} );

		edtfopaktd.on( 'close', function () {
			edtfopaktd.enable();
		} );
		
		tblfopaktd = $('#tblfopaktd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/fopxxth/fopaktd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fopaktd = show_deleted_fopaktd;
					d.id_fopxxth = id_fopxxth;
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
				{ data: "fopaktd.id",visible:false },
				{ data: "fopaktd.id_fopxxth",visible:false },
				{ data: "fopaktd.aakxxmh" },
				{ 
					data: "fopaktd.amount" ,
					...renderNumber(2)
				},
				{ data: "fopaktd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fopaktd';
					$table       = 'tblfopaktd';
					$edt         = 'edtfopaktd';
					$show_status = '_fopaktd';
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

		tblfopaktd.searchPanes.container().appendTo('#spfopaktd');
		tblfopaktd.searchBuilder.container().appendTo( '#sbfopaktd' );

		tblfopaktd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblfopxxth, tblfopaktd, 'fopaktd' );
			CekDrawDetailHDFinal(tblfopxxth);
		} );

		tblfopaktd.on( 'select', function( e, dt, type, indexes ) {
			data_fopaktd 		= tblfopaktd.row( { selected: true } ).data().fopaktd;
			id_fopaktd   		= data_fopaktd.id;
			id_transaksi_d 		= id_fopaktd; // dipakai untuk general
			id_transaksi_log 	= id_fopaktd; // dipakai untuk log

			transaction_state_d   = data_fopaktd.transaction_state;
			id_aakxxmh_old   = data_fopaktd.id_aakxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblfopxxth, tblfopaktd );
		} );

		tblfopaktd.on( 'deselect', function() {
			id_fopaktd = 0;
			id_aakxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblfopxxth, tblfopaktd );
		} );

		// END fopaktd
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
