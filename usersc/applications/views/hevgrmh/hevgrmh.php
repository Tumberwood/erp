<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hevgrmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhevgrmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hevgrmh/fn/hevgrmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthevgrmh, tblhevgrmh, show_deleted_hevgrmh = 0, id_hevgrmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hevgrmh');

	$(document).ready(function() {
		// BEGIN hevgrmh
		edthevgrmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hevgrmh/hevgrmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hevgrmh = show_deleted_hevgrmh;
				}
			},
			table: "#tblhevgrmh",
			fields: [ 
				{
					label: "hevgrmh.start_at",
					name: "hevgrmh.start_at",
					type: "hidden"
				},	
				{
					label: "hevgrmh.finish_at",
					name: "hevgrmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hevgrmh",
					type: "hidden"
				},	
				{
					label: "hevgrmh.transaction_state",
					name: "hevgrmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hevgrmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hevgrmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "hevgrmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthevgrmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthevgrmh.field('hevgrmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhevgrmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edthevgrmh.field('hevgrmh.kode').enable();
					edthevgrmh.field('hevgrmh.nama').enable();
				}else{
					edthevgrmh.field('hevgrmh.kode').disable();
					edthevgrmh.field('hevgrmh.nama').disable();
				}
			}
		});

		edthevgrmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthevgrmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthevgrmh.field('hevgrmh.kode').val();
				nama = edthevgrmh.field('hevgrmh.nama').val();

				validasiRequired(
					edthevgrmh,
					'hevgrmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthevgrmh,
					'hevgrmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hevgrmh
				);

				validasiUnique(
					action,
					edthevgrmh,
					'hevgrmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hevgrmh
				);
			}
			
			if ( edthevgrmh.inError() ) {
				return false;
			}
		});
		
		edthevgrmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthevgrmh.field('hevgrmh.finish_at').val(finish_at);
		});

		edthevgrmh.on( 'close', function () {
			edthevgrmh.enable();
		} );

		tblhevgrmh = $('#tblhevgrmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hevgrmh/hevgrmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hevgrmh = show_deleted_hevgrmh;
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
					targets: [0]
				}
			],
			columns: [
				{ data: "hevgrmh.id",visible:false },
				{ data: "hevgrmh.kode" },
				{ data: "hevgrmh.nama" },
				{ 
					data: "hevgrmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hevgrmh';
					$table       = 'tblhevgrmh';
					$edt         = 'edthevgrmh';
					$show_status = '_hevgrmh';
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
				if ( data.hevgrmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hevgrmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhevgrmh.searchPanes.container().appendTo('#sphevgrmh');
		tblhevgrmh.searchBuilder.container().appendTo( '#sbhevgrmh' );
		
		tblhevgrmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhevgrmh);
		} );
		
		tblhevgrmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hevgrmh');

			// atur hak akses
			CekSelectHeaderH(tblhevgrmh);
		} );

		tblhevgrmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hevgrmh');

			// atur hak akses
			CekDeselectHeaderH(tblhevgrmh);
		} );

		// END hevgrmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
