<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wloznmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwloznmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wloznmh/fn/wloznmh_fn.php'; ?>


<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwloznmh, tblwloznmh, show_deleted_wloznmh = 0, id_wloznmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('wloznmh');

	$(document).ready(function() {
		//start datatables editor
		edtwloznmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wloznmh/wloznmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wloznmh = show_deleted_wloznmh;
				}
			},
			table: "#tblwloznmh",
			fields: [ 
				{
					label: "wloznmh.start_at",
					name: "wloznmh.start_at",
					type: "hidden"
				},	
				{
					label: "wloznmh.finish_at",
					name: "wloznmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wloznmh",
					type: "hidden"
				},	
				{
					label: "wloznmh.transaction_state",
					name: "wloznmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "wloznmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "wloznmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "wloznmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwloznmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwloznmh.field('wloznmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwloznmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwloznmh.field('wloznmh.kode').enable();
					edtwloznmh.field('wloznmh.nama').enable();
				}else{
					edtwloznmh.field('wloznmh.kode').disable();
					edtwloznmh.field('wloznmh.nama').disable();
				}
			}
		});

		edtwloznmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwloznmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwloznmh.field('wloznmh.kode').val();
				nama = edtwloznmh.field('wloznmh.nama').val();

				validasiRequired(
					edtwloznmh,
					'wloznmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtwloznmh,
					'wloznmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wloznmh
				);

				validasiUnique(
					action,
					edtwloznmh,
					'wloznmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_wloznmh
				);
			}
			
			if ( edtwloznmh.inError() ) {
				return false;
			}
		});
		
		edtwloznmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwloznmh.field('wloznmh.finish_at').val(finish_at);
		});

		edtwloznmh.on( 'close', function () {
			edtwloznmh.enable();
		} );

		tblwloznmh = $('#tblwloznmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wloznmh/wloznmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wloznmh = show_deleted_wloznmh;
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
				{ data: "wloznmh.id",visible:false },
				{ data: "wloznmh.kode" },
				{ data: "wloznmh.nama" },
				{ data: "wloznmh.keterangan" },
				{ 
					data: "wloznmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wloznmh';
					$table       = 'tblwloznmh';
					$edt         = 'edtwloznmh';
					$show_status = '_wloznmh';
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
				if ( data.wloznmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wloznmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwloznmh.searchPanes.container().appendTo('#spwloznmh');
		tblwloznmh.searchBuilder.container().appendTo( '#sbwloznmh' );
		
		tblwloznmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwloznmh);
		} );
		
		tblwloznmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wloznmh');

			// atur hak akses
			CekSelectHeaderH(tblwloznmh);
		} );

		tblwloznmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wloznmh');

			// atur hak akses
			CekDeselectHeaderH(tblwloznmh);
		} );
		
		// END wloznmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
