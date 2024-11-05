<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'httlpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhttlpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th>Jenis</th>
                                <th>Self Service</th>
                                <th>Jenis Jam</th>
                                <th>Potong Cuti</th>
                                <th>Dashboard Personal</th>
                                <th data-i18n="state"></th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httlpmh/fn/httlpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthttlpmh, tblhttlpmh, show_deleted_httlpmh = 0, id_httlpmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('httlpmh');

	$(document).ready(function() {
		// BEGIN httlpmh
		edthttlpmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/httlpmh/httlpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httlpmh = show_deleted_httlpmh;
				}
			},
			table: "#tblhttlpmh",
			fields: [ 
				{
					label: "httlpmh.start_at",
					name: "httlpmh.start_at",
					type: "hidden"
				},	
				{
					label: "httlpmh.finish_at",
					name: "httlpmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "httlpmh",
					type: "hidden"
				},	
				{
					label: "httlpmh.transaction_state",
					name: "httlpmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "httlpmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "httlpmh.nama"
				}, 	
				{
					label: "Self Service",
					name: "httlpmh.is_self_service",
					type: "select",
					def : 0,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Jenis <sup class='text-danger'>*<sup>",
					name: "httlpmh.jenis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Hari", "value": 1 },
						{ "label": "Jam", "value": 2 }
					]
				},
				{
					label: "Jumlah Hari <sup class='text-danger'>*<sup>",
					name: "httlpmh.hari",
				},
				{
					label: "Jenis Jam <sup class='text-danger'>*<sup>",
					name: "httlpmh.jenis_jam",
					type: "select",
					placeholder : "Select",
					fieldInfo: "Inputan jam yang harus diisi saat pengajuan Izin",
					options: [
						{ "label": "Awal", "value": 1 },
						{ "label": "Akhir", "value": 2 },
						{ "label": "Awal dan Akhir", "value": 3 }
					]
				},
				{
					label: "Potong Cuti",
					name: "httlpmh.is_potongcuti",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Dashboard Personal",
					name: "httlpmh.is_dashboard_personal",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: getTranslation('notes'),
					name: "httlpmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthttlpmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttlpmh.field('httlpmh.start_at').val(start_at);
			edthttlpmh.field('httlpmh.jenis_jam').hide();
			
			if(action == 'create'){
				tblhttlpmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edthttlpmh.field('httlpmh.kode').enable();
					edthttlpmh.field('httlpmh.nama').enable();
				}else{
					edthttlpmh.field('httlpmh.kode').disable();
					edthttlpmh.field('httlpmh.nama').disable();
				}
			}
		});

		edthttlpmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthttlpmh.dependent( 'httlpmh.jenis', function ( val, data, callback ) {
			if (val == 1) {
				edthttlpmh.field('httlpmh.jenis_jam').hide();
				edthttlpmh.field('httlpmh.jenis_jam').val('');

				edthttlpmh.field('httlpmh.hari').show();
				edthttlpmh.field('httlpmh.hari').val();
			} else {
				edthttlpmh.field('httlpmh.jenis_jam').show();
				edthttlpmh.field('httlpmh.jenis_jam').val();

				edthttlpmh.field('httlpmh.hari').hide();
				edthttlpmh.field('httlpmh.hari').val('');
			}
			return {}
		}, {event: 'keyup change'});

		edthttlpmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthttlpmh.field('httlpmh.kode').val();
				nama = edthttlpmh.field('httlpmh.nama').val();
				jenis = edthttlpmh.field('httlpmh.jenis').val();
				jenis_jam = edthttlpmh.field('httlpmh.jenis_jam').val();
				hari = edthttlpmh.field('httlpmh.hari').val();

				validasiRequired(
					edthttlpmh,
					'httlpmh',
					{
						'kode': kode,
						'nama': nama,
						'jenis': jenis,
					}
				);

				if (jenis == 2) {
					validasiRequired(
						edthttlpmh,
						'httlpmh',
						{
							'jenis_jam': jenis_jam,
						}
					);
				}

				validasiUnique(
					action,
					edthttlpmh,
					'httlpmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_httlpmh
				);

				validasiUnique(
					action,
					edthttlpmh,
					'httlpmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_httlpmh
				);

				validasiNumber(
					edthttlpmh,
					'httlpmh',
					{
						'hari': hari,
					},
					0,
					'>='
				);
			}
			
			if ( edthttlpmh.inError() ) {
				return false;
			}
		});
		
		edthttlpmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthttlpmh.field('httlpmh.finish_at').val(finish_at);
		});

		edthttlpmh.on( 'close', function () {
			edthttlpmh.enable();
		} );

		tblhttlpmh = $('#tblhttlpmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/httlpmh/httlpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httlpmh = show_deleted_httlpmh;
				}
			},
			order: [[ 0, "asc" ]],
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
				{ data: "httlpmh.id",visible:false },
				{ data: "httlpmh.kode" },
				{ data: "httlpmh.nama" },
				{ 
					data: "httlpmh.jenis",
					render: function (data) {
						if (data == 1) {
							return '<span class="badge badge-primary">Hari</span>';
						} else if (data == 2) {
							return '<span class="badge badge-warning">Jam</span>';
						} else {
							return '<span class="badge badge-danger">INVALID</span>';
						}
					}
				},
				
				{ 
					data: "httlpmh.is_self_service" ,
					...renderYaTidak()
				},
				{ 
					data: "httlpmh.jenis_jam" ,
					render: function (data){
						if(data == 1){
							return '<span class="badge badge-primary">Awal</span>';
						}else if(data == 2){
							return '<span class="badge badge-primary">Akhir</span>';
						}else if(data == 3){
							return '<span class="badge badge-primary">Awal dan Akhir</span>';
						}else{
							return '<span class="badge badge-danger">INVALID</span>';
						}
					}
				},
				{ 
					data: "httlpmh.is_potongcuti" ,
					...renderYaTidak()
				},
				{ 
					data: "httlpmh.is_dashboard_personal" ,
					...renderYaTidak()
				},
				{ 
					data: "httlpmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_httlpmh';
					$table       = 'tblhttlpmh';
					$edt         = 'edthttlpmh';
					$show_status = '_httlpmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.httlpmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.httlpmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhttlpmh.searchPanes.container().appendTo('#sphttlpmh');
		tblhttlpmh.searchBuilder.container().appendTo( '#sbhttlpmh' );
		
		tblhttlpmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhttlpmh);
		} );
		
		tblhttlpmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('httlpmh');

			// atur hak akses
			CekSelectHeaderH(tblhttlpmh);
			tblhttlpmh.button('btnEdit:name')
			.nodes()
            .css( 'display', 'block' );
		} );
		
		tblhttlpmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('httlpmh');
			
			// atur hak akses
			CekDeselectHeaderH(tblhttlpmh);
		} );

		// END httlpmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
