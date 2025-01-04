<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrctstd_cfit';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhrctstd_cfit" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Tes</th>
                                <th>Nama</th>
                                <th>Tanggal Tes</th>
                                <th>Total Benar</th>
                                <th>Total Nilai</th>
                                <th>IQ</th>
                                <th>Kategori</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctstd_cfit/fn/hrctstd_cfit_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthrctstd_cfit, tblhrctstd_cfit, show_deleted_hrctstd_cfit = 0, id_hrctstd_cfit;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hrctstd_cfit');

	$(document).ready(function() {
		// BEGIN hrctstd_cfit
		edthrctstd_cfit = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrctstd_cfit/hrctstd_cfit.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd_cfit = show_deleted_hrctstd_cfit;
				}
			},
			table: "#tblhrctstd_cfit",
			fields: [ 
				{
					label: "hrctstd_cfit.start_at",
					name: "hrctstd_cfit.start_at",
					type: "hidden"
				},	
				{
					label: "hrctstd_cfit.finish_at",
					name: "hrctstd_cfit.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrctstd_cfit",
					type: "hidden"
				},	
				{
					label: "hrctstd_cfit.transaction_state",
					name: "hrctstd_cfit.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "hrctstd_cfit.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hrctstd_cfit.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hrctstd_cfit.keterangan",
					type: "textarea"
				}
			]
		} );

		edthrctstd_cfit.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd_cfit.field('hrctstd_cfit.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrctstd_cfit.rows().deselect();
				edthrctstd_cfit.field('hrctstd_cfit.kode').enable();
				edthrctstd_cfit.field('hrctstd_cfit.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthrctstd_cfit.field('hrctstd_cfit.kode').enable();
					edthrctstd_cfit.field('hrctstd_cfit.nama').enable();
				}else{
					edthrctstd_cfit.field('hrctstd_cfit.kode').disable();
					edthrctstd_cfit.field('hrctstd_cfit.nama').disable();
				}
			}
		});

		edthrctstd_cfit.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthrctstd_cfit.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthrctstd_cfit.field('hrctstd_cfit.kode').val();
				nama = edthrctstd_cfit.field('hrctstd_cfit.nama').val();

				validasiRequired(
					edthrctstd_cfit,
					'hrctstd_cfit',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthrctstd_cfit,
					'hrctstd_cfit',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hrctstd_cfit
				);

				validasiUnique(
					action,
					edthrctstd_cfit,
					'hrctstd_cfit',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hrctstd_cfit
				);
			}
			
			if ( edthrctstd_cfit.inError() ) {
				return false;
			}
		});
		
		edthrctstd_cfit.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd_cfit.field('hrctstd_cfit.finish_at').val(finish_at);
		});

		edthrctstd_cfit.on( 'close', function () {
			edthrctstd_cfit.enable();
		} );

		tblhrctstd_cfit = $('#tblhrctstd_cfit').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrctstd_cfit/hrctstd_cfit.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd_cfit = show_deleted_hrctstd_cfit;
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
				{ data: "hrctstd_cfit.id",visible:false },
				{ data: "hrctsth_cfit.kode" },
				{ data: "hcdxxmh.nama" },
				{ data: "hrctsth_cfit.tanggal"},
				{ data: "hrctstd_cfit.total_benar" },
				{ data: "hrctstd_cfit.total_nilai" },
				{ data: "hrctstd_cfit.iq" },
				{ data: "hrctstd_cfit.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrctstd_cfit';
					$table       = 'tblhrctstd_cfit';
					$edt         = 'edthrctstd_cfit';
					$show_status = '_hrctstd_cfit';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hrctstd_cfit.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrctstd_cfit.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrctstd_cfit.searchPanes.container().appendTo('#sphrctstd_cfit');
		tblhrctstd_cfit.searchBuilder.container().appendTo( '#sbhrctstd_cfit' );
		
		tblhrctstd_cfit.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhrctstd_cfit);
		} );
		
		tblhrctstd_cfit.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrctstd_cfit');

			// atur hak akses
			CekSelectHeaderH(tblhrctstd_cfit);
		} );

		tblhrctstd_cfit.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrctstd_cfit');

			// atur hak akses
			CekDeselectHeaderH(tblhrctstd_cfit);
		} );

		// END hrctstd_cfit
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
