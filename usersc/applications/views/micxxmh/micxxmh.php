<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'micxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblmicxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/micxxmh/fn/micxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtmicxxmh, tblmicxxmh, show_deleted_micxxmh = 0, id_micxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('micxxmh');

	$(document).ready(function() {
		// BEGIN micxxmh
		edtmicxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/micxxmh/micxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_micxxmh = show_deleted_micxxmh;
				}
			},
			table: "#tblmicxxmh",
			fields: [ 
				{
					label: "micxxmh.start_at",
					name: "micxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "micxxmh.finish_at",
					name: "micxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "micxxmh",
					type: "hidden"
				},	
				{
					label: "micxxmh.transaction_state",
					name: "micxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "micxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "micxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "micxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtmicxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmicxxmh.field('micxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblmicxxmh.rows().deselect();
			}
		});

		edtmicxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtmicxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtmicxxmh.field('micxxmh.kode').val();
				nama = edtmicxxmh.field('micxxmh.nama').val();

				validasiRequired(
					edtmicxxmh,
					'micxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtmicxxmh,
					'micxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_micxxmh
				);

				validasiUnique(
					action,
					edtmicxxmh,
					'micxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_micxxmh
				);
			}
			
			if ( edtmicxxmh.inError() ) {
				return false;
			}
		});
		
		edtmicxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtmicxxmh.field('micxxmh.finish_at').val(finish_at);
		});

		edtmicxxmh.on( 'close', function () {
			edtmicxxmh.enable();
		} );

		tblmicxxmh = $('#tblmicxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/micxxmh/micxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_micxxmh = show_deleted_micxxmh;
				}
			},
			serverSide: true,
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
				{ data: "micxxmh.id",visible:false },
				{ data: "micxxmh.kode" },
				{ data: "micxxmh.nama" },
				{ data: "micxxmh.keterangan" },
				{ 
					data: "micxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_micxxmh';
					$table       = 'tblmicxxmh';
					$edt         = 'edtmicxxmh';
					$show_status = '_micxxmh';
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
				if ( data.micxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.micxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblmicxxmh.searchPanes.container().appendTo('#spmicxxmh');
		tblmicxxmh.searchBuilder.container().appendTo( '#sbmicxxmh' );
		
		tblmicxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblmicxxmh);
		} );
		
		tblmicxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('micxxmh');

			// atur hak akses
			CekSelectHeaderH(tblmicxxmh);
		} );

		tblmicxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('micxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblmicxxmh);
		} );

		// END micxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
