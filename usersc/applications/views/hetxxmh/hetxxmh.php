<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hetxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhetxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hetxxmh/fn/hetxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthetxxmh, tblhetxxmh, show_deleted_hetxxmh = 0, id_hetxxmh;
	// ------------- end of default variable
	
	var id_hevxxmh_old = 0;

	// get tableRelation
	tableRelation('hetxxmh');

	$(document).ready(function() {
		// BEGIN hetxxmh
		edthetxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hetxxmh/hetxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hetxxmh = show_deleted_hetxxmh;
				}
			},
			table: "#tblhetxxmh",
			fields: [ 
				{
					label: "hetxxmh.start_at",
					name: "hetxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hetxxmh.finish_at",
					name: "hetxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hetxxmh",
					type: "hidden"
				},	
				{
					label: "hetxxmh.transaction_state",
					name: "hetxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hetxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hetxxmh.nama"
				}, 	
				{
					label: "Level",
					name: "hetxxmh.id_hevxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hevxxmh/hevxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hevxxmh_old: id_hevxxmh_old,
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
					label: "Keterangan",
					name: "hetxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthetxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthetxxmh.field('hetxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhetxxmh.rows().deselect();
				edthetxxmh.field('hetxxmh.kode').enable();
				edthetxxmh.field('hetxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthetxxmh.field('hetxxmh.kode').enable();
					edthetxxmh.field('hetxxmh.nama').enable();
				}else{
					edthetxxmh.field('hetxxmh.kode').disable();
					edthetxxmh.field('hetxxmh.nama').disable();
				}
			}
		});

		edthetxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthetxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthetxxmh.field('hetxxmh.kode').val();
				nama = edthetxxmh.field('hetxxmh.nama').val();

				validasiRequired(
					edthetxxmh,
					'hetxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthetxxmh,
					'hetxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hetxxmh
				);

				validasiUnique(
					action,
					edthetxxmh,
					'hetxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hetxxmh
				);
			}
			
			if ( edthetxxmh.inError() ) {
				return false;
			}
		});
		
		edthetxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthetxxmh.field('hetxxmh.finish_at').val(finish_at);
		});

		edthetxxmh.on( 'close', function () {
			edthetxxmh.enable();
		} );

		tblhetxxmh = $('#tblhetxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hetxxmh/hetxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hetxxmh = show_deleted_hetxxmh;
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
				{ data: "hetxxmh.id",visible:false },
				{ data: "hetxxmh.kode" },
				{ data: "hetxxmh.nama" },
				{ 
					data: "hetxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hetxxmh';
					$table       = 'tblhetxxmh';
					$edt         = 'edthetxxmh';
					$show_status = '_hetxxmh';
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
				if ( data.hetxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hetxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhetxxmh.searchPanes.container().appendTo('#sphetxxmh');
		tblhetxxmh.searchBuilder.container().appendTo( '#sbhetxxmh' );
		
		tblhetxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhetxxmh);
		} );
		
		tblhetxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hetxxmh');
			id_hevxxmh_old 		= hetxxmh_data.id_hevxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhetxxmh);
		} );

		tblhetxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hetxxmh');
			id_hevxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhetxxmh);
		} );

		// END hetxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
