<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iigx2mh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliigx2mh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iigx2mh/fn/iigx2mh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiigx2mh, tbliigx2mh, show_deleted_iigx2mh = 0, id_iigx2mh;
	// ------------- end of default variable
	
	var id_iigxxmh_old = 0;

	// get tableRelation
	tableRelation('iigx2mh');

	$(document).ready(function() {
		
		// BEGIN iigx2mh
		edtiigx2mh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iigx2mh/iigx2mh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iigx2mh = show_deleted_iigx2mh;
				}
			},
			table: "#tbliigx2mh",
			formOptions: {
				main: {
					focus: 6,
				}
			},
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},
				{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},
				{
					label: "iigx2mh.start_at",
					name: "iigx2mh.start_at",
					type: "hidden"
				},	
				{
					label: "iigx2mh.finish_at",
					name: "iigx2mh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iigx2mh",
					type: "hidden"
				},	
				{
					label: "iigx2mh.transaction_state",
					name: "iigx2mh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "iigx2mh.nama"
				}, 	
				{
					label: "Item Group 1",
					name: "iigx2mh.id_iigxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iigxxmh/iigxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iigxxmh_old: id_iigxxmh_old,
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
					name: "iigx2mh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtiigx2mh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiigx2mh.field('iigx2mh.start_at').val(start_at);
			
			if(action == 'create'){
				tbliigx2mh.rows().deselect();

				edtiigx2mh.field('iigx2mh.nama').enable();

			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtiigx2mh.field('iigx2mh.nama').enable();

					edtiigx2mh.field('kategori_dokumen').val('');
					edtiigx2mh.field('kategori_dokumen_value').val('');
				}else{
					edtiigx2mh.field('iigx2mh.nama').disable();
				}
			}
		});

		edtiigx2mh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtiigx2mh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtiigx2mh.field('iigx2mh.nama').val();
				validasiRequired(
					edtiigx2mh,
					'iigx2mh',
					{
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtiigx2mh,
					'iigx2mh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_iigx2mh,
				);
			
			}
			
			if ( edtiigx2mh.inError() ) {
				return false;
			}
		});
		
		edtiigx2mh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiigx2mh.field('iigx2mh.finish_at').val(finish_at);
		});

		edtiigx2mh.on( 'close', function () {
			edtiigx2mh.enable();
		} );

		tbliigx2mh = $('#tbliigx2mh').DataTable( {
			ajax: {
				url: "../../models/iigx2mh/iigx2mh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iigx2mh = show_deleted_iigx2mh;
				}
			},
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "iigx2mh.id",visible:false },
				{ data: "iigx2mh.kode" },
				{ data: "iigx2mh.nama" },
				{ data: "iigx2mh.keterangan" },
				{ 
					data: "iigx2mh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iigx2mh';
					$table       = 'tbliigx2mh';
					$edt         = 'edtiigx2mh';
					$show_status = '_iigx2mh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.iigx2mh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iigx2mh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );
		
		tbliigx2mh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbliigx2mh);
		} );
		
		tbliigx2mh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iigx2mh');
			id_iigxxmh_old    = iigx2mh_data.id_iigxxmh;

			// atur hak akses
			CekSelectHeaderH(tbliigx2mh);
		} );

		tbliigx2mh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iigx2mh');
			id_iigxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tbliigx2mh);
		} );
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
