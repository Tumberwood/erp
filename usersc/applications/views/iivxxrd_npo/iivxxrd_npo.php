<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>


<?php
	$nama_tabel    = 'iivxxrd_npo';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFiivxxrd_npo" tabindex="-1" role="dialog" aria-hidden="true">
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
												<input type="text" id="end_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Warehouse</label>
										<div class="col-sm-6">
											<select class="form-control" id="select_id_iwhxxmh" name="select_id_iwhxxmh"></select>
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

				<table id="tbliivxxrd_npo" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th rowspan="2">Warehouse</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2">Nama</th>
							<th colspan="2" class="text-center bg-beige">Terkecil</th>
							<th colspan="2" class="text-center">Default</th>
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

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var tbliivxxrd_npo, show_deleted_iivxxrd_npo = 0;
	// ------------- end of default variable

	var id_iwhxxmh = 0, id_iwhxxmh_old = 0;

	// get tableRelation
	tableRelation('iivxxrd_npo');

	$(document).ready(function() {
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		$("#select_id_iwhxxmh").select2({
			dropdownParent: $("#modalSFiivxxrd_npo"),
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_iwhxxmh_old: id_iwhxxmh_old,
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
		
		//start datatables
		tbliivxxrd_npo = $('#tbliivxxrd_npo').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iivxxrd_npo/iivxxrd_npo.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iivxxrd_npo = show_deleted_iivxxrd_npo;
					d.end_date = end_date;
					d.id_iwhxxmh = id_iwhxxmh;
				}
			},
			order: [[ 0, "asc" ],[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [0,1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				},
				{ 
					className: 'bg-beige', targets: [3,4]
				}
			],
			columns: [
				{ data: "iwhxxmh_kode" },
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ 
					data: "jumlah_terkecil",
					...renderNumber(2)
				},
				{ data: "iumxxmh_terkecil_kode" },
				{ 
					data: "jumlah_default",
					...renderNumber(2)
				},
				{ data: "iumxxmh_default_kode" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iivxxrd_npo';
					$table       = 'tbliivxxrd_npo';
					$edt         = 'edtiivxxrd_npo';
					$show_status = '_iivxxrd_npo';
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
				
			}
		} );

		tbliivxxrd_npo.searchPanes.container().appendTo('#spiivxxrd_npo');
		tbliivxxrd_npo.searchBuilder.container().appendTo( '#sbiivxxrd_npo' );
	
		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {			
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				id_iwhxxmh = $('#select_id_iwhxxmh').val();

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbliivxxrd_npo.rows().deselect();
				tbliivxxrd_npo.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFiivxxrd_npo').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter
		
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
