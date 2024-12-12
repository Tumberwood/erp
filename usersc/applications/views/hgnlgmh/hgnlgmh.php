<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hgnlgmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhgnlgmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hgnlgmh/fn/hgnlgmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthgnlgmh, tblhgnlgmh, show_deleted_hgnlgmh = 0, id_hgnlgmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hgnlgmh');

	$(document).ready(function() {
		// BEGIN hgnlgmh
		edthgnlgmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hgnlgmh/hgnlgmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hgnlgmh = show_deleted_hgnlgmh;
				}
			},
			table: "#tblhgnlgmh",
			fields: [ 
				{
					label: "hgnlgmh.start_at",
					name: "hgnlgmh.start_at",
					type: "hidden"
				},	
				{
					label: "hgnlgmh.finish_at",
					name: "hgnlgmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hgnlgmh",
					type: "hidden"
				},	
				{
					label: "hgnlgmh.transaction_state",
					name: "hgnlgmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hgnlgmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hgnlgmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "hgnlgmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthgnlgmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthgnlgmh.field('hgnlgmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhgnlgmh.rows().deselect();
				edthgnlgmh.field('hgnlgmh.kode').enable();
				edthgnlgmh.field('hgnlgmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthgnlgmh.field('hgnlgmh.kode').enable();
					edthgnlgmh.field('hgnlgmh.nama').enable();
				}else{
					edthgnlgmh.field('hgnlgmh.kode').disable();
					edthgnlgmh.field('hgnlgmh.nama').disable();
				}
			}
		});

		edthgnlgmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthgnlgmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthgnlgmh.field('hgnlgmh.kode').val();
				nama = edthgnlgmh.field('hgnlgmh.nama').val();

				validasiRequired(
					edthgnlgmh,
					'hgnlgmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthgnlgmh,
					'hgnlgmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hgnlgmh
				);

				validasiUnique(
					action,
					edthgnlgmh,
					'hgnlgmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hgnlgmh
				);
			}
			
			if ( edthgnlgmh.inError() ) {
				return false;
			}
		});
		
		edthgnlgmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthgnlgmh.field('hgnlgmh.finish_at').val(finish_at);
		});

		edthgnlgmh.on( 'close', function () {
			edthgnlgmh.enable();
		} );

		tblhgnlgmh = $('#tblhgnlgmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hgnlgmh/hgnlgmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hgnlgmh = show_deleted_hgnlgmh;
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
				{ data: "hgnlgmh.id",visible:false },
				{ data: "hgnlgmh.kode" },
				{ data: "hgnlgmh.nama" },
				{ data: "hgnlgmh.keterangan" },
				{ 
					data: "hgnlgmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hgnlgmh';
					$table       = 'tblhgnlgmh';
					$edt         = 'edthgnlgmh';
					$show_status = '_hgnlgmh';
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
				if ( data.hgnlgmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hgnlgmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhgnlgmh.searchPanes.container().appendTo('#sphgnlgmh');
		tblhgnlgmh.searchBuilder.container().appendTo( '#sbhgnlgmh' );
		
		tblhgnlgmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhgnlgmh);
		} );
		
		tblhgnlgmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hgnlgmh');

			// atur hak akses
			CekSelectHeaderH(tblhgnlgmh);
		} );

		tblhgnlgmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hgnlgmh');

			// atur hak akses
			CekDeselectHeaderH(tblhgnlgmh);
		} );

		// END hgnlgmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
