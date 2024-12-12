<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wdpxxth';
	$nama_tabels_d = [];
?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFwdpxxth" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-8">
											<div class="input-group input-daterange" id="periodeDatetime">
												<input type="text" id="start_dateDatetime" class="form-control datetimepicker">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_dateDatetime" class="form-control datetimepicker">
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
                    <table id="tblwdpxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>id_wdpxxth</th>
								<th>Tanggal</th>
								<th>Kode</th>
								<th>User</th>
								<th>Warehouse</th>
								<th>Lokasi Asal</th>
								<th>Lokasi Tujuan</th>
								<th>LPN</th>
								<th>Item Code</th>
								<th>Item Name</th>
								<th>UoM</th>
								<th>Jumlah Unit</th>
								<th>Batch Number</th>
								<th>Expired Date</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdpxxrd/fn/wdpxxrd_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwdpxxth, tblwdpxxth, show_deleted_wdpxxth = 0, id_wdpxxth;
		// ------------- end of default variable
		$('.datetimepicker').datetimepicker({
			format: 'DD MMM YYYY HH:mm',
			useCurrent: false,
			sideBySide: true,
		});

		$('#start_dateDatetime').data('DateTimePicker').date(moment(awal_bulan_dmy, 'DD MMM YYYY HH:mm'));
		var lastDayOfMonthHour = moment().endOf('month').set({ hour: 23, minute: 59, second: 0, millisecond: 0 });
    	$('#end_dateDatetime').data('DateTimePicker').date(lastDayOfMonthHour);

		// get tableRelation
		tableRelation('wdpxxth');
		
		$(document).ready(function() {
			start_date = moment($('#start_dateDatetime').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
			end_date = moment($('#end_dateDatetime').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
			
			tblwdpxxth = $('#tblwdpxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/wdpxxrd/wdpxxrd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wdpxxth = show_deleted_wdpxxth;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				order: [[ 2, "desc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [2,5,6]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				columns: [
					{ data: "wdplptd.id",visible:false },
					{ data: "wdplptd.id_wdpxxth",visible:false },
					{ data: "tanggal_confirm" },
					{ data: "wdplptd.kode" },
					{ data: "username" },
					{ data: "iwhxxmh.kode" },
					{ data: "asal.nama" },
					{ data: "tujuan.nama" },
					{ data: "wdplptd.wlpxxmh_kode" },
					{ data: "iimxxmh.kode" },
					{ data: "iimxxmh.nama" },
					{ data: "iumxxmh.kode" },
					{ 
						data: "wdplptd.jumlah_unit", //4
						...renderNumber(2)
					},
					{ data: "wdplptd.batch_number" },
					{ data: "wdplptd.expired_date" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wdpxxth';
						$table       = 'tblwdpxxth';
						$edt         = 'edtwdpxxth';
						$show_status = '_wdpxxth';
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
					if ( data.wdpxxth.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.wdpxxth.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblwdpxxth.searchPanes.container().appendTo('#spwdpxxth');
			tblwdpxxth.searchBuilder.container().appendTo( '#sbwdpxxth' );
			
			tblwdpxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwdpxxth);
			} );
			
			tblwdpxxth.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('wdpxxth');

				// atur hak akses
				CekSelectHeaderH(tblwdpxxth);
			} );

			tblwdpxxth.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('wdpxxth');

				// atur hak akses
				CekDeselectHeaderH(tblwdpxxth);
			} );

			// END wdpxxth
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_dateDatetime').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
					end_date = moment($('#end_dateDatetime').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					console.log(start_date);
					console.log(end_date);

					tblwdpxxth.rows().deselect();
					tblwdpxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFwdpxxth').modal('toggle');
				}, false);
					return false;
				}
			});
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
