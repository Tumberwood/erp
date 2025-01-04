<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wlotpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwlotpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wlotpmh/fn/wlotpmh_fn.php'; ?>


<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwlotpmh, tblwlotpmh, show_deleted_wlotpmh = 0, id_wlotpmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('wlotpmh');

	$(document).ready(function() {
		// BEGIN wlotpmh
		edtwlotpmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wlotpmh/wlotpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wlotpmh = show_deleted_wlotpmh;
				}
			},
			table: "#tblwlotpmh",
			fields: [ 
				{
					label: "wlotpmh.start_at",
					name: "wlotpmh.start_at",
					type: "hidden"
				},	
				{
					label: "wlotpmh.finish_at",
					name: "wlotpmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wlotpmh",
					type: "hidden"
				},	
				{
					label: "wlotpmh.transaction_state",
					name: "wlotpmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "wlotpmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "wlotpmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "wlotpmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwlotpmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwlotpmh.field('wlotpmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwlotpmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwlotpmh.field('wlotpmh.kode').enable();
					edtwlotpmh.field('wlotpmh.nama').enable();
				}else{
					edtwlotpmh.field('wlotpmh.kode').disable();
					edtwlotpmh.field('wlotpmh.nama').disable();
				}
			}
		});

		edtwlotpmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwlotpmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwlotpmh.field('wlotpmh.kode').val();
				nama = edtwlotpmh.field('wlotpmh.nama').val();

				validasiRequired(
					edtwlotpmh,
					'wlotpmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtwlotpmh,
					'wlotpmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wlotpmh
				);

				validasiUnique(
					action,
					edtwlotpmh,
					'wlotpmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_wlotpmh
				);
			}
			
			if ( edtwlotpmh.inError() ) {
				return false;
			}
		});
		
		edtwlotpmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwlotpmh.field('wlotpmh.finish_at').val(finish_at);
		});

		edtwlotpmh.on( 'close', function () {
			edtwlotpmh.enable();
		} );

		tblwlotpmh = $('#tblwlotpmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wlotpmh/wlotpmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wlotpmh = show_deleted_wlotpmh;
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
				{ data: "wlotpmh.id",visible:false },
				{ data: "wlotpmh.kode" },
				{ data: "wlotpmh.nama" },
				{ data: "wlotpmh.keterangan" },
				{ 
					data: "wlotpmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wlotpmh';
					$table       = 'tblwlotpmh';
					$edt         = 'edtwlotpmh';
					$show_status = '_wlotpmh';
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
				if ( data.wlotpmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wlotpmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwlotpmh.searchPanes.container().appendTo('#spwlotpmh');
		tblwlotpmh.searchBuilder.container().appendTo( '#sbwlotpmh' );
		
		tblwlotpmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwlotpmh);
		} );
		
		tblwlotpmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wlotpmh');

			// atur hak akses
			CekSelectHeaderH(tblwlotpmh);
		} );

		tblwlotpmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wlotpmh');

			// atur hak akses
			CekDeselectHeaderH(tblwlotpmh);
		} );
		
		// END wlotpmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
