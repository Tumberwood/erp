<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hactpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhactpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hactpmh/fn/hactpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthactpmh, tblhactpmh, show_deleted_hactpmh = 0, id_hactpmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hactpmh');

	$(document).ready(function() {
		// BEGIN hactpmh
		edthactpmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hactpmh/hactpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hactpmh = show_deleted_hactpmh;
				}
			},
			table: "#tblhactpmh",
			fields: [ 
				{
					label: "hactpmh.start_at",
					name: "hactpmh.start_at",
					type: "hidden"
				},	
				{
					label: "hactpmh.finish_at",
					name: "hactpmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hactpmh",
					type: "hidden"
				},	
				{
					label: "hactpmh.transaction_state",
					name: "hactpmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "hactpmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hactpmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hactpmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthactpmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthactpmh.field('hactpmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhactpmh.rows().deselect();
				edthactpmh.field('hactpmh.kode').enable();
				edthactpmh.field('hactpmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthactpmh.field('hactpmh.kode').enable();
					edthactpmh.field('hactpmh.nama').enable();
				}else{
					edthactpmh.field('hactpmh.kode').disable();
					edthactpmh.field('hactpmh.nama').disable();
				}
			}
		});

		edthactpmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthactpmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthactpmh.field('hactpmh.kode').val();
				nama = edthactpmh.field('hactpmh.nama').val();

				validasiRequired(
					edthactpmh,
					'hactpmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthactpmh,
					'hactpmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hactpmh
				);

				validasiUnique(
					action,
					edthactpmh,
					'hactpmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hactpmh
				);
			}
			
			if ( edthactpmh.inError() ) {
				return false;
			}
		});
		
		edthactpmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthactpmh.field('hactpmh.finish_at').val(finish_at);
		});

		edthactpmh.on( 'close', function () {
			edthactpmh.enable();
		} );

		tblhactpmh = $('#tblhactpmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hactpmh/hactpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hactpmh = show_deleted_hactpmh;
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
				{ data: "hactpmh.id",visible:false },
				{ data: "hactpmh.kode" },
				{ data: "hactpmh.nama" },
				{ 
					data: "hactpmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hactpmh';
					$table       = 'tblhactpmh';
					$edt         = 'edthactpmh';
					$show_status = '_hactpmh';
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
				if ( data.hactpmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hactpmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhactpmh.searchPanes.container().appendTo('#sphactpmh');
		tblhactpmh.searchBuilder.container().appendTo( '#sbhactpmh' );
		
		tblhactpmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhactpmh);
		} );
		
		tblhactpmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hactpmh');

			// atur hak akses
			CekSelectHeaderH(tblhactpmh);
		} );

		tblhactpmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hactpmh');

			// atur hak akses
			CekDeselectHeaderH(tblhactpmh);
		} );

		// END hactpmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
