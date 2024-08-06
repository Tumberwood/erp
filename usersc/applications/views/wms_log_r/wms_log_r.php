<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wms_log_r';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				
				<div class="modal" id="modalSFwms_log_r" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwms_log_r" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>id_transaksi</th>
                                <th>Activity</th>
                                <th>Kode</th>
                                <th>Warehouse</th>
                                <th>Location</th>
                                <th>Username</th>
                                <th>Start</th>
                                <th>Finish</th>
                                <th>Durasi</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wms_log_r/fn/wms_log_r_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwms_log_r, tblwms_log_r, show_deleted_wms_log_r = 0, id_wms_log_r;
		// ------------- end of default variable

		// get tableRelation
		// tableRelation('wms_log_rheader');
		$('#start_date').datepicker('setDate', tanggal_hariini_dmy);

		$(document).ready(function() {
			start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			
			tblwms_log_r = $('#tblwms_log_r').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/wms_log_r/wms_log_r.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wms_log_r = show_deleted_wms_log_r;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [2,3,4,5,6]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				order: [[ 7, "desc" ]],
				columns: [
					{ data: "id",visible:false },
					{ data: "id_transaksi",visible:false },
					{ data: "activity" },
					{ data: "kode_transaksi" },
					{ data: "iwhxxmh_kode" },
					{ data: "wloxxmh_nama" },
					{ data: "username" },
					{
						data: "start_on",
						render: function(data, type, row) {
							if (type === 'sp') {
								return moment(data).format('DD MMM YYYY');
							} else {
								return data;
							}
						},
						searchPanes: {
							orthogonal: 'sp',
							show: true
						}
					},
					{ data: "finish_on" },
					{ 
						data: "durasi",
						render: function (data){
							if(data){
								waktu_tunggu = moment.duration(data, 'seconds');
								waktu_tunggu_humanize = waktu_tunggu.format("d [days], h [hrs], m [min], s [sec]");
								return waktu_tunggu_humanize;
							}else{
								return '';
							}
						}
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wms_log_r';
						$table       = 'tblwms_log_r';
						$edt         = 'edtwms_log_r';
						$show_status = '_wms_log_r';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['copy','excel','colvis'];
						$arr_buttons_tools2 	= [ 'sf','sp', 'sb'];
						$arr_buttons_action 	= [];
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

			tblwms_log_r.searchPanes.container().appendTo('#spwms_log_r');
			tblwms_log_r.searchBuilder.container().appendTo( '#sbwms_log_r' );
			
			// END wms_log_r
			// BEGIN form filter
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					start_date: {
						required: true,
						validDate: "DD MMM YYYY"
					},
					end_date: {
						required: true,
						validDate: "DD MMM YYYY"
					}
				},
				messages: {
					start_date: {
						required: "Start Date Wajib Diisi!"
					},
					end_date: {
						required: "End Date Wajib Diisi!"
					}
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date   = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblwms_log_r.rows().deselect();
					tblwms_log_r.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFwms_log_r').modal('toggle');
				}, false);
					return false;
				}
			});
			// END form filter
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
