<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'nirctmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblnirctmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/nirctmh/fn/nirctmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtnirctmh, tblnirctmh, show_deleted_nirctmh = 0, id_nirctmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('nirctmh');

	$(document).ready(function() {
		// BEGIN nirctmh
		edtnirctmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/nirctmh/nirctmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_nirctmh = show_deleted_nirctmh;
				}
			},
			table: "#tblnirctmh",
			fields: [ 
				{
					label: "nirctmh.start_at",
					name: "nirctmh.start_at",
					type: "hidden"
				},	
				{
					label: "nirctmh.finish_at",
					name: "nirctmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "nirctmh",
					type: "hidden"
				},	
				{
					label: "nirctmh.transaction_state",
					name: "nirctmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "nirctmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "nirctmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "nirctmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtnirctmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtnirctmh.field('nirctmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblnirctmh.rows().deselect();
			}
		});

		edtnirctmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtnirctmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtnirctmh.field('nirctmh.kode').val();
				nama = edtnirctmh.field('nirctmh.nama').val();

				validasiRequired(
					edtnirctmh,
					'nirctmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtnirctmh,
					'nirctmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_nirctmh
				);

				validasiUnique(
					action,
					edtnirctmh,
					'nirctmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_nirctmh
				);
			}
			
			if ( edtnirctmh.inError() ) {
				return false;
			}
		});
		
		edtnirctmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtnirctmh.field('nirctmh.finish_at').val(finish_at);
		});

		edtnirctmh.on( 'close', function () {
			edtnirctmh.enable();
		} );

		tblnirctmh = $('#tblnirctmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/nirctmh/nirctmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_nirctmh = show_deleted_nirctmh;
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
				{ data: "nirctmh.id",visible:false },
				{ data: "nirctmh.kode" },
				{ data: "nirctmh.nama" },
				{ data: "nirctmh.keterangan" },
				{ 
					data: "nirctmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_nirctmh';
					$table       = 'tblnirctmh';
					$edt         = 'edtnirctmh';
					$show_status = '_nirctmh';
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
				if ( data.nirctmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.nirctmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblnirctmh.searchPanes.container().appendTo('#spnirctmh');
		tblnirctmh.searchBuilder.container().appendTo( '#sbnirctmh' );
		
		tblnirctmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblnirctmh);
		} );
		
		tblnirctmh.on( 'select', function( e, dt, type, indexes ) {
			nirctmh_data    		= tblnirctmh.row( { selected: true } ).data().nirctmh;
			id_nirctmh      		= nirctmh_data.id;
			id_transaksi_h 		= id_nirctmh; // dipakai untuk general
			id_transaksi_log	= id_nirctmh; // dipakai untuk general
			transaction_state   = nirctmh_data.transaction_state;
			approval_state   	= nirctmh_data.approval_state;
			is_nextprocess 		= nirctmh_data.is_nextprocess;

			// atur hak akses
			CekSelectHeaderH(tblnirctmh);
		} );

		tblnirctmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_nirctmh = 0;

			// atur hak akses
			CekDeselectHeaderH(tblnirctmh);
		} );

		// END nirctmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
