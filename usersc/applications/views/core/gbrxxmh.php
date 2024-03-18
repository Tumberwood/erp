<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gbrxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgbrxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cabang</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Perusahaan</th>
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

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgbrxxmh, tblgbrxxmh, show_deleted_gbrxxmh = 0, id_gbrxxmh;
		// ------------- end of default variable

		var id_gctxxmh_old = 0, id_gcpxxmh_old = 0;

		// get tableRelation
		tableRelation('gcpxxmh');

		$(document).ready(function() {

			// BEGIN gbrxxmh
			edtgbrxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/gbrxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gbrxxmh = show_deleted_gbrxxmh;
					}
				},
				table: "#tblgbrxxmh",
				fields: [ 
					{
						label: "gbrxxmh.start_at",
						name: "gbrxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "gbrxxmh.finish_at",
						name: "gbrxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gbrxxmh",
						type: "hidden"
					},	
					{
						label: "gbrxxmh.transaction_state",
						name: "gbrxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},
					{
						label: "Cabang <sup class='text-danger'>*<sup>",
						name: "gbrxxmh.nama"
					}, 	
					{
						label: "Alamat <sup class='text-danger'>*<sup>",
						name: "gbrxxmh.alamat"
					},	
					{
						label: "Kota <sup class='text-danger'>*<sup>",
						name: "gbrxxmh.id_gctxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/core/gctxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_gctxxmh_old: id_gctxxmh_old,
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
						label: "Perusahaan <sup class='text-danger'>*<sup>",
						name: "gbrxxmh.id_gcpxxmh",
                        type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/core/gcpxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_gcpxxmh_old: id_gcpxxmh_old,
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
						label: "Latitude",
						name: "gbrxxmh.lat",
                        type: "readonly"
					}, 	
					{
						label: "Longitude",
						name: "gbrxxmh.lng",
                        type: "readonly"
					}, 
					{
						label: "Maps",
						name: "tes_maps"
					}
				]
			} );

			edtgbrxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgbrxxmh.field('gbrxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgbrxxmh.rows().deselect();
				}
			});

			edtgbrxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtgbrxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama       = edtgbrxxmh.field('gbrxxmh.nama').val();
					alamat     = edtgbrxxmh.field('gbrxxmh.alamat').val();
					id_gctxxmh = edtgbrxxmh.field('gbrxxmh.id_gctxxmh').val();
					id_gcpxxmh = edtgbrxxmh.field('gbrxxmh.id_gcpxxmh').val();

					validasiRequired(
						edtgbrxxmh,
						'gbrxxmh',
						{
							'nama'      : nama,
							'alamat'    : alamat,
							'id_gctxxmh': id_gctxxmh,
							'id_gcpxxmh': id_gcpxxmh
						}
					);

				}
				
				if ( edtgbrxxmh.inError() ) {
					return false;
				}
			});

			edtgbrxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgbrxxmh.field('gbrxxmh.finish_at').val(finish_at);
			});

			edtgbrxxmh.on( 'close', function () {
				edtgbrxxmh.enable();
			} );
			
			tblgbrxxmh = $('#tblgbrxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/core/gbrxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gbrxxmh = show_deleted_gbrxxmh;
					}
				},
				order: [[ 2, "asc" ],[1,"asc"]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,3,4]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0,2]
					}
				],
				columns: [
					{ data: "gbrxxmh.id",visible:false },
					{ data: "gbrxxmh.nama" },
					{ data: "gbrxxmh.alamat" },
					{ data: "gctxxmh.nama" },
					{ data: "gcpxxmh.nama" },
					{ 
						data: "gbrxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gbrxxmh';
						$table       = 'tblgbrxxmh';
						$edt         = 'edtgbrxxmh';
						$show_status = '_gbrxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide', 'copy', 'excel', 'colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
				}
			} );

			tblgbrxxmh.searchPanes.container().appendTo('#spgbrxxmh');
			tblgbrxxmh.searchBuilder.container().appendTo( '#sbgbrxxmh' );
			
			tblgbrxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgbrxxmh);
			} );
			
			tblgbrxxmh.on( 'select', function( e, dt, type, indexes ) {
				gbrxxmh_data    	= tblgbrxxmh.row( { selected: true } ).data().gbrxxmh;
				id_gbrxxmh      	= gbrxxmh_data.id;
				id_transaksi_h 		= id_gbrxxmh; // dipakai untuk general
				id_transaksi_log	= id_gbrxxmh; // dipakai untuk general
				transaction_state   = gbrxxmh_data.transaction_state;
				approval_state   	= gbrxxmh_data.approval_state;
				is_nextprocess 		= gbrxxmh_data.is_nextprocess;

				id_gctxxmh_old = gbrxxmh_data.id_gctxxmh;
				id_gcpxxmh_old = gbrxxmh_data.id_gcpxxmh;

				// atur hak akses
				CekSelectHeaderH(tblgbrxxmh);
			} );

			tblgbrxxmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_gbrxxmh = 0;
				id_gctxxmh_old = 0;
				id_gcpxxmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblgbrxxmh);
			} );
			// END gbrxxmh
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
