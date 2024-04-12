<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'grlxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'grllomd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgrlxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabgrllomd"> Location</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabgrllomd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgrllomd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_grlxxmh</th>
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
	var edtgrlxxmh, tblgrlxxmh, show_deleted_grlxxmh = 0, id_grlxxmh;
	var edtgrllomd, tblgrllomd, show_deleted_grllomd = 0, id_grllomd;
	// ------------- end of default variable

	var kategori_dokumen = 'is_expedition', kategori_dokumen_value = 1;

	var id_gctxxmh_old = 0;

	// get tableRelation
	tableRelation('grlxxmh');

	$(document).ready(function() {
		
		// BEGIN grlxxmh
		edtgrlxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lexxxmh/lexxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlxxmh = show_deleted_grlxxmh;
				}
			},
			table: "#tblgrlxxmh",
			fields: [ 
				{
					label: "grlxxmh.start_at",
					name: "grlxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "grlxxmh.finish_at",
					name: "grlxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "grlxxmh",
					type: "hidden"
				},	
				{
					label: "grlxxmh.transaction_state",
					name: "grlxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "grlxxmh.nama"
				},
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "grlxxmh.alamat",
					type: "textarea"
				},
				{
					label: "Kota",
					name: "grlxxmh.id_gctxxmh",
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
					name: "grlxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtgrlxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlxxmh.field('grlxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblgrlxxmh.rows().deselect();

				edtgrlxxmh.field('grlxxmh.nama').enable();
			}else if(action == 'edit'){
					
				if(transaction_state == 0){
					edtgrlxxmh.field('grlxxmh.nama').enable();
				}else{
					edtgrlxxmh.field('grlxxmh.nama').disable();
				}
			}
		});

		edtgrlxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtgrlxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				nama = edtgrlxxmh.field('grlxxmh.nama').val();
				alamat = edtgrlxxmh.field('grlxxmh.alamat').val();

				validasiRequired(
					edtgrlxxmh,
					'grlxxmh',
					{
						'nama': nama,
						'alamat': alamat
					}
				);

				validasiUnique(
					action,
					edtgrlxxmh,
					'grlxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_grlxxmh
				);
			}
			
			if ( edtgrlxxmh.inError() ) {
				return false;
			}
		});

		edtgrlxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrlxxmh.field('grlxxmh.finish_at').val(finish_at);
		});
		
		edtgrlxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgrlxxmh.on( 'close', function () {
			edtgrlxxmh.enable();
		} );
		
		tblgrlxxmh = $('#tblgrlxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lexxxmh/lexxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grlxxmh = show_deleted_grlxxmh;
				}
			},
			order: [[ 1, "asc" ]],
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
				{ data: "grlxxmh.id",visible:false },
				{ data: "grlxxmh.kode" },
				{ data: "grlxxmh.nama" },
				{ data: "grlxxmh.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_grlxxmh';
					$table       = 'tblgrlxxmh';
					$edt         = 'edtgrlxxmh';
					$show_status = '_grlxxmh';
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
				if ( data.grlxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.grlxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblgrlxxmh.searchPanes.container().appendTo('#spgrlxxmh');
		tblgrlxxmh.searchBuilder.container().appendTo( '#sbgrlxxmh' );
		
		tblgrlxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblgrllomd];
			CekInitHeaderHD(tblgrlxxmh, tbl_details);
		} );
		
		tblgrlxxmh.on( 'select', function( e, dt, type, indexes ) {
			grlxxmh_data = tblgrlxxmh.row( { selected: true } ).data().grlxxmh;
			id_grlxxmh   = grlxxmh_data.id;
			id_transaksi_h    = id_grlxxmh;                                                // dipakai untuk general
			id_transaksi_log  = id_grlxxmh;                                                // dipakai untuk general
			transaction_state = grlxxmh_data.transaction_state;
			approval_state    = grlxxmh_data.approval_state;
			is_nextprocess    = grlxxmh_data.is_nextprocess;

			id_gctxxmh_old    = grlxxmh_data.id_gctxxmh;
			
			// atur hak akses
			tbl_details = [tblgrllomd];
			CekSelectHeaderHD(tblgrlxxmh, tbl_details);

		} );
		
		tblgrlxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_grlxxmh = 0;

			id_gctxxmh_old = 0;

			// atur hak akses
			tbl_details = [tblgrllomd];
			CekDeselectHeaderHD(tblgrlxxmh, tbl_details);
		} );
		// END grlxxmh

		// BEGIN grllomd
		edtgrllomd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lexxxmh/lexlomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grllomd = show_deleted_grllomd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			table: "#tblgrllomd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "grllomd.start_at",
					name: "grllomd.start_at",
					type: "hidden"
				},	
				{
					label: "grllomd.finish_at",
					name: "grllomd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "grllomd",
					type: "hidden"
				},	
				{
					label: "grllomd.transaction_state",
					name: "grllomd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_grlxxmh",
					name: "grllomd.id_grlxxmh",
					type: "hidden"
				},	
				{
					label: "Lokasi <sup class='text-danger'>*<sup>",
					name: "grllomd.nama"
				},
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "grllomd.alamat",
					type: "textarea"
				}, 	
				{
					label: "Kota",
					name: "grllomd.id_gctxxmh",
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
					name: "grllomd.pic_nama"
				},
				{
					label: "No Handphone PIC <sup class='text-danger'>*<sup>",
					name: "grllomd.pic_handphone",
				},
				{
					label: "Keterangan",
					name: "grllomd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtgrllomd.on( 'preOpen', function( e, mode, action ) {
			edtgrllomd.field('grllomd.id_grlxxmh').val(id_grlxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrllomd.field('grllomd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgrllomd.rows().deselect();
			}
		});

		edtgrllomd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edtgrllomd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama          = edtgrllomd.field('grllomd.nama').val();
				alamat        = edtgrllomd.field('grllomd.alamat').val();
				id_gctxxmh    = edtgrllomd.field('grllomd.id_gctxxmh').val();
				pic_nama      = edtgrllomd.field('grllomd.pic_nama').val();
				pic_handphone = edtgrllomd.field('grllomd.pic_handphone').val();

				validasiRequired(
					edtgrllomd,
					'grllomd',
					{
						'nama': nama,
						'alamat': alamat,
						'id_gctxxmh': id_gctxxmh,
						'pic_nama': pic_nama,
						'pic_handphone': pic_handphone
					}
				);

			}
			
			if ( edtgrllomd.inError() ) {
				return false;
			}
		});

		edtgrllomd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgrllomd.field('grllomd.finish_at').val(finish_at);
		});
			
		edtgrllomd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblgrllomd.rows().deselect();
			tblgrllomd.ajax.reload(null, false);
		} );

		edtgrllomd.on( 'close', function () {
			edtgrllomd.enable();
		} );
		
		tblgrllomd = $('#tblgrllomd').DataTable( {
			ajax: {
				url: "../../models/lexxxmh/lexlomd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_grllomd = show_deleted_grllomd;
					d.id_grlxxmh = id_grlxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "grllomd.id",visible:false },
				{ data: "grllomd.id_grlxxmh",visible:false },
				{ data: "grllomd.nama" },
				{ data: "grllomd.pic_nama" },
				{ data: "grllomd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_grllomd';
					$table       = 'tblgrllomd';
					$edt         = 'edtgrllomd';
					$show_status = '_grllomd';
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

		tblgrllomd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblgrlxxmh, tblgrllomd, 'grllomd' );
			CekDrawDetailHDFinal(tblgrlxxmh);
		} );

		tblgrllomd.on( 'select', function( e, dt, type, indexes ) {
			data_grllomd = tblgrllomd.row( { selected: true } ).data().grllomd;
			id_grllomd   = data_grllomd.id;
			id_transaksi_d    = id_grllomd;                                                // dipakai untuk general
			id_transaksi_log  = id_grllomd;                                                // dipakai untuk log

			transaction_state_d   = data_grllomd.transaction_state;
			
			// atur hak akses
			CekSelectDetailHD(tblgrlxxmh, tblgrllomd );
		} );

		tblgrllomd.on( 'deselect', function() {
			id_grllomd = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblgrlxxmh, tblgrllomd );
		} );
		// END grllomd

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
