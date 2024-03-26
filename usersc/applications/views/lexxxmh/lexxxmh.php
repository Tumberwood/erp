<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'lexxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'lexlomd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbllexxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tablexlomd"> Location</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tablexlomd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbllexlomd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_lexxxmh</th>
										<th>Lokasi</th>
										<th>PIC</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/lexxxmh/fn/lexxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtlexxxmh, tbllexxxmh, show_deleted_lexxxmh = 0, id_lexxxmh;
	var edtlexlomd, tbllexlomd, show_deleted_lexlomd = 0, id_lexlomd;
	// ------------- end of default variable

	var id_gctxxmh_old = 0;

	// get tableRelation
	tableRelation('lexxxmh');

	$(document).ready(function() {
		
		// BEGIN lexxxmh
		edtlexxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lexxxmh/lexxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lexxxmh = show_deleted_lexxxmh;
				}
			},
			table: "#tbllexxxmh",
			fields: [ 
				{
					label: "lexxxmh.start_at",
					name: "lexxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "lexxxmh.finish_at",
					name: "lexxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "lexxxmh",
					type: "hidden"
				},	
				{
					label: "lexxxmh.transaction_state",
					name: "lexxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "lexxxmh.nama"
				},
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "lexxxmh.alamat",
					type: "textarea"
				},
				{
					label: "Kota",
					name: "lexxxmh.id_gctxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_old,
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
					name: "lexxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtlexxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlexxxmh.field('lexxxmh.start_at').val(start_at);

			if(action == 'create'){
				tbllexxxmh.rows().deselect();

				edtlexxxmh.field('lexxxmh.kode').enable();
				edtlexxxmh.field('lexxxmh.nama').enable();
			}else if(action == 'edit'){
					
				if(transaction_state == 0){
					edtlexxxmh.field('lexxxmh.kode').enable();
					edtlexxxmh.field('lexxxmh.nama').enable();
				}else{
					edtlexxxmh.field('lexxxmh.kode').disable();
					edtlexxxmh.field('lexxxmh.nama').disable();
				}
			}
		});

		edtlexxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtlexxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				nama = edtlexxxmh.field('lexxxmh.nama').val();
				alamat = edtlexxxmh.field('lexxxmh.alamat').val();

				validasiRequired(
					edtlexxxmh,
					'lexxxmh',
					{
						'nama': nama,
						'alamat': alamat
					}
				);

				validasiUnique(
					action,
					edtlexxxmh,
					'lexxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_lexxxmh
				);
			}
			
			if ( edtlexxxmh.inError() ) {
				return false;
			}
		});

		edtlexxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlexxxmh.field('lexxxmh.finish_at').val(finish_at);
		});
		
		edtlexxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtlexxxmh.on( 'close', function () {
			edtlexxxmh.enable();
		} );
		
		tbllexxxmh = $('#tbllexxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lexxxmh/lexxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lexxxmh = show_deleted_lexxxmh;
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
				{ data: "lexxxmh.id",visible:false },
				{ data: "lexxxmh.kode" },
				{ data: "lexxxmh.nama" },
				{ data: "lexxxmh.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_lexxxmh';
					$table       = 'tbllexxxmh';
					$edt         = 'edtlexxxmh';
					$show_status = '_lexxxmh';
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
				if ( data.lexxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.lexxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbllexxxmh.searchPanes.container().appendTo('#splexxxmh');
		tbllexxxmh.searchBuilder.container().appendTo( '#sblexxxmh' );
		
		tbllexxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbllexlomd];
			CekInitHeaderHD(tbllexxxmh, tbl_details);
		} );
		
		tbllexxxmh.on( 'select', function( e, dt, type, indexes ) {
			lexxxmh_data = tbllexxxmh.row( { selected: true } ).data().lexxxmh;
			id_lexxxmh   = lexxxmh_data.id;
			id_transaksi_h    = id_lexxxmh;                                                // dipakai untuk general
			id_transaksi_log  = id_lexxxmh;                                                // dipakai untuk general
			transaction_state = lexxxmh_data.transaction_state;
			approval_state    = lexxxmh_data.approval_state;
			is_nextprocess    = lexxxmh_data.is_nextprocess;

			id_gctxxmh_old    = lexxxmh_data.id_gctxxmh;
			
			// atur hak akses
			tbl_details = [tbllexlomd];
			CekSelectHeaderHD(tbllexxxmh, tbl_details);

		} );
		
		tbllexxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_lexxxmh = 0;

			id_gctxxmh_old = 0;

			// atur hak akses
			tbl_details = [tbllexlomd];
			CekDeselectHeaderHD(tbllexxxmh, tbl_details);
		} );
		// END lexxxmh

		// BEGIN lexlomd
		edtlexlomd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lexxxmh/lexlomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lexlomd = show_deleted_lexlomd;
					d.id_lexxxmh = id_lexxxmh;
				}
			},
			table: "#tbllexlomd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "lexlomd.start_at",
					name: "lexlomd.start_at",
					type: "hidden"
				},	
				{
					label: "lexlomd.finish_at",
					name: "lexlomd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "lexlomd",
					type: "hidden"
				},	
				{
					label: "lexlomd.transaction_state",
					name: "lexlomd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_lexxxmh",
					name: "lexlomd.id_lexxxmh",
					type: "hidden"
				},	
				{
					label: "Lokasi <sup class='text-danger'>*<sup>",
					name: "lexlomd.nama"
				},
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "lexlomd.alamat",
					type: "textarea"
				}, 	
				{
					label: "Kota",
					name: "lexlomd.id_gctxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_old,
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
					label: "Nama PIC <sup class='text-danger'>*<sup>",
					name: "lexlomd.pic_nama"
				},
				{
					label: "No Handphone PIC <sup class='text-danger'>*<sup>",
					name: "lexlomd.pic_handphone",
				},
				{
					label: "Keterangan",
					name: "lexlomd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtlexlomd.on( 'preOpen', function( e, mode, action ) {
			edtlexlomd.field('lexlomd.id_lexxxmh').val(id_lexxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlexlomd.field('lexlomd.start_at').val(start_at);
			
			if(action == 'create'){
				tbllexlomd.rows().deselect();
			}
		});

		edtlexlomd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtlexlomd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama          = edtlexlomd.field('lexlomd.nama').val();
				alamat        = edtlexlomd.field('lexlomd.alamat').val();
				id_gctxxmh    = edtlexlomd.field('lexlomd.id_gctxxmh').val();
				pic_nama      = edtlexlomd.field('lexlomd.pic_nama').val();
				pic_handphone = edtlexlomd.field('lexlomd.pic_handphone').val();

				validasiRequired(
					edtlexlomd,
					'lexlomd',
					{
						'nama': nama,
						'alamat': alamat,
						'id_gctxxmh': id_gctxxmh,
						'pic_nama': pic_nama,
						'pic_handphone': pic_handphone
					}
				);

				validasiUnique(
					action,
					edtlexlomd,
					'lexlomd',
					'nama',
					'nama',
					'"'+nama+'"',
					id_lexlomd
				);

			}
			
			if ( edtlexlomd.inError() ) {
				return false;
			}
		});

		edtlexlomd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlexlomd.field('lexlomd.finish_at').val(finish_at);
		});
			
		edtlexlomd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtlexlomd.on( 'close', function () {
			edtlexlomd.enable();
		} );
		
		tbllexlomd = $('#tbllexlomd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lexxxmh/lexlomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lexlomd = show_deleted_lexlomd;
					d.id_lexxxmh = id_lexxxmh;
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
				{ data: "lexlomd.id",visible:false },
				{ data: "lexlomd.id_lexxxmh",visible:false },
				{ data: "lexlomd.nama" },
				{ data: "lexlomd.pic_nama" },
				{ data: "lexlomd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_lexlomd';
					$table       = 'tbllexlomd';
					$edt         = 'edtlexlomd';
					$show_status = '_lexlomd';
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

		tbllexlomd.searchPanes.container().appendTo('#splexlomd');
		tbllexlomd.searchBuilder.container().appendTo( '#sblexlomd' );

		tbllexlomd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tbllexxxmh, tbllexlomd, 'lexlomd' );
			CekDrawDetailHDFinal(tbllexxxmh);
		} );

		tbllexlomd.on( 'select', function( e, dt, type, indexes ) {
			data_lexlomd = tbllexlomd.row( { selected: true } ).data().lexlomd;
			id_lexlomd   = data_lexlomd.id;
			id_transaksi_d    = id_lexlomd;                                                // dipakai untuk general
			id_transaksi_log  = id_lexlomd;                                                // dipakai untuk log

			transaction_state_d   = data_lexlomd.transaction_state;
			
			// atur hak akses
			CekSelectDetailHD(tbllexxxmh, tbllexlomd );
		} );

		tbllexlomd.on( 'deselect', function() {
			id_lexlomd = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tbllexxxmh, tbllexlomd );
		} );
		// END lexlomd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
