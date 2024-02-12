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
                                <th>Kode</th>
                                <th>Progresif</th>
                                <th>Keterangan</th>
                                <th>TX</th>
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
										<th>Batas Bawah (>=)</th>
										<th>Batas Atas (<)</th>
										<th>Tarif (%)</th>
										<th>Keterangan</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ftxxxmh/fn/ftxxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtftxxxmh, tblftxxxmh, show_deleted_ftxxxmh = 0, id_ftxxxmh;
	var edtftxrtmd, tblftxrtmd, show_deleted_ftxrtmd = 0, id_ftxrtmd;
	// ------------- end of default variable

	is_master_table = 1;

	var is_progressif = 0;

	$(document).ready(function() {
		//start datatables editor
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
					label: "Pajak <sup class='text-danger'>*<sup>",
					name: "ftxxxmh.kode"
				}, 	
				{
					label: "Progresif",
					name: "ftxxxmh.is_progressif",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
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
		
		//start datatables
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
					targets: [0]
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
					$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
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
			ftxxxmh_data    		= tblftxxxmh.row( { selected: true } ).data().ftxxxmh;
			id_ftxxxmh      		= ftxxxmh_data.id;
			id_transaksi_h 		= id_ftxxxmh; // dipakai untuk general
			id_transaksi_log	= id_ftxxxmh; // dipakai untuk general
			transaction_state   = ftxxxmh_data.transaction_state;
			approval_state   	= ftxxxmh_data.approval_state;
			is_nextprocess 		= ftxxxmh_data.is_nextprocess;
			
			is_progressif 		= ftxxxmh_data.is_progressif

			// atur hak akses
			tbl_details = [tblftxrtmd];
			CekSelectHeaderHD(tblftxxxmh, tbl_details);

		} );
		
		tblftxxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_ftxxxmh = 0;

			// atur hak akses
			tbl_details = [tblftxrtmd];
			CekDeselectHeaderHD(tblftxxxmh, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
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
					label: "Batas Bawah <sup class='text-danger'>*<sup>",
					name: "ftxrtmd.batas_bawah"
				}, 	
				{
					label: "Batas Atas <sup class='text-danger'>*<sup>",
					name: "ftxrtmd.batas_atas"
				}, 	
				{
					label: "Tarif <sup class='text-danger'>*<sup>",
					name: "ftxrtmd.tarif"
				}, 	
				{
					label: "Keterangan",
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
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtftxrtmd.on( 'close', function () {
			edtftxrtmd.enable();
		} );
		
		//start datatables
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
					targets: [0,4]
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
					$arr_buttons_approve 	= ['noapprove'];
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
			cek_c_detail= 1;
			CekDrawDetailHD(tblftxxxmh, tblftxrtmd, 'ftxrtmd' );
			CekDrawDetailHDFinal(tblftxxxmh);
		} );

		tblftxrtmd.on( 'select', function( e, dt, type, indexes ) {
			data_ftxrtmd 		= tblftxrtmd.row( { selected: true } ).data().ftxrtmd;
			id_ftxrtmd   		= data_ftxrtmd.id;
			id_transaksi_d 		= id_ftxrtmd; // dipakai untuk general
			id_transaksi_log 	= id_ftxrtmd; // dipakai untuk log

			transaction_state_d   = data_ftxrtmd.transaction_state;
			
			// atur hak akses
			CekSelectDetailHD(tblftxxxmh, tblftxrtmd );
		} );

		tblftxrtmd.on( 'deselect', function() {
			id_ftxrtmd = 0;
			is_active_d = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblftxxxmh, tblftxrtmd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
