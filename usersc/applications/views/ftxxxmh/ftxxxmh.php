<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'ftxxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'ftxrtmd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblftxxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="progressive"></th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabftxrtmd"> Tarif</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabftxrtmd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblftxrtmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_ftxxxmh</th>
										<th data-i18n="upperLimit" data-toggle="tooltip" data-placement="top" title="" data-original-title=">="></th>
										<th data-i18n="lowerLimit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<"></th>
										<th data-i18n="ratesPercentage"></th>
										<th data-i18n="notes"></th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ftxxxmh/fn/ftxxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtftxxxmh, tblftxxxmh, show_deleted_ftxxxmh = 0, id_ftxxxmh;
	var edtftxrtmd, tblftxrtmd, show_deleted_ftxrtmd = 0, id_ftxrtmd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('ftxxxmh');

	var is_progressif = 0;

	$(document).ready(function() {
		// BEGIN ftxxxmh
		edtftxxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ftxxxmh/ftxxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ftxxxmh = show_deleted_ftxxxmh;
				}
			},
			table: "#tblftxxxmh",
			fields: [ 
				{
					label: "ftxxxmh.start_at",
					name: "ftxxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "ftxxxmh.finish_at",
					name: "ftxxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ftxxxmh",
					type: "hidden"
				},	
				{
					label: "ftxxxmh.transaction_state",
					name: "ftxxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('tax') + "<sup class='text-danger'>*<sup>",
					name: "ftxxxmh.kode"
				}, 	
				{
					label: getTranslation('progressive'),
					name: "ftxxxmh.is_progressif",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: getTranslation('notes'),
					name: "ftxxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtftxxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtftxxxmh.field('ftxxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblftxxxmh.rows().deselect();

				edtftxxxmh.field('ftxxxmh.kode').enable();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtftxxxmh.field('ftxxxmh.kode').enable();
				}else{
					edtftxxxmh.field('ftxxxmh.kode').disable();
				}
			}
		});

		edtftxxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});
		
		edtftxxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				kode = edtftxxxmh.field('ftxxxmh.kode').val();
					
				validasiRequired(
					edtftxxxmh,
					'ftxxxmh',
					{
						'kode': kode
					}
				);
				
			}
			
			if ( edtftxxxmh.inError() ) {
				return false;
			}
		});

		edtftxxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtftxxxmh.field('ftxxxmh.finish_at').val(finish_at);
		});
		
		edtftxxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtftxxxmh.on( 'close', function () {
			edtftxxxmh.enable();
		} );
		
		tblftxxxmh = $('#tblftxxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ftxxxmh/ftxxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ftxxxmh = show_deleted_ftxxxmh;
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
				{ data: "ftxxxmh.id",visible:false },
				{ data: "ftxxxmh.kode" },
				{ 
					data: "ftxxxmh.is_progressif",
					...renderYaTidak()
				},
				{ data: "ftxxxmh.keterangan" },
				{ 
					data: "ftxxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ftxxxmh';
					$table       = 'tblftxxxmh';
					$edt         = 'edtftxxxmh';
					$show_status = '_ftxxxmh';
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
				if ( data.ftxxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ftxxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblftxxxmh.searchPanes.container().appendTo('#spftxxxmh');
		tblftxxxmh.searchBuilder.container().appendTo( '#sbftxxxmh' );
		
		tblftxxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblftxrtmd];
			CekInitHeaderHD(tblftxxxmh, tbl_details);
		} );
		
		tblftxxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ftxxxmh');
			is_progressif 		= ftxxxmh_data.is_progressif

			// atur hak akses
			tbl_details = [tblftxrtmd];
			CekSelectHeaderHD(tblftxxxmh, tbl_details);

		} );
		
		tblftxxxmh.on( 'deselect', function () {
			// set variable standar framework
			siVarReset('ftxxxmh');

			// atur hak akses
			tbl_details = [tblftxrtmd];
			CekDeselectHeaderHD(tblftxxxmh, tbl_details);
		} );
		

		// BEGIN ftxrtmd
		edtftxrtmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ftxxxmh/ftxrtmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ftxrtmd = show_deleted_ftxrtmd;
					d.id_ftxxxmh = id_ftxxxmh;
				}
			},
			table: "#tblftxrtmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "ftxrtmd.start_at",
					name: "ftxrtmd.start_at",
					type: "hidden"
				},	
				{
					label: "ftxrtmd.finish_at",
					name: "ftxrtmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ftxrtmd",
					type: "hidden"
				},	
				{
					label: "ftxrtmd.transaction_state",
					name: "ftxrtmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_ftxxxmh",
					name: "ftxrtmd.id_ftxxxmh",
					type: "hidden"
				},	
				{
					label: getTranslation('lowerLimit') + "<sup class='text-danger'>*<sup>",
					label: "Batas Bawah <sup class='text-danger'>*<sup>",
					name: "ftxrtmd.batas_bawah"
				}, 	
				{
					label: getTranslation('upperLimit') + "<sup class='text-danger'>*<sup>",
					name: "ftxrtmd.batas_atas"
				}, 	
				{
					label: getTranslation('rates') + "<sup class='text-danger'>*<sup>",
					name: "ftxrtmd.tarif"
				}, 	
				{
					label: getTranslation('notes'),
					name: "ftxrtmd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtftxrtmd.on( 'preOpen', function( e, mode, action ) {
			edtftxrtmd.field('ftxrtmd.id_ftxxxmh').val(id_ftxxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtftxrtmd.field('ftxrtmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblftxrtmd.rows().deselect();
			}
			console.log(is_progressif);
			if(is_progressif == 1){
				edtftxrtmd.field('ftxrtmd.batas_bawah').show();
				edtftxrtmd.field('ftxrtmd.batas_atas').show();
			}else{
				edtftxrtmd.field('ftxrtmd.batas_bawah').hide();
				edtftxrtmd.field('ftxrtmd.batas_atas').hide();
			}
		});

		edtftxrtmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		
		edtftxrtmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tarif = edtftxrtmd.field('ftxrtmd.tarif').val();
				validasiNumber(
					edtftxrtmd,
					'ftxrtmd',
					{
						'tarif': tarif
					},
					0,
					'>'
				);

				if(is_progressif == 1){
					validasiNumber(
						edtftxrtmd,
						'ftxrtmd',
						{
							'batas_bawah': batas_bawah,
							'batas_atas': batas_atas
						},
						0,
						'>'
					);
				}
			}
			
			if ( edtftxrtmd.inError() ) {
				return false;
			}
		});

		edtftxrtmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtftxrtmd.field('ftxrtmd.finish_at').val(finish_at);
		});
			
		edtftxrtmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblftxrtmd.rows().deselect();
			tblftxrtmd.ajax.reload(null, false);
		} );

		edtftxrtmd.on( 'close', function () {
			edtftxrtmd.enable();
		} );
		
		tblftxrtmd = $('#tblftxrtmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ftxxxmh/ftxrtmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ftxrtmd = show_deleted_ftxrtmd;
					d.id_ftxxxmh = id_ftxxxmh;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "ftxrtmd.id",visible:false },
				{ data: "ftxrtmd.id_ftxxxmh",visible:false },
				{ 
					data: "ftxrtmd.batas_bawah",
					...renderNumber(0)
				},
				{ 
					data: "ftxrtmd.batas_atas",
					...renderNumber(0)
				},
				{ 
					data: "ftxrtmd.tarif",
					...renderNumber(0)
				},
				{ data: "ftxrtmd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ftxrtmd';
					$table       = 'tblftxrtmd';
					$edt         = 'edtftxrtmd';
					$show_status = '_ftxrtmd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
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

		tblftxrtmd.searchPanes.container().appendTo('#spftxrtmd');
		tblftxrtmd.searchBuilder.container().appendTo( '#sbftxrtmd' );

		tblftxrtmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblftxrtmd, 1 );
			CekDrawDetailHDFinal(tblftxxxmh);
		} );

		tblftxrtmd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('ftxrtmd');
			
			// atur hak akses
			CekSelectDetailHD( tblftxrtmd );
		} );

		tblftxrtmd.on( 'deselect', function() {
			siVarResetD('ftxrtmd');
			
			// atur hak akses
			CekDeselectDetailHD( tblftxrtmd );
		} );

		// END ftxrtmd
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
