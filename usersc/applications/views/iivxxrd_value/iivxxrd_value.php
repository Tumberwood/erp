<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iivxxrd_value';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				
				<div class="modal" id="modalSFiivxxrd_value" tabindex="-1" role="dialog" aria-hidden="true">
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
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Item Category</label>
										<div class="col-sm-6">
											<select class="form-control" id="select_id_iicxxmh" name="select_id_iicxxmh"></select>
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
                    <table id="tbliivxxrd_value" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th data-i18n='itemCode'></th>
								<th data-i18n='itemName'></th>
								<th data-i18n='Beginning Qty'></th>
								<th data-i18n='Beginning Value'></th>
								<th data-i18n='Quantity IN'></th>
								<th data-i18n='Value IN'></th>
								<th data-i18n='Quantity Out'></th>
								<th data-i18n='Value Out'></th>
								<th data-i18n='Ending Qty'></th>
								<th data-i18n='Ending Value'></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iivxxrd_value/fn/iivxxrd_value_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtiivxxrd_value, tbliivxxrd_value, show_deleted_iivxxrd_value = 0, id_iivxxrd_value;
		// ------------- end of default variable
		var id_iicxxmh_old = 0;

		// get tableRelation
		// tableRelation('iivxxrd_valueheader');
		$('#start_date').datepicker('setDate', tanggal_hariini_dmy);

		$("#select_id_iicxxmh").select2({
			dropdownParent: $("#modalSFiivxxrd_value"),
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/iicxxmh/iicxxmh_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_iicxxmh_old: id_iicxxmh_old,
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
		});

		$(document).ready(function() {
			start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			id_iicxxmh_old = $("#select_id_iicxxmh").val();

			tbliivxxrd_value = $('#tbliivxxrd_value').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/iivxxrd_value/iivxxrd_value.php",
					type: 'POST',
					data: function (d){
						d.id_iicxxmh_old = id_iicxxmh_old;
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
					{ data: "id_iimxxmh",visible:false },
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "jumlah_begin", ...renderNumber(2) },
					{ data: "hpp_begin", ...renderNumber(2) },
					{ data: "jumlah_in", ...renderNumber(2) },
					{ data: "hpp_in", ...renderNumber(2) },
					{ data: "jumlah_out", ...renderNumber(2) },
					{ data: "hpp_out", ...renderNumber(2) },
					{ data: "jumlah_ending", ...renderNumber(2) },
					{ data: "hpp_ending", ...renderNumber(2) },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iivxxrd_value';
						$table       = 'tbliivxxrd_value';
						$edt         = 'edtiivxxrd_value';
						$show_status = '_iivxxrd_value';
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

			tbliivxxrd_value.searchPanes.container().appendTo('#spiivxxrd_value');
			tbliivxxrd_value.searchBuilder.container().appendTo( '#sbiivxxrd_value' );
			
			// END iivxxrd_value
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
					id_iicxxmh_old = $("#select_id_iicxxmh").val();

					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tbliivxxrd_value.rows().deselect();
					tbliivxxrd_value.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFiivxxrd_value').modal('toggle');
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
