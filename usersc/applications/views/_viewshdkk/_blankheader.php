<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = '_blankheader';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = '_blankdetail';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbl_blankheader" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tab_blankdetail_1"> Tab 1</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tab_blankdetail_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tab_blankdetail_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id__blankheader</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tab_blankdetail_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbl_blankdetail_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id__blankheader</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/_blankheader/fn/_blankheader_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edt_blankheader, tbl_blankheader, show_deleted__blankheader = 0, id__blankheader;
	var edt_blankdetail, tbl_blankdetail, show_deleted__blankdetail = 0, id__blankdetail;
	// ------------- end of default variable

	$(document).ready(function() {
		//start datatables editor
		edt_blankheader = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blankheader/_blankheader.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankheader = show_deleted__blankheader;
				}
			},
			table: "#tbl_blankheader",
			fields: [ 
				{
					label: "_blankheader.start_at",
					name: "_blankheader.start_at",
					type: "hidden"
				},	
				{
					label: "_blankheader.finish_at",
					name: "_blankheader.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankheader",
					type: "hidden"
				},	
				{
					label: "_blankheader.transaction_state",
					name: "_blankheader.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "_blankheader.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "_blankheader.nama"
				}, 	
				{
					label: "Keterangan",
					name: "_blankheader.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edt_blankheader.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankheader.field('_blankheader.start_at').val(start_at);

			if(action == 'create'){
				tbl_blankheader.rows().deselect();
			}
		});

		edt_blankheader.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edt_blankheader.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blank.field('_blank.kode').val();
				nama = edt_blank.field('_blank.nama').val();

				validasiRequired(
					edt_blank,
					'_blank',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edt_blank,
					'_blank',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blank
				);

				validasiUnique(
					action,
					edt_blank,
					'_blank',
					'nama',
					'nama',
					'"'+nama+'"',
					id__blank
				);
			}
			
			if ( edt_blankheader.inError() ) {
				return false;
			}
		});

		edt_blankheader.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankheader.field('_blankheader.finish_at').val(finish_at);
		});
		
		edt_blankheader.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankheader.on( 'close', function () {
			edt_blankheader.enable();
		} );
		
		//start datatables
		tbl_blankheader = $('#tbl_blankheader').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/_blankheader/_blankheader.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankheader = show_deleted__blankheader;
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
				{ data: "_blankheader.id",visible:false },
				{ data: "_blankheader.kode" },
				{ data: "_blankheader.nama" },
				{ data: "_blankheader.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__blankheader';
					$table       = 'tbl_blankheader';
					$edt         = 'edt_blankheader';
					$show_status = '__blankheader';
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
				if ( data._blankheader.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data._blankheader.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbl_blankheader.searchPanes.container().appendTo('#sp_blankheader');
			tbl_blankheader.searchBuilder.container().appendTo( '#sb_blankheader' );
		
		tbl_blankheader.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekInitHeaderHD(tbl_blankheader, tbl_details);
		} );
		
		tbl_blankheader.on( 'select', function( e, dt, type, indexes ) {
			_blankheader_data    		= tbl_blankheader.row( { selected: true } ).data()._blankheader;
			id__blankheader      		= _blankheader_data.id;
			id_transaksi_h 		= id__blankheader; // dipakai untuk general
			id_transaksi_log	= id__blankheader; // dipakai untuk general
			transaction_state   = _blankheader_data.transaction_state;
			approval_state   	= _blankheader_data.approval_state;
			is_nextprocess 		= _blankheader_data.is_nextprocess;
			is_jurnal      		= _blankheader_data.is_jurnal;
			
			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekSelectHeaderHD(tbl_blankheader, tbl_details);

		} );
		
		tbl_blankheader.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id__blankheader = 0;

			// atur hak akses
			tbl_details = [tbl_blankdetail];
			CekDeselectHeaderHD(tbl_blankheader, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edt_blankdetail = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blankheader/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id__blankheader = id__blankheader;
				}
			},
			table: "#tbl_blankdetail",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "_blankdetail.start_at",
					name: "_blankdetail.start_at",
					type: "hidden"
				},	
				{
					label: "_blankdetail.finish_at",
					name: "_blankdetail.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blankdetail",
					type: "hidden"
				},	
				{
					label: "_blankdetail.transaction_state",
					name: "_blankdetail.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id__blankheader",
					name: "_blankdetail.id__blankheader",
					type: "hidden"
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "_blankdetail.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "_blankdetail.nama"
				}, 	
				{
					label: "Keterangan",
					name: "_blankdetail.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edt_blankdetail.on( 'preOpen', function( e, mode, action ) {
			edt_blankdetail.field('_blankdetail.id__blankheader').val(id__blankheader);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.start_at').val(start_at);
			
			if(action == 'create'){
				tbl_blankdetail.rows().deselect();
			}
		});

		edt_blankdetail.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});
		
		edt_blankdetail.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blank.field('_blank.kode').val();

				validasiRequired(
					edt_blank,
					'_blank',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edt_blank,
					'_blank',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blank
				);

			}
			
			if ( edt_blankdetail.inError() ) {
				return false;
			}
		});

		edt_blankdetail.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blankdetail.field('_blankdetail.finish_at').val(finish_at);
		});
			
		edt_blankdetail.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edt_blankdetail.on( 'close', function () {
			edt_blankdetail.enable();
		} );
		
		//start datatables
		tbl_blankdetail = $('#tbl_blankdetail').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/_blankheader/_blankdetail.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blankdetail = show_deleted__blankdetail;
					d.id__blankheader = id__blankheader;
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
				{ data: "_blankdetail.id",visible:false },
				{ data: "_blankdetail.id__blankheader",visible:false },
				{ data: "_blankdetail.kode" },
				{ data: "_blankdetail.nama" },
				{ data: "_blankdetail.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__blankdetail';
					$table       = 'tbl_blankdetail';
					$edt         = 'edt_blankdetail';
					$show_status = '__blankdetail';
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

		tbl_blankdetail.searchPanes.container().appendTo('#sp_blankdetail');
		tbl_blankdetail.searchBuilder.container().appendTo( '#sb_blankdetail' );

		tbl_blankdetail.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tbl_blankheader, tbl_blankdetail, '_blankdetail' );
			CekDrawDetailHDFinal(tbl_blankheader);
		} );

		tbl_blankdetail.on( 'select', function( e, dt, type, indexes ) {
			data__blankdetail 		= tbl_blankdetail.row( { selected: true } ).data()._blankdetail;
			id__blankdetail   		= data__blankdetail.id;
			id_transaksi_d 		= id__blankdetail; // dipakai untuk general
			id_transaksi_log 	= id__blankdetail; // dipakai untuk log

			transaction_state_d   = data__blankdetail.transaction_state;
			
			// atur hak akses
			CekSelectDetailHD(tbl_blankheader, tbl_blankdetail );
		} );

		tbl_blankdetail.on( 'deselect', function() {
			id__blankdetail = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tbl_blankheader, tbl_blankdetail );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
