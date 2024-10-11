<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'holxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblholxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/holxxmh/fn/holxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtholxxmh, tblholxxmh, show_deleted_holxxmh = 0, id_holxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('holxxmh');

	$(document).ready(function() {
		// BEGIN holxxmh
		edtholxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/holxxmh/holxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_holxxmh = show_deleted_holxxmh;
				}
			},
			table: "#tblholxxmh",
			fields: [ 
				{
					label: "holxxmh.start_at",
					name: "holxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "holxxmh.finish_at",
					name: "holxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "holxxmh",
					type: "hidden"
				},	
				{
					label: "holxxmh.transaction_state",
					name: "holxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "holxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "holxxmh.nama"
				}, 	
				
				{
					label: getTranslation('notes'),
					name: "holxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtholxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtholxxmh.field('holxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblholxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtholxxmh.field('holxxmh.kode').enable();
					edtholxxmh.field('holxxmh.nama').enable();
				}else{
					edtholxxmh.field('holxxmh.kode').disable();
					edtholxxmh.field('holxxmh.nama').disable();
				}
			}
		});

		edtholxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtholxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtholxxmh.field('holxxmh.kode').val();
				nama = edtholxxmh.field('holxxmh.nama').val();

				validasiRequired(
					edtholxxmh,
					'holxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtholxxmh,
					'holxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_holxxmh
				);

				validasiUnique(
					action,
					edtholxxmh,
					'holxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_holxxmh
				);
			}
			
			if ( edtholxxmh.inError() ) {
				return false;
			}
		});
		
		edtholxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtholxxmh.field('holxxmh.finish_at').val(finish_at);
		});

		edtholxxmh.on( 'close', function () {
			edtholxxmh.enable();
		} );

		tblholxxmh = $('#tblholxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/holxxmh/holxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_holxxmh = show_deleted_holxxmh;
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
				{ data: "holxxmh.id",visible:false },
				{ data: "holxxmh.kode" },
				{ data: "holxxmh.nama" },
				{ data: "holxxmh.keterangan" },
				{ 
					data: "holxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_holxxmh';
					$table       = 'tblholxxmh';
					$edt         = 'edtholxxmh';
					$show_status = '_holxxmh';
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
				if ( data.holxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.holxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblholxxmh.searchPanes.container().appendTo('#spholxxmh');
		tblholxxmh.searchBuilder.container().appendTo( '#sbholxxmh' );
		
		tblholxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblholxxmh);
		} );
		
		tblholxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('holxxmh');
			// atur hak akses
			CekSelectHeaderH(tblholxxmh);
		} );

		tblholxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('holxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblholxxmh);
		} );

		// END holxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
