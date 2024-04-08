<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ndrxxtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblndrxxtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document No</th>
                                <th>Tanggal Jam Masuk</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndrxxtd/fn/ndrxxtd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtndrxxtd, tblndrxxtd, show_deleted_ndrxxtd = 0, id_ndrxxtd;
		// ------------- end of default variable

		var id_grlxxmh_expedisi_old = 0;
		
		// get tableRelation
		tableRelation('ndrxxtd');

		$(document).ready(function() {
			// BEGIN ndrxxtd
			edtndrxxtd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/ndrxxtd/ndrxxtd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ndrxxtd = show_deleted_ndrxxtd;
					}
				},
				table: "#tblndrxxtd",
				fields: [ 
					{
						label: "ndrxxtd.start_at",
						name: "ndrxxtd.start_at",
						type: "hidden"
					},	
					{
						label: "ndrxxtd.finish_at",
						name: "ndrxxtd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "ndrxxtd",
						type: "hidden"
					},	
					{
						label: "ndrxxtd.transaction_state",
						name: "ndrxxtd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Document No <sup class='text-danger'>*<sup>",
						name: "ndrxxtd.dokumen_nomor"
					}, 	
					{
						label: "Tanggal Jam Masuk <sup class='text-danger'>*<sup>",
						name: "ndrxxtd.tanggal_jam_terima",
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
						name: "ndrxxtd.pengirim"
					},
					{
						label: "Ditujukan Kepada <sup class='text-danger'>*<sup>",
						name: "ndrxxtd.kepada"
					},
					{
						label: "Courier / Expedition",
						name: "ndrxxtd.id_grlxxmh_expedisi",
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
						name: "ndrxxtd.keterangan",
						type: "textarea"
					}
				]
			} );

			edtndrxxtd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtndrxxtd.field('ndrxxtd.start_at').val(start_at);
				
				if(action == 'create'){
					tblndrxxtd.rows().deselect();
				}
			});

			edtndrxxtd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtndrxxtd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					dokumen_nomor = edtndrxxtd.field('ndrxxtd.dokumen_nomor').val();
					tanggal_jam_terima = edtndrxxtd.field('ndrxxtd.tanggal_jam_terima').val();
					pengirim = edtndrxxtd.field('ndrxxtd.pengirim').val();
					kepada = edtndrxxtd.field('ndrxxtd.kepada').val();

					validasiRequired(
						edtndrxxtd,
						'ndrxxtd',
						{
							'dokumen_nomor': dokumen_nomor,
							'tanggal_jam_terima': tanggal_jam_terima,
							'pengirim': pengirim,
							'kepada': kepada
						}
					);

				}
				
				if ( edtndrxxtd.inError() ) {
					return false;
				}
			});
			
			edtndrxxtd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtndrxxtd.field('ndrxxtd.finish_at').val(finish_at);
			});

			edtndrxxtd.on( 'close', function () {
				edtndrxxtd.enable();
			} );

			tblndrxxtd = $('#tblndrxxtd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/ndrxxtd/ndrxxtd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ndrxxtd = show_deleted_ndrxxtd;
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
					{ data: "ndrxxtd.id",visible:false },
					{ data: "ndrxxtd.dokumen_nomor" },
					{ data: "ndrxxtd.tanggal_jam_terima" },
					{ data: "ndrxxtd.pengirim" },
					{ data: "ndrxxtd.kepada" },
					{ data: "ndrxxtd.keterangan" },
					{ 
						data: "ndrxxtd.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_ndrxxtd';
						$table       = 'tblndrxxtd';
						$edt         = 'edtndrxxtd';
						$show_status = '_ndrxxtd';
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
					if ( data.ndrxxtd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.ndrxxtd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblndrxxtd.searchPanes.container().appendTo('#spndrxxtd');
			tblndrxxtd.searchBuilder.container().appendTo( '#sbndrxxtd' );
			
			tblndrxxtd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblndrxxtd);
			} );
			
			tblndrxxtd.on( 'select', function( e, dt, type, indexes ) {
				ndrxxtd_data    		= tblndrxxtd.row( { selected: true } ).data().ndrxxtd;
				id_ndrxxtd      		= ndrxxtd_data.id;
				id_transaksi_h 		= id_ndrxxtd; // dipakai untuk general
				id_transaksi_log	= id_ndrxxtd; // dipakai untuk general
				transaction_state   = ndrxxtd_data.transaction_state;
				approval_state   	= ndrxxtd_data.approval_state;
				is_nextprocess 		= ndrxxtd_data.is_nextprocess;

				id_grlxxmh_expedisi_old	= ndrxxtd_data.id_grlxxmh_expedisi;

				// atur hak akses
				CekSelectHeaderH(tblndrxxtd);
			} );

			tblndrxxtd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ndrxxtd = 0;
				id_grlxxmh_expedisi_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblndrxxtd);
			} );

			// END ndrxxtd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
