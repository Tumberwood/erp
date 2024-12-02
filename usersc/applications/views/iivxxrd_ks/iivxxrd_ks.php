<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>


<?php
	$nama_tabel    = 'iivxxrd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFiivxxrd" tabindex="-1" role="dialog" aria-hidden="true">
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
										<label class="col-sm-2 col-form-label">Warehouse</label>
										<div class="col-sm-6">
											<select class="form-control" id="select_id_iwhxxmh" name="select_id_iwhxxmh"></select>
										</div>
									</div>
									<div class="form-group row">												
										<label class="col-sm-2 col-form-label">Item</label>
										<div class="col-sm-10">
											<select class="form-control" id="select_id_iimxxmh" name="select_id_iimxxmh"></select>
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
				<div id="nama_item"></div>
				<table id="tbliivxxrd_ks" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Kode</th>
							<th>Movement Type</th>
							<th>Relasi</th>
							<th>Keterangan</th>
							<th>In</th>
							<th>Out</th>
							<th>Saldo</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iivxxrd_ks/fn/iivxxrd_ks_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var tbliivxxrd_ks;
	// ------------- end of default variable
	var id_iimxxmh = 0, id_iwhxxmh = 0, id_iimxxmh_old=0,id_iwhxxmh_old=0 ;

	// BEGIN select2 init
	$("#select_id_iwhxxmh").select2({
		dropdownParent: $("#modalSFiivxxrd"),
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

	$("#select_id_iimxxmh").select2({
		dropdownParent: $("#modalSFiivxxrd"),
		placeholder : "Select",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_iimxxmh_old: id_iimxxmh_old,
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

		//start datatables
		tbliivxxrd_ks = $('#tbliivxxrd_ks').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iivxxrd_ks/iivxxrd_ks.php",
				type: 'POST',
				data: function (d){
					d.id_iwhxxmh = id_iwhxxmh;
					d.id_iimxxmh = id_iimxxmh;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "tanggal" },
				{ data: "kode" },
				{ data: "imtxxmh_movement_type" },
				{ data: "relasi" },
				{ data: "keterangan" },
				{ 
					data: "jumlah_in",
					...renderNumber(0)
				},
				{ 
					data: "jumlah_out",
					...renderNumber(0)
				},
				{ 
					data: "saldo",
					...renderNumber(0)
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iivxxrd';
					$table       = 'tbliivxxrd_ks';
					$edt         = 'edtiivxxrd';
					$show_status = '_iivxxrd';
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
			rowCallback: function( row, data, index ) {
				
			}
		} );

		tbliivxxrd_ks.searchPanes.container().appendTo('#spiivxxrd');
		tbliivxxrd_ks.searchBuilder.container().appendTo( '#sbiivxxrd' );

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
				},
				select_id_iwhxxmh: {
					required: true
				},
				select_id_iimxxmh: {
					required: true
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				},
				select_id_iwhxxmh: {
					required: "Warehouse Wajib Diisi!"
				},
				select_id_iimxxmh: {
					required: "Item Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date   = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				id_iwhxxmh = $('#select_id_iwhxxmh').val();
				id_iimxxmh = $('#select_id_iimxxmh').val();

				getTitle();

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbliivxxrd_ks.rows().deselect();
				tbliivxxrd_ks.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFiivxxrd').modal('toggle');
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
