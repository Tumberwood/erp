<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ljoxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblljoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Expedition</th>
                                <th>Plate No</th>
                                <th>Vehicle Type</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ljoactd_booking/fn/ljoactd_booking_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtljoxxth, tblljoxxth, show_deleted_ljoxxth = 0, id_ljoxxth;
		// ------------- end of default variable
		
		var id_lexxxmh_old = 0, id_lacxxmh_old = 0, id_lvtxxmh_old = 0;

		// get tableRelation
		tableRelation('ljoxxth');

		$(document).ready(function() {
			
			// BEGIN ljoxxth
			edtljoxxth = new $.fn.dataTable.Editor( {
				formOptions: {
					main: {
						focus: 3,
					}
				},
				ajax: {
					url: "../../models/ljoactd_booking/ljoactd_booking.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ljoxxth = show_deleted_ljoxxth;
					}
				},
				table: "#tblljoxxth",
				fields: [ 
					{
						label: "ljoxxth.start_at",
						name: "ljoxxth.start_at",
						type: "hidden"
					},	
					{
						label: "ljoxxth.finish_at",
						name: "ljoxxth.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "ljoxxth",
						type: "hidden"
					},	
					{
						label: "ljoxxth.transaction_state",
						name: "ljoxxth.transaction_state",
						type: "hidden",
						def: 0
					},
					{
						label: "Tanggal <sup class='text-danger'>*<sup>",
						name: "ljoxxth.tanggal",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY'
					},
					{
						label: "Activity <sup class='text-danger'>*<sup>",
						name: "ljoxxth.id_lacxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/lacxxmh/lacxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_lacxxmh_old: id_lacxxmh_old,
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
						label: "Expedition",
						name: "ljoxxth.id_lexxxmh",
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
										id_lexxxmh_old: id_lexxxmh_old,
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
						label: "Vehicle Type <sup class='text-danger'>*<sup>",
						name: "ljoxxth.id_lvtxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/lvtxxmh/lvtxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_lvtxxmh_old: id_lvtxxmh_old,
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
						label: "Plat No",
						name: "ljoxxth.plat_no",
					},
					{
						label: "Supir",
						name: "ljoxxth.supir_nama",
					},
					{
						label: "Kernet",
						name: "ljoxxth.kernet_nama",
					},
					{
						label: "Keterangan",
						name: "ljoxxth.keterangan",
						type: "textarea"
					}
				]
			} );

			edtljoxxth.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtljoxxth.field('ljoxxth.start_at').val(start_at);
				
				if(action == 'create'){
					tblljoxxth.rows().deselect();
				}
			});

			edtljoxxth.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtljoxxth.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					tanggal    = edtljoxxth.field('ljoxxth.tanggal').val();
					id_lacxxmh = edtljoxxth.field('ljoxxth.id_lacxxmh').val();
					id_lvtxxmh = edtljoxxth.field('ljoxxth.id_lvtxxmh').val();

					validasiRequired(
						edtljoxxth,
						'ljoxxth',
						{
							'tanggal': tanggal,
							'id_lacxxmh': id_lacxxmh,
							'id_lvtxxmh': id_lvtxxmh
						}
					);
					
				}
				
				if ( edtljoxxth.inError() ) {
					return false;
				}
			});
			
			edtljoxxth.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtljoxxth.field('ljoxxth.finish_at').val(finish_at);
			});

			edtljoxxth.on( 'close', function () {
				edtljoxxth.enable();
			} );

			tblljoxxth = $('#tblljoxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/ljoactd_booking/ljoactd_booking.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ljoxxth = show_deleted_ljoxxth;
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
					{ data: "ljoxxth.id",visible:false },
					{ data: "ljoxxth.kode" },
					{ data: "ljoxxth.tanggal" },
					{ data: "lexxxmh.nama" },
					{ data: "ljoxxth.plat_no" },
					{ data: "lvtxxmh.nama" },
					{ 
						data: "ljoxxth.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_ljoxxth';
						$table       = 'tblljoxxth';
						$edt         = 'edtljoxxth';
						$show_status = '_ljoxxth';
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
					if ( data.ljoxxth.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.ljoxxth.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblljoxxth.searchPanes.container().appendTo('#spljoxxth');
			tblljoxxth.searchBuilder.container().appendTo( '#sbljoxxth' );
			
			tblljoxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblljoxxth);
			} );
			
			tblljoxxth.on( 'select', function( e, dt, type, indexes ) {
				ljoxxth_data      = tblljoxxth.row( { selected: true } ).data().ljoxxth;
				id_ljoxxth        = ljoxxth_data.id;
				id_transaksi_h    = id_ljoxxth;                                           // dipakai untuk general
				id_transaksi_log  = id_ljoxxth;                                           // dipakai untuk general
				transaction_state = ljoxxth_data.transaction_state;
				approval_state    = ljoxxth_data.approval_state;
				is_nextprocess    = ljoxxth_data.is_nextprocess;

				id_lexxxmh_old    = ljoxxth_data.id_lexxxmh;
				id_lacxxmh_old    = ljoxxth_data.id_lacxxmh;
				id_lvtxxmh_old    = ljoxxth_data.id_lvtxxmh;

				// atur hak akses
				CekSelectHeaderH(tblljoxxth);
			} );

			tblljoxxth.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ljoxxth = 0;
				id_lexxxmh_old = 0, id_lacxxmh_old = 0, id_lvtxxmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblljoxxth);
			} );

			// END ljoxxth
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
