<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gtxpkmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgtxpkmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="amount"></th>
                                <th data-i18n="Kategori Kelas"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gtxpkmh/fn/gtxpkmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtgtxpkmh, tblgtxpkmh, show_deleted_gtxpkmh = 0, id_gtxpkmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('gtxpkmh');

	$(document).ready(function() {
		// BEGIN gtxpkmh
		edtgtxpkmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/gtxpkmh/gtxpkmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gtxpkmh = show_deleted_gtxpkmh;
				}
			},
			table: "#tblgtxpkmh",
			fields: [ 
				{
					label: "gtxpkmh.start_at",
					name: "gtxpkmh.start_at",
					type: "hidden"
				},	
				{
					label: "gtxpkmh.finish_at",
					name: "gtxpkmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "gtxpkmh",
					type: "hidden"
				},	
				{
					label: "gtxpkmh.transaction_state",
					name: "gtxpkmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "gtxpkmh.kode"
				}, 	
				{
					label: getTranslation('amount') + "<sup class='text-danger'>*<sup>",
					name: "gtxpkmh.amount"
				}, 	
				{
					label: getTranslation('Kategori Kelas') + "<sup class='text-danger'>*<sup>",
					name: "gtxpkmh.kategori_kelas"
				}, 	
				{
					label: getTranslation('notes'),
					name: "gtxpkmh.keterangan",
					type: "textarea"
				}
			]
		} );

		//masking
		unmaskedData = maskingNumber(
			edtgtxpkmh, 
			"gtxpkmh", 
			[
				"amount", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>' // val >= 0
		);
		edtgtxpkmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgtxpkmh.field('gtxpkmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblgtxpkmh.rows().deselect();
				edtgtxpkmh.field('gtxpkmh.kode').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtgtxpkmh.field('gtxpkmh.kode').enable();
				}else{
					edtgtxpkmh.field('gtxpkmh.kode').disable();
				}
			}
		});

		edtgtxpkmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtgtxpkmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtgtxpkmh.field('gtxpkmh.kode').val();
				kategori_kelas = edtgtxpkmh.field('gtxpkmh.kategori_kelas').val();

				validasiRequired(
					edtgtxpkmh,
					'gtxpkmh',
					{
						'kode': kode,
						'kategori_kelas': kategori_kelas,
					}
				);

				validasiUnique(
					action,
					edtgtxpkmh,
					'gtxpkmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_gtxpkmh
				);
			}
			
			if ( edtgtxpkmh.inError() ) {
				return false;
			}
		});
		
		edtgtxpkmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtgtxpkmh.field('gtxpkmh.finish_at').val(finish_at);
		});

		edtgtxpkmh.on( 'close', function () {
			edtgtxpkmh.enable();
		} );

		tblgtxpkmh = $('#tblgtxpkmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/gtxpkmh/gtxpkmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_gtxpkmh = show_deleted_gtxpkmh;
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
				{ data: "gtxpkmh.id",visible:false },
				{ data: "gtxpkmh.kode" },
				{ data: "gtxpkmh.amount",...renderNumber() },
				{ data: "gtxpkmh.kategori_kelas" },
				{ 
					data: "gtxpkmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_gtxpkmh';
					$table       = 'tblgtxpkmh';
					$edt         = 'edtgtxpkmh';
					$show_status = '_gtxpkmh';
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
				if ( data.gtxpkmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.gtxpkmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblgtxpkmh.searchPanes.container().appendTo('#spgtxpkmh');
		tblgtxpkmh.searchBuilder.container().appendTo( '#sbgtxpkmh' );
		
		tblgtxpkmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblgtxpkmh);
		} );
		
		tblgtxpkmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('gtxpkmh');

			// atur hak akses
			CekSelectHeaderH(tblgtxpkmh);
		} );

		tblgtxpkmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('gtxpkmh');

			// atur hak akses
			CekDeselectHeaderH(tblgtxpkmh);
		} );

		// END gtxpkmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
