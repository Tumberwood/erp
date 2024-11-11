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

<style>
	.bg-green-light {
		background-color: #d4edda !important; /* Light green */
	}

	.bg-blue-light {
		background-color: #d1ecf1 !important; /* Light blue */
	}
</style>

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
                    <table id="tblwdpxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th rowspan=2>Item Code</th>
								<th rowspan=2>Item Name</th>
								<th rowspan=2>LPN</th>
								<th colspan=2 >Delivery Order</th>
								<th colspan=3 class="bg-green-light">Picking List</th>
								<th colspan=3 class="bg-beige">Picking</th>
								<th colspan=3 class="bg-blue-light">Dispatch</th>
								<th colspan=2>Delivery Note</th>
							</tr>
							<tr>
								<th>Kode</th>
								<th>Qty</th>
								<th>Kode</th>
								<th>Qty</th>
								<th class="bg-green-light">Status</th>
								<th>Kode</th>
								<th>Qty</th>
								<th class="bg-beige">Status</th>
								<th>Kode</th>
								<th>Qty</th>
								<th class="bg-blue-light">Status</th>
								<th>Kode</th>
								<th>Qty</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdpxxrd/fn/wdpxxrd_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwdpxxth, tblwdpxxth, show_deleted_wdpxxth = 0, id_wdpxxth;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('wdpxxth');
		
		$(document).ready(function() {
			
			start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

			console.log(start_date);
			
			tblwdpxxth = $('#tblwdpxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/outbound_r/outbound_r.php",
					type: 'POST',
					data: function (d){
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				order: [[ 2, "asc" ]],
				responsive: false,
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
					},
					{ 
						className: 'bg-green-light', targets: [5,6]
					},
					{ 
						className: 'bg-beige', targets: [8,9]
					},
					{ 
						className: 'bg-blue-light', targets: [11,12]
					},
				],
				columns: [
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "wlpxxmh_kode" },
					{ data: "kode_do" },
					{ 
						data: "jumlah_do", //4
						...renderNumber(2)
					},
					{ data: "kode_pl" },
					{ 
						data: "jumlah_pl", //4
						...renderNumber(2)
					},
					{ data: "ket_pl" },
					{ data: "kode_pc" },
					{ 
						data: "jumlah_pc", //4
						...renderNumber(2)
					},
					{ data: "ket_pc" },
					{ data: "kode_dp" },
					{ 
						data: "jumlah_dp", //4
						...renderNumber(2)
					},
					{ data: "ket_dp" },
					{ data: "kode_dn" },
					{ 
						data: "jumlah_dn", //4
						...renderNumber(2)
					},
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
					if ( data.ket_pl != 'Lunas' ) {
						$('td:eq(7)', row).addClass('bg-warning');
					} else {
						$('td:eq(7)', row).addClass('bg-green-light');
					}

					if ( data.ket_pc != 'Lunas' ) {
						$('td:eq(10)', row).addClass('bg-warning');
					}else {
						$('td:eq(10)', row).addClass('bg-beige');
					}

					if ( data.ket_dp != 'Lunas' ) {
						$('td:eq(13)', row).addClass('bg-warning');
					} else {
						$('td:eq(13)', row).addClass('bg-blue-light');
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
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
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
