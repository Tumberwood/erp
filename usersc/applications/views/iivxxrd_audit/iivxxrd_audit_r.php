<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iivxxrd_audit';
	$nama_tabels_d = [];
?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFiivxxrd_audit" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tbliivxxrd_audit" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th rowspan="2">ID</th>
								<th rowspan="2">Tanggal</th>
								<th rowspan="2">Kode Doc</th>
								<th rowspan="2">User</th>
								<th rowspan="2">Warehouse</th>
								<th rowspan="2">Location</th>
								<th rowspan="2">Item Kode</th>
								<th rowspan="2">Item Nama</th>
								<th colspan="2">Terkecil</th>
								<th colspan="2">Default</th>
								<th rowspan="2">LPN</th>
								<th rowspan="2">Batch Number</th>
								<th rowspan="2">Expired Date</th>
								<th rowspan="2">Status Audit</th>
							</tr>
							<tr>
								<th>Jumlah</th>
								<th>UoM</th>
								<th>Jumlah</th>
								<th>UoM</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script><!-- Datetimepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iivxxrd_audit/fn/iivxxrd_audit_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtiivxxrd_audit, tbliivxxrd_audit, show_deleted_iivxxrd_audit = 0, id_iivxxrd_audit;
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
		tableRelation('iivxxrd_audit');
		
		$(document).ready(function() {
			start_date = moment($('#start_dateDatetime').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
			end_date = moment($('#end_dateDatetime').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
			
			tbliivxxrd_audit = $('#tbliivxxrd_audit').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/iivxxrd_audit/iivxxrd_audit.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iivxxrd_audit = show_deleted_iivxxrd_audit;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				order: [[ 1, "desc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,9]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					}
				],
				columns: [
					{ data: "iivxxrd_audit.id",visible:false },
					{ data: "tanggal_confirm" },
					{ data: "iivxxrd_audit.kode" },
					{ data: "username" },
					{ data: "iivxxrd_audit.iwhxxmh_kode" },
					{ data: "iivxxrd_audit.wloxxmh_nama" },
					{ data: "iivxxrd_audit.iimxxmh_kode" },
					{ data: "iivxxrd_audit.iimxxmh_nama" },
					{ 
						data: "iivxxrd_audit.jumlah_terkecil", //4
						...renderNumber(0)
					},
					{ data: "iivxxrd_audit.iumxxmh_terkecil_kode" },//5
					{ 
						data: "iivxxrd_audit.jumlah_default",
						render: function (data){
							return data.toString().replace(/\.?0+$/, '');
						},
						class: "text-right"
					},
					{ data: "iivxxrd_audit.iumxxmh_default_kode" },
					{ data: "iivxxrd_audit.wlpxxmh_kode" },
					{ data: "iivxxrd_audit.batch_number" },
					{ data: "iivxxrd_audit.expired_date" },
					{ 
						data: "iivxxrd_audit.status_audit",
						render: function (data){
							if (data == 0) {
								return '<span class="badge badge-plain">Tidak OK</span>';
							} else if (data == 1) {
								return '<span class="badge badge-primary">OK</span>';
							} else {
								return '<span class="badge badge-warning">INVALID</span>';
							}
						}
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iivxxrd_audit';
						$table       = 'tbliivxxrd_audit';
						$edt         = 'edtiivxxrd_audit';
						$show_status = '_iivxxrd_audit';
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
					if ( data.iivxxrd_audit.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iivxxrd_audit.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliivxxrd_audit.searchPanes.container().appendTo('#spiivxxrd_audit');
			tbliivxxrd_audit.searchBuilder.container().appendTo( '#sbiivxxrd_audit' );
			
			tbliivxxrd_audit.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliivxxrd_audit);
			} );
			
			tbliivxxrd_audit.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('iivxxrd_audit');

				// atur hak akses
				CekSelectHeaderH(tbliivxxrd_audit);
			} );

			tbliivxxrd_audit.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('iivxxrd_audit');

				// atur hak akses
				CekDeselectHeaderH(tbliivxxrd_audit);
			} );

			// END iivxxrd_audit
			
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

					tbliivxxrd_audit.rows().deselect();
					tbliivxxrd_audit.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFiivxxrd_audit').modal('toggle');
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
