<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrtxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhrtxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrtxxmh/fn/hrtxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthrtxxmh, tblhrtxxmh, show_deleted_hrtxxmh = 0, id_hrtxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hrtxxmh');

	$(document).ready(function() {
		// BEGIN hrtxxmh
		edthrtxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrtxxmh/hrtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrtxxmh = show_deleted_hrtxxmh;
				}
			},
			table: "#tblhrtxxmh",
			fields: [ 
				{
					label: "hrtxxmh.start_at",
					name: "hrtxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hrtxxmh.finish_at",
					name: "hrtxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrtxxmh",
					type: "hidden"
				},	
				{
					label: "hrtxxmh.transaction_state",
					name: "hrtxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hrtxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hrtxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "hrtxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthrtxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrtxxmh.field('hrtxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrtxxmh.rows().deselect();
				edthrtxxmh.field('hrtxxmh.kode').enable();
				edthrtxxmh.field('hrtxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthrtxxmh.field('hrtxxmh.kode').enable();
					edthrtxxmh.field('hrtxxmh.nama').enable();
				}else{
					edthrtxxmh.field('hrtxxmh.kode').disable();
					edthrtxxmh.field('hrtxxmh.nama').disable();
				}
			}
		});

		edthrtxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthrtxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthrtxxmh.field('hrtxxmh.kode').val();
				nama = edthrtxxmh.field('hrtxxmh.nama').val();

				validasiRequired(
					edthrtxxmh,
					'hrtxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthrtxxmh,
					'hrtxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hrtxxmh
				);

				validasiUnique(
					action,
					edthrtxxmh,
					'hrtxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hrtxxmh
				);
			}
			
			if ( edthrtxxmh.inError() ) {
				return false;
			}
		});
		
		edthrtxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrtxxmh.field('hrtxxmh.finish_at').val(finish_at);
		});

		edthrtxxmh.on( 'close', function () {
			edthrtxxmh.enable();
		} );

		tblhrtxxmh = $('#tblhrtxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrtxxmh/hrtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrtxxmh = show_deleted_hrtxxmh;
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
				{ data: "hrtxxmh.id",visible:false },
				{ data: "hrtxxmh.kode" },
				{ data: "hrtxxmh.nama" },
				{ data: "hrtxxmh.keterangan" },
				{ 
					data: "hrtxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrtxxmh';
					$table       = 'tblhrtxxmh';
					$edt         = 'edthrtxxmh';
					$show_status = '_hrtxxmh';
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
				if ( data.hrtxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrtxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrtxxmh.searchPanes.container().appendTo('#sphrtxxmh');
		tblhrtxxmh.searchBuilder.container().appendTo( '#sbhrtxxmh' );
		
		tblhrtxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhrtxxmh);
		} );
		
		tblhrtxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrtxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhrtxxmh);
		} );

		tblhrtxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrtxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhrtxxmh);
		} );

		// END hrtxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
