<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'pivxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				
				<div class="modal" id="modalSFpivxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
										<label class="col-sm-2 col-form-label">Supplier</label>
										<div class="col-sm-6">
											<select class="form-control" id="select_id_psuxxmh" name="select_id_psuxxmh"></select>
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
                    <table id="tblpivxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode PIV</th>
								<th>Supplier</th>
								<th data-i18n='date'></th>
								<th data-i18n='itemCode'></th>
								<th data-i18n='itemName'></th>
								<th data-i18n='quantity'></th>
								<th data-i18n='uom'></th>
								<th data-i18n='price'></th>
								<th data-i18n='subtotal'></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pivxxth/fn/pivxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtpivxxth, tblpivxxth, show_deleted_pivxxth = 0, id_pivxxth;
		var id_grlxxmh_supplier = 0;
		// ------------- end of default variable

		// get tableRelation
		// tableRelation('pivxxthheader');
		$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
		
		$("#select_id_psuxxmh").select2({
			dropdownParent: $("#modalSFpivxxth"),
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/psuxxmh/psuxxmh_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_grlxxmh_old: id_grlxxmh_supplier,
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
			id_grlxxmh_supplier = $('#select_id_psuxxmh').val();

			tblpivxxth = $('#tblpivxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-3',
				},
				ajax: {
					url: "../../models/pivxxth_r/pivxxth_r.php",
					type: 'POST',
					data: function (d){
						d.start_date = start_date;
						d.end_date = end_date;
						d.id_grlxxmh_supplier = id_grlxxmh_supplier;
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
					{ data: "kode",visible:false },
					{ data: "supplier",visible:false },
					{ data: "tanggal" },
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "jumlah_unit", ...renderNumber(2) },
					{ data: "uom" },
					{ data: "harga_unit", ...renderNumber(2) },
					{ data: "subtotal", ...renderNumber(2) },
				],
				rowGroup: {
					dataSrc: function (row) {
						return  row.kode+' - '+row.supplier
					},
					endRender: function (rows, group) {
						var sum_subtotal = rows
							.data()
							.pluck('subtotal')
							.map(function (subtotal) {
								return parseFloat(subtotal) || 0;
							})
							.reduce(function (a, b) {
								return a + b;
							}, 0);
						
						sum_subtotal = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_subtotal);
						
						return $('<tr/>')
							.append('<td class="font-bold text-success">Total</td>')
							.append('<td></td>')
							.append('<td></td>')
							.append('<td></td>')
							.append('<td></td>')
							.append('<td></td>')
							.append('<td class="text-right font-bold bg-success">' + sum_subtotal + '</td>')
							;
					}
				},
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_pivxxth';
						$table       = 'tblpivxxth';
						$edt         = 'edtpivxxth';
						$show_status = '_pivxxth';
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

			tblpivxxth.searchPanes.container().appendTo('#sppivxxth');
			tblpivxxth.searchBuilder.container().appendTo( '#sbpivxxth' );
			
			// END pivxxth
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
					id_grlxxmh_supplier = $('#select_id_psuxxmh').val();

					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblpivxxth.rows().deselect();
					tblpivxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFpivxxth').modal('toggle');
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
