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
							<th rowspan="2">Warehouse</th>
							<th rowspan="2">Location</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2">Nama</th>
							<th colspan="2">Terkecil</th>
							<th colspan="2">Default</th>
							<th rowspan="2">LPN</th>
							<th rowspan="2">Batch Number</th>
							<th rowspan="2">Expired Date</th>
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

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var tbliivxxrd, show_deleted_iivxxrd = 0;
	// ------------- end of default variable

	$(document).ready(function() {
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

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
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [0,1,2,3,8,9,10]
				},
				{
					searchPanes:{
						show: false,
					},
					targets:'_all'
				},
				{ 
					className: 'bg-beige', targets: [4,5] //ini jumlah sama uom
				}
			],
			columns: [
				{ data: "iwhxxmh_kode" },
				{ data: "wloxxmh_nama" },
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
				{ data: "wlpxxmh_kode" },
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
