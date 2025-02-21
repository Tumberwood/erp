<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hfmxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhfmxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="name"></th>
                                <th data-i18n="Polarization"></th>
                                <th data-i18n="uom"></th>
                                <th data-i18n="Objective"></th>
                                <th data-i18n="group"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hfmxxmh/fn/hfmxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthfmxxmh, tblhfmxxmh, show_deleted_hfmxxmh = 0, id_hfmxxmh;
	var id_hfoxxmh_old = 0, id_hfogrmh_old = 0, id_iumxxmh_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hfmxxmh');

	$(document).ready(function() {
		// BEGIN hfmxxmh
		edthfmxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hfmxxmh/hfmxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfmxxmh = show_deleted_hfmxxmh;
				}
			},
			table: "#tblhfmxxmh",
			fields: [ 
				{
					label: "hfmxxmh.start_at",
					name: "hfmxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hfmxxmh.finish_at",
					name: "hfmxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hfmxxmh",
					type: "hidden"
				},	
				{
					label: "hfmxxmh.transaction_state",
					name: "hfmxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hfmxxmh.nama"
				}, 	
				{
					label: 'Objective <sup class="text-danger">*<sup>',
					name: "hfmxxmh.id_hfoxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfoxxmh/hfoxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfoxxmh_old: id_hfoxxmh_old,
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
					label: getTranslation('uom') + " <sup class='text-danger'>*<sup>',",
					name: "hfmxxmh.id_iumxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_old,
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
					label: getTranslation('group'),
					name: "hfmxxmh.id_hfogrmh",
					type: "select2",
					opts: {
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hfogrmh/hfogrmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hfogrmh_old: id_hfogrmh_old,
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
					label: "Polarization <sup class='text-danger'>*<sup>", 
					name: "hfmxxmh.polarisasi",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Min", "value": "Min" },
						{ "label": "Max", "value": "Max" }
					]
				},
				{
					label: getTranslation('notes'),
					name: "hfmxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthfmxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfmxxmh.field('hfmxxmh.start_at').val(start_at);
			edthfmxxmh.field('hfmxxmh.id_hfogrmh').disable();
			
			if(action == 'create'){
				tblhfmxxmh.rows().deselect();
				edthfmxxmh.field('hfmxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthfmxxmh.field('hfmxxmh.nama').enable();
				}else{
					edthfmxxmh.field('hfmxxmh.nama').disable();
				}
			}
		});

		edthfmxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthfmxxmh.dependent( 'hfmxxmh.id_hfoxxmh', function ( val, data, callback ) {
			if (val > 0) {
				autofillField('hfoxxmh', val, 'id_hfogrmh');
				id_hfogrmh_old = autofillData.id_hfogrmh;
				edthfmxxmh.field('hfmxxmh.id_hfogrmh').val(id_hfogrmh_old);
			}
			return {}
		}, {event: 'keyup change'});

		edthfmxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				polarisasi = edthfmxxmh.field('hfmxxmh.polarisasi').val();
				nama = edthfmxxmh.field('hfmxxmh.nama').val();
				id_hfoxxmh = edthfmxxmh.field('hfmxxmh.id_hfoxxmh').val();
				id_iumxxmh = edthfmxxmh.field('hfmxxmh.id_iumxxmh').val();

				validasiRequired(
					edthfmxxmh,
					'hfmxxmh',
					{
						'polarisasi': polarisasi,
						'nama': nama,
						'id_hfoxxmh': id_hfoxxmh,
						'id_iumxxmh': id_iumxxmh,
					}
				);

				validasiUnique(
					action,
					edthfmxxmh,
					'hfmxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hfmxxmh
				);
			}
			
			if ( edthfmxxmh.inError() ) {
				return false;
			}
		});
		
		edthfmxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthfmxxmh.field('hfmxxmh.finish_at').val(finish_at);
		});

		edthfmxxmh.on( 'close', function () {
			edthfmxxmh.enable();
		} );

		tblhfmxxmh = $('#tblhfmxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hfmxxmh/hfmxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hfmxxmh = show_deleted_hfmxxmh;
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
				{ data: "hfmxxmh.id",visible:false },
				{ data: "hfmxxmh.nama" },
				{ 
					data: "hfmxxmh.polarisasi",
					render: function (data, type, row, meta) {
						if (data.toLowerCase() === 'max') {
							return '<span class="badge bg-primary"><i class="fa fa-arrow-up"></i> MAX</span>';
						}
						else {
							return '<span class="badge bg-danger"><i class="fa fa-arrow-down"></i> MIN</span>';
						}
					}
				},

				{ data: "iumxxmh.kode" },
				{ data: "hfoxxmh.nama" },
				{ 
					data: "hfogrmh.nama",
					render: function (data, type, row, meta) {
						return '<span class="badge badge-plain" style="color: white; background-color: ' + row.hfogrmh.color + ';">' + data + '</span>';
					}
				},
				{ 
					data: "hfmxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hfmxxmh';
					$table       = 'tblhfmxxmh';
					$edt         = 'edthfmxxmh';
					$show_status = '_hfmxxmh';
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
				if ( data.hfmxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hfmxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhfmxxmh.searchPanes.container().appendTo('#sphfmxxmh');
		tblhfmxxmh.searchBuilder.container().appendTo( '#sbhfmxxmh' );
		
		tblhfmxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhfmxxmh);
		} );
		
		tblhfmxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hfmxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhfmxxmh);
		} );

		tblhfmxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hfmxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhfmxxmh);
		} );

		// END hfmxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
