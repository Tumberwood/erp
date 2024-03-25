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
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- <div class="table-responsive"> -->
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
                <!-- </div> -->
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/forxxth/fn/forxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtforxxth, tblforxxth, show_deleted_forxxth = 0, id_forxxth;
	var edtforaktd, tblforaktd, show_deleted_foraktd = 0, id_foraktd;
	// ------------- end of default variable

	var id_aakxxmh_kasbank_old = 0;
	var id_aakxxmh_old = 0;

	// get tableRelation
	tableRelation('forxxth');

	$(document).ready(function() {
		// BEGIN forxxth
		edtforxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/forxxth/forxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_forxxth = show_deleted_forxxth;
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
						window.open('forxxth_jv_print.php?id_forxxth='+id_forxxth, '_blank');
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
			forxxth_data    		= tblforxxth.row( { selected: true } ).data().forxxth;
			id_forxxth      		= forxxth_data.id;
			id_transaksi_h 		= id_forxxth; // dipakai untuk general
			id_transaksi_log	= id_forxxth; // dipakai untuk general
			transaction_state   = forxxth_data.transaction_state;
			approval_state   	= forxxth_data.approval_state;
			is_nextprocess 		= forxxth_data.is_nextprocess;

			id_aakxxmh_kasbank_old = forxxth_data.id_aakxxmh;
			
			// atur hak akses
			tbl_details = [tblforaktd];
			CekSelectHeaderHD(tblforxxth, tbl_details);

		} );
		
		tblforxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_forxxth = 0;
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
			cek_c_detail= 1;
			CekDrawDetailHD(tblforxxth, tblforaktd, 'foraktd' );
			CekDrawDetailHDFinal(tblforxxth);
		} );

		tblforaktd.on( 'select', function( e, dt, type, indexes ) {
			data_foraktd 		= tblforaktd.row( { selected: true } ).data().foraktd;
			id_foraktd   		= data_foraktd.id;
			id_transaksi_d 		= id_foraktd; // dipakai untuk general
			id_transaksi_log 	= id_foraktd; // dipakai untuk log

			transaction_state_d   = data_foraktd.transaction_state;
			id_aakxxmh_old   = data_foraktd.id_aakxxmh;
			
			// atur hak akses
			CekSelectDetailHD(tblforxxth, tblforaktd );
		} );

		tblforaktd.on( 'deselect', function() {
			id_foraktd = 0;
			id_aakxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblforxxth, tblforaktd );
		} );

		// END foraktd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
