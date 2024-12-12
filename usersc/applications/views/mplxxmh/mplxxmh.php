<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'mplxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblmplxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/mplxxmh/fn/mplxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtmplxxmh, tblmplxxmh, show_deleted_mplxxmh = 0, id_mplxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('mplxxmh');

	$(document).ready(function() {
		// BEGIN mplxxmh
		edtmplxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/mplxxmh/mplxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_mplxxmh = show_deleted_mplxxmh;
				}
			},
			table: "#tblmplxxmh",
			fields: [ 
				{
					label: "mplxxmh.start_at",
					name: "mplxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "mplxxmh.finish_at",
					name: "mplxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "mplxxmh",
					type: "hidden"
				},	
				{
					label: "mplxxmh.transaction_state",
					name: "mplxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "mplxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "mplxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "mplxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtmplxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmplxxmh.field('mplxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblmplxxmh.rows().deselect();
				edtmplxxmh.field('mplxxmh.kode').enable();
				edtmplxxmh.field('mplxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtmplxxmh.field('mplxxmh.kode').enable();
					edtmplxxmh.field('mplxxmh.nama').enable();
				}else{
					edtmplxxmh.field('mplxxmh.kode').disable();
					edtmplxxmh.field('mplxxmh.nama').disable();
				}
			}
		});

		edtmplxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtmplxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtmplxxmh.field('mplxxmh.kode').val();
				nama = edtmplxxmh.field('mplxxmh.nama').val();

				validasiRequired(
					edtmplxxmh,
					'mplxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtmplxxmh,
					'mplxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_mplxxmh
				);

				validasiUnique(
					action,
					edtmplxxmh,
					'mplxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_mplxxmh
				);
			}
			
			if ( edtmplxxmh.inError() ) {
				return false;
			}
		});
		
		edtmplxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmplxxmh.field('mplxxmh.finish_at').val(finish_at);
		});

		edtmplxxmh.on( 'close', function () {
			edtmplxxmh.enable();
		} );

		tblmplxxmh = $('#tblmplxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/mplxxmh/mplxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_mplxxmh = show_deleted_mplxxmh;
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
				{ data: "mplxxmh.id",visible:false },
				{ data: "mplxxmh.kode" },
				{ data: "mplxxmh.nama" },
				{ data: "mplxxmh.keterangan" },
				{ 
					data: "mplxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_mplxxmh';
					$table       = 'tblmplxxmh';
					$edt         = 'edtmplxxmh';
					$show_status = '_mplxxmh';
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
				if ( data.mplxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.mplxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblmplxxmh.searchPanes.container().appendTo('#spmplxxmh');
		tblmplxxmh.searchBuilder.container().appendTo( '#sbmplxxmh' );
		
		tblmplxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblmplxxmh);
		} );
		
		tblmplxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('mplxxmh');

			// atur hak akses
			CekSelectHeaderH(tblmplxxmh);
		} );

		tblmplxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('mplxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblmplxxmh);
		} );

		// END mplxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
