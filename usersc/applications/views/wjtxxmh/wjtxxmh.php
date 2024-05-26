<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wjtxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwjtxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>TX</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wjtxxmh/fn/wjtxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwjtxxmh, tblwjtxxmh, show_deleted_wjtxxmh = 0, id_wjtxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('wjtxxmh');

	$(document).ready(function() {
		// BEGIN wjtxxmh
		edtwjtxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wjtxxmh/wjtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wjtxxmh = show_deleted_wjtxxmh;
				}
			},
			table: "#tblwjtxxmh",
			fields: [ 
				{
					label: "wjtxxmh.start_at",
					name: "wjtxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wjtxxmh.finish_at",
					name: "wjtxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wjtxxmh",
					type: "hidden"
				},	
				{
					label: "wjtxxmh.transaction_state",
					name: "wjtxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "wjtxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "wjtxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "wjtxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwjtxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwjtxxmh.field('wjtxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwjtxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwjtxxmh.field('wjtxxmh.kode').enable();
					edtwjtxxmh.field('wjtxxmh.nama').enable();
				}else{
					edtwjtxxmh.field('wjtxxmh.kode').disable();
					edtwjtxxmh.field('wjtxxmh.nama').disable();
				}
			}
		});

		edtwjtxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwjtxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwjtxxmh.field('wjtxxmh.kode').val();
				nama = edtwjtxxmh.field('wjtxxmh.nama').val();

				validasiRequired(
					edtwjtxxmh,
					'wjtxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtwjtxxmh,
					'wjtxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wjtxxmh
				);

				validasiUnique(
					action,
					edtwjtxxmh,
					'wjtxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_wjtxxmh
				);
			}
			
			if ( edtwjtxxmh.inError() ) {
				return false;
			}
		});
		
		edtwjtxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwjtxxmh.field('wjtxxmh.finish_at').val(finish_at);
		});

		edtwjtxxmh.on( 'close', function () {
			edtwjtxxmh.enable();
		} );

		tblwjtxxmh = $('#tblwjtxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wjtxxmh/wjtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wjtxxmh = show_deleted_wjtxxmh;
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
				{ data: "wjtxxmh.id",visible:false },
				{ data: "wjtxxmh.kode" },
				{ data: "wjtxxmh.nama" },
				{ data: "wjtxxmh.keterangan" },
				{ 
					data: "wjtxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wjtxxmh';
					$table       = 'tblwjtxxmh';
					$edt         = 'edtwjtxxmh';
					$show_status = '_wjtxxmh';
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
				if ( data.wjtxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wjtxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwjtxxmh.searchPanes.container().appendTo('#spwjtxxmh');
		tblwjtxxmh.searchBuilder.container().appendTo( '#sbwjtxxmh' );
		
		tblwjtxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwjtxxmh);
		} );
		
		tblwjtxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wjtxxmh');

			// atur hak akses
			CekSelectHeaderH(tblwjtxxmh);
		} );

		tblwjtxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wjtxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblwjtxxmh);
		} );

		// END wjtxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
