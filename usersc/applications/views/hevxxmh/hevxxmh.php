<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hevxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhevxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hevxxmh/fn/hevxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthevxxmh, tblhevxxmh, show_deleted_hevxxmh = 0, id_hevxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hevxxmh');

	$(document).ready(function() {
		// BEGIN hevxxmh
		edthevxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hevxxmh/hevxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hevxxmh = show_deleted_hevxxmh;
				}
			},
			table: "#tblhevxxmh",
			fields: [ 
				{
					label: "hevxxmh.start_at",
					name: "hevxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hevxxmh.finish_at",
					name: "hevxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hevxxmh",
					type: "hidden"
				},	
				{
					label: "hevxxmh.transaction_state",
					name: "hevxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hevxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hevxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "hevxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthevxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthevxxmh.field('hevxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhevxxmh.rows().deselect();
				edthevxxmh.field('hevxxmh.kode').enable();
				edthevxxmh.field('hevxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthevxxmh.field('hevxxmh.kode').enable();
					edthevxxmh.field('hevxxmh.nama').enable();
				}else{
					edthevxxmh.field('hevxxmh.kode').disable();
					edthevxxmh.field('hevxxmh.nama').disable();
				}
			}
		});

		edthevxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthevxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthevxxmh.field('hevxxmh.kode').val();
				nama = edthevxxmh.field('hevxxmh.nama').val();

				validasiRequired(
					edthevxxmh,
					'hevxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthevxxmh,
					'hevxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hevxxmh
				);

				validasiUnique(
					action,
					edthevxxmh,
					'hevxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hevxxmh
				);
			}
			
			if ( edthevxxmh.inError() ) {
				return false;
			}
		});
		
		edthevxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthevxxmh.field('hevxxmh.finish_at').val(finish_at);
		});

		edthevxxmh.on( 'close', function () {
			edthevxxmh.enable();
		} );

		tblhevxxmh = $('#tblhevxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hevxxmh/hevxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hevxxmh = show_deleted_hevxxmh;
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
				{ data: "hevxxmh.id",visible:false },
				{ data: "hevxxmh.kode" },
				{ data: "hevxxmh.nama" },
				{ 
					data: "hevxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hevxxmh';
					$table       = 'tblhevxxmh';
					$edt         = 'edthevxxmh';
					$show_status = '_hevxxmh';
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
				if ( data.hevxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hevxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhevxxmh.searchPanes.container().appendTo('#sphevxxmh');
		tblhevxxmh.searchBuilder.container().appendTo( '#sbhevxxmh' );
		
		tblhevxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhevxxmh);
		} );
		
		tblhevxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hevxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhevxxmh);
		} );

		tblhevxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hevxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhevxxmh);
		} );

		// END hevxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
