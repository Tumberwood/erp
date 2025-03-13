<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iibprmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliibprmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iibprmh/fn/iibprmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiibprmh, tbliibprmh, show_deleted_iibprmh = 0, id_iibprmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('iibprmh');

	$(document).ready(function() {
		// BEGIN iibprmh
		edtiibprmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iibprmh/iibprmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iibprmh = show_deleted_iibprmh;
				}
			},
			table: "#tbliibprmh",
			fields: [ 
				{
					label: "iibprmh.start_at",
					name: "iibprmh.start_at",
					type: "hidden"
				},	
				{
					label: "iibprmh.finish_at",
					name: "iibprmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iibprmh",
					type: "hidden"
				},	
				{
					label: "iibprmh.transaction_state",
					name: "iibprmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "iibprmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "iibprmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtiibprmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiibprmh.field('iibprmh.start_at').val(start_at);
			//cek_is_need_generate_kode
			cek_is_need_generate_kode('iibprmh', edtiibprmh, 1, action);
			
			if(action == 'create'){
				tbliibprmh.rows().deselect();

				edtiibprmh.field('iibprmh.nama').enable();

			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtiibprmh.field('iibprmh.nama').enable();
				}else{
					edtiibprmh.field('iibprmh.nama').disable();
				}
			}
		});

		edtiibprmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtiibprmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtiibprmh.field('iibprmh.nama').val();

				validasiRequired(
					edtiibprmh,
					'iibprmh',
					{
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtiibprmh,
					'iibprmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_iibprmh
				);
			}
			
			if ( edtiibprmh.inError() ) {
				return false;
			}
		});
		
		edtiibprmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiibprmh.field('iibprmh.finish_at').val(finish_at);
		});

		edtiibprmh.on( 'close', function () {
			edtiibprmh.enable();
		} );
		
		tbliibprmh = $('#tbliibprmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iibprmh/iibprmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iibprmh = show_deleted_iibprmh;
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
				{ data: "iibprmh.id",visible:false },
				{ data: "iibprmh.nama" },
				{ data: "iibprmh.keterangan" },
				{ 
					data: "iibprmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iibprmh';
					$table       = 'tbliibprmh';
					$edt         = 'edtiibprmh';
					$show_status = '_iibprmh';
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
				if ( data.iibprmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iibprmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbliibprmh.searchPanes.container().appendTo('#spiibprmh');
		tbliibprmh.searchBuilder.container().appendTo( '#sbiibprmh' );
		
		tbliibprmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbliibprmh);
		} );
		
		tbliibprmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iibprmh');

			// atur hak akses
			CekSelectHeaderH(tbliibprmh);
		} );

		tbliibprmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iibprmh');

			// atur hak akses
			CekDeselectHeaderH(tbliibprmh);
		} );
		
		// END iibprmh
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
