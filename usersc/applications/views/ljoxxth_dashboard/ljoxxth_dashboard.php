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
				<div class="modal" id="modalSFljoxxth" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode">
												<input type="text" id="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblljoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Plate No</th>
                                <th rowspan="2">Expedition</th>
                                <th rowspan="2">Vehicle Type</th>
                                <th rowspan="2">Driver</th>
                                <th rowspan="2">Load</th>
                                <th colspan="4">Time</th>
                            </tr>
							<tr>
                                <th>Booking</th>
                                <th>Arrival</th>
                                <th>Clearance</th>
                                <th>Done</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ljoxxth/fn/ljoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtljoxxth, tblljoxxth, show_deleted_ljoxxth = 0, id_ljoxxth;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('ljoxxth');

		// BEGIN datepicker init
		$('#periode').datepicker({
			setDate: new Date(),
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			format: "dd M yyyy",
			minViewMode: 'month' 
		});
		$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
		$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
		// END datepicker init

		$(document).ready(function() {
			
			start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	

			tblljoxxth = $('#tblljoxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/ljoxxth_dashboard/ljoxxth_dashboard.php",
					type: 'POST',
					data: function (d){
						d.start_date = start_date;
						d.end_date = end_date;
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
					{ data: "id",visible:false },
					{ data: "tanggal" },
					{ data: "plat_no" },
					{ data: "grlxxmh_expedition_nama" },
					{ data: "lvtxxmh_nama" },
					{ data: "supir_nama" },
					{ data: "berat_muatan" },
					{ data: "waktu_booking" },
					{ data: "waktu_arrival" },
					{ data: "waktu_clearance" },
					{ data: "waktu_done" }
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
						$arr_buttons_tools2 	= ['sf','sp', 'sb'];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					// if ( data.ljoxxth.transaction_state == -9 ) {
					// 	$('td', row).addClass('text-danger');
					// }else if ( data.ljoxxth.transaction_state == 0 ) {
					// 	$('td', row).addClass('text-warning');
					// }
				}
			} );

			tblljoxxth.searchPanes.container().appendTo('#spljoxxth');
			tblljoxxth.searchBuilder.container().appendTo( '#sbljoxxth' );
			
			tblljoxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblljoxxth);
			} );
			
			tblljoxxth.on( 'select', function( e, dt, type, indexes ) {
				ljoxxth_data    		= tblljoxxth.row( { selected: true } ).data().ljoxxth;
				id_ljoxxth      		= ljoxxth_data.id;
				id_transaksi_h 		= id_ljoxxth; // dipakai untuk general
				id_transaksi_log	= id_ljoxxth; // dipakai untuk general
				transaction_state   = ljoxxth_data.transaction_state;
				approval_state   	= ljoxxth_data.approval_state;
				is_nextprocess 		= ljoxxth_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblljoxxth);
			} );

			tblljoxxth.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ljoxxth = 0;

				// atur hak akses
				CekDeselectHeaderH(tblljoxxth);
			} );

			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblljoxxth.rows().deselect();
					tblljoxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFljoxxth').modal('toggle');
				}, false);
					return false;
				}
			});

			// END ljoxxth
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
