<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iitxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliitxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tax Type</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iitxxmh/fn/iitxxmh_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiitxxmh, tbliitxxmh, show_deleted_iitxxmh = 0, id_iitxxmh;
		// ------------- end of default variable

		is_master_table = 1;

		var id_ftxxxmh_old = 0;
		
		$(document).ready(function() {
			//start datatables editor
			edtiitxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iitxxmh/iitxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iitxxmh = show_deleted_iitxxmh;
					}
				},
				table: "#tbliitxxmh",
				fields: [ 
					{
						label: "iitxxmh.start_at",
						name: "iitxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "iitxxmh.finish_at",
						name: "iitxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iitxxmh",
						type: "hidden"
					},	
					{
						label: "iitxxmh.transaction_state",
						name: "iitxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iitxxmh.nama"
					}, 	
					{
						label: "Tax Type",
						name: "iitxxmh.id_ftxxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/ftxxxmh/ftxxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_ftxxxmh_old: id_ftxxxmh_old,
										search: params.term || '',
										page: params.page || 1
									}
										return query;
								},
								processResults: function (data, params) {
									return {
										results: data.results,
										pagination: {
											more: true
										}
									};
								},
								cache: true,
								minimumInputLength: 1,
								maximum: 10,
								delay: 500,
								maximumSelectionLength: 5,
								minimumResultsForSearch: -1,
							},
						}
					},
					{
						label: "Keterangan",
						name: "iitxxmh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiitxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiitxxmh.field('iitxxmh.start_at').val(start_at);

				if(action == 'create'){
					tbliitxxmh.rows().deselect();
				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtiitxxmh.field('iitxxmh.kode').enable();
						edtiitxxmh.field('iitxxmh.nama').enable();
					}else{
						edtiitxxmh.field('iitxxmh.kode').disable();
						edtiitxxmh.field('iitxxmh.nama').disable();
					}
				}
			});

			edtiitxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiitxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama = edtiitxxmh.field('iitxxmh.nama').val();
					validasiRequired(
						edtiitxxmh, 
						"iitxxmh", 
						{
							"nama": nama
						}
					)

					validasiUnique(
						action,
						edtiitxxmh, 
						'iitxxmh', 
						'nama', 
						'nama',
						'"'+nama+'"',
						id_iitxxmh
					);
				}
				
				if ( edtiitxxmh.inError() ) {
					return false;
				}
			});
			
			edtiitxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiitxxmh.field('iitxxmh.finish_at').val(finish_at);
			});

			edtiitxxmh.on( 'close', function () {
				edtiitxxmh.enable();
			} );

			//start datatables
			tbliitxxmh = $('#tbliitxxmh').DataTable( {
				ajax: {
					url: "../../models/iitxxmh/iitxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iitxxmh = show_deleted_iitxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "iitxxmh.id",visible:false },
					{ data: "iitxxmh.nama" },
					{ data: "ftxxxmh.kode" },
					{ data: "iitxxmh.keterangan" },
					{ 
						data: "iitxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iitxxmh';
						$table       = 'tbliitxxmh';
						$edt         = 'edtiitxxmh';
						$show_status = '_iitxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
				},
				rowCallback: function( row, data, index ) {
					if ( data.iitxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iitxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliitxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliitxxmh);
			} );
			
			tbliitxxmh.on( 'select', function( e, dt, type, indexes ) {
				iitxxmh_data    	= tbliitxxmh.row( { selected: true } ).data().iitxxmh;
				id_iitxxmh      	= iitxxmh_data.id;
				id_transaksi_h 		= id_iitxxmh; // dipakai untuk general
				id_transaksi_log	= id_iitxxmh; // dipakai untuk general
				transaction_state   = iitxxmh_data.transaction_state;
				is_defaultprogram   = iitxxmh_data.is_defaultprogram;
				id_ftxxxmh_old   	= iitxxmh_data.id_ftxxxmh;

				// atur hak akses
				CekSelectHeaderH(tbliitxxmh);
			} );

			tbliitxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iitxxmh = '';

				// atur hak akses
				CekDeselectHeaderH(tbliitxxmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
