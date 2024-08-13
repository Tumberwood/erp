<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'imtxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblimtxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th data-i18n="code"></th>
								<th data-i18n="movementType"></th>
								<th data-i18n="module"></th>
								<th data-i18n="type"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/imtxxmh/fn/imtxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtimtxxmh, tblimtxxmh, show_deleted_imtxxmh = 0, id_imtxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('imtxxmh');

	$(document).ready(function() {
		// BEGIN imtxxmh
		edtimtxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/imtxxmh/imtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_imtxxmh = show_deleted_imtxxmh;
				}
			},
			table: "#tblimtxxmh",
			fields: [ 
				{
					label: "imtxxmh.start_at",
					name: "imtxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "imtxxmh.finish_at",
					name: "imtxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "imtxxmh",
					type: "hidden"
				},	
				{
					label: "imtxxmh.transaction_state",
					name: "imtxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "imtxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " class='text-danger'>*<sup>",
					name: "imtxxmh.movement_type"
				},
				{
					label: getTranslation('type') + " <sup class='text-danger'>*<sup>",
					name: "imtxxmh.movement_type_group",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "GR", "value": "GR" },
						{ "label": "GI", "value": "GI" },
						{ "label": "GT", "value": "GT" }
					]
				},
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "imtxxmh.nama"
				},
				{
					label: getTranslation('module') + " <sup class='text-danger'>*<sup>",
					name: "imtxxmh.module",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "WMS", "value": "WMS" },
						{ "label": "ERP", "value": "ERP" },
						{ "label": "SIG", "value": "SIG" }
					]
				},
				{
					label: getTranslation('notes'),
					name: "imtxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtimtxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtimtxxmh.field('imtxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblimtxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtimtxxmh.field('imtxxmh.kode').enable();
					edtimtxxmh.field('imtxxmh.nama').enable();
				}else{
					edtimtxxmh.field('imtxxmh.kode').disable();
					edtimtxxmh.field('imtxxmh.nama').disable();
				}
			}
		});

		edtimtxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtimtxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtimtxxmh.field('imtxxmh.kode').val();
				movement_type = edtimtxxmh.field('imtxxmh.movement_type').val();
				module = edtimtxxmh.field('imtxxmh.module').val();

				validasiRequired(
					edtimtxxmh,
					'imtxxmh',
					{
						'kode': kode,
						'movement_type': movement_type,
						'module': module
					}
				);

				validasiUnique(
					action,
					edtimtxxmh,
					'imtxxmh',
					'kode.module',
					'kode,module',
					'"'+kode+','+module+'"',
					id_imtxxmh
				);

			}
			
			if ( edtimtxxmh.inError() ) {
				return false;
			}
		});
		
		edtimtxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtimtxxmh.field('imtxxmh.finish_at').val(finish_at);
		});

		edtimtxxmh.on( 'close', function () {
			edtimtxxmh.enable();
		} );

		tblimtxxmh = $('#tblimtxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/imtxxmh/imtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_imtxxmh = show_deleted_imtxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "imtxxmh.id",visible:false },
				{ data: "imtxxmh.kode" },
				{ data: "imtxxmh.movement_type" },
				{ data: "imtxxmh.module" },
				{ data: "imtxxmh.movement_type_group" },
				{ data: "imtxxmh.keterangan" },
				{ 
					data: "imtxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_imtxxmh';
					$table       = 'tblimtxxmh';
					$edt         = 'edtimtxxmh';
					$show_status = '_imtxxmh';
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
				if ( data.imtxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.imtxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblimtxxmh.searchPanes.container().appendTo('#spimtxxmh');
		tblimtxxmh.searchBuilder.container().appendTo( '#sbimtxxmh' );
		
		tblimtxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblimtxxmh);
		} );
		
		tblimtxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('imtxxmh');
			// atur hak akses
			CekSelectHeaderH(tblimtxxmh);
		} );

		tblimtxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('imtxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblimtxxmh);
		} );

		// END imtxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
