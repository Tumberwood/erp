<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'heyxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblheyxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/heyxxmh/fn/heyxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtheyxxmh, tblheyxxmh, show_deleted_heyxxmh = 0, id_heyxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('heyxxmh');

	$(document).ready(function() {
		// BEGIN heyxxmh
		edtheyxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/heyxxmh/heyxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_heyxxmh = show_deleted_heyxxmh;
				}
			},
			table: "#tblheyxxmh",
			fields: [ 
				{
					label: "heyxxmh.start_at",
					name: "heyxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "heyxxmh.finish_at",
					name: "heyxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "heyxxmh",
					type: "hidden"
				},	
				{
					label: "heyxxmh.transaction_state",
					name: "heyxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "heyxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "heyxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "heyxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtheyxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtheyxxmh.field('heyxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblheyxxmh.rows().deselect();
				edtheyxxmh.field('heyxxmh.kode').enable();
				edtheyxxmh.field('heyxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtheyxxmh.field('heyxxmh.kode').enable();
					edtheyxxmh.field('heyxxmh.nama').enable();
				}else{
					edtheyxxmh.field('heyxxmh.kode').disable();
					edtheyxxmh.field('heyxxmh.nama').disable();
				}
			}
		});

		edtheyxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtheyxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtheyxxmh.field('heyxxmh.kode').val();
				nama = edtheyxxmh.field('heyxxmh.nama').val();

				validasiRequired(
					edtheyxxmh,
					'heyxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtheyxxmh,
					'heyxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_heyxxmh
				);

				validasiUnique(
					action,
					edtheyxxmh,
					'heyxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_heyxxmh
				);
			}
			
			if ( edtheyxxmh.inError() ) {
				return false;
			}
		});
		
		edtheyxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtheyxxmh.field('heyxxmh.finish_at').val(finish_at);
		});

		edtheyxxmh.on( 'close', function () {
			edtheyxxmh.enable();
		} );

		tblheyxxmh = $('#tblheyxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/heyxxmh/heyxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_heyxxmh = show_deleted_heyxxmh;
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
				{ data: "heyxxmh.id",visible:false },
				{ data: "heyxxmh.kode" },
				{ data: "heyxxmh.nama" },
				{ 
					data: "heyxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_heyxxmh';
					$table       = 'tblheyxxmh';
					$edt         = 'edtheyxxmh';
					$show_status = '_heyxxmh';
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
				if ( data.heyxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.heyxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblheyxxmh.searchPanes.container().appendTo('#spheyxxmh');
		tblheyxxmh.searchBuilder.container().appendTo( '#sbheyxxmh' );
		
		tblheyxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblheyxxmh);
		} );
		
		tblheyxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('heyxxmh');

			// atur hak akses
			CekSelectHeaderH(tblheyxxmh);
		} );

		tblheyxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('heyxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblheyxxmh);
		} );

		// END heyxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
