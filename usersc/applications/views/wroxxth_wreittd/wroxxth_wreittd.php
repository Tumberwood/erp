<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wroxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFwroxxth" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Filter Sisa</label>
										<div class="col-lg-5">
											<select class="form-control" id="kondisi" name="kondisi">
												<option value="0" selected>Belum Lunas</option>
												<option value="99">Semua</option>
												<option value="1">Lunas</option>
											</select>
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
                    <table id="tblwroxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode RO</th>
                                <th>Supplier</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>UoM</th>
                                <th>Receive Order</th>
                                <th>Receive Entry</th>
                                <th>Sisa</th>
                                <th data-toggle="tooltip" data-placement="top" title="" data-original-title="Dihitung dari Konfirmasi Receive Order hingga pelunasan di Receive Entry">Pemenuhan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wroxxth/fn/wroxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwroxxth, tblwroxxth, show_deleted_wroxxth = 0, id_wroxxth;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('wroxxth');
		var kondisi = $('#kondisi').val();

		$(document).ready(function() {
			tblwroxxth = $('#tblwroxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/wroxxth_wreittd/wroxxth_wreittd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wroxxth = show_deleted_wroxxth;
						d.kondisi = kondisi;
					}
				},
				order: [[ 1, "asc" ]],
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
				responsive: false,
				scrollX: true,
				columns: [
					{ data: "id",visible:false },
					{ data: "kode" },
					{ data: "supplier" },
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "iumxxmh_kode" },
					{ data: "jumlah_unit_ro", ...renderNumber(2) },
					{ data: "jumlah_unit_re", ...renderNumber(2) },
					{ data: "sisa", ...renderNumber(2) },
					{ 
						data: "pemenuhan",
						render: function (data){
							if(data){
								waktu_tunggu = moment.duration(data, 'seconds');
								waktu_tunggu_humanize = waktu_tunggu.format("d [days], h [hrs], m [min], s [sec]");
								return waktu_tunggu_humanize;
							}else{
								return '';
							}
						} 
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wroxxth';
						$table       = 'tblwroxxth';
						$edt         = 'edtwroxxth';
						$show_status = '_wroxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
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

			tblwroxxth.searchPanes.container().appendTo('#spwroxxth');
			tblwroxxth.searchBuilder.container().appendTo( '#sbwroxxth' );
			
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					kondisi = $('#kondisi').val();
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

					tblwroxxth.rows().deselect();
					tblwroxxth.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFwroxxth').modal('toggle');
				}, false);
					return false;
				}
			});
			// END wroxxth
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
