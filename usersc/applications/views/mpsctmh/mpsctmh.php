<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'mpsctmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblmpsctmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="notes"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/mpsctmh/fn/mpsctmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtmpsctmh, tblmpsctmh, show_deleted_mpsctmh = 0, id_mpsctmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('mpsctmh');

	$(document).ready(function() {
		// BEGIN mpsctmh
		edtmpsctmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/mpsctmh/mpsctmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_mpsctmh = show_deleted_mpsctmh;
				}
			},
			table: "#tblmpsctmh",
			fields: [ 
				{
					label: "mpsctmh.start_at",
					name: "mpsctmh.start_at",
					type: "hidden"
				},	
				{
					label: "mpsctmh.finish_at",
					name: "mpsctmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "mpsctmh",
					type: "hidden"
				},	
				{
					label: "mpsctmh.transaction_state",
					name: "mpsctmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "mpsctmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "mpsctmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "mpsctmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtmpsctmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmpsctmh.field('mpsctmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblmpsctmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtmpsctmh.field('mpsctmh.kode').enable();
					edtmpsctmh.field('mpsctmh.nama').enable();
				}else{
					edtmpsctmh.field('mpsctmh.kode').disable();
					edtmpsctmh.field('mpsctmh.nama').disable();
				}
			}
		});

		edtmpsctmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtmpsctmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtmpsctmh.field('mpsctmh.kode').val();
				nama = edtmpsctmh.field('mpsctmh.nama').val();

				validasiRequired(
					edtmpsctmh,
					'mpsctmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtmpsctmh,
					'mpsctmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_mpsctmh
				);

				validasiUnique(
					action,
					edtmpsctmh,
					'mpsctmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_mpsctmh
				);
			}
			
			if ( edtmpsctmh.inError() ) {
				return false;
			}
		});
		
		edtmpsctmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmpsctmh.field('mpsctmh.finish_at').val(finish_at);
		});

		edtmpsctmh.on( 'close', function () {
			edtmpsctmh.enable();
		} );

		tblmpsctmh = $('#tblmpsctmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/mpsctmh/mpsctmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_mpsctmh = show_deleted_mpsctmh;
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
				{ data: "mpsctmh.id",visible:false },
				{ data: "mpsctmh.kode" },
				{ data: "mpsctmh.nama" },
				{ data: "mpsctmh.keterangan" },
				{ 
					data: "mpsctmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_mpsctmh';
					$table       = 'tblmpsctmh';
					$edt         = 'edtmpsctmh';
					$show_status = '_mpsctmh';
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
				if ( data.mpsctmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.mpsctmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblmpsctmh.searchPanes.container().appendTo('#spmpsctmh');
		tblmpsctmh.searchBuilder.container().appendTo( '#sbmpsctmh' );
		
		tblmpsctmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblmpsctmh);
		} );
		
		tblmpsctmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('mpsctmh');
			// atur hak akses
			CekSelectHeaderH(tblmpsctmh);
		} );

		tblmpsctmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('mpsctmh');

			// atur hak akses
			CekDeselectHeaderH(tblmpsctmh);
		} );

		// END mpsctmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
