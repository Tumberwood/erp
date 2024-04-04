<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ljoprtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblljoprtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Activity</th>
                                <th>Expedition</th>
                                <th>Vehicle Type</th>
                                <th>Start</th>
                                <th>Finish</th>
                                <th>Duration</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ljoprtd_arrival/fn/ljoprtd_arrival_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtljoprtd, tblljoprtd, show_deleted_ljoprtd = 0, id_ljoprtd;
		// ------------- end of default variable

		id_lacxxmh_old = 0, id_lvtxxmh_old = 0, id_grlxxmh_old = 0;
		
		// get tableRelation
		tableRelation('ljoprtd');

		$(document).ready(function() {
			// BEGIN ljoprtd
			edtljoprtd = new $.fn.dataTable.Editor( {
				formOptions: {
					main: {
						focus: 3,
					}
				},
				ajax: {
					url: "../../models/ljoprtd_arrival/ljoprtd_arrival.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ljoprtd = show_deleted_ljoprtd;
					}
				},
				table: "#tblljoprtd",
				fields: [ 
					{
						label: "ljoprtd.start_at",
						name: "ljoprtd.start_at",
						type: "hidden"
					},	
					{
						label: "ljoprtd.finish_at",
						name: "ljoprtd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "ljoprtd",
						type: "hidden"
					},	
					{
						label: "ljoprtd.transaction_state",
						name: "ljoprtd.transaction_state",
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
						label: "Expedition <sup class='text-danger'>*<sup>",
						name: "ljoxxth.id_grlxxmh_expedition",
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
										id_grlxxmh_old: id_grlxxmh_old,
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

			edtljoprtd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtljoprtd.field('ljoprtd.start_at').val(start_at);
				
				if(action == 'create'){
					tblljoprtd.rows().deselect();
				}
			});

			edtljoprtd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtljoprtd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					tanggal = edtljoprtd.field('ljoxxth.tanggal').val();
					id_lacxxmh = edtljoprtd.field('ljoxxth.id_lacxxmh').val();
					id_grlxxmh_expedition = edtljoprtd.field('ljoxxth.id_grlxxmh_expedition').val();
					id_lvtxxmh = edtljoprtd.field('ljoxxth.id_lvtxxmh').val();

					validasiRequired(
						edtljoprtd,
						'ljoxxth',
						{
							'tanggal': tanggal,
							'id_lacxxmh': id_lacxxmh,
							'id_grlxxmh_expedition': id_grlxxmh_expedition,
							'id_lvtxxmh': id_lvtxxmh
						}
					);

				}
				
				if ( edtljoprtd.inError() ) {
					return false;
				}
			});
			
			edtljoprtd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtljoprtd.field('ljoprtd.finish_at').val(finish_at);
			});

			edtljoprtd.on( 'close', function () {
				edtljoprtd.enable();
			} );

			tblljoprtd = $('#tblljoprtd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/ljoprtd_arrival/ljoprtd_arrival.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ljoprtd = show_deleted_ljoprtd;
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
						targets: [0,4]
					}
				],
				columns: [
					{ data: "ljoprtd.id",visible:false },
					{ data: "ljoxxth.id",visible:false },
					{ data: "ljoxxth.kode" },
					{ data: "ljoxxth.tanggal" },
					{ data: "lacxxmh.nama" },
					{ data: "grlxxmh.nama" },
					{ data: "lvtxxmh.nama" },
					{ data: "ljoprtd.tanggaljam_start" },
					{ data: "ljoprtd.tanggaljam_finish" },
					{ 
						data: "ljoprtd.durasi_detik" ,
						...renderNumber(0)
					},
					{ 
						data: "ljoprtd.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_ljoprtd';
						$table       = 'tblljoprtd';
						$edt         = 'edtljoprtd';
						$show_status = '_ljoprtd';
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
					if ( data.ljoprtd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.ljoprtd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblljoprtd.searchPanes.container().appendTo('#spljoprtd');
			tblljoprtd.searchBuilder.container().appendTo( '#sbljoprtd' );
			
			tblljoprtd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblljoprtd);
			} );
			
			tblljoprtd.on( 'select', function( e, dt, type, indexes ) {
				ljoprtd_data    		= tblljoprtd.row( { selected: true } ).data().ljoprtd;
				ljoxxth_data    		= tblljoprtd.row( { selected: true } ).data().ljoxxth;
				id_ljoprtd      		= ljoprtd_data.id;
				id_transaksi_h 		= id_ljoprtd; // dipakai untuk general
				id_transaksi_log	= id_ljoprtd; // dipakai untuk general
				transaction_state   = ljoprtd_data.transaction_state;
				approval_state   	= ljoprtd_data.approval_state;
				is_nextprocess 		= ljoprtd_data.is_nextprocess;

				id_lacxxmh_old 		= ljoxxth_data.id_lacxxmh;
				id_lvtxxmh_old 		= ljoxxth_data.id_lvtxxmh;
				id_grlxxmh_old 		= ljoxxth_data.id_grlxxmh_expedition;

				// atur hak akses
				CekSelectHeaderH(tblljoprtd);
			} );

			tblljoprtd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ljoprtd = 0;

				id_lacxxmh_old = 0, id_lvtxxmh_old = 0, id_grlxxmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblljoprtd);
			} );

			// END ljoprtd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
