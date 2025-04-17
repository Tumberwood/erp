<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wpcxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFwpcxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwpcxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>id_wpcxxth</th>
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
								<th>Status Dispatch</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpkxxth/fn/wpkxxth_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwpcxxth, tblwpcxxth, show_deleted_wpcxxth = 0, id_wpcxxth;
		var selectedIds;
		var start_at;
		var finish_at;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('wpcxxth');
		
		$(document).ready(function() {
			start_date = moment($('#start_date').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
		
			//start datatables
			tblwpcxxth = $('#tblwpcxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/wpkxxth/wpkxxth.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wpcxxth = show_deleted_wpcxxth;
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
				responsive: false,
				scrollX: true,
				columns: [
					{ data: "wpclptd.id",visible:false },
					{ data: "wpclptd.id_wpcxxth",visible:false },
					{ data: "tanggal_confirm" },
					{ data: "wpclptd.kode" },
					{ data: "username" },
					{ data: "iwhxxmh.kode" },
					{ data: "asal.nama" },
					{ data: "tujuan.nama" },
					{ data: "wpclptd.wlpxxmh_kode" },
					{ data: "iimxxmh.kode" },
					{ data: "iimxxmh.nama" },
					{ data: "iumxxmh.kode" },
					{ 
						data: "wpclptd.jumlah_unit", //4
						...renderNumber(2)
					},
					{ data: "wpclptd.batch_number" },
					{ data: "wpclptd.expired_date" },
					{ 
						data: "wpclptd.status_dispatch",
						render: function (data) {
							if (data == 1) {
								return '<span class="badge badge-plain">Open</span>';
							} else if (data == 2) {
								return '<span class="badge badge-warning">Parsial</span>';
							} else if (data == 3) {
								return '<span class="badge badge-primary">Full</span>';
							} else {
								return '<span class="badge badge-danger">INVALID</span>';
							}
						}
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wpcxxth';
						$table       = 'tblwpcxxth';
						$edt         = 'edtwpcxxth';
						$show_status = '_wpcxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sf','sp', 'sb'];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					{
						extend: 'create',
						name: 'btnPacking',
						text: 'Crate Packing',
						className: 'btn btn-outline',
						action: function ( e, dt, node, config ) {
							e.preventDefault();
							var queryString = selectedIds.join(',');

							swal({
								text: "Apakah Anda Yakin?",
								icon: "info",
								buttons: {
									cancel: "Batal",
									confirm: "Ya, Simpan"
								},
							}).then((willConfirm) => {
								if (willConfirm) {
									// console.log(selectedIds);
									finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
									// console.log(finish_at);
									createPacking(selectedIds, start_at, finish_at);
								} else {
									// If the user cancels, do nothing
									// console.log("Submission canceled by the user.");
								}
							});
						}
					}
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.wpcxxth.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.wpcxxth.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblwpcxxth.searchPanes.container().appendTo('#spwpcxxth');
			tblwpcxxth.searchBuilder.container().appendTo( '#sbwpcxxth' );
			
			tblwpcxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwpcxxth);
				tblwpcxxth.button( 'btnPacking:name' ).disable();
			} );
			
			tblwpcxxth.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('wpcxxth');
				selectedIds = getSelectedRowIds();

				// atur hak akses
				CekSelectHeaderH(tblwpcxxth);
				tblwpcxxth.button( 'btnPacking:name' ).enable();
			} );

			tblwpcxxth.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('wpcxxth');
				var selectedIds = getSelectedRowIds();

				// atur hak akses
				CekDeselectHeaderH(tblwpcxxth);
				tblwpcxxth.button( 'btnPacking:name' ).disable();
			} );

			// END wpcxxth
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY HH:mm').format('YYYY-MM-DD HH:mm');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					// console.log(start_date);
					// console.log(end_date);

					tblwpcxxth.rows().deselect();
					tblwpcxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFwpcxxth').modal('toggle');
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
