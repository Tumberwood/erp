<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'gfrxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'gfrfltd';
    $nama_tabels_d[1] = 'gfroptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgfrxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Menu</th>
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
				<li id="detail"><a class="nav-link active" data-toggle="tab" href="#tabgfrfltd_1"> Question</a></li>
				<li id="select_opt" style="display: none"><a class="nav-link" data-toggle="tab" href="#tabgfroptd"> Select Options</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabgfrfltd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgfrfltd" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_gfrxxth</th>
										<th>Label</th>
										<th>Type</th>
										<th>Type Data</th>
										<th>Urutan</th>
										<th>Required</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabgfroptd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblgfroptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_gfrfltd</th>
										<th>Options</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gfrxxth/fn/gfrxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtgfrxxth, tblgfrxxth, show_deleted_gfrxxth = 0, id_gfrxxth;
	var edtgfrfltd, tblgfrfltd, show_deleted_gfrfltd = 0, id_gfrfltd;
	var edtgfroptd, tblgfroptd, show_deleted_gfroptd = 0, id_gfroptd;
	// ------------- end of default variable
	var type_form = '';

	// get tableRelation
	tableRelation('gfrxxth');

	$(document).ready(function() {

		// BEGIN gfrxxth
		edtgfrxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gfrxxth/gfrxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gfrxxth = show_deleted_gfrxxth;
				}
			},
			table: "#tblgfrxxth",
			fields: [ 
				{
					label: "gfrxxth.start_at",
					name: "gfrxxth.start_at",
					type: "hidden"
				},	
				{
					label: "gfrxxth.finish_at",
					name: "gfrxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gfrxxth",
					type: "hidden"
				},	
				{
					label: "gfrxxth.transaction_state",
					name: "gfrxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Nama Tabel <sup class='text-danger'>*<sup>",
					name: "gfrxxth.nama_tabel",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Candidate", "value": "hcdxxmh" },
						{ "label": "Interview Candidate", "value": "hrcivtd" },
					]
				}, 	
				{
					label: "Keterangan",
					name: "gfrxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtgfrxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgfrxxth.field('gfrxxth.start_at').val(start_at);

			if(action == 'create'){
				tblgfrxxth.rows().deselect();
			}
		});

		edtgfrxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edtgfrxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama_tabel = edtgfrxxth.field('gfrxxth.nama_tabel').val();

				validasiRequired(
					edtgfrxxth,
					'gfrxxth',
					{
						'nama_tabel': nama_tabel,
					}
				);

				validasiUnique(
					action,
					edtgfrxxth,
					'gfrxxth',
					'nama_tabel',
					'nama_tabel',
					'"'+nama_tabel+'"',
					id_gfrxxth
				);
			}
			
			if ( edtgfrxxth.inError() ) {
				return false;
			}
		});

		edtgfrxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgfrxxth.field('gfrxxth.finish_at').val(finish_at);
		});
		
		edtgfrxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgfrxxth.on( 'close', function () {
			edtgfrxxth.enable();
		} );
		
		tblgfrxxth = $('#tblgfrxxth').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/gfrxxth/gfrxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gfrxxth = show_deleted_gfrxxth;
				}
			},
			order: [[ 1, "desc" ]],
			columns: [
				{ data: "gfrxxth.id",visible:false },
				{ 
					data: "gfrxxth.nama_tabel",
					render: function (data){	
						if (data == 'hcdxxmh'){
							return 'Candidate';
						}else if (data == 'hrcivtd'){
							return 'Interview Candidate';
						}else{
							return '';
						}
					}
				},
				{ data: "gfrxxth.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gfrxxth';
					$table       = 'tblgfrxxth';
					$edt         = 'edtgfrxxth';
					$show_status = '_gfrxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			rowCallback: function( row, data, index ) {
				if ( data.gfrxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.gfrxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );
		
		tblgfrxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblgfrfltd];
			CekInitHeaderHD(tblgfrxxth, tbl_details);
			tblgfroptd.button('btnCreate:name')
			.nodes()
            .css( 'display', 'none' );
		} );
		
		tblgfrxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('gfrxxth');
			id_gfrxxth   = gfrxxth_data.id;
			
			// atur hak akses
			tbl_details = [tblgfrfltd];
			CekSelectHeaderHD(tblgfrxxth, tbl_details);
			tblgfroptd.button('btnCreate:name')
			.nodes()
            .css( 'display', 'none' );
		} );
		
		tblgfrxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('gfrxxth');
			id_gfrfltd   = 0;
			tblgfrfltd.rows().deselect();
			tblgfrfltd.ajax.reload(null, false);

			// atur hak akses
			tbl_details = [tblgfrfltd];
			CekDeselectHeaderHD(tblgfrxxth, tbl_details);
			$('#select_opt').hide();
			$('#detail a').tab('show');
		} );
		// END gfrxxth

		// BEGIN gfrfltd
		edtgfrfltd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gfrxxth/gfrfltd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gfrfltd = show_deleted_gfrfltd;
					d.id_gfrxxth = id_gfrxxth;
				}
			},
			table: "#tblgfrfltd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "gfrfltd.start_at",
					name: "gfrfltd.start_at",
					type: "hidden"
				},	
				{
					label: "gfrfltd.finish_at",
					name: "gfrfltd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gfrfltd",
					type: "hidden"
				},	
				{
					label: "gfrfltd.transaction_state",
					name: "gfrfltd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_gfrxxth",
					name: "gfrfltd.id_gfrxxth",
					type: "hidden"
				},	
				{
					label: "Label <sup class='text-danger'>*<sup>",
					name: "gfrfltd.label",
					type: "textarea"
				},	
				{
					label: "Type <sup class='text-danger'>*<sup>",
					name: "gfrfltd.type",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Input", "value": "text" },
						{ "label": "Textarea", "value": "textarea" },
						{ "label": "Editor", "value": "quill" },
						{ "label": "Select", "value": "select" },
						{ "label": "Datepicker", "value": "datetime" },
					]
				},
				{
					label: "Tipe Data <sup class='text-danger'>*<sup>",
					name: "gfrfltd.type_data",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Sort Text", "value": "VARCHAR(200)" },
						{ "label": "Long Text", "value": "VARCHAR(1000)" },
						{ "label": "Decimal", "value": "DECIMAL(12,2)" },
						{ "label": "Integer", "value": "INT(11)" },
						{ "label": "DATE", "value": "DATE" },
						{ "label": "TIME", "value": "TIME" },
						{ "label": "DATETIME", "value": "DATETIME" },
					]
				},
				{
					label: "Urutan <sup class='text-danger'>*<sup>",
					name: "gfrfltd.urutan",
				}, 	
				{
					label: "Required <sup class='text-danger'>*<sup>",
					name: "gfrfltd.is_required",
					type: "select",
					def: 1,
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					],
					fieldInfo: "Yes = Inputan Wajib Diisi | No = Tidak Wajib"
				}, 	
				{
					label: "Input Number",
					name: "gfrfltd.is_number",
					type: "select",
					def: 0,
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					],
					fieldInfo: "Yes = Inputan Wajib Angka dan Inputan > 0 | No = Tidak ada Validasi Angka"
				},
			]
		} );
			
		edtgfrfltd.field('gfrfltd.is_number').hide();
		
		edtgfrfltd.on( 'preOpen', function( e, mode, action ) {
			edtgfrfltd.field('gfrfltd.id_gfrxxth').val(id_gfrxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgfrfltd.field('gfrfltd.start_at').val(start_at);
			
			getUrutan();
			
			if(action == 'create'){
				tblgfrfltd.rows().deselect();
			}
		});

		edtgfrfltd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtgfrfltd.dependent('gfrfltd.type', function (val, data, callback) {
			var field = edtgfrfltd.field('gfrfltd.type_data'); 
			var options = []; 

			if (val === 'datetime') {
				edtgfrfltd.field('gfrfltd.is_number').hide();

				options.push({ "label": "DATE", "value": "DATE" });
				options.push({ "label": "TIME", "value": "TIME" });
				options.push({ "label": "DATETIME", "value": "DATETIME" });
			} else {
				if (val == 'select') {
					edtgfrfltd.field('gfrfltd.type').fieldInfo('Jika memilih select, maka bisa isi detail options');
				} else {
					edtgfrfltd.field('gfrfltd.type').fieldInfo('');
				}
				options.push({ "label": "Sort Text", "value": "VARCHAR(200)" });
				options.push({ "label": "Long Text", "value": "VARCHAR(1000)" });
				options.push({ "label": "Decimal", "value": "DECIMAL(12,2)"  });
				options.push({ "label": "Integer", "value": "INT(11)"  });
			}
			field.update(options);

			return {};
		}, { event: 'keyup change' });


		edtgfrfltd.dependent( 'gfrfltd.type_data', function ( val, data, callback ) {
			if (val == 'VARCHAR(200)') {
				edtgfrfltd.field('gfrfltd.is_number').show();
				edtgfrfltd.field('gfrfltd.is_number').val(0);
				edtgfrfltd.field('gfrfltd.type_data').fieldInfo('Max Char untuk Short Text: 200');
			} else if (val == 'VARCHAR(1000)') {
				edtgfrfltd.field('gfrfltd.is_number').show();
				edtgfrfltd.field('gfrfltd.is_number').val(0);
				edtgfrfltd.field('gfrfltd.type_data').fieldInfo('Max Char untuk Long Text: 1000');
			} else if (val == 'DECIMAL(12,2)') {
				edtgfrfltd.field('gfrfltd.is_number').hide();
				edtgfrfltd.field('gfrfltd.is_number').val(1);
				edtgfrfltd.field('gfrfltd.type_data').fieldInfo('Max Char untuk Decimal: 12 Digit dengan 2 koma');
			} else if (val == 'INT(11)') {
				edtgfrfltd.field('gfrfltd.is_number').hide();
				edtgfrfltd.field('gfrfltd.is_number').val(1);
				edtgfrfltd.field('gfrfltd.type_data').fieldInfo('Max Char untuk Integer: 11 Digit');
			} else {
				edtgfrfltd.field('gfrfltd.type_data').fieldInfo('');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtgfrfltd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				type = edtgfrfltd.field('gfrfltd.type').val();
				keterangan = edtgfrfltd.field('gfrfltd.label').val();
				urutan = edtgfrfltd.field('gfrfltd.urutan').val();
				type_data = edtgfrfltd.field('gfrfltd.type_data').val();

				validasiRequired(
					edtgfrfltd,
					'gfrfltd',
					{
						'type': type,
						'keterangan': keterangan,
						'urutan': urutan,
						'type_data': type_data,
					}
				);

				validasiUnique(
					action,
					edtgfrfltd,
					'gfrfltd',
					'keterangan',
					'keterangan',
					'"'+keterangan+'"',
					id_gfrfltd
				);		

				validasiUnique(
					action,
					edtgfrfltd,
					'gfrfltd',
					'urutan',
					'urutan,id_gfrxxth',
					urutan+','+id_gfrxxth,
					id_gfrfltd
				);		
			}
			
			if ( edtgfrfltd.inError() ) {
				return false;
			}
		});

		edtgfrfltd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgfrfltd.field('gfrfltd.finish_at').val(finish_at);
		});
			
		edtgfrfltd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtgfrfltd.on( 'close', function () {
			edtgfrfltd.enable();
			tblgfrfltd.ajax.reload(null, false);
			tblgfroptd.ajax.reload(null, false);
		} );
		
		tblgfrfltd = $('#tblgfrfltd').DataTable( {
			ajax: {
				url: "../../models/gfrxxth/gfrfltd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gfrfltd = show_deleted_gfrfltd;
					d.id_gfrxxth = id_gfrxxth;
				}
			},
			order: [[ 5, "asc" ]],
			columns: [
				{ data: "gfrfltd.id",visible:false },
				{ data: "gfrfltd.id_gfrxxth",visible:false },
				{ data: "gfrfltd.label" },
				
				{ 
					data: "gfrfltd.type",
					render: function (data){	
						if (data == 'text'){
							return 'Input';
						}else if (data == 'select'){
							return 'Select';
						}else if (data == 'datetime'){
							return 'Datepicker';
						}else if (data == 'textarea'){
							return 'Textarea';
						}else if (data == 'quill'){
							return 'Editor';
						}else{
							return '';
						}
					}
				},
				{ 
					data: "gfrfltd.type_data",
					render: function (data){	
						if (data == 'VARCHAR(200)'){
							return 'Sort Text';
						}else if (data == 'VARCHAR(1000)'){
							return 'Long Text';
						}else if (data == 'DATE'){
							return 'DATE';
						}else if (data == 'DATETIME'){
							return 'DATETIME';
						}else{
							return '';
						}
					}
				},
				{ data: "gfrfltd.urutan" },
				{ 
					data: "gfrfltd.is_required",
					...renderYaTidak()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gfrfltd';
					$table       = 'tblgfrfltd';
					$edt         = 'edtgfrfltd';
					$show_status = '_gfrfltd';
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

		tblgfrfltd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblgfrfltd, 1 );
			CekDrawDetailHDFinal(tblgfrxxth);
		} );
		
		tblgfrfltd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('gfrfltd');
			type_form   = gfrfltd_data.type;

			console.log(type_form);
			if (type_form == 'select') {
				$('#select_opt').show();
			} else {
				$('#select_opt').hide();
				$('#detail a').tab('show');
			}

			// atur hak akses
			CekSelectDetailHD( tblgfrfltd );
			tblgfroptd.ajax.reload(null, false);
			tblgfroptd.button('btnCreate:name')
			.nodes()
            .css( 'display', 'block' );
		} );

		tblgfrfltd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('gfrfltd');
			type_form = '';
			
			// atur hak akses
			CekDeselectDetailHD( tblgfrfltd );
			tblgfroptd.ajax.reload(null, false);
			tblgfroptd.button('btnCreate:name')
			.nodes()
            .css( 'display', 'none' );
			$('#select_opt').hide();
			$('#detail a').tab('show');
		} );
		// END gfrfltd
		
		// BEGIN gfroptd
		edtgfroptd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gfrxxth/gfroptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gfroptd = show_deleted_gfroptd;
					d.id_gfrfltd = id_gfrfltd;
				}
			},
			table: "#tblgfroptd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "gfroptd.start_at",
					name: "gfroptd.start_at",
					type: "hidden"
				},	
				{
					label: "gfroptd.finish_at",
					name: "gfroptd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gfroptd",
					type: "hidden"
				},	
				{
					label: "gfroptd.transaction_state",
					name: "gfroptd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_gfrfltd",
					name: "gfroptd.id_gfrfltd",
					type: "hidden"
				},	
				{
					label: "Option <sup class='text-danger'>*<sup>",
					name: "gfroptd.nama"
				}, 		
				{
					label: "Keterangan",
					name: "gfroptd.keterangan",
					type: "textarea"
				},
			]
		} );
			
		edtgfroptd.on( 'preOpen', function( e, mode, action ) {
			edtgfroptd.field('gfroptd.id_gfrfltd').val(id_gfrfltd);
			console.log(id_gfrfltd);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgfroptd.field('gfroptd.start_at').val(start_at);
			
			if(action == 'create'){
				tblgfroptd.rows().deselect();
			}
		});

		edtgfroptd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edtgfroptd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtgfroptd.field('gfroptd.nama').val();

				validasiRequired(
					edtgfroptd,
					'gfroptd',
					{
						'nama': nama,
					}
				);

				validasiUnique(
					action,
					edtgfroptd,
					'gfroptd',
					'nama',
					'nama',
					'"'+nama+'"',
					id_gfroptd
				);	
			}
			
			if ( edtgfroptd.inError() ) {
				return false;
			}
		});

		edtgfroptd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgfroptd.field('gfroptd.finish_at').val(finish_at);
		});
			
		edtgfroptd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblgfroptd.ajax.reload(null, false);
		} );

		edtgfroptd.on( 'close', function () {
			edtgfroptd.enable();
		} );
		
		tblgfroptd = $('#tblgfroptd').DataTable( {
			ajax: {
				url: "../../models/gfrxxth/gfroptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gfroptd = show_deleted_gfroptd;
					d.id_gfrfltd = id_gfrfltd;
				}
			},
			order: [[ 0, "asc" ]],
			columns: [
				{ data: "gfroptd.id",visible:false },
				{ data: "gfroptd.id_gfrfltd",visible:false },
				{ data: "gfroptd.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gfroptd';
					$table       = 'tblgfroptd';
					$edt         = 'edtgfroptd';
					$show_status = '_gfroptd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view'];
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

		tblgfroptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblgfroptd, 1 );
			CekDrawDetailHDFinal(tblgfrxxth);
		} );
		
		tblgfroptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('gfroptd');
			
			// atur hak akses
			CekSelectDetailHD( tblgfroptd );
		} );

		tblgfroptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('gfroptd');
			
			// atur hak akses
			CekDeselectDetailHD( tblgfroptd );
			CekDeselectHeaderHD(tblgfroptd, tbl_details);
		} );
		// END gfroptd
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
