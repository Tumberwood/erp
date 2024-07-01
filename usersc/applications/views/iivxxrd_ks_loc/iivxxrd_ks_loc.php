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
										<div class="col-lg-4 col-sm-4">
											<input type="text" class="form-control" id="wloxxmh_nama" name="wloxxmh_nama" placeholder="Location">
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
				<table id="tbliivxxrd_ks_loc" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>LPN</th>
							<th>Item Code</th>
							<th>Item Name</th>
							<th>Location</th>
							<th>Relasi</th>
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

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var tbliivxxrd_ks_loc;
	// ------------- end of default variable
	var wloxxmh_nama = '', id_iimxxmh_old=0,id_iwhxxmh_old=0 ;
	

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		wloxxmh_nama  = $('#wloxxmh_nama').val();

		//start datatables
		tbliivxxrd_ks_loc = $('#tbliivxxrd_ks_loc').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iivxxrd_ks_loc/iivxxrd_ks_loc.php",
				type: 'POST',
				data: function (d){
					d.wloxxmh_nama = wloxxmh_nama;
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
			rowGroup: {
				dataSrc: function (row) {
						return  row.iimxxmh_kode+' - '+row.iimxxmh_nama;
					},
				endRender: function(rows, group) {
					var sum_jumlah_in = rows
						.data()
						.pluck('jumlah_in')
						.reduce( function (a, b) {
							return parseInt(a) + parseInt(b);
						}, 0);
					sum_jumlah_in = $.fn.dataTable.render.number(',', '.', 0, '').display( sum_jumlah_in )

					var sum_jumlah_in = rows
						.data()
						.pluck('jumlah_in')
						.reduce( function (a, b) {
							return parseInt(a) + parseInt(b);
						}, 0);
					sum_jumlah_in = $.fn.dataTable.render.number(',', '.', 0, '').display( sum_jumlah_in )

					return $('<tr/>')
						.append( '<td class="font-bold text-success">Subtotal</td>' )
						.append( '<td></td>' )
						.append( '<td></td>' )
						.append( '<td></td>' )
						.append( '<td></td>' )
						.append( '<td></td>' )
						.append( '<td class="text-right font-bold bg-warning">'+sum_jumlah_in+'</td>' );
						.append( '<td class="text-right font-bold bg-warning">'+sum_jumlah_out'</td>' );
						.append( '<td></td>' )

				}
				
			},
			columns: [
				{ data: "tanggal" },
				{ data: "wlpxxmh_kode" },
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ data: "wloxxmh_nama" },
				{ data: "relasi" },
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
					$table       = 'tbliivxxrd_ks_loc';
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

		tbliivxxrd_ks_loc.searchPanes.container().appendTo('#spiivxxrd');
		tbliivxxrd_ks_loc.searchBuilder.container().appendTo( '#sbiivxxrd' );

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
				wloxxmh_nama: {
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
				wloxxmh_nama: {
					required: "Location Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date   = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				
				wloxxmh_nama  = $('#wloxxmh_nama').val();

				console.log(wloxxmh_nama);

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbliivxxrd_ks_loc.rows().deselect();
				tbliivxxrd_ks_loc.ajax.reload(function ( json ) {
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
