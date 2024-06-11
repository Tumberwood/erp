<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iibxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliibxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iibxxmh/fn/iibxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtiibxxmh, tbliibxxmh, show_deleted_iibxxmh = 0, id_iibxxmh;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('iibxxmh');
	
	$(document).ready(function() {
		// BEGIN iibxxmh
		edtiibxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iibxxmh/iibxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iibxxmh = show_deleted_iibxxmh;
				}
			},
			table: "#tbliibxxmh",
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
					label: "iibxxmh.start_at",
					name: "iibxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "iibxxmh.finish_at",
					name: "iibxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "iibxxmh",
					type: "hidden"
				},	
				{
					label: "iibxxmh.transaction_state",
					name: "iibxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>", 
					name: "iibxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "iibxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtiibxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiibxxmh.field('iibxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbliibxxmh.rows().deselect();

				edtiibxxmh.field('iibxxmh.nama').enable();

			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtiibxxmh.field('iibxxmh.nama').enable();
				}else{
					edtiibxxmh.field('iibxxmh.nama').disable();
				}
			}
		});

		edtiibxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtiibxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				nama = edtiibxxmh.field('iibxxmh.nama').val();
				validasiRequired(
					edtiibxxmh,
					'iibxxmh',
					{
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtiibxxmh,
					'iibxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_iibxxmh,
				);
			}
			
			if ( edtiibxxmh.inError() ) {
				return false;
			}
		});
		
		edtiibxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtiibxxmh.field('iibxxmh.finish_at').val(finish_at);
		});

		edtiibxxmh.on( 'close', function () {
			edtiibxxmh.enable();
		} );

		tbliibxxmh = $('#tbliibxxmh').DataTable( {
			ajax: {
				url: "../../models/iibxxmh/iibxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iibxxmh = show_deleted_iibxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "iibxxmh.id",visible:false },
				{ data: "iibxxmh.kode" },
				{ data: "iibxxmh.nama" },
				{ data: "iibxxmh.keterangan" },
				{ 
					data: "iibxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iibxxmh';
					$table       = 'tbliibxxmh';
					$edt         = 'edtiibxxmh';
					$show_status = '_iibxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h','view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
				if ( data.iibxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.iibxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );
		
		tbliibxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbliibxxmh);
		} );
		
		tbliibxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('iibxxmh');

			// atur hak akses
			CekSelectHeaderH(tbliibxxmh);
		} );

		tbliibxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('iibxxmh');

			// atur hak akses
			CekDeselectHeaderH(tbliibxxmh);
		} );

		// END iibxxmh
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
