<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'isoxxth_wms';
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
				
				<div class="modal" id="modalSFisoxxth_wms" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblisoxxth_wms" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>Kode SO</th>
								<th>Tanggal</th>
								<th>Warehouse</th>
								<th>Location</th>
								<th>Item</th>
								<th>LPN</th>
								<th>Batch Number</th>
								<th>Expired Date</th>
								<th>UoM</th>
								<th>Fisik</th>
								<th>Sistem</th>
								<th>Selisih</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdpxxrd/fn/wdpxxrd_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtisoxxth_wms, tblisoxxth_wms, show_deleted_isoxxth_wms = 0, id_isoxxth_wms;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('isoxxth_wms');
		
		$(document).ready(function() {
			
			start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

			console.log(start_date);
			
			tblisoxxth_wms = $('#tblisoxxth_wms').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/isoxxth_wms_r/isoxxth_wms_r.php",
					type: 'POST',
					data: function (d){
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				order: [[ 1, "asc" ], [ 0, "asc" ]],
				responsive: false,
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,3,4]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: '_all'
					},

				],
				columns: [
					{ data: "kode" },
					{ data: "tanggal" },
					{ data: "wh" },
					{ data: "loc" },
					{ data: "item" },
					{ data: "wlpxxmh_kode" },
					{ data: "batch_number" },
					{ data: "expired_date" },
					{ data: "uom" },
					{ 
						data: "fisik",
						...renderNumber(2)
					},
					{ 
						data: "sistem",
						...renderNumber(2)
					},
					{ 
						data: "selisih",
						...renderNumber(2)
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_isoxxth_wms';
						$table       = 'tblisoxxth_wms';
						$edt         = 'edtisoxxth_wms';
						$show_status = '_isoxxth_wms';
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
					if ( data.selisih != 0 ) {
						$('td', row).addClass('bg-danger');
					}
				}
			} );

			tblisoxxth_wms.searchPanes.container().appendTo('#spisoxxth_wms');
			tblisoxxth_wms.searchBuilder.container().appendTo( '#sbisoxxth_wms' );
			
			tblisoxxth_wms.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblisoxxth_wms);
			} );
			
			tblisoxxth_wms.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('isoxxth_wms');

				// atur hak akses
				CekSelectHeaderH(tblisoxxth_wms);
			} );

			tblisoxxth_wms.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('isoxxth_wms');

				// atur hak akses
				CekDeselectHeaderH(tblisoxxth_wms);
			} );

			// END isoxxth_wms
			$("#frmFilter").submit(function(e) {
			e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblisoxxth_wms.rows().deselect();
					tblisoxxth_wms.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFisoxxth_wms').modal('toggle');
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
