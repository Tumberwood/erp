<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wttxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwttxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th>Jenis</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wttxxmh/fn/wttxxmh_fn.php'; ?>


<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwttxxmh, tblwttxxmh, show_deleted_wttxxmh = 0, id_wttxxmh;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('wttxxmh');
	
	$(document).ready(function() {

		// BEGIN wttxxmh
		edtwttxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wttxxmh/wttxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wttxxmh = show_deleted_wttxxmh;
				}
			},
			table: "#tblwttxxmh",
			fields: [ 
				{
					label: "wttxxmh.start_at",
					name: "wttxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wttxxmh.finish_at",
					name: "wttxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wttxxmh",
					type: "hidden"
				},	
				{
					label: "wttxxmh.transaction_state",
					name: "wttxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "wttxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "wttxxmh.nama"
				}, 	
				{
					label: "Jenis <sup class='text-danger'>*<sup>",
					name: "wttxxmh.jenis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Goods Receive", "value": 1 },
						{ "label": "Goods Issue", "value": 2 },
						{ "label": "Goods Transfer", "value": 3 }
					]
				},
				{
					label: getTranslation('notes'),
					name: "wttxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwttxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwttxxmh.field('wttxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwttxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwttxxmh.field('wttxxmh.kode').enable();
					edtwttxxmh.field('wttxxmh.nama').enable();
				}else{
					edtwttxxmh.field('wttxxmh.kode').disable();
					edtwttxxmh.field('wttxxmh.nama').disable();
				}
			}
			
		});

		edtwttxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwttxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				kode = edtwttxxmh.field('wttxxmh.kode').val();
				nama = edtwttxxmh.field('wttxxmh.nama').val();
				jenis = edtwttxxmh.field('wttxxmh.jenis').val();

				validasiRequired(
					edtwttxxmh,
					'wttxxmh',
					{
						'kode': kode,
						'nama': nama,
						'jenis': jenis

					}
				);

				validasiUnique(
					action,
					edtwttxxmh,
					'wttxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wttxxmh
				);

				validasiUnique(
					action,
					edtwttxxmh,
					'wttxxmh',
					'name',
					'name',
					'"'+name+'"',
					id_wttxxmh
				);

			}
			
			if ( edtwttxxmh.inError() ) {
				return false;
			}
		});
		
		edtwttxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwttxxmh.field('wttxxmh.finish_at').val(finish_at);
		});

		edtwttxxmh.on( 'close', function () {
			edtwttxxmh.enable();
		} );

		tblwttxxmh = $('#tblwttxxmh').DataTable( {
			ajax: {
				url: "../../models/wttxxmh/wttxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wttxxmh = show_deleted_wttxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "wttxxmh.id",visible:false },
				{ data: "wttxxmh.kode" },
				{ data: "wttxxmh.nama" },
				{ 
					data: "wttxxmh.jenis" ,
					render: function (data){
							if(data == 1){
								return 'Goods Receive';
							}else if(data == 2){
								return 'Goods Issue';
							}else if(data == 3){
								return 'Goods Transfer';
							}else{
								return '<span class="badge badge-warning">INVALID</span>';
							}
						}

				},
				{ 
					data: "wttxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wttxxmh';
					$table       = 'tblwttxxmh';
					$edt         = 'edtwttxxmh';
					$show_status = '_wttxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
				if ( data.wttxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wttxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );
		
		tblwttxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwttxxmh);
		} );
		
		tblwttxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wttxxmh');

			// atur hak akses
			CekSelectHeaderH(tblwttxxmh);
		} );

		tblwttxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wttxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblwttxxmh);
		} );

		// END wttxxmh
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
