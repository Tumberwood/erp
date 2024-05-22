<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htscstd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				
				<div class="modal" id="modalSFhtscstd" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhtscstd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Pengaju</th>
                                <th>Pengganti</th>
                                <th>Keterangan</th>
                                <th>TX</th>
                                <th>Approval</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htscstd/fn/htscstd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtscstd, tblhtscstd, show_deleted_htscstd = 0, id_htscstd;
		// ------------- end of default variable

		var id_hodxxmh_old = 0;
		
		kategori_dokumen = "";
		kategori_dokumen_value = "";
		var id_hemxxmh_pengaju_old = 0, id_hemxxmh_pengganti_old = 0;
		
		// get tableRelation
		tableRelation('htscstd');

		$(document).ready(function() {
			// BEGIN htscstd
			start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');
			edthtscstd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/htscstd/htscstd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htscstd = show_deleted_htscstd;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				table: "#tblhtscstd",
				fields: [ 
					{
						label: "htscstd.start_at",
						name: "htscstd.start_at",
						type: "hidden"
					},	
					{
						label: "htscstd.finish_at",
						name: "htscstd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "htscstd",
						type: "hidden"
					},	
					{
						label: "htscstd.transaction_state",
						name: "htscstd.transaction_state",
                        type: "hidden",
						def: 0
					},
					{
						label: "Jenis <sup class='text-danger'>*<sup>",
						name: "htscstd.jenis",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Replacement", "value": "Replacement" },
							{ "label": "Tukar Jadwal", "value": "Tukar Jadwal" },
						]
					},	
					{
						label: "Tanggal <sup class='text-danger'>*<sup>",
						name: "htscstd.tanggal",
						type: "datetime",
						def: function () { 
							return moment($('#end_date').val()).format('DD MMM YYYY'); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY'
					}, 	{
						label: "Pengaju <sup class='text-danger'>*<sup>",
						name: "htscstd.id_hemxxmh_pengaju",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_hemxxmh_old: id_hemxxmh_pengaju_old,
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
						}
					}, 	{
						label: "Shift Pengaju <sup class='text-danger'>*<sup>",
						name: "htsxxmh_pengaju_data",
						type: "readonly"
					}, 	{
						label: "Pengganti <sup class='text-danger'>*<sup>",
						name: "htscstd.id_hemxxmh_pengganti",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_hemxxmh_old: id_hemxxmh_pengganti_old,
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
						}
					}, 	{
						label: "htscstd.jam_awal_pengganti",
						name: "htscstd.jam_awal_pengganti",
						type: "hidden"
					}, 	{
						label: "htscstd.jam_akhir_pengganti",
						name: "htscstd.jam_akhir_pengganti",
						type: "hidden"
					}, 	{
						label: "htscstd.jam_awal_pengaju",
						name: "htscstd.jam_awal_pengaju",
						type: "hidden"
					}, 	{
						label: "htscstd.jam_akhir_pengaju",
						name: "htscstd.jam_akhir_pengaju",
						type: "hidden"
					}, 	{
						label: "htscstd.jam_awal_istirahat_pengaju",
						name: "htscstd.jam_awal_istirahat_pengaju",
						type: "hidden"
					}, 	{
						label: "htscstd.jam_awal_istirahat_pengganti",
						name: "htscstd.jam_awal_istirahat_pengganti",
						type: "hidden"
					}, 	{
						label: "Shift Pengganti <sup class='text-danger'>*<sup>",
						name: "htsxxmh_pengganti_data",
						type: "readonly"
					}, 	{
						label: "Keterangan",
						name: "htscstd.keterangan",
						type: "textarea"
					}
				]
			} );

			edthtscstd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtscstd.field('htscstd.start_at').val(start_at);
				
				if(action == 'create'){
					tblhtscstd.rows().deselect();
				}
			});

			edthtscstd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

			edthtscstd.dependent( 'htscstd.tanggal', function ( val, data, callback ) {
				tanggal = edthtscstd.field('htscstd.tanggal').val();
				id_hemxxmh_pengaju = edthtscstd.field('htscstd.id_hemxxmh_pengaju').val();
				id_hemxxmh_pengganti = edthtscstd.field('htscstd.id_hemxxmh_pengganti').val();
				if(tanggal != '' && id_hemxxmh_pengaju > 0){
					get_htsxxmh_pengaju();
				}
				if(tanggal != '' && id_hemxxmh_pengganti > 0){
					get_htsxxmh_pengganti();
				}
				return {}
			}, {event: 'keyup change'});

			edthtscstd.dependent( 'htscstd.id_hemxxmh_pengaju', function ( val, data, callback ) {
				tanggal = edthtscstd.field('htscstd.tanggal').val();
				id_hemxxmh_pengaju = edthtscstd.field('htscstd.id_hemxxmh_pengaju').val();
				if(tanggal != '' && id_hemxxmh_pengaju > 0){
					get_htsxxmh_pengaju();
				}
				return {}
			}, {event: 'keyup change'});

			edthtscstd.dependent( 'htscstd.id_hemxxmh_pengganti', function ( val, data, callback ) {
				tanggal = edthtscstd.field('htscstd.tanggal').val();
				id_hemxxmh_pengganti = edthtscstd.field('htscstd.id_hemxxmh_pengganti').val();
				if(tanggal != '' && id_hemxxmh_pengganti > 0){
					get_htsxxmh_pengganti();
				}
				return {}
			}, {event: 'keyup change'});

            edthtscstd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					jenis = edthtscstd.field('htscstd.jenis').val();
					tanggal = edthtscstd.field('htscstd.tanggal').val();
					id_hemxxmh_pengaju = edthtscstd.field('htscstd.id_hemxxmh_pengaju').val();
					id_hemxxmh_pengganti = edthtscstd.field('htscstd.id_hemxxmh_pengganti').val();

					validasiRequired(
						edthtscstd,
						'htscstd',
						{
							'jenis': jenis,
							'tanggal': tanggal,
							'id_hemxxmh_pengaju': id_hemxxmh_pengaju,
							'id_hemxxmh_pengganti': id_hemxxmh_pengganti,
						}
					);

				}
				
				if ( edthtscstd.inError() ) {
					return false;
				}
			});
			
			edthtscstd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtscstd.field('htscstd.finish_at').val(finish_at);
			});

			edthtscstd.on( 'close', function () {
				edthtscstd.enable();
			} );

			tblhtscstd = $('#tblhtscstd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htscstd/htscstd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htscstd = show_deleted_htscstd;
						d.start_date = start_date;
						d.end_date = end_date;
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
						targets: [0]
					}
				],
				columns: [
					{ data: "htscstd.id",visible:false },
					{ data: "htscstd.kode" },
					{ data: "htscstd.jenis" },
					{ data: "htscstd.tanggal" },
					{ data: "hemxxmh_pengaju" },
					{ data: "hemxxmh_pengganti" },
					{ data: "htscstd.keterangan" },
					{ 
						data: "htscstd.transaction_state" ,
						...renderTransactionStatus()
					},
					{ 
						data: "htscstd.approval_state" ,
						...renderApprovalStatus()
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_htscstd';
						$table       = 'tblhtscstd';
						$edt         = 'edthtscstd';
						$show_status = '_htscstd';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [ 'sf', 'sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.htscstd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.htscstd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhtscstd.searchPanes.container().appendTo('#sphtscstd');
			tblhtscstd.searchBuilder.container().appendTo( '#sbhtscstd' );
			
			tblhtscstd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhtscstd);
			} );
			
			tblhtscstd.on( 'select', function( e, dt, type, indexes ) {
				htscstd_data    		= tblhtscstd.row( { selected: true } ).data().htscstd;
				id_htscstd      		= htscstd_data.id;
				id_transaksi_h 		= id_htscstd; // dipakai untuk general
				id_transaksi_log	= id_htscstd; // dipakai untuk general
				transaction_state   = htscstd_data.transaction_state;
				approval_state   	= htscstd_data.approval_state;
				is_nextprocess 		= htscstd_data.is_nextprocess;

				id_hemxxmh_pengaju_old 		= htscstd_data.id_hemxxmh_pengaju;
				id_hemxxmh_pengganti_old 		= htscstd_data.id_hemxxmh_pengganti;

				// atur hak akses
				CekSelectHeaderH(tblhtscstd);
			} );

			tblhtscstd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htscstd = 0;
				id_hemxxmh_pengaju_old = 0;
				id_hemxxmh_pengganti_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtscstd);
			} );

			// END htscstd
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblhtscstd.rows().deselect();
					tblhtscstd.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFhtscstd').modal('toggle');
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
