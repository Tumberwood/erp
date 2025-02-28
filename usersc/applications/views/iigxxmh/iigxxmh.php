<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'iigxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'iigxxmh_aakxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="table-responsive">
                    <table id="tbliigxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabiigxxmh_aakxxmh"> Account</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabiigxxmh_aakxxmh" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbliigxxmh_aakxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_iigxxmh</th>
										<th data-i18n="inventory"></th>
										<th data-i18n="expenses"></th>
										<th data-i18n="Penjualan"></th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iigxxmh/fn/iigxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtiigxxmh, tbliigxxmh, show_deleted_iigxxmh = 0, id_iigxxmh;
	var edtiigxxmh_aakxxmh, tbliigxxmh_aakxxmh, show_deleted_iigxxmh_aakxxmh = 0, id_iigxxmh_aakxxmh;
	// ------------- end of default variable

	var id_aakxxmh_persediaan_old  = 0, id_aakxxmh_biaya_old = 0, id_aakxxmh_penjualan_old = 0;

	// get tableRelation
	tableRelation('iigxxmh');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN iigxxmh
		edtiigxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iigxxmh/iigxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iigxxmh = show_deleted_iigxxmh;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tbliigxxmh",
			fields: [ 
				{
					label: "iigxxmh.start_at",
					name: "iigxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iigxxmh.finish_at",
					name: "iigxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iigxxmh",
					type: "hidden"
				},	
				{
					label: "iigxxmh.transaction_state",
					name: "iigxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "iigxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "iigxxmh.nama"
				}, 
				{
					label: getTranslation('notes'),
					name: "iigxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtiigxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiigxxmh.field('iigxxmh.start_at').val(start_at);

			if(action == 'create'){
				tbliigxxmh.rows().deselect();
			}
		});

		edtiigxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtiigxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtiigxxmh.field('iigxxmh.kode').val();
				nama = edtiigxxmh.field('iigxxmh.nama').val();
				validasiRequired(
					edtiigxxmh,
					'iigxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtiigxxmh,
					'iigxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_iigxxmh,
				);

				validasiUnique(
					action,
					edtiigxxmh,
					'iigxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_iigxxmh,
				);
			}
			
			if ( edtiigxxmh.inError() ) {
				return false;
			}
		});

		edtiigxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiigxxmh.field('iigxxmh.finish_at').val(finish_at);
		});
		
		edtiigxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtiigxxmh.on( 'close', function () {
			edtiigxxmh.enable();
		} );
		
		tbliigxxmh = $('#tbliigxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iigxxmh/iigxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iigxxmh = show_deleted_iigxxmh;
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
				{ data: "iigxxmh.id",visible:false },
				{ data: "iigxxmh.kode" },
				{ data: "iigxxmh.nama" },
				{ 
					data: "iigxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iigxxmh';
					$table       = 'tbliigxxmh';
					$edt         = 'edtiigxxmh';
					$show_status = '_iigxxmh';
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
				if ( data.iigxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iigxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbliigxxmh.searchPanes.container().appendTo('#spiigxxmh');
		tbliigxxmh.searchBuilder.container().appendTo( '#sbiigxxmh' );
		
		tbliigxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbliigxxmh_aakxxmh];
			CekInitHeaderHD(tbliigxxmh, tbl_details);
		} );
		
		tbliigxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iigxxmh');
			
			// atur hak akses
			tbl_details = [tbliigxxmh_aakxxmh];
			CekSelectHeaderHD(tbliigxxmh, tbl_details);

		} );
		
		tbliigxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iigxxmh');

			// atur hak akses
			tbl_details = [tbliigxxmh_aakxxmh];
			CekDeselectHeaderHD(tbliigxxmh, tbl_details);
		} );
		// END iigxxmh

		// BEGIN iigxxmh_aakxxmh
		edtiigxxmh_aakxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iigxxmh/iigxxmh_aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iigxxmh_aakxxmh = show_deleted_iigxxmh_aakxxmh;
					d.id_iigxxmh = id_iigxxmh;
				}
			},
			table: "#tbliigxxmh_aakxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "iigxxmh_aakxxmh.start_at",
					name: "iigxxmh_aakxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iigxxmh_aakxxmh.finish_at",
					name: "iigxxmh_aakxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iigxxmh_aakxxmh",
					type: "hidden"
				},	
				{
					label: "iigxxmh_aakxxmh.transaction_state",
					name: "iigxxmh_aakxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_iigxxmh",
					name: "iigxxmh_aakxxmh.id_iigxxmh",
					type: "hidden"
				},	
				{
					label: "Akun Persediaan",
					name: "iigxxmh_aakxxmh.id_aakxxmh_persediaan",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_persediaan.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_persediaan_old: id_aakxxmh_persediaan_old,
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
					label: "Akun Biaya",
					name: "iigxxmh_aakxxmh.id_aakxxmh_biaya",
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
									id_aakxxmh_old: id_aakxxmh_biaya_old,
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
					label: "Akun Penjualan",
					name: "iigxxmh_aakxxmh.id_aakxxmh_penjualan",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_type_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_penjualan_old,
									id_aatxxmh: '13',
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
			
		edtiigxxmh_aakxxmh.on( 'preOpen', function( e, mode, action ) {
			edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.id_iigxxmh').val(id_iigxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbliigxxmh_aakxxmh.rows().deselect();
			}
		});

		edtiigxxmh_aakxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtiigxxmh_aakxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh_persediaan = edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.id_aakxxmh_persediaan').val();
				id_aakxxmh_biaya = edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.id_aakxxmh_biaya').val();

				if( (!id_aakxxmh_persediaan || id_aakxxmh_persediaan == '') && (!id_aakxxmh_biaya || id_aakxxmh_biaya == '') ){
					edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.id_aakxxmh_persediaan').error( 'Wajib diisi salah satu!' );
					edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.id_aakxxmh_biaya').error( 'Wajib diisi salah satu!' );
				}

			}
			
			if ( edtiigxxmh_aakxxmh.inError() ) {
				return false;
			}
		});

		edtiigxxmh_aakxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiigxxmh_aakxxmh.field('iigxxmh_aakxxmh.finish_at').val(finish_at);
		});
			
		edtiigxxmh_aakxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			tbliigxxmh.ajax.reload(null, false);
		} );

		edtiigxxmh_aakxxmh.on( 'close', function () {
			edtiigxxmh_aakxxmh.enable();
		} );
		
		tbliigxxmh_aakxxmh = $('#tbliigxxmh_aakxxmh').DataTable( {
			ajax: {
				url: "../../models/iigxxmh/iigxxmh_aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iigxxmh_aakxxmh = show_deleted_iigxxmh_aakxxmh;
					d.id_iigxxmh = id_iigxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "iigxxmh_aakxxmh.id",visible:false },
				{ data: "iigxxmh_aakxxmh.id_iigxxmh",visible:false },
				{ data: "aakxxmh_persediaan" },
				{ data: "aakxxmh_biaya" },
				{ data: "aakxxmh_penjualan" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iigxxmh_aakxxmh';
					$table       = 'tbliigxxmh_aakxxmh';
					$edt         = 'edtiigxxmh_aakxxmh';
					$show_status = '_iigxxmh_aakxxmh';
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

		tbliigxxmh_aakxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbliigxxmh_aakxxmh, 1 );
			CekDrawDetailHDFinal(tbliigxxmh);
		} );

		tbliigxxmh_aakxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('iigxxmh_aakxxmh');
			id_aakxxmh_persediaan_old  = iigxxmh_aakxxmh_data.id_aakxxmh_persediaan;
			id_aakxxmh_biaya_old  = iigxxmh_aakxxmh_data.id_aakxxmh_biaya;
			id_aakxxmh_penjualan_old  = iigxxmh_aakxxmh_data.id_aakxxmh_penjualan;
			
			// atur hak akses
			CekSelectDetailHD( tbliigxxmh_aakxxmh );
		} );

		tbliigxxmh_aakxxmh.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('iigxxmh_aakxxmh');
			id_aakxxmh_persediaan_old  = 0, id_aakxxmh_biaya_old  = 0, id_aakxxmh_penjualan_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbliigxxmh_aakxxmh );
		} );
		// END iigxxmh_aakxxmh

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbliigxxmh.rows().deselect();
				tbliigxxmh.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFiigxxmh').modal('toggle');
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
