<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hodxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhodxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="department"></th>
                                <th data-i18n="division"></th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hodxxmh/fn/hodxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthodxxmh, tblhodxxmh, show_deleted_hodxxmh = 0, id_hodxxmh;
	// ------------- end of default variable

	var id_hovxxmh_old = 0;

	// get tableRelation
	tableRelation('hodxxmh');

	$(document).ready(function() {
		// BEGIN hodxxmh
		edthodxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hodxxmh/hodxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hodxxmh = show_deleted_hodxxmh;
				}
			},
			table: "#tblhodxxmh",
			fields: [ 
				{
					label: "hodxxmh.start_at",
					name: "hodxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hodxxmh.finish_at",
					name: "hodxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hodxxmh",
					type: "hidden"
				},	
				{
					label: "hodxxmh.transaction_state",
					name: "hodxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "hodxxmh.kode"
				}, 	
				{
					label: getTranslation('department') + " <sup class='text-danger'>*<sup>",
					name: "hodxxmh.nama"
				},
				{
					label: getTranslation('division') + " <sup class='text-danger'>*<sup>" ,
					name: "hodxxmh.id_hovxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hovxxmh/hovxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hovxxmh_old: id_hovxxmh_old,
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
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: getTranslation('notes'),
					name: "hodxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthodxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthodxxmh.field('hodxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhodxxmh.rows().deselect();
				edthodxxmh.field('hodxxmh.kode').enable();
				edthodxxmh.field('hodxxmh.nama').enable();
			}else if(action == 'edit'){
				edthodxxmh.field('hodxxmh.kode').disable();
				edthodxxmh.field('hodxxmh.nama').disable();

			}
		});

		edthodxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthodxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthodxxmh.field('hodxxmh.kode').val();
				nama = edthodxxmh.field('hodxxmh.nama').val();
				id_hovxxmh = edthodxxmh.field('hodxxmh.id_hovxxmh').val();

				validasiRequired(
					edthodxxmh,
					'hodxxmh',
					{
						'kode': kode,
						'nama': nama,
						'id_hovxxmh': id_hovxxmh
					}
				);
				
				validasiUnique(
					action,
					edthodxxmh,
					'hodxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hodxxmh
				);

				validasiUnique(
					action,
					edthodxxmh,
					'hodxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hodxxmh
				);
			}
			
			if ( edthodxxmh.inError() ) {
				return false;
			}
		});
		
		edthodxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthodxxmh.field('hodxxmh.finish_at').val(finish_at);
		});

		edthodxxmh.on( 'close', function () {
			edthodxxmh.enable();
		} );

		tblhodxxmh = $('#tblhodxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hodxxmh/hodxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hodxxmh = show_deleted_hodxxmh;
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
					targets: [0, 4]
				}
			],
			columns: [
				{ data: "hodxxmh.id",visible:false },
				{ data: "hodxxmh.kode" , type: 'string'},
				{ data: "hodxxmh.nama" },
				{ data: "hovxxmh.nama" },
				{ 
					data: "hodxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hodxxmh';
					$table       = 'tblhodxxmh';
					$edt         = 'edthodxxmh';
					$show_status = '_hodxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis','upload'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hodxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hodxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhodxxmh.searchPanes.container().appendTo('#sphodxxmh');
		tblhodxxmh.searchBuilder.container().appendTo( '#sbhodxxmh' );
		
		tblhodxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhodxxmh);
		} );
		
		tblhodxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hodxxmh');
			
			id_hovxxmh_old = hodxxmh_data.id_hovxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhodxxmh);
		} );

		tblhodxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hodxxmh');
			id_hovxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhodxxmh);
		} );

		// END hodxxmh
		uploadMaster('hodxxmh', tblhodxxmh, 'files/template_file_upload/Master Department.xlsx');
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
