<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'msnxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblmsnxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="type"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/msnxxmh/fn/msnxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtmsnxxmh, tblmsnxxmh, show_deleted_msnxxmh = 0, id_msnxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('msnxxmh');

	$(document).ready(function() {
		// BEGIN msnxxmh
		edtmsnxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/msnxxmh/msnxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_msnxxmh = show_deleted_msnxxmh;
				}
			},
			table: "#tblmsnxxmh",
			fields: [ 
				{
					label: "msnxxmh.start_at",
					name: "msnxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "msnxxmh.finish_at",
					name: "msnxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "msnxxmh",
					type: "hidden"
				},	
				{
					label: "msnxxmh.transaction_state",
					name: "msnxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "msnxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "msnxxmh.nama"
				}, 	
				{
					label: getTranslation('type') + " <sup class='text-danger'>*<sup>",
					name: "msnxxmh.tipe",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Aturan Minum", "value": 1 },
						{ "label": "Cara Buat", "value": 2 }
					]
				},
				{
					label: getTranslation('notes'),
					name: "msnxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtmsnxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmsnxxmh.field('msnxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblmsnxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtmsnxxmh.field('msnxxmh.kode').enable();
					edtmsnxxmh.field('msnxxmh.nama').enable();
				}else{
					edtmsnxxmh.field('msnxxmh.kode').disable();
					edtmsnxxmh.field('msnxxmh.nama').disable();
				}
			}
		});

		edtmsnxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtmsnxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtmsnxxmh.field('msnxxmh.kode').val();
				nama = edtmsnxxmh.field('msnxxmh.nama').val();
				tipe = edtmsnxxmh.field('msnxxmh.tipe').val();

				validasiRequired(
					edtmsnxxmh,
					'msnxxmh',
					{
						'kode': kode,
						'nama': nama,
						'tipe': tipe
					}
				);

				validasiUnique(
					action,
					edtmsnxxmh,
					'msnxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_msnxxmh
				);

				validasiUnique(
					action,
					edtmsnxxmh,
					'msnxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_msnxxmh
				);
			}
			
			if ( edtmsnxxmh.inError() ) {
				return false;
			}
		});
		
		edtmsnxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmsnxxmh.field('msnxxmh.finish_at').val(finish_at);
		});

		edtmsnxxmh.on( 'close', function () {
			edtmsnxxmh.enable();
		} );

		tblmsnxxmh = $('#tblmsnxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/msnxxmh/msnxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_msnxxmh = show_deleted_msnxxmh;
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
				{ data: "msnxxmh.id",visible:false },
				{ data: "msnxxmh.kode" },
				{ data: "msnxxmh.nama" },
				{
					data: "msnxxmh.tipe" ,
					render: function (data){
						if(data == 1){
							return 'Aturan Minum';
						}else if(data == 2){
							return 'Cara Buat';
						}else{
							return 'Invalid Value';
						}
					}
				},
				{ 
					data: "msnxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_msnxxmh';
					$table       = 'tblmsnxxmh';
					$edt         = 'edtmsnxxmh';
					$show_status = '_msnxxmh';
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
				if ( data.msnxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.msnxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblmsnxxmh.searchPanes.container().appendTo('#spmsnxxmh');
		tblmsnxxmh.searchBuilder.container().appendTo( '#sbmsnxxmh' );
		
		tblmsnxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblmsnxxmh);
		} );
		
		tblmsnxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('msnxxmh');
			// atur hak akses
			CekSelectHeaderH(tblmsnxxmh);
		} );

		tblmsnxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('msnxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblmsnxxmh);
		} );

		// END msnxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
