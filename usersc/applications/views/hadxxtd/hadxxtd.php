<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hadxxtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhadxxtd" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>NRP</th>
                                <th>Nama</th>
                                <th>Department</th>
                                <th>Jabatan</th>
                                <th>Jenis</th>
                                <th>Pelanggaran</th>
                                <th>Tanggal Berlaku</th>
                                <th>TX</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hadxxtd/fn/hadxxtd_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthadxxtd, tblhadxxtd, show_deleted_hadxxtd = 0, id_hadxxtd;
	// ------------- end of default variable
	
	kategori_dokumen = "";
	kategori_dokumen_value = "";
	
	// get tableRelation
	tableRelation('hadxxtd');
	
	var id_hemxxmh_old = 0, id_havxxmh_old = 0, id_hadxxmh_old = 0;
	var id_hadxxmh_saran = 0;
	
	$(document).ready(function() {
		// BEGIN hadxxtd
		edthadxxtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hadxxtd/hadxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hadxxtd = show_deleted_hadxxtd;
				}
			},
			table: "#tblhadxxtd",
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
					label: "hadxxtd.start_at",
					name: "hadxxtd.start_at",
					type: "hidden"
				},	
				{
					label: "hadxxtd.finish_at",
					name: "hadxxtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hadxxtd",
					type: "hidden"
				},	
				{
					label: "hadxxtd.transaction_state",
					name: "hadxxtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hadxxtd.id_hemxxmh",
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
				},
				{
					label: "Pelanggaran <sup class='text-danger'>*<sup>",
					name: "hadxxtd.id_havxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/havxxmh/havxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_havxxmh_old: id_havxxmh_old,
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
					label: "Tindakan <sup class='text-danger'>*<sup>",
					name: "hadxxtd.id_hadxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hadxxmh/hadxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hadxxmh_saran: id_hadxxmh_saran,
									id_hadxxmh_old: id_hadxxmh_old,
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
					label: "Tanggal Mulai Berlaku <sup class='text-danger'>*<sup>",
					name: "hadxxtd.tanggal_awal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Tanggal Selesai Berlaku",
					name: "hadxxtd.tanggal_akhir",
					type: "datetime",
					format: 'DD MMM YYYY'
				},
				{
					label: "Bukti",
					name: "hadxxtd.id_files_bukti",
					type: "upload",
					display: function ( fileId, counter ) {
						if(fileId > 0){
							return '<img src="'+edthadxxtd.file( 'files', fileId ).web_path+'"/>';
						}
					},
					noFileText: 'Belum ada lampiran'
				},
				{
					label: "Dokumen",
					name: "hadxxtd.id_files_dokumen",
					type: "upload",
					display: function ( fileId, counter ) {
						if(fileId > 0){
							return '<img src="'+edthadxxtd.file( 'files', fileId ).web_path+'"/>';
						}
					},
					noFileText: 'Belum ada lampiran'
				},
				{
					label: "Keterangan",
					name: "hadxxtd.keterangan",
					type: "textarea"
				}
			]
		} );

		edthadxxtd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthadxxtd.field('hadxxtd.start_at').val(start_at);
			edthadxxtd.field('hadxxtd.tanggal_akhir').disable();
			
			if(action == 'create'){
				edthadxxtd.field('kategori_dokumen').val('');
				edthadxxtd.field('kategori_dokumen_value').val('');
				edthadxxtd.field('field_tanggal').val('start_at');
				tblhadxxtd.rows().deselect();
			}
		});

		edthadxxtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthadxxtd.dependent( 'hadxxtd.id_havxxmh', function ( val, data, callback ) {
			havxxmh_load_hadxxmh ();
			hadxxmh_fn_tanggal_akhir();
			return {}
		}, {event: 'keyup change'});

		edthadxxtd.dependent( 'hadxxtd.id_hadxxmh', function ( val, data, callback ) {
			hadxxmh_fn_tanggal_akhir();
			return {}
		}, {event: 'keyup change'});

		edthadxxtd.dependent( 'hadxxtd.tanggal_awal', function ( val, data, callback ) {
			hadxxmh_fn_tanggal_akhir();
			return {}
		}, {event: 'keyup change'});

		edthadxxtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hemxxmh = edthadxxtd.field('hadxxtd.id_hemxxmh').val();
				id_hadxxmh = edthadxxtd.field('hadxxtd.id_hadxxmh').val();
				tanggal_awal = edthadxxtd.field('hadxxtd.tanggal_awal').val();
				id_havxxmh = edthadxxtd.field('hadxxtd.id_havxxmh').val();

				validasiRequired(
					edthadxxtd,
					'hadxxtd',
					{
						'id_hadxxmh': id_hadxxmh,
						'tanggal_awal': tanggal_awal,
						'id_havxxmh': id_havxxmh,
						'id_hemxxmh': id_hemxxmh,
					}
				);
			}
			
			if ( edthadxxtd.inError() ) {
				return false;
			}
		});
		
		edthadxxtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthadxxtd.field('hadxxtd.finish_at').val(finish_at);
		});

		edthadxxtd.on( 'close', function () {
			edthadxxtd.enable();
		} );

		tblhadxxtd = $('#tblhadxxtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hadxxtd/hadxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hadxxtd = show_deleted_hadxxtd;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "hadxxtd.id",visible:false },
				{ data: "hadxxtd.kode" },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ data: "hadxxmh.nama" },
				{ data: "havxxmh.nama" },
				{ data: "hadxxtd.tanggal_awal" },
				{ 
					data: "hadxxtd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hadxxtd';
					$table       = 'tblhadxxtd';
					$edt         = 'edthadxxtd';
					$show_status = '_hadxxtd';
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
				if ( data.hadxxtd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hadxxtd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhadxxtd.searchPanes.container().appendTo('#sphadxxtd');
		tblhadxxtd.searchBuilder.container().appendTo( '#sbhadxxtd' );
		
		tblhadxxtd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhadxxtd);
		} );
		
		tblhadxxtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hadxxtd');
			id_hadxxmh_old    		= hadxxtd_data.id_hadxxmh;
			id_havxxmh_old    		= hadxxtd_data.id_havxxmh;
			id_hemxxmh_old    		= hadxxtd_data.id_hemxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhadxxtd);
		} );

		tblhadxxtd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hadxxtd');
			id_hadxxmh_old = 0, id_havxxmh_old = 0, id_hemxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhadxxtd);
		} );
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
