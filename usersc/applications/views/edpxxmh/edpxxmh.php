<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'edpxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbledpxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/edpxxmh/fn/edpxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtedpxxmh, tbledpxxmh, show_deleted_edpxxmh = 0, id_edpxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('edpxxmh');

	$(document).ready(function() {
		// BEGIN edpxxmh
		edtedpxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/edpxxmh/edpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_edpxxmh = show_deleted_edpxxmh;
				}
			},
			table: "#tbledpxxmh",
			fields: [ 
				{
					label: "edpxxmh.start_at",
					name: "edpxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "edpxxmh.finish_at",
					name: "edpxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "edpxxmh",
					type: "hidden"
				},	
				{
					label: "edpxxmh.transaction_state",
					name: "edpxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "edpxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "edpxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "edpxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtedpxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtedpxxmh.field('edpxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbledpxxmh.rows().deselect();
				edtedpxxmh.field('edpxxmh.kode').enable();
				edtedpxxmh.field('edpxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtedpxxmh.field('edpxxmh.kode').enable();
					edtedpxxmh.field('edpxxmh.nama').enable();
				}else{
					edtedpxxmh.field('edpxxmh.kode').disable();
					edtedpxxmh.field('edpxxmh.nama').disable();
				}
			}
		});

		edtedpxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtedpxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtedpxxmh.field('edpxxmh.kode').val();
				nama = edtedpxxmh.field('edpxxmh.nama').val();

				validasiRequired(
					edtedpxxmh,
					'edpxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtedpxxmh,
					'edpxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_edpxxmh
				);

				validasiUnique(
					action,
					edtedpxxmh,
					'edpxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_edpxxmh
				);
			}
			
			if ( edtedpxxmh.inError() ) {
				return false;
			}
		});
		
		edtedpxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtedpxxmh.field('edpxxmh.finish_at').val(finish_at);
		});

		edtedpxxmh.on( 'close', function () {
			edtedpxxmh.enable();
		} );

		tbledpxxmh = $('#tbledpxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/edpxxmh/edpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_edpxxmh = show_deleted_edpxxmh;
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
				{ data: "edpxxmh.id",visible:false },
				{ data: "edpxxmh.kode" },
				{ data: "edpxxmh.nama" },
				{ 
					data: "edpxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_edpxxmh';
					$table       = 'tbledpxxmh';
					$edt         = 'edtedpxxmh';
					$show_status = '_edpxxmh';
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
				if ( data.edpxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.edpxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbledpxxmh.searchPanes.container().appendTo('#spedpxxmh');
		tbledpxxmh.searchBuilder.container().appendTo( '#sbedpxxmh' );
		
		tbledpxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbledpxxmh);
		} );
		
		tbledpxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('edpxxmh');

			// atur hak akses
			CekSelectHeaderH(tbledpxxmh);
		} );

		tbledpxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('edpxxmh');

			// atur hak akses
			CekDeselectHeaderH(tbledpxxmh);
		} );

		// END edpxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
