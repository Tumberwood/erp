<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wpmxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwpmxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpmxxmh/fn/wpmxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwpmxxmh, tblwpmxxmh, show_deleted_wpmxxmh = 0, id_wpmxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('wpmxxmh');

	$(document).ready(function() {
		//start datatables editor
		edtwpmxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wpmxxmh/wpmxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpmxxmh = show_deleted_wpmxxmh;
				}
			},
			table: "#tblwpmxxmh",
			fields: [ 
				{
					label: "wpmxxmh.start_at",
					name: "wpmxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wpmxxmh.finish_at",
					name: "wpmxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wpmxxmh",
					type: "hidden"
				},	
				{
					label: "wpmxxmh.transaction_state",
					name: "wpmxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "wpmxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "wpmxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "wpmxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtwpmxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpmxxmh.field('wpmxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwpmxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwpmxxmh.field('wpmxxmh.kode').enable();
					edtwpmxxmh.field('wpmxxmh.nama').enable();
				}else{
					edtwpmxxmh.field('wpmxxmh.kode').disable();
					edtwpmxxmh.field('wpmxxmh.nama').disable();
				}
			}
		});

		edtwpmxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwpmxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwpmxxmh.field('wpmxxmh.kode').val();
				nama = edtwpmxxmh.field('wpmxxmh.nama').val();

				validasiRequired(
					edtwpmxxmh,
					'wpmxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtwpmxxmh,
					'wpmxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wpmxxmh
				);

				validasiUnique(
					action,
					edtwpmxxmh,
					'wpmxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_wpmxxmh
				);
			}
			
			if ( edtwpmxxmh.inError() ) {
				return false;
			}
		});
		
		edtwpmxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpmxxmh.field('wpmxxmh.finish_at').val(finish_at);
		});

		edtwpmxxmh.on( 'close', function () {
			edtwpmxxmh.enable();
		} );

		tblwpmxxmh = $('#tblwpmxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wpmxxmh/wpmxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpmxxmh = show_deleted_wpmxxmh;
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
				{ data: "wpmxxmh.id",visible:false },
				{ data: "wpmxxmh.kode" },
				{ data: "wpmxxmh.nama" },
				{ data: "wpmxxmh.keterangan" },
				{ 
					data: "wpmxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wpmxxmh';
					$table       = 'tblwpmxxmh';
					$edt         = 'edtwpmxxmh';
					$show_status = '_wpmxxmh';
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
				if ( data.wpmxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wpmxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwpmxxmh.searchPanes.container().appendTo('#spwpmxxmh');
		tblwpmxxmh.searchBuilder.container().appendTo( '#sbwpmxxmh' );
		
		tblwpmxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwpmxxmh);
		} );
		
		tblwpmxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wpmxxmh');

			// atur hak akses
			CekSelectHeaderH(tblwpmxxmh);
		} );

		tblwpmxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wpmxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblwpmxxmh);
		} );
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
