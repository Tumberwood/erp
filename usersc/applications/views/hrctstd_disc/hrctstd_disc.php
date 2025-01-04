<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrctstd_disc';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhrctstd_disc" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Tes</th>
                                <th>Nama</th>
                                <th>Tanggal Tes</th>
								<th>Line 1</th>
								<th>Line 2</th>
								<th>Line 3</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="display: none;" id="hasil_akhir">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
			<div class="ibox ">
				<div class="ibox-content">
					<h3 class="text-danger text-center">Mask Public Self</h3>
					<div id="data-line1"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
			<div class="ibox ">
				<div class="ibox-content">
					<h3 class="text-danger text-center">Core Private Self</h3>
					<div id="data-line2"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
			<div class="ibox ">
				<div class="ibox-content">
					<h3 class="text-danger text-center">Mirror Perceived Self</h3>
					<div id="data-line3"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 p-w-xs">
			<div class="row">
				<div class="ibox ">
					<div class="ibox-content">
						<h3 class="text-danger text-center">Keterangan</h3>
						<div id="data-keterangan"></div>
						<hr>
						<h3 class="text-danger text-center">Job</h3>
						<div id="data-job"></div>
					</div>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctstd_disc/fn/hrctstd_disc_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthrctstd_disc, tblhrctstd_disc, show_deleted_hrctstd_disc = 0, id_hrctstd_disc;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hrctstd_disc');

	$(document).ready(function() {
		// BEGIN hrctstd_disc
		edthrctstd_disc = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrctstd_disc/hrctstd_disc.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd_disc = show_deleted_hrctstd_disc;
				}
			},
			table: "#tblhrctstd_disc",
			fields: [ 
				{
					label: "hrctstd_disc.start_at",
					name: "hrctstd_disc.start_at",
					type: "hidden"
				},	
				{
					label: "hrctstd_disc.finish_at",
					name: "hrctstd_disc.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrctstd_disc",
					type: "hidden"
				},	
				{
					label: "hrctstd_disc.transaction_state",
					name: "hrctstd_disc.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "hrctstd_disc.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hrctstd_disc.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hrctstd_disc.keterangan",
					type: "textarea"
				}
			]
		} );

		edthrctstd_disc.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd_disc.field('hrctstd_disc.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrctstd_disc.rows().deselect();
				edthrctstd_disc.field('hrctstd_disc.kode').enable();
				edthrctstd_disc.field('hrctstd_disc.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthrctstd_disc.field('hrctstd_disc.kode').enable();
					edthrctstd_disc.field('hrctstd_disc.nama').enable();
				}else{
					edthrctstd_disc.field('hrctstd_disc.kode').disable();
					edthrctstd_disc.field('hrctstd_disc.nama').disable();
				}
			}
		});

		edthrctstd_disc.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthrctstd_disc.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthrctstd_disc.field('hrctstd_disc.kode').val();
				nama = edthrctstd_disc.field('hrctstd_disc.nama').val();

				validasiRequired(
					edthrctstd_disc,
					'hrctstd_disc',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthrctstd_disc,
					'hrctstd_disc',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hrctstd_disc
				);

				validasiUnique(
					action,
					edthrctstd_disc,
					'hrctstd_disc',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hrctstd_disc
				);
			}
			
			if ( edthrctstd_disc.inError() ) {
				return false;
			}
		});
		
		edthrctstd_disc.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctstd_disc.field('hrctstd_disc.finish_at').val(finish_at);
		});

		edthrctstd_disc.on( 'close', function () {
			edthrctstd_disc.enable();
		} );

		tblhrctstd_disc = $('#tblhrctstd_disc').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrctstd_disc/hrctstd_disc.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctstd_disc = show_deleted_hrctstd_disc;
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
				{ data: "hrctstd_disc.id",visible:false },
				{ data: "hrctsth_disc.kode" },
				{ data: "hcdxxmh.nama" },
				{ data: "hrctsth_disc.tanggal"},
				{ data: "hrctstd_disc.hasil_line1"},
				{ data: "hrctstd_disc.hasil_line2"},
				{ data: "hrctstd_disc.hasil_line3"}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrctstd_disc';
					$table       = 'tblhrctstd_disc';
					$edt         = 'edthrctstd_disc';
					$show_status = '_hrctstd_disc';
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
				if ( data.hrctstd_disc.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrctstd_disc.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrctstd_disc.searchPanes.container().appendTo('#sphrctstd_disc');
		tblhrctstd_disc.searchBuilder.container().appendTo( '#sbhrctstd_disc' );
		
		tblhrctstd_disc.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhrctstd_disc);
		} );
		
		tblhrctstd_disc.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrctstd_disc');
			hasil_line1      = hrctstd_disc_data.hasil_line1;
			hasil_line2      = hrctstd_disc_data.hasil_line2;
			hasil_line3      = hrctstd_disc_data.hasil_line3;

			// atur hak akses
			CekSelectHeaderH(tblhrctstd_disc);
			$("#hasil_akhir").show();
			hasil(hasil_line1, hasil_line2, hasil_line3);
		} );

		tblhrctstd_disc.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrctstd_disc');
			hasil_line1 = 0;
			hasil_line2 = 0;
			hasil_line3 = 0;
			$("#hasil_akhir").hide();

			// atur hak akses
			CekDeselectHeaderH(tblhrctstd_disc);
		} );

		// END hrctstd_disc
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
