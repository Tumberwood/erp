<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iivxxrd_sa';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">

				<div class="modal" id="modalSFiivxxrd_sa" tabindex="-1" role="dialog" aria-hidden="true">
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
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit" id="go">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="modal" id="mdlfrmUpload" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-xl">
						<div class="modal-content animated bounceInRight">
							<form id="frmUpload" enctype="multipart/form-data">
								<div class="modal-header">
									<h5 class="modal-title">Upload Stok</h5>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Upload File</label>
										<div class="col-lg-6">
											<div class="input-group">
												<input type="file" placeholder="Select File" id="inputfileUpload" name="inputfileUpload" class="form-control">
												<div class="input-group-append">
													<button type="button" class="btn btn-success" onclick="window.open('../../../files/uploads/template_upload.xlsx');">
														<i class="fa fa-download"></i>&nbsp;Template
													</button>
												</div>
											</div>
											<span class="form-text text-info">Format file harus dalam .xlsx dan disesuaikan dengan format template.</span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Configuration</label>
										<div class="col-lg-6">
											<fieldset>
												<div class="form-check abc-checkbox form-check-inline">
													<input class="form-check-input" type="checkbox" id="cbLocation">
													<label class="form-check-label" for=""> Location </label>
												</div>
												<div class="form-check abc-checkbox abc-checkbox-success form-check-inline">
													<input class="form-check-input" type="checkbox" id="cbLPN">
													<label class="form-check-label" for=""> LPN </label>
												</div>
												<div class="form-check abc-checkbox form-check-inline">
													<input class="form-check-input" type="checkbox" id="cbExpiredDate">
													<label class="form-check-label" for=""> Expired Date </label>
												</div>
												<div class="form-check abc-checkbox form-check-inline">
													<input class="form-check-input" type="checkbox" id="cbBatchNumber">
													<label class="form-check-label" for=""> Batch Number </label>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary m-r-xs">Import</button>
								</div>

							</form>
						</div>
					</div>
				</div>

				<div class="table-responsive">
                    <table id="tbliivxxrd_sa" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Branch</th>
                                <th>Warehouse</th>
                                <th>Location</th>
                                <th>Tanggal</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Quantity (Terkecil)</th>
                                <th>UoM (Terkecil)</th>
                                <th>LPN</th>
                                <th>Expired Date</th>
                                <th>Batch Number</th>
                                <th>Upload State</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iivxxrd_sa/fn/iivxxrd_sa_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiivxxrd_sa, tbliivxxrd_sa, show_deleted_iivxxrd_sa = 0, id_iivxxrd_sa;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('iivxxrd_sa');

		// BEGIN datepicker init
		$('#periode').datepicker({
			setDate: new Date(),
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			format: "dd M yyyy",
			minViewMode: 'month' 
		});
		$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
		$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
        // END datepicker init

		$(document).ready(function() {
			start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date = moment($('#end_date').val()).format('YYYY-MM-DD');
			// BEGIN iivxxrd_sa
			edtiivxxrd_sa = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iivxxrd_sa/iivxxrd_sa.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iivxxrd_sa = show_deleted_iivxxrd_sa;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				table: "#tbliivxxrd_sa",
				fields: [ 
					{
						label: "iivxxrd_sa.start_at",
						name: "iivxxrd_sa.start_at",
						type: "hidden"
					},	
					{
						label: "iivxxrd_sa.finish_at",
						name: "iivxxrd_sa.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iivxxrd_sa",
						type: "hidden"
					},	
					{
						label: "iivxxrd_sa.transaction_state",
						name: "iivxxrd_sa.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iivxxrd_sa.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iivxxrd_sa.nama"
					}, 	
					{
						label: "Keterangan",
						name: "iivxxrd_sa.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiivxxrd_sa.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiivxxrd_sa.field('iivxxrd_sa.start_at').val(start_at);
				
				if(action == 'create'){
					tbliivxxrd_sa.rows().deselect();
				}
			});

			edtiivxxrd_sa.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtiivxxrd_sa.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					kode = edtiivxxrd_sa.field('iivxxrd_sa.kode').val();
					nama = edtiivxxrd_sa.field('iivxxrd_sa.nama').val();

					validasiRequired(
						edtiivxxrd_sa,
						'iivxxrd_sa',
						{
							'kode': kode,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtiivxxrd_sa,
						'iivxxrd_sa',
						'kode',
						'kode',
						'"'+kode+'"',
						id_iivxxrd_sa
					);

					validasiUnique(
						action,
						edtiivxxrd_sa,
						'iivxxrd_sa',
						'nama',
						'nama',
						'"'+nama+'"',
						id_iivxxrd_sa
					);
				}
				
				if ( edtiivxxrd_sa.inError() ) {
					return false;
				}
			});
			
			edtiivxxrd_sa.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiivxxrd_sa.field('iivxxrd_sa.finish_at').val(finish_at);
			});

			edtiivxxrd_sa.on( 'close', function () {
				edtiivxxrd_sa.enable();
			} );

			tbliivxxrd_sa = $('#tbliivxxrd_sa').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/iivxxrd_sa/iivxxrd_sa.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iivxxrd_sa = show_deleted_iivxxrd_sa;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				order: [[ 0, "asc" ]],
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
					{ data: "iivxxrd_sa.id",visible:false },
					{ data: "iivxxrd_sa.gbrxxmh_nama" },
					{ data: "iivxxrd_sa.iwhxxmh_nama" },
					{ data: "iivxxrd_sa.wloxxmh_nama" },
					{ data: "iivxxrd_sa.tanggal" },
					{ data: "iivxxrd_sa.iimxxmh_kode" },
					{ data: "iivxxrd_sa.iimxxmh_nama" },
					{ 
						data: "iivxxrd_sa.jumlah_terkecil" ,
						...renderNumber(0)
					},
					{ data: "iivxxrd_sa.iumxxmh_kode_terkecil" },
					{ data: "iivxxrd_sa.lpn" },
					{ data: "iivxxrd_sa.expired_date" },
					{ data: "iivxxrd_sa.batch_number" },
					{ data: "iivxxrd_sa.upload_state" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iivxxrd_sa';
						$table       = 'tbliivxxrd_sa';
						$edt         = 'edtiivxxrd_sa';
						$show_status = '_iivxxrd_sa';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sf','sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
					{
						text: '<i class="fa fa-upload"></i>',
						name: 'btnModalUpload',
						className: 'btn btn-outline',
						titleAttr: 'Upload Data',
						action: function ( e, dt, node, config ) {
							e.preventDefault();
							$('#mdlfrmUpload').modal('show');
						}
					},
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.iivxxrd_sa.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iivxxrd_sa.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}

					if ( data.iivxxrd_sa.upload_state == 2 ) {
						$('td', row).addClass('text-danger');
					}
				}
			} );

			tbliivxxrd_sa.searchPanes.container().appendTo('#spiivxxrd_sa');
			tbliivxxrd_sa.searchBuilder.container().appendTo( '#sbiivxxrd_sa' );
			
			tbliivxxrd_sa.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliivxxrd_sa);
			} );
			
			tbliivxxrd_sa.on( 'select', function( e, dt, type, indexes ) {
				iivxxrd_sa_data    		= tbliivxxrd_sa.row( { selected: true } ).data().iivxxrd_sa;
				id_iivxxrd_sa      		= iivxxrd_sa_data.id;
				id_transaksi_h 		= id_iivxxrd_sa; // dipakai untuk general
				id_transaksi_log	= id_iivxxrd_sa; // dipakai untuk general
				transaction_state   = iivxxrd_sa_data.transaction_state;
				approval_state   	= iivxxrd_sa_data.approval_state;
				is_nextprocess 		= iivxxrd_sa_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tbliivxxrd_sa);
			} );

			tbliivxxrd_sa.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_iivxxrd_sa = 0;

				// atur hak akses
				CekDeselectHeaderH(tbliivxxrd_sa);
			} );
			// END iivxxrd_sa
			
			var frmUpload = $("#frmUpload").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					inputfileUpload: {
						required: true
					}
				},
				submitHandler: function(form) { 
					full_message = '';
					var notifyprogress;
					var fd = new FormData();
					var files = $('#inputfileUpload')[0].files[0];
					fd.append('inputfileUpload',files);

					// BEGIN parameter tambahan
					if( $('#cbLocation').is(':checked') ){
						is_location = 1;
					}else{
						is_location = 0;
					}
					fd.append('is_location', is_location);

					if( $('#cbLPN').is(':checked') ){
						is_lpn = 1;
					}else{
						is_lpn = 0;
					}
					fd.append('is_lpn', is_lpn);

					if( $('#cbExpiredDate').is(':checked') ){
						is_expired_date = 1;
					}else{
						is_expired_date = 0;
					}
					fd.append('is_expired_date', is_expired_date);

					if( $('#cbBatchNumber').is(':checked') ){
						is_batch_number = 1;
					}else{
						is_batch_number = 0;
					}
					fd.append('is_batch_number', is_batch_number);

					// END parameter tambahan
					
					toastr['warning']('Harap tunggu ...', 'Error', {progressBar: false, timeOut:0});

					$.ajax( {
						url: "../../models/iivxxrd_sa/iivxxrd_sa_fn_upload.php",
						type: 'POST',
						dataType: 'json',
						data: fd,
						async: false,
						contentType: false,
						processData: false,
						success: function ( json ) {
							
							toastr.remove();
							toast_type   = json.data.type_message;
							full_message = full_message + json.data.message + '</br>';
							
							toastr[toast_type](full_message, 'INFO');
							$("#frmUpload")[0].reset();
							tbliivxxrd_sa.ajax.reload(null,false);
						},
					} );
					return false;
				}
			});

			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
					end_date = moment($('#end_date').val()).format('YYYY-MM-DD');
					
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tbliivxxrd_sa.rows().deselect();
					tbliivxxrd_sa.ajax.reload(function ( json ) {
						toastr.remove();
						toastr["success"]("Load data berhasil","INFO")
						$('#modalSFiivxxrd_sa').modal('toggle');
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
