<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'htsptth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htststd';
    $nama_tabels_d[1] = 'htsemtd';
?>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtsptth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jumlah Grup</th>
                                <th>Tukar Jadwal</th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtststd"> Shift</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabhtsemtd"> Pegawai</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtststd" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtststd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_htsptth</th>
										<th>Urutan</th>
										<th>Shift</th>
										<th>Mulai Grup ke</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->
					</div>
				</div>

				<div role="tabpanel" id="tabhtsemtd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtsemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_htsptth</th>
										<th>Grup ke</th>
										<th>Nama</th>
										<th>Department</th>
										<th>Jabatan</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htsptth/fn/htsptth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthtsptth, tblhtsptth, show_deleted_htsptth = 0, id_htsptth;
	var edthtststd, tblhtststd, show_deleted_htststd = 0, id_htststd;
	var edthtsemtd, tblhtsemtd, show_deleted_htsemtd = 0, id_htsemtd;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('htsptth');

	var id_htsxxmh_old = 0;
	var id_hemxxmh_old = 0;
	var jumlah_grup;

	$(document).ready(function() {
		
		// BEGIN htsptth
		edthtsptth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htsptth/htsptth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsptth = show_deleted_htsptth;
				}
			},
			table: "#tblhtsptth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},	
				{
					label: "htsptth.start_at",
					name: "htsptth.start_at",
					type: "hidden"
				},	
				{
					label: "htsptth.finish_at",
					name: "htsptth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htsptth",
					type: "hidden"
				},	
				{
					label: "htsptth.transaction_state",
					name: "htsptth.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "htsptth.nama"
				}, 	{
					label: "Jumlah Grup <sup class='text-danger'>*<sup>",
					name: "htsptth.jumlah_grup"
				}, 	{
					label: "Keterangan",
					name: "htsptth.keterangan",
					type: "textarea"
				}, {
					label: "Tukar Jadwal",
					name: "htsptth.is_tukar",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
			]
		} );
		
		edthtsptth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsptth.field('htsptth.start_at').val(start_at);

			if(action == 'create'){
				tblhtsptth.rows().deselect();
			}
		});

		edthtsptth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthtsptth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi htsptth.nama 
				nama = edthtsptth.field('htsptth.nama').val();
				if(!nama || nama == ''){
					edthtsptth.field('htsptth.nama').error( 'Wajib diisi!' );
				}
				
				// BEGIN of cek unik htsptth.nama 
				if(action == 'create'){
					id_htsptth = 0;
				}
				
				$.ajax( {
					url: '../../../helpers/validate_fn_unique.php',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						table_name       : 'htsptth',
						nama_field       : 'nama',
						nama_field_value : '"' + nama + '"',
						id_transaksi     : id_htsptth
					},
					success: function ( json ) {
						if(json.data.count == 1){
							edthtsptth.field('htsptth.nama').error( 'Data tidak boleh kembar!' );
						}
					}
				} );
				
				// END of cek unik htsptth.nama 
				// END of validasi htsptth.nama 
				
				// BEGIN of validasi htsptth.jumlah_grup 
				jumlah_grup = edthtsptth.field('htsptth.jumlah_grup').val();
				if(!jumlah_grup || jumlah_grup == ''){
					edthtsptth.field('htsptth.jumlah_grup').error( 'Wajib diisi!' );
				}
				if(jumlah_grup <= 0 ){
					edthtsptth.field('htsptth.jumlah_grup').error( 'Inputan harus > 0' );
				}
				if(isNaN(jumlah_grup) ){
					edthtsptth.field('htsptth.jumlah_grup').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htsptth.jumlah_grup 
			}
			
			if ( edthtsptth.inError() ) {
				return false;
			}
		});

		edthtsptth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsptth.field('htsptth.finish_at').val(finish_at);
		});
		
		edthtsptth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtsptth.on( 'close', function () {
			edthtsptth.enable();
		} );
		
		tblhtsptth = $('#tblhtsptth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htsptth/htsptth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsptth = show_deleted_htsptth;
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
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "htsptth.id",visible:false },
				{ data: "htsptth.nama" },
				{ 
					data: "htsptth.jumlah_grup" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "htsptth.is_tukar",
					render: function (data){
						if (data == 0){
							return 'Tidak';
						}else if(data == 1){
							return 'Ya';
						}
					} 
				},
				{ 
					data: "htsptth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htsptth';
					$table       = 'tblhtsptth';
					$edt         = 'edthtsptth';
					$show_status = '_htsptth';
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
				if ( data.htsptth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htsptth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtsptth.searchPanes.container().appendTo('#sphtsptth');
		tblhtsptth.searchBuilder.container().appendTo( '#sbhtsptth' );
		
		tblhtsptth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtststd, tblhtsemtd];
			CekInitHeaderHD(tblhtsptth, tbl_details);
		} );
		
		tblhtsptth.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('htsptth');			
			jumlah_grup = htsptth_data.jumlah_grup;
			
			// atur hak akses
			tbl_details = [tblhtststd, tblhtsemtd];
			CekSelectHeaderHD(tblhtsptth, tbl_details);

			if (transaction_state == 1) {
				tblhtststd.button('btnCreate:name')
				.nodes()
				.css( 'display', 'none' );
			} else {
				tblhtststd.button('btnCreate:name')
				.nodes()
				.css( 'display', 'block' );

			}
		} );
		
		tblhtsptth.on( 'deselect', function () {
			siVarReset('htsptth');
			id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0
			// atur hak akses
			tbl_details = [tblhtststd, tblhtsemtd];
			CekDeselectHeaderHD(tblhtsptth, tbl_details);
		} );
		
		// END htsptth

		// BEGIN htststd
		edthtststd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htsptth/htststd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htststd = show_deleted_htststd;
					d.id_htsptth = id_htsptth;
				}
			},
			table: "#tblhtststd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htststd.start_at",
					name: "htststd.start_at",
					type: "hidden"
				},	
				{
					label: "htststd.finish_at",
					name: "htststd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htststd",
					type: "hidden"
				},	
				{
					label: "htststd.transaction_state",
					name: "htststd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_htsptth",
					name: "htststd.id_htsptth",
					type: "hidden"
				},	
				{
					label: "Urutan <sup class='text-danger'>*<sup>",
					name: "htststd.urutan"
				}, 	{
					label: "Shift <sup class='text-danger'>*<sup>",
					name: "htststd.id_htsxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/htsxxmh/htsxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_htsxxmh_old: id_htsxxmh_old,
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
				}, 	{
					label: "Mulai Grup ke <sup class='text-danger'>*<sup>",
					name: "htststd.mulai_grup",
					def: 0
				}, 	{
					label: "Keterangan",
					name: "htststd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtststd.on( 'preOpen', function( e, mode, action ) {
			edthtststd.field('htststd.id_htsptth').val(id_htsptth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtststd.field('htststd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtststd.rows().deselect();
			}
		});

		edthtststd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtststd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				// BEGIN of validasi htststd.urutan 
				urutan = edthtststd.field('htststd.urutan').val();
				if(!urutan || urutan == ''){
					edthtststd.field('htststd.urutan').error( 'Wajib diisi!' );
				}
				if(urutan <= 0 ){
					edthtststd.field('htststd.urutan').error( 'Inputan harus > 0' );
				}
				if(isNaN(urutan) ){
					edthtststd.field('htststd.urutan').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htststd.urutan 

				// BEGIN of validasi htststd.id_htsxxmh 
				id_htsxxmh = edthtststd.field('htststd.id_htsxxmh').val();
				if(!id_htsxxmh || id_htsxxmh == ''){
					edthtststd.field('htststd.id_htsxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi htststd.id_htsxxmh 

				// BEGIN of validasi htststd.mulai_grup 
				mulai_grup = edthtststd.field('htststd.mulai_grup').val();
				if(!mulai_grup || mulai_grup == ''){
					edthtststd.field('htststd.mulai_grup').error( 'Wajib diisi!' );
				}
				if(mulai_grup < 0 ){
					edthtststd.field('htststd.mulai_grup').error( 'Inputan Minimal 0!' );
				}
				if(isNaN(mulai_grup) ){
					edthtststd.field('htststd.mulai_grup').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htststd.mulai_grup 
			}
			
			if ( edthtststd.inError() ) {
				return false;
			}
		});

		edthtststd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtststd.field('htststd.finish_at').val(finish_at);
		});
			
		edthtststd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtststd.on( 'close', function () {
			edthtststd.enable();
		} );
		
		//start datatables
		tblhtststd = $('#tblhtststd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htsptth/htststd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htststd = show_deleted_htststd;
					d.id_htsptth = id_htsptth;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1]
				}
			],
			order: [[ 2, "asc" ]],
			columns: [
				{ data: "htststd.id",visible:false },
				{ data: "htststd.id_htsptth",visible:false },
				{ 
					data: "htststd.urutan" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "htsxxmh.kode" },
				{ 
					data: "htststd.mulai_grup" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "htststd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htststd';
					$table       = 'tblhtststd';
					$edt         = 'edthtststd';
					$show_status = '_htststd';
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

		tblhtststd.searchPanes.container().appendTo('#sphtststd');
		tblhtststd.searchBuilder.container().appendTo( '#sbhtststd' );

		tblhtststd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtststd, 1 );
			CekDrawDetailHDFinal(tblhtsptth);
		} );

		tblhtststd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htststd');			
			id_htsxxmh_old = htststd_data.id_htsxxmh;

			CekSelectDetailHD( tblhtststd );
			if (transaction_state == 1) {
				tblhtststd.button('btnEdit:name')
				.nodes()
				.css( 'display', 'none' );

				tblhtststd.button('btnRemove:name')
				.nodes()
				.css( 'display', 'none' );				
			} else {
				tblhtststd.button('btnEdit:name')
				.nodes()
				.css( 'display', 'block' );

				tblhtststd.button('btnRemove:name')
				.nodes()
				.css( 'display', 'block' );				
			}
		} );

		tblhtststd.on( 'deselect', function() {
			siVarResetD('htststd');
			id_htsxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtststd );
			tblhtststd.button('btnEdit:name')
			.nodes()
			.css( 'display', 'none' );

			tblhtststd.button('btnRemove:name')
			.nodes()
			.css( 'display', 'none' );
			
			tblhtststd.button('btnCreate:name')
			.nodes()
			.css( 'display', 'none' );
		} );

		// END htststd
		
		// BEGIN htsemtd
		edthtsemtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htsptth/htsemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsemtd = show_deleted_htsemtd;
					d.id_htsptth = id_htsptth;
				}
			},
			table: "#tblhtsemtd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "htsemtd.start_at",
					name: "htsemtd.start_at",
					type: "hidden"
				},	
				{
					label: "htsemtd.finish_at",
					name: "htsemtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htsemtd",
					type: "hidden"
				},	
				{
					label: "htsemtd.transaction_state",
					name: "htsemtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_htsptth",
					name: "htsemtd.id_htsptth",
					type: "hidden"
				},	
				{
					label: "Grup ke <sup class='text-danger'>*<sup>",
					name: "htsemtd.grup_ke"
				}, 	{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "htsemtd.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
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
				},	{
					label: "Keterangan",
					name: "htsemtd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtsemtd.on( 'preOpen', function( e, mode, action ) {
			edthtsemtd.field('htsemtd.id_htsptth').val(id_htsptth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsemtd.field('htsemtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtsemtd.rows().deselect();
			}
		});

		edthtsemtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtsemtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				// BEGIN of validasi htsemtd.grup_ke 
				grup_ke = edthtsemtd.field('htsemtd.grup_ke').val();
				if(!grup_ke || grup_ke == ''){
					edthtsemtd.field('htsemtd.grup_ke').error( 'Wajib diisi!' );
				}
				if(grup_ke <= 0 ){
					edthtsemtd.field('htsemtd.grup_ke').error( 'Inputan harus > 0' );
				}
				if(isNaN(grup_ke) ){
					edthtsemtd.field('htsemtd.grup_ke').error( 'Inputan harus berupa Angka!' );
				}
				if(grup_ke > jumlah_grup){
					edthtsemtd.field('htsemtd.grup_ke').error( 'Maksimal Jumlah Grup adalah ' + jumlah_grup);
				}
				// END of validasi htsemtd.grup_ke 

				// BEGIN of validasi htsemtd.id_hemxxmh 
				id_hemxxmh = edthtsemtd.field('htsemtd.id_hemxxmh').val();
				if(!id_hemxxmh || id_hemxxmh == ''){
					edthtsemtd.field('htsemtd.id_hemxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi htsemtd.id_hemxxmh 
			}
			
			if ( edthtsemtd.inError() ) {
				return false;
			}
		});

		edthtsemtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsemtd.field('htsemtd.finish_at').val(finish_at);
		});
			
		edthtsemtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtsemtd.on( 'close', function () {
			edthtsemtd.enable();
		} );
		
		tblhtsemtd = $('#tblhtsemtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htsptth/htsemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsemtd = show_deleted_htsemtd;
					d.id_htsptth = id_htsptth;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1]
				}
			],
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "htsemtd.id",visible:false },
				{ data: "htsemtd.id_htsptth",visible:false },
				{ data: "htsemtd.grup_ke" },
				{ data: "hemxxmh_data" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ data: "htsemtd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htsemtd';
					$table       = 'tblhtsemtd';
					$edt         = 'edthtsemtd';
					$show_status = '_htsemtd';
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

		tblhtsemtd.searchPanes.container().appendTo('#sphtsemtd');
		tblhtsemtd.searchBuilder.container().appendTo( '#sbhtsemtd' );

		tblhtsemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtsemtd, 1 );
			CekDrawDetailHDFinal(tblhtsptth);

		} );

		tblhtsemtd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htsemtd');			
			id_hemxxmh_old = htsemtd_data.id_hemxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtsemtd );
		} );

		tblhtsemtd.on( 'deselect', function() {
			siVarResetD('htsemtd');
			id_hemxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtsemtd );
		} );

		// END htsemtd

		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
