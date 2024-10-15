<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hrctsmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhrctsmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrctsmh/fn/hrctsmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthrctsmh, tblhrctsmh, show_deleted_hrctsmh = 0, id_hrctsmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hrctsmh');

	$(document).ready(function() {
		// BEGIN hrctsmh
		edthrctsmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrctsmh/hrctsmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctsmh = show_deleted_hrctsmh;
				}
			},
			table: "#tblhrctsmh",
			fields: [ 
				{
					label: "hrctsmh.start_at",
					name: "hrctsmh.start_at",
					type: "hidden"
				},	
				{
					label: "hrctsmh.finish_at",
					name: "hrctsmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrctsmh",
					type: "hidden"
				},	
				{
					label: "hrctsmh.transaction_state",
					name: "hrctsmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "hrctsmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "hrctsmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "hrctsmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthrctsmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctsmh.field('hrctsmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrctsmh.rows().deselect();
				edthrctsmh.field('hrctsmh.kode').enable();
				edthrctsmh.field('hrctsmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthrctsmh.field('hrctsmh.kode').enable();
					edthrctsmh.field('hrctsmh.nama').enable();
				}else{
					edthrctsmh.field('hrctsmh.kode').disable();
					edthrctsmh.field('hrctsmh.nama').disable();
				}
			}
		});

		edthrctsmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthrctsmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthrctsmh.field('hrctsmh.kode').val();
				nama = edthrctsmh.field('hrctsmh.nama').val();

				validasiRequired(
					edthrctsmh,
					'hrctsmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edthrctsmh,
					'hrctsmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hrctsmh
				);

				validasiUnique(
					action,
					edthrctsmh,
					'hrctsmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hrctsmh
				);
			}
			
			if ( edthrctsmh.inError() ) {
				return false;
			}
		});
		
		edthrctsmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrctsmh.field('hrctsmh.finish_at').val(finish_at);
		});

		edthrctsmh.on( 'close', function () {
			edthrctsmh.enable();
		} );

		tblhrctsmh = $('#tblhrctsmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrctsmh/hrctsmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrctsmh = show_deleted_hrctsmh;
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
				{ data: "hrctsmh.id",visible:false },
				{ data: "hrctsmh.kode" },
				{ data: "hrctsmh.nama" },
				{ 
					data: "hrctsmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrctsmh';
					$table       = 'tblhrctsmh';
					$edt         = 'edthrctsmh';
					$show_status = '_hrctsmh';
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
				if ( data.hrctsmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrctsmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrctsmh.searchPanes.container().appendTo('#sphrctsmh');
		tblhrctsmh.searchBuilder.container().appendTo( '#sbhrctsmh' );
		
		tblhrctsmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhrctsmh);
		} );
		
		tblhrctsmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrctsmh');

			// atur hak akses
			CekSelectHeaderH(tblhrctsmh);
		} );

		tblhrctsmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrctsmh');

			// atur hak akses
			CekDeselectHeaderH(tblhrctsmh);
		} );

		// END hrctsmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
