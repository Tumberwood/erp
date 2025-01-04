<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hovxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhovxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="division"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hovxxmh/fn/hovxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthovxxmh, tblhovxxmh, show_deleted_hovxxmh = 0, id_hovxxmh;
	// ------------- end of default variable
	// get tableRelation
	tableRelation('hovxxmh');		

	$(document).ready(function() {
		// BEGIN hovxxmh
		edthovxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hovxxmh/hovxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hovxxmh = show_deleted_hovxxmh;
				}
			},
			table: "#tblhovxxmh",
			fields: [ 
				{
					label: "hovxxmh.start_at",
					name: "hovxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hovxxmh.finish_at",
					name: "hovxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hovxxmh",
					type: "hidden"
				},	
				{
					label: "hovxxmh.transaction_state",
					name: "hovxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "hovxxmh.kode"
				}, 	{
					label: getTranslation('division') + " <sup class='text-danger'>*<sup>",
					name: "hovxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hovxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthovxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthovxxmh.field('hovxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhovxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edthovxxmh.field('hovxxmh.kode').enable();
					edthovxxmh.field('hovxxmh.nama').enable();
				}else{
					edthovxxmh.field('hovxxmh.kode').disable();
					edthovxxmh.field('hovxxmh.nama').disable();
				}
			}
		});

		edthovxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthovxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				kode = edthovxxmh.field('hovxxmh.kode').val();
				nama = edthovxxmh.field('hovxxmh.nama').val();

				validasiRequired(
					edthovxxmh,
					'hovxxmh',
					{
						'nama': nama,
						'kode': kode,
					}
				);

				validasiUnique(
					action,
					edthovxxmh,
					'hovxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hovxxmh
				);
				
				validasiUnique(
					action,
					edthovxxmh,
					'hovxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hovxxmh
				);
			}
			
			if ( edthovxxmh.inError() ) {
				return false;
			}
		});
		
		edthovxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthovxxmh.field('hovxxmh.finish_at').val(finish_at);
		});

		edthovxxmh.on( 'close', function () {
			edthovxxmh.enable();
		} );

		tblhovxxmh = $('#tblhovxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hovxxmh/hovxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hovxxmh = show_deleted_hovxxmh;
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
				{ data: "hovxxmh.id",visible:false },
				{ data: "hovxxmh.kode" },
				{ data: "hovxxmh.nama" },
				{ 
					data: "hovxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hovxxmh';
					$table       = 'tblhovxxmh';
					$edt         = 'edthovxxmh';
					$show_status = '_hovxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis','upload'];
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
				if ( data.hovxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hovxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhovxxmh.searchPanes.container().appendTo('#sphovxxmh');
		tblhovxxmh.searchBuilder.container().appendTo( '#sbhovxxmh' );
		
		tblhovxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhovxxmh);
		} );
		
		tblhovxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hovxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhovxxmh);
		} );

		tblhovxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hovxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhovxxmh);
		} );

		// END hovxxmh
		uploadMaster('hovxxmh', tblhovxxmh, 'files/template_file_upload/Master Division.xlsx');
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
