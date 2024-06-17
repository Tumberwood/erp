<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'iicxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'iicxxmh_aakxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliicxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="notes"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabiicxxmh_aakxxmh"> Account</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabiicxxmh_aakxxmh" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbliicxxmh_aakxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_iicxxmh</th>
										<th>Kode</th>
										<th>Nama</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iicxxmh/fn/iicxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtiicxxmh, tbliicxxmh, show_deleted_iicxxmh = 0, id_iicxxmh;
	var edtiicxxmh_aakxxmh, tbliicxxmh_aakxxmh, show_deleted_iicxxmh_aakxxmh = 0, id_iicxxmh_aakxxmh;
	// ------------- end of default variable

	var id_aakxxmh_persediaan_old  = 0;

	// get tableRelation
	tableRelation('iicxxmh');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN iicxxmh
		edtiicxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iicxxmh/iicxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iicxxmh = show_deleted_iicxxmh;
				}
			},
			table: "#tbliicxxmh",
			fields: [ 
				{
					label: "iicxxmh.start_at",
					name: "iicxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iicxxmh.finish_at",
					name: "iicxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iicxxmh",
					type: "hidden"
				},	
				{
					label: "iicxxmh.transaction_state",
					name: "iicxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "iicxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "iicxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "iicxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtiicxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiicxxmh.field('iicxxmh.start_at').val(start_at);

			if(action == 'create'){
				tbliicxxmh.rows().deselect();
			}
		});

		edtiicxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtiicxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtiicxxmh.field('iicxxmh.kode').val();
				nama = edtiicxxmh.field('iicxxmh.nama').val();
				validasiRequired(
					edtiicxxmh,
					'iicxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtiicxxmh,
					'iicxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_iicxxmh,
				);

				validasiUnique(
					action,
					edtiicxxmh,
					'iicxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_iicxxmh,
				);
			}
			
			if ( edtiicxxmh.inError() ) {
				return false;
			}
		});

		edtiicxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiicxxmh.field('iicxxmh.finish_at').val(finish_at);
		});
		
		edtiicxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtiicxxmh.on( 'close', function () {
			edtiicxxmh.enable();
		} );
		
		tbliicxxmh = $('#tbliicxxmh').DataTable( {
			ajax: {
				url: "../../models/iicxxmh/iicxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iicxxmh = show_deleted_iicxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "iicxxmh.id",visible:false },
				{ data: "iicxxmh.kode" },
				{ data: "iicxxmh.nama" },
				{ data: "iicxxmh.keterangan" },
				{ 
					data: "iicxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iicxxmh';
					$table       = 'tbliicxxmh';
					$edt         = 'edtiicxxmh';
					$show_status = '_iicxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h','view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
				if ( data.iicxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iicxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );
		
		tbliicxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbliicxxmh_aakxxmh];
			CekInitHeaderHD(tbliicxxmh, tbl_details);
		} );
		
		tbliicxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iicxxmh');
			
			// atur hak akses
			tbl_details = [tbliicxxmh_aakxxmh];
			CekSelectHeaderHD(tbliicxxmh, tbl_details);

		} );
		
		tbliicxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iicxxmh');

			// atur hak akses
			tbl_details = [tbliicxxmh_aakxxmh];
			CekDeselectHeaderHD(tbliicxxmh, tbl_details);
		} );
		// END iicxxmh

		// BEGIN iicxxmh_aakxxmh
		edtiicxxmh_aakxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iicxxmh/iicxxmh_aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iicxxmh_aakxxmh = show_deleted_iicxxmh_aakxxmh;
					d.id_iicxxmh = id_iicxxmh;
				}
			},
			table: "#tbliicxxmh_aakxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "iicxxmh_aakxxmh.start_at",
					name: "iicxxmh_aakxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iicxxmh_aakxxmh.finish_at",
					name: "iicxxmh_aakxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iicxxmh_aakxxmh",
					type: "hidden"
				},	
				{
					label: "iicxxmh_aakxxmh.transaction_state",
					name: "iicxxmh_aakxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_iicxxmh",
					name: "iicxxmh_aakxxmh.id_iicxxmh",
					type: "hidden"
				},	
				{
					label: "Akun Persediaan",
					name: "iicxxmh_aakxxmh.id_aakxxmh_persediaan",
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
			]
		} );
			
		edtiicxxmh_aakxxmh.on( 'preOpen', function( e, mode, action ) {
			edtiicxxmh_aakxxmh.field('iicxxmh_aakxxmh.id_iicxxmh').val(id_iicxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiicxxmh_aakxxmh.field('iicxxmh_aakxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbliicxxmh_aakxxmh.rows().deselect();
			}
		});

		edtiicxxmh_aakxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtiicxxmh_aakxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_aakxxmh_persediaan = edtiicxxmh_aakxxmh.field('iicxxmh_aakxxmh.id_aakxxmh_persediaan').val();

				validasiRequired(
					edtiicxxmh_aakxxmh,
					'iicxxmh_aakxxmh',
					{
						'id_aakxxmh_persediaan': id_aakxxmh_persediaan
					}
				);

			}
			
			if ( edtiicxxmh_aakxxmh.inError() ) {
				return false;
			}
		});

		edtiicxxmh_aakxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiicxxmh_aakxxmh.field('iicxxmh_aakxxmh.finish_at').val(finish_at);
		});
			
		edtiicxxmh_aakxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtiicxxmh_aakxxmh.on( 'close', function () {
			edtiicxxmh_aakxxmh.enable();
		} );
		
		tbliicxxmh_aakxxmh = $('#tbliicxxmh_aakxxmh').DataTable( {
			ajax: {
				url: "../../models/iicxxmh/iicxxmh_aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iicxxmh_aakxxmh = show_deleted_iicxxmh_aakxxmh;
					d.id_iicxxmh = id_iicxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "iicxxmh_aakxxmh.id",visible:false },
				{ data: "iicxxmh_aakxxmh.id_iicxxmh",visible:false },
				{ data: "aakxxmh_persediaan.kode" },
				{ data: "aakxxmh_persediaan.nama" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iicxxmh_aakxxmh';
					$table       = 'tbliicxxmh_aakxxmh';
					$edt         = 'edtiicxxmh_aakxxmh';
					$show_status = '_iicxxmh_aakxxmh';
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

		tbliicxxmh_aakxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tbliicxxmh_aakxxmh, 1 );
			CekDrawDetailHDFinal(tbliicxxmh);
			c_rows = tbliicxxmh_aakxxmh.rows().count();
			
			if(c_rows == 1){
				tbliicxxmh_aakxxmh.button( 'btnCreate:name' ).disable();
			}else{
				tbliicxxmh_aakxxmh.button( 'btnCreate:name' ).enable();
			}
			
		} );

		tbliicxxmh_aakxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('iicxxmh_aakxxmh');
			id_aakxxmh_persediaan_old  = iicxxmh_aakxxmh_data.id_aakxxmh_persediaan;
			
			// atur hak akses
			CekSelectDetailHD( tbliicxxmh_aakxxmh );
		} );

		tbliicxxmh_aakxxmh.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('iicxxmh_aakxxmh');
			id_aakxxmh_persediaan_old  = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tbliicxxmh_aakxxmh );
		} );
		// END iicxxmh_aakxxmh
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
