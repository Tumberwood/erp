<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ittxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblittxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th>Movement Type</th>
                                <th>Jenis</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ittxxmh/fn/ittxxmh_fn.php'; ?>


<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtittxxmh, tblittxxmh, show_deleted_ittxxmh = 0, id_ittxxmh;
	// ------------- end of default variable
	var imtxxmh_kode_old = 0;

	// get tableRelation
	tableRelation('ittxxmh');
	
	$(document).ready(function() {

		// BEGIN ittxxmh
		edtittxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ittxxmh/ittxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ittxxmh = show_deleted_ittxxmh;
				}
			},
			table: "#tblittxxmh",
			fields: [ 
				{
					label: "ittxxmh.start_at",
					name: "ittxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "ittxxmh.finish_at",
					name: "ittxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ittxxmh",
					type: "hidden"
				},	
				{
					label: "ittxxmh.transaction_state",
					name: "ittxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	{
					label: "Movement Type <sup class='text-danger'>*<sup>",
					name: "ittxxmh.imtxxmh_kode",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/imtxxmh/imtxxmh_fn_opt_kode.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									imtxxmh_kode_old: imtxxmh_kode_old,
									module: 'SIG',
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
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "ittxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "ittxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "ittxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtittxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtittxxmh.field('ittxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblittxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtittxxmh.field('ittxxmh.kode').enable();
					edtittxxmh.field('ittxxmh.nama').enable();
				}else{
					edtittxxmh.field('ittxxmh.kode').disable();
					edtittxxmh.field('ittxxmh.nama').disable();
				}
			}
			
		});

		edtittxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtittxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				kode = edtittxxmh.field('ittxxmh.kode').val();
				nama = edtittxxmh.field('ittxxmh.nama').val();
				imtxxmh_kode = edtittxxmh.field('ittxxmh.imtxxmh_kode').val();

				validasiRequired(
					edtittxxmh,
					'ittxxmh',
					{
						'kode': kode,
						'nama': nama,
						'imtxxmh_kode': imtxxmh_kode

					}
				);

				validasiUnique(
					action,
					edtittxxmh,
					'ittxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_ittxxmh
				);

				validasiUnique(
					action,
					edtittxxmh,
					'ittxxmh',
					'name',
					'name',
					'"'+name+'"',
					id_ittxxmh
				);

			}
			
			if ( edtittxxmh.inError() ) {
				return false;
			}
		});
		
		edtittxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtittxxmh.field('ittxxmh.finish_at').val(finish_at);
		});

		edtittxxmh.on( 'close', function () {
			edtittxxmh.enable();
		} );

		tblittxxmh = $('#tblittxxmh').DataTable( {
			ajax: {
				url: "../../models/ittxxmh/ittxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ittxxmh = show_deleted_ittxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "ittxxmh.id",visible:false },
				{ data: "ittxxmh.kode" },
				{ data: "ittxxmh.nama" },
				{ data: "imtxxmh.nama" },
				{ 
					data: "imtxxmh.movement_type_group" ,
					render: function (data){
							if(data == 1){
								return 'Goods Receive';
							}else if(data == 2){
								return 'Goods Issue';
							}else if(data == 3){
								return 'Goods Transfer';
							}else{
								return '<span class="badge badge-warning">INVALID</span>';
							}
						}

				},
				{ 
					data: "ittxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ittxxmh';
					$table       = 'tblittxxmh';
					$edt         = 'edtittxxmh';
					$show_status = '_ittxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
				if ( data.ittxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ittxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );
		
		tblittxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblittxxmh);
		} );
		
		tblittxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ittxxmh');
			imtxxmh_old = ittxxmh_data.imtxxmh;

			// atur hak akses
			CekSelectHeaderH(tblittxxmh);
		} );

		tblittxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ittxxmh');
			imtxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblittxxmh);
		} );

		// END ittxxmh
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
