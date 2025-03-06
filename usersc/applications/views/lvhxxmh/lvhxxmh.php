<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'lvhxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbllvhxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="Vehicle Type"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/lvhxxmh/fn/lvhxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtlvhxxmh, tbllvhxxmh, show_deleted_lvhxxmh = 0, id_lvhxxmh;
	var id_lvtxxmh_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('lvhxxmh');

	$(document).ready(function() {
		// BEGIN lvhxxmh
		edtlvhxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lvhxxmh/lvhxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lvhxxmh = show_deleted_lvhxxmh;
				}
			},
			table: "#tbllvhxxmh",
			fields: [ 
				{
					label: "lvhxxmh.start_at",
					name: "lvhxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "lvhxxmh.finish_at",
					name: "lvhxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "lvhxxmh",
					type: "hidden"
				},	
				{
					label: "lvhxxmh.transaction_state",
					name: "lvhxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "lvhxxmh.kode"
				}, 	
				{
					label: "Vehicle Type <sup class='text-danger'>*<sup>",
					name: "lvhxxmh.id_lvtxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lvtxxmh/lvtxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_lvtxxmh_old: id_lvtxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
								return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1
						}
					}
				},	
				{
					label: getTranslation('notes'),
					name: "lvhxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtlvhxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlvhxxmh.field('lvhxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbllvhxxmh.rows().deselect();
				edtlvhxxmh.field('lvhxxmh.kode').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtlvhxxmh.field('lvhxxmh.kode').enable();
				}else{
					edtlvhxxmh.field('lvhxxmh.kode').disable();
				}
			}
		});

		edtlvhxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtlvhxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtlvhxxmh.field('lvhxxmh.kode').val();
				id_lvtxxmh = edtlvhxxmh.field('lvhxxmh.id_lvtxxmh').val();

				validasiRequired(
					edtlvhxxmh,
					'lvhxxmh',
					{
						'kode': kode,
						'id_lvtxxmh': id_lvtxxmh,
					}
				);

				validasiUnique(
					action,
					edtlvhxxmh,
					'lvhxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_lvhxxmh
				);
			}
			
			if ( edtlvhxxmh.inError() ) {
				return false;
			}
		});
		
		edtlvhxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlvhxxmh.field('lvhxxmh.finish_at').val(finish_at);
		});

		edtlvhxxmh.on( 'close', function () {
			edtlvhxxmh.enable();
		} );

		tbllvhxxmh = $('#tbllvhxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lvhxxmh/lvhxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lvhxxmh = show_deleted_lvhxxmh;
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
				{ data: "lvhxxmh.id",visible:false },
				{ data: "lvhxxmh.kode" },
				{ data: "lvtxxmh.nama" },
				{ 
					data: "lvhxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_lvhxxmh';
					$table       = 'tbllvhxxmh';
					$edt         = 'edtlvhxxmh';
					$show_status = '_lvhxxmh';
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
				if ( data.lvhxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.lvhxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbllvhxxmh.searchPanes.container().appendTo('#splvhxxmh');
		tbllvhxxmh.searchBuilder.container().appendTo( '#sblvhxxmh' );
		
		tbllvhxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbllvhxxmh);
		} );
		
		tbllvhxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('lvhxxmh');

			// atur hak akses
			CekSelectHeaderH(tbllvhxxmh);
		} );

		tbllvhxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('lvhxxmh');

			// atur hak akses
			CekDeselectHeaderH(tbllvhxxmh);
		} );

		// END lvhxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
