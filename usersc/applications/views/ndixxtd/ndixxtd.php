<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ndixxtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndixxtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document No</th>
                                <th>Tanggal Jam Keluar</th>
                                <th>Pengirim</th>
                                <th>Ditujukan Kepada</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndixxtd/fn/ndixxtd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtndixxtd, tblndixxtd, show_deleted_ndixxtd = 0, id_ndixxtd;
		// ------------- end of default variable

		var id_grlxxmh_expedisi_old = 0;
		
		// get tableRelation
		tableRelation('ndixxtd');

		$(document).ready(function() {
			// BEGIN ndixxtd
			edtndixxtd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/ndixxtd/ndixxtd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ndixxtd = show_deleted_ndixxtd;
					}
				},
				table: "#tblndixxtd",
				fields: [ 
					{
						label: "ndixxtd.start_at",
						name: "ndixxtd.start_at",
						type: "hidden"
					},	
					{
						label: "ndixxtd.finish_at",
						name: "ndixxtd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "ndixxtd",
						type: "hidden"
					},	
					{
						label: "ndixxtd.transaction_state",
						name: "ndixxtd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Document No <sup class='text-danger'>*<sup>",
						name: "ndixxtd.dokumen_nomor"
					}, 	
					{
						label: "Tanggal Jam Keluar <sup class='text-danger'>*<sup>",
						name: "ndixxtd.tanggal_jam_kirim",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Pengirim <sup class='text-danger'>*<sup>",
						name: "ndixxtd.pengirim"
					},
					{
						label: "Ditujukan Kepada <sup class='text-danger'>*<sup>",
						name: "ndixxtd.kepada"
					},
					{
						label: "Courier / Expedition",
						name: "ndixxtd.id_grlxxmh_expedisi",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/lexxxmh/lexxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_grlxxmh_old: id_grlxxmh_expedisi_old,
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
						name: "ndixxtd.keterangan",
						type: "textarea"
					}
				]
			} );

			edtndixxtd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtndixxtd.field('ndixxtd.start_at').val(start_at);
				
				if(action == 'create'){
					tblndixxtd.rows().deselect();
				}
			});

			edtndixxtd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtndixxtd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					dokumen_nomor = edtndixxtd.field('ndixxtd.dokumen_nomor').val();
					tanggal_jam_kirim = edtndixxtd.field('ndixxtd.tanggal_jam_kirim').val();
					pengirim = edtndixxtd.field('ndixxtd.pengirim').val();
					kepada = edtndixxtd.field('ndixxtd.kepada').val();

					validasiRequired(
						edtndixxtd,
						'ndixxtd',
						{
							'dokumen_nomor': dokumen_nomor,
							'tanggal_jam_kirim': tanggal_jam_kirim,
							'pengirim': pengirim,
							'kepada': kepada
						}
					);

				}
				
				if ( edtndixxtd.inError() ) {
					return false;
				}
			});
			
			edtndixxtd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtndixxtd.field('ndixxtd.finish_at').val(finish_at);
			});

			edtndixxtd.on( 'close', function () {
				edtndixxtd.enable();
			} );

			tblndixxtd = $('#tblndixxtd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/ndixxtd/ndixxtd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ndixxtd = show_deleted_ndixxtd;
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
					{ data: "ndixxtd.id",visible:false },
					{ data: "ndixxtd.dokumen_nomor" },
					{ data: "ndixxtd.tanggal_jam_kirim" },
					{ data: "ndixxtd.pengirim" },
					{ data: "ndixxtd.kepada" },
					{ data: "ndixxtd.keterangan" },
					{ 
						data: "ndixxtd.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_ndixxtd';
						$table       = 'tblndixxtd';
						$edt         = 'edtndixxtd';
						$show_status = '_ndixxtd';
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
					if ( data.ndixxtd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.ndixxtd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblndixxtd.searchPanes.container().appendTo('#spndixxtd');
			tblndixxtd.searchBuilder.container().appendTo( '#sbndixxtd' );
			
			tblndixxtd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblndixxtd);
			} );
			
			tblndixxtd.on( 'select', function( e, dt, type, indexes ) {
				ndixxtd_data    		= tblndixxtd.row( { selected: true } ).data().ndixxtd;
				id_ndixxtd      		= ndixxtd_data.id;
				id_transaksi_h 		= id_ndixxtd; // dipakai untuk general
				id_transaksi_log	= id_ndixxtd; // dipakai untuk general
				transaction_state   = ndixxtd_data.transaction_state;
				approval_state   	= ndixxtd_data.approval_state;
				is_nextprocess 		= ndixxtd_data.is_nextprocess;

				id_grlxxmh_expedisi_old	= ndixxtd_data.id_grlxxmh_expedisi;

				// atur hak akses
				CekSelectHeaderH(tblndixxtd);
			} );

			tblndixxtd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ndixxtd = 0;
				id_grlxxmh_expedisi_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblndixxtd);
			} );

			// END ndixxtd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
