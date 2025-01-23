<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'aatxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblaatxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/aatxxmh/fn/aatxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtaatxxmh, tblaatxxmh, show_deleted_aatxxmh = 0, id_aatxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('aatxxmh');

	$(document).ready(function() {
		// BEGIN aatxxmh
		edtaatxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/aatxxmh/aatxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aatxxmh = show_deleted_aatxxmh;
				}
			},
			table: "#tblaatxxmh",
			fields: [ 
				{
					label: "aatxxmh.start_at",
					name: "aatxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "aatxxmh.finish_at",
					name: "aatxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "aatxxmh",
					type: "hidden"
				},	
				{
					label: "aatxxmh.transaction_state",
					name: "aatxxmh.transaction_state",
					type: "hidden",
					def: 0
				},		
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "aatxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "aatxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtaatxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaatxxmh.field('aatxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblaatxxmh.rows().deselect();
				edtaatxxmh.field('aatxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtaatxxmh.field('aatxxmh.nama').enable();
				}else{
					edtaatxxmh.field('aatxxmh.nama').disable();
				}
			}
		});

		edtaatxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtaatxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtaatxxmh.field('aatxxmh.nama').val();

				validasiRequired(
					edtaatxxmh,
					'aatxxmh',
					{
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtaatxxmh,
					'aatxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_aatxxmh
				);
			}
			
			if ( edtaatxxmh.inError() ) {
				return false;
			}
		});
		
		edtaatxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaatxxmh.field('aatxxmh.finish_at').val(finish_at);
		});

		edtaatxxmh.on( 'close', function () {
			edtaatxxmh.enable();
		} );

		tblaatxxmh = $('#tblaatxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aatxxmh/aatxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aatxxmh = show_deleted_aatxxmh;
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
				{ data: "aatxxmh.id",visible:false },
				{ data: "aatxxmh.nama" },
				{ 
					data: "aatxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aatxxmh';
					$table       = 'tblaatxxmh';
					$edt         = 'edtaatxxmh';
					$show_status = '_aatxxmh';
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
				if ( data.aatxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.aatxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblaatxxmh.searchPanes.container().appendTo('#spaatxxmh');
		tblaatxxmh.searchBuilder.container().appendTo( '#sbaatxxmh' );
		
		tblaatxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblaatxxmh);
		} );
		
		tblaatxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('aatxxmh');

			// atur hak akses
			CekSelectHeaderH(tblaatxxmh);
		} );

		tblaatxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('aatxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblaatxxmh);
		} );

		// END aatxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
