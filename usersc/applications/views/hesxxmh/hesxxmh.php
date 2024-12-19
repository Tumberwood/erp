<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hesxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhesxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hesxxmh/fn/hesxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthesxxmh, tblhesxxmh, show_deleted_hesxxmh = 0, id_hesxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hesxxmh');

	$(document).ready(function() {
		// BEGIN hesxxmh
		edthesxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hesxxmh/hesxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hesxxmh = show_deleted_hesxxmh;
				}
			},
			table: "#tblhesxxmh",
			fields: [ 
				{
					label: "hesxxmh.start_at",
					name: "hesxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hesxxmh.finish_at",
					name: "hesxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hesxxmh",
					type: "hidden"
				},	
				{
					label: "hesxxmh.transaction_state",
					name: "hesxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "hesxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "hesxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hesxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthesxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthesxxmh.field('hesxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhesxxmh.rows().deselect();
				edthesxxmh.field('hesxxmh.kode').enable();
				edthesxxmh.field('hesxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthesxxmh.field('hesxxmh.kode').enable();
					edthesxxmh.field('hesxxmh.nama').enable();
				}else{
					edthesxxmh.field('hesxxmh.kode').disable();
					edthesxxmh.field('hesxxmh.nama').disable();
				}
			}
		});

		edthesxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthesxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthesxxmh.field('hesxxmh.kode').val();
				nama = edthesxxmh.field('hesxxmh.nama').val();

				validasiRequired(
					edthesxxmh,
					'hesxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthesxxmh,
					'hesxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hesxxmh
				);

				validasiUnique(
					action,
					edthesxxmh,
					'hesxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hesxxmh
				);
			}
			
			if ( edthesxxmh.inError() ) {
				return false;
			}
		});
		
		edthesxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthesxxmh.field('hesxxmh.finish_at').val(finish_at);
		});

		edthesxxmh.on( 'close', function () {
			edthesxxmh.enable();
		} );

		tblhesxxmh = $('#tblhesxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hesxxmh/hesxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hesxxmh = show_deleted_hesxxmh;
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
				{ data: "hesxxmh.id",visible:false },
				{ data: "hesxxmh.kode" },
				{ data: "hesxxmh.nama" },
				{ 
					data: "hesxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hesxxmh';
					$table       = 'tblhesxxmh';
					$edt         = 'edthesxxmh';
					$show_status = '_hesxxmh';
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
				if ( data.hesxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hesxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhesxxmh.searchPanes.container().appendTo('#sphesxxmh');
		tblhesxxmh.searchBuilder.container().appendTo( '#sbhesxxmh' );
		
		tblhesxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhesxxmh);
		} );
		
		tblhesxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hesxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhesxxmh);
		} );

		tblhesxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hesxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhesxxmh);
		} );

		// END hesxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
