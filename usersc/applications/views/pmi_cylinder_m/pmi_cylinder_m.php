<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'pmi_cylinder_m';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'pmi_cylinder_m_color';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="table-responsive">
                    <table id="tblpmi_cylinder_m" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
								<th>State</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabpmi_cylinder_m_color_1"> Warna</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabpmi_cylinder_m_color_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpmi_cylinder_m_color" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_pmi_cylinder_m</th>
										<th>Warna</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pmi_cylinder_m/fn/pmi_cylinder_m_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtpmi_cylinder_m, tblpmi_cylinder_m, show_deleted_pmi_cylinder_m = 0, id_pmi_cylinder_m;
	var edtpmi_cylinder_m_color, tblpmi_cylinder_m_color, show_deleted_pmi_cylinder_m_color = 0, id_pmi_cylinder_m_color;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('pmi_cylinder_m');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN pmi_cylinder_m
		edtpmi_cylinder_m = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pmi_cylinder_m/pmi_cylinder_m.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_m = show_deleted_pmi_cylinder_m;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblpmi_cylinder_m",
			fields: [ 
				{
					label: "pmi_cylinder_m.start_at",
					name: "pmi_cylinder_m.start_at",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_m.finish_at",
					name: "pmi_cylinder_m.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pmi_cylinder_m",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_m.transaction_state",
					name: "pmi_cylinder_m.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_m.nama"
				}, 	
			]
		} );
		
		edtpmi_cylinder_m.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_m.field('pmi_cylinder_m.start_at').val(start_at);

			if(action == 'create'){
				tblpmi_cylinder_m.rows().deselect();
			}
		});

		edtpmi_cylinder_m.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtpmi_cylinder_m.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtpmi_cylinder_m.field('pmi_cylinder_m.nama').val();

				validasiRequired(
					edtpmi_cylinder_m,
					'pmi_cylinder_m',
					{
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtpmi_cylinder_m,
					'pmi_cylinder_m',
					'nama',
					'nama',
					'"'+nama+'"',
					id_pmi_cylinder_m
				);
			}
			
			if ( edtpmi_cylinder_m.inError() ) {
				return false;
			}
		});

		edtpmi_cylinder_m.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_m.field('pmi_cylinder_m.finish_at').val(finish_at);
		});
		
		edtpmi_cylinder_m.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtpmi_cylinder_m.on( 'close', function () {
			edtpmi_cylinder_m.enable();
		} );
		
		tblpmi_cylinder_m = $('#tblpmi_cylinder_m').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/pmi_cylinder_m/pmi_cylinder_m.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_m = show_deleted_pmi_cylinder_m;
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
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "pmi_cylinder_m.id",visible:false },
				{ data: "pmi_cylinder_m.nama" },
				{ 
					data: "pmi_cylinder_m.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pmi_cylinder_m';
					$table       = 'tblpmi_cylinder_m';
					$edt         = 'edtpmi_cylinder_m';
					$show_status = '_pmi_cylinder_m';
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
				if ( data.pmi_cylinder_m.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.pmi_cylinder_m.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpmi_cylinder_m.searchPanes.container().appendTo('#sppmi_cylinder_m');
		tblpmi_cylinder_m.searchBuilder.container().appendTo( '#sbpmi_cylinder_m' );
		
		tblpmi_cylinder_m.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblpmi_cylinder_m_color];
			CekInitHeaderHD(tblpmi_cylinder_m, tbl_details);
		} );
		
		tblpmi_cylinder_m.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('pmi_cylinder_m');
			
			// atur hak akses
			tbl_details = [tblpmi_cylinder_m_color];
			CekSelectHeaderHD(tblpmi_cylinder_m, tbl_details);

		} );
		
		tblpmi_cylinder_m.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('pmi_cylinder_m');

			// atur hak akses
			tbl_details = [tblpmi_cylinder_m_color];
			CekDeselectHeaderHD(tblpmi_cylinder_m, tbl_details);
		} );
		// END pmi_cylinder_m

		// BEGIN pmi_cylinder_m_color
		edtpmi_cylinder_m_color = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pmi_cylinder_m/pmi_cylinder_m_color.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_m_color = show_deleted_pmi_cylinder_m_color;
					d.id_pmi_cylinder_m = id_pmi_cylinder_m;
				}
			},
			table: "#tblpmi_cylinder_m_color",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "pmi_cylinder_m_color.start_at",
					name: "pmi_cylinder_m_color.start_at",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_m_color.finish_at",
					name: "pmi_cylinder_m_color.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pmi_cylinder_m_color",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_m_color.transaction_state",
					name: "pmi_cylinder_m_color.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_pmi_cylinder_m",
					name: "pmi_cylinder_m_color.id_pmi_cylinder_m",
					type: "hidden"
				},	
				{
					label: "Warna <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_m_color.nama"
				}, 	
			]
		} );
			
		edtpmi_cylinder_m_color.on( 'preOpen', function( e, mode, action ) {
			edtpmi_cylinder_m_color.field('pmi_cylinder_m_color.id_pmi_cylinder_m').val(id_pmi_cylinder_m);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_m_color.field('pmi_cylinder_m_color.start_at').val(start_at);
			
			if(action == 'create'){
				tblpmi_cylinder_m_color.rows().deselect();
			}
		});

		edtpmi_cylinder_m_color.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtpmi_cylinder_m_color.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtpmi_cylinder_m_color.field('pmi_cylinder_m_color.nama').val();

				validasiRequired(
					edtpmi_cylinder_m_color,
					'pmi_cylinder_m_color',
					{
						'nama': nama
					}
				);
			}
			
			if ( edtpmi_cylinder_m_color.inError() ) {
				return false;
			}
		});

		edtpmi_cylinder_m_color.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_m_color.field('pmi_cylinder_m_color.finish_at').val(finish_at);
		});
			
		edtpmi_cylinder_m_color.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblpmi_cylinder_m.ajax.reload(null, false);
		} );

		edtpmi_cylinder_m_color.on( 'close', function () {
			edtpmi_cylinder_m_color.enable();
		} );
		
		tblpmi_cylinder_m_color = $('#tblpmi_cylinder_m_color').DataTable( {
			ajax: {
				url: "../../models/pmi_cylinder_m/pmi_cylinder_m_color.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_m_color = show_deleted_pmi_cylinder_m_color;
					d.id_pmi_cylinder_m = id_pmi_cylinder_m;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "pmi_cylinder_m_color.id",visible:false },
				{ data: "pmi_cylinder_m_color.id_pmi_cylinder_m",visible:false },
				{ data: "pmi_cylinder_m_color.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pmi_cylinder_m_color';
					$table       = 'tblpmi_cylinder_m_color';
					$edt         = 'edtpmi_cylinder_m_color';
					$show_status = '_pmi_cylinder_m_color';
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
			}
		} );

		tblpmi_cylinder_m_color.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblpmi_cylinder_m_color, 1 );
			CekDrawDetailHDFinal(tblpmi_cylinder_m);
		} );

		tblpmi_cylinder_m_color.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('pmi_cylinder_m_color');
			
			// atur hak akses
			CekSelectDetailHD( tblpmi_cylinder_m_color );
		} );

		tblpmi_cylinder_m_color.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('pmi_cylinder_m_color');
			
			// atur hak akses
			CekDeselectDetailHD( tblpmi_cylinder_m_color );
		} );
		// END pmi_cylinder_m_color
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
