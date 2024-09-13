<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hpcatmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhpcatmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori</th>
                                <th>Bruto (>)</th>
                                <th>Bruto (<=)</th>
                                <th>TER (%)</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hpcatmh/fn/hpcatmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthpcatmh, tblhpcatmh, show_deleted_hpcatmh = 0, id_hpcatmh;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hpcatmh');
	
	$(document).ready(function() {
		
		// BEGIN hpcatmh
		edthpcatmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hpcatmh/hpcatmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpcatmh = show_deleted_hpcatmh;
				}
			},
			table: "#tblhpcatmh",
			fields: [ 
				{
					label: "hpcatmh.start_at",
					name: "hpcatmh.start_at",
					type: "hidden"
				},	
				{
					label: "hpcatmh.finish_at",
					name: "hpcatmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hpcatmh",
					type: "hidden"
				},	
				{
					label: "hpcatmh.transaction_state",
					name: "hpcatmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kategori <sup class='text-danger'>*<sup>",
					name: "hpcatmh.kategori",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "A", "value": "A" },
						{ "label": "B", "value": "B" },
						{ "label": "C", "value": "C" }
					]
				}, 	{
					label: "Bruto (>) <sup class='text-danger'>*<sup>",
					name: "hpcatmh.nominal_awal"
				}, 	{
					label: "Bruto (<=) <sup class='text-danger'>*<sup>",
					name: "hpcatmh.nominal_akhir"
				}, 	{
					label: "TER (%) <sup class='text-danger'>*<sup>",
					name: "hpcatmh.persen"
				}
			]
		} );

		edthpcatmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpcatmh.field('hpcatmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhpcatmh.rows().deselect();
			}
		});

		edthpcatmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthpcatmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kategori = edthpcatmh.field('hpcatmh.kategori').val();
				nominal_awal = edthpcatmh.field('hpcatmh.nominal_awal').val();
				nominal_akhir = edthpcatmh.field('hpcatmh.nominal_akhir').val();
				nominal_akhir = edthpcatmh.field('hpcatmh.nominal_akhir').val();
				persen = edthpcatmh.field('hpcatmh.persen').val();

				validasiRequired(
					edthpcatmh,
					'hpcatmh',
					{
						'kategori': kategori,
						'nominal_awal': nominal_awal,
						'nominal_akhir': nominal_akhir,
						'persen': persen,
					}
				);

				validasiNumber(
					edthpcatmh,
					'hpcatmh',
					{
						'nominal_awal': nominal_awal,
						'nominal_akhir': nominal_akhir,
						'persen': persen,
					},
					0,
					'>'
				);
			}
			
			if ( edthpcatmh.inError() ) {
				return false;
			}
		});
		
		edthpcatmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthpcatmh.field('hpcatmh.finish_at').val(finish_at);
		});

		edthpcatmh.on( 'close', function () {
			edthpcatmh.enable();
		} );

		tblhpcatmh = $('#tblhpcatmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hpcatmh/hpcatmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hpcatmh = show_deleted_hpcatmh;
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
				{ data: "hpcatmh.id",visible:false },
				{ data: "hpcatmh.kategori" },
				{ 
					data: "hpcatmh.nominal_awal",
					...renderNumber(0) 
				},
				{ 
					data: "hpcatmh.nominal_akhir",
					...renderNumber(0) 
				},
				{ 
					data: "hpcatmh.persen",
					...renderNumber(2)
				},
				{ 
					data: "hpcatmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hpcatmh';
					$table       = 'tblhpcatmh';
					$edt         = 'edthpcatmh';
					$show_status = '_hpcatmh';
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
				if ( data.hpcatmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hpcatmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhpcatmh.searchPanes.container().appendTo('#sphpcatmh');
		tblhpcatmh.searchBuilder.container().appendTo( '#sbhpcatmh' );
		
		tblhpcatmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhpcatmh);
		} );
		
		tblhpcatmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hpcatmh');

			// atur hak akses
			CekSelectHeaderH(tblhpcatmh);
		} );

		tblhpcatmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hpcatmh');

			// atur hak akses
			CekDeselectHeaderH(tblhpcatmh);
		} );

		// END hpcatmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
