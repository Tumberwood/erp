<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'crfpxth';
	$nama_tabels_d = [];
?>

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
			<div class="modal" id="modalSFcrfpxth" tabindex="-1" role="dialog" aria-hidden="true">
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
												<input type="text" id="start_date" name="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" name="end_date" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group row">												
                        				<label class="col-sm-2 col-form-label">Customer</label>
                        				<div class="col-sm-4">
                            				<select class="form-control" id="select_scuxxmh" name="select_scuxxmh"></select>
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
                    <table id="tblcrfpxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Tanggal</th>
								<th>RFP</th>
								<th>Customer</th>
								<th>Sales Order</th>
								<th>Customer Delivery Request</th>
								<th>Internal Delivery Request</th>
								<th>Item</th>
								<th>Quantity RFP</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/crfpxth_r/fn/crfpxth_r_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtcrfpxth, tblcrfpxth, show_deleted_crfpxth = 0, id_crfpxth;
		// ------------- end of default variable
		var id_scuxxmh = 0;
		var id_grlxxmh_old = 0;
		
		//Select2 init
        $("#select_scuxxmh").select2({
			placeholder: 'Ketik atau TekanTanda Panah Kanan',
			allowClear: true,
			multiple: true,
			ajax: {
				url: "../../models/scuxxmh/scuxxmh_fn_opt.php",
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
			}
			
		});
        // END select2 init

		$('#start_date').datepicker('setDate', '');
		$('#end_date').datepicker('setDate', '');

		$(document).ready(function() {
			start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');
			// BEGIN crfpxth

			tblcrfpxth = $('#tblcrfpxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/crfpxth_r/crfpxth_r.php",
					type: 'POST',
					data: function (d){
						d.start_date = start_date;
						d.end_date = end_date;
						d.id_scuxxmh = id_scuxxmh;
					},
					dataSrc: function(json) {
						return json.data?.rfp || []; // Ambil data di dalam `data.rfp`
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,3,5]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: "_all"
					}
				],
				
				
				columns: [
					{ data: "id",visible:false },
					{ data: "tanggal" },
					{ data: "kode" },
					{ data: "customer" },
					{ data: "kode_so" },
					{ data: "tanggal_dibutuhkan_customer" },
					{ data: "tanggal_dibutuhkan" },
					{ data: "item" },
					{ 
						data: "jumlah_unit" ,
						...renderNumber(2)
					},
					{ data: "uom" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_crfpxth';
						$table       = 'tblcrfpxth';
						$edt         = 'edtcrfpxth';
						$show_status = '_crfpxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
			} );

			tblcrfpxth.searchPanes.container().appendTo('#spcrfpxth');
			tblcrfpxth.searchBuilder.container().appendTo( '#sbcrfpxth' );
			
			// BEGIN form filter
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					start_date: {
						required: true
					},
					end_date: {
						required: true
					}
				},
				messages: {
					start_date: {
						required: "Tanggal mulai harus diisi"
					},
					end_date: {
						required: "Tanggal akhir harus diisi"
					}
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					id_scuxxmh = $('#select_scuxxmh').val();

					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblcrfpxth.rows().deselect();
					tblcrfpxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFcrfpxth').modal('toggle');
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
