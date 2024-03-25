<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'lactpmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbllactpmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/lactpmh/fn/lactpmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtlactpmh, tbllactpmh, show_deleted_lactpmh = 0, id_lactpmh;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('lactpmh');

		$(document).ready(function() {
			// BEGIN lactpmh
			edtlactpmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/lactpmh/lactpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_lactpmh = show_deleted_lactpmh;
					}
				},
				table: "#tbllactpmh",
				fields: [ 
					{
						label: "lactpmh.start_at",
						name: "lactpmh.start_at",
						type: "hidden"
					},	
					{
						label: "lactpmh.finish_at",
						name: "lactpmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "lactpmh",
						type: "hidden"
					},	
					{
						label: "lactpmh.transaction_state",
						name: "lactpmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "lactpmh.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "lactpmh.nama"
					}, 	
					{
						label: "Keterangan",
						name: "lactpmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtlactpmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtlactpmh.field('lactpmh.start_at').val(start_at);
				
				if(action == 'create'){
					tbllactpmh.rows().deselect();
				}
			});

			edtlactpmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtlactpmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edtlactpmh.field('lactpmh.kode').val();
					nama = edtlactpmh.field('lactpmh.nama').val();

					validasiRequired(
						edtlactpmh,
						'lactpmh',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtlactpmh,
						'lactpmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_lactpmh
					);

					validasiUnique(
						action,
						edtlactpmh,
						'lactpmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_lactpmh
					);
				}
				
				if ( edtlactpmh.inError() ) {
					return false;
				}
			});
			
			edtlactpmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtlactpmh.field('lactpmh.finish_at').val(finish_at);
			});

			edtlactpmh.on( 'close', function () {
				edtlactpmh.enable();
			} );

			tbllactpmh = $('#tbllactpmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/lactpmh/lactpmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_lactpmh = show_deleted_lactpmh;
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
					{ data: "lactpmh.id",visible:false },
					{ data: "lactpmh.kode" },
					{ data: "lactpmh.nama" },
					{ data: "lactpmh.keterangan" },
					{ 
						data: "lactpmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_lactpmh';
						$table       = 'tbllactpmh';
						$edt         = 'edtlactpmh';
						$show_status = '_lactpmh';
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
					if ( data.lactpmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.lactpmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbllactpmh.searchPanes.container().appendTo('#splactpmh');
			tbllactpmh.searchBuilder.container().appendTo( '#sblactpmh' );
			
			tbllactpmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbllactpmh);
			} );
			
			tbllactpmh.on( 'select', function( e, dt, type, indexes ) {
				lactpmh_data    		= tbllactpmh.row( { selected: true } ).data().lactpmh;
				id_lactpmh      		= lactpmh_data.id;
				id_transaksi_h 		= id_lactpmh; // dipakai untuk general
				id_transaksi_log	= id_lactpmh; // dipakai untuk general
				transaction_state   = lactpmh_data.transaction_state;
				approval_state   	= lactpmh_data.approval_state;
				is_nextprocess 		= lactpmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tbllactpmh);
			} );

			tbllactpmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_lactpmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tbllactpmh);
			} );

			// END lactpmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
