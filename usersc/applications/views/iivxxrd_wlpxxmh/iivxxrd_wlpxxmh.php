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
												<input type="text" id="end_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">												
										<label class="col-sm-2 col-form-label">Location Category</label>
										<div class="col-sm-6">
											<select class="form-control" id="select_id_wloctmh" name="select_id_wloctmh"></select>
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

				<table id="tbliivxxrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
				<thead>
					<tr>
						<th style="vertical-align: middle" rowspan="3">Warehouse</th>
						<th style="vertical-align: middle" rowspan="3">Location</th>
						<th style="vertical-align: middle" rowspan="3">LPN</th>
						<th style="vertical-align: middle" rowspan="3">Kode</th>
						<th style="vertical-align: middle" rowspan="3">Nama</th>
						<th colspan="4" class="text-center bg-success">On Hand</th>
						<th colspan="4" class="text-center bg-warning">Reserved</th>
						<th colspan="4" class="text-center bg-primary">Avalaible</th>
						<th style="vertical-align: middle" rowspan="3">Batch Number</th>
						<th style="vertical-align: middle" rowspan="3">Expired Date</th>
					</tr>
					<tr>
						<th colspan="2">Terkecil</th>
						<th colspan="2">Default</th>

						<th colspan="2">Terkecil</th>
						<th colspan="2">Default</th>

						<th colspan="2">Terkecil</th>
						<th colspan="2">Default</th>
					</tr>
					<tr>
						<th>Jumlah</th>
						<th>UoM</th>
						<th>Jumlah</th>
						<th>UoM</th>

						<th>Jumlah</th>
						<th>UoM</th>
						<th>Jumlah</th>
						<th>UoM</th>

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
<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var tbliivxxrd, show_deleted_iivxxrd = 0, id_wloctmh_old = 0, id_wloctmh = 0;
	// ------------- end of default variable
	
	// BEGIN select2 init
	$("#select_id_wloctmh").select2({
		dropdownParent: $("#modalSFiivxxrd"),
		placeholder : "Select",
		allowClear: true,
		multiple: true,
		ajax: {
			url: "../../models/wloctmh/wloctmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_wloctmh_old: id_wloctmh_old,
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
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		id_wloctmh = $('#select_id_wloctmh').val();
		id_wloctmh = '(' + id_wloctmh.join(',') + ')';
		console.log(id_wloctmh);

		//start datatables
		tbliivxxrd = $('#tbliivxxrd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iivxxrd_wlpxxmh/iivxxrd_wlpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iivxxrd = show_deleted_iivxxrd;
					d.end_date = end_date;
					d.id_wloctmh = id_wloctmh;
				}
			},
			responsive: false,
			scrollX: true,
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [0,1,2,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets:'_all'
				},
				{ 
					className: 'bg-beige', targets: [5,6,9,10,13,14] //ini jumlah sama uom
				}
			],
			columns: [
				{ data: "iwhxxmh_kode" },
				{ data: "wloxxmh_nama" },
				{ data: "wlpxxmh_kode" },
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ 
					data: "jumlah_terkecil", //4
					...renderNumber(0)
				},
				{ data: "iumxxmh_terkecil_kode" },//5
				{ 
					data: "jumlah_default",
					...renderNumber(3)
				},
				{ data: "iumxxmh_default_kode" },

				//Reserved
				{ 
					data: "jumlah_terkecil_booking",
					...renderNumber(0)
				},
				{ data: "iumxxmh_terkecil_kode" },
				{ 
					data: "jumlah_default_booking",
					...renderNumber(3)
				},
				{ data: "iumxxmh_default_kode" },

				//Avalaible
				{ 
					data: "jumlah_terkecil_ava",
					...renderNumber(0)
				},
				{ data: "iumxxmh_terkecil_kode" },
				{ 
					data: "jumlah_default_ava",
					...renderNumber(3)
				},
				{ data: "iumxxmh_default_kode" },

				{ data: "batch_number" },
				{ data: "expired_date" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iivxxrd';
					$table       = 'tbliivxxrd';
					$edt         = 'edtiivxxrd';
					$show_status = '_iivxxrd';
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

		tbliivxxrd.searchPanes.container().appendTo('#spiivxxrd');
		tbliivxxrd.searchBuilder.container().appendTo( '#sbiivxxrd' );
	
		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				id_wloctmh = $('#select_id_wloctmh').val();
				id_wloctmh = '(' + id_wloctmh.join(',') + ')';
				console.log(id_wloctmh);

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbliivxxrd.rows().deselect();
				tbliivxxrd.ajax.reload(function ( json ) {
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
