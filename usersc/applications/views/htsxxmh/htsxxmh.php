<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htsxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtsxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Kode</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="2">Jam Kerja</th>
                                <th colspan="2">Jam Istirahat</th>
                                <th colspan="2">Menit Toleransi In</th>
                                <th colspan="2">Menit Toleransi Out</th>
                                <th rowspan="2">TX</th>
                            </tr>
							<tr>
                                <th>Awal</th>
                                <th>Akhir</th>
                                <th>Awal</th>
                                <th>Akhir</th>
								<th>Awal</th>
                                <th>Akhir</th>
								<th>Awal</th>
                                <th>Akhir</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htsxxmh/fn/htsxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthtsxxmh, tblhtsxxmh, show_deleted_htsxxmh = 0, id_htsxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('htsxxmh');

	$(document).ready(function() {
		// BEGIN htsxxmh
		edthtsxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htsxxmh/htsxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsxxmh = show_deleted_htsxxmh;
				}
			},
			table: "#tblhtsxxmh",
			fields: [ 
				{
					label: "htsxxmh.start_at",
					name: "htsxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "htsxxmh.finish_at",
					name: "htsxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htsxxmh",
					type: "hidden"
				},	
				{
					label: "htsxxmh.transaction_state",
					name: "htsxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "htsxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "htsxxmh.nama"
				}, 	
				{
					label: "Jam Awal <sup class='text-danger'>*<sup>",
					name: "htsxxmh.jam_awal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					format: 'HH:mm'
				},
				{
					label: "Jam Akhir <sup class='text-danger'>*<sup>",
					name: "htsxxmh.jam_akhir",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					format: 'HH:mm'
				},
				{
					label: "Jam Awal Istirahat",
					name: "htsxxmh.jam_awal_istirahat",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					format: 'HH:mm'
				},
				{
					label: "Jam Akhir Istirahat",
					name: "htsxxmh.jam_akhir_istirahat",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					format: 'HH:mm'
				},
				{
					label: "Toleransi In Awal",
					name: "htsxxmh.menit_toleransi_awal_in"
				},
				{
					label: "Toleransi In Akhir",
					name: "htsxxmh.menit_toleransi_akhir_in"
				},
				{
					label: "Toleransi Out Awal",
					name: "htsxxmh.menit_toleransi_awal_out"
				},
				{
					label: "Toleransi Out Akhir",
					name: "htsxxmh.menit_toleransi_akhir_out"
				},
				{
					label: "Keterangan",
					name: "htsxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthtsxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsxxmh.field('htsxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtsxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edthtsxxmh.field('htsxxmh.kode').enable();
					edthtsxxmh.field('htsxxmh.nama').enable();
				}else{
					edthtsxxmh.field('htsxxmh.kode').disable();
					edthtsxxmh.field('htsxxmh.nama').disable();
				}
			}
		});

		edthtsxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthtsxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthtsxxmh.field('htsxxmh.kode').val();
				nama = edthtsxxmh.field('htsxxmh.nama').val();
				jam_awal = edthtsxxmh.field('htsxxmh.jam_awal').val();
				jam_akhir = edthtsxxmh.field('htsxxmh.jam_akhir').val();

				validasiRequired(
					edthtsxxmh,
					'htsxxmh',
					{
						'kode': kode,
						'nama': nama,
						'jam_awal': jam_awal,
						'jam_akhir': jam_akhir
					}
				);

				validasiUnique(
					action,
					edthtsxxmh,
					'htsxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_htsxxmh
				);

				validasiUnique(
					action,
					edthtsxxmh,
					'htsxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_htsxxmh
				);
			}
			
			if ( edthtsxxmh.inError() ) {
				return false;
			}
		});
		
		edthtsxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsxxmh.field('htsxxmh.finish_at').val(finish_at);
		});

		edthtsxxmh.on( 'close', function () {
			edthtsxxmh.enable();
		} );

		tblhtsxxmh = $('#tblhtsxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htsxxmh/htsxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsxxmh = show_deleted_htsxxmh;
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
					targets: [0,4,5,6,7,8,9,10,11]
				}
			],
			columns: [
				{ data: "htsxxmh.id",visible:false },
				{ data: "htsxxmh.kode" },
				{ data: "htsxxmh.nama" },
				{ data: "htsxxmh.jam_awal" },
				{ data: "htsxxmh.jam_akhir" },
				{ data: "htsxxmh.jam_awal_istirahat" },
				{ data: "htsxxmh.jam_akhir_istirahat" },
				{ 
					data: "htsxxmh.menit_toleransi_awal_in" ,
					...renderNumber(0)
				},
				{ 
					data: "htsxxmh.menit_toleransi_akhir_in" ,
					...renderNumber(0)
				},
				{ 
					data: "htsxxmh.menit_toleransi_awal_out" ,
					...renderNumber(0)
				},
				{ 
					data: "htsxxmh.menit_toleransi_akhir_out" ,
					...renderNumber(0)
				},
				{ 
					data: "htsxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htsxxmh';
					$table       = 'tblhtsxxmh';
					$edt         = 'edthtsxxmh';
					$show_status = '_htsxxmh';
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
				if ( data.htsxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htsxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtsxxmh.searchPanes.container().appendTo('#sphtsxxmh');
		tblhtsxxmh.searchBuilder.container().appendTo( '#sbhtsxxmh' );
		
		tblhtsxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhtsxxmh);
		} );
		
		tblhtsxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('htsxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhtsxxmh);
		} );

		tblhtsxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('htsxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhtsxxmh);
		} );

		// END htsxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
