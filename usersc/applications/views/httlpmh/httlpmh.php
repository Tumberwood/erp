<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'httlpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhttlpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Potong Cuti</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httlpmh/fn/httlpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthttlpmh, tblhttlpmh, show_deleted_httlpmh = 0, id_httlpmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('httlpmh');

		$(document).ready(function() {
			// BEGIN httlpmh
			edthttlpmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/httlpmh/httlpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_httlpmh = show_deleted_httlpmh;
					}
				},
				table: "#tblhttlpmh",
				fields: [ 
					{
						label: "httlpmh.start_at",
						name: "httlpmh.start_at",
						type: "hidden"
					},	
					{
						label: "httlpmh.finish_at",
						name: "httlpmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "httlpmh",
						type: "hidden"
					},	
					{
						label: "httlpmh.transaction_state",
						name: "httlpmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "httlpmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "httlpmh.nama"
					}, 	
					{
						label: "Jenis",
						name: "httlpmh.jenis",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Hari", "value": 1 },
							{ "label": "Jam", "value": 2 }
						]
					},
					{
						label: "Potong Cuti",
						name: "httlpmh.is_potongcuti",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
					},
					{
						label: "Keterangan",
						name: "httlpmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edthttlpmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthttlpmh.field('httlpmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblhttlpmh.rows().deselect();
				}
			});

			edthttlpmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthttlpmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edthttlpmh.field('httlpmh.kode').val();
					nama = edthttlpmh.field('httlpmh.nama').val();

					validasiRequired(
						edthttlpmh,
						'httlpmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edthttlpmh,
						'httlpmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_httlpmh
					);

					validasiUnique(
						action,
						edthttlpmh,
						'httlpmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_httlpmh
					);
				}
				
				if ( edthttlpmh.inError() ) {
					return false;
				}
			});
			
			edthttlpmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthttlpmh.field('httlpmh.finish_at').val(finish_at);
			});

			edthttlpmh.on( 'close', function () {
				edthttlpmh.enable();
			} );

			tblhttlpmh = $('#tblhttlpmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/httlpmh/httlpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_httlpmh = show_deleted_httlpmh;
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
					{ data: "httlpmh.id",visible:false },
					{ data: "httlpmh.kode" },
					{ data: "httlpmh.nama" },
					{ data: "httlpmh.jenis" },
					{ 
						data: "httlpmh.is_potongcuti" ,
						...renderYaTidak()
					},
					{ data: "httlpmh.keterangan" },
					{ 
						data: "httlpmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_httlpmh';
						$table       = 'tblhttlpmh';
						$edt         = 'edthttlpmh';
						$show_status = '_httlpmh';
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
					if ( data.httlpmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.httlpmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhttlpmh.searchPanes.container().appendTo('#sphttlpmh');
			tblhttlpmh.searchBuilder.container().appendTo( '#sbhttlpmh' );
			
			tblhttlpmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhttlpmh);
			} );
			
			tblhttlpmh.on( 'select', function( e, dt, type, indexes ) {
				httlpmh_data    		= tblhttlpmh.row( { selected: true } ).data().httlpmh;
				id_httlpmh      		= httlpmh_data.id;
				id_transaksi_h 		= id_httlpmh; // dipakai untuk general
				id_transaksi_log	= id_httlpmh; // dipakai untuk general
				transaction_state   = httlpmh_data.transaction_state;
				approval_state   	= httlpmh_data.approval_state;
				is_nextprocess 		= httlpmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblhttlpmh);
			} );

			tblhttlpmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_httlpmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhttlpmh);
			} );

			// END httlpmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
