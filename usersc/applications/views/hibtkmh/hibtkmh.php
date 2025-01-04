<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hibtkmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhibtkmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
							<tr>
                                <th rowspan="2">ID</th>
                                <th colspan="2">JHT</th>
                                <th rowspan="2">JKK</th>
                                <th rowspan="2">JKM</th>
                                <th colspan="2">JP</th>
                                <th rowspan="2">Gaji Maksimal</th>
                                <th rowspan="2">Tanggal Efektif</th>
                                <th rowspan="2">Keterangan</th>
                            </tr>
                            <tr>
                                <th>Perusahaan</th>
                                <th>Karyawan</th>
                                <th>Perusahaan</th>
                                <th>Karyawan</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hibtkmh/fn/hibtkmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthibtkmh, tblhibtkmh, show_deleted_hibtkmh = 0, id_hibtkmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hibtkmh');

	$(document).ready(function() {
		// BEGIN hibtkmh
		edthibtkmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hibtkmh/hibtkmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hibtkmh = show_deleted_hibtkmh;
				}
			},
			table: "#tblhibtkmh",
			fields: [ 
				{
					label: "hibtkmh.start_at",
					name: "hibtkmh.start_at",
					type: "hidden"
				},	
				{
					label: "hibtkmh.finish_at",
					name: "hibtkmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hibtkmh",
					type: "hidden"
				},	
				{
					label: "hibtkmh.transaction_state",
					name: "hibtkmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "JHT Ditanggung Perusahaan <sup class='text-danger'>*<sup>",
					name: "hibtkmh.persen_jht_perusahaan"
				}, 	
				{
					label: "JHT Ditanggung Karyawan <sup class='text-danger'>*<sup>",
					name: "hibtkmh.persen_jht_karyawan"
				}, 	
				{
					label: "JKK Ditanggung Perusahaan <sup class='text-danger'>*<sup>",
					name: "hibtkmh.persen_jkk"
				}, 	
				{
					label: "JKM Ditanggung Perusahaan <sup class='text-danger'>*<sup>",
					name: "hibtkmh.persen_jkm"
				}, 	
				{
					label: "JP Ditanggung Perusahaan <sup class='text-danger'>*<sup>",
					name: "hibtkmh.persen_jp_perusahaan"
				}, 	
				{
					label: "JP Ditanggung Karyawan <sup class='text-danger'>*<sup>",
					name: "hibtkmh.persen_jp_karyawan"
				}, 	
				{
					label: "Gaji Maksimal <sup class='text-danger'>*<sup>",
					name: "hibtkmh.gaji_max"
				}, 	
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "hibtkmh.tanggal_efektif",
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
					label: "Keterangan",
					name: "hibtkmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthibtkmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthibtkmh.field('hibtkmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhibtkmh.rows().deselect();
			}
		});

		edthibtkmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirm();
		});

		edthibtkmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_efektif = edthibtkmh.field('hibtkmh.tanggal_efektif').val();
				persen_jht_perusahaan = edthibtkmh.field('hibtkmh.persen_jht_perusahaan').val();
				persen_jht_karyawan = edthibtkmh.field('hibtkmh.persen_jht_karyawan').val();
				persen_jkk = edthibtkmh.field('hibtkmh.persen_jkk').val();
				persen_jkm = edthibtkmh.field('hibtkmh.persen_jkm').val();
				persen_jp_perusahaan = edthibtkmh.field('hibtkmh.persen_jp_perusahaan').val();
				persen_jp_karyawan = edthibtkmh.field('hibtkmh.persen_jp_karyawan').val();
				gaji_max = edthibtkmh.field('hibtkmh.gaji_max').val();

				validasiRequired(
					edthibtkmh,
					'hibtkmh',
					{
						'tanggal_efektif': tanggal_efektif,
						'persen_jht_perusahaan': persen_jht_perusahaan,
						'persen_jht_karyawan': persen_jht_karyawan,
						'persen_jkk': persen_jkk,
						'persen_jkm': persen_jkm,
						'persen_jp_perusahaan': persen_jp_perusahaan,
						'persen_jp_karyawan': persen_jp_karyawan,
						'gaji_max': gaji_max,
					}
				);

				validasiNumber(
					edthibtkmh, 
					"hibtkmh", 
					{
						"persen_jht_perusahaan": persen_jht_perusahaan, 
						"persen_jht_karyawan": persen_jht_karyawan,
						"persen_jkk": persen_jkk,
						"persen_jkm": persen_jkm,
						"persen_jp_perusahaan": persen_jp_perusahaan,
						"persen_jp_karyawan": persen_jp_karyawan,
						"gaji_max": gaji_max,
					},
					0,
					'>='
				);
			}
			
			if ( edthibtkmh.inError() ) {
				return false;
			}
		});
		
		edthibtkmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthibtkmh.field('hibtkmh.finish_at').val(finish_at);
		});

		edthibtkmh.on( 'close', function () {
			edthibtkmh.enable();
		} );

		tblhibtkmh = $('#tblhibtkmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hibtkmh/hibtkmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hibtkmh = show_deleted_hibtkmh;
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
				{ data: "hibtkmh.id",visible:false },
				{ 
					data: "hibtkmh.persen_jht_perusahaan" ,
					...renderNumber(1)
				},
				{ 
					data: "hibtkmh.persen_jht_karyawan" ,
					...renderNumber(1)
				},
				{ 
					data: "hibtkmh.persen_jkk" ,
					...renderNumber(2)
				},
				{ 
					data: "hibtkmh.persen_jkm" ,
					...renderNumber(1)
				},
				{ 
					data: "hibtkmh.persen_jp_perusahaan" ,
					...renderNumber(1)
				},
				{ 
					data: "hibtkmh.persen_jp_karyawan" ,
					...renderNumber(1)
				},
				{ 
					data: "hibtkmh.gaji_max" ,
					...renderNumber(0)
				},
				{ data: "hibtkmh.tanggal_efektif" },
				{ data: "hibtkmh.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hibtkmh';
					$table       = 'tblhibtkmh';
					$edt         = 'edthibtkmh';
					$show_status = '_hibtkmh';
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
				if ( data.hibtkmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hibtkmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhibtkmh.searchPanes.container().appendTo('#sphibtkmh');
		tblhibtkmh.searchBuilder.container().appendTo( '#sbhibtkmh' );
		
		tblhibtkmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhibtkmh);
		} );
		
		tblhibtkmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hibtkmh');

			// atur hak akses
			CekSelectHeaderH(tblhibtkmh);
		} );

		tblhibtkmh.on( 'deselect', function () {
			siVarReset('hibtkmh');

			// atur hak akses
			CekDeselectHeaderH(tblhibtkmh);
		} );

		// END hibtkmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
