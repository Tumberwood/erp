<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hibksmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhibksmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>% Perusahaan</th>
                                <th>% Karyawan</th>
                                <th>Gaji Maksimal</th>
                                <th>Tanggal Efektif</th>
                                <th>Keterangan</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hibksmh/fn/hibksmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthibksmh, tblhibksmh, show_deleted_hibksmh = 0, id_hibksmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hibksmh');

	$(document).ready(function() {
		// BEGIN hibksmh
		edthibksmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hibksmh/hibksmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hibksmh = show_deleted_hibksmh;
				}
			},
			table: "#tblhibksmh",
			fields: [ 
				{
					label: "hibksmh.start_at",
					name: "hibksmh.start_at",
					type: "hidden"
				},	
				{
					label: "hibksmh.finish_at",
					name: "hibksmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hibksmh",
					type: "hidden"
				},	
				{
					label: "hibksmh.transaction_state",
					name: "hibksmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "% Perusahaan <sup class='text-danger'>*<sup>",
					name: "hibksmh.persen_perusahaan"
				
				}, 	{
					label: "% Karyawan <sup class='text-danger'>*<sup>",
					name: "hibksmh.persen_karyawan"
				}, 	
				{
					label: "Gaji Maksimal <sup class='text-danger'>*<sup>",
					name: "hibksmh.gaji_max"
				}, 
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "hibksmh.tanggal_efektif",
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
					name: "hibksmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthibksmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthibksmh.field('hibksmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhibksmh.rows().deselect();
			}
		});

		edthibksmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirm();
		});

		edthibksmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal_efektif = edthibksmh.field('hibksmh.tanggal_efektif').val();
				persen_perusahaan = edthibksmh.field('hibksmh.persen_perusahaan').val();
				persen_karyawan = edthibksmh.field('hibksmh.persen_karyawan').val();
				gaji_max = edthibksmh.field('hibksmh.gaji_max').val();

				validasiRequired(
					edthibksmh,
					'hibksmh',
					{
						'tanggal_efektif': tanggal_efektif,
						'persen_perusahaan': persen_perusahaan,
						'persen_karyawan': persen_karyawan,
						'gaji_max': gaji_max,
					}
				);

				validasiNumber(
					edthibksmh, 
					"hibksmh", 
					{
						"persen_perusahaan": persen_perusahaan, 
						"persen_karyawan": persen_karyawan,
						"gaji_max": gaji_max,
					},
					0,
					'>='
				);
			}
			
			if ( edthibksmh.inError() ) {
				return false;
			}
		});
		
		edthibksmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthibksmh.field('hibksmh.finish_at').val(finish_at);
		});

		edthibksmh.on( 'close', function () {
			edthibksmh.enable();
		} );

		tblhibksmh = $('#tblhibksmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hibksmh/hibksmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hibksmh = show_deleted_hibksmh;
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
				{ data: "hibksmh.id",visible:false },
				{ 
					data: "hibksmh.persen_perusahaan" ,
					...renderNumber(1)
				},
				{ 
					data: "hibksmh.persen_karyawan" ,
					...renderNumber(1)
				},
				{ 
					data: "hibksmh.gaji_max" ,
					...renderNumber(0)
				},
				{ data: "hibksmh.tanggal_efektif" },
				{ data: "hibksmh.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hibksmh';
					$table       = 'tblhibksmh';
					$edt         = 'edthibksmh';
					$show_status = '_hibksmh';
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
				if ( data.hibksmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hibksmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhibksmh.searchPanes.container().appendTo('#sphibksmh');
		tblhibksmh.searchBuilder.container().appendTo( '#sbhibksmh' );
		
		tblhibksmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhibksmh);
		} );
		
		tblhibksmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hibksmh');
			// atur hak akses
			CekSelectHeaderH(tblhibksmh);
		} );

		tblhibksmh.on( 'deselect', function () {
			siVarReset('hibksmh');

			// atur hak akses
			CekDeselectHeaderH(tblhibksmh);
		} );

		// END hibksmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
